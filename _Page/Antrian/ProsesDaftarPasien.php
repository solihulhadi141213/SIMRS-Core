<?php
// Membuat rekam medis baru dari identitas pasien yang sebelumnya tersimpan di antrean.
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

/** Mengirim respons JSON error dan menghentikan proses pendaftaran pasien. */
function antrianPatientError(string $message, int $statusCode = 400): void
{
    http_response_code($statusCode);
    echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validasi sesi dan metode request sebelum membaca data form.
if (empty($SessionIdAkses)) {
    antrianPatientError('Sesi berakhir. Silakan login kembali.', 401);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    antrianPatientError('Metode request tidak valid.', 405);
}
// Ambil dan bersihkan nilai form sebelum validasi bisnis dijalankan.
$idAntrian = (int) ($_POST['id_antrian'] ?? 0);
$nama = trim((string) ($_POST['nama'] ?? ''));
$gender = (string) ($_POST['gender'] ?? '');
$nik = trim((string) ($_POST['nik'] ?? ''));
$noBpjs = trim((string) ($_POST['no_bpjs'] ?? ''));
$kontak = trim((string) ($_POST['kontak'] ?? ''));
$tempatLahir = trim((string) ($_POST['tempat_lahir'] ?? ''));
$tanggalLahir = trim((string) ($_POST['tanggal_lahir'] ?? ''));
$street = trim((string) ($_POST['street'] ?? ''));
$todayUtc = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d');

// Pastikan identitas wajib, panjang kolom, dan tanggal lahir sesuai aturan pasien.
if (!$idAntrian || $nama === '' || !in_array($gender, ['Laki-laki', 'Perempuan'], true)) {
    antrianPatientError('Antrian, nama, dan jenis kelamin pasien wajib valid.');
}
if (strlen($nama) > 255 || strlen($nik) > 16 || strlen($noBpjs) > 13 || strlen($kontak) > 20 || strlen($tempatLahir) > 255 || strlen($street) > 255) {
    antrianPatientError('Salah satu data pasien melebihi panjang yang diizinkan.');
}
if ($tanggalLahir !== '') {
    $birthDate = DateTime::createFromFormat('!Y-m-d', $tanggalLahir);
    if (!$birthDate || $birthDate->format('Y-m-d') !== $tanggalLahir || $tanggalLahir > $todayUtc) {
        antrianPatientError('Tanggal lahir tidak valid.');
    }
} else {
    $tanggalLahir = null;
}
// Ubah data opsional kosong menjadi NULL agar konsisten dengan skema basis data.
$nik = $nik === '' ? null : $nik;
$noBpjs = $noBpjs === '' ? null : $noBpjs;
$kontak = $kontak === '' ? null : $kontak;
$tempatLahir = $tempatLahir === '' ? null : $tempatLahir;
$street = $street === '' ? null : $street;
$utcNow = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

// Jalankan pembuatan rekam medis dan pengaitan ke antrean sebagai satu transaksi.
if (!mysqli_begin_transaction($Conn)) {
    antrianPatientError('Gagal memulai proses pendaftaran pasien.', 500);
}
try {
    // Kunci antrean untuk mencegah dua petugas mendaftarkan rekam medis bersamaan.
    $stmtQueue = mysqli_prepare($Conn, "SELECT id_pasien FROM antrian WHERE id_antrian = ? FOR UPDATE");
    if (!$stmtQueue) {
        throw new RuntimeException('Gagal menyiapkan validasi antrian.');
    }
    mysqli_stmt_bind_param($stmtQueue, 'i', $idAntrian);
    if (!mysqli_stmt_execute($stmtQueue)) {
        mysqli_stmt_close($stmtQueue);
        throw new RuntimeException('Gagal memeriksa data antrian.');
    }
    $queueResult = mysqli_stmt_get_result($stmtQueue);
    $queue = mysqli_fetch_assoc($queueResult);
    mysqli_stmt_close($stmtQueue);
    if (!$queue) {
        throw new DomainException('Data antrian tidak ditemukan.');
    }
    if (!empty($queue['id_pasien'])) {
        throw new DomainException('Antrian ini sudah terhubung dengan rekam medis.');
    }

    // Cegah penggunaan NIK atau nomor BPJS yang sudah terhubung dengan pasien lain.
    foreach (['nik' => $nik, 'no_bpjs' => $noBpjs] as $field => $value) {
        if ($value === null) {
            continue;
        }
        $check = mysqli_prepare($Conn, "SELECT id_pasien FROM pasien WHERE $field = ? LIMIT 1");
        if (!$check) {
            throw new RuntimeException('Gagal menyiapkan pemeriksaan identitas pasien.');
        }
        mysqli_stmt_bind_param($check, 's', $value);
        if (!mysqli_stmt_execute($check)) {
            mysqli_stmt_close($check);
            throw new RuntimeException('Gagal memeriksa duplikasi identitas pasien.');
        }
        $duplicateResult = mysqli_stmt_get_result($check);
        $duplicate = mysqli_fetch_assoc($duplicateResult);
        mysqli_stmt_close($check);
        if ($duplicate) {
            $label = $field === 'nik' ? 'NIK' : 'Nomor BPJS';
            throw new DomainException("$label sudah terdaftar. Pilih pasien tersebut pada form antrian.");
        }
    }

    // Buat rekam medis aktif dan simpan waktu pendaftaran dalam UTC.
    $stmtInsert = mysqli_prepare(
        $Conn,
        "INSERT INTO pasien (
            nik, no_bpjs, nama, gender, tempat_lahir, tanggal_lahir, street, kontak,
            status, id_akses, petugas_pendaftaran, registered_at, updated_at
         ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Active', ?, ?, ?, ?)"
    );
    if (!$stmtInsert) {
        throw new RuntimeException('Gagal menyiapkan pembuatan rekam medis.');
    }
    mysqli_stmt_bind_param(
        $stmtInsert,
        'ssssssssisss',
        $nik, $noBpjs, $nama, $gender, $tempatLahir, $tanggalLahir, $street,
        $kontak, $SessionIdAkses, $SessionNama, $utcNow, $utcNow
    );
    if (!mysqli_stmt_execute($stmtInsert)) {
        mysqli_stmt_close($stmtInsert);
        throw new RuntimeException('Gagal membuat rekam medis pasien.');
    }
    $idPasien = mysqli_insert_id($Conn);
    mysqli_stmt_close($stmtInsert);

    // Kaitkan nomor rekam medis baru dan identitas lengkap ke antrean asal.
    $stmtUpdate = mysqli_prepare(
        $Conn,
        "UPDATE antrian
         SET id_pasien = ?, nama_pasien = ?, nik = ?, no_bpjs = ?, kontak = ?,
             gender = ?, update_by_id = ?, update_by_name = ?, update_at = ?
         WHERE id_antrian = ? AND id_pasien IS NULL"
    );
    if (!$stmtUpdate) {
        throw new RuntimeException('Gagal menyiapkan pengaitan rekam medis.');
    }
    mysqli_stmt_bind_param(
        $stmtUpdate,
        'isssssissi',
        $idPasien, $nama, $nik, $noBpjs, $kontak, $gender,
        $SessionIdAkses, $SessionNama, $utcNow, $idAntrian
    );
    if (!mysqli_stmt_execute($stmtUpdate) || mysqli_stmt_affected_rows($stmtUpdate) !== 1) {
        mysqli_stmt_close($stmtUpdate);
        throw new RuntimeException('Gagal menghubungkan pasien dengan antrian.');
    }
    mysqli_stmt_close($stmtUpdate);

    // Catat petugas dan identitas antrean/pasien pada log aplikasi.
    $logTitle = 'Mendaftarkan pasien dari antrian';
    $logMetadata = json_encode([
        'id_antrian' => $idAntrian,
        'id_pasien' => $idPasien,
    ], JSON_UNESCAPED_UNICODE);
    $stmtAudit = mysqli_prepare(
        $Conn,
        "INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, metadata_log)
         VALUES (?, ?, ?, ?, ?)"
    );
    if (!$stmtAudit || $logMetadata === false) {
        throw new RuntimeException('Gagal menyiapkan pencatatan aktivitas pasien.');
    }
    mysqli_stmt_bind_param($stmtAudit, 'issss', $SessionIdAkses, $utcNow, $SessionNama, $logTitle, $logMetadata);
    if (!mysqli_stmt_execute($stmtAudit)) {
        mysqli_stmt_close($stmtAudit);
        throw new RuntimeException('Gagal mencatat aktivitas pendaftaran pasien.');
    }
    mysqli_stmt_close($stmtAudit);

    // Selesaikan transaksi hanya setelah pembuatan, pengaitan, dan audit berhasil.
    if (!mysqli_commit($Conn)) {
        throw new RuntimeException('Gagal menyelesaikan pendaftaran pasien.');
    }
    echo json_encode([
        'status' => 'success',
        'message' => 'Pasien berhasil didaftarkan.',
        'id_pasien' => $idPasien,
    ], JSON_UNESCAPED_UNICODE);
} catch (DomainException $error) {
    mysqli_rollback($Conn);
    antrianPatientError($error->getMessage());
} catch (Throwable $error) {
    mysqli_rollback($Conn);
    error_log('Antrian patient registration failed: ' . $error->getMessage());
    antrianPatientError('Terjadi kegagalan saat mendaftarkan pasien. Periksa log aplikasi.', 500);
}
?>

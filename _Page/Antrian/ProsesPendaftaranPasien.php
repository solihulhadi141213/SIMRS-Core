<?php
    // Membuat rekam medis baru dari identitas pasien yang sebelumnya tersimpan di antrean.
    header('Content-Type: application/json; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    /** Mengirim respons JSON error dan menghentikan proses pendaftaran pasien. */
    function antrianPatientError(string $message, int $statusCode = 400, ?string $debug = null): void
    {
        http_response_code($statusCode);
        $response = ['status' => 'error', 'message' => $message];
        if ($debug !== null) {
            $response['debug'] = $debug;
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /** Helper: validasi panjang string per field. */
    function validateLength(?string $value, int $max, string $field): void {
        $value = $value ?? '';
        if (strlen($value) > $max) {
            error_log("Validation error: {$field} exceeds {$max} characters (got " . strlen($value) . ").");
            antrianPatientError("{$field} melebihi panjang maksimum {$max} karakter.");
        }
    }

    /** Helper: ubah string kosong menjadi NULL. */
    function emptyToNull(?string $value): ?string {
        return ($value === null || $value === '') ? null : $value;
    }

    // Validasi sesi dan metode request sebelum membaca data form.
    if (empty($SessionIdAkses)) {
        antrianPatientError('Sesi berakhir. Silakan login kembali.', 401);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        antrianPatientError('Metode request tidak valid.', 405);
    }

    // Ambil dan bersihkan nilai form sebelum validasi bisnis dijalankan.
    $idAntrian      = (int) ($_POST['id_antrian'] ?? 0);
    $nama           = trim((string) ($_POST['nama'] ?? ''));
    $gender         = (string) ($_POST['gender'] ?? '');
    $nik            = trim((string) ($_POST['nik'] ?? ''));
    $noBpjs         = trim((string) ($_POST['no_bpjs'] ?? ''));
    $kontak         = trim((string) ($_POST['kontak'] ?? ''));
    $tempatLahir    = trim((string) ($_POST['tempat_lahir'] ?? ''));
    $tanggalLahir   = trim((string) ($_POST['tanggal_lahir'] ?? ''));
    $street         = trim((string) ($_POST['street'] ?? ''));
    $province       = trim((string) ($_POST['province'] ?? ''));
    $regency        = trim((string) ($_POST['regency'] ?? ''));
    $subdistrict    = trim((string) ($_POST['subdistrict'] ?? ''));
    $village        = trim((string) ($_POST['village'] ?? ''));
    $postalCode     = trim((string) ($_POST['postal_code'] ?? ''));
    $golonganDarah  = trim((string) ($_POST['golongan_darah'] ?? ''));
    $pernikahan     = trim((string) ($_POST['pernikahan'] ?? ''));
    $pekerjaan      = trim((string) ($_POST['pekerjaan'] ?? ''));
    $registeredDate = trim((string) ($_POST['registered_date'] ?? ''));
    $registeredTime = trim((string) ($_POST['registered_time'] ?? ''));
    $todayUtc       = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d');

    // Validasi dan format registered_at (tambahkan :00 detik jika format H:i).
    if ($registeredDate && $registeredTime) {
        // Jika waktu hanya H:i (tanpa detik), tambahkan :00
        if (preg_match('/^\d{2}:\d{2}$/', $registeredTime)) {
            $registeredTime .= ':00';
        }
        $registeredAt = $registeredDate . ' ' . $registeredTime;
    } else {
        $registeredAt = null;
    }

    // Validasi field wajib dengan pesan spesifik.
    if (!$idAntrian) {
        antrianPatientError('ID antrean tidak valid.');
    }
    if ($nama === '') {
        antrianPatientError('Nama pasien wajib diisi.');
    }
    if (!in_array($gender, ['Laki-laki', 'Perempuan'], true)) {
        antrianPatientError('Jenis kelamin tidak valid. Nilai diterima: ' . $gender);
    }
    if ($registeredAt === null) {
        antrianPatientError('Tanggal dan jam pendaftaran wajib diisi.');
    }

    // Validasi panjang setiap field sesuai skema database.
    validateLength($nama, 255, 'Nama');
    validateLength($nik, 255, 'NIK');
    validateLength($noBpjs, 255, 'No BPJS');
    validateLength($kontak, 255, 'Kontak');
    validateLength($tempatLahir, 255, 'Tempat lahir');
    validateLength($street, 255, 'Street');
    validateLength($province, 255, 'Provinsi');
    validateLength($regency, 255, 'Kabupaten/Kota');
    validateLength($subdistrict, 255, 'Kecamatan');
    validateLength($village, 255, 'Desa/Kelurahan');
    validateLength($postalCode, 255, 'Kode Pos');

    // Validasi tanggal lahir.
    if ($tanggalLahir !== '') {
        $birthDate = DateTime::createFromFormat('!Y-m-d', $tanggalLahir);
        if (!$birthDate || $birthDate->format('Y-m-d') !== $tanggalLahir || $tanggalLahir > $todayUtc) {
            antrianPatientError('Tanggal lahir tidak valid.');
        }
    } else {
        $tanggalLahir = null;
    }

    // Validasi ENUM golongan_darah sesuai database: A, B, AB, O atau kosong.
    $golonganDarahValid = ['A', 'B', 'AB', 'O', ''];
    if (!in_array($golonganDarah, $golonganDarahValid, true)) {
        antrianPatientError('Golongan darah tidak valid. Nilai diterima: ' . $golonganDarah);
    }

    // Validasi ENUM pernikahan sesuai database: Lajang, Menikah, Janda, Duda atau kosong.
    $pernikahanValid = ['Lajang', 'Menikah', 'Janda', 'Duda', ''];
    if (!in_array($pernikahan, $pernikahanValid, true)) {
        antrianPatientError('Status pernikahan tidak valid. Nilai diterima: ' . $pernikahan);
    }

    // Validasi ENUM pekerjaan sesuai database: Tidak Bekerja, Karyawan Swasta, Wirausaha, PNS atau kosong.
    $pekerjaanValid = ['Tidak Bekerja', 'Karyawan Swasta', 'Wirausaha', 'PNS', ''];
    if (!in_array($pekerjaan, $pekerjaanValid, true)) {
        antrianPatientError('Pekerjaan tidak valid. Nilai diterima: ' . $pekerjaan);
    }

    // Ubah data opsional kosong menjadi NULL agar konsisten dengan skema basis data.
    $nik           = emptyToNull($nik);
    $noBpjs        = emptyToNull($noBpjs);
    $kontak        = emptyToNull($kontak);
    $tempatLahir   = emptyToNull($tempatLahir);
    $street        = emptyToNull($street);
    $province      = emptyToNull($province);
    $regency       = emptyToNull($regency);
    $subdistrict   = emptyToNull($subdistrict);
    $village       = emptyToNull($village);
    $postalCode    = emptyToNull($postalCode);
    $golonganDarah = emptyToNull($golonganDarah);
    $pernikahan    = emptyToNull($pernikahan);
    $pekerjaan     = emptyToNull($pekerjaan);
    $photoFileName = null; // Placeholder for patient photo (future implementation)
    $utcNow        = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    // Debug: log semua data yang akan di-insert.
    error_log("=== DEBUG ProsesPendaftaranPasien ===");
    error_log("id_antrian={$idAntrian}, nama={$nama}, gender={$gender}");
    error_log("nik=" . ($nik ?? 'NULL') . ", no_bpjs=" . ($noBpjs ?? 'NULL') . ", kontak=" . ($kontak ?? 'NULL'));
    error_log("registered_at=" . ($registeredAt ?? 'NULL') . ", utcNow={$utcNow}");
    error_log("SessionIdAkses={$SessionIdAkses}, SessionNama={$SessionNama}");

    // Jalankan pembuatan rekam medis dan pengaitan ke antrean sebagai satu transaksi.
    if (!mysqli_begin_transaction($Conn)) {
        antrianPatientError('Gagal memulai proses pendaftaran pasien.', 500, mysqli_error($Conn));
    }
    try {
        // Kunci antrean untuk mencegah dua petugas mendaftarkan rekam medis bersamaan.
        $stmtQueue = mysqli_prepare($Conn, "SELECT id_pasien FROM antrian WHERE id_antrian = ? FOR UPDATE");
        if (!$stmtQueue) {
            throw new RuntimeException('Gagal menyiapkan validasi antrian: ' . mysqli_error($Conn));
        }
        mysqli_stmt_bind_param($stmtQueue, 'i', $idAntrian);
        if (!mysqli_stmt_execute($stmtQueue)) {
            $err = mysqli_stmt_error($stmtQueue);
            mysqli_stmt_close($stmtQueue);
            throw new RuntimeException('Gagal memeriksa data antrian: ' . $err);
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
                throw new RuntimeException("Gagal menyiapkan pemeriksaan {$field}: " . mysqli_error($Conn));
            }
            mysqli_stmt_bind_param($check, 's', $value);
            if (!mysqli_stmt_execute($check)) {
                $err = mysqli_stmt_error($check);
                mysqli_stmt_close($check);
                throw new RuntimeException("Gagal memeriksa duplikasi {$field}: " . $err);
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
        // 22 kolom, 1 hardcoded ('Active'), maka 21 placeholder (?).
        $sqlInsert = "INSERT INTO pasien (
                nik, no_bpjs, nama, gender, tempat_lahir, tanggal_lahir,
                province, regency, subdistrict, village, street, postal_code,
                kontak, golongan_darah, pernikahan, pekerjaan, photo_file_name,
                status, id_akses, petugas_pendaftaran, registered_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active', ?, ?, ?, ?)";

        $stmtInsert = mysqli_prepare($Conn, $sqlInsert);
        if (!$stmtInsert) {
            throw new RuntimeException('Gagal menyiapkan INSERT pasien: ' . mysqli_error($Conn));
        }

        // 21 placeholder = 17 data pasien + 4 data sistem (id_akses, petugas, registered_at, updated_at)
        // Type: s=string untuk semua (MySQL auto-cast int/date dari string)
        mysqli_stmt_bind_param(
            $stmtInsert,
            'sssssssssssssssssssss',
            $nik, $noBpjs, $nama, $gender, $tempatLahir, $tanggalLahir,
            $province, $regency, $subdistrict, $village, $street, $postalCode,
            $kontak, $golonganDarah, $pernikahan, $pekerjaan, $photoFileName,
            $SessionIdAkses, $SessionNama, $registeredAt, $utcNow
        );

        if (!mysqli_stmt_execute($stmtInsert)) {
            $err = mysqli_stmt_error($stmtInsert);
            mysqli_stmt_close($stmtInsert);
            throw new RuntimeException('Gagal INSERT pasien: ' . $err);
        }
        $idPasien = mysqli_insert_id($Conn);
        mysqli_stmt_close($stmtInsert);

        error_log("Pasien berhasil dibuat dengan id_pasien={$idPasien}");

        // Kaitkan nomor rekam medis baru dan identitas lengkap ke antrean asal.
        $stmtUpdate = mysqli_prepare(
            $Conn,
            "UPDATE antrian
            SET id_pasien = ?, nama_pasien = ?, nik = ?, no_bpjs = ?, kontak = ?,
                gender = ?, update_by_id = ?, update_by_name = ?, update_at = ?
            WHERE id_antrian = ? AND id_pasien IS NULL"
        );
        if (!$stmtUpdate) {
            throw new RuntimeException('Gagal menyiapkan UPDATE antrian: ' . mysqli_error($Conn));
        }
        mysqli_stmt_bind_param(
            $stmtUpdate,
            'isssssissi',
            $idPasien, $nama, $nik, $noBpjs, $kontak, $gender,
            $SessionIdAkses, $SessionNama, $utcNow, $idAntrian
        );
        if (!mysqli_stmt_execute($stmtUpdate)) {
            $err = mysqli_stmt_error($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);
            throw new RuntimeException('Gagal UPDATE antrian: ' . $err);
        }
        if (mysqli_stmt_affected_rows($stmtUpdate) !== 1) {
            mysqli_stmt_close($stmtUpdate);
            throw new RuntimeException('UPDATE antrian affected 0 rows. Kemungkinan antrian sudah terisi id_pasien oleh petugas lain.');
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
            throw new RuntimeException('Gagal menyiapkan INSERT log: ' . mysqli_error($Conn));
        }
        mysqli_stmt_bind_param($stmtAudit, 'issss', $SessionIdAkses, $utcNow, $SessionNama, $logTitle, $logMetadata);
        if (!mysqli_stmt_execute($stmtAudit)) {
            $err = mysqli_stmt_error($stmtAudit);
            mysqli_stmt_close($stmtAudit);
            throw new RuntimeException('Gagal INSERT log: ' . $err);
        }
        mysqli_stmt_close($stmtAudit);

        // Selesaikan transaksi hanya setelah pembuatan, pengaitan, dan audit berhasil.
        if (!mysqli_commit($Conn)) {
            throw new RuntimeException('Gagal commit transaksi: ' . mysqli_error($Conn));
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
        $debugMsg = $error->getMessage() . ' | File: ' . $error->getFile() . ':' . $error->getLine();
        error_log('Antrian patient registration failed: ' . $debugMsg);
        // Kirim detail error ke frontend agar mudah di-debug.
        antrianPatientError('Terjadi kegagalan saat mendaftarkan pasien.', 500, $debugMsg);
    }
?>

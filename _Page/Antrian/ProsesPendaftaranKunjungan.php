<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    function antrianVisitError(string $message, int $statusCode = 400, ?string $debug = null): void
    {
        http_response_code($statusCode);
        $response = ['status' => 'error', 'message' => $message];
        if ($debug !== null) {
            $response['debug'] = $debug;
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (empty($SessionIdAkses)) {
        antrianVisitError('Sesi berakhir. Silakan login kembali.', 401);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        antrianVisitError('Metode request tidak valid.', 405);
    }

    $idAntrian             = (int) ($_POST['id_antrian'] ?? 0);
    $idPasienForm          = trim((string) ($_POST['id_pasien'] ?? ''));
    $prioritas             = trim((string) ($_POST['prioritas'] ?? ''));
    $keluhan               = trim((string) ($_POST['keluhan'] ?? ''));
    $dateDaftar            = trim((string) ($_POST['date_daftar'] ?? ''));
    $timeDaftar            = trim((string) ($_POST['time_daftar'] ?? ''));
    $kodeDokter            = trim((string) ($_POST['kode_dokter'] ?? ''));
    $dokter                = trim((string) ($_POST['dokter'] ?? ''));
    $kodePoliklinik        = trim((string) ($_POST['kode_poliklinik'] ?? ''));
    $poliklinik            = trim((string) ($_POST['poliklinik'] ?? ''));
    $pembayaranMetode      = trim((string) ($_POST['pembayaran_metode'] ?? ''));
    $pembayaranPenanggung  = trim((string) ($_POST['pembayaran_penanggung'] ?? ''));
    $sep                   = trim((string) ($_POST['sep'] ?? ''));
    $kontakDaruratNomor    = trim((string) ($_POST['kontak_darurat_nomor'] ?? ''));
    $kontakDaruratNama     = trim((string) ($_POST['kontak_darurat_nama'] ?? ''));
    $kontakDaruratHubungan = trim((string) ($_POST['kontak_darurat_hubungan'] ?? ''));
    $pernyataanPetugas     = trim((string) ($_POST['pernyataan_petugas'] ?? ''));

    if (!$idAntrian) {
        antrianVisitError('ID antrian tidak valid.');
    }
    if ($prioritas === '' || !in_array($prioritas, ['Normal', 'Urgent', 'Emergency'], true)) {
        antrianVisitError('Prioritas tindakan tidak valid.');
    }
    if ($keluhan === '') {
        antrianVisitError('Keluhan utama wajib diisi.');
    }
    if ($pembayaranMetode === '' || !in_array($pembayaranMetode, ['UMUM', 'ASURANSI'], true)) {
        antrianVisitError('Metode pembayaran tidak valid.');
    }
    if ($pernyataanPetugas !== '1') {
        antrianVisitError('Pernyataan petugas wajib dicentang.');
    }

    // datetime_daftar diisi dengan tanggal dan waktu sekarang dalam format UTC.
    $datetimeDaftar = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    // Ambil data antrian asal untuk memastikan valid dan mendapatkan id pasien/poli/dokter.
    $stmtAntrian = mysqli_prepare(
        $Conn,
        "SELECT id_antrian, id_pasien, id_poliklinik, id_dokter
         FROM antrian
         WHERE id_antrian = ?
         LIMIT 1"
    );
    if (!$stmtAntrian) {
        antrianVisitError('Gagal menyiapkan query antrian.', 500, mysqli_error($Conn));
    }
    mysqli_stmt_bind_param($stmtAntrian, 'i', $idAntrian);
    if (!mysqli_stmt_execute($stmtAntrian)) {
        $err = mysqli_stmt_error($stmtAntrian);
        mysqli_stmt_close($stmtAntrian);
        antrianVisitError('Gagal mengambil data antrian.', 500, $err);
    }
    $resultAntrian = mysqli_stmt_get_result($stmtAntrian);
    $antrian       = mysqli_fetch_assoc($resultAntrian);
    mysqli_stmt_close($stmtAntrian);

    if (!$antrian) {
        antrianVisitError('Data antrian tidak ditemukan.');
    }

    $idPasien = $idPasienForm !== '' ? (int) $idPasienForm : (int) ($antrian['id_pasien'] ?? 0);
    if (!$idPasien) {
        antrianVisitError('Pasien belum terdaftar. Lakukan pendaftaran pasien terlebih dahulu.');
    }

    $idPoliklinik = !empty($antrian['id_poliklinik']) ? (int) $antrian['id_poliklinik'] : null;
    if (!$idPoliklinik) {
        antrianVisitError('Poliklinik pada antrian tidak valid.');
    }
    $idDokter = !empty($antrian['id_dokter']) ? (int) $antrian['id_dokter'] : null;
    if (!$idDokter) {
        antrianVisitError('Dokter pada antrian tidak valid.');
    }

    // Validasi dokter berdasarkan id_dokter.
    $stmtDokter = mysqli_prepare($Conn, "SELECT id_dokter, kode, nama FROM dokter WHERE id_dokter = ? LIMIT 1");
    if (!$stmtDokter) {
        antrianVisitError('Gagal menyiapkan query dokter.', 500, mysqli_error($Conn));
    }
    mysqli_stmt_bind_param($stmtDokter, 'i', $idDokter);
    if (!mysqli_stmt_execute($stmtDokter)) {
        $err = mysqli_stmt_error($stmtDokter);
        mysqli_stmt_close($stmtDokter);
        antrianVisitError('Gagal mengambil data dokter.', 500, $err);
    }
    $resultDokter = mysqli_stmt_get_result($stmtDokter);
    $dokterRow = mysqli_fetch_assoc($resultDokter);
    mysqli_stmt_close($stmtDokter);
    if (!$dokterRow) {
        antrianVisitError('Data dokter tidak ditemukan.');
    }
    $kodeDokter = trim((string) ($dokterRow['kode'] ?? ''));
    $dokter = trim((string) ($dokterRow['nama'] ?? ''));
    if ($kodeDokter === '') {
        antrianVisitError('Kode dokter tidak ditemukan pada data dokter.');
    }
    if ($dokter === '') {
        antrianVisitError('Nama dokter tidak ditemukan pada data dokter.');
    }

    // dpjp mengikuti dokter penerima.
    $dpjpId = $idDokter;
    $dpjpKode = $kodeDokter;
    $dpjpNama = $dokter;

    // Validasi poliklinik berdasarkan id_poliklinik pada antrian.
    $stmtPoli = mysqli_prepare($Conn, "SELECT id_poliklinik, kode, poliklinik FROM poliklinik WHERE id_poliklinik = ? LIMIT 1");
    if (!$stmtPoli) {
        antrianVisitError('Gagal menyiapkan query poliklinik.', 500, mysqli_error($Conn));
    }
    mysqli_stmt_bind_param($stmtPoli, 'i', $idPoliklinik);
    if (!mysqli_stmt_execute($stmtPoli)) {
        $err = mysqli_stmt_error($stmtPoli);
        mysqli_stmt_close($stmtPoli);
        antrianVisitError('Gagal mengambil data poliklinik.', 500, $err);
    }
    $resultPoli = mysqli_stmt_get_result($stmtPoli);
    $poliRow = mysqli_fetch_assoc($resultPoli);
    mysqli_stmt_close($stmtPoli);
    if (!$poliRow) {
        antrianVisitError('Data poliklinik tidak ditemukan.');
    }
    $kodePoliklinik = trim((string) ($poliRow['kode'] ?? ''));
    $poliklinik = trim((string) ($poliRow['poliklinik'] ?? ''));

    // Pastikan pasien ada.
    $stmtPasien = mysqli_prepare($Conn, "SELECT id_pasien FROM pasien WHERE id_pasien = ? LIMIT 1");
    if (!$stmtPasien) {
        antrianVisitError('Gagal menyiapkan query pasien.', 500, mysqli_error($Conn));
    }
    mysqli_stmt_bind_param($stmtPasien, 'i', $idPasien);
    if (!mysqli_stmt_execute($stmtPasien)) {
        $err = mysqli_stmt_error($stmtPasien);
        mysqli_stmt_close($stmtPasien);
        antrianVisitError('Gagal memvalidasi pasien.', 500, $err);
    }
    $resultPasien = mysqli_stmt_get_result($stmtPasien);
    $pasienExists = (bool) mysqli_fetch_assoc($resultPasien);
    mysqli_stmt_close($stmtPasien);
    if (!$pasienExists) {
        antrianVisitError('Pasien tidak ditemukan.');
    }

    $utcNow = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    mysqli_begin_transaction($Conn);

    try {
        // Insert kunjungan baru.
        $stmtInsert = mysqli_prepare(
            $Conn,
            "INSERT INTO kunjungan (
                id_encounter, id_pasien, sep, prioritas, keluhan, jenis_kunjungan,
                id_dokter, kode_dokter, dokter, dpjp_id, dpjp_kode, dpjp_nama,
                id_poliklinik, kode_poliklinik, poliklinik, kelas, ruang_rawat, tempat_tidur,
                pembayaran_metode, pembayaran_penanggung, kontak_darurat_nomor, kontak_darurat_nama,
                kontak_darurat_hubungan, status, petugas_id, petugas_nama, datetime_daftar
            ) VALUES (
                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
            )"
        );
        if (!$stmtInsert) {
            throw new RuntimeException('Gagal menyiapkan INSERT kunjungan: ' . mysqli_error($Conn));
        }

        $idEncounter = null;
        $jenisKunjungan = 'Rajal';
        $dpjpId = $idDokter;
        $dpjpKode = $kodeDokter;
        $dpjpNama = $dokter;
        $kelas = null;
        $ruangRawat = null;
        $tempatTidur = null;
        $statusKunjungan = 'Terdaftar';

        mysqli_stmt_bind_param(
            $stmtInsert,
            "sssssssssssssssssssssssssss",
            $idEncounter,
            $idPasien,
            $sep,
            $prioritas,
            $keluhan,
            $jenisKunjungan,
            $idDokter,
            $kodeDokter,
            $dokter,
            $dpjpId,
            $dpjpKode,
            $dpjpNama,
            $idPoliklinik,
            $kodePoliklinik,
            $poliklinik,
            $kelas,
            $ruangRawat,
            $tempatTidur,
            $pembayaranMetode,
            $pembayaranPenanggung,
            $kontakDaruratNomor,
            $kontakDaruratNama,
            $kontakDaruratHubungan,
            $statusKunjungan,
            $SessionIdAkses,
            $SessionNama,
            $datetimeDaftar
        );

        if (!mysqli_stmt_execute($stmtInsert)) {
            $err = mysqli_stmt_error($stmtInsert);
            mysqli_stmt_close($stmtInsert);
            throw new RuntimeException('Gagal INSERT kunjungan: ' . $err);
        }
        $idKunjungan = mysqli_insert_id($Conn);
        mysqli_stmt_close($stmtInsert);

        if (!$idKunjungan) {
            throw new RuntimeException('Gagal mendapatkan ID kunjungan baru.');
        }

        // Kaitkan kunjungan baru ke antrian asal.
        $stmtUpdateAntrian = mysqli_prepare(
            $Conn,
            "UPDATE antrian
             SET id_kunjungan = ?, update_by_id = ?, update_by_name = ?, update_at = ?
             WHERE id_antrian = ?"
        );
        if (!$stmtUpdateAntrian) {
            throw new RuntimeException('Gagal menyiapkan UPDATE antrian: ' . mysqli_error($Conn));
        }
        mysqli_stmt_bind_param(
            $stmtUpdateAntrian,
            'iissi',
            $idKunjungan,
            $SessionIdAkses,
            $SessionNama,
            $utcNow,
            $idAntrian
        );
        if (!mysqli_stmt_execute($stmtUpdateAntrian)) {
            $err = mysqli_stmt_error($stmtUpdateAntrian);
            mysqli_stmt_close($stmtUpdateAntrian);
            throw new RuntimeException('Gagal UPDATE antrian: ' . $err);
        }
        mysqli_stmt_close($stmtUpdateAntrian);

        // Catat aktivitas pada log aplikasi.
        $logTitle = 'Pendaftaran kunjungan dari antrian';
        $logMetadata = json_encode([
            'id_antrian'   => $idAntrian,
            'id_kunjungan' => $idKunjungan,
            'id_pasien'    => $idPasien,
        ], JSON_UNESCAPED_UNICODE);
        $stmtLog = mysqli_prepare(
            $Conn,
            "INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, metadata_log)
             VALUES (?, ?, ?, ?, ?)"
        );
        if (!$stmtLog || $logMetadata === false) {
            throw new RuntimeException('Gagal menyiapkan INSERT log: ' . mysqli_error($Conn));
        }
        mysqli_stmt_bind_param($stmtLog, 'issss', $SessionIdAkses, $utcNow, $SessionNama, $logTitle, $logMetadata);
        if (!mysqli_stmt_execute($stmtLog)) {
            $err = mysqli_stmt_error($stmtLog);
            mysqli_stmt_close($stmtLog);
            throw new RuntimeException('Gagal INSERT log: ' . $err);
        }
        mysqli_stmt_close($stmtLog);

        if (!mysqli_commit($Conn)) {
            throw new RuntimeException('Gagal commit transaksi: ' . mysqli_error($Conn));
        }

        echo json_encode([
            'status'        => 'success',
            'message'       => 'Kunjungan berhasil didaftarkan.',
            'id_kunjungan'  => $idKunjungan,
        ], JSON_UNESCAPED_UNICODE);
    } catch (RuntimeException $error) {
        mysqli_rollback($Conn);
        error_log('Antrian visit registration failed: ' . $error->getMessage());
        antrianVisitError('Terjadi kegagalan saat mendaftarkan kunjungan.', 500, $error->getMessage());
    } catch (Throwable $error) {
        mysqli_rollback($Conn);
        $debugMsg = $error->getMessage() . ' | File: ' . $error->getFile() . ':' . $error->getLine();
        error_log('Antrian visit registration failed: ' . $debugMsg);
        antrianVisitError('Terjadi kegagalan saat mendaftarkan kunjungan.', 500, $debugMsg);
    }
?>

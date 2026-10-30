<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    ob_start();

    header('Content-Type: application/json; charset=utf-8');

    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan yang tidak diketahui.'
    ];

    $jsonSent = false;

    register_shutdown_function(function () use (&$response, &$jsonSent) {
        if (!$jsonSent) {
            ob_end_clean();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
        }
    });

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($Conn) || $Conn->connect_error) {
        $response['message'] = 'Koneksi database gagal.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    // Tangkap data
    $id_imunisasi          = (int)($_POST['id_imunisasi'] ?? 0);
    $id_pasien             = (int)($_POST['id_pasien'] ?? 0);
    $id_kunjungan          = (int)($_POST['id_kunjungan'] ?? 0);
    $tanggal_pemberian     = trim(validateAndSanitizeInput($_POST['tanggal_pemberian'] ?? ''));
    $jam_pemberian         = trim(validateAndSanitizeInput($_POST['jam_pemberian'] ?? ''));
    $id_imunisasi_referensi= (int)($_POST['id_imunisasi_referensi'] ?? 0);
    $dosis_ke              = (int)($_POST['dosis_ke'] ?? 0);
    $nomor_batch           = trim(validateAndSanitizeInput($_POST['nomor_batch'] ?? ''));
    $produsen_vaksin       = trim(validateAndSanitizeInput($_POST['produsen_vaksin'] ?? ''));
    $id_body_site          = (int)($_POST['id_body_site'] ?? 0);
    $id_praktisi           = (int)($_POST['id_praktisi'] ?? 0);
    $catatan               = trim(validateAndSanitizeInput($_POST['catatan'] ?? ''));

    // Validasi ID
    if (!$id_imunisasi) {
        $response['message'] = 'ID imunisasi tidak valid.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    // Validasi mandatory
    if (!$id_pasien) {
        $response['message'] = 'Pasien wajib dipilih.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if (!$id_kunjungan) {
        $response['message'] = 'Kunjungan wajib dipilih.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if ($tanggal_pemberian === '') {
        $response['message'] = 'Tanggal pemberian wajib diisi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if ($jam_pemberian === '') {
        $response['message'] = 'Jam pemberian wajib diisi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if (!$id_imunisasi_referensi) {
        $response['message'] = 'Jenis/Nama Vaksin wajib dipilih.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if ($dosis_ke <= 0) {
        $dosis_ke = 1;
    }

    // Cek existing
    $stmtExisting = mysqli_prepare($Conn, "SELECT id_imunisasi FROM imunisasi WHERE id_imunisasi = ? LIMIT 1");
    if (!$stmtExisting) {
        $response['message'] = 'Gagal menyiapkan query validasi data.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_bind_param($stmtExisting, 'i', $id_imunisasi);
    mysqli_stmt_execute($stmtExisting);
    $resultExisting = mysqli_stmt_get_result($stmtExisting);
    if (mysqli_num_rows($resultExisting) === 0) {
        mysqli_stmt_close($stmtExisting);
        $response['message'] = 'Data imunisasi tidak ditemukan.';
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_close($stmtExisting);

    // Ambil referensi vaksin
    $stmtRef = mysqli_prepare($Conn, "SELECT nama_vaksin FROM imunisasi_referensi WHERE id_imunisasi_referensi = ? LIMIT 1");
    if (!$stmtRef) {
        $response['message'] = 'Gagal menyiapkan query referensi imunisasi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_bind_param($stmtRef, 'i', $id_imunisasi_referensi);
    mysqli_stmt_execute($stmtRef);
    $resultRef = mysqli_stmt_get_result($stmtRef);
    $dataRef = mysqli_fetch_assoc($resultRef);
    mysqli_stmt_close($stmtRef);

    if (!$dataRef) {
        $response['message'] = 'Data referensi imunisasi tidak ditemukan.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    $nama_vaksin = (string)($dataRef['nama_vaksin'] ?? '');

    // Ambil body site
    $body_site_nama    = null;
    $body_site_display = null;
    $body_site_code    = null;
    $body_site_system  = null;

    if ($id_body_site > 0) {
        $stmtBs = mysqli_prepare($Conn, "SELECT body_site_nama, body_site_display, body_site_code, body_site_system FROM body_site WHERE id_body_site = ? LIMIT 1");
        if ($stmtBs) {
            mysqli_stmt_bind_param($stmtBs, 'i', $id_body_site);
            mysqli_stmt_execute($stmtBs);
            $resultBs = mysqli_stmt_get_result($stmtBs);
            $dataBs = mysqli_fetch_assoc($resultBs);
            mysqli_stmt_close($stmtBs);
            if ($dataBs) {
                $body_site_nama    = (string)($dataBs['body_site_nama'] ?? '');
                $body_site_display = (string)($dataBs['body_site_display'] ?? '');
                $body_site_code    = (string)($dataBs['body_site_code'] ?? '');
                $body_site_system  = (string)($dataBs['body_site_system'] ?? '');
            }
        }
    }

    // Ambil praktisi
    $praktisi_ihs   = null;
    $praktisi_nama  = null;

    if ($id_praktisi > 0) {
        $stmtPr = mysqli_prepare($Conn, "SELECT id_practitioner, nama_praktisi FROM praktisi WHERE id_praktisi = ? LIMIT 1");
        if ($stmtPr) {
            mysqli_stmt_bind_param($stmtPr, 'i', $id_praktisi);
            mysqli_stmt_execute($stmtPr);
            $resultPr = mysqli_stmt_get_result($stmtPr);
            $dataPr = mysqli_fetch_assoc($resultPr);
            mysqli_stmt_close($stmtPr);
            if ($dataPr) {
                $praktisi_ihs  = (string)($dataPr['id_practitioner'] ?? '');
                $praktisi_nama = (string)($dataPr['nama_praktisi'] ?? '');
            }
        }
    }

    // Konversi waktu user -> UTC
    $timezoneName = trim((string)($SessionUserTimezone ?? ''));
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
        $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
    }
    try {
        $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
    } catch (Throwable $e) {
        $userTimezone = new DateTimeZone('UTC');
    }

    try {
        $dtUser = new DateTime($tanggal_pemberian . ' ' . $jam_pemberian, $userTimezone);
        $dtUser->setTimezone(new DateTimeZone('UTC'));
        $tanggal_pemberian_utc = $dtUser->format('Y-m-d');
    } catch (Throwable $e) {
        $tanggal_pemberian_utc = $tanggal_pemberian;
    }

    // =========================================================
    // VALIDASI DUPLIKAT (exclude current id)
    // =========================================================
    $whereDup = "WHERE id_imunisasi != ? AND id_pasien = ? AND id_kunjungan = ? AND id_imunisasi_referensi = ? AND tanggal_pemberian = ?";
    $paramsDup = [$id_imunisasi, $id_pasien, $id_kunjungan, $id_imunisasi_referensi, $tanggal_pemberian_utc];
    $typesDup  = 'iiiis';

    $queryCek = "SELECT id_imunisasi FROM imunisasi $whereDup LIMIT 1";
    $stmtCek = mysqli_prepare($Conn, $queryCek);
    if (!$stmtCek) {
        $response['message'] = 'Gagal menyiapkan query validasi duplikat.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    mysqli_stmt_bind_param($stmtCek, $typesDup, ...$paramsDup);
    mysqli_stmt_execute($stmtCek);
    $resultCek = mysqli_stmt_get_result($stmtCek);

    if (mysqli_num_rows($resultCek) > 0) {
        mysqli_stmt_close($stmtCek);
        $response['message'] = 'Data imunisasi sudah ada (duplikat).';
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    mysqli_stmt_close($stmtCek);

    // =========================================================
    // UPDATE DATA
    // =========================================================
    $datetime_update = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    mysqli_begin_transaction($Conn);

    try {
        $queryUpdate = "
            UPDATE imunisasi SET
                id_pasien = ?,
                id_kunjungan = ?,
                id_imunisasi_referensi = ?,
                tanggal_pemberian = ?,
                dosis_ke = ?,
                nomor_batch = ?,
                produsen_vaksin = ?,
                body_site_nama = ?,
                body_site_display = ?,
                body_site_code = ?,
                body_site_system = ?,
                id_praktisi = ?,
                praktisi_ihs = ?,
                praktisi_nama = ?,
                catatan = ?,
                datetime_update = ?
            WHERE id_imunisasi = ?
        ";

        $stmtUpdate = mysqli_prepare($Conn, $queryUpdate);
        if (!$stmtUpdate) {
            throw new Exception('Gagal menyiapkan query update.');
        }

        $typesUpdate = str_repeat('s', 17);
        $paramsUpdate = [
            $id_pasien,
            $id_kunjungan,
            $id_imunisasi_referensi,
            $tanggal_pemberian_utc,
            $dosis_ke,
            $nomor_batch !== '' ? $nomor_batch : null,
            $produsen_vaksin !== '' ? $produsen_vaksin : null,
            $body_site_nama,
            $body_site_display,
            $body_site_code,
            $body_site_system,
            $id_praktisi > 0 ? $id_praktisi : null,
            $praktisi_ihs,
            $praktisi_nama,
            $catatan !== '' ? $catatan : null,
            $datetime_update,
            $id_imunisasi
        ];

        mysqli_stmt_bind_param($stmtUpdate, $typesUpdate, ...$paramsUpdate);

        if (!mysqli_stmt_execute($stmtUpdate)) {
            throw new Exception('Gagal menyimpan perubahan data ke database.');
        }

        mysqli_stmt_close($stmtUpdate);
        mysqli_commit($Conn);

        $response['status']  = 'success';
        $response['message'] = 'Data imunisasi berhasil diperbarui.';

    } catch (Exception $e) {
        mysqli_rollback($Conn);
        $response['message'] = $e->getMessage();
    } catch (Throwable $e) {
        mysqli_rollback($Conn);
        $response['message'] = 'Terjadi kesalahan sistem: ' . $e->getMessage();
    }

    $jsonEncoded = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($jsonEncoded === false) {
        $response['message'] = 'Gagal mengkodekan respons JSON.';
        $jsonEncoded = json_encode($response);
    }

    echo $jsonEncoded;
    $jsonSent = true;
    ob_end_flush();
?>


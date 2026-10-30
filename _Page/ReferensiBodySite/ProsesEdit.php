<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // OUTPUT BUFFERING
    // =========================================================
    ob_start();

    // =========================================================
    // JSON RESPONSE HEADER
    // =========================================================
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

    // =========================================================
    // CONNECTION
    // =========================================================
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

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    // =========================================================
    // TANGKAP DATA
    // =========================================================
    $id_body_site       = (int)($_POST['id_body_site'] ?? 0);
    $body_site_category = trim(validateAndSanitizeInput($_POST['body_site_category'] ?? ''));
    $body_site_nama     = trim(validateAndSanitizeInput($_POST['body_site_nama'] ?? ''));
    $body_site_display  = trim(validateAndSanitizeInput($_POST['body_site_display'] ?? ''));
    $body_site_code     = trim(validateAndSanitizeInput($_POST['body_site_code'] ?? ''));
    $body_site_system   = trim(validateAndSanitizeInput($_POST['body_site_system'] ?? ''));

    if ($body_site_nama === '' && $body_site_display !== '') {
        $body_site_nama = $body_site_display;
    }

    // =========================================================
    // VALIDASI ID
    // =========================================================
    if (!$id_body_site) {
        $response['message'] = 'ID body site tidak valid.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    // =========================================================
    // VALIDASI MANDATORY
    // =========================================================
    if ($body_site_category === '') {
        $response['message'] = 'Kategori Body Site wajib dipilih.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if ($body_site_display === '') {
        $response['message'] = 'Display Body Site wajib diisi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if ($body_site_nama === '') {
        $response['message'] = 'Nama Lokal Body Site wajib diisi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    // =========================================================
    // CEK DATA EXISTING
    // =========================================================
    $stmtExisting = mysqli_prepare($Conn, "SELECT id_body_site FROM body_site WHERE id_body_site = ? LIMIT 1");
    if (!$stmtExisting) {
        $response['message'] = 'Gagal menyiapkan query validasi data.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_bind_param($stmtExisting, 'i', $id_body_site);
    mysqli_stmt_execute($stmtExisting);
    $resultExisting = mysqli_stmt_get_result($stmtExisting);
    if (mysqli_num_rows($resultExisting) === 0) {
        mysqli_stmt_close($stmtExisting);
        $response['message'] = 'Data body site tidak ditemukan.';
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_close($stmtExisting);

    // =========================================================
    // VALIDASI DUPLIKAT (OR) mengecualikan id saat ini
    // =========================================================
    $conditions = [];
    $params     = [];
    $types      = 'i';
    $params[]   = $id_body_site;

    if ($body_site_nama !== '') {
        $conditions[] = "body_site_nama = ?";
        $params[]     = $body_site_nama;
        $types       .= 's';
    }
    if ($body_site_display !== '') {
        $conditions[] = "body_site_display = ?";
        $params[]     = $body_site_display;
        $types       .= 's';
    }
    if ($body_site_code !== '') {
        $conditions[] = "body_site_code = ?";
        $params[]     = $body_site_code;
        $types       .= 's';
    }

    if (!empty($conditions)) {
        $where = "WHERE id_body_site != ? AND (" . implode(" OR ", $conditions) . ")";
        $queryCek = "SELECT id_body_site FROM body_site $where LIMIT 1";
        $stmtCek = mysqli_prepare($Conn, $queryCek);
        if (!$stmtCek) {
            $response['message'] = 'Gagal menyiapkan query validasi duplikat.';
            echo json_encode($response);
            $jsonSent = true;
            ob_end_flush();
            exit;
        }
        mysqli_stmt_bind_param($stmtCek, $types, ...$params);
        mysqli_stmt_execute($stmtCek);
        $resultCek = mysqli_stmt_get_result($stmtCek);
        if (mysqli_num_rows($resultCek) > 0) {
            mysqli_stmt_close($stmtCek);
            $response['message'] = 'Data body site sudah ada (nama/display/code tidak boleh duplikat).';
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $jsonSent = true;
            ob_end_flush();
            exit;
        }
        mysqli_stmt_close($stmtCek);
    }

    // =========================================================
    // UPDATE DATA
    // =========================================================
    $datetime_update = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    mysqli_begin_transaction($Conn);

    try {
        $queryUpdate = "
            UPDATE body_site SET
                body_site_category = ?,
                body_site_nama = ?,
                body_site_display = ?,
                body_site_code = ?,
                body_site_system = ?,
                datetime_update = ?
            WHERE id_body_site = ?
        ";

        $stmtUpdate = mysqli_prepare($Conn, $queryUpdate);
        if (!$stmtUpdate) {
            throw new Exception('Gagal menyiapkan query update.');
        }

        $typesUpdate = 'ssssssi';
        $paramsUpdate = [
            $body_site_category,
            $body_site_nama,
            $body_site_display,
            $body_site_code !== '' ? $body_site_code : null,
            $body_site_system !== '' ? $body_site_system : null,
            $datetime_update,
            $id_body_site
        ];

        mysqli_stmt_bind_param($stmtUpdate, $typesUpdate, ...$paramsUpdate);

        if (!mysqli_stmt_execute($stmtUpdate)) {
            throw new Exception('Gagal menyimpan perubahan data ke database.');
        }

        mysqli_stmt_close($stmtUpdate);
        mysqli_commit($Conn);

        $response['status']  = 'success';
        $response['message'] = 'Data referensi body site berhasil diperbarui.';

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


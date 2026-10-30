<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // OUTPUT BUFFERING (Ensure clean JSON output)
    // =========================================================
    ob_start();

    // =========================================================
    // JSON RESPONSE HEADER
    // =========================================================
    header('Content-Type: application/json; charset=utf-8');

    // Default response
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan yang tidak diketahui.'
    ];

    $jsonSent = false;

    // =========================================================
    // SHUTDOWN HANDLER — ensure JSON is always returned
    // =========================================================
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

    // Validate connection
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
    // TANGKAP DATA DARI FORM
    // =========================================================
    $body_site_category = trim(validateAndSanitizeInput($_POST['body_site_category'] ?? ''));
    $body_site_nama     = trim(validateAndSanitizeInput($_POST['body_site_nama'] ?? ''));
    $body_site_display  = trim(validateAndSanitizeInput($_POST['body_site_display'] ?? ''));
    $body_site_code     = trim(validateAndSanitizeInput($_POST['body_site_code'] ?? ''));
    $body_site_system   = trim(validateAndSanitizeInput($_POST['body_site_system'] ?? ''));

    // Fallback nama lokal dari display jika tidak dikirim
    if ($body_site_nama === '' && $body_site_display !== '') {
        $body_site_nama = $body_site_display;
    }

    // =========================================================
    // VALIDASI DATA MANDATORY
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
    // VALIDASI DATA DUPLIKAT
    // (body_site_nama, body_site_display, body_site_code)
    // =========================================================
    $conditions = [];
    $params     = [];
    $types      = '';

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

        $where = "WHERE " . implode(" OR ", $conditions);

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
            $response['message'] = 'Data body site sudah ada (nama/display/code tidak boleh duplikat).';
            mysqli_stmt_close($stmtCek);
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $jsonSent = true;
            ob_end_flush();
            exit;
        }

        mysqli_stmt_close($stmtCek);
    }

    // =========================================================
    // SIMPAN DATA DENGAN TRANSACTION
    // =========================================================
    $datetime_now = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    $author_id   = (int)$SessionIdAkses;
    $author_name = validateAndSanitizeInput($SessionNama ?? 'Unknown');

    mysqli_begin_transaction($Conn);

    try {
        $queryInsert = "
            INSERT INTO body_site (
                body_site_category,
                body_site_nama,
                body_site_display,
                body_site_code,
                body_site_system,
                datetime_creat,
                datetime_update,
                author_id,
                author_name
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmtInsert = mysqli_prepare($Conn, $queryInsert);

        if (!$stmtInsert) {
            throw new Exception('Gagal menyiapkan query insert.');
        }

        $typesInsert = 'sssssssis';
        $paramsInsert = [
            $body_site_category,
            $body_site_nama,
            $body_site_display,
            $body_site_code,
            $body_site_system,
            $datetime_now,
            $datetime_now,
            $author_id,
            $author_name
        ];

        mysqli_stmt_bind_param($stmtInsert, $typesInsert, ...$paramsInsert);

        if (!mysqli_stmt_execute($stmtInsert)) {
            throw new Exception('Gagal menyimpan data ke database.');
        }

        mysqli_stmt_close($stmtInsert);
        mysqli_commit($Conn);

        $response['status']  = 'success';
        $response['message'] = 'Data referensi body site berhasil disimpan.';

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


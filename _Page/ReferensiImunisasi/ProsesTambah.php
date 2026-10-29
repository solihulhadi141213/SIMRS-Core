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
    // even if die()/exit() or a fatal error occurs
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

    // Validate connection (Connection.php may call die() on failure,
    // which is intercepted by the shutdown handler above)
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
    $nama_vaksin     = trim(validateAndSanitizeInput($_POST['nama_vaksin'] ?? ''));
    $kode_cvx        = trim(validateAndSanitizeInput($_POST['kode_cvx'] ?? ''));
    $kode_kemenkes   = trim(validateAndSanitizeInput($_POST['kode_kemenkes'] ?? ''));
    $display_vaksin  = trim(validateAndSanitizeInput($_POST['display_vaksin'] ?? ''));
    $system_vaksin   = trim(validateAndSanitizeInput($_POST['system_vaksin'] ?? ''));
    $target_penyakit = trim(validateAndSanitizeInput($_POST['target_penyakit'] ?? ''));
    $status          = (int)($_POST['status'] ?? 1);

    // =========================================================
    // VALIDASI DATA MANDATORY
    // =========================================================
    if ($nama_vaksin === '') {
        $response['message'] = 'Nama Vaksin wajib diisi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if (!in_array($status, [0, 1])) {
        $status = 1;
    }

    // =========================================================
    // VALIDASI DATA DUPLIKAT
    // =========================================================
    $where = "WHERE nama_vaksin = ?";
    $params = [$nama_vaksin];
    $types = 's';

    if ($kode_cvx !== '') {
        $where .= " AND kode_cvx = ?";
        $params[] = $kode_cvx;
        $types .= 's';
    }

    if ($kode_kemenkes !== '') {
        $where .= " AND kode_kemenkes = ?";
        $params[] = $kode_kemenkes;
        $types .= 's';
    }

    if ($display_vaksin !== '') {
        $where .= " AND display_vaksin = ?";
        $params[] = $display_vaksin;
        $types .= 's';
    }

    if ($system_vaksin !== '') {
        $where .= " AND system_vaksin = ?";
        $params[] = $system_vaksin;
        $types .= 's';
    }

    $queryCek = "SELECT id_imunisasi_referensi FROM imunisasi_referensi $where LIMIT 1";
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
        $response['message'] = 'Data referensi imunisasi sudah tersedia dengan kriteria yang sama.';
        mysqli_stmt_close($stmtCek);
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_close($stmtCek);

    // =========================================================
    // SIMPAN DATA DENGAN TRANSACTION
    // =========================================================
    $datetime_creat = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    $author_id   = (int)$SessionIdAkses;
    $author_name = validateAndSanitizeInput($SessionNama);

    mysqli_begin_transaction($Conn);

    try {
        $queryInsert = "
            INSERT INTO imunisasi_referensi (
                nama_vaksin,
                kode_cvx,
                kode_kemenkes,
                display_vaksin,
                system_vaksin,
                target_penyakit,
                status,
                datetime_creat,
                author_id,
                author_name
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmtInsert = mysqli_prepare($Conn, $queryInsert);

        if (!$stmtInsert) {
            throw new Exception('Gagal menyiapkan query insert.');
        }

        $typesInsert = 'ssssssisis';
        $paramsInsert = [
            $nama_vaksin,
            $kode_cvx,
            $kode_kemenkes,
            $display_vaksin,
            $system_vaksin,
            $target_penyakit,
            $status,
            $datetime_creat,
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
        $response['message'] = 'Data referensi imunisasi berhasil disimpan.';

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



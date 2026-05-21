<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json; charset=utf-8');

    // =========================================================
    // DEFAULT RESPONSE
    // =========================================================
    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan"
    ];

    try {

        // =====================================================
        // LOAD FILE
        // =====================================================
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/SimrsFunction.php";

        // =====================================================
        // VALIDASI KONEKSI
        // =====================================================
        if (empty($Conn)) {

            $response["message"] = "Koneksi database gagal";

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // TANGKAP DATA
        // =====================================================
        $kategori_alergen = $_POST['kategori_alergen'] ?? '';
        $nama_alergen     = $_POST['nama_alergen'] ?? '';
        $code_alergen     = $_POST['code_alergen'] ?? '';
        $display_alergen  = $_POST['display_alergen'] ?? '';
        $system_alergen   = $_POST['system_alergen'] ?? '';

        // =====================================================
        // SANITASI
        // =====================================================
        if(function_exists('validateAndSanitizeInput')){

            $kategori_alergen = validateAndSanitizeInput($kategori_alergen);
            $nama_alergen     = validateAndSanitizeInput($nama_alergen);
            $code_alergen     = validateAndSanitizeInput($code_alergen);
            $display_alergen  = validateAndSanitizeInput($display_alergen);
            $system_alergen   = validateAndSanitizeInput($system_alergen);
        }

        // =====================================================
        // TRIM
        // =====================================================
        $kategori_alergen = trim($kategori_alergen);
        $nama_alergen     = trim($nama_alergen);
        $code_alergen     = trim($code_alergen);
        $display_alergen  = trim($display_alergen);
        $system_alergen   = trim($system_alergen);

        // =====================================================
        // VALIDASI
        // =====================================================
        if (empty($kategori_alergen)) {

            $response["message"] = "Kategori alergen tidak boleh kosong";

            echo json_encode($response);
            exit;
        }

        if (empty($nama_alergen)) {

            $response["message"] = "Nama alergen tidak boleh kosong";

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // VALIDASI ENUM
        // =====================================================
        $allowed_kategori = [
            'Food',
            'Medication',
            'Environment',
            'Biologic'
        ];

        if (!in_array($kategori_alergen, $allowed_kategori)) {

            $response["message"] = "Kategori alergen tidak valid";

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // CEK DUPLIKAT
        // =====================================================
        $query_check = "
            SELECT id_alergi_alergen
            FROM alergi_alergen
            WHERE nama_alergen = ?
            LIMIT 1
        ";

        $stmt_check = mysqli_prepare($Conn, $query_check);

        if (!$stmt_check) {

            $response["message"] = "Prepare statement gagal";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt_check,
            "s",
            $nama_alergen
        );

        mysqli_stmt_execute($stmt_check);

        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {

            mysqli_stmt_close($stmt_check);

            $response["message"] = "Data alergen sudah ada";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_check);

        // =====================================================
        // AUTHOR
        // =====================================================
        $author_id   = $SessionIdAkses ?? 0;
        $author_name = $SessionNama ?? 'Unknown';

        // =====================================================
        // DATETIME
        // =====================================================
        date_default_timezone_set('Asia/Jakarta');

        $datetime_creat = date('Y-m-d H:i:s');

        // =====================================================
        // STATUS
        // =====================================================
        $status = 1;

        // =====================================================
        // INSERT
        // =====================================================
        $query_insert = "
            INSERT INTO alergi_alergen (
                kategori_alergen,
                nama_alergen,
                code_alergen,
                display_alergen,
                system_alergen,
                author_id,
                author_name,
                datetime_creat,
                status
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";

        $stmt_insert = mysqli_prepare($Conn, $query_insert);

        if (!$stmt_insert) {

            $response["message"] = "Prepare insert gagal";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt_insert,
            "sssssissi",
            $kategori_alergen,
            $nama_alergen,
            $code_alergen,
            $display_alergen,
            $system_alergen,
            $author_id,
            $author_name,
            $datetime_creat,
            $status
        );

        $execute = mysqli_stmt_execute($stmt_insert);

        if (!$execute) {

            mysqli_stmt_close($stmt_insert);

            $response["message"] = "Gagal menyimpan data";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_insert);

        // =====================================================
        // SUCCESS
        // =====================================================
        $response["status"]  = "success";
        $response["message"] = "Data referensi alergen berhasil disimpan";

        echo json_encode(
            $response,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;

    } catch (Throwable $e) {

        $response["status"]  = "error";
        $response["message"] = "Terjadi kesalahan sistem";

        echo json_encode(
            $response,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;
    }
?>
<?php
    // Error reporting
    error_reporting(0);
    ini_set('display_errors', 0);

    // Header JSON
    header('Content-Type: application/json; charset=utf-8');

    // Default response
    $response = ["status" => "error", "message" => "Terjadi kesalahan"];

    try {

        // Load config
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/SimrsFunction.php";

        // Validasi koneksi
        if (empty($Conn)) {
            $response["message"] = "Koneksi database gagal";
            echo json_encode($response);
            exit;
        }

        // Tangkap data
        $id_alergi_alergen = validateAndSanitizeInput($_POST['id_alergi_alergen'] ?? '');
        $kategori_alergen  = validateAndSanitizeInput($_POST['kategori_alergen'] ?? '');
        $nama_alergen      = validateAndSanitizeInput($_POST['nama_alergen'] ?? '');
        $code_alergen      = validateAndSanitizeInput($_POST['code_alergen'] ?? '');
        $display_alergen   = validateAndSanitizeInput($_POST['display_alergen'] ?? '');
        $system_alergen    = validateAndSanitizeInput($_POST['system_alergen'] ?? '');
        $status            = (!empty($_POST['status'])) ? '1' : '0';

        // Trim
        $kategori_alergen = trim($kategori_alergen);
        $nama_alergen     = trim($nama_alergen);
        $code_alergen     = trim($code_alergen);
        $display_alergen  = trim($display_alergen);
        $system_alergen   = trim($system_alergen);

        // Validasi ID
        if (empty($id_alergi_alergen) || !is_numeric($id_alergi_alergen)) {
            $response["message"] = "ID alergen tidak valid";
            echo json_encode($response);
            exit;
        }

        // Validasi wajib
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

        // Validasi kategori
        $allowed_kategori = ['Food', 'Medication', 'Environment', 'Biologic'];

        if (!in_array($kategori_alergen, $allowed_kategori)) {
            $response["message"] = "Kategori alergen tidak valid";
            echo json_encode($response);
            exit;
        }

        // Cek data
        $query_check = "SELECT id_alergi_alergen FROM alergi_alergen WHERE id_alergi_alergen = ? LIMIT 1";
        $stmt_check = mysqli_prepare($Conn, $query_check);

        if (!$stmt_check) {
            $response["message"] = "Terjadi kesalahan query";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param($stmt_check, "i", $id_alergi_alergen);
        mysqli_stmt_execute($stmt_check);

        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) == 0) {
            mysqli_stmt_close($stmt_check);
            $response["message"] = "Data alergen tidak ditemukan";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_check);

        // Cek duplikat
        $query_duplicate = "SELECT id_alergi_alergen FROM alergi_alergen WHERE nama_alergen = ? AND id_alergi_alergen != ? LIMIT 1";
        $stmt_duplicate = mysqli_prepare($Conn, $query_duplicate);

        if (!$stmt_duplicate) {
            $response["message"] = "Terjadi kesalahan query duplicate";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param($stmt_duplicate, "si", $nama_alergen, $id_alergi_alergen);
        mysqli_stmt_execute($stmt_duplicate);

        $result_duplicate = mysqli_stmt_get_result($stmt_duplicate);

        if (mysqli_num_rows($result_duplicate) > 0) {
            mysqli_stmt_close($stmt_duplicate);
            $response["message"] = "Nama alergen sudah digunakan";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_duplicate);

        // Query update
        $query_update = "
            UPDATE alergi_alergen SET
                kategori_alergen = ?,
                nama_alergen = ?,
                code_alergen = ?,
                display_alergen = ?,
                system_alergen = ?,
                status = ?
            WHERE id_alergi_alergen = ?
        ";

        $stmt_update = mysqli_prepare($Conn, $query_update);

        if (!$stmt_update) {
            $response["message"] = "Prepare update gagal";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt_update,
            "sssssii",
            $kategori_alergen,
            $nama_alergen,
            $code_alergen,
            $display_alergen,
            $system_alergen,
            $status,
            $id_alergi_alergen
        );

        $execute = mysqli_stmt_execute($stmt_update);

        // Validasi update
        if (!$execute) {
            mysqli_stmt_close($stmt_update);
            $response["message"] = "Gagal update data";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_update);

        // Success
        $response["status"] = "success";
        $response["message"] = "Edit referensi alergen berhasil";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;

    } catch (Throwable $e) {

        $response["status"] = "error";
        $response["message"] = "Terjadi kesalahan sistem";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
?>
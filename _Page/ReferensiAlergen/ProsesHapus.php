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

        // Validasi session
        if (empty($SessionIdAkses)) {
            $response["message"] = "Sesi akses sudah berakhir";
            echo json_encode($response);
            exit;
        }

        // Tangkap ID
        $id_alergi_alergen = validateAndSanitizeInput($_POST['id_alergi_alergen'] ?? '');

        // Trim
        $id_alergi_alergen = trim($id_alergi_alergen);

        // Validasi ID
        if (empty($id_alergi_alergen) || !is_numeric($id_alergi_alergen)) {
            $response["message"] = "ID alergen tidak valid";
            echo json_encode($response);
            exit;
        }

        // Cek data
        $query_check = "SELECT id_alergi_alergen FROM alergi_alergen WHERE id_alergi_alergen = ? LIMIT 1";
        $stmt_check = mysqli_prepare($Conn, $query_check);

        // Validasi prepare
        if (!$stmt_check) {
            $response["message"] = "Terjadi kesalahan query";
            echo json_encode($response);
            exit;
        }

        // Bind
        mysqli_stmt_bind_param($stmt_check, "i", $id_alergi_alergen);

        // Execute
        mysqli_stmt_execute($stmt_check);

        // Result
        $result_check = mysqli_stmt_get_result($stmt_check);

        // Validasi data
        if (mysqli_num_rows($result_check) == 0) {

            mysqli_stmt_close($stmt_check);

            $response["message"] = "Data alergen tidak ditemukan";
            echo json_encode($response);
            exit;
        }

        // Close
        mysqli_stmt_close($stmt_check);

        // Query hapus
        $query_delete = "DELETE FROM alergi_alergen WHERE id_alergi_alergen = ?";
        $stmt_delete = mysqli_prepare($Conn, $query_delete);

        // Validasi prepare delete
        if (!$stmt_delete) {
            $response["message"] = "Prepare delete gagal";
            echo json_encode($response);
            exit;
        }

        // Bind delete
        mysqli_stmt_bind_param($stmt_delete, "i", $id_alergi_alergen);

        // Execute delete
        $execute = mysqli_stmt_execute($stmt_delete);

        // Validasi execute
        if (!$execute) {

            mysqli_stmt_close($stmt_delete);

            $response["message"] = "Gagal menghapus data";
            echo json_encode($response);
            exit;
        }

        // Close
        mysqli_stmt_close($stmt_delete);

        // Success
        $response["status"] = "success";
        $response["message"] = "Referensi alergen berhasil dihapus";

        // Output
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;

    } catch (Throwable $e) {

        // Error sistem
        $response["status"] = "error";
        $response["message"] = "Terjadi kesalahan sistem";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
?>
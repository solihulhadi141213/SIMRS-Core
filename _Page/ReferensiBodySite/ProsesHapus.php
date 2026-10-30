<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // JSON RESPONSE HEADER
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
        // LOAD CONFIG
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
        // VALIDASI SESSION
        // =====================================================
        if (empty($SessionIdAkses)) {
            $response["message"] = "Sesi akses sudah berakhir";
            echo json_encode($response);
            exit;
        }

        // =====================================================
        // TANGKAP ID
        // =====================================================
        $id_body_site = validateAndSanitizeInput($_POST['id_body_site'] ?? '');
        $id_body_site = trim($id_body_site);

        // =====================================================
        // VALIDASI ID
        // =====================================================
        if (empty($id_body_site) || !is_numeric($id_body_site)) {
            $response["message"] = "ID body site tidak valid";
            echo json_encode($response);
            exit;
        }

        // =====================================================
        // CEK DATA
        // =====================================================
        $query_check = "SELECT id_body_site FROM body_site WHERE id_body_site = ? LIMIT 1";
        $stmt_check = mysqli_prepare($Conn, $query_check);

        if (!$stmt_check) {
            $response["message"] = "Terjadi kesalahan query";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param($stmt_check, "i", $id_body_site);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) == 0) {
            mysqli_stmt_close($stmt_check);
            $response["message"] = "Data body site tidak ditemukan";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_check);

        // =====================================================
        // HAPUS DATA
        // =====================================================
        $query_delete = "DELETE FROM body_site WHERE id_body_site = ?";
        $stmt_delete = mysqli_prepare($Conn, $query_delete);

        if (!$stmt_delete) {
            $response["message"] = "Prepare delete gagal";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param($stmt_delete, "i", $id_body_site);
        $execute = mysqli_stmt_execute($stmt_delete);

        if (!$execute) {
            mysqli_stmt_close($stmt_delete);
            $response["message"] = "Gagal menghapus data";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_delete);

        // =====================================================
        // SUCCESS
        // =====================================================
        $response["status"]  = "success";
        $response["message"] = "Referensi body site berhasil dihapus";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;

    } catch (Throwable $e) {

        $response["status"]  = "error";
        $response["message"] = "Terjadi kesalahan sistem";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
?>


<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    header('Content-Type: application/json; charset=utf-8');

    $response = ["status" => "error", "message" => "Terjadi kesalahan"];

    try {
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/SimrsFunction.php";

        if (empty($Conn)) {
            $response["message"] = "Koneksi database gagal";
            echo json_encode($response);
            exit;
        }

        if (empty($SessionIdAkses)) {
            $response["message"] = "Sesi akses sudah berakhir";
            echo json_encode($response);
            exit;
        }

        $pernyataan = trim((string) ($_POST['pernyataan_petugas_penghapus_imunisasi'] ?? ''));
        if ($pernyataan !== '1') {
            $response["message"] = "Pernyataan petugas wajib dicentang.";
            echo json_encode($response);
            exit;
        }

        $id_imunisasi_referensi = validateAndSanitizeInput($_POST['id_imunisasi_referensi'] ?? '');
        $id_imunisasi_referensi = trim($id_imunisasi_referensi);


        if (empty($id_imunisasi_referensi) || !is_numeric($id_imunisasi_referensi)) {
            $response["message"] = "ID referensi imunisasi tidak valid";
            echo json_encode($response);
            exit;
        }

        $query_check = "SELECT id_imunisasi_referensi FROM imunisasi_referensi WHERE id_imunisasi_referensi = ? LIMIT 1";
        $stmt_check = mysqli_prepare($Conn, $query_check);
        if (!$stmt_check) {
            $response["message"] = "Terjadi kesalahan query";
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_bind_param($stmt_check, "i", $id_imunisasi_referensi);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        if (mysqli_num_rows($result_check) == 0) {
            mysqli_stmt_close($stmt_check);
            $response["message"] = "Data referensi imunisasi tidak ditemukan";
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmt_check);

        $query_delete = "DELETE FROM imunisasi_referensi WHERE id_imunisasi_referensi = ?";
        $stmt_delete = mysqli_prepare($Conn, $query_delete);
        if (!$stmt_delete) {
            $response["message"] = "Prepare delete gagal";
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_bind_param($stmt_delete, "i", $id_imunisasi_referensi);
        $execute = mysqli_stmt_execute($stmt_delete);
        if (!$execute) {
            mysqli_stmt_close($stmt_delete);
            $response["message"] = "Gagal menghapus data";
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmt_delete);

        $response["status"] = "success";
        $response["message"] = "Referensi imunisasi berhasil dihapus";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;

    } catch (Throwable $e) {
        $response["status"] = "error";
        $response["message"] = "Terjadi kesalahan sistem";
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
?>


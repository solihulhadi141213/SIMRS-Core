<?php
    header('Content-Type: application/json');

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi & Session
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Default response
    $response = [
        "status" => "error",
        "message" => "Terjadi kesalahan."
    ];

    // ===============================
    // VALIDASI SESSION
    // ===============================
    if (empty($SessionIdAkses)) {
        $response["message"] = "Sesi akses berakhir, silahkan login ulang.";
        echo json_encode($response);
        exit;
    }

    // ===============================
    // VALIDASI METHOD
    // ===============================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response["message"] = "Metode request tidak valid.";
        echo json_encode($response);
        exit;
    }

    // ===============================
    // VALIDASI ID
    // ===============================
    $id_setting_sirs_online = isset($_POST['id_setting_sirs_online']) ? (int)$_POST['id_setting_sirs_online'] : 0;

    if (empty($id_setting_sirs_online)) {
        $response["message"] = "ID tidak valid.";
        echo json_encode($response);
        exit;
    }

    // ===============================
    // CEK DATA EXIST (PREPARED)
    // ===============================
    $stmtCheck = mysqli_prepare($Conn, "
        SELECT id_setting_sirs_online, status 
        FROM setting_sirs_online 
        WHERE id_setting_sirs_online = ?
    ");

    if (!$stmtCheck) {
        $response["message"] = "Gagal prepare statement.";
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmtCheck, "i", $id_setting_sirs_online);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);

    if (!$resultCheck || mysqli_num_rows($resultCheck) == 0) {
        $response["message"] = "Data tidak ditemukan.";
        echo json_encode($response);
        exit;
    }

    $data = mysqli_fetch_assoc($resultCheck);
    mysqli_stmt_close($stmtCheck);

    // ===============================
    // PROSES HAPUS (PREPARED)
    // ===============================
    $stmtDelete = mysqli_prepare($Conn, "
        DELETE FROM setting_sirs_online 
        WHERE id_setting_sirs_online = ?
    ");

    if (!$stmtDelete) {
        $response["message"] = "Gagal prepare delete.";
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmtDelete, "i", $id_setting_sirs_online);

    $delete = mysqli_stmt_execute($stmtDelete);

    if ($delete) {

        $response["status"]  = "success";
        $response["message"] = "Data berhasil dihapus.";

    } else {
        $response["message"] = "Gagal menghapus data.";
    }

    mysqli_stmt_close($stmtDelete);

    // ===============================
    // OUTPUT
    // ===============================
    echo json_encode($response);
?>
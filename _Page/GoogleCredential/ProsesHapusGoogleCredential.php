<?php
    // Header JSON
    header('Content-Type: application/json');

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir, silakan login ulang.'
        ]);
        exit;
    }

    // =============================================
    // VALIDASI METHOD
    // =============================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // =============================================
    // VALIDASI ID
    // =============================================
    if (empty($_POST['id_setting_google'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Google Credential tidak boleh kosong.'
        ]);
        exit;
    }

    $id_setting_google = (int) $_POST['id_setting_google'];

    // =============================================
    // VALIDASI DATA ADA
    // =============================================
    $check = mysqli_prepare(
        $Conn,
        "SELECT id_setting_google 
         FROM setting_google 
         WHERE id_setting_google = ?"
    );

    if (!$check) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal prepare query validasi.'
        ]);
        exit;
    }

    mysqli_stmt_bind_param($check, "i", $id_setting_google);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data Google Credential tidak ditemukan.'
        ]);
        exit;
    }

    mysqli_stmt_close($check);

    // =============================================
    // PROSES HAPUS
    // =============================================
    $delete = mysqli_prepare(
        $Conn,
        "DELETE FROM setting_google 
         WHERE id_setting_google = ?"
    );

    if (!$delete) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal prepare query hapus.'
        ]);
        exit;
    }

    mysqli_stmt_bind_param($delete, "i", $id_setting_google);

    if (mysqli_stmt_execute($delete)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Google Credential berhasil dihapus.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus data.'
        ]);
    }

    mysqli_stmt_close($delete);
?>
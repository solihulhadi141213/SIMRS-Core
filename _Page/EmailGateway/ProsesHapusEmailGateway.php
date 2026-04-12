<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // ======================================
    // VALIDASI SESSION
    // ======================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir.'
        ]);
        exit;
    }

    // ======================================
    // VALIDASI ID
    // ======================================
    if (empty($_POST['id_setting_email_gateway'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID API Key tidak valid.'
        ]);
        exit;
    }

    $id_setting_email_gateway = validateAndSanitizeInput($_POST['id_setting_email_gateway']);

    // ======================================
    // HAPUS DATABASE
    // ======================================
    $stmtDelete = $Conn->prepare("DELETE FROM setting_email_gateway WHERE id_setting_email_gateway = ?");
    $stmtDelete->bind_param("i", $id_setting_email_gateway);

    $delete = $stmtDelete->execute();

    if ($delete) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus data.'
        ]);
    }
?>
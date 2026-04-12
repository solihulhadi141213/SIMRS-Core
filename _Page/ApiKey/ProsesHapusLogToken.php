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
    if (empty($_POST['id_api_key'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID API Key tidak valid.'
        ]);
        exit;
    }

    $id_api_key = validateAndSanitizeInput($_POST['id_api_key']);

    // ======================================
    // HAPUS DATABASE
    // ======================================
    $stmtDelete = $Conn->prepare("DELETE FROM api_token WHERE id_api_key = ?");
    $stmtDelete->bind_param("i", $id_api_key);

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
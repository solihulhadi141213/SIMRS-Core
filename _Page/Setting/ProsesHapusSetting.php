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
    if (empty($_POST['id_setting'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID setting tidak valid.'
        ]);
        exit;
    }

    $id_setting = validateAndSanitizeInput($_POST['id_setting']);

    // ======================================
    // AMBIL DATA FILE LAMA
    // ======================================
    $stmt = $Conn->prepare("SELECT favicon, logo FROM setting WHERE id_setting = ?");
    $stmt->bind_param("i", $id_setting);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data setting tidak ditemukan.'
        ]);
        exit;
    }

    $favicon = $data['favicon'] ?? '';
    $logo = $data['logo'] ?? '';

    $stmt->close();

    // ======================================
    // HAPUS FILE
    // ======================================
    $uploadDir = "../../assets/images/";

    if (!empty($favicon) && file_exists($uploadDir . $favicon)) {
        unlink($uploadDir . $favicon);
    }

    if (!empty($logo) && file_exists($uploadDir . $logo)) {
        unlink($uploadDir . $logo);
    }

    // ======================================
    // HAPUS DATABASE
    // ======================================
    $stmtDelete = $Conn->prepare("DELETE FROM setting WHERE id_setting = ?");
    $stmtDelete->bind_param("i", $id_setting);

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
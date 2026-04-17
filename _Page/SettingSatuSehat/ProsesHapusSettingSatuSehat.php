<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";

$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan.'
];

// Validasi session
if (empty($SessionIdAkses)) {
    $response['message'] = 'Sesi berakhir.';
    echo json_encode($response);
    exit;
}

// Validasi method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Request tidak valid.';
    echo json_encode($response);
    exit;
}

try {

    $id = $_POST['id_setting_satusehat'] ?? '';

    if (empty($id)) {
        $response['message'] = 'ID tidak valid.';
        echo json_encode($response);
        exit;
    }

    // Ambil data
    $stmt = $Conn->prepare("SELECT status_setting_satusehat FROM setting_satusehat WHERE id_setting_satusehat = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        $response['message'] = 'Data tidak ditemukan.';
        echo json_encode($response);
        exit;
    }

    // =============================================
    // CEGAH HAPUS DATA AKTIF
    // =============================================
    if ($data['status_setting_satusehat'] == 1) {
        $response['message'] = 'Data yang sedang aktif tidak boleh dihapus.';
        echo json_encode($response);
        exit;
    }

    // =============================================
    // HAPUS DATA
    // =============================================
    $stmtDelete = $Conn->prepare("DELETE FROM setting_satusehat WHERE id_setting_satusehat = ?");
    $stmtDelete->bind_param("i", $id);

    if ($stmtDelete->execute()) {
        $response['status']  = 'success';
        $response['message'] = 'Data berhasil dihapus.';
    } else {
        $response['message'] = 'Gagal menghapus data.';
    }

    $stmtDelete->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
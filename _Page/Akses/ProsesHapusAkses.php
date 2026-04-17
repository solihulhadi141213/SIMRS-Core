<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";

$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan'
];

// =============================
// VALIDASI SESSION
// =============================
if (empty($SessionIdAkses)) {
    $response['message'] = 'Session habis';
    echo json_encode($response);
    exit;
}

// =============================
// VALIDASI METHOD
// =============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Metode tidak valid';
    echo json_encode($response);
    exit;
}

try {

    // =============================
    // AMBIL ID
    // =============================
    $id_akses = (int) ($_POST['id_akses'] ?? 0);

    if (empty($id_akses)) {
        throw new Exception('ID tidak valid');
    }

    // =============================
    // AMBIL DATA (UNTUK GAMBAR)
    // =============================
    $stmt = $Conn->prepare("SELECT gambar FROM akses WHERE id_akses = ?");
    $stmt->bind_param("i", $id_akses);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if (!$data) {
        throw new Exception('Data tidak ditemukan');
    }

    $gambar = $data['gambar'];

    // =============================
    // HAPUS DATA DATABASE
    // =============================
    $stmtDelete = $Conn->prepare("DELETE FROM akses WHERE id_akses = ?");
    $stmtDelete->bind_param("i", $id_akses);

    if (!$stmtDelete->execute()) {
        throw new Exception('Gagal menghapus data');
    }

    $stmtDelete->close();

    // =============================
    // HAPUS FILE GAMBAR (JIKA ADA)
    // =============================
    if (!empty($gambar)) {

        $path = "../../assets/images/user/" . $gambar;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    // =============================
    // SUCCESS
    // =============================
    $response['status']  = 'success';
    $response['message'] = 'Data berhasil dihapus';

} catch (Exception $e) {

    $response['message'] = $e->getMessage();
}

// =============================
// OUTPUT
// =============================
echo json_encode($response);
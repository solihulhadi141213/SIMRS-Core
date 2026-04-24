<?php
header('Content-Type: application/json');

date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan.'
];

// ==========================
// VALIDASI SESSION
// ==========================
if (empty($SessionIdAkses)) {
    $response['message'] = 'Sesi akses berakhir.';
    echo json_encode($response);
    exit;
}

// ==========================
// VALIDASI METHOD
// ==========================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Request tidak valid.';
    echo json_encode($response);
    exit;
}

// ==========================
// VALIDASI INPUT
// ==========================
$id_jadwal = $_POST['id_jadwal'] ?? '';

if (empty($id_jadwal)) {
    $response['message'] = 'ID tidak valid.';
    echo json_encode($response);
    exit;
}

// ==========================
// CEK DATA ADA
// ==========================
$cek = mysqli_prepare($Conn, "SELECT id_jadwal FROM jadwal_dokter WHERE id_jadwal=?");
mysqli_stmt_bind_param($cek, "i", $id_jadwal);
mysqli_stmt_execute($cek);
$result = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($result) == 0) {
    $response['message'] = 'Data tidak ditemukan.';
    echo json_encode($response);
    exit;
}

// ==========================
// HAPUS DATA
// ==========================
$delete = mysqli_prepare($Conn, "DELETE FROM jadwal_dokter WHERE id_jadwal=?");
mysqli_stmt_bind_param($delete, "i", $id_jadwal);

if (mysqli_stmt_execute($delete)) {
    $response['status'] = 'success';
    $response['message'] = 'Data berhasil dihapus.';
} else {
    $response['message'] = 'Gagal menghapus data.';
}

mysqli_stmt_close($delete);
echo json_encode($response);
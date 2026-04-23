<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";

$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan.'
];

// VALIDASI SESSION
if (empty($SessionIdAkses)) {
    exit(json_encode([
        'status'=>'error',
        'message'=>'Sesi berakhir, silakan login ulang'
    ]));
}

// VALIDASI METHOD
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode([
        'status'=>'error',
        'message'=>'Request tidak valid'
    ]));
}

// VALIDASI INPUT
$id_dokter = $_POST['id_dokter'] ?? '';

if ($id_dokter == '') {
    exit(json_encode([
        'status'=>'error',
        'message'=>'ID dokter tidak valid'
    ]));
}

try {

    // =========================
    // AMBIL DATA (UNTUK FOTO)
    // =========================
    $stmt = mysqli_prepare($Conn, "
        SELECT foto 
        FROM dokter 
        WHERE id_dokter = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $id_dokter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        exit(json_encode([
            'status'=>'error',
            'message'=>'Data tidak ditemukan'
        ]));
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $foto = $data['foto'];

    // =========================
    // HAPUS DATA DOKTER
    // =========================
    $stmt = mysqli_prepare($Conn, "
        DELETE FROM dokter 
        WHERE id_dokter = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $id_dokter);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Gagal menghapus data dokter');
    }

    mysqli_stmt_close($stmt);

    // =========================
    // HAPUS FILE FOTO (JIKA ADA)
    // =========================
    if (!empty($foto)) {
        $path = "../../assets/images/Dokter/" . $foto;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    echo json_encode([
        'status'  => 'success',
        'message' => 'Data dokter berhasil dihapus'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
}
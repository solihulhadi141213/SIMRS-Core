<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Header JSON
    header('Content-Type: application/json');

    // =====================
    // VALIDASI SESSION
    // =====================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Session login tidak valid, silahkan login ulang.'
        ]);
        exit;
    }

    // =====================
    // VALIDASI METHOD
    // =====================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // =====================
    // AMBIL DATA
    // =====================
    $id_ruang_rawat = !empty($_POST['id_ruang_rawat']) 
        ? validateAndSanitizeInput($_POST['id_ruang_rawat']) 
        : '';

    $id_kelas_rawat = !empty($_POST['id_kelas_rawat']) 
        ? validateAndSanitizeInput($_POST['id_kelas_rawat']) 
        : '';

    // =====================
    // VALIDASI INPUT
    // =====================
    if (empty($id_ruang_rawat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID ruangan tidak valid.'
        ]);
        exit;
    }

    if (empty($id_kelas_rawat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID kelas tidak valid.'
        ]);
        exit;
    }

    // =====================
    // CEK DATA EXIST
    // =====================
    $cek = $Conn->prepare("
        SELECT id_ruang_rawat 
        FROM rr_ruang_rawat 
        WHERE id_ruang_rawat = ?
    ");
    $cek->bind_param("i", $id_ruang_rawat);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Data ruangan tidak ditemukan.'
        ]);
        exit;
    }
    $cek->close();

    // =====================
    // PROSES HAPUS
    // =====================
    try {

        $stmt = $Conn->prepare("
            DELETE FROM rr_ruang_rawat 
            WHERE id_ruang_rawat = ?
        ");

        $stmt->bind_param("i", $id_ruang_rawat);

        if ($stmt->execute()) {

            echo json_encode([
                'status'           => 'success',
                'message'          => 'Data ruangan berhasil dihapus.',
                'id_kelas_rawat'   => $id_kelas_rawat
            ]);

        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Gagal menghapus data.'
            ]);
        }

        $stmt->close();

    } catch (Exception $e) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>
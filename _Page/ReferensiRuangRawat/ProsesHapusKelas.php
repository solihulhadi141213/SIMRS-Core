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
    $id_kelas_rawat = !empty($_POST['id_kelas_rawat']) 
        ? validateAndSanitizeInput($_POST['id_kelas_rawat']) 
        : '';

    // =====================
    // VALIDASI INPUT
    // =====================
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
        SELECT id_kelas_rawat 
        FROM rr_kelas_rawat 
        WHERE id_kelas_rawat = ?
    ");
    $cek->bind_param("i", $id_kelas_rawat);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Data kelas tidak ditemukan.'
        ]);
        exit;
    }
    $cek->close();

    // =====================
    // OPTIONAL VALIDASI TAMBAHAN (RECOMMENDED)
    // =====================
    // Cegah hapus jika masih ada ruangan (kalau mau lebih aman)
    // $cekRelasi = $Conn->prepare("
    //     SELECT id_ruang_rawat 
    //     FROM rr_ruang_rawat 
    //     WHERE id_kelas_rawat = ?
    // ");
    // $cekRelasi->bind_param("i", $id_kelas_rawat);
    // $cekRelasi->execute();
    // $cekRelasi->store_result();

    // if ($cekRelasi->num_rows > 0) {
    //     echo json_encode([
    //         'status'  => 'error',
    //         'message' => 'Kelas masih memiliki ruangan. Hapus ruangan terlebih dahulu.'
    //     ]);
    //     exit;
    // }
    // $cekRelasi->close();

    // =====================
    // PROSES HAPUS
    // =====================
    try {

        $stmt = $Conn->prepare("
            DELETE FROM rr_kelas_rawat 
            WHERE id_kelas_rawat = ?
        ");

        $stmt->bind_param("i", $id_kelas_rawat);

        if ($stmt->execute()) {

            echo json_encode([
                'status'  => 'success',
                'message' => 'Data kelas berhasil dihapus.'
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
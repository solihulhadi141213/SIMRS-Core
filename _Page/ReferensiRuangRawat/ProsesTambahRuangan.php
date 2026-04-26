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
    // AMBIL & SANITASI DATA
    // =====================
    $id_kelas_rawat = !empty($_POST['id_kelas_rawat']) 
        ? validateAndSanitizeInput($_POST['id_kelas_rawat']) 
        : '';

    $ruang_rawat = !empty($_POST['nama_ruangan']) 
        ? validateAndSanitizeInput($_POST['nama_ruangan']) 
        : '';

    $status = !empty($_POST['status']) ? 1 : 0;

    // =====================
    // VALIDASI INPUT
    // =====================
    if (empty($id_kelas_rawat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID kelas rawat tidak ditemukan.'
        ]);
        exit;
    }

    if (empty($ruang_rawat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama ruangan tidak boleh kosong.'
        ]);
        exit;
    }

    // =====================
    // CEK DUPLIKAT (OPTIONAL TAPI PENTING)
    // =====================
    $cek = $Conn->prepare("
        SELECT id_ruang_rawat 
        FROM rr_ruang_rawat 
        WHERE ruang_rawat = ? AND id_kelas_rawat = ?
    ");
    $cek->bind_param("si", $ruang_rawat, $id_kelas_rawat);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama ruangan sudah ada pada kelas ini.'
        ]);
        exit;
    }
    $cek->close();

    // =====================
    // WAKTU SEKARANG
    // =====================
    $updatetime = date('Y-m-d H:i:s');

    // =====================
    // INSERT DATA
    // =====================
    try {

        $stmt = $Conn->prepare("
            INSERT INTO rr_ruang_rawat (
                id_kelas_rawat,
                ruang_rawat,
                status,
                updatetime
            ) VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("isis", 
            $id_kelas_rawat,
            $ruang_rawat,
            $status,
            $updatetime
        );

        if ($stmt->execute()) {

            echo json_encode([
                'status'  => 'success',
                'message' => 'Data ruangan berhasil ditambahkan.',
                'id_kelas_rawat' => $id_kelas_rawat
            ]);

        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data.'
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
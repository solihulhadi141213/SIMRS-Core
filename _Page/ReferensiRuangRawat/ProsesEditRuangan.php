<?php
    // ================= ZONA WAKTU
    date_default_timezone_set('Asia/Jakarta');

    // ================= KONEKSI & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    header('Content-Type: application/json');

    // ================= VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Session login tidak valid, silahkan login ulang.'
        ]);
        exit;
    }

    // ================= VALIDASI METHOD
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'=>'error',
            'message'=>'Metode request tidak valid.'
        ]);
        exit;
    }

    // ================= AMBIL DATA
    $id_ruang_rawat = !empty($_POST['id_ruang_rawat']) 
        ? validateAndSanitizeInput($_POST['id_ruang_rawat']) : '';

    $id_kelas_rawat = !empty($_POST['id_kelas_rawat']) 
        ? validateAndSanitizeInput($_POST['id_kelas_rawat']) : '';

    $ruang_rawat = !empty($_POST['nama_ruangan']) 
        ? strtoupper(trim(validateAndSanitizeInput($_POST['nama_ruangan']))) : '';

    $status = !empty($_POST['status']) ? 1 : 0;

    // ================= VALIDASI INPUT
    if (empty($id_ruang_rawat)) {
        echo json_encode(['status'=>'error','message'=>'ID ruangan tidak valid']); exit;
    }
    if (empty($id_kelas_rawat)) {
        echo json_encode(['status'=>'error','message'=>'ID kelas tidak valid']); exit;
    }
    if (empty($ruang_rawat)) {
        echo json_encode(['status'=>'error','message'=>'Nama ruangan tidak boleh kosong']); exit;
    }

    // ================= CEK DATA RUANGAN + AMBIL STATUS LAMA
    $stmt = $Conn->prepare("
        SELECT status 
        FROM rr_ruang_rawat 
        WHERE id_ruang_rawat = ?
    ");
    $stmt->bind_param("i", $id_ruang_rawat);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status'=>'error','message'=>'Data ruangan tidak ditemukan']); exit;
    }

    $dataRuang = $result->fetch_assoc();
    $status_lama = $dataRuang['status'];
    $stmt->close();

    // ================= CEK STATUS KELAS
    $stmt = $Conn->prepare("
        SELECT status 
        FROM rr_kelas_rawat 
        WHERE id_kelas_rawat = ?
    ");
    $stmt->bind_param("i", $id_kelas_rawat);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status'=>'error','message'=>'Data kelas tidak ditemukan']); exit;
    }

    $dataKelas = $result->fetch_assoc();
    $status_kelas = $dataKelas['status'];
    $stmt->close();

    // ================= RULE BISNIS
    if ($status_kelas == 0 && $status == 1) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Kelas nonaktif, ruangan tidak bisa diaktifkan.'
        ]);
        exit;
    }

    // ================= CEK DUPLIKAT
    $stmt = $Conn->prepare("
        SELECT id_ruang_rawat 
        FROM rr_ruang_rawat 
        WHERE ruang_rawat = ? 
        AND id_kelas_rawat = ? 
        AND id_ruang_rawat != ?
    ");
    $stmt->bind_param("sii", $ruang_rawat, $id_kelas_rawat, $id_ruang_rawat);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Nama ruangan sudah digunakan.'
        ]);
        exit;
    }
    $stmt->close();

    // ================= TRANSACTION
    $updatetime = date('Y-m-d H:i:s');
    $Conn->begin_transaction();

    try {

        // ================= UPDATE RUANGAN
        $stmt = $Conn->prepare("
            UPDATE rr_ruang_rawat SET
                ruang_rawat = ?,
                status = ?,
                updatetime = ?
            WHERE id_ruang_rawat = ?
        ");
        $stmt->bind_param("sisi", $ruang_rawat, $status, $updatetime, $id_ruang_rawat);
        $stmt->execute();
        $stmt->close();

        // ================= CASCADE (HANYA JIKA STATUS BERUBAH)
        if ($status_lama != $status) {

            // AKTIF → NONAKTIF
            if ($status == 0) {
                $stmt = $Conn->prepare("
                    UPDATE rr_tempat_tidur 
                    SET status = 0, updatetime = ?
                    WHERE id_ruang_rawat = ?
                ");
                $stmt->bind_param("si", $updatetime, $id_ruang_rawat);
                $stmt->execute();
                $stmt->close();
            }

            // NONAKTIF → AKTIF
            if ($status == 1) {
                $stmt = $Conn->prepare("
                    UPDATE rr_tempat_tidur 
                    SET status = 1, updatetime = ?
                    WHERE id_ruang_rawat = ?
                ");
                $stmt->bind_param("si", $updatetime, $id_ruang_rawat);
                $stmt->execute();
                $stmt->close();
            }
        }

        // ================= COMMIT
        $Conn->commit();

        echo json_encode([
            'status'=>'success',
            'message'=>'Data ruangan berhasil diperbarui.',
            'id_kelas_rawat'=>$id_kelas_rawat
        ]);

    } catch (Exception $e) {

        $Conn->rollback();

        echo json_encode([
            'status'=>'error',
            'message'=>'Terjadi kesalahan: '.$e->getMessage()
        ]);
    }
?>
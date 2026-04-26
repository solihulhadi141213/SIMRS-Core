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
    $id_kelas_rawat = !empty($_POST['id_kelas_rawat']) 
        ? validateAndSanitizeInput($_POST['id_kelas_rawat']) : '';

    $kode_kelas = !empty($_POST['kode_kelas']) 
        ? strtoupper(trim(validateAndSanitizeInput($_POST['kode_kelas']))) : '';

    $kelas = !empty($_POST['kelas']) 
        ? strtoupper(trim(validateAndSanitizeInput($_POST['kelas']))) : '';

    $status = !empty($_POST['status']) ? 1 : 0;

    // ================= VALIDASI
    if (empty($id_kelas_rawat)) {
        echo json_encode(['status'=>'error','message'=>'ID kelas tidak valid']); exit;
    }
    if (empty($kode_kelas)) {
        echo json_encode(['status'=>'error','message'=>'Kode kelas tidak boleh kosong']); exit;
    }
    if (empty($kelas)) {
        echo json_encode(['status'=>'error','message'=>'Nama kelas tidak boleh kosong']); exit;
    }

    // ================= CEK DATA + AMBIL STATUS LAMA
    $stmt = $Conn->prepare("
        SELECT status 
        FROM rr_kelas_rawat 
        WHERE id_kelas_rawat=?
    ");
    $stmt->bind_param("i",$id_kelas_rawat);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        echo json_encode(['status'=>'error','message'=>'Data tidak ditemukan']); exit;
    }

    $data = $result->fetch_assoc();
    $status_lama = $data['status'];
    $stmt->close();

    // ================= CEK DUPLIKAT
    $stmt = $Conn->prepare("
        SELECT id_kelas_rawat 
        FROM rr_kelas_rawat 
        WHERE kode_kelas=? AND kelas=? AND id_kelas_rawat!=?
    ");
    $stmt->bind_param("ssi",$kode_kelas,$kelas,$id_kelas_rawat);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        echo json_encode(['status'=>'error','message'=>'Data sudah digunakan']); exit;
    }
    $stmt->close();

    // ================= TRANSACTION
    $updatetime = date('Y-m-d H:i:s');
    $Conn->begin_transaction();

    try {

        // ================= UPDATE KELAS
        $stmt = $Conn->prepare("
            UPDATE rr_kelas_rawat 
            SET kode_kelas=?, kelas=?, status=?, updatetime=? 
            WHERE id_kelas_rawat=?
        ");
        $stmt->bind_param("ssisi",$kode_kelas,$kelas,$status,$updatetime,$id_kelas_rawat);
        $stmt->execute();
        $stmt->close();

        // ================= LOGIKA PERUBAHAN STATUS
        if ($status_lama != $status) {

            // ================= DARI AKTIF → NON AKTIF
            if ($status == 0) {

                // Nonaktifkan ruangan
                $stmt = $Conn->prepare("
                    UPDATE rr_ruang_rawat 
                    SET status=0, updatetime=? 
                    WHERE id_kelas_rawat=?
                ");
                $stmt->bind_param("si",$updatetime,$id_kelas_rawat);
                $stmt->execute();
                $stmt->close();

                // Nonaktifkan tempat tidur
                $stmt = $Conn->prepare("
                    UPDATE rr_tempat_tidur 
                    SET status=0, updatetime=? 
                    WHERE id_kelas_rawat=?
                ");
                $stmt->bind_param("si",$updatetime,$id_kelas_rawat);
                $stmt->execute();
                $stmt->close();
            }

            // ================= DARI NON AKTIF → AKTIF
            if ($status == 1) {

                // Aktifkan ruangan
                $stmt = $Conn->prepare("
                    UPDATE rr_ruang_rawat 
                    SET status=1, updatetime=? 
                    WHERE id_kelas_rawat=?
                ");
                $stmt->bind_param("si",$updatetime,$id_kelas_rawat);
                $stmt->execute();
                $stmt->close();

                // Aktifkan tempat tidur
                $stmt = $Conn->prepare("
                    UPDATE rr_tempat_tidur 
                    SET status=1, updatetime=? 
                    WHERE id_kelas_rawat=?
                ");
                $stmt->bind_param("si",$updatetime,$id_kelas_rawat);
                $stmt->execute();
                $stmt->close();
            }
        }

        // ================= COMMIT
        $Conn->commit();

        echo json_encode([
            'status'=>'success',
            'message'=>'Data berhasil diperbarui.'
        ]);

    } catch (Exception $e) {

        $Conn->rollback();

        echo json_encode([
            'status'=>'error',
            'message'=>'Terjadi kesalahan: '.$e->getMessage()
        ]);
    }
?>
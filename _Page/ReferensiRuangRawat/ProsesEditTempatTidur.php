<?php
    // ================= ZONA WAKTU
    date_default_timezone_set('Asia/Jakarta');

    // ================= KONEKSI & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ================= HEADER JSON
    header('Content-Type: application/json');

    // ================= VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Session habis, silahkan login ulang.'
        ]);
        exit;
    }

    // ================= VALIDASI METHOD
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode tidak valid.'
        ]);
        exit;
    }

    // ================= AMBIL & SANITASI DATA
    $id     = !empty($_POST['id_tempat_tidur']) 
        ? validateAndSanitizeInput($_POST['id_tempat_tidur']) 
        : '';

    $ruang  = !empty($_POST['id_ruang_rawat']) 
        ? validateAndSanitizeInput($_POST['id_ruang_rawat']) 
        : '';

    $kelas  = !empty($_POST['id_kelas_rawat']) 
        ? validateAndSanitizeInput($_POST['id_kelas_rawat']) 
        : '';

    $nama   = !empty($_POST['tempat_tidur']) 
        ? trim(validateAndSanitizeInput($_POST['tempat_tidur'])) 
        : '';

    $status = !empty($_POST['status']) ? 1 : 0;

    $kategori = !empty($_POST['kategori_tempat_tidur']) 
        ? $_POST['kategori_tempat_tidur'] 
        : '';

    // Rapihkan nama
    $nama = strtoupper($nama);

    // ================= VALIDASI INPUT
    if (empty($id) || empty($ruang) || empty($kelas)) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Data tidak lengkap.'
        ]);
        exit;
    }

    if (empty($nama)) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Nama tempat tidur tidak boleh kosong.'
        ]);
        exit;
    }

    if (empty($kategori)) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Kategori wajib dipilih.'
        ]);
        exit;
    }

    // ================= CEK DATA RUANGAN (UNTUK VALIDASI STATUS)
    $cekRuang = $Conn->prepare("
        SELECT status 
        FROM rr_ruang_rawat 
        WHERE id_ruang_rawat = ?
    ");
    $cekRuang->bind_param("i", $ruang);
    $cekRuang->execute();
    $resultRuang = $cekRuang->get_result();

    if ($resultRuang->num_rows == 0) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Ruangan tidak ditemukan.'
        ]);
        exit;
    }

    $dataRuang = $resultRuang->fetch_assoc();
    $status_ruangan = $dataRuang['status'];
    $cekRuang->close();

    // ================= VALIDASI KHUSUS
    // Jika ruangan NON AKTIF maka tempat tidur tidak boleh aktif
    if ($status_ruangan == 0 && $status == 1) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Ruangan non aktif, tempat tidur tidak bisa diaktifkan.'
        ]);
        exit;
    }

    // ================= SET KATEGORI
    $pria = 0; 
    $wanita = 0; 
    $bebas = 0;

    if ($kategori == 'pria')   $pria = 1;
    if ($kategori == 'wanita') $wanita = 1;
    if ($kategori == 'bebas')  $bebas = 1;

    // ================= CEK DUPLIKAT
    $cek = $Conn->prepare("
        SELECT id_tempat_tidur 
        FROM rr_tempat_tidur 
        WHERE tempat_tidur = ? 
        AND id_ruang_rawat = ? 
        AND id_tempat_tidur != ?
    ");
    $cek->bind_param("sii", $nama, $ruang, $id);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Nama tempat tidur sudah digunakan.'
        ]);
        exit;
    }
    $cek->close();

    // ================= UPDATE DATA
    $updatetime = date('Y-m-d H:i:s');

    try {

        $stmt = $Conn->prepare("
            UPDATE rr_tempat_tidur SET
                tempat_tidur = ?,
                pria = ?,
                wanita = ?,
                bebas = ?,
                status = ?,
                updatetime = ?
            WHERE id_tempat_tidur = ?
        ");

        $stmt->bind_param(
            "siiiisi",
            $nama,
            $pria,
            $wanita,
            $bebas,
            $status,
            $updatetime,
            $id
        );

        if ($stmt->execute()) {

            echo json_encode([
                'status'          => 'success',
                'message'         => 'Data tempat tidur berhasil diperbarui.',
                'id_ruang_rawat'  => $ruang,
                'id_kelas_rawat'  => $kelas
            ]);

        } else {

            echo json_encode([
                'status'=>'error',
                'message'=>'Gagal update data.'
            ]);
        }

        $stmt->close();

    } catch (Exception $e) {

        echo json_encode([
            'status'=>'error',
            'message'=>'Terjadi kesalahan: '.$e->getMessage()
        ]);
    }
?>
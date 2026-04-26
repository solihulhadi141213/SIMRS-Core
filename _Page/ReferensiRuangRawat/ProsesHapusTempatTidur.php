<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Header JSON
    header('Content-Type: application/json');

    // ================= VALIDASI SESSION =================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Session login tidak valid, silahkan login ulang.'
        ]);
        exit;
    }

    // ================= VALIDASI METHOD =================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // ================= AMBIL DATA =================
    $id_tempat_tidur = !empty($_POST['id_tempat_tidur']) 
        ? validateAndSanitizeInput($_POST['id_tempat_tidur']) 
        : '';

    // ================= VALIDASI INPUT =================
    if (empty($id_tempat_tidur)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID tempat tidur tidak valid.'
        ]);
        exit;
    }

    // ================= CEK DATA =================
    $stmt = $Conn->prepare("
        SELECT id_kelas_rawat, id_ruang_rawat 
        FROM rr_tempat_tidur 
        WHERE id_tempat_tidur = ?
    ");
    $stmt->bind_param("i", $id_tempat_tidur);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Data tempat tidur tidak ditemukan.'
        ]);
        exit;
    }

    $data = $result->fetch_assoc();
    $id_kelas_rawat = $data['id_kelas_rawat'];
    $id_ruang_rawat = $data['id_ruang_rawat'];
    $stmt->close();

    // ================= OPTIONAL: CEK RELASI (REKOMENDASI) =================
    // Jika nanti ada tabel pasien/rawat inap, cek disini
    /*
    $cekRelasi = $Conn->prepare("SELECT id FROM pasien_rawat WHERE id_tempat_tidur=? AND status='aktif'");
    $cekRelasi->bind_param("i", $id_tempat_tidur);
    $cekRelasi->execute();
    $cekRelasi->store_result();

    if ($cekRelasi->num_rows > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Tempat tidur sedang digunakan, tidak bisa dihapus.'
        ]);
        exit;
    }
    $cekRelasi->close();
    */

    // ================= PROSES DELETE =================
    try {

        $delete = $Conn->prepare("
            DELETE FROM rr_tempat_tidur 
            WHERE id_tempat_tidur = ?
        ");
        $delete->bind_param("i", $id_tempat_tidur);

        if ($delete->execute()) {

            echo json_encode([
                'status'           => 'success',
                'message'          => 'Data berhasil dihapus.',
                'id_ruang_rawat'   => $id_ruang_rawat,
                'id_kelas_rawat'   => $id_kelas_rawat
            ]);

        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Gagal menghapus data.'
            ]);
        }

        $delete->close();

    } catch (Exception $e) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>
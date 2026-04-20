<?php
    header('Content-Type: application/json');

    // Timezone
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi & Session
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // =========================
    // VALIDASI SESSION
    // =========================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses berakhir"
        ]);
        exit;
    }

    // =========================
    // AMBIL INPUT
    // =========================
    $id_akses_laporan = $_POST['id_akses_laporan'] ?? '';

    if (empty($id_akses_laporan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID tidak boleh kosong"
        ]);
        exit;
    }

    // =========================
    // CEK DATA 
    // =========================
    $stmt = $Conn->prepare("SELECT * FROM akses_laporan WHERE id_akses_laporan = ?");
    $stmt->bind_param("i", $id_akses_laporan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if (!$data) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data tidak ditemukan"
        ]);
        exit;
    }


    // =========================
    // HAPUS DATA
    // =========================
    $stmt_delete = $Conn->prepare("DELETE FROM akses_laporan WHERE id_akses_laporan = ?");
    $stmt_delete->bind_param("i", $id_akses_laporan);

    if ($stmt_delete->execute()) {

        echo json_encode([
            "status"  => "success",
            "message" => "Data berhasil dihapus"
        ]);

    } else {

        echo json_encode([
            "status"  => "error",
            "message" => "Gagal menghapus data"
        ]);
    }

    $stmt_delete->close();
?>
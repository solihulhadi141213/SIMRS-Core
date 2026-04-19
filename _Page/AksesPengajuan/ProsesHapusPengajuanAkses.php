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
    $id_akses_pengajuan = $_POST['id_akses_pengajuan'] ?? '';

    if (empty($id_akses_pengajuan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID tidak boleh kosong"
        ]);
        exit;
    }

    // =========================
    // CEK DATA + AMBIL FOTO
    // =========================
    $stmt = $Conn->prepare("SELECT foto FROM akses_pengajuan WHERE id_akses_pengajuan = ?");
    $stmt->bind_param("i", $id_akses_pengajuan);
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

    $foto = $data['foto'] ?? '';

    // =========================
    // HAPUS DATA
    // =========================
    $stmt_delete = $Conn->prepare("DELETE FROM akses_pengajuan WHERE id_akses_pengajuan = ?");
    $stmt_delete->bind_param("i", $id_akses_pengajuan);

    if ($stmt_delete->execute()) {

        // =========================
        // HAPUS FILE FOTO
        // =========================
        if (!empty($foto)) {

            $path = "../../assets/images/PengajuanAkses/" . $foto;

            // Hindari hapus file default
            if (file_exists($path) && is_file($path)) {
                unlink($path);
            }
        }

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
<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

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
    // INPUT
    // =========================
    $id_akses_pengajuan = $_POST['id_akses_pengajuan'] ?? '';
    $id_akses           = $_POST['id_akses'] ?? '';

    // =========================
    // VALIDASI INPUT
    // =========================
    if (empty($id_akses_pengajuan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID Pengajuan tidak valid"
        ]);
        exit;
    }

    if (empty($id_akses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Silahkan pilih akun pengguna"
        ]);
        exit;
    }

    // =========================
    // CEK DATA PENGAJUAN
    // =========================
    $stmt = $Conn->prepare("SELECT status FROM akses_pengajuan WHERE id_akses_pengajuan = ?");
    $stmt->bind_param("i", $id_akses_pengajuan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_pengajuan = $result->fetch_assoc();
    $stmt->close();

    if (!$data_pengajuan) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data pengajuan tidak ditemukan"
        ]);
        exit;
    }

    // =========================
    // CEK DATA AKSES
    // =========================
    $stmt = $Conn->prepare("SELECT id_akses FROM akses WHERE id_akses = ?");
    $stmt->bind_param("i", $id_akses);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_akses = $result->fetch_assoc();
    $stmt->close();

    if (!$data_akses) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data akun tidak ditemukan"
        ]);
        exit;
    }

    // =========================
    // UPDATE (HUBUNGKAN)
    // =========================
    $stmt = $Conn->prepare("UPDATE akses SET id_akses_pengajuan = ? WHERE id_akses = ?");
    $stmt->bind_param("ii", $id_akses_pengajuan, $id_akses);

    if ($stmt->execute()) {

        echo json_encode([
            "status"  => "success",
            "message" => "Akun berhasil dihubungkan"
        ]);

    } else {

        echo json_encode([
            "status"  => "error",
            "message" => "Gagal menghubungkan akun"
        ]);
    }

    $stmt->close();
?>
<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // ===============================
    // VALIDASI SESSION
    // ===============================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi berakhir, silakan login ulang"
        ]);
        exit;
    }

    // ===============================
    // INPUT
    // ===============================
    $id_akses_laporan = $_POST['id_akses_laporan'] ?? '';

    // ===============================
    // VALIDASI INPUT
    // ===============================
    if (empty($id_akses_laporan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID Laporan tidak boleh kosong"
        ]);
        exit;
    }

    // ===============================
    // CEK DATA
    // ===============================
    $stmt = $Conn->prepare("SELECT status FROM akses_laporan WHERE id_akses_laporan = ?");
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

    // ===============================
    // VALIDASI STATUS
    // ===============================
    $status_sekarang = $data['status'];

    if ($status_sekarang == 'Dibaca') {
        echo json_encode([
            "status"  => "error",
            "message" => "Laporan sudah ditandai sebagai Dibaca"
        ]);
        exit;
    }

    if ($status_sekarang == 'Selesai') {
        echo json_encode([
            "status"  => "error",
            "message" => "Laporan sudah selesai, tidak bisa diubah"
        ]);
        exit;
    }

    // ===============================
    // UPDATE STATUS
    // ===============================
    $status_baru = "Dibaca";

    $stmt_update = $Conn->prepare("
        UPDATE akses_laporan 
        SET status = ?, response = IFNULL(response, '')
        WHERE id_akses_laporan = ?
    ");

    $stmt_update->bind_param("si", $status_baru, $id_akses_laporan);

    if ($stmt_update->execute()) {

        echo json_encode([
            "status"  => "success",
            "message" => "Status berhasil diperbarui"
        ]);

    } else {

        echo json_encode([
            "status"  => "error",
            "message" => "Gagal memperbarui data"
        ]);
    }

    $stmt_update->close();
    $Conn->close();
?>
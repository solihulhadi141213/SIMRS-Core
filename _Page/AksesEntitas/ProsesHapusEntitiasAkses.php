<?php
    // Header JSON
    header('Content-Type: application/json');

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // =====================================
    // VALIDASI SESSION
    // =====================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI METHOD
    // =====================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI ID
    // =====================================
    if (empty($_POST['id_akses_entitas'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID entitas akses tidak boleh kosong.'
        ]);
        exit;
    }

    // Sanitasi ID
    $id_akses_entitas = (int) $_POST['id_akses_entitas'];

    if ($id_akses_entitas <= 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Entitas Akses tidak valid.'
        ]);
        exit;
    }

    // =====================================
    // CEK DATA ADA ATAU TIDAK
    // =====================================
    $check_sql = "SELECT id_akses_entitas FROM akses_entitas WHERE id_akses_entitas = ?";
    $check_stmt = $Conn->prepare($check_sql);

    if (!$check_stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal mempersiapkan query validasi.'
        ]);
        exit;
    }

    $check_stmt->bind_param("i", $id_akses_entitas);
    $check_stmt->execute();

    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Data entitas akses tidak ditemukan.'
        ]);
        exit;
    }

    $check_stmt->close();

    // =====================================
    // PROSES HAPUS
    // =====================================
    $delete_sql = "DELETE FROM akses_entitas WHERE id_akses_entitas = ?";
    $delete_stmt = $Conn->prepare($delete_sql);

    if (!$delete_stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal mempersiapkan query hapus.'
        ]);
        exit;
    }

    $delete_stmt->bind_param("i", $id_akses_entitas);

    if ($delete_stmt->execute()) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Data entitas akses berhasil dihapus.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menghapus data.'
        ]);
    }

    $delete_stmt->close();
?>
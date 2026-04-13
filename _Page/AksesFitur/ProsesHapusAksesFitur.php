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
    if (empty($_POST['id_akses_fitur'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID fitur tidak boleh kosong.'
        ]);
        exit;
    }

    // Sanitasi ID
    $id_akses_fitur = (int) $_POST['id_akses_fitur'];

    if ($id_akses_fitur <= 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID fitur tidak valid.'
        ]);
        exit;
    }

    // =====================================
    // CEK DATA ADA ATAU TIDAK
    // =====================================
    $check_sql = "SELECT id_akses_fitur, nama_fitur 
                  FROM akses_fitur 
                  WHERE id_akses_fitur = ?";
    $check_stmt = $Conn->prepare($check_sql);

    if (!$check_stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal mempersiapkan query validasi.'
        ]);
        exit;
    }

    $check_stmt->bind_param("i", $id_akses_fitur);
    $check_stmt->execute();

    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Data fitur tidak ditemukan.'
        ]);
        exit;
    }

    $check_stmt->close();

    // =====================================
    // PROSES HAPUS
    // =====================================
    $delete_sql = "DELETE FROM akses_fitur WHERE id_akses_fitur = ?";
    $delete_stmt = $Conn->prepare($delete_sql);

    if (!$delete_stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal mempersiapkan query hapus.'
        ]);
        exit;
    }

    $delete_stmt->bind_param("i", $id_akses_fitur);

    if ($delete_stmt->execute()) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Data fitur berhasil dihapus.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menghapus data fitur.'
        ]);
    }

    $delete_stmt->close();
?>
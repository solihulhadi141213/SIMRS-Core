<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

    // =========================================================
    // TIMEZONE
    // =========================================================
    date_default_timezone_set('Asia/Jakarta');

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir! Silahkan login ulang.'
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI METHOD
    // =========================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid!'
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI ID TINDAKAN
    // =========================================================
    if (empty($_POST['id_tindakan'])) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'ID tindakan tidak boleh kosong!'
        ]);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_tindakan = validateAndSanitizeInput($_POST['id_tindakan']);

    // =========================================================
    // VALIDASI DATA TINDAKAN
    // =========================================================
    $stmt = $Conn->prepare("
        SELECT 
            id_tindakan,
            id_kunjungan,
            id_procedure
        FROM tindakan 
        WHERE id_tindakan = ?
        LIMIT 1
    ");

    // VALIDASI PREPARE
    if (!$stmt) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan pada prepare statement!'
        ]);
        exit;
    }

    // BIND
    $stmt->bind_param("i", $id_tindakan);

    // EXECUTE
    if (!$stmt->execute()) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan pada saat membuka data tindakan!'
        ]);
        exit;
    }

    // RESULT
    $result = $stmt->get_result();

    // VALIDASI DATA
    if ($result->num_rows == 0) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Data tindakan tidak ditemukan!'
        ]);
        exit;
    }

    // FETCH DATA
    $data = $result->fetch_assoc();

    // TUTUP STATEMENT
    $stmt->close();

    // =========================================================
    // MAPPING DATA
    // =========================================================
    $id_kunjungan = $data['id_kunjungan'];
    $id_procedure = $data['id_procedure'];

    // =========================================================
    // MULAI TRANSACTION
    // =========================================================
    mysqli_begin_transaction($Conn);

    try {

        // =====================================================
        // HAPUS DATA PERFORMER
        // =====================================================
        $stmt_performer = $Conn->prepare("
            DELETE FROM tindakan_performer 
            WHERE id_tindakan = ?
        ");

        if (!$stmt_performer) {
            throw new Exception('Gagal prepare hapus performer.');
        }

        $stmt_performer->bind_param("i", $id_tindakan);

        if (!$stmt_performer->execute()) {
            throw new Exception('Gagal menghapus data performer.');
        }

        $stmt_performer->close();

        // =====================================================
        // HAPUS DATA TINDAKAN
        // =====================================================
        $stmt_tindakan = $Conn->prepare("
            DELETE FROM tindakan 
            WHERE id_tindakan = ?
        ");

        if (!$stmt_tindakan) {
            throw new Exception('Gagal prepare hapus tindakan.');
        }

        $stmt_tindakan->bind_param("i", $id_tindakan);

        if (!$stmt_tindakan->execute()) {
            throw new Exception('Gagal menghapus data tindakan.');
        }

        // VALIDASI DELETE
        if ($stmt_tindakan->affected_rows == 0) {
            throw new Exception('Data tindakan gagal dihapus.');
        }

        $stmt_tindakan->close();

        // =====================================================
        // COMMIT TRANSACTION
        // =====================================================
        mysqli_commit($Conn);

        // =====================================================
        // RESPONSE SUCCESS
        // =====================================================
        echo json_encode([
            'status'        => 'success',
            'message'       => 'Data tindakan berhasil dihapus.',
            'id_tindakan'   => $id_tindakan,
            'id_kunjungan'  => $id_kunjungan,
            'id_procedure'  => $id_procedure
        ]);
        exit;

    } catch (Exception $e) {

        // =====================================================
        // ROLLBACK
        // =====================================================
        mysqli_rollback($Conn);

        // =====================================================
        // RESPONSE ERROR
        // =====================================================
        echo json_encode([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>
<?php
    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

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
    // VALIDASI ID GENERAL CONSENT
    // =========================================================
    if (empty($_POST['id_general_consent'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID General Consent tidak boleh kosong!'
        ]);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_general_consent = validateAndSanitizeInput($_POST['id_general_consent']);

    // =========================================================
    // CEK DATA GENERAL CONSENT
    // =========================================================
    $queryCheck = "
        SELECT 
            id_general_consent
        FROM general_consent
        WHERE id_general_consent = ?
        LIMIT 1
    ";

    $stmtCheck = $Conn->prepare($queryCheck);

    if (!$stmtCheck) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal prepare query pengecekan data.'
        ]);
        exit;
    }

    $stmtCheck->bind_param("i", $id_general_consent);
    $stmtCheck->execute();

    $resultCheck = $stmtCheck->get_result();

    // =========================================================
    // VALIDASI DATA
    // =========================================================
    if ($resultCheck->num_rows == 0) {

        $stmtCheck->close();

        echo json_encode([
            'status'  => 'error',
            'message' => 'Data General Consent tidak ditemukan.'
        ]);
        exit;
    }

    $stmtCheck->close();

    // =========================================================
    // HAPUS DATA
    // =========================================================
    $queryDelete = "
        DELETE FROM general_consent
        WHERE id_general_consent = ?
    ";

    $stmtDelete = $Conn->prepare($queryDelete);

    if (!$stmtDelete) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal prepare query hapus data.'
        ]);
        exit;
    }

    $stmtDelete->bind_param("i", $id_general_consent);

    // =========================================================
    // EKSEKUSI DELETE
    // =========================================================
    if ($stmtDelete->execute()) {

        $stmtDelete->close();

        echo json_encode([
            'status'  => 'success',
            'message' => 'General Consent berhasil dihapus.'
        ]);
        exit;

    } else {

        $stmtDelete->close();

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan saat menghapus General Consent.'
        ]);
        exit;
    }
?>
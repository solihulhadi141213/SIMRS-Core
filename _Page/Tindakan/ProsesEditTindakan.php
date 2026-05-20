<?php
    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

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
    $id_tindakan            = validateAndSanitizeInput($_POST['id_tindakan']);

    $id_tindakan_referensi  = validateAndSanitizeInput($_POST['id_tindakan_referensi'] ?? '');

    $date_start             = validateAndSanitizeInput($_POST['date_start'] ?? '');
    $time_start             = validateAndSanitizeInput($_POST['time_start'] ?? '');

    $date_end               = validateAndSanitizeInput($_POST['date_end'] ?? '');
    $time_end               = validateAndSanitizeInput($_POST['time_end'] ?? '');

    $reson_reference        = validateAndSanitizeInput($_POST['reson_reference'] ?? '');
    $reson_code             = validateAndSanitizeInput($_POST['reson_code'] ?? '');
    $reson_display          = validateAndSanitizeInput($_POST['reson_display'] ?? '');

    $post_tindakan          = validateAndSanitizeInput($_POST['post_tindakan'] ?? '');

    // =========================================================
    // VALIDASI
    // =========================================================
    if (empty($id_tindakan_referensi)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Referensi tindakan tidak boleh kosong!'
        ]);
        exit;
    }

    if (empty($date_start) || empty($time_start)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Waktu mulai tindakan tidak boleh kosong!'
        ]);
        exit;
    }

    if (empty($date_end) || empty($time_end)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Waktu selesai tindakan tidak boleh kosong!'
        ]);
        exit;
    }

    // =========================================================
    // FORMAT DATETIME
    // =========================================================
    $datetime_start = $date_start . ' ' . $time_start . ':00';
    $datetime_end   = $date_end . ' ' . $time_end . ':00';

    // =========================================================
    // VALIDASI RENTANG WAKTU
    // =========================================================
    if (strtotime($datetime_end) < strtotime($datetime_start)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Waktu selesai tidak boleh lebih kecil dari waktu mulai!'
        ]);
        exit;
    }

    // =========================================================
    // CEK DATA TINDAKAN
    // =========================================================
    $Qry = $Conn->prepare("
        SELECT 
            id_tindakan,
            id_kunjungan
        FROM tindakan
        WHERE id_tindakan = ?
    ");

    $Qry->bind_param("i", $id_tindakan);
    $Qry->execute();

    $Result = $Qry->get_result();
    $Data   = $Result->fetch_assoc();

    if (empty($Data)) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Data tindakan tidak ditemukan!'
        ]);
        exit;
    }

    // =========================================================
    // ID KUNJUNGAN
    // =========================================================
    $id_kunjungan = $Data['id_kunjungan'];

    // =========================================================
    // UPDATE DATA
    // =========================================================
    $Update = $Conn->prepare("
        UPDATE tindakan 
        SET
            id_tindakan_referensi = ?,
            datetime_start        = ?,
            datetime_end          = ?,
            reson_reference       = ?,
            reson_code            = ?,
            reson_display         = ?,
            post_tindakan         = ?,
            datetime_update       = NOW()
        WHERE id_tindakan = ?
    ");

    if (!$Update) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Prepare statement gagal! ' . $Conn->error
        ]);
        exit;
    }

    $Update->bind_param(
        "issssssi",
        $id_tindakan_referensi,
        $datetime_start,
        $datetime_end,
        $reson_reference,
        $reson_code,
        $reson_display,
        $post_tindakan,
        $id_tindakan
    );

    // =========================================================
    // EKSEKUSI UPDATE
    // =========================================================
    if ($Update->execute()) {

        echo json_encode([
            'status'       => 'success',
            'message'      => 'Edit tindakan berhasil!',
            'id_kunjungan' => $id_kunjungan
        ]);

    } else {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal update tindakan! ' . $Update->error
        ]);
    }

    // =========================================================
    // CLOSE
    // =========================================================
    $Update->close();
    $Qry->close();
    $Conn->close();
?>
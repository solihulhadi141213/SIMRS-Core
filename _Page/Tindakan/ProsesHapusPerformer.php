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
    // CONNECTION
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
            'message' => 'Sesi akses sudah berakhir, silahkan login ulang!'
        ]);

        exit;
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    if (empty($_POST['id_tindakan_performer'])) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'ID performer tidak boleh kosong!'
        ]);

        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_tindakan_performer = validateAndSanitizeInput($_POST['id_tindakan_performer']);

    // =========================================================
    // CEK DATA PERFORMER
    // =========================================================
    $query_performer = mysqli_query($Conn, "
        SELECT *
        FROM tindakan_performer
        WHERE id_tindakan_performer='$id_tindakan_performer'
        LIMIT 1
    ");

    if (mysqli_num_rows($query_performer) == 0) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Data performer tidak ditemukan!'
        ]);

        exit;
    }

    $data_performer = mysqli_fetch_array($query_performer);

    $id_tindakan = $data_performer['id_tindakan'];

    // =========================================================
    // CEK DATA TINDAKAN
    // =========================================================
    $query_tindakan = mysqli_query($Conn, "
        SELECT *
        FROM tindakan
        WHERE id_tindakan='$id_tindakan'
        LIMIT 1
    ");

    if (mysqli_num_rows($query_tindakan) == 0) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Data tindakan tidak ditemukan!'
        ]);

        exit;
    }

    $data_tindakan = mysqli_fetch_array($query_tindakan);

    $id_kunjungan = $data_tindakan['id_kunjungan'];

    // =========================================================
    // HAPUS DATA
    // =========================================================
    $delete = mysqli_query($Conn, "
        DELETE FROM tindakan_performer
        WHERE id_tindakan_performer='$id_tindakan_performer'
    ");

    // =========================================================
    // RESPONSE
    // =========================================================
    if ($delete) {

        echo json_encode([
            'status'                => 'success',
            'message'               => 'Hapus performer berhasil',
            'id_tindakan'           => $id_tindakan,
            'id_kunjungan'          => $id_kunjungan,
            'id_tindakan_performer' => $id_tindakan_performer
        ]);

    } else {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan saat menghapus data!'
        ]);
    }
?>
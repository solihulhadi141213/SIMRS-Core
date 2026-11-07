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
    // Prepared Statement: ambil performer berdasarkan ID.
    $stmtPerformer = mysqli_prepare($Conn, "
        SELECT *
        FROM tindakan_performer
        WHERE id_tindakan_performer=?
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmtPerformer, "s", $id_tindakan_performer);
    mysqli_stmt_execute($stmtPerformer);
    $query_performer = mysqli_stmt_get_result($stmtPerformer);

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
    // Prepared Statement: ambil tindakan yang memiliki performer tersebut.
    $stmtTindakan = mysqli_prepare($Conn, "
        SELECT *
        FROM tindakan
        WHERE id_tindakan=?
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmtTindakan, "s", $id_tindakan);
    mysqli_stmt_execute($stmtTindakan);
    $query_tindakan = mysqli_stmt_get_result($stmtTindakan);

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
    // Prepared Statement: hapus performer berdasarkan ID.
    $stmtDelete = mysqli_prepare($Conn, "
        DELETE FROM tindakan_performer
        WHERE id_tindakan_performer=?
    ");
    mysqli_stmt_bind_param($stmtDelete, "s", $id_tindakan_performer);
    $delete = mysqli_stmt_execute($stmtDelete);

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
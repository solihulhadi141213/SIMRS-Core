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

    if (empty($_POST['performer_type'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Tipe performer tidak boleh kosong!'
        ]);
        exit;
    }

    if (empty($_POST['performer_nama'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama performer tidak boleh kosong!'
        ]);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_tindakan_performer = validateAndSanitizeInput($_POST['id_tindakan_performer']);

    $performer_type = validateAndSanitizeInput($_POST['performer_type']);

    $id_praktisi = !empty($_POST['id_praktisi']) 
        ? validateAndSanitizeInput($_POST['id_praktisi']) 
        : NULL;

    $performer_nama = validateAndSanitizeInput($_POST['performer_nama']);

    $performer_ihs = !empty($_POST['performer_ihs']) 
        ? validateAndSanitizeInput($_POST['performer_ihs']) 
        : NULL;

    $performer_nik = !empty($_POST['performer_nik']) 
        ? validateAndSanitizeInput($_POST['performer_nik']) 
        : NULL;

    $performer_notes = !empty($_POST['performer_notes']) 
        ? validateAndSanitizeInput($_POST['performer_notes']) 
        : NULL;

    // =========================================================
    // VALIDASI ENUM
    // =========================================================
    $allow_type = ['Utama', 'Pendamping'];

    if (!in_array($performer_type, $allow_type)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Tipe performer tidak valid!'
        ]);
        exit;
    }

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
    // VALIDASI DUPLIKAT PRAKTISI
    // =========================================================
    if (!empty($id_praktisi)) {

        // Prepared Statement: cegah penggunaan praktisi ganda.
        $stmtDuplikat = mysqli_prepare($Conn, "
            SELECT id_tindakan_performer
            FROM tindakan_performer
            WHERE 
                id_tindakan=?
                AND id_praktisi=?
                AND id_tindakan_performer != ?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtDuplikat, "sss", $id_tindakan, $id_praktisi, $id_tindakan_performer);
        mysqli_stmt_execute($stmtDuplikat);
        $query_duplikat = mysqli_stmt_get_result($stmtDuplikat);

        if (mysqli_num_rows($query_duplikat) > 0) {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Praktisi tersebut sudah digunakan pada tindakan ini!'
            ]);
            exit;
        }
    }

    // =========================================================
    // UPDATE DATA
    // =========================================================
    // Prepared Statement: update performer dengan nilai terikat.
    $stmtUpdate = mysqli_prepare($Conn, "
        UPDATE tindakan_performer SET
            id_praktisi       = ?,
            performer_type    = ?,
            performer_ihs     = ?,
            performer_nik     = ?,
            performer_nama    = ?,
            performer_notes   = ?
        WHERE id_tindakan_performer=?
    ");
    mysqli_stmt_bind_param($stmtUpdate, "sssssss", $id_praktisi, $performer_type, $performer_ihs, $performer_nik, $performer_nama, $performer_notes, $id_tindakan_performer);
    $update = mysqli_stmt_execute($stmtUpdate);

    // =========================================================
    // RESPONSE
    // =========================================================
    if ($update) {

        echo json_encode([
            'status'                => 'success',
            'message'               => 'Edit performer berhasil',
            'id_tindakan'           => $id_tindakan,
            'id_kunjungan'          => $id_kunjungan,
            'id_tindakan_performer' => $id_tindakan_performer
        ]);

    } else {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan saat update data!'
        ]);
    }
?>
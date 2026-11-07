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
    if (empty($_POST['id_tindakan'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID tindakan tidak boleh kosong!'
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
    $id_tindakan       = validateAndSanitizeInput($_POST['id_tindakan']);
    $performer_type    = validateAndSanitizeInput($_POST['performer_type']);

    $id_praktisi       = !empty($_POST['id_praktisi']) ? validateAndSanitizeInput($_POST['id_praktisi']) : NULL;

    $performer_ihs     = !empty($_POST['performer_ihs']) ? validateAndSanitizeInput($_POST['performer_ihs']) : NULL;

    $performer_nik     = !empty($_POST['performer_nik']) ? validateAndSanitizeInput($_POST['performer_nik']) : NULL;

    $performer_nama    = validateAndSanitizeInput($_POST['performer_nama']);

    $performer_notes   = !empty($_POST['performer_notes']) ? validateAndSanitizeInput($_POST['performer_notes']) : NULL;

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
    // CEK TINDAKAN
    // =========================================================
    // Prepared Statement: ambil tindakan berdasarkan ID.
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
    // CEK DUPLIKAT PERFORMER
    // =========================================================
    if (!empty($id_praktisi)) {

        // Prepared Statement: cegah penggunaan praktisi ganda.
        $stmtDuplikat = mysqli_prepare($Conn, "
            SELECT id_tindakan_performer
            FROM tindakan_performer
            WHERE 
                id_tindakan=?
                AND id_praktisi=?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtDuplikat, "ss", $id_tindakan, $id_praktisi);
        mysqli_stmt_execute($stmtDuplikat);
        $query_duplikat = mysqli_stmt_get_result($stmtDuplikat);

        if (mysqli_num_rows($query_duplikat) > 0) {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Performer tersebut sudah ditambahkan pada tindakan ini!'
            ]);
            exit;
        }
    }

    // =========================================================
    // INSERT DATA
    // =========================================================
    // Prepared Statement: tambah performer dengan nilai terikat.
    $stmtInsert = mysqli_prepare($Conn, "
        INSERT INTO tindakan_performer (
            id_tindakan,
            id_praktisi,
            performer_type,
            performer_ihs,
            performer_nik,
            performer_nama,
            performer_notes
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?
        )
    ");
    mysqli_stmt_bind_param($stmtInsert, "sssssss", $id_tindakan, $id_praktisi, $performer_type, $performer_ihs, $performer_nik, $performer_nama, $performer_notes);
    $insert = mysqli_stmt_execute($stmtInsert);

    // =========================================================
    // RESPONSE
    // =========================================================
    if ($insert) {

        echo json_encode([
            'status'        => 'success',
            'message'       => 'Tambah performer berhasil',
            'id_tindakan'   => $id_tindakan,
            'id_kunjungan'  => $id_kunjungan
        ]);

    } else {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan data!'
        ]);
    }
?>
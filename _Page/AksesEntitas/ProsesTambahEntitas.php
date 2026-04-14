<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // ==========================================
    // VALIDASI SESSION
    // ==========================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // ==========================================
    // VALIDASI METHOD
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // ==========================================
    // AMBIL DATA
    // ==========================================
    $akses     = isset($_POST['akses']) ? trim($_POST['akses']) : '';
    $deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
    $id_akses_fitur = isset($_POST['id_akses_fitur']) ? $_POST['id_akses_fitur'] : [];

    // ==========================================
    // VALIDASI INPUT
    // ==========================================
    if ($akses == '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Entitas Akses Tidak Boleh Kosong!'
        ]);
        exit;
    }

    if ($deskripsi == '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Deskripsi tidak boleh kosong.'
        ]);
        exit;
    }

    if (mb_strlen($akses) > 250) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama Entitas maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($deskripsi) > 500) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Deskripsi maksimal 500 karakter.'
        ]);
        exit;
    }

    // ==========================================
    // VALIDASI CHECKLIST FITUR
    // ==========================================
    if (empty($id_akses_fitur) || !is_array($id_akses_fitur)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Pilih minimal satu fitur akses.'
        ]);
        exit;
    }

    // ==========================================
    // VALIDASI DUPLIKAT
    // ==========================================
    $check_nama = mysqli_prepare(
        $Conn,
        "SELECT id_akses_entitas FROM akses_entitas WHERE akses = ?"
    );

    mysqli_stmt_bind_param($check_nama, "s", $akses);
    mysqli_stmt_execute($check_nama);
    $result_nama = mysqli_stmt_get_result($check_nama);

    if (mysqli_num_rows($result_nama) > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama entitas sudah digunakan.'
        ]);
        exit;
    }

    mysqli_stmt_close($check_nama);

    // ==========================================
    // TRANSACTION START
    // ==========================================
    mysqli_begin_transaction($Conn);

    try {

        // ==========================================
        // INSERT MASTER ENTITAS
        // ==========================================
        $insert = mysqli_prepare(
            $Conn,
            "INSERT INTO akses_entitas (akses, deskripsi) VALUES (?, ?)"
        );

        if (!$insert) {
            throw new Exception('Gagal prepare query akses_entitas.');
        }

        mysqli_stmt_bind_param($insert, "ss", $akses, $deskripsi);

        if (!mysqli_stmt_execute($insert)) {
            throw new Exception('Gagal menyimpan entitas.');
        }

        // ==========================================
        // AMBIL ID TERAKHIR
        // ==========================================
        $id_akses_entitas = mysqli_insert_id($Conn);

        mysqli_stmt_close($insert);

        // ==========================================
        // INSERT DETAIL AKSES FITUR
        // ==========================================
        $insert_detail = mysqli_prepare(
            $Conn,
            "INSERT INTO akses_entitas_acc 
            (id_akses_entitas, id_akses_fitur) 
            VALUES (?, ?)"
        );

        if (!$insert_detail) {
            throw new Exception('Gagal prepare query detail akses.');
        }

        foreach ($id_akses_fitur as $id_fitur) {

            // validasi numeric
            if (!is_numeric($id_fitur)) {
                throw new Exception('ID fitur tidak valid.');
            }

            $id_fitur = intval($id_fitur);

            mysqli_stmt_bind_param(
                $insert_detail,
                "ii",
                $id_akses_entitas,
                $id_fitur
            );

            if (!mysqli_stmt_execute($insert_detail)) {
                throw new Exception('Gagal menyimpan detail akses fitur.');
            }
        }

        mysqli_stmt_close($insert_detail);

        // ==========================================
        // COMMIT
        // ==========================================
        mysqli_commit($Conn);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Tambah Entitas Akses Berhasil.'
        ]);

    } catch (Exception $e) {

        // ==========================================
        // ROLLBACK JIKA GAGAL
        // ==========================================
        mysqli_rollback($Conn);

        echo json_encode([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
    }
?>
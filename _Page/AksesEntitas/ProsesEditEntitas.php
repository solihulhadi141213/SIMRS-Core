<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi berakhir'
        ]);
        exit;
    }

    // Ambil data
    $id_akses_entitas = isset($_POST['id_akses_entitas']) ? intval($_POST['id_akses_entitas']) : 0;
    $akses            = isset($_POST['akses']) ? trim($_POST['akses']) : '';
    $deskripsi        = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
    $id_akses_fitur   = isset($_POST['id_akses_fitur']) ? $_POST['id_akses_fitur'] : [];

    // Validasi
    if ($id_akses_entitas <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID entitas tidak valid'
        ]);
        exit;
    }

    if ($akses == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nama entitas wajib diisi'
        ]);
        exit;
    }

    if ($deskripsi == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Deskripsi wajib diisi'
        ]);
        exit;
    }

    if (empty($id_akses_fitur)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Pilih minimal satu fitur'
        ]);
        exit;
    }

    // Cek duplikat nama selain dirinya sendiri
    $check = mysqli_prepare(
        $Conn,
        "SELECT id_akses_entitas
        FROM akses_entitas
        WHERE akses = ?
        AND id_akses_entitas != ?"
    );

    mysqli_stmt_bind_param($check, "si", $akses, $id_akses_entitas);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nama entitas sudah digunakan'
        ]);
        exit;
    }

    // Transaction
    mysqli_begin_transaction($Conn);

    try {

        // Update master
        $update = mysqli_prepare(
            $Conn,
            "UPDATE akses_entitas
            SET akses = ?, deskripsi = ?
            WHERE id_akses_entitas = ?"
        );

        mysqli_stmt_bind_param(
            $update,
            "ssi",
            $akses,
            $deskripsi,
            $id_akses_entitas
        );

        if (!mysqli_stmt_execute($update)) {
            throw new Exception('Gagal update entitas');
        }

        // Hapus detail lama
        $delete = mysqli_prepare(
            $Conn,
            "DELETE FROM akses_entitas_acc
            WHERE id_akses_entitas = ?"
        );

        mysqli_stmt_bind_param($delete, "i", $id_akses_entitas);

        if (!mysqli_stmt_execute($delete)) {
            throw new Exception('Gagal hapus detail lama');
        }

        // Insert detail baru
        $insert = mysqli_prepare(
            $Conn,
            "INSERT INTO akses_entitas_acc
            (id_akses_entitas, id_akses_fitur)
            VALUES (?, ?)"
        );

        foreach ($id_akses_fitur as $id_fitur) {

            $id_fitur = intval($id_fitur);

            mysqli_stmt_bind_param(
                $insert,
                "ii",
                $id_akses_entitas,
                $id_fitur
            );

            if (!mysqli_stmt_execute($insert)) {
                throw new Exception('Gagal update detail fitur');
            }
        }

        mysqli_commit($Conn);

        echo json_encode([
            'status' => 'success',
            'message' => 'Update berhasil'
        ]);

    } catch (Exception $e) {

        mysqli_rollback($Conn);

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
?>
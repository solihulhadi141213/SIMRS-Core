<?php
    header('Content-Type: application/json');
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
            'status' => 'error',
            'message' => 'Sesi akses berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI METHOD
    // =====================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // =====================================
    // AMBIL DATA
    // =====================================
    $id_akses_fitur = isset($_POST['id_akses_fitur']) ? intval($_POST['id_akses_fitur']) : 0;
    $nama_fitur     = isset($_POST['nama_fitur']) ? trim($_POST['nama_fitur']) : '';
    $kategori       = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
    $kode           = isset($_POST['kode']) ? trim($_POST['kode']) : '';
    $keterangan     = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

    // =====================================
    // VALIDASI ID
    // =====================================
    if (empty($id_akses_fitur)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID fitur tidak boleh kosong.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI MANDATORY
    // =====================================
    if ($nama_fitur == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nama fitur belum diisi.'
        ]);
        exit;
    }

    if ($kategori == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kategori belum diisi.'
        ]);
        exit;
    }

    if ($kode == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kode akses belum diisi.'
        ]);
        exit;
    }

    if ($keterangan == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Keterangan belum diisi.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI PANJANG KARAKTER
    // =====================================
    if (mb_strlen($nama_fitur) > 250) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nama fitur maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($kategori) > 250) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kategori maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($kode) > 250) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kode maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($keterangan) > 500) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Keterangan maksimal 500 karakter.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI FORMAT KODE
    // =====================================
    if (!preg_match('/^[A-Za-z0-9]+$/', $kode)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kode hanya boleh huruf dan angka.'
        ]);
        exit;
    }

    // =====================================
    // AMBIL DATA LAMA
    // =====================================
    $stmt_old = $Conn->prepare("
        SELECT nama_fitur, kode 
        FROM akses_fitur 
        WHERE id_akses_fitur = ?
    ");
    $stmt_old->bind_param("i", $id_akses_fitur);
    $stmt_old->execute();
    $result_old = $stmt_old->get_result();

    if ($result_old->num_rows == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data fitur tidak ditemukan.'
        ]);
        exit;
    }

    $old = $result_old->fetch_assoc();
    $old_nama = $old['nama_fitur'];
    $old_kode = $old['kode'];

    $stmt_old->close();

    // =====================================
    // VALIDASI DUPLIKAT NAMA
    // JIKA ADA PERUBAHAN
    // =====================================
    if ($nama_fitur != $old_nama) {
        $stmt_check = $Conn->prepare("
            SELECT id_akses_fitur 
            FROM akses_fitur 
            WHERE nama_fitur = ?
            AND id_akses_fitur != ?
        ");
        $stmt_check->bind_param("si", $nama_fitur, $id_akses_fitur);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nama fitur sudah digunakan.'
            ]);
            exit;
        }

        $stmt_check->close();
    }

    // =====================================
    // VALIDASI DUPLIKAT KODE
    // JIKA ADA PERUBAHAN
    // =====================================
    if ($kode != $old_kode) {
        $stmt_check = $Conn->prepare("
            SELECT id_akses_fitur 
            FROM akses_fitur 
            WHERE kode = ?
            AND id_akses_fitur != ?
        ");
        $stmt_check->bind_param("si", $kode, $id_akses_fitur);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Kode akses sudah digunakan.'
            ]);
            exit;
        }

        $stmt_check->close();
    }

    // =====================================
    // UPDATE DATA
    // =====================================
    $stmt_update = $Conn->prepare("
        UPDATE akses_fitur 
        SET 
            nama_fitur = ?,
            kategori = ?,
            kode = ?,
            keterangan = ?
        WHERE id_akses_fitur = ?
    ");

    $stmt_update->bind_param(
        "ssssi",
        $nama_fitur,
        $kategori,
        $kode,
        $keterangan,
        $id_akses_fitur
    );

    if ($stmt_update->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memperbarui data.'
        ]);
    }

    $stmt_update->close();
?>
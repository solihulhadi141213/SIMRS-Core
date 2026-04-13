<?php
    // Header JSON
    header('Content-Type: application/json');

    // Timezone
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
    $nama_fitur = isset($_POST['nama_fitur']) ? trim($_POST['nama_fitur']) : '';
    $kategori   = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
    $kode       = isset($_POST['kode']) ? trim($_POST['kode']) : '';
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

    // ==========================================
    // VALIDASI MANDATORY SATU PERSATU
    // ==========================================
    if ($nama_fitur == '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama fitur belum diisi.'
        ]);
        exit;
    }

    if ($kategori == '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kategori belum diisi.'
        ]);
        exit;
    }

    if ($kode == '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kode akses belum diisi.'
        ]);
        exit;
    }

    if ($keterangan == '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Keterangan belum diisi.'
        ]);
        exit;
    }

    // ==========================================
    // VALIDASI PANJANG KARAKTER
    // ==========================================
    if (mb_strlen($nama_fitur) > 250) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama fitur maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($kategori) > 250) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kategori maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($kode) > 250) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kode akses maksimal 250 karakter.'
        ]);
        exit;
    }

    if (mb_strlen($keterangan) > 500) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Keterangan maksimal 500 karakter.'
        ]);
        exit;
    }

    // ==========================================
    // VALIDASI FORMAT KODE
    // HANYA HURUF DAN ANGKA
    // ==========================================
    if (!preg_match('/^[A-Za-z0-9]+$/', $kode)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kode akses hanya boleh huruf dan angka tanpa spasi.'
        ]);
        exit;
    }

    // ==========================================
    // VALIDASI DUPLIKAT NAMA FITUR
    // ==========================================
    $check_nama = mysqli_prepare(
        $Conn,
        "SELECT id_akses_fitur 
         FROM akses_fitur 
         WHERE nama_fitur = ?"
    );

    mysqli_stmt_bind_param($check_nama, "s", $nama_fitur);
    mysqli_stmt_execute($check_nama);
    $result_nama = mysqli_stmt_get_result($check_nama);

    if (mysqli_num_rows($result_nama) > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama fitur sudah digunakan.'
        ]);
        exit;
    }

    mysqli_stmt_close($check_nama);

    // ==========================================
    // VALIDASI DUPLIKAT KODE
    // ==========================================
    $check_kode = mysqli_prepare(
        $Conn,
        "SELECT id_akses_fitur 
         FROM akses_fitur 
         WHERE kode = ?"
    );

    mysqli_stmt_bind_param($check_kode, "s", $kode);
    mysqli_stmt_execute($check_kode);
    $result_kode = mysqli_stmt_get_result($check_kode);

    if (mysqli_num_rows($result_kode) > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kode akses sudah digunakan.'
        ]);
        exit;
    }

    mysqli_stmt_close($check_kode);

    // ==========================================
    // SIMPAN DATA
    // ==========================================
    $insert = mysqli_prepare(
        $Conn,
        "INSERT INTO akses_fitur (
            nama_fitur,
            kategori,
            kode,
            keterangan
        ) VALUES (?, ?, ?, ?)"
    );

    if (!$insert) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal prepare query simpan data.'
        ]);
        exit;
    }

    mysqli_stmt_bind_param(
        $insert,
        "ssss",
        $nama_fitur,
        $kategori,
        $kode,
        $keterangan
    );

    if (mysqli_stmt_execute($insert)) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Tambah fitur berhasil.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menyimpan data.'
        ]);
    }

    mysqli_stmt_close($insert);
?>
<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    function respond($status, $message){
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond('error', 'Metode tidak diizinkan.');
    }

    if (empty($_SESSION['code'])) {
        respond('error', 'Captcha expired.');
    }

    // Ambil & sanitasi
    $nama      = trim($_POST['nama'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $kontak    = trim($_POST['kontak'] ?? '');
    $nik       = trim($_POST['nik'] ?? '');
    $alamat    = trim($_POST['alamat'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $captcha   = trim($_POST['captcha'] ?? '');

    // Validasi
    if (!$nama || !$email || !$kontak || !$nik || !$alamat || !$deskripsi || !$captcha) {
        respond('error', 'Semua field wajib diisi.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond('error', 'Email tidak valid.');
    }

    if (!preg_match('/^[0-9]+$/', $kontak)) {
        respond('error', 'Kontak harus angka.');
    }

    if (!preg_match('/^[0-9]+$/', $nik)) {
        respond('error', 'NIK harus angka.');
    }

    if (strlen($alamat) > 200 || strlen($deskripsi) > 200) {
        respond('error', 'Maksimal 200 karakter.');
    }

    // Captcha
    if (md5($captcha) !== $_SESSION['code']) {
        respond('error', 'Captcha salah.');
    }

    // FILE VALIDATION
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
        respond('error', 'Upload foto gagal.');
    }

    $file = $_FILES['foto'];

    if ($file['size'] > 2000000) {
        respond('error', 'Maksimal 2MB.');
    }

    // Validasi extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg','jpeg','png','gif'];

    if (!in_array($ext, $allowed_ext)) {
        respond('error', 'Format file tidak valid.');
    }

    // Validasi MIME (lebih aman)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);

    $allowed_mime = ['image/jpeg','image/png','image/gif'];

    if (!in_array($mime, $allowed_mime)) {
        respond('error', 'File bukan gambar valid.');
    }

    // Rename file
    $NamaFileBaru = uniqid('foto_', true) . '.' . $ext;
    $path = "../../assets/images/PengajuanAkses/" . $NamaFileBaru;

    // Cek duplikat
    $stmt = $Conn->prepare("SELECT 1 FROM akses_pengajuan WHERE email=? OR nik=?");
    $stmt->bind_param('ss', $email, $nik);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        respond('error', 'Email/NIK sudah digunakan.');
    }

    // Upload
    if (!move_uploaded_file($file['tmp_name'], $path)) {
        respond('error', 'Upload gagal.');
    }

    // Insert
    $stmt = $Conn->prepare("INSERT INTO akses_pengajuan 
    (tanggal, nik, nama, kontak, email, alamat, deskripsi, foto, status) 
    VALUES (NOW(),?,?,?,?,?,?,?, 'Pending')");

    // ✅ jumlah harus 7
    $stmt->bind_param(
        'sssssss',
        $nik,
        $nama,
        $kontak,
        $email,
        $alamat,
        $deskripsi,
        $NamaFileBaru
    );

    if ($stmt->execute()) {
        respond('success', 'Berhasil dikirim.');
    }

    // Jika gagal, hapus file
    unlink($path);

    respond('error', 'Gagal menyimpan data.');
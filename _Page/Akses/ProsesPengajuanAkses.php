<?php
// Proses pengajuan akses via AJAX (JSON response)
session_start();
date_default_timezone_set('Asia/Jakarta');
header('Content-Type: application/json');

include "../../_Config/Connection.php";

$TanggalPengajuan = date('Y-m-d H:i:s');

function respond($status, $message)
{
    echo json_encode([
        'status'  => $status,
        'message' => $message
    ]);
    exit;
}

// Validasi Session
if (empty($_SESSION['code'])) {
    respond('error', 'Sesi berakhir, silakan reload captcha terlebih dulu.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', 'Metode tidak diizinkan.');
}

$errors = [];

// Validasi Input Form
if (empty($_POST['nama'])) {
    $errors[] = 'Nama tidak boleh kosong.';
} else {
    $nama = filter_var($_POST['nama'], FILTER_SANITIZE_STRING);
    if ($nama === '') {
        $errors[] = 'Karakter nama Anda tidak valid.';
    }
}

if (empty($_POST['email'])) {
    $errors[] = 'Email tidak boleh kosong.';
} else {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
}

if (empty($_POST['kontak'])) {
    $errors[] = 'Nomor kontak tidak boleh kosong.';
} elseif (!preg_match('/^[0-9]+$/', $_POST['kontak'])) {
    $errors[] = 'Kontak hanya boleh terdiri dari angka.';
} else {
    $kontak = $_POST['kontak'];
}

if (empty($_POST['nik'])) {
    $errors[] = 'NIK tidak boleh kosong.';
} elseif (!preg_match('/^[0-9]+$/', $_POST['nik'])) {
    $errors[] = 'NIK hanya boleh terdiri dari angka.';
} else {
    $nik = $_POST['nik'];
}

if (empty($_POST['alamat'])) {
    $errors[] = 'Alamat tidak boleh kosong.';
} else {
    $alamat = filter_var($_POST['alamat'], FILTER_SANITIZE_STRING);
    if ($alamat === '' || strlen($alamat) > 200) {
        $errors[] = 'Alamat maksimal 200 karakter.';
    }
}

if (empty($_POST['deskripsi'])) {
    $errors[] = 'Deskripsi tidak boleh kosong.';
} else {
    $deskripsi = filter_var($_POST['deskripsi'], FILTER_SANITIZE_STRING);
    if ($deskripsi === '' || strlen($deskripsi) > 200) {
        $errors[] = 'Deskripsi maksimal 200 karakter.';
    }
}

if (empty($_POST['captcha'])) {
    $errors[] = 'Kode captcha tidak boleh kosong.';
} elseif (md5($_POST['captcha']) !== $_SESSION['code']) {
    $errors[] = 'Kode captcha yang Anda masukkan tidak valid.';
}

// Validasi Foto
if (empty($_FILES['foto']['name'])) {
    $errors[] = 'Pas foto tidak boleh kosong.';
} else {
    $nama_gambar   = $_FILES['foto']['name'];
    $ukuran_gambar = $_FILES['foto']['size'];
    $tipe_gambar   = $_FILES['foto']['type'];
    $tmp_gambar    = $_FILES['foto']['tmp_name'];

    if ($ukuran_gambar > 2000000) {
        $errors[] = 'Ukuran file foto tidak boleh lebih dari 2 MB.';
    }

    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($tipe_gambar, $allowed_types, true)) {
        $errors[] = 'Tipe file foto tidak sesuai (hanya jpeg, jpg, png, gif).';
    }

    $ext          = pathinfo($nama_gambar, PATHINFO_EXTENSION);
    $NamaFileBaru = uniqid('', true) . '.' . $ext;
    $path         = \"../../assets/images/PengajuanAkses/\" . $NamaFileBaru;
}

if (!empty($errors)) {
    respond('error', implode(' | ', $errors));
}

// Validasi email dan NIK unik
$stmt = $Conn->prepare('SELECT 1 FROM akses_pengajuan WHERE email = ? OR nik = ?');
$stmt->bind_param('ss', $email, $nik);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    respond('error', 'Email atau NIK telah digunakan untuk pengajuan.');
}

if (!move_uploaded_file($tmp_gambar, $path)) {
    respond('error', 'Gagal mengupload file foto.');
}

$stmt = $Conn->prepare(\"INSERT INTO akses_pengajuan (
    tanggal, nik, nama, kontak, email, alamat, deskripsi, foto, status, keterangan
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', '')\");

if (!$stmt) {
    respond('error', 'Gagal menyiapkan query: ' . $Conn->error);
}

$stmt->bind_param(
    'ssssssss',
    $TanggalPengajuan,
    $nik,
    $nama,
    $kontak,
    $email,
    $alamat,
    $deskripsi,
    $NamaFileBaru
);

if ($stmt->execute()) {
    $_SESSION['NotifikasiSwal'] = 'Tambah Pengajuan Akses Berhasil';
    respond('success', 'Pengajuan akses berhasil dikirim.');
}

respond('error', 'Gagal menyimpan data pengajuan.');

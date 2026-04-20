<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
require_once __DIR__ . '/../../vendor/autoload.php';

// Validasi session
if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger">Sesi berakhir</div>';
    exit;
}

// Ambil ID
$id_akses_laporan = $_POST['id_akses_laporan'] ?? '';

if (empty($id_akses_laporan)) {
    echo '<div class="alert alert-danger text-center">ID Laporan Tidak Boleh Kosong!</div>';
    exit;
}

// Ambil data
$stmt = $Conn->prepare("
    SELECT a.*, b.nama 
    FROM akses_laporan a
    LEFT JOIN akses b ON a.id_akses = b.id_akses
    WHERE a.id_akses_laporan = ?
");
$stmt->bind_param("i", $id_akses_laporan);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    echo '<div class="alert alert-danger text-center">Data tidak ditemukan</div>';
    exit;
}

// 🔐 Sanitasi HTML
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
$laporan = $purifier->purify($data['laporan'] ?? '');

// Escape biasa
$nama    = htmlspecialchars($data['nama'] ?? '');
$judul   = htmlspecialchars($data['judul'] ?? '');
$tanggal = date('d/m/Y H:i', strtotime($data['tanggal']));
?>

<input type="hidden" name="id_akses_laporan" value="<?= $id_akses_laporan ?>">
<input type="hidden" name="response" id="response_hidden">

<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1">:</div>
    <div class="col-6"><small class="text-muted"><?= $nama ?></small></div>
</div>

<div class="row mb-3">
    <div class="col-5"><small>Tanggal</small></div>
    <div class="col-1">:</div>
    <div class="col-6"><small class="text-muted"><?= $tanggal ?></small></div>
</div>

<div class="row mb-3">
    <div class="col-5"><small>Judul</small></div>
    <div class="col-1">:</div>
    <div class="col-6"><small class="text-muted"><?= $judul ?></small></div>
</div>

<div class="row mb-3">
    <div class="col-5"><small>Isi Laporan</small></div>
    <div class="col-1">:</div>
    <div class="col-6">
        <div class="text-muted">
            <?= $laporan ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label>Response</label>
        <div id="quill_editor" style="height:200px;"></div>
    </div>
</div>
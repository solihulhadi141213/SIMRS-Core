<?php
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";

// ================= VALIDASI INPUT
if (empty($_POST['id_tempat_tidur'])) {
    echo '
        <div class="alert alert-danger text-center">
            <small>ID Tempat Tidur Tidak Boleh Kosong!</small>
        </div>
    ';
    exit;
}

$id_tempat_tidur = validateAndSanitizeInput($_POST['id_tempat_tidur']);

// ================= AMBIL DATA
$stmt = $Conn->prepare("SELECT * FROM rr_tempat_tidur WHERE id_tempat_tidur = ?");
$stmt->bind_param("i", $id_tempat_tidur);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo '
        <div class="alert alert-danger text-center">
            <small>Data tidak ditemukan!</small>
        </div>
    ';
    exit;
}

$data = $result->fetch_assoc();

$id_kelas     = $data['id_kelas_rawat'];
$id_ruang     = $data['id_ruang_rawat'];
$tempat_tidur = $data['tempat_tidur'];
$updatetime   = $data['updatetime'];
$status       = $data['status'];

// ================= FORMAT STATUS
$status_label = ($status == 1)
    ? '<span class="badge bg-success">Aktif</span>'
    : '<span class="badge bg-secondary">Tidak Aktif</span>';

// ================= FORMAT KATEGORI
if ($data['pria'] == 1) {
    $kategori = '<span class="badge bg-primary">Pria</span>';
} elseif ($data['wanita'] == 1) {
    $kategori = '<span class="badge bg-danger">Wanita</span>';
} else {
    $kategori = '<span class="badge bg-info text-dark">Bebas</span>';
}

$stmt->close();
?>

<!-- Hidden Field -->
<input type="hidden" name="id_tempat_tidur" value="<?= $id_tempat_tidur ?>">
<input type="hidden" name="id_ruang_rawat" value="<?= $id_ruang ?>">
<input type="hidden" name="id_kelas_rawat" value="<?= $id_kelas ?>">

<!-- Nama -->
<div class="row mb-3">
    <div class="col-4"><small>Nama/Kode</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><small class="text-muted"><?= $tempat_tidur ?></small></div>
</div>

<!-- Kategori -->
<div class="row mb-3">
    <div class="col-4"><small>Kategori</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><?= $kategori ?></div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><?= $status_label ?></div>
</div>

<!-- Updatetime -->
<div class="row mb-3">
    <div class="col-4"><small>Update</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><small class="text-muted"><?= $updatetime ?></small></div>
</div>

<!-- Warning -->
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger text-center">
            <small>
                <b>PERINGATAN!</b><br>
                Data tempat tidur ini akan dihapus permanen.<br>
                <b>Apakah Anda yakin?</b>
            </small>
        </div>
    </div>
</div>
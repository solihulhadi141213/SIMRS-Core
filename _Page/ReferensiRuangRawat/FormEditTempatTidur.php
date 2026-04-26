<?php
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";

if (empty($_POST['id_tempat_tidur'])) {
    echo '<div class="alert alert-danger text-center"><small>ID tidak valid</small></div>';
    exit;
}

$id = validateAndSanitizeInput($_POST['id_tempat_tidur']);

$stmt = $Conn->prepare("SELECT * FROM rr_tempat_tidur WHERE id_tempat_tidur=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo '<div class="alert alert-danger text-center"><small>Data tidak ditemukan</small></div>';
    exit;
}

$data = $result->fetch_assoc();

$id_kelas = $data['id_kelas_rawat'];
$id_ruang = $data['id_ruang_rawat'];
$nama     = $data['tempat_tidur'];
$status   = $data['status'];

$pria   = $data['pria']   ? 'checked' : '';
$wanita = $data['wanita'] ? 'checked' : '';
$bebas  = $data['bebas']  ? 'checked' : '';
$checked = $status ? 'checked' : '';

$stmt->close();
?>

<input type="hidden" name="id_tempat_tidur" value="<?= $id ?>">
<input type="hidden" name="id_ruang_rawat" value="<?= $id_ruang ?>">
<input type="hidden" name="id_kelas_rawat" value="<?= $id_kelas ?>">

<div class="mb-3">
    <label><small>Nama Tempat Tidur</small></label>
    <input type="text" name="tempat_tidur" id="tempat_tidur_edit" class="form-control" value="<?= $nama ?>" required>
</div>

<div class="mb-3">
    <label><small>Kategori</small></label>

    <div class="form-check">
        <input type="radio" name="kategori_tempat_tidur" id="kategori_tempat_tidur1" value="pria" <?= $pria ?>> 
        <label for="kategori_tempat_tidur1"><small>Pria</small></label>
    </div>
    <div class="form-check">
        <input type="radio" name="kategori_tempat_tidur" id="kategori_tempat_tidur2" value="wanita" <?= $wanita ?>>
        <label for="kategori_tempat_tidur2"><small>Wanita</small></label>
    </div>
    <div class="form-check">
        <input type="radio" name="kategori_tempat_tidur" id="kategori_tempat_tidur3" value="bebas" <?= $bebas ?>>
        <label for="kategori_tempat_tidur3"><small>Bebas</small></label>
    </div>
</div>

<div class="form-check">
    <input type="checkbox" name="status" id="status_tt_edit" value="1" <?= $checked ?>>
    <label  for="status_tt_edit">Status Aktif</label>
</div>
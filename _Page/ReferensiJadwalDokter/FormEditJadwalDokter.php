<?php
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger">Sesi habis</div>';
    exit;
}

if (empty($_POST['id_jadwal'])) {
    echo '<div class="alert alert-danger">ID tidak valid</div>';
    exit;
}

$id_jadwal = (int) $_POST['id_jadwal'];

$query = "SELECT * FROM jadwal_dokter WHERE id_jadwal=?";
$stmt  = mysqli_prepare($Conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_jadwal);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
    exit;
}

$data = mysqli_fetch_assoc($result);

$nama_dokter = getDataDetail_v2($Conn,'dokter','id_dokter',$data['id_dokter'],'nama');
$poliklinik  = getDataDetail_v2($Conn,'poliklinik','id_poliklinik',$data['id_poliklinik'],'poliklinik');
?>

<input type="hidden" name="id_jadwal" value="<?= $id_jadwal ?>">

<div class="row mb-3">
    <div class="col-12">
        <label><small>Dokter</small></label>
        <select 
            name="id_dokter" 
            id="edit_id_dokter" 
            class="form-control"
            data-selected-id="<?= $data['id_dokter'] ?>"
            data-selected-text="<?= $nama_dokter ?>">
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small>Poliklinik</small></label>
        <select 
            name="id_poliklinik" 
            id="edit_id_poliklinik" 
            class="form-control"
            data-selected-id="<?= $data['id_poliklinik'] ?>"
            data-selected-text="<?= $poliklinik ?>">
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small>Hari</small></label>
        <input type="text" readonly name="hari" id="hari_edit" class="form-control" value="<?php echo $data['hari']; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label><small>Jam Mulai</small></label>
        <input type="time" name="jam_mulai" class="form-control" value="<?= $data['jam_mulai'] ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label><small>Jam Selesai</small></label>
        <input type="time" name="jam_selesai" class="form-control" value="<?= $data['jam_selesai'] ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label><small>Kuota BPJS</small></label>
        <input type="number" name="kuota_jkn" class="form-control" value="<?= $data['kuota_jkn'] ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label><small>Kuota Umum</small></label>
        <input type="number" name="kuota_non_jkn" class="form-control" value="<?= $data['kuota_non_jkn'] ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small>Batas Waktu</small></label>
        <select name="time_max" class="form-control">
            <option value="60" <?= $data['time_max']==60?'selected':'' ?>>1 Jam</option>
            <option value="360" <?= $data['time_max']==360?'selected':'' ?>>6 Jam</option>
            <option value="720" <?= $data['time_max']==720?'selected':'' ?>>12 Jam</option>
            <option value="1440" <?= $data['time_max']==1440?'selected':'' ?>>24 Jam</option>
            <option value="2880" <?= $data['time_max']==2880?'selected':'' ?>>2 Hari</option>
        </select>
    </div>
</div>
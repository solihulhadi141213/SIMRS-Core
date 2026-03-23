<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
?>
<div class="row mb-4">
    <div class="col-md-12">
        <label for="tanggal_daftar">Tanggal/Waktu Permintaan Diterima</label>
    </div>
    <div class="col-md-6">
        <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control" value="<?php echo date('Y-m-d'); ?>">
        <small>Tanggal</small>
    </div>
    <div class="col-md-6">
        <input type="time" name="jam_daftar" id="jam_daftar" class="form-control" value="<?php echo date('H:i'); ?>">
        <small>Jam</small>
    </div>
</div>

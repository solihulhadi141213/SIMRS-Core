<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI ID TINDAKAN
    if (empty($_POST['id_tindakan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_tindakan = validateAndSanitizeInput($_POST['id_tindakan']);
?>
<input type="hidden" name="id_tindakan" value="<?php echo $id_tindakan; ?>">
<div class="row mb-3">
    <div class="col-12">
        <label for="performer_type">
            <small>*Tipe Pelaksana</small>
        </label>
        <select name="performer_type" id="performer_type" class="form-control" required>
            <option value="">Pilih</option>
            <option value="Dokter">Dokter</option>
            <option value="Perawat">Perawat</option>
            <option value="Bidan">Bidan</option>
            <option value="Ahli Gizi">Ahli Gizi</option>
            <option value="Radiografer">Radiografer</option>
            <option value="Fisioterapis">Fisioterapis</option>
            <option value="Analis Laboratorium">Analis Laboratorium</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer">
            <small>Pilih Pelaksana (<i>Performer</i>)</small>
        </label>
        <select name="performer" id="performer" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_id">
            <small>ID Akses SIMRS</small>
        </label>
        <input type="text" name="performer_id" id="performer_id" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_ihs">
            <small>ID IHS (SATUSEHAT)</small>
        </label>
        <input type="text" name="performer_ihs" id="performer_ihs" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_nik">
            <small>Nomor NIK / KTP</small>
        </label>
        <input type="text" name="performer_nik" id="performer_nik" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_nama">
            <small>Nama Lengkap</small>
        </label>
        <input type="text" name="performer_nama" id="performer_nama" class="form-control">
    </div>
</div>


<div class="row mb-3">
    <div class="col-12">
        <label for="performer_notes">
            <small>Catatan Dari Pelaksana</small>
        </label>
        <textarea name="performer_notes" id="performer_notes" class="form-control"></textarea>
    </div>
</div>
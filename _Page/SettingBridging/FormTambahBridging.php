<?php
    //Koneksi
    include "../../_Config/Connection.php";
?>
<form action="javascript:void(0);" method="POST" id="ProsesTambahSettingBridging">
    <div class="modal-body p-0">
        <div class="card-body border-0 pb-0">
            <div class="row">
                <div class="col-md-12 mb-3 form-group form-primary">
                    <label for="nama_bridging"><dt>Nama Profile</dt></label>
                    <input type="text" name="nama_bridging" id="nama_bridging" class="form-control" required>
                    <small>Ex: Setting Test bridging Vclaim V.2</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 form-group form-primary">
                    <label for="url_vclaim"><dt>URL VClaim</dt></label>
                    <input type="text" name="url_vclaim" id="url_vclaim" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 form-group form-primary">
                    <label for="url_aplicare"><dt>URL Aplicare</dt></label>
                    <input type="text" name="url_aplicare" id="url_aplicare" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 form-group form-primary">
                    <label for="url_antrol"><dt>URL Antrian Online</dt></label>
                    <input type="text" name="url_antrol" id="url_antrol" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 form-group form-primary">
                    <label for="url_faskes"><dt>URL Faskes</dt></label>
                    <input type="text" name="url_faskes" id="url_faskes" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="consid"><dt>Cons-id Vclaim</dt></label>
                    <input type="text" name="consid" id="consid" class="form-control">
                </div>
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="consid"><dt>Cons-id Antrol</dt></label>
                    <input type="text" name="cons_id_antrol" id="cons_id_antrol" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="user_key"><dt>User Key Vclaim</dt></label>
                    <input type="text" name="user_key" id="user_key" class="form-control">
                </div>
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="user_key"><dt>User Key Antrol</dt></label>
                    <input type="text" name="user_key_antrol" id="user_key_antrol" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="secret_key"><dt>Secret Key Vclaim</dt></label>
                    <input type="text" name="secret_key" id="secret_key" class="form-control">
                </div>
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="secret_key"><dt>Secret Key Vclaim</dt></label>
                    <input type="text" name="secret_key_antrol" id="secret_key_antrol" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 form-group form-primary">
                    <label for="kode_ppk"><dt>Kode PPK</dt></label>
                    <input type="text" name="kode_ppk" id="kode_ppk" class="form-control">
                </div>
                <div class="col-md-6 mb-3 form-group form-primary" required>
                    <label for="kategori_ppk"><dt>Kategori PPK</dt></label>
                    <select name="kategori_ppk" id="kategori_ppk" class="form-control">
                        <option value="PCare">PCare</option>
                        <option value="Rumah Sakit">Rumah Sakit</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 form-group form-primary text-left ml-4" required>
                    <label for="status"><dt>Status Profile</dt></label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="Aktiv">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Aktiv Profile Setting</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="Non-Aktiv">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Non Aktiv Profile Setting</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiTambahSettingBridging">
                        Pastikan data setting bridging yang anda masukan sudah benar.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                    <i class="ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>
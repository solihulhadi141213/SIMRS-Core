<?php
    date_default_timezone_set('Asia/Jakarta');
    //Membuka Setting API Key
    $QryApiKey = mysqli_query($Conn,"SELECT * FROM setting_web ORDER BY id_setting_web DESC")or die(mysqli_error($Conn));
    $DataApiKey = mysqli_fetch_array($QryApiKey);
    if(!empty($DataApiKey['id_setting_web'])){
        //Apabila data pengaturan sudah ada maka buat variabel
        $id_setting_web= $DataApiKey['id_setting_web'];
        $api_key= $DataApiKey['api_key'];
        $base_url_service= $DataApiKey['base_url_service'];
        $updatetime= $DataApiKey['last_update'];
        $strtotime= strtotime($updatetime);
        $last_update= date('d/m/Y H:i',$strtotime);
        
    }else{
        //Apabila data pengaturan belum ada maka buat variabel kosong
        $id_setting_web="";
        $api_key="";
        $base_url_service="";
        $last_update="";
    }
?>
<!--- Modal Tambah Service Web ---->
<div class="modal fade" id="ModalSettingApiKey" tabindex="-1" role="dialog" aria-labelledby="ModalSettingApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesSettingKoneksiWebsite">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-key"></i> Atur API Key</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="api_key">API Key</label>
                            <input type="text" name="api_key" id="api_key" class="form-control" value="<?php echo "$api_key"; ?>">
                            <small>API Key untutk autentifikasi service website.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="base_url_service">Base URL</label>
                            <input type="text" name="base_url_service" id="base_url_service" class="form-control" value="<?php echo "$base_url_service"; ?>">
                            <small>URL yang digunakan untuk mengakses service website.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiSettingKoneksiWebsite">
                            <span class="text-primary">
                                Pastikan Pengaturan API Key yang digunakan sudah benar.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Service Web ---->
<div class="modal fade" id="ModalTambahServiceWeb" tabindex="-1" role="dialog" aria-labelledby="ModalTambahServiceWeb" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahService">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Service</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="service_name">Nama Service</label>
                            <input type="text" name="service_name" id="service_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="service_category">Kategori</label>
                            <input type="text" name="service_category" id="service_category" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="url_service">URL Service</label>
                            <input type="text" name="url_service" id="url_service" class="form-control" value="<?php echo "$base_url_service"; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiTambahService">
                            <span class="text-primary">
                                Pastikan Service yang input sudah benar.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Service Web ---->
<div class="modal fade" id="ModalEditService" tabindex="-1" role="dialog" aria-labelledby="ModalEditService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditService">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Edit Service</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditService">
                    
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Replice Service ---->
<div class="modal fade" id="ModalReplace" tabindex="-1" role="dialog" aria-labelledby="ModalReplace" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesRepliceService">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Replice Service</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="from_replice">Ubah Dari</label>
                            <input type="text" id="from_replice" name="from_replice" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="to_replice">Ubah Ke</label>
                            <input type="text" id="to_replice" name="to_replice" class="form-control" value="<?php echo "$base_url_service"; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiRepliceService">
                            <span class="text-primary">Apakah anda yakin ingin merubah data URL service? </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success" id="RepliceSekarang">
                        <i class="ti ti-save"></i> Replice
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Delete web Service ---->
<div class="modal fade" id="ModalHapusService" tabindex="-1" role="dialog" aria-labelledby="ModalHapusService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Service</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDeleteService">
                <!---- Konfirmasi Delete Service ----->
            </div>
        </div>
    </div>
</div>
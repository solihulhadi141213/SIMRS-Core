<!--- Modal Tambah Bridging BPJS --->
<div class="modal fade" id="ModalTambahSettingBpjs" tabindex="-1" aria-labelledby="ModalTambahSettingBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahSettingBpjs" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Profil Pengaturan SATUSEHAT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama_setting_bpjs"><small>Profil Pengaturan</small></label>
                            <input type="text" name="nama_setting_bpjs" id="nama_setting_bpjs" class="form-control" placeholder="Contoh : Development" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="consid"><small><i>Cons ID</i></small></label>
                            <input type="text" name="consid" id="consid" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="user_key"><small><i>User Key (Vclaim)</i></small></label>
                            <input type="text" name="user_key" id="user_key" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="user_key_antrol"><small><i>User Key (Antrol)</i></small></label>
                            <input type="text" name="user_key_antrol" id="user_key_antrol" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="secret_key"><small><i>Secret Key</i></small></label>
                            <input type="text" name="secret_key" id="secret_key" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode_ppk"><small>Kode PPK</small></label>
                            <input type="text" name="kode_ppk" id="kode_ppk" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="url_vclaim"><small><i>URL Vclaim</i></small></label>
                            <input type="text" name="url_vclaim" id="url_vclaim" class="form-control" placeholder="https://" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="url_aplicare"><small><i>URL Aplicare</i></small></label>
                            <input type="url" name="url_aplicare" id="url_aplicare" class="form-control" placeholder="https://" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="url_antrol"><small><i>URL Antrol</i></small></label>
                            <input type="url" name="url_antrol" id="url_antrol" class="form-control" placeholder="https://" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="url_icare"><small><i>URL iCare</i></small></label>
                            <input type="url" name="url_icare" id="url_icare" class="form-control" placeholder="https://" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked="">
                                <label class="form-check-label" for="status">
                                    <small>Aktifkan Profil Pengaturan Ini</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahSettingBpjs">
                           <!-- Notifikasi Tambah Bridging BPJS Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahSettingBpjs">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail Bridging BPJS --->
<div class="modal fade" id="ModalDetailBpjs" tabindex="-1" aria-labelledby="ModalDetailBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Bridging BPJS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailBpjs">
                        <!-- Form Detail Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Koneksi Bridging BPJS --->
<div class="modal fade" id="ModalKoneksiBpjs" tabindex="-1" aria-labelledby="ModalKoneksiBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-arrow-left-right"></i> Koneksi Bridging BPJS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormKoneksiBpjs">
                        <!-- Form Uji Coba Koneksi Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Edit Bridging BPJS --->
<div class="modal fade" id="ModalEditSettingBpjs" tabindex="-1" aria-labelledby="ModalEditSettingBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditSettingBpjs" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Setting Bridging BPJS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditSettingBpjs">
                           <!-- Form Edit Bridging BPJS Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditSettingBpjs">
                           <!-- Notifikasi Edit Bridging BPJS Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditBpjs">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Hapus Bridging BPJS --->
<div class="modal fade" id="ModalHapusSettingBpjs" tabindex="-1" aria-labelledby="ModalHapusSettingBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusSettingBpjs" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Setting Bridging BPJS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusSettingBpjs">
                            <!-- Form Hapus Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusSettingBpjs">
                            <!-- Notifikasi Hapus Setting Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusSettingBpjs">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
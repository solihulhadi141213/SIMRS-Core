<!--- Modal Tambah Setting --->
<div class="modal fade" id="ModalTambahSetting" tabindex="-1" aria-labelledby="ModalTambahSetting" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahSetting" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="setting_name"><small>Nama Profil Pengaturan</small></label>
                            <input type="text" name="setting_name" id="setting_name" class="form-control" required placeholder="Contoh : Development, Staging atau Production">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="aplication_name"><small>Nama Aplikasi</small></label>
                            <input type="text" name="aplication_name" id="aplication_name" required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="aplication_description"><small>Deskripsi</small></label>
                            <textarea name="aplication_description" id="aplication_description" required class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="aplication_keyword"><small>Kata Kunci (<i>Keyword</i>)</small></label>
                            <input type="text" name="aplication_keyword" id="aplication_keyword" required class="form-control" placeholder="Contoh : Key1, Key2, Key3, dst ">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="aplication_author"><small>Author Aplikasi</small></label>
                            <input type="text" name="aplication_author" id="aplication_author" required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="base_url"><small>Base URL</small></label>
                            <input type="url" name="base_url" id="base_url" class="form-control" required placeholder="https://">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hospital_name"><small>Nama Faskes</small></label>
                            <input type="text" name="hospital_name" id="hospital_name" class="form-control" required placeholder="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hospital_address"><small>Alamat</small></label>
                            <textarea name="hospital_address" id="hospital_address" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hospital_contact"><small>No.Kontak</small></label>
                            <input type="text" name="hospital_contact" id="hospital_contact" class="form-control" required placeholder="+62">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hospital_email"><small>Email</small></label>
                            <input type="email" name="hospital_email" id="hospital_email" class="form-control" required placeholder="faskes@domain.com">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hospital_code"><small>Kode Faskes (Kemenkes)</small></label>
                            <input type="text" name="hospital_code" id="hospital_code" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hospital_manager"><small>Nama Manager / Direktur</small></label>
                            <input type="text" name="hospital_manager" id="hospital_manager" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="favicon"><small>Favicon Aplikasi</small></label>
                            <input type="file" name="favicon" id="favicon" class="form-control" required>
                            <small class="text text-muted">
                                Maksimal 1 Mb (ICO, PNG, JPG, GIF)
                            </small>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="logo"><small>Logo Faskes</small></label>
                            <input type="file" name="logo" id="logo" class="form-control" required>
                            <small class="text text-muted">
                                Maksimal 1 Mb (ICO, PNG, JPG, GIF)
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="aktivasi_setting" name="aktivasi_setting" value="1" checked="">
                                <label class="form-check-label" for="aktivasi_setting">Aktifkan Profil Pengaturan Ini</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahSetting">
                           <!-- Notifikasi Tambah Setting Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahSetting">
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

<!--- Modal Detail Setting --->
<div class="modal fade" id="ModalDetailSetting" tabindex="-1" aria-labelledby="ModalDetailSetting" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailSetting">
                        <!-- Form Detail Setting Akan Muncul Disini -->
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

<!--- Modal Edit Setting --->
<div class="modal fade" id="ModalEditSetting" tabindex="-1" aria-labelledby="ModalEditSetting" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditSetting" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditSetting">
                           <!-- Form Edit Setting Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditSetting">
                           <!-- Notifikasi Edit Setting Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditSetting">
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

<!--- Modal Hapus Setting --->
<div class="modal fade" id="ModalHapusSetting" tabindex="-1" aria-labelledby="ModalHapusSetting" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusSetting" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Profil Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapusSetting">
                           <!-- Form Hapus Setting Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusSetting">
                           <!-- Notifikasi Hapus Setting Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusSetting">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
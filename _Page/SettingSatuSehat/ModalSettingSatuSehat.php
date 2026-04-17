<!--- Modal Tambah Satu Sehat --->
<div class="modal fade" id="ModalTambahSettingSatuSehat" tabindex="-1" aria-labelledby="ModalTambahSettingSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahSettingSatuSehat" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Profil Pengaturan SATUSEHAT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama_setting_satusehat"><small>Profil Pengaturan</small></label>
                            <input type="text" name="nama_setting_satusehat" id="nama_setting_satusehat" class="form-control" placeholder="Contoh : Development" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="url_satusehat"><small><i>URL (ENDPOINT)</i></small></label>
                            <input type="urk" name="url_satusehat" id="url_satusehat" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="organization_id"><small><i>Organization ID</i></small></label>
                            <input type="text" name="organization_id" id="organization_id" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="client_key"><small><i>Client Key</i></small></label>
                            <input type="text" name="client_key" id="client_key" class="form-control" required>
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
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked="">
                                <label class="form-check-label" for="status">
                                    <small>Aktifkan Profil Pengaturan Ini</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahSettingSatuSehat">
                           <!-- Notifikasi Tambah Satu Sehat Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahSettingSatuSehat">
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

<!--- Modal Detail Satu Sehat --->
<div class="modal fade" id="ModalDetailSatuSehat" tabindex="-1" aria-labelledby="ModalDetailSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Satu Sehat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailSatuSehat">
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

<!--- Modal Koneksi Satu Sehat --->
<div class="modal fade" id="ModalKoneksiSatuSehat" tabindex="-1" aria-labelledby="ModalKoneksiSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-arrow-left-right"></i> Koneksi Satu Sehat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormKoneksiSatuSehat">
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

<!--- Modal Edit Satu Sehat --->
<div class="modal fade" id="ModalEditSettingSatuSehat" tabindex="-1" aria-labelledby="ModalEditSettingSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditSettingSatuSehat" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Setting Satu Sehat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditSettingSatuSehat">
                           <!-- Form Edit Satu Sehat Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditSettingSatuSehat">
                           <!-- Notifikasi Edit Satu Sehat Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditSatuSehat">
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

<!--- Modal Hapus Satu Sehat --->
<div class="modal fade" id="ModalHapusSettingSatuSehat" tabindex="-1" aria-labelledby="ModalHapusSettingSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusSettingSatuSehat" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Setting Satu Sehat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusSettingSatuSehat">
                            <!-- Form Hapus Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusSettingSatuSehat">
                            <!-- Notifikasi Hapus Setting Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusSettingSatuSehat">
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
<div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="ModalTambah" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah">
                <div class="modal-header">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tabah Pengaturan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="setting_name"><dt>Nama Pengaturan</dt></label>
                            <input type="text" name="setting_name" id="setting_name" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="base_url"><dt>Base Url</dt></label>
                            <input type="url" name="base_url" id="base_url" class="form-control" placeholder="https://">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="setting_username"><dt>Username</dt></label>
                            <input type="text" name="setting_username" id="setting_username" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="setting_password"><dt>Password</dt></label>
                            <input type="text" name="setting_password" id="setting_password" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="setting_status"><dt>Status</dt></label>
                            <select name="setting_status" id="setting_status" class="form-control">
                                <option value="0">Non Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="Notifikasi_tambah">
                            <!-- Notifikasi Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUjiKoneksi">
                <div class="modal-header">
                    <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Pengaturan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormDetail">
                            <!-- Detail Pengaturan -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="FormUjiKoneksi">
                            <!-- Form Uji Koneksi -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn btn-primary">
                        <i class="ti ti-arrow-circle-right"></i> Uji Koneksi
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit">
                <div class="modal-header">
                    <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Pengaturan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEdit">
                            <!-- Detail Pengaturan -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiEdit">
                            <!-- Form Uji Koneksi -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus">
                <div class="modal-header">
                    <b cass="text-light"><i class="ti ti-trash"></i> Hapus Pengaturan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapus">
                            <!-- Form Hapus -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn btn-primary">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
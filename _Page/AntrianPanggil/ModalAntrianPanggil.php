<!--- Modal Detail Antrian ---->
<div class="modal fade" id="ModalDetailAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="index.php" method="GET" target="_blank">
                <div class="modal-header bg-primary">
                    <b cass="card-title text-light">
                        <i class="ti ti-info-alt"></i> Panggil Antrian
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormDetailAntrian">
                            <!---- Informasi Detail Antrian Akan Muncul Disini ----->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiProsesKirimDataMonitor">
                            <!---- Notifikasi Proses Pemanggilan Akan Muncul Disini ----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <a href="javascript:void(0);" class="btn btn-md btn-success panggil-antrian">
                        <i class="ti ti-control-play"></i> Panggil
                    </a>
                    <button type="submit" class="btn btn-md btn-info">
                        <i class="ti ti-arrow-circle-right"></i> Buka Antrian
                    </button>
                    <button type="button" class="btn btn-md btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Setting Koneksi Monitor Antrian ---->
<div class="modal fade" id="ModalSettingKoneksiMonitor" tabindex="-1" role="dialog" aria-labelledby="ModalSettingKoneksiMonitor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesSimpanSettingKoneksiMonitor">
                <div class="modal-header">
                    <b cass="card-title">
                        <i class="ti ti-settings"></i> Setting Koneksi Monitor
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormSettingKoneksiMonitor">
                            <!---- Informasi Detail Antrian Akan Muncul Disini ----->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiSimpanSettingKoneksiMonitor">
                            <!---- Notifikasi Proses Pemanggilan Akan Muncul Disini ----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="ButtonSimpanSettingKoneksiMonitor">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Credential Koneksi Monitor Antrian ---->
<div class="modal fade" id="ModalCredentialMonitor" tabindex="-1" role="dialog" aria-labelledby="ModalCredentialMonitor" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="card-title">
                    <i class="ti ti-settings"></i> Credential Koneksi Monitor
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesTambahCredential" class="form-tambah-credential">
                    <!-- Form Tambah Credential Akan Muncul Disini -->
                </form>
                <div class="row">
                    <div class="col-md-12" id="NotifikasiTambahCredential">
                        <!---- Notifikasi Tambah Credential Akan Muncul Disini ----->
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12" id="FormListCredential">
                        <!---- List Credential Akan Muncul Disini ----->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Edit Credential ---->
<div class="modal fade" id="ModalEditCredential" tabindex="-1" role="dialog" aria-labelledby="ModalEditCredential" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditCredential">
                <div class="modal-header bg-success">
                    <b class="card-title text-light">
                        <i class="ti ti-pencil"></i> Edit Credential
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditCredential">
                            <!---- List Credential Akan Muncul Disini ----->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditCredential">
                            <!---- Notifikasi Edit Credential Akan Muncul Disini ----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-sm btn-primary" id="ButtonEditCredential">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Hapus Credential ---->
<div class="modal fade" id="ModalHapusCredential" tabindex="-1" role="dialog" aria-labelledby="ModalHapusCredential" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusCredential">
                <div class="modal-header bg-danger">
                    <b class="card-title text-light">
                        <i class="ti ti-trash"></i> Hapus Credential
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusCredential">
                            <!---- List Credential Akan Muncul Disini ----->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusCredential">
                            <!---- Notifikasi Edit Credential Akan Muncul Disini ----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-sm btn-primary" id="ButtonEditCredential">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail Credential ---->
<div class="modal fade" id="ModalDetailCredential" tabindex="-1" role="dialog" aria-labelledby="ModalDetailCredential" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="card-title">
                    <i class="ti ti-info"></i> Detail Credential
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12" id="FormDetailCredential">
                        <!---- Form Detail Credential Akan Muncul Disini ----->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah So ---->
<div class="modal fade" id="ModalTambahSo" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSo">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Struktur Organiasasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="boss">Key Boss</label>
                            <input type="text" name="boss" id="boss" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="job_title">Job Title</label>
                            <input type="text" name="job_title" id="job_title" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="NIP">NIP</label>
                            <input type="text" name="NIP" id="NIP" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="foto">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiTambahSo">
                            <span class="text-primary">
                                Pastikan data Struktur Orgnisasi sudah benar.
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
<!--- Modal Edit So ---->
<div class="modal fade" id="ModalEditSo" tabindex="-1" role="dialog" aria-labelledby="ModalEditSo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSo">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Edit Struktur Organiasasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditSo">
                    
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
<!--- Modal Delete So ---->
<div class="modal fade" id="ModalHapustSo" tabindex="-1" role="dialog" aria-labelledby="ModalHapusService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Struktur Organiasasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSo">
                <!---- Konfirmasi Hapus So ----->
            </div>
        </div>
    </div>
</div>

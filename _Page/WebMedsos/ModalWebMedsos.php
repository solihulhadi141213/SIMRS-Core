<!--- Modal Tambah Medsos ---->
<div class="modal fade" id="ModalTambahMedsos" tabindex="-1" role="dialog" aria-labelledby="ModalTambahMedsos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahMedsos">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Medsos</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="nama_medsos">Nama Medsos</label>
                            <input type="text" name="nama_medsos" id="nama_medsos" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="url_medsos">URL Medsos</label>
                            <input type="text" name="url_medsos" id="url_medsos" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="img_medsos">Icon Medsos</label>
                            <input type="file" name="img_medsos" id="img_medsos" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiTambahMedsos">
                            <span class="text-primary">
                                Pastikan data Medsos sudah benar.
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
<!--- Modal Edit Medsos ---->
<div class="modal fade" id="ModalEditMedsos" tabindex="-1" role="dialog" aria-labelledby="ModalEditMedsos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditMedsos">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Edit Medsos</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditMedsos">
                    
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
<!--- Modal Delete Medsos ---->
<div class="modal fade" id="ModalHapustMedsos" tabindex="-1" role="dialog" aria-labelledby="ModalHapusService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Medsos</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusMedsos">
                <!---- Konfirmasi Hapus Medsos ----->
            </div>
        </div>
    </div>
</div>
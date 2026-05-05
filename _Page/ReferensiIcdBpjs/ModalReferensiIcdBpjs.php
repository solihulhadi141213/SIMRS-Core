<!--- Modal Detail ICD --->
<div class="modal fade" id="ModalDetailIcd" tabindex="-1" aria-labelledby="ModalDetailIcd" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail ICD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailIcd">
                        <!-- Notifikasi Detail  Akan Muncul Disini -->
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

<!--- Modal Tambah ICD --->
<div class="modal fade" id="ModalTambahIcd" tabindex="-1" aria-labelledby="ModalTambahIcd" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahIcd" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah ICD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Versi -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="icd_add"><small>ICD / Version</small></label>
                            <input type="text" readonly name="icd" id="icd_add" class="form-control bg-secondary-subtle input_icd_version">
                        </div>
                    </div>

                    <!-- Kode -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode_add"><small>Kode ICD</small></label>
                            <input type="text" name="kode" id="kode_add" class="form-control" required>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="short_des_add"><small><i>Short Description</i></small></label>
                            <input type="text" name="short_des" id="short_des_add" class="form-control" required>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="long_des_add"><small><i>Long Description</i></small></label>
                            <textarea name="long_des" id="long_des_add" class="form-control" required></textarea>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahIcd">
                           <!-- Notifikasi Tambah  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahIcd">
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
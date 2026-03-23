<!--- Modal Tambah Tarif Tindakan ---->
<div class="modal fade" id="ModalTambahTarifTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahTarifTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahTarifTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Tarif Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nama">Nama Tarif</label>
                            <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="kategori">Kategori Tarif</label>
                            <input type="text" class="form-control" name="kategori" id="kategori" list="ListKategori">
                            <datalist id="ListKategori"></datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="tarif">Tarif</label>
                            <input type="number" class="form-control" name="tarif" id="tarif">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahTarifTindakan">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Tarif Tindakan ---->
<div class="modal fade" id="ModalDetailTarif" tabindex="-1" role="dialog" aria-labelledby="ModalDetailTarif" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Tarif Tindakan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailTarif"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Tarif Tindakan ---->
<div class="modal fade" id="ModalEditTarif" tabindex="-1" role="dialog" aria-labelledby="ModalEditTarif" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTarifTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Edit Tarif Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditTarifTindakan"></div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditTarifTindakan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Tarif Tindakan 2 ---->
<div class="modal fade" id="ModalEditTarif2" tabindex="-1" role="dialog" aria-labelledby="ModalEditTarif2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTarifTindakan2">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Edit Tarif Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditTarifTindakan2"></div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditTarifTindakan2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Tarif Tindakan ---->
<div class="modal fade" id="ModalHapusTarif" tabindex="-1" role="dialog" aria-labelledby="ModalHapusTarif" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTarif">
                <input type="hidden" name="id_tarif" id="PutIdTarifHapus">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Tarif Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col col-md-12 text-center">
                            <span class="modal-icon display-2-lg">
                                <img src="assets/images/question.gif" width="70%">
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 text-center">
                            <small>
                                Apakah anda yakin akan menghapus data ini?
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusTarif"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-primary">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Unit Cost ---->
<div class="modal fade" id="ModalTambahUnitCost" tabindex="-1" role="dialog" aria-labelledby="ModalTambahUnitCost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahUnitCost">
                <input type="hidden" name="id_tarif" id="PutIdTarifForAddCost">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Unit Cost</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nama">Nama Unit Cost</label>
                            <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="cost">Nilai Cost (Rp)</label>
                            <input type="number" class="form-control" name="cost" id="cost">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahUnitCost">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Unit Cost ---->
<div class="modal fade" id="ModalEditUnitCost" tabindex="-1" role="dialog" aria-labelledby="ModalEditUnitCost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditUnitCost">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Unit Cost</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditUnitCost"></div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditUnitCost">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Unit Cost Tindakan ---->
<div class="modal fade" id="ModalHapusUnitCost" tabindex="-1" role="dialog" aria-labelledby="ModalHapusUnitCost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusUnitCost">
                <input type="hidden" name="id_cost" id="PutIdCostHapus">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Unit Cost</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col col-md-12 text-center">
                            <span class="modal-icon display-2-lg">
                                <img src="assets/images/question.gif" width="70%">
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 text-center">
                            <small>
                                Apakah anda yakin akan menghapus data ini?
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusUnitCost"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-primary">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
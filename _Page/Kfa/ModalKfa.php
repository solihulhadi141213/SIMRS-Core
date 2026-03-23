<!--- Modal Export Referensi ---->
<div class="modal fade" id="ModalFilterKfa" tabindex="-1" role="dialog" aria-labelledby="ModalFilterKfa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="FilterKfa">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="size"><dt>Batas</dt></label>
                            <select name="size" id="size" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="product_type"><dt>Type Product</dt></label>
                            <select name="product_type" id="product_type" class="form-control">
                                <option value="">Pilih</option>
                                <option selected value="farmasi">Farmasi</option>
                                <option value="alker">Alkes</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="keyword"><dt>Keyword</dt></label>
                            <input type="text" class="form-control" name="keyword" id="keyword">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail KFA ---->
<div class="modal fade" id="ModalDetailKfa" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKfa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail KFA</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailKfa">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Harga KFA ---->
<div class="modal fade" id="ModalHargaKfa" tabindex="-1" role="dialog" aria-labelledby="ModalHargaKfa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Harga KFA</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormHargaKfa">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Filter Msi -->
<div class="modal fade" id="ModalFilterMsi" tabindex="-1" role="dialog" aria-labelledby="ModalFilterMsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="FilterMsi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="limit"><dt>Limit</dt></label>
                            <select name="limit" id="limit" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="jenis_sarana"><dt>Jenis Sarana</dt></label>
                            <select name="jenis_sarana" id="jenis_sarana" class="form-control">
                                <option value="">Pilih</option>
                                <option selected value="104">Rumah Sakit</option>
                                <option value="103">Klinik</option>
                                <option value="102">PUSKESMAS</option>
                                <option value="101">Praktek Mandiri</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kode_provinsi"><dt>Provinsi</dt></label>
                            <select name="kode_provinsi" id="kode_provinsi" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kode_kabkota"><dt>Kabupaten/Kota</dt></label>
                            <select name="kode_kabkota" id="kode_kabkota" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kode_kecamatan"><dt>Kecamatan</dt></label>
                            <select name="kode_kecamatan" id="kode_kecamatan" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail MSI ---->
<div class="modal fade" id="ModalDetailMsi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail MSI</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailMsi">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
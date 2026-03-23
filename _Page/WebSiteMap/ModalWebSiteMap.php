<!--- Modal Tambah Sitemap---->
<div class="modal fade" id="ModalTambahSitemap" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSitemap" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSitemap">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-info"></i> Tambah Sitemap</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="url_site">URL</label>
                            <input type="text" id="url_site" name="url_site" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="label">Label</label>
                            <input type="text" id="label" name="label" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priority_site">Priority</label>
                            <select name="priority_site" id="priority_site" class="form-control">
                                <option value="0.0">0.0</option>
                                <option value="0.1">0.1</option>
                                <option value="0.2">0.2</option>
                                <option value="0.3">0.3</option>
                                <option value="0.4">0.4</option>
                                <option value="0.5">0.5</option>
                                <option value="0.6">0.6</option>
                                <option value="0.7">0.7</option>
                                <option value="0.8">0.8</option>
                                <option value="0.9">0.9</option>
                                <option value="1.0">1.0</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Draft">Draft</option>
                                <option value="Publish">Publish</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahSitemap">
                            <span class="text-primary">Pastikan bahwa data site map sudah terisi dengan lengkap</span>
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
<!--- Modal Detail Sitemap---->
<div class="modal fade" id="ModalViewPage" tabindex="-1" role="dialog" aria-labelledby="ModalViewPage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-info"></i> Detail Sitemap</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pre-scrollable" id="FormDetailSitemap">
                
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Sitemap---->
<div class="modal fade" id="ModalEditSitemap" tabindex="-1" role="dialog" aria-labelledby="ModalEditSitemap" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSitemap">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Edit Sitemap</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditSitemap">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Delete Sitemap ---->
<div class="modal fade" id="ModalHapusSitemap" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSitemap" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Sitemap</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSitemap">
                <!---- Konfirmasi Hapus Sitemap ----->
            </div>
        </div>
    </div>
</div>
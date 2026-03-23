<div class="modal fade" id="ModalFilter" tabindex="-1" role="dialog" aria-labelledby="ModalFilter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterApiKey">
                <input type="hidden" name="page" id="page" value="1">
                <div class="modal-header bg-inverse">
                    <b cass="text-light">
                        <i class="ti ti-filter"></i> Form Filter
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="batas">Batas/Limit</label>
                        </div>
                        <div class="col-md-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="OrderBy">Order By</label>
                        </div>
                        <div class="col-md-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="api_name">API Name</option>
                                <option value="client_id">Client ID</option>
                                <option value="datetime_creat">Datetime Creat</option>
                                <option value="datetime_update">Datetime Update</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ShortBy">Short By</label>
                        </div>
                        <div class="col-md-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">Z to A</option>
                                <option value="ASC">A to Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keyword_by">Keyword By</label>
                        </div>
                        <div class="col-md-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="api_name">API Name</option>
                                <option value="client_id">Client ID</option>
                                <option value="datetime_creat">Datetime Creat</option>
                                <option value="datetime_update">Datetime Update</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keyword">Keyword</label>
                        </div>
                        <div class="col-md-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti ti-check"></i> Filter
                    </button>
                    <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahApiKey" tabindex="-1" role="dialog" aria-labelledby="ModalTambahApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahApiKey">
                <div class="modal-header bg-primary">
                    <b cass="text-light">
                        <i class="ti ti-plus"></i> Tambah API Key
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="api_name">Nama API Key</label>
                            <input type="text" name="api_name" id="api_name" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="api_description">Deskripsi</label>
                            <textarea name="api_description" id="api_description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="client_id">Client ID</label>
                            <div class="input-group">
                                <input type="text" name="client_id" id="client_id" class="form-control client_id">
                                <button type="button" class="btn btn-sm btn-outline-dark" id="GenerateClientId">
                                    <i class="ti ti-reload"></i> Generate
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="client_key">Client Key</label>
                            <div class="input-group">
                                <input type="text" name="client_key" id="client_key" class="form-control client_key">
                                <button type="button" class="btn btn-sm btn-outline-dark" id="GenerateClientKey">
                                    <i class="ti ti-reload"></i> Generate
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="expired_duration">Durasi Expired</label>
                            <input type="number" min="0" name="expired_duration" id="expired_duration" class="form-control">
                            <small>Dalam satuan Milisecond</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahApiKey">
                            <!-- Notifikasi Tambah API Key -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="TombolSimpanApiKey">
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
<div class="modal fade" id="ModalEditApiKeyService" tabindex="-1" role="dialog" aria-labelledby="ModalEditApiKeyService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditApiKey">
                <div class="modal-header bg-success">
                    <b cass="text-light">
                        <i class="ti ti-pencil"></i> Edit API Key
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditApiKeyService">
                            <!-- Form Edit Api Key Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditApiKey">
                            <!-- Notifikasi Edit API Key -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="TombolEditApiKey">
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
<div class="modal fade" id="ModalHapusApiKey" tabindex="-1" role="dialog" aria-labelledby="ModalHapusApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusApiKey">
                <div class="modal-header bg-danger">
                    <b cass="text-light">
                        <i class="ti ti-trash"></i> Hapus API Key
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusApiKey">
                            <!-- Form Hapus Api Key Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiHapusApiKey">
                            <!-- Notifikasi Hapus API Key -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="TombolHapusApiKey">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
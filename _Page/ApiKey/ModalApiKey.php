<!--- Modal Tambah API Key --->
<div class="modal fade" id="ModalTambahApiKey" tabindex="-1" aria-labelledby="ModalTambahApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahApiKey" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah API Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="api_name"><small>Nama API Key</small></label>
                            <input type="text" name="api_name" id="api_name" class="form-control" required placeholder="Contoh : Aplikasi Radiologi, Aplikasi LMS">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="api_description"><small>Deskripsi</small></label>
                            <textarea name="api_description" id="api_description" required class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="client_id">
                                <small>
                                    <i>Client ID</i>
                                </small>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="client_id" id="client_id" required>
                                <button class="btn btn-sm btn btn-outline-secondary generate_client_id" type="button" title="Generate Client ID">
                                    <i class="bi bi-repeat"></i> Generate
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="client_key">
                                <small>
                                    <i>Client Key</i>
                                </small>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="client_key" id="client_key" required>
                                <button class="btn btn-sm btn btn-outline-secondary generate_client_key" type="button" title="Generate Client Key">
                                    <i class="bi bi-repeat"></i> Generate
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="expired_duration"><small>
                                <small><i>Expired Duration</i></small>
                            </small></label>
                            <select name="expired_duration" id="expired_duration" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="1">1 Jam</option>
                                <option value="6">6 Jam</option>
                                <option value="12">12 Jam</option>
                                <option value="24">24 Jam</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahApiKey">
                           <!-- Notifikasi Tambah API Key Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahApiKey">
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

<!--- Modal Detail API Key --->
<div class="modal fade" id="ModalDetailApiKey" tabindex="-1" aria-labelledby="ModalDetailApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail API Key</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailApiKey">
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

<!--- Modal Edit API Key --->
<div class="modal fade" id="ModalEditApiKey" tabindex="-1" aria-labelledby="ModalEditApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditApiKey" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit API Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditApiKey">
                           <!-- Form Edit API Key Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditApiKey">
                           <!-- Notifikasi Edit API Key Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditApiKey">
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

<!--- Modal Regenerate Client Key --->
<div class="modal fade" id="ModalRegenerateClientKey" tabindex="-1" aria-labelledby="ModalRegenerateClientKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesRegenerateClientKey" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-repeat"></i> Regenerate Client Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormRegenerateClientKey">
                           <!-- Form Regenerate Client Key Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiRegenerateClientKey">
                           <!-- Notifikasi Regenerate Client Key Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonRegenerateClientKey">
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

<!--- Modal Log Token --->
<div class="modal fade" id="ModalHapusLogToken" tabindex="-1" aria-labelledby="ModalHapusLogToken" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusLogToken" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Log Token</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusLogToken">
                            <!-- Form Hapus Log Token Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusLogToken">
                            <!-- Notifikasi Hapus Log Token Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusLogToken">
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

<!--- Modal Hapus API Key --->
<div class="modal fade" id="ModalHapusApiKey" tabindex="-1" aria-labelledby="ModalHapusApiKey" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusApiKey" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus API Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusApiKey">
                            <!-- Form Hapus Log Token Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusApiKey">
                            <!-- Notifikasi Hapus Log Token Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusApiKey">
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
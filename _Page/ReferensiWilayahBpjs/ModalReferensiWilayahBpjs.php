<!--- Modal Kabupaten --->
<div class="modal fade" id="ModalKabupaten" tabindex="-1" aria-labelledby="ModalKabupaten" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Data Wilayah Kabupaten / Kota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesFilterKabupaten">
                    <input type="hidden" name="nama_prov" id="nama_prov" value="">
                    <input type="hidden" name="kode_prov" id="kode_prov" value="">
                    <div class="row mb-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="keyword_kabupaten" id="keyword_kabupaten" class="form-control" placeholder="Kabupaten / Kota">
                                <button type="submit" class="input-group-text" id="basic-addon2">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12" id="FormKabupaten">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <td><small><b>No</b></small></td>
                                        <td><small><b>Kode Provinsi</b></small></td>
                                        <td><small><b>Nama Provinsi</b></small></td>
                                        <td><small><b>Kode Kab/Kota</b></small></td>
                                        <td><small><b>Nama Kab/Kota</b></small></td>
                                        <td><small><b>Opsi</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="TabelKabupaten">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <small>No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Form Akan Muncul Disini -->
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

<!--- Modal Kecamatan --->
<div class="modal fade" id="ModalKecamatan" tabindex="-1" aria-labelledby="ModalKecamatan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Data Wilayah Kecamatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesFilterKecamatan">
                    <input type="hidden" name="nama_prov" id="nama_prov2" value="">
                    <input type="hidden" name="kode_prov" id="kode_prov2" value="">
                    <input type="hidden" name="nama_kab" id="nama_kab" value="">
                    <input type="hidden" name="kode_kab" id="kode_kab" value="">
                    <div class="row mb-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="keyword_kecamatan" id="keyword_kecamatan" class="form-control" placeholder="Kecamatan">
                                <button type="submit" class="input-group-text" id="basic-addon2">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <td><small><b>No</b></small></td>
                                        <td><small><b>Kode Provinsi</b></small></td>
                                        <td><small><b>Nama Provinsi</b></small></td>
                                        <td><small><b>Kode Kab/Kota</b></small></td>
                                        <td><small><b>Nama Kab/Kota</b></small></td>
                                        <td><small><b>Kode Kecamatan</b></small></td>
                                        <td><small><b>Nama Kabupaten</b></small></td>
                                        <td><small><b>Opsi</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="TabelKecamatan">
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <small>No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Form Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTambahSimrs" tabindex="-1" aria-labelledby="ModalTambahSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahSimrs" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Ke SIMRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormTambahSimrs">
                           <!-- Form Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahSimrs">
                           <!-- Notifikasi Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahSimrs">
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
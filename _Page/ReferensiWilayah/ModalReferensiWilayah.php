<!-- Filter Data -->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page" id="page_filter" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas">
                                <small>Limit</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="OrderBy">
                                <small>Dasar Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="province">Provinsi</option>
                                <option value="regency">Kabupaten / Kota</option>
                                <option value="subdistrict">Kecamatan</option>
                                <option value="village">Desa / Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortBy">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="province">Provinsi</option>
                                <option value="regency">Kabupaten / Kota</option>
                                <option value="subdistrict">Kecamatan</option>
                                <option value="village">Desa / Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Tambah Wilayah --->
<div class="modal fade" id="ModalTambahWilayah" tabindex="-1" aria-labelledby="ModalTambahWilayah" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahWilayah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Wilayah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Provinsi -->
                    <div class="row mb-3">
                        <div class="col-12">
                           <small><b>Provinsi</b></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-mb-6 mb-3">
                            <label for="province"><small>Nama Provinsi</small></label>
                            <select name="province" id="province" class="form-control" required>
                               <option value="">- Pilih -</option>
                            </select>
                        </div>
                         <!-- kode_mendagri_1 -->
                        <div class="col-mb-6 mb-3">
                            <label for="kode_mendagri_1"><small>* Kode Provinsi (Mendagri)</small></label>
                            <div class="input-group">
                                <input type="text" name="kode_mendagri_1" id="kode_mendagri_1" class="form-control">
                                <span class="input-group-text" id="search_kode_mendagri_1" title="Cari Kode Mendagri">
                                    <i class="bi bi-search"></i>
                                </span>
                            </div>
                            <small id="notifikasi_kode_mendagri_1"></small>
                        </div>
                    </div>
                    <hr>

                    <!-- regency -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <small><b>Kabupaten / Kota</b></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipe_level2"><small>Tipe Wilayah Kab/Kot</small></label>
                            <select name="tipe_level2" id="tipe_level2" class="form-control" disabled>
                                <option value="">-Pilih Tipe-</option>
                                <option value="Kabupaten">Kabupaten</option>
                                <option value="Kota">Kota</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="regency"><small>Nama Kabupaten / Kota</small></label>
                            <select name="regency" id="regency" class="form-control" required disabled>
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="kode_mendagri_2"><small>* Kode Kabupaten / Kota (Mendagri)</small></label>
                            <div class="input-group">
                                <input type="text" name="kode_mendagri_2" id="kode_mendagri_2" class="form-control" disabled>
                                <span class="input-group-text" id="search_kode_mendagri_2" title="Cari Kode Mendagri">
                                    <i class="bi bi-search"></i>
                                </span>
                            </div>
                            <small id="notifikasi_kode_mendagri_2"></small>
                        </div>
                    </div>
                    <hr>

                    <!-- subdistrict -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <small><b>Kecamatan</b></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="subdistrict"><small>Kecamatan</small></label>
                            <select name="subdistrict" id="subdistrict" class="form-control" required disabled>
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="kode_mendagri_3"><small>* Kode Kecamatan (Mendagri)</small></label>
                            <div class="input-group">
                                <input type="text" name="kode_mendagri_3" id="kode_mendagri_3" class="form-control" disabled>
                                <span class="input-group-text" id="search_kode_mendagri_3" title="Cari Kode Mendagri">
                                    <i class="bi bi-search"></i>
                                </span>
                            </div>
                             <small id="notifikasi_kode_mendagri_3"></small>
                        </div>
                    </div>
                    <hr>

                    <!-- village -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <small><b>Desa / Kelurahan</b></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="tipe_level4"><small>Tipe Desa / Kelurahan</small></label>
                            <select name="tipe_level4" id="tipe_level4" class="form-control" disabled>
                                <option value="">- Pilih Tipe - </option>
                                <option value="Desa">Desa</option>
                                <option value="Kelurahan">Kelurahan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="village"><small>Nama Desa / Kelurahan</small></label>
                            <input type="text" name="village" id="village" class="form-control" required disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="kode_mendagri_4"><small>* Kode Desa / Kelurahan (Mendagri)</small></label>
                            <div class="input-group">
                                <input type="text" name="kode_mendagri_4" id="kode_mendagri_4" class="form-control" disabled>
                                <span class="input-group-text" id="search_kode_mendagri_4" title="Cari Kode Mendagri">
                                    <i class="bi bi-search"></i>
                                </span>
                            </div>
                             <small id="notifikasi_kode_mendagri_4"></small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahWilayah">
                           <!-- Notifikasi Tambah Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahWilayah">
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

<!--- Modal Download Wilayah --->
<div class="modal fade" id="ModalDownload" tabindex="-1" aria-labelledby="ModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesDownload" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Download Referensi Wilayah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormDownload">
                           <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiDownload">
                           <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonDownload">
                        <i class="bi bi-download"></i> Download
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload Wilayah -->
<div class="modal fade" id="ModalUpload" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="ProsesUpload" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-upload"></i> Upload Wilayah
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Info -->
                    <div class="alert alert-info">
                        <small>
                            <b>PENTING :</b> Download template
                            <a href="_Page/ReferensiWilayah/wilayah_tmp.xlsx" target="_blank" class="text-primary">
                                <b>disini</b>
                            </a>
                        </small>
                    </div>

                    <!-- Upload -->
                    <div class="mb-3">
                        <label class="form-label">
                            <small>Upload File Excel</small>
                        </label>
                        <input type="file" name="file_upload" id="file_upload" class="form-control">
                        <small class="text-muted">
                            Maksimal 10MB (.xlsx)
                        </small>
                    </div>

                    <!-- Progress -->
                    <div id="progressContainer" class="d-none">
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                id="progressBar"
                                style="width:0%">
                                0%
                            </div>
                        </div>
                        <small id="progressText" class="text-muted">
                            Menunggu proses...
                        </small>
                    </div>

                    <!-- Notifikasi -->
                    <div id="NotifikasiUpload"></div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ButtonUpload">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!--- Modal Detail Wilayah --->
<div class="modal fade" id="ModalDetailWilayah" tabindex="-1" aria-labelledby="ModalDetailWilayah" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Wilayah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailWilayah">
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

<!-- DESA -->
<div class="modal fade" id="ModalEditDesa" tabindex="-1" aria-labelledby="ModalEditDesa" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditDesa" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Wilayah Desa/Kelurahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditDesa">
                           <!-- Form Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditDesa">
                           <!-- Notifikasi Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditDesa">
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

<div class="modal fade" id="ModalHapusDesa" tabindex="-1" aria-labelledby="ModalHapusDesa" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusDesa" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Wilayah Desa/Kelurahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusDesa">
                            <!-- Form Hapus Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusDesa">
                            <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusDesa">
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

<!-- KECAMATAN -->
<div class="modal fade" id="ModalEditKecamatan" tabindex="-1" aria-labelledby="ModalEditKecamatan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditKecamatan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Wilayah Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditKecamatan">
                           <!-- Form Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditKecamatan">
                           <!-- Notifikasi Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditKecamatan">
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

<div class="modal fade" id="ModalHapusKecamatan" tabindex="-1" aria-labelledby="ModalHapusKecamatan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusKecamatan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Wilayah Desa/Kelurahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusKecamatan">
                            <!-- Form Hapus Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikassiHapusKecamatan">
                            <!-- Notifikasi Hapus Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusKecamatan">
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

<!-- KABUPATEN / KOTA -->
<div class="modal fade" id="ModalEditKabupaten" tabindex="-1" aria-labelledby="ModalEditKabupaten" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditKabupaten" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Wilayah Kabupaten/Kota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditKabupaten">
                           <!-- Form Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditKabupaten">
                           <!-- Notifikasi Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditKabupaten">
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

<div class="modal fade" id="ModalHapusKabupaten" tabindex="-1" aria-labelledby="ModalHapusKabupaten" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusKabupaten" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Wilayah Kabupaten/Kota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusKabupaten">
                            <!-- Form Hapus Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusKabupaten">
                            <!-- Notifikasi Hapus Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusKabupaten">
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

<!-- PROVINSI -->
<div class="modal fade" id="ModalEditProvinsi" tabindex="-1" aria-labelledby="ModalEditProvinsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditProvinsi" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Wilayah Provinsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditProvinsi">
                           <!-- Form Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditProvinsi">
                           <!-- Notifikasi Edit Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditProvinsi">
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

<div class="modal fade" id="ModalHapusProvinsi" tabindex="-1" aria-labelledby="ModalHapusProvinsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusProvinsi" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Wilayah Provinsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusProvinsi">
                            <!-- Form Hapus Wilayah Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusProvinsi">
                            <!-- Notifikasi Hapus Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusProvinsi">
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
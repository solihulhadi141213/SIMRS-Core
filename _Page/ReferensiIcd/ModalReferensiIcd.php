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
                                <option value="kode">Kode</option>
                                <option value="long_des">Long Description</option>
                                <option value="short_des">Short Description</option>
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
                                <option value="kode">Kode</option>
                                <option value="long_des">Long Description</option>
                                <option value="short_des">Short Description</option>
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
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="icd_version">
                                <small>ICD / Versi</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" readonly name="icd_version" id="icd_version" class="form-control bg-secondary-subtle form_icd_version">
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
                            <label for="icd"><small>ICD / Version</small></label>
                            <input type="text" readonly name="icd" id="icd" class="form-control bg-secondary-subtle input_icd_version">
                        </div>
                    </div>

                    <!-- Kode -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode"><small>Kode ICD</small></label>
                            <input type="text" name="kode" id="kode" class="form-control" required>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="short_des"><small><i>Short Description</i></small></label>
                            <input type="text" name="short_des" id="short_des" class="form-control" required>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="long_des"><small><i>Long Description</i></small></label>
                            <textarea name="long_des" id="long_des" class="form-control" required></textarea>
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

<!--- Modal Edit ICD --->
<div class="modal fade" id="ModalEditIcd" tabindex="-1" aria-labelledby="ModalEditIcd" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditIcd" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit ICD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormEditIcd">
                           <!-- Notifikasi Edit  Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiEditIcd">
                           <!-- Notifikasi Edit  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditIcd">
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

<!--- Modal Hapus ICD --->
<div class="modal fade" id="ModalHapusIcd" tabindex="-1" aria-labelledby="ModalHapusIcd" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusIcd" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus ICD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormHapusIcd">
                           <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusIcd">
                           <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusIcd">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Download ICD --->
<div class="modal fade" id="ModalDownload" tabindex="-1" aria-labelledby="ModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesDownload" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Download ICD</h5>
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

<!--- Modal Upload ICD --->
<!-- Modal Upload ICD -->
<div class="modal fade" id="ModalUpload" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="ProsesUpload" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-upload"></i> Upload ICD
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Info -->
                    <div class="alert alert-info">
                        <small>
                            <b>PENTING :</b>
                            Download template
                            <a href="_Page/ReferensiIcd/icd_tmp.xlsx" target="_blank">
                                disini
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
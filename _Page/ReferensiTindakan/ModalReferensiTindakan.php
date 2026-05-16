<!-- Filter Data -->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page_filter" id="page_filter" value="1">
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
                                <option value="kategori_tindakan">Kategori</option>
                                <option value="kategori_tindakan_code">Kategori (Code)</option>
                                <option value="kategori_tindakan_display">Kategori (Display)</option>
                                <option value="nama_tindakan">Tindakan</option>
                                <option value="nama_tindakan_code">Tindakan (Code)</option>
                                <option value="nama_tindakan_display">Tindakan (Display)</option>
                                <option value="lokasi_tubuh">Lokasi Tubuh</option>
                                <option value="lokasi_tubuh_code">Lokasi Tubuh (Code)</option>
                                <option value="lokasi_tubuh_display">Lokasi Tubuh (Display)</option>
                                <option value="icd9_code">ICD9 (Code)</option>
                                <option value="icd9_description">ICD9 (Description)</option>
                                <option value="status">Status</option>
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
                                <option value="kategori_tindakan">Kategori</option>
                                <option value="kategori_tindakan_code">Kategori (Code)</option>
                                <option value="kategori_tindakan_display">Kategori (Display)</option>
                                <option value="nama_tindakan">Tindakan</option>
                                <option value="nama_tindakan_code">Tindakan (Code)</option>
                                <option value="nama_tindakan_display">Tindakan (Display)</option>
                                <option value="lokasi_tubuh">Lokasi Tubuh</option>
                                <option value="lokasi_tubuh_code">Lokasi Tubuh (Code)</option>
                                <option value="lokasi_tubuh_display">Lokasi Tubuh (Display)</option>
                                <option value="icd9_code">ICD9 (Code)</option>
                                <option value="icd9_description">ICD9 (Description)</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_form">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword_form" class="form-control">
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

<!-- Tambah Referensi Tindakan -->
<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Referensi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form_kategori_tindakan mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>A. Kategori Tindakan</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="kategori_tindakan"><small>Kategori Tindakan</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <select name="kategori_tindakan" id="kategori_tindakan" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="kategori_tindakan_code"><small><i>Code</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="kategori_tindakan_code" id="kategori_tindakan_code" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="kategori_tindakan_display"><small><i>Display</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="kategori_tindakan_display" id="kategori_tindakan_display" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="kategori_tindakan_system"><small><i>System</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="kategori_tindakan_system" id="kategori_tindakan_system" class="form-control" value="http://snomed.info/sct">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form_jenis_tindakan mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>B. Nama/Jenis Tindakan</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="nama_tindakan"><small>Nama Tindakan</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="nama_tindakan" id="nama_tindakan" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="nama_tindakan_code"><small><i>Code</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="nama_tindakan_code" id="nama_tindakan_code" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="nama_tindakan_display"><small><i>Display</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="nama_tindakan_display" id="nama_tindakan_display" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="nama_tindakan_system"><small><i>System</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="nama_tindakan_system" id="nama_tindakan_system" class="form-control" value="http://snomed.info/sct">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form_lokasi_tubuh mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>C. Lokasi Tubuh (<i>Body Site</i>)</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="lokasi_tubuh"><small>Nama Lokasi Tubuh (<i>Body Site</i>)</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <select name="lokasi_tubuh" id="lokasi_tubuh" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="lokasi_tubuh_code"><small><i>Code</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="lokasi_tubuh_code" id="lokasi_tubuh_code" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="lokasi_tubuh_display"><small><i>Display</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="lokasi_tubuh_display" id="lokasi_tubuh_display" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="lokasi_tubuh_system"><small><i>System</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="lokasi_tubuh_system" id="lokasi_tubuh_system" class="form-control" value="http://snomed.info/sct">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form_icd9 mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>D. ICD9</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="icd9_code"><small>ICD9 Code</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <select name="icd9_code" id="icd9_code" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><label for="icd9_description"><small><i>ICD9 Description</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <input type="text" name="icd9_description" id="icd9_description" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambah">
                            <!-- Notifikasi Tambah -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambah">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--- Modal Detail --->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_detail">
                    <i class="bi bi-info-circle"></i> Detail Tindakan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetail">
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

<!--- Modal Edit --->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Referensi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormEdit">
                           <!-- Notifikasi Edit  Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiEdit">
                           <!-- Notifikasi Edit  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEdit">
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

<!--- Modal Hapus --->
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Referensi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormHapus">
                           <!-- Form Hapus Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiHapus">
                           <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapus">
                        <i class="bi bi-check"></i> Hapus Referensi
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Recovery --->
<div class="modal fade" id="ModalRecovery" tabindex="-1" aria-labelledby="ModalRecovery" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesRecovery" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-repeat"></i> Recovery Referensi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormRecovery">
                           <!-- Form Recovery Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiRecovery">
                           <!-- Notifikasi Recovery  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonRecovery">
                        <i class="bi bi-repeat"></i> Recovery Referensi
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Download --->
<div class="modal fade" id="ModalDownload" tabindex="-1" aria-labelledby="ModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/ReferensiTindakan/ProsesExport.php" method="GET" target="_blank" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Download/Export Referensi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <small>
                                    <b>PENTING</b><br>
                                    Semakin banyak data referensi tindakan yang tersedia maka sistem akan membutuhkan waktu lebih lama untuk memproses permintaan anda.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary">
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
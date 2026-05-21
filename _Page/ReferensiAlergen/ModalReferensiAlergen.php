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
                                <option value="kategori_alergen">Kategori</option>
                                <option value="nama_alergen">Alergen</option>
                                <option value="code_alergen">Code</option>
                                <option value="display_alergen">Display</option>
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
                                <option value="kategori_alergen">Kategori</option>
                                <option value="nama_alergen">Alergen</option>
                                <option value="code_alergen">Code</option>
                                <option value="display_alergen">Display</option>
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

<!-- Tambah -->
<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Referensi Alergen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-126">
                            <label for="kategori_alergen"><small>Kategori Alergen</small></label>
                            <select name="kategori_alergen" id="kategori_alergen" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Food">Makanan (Food)</option>
                                <option value="Medication">Obat (Medication)</option>
                                <option value="Environment">Alergen Lingkungan (Environment)</option>
                                <option value="Biologic">Biologis (Biologic)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-126">
                            <label for="nama_alergen"><small>Nama/Jenis Alergen</small></label>
                            <input type="text" name="nama_alergen" id="nama_alergen" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-126">
                            <label for="code_alergen"><small>Kode Alergen (<i>Code</i>)</small></label>
                            <input type="text" name="code_alergen" id="code_alergen" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-126">
                            <label for="display_alergen"><small>Deskripsi (<i>Display</i>)</small></label>
                            <input type="text" name="display_alergen" id="display_alergen" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-126">
                            <label for="system_alergen"><small>Referensi (<i>System</i>)</small></label>
                            <input type="text" name="system_alergen" id="system_alergen" class="form-control" value="http://snomed.info/sct">
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
                    <i class="bi bi-info-circle"></i> Detail Referensi Alergen
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
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Referensi Alergen</h5>
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
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Referensi Alergen</h5>
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


<!--- Modal Download --->
<div class="modal fade" id="ModalDownload" tabindex="-1" aria-labelledby="ModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/ReferensiAlergen/ProsesExport.php" method="GET" target="_blank" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Download/Export Referensi Alergen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <small>
                                    <b>PENTING</b><br>
                                    Semakin banyak data referensi yang tersedia maka sistem akan membutuhkan waktu lebih lama untuk memproses permintaan anda.
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

<!--- Modal Upload --->
<div class="modal fade" id="ModalUpload" tabindex="-1" aria-labelledby="ModalUpload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesUpload" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Upload/Export Referensi Alergen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <small><b>Petunjuk Penggunaan</b></small><br>
                            <ol>
                                <li>
                                    <small>
                                        Download template file excel <a href="_Page/ReferensiAlergen/TemplateAlergen.xlsx" target="_blank" class="text-primary text-decoration-underline">berikut ini.</a>
                                    </small>
                                </li>
                                <li><small>Isi template dengan data yang akan diimport ke database</small></li>
                                <li><small>Simpan (Save) perubahan pada file tersebut, kemudian brows pada form halaman ini</small></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="file_alergen">
                                <small>Upload File Excel</small>
                           </label>
                           <input type="file" name="file_alergen" id="file_alergen" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiUpload">
                           <!-- Notifikasi Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonUpload">
                        <i class="bi bi-upload"></i> Upload / Import
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
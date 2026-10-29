<!-- filter -->
<div class="modal fade" id="ModalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page_filter" id="page_filter" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-search"></i> Filter Referensi Imunisasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Atur jumlah baris yang akan dimuat pada setiap halaman tabel. -->
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas"><small>Limit</small></label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <!-- Tentukan kolom dan arah pengurutan hasil tabel. -->
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="OrderBy"><small>Dasar Urutan</small></label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_imunisasi_referensi">ID Referensi</option>
                                <option value="nama_vaksin">Nama Vaksin</option>
                                <option value="kode_cvx">Kode CVX</option>
                                <option value="kode_kemenkes">Kode Kemenkes</option>
                                <option value="display_vaksin">Display</option>
                                <option value="system_vaksin">System</option>
                                <option value="target_penyakit">Target Penyakit</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortBy"><small>Tipe Urutan</small></label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option value="DESC" selected>Z To A</option>
                            </select>
                        </div>
                    </div>
                    <!-- Pilih kolom pencarian; kontrol kata kunci di bawahnya menyesuaikan pilihan ini. -->
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_by"><small>Dasar Pencarian</small></label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama_vaksin">Nama Vaksin</option>
                                <option value="kode_cvx">Kode CVX</option>
                                <option value="kode_kemenkes">Kode Kemenkes</option>
                                <option value="display_vaksin">Display</option>
                                <option value="system_vaksin">System</option>
                                <option value="target_penyakit">Target Penyakit</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_form"><small>Kata Kunci</small></label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword_form" class="form-control">
                        </div>
                    </div>
                    <!-- Pesan kegagalan pemuatan kontrol filter ditampilkan pada modal ini. -->
                    <div class="row">
                        <div class="col-12" id="NotifikasiFilter"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- TAMBAH REFERENSI IMUNISASI -->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_form_antrian">
                        <i class="bi bi-plus"></i> Tambah Referensi Imunisasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">

                    <!-- Nama Vaksin -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama_vaksin"><small>Nama Vaksin </small> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama_vaksin" id="nama_vaksin" class="form-control">
                        </div>
                    </div>

                    <!-- Kode CVX -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode_cvx"><small>Kode CVX </small></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kode_cvx" id="kode_cvx" class="form-control">
                        </div>
                    </div>

                    <!-- Kode Kemenkes -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode_kemenkes">
                                <small>Kode Kemenkes</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kode_kemenkes" id="kode_kemenkes" class="form-control">
                        </div>
                    </div>

                    <!-- Display Vaksin -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="display_vaksin">
                                <small><i>Display</i> Vaksin</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="display_vaksin" id="display_vaksin" class="form-control">
                        </div>
                    </div>

                    <!-- System Vaksin -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="system_vaksin">
                                <small><i>System</i> Vaksin</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="system_vaksin" id="system_vaksin" class="form-control">
                        </div>
                    </div>

                    <!-- Target Penyakit -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="target_penyakit">
                                <small>Target Penyakit</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="target_penyakit" id="target_penyakit" class="form-control">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="status_vaksin">
                                <small>Status</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input js-mode-pasien" type="radio" name="status" id="status_inactive" value="0">
                                    <label class="form-check-label" for="status_inactive">
                                        <small>Inactive</small>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input js-mode-pasien" type="radio" name="status" id="status_active" value="1" checked>
                                    <label class="form-check-label" for="status_active">
                                        <small>Active</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi Tambah -->
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambah">
                            <!-- Notifikasi Kesalahan Pada Proses Tambah Akan Ditampilkan Di Sini. -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ButtonTambah">
                        <i class="bi bi-floppy"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL REFERENSI IMUNISASI -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Referensi Imunisasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat data...</div>
                        <!-- Detail Imunisasi Akan Ditampilkan Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="judul_edit_antrian" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Edit Referensi Imunisasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormEdit">
                            <div class="text-center text-muted py-4">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat form edit...
                            </div>
                            <!-- Form Edit Akan Ditampilkan Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Proses Edit Akan Ditampilkan Disini Tanpa Menutup Modal. -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ButtonEdit">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="judul_hapus_antrian" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-trash"></i> Hapus Referensi Imunisasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapus">
                            <div class="text-center text-muted py-3">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat detail ...
                            </div>
                            <!-- Form Hapus Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus AKan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapus">
                        <i class="bi bi-check"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL EXPORT -->
<div class="modal fade" id="ModalExport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="_Page/ReferensiImunisasi/ProsesExport.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-download"></i> Export Referensi Imunisasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_data">
                                <small>Periode Data</small>
                            </label>
                            <select name="periode_data" id="periode_data" class="form-control">
                                <option selected value="Semua">Semua Periode</option>
                                <option value="Tahun">Tahun</option>
                                <option value="Bulan">Bulan</option>
                                <option value="Periodik">Periodik</option>
                            </select>
                        </div>
                    </div>
                    <div id="FormLanjutanExport">
                        <!-- Form Lanjutan Filter Data Antrian Yang Akan Di export -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiJumlahDataExport">
                            <!-- Informasi Jumlah Data yang Akan Di Export Akan Ditampilkan Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonExport">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL IMPORT -->
<div class="modal fade" id="ModalImport" tabindex="-1" aaria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesImport" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-upload"></i> Form Import
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <small>
                                    <b>CARA IMPORT DATA :</b><br>
                                    <ol>
                                        <li>File yang digunakan adalah file <i>Excel</i>. </li>
                                        <li>
                                            Download templatenya pada tautan 
                                            <a href="_Page\ReferensiImunisasi\Referensi-imunisasi.xlsx" target="_blank"> 
                                                <b>berikut ini.</b>
                                            </a> 
                                        </li>
                                        <li>
                                             Maksimal file yang diimport adalah sebesar 5 Mb.
                                        </li>
                                    </ol>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="import_file">
                                <small>Upload File</small>
                            </label>
                            <input type="file" name="import_file" id="import_file" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiImport">
                            <!-- Notifikasi import AKan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonImport">
                        <i class="bi bi-upload"></i> Import
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                                <option value="episode_category">Kategori</option>
                                <option value="episode_name">Nama Episode Perawatan</option>
                                <option value="episode_display">Display</option>
                                <option value="episode_code">Kode</option>
                                <option value="episode_system">System</option>
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
                                <option value="episode_category">Kategori</option>
                                <option value="episode_name">Nama Episode Perawatan</option>
                                <option value="episode_display">Display</option>
                                <option value="episode_code">Kode</option>
                                <option value="episode_system">System</option>
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
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Kode Episode Perawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="episode_category">
                                <small>Kategori Episode Perawatan</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="episode_category" id="episode_category" class="form-control" required>
                                <option value="">Pilih / Ketik Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="episode_name">
                                <small>Nama Episode Perawatan</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="episode_name" id="episode_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="episode_display">
                                <small><i>Display</i></small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="episode_display" id="episode_display" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="episode_code">
                                <small><i>Code</i></small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="episode_code" id="episode_code" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="episode_system">
                                <small>Referensi (<i>System</i>)</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="episode_system" id="episode_system" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="source">
                                <small>Sumber Referensi</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="source" id="source" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="status">
                                <small>Status</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="status" id="status" class="form-control" required>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
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
                    <i class="bi bi-info-circle"></i> Detail Kode Episode Perawatan
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
                <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i> Tutup
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
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Episode Perawatan</h5>
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
                        <i class="bi bi-floppy"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
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
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Episode Perawatan</h5>
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
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--- Modal Export --->
<div class="modal fade" id="ModalExport" tabindex="-1" aria-labelledby="ModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="_Page\ReferensiEpisodePerawatan\ProsesExport.php" method="GET" target="_blank" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Download/Export Referensi Episode Perawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <small>
                                    <b>PENTING</b><br>
                                    Semakin banyak data referensi yang tersedia maka sistem akan membutuhkan waktu lebih lama 
                                    untuk memproses permintaan anda.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary">
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

<!--- Modal Import --->
<div class="modal fade" id="ModalImport" tabindex="-1" aria-labelledby="ModalImport" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesUpload" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-upload"></i> Upload/Export Referensi Episode Perawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <small><b>Petunjuk Penggunaan</b></small><br>
                            <ol>
                                <li>
                                    <small>
                                        Download template file excel <a href="_Page/ReferensiEpisodePerawatan/TemplateEpisodePerawatan.xlsx" target="_blank" class="text-primary text-decoration-underline">berikut ini.</a>
                                    </small>
                                </li>
                                <li><small>Isi template dengan data yang akan diimport ke database</small></li>
                                <li><small>Simpan (Save) perubahan pada file tersebut, kemudian brows pada form halaman ini</small></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="file_episode_perawatan">
                                    <small>Upload File Excel</small>
                            </label>
                            <input type="file" name="file_episode_perawatan" id="file_episode_perawatan" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiImport">
                        <!-- Notifikasi Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonImport">
                        <i class="bi bi-upload"></i> Upload / Import
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
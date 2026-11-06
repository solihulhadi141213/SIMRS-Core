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
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="episode_name">Episode Perawatan</option>
                                <option value="id_dokter">Dokter</option>
                                <option value="date_start">Tanggal Mulai</option>
                                <option value="status">Status</option>
                                <option value="IdEpisodeOfCare">ID Episode Perawatan</option>
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
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="episode_name">Episode Perawatan</option>
                                <option value="id_dokter">Dokter</option>
                                <option value="date_start">Tanggal Mulai</option>
                                <option value="status">Status</option>
                                <option value="IdEpisodeOfCare">ID Episode Perawatan</option>
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


<!-- MODAL TAMBAH -->
<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah">
                <div class="modal-header">
                    <h5 class="modal-title text-primary"><i class="bi bi-plus"></i> Tambah Episode Perawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- ID pasien -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_pasien">ID/Nama Pasien <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="FormIdPasien">
                            <select name="id_pasien" id="id_pasien" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kode Episode Perawatan -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_episode_perawatan_kode">Nama Episode Perawatan <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="FormKodeEpisodePerawatan">
                            <select name="id_episode_perawatan_kode" id="id_episode_perawatan_kode" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                            <small class="text-muted">Referensi episode perawatan sepenuhnya dikelola petugas rekam medis.</small>
                        </div>
                    </div>

                    <!-- Diagnosis Pasien -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_diagnosis">Diagnosis Pasien <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="FormDiagnosis">
                            <select name="id_diagnosis" id="id_diagnosis" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                            <small class="text-muted">Hubungkan dengan diagnosis pasien</small>
                        </div>
                    </div>

                    <!-- Dokter DPJP -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_dokter">Dokter DPJP <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="FormDokterDPJP">
                            <select name="id_dokter" id="id_dokter" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                            <small class="text-muted">Dokter yang memberikan pernyataan</small>
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="date_start">Tanggal Mulai <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="date_start" id="date_start" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="status">Status <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="FormStatus">
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="planned">Direncanakan</option>
                                <option value="waitlist">Menunggu</option>
                                <option value="active">Aktif</option>
                                <option value="onhold">Ditahan</option>
                                <option value="finished">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                                <option value="entered-in-error">Kesalahan Entry</option>
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

<!-- MODAL DETAIL -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Episode Perawatan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <div class="text-center text-muted py-4">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat data...
                        </div>
                        <!-- Detail Akan Ditampilkan Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PASIEN -->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Pasien
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailPasien">
                        <div class="text-center text-muted py-4">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat data...
                        </div>
                        <!-- Detail Akan Ditampilkan Disini -->
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
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Edit Episode Perawatan
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
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-trash"></i> Hapus Episode Perawatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapus">
                            <div class="text-center text-muted py-3">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat detail...
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
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonHapus">
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

<!-- MODAL KIRIM -->
<div class="modal fade" id="ModalKirim" tabindex="-1" aria-labelledby="ModalKirim" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesKirim" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-send"></i> Kirim Episode Of Care
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormKirim">
                            <div class="text-center text-muted py-3">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat detail...
                            </div>
                            <!-- Form Kirim Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiKirim">
                            <!-- Notifikasi Kirim AKan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonKirim">
                        <i class="bi bi-send"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL SATUSEHAT -->
<div class="modal fade" id="ModalDetailEpisodeOfCare" tabindex="-1" aria-labelledby="ModalDetailEpisodeOfCare" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Episode Of Care
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12" id="FormDetailEpisodeOfCare">
                        <div class="text-center text-muted py-3">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                            Memuat detail...
                        </div>
                        <!-- Form Detail Satusehat Akan Muncul Disini -->
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

<!--- Modal Export --->
<div class="modal fade" id="ModalExport" tabindex="-1" aria-labelledby="ModalExport" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/EpisodePerawatan/ProsesExport.php" method="POST" target="_blank" id="ProsesExport" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Export Episode Perawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Periode Awal -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="periode_awal">Periode Awal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="periode_awal" id="periode_awal">
                        </div>
                    </div>

                    <!-- Periode Akhir -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="periode_akhir">Periode Akhir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="periode_akhir" id="periode_akhir">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <b>PENTING!</b><br>
                                <small>Semakin besar data yang diexport maka sistem akan membutuhkan waktu lebih lama.</small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonExport">
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


<!-- filter -->
<div class="modal fade" id="ModalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page_filter" id="page_filter" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-search"></i> Filter Antrian
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
                                <option value="datetime_creat">Tanggal daftar</option>
                                <option value="nama_pasien">Nama pasien</option>
                                <option value="kode_booking">Kode booking</option>
                                <option value="tanggal_kunjungan">Rencana kunjungan</option>
                                <option value="nama_poliklinik">Poliklinik</option>
                                <option value="nama_dokter">Dokter</option>
                                <option value="jadwal">Jadwal</option>
                                <option value="no_antrian">Nomor antrian</option>
                                <option value="id_pasien">Nomor RM</option>
                                <option value="id_kunjungan">Kunjungan</option>
                                <option value="status_antrian">Status</option>
                                <option value="sumber_antrian">Sumber</option>
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
                                <option value="">Semua kolom</option>
                                <option value="nama_pasien">Nama pasien</option>
                                <option value="kode_booking">Kode booking</option>
                                <option value="datetime_creat">Tanggal daftar</option>
                                <option value="tanggal_kunjungan">Rencana kunjungan</option>
                                <option value="nama_poliklinik">Poliklinik</option>
                                <option value="nama_dokter">Dokter</option>
                                <option value="jadwal">Jadwal</option>
                                <option value="no_antrian">Nomor antrian</option>
                                <option value="id_pasien">Nomor RM</option>
                                <option value="id_kunjungan">Kunjungan</option>
                                <option value="sumber_antrian">Sumber</option>
                                <option value="status_antrian">Status</option>
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

<!-- TAMBAH ANTRIAN -->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="FormAntrian" class="js-form-simpan-antrian" autocomplete="off">
                <input type="hidden" name="id_antrian" id="antrian_id" value="">
                <input type="hidden" name="id_pasien" id="antrian_id_pasien" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_form_antrian">
                        <i class="bi bi-plus-circle"></i> Tambah Antrian Manual
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">

                    <!-- Group Form pasien -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                <b>A. Data Pasien</b>
                            </small>
                        </div>
                    </div>
                    <!-- Jenis Pasien -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label><small>Jenis Pasien</small></label>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input js-mode-pasien" type="radio" name="jenis_request" id="pasien_lama" value="0" checked>
                                    <label class="form-check-label" for="pasien_lama">
                                        <small>Pasien Lama</small>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input js-mode-pasien" type="radio" name="jenis_request" id="pasien_baru" value="1">
                                    <label class="form-check-label" for="pasien_baru">
                                        <small>Pasien Baru</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pencarian Pasien -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label><small>No.RM</small></label>
                        </div>
                        <div class="col-md-8" id="select_id_pasien">
                            <select name="id_pasien" id="id_pasien" class="form-control">
                                <option value="">Pilih Pasien</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Pasien -->
                     <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama_pasien">
                                <small>Nama Pasien</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama_pasien" id="nama_pasien" class="form-control" maxlength="255" required>
                        </div>
                     </div>

                    <!-- Gender -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="gender_antrian">
                                <small>Jenis Kelamin</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="gender" id="gender_antrian" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- NIK -->
                     <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nik_antrian">
                                <small>Nomor Induk Kependudukan (NIK)</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nik" id="nik_antrian" class="form-control" maxlength="16" inputmode="numeric">
                        </div>
                    </div>

                    <!-- Nomor BPJS -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="no_bpjs_antrian">
                                <small>Nomor BPJS</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="no_bpjs" id="no_bpjs_antrian" class="form-control" maxlength="13" inputmode="numeric">
                        </div>
                    </div>
                    <!-- Kontak -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak_antrian">
                                <small>Kontak</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kontak" id="kontak_antrian" class="form-control" maxlength="20" inputmode="tel">
                        </div>
                    </div>

                    <!-- Group Form pasien -->
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <small>
                                <b>B. Data Antrian</b>
                            </small>
                        </div>
                    </div>

                    <!-- Tanggal Rencana Kunjungan -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_kunjungan">
                                <small>Tanggal Rencana Kunjungan</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control" required>
                        </div>
                    </div>

                    <!-- Poliklinik -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_poliklinik">
                                <small>Poliklinik</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_poliklinik" id="id_poliklinik" class="form-select" required>
                                <option value="">Pilih poliklinik</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dokter -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_dokter">
                                <small>Dokter</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_dokter" id="id_dokter" class="form-select" required>
                                <option value="">Pilih Dokter</option>
                            </select>
                        </div>
                    </div>

                    <!-- Jadwal Praktek -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_jadwal">
                                <small>Jadwal Praktek</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_jadwal" id="id_jadwal" class="form-select" required>
                                <option value="">Pilih Jadwal</option>
                            </select>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="pembayaran">
                                <small>Metode Pembayaran</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="pembayaran" id="pembayaran" class="form-select" required>
                                <option value="UMUM">UMUM</option>
                                <option value="BPJS">BPJS</option>
                                <option value="ASURANSI">ASURANSI</option>
                            </select>
                        </div>
                    </div>

                    <!-- Jenis Referensi -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jenis_referensi">
                                <small>Jenis Referensi</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="jenis_referensi" id="jenis_referensi" class="form-select">
                                <option value="">Pilih Jenis Referensi</option>
                                <option value="1">Rujukan FKTP</option>
                                <option value="2">Rujukan Internal</option>
                                <option value="3">Kontrol</option>
                                <option value="4">Rujukan Antar RS</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nomor Referensi -->
                     <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nomor_referensi">
                                <small>Nomor Referensi</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" readonly name="nomor_referensi" id="nomor_referensi" class="form-control" maxlength="255">
                        </div>
                     </div>

                     <!-- Keluhan Pasien -->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="keluhan_antrian">
                                <small>Keluhan</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="keluhan" id="keluhan_antrian" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <!-- Notifikasi Tambah Antrian -->
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiAntrian">
                            <!-- Notifikasi Kesalahan Pada Proses Tambah Antrian Akan Ditampilkan Di Sini. -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ButtonTambahAntrian">
                        <i class="bi bi-floppy"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL ANTRIAN -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Antrian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat data...</div>
                        <!-- Detail Antrian Akan Ditampilkan Disini -->
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
                    <h5 class="modal-title" id="judul_edit_antrian">
                        <i class="bi bi-pencil-square"></i> Edit Data Antrian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormEdit">
                            <div class="text-center text-muted py-4">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat form edit antrian...
                            </div>
                            <!-- Form Edit Antrian Akan Ditampilkan Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 js-antrian-notification" id="NotifikasiEdit">
                            <!-- Notifikasi Proses Edit Antrian Akan Ditampilkan Disini Tanpa Menutup Modal. -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary js-simpan-antrian" id="SimpanEditAntrian">
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
                    <h5 class="modal-title" id="judul_hapus_antrian">
                        <i class="bi bi-trash"></i> Hapus Antrian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapus">
                            <div class="text-center text-muted py-3">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat detail antrian...
                            </div>
                            <!-- Form Hapus Antrian Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiHapusAntrian">
                            <!-- Notifikasi Hapus AKan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonHapusAntrian">
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

<!-- MODAL DAFTAR PASIEN BARU -->
<div class="modal fade" id="ModalPendaftaranPasien" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPendaftaranPasien" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus"></i> Pendaftaran Pasien Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormPendaftaranPasien">
                            <!-- Notifikasi Pendaftaran pasien Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiPendaftaranPasien">
                            <!-- Notifikasi Pendaftaran pasien Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-primary" id="ButtonPendaftaranPasien">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                       <i class="bi bi-x"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PASIEN -->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Pasien
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12" id="FormDetailPasien">
                        <!-- Detail Pasien Akan Muncul Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENDAFTARAN KUNJUNGAN -->
<div class="modal fade" id="ModalPendaftaranKunjungan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPendaftaranKunjungan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus"></i> Pendaftaran Kunjungan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormPendaftaranKunjungan">
                            <!-- Notifikasi Pendaftaran Kunjungan Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiPendaftaranKunjungan">
                            <!-- Notifikasi Pendaftaran Kunjungan Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ButtonPendaftaranKunjungan">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                       <i class="bi bi-x"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL DETAIL KUNJUNGAN -->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Kunjungan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12" id="FormDetailKunjungan">
                        <!-- Detail Pasien Akan Muncul Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EXPORT ANTRIAN -->
<div class="modal fade" id="ModalExportAntrian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page\Antrian\ProsesExportAntrian.php" method="POST" target="_blank" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-download"></i> Export Data Antrian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
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
                        <div class="col-12" id="NotifikasiJumlahDataAntrian">
                            <!-- Informasi Jumlah Data yang Akan Di Export Akan Ditampilkan Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" disabled id="ButtonExport">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                       <i class="bi bi-x"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
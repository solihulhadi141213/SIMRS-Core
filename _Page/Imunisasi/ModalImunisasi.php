<!-- filter -->
<div class="modal fade" id="ModalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page_filter" id="page_filter" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-search"></i> Filter Imunisasi
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
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="tanggal_pemberian">Tanggal Pemberian</option>
                                <option value="nama_vaksin">Nama Vaksin</option>
                                <option value="body_site_nama">Lokasi Tubuh (Body Site)</option>
                                <option value="id_immunization">ID Imunization</option>
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
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="tanggal_pemberian">Tanggal Pemberian</option>
                                <option value="nama_vaksin">Nama Vaksin</option>
                                <option value="body_site_nama">Lokasi Tubuh (Body Site)</option>
                                <option value="id_immunization">ID Imunization</option>
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

<!-- TAMBAH IMUNISASI -->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i> Tambah Imunisasi
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

                    <!-- Form Pencarian Pasien -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_pasien"><small>No.RM</small> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="select_id_pasien">
                            <select name="id_pasien" id="id_pasien" class="form-control" required>
                                <option value="">Pilih Pasien</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form Pencarian Pasien -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_kunjungan"><small>Kunjungan</small> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8" id="select_id_kunjungan">
                            <select name="id_kunjungan" id="id_kunjungan" class="form-control" required>
                                <option value="">Pilih Kunjungan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Group Form Pemberian Imunisasi -->
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <small>
                                <b>B. Pemberian Imunisasi</b>
                            </small>
                        </div>
                    </div>

                    <!-- Tanggal Rencana Kunjungan -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_pemberian">
                                <small>Tanggal & Jam Pemberian</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="tanggal_pemberian" id="tanggal_pemberian" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <input type="time" name="jam_pemberian" id="jam_pemberian" class="form-control" required>
                        </div>
                    </div>

                    <!-- Nama Jenis Vaksin -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_imunisasi_referensi">
                                <small>Jenis/Nama Vaksin</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8" id="select_imunisasi_referensi">
                            <select name="id_imunisasi_referensi" id="id_imunisasi_referensi" class="form-select" required>
                                <option value="">Pilih Vaksin</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dosis Ke -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="dosis_ke">
                                <small>Dosis Ke</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="1" step="1" name="dosis_ke" id="dosis_ke" class="form-control" value="1" required>
                        </div>
                    </div>

                    <!-- No Batch -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nomor_batch">
                                <small>Nomor Batch</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nomor_batch" id="nomor_batch" class="form-control">
                        </div>
                    </div>

                    <!-- Produsen Vaksin -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="produsen_vaksin">
                                <small>Produsen</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="produsen_vaksin" id="produsen_vaksin" class="form-control">
                        </div>
                    </div>

                    <!-- Group Form Lokasi Tubuh -->
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <small>
                                <b>C. Lokasi Tubuh</b>
                            </small>
                        </div>
                    </div>

                    <!-- id_body_site -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_body_site">
                                <small>Lokasi Tubuh (<i>Body Site</i>) </small>
                            </label>
                        </div>
                        <div class="col-md-8" id="select_body_site">
                            <select name="id_body_site" id="id_body_site" class="form-select">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <!-- Body Site Preview -->
                    <div class="row mb-3">
                        <div class="col-md-12" id="body_site_preview">
                           <!-- Detail Body Site Yang Dipilih Akan Ditampilkan Disini  -->
                        </div>
                    </div>

                    <!-- Group Form Petugas Pemberi Imunisasi -->
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <small>
                                <b>D. Petugas / Praktisi Medis</b>
                            </small>
                        </div>
                    </div>

                    <!-- id_praktisi -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_praktisi">
                                <small>Petugas Medis</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8" id="select_praktisi">
                            <select name="id_praktisi" id="id_praktisi" class="form-select">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <!-- Preview Praktisi -->
                    <div class="row mb-3">
                        <div class="col-md-12" id="praktisi_preview">
                           <!-- Detail Praktisi Yang Dipilih Akan Ditampilkan Disini  -->
                        </div>
                    </div>

                    <!-- Group Form Catatan -->
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <small>
                                <b>E. Catatan / Keterangan Lainnya</b>
                            </small>
                        </div>
                    </div>

                    <!-- catatan -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="catatan">
                                <small>Keterangan</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
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


<!--- MODAL DETAIL --->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_detail">
                    <i class="bi bi-info-circle"></i> Detail Imunisasi
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
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Imunisasi</h5>
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
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Imunisasi</h5>
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
                        <i class="bi bi-check"></i> Ya, Hapus
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page\Imunisasi\ProsesExport.php" method="POST" target="_blank" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-download"></i> Export Data Imunisasi
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
                        <!-- Form Lanjutan Filter Data Yang Akan Di export -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiJumlahData">
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
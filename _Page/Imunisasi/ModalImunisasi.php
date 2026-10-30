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
                                <small>Tanggal Pemberian</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal_pemberian" id="tanggal_pemberian" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <!-- Nama Jenis Vaksin -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_imunisasi_referensi">
                                <small>Jenis/Nama Vaksin</small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
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

                    <!-- body_site_nama -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="body_site_nama">
                                <small>Nama Lokasi Tubuh </small> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="body_site_nama" id="body_site_nama" class="form-select" required>
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
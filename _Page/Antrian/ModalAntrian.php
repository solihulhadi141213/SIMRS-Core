<?php
    // Siapkan daftar poliklinik aktif untuk pilihan pada form tambah dan edit antrean.
    $stmtPoliklinikAntrian = mysqli_prepare(
        $Conn,
        "SELECT id_poliklinik, poliklinik
         FROM poliklinik
         WHERE status = 1
         ORDER BY poliklinik ASC"
    );
    $resultPoliklinikAntrian = false;
    if ($stmtPoliklinikAntrian && mysqli_stmt_execute($stmtPoliklinikAntrian)) {
        $resultPoliklinikAntrian = mysqli_stmt_get_result($stmtPoliklinikAntrian);
    } else {
        error_log('Antrian: gagal memuat daftar poliklinik: ' . mysqli_error($Conn));
    }
    if ($stmtPoliklinikAntrian) {
        mysqli_stmt_close($stmtPoliklinikAntrian);
    }
?>
<!-- Modal ini mengatur batas hasil, pengurutan, dan kriteria pencarian daftar antrean. -->
<div class="modal fade" id="ModalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page_filter" id="page_filter" value="1">
                <input type="hidden" name="utc_start" id="filter_utc_start" value="">
                <input type="hidden" name="utc_end" id="filter_utc_end" value="">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Antrian</h5>
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

<!-- Form tambah tersedia langsung pada modal; form edit dimuat dari PHP berdasarkan ID antrean. -->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <form id="FormAntrian" class="js-form-simpan-antrian" autocomplete="off">
                <input type="hidden" name="id_antrian" id="antrian_id" value="">
                <input type="hidden" name="id_pasien" id="antrian_id_pasien" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_form_antrian"><i class="bi bi-plus-circle"></i> Tambah Antrian Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 g-lg-3">
                        <!-- Bagian A mengatur pemilihan rekam medis atau pengisian pasien baru. -->
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-0">A. Identitas Pasien</h6>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label mb-1 d-block">Jenis pasien</label>
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input js-mode-pasien" type="radio" name="mode_pasien" id="mode_pasien_lama" value="lama" checked>
                                    <label class="form-check-label" for="mode_pasien_lama">Pilih pasien terdaftar</label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input js-mode-pasien" type="radio" name="mode_pasien" id="mode_pasien_baru" value="baru">
                                    <label class="form-check-label" for="mode_pasien_baru">Pasien baru</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 js-pilih-pasien-field" id="pilih_pasien_field">
                            <label for="pilih_pasien_antrian" class="form-label mb-1">Cari pasien <span class="text-danger">*</span></label>
                            <select id="pilih_pasien_antrian" class="form-control js-pilih-pasien-antrian"></select>
                        </div>
                        <!-- Data tambahan diaktifkan hanya saat petugas memilih pasien baru. -->
                        <div class="col-12 d-none js-data-pasien-field" id="data_pasien_field">
                            <div class="row g-2 g-lg-3">
                                <div class="col-6">
                                    <label for="nama_pasien" class="form-label mb-1">Nama lengkap pasien <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pasien" id="nama_pasien" class="form-control" maxlength="255" required>
                                </div>
                                <div class="col-6">
                                    <label for="gender_antrian" class="form-label mb-1">Jenis kelamin <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender_antrian" class="form-select" required>
                                        <option value="">Pilih</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <label for="nik_antrian" class="form-label mb-1">NIK</label>
                                    <input type="text" name="nik" id="nik_antrian" class="form-control" maxlength="16" inputmode="numeric">
                                </div>
                                <div class="col-6 col-lg-4">
                                    <label for="no_bpjs_antrian" class="form-label mb-1">Nomor BPJS</label>
                                    <input type="text" name="no_bpjs" id="no_bpjs_antrian" class="form-control" maxlength="13" inputmode="numeric">
                                </div>
                                <div class="col-6 col-lg-4">
                                    <label for="kontak_antrian" class="form-label mb-1">Kontak</label>
                                    <input type="text" name="kontak" id="kontak_antrian" class="form-control" maxlength="20" inputmode="tel">
                                </div>
                            </div>
                        </div>

                        <!-- Bagian B mengelompokkan tanggal, poliklinik, dan jadwal pelayanan. -->
                        <div class="col-12"><hr class="my-1"></div>
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-0">B. Tujuan Kunjungan</h6>
                        </div>
                        <div class="col-6 col-lg-4">
                            <label for="tanggal_kunjungan" class="form-label mb-1">Rencana kunjungan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control js-antrian-schedule-filter" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-6 col-lg-4">
                            <label for="id_poliklinik" class="form-label mb-1">Poliklinik <span class="text-danger">*</span></label>
                            <select name="id_poliklinik" id="id_poliklinik" class="form-select js-antrian-schedule-filter" required>
                                <option value="">Pilih poliklinik</option>
                                <?php if ($resultPoliklinikAntrian): ?>
                                    <?php while ($poliAntrian = mysqli_fetch_assoc($resultPoliklinikAntrian)): ?>
                                        <option value="<?php echo (int) $poliAntrian['id_poliklinik']; ?>"><?php echo htmlspecialchars($poliAntrian['poliklinik'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option value="" disabled>Daftar poliklinik gagal dimuat</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="id_jadwal" class="form-label mb-1">Jadwal dokter <span class="text-danger">*</span></label>
                            <select name="id_jadwal" id="id_jadwal" class="form-select" required disabled>
                                <option value="">Pilih tanggal dan poliklinik terlebih dahulu</option>
                            </select>
                        </div>
                        <!-- Bagian C berisi keterangan antrean dan status saat data diedit. -->
                        <div class="col-12"><hr class="my-1"></div>
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-0">C. Informasi Antrian</h6>
                        </div>
                        <div class="col-6">
                            <label for="pembayaran" class="form-label mb-1">Pembayaran <span class="text-danger">*</span></label>
                            <select name="pembayaran" id="pembayaran" class="form-select" required>
                                <option value="UMUM">UMUM</option>
                                <option value="BPJS">BPJS</option>
                                <option value="ASURANSI">ASURANSI</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="nomor_referensi" class="form-label mb-1">Nomor referensi</label>
                            <input type="text" name="nomor_referensi" id="nomor_referensi" class="form-control" maxlength="255" value="MANUAL">
                        </div>
                        <div class="col-12">
                            <label for="keluhan_antrian" class="form-label mb-1">Keluhan <span class="text-danger">*</span></label>
                            <textarea name="keluhan" id="keluhan_antrian" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <!-- Pesan validasi dan hasil penyimpanan ditampilkan di dalam modal form. -->
                    <div class="row mt-2">
                        <div class="col-12 js-antrian-notification" id="NotifikasiAntrian"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary js-simpan-antrian" id="simpan_antrian"><i class="bi bi-check-circle"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Isi form edit dikirim oleh FormEditAntrian.php setelah JavaScript mengirimkan ID antrean. -->
<div class="modal fade" id="ModalEditAntrian" tabindex="-1" aria-labelledby="judul_edit_antrian" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <form id="FormEditAntrian" class="js-form-simpan-antrian" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_edit_antrian"><i class="bi bi-pencil-square"></i> Ubah Data Antrian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="KontenFormEditAntrian">
                        <div class="text-center text-muted py-4">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                            Memuat form edit antrian...
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 js-antrian-notification" id="NotifikasiEditAntrian"></div>
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

<!-- Isi modal hapus dimuat dari FormhapusAntrian.php berdasarkan ID yang dipilih. -->
<div class="modal fade" id="ModalHapusAntrian" tabindex="-1" aria-labelledby="judul_hapus_antrian" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusAntrian" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_hapus_antrian"><i class="bi bi-trash"></i> Hapus Antrian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapusAntrian">
                            <div class="text-center text-muted py-3">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>
                                Memuat detail antrian...
                            </div>
                        </div>
                    </div>
                    <!-- Pesan proses hapus ditampilkan tanpa menutup modal konfirmasi. -->
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiHapusAntrian"></div>
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

<!-- Konten detail antrean, pasien, poliklinik, dan dokter dimuat oleh Antrian.js. -->
<div class="modal fade" id="ModalDetailAntrian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_detail_antrian"><i class="bi bi-ticket-detailed"></i> Detail Antrian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="isi_detail_antrian">
                <div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat data...</div>
            </div>
            <div class="modal-footer" id="aksi_detail_antrian">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Form ini melengkapi identitas antrean sebelum pasien baru dibuat sebagai rekam medis. -->
<div class="modal fade" id="ModalDaftarPasienAntrian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="FormDaftarPasienAntrian" autocomplete="off">
                <input type="hidden" name="id_antrian" id="daftar_pasien_id_antrian">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus"></i> Daftarkan Pasien ke Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted">Lengkapi data pasien. Sistem akan membuat nomor RM dan menghubungkannya dengan antrian.</p>
                    <!-- Isian dikelompokkan menjadi identitas utama, tanggal lahir, dan alamat pasien. -->
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="daftar_nama_pasien" class="form-label">Nama lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="daftar_nama_pasien" class="form-control" maxlength="255" required>
                        </div>
                        <div class="col-md-4">
                            <label for="daftar_gender_pasien" class="form-label">Jenis kelamin <span class="text-danger">*</span></label>
                            <select name="gender" id="daftar_gender_pasien" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="daftar_nik_pasien" class="form-label">NIK</label>
                            <input type="text" name="nik" id="daftar_nik_pasien" class="form-control" maxlength="16" inputmode="numeric">
                        </div>
                        <div class="col-md-4">
                            <label for="daftar_bpjs_pasien" class="form-label">Nomor BPJS</label>
                            <input type="text" name="no_bpjs" id="daftar_bpjs_pasien" class="form-control" maxlength="13" inputmode="numeric">
                        </div>
                        <div class="col-md-4">
                            <label for="daftar_kontak_pasien" class="form-label">Kontak</label>
                            <input type="text" name="kontak" id="daftar_kontak_pasien" class="form-control" maxlength="20" inputmode="tel">
                        </div>
                        <div class="col-md-6">
                            <label for="daftar_tempat_lahir" class="form-label">Tempat lahir</label>
                            <input type="text" name="tempat_lahir" id="daftar_tempat_lahir" class="form-control" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label for="daftar_tanggal_lahir" class="form-label">Tanggal lahir</label>
                            <input type="date" name="tanggal_lahir" id="daftar_tanggal_lahir" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="daftar_alamat_pasien" class="form-label">Alamat</label>
                            <textarea name="street" id="daftar_alamat_pasien" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <!-- Pesan validasi pendaftaran rekam medis ditampilkan di bawah isian form. -->
                    <div class="row mt-3">
                        <div class="col-12" id="NotifikasiDaftarPasienAntrian"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-person-check"></i> Buat Rekam Medis</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

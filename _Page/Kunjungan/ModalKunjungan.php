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
                                <option value="id_pasien">ID Pasien</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="prioritas">Prioritas</option>
                                <option value="jenis_kunjungan">Tujuan</option>
                                <option value="dpjp_nama">Dokter BPJP</option>
                                <option value="poliklinik">Poliklinik</option>
                                <option value="kelas">Kelas</option>
                                <option value="pembayaran_metode">Pembayaran</option>
                                <option value="datetime_daftar">Tanggal</option>
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
                                <option value="id_pasien">ID Pasien</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="prioritas">Prioritas</option>
                                <option value="jenis_kunjungan">Tujuan</option>
                                <option value="dpjp_nama">Dokter BPJP</option>
                                <option value="poliklinik">Poliklinik</option>
                                <option value="kelas">Kelas</option>
                                <option value="pembayaran_metode">Pembayaran</option>
                                <option value="datetime_daftar">Tanggal</option>
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

<!-- PILIH PASIEN -->
<div class="modal fade" id="ModalPilihPasien" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light"><i class="bi bi-search"></i> Pilih Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 d-flex flex-column" style="height: calc(100vh - 120px);">

                <!-- Form Pencarian Pasien -->
                <div class="sticky-top bg-white p-3 border-bottom">
                    <div class="row mb-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <form action="javascript:void(0);" id="ProsesFilterPasien" autocomplete="off">
                                <div class="input-group">
                                    <input type="hidden" name="page_pasien" id="page_pasien" value="1">
                                    <input type="hidden" name="current_id_pasien" id="current_id_pasien" value="">

                                    <input type="text" name="keyword_pasien" id="keyword_pasien" class="form-control" placeholder="Nama / RM / NIK">

                                    <button type="submit" class="btn btn-md btn-dark">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pasien -->
                <div class="flex-grow-1 overflow-auto p-3">
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th><b><small>No</small></b></th>
                                            <th><b><small>Nama</small></b></th>
                                            <th><b><small>RM</small></b></th>
                                            <th><b><small>NIK</small></b></th>
                                            <th><b><small>BPJS</small></b></th>
                                            <th><b><small>Gender</small></b></th>
                                            <th><b><small>Alamat</small></b></th>
                                            <th><b><small>Status</small></b></th>
                                            <th><b><small>Pilih</small></b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_pasien">
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <small>No Data</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagging Pasien -->
                <div class="sticky-bottom bg-white border-top p-3">
                    <div class="row mb-2">
                        <div class="col-6">
                            <small id="page_info_pasien">0 / 0</small>
                        </div>

                        <div class="col-6 text-end icon-btn">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page_pasien">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page_pasien">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-warning btn-rounded" id="modal_tambah_pasien">
                    <i class="bi bi-plus"></i> Daftar Pasien Baru 
                </button>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kelas -->
<div class="modal fade" id="ModalKelas" tabindex="-1" aria-labelledby="ModalKelas" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-1-circle"></i> Kelas Perawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <td align="center"><small><b>No</b></small></td>
                                        <td align="left"><small><b>Kelas</b></small></td>
                                        <td align="left"><small><b>Kode</b></small></td>
                                        <td align="left"><small><b>Ruangan</b></small></td>
                                        <td align="left"><small><b>Tepat Tidur</b></small></td>
                                        <td align="center"><small><b><i>Status</i></b></small></td>
                                        <td align="center"><small><b>Opsi</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_kelas_rawat">
                                    <!-- Konten Akan Tampil Disini -->
                                    <tr>
                                        <td align="center" colspan="7">
                                            <small class="text text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

<!-- Modal Ruangan -->
<div class="modal fade" id="ModalRuangan" tabindex="-1" aria-labelledby="ModalRuangan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-2-circle"></i> Ruangan Perawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <td align="center"><small><b>No</b></small></td>
                                        <td align="left"><small><b>Nama Ruangan</b></small></td>
                                        <td align="left"><small><b>Tempat Tidur</b></small></td>
                                        <td align="center"><small><b><i>Status</i></b></small></td>
                                        <td align="center"><small><b>Opsi</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_ruangan">
                                    <!-- Konten Akan Tampil Disini -->
                                    <tr>
                                        <td align="center" colspan="7">
                                            <small class="text text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

<!-- Modal Tempat Tidur -->
<div class="modal fade" id="ModalTempatTidur" tabindex="-1" aria-labelledby="ModalTempatTidur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-3-circle"></i> Tempat Tidur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <td align="center"><small><b>No</b></small></td>
                                        <td align="left"><small><b>Kode TT</b></small></td>
                                        <td align="left"><small><b>Kategori</b></small></td>
                                        <td align="center"><small><b><i>Status</i></b></small></td>
                                        <td align="center"><small><b>Opsi</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_tempat_tidur">
                                    <!-- Konten Akan Tampil Disini -->
                                    <tr>
                                        <td align="center" colspan="7">
                                            <small class="text text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

<!--- Modal Tambah pasien --->
<div class="modal fade" id="ModalTambahPasien" tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahPasien" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Pendaftaran Pasien Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- No.RM -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <small><b>A. Nomor Rekam Medis</b></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="id_pasid_pasien_baruien"><small>No.RM</small></label>
                            <input type="text" disabled name="id_pasien" id="id_pasien_baru" class="form-control bg-secondary-subtle">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="id_pasien_manual" name="id_pasien_manual" value="1">
                                <label class="form-check-label" for="id_pasien_manual"><small>Tambahkan No.RM Secara manual</small></label>
                            </div>
                        </div>
                        <!-- No.RM RELASI -->
                        <div class="col-md-6 mb-3">
                            <label for="id_pasien_relasi"><small>No.RM (Ibu)</small></label>
                            <select disabled name="id_pasien_relasi" id="id_pasien_relasi" class="form-control bg-danger-subtle"></select>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="pasien_anak" name="pasien_anak" value="1">
                                <label class="form-check-label" for="pasien_anak"><small>Pendaftaran Untuk Pasien Anak Baru Lahir</small></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- IDENTITAS -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <small><b>B. Nomor Identitas</b></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nik_pasien "><small>NIK (KTP)</small></label>
                            <input type="text" name="nik" id="nik_pasien" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_ihs_asien"><small>ID IHS (SATUSEHAT)</small></label>
                            <input type="text" name="id_ihs" id="id_ihs_asien" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label for="no_bpjs_pasien"><small>No.BPJS</small></label>
                            <input type="text" name="no_bpjs" id="no_bpjs_pasien" class="form-control">
                        </div>
                    </div>
                    <hr>
                    
                    <!-- INFORMASI UTAMA -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <small><b>C. Informasi Utama</b></small>
                        </div>
                    </div>

                    <!-- Nama -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama"><small>* Nama Lengkap</small></label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="gender"><small>* Gender (Jenis Kelamin)</small></label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir"><small>Tempat Lahir</small></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir"><small>Tanggal Lahir</small></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <b><small>D. Alamat Tempat Tinggal</small></b>
                        </div>
                    </div>
                    <!-- Alamat -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="province"><small>Provinsi</small></label>
                            <select name="province" id="province" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="regency"><small>Kabupaten/Kota</small></label>
                            <select name="regency" id="regency" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subdistrict"><small>Kecamatan</small></label>
                            <select name="subdistrict" id="subdistrict" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="village"><small>Desa/Kelurahan</small></label>
                            <select name="village" id="village" class="form-control" required>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="street"><small>Jalan, Nomor Rumah, RT/RW</small></label>
                            <input type="text" id="street" name="street" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="postal_code"><small>Kode POS</small></label>
                            <input type="text" id="postal_code" name="postal_code" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kontak"><small>Nomor Kontak Pasien</small></label>
                            <input type="text" id="kontak" name="kontak" class="form-control" placeholder="62">
                        </div>
                    </div>
                    <hr>

                    <!-- INFORMASI PENDUKUNG -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <small><b>E. Informasi Pendukung Lainnya</b></small>
                        </div>
                    </div>

                    <!-- Golongan Darah -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="golongan_darah"><small>Golongan Darah</small></label>
                            <select name="golongan_darah" id="golongan_darah" class="form-control">
                                <option value="">Pilih</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Pernikahan -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="pernikahan"><small>Status Pernikahan</small></label>
                            <select name="pernikahan" id="pernikahan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Lajang">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Janda">Janda</option>
                                <option value="Duda">Duda</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pekerjaan -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="pekerjaan"><small>Pekerjaan</small></label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                <option value="Wirausaha">Wirausaha</option>
                                <option value="PNS">ASN TNI/POLRI</option>
                            </select>
                        </div>
                    </div>

                     <!-- Tanggal Pendaftaran -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="registered_date"><small>* Tanggal Pendaftaran</small></label>
                            <input type="date" name="registered_date" id="registered_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="registered_time"><small>* Jam Pendaftaran</small></label>
                            <input type="time" name="registered_time" id="registered_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="pernyataan_petugas_pasien_baru" name="pernyataan_petugas" value="1">
                                    <label class="form-check-label" for="pernyataan_petugas_pasien_baru">
                                        <small>
                                            <b>Pernyataan Petugas Pendaftaran</b><br>
                                            Saya menyatakan bahwa seluruh data dan informasi pasien yang saya input telah sesuai dengan dokumen dan kondisi sebenarnya. Saya juga memahami serta berkomitmen untuk menjaga kerahasiaan data pasien sesuai dengan ketentuan etika dan peraturan perundang-undangan yang berlaku.
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambah">
                           <!-- Notifikasi Tambah  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonTambahPasienBaru">
                        <i class="ti-save"></i> Simpan Pendaftaran
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Kunjungan -->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" aria-labelledby="ModalDetailKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesDetailKunjungan">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormDetailKunjungan">
                            <!-- Form Detail Kunjungan -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary ms-2" id="ButtonDetailKunjunganSelengkapnya">
                        Selengkapnya <i class="bi bi-chevron-right"></i>
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Pasien -->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailPasien">
                        <!-- Form Detail Pasien -->
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

<!-- Modal Detail Poliklinik -->
<div class="modal fade" id="ModalDetailPoliklinik" tabindex="-1" aria-labelledby="ModalDetailPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Poliklinik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailPoliklinik">
                        <!-- Form Detail Poliklinik -->
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

<!-- Modal Detail Kelas -->
<div class="modal fade" id="ModalDetailKelas" tabindex="-1" aria-labelledby="ModalDetailKelas" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Kelas Rawat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailKelas">
                        <!-- Form Detail Kelas -->
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

<!-- Modal Detail DPJP -->
<div class="modal fade" id="ModalDetailDokter" tabindex="-1" aria-labelledby="ModalDetailDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailDokter">
                        <!-- Form Detail Dokter -->
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

<!-- Modal Detail Status -->
<div class="modal fade" id="ModalDetailStatus" tabindex="-1" aria-labelledby="ModalDetailStatus" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailStatus">
                        <!-- Form Detail Status -->
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

<!-- Modal Edit Kunjungan -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKunjungan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormEdit">
                            <!-- Form Edit -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary ms-2" id="ButtonEdit">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Status Kunjungan -->
<div class="modal fade" id="ModalUpdateStatusKunjungan" tabindex="-1" aria-labelledby="ModalUpdateStatusKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateStatusKunjungan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Update Status Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormUpdateStatusKunjungan">
                            <!-- Form Update -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiUpdateStatusKunjungan">
                            <!-- Notifikasi Update -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary ms-2" id="ButtonUpdateStatusKunjungan">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Hapus Kunjungan -->
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapus">
                            <!-- Form Update -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiHapus">
                            <!-- Notifikasi Update -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary ms-2" id="ButtonHapus">
                        <i class="bi bi-check"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cetak Label -->
<div class="modal fade" id="ModalCetaklabel" tabindex="-1" aria-labelledby="ModalCetaklabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCetaklabel" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-printer"></i> Cetak Label</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormCetaklabel">
                            <!-- Form Update -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary ms-2" id="ButtonCetak">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Download Kunjungan -->
<div class="modal fade" id="ModalDownloadKunjungan" tabindex="-1" aria-labelledby="ModalDownloadKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Kunjungan/ProsesDownloadKunjungan.php" method="POST" autocomplete="off" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Export / Download Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="periode_awal">
                                <small>Periode Awal</small>
                            </label>
                            <input type="date" class="form-control" name="periode_awal" id="periode_awal">
                        </div>
                        <div class="col-md-12">
                            <label for="periode_akhir">
                                <small>Periode Akhir</small>
                            </label>
                            <input type="date" class="form-control" name="periode_akhir" id="periode_akhir">
                        </div>
                        <div class="col-md-12 mt-4" id="NotifikasiDownloadKunjungan">
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary ms-2" id="ButtonDownloadKunjungan">
                        <i class="bi bi-download"></i> Export / Download
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload/Import Kunjungan -->
<div class="modal fade" id="ModalUploadKunjungan" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light"><i class="bi bi-upload"></i> Upload / Import Data Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 d-flex flex-column" style="height: calc(100vh - 120px);">
            
                <!-- Form Pencarian Pasien -->
                <div class="sticky-top bg-white p-3 border-bottom">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="javascript:void(0);" id="ProsesUploadKunjungan">
                                <label for="file_excel" class="mb-1">
                                    <small><b>File Excel</b></small>
                                </label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="file_excel" id="file_excel"accept=".xlsx,.xls">
                                    <button type="submit" class="btn btn-sm btn-primary" id="ButtonUploadKunjungan">
                                        <i class="bi bi-upload"></i> Import Data
                                    </button>
                                </div>
                                
                                <small class="text-muted">
                                    Pilih file excel data kunjungan pasien.
                                </small>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pasien -->
                <div class="flex-grow-1 overflow-auto p-3">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <b>Gunakan Template Excel</b><br>
                                        <small>
                                            Untuk menghindari kesalahan format import data.
                                        </small>
                                    </div>
                                    <div>
                                        <a href="_Page/Kunjungan/template_import_kunjungan.xlsx" class="btn btn-sm btn-warning">
                                            <i class="bi bi-download"></i> Download Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Import -->
                    <div class="row mb-3">
                        <div class="col-12">

                            <div id="ImportProgressWrapper" style="display:none;">

                                <div class="d-flex justify-content-between mb-1">
                                    <small><b>Progress Import</b></small>
                                    <small id="ImportProgressText">0%</small>
                                </div>

                                <div class="progress" style="height:22px;">
                                    <div 
                                        id="ImportProgressBar"
                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar"
                                        style="width:0%">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Tabel Preview -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="table table-responsive table-sm">
                                <table class="table table-bordered table-sm table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th><b><small>No</small></b></th>
                                            <th><b><small>No.RM</small></b></th>
                                            <th><b><small>Nama Pasien</small></b></th>
                                            <th><b><small>Tanggal Kunjungan</small></b></th>
                                            <th><b><small>Jenis Kunjungan</small></b></th>
                                            <th><b><small>Dokter Penerima</small></b></th>
                                            <th><b><small>Dokter DPJP</small></b></th>
                                            <th><b><small>Poliklinik</small></b></th>
                                            <th><b><small>Kelas</small></b></th>
                                            <th><b><small>Status</small></b></th>
                                            <th><b><small>Keterangan Import</small></b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="NotifikasiUploadKunjungan">
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                <small class="text-muted">Belum Ada Data Yang Diimport</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
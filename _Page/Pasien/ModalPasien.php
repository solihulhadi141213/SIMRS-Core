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
                                <option value="id_pasien">ID pasien</option>
                                <option value="id_ihs">ID IHS</option>
                                <option value="nik">NIK</option>
                                <option value="no_bpjs">No BPJS</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="gender">Gender</option>
                                <option value="registered_at">Tgl Daftar</option>
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
                                <option value="id_pasien">ID pasien</option>
                                <option value="id_ihs">ID IHS</option>
                                <option value="nik">NIK</option>
                                <option value="no_bpjs">No BPJS</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="gender">Gender</option>
                                <option value="registered_at">Tgl Daftar</option>
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

<!--- Modal Tambah pasien --->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambah" autocomplete="off">
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
                            <label for="id_pasien"><small>No.RM</small></label>
                            <input type="text" disabled name="id_pasien" id="id_pasien" class="form-control bg-secondary-subtle">
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
                            <label for="nik "><small>NIK (KTP)</small></label>
                            <div class="input-group">
                                <input type="text" name="nik" id="nik" class="form-control">
                                <span class="input-group-text" data-bs-toggle="dropdown">
                                    <small>Ambil Data</small>
                                </span>
                                <ul class="dropdown-menu shadow">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item cari_nik_pasien_satusehat">
                                            <i class="bi bi-search"></i> Cari Dari SATUSEHAT
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item cari_nik_pasien_bpjs">
                                            <i class="bi bi-search"></i> Cari Dari Bridging BPJS
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <small class="text-danger" id="notifikasi_cari_pasien_by_nik"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_ihs"><small>ID IHS (SATUSEHAT)</small></label>
                            <div class="input-group">
                                <input type="text" name="id_ihs" id="id_ihs" class="form-control">
                                <span class="input-group-text cari_ihs_pasien_satusehat" title="Cari Dari Resource SATUSEHAT">
                                    <i class="bi bi-info-circle"></i>
                                </span>
                            </div>
                            <small class="text-danger" id="notifikasi_cari_pasien_by_ihs"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label for="no_bpjs"><small>No.BPJS</small></label>
                            <div class="input-group">
                                <input type="text" name="no_bpjs" id="no_bpjs" class="form-control">
                                <span class="input-group-text cari_no_bpjs" title="Cari Dari Resource Bridging BPJS">
                                    <small>Ambil Data</small>
                                </span>
                            </div>
                            <small class="text-danger" id="notifikasi_cari_no_bpjs"></small>
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
                                    <input class="form-check-input" type="checkbox" id="pernyataan_petugas" name="pernyataan_petugas" value="1">
                                    <label class="form-check-label" for="pernyataan_petugas">
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
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonTambah">
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

<!-- Pencarian Pasien Berdsarkan NIK dari SATUSEHAT -->
<div class="modal fade" id="ModalCariNikSatuSehat" tabindex="-1" aria-labelledby="ModalCariNikSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary-subtle">
                <h5 class="modal-title"><i class="bi bi-search"></i> Pencarian Pasien (SATUSEHAT)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-secondary-subtle">
                <div id="DisplayCariNikSatuSehat">
                    <div class="row mb-2">
                        <div class="col-4"><small>IHS Pasien</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_ihs_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Nama Pasien</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nama_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>NIK</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nik_pasien">-</small></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12" id="NotifikasiCariNikSatuSehat">
                        <!-- Data Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-secondary-subtle">
                <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonTerapkanIhsPasien">
                    <i class="bi bi-check"></i> Terapkan
                </button>
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ModalCariNikBpjs" tabindex="-1" aria-labelledby="ModalCariNikBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary-subtle">
                <h5 class="modal-title"><i class="bi bi-search"></i> Pencarian Pasien (BPJS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-secondary-subtle">
                
                <div id="DisplayCariNikBpjs">
                    <div class="row mb-2">
                        <div class="col-4"><small>Nomor Kartu</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nomor_kartu_bpjs">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Nama Pasien</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nama_pasien_bpjs">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>NIK</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nik_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Tanggal Lahir</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_tanggal_lahir">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>No.Kontak</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_noTelepon">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Sex</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_sex">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2"><small>Raw</small></div>
                        <div class="col-12 mb-2">
                            <pre class="put_raw"></pre>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12" id="NotifikasiCariNikBpjs">
                        <!-- Data Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-secondary-subtle">
                <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonTerapkanPasienBpjs">
                    <i class="bi bi-check"></i> Terapkan
                </button>
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCariIhsPasien" tabindex="-1" aria-labelledby="ModalCariIhsPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary-subtle">
                <h5 class="modal-title"><i class="bi bi-search"></i> Pencarian Pasien (SATUSEHAT)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-secondary-subtle">
                <div id="DisplayCariIhs">
                    <div class="row mb-2">
                        <div class="col-4"><small>IHS Pasien</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_ihs_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Nama Pasien</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nama_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>NIK</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nik_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2"><small>Raw</small></div>
                        <div class="col-12 mb-2">
                            <pre class="put_raw"></pre>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12" id="NotifikasiCariIhs">
                        <!-- Notifikasi Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-secondary-subtle">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCariNoBpjs" tabindex="-1" aria-labelledby="ModalCariNoBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary-subtle">
                <h5 class="modal-title"><i class="bi bi-search"></i> Pencarian Pasien (BPJS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-secondary-subtle">
                
                <div id="DisplayCariNoBpjs">
                    <div class="row mb-2">
                        <div class="col-4"><small>Nomor Kartu</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nomor_kartu_bpjs">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Nama Pasien</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nama_pasien_bpjs">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>NIK</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_nik_pasien">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Tanggal Lahir</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_tanggal_lahir">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>No.Kontak</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_noTelepon">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Sex</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted put_sex">-</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2"><small>Raw</small></div>
                        <div class="col-12 mb-2">
                            <pre class="put_raw"></pre>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12" id="NotifikasiCariNoBpjs">
                        <!-- Data Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-secondary-subtle">
                <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonTerapkanPasienNoBpjs">
                    <i class="bi bi-check"></i> Terapkan
                </button>
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <!-- Detail Akan Muncul Disini -->
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

<!-- Modal Ubah Status Pasien -->
<div class="modal fade" id="ModalUbahStatus" tabindex="-1" aria-labelledby="ModalUbahStatus" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesUbahStatus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-tag"></i> Ubah Status Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-2">
                        <div class="col-12" id="FormUbahStatus">
                            <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiUbahStatus">
                            <!-- Notifikasi Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonUbahStatus">
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

<!-- Modal Edit pasien -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-2">
                        <div class="col-12" id="FormEdit">
                            <!-- Form Edit pasien -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit pasien -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonEdit">
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

<!-- Modal Hapus pasien -->
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapus">
                            <!-- Form Hapus pasien -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus pasien -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonHapus">
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

<!-- Modal Export -->
<div class="modal fade" id="ModalExport" tabindex="-1" aria-labelledby="ModalExport" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesExport" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Download / Export</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_data"><small>Periode Data</small></label>
                            <select name="periode_data" id="periode_data" class="form-control">
                                <option selected value="Semua">Semua Data</option>
                                <option value="Periode">Berdasarkan Periode</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_awal"><small>Periode Awal</small></label>
                            <input type="date" disabled name="periode_awal" id="periode_awal" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_akhir"><small>Periode Akhir</small></label>
                            <input type="date" disabled name="periode_akhir" id="periode_akhir" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiDownload">
                            <!-- Notifikasi Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary" id="ButtonExport">
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

<!-- Modal Import -->
<div class="modal fade" id="ModalImport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="ProsesImport" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-upload"></i> Upload / Import Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- File -->
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" name="file_pasien" id="file_pasien" class="form-control">
                    </div>

                    <!-- Progress -->
                    <div class="mb-3 d-none" id="ProgressUploadWrapper">
                        <div class="progress" style="height:25px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="ProgressUpload" role="progressbar" style="width:0%;">0%</div>
                        </div>
                    </div>

                    <!-- Notifikasi -->
                    <div id="NotifikasiUpload"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ButtonUpload" disabled>
                        <i class="bi bi-upload"></i> Import Data
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail NIK -->
 <div class="modal fade" id="ModalDetailNik" tabindex="-1" aria-labelledby="ModalDetailNik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail NIK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailNik">
                        <!-- Form Akan Muncul Disini -->
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

<!-- Modal Detail BPJS -->
 <div class="modal fade" id="ModalDetailBpjs" tabindex="-1" aria-labelledby="ModalDetailBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail No.BPJS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailBpjs">
                        <!-- Form Akan Muncul Disini -->
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

<!-- Modal Detail IHS -->
 <div class="modal fade" id="ModalDetailIhs" tabindex="-1" aria-labelledby="ModalDetailIhs" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail IHS Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailIhs">
                        <!-- Form Akan Muncul Disini -->
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

<!-- Modal Edit Identitas Pasien -->
<div class="modal fade" id="ModalEditIdentitasPasien" tabindex="-1" aria-labelledby="ModalEditIdentitasPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditIdentitasPasien" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-2">
                        <div class="col-12" id="FormEditIdentitasPasien">
                            <!-- Form Edit Identias pasien -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiEditIdentitasPasien">
                            <!-- Notifikasi Edit Identias pasien -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditIdentitasPasien">
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
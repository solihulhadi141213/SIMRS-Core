<!-- Filter Data -->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page" id="page_filter" value="1">
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
                                <option value="nama">Nama Dokter</option>
                                <option value="kode">Kode Dokter</option>
                                <option value="id_ihs_practitioner">ID Practitioner</option>
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
                                <option value="nama">Nama Dokter</option>
                                <option value="kode">Kode Dokter</option>
                                <option value="id_ihs_practitioner">ID Practitioner</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword" class="form-control">
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

<!--- Modal Tambah Dokter --->
<div class="modal fade" id="ModalTambahDokter" tabindex="-1" aria-labelledby="ModalTambahDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahDokter" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Nama Dokter -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama"><small>Nama Dokter</small></label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh : dr Jhone Doe" required>
                        </div>
                    </div>

                    <!-- Kode -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode"><small>Kode Dokter</small></label>
                            <select name="kode" id="kode" class="form-control" required>
                            </select>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="gender"><small>Jenis Kelamin</small></label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="tanggal_lahir"><small>Tanggal Lahir</small></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kategori"><small>Kategori Spesialistik</small></label>
                            <select name="kategori" id="kategori" class="form-control" required>
                            </select>
                        </div>
                    </div>

                    <!-- Identitas -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="identitas"><small>Identitas (NIK)</small></label>
                            <input type="text" name="no_identitas" id="no_identitas" class="form-control" placeholder="Nomor Identitas" required>
                        </div>
                    </div>
                    
                    <!-- ID Practitioner -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_ihs_practitioner"><small>ID Practitioner</small></label>
                            <div class="input-group">
                                <input type="text" name="id_ihs_practitioner" id="id_ihs_practitioner" class="form-control" placeholder="Cari Dari SATUSEHAT">
                                <button type="button" class="input-group-text modal_cari_practitioner">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="alamat"><small>Alamat</small></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat dokter"></textarea>
                        </div>
                    </div>

                    <!-- Kontak dan Email -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kontak"><small>Kontak</small></label>
                            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label for="email"><small>Email</small></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="dokter@email.com">
                        </div>
                    </div>

                    <!-- SIP -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="SIP"><small>SIP</small></label>
                            <input type="text" name="SIP" id="SIP" class="form-control" placeholder="Nomor SIP">
                        </div>
                    </div>

                    <!-- SIP -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="foto"><small>Foto</small></label>
                            <input type="file" name="foto" id="foto" class="form-control">
                            <small class="text text-muted">
                                Foto Maksimal 2 Mb (File Type : JPG, JPEG, PNG dan GIF)
                            </small>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked="">
                                <label class="form-check-label" for="status">
                                    <small>Status Dokter Aktif</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahDokter">
                           <!-- Notifikasi Tambah Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahDokter">
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



<!--- Modal Detail Dokter --->
<div class="modal fade" id="ModalDetailDokter" tabindex="-1" aria-labelledby="ModalDetailDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailDokter">
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

<!--- Modal Edit Dokter --->
<div class="modal fade" id="ModalEditDokter" tabindex="-1" aria-labelledby="ModalEditDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditDokter" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditDokter">
                           <!-- Form Edit Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditDokter">
                           <!-- Notifikasi Edit Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditDokter">
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

<!--- Modal Hapus Dokter --->
<div class="modal fade" id="ModalHapusDokter" tabindex="-1" aria-labelledby="ModalHapusDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusDokter" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusDokter">
                            <!-- Form Hapus Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusDokter">
                            <!-- Notifikasi Hapus Dokter Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusDokter">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail Practitioner --->
<div class="modal fade" id="ModalDetailPractitioner" tabindex="-1" aria-labelledby="ModalDetailPractitioner" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> <i>Detail Practitioner</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row mt-4">
                    <div class="col-12" id="FormDetailPractitioner">
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


<!--- Modal Detail Jadwal --->
<div class="modal fade" id="ModalJadwalDokter" tabindex="-1" aria-labelledby="ModalJadwalDokter" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Jadwal Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormJadwalDokter">
                        <!-- Form jadwal Dokter Akan Muncul Disini -->
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

<!--- Modal Cari Practitioner --->
<div class="modal fade" id="ModalCariPractitioner" tabindex="-1" aria-labelledby="ModalCariPractitioner" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Cari ID Practitioner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row mt-4">
                    <div class="col-12" id="FormCariPractitioner">
                        <!-- Form Detail Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer  bg-primary">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>


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
                                <option value="id_practitioner">ID Practitioner</option>
                                <option value="tipe_praktisi">Tipe</option>
                                <option value="profesi_praktisi">Profesi</option>
                                <option value="nama_praktisi">Nama</option>
                                <option value="nik_praktisi">NIK</option>
                                <option value="id_akses">ID Akses</option>
                                <option value="id_dokter">ID Dokter</option>
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
                                <option value="id_practitioner">ID Practitioner</option>
                                <option value="tipe_praktisi">Tipe</option>
                                <option value="profesi_praktisi">Profesi</option>
                                <option value="nama_praktisi">Nama</option>
                                <option value="nik_praktisi">NIK</option>
                                <option value="id_akses">ID Akses</option>
                                <option value="id_dokter">ID Dokter</option>
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

<!--- Modal Akses --->
<div class="modal fade" id="ModalAkses" tabindex="-1" aria-labelledby="ModalAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-search"></i> Pilih Akses Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- Form Pencarian Akses Pengguna -->
                 <form action="javascript:void(0);" id="ProsesFilterAkses">
                    <input type="hidden" name="page" id="page_akses" value="1">
                    <input type="hidden" name="batas" id="batas_akses" value="10">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="keyword" id="keyword_akses" class="form-control">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Tabel Akses -->
                <div class="row mt-4 mb-3">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center"><small><b>No</b></small></td>
                                        <td><small><b>Nama</b></small></td>
                                        <td><small><b>NIK</b></small></td>
                                        <td><small><b>Email</b></small></td>
                                        <td><small><b>Kontak</b></small></td>
                                        <td class="text-center"><small><b>Akses</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_akses">
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <small>No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagging Akses -->
                <div class="row">
                    <div class="col-6"><small id="page_info_akses">Page 0 Of 0</small></div>
                    <div class="col-6 text-end icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page_akses">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page_akses">
                            <i class="bi bi-chevron-right"></i>
                        </button>
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

<!--- Modal Dokter --->
<div class="modal fade" id="ModalDokter" tabindex="-1" aria-labelledby="ModalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-search"></i> Pilih Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- Form Pencarian Dokter Pengguna -->
                 <form action="javascript:void(0);" id="ProsesFilterDokter">
                    <input type="hidden" name="page" id="page_dokter" value="1">
                    <input type="hidden" name="batas" id="batas_dokter" value="10">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="keyword" id="keyword_dokter" class="form-control">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Tabel Dokter -->
                <div class="row mt-4 mb-3">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center"><small><b>No</b></small></td>
                                        <td><small><b>Nama</b></small></td>
                                        <td><small><b>NIK</b></small></td>
                                        <td><small><b>Email</b></small></td>
                                        <td><small><b>Kontak</b></small></td>
                                        <td><small><b>IHS</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_dokter">
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <small>No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagging Akses -->
                <div class="row">
                    <div class="col-6"><small id="page_info_dokter">Page 0 Of 0</small></div>
                    <div class="col-6 text-end icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page_dokter">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page_dokter">
                            <i class="bi bi-chevron-right"></i>
                        </button>
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

<!--- Modal Tambah Praktisi --->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Praktisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Nama Lengkap -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama_praktisi"><small>* Nama Lengkap</small></label>
                            <input type="text" name="nama_praktisi" id="nama_praktisi" class="form-control" required>
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nik_praktisi"><small>* Nomor NIK/KTP</small></label>
                            <div class="input-group">
                                <input type="text" name="nik_praktisi" id="nik_praktisi" class="form-control get_nik_value" required>
                                <button type="button" class="btn btn-sm btn-outline-dark modal_cek_nik">
                                    <i class="bi bi-search"></i> SATUSEHAT
                                </button>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Nomor Kontak -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kontak_praktisi"><small>Nomor Kontak</small></label>
                            <input type="text" name="kontak_praktisi" id="kontak_praktisi" class="form-control" placeholder="62">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="email_praktisi"><small>Alamat Email</small></label>
                            <input type="email" name="email_praktisi" id="email_praktisi" class="form-control" placeholder="email@domain.com">
                        </div>
                    </div>

                    <!-- ID Practitioner -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_practitioner"><small>ID Practitioner (<i>SATUSEHAT</i>)</small></label>
                            <input type="text" name="id_practitioner" id="id_practitioner" class="form-control">
                        </div>
                    </div>

                    <!-- Tipe Praktisi -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="tipe_praktisi"><small>* Tipe Praktisi</small></label>
                            <select name="tipe_praktisi" id="tipe_praktisi" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Medis">Medis</option>
                                <option value="Non Medis">Non Medis</option>
                            </select>
                        </div>
                    </div>

                    <!-- Profesi -->
                    <div class="row mb-3">
                        <div class="col-12" id="FormProfesi">
                            <label for="profesi_praktisi"><small>* Profesi Praktisi</small></label>
                            <select name="profesi_praktisi" id="profesi_praktisi" class="form-select" required>
                                <option value="">Pilih Profesi</option>
                            </select>
                        </div>
                    </div>

                    <!-- ID Akses -->
                    <div class="row mb-3">
                        <div class="col-12" id="FormAkses">
                            <label for="id_akses"><small>ID Akses</small></label>
                            <select name="id_akses" id="id_akses" class="form-select">
                                <option value="">Pilih Akses</option>
                            </select>
                            <small>
                                <small class="text-muted">
                                    Hanya apabila praktisi/SDM bersangkutan memiliki akses SIMRS
                                </small>
                            </small>
                        </div>
                    </div>

                    <!-- ID Dokter -->
                    <div class="row mb-3">
                        <div class="col-12" id="FormDokter">
                            <label for="id_dokter"><small>ID Dokter</small></label>
                            <select name="id_dokter" id="id_dokter" class="form-select">
                                <option value="">Pilih Dokter</option>
                            </select>
                            <small>
                                <small class="text-muted">
                                    Hanya apabila praktisi/SDM bersangkutan adalah seorang dokter.
                                </small>
                            </small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambah">
                           <!-- Notifikasi Tambah Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambah">
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

<!--- Modal Detail --->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Praktisi / SDM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <!-- Form Detail Muncul Disini -->
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

<!--- Modal Akses --->
<div class="modal fade" id="ModalDetailAkses" tabindex="-1" aria-labelledby="ModalDetailAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailAkses">
                        <!-- Form Detail Muncul Disini -->
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

<!--- Modal Dokter --->
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
                        <!-- Form Detail Muncul Disini -->
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

<!--- Modal Edit Praktisi --->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Praktisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEdit">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEdit">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEdit">
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

<!--- Modal Cek NIK --->
<div class="modal fade" id="ModalCeknik" tabindex="-1" aria-labelledby="ModalCeknik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail NIK Praktisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormCekNik">
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

<!--- Modal Hapus Praktisi --->
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Praktisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapus">
                            <!-- Form Hapus Praktisi Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus Praktisi Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapus">
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

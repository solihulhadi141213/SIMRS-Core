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
                                <option value="nama">Nama Pengguna</option>
                                <option value="email">Email</option>
                                <option value="id_akses_entitas">Entitas</option>
                                <option value="tanggal">Registered</option>
                                <option value="updatetime">Updated</option>
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
                                <option value="nama">Nama Pengguna</option>
                                <option value="email">Email</option>
                                <option value="id_akses_entitas">Entitas</option>
                                <option value="tanggal">Registered</option>
                                <option value="updatetime">Updated</option>
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

<!--- Modal Tambah Akses --->
<div class="modal fade" id="ModalTambahAkses" tabindex="-1" aria-labelledby="ModalTambahAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahAkses" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Nama Pengguna -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama"><small>Nama Lengkap</small></label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh : Jhon Doe" required>
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nik"><small>NIK / KTP</small></label>
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="Contoh : 32000000001" required>
                        </div>
                    </div>

                    <!-- IHS -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="ihs"><small>ID Practitioner (IHS)</small></label>
                            <div class="input-group">
                                <input type="text" name="ihs" id="ihs" class="form-control">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="SearchByNik" title="Cari Berdasarkan NIK">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                            <small class="text text-muted">ID Practitioner Dari SATUSEHAT</small>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="email"><small>Alamat Email</small></label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- KONTAK -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kontak"><small>Nomor Kontak</small></label>
                            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="62" required>
                        </div>
                    </div>

                    <!-- AKSES -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_akses_entitas"><small>Entitas Akses</small></label>
                            <select name="id_akses_entitas" id="id_akses_entitas" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="password"><small>Password</small></label>
                            <div class="input-group">
                                <input type="text" name="password" id="password" class="form-control"  required>
                                <button type="button" class="btn btn-sm btn-secondary" id="GeneratePassword" title="Buat Password Otomatiis">
                                    <i class="bi bi-repeat"></i> Generate
                                </button>
                            </div>
                            <small class="text text-muted">Minimal 8 karakter huruf dan angka</small>
                        </div>
                    </div>

                    <!-- FOTO PROFIL -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="gambar"><small>Foto Profil</small></label>
                            <input type="file" name="gambar" id="gambar" class="form-control"  required>
                            <small class="text text-muted">Maksimal 2 Mb (File Type : JPG, PNG, GIF)</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahAkses">
                           <!-- Notifikasi Tambah Akses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahAkses">
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

<!--- Modal Detail Akses Akses --->
<div class="modal fade" id="ModalDetailAksesAkses" tabindex="-1" aria-labelledby="ModalDetailAksesAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Akses Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailAksesAkses">
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

<!--- Modal Pengguna Akses Akses --->
<div class="modal fade" id="ModalAksesPengguna" tabindex="-1" aria-labelledby="ModalAksesPengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Daftar Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form action="javascript:void(0);" id="FilterDaftarPengguna" autocomplete="off">
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <div class="search-custom-group d-flex align-items-center border">
                                <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari Nama / Email...">
                                <input type="hidden" name="page" id="page_pengguna" value="1">
                                <input type="hidden" name="id_akses_fitur" id="put_id_akses_fitur">
                                <button class="btn btn-sm btn-icon">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center"><small><b>No</b></small></td>
                                        <td><small><b>Nama</b></small></td>
                                        <td><small><b>Email</b></small></td>
                                        <td class="text-center"><small><b>Entitas</b></small></td>
                                        <td class="text-center"><small><b>Opsi</b></small></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_pengguna">
                                    <tr>
                                        <!-- Form Detail Akan Muncul Disini -->
                                        <td colspan="5" class="text-center"><small>No Data</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <small id="page_info_pengguna">0 / 0</small>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn-floating btn-sm" id="previous_page_pengguna">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn-floating btn-sm" id="next_page_pengguna">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>


<!--- Modal Edit Akses Akses --->
<div class="modal fade" id="ModalEditAksesAkses" tabindex="-1" aria-labelledby="ModalEditAksesAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditAksesAkses" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditAksesAkses">
                           <!-- Form Edit Akses Akses Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditAksesAkses">
                           <!-- Notifikasi Edit Akses Akses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditAksesAkses">
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

<!--- Modal Hapus Akses --->
<div class="modal fade" id="ModalHapusAksesAkses" tabindex="-1" aria-labelledby="ModalHapusAksesAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusAksesAkses" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Akses Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusAksesAkses">
                            <!-- Form Hapus Akses Akses Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusAksesAkses">
                            <!-- Notifikasi Hapus Akses fitur Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusAksesAkses">
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
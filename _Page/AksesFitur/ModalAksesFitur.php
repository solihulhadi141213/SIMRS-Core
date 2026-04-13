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
                                <option value="nama_fitur">Nama Fitur</option>
                                <option value="kategori">Kategori</option>
                                <option value="kode">Kode</option>
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
                                <option value="nama_fitur">Nama Fitur</option>
                                <option value="kategori">Kategori</option>
                                <option value="kode">Kode</option>
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

<!--- Modal Tambah Fitur --->
<div class="modal fade" id="ModalTambahFitur" tabindex="-1" aria-labelledby="ModalTambahFitur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahFitur" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Fitur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Nama Fitur -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama_fitur"><small>Nama Fitur</small></label>
                            <input type="text" name="nama_fitur" id="nama_fitur" class="form-control" placeholder="Contoh : Laporan" required>
                        </div>
                    </div>
                    <!-- Kategori -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kategori"><small>Kategori</small></label>
                            <select name="kategori" id="kategori" class="form-control" required>
                            </select>
                        </div>
                    </div>

                    <!-- Kode -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode"><small>Kode Akses</small></label>
                            <div class="input-group">
                                <input type="text" name="kode" id="kode" class="form-control" required>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="GenerateKode">
                                    <i class="bi bi-arrow-repeat"></i> Generate
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Keterangan -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="keterangan"><small>Keterangan</small></label>
                            <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahFitur">
                           <!-- Notifikasi Tambah Fitur Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahFitur">
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

<!--- Modal Detail Akses Fitur --->
<div class="modal fade" id="ModalDetailAksesFitur" tabindex="-1" aria-labelledby="ModalDetailAksesFitur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Akses Fitur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailAksesFitur">
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

<!--- Modal Pengguna Akses Fitur --->
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


<!--- Modal Edit Akses Fitur --->
<div class="modal fade" id="ModalEditAksesFitur" tabindex="-1" aria-labelledby="ModalEditAksesFitur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditAksesFitur" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Fitur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditAksesFitur">
                           <!-- Form Edit Akses Fitur Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditAksesFitur">
                           <!-- Notifikasi Edit Akses Fitur Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditAksesFitur">
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

<!--- Modal Hapus Fitur --->
<div class="modal fade" id="ModalHapusAksesFitur" tabindex="-1" aria-labelledby="ModalHapusAksesFitur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusAksesFitur" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Akses Fitur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusAksesFitur">
                            <!-- Form Hapus Akses Fitur Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusAksesFitur">
                            <!-- Notifikasi Hapus Akses fitur Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusAksesFitur">
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
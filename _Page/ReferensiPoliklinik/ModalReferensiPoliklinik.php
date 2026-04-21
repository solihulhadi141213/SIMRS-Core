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
                                <option value="poliklinik">Poliklinik</option>
                                <option value="kode">Kode Poliklinik</option>
                                <option value="status">Status</option>
                                <option value="updatetime">Updatetime</option>
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
                                <option value="poliklinik">Poliklinik</option>
                                <option value="kode">Kode Poliklinik</option>
                                <option value="status">Status</option>
                                <option value="updatetime">Updatetime</option>
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

<!--- Modal Tambah Poliklinik --->
<div class="modal fade" id="ModalTambahPoliklinik" tabindex="-1" aria-labelledby="ModalTambahPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahPoliklinik" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Poliklinik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Nama Poliklinik -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="poliklinik"><small>Nama Poliklinik</small></label>
                            <input type="text" name="poliklinik" id="poliklinik" class="form-control" placeholder="Contoh : Penyakit Dalam" required>
                        </div>
                    </div>

                    <!-- Kode -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode"><small>kode Poli</small></label>
                            <select name="kode" id="kode" class="form-control" required>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked="">
                                <label class="form-check-label" for="status">
                                    <small>Status Poliklinik Aktif</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahPoliklinik">
                           <!-- Notifikasi Tambah Poliklinik Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahPoliklinik">
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

<!--- Modal Detail Poliklinik --->
<div class="modal fade" id="ModalDetailPoliklinik" tabindex="-1" aria-labelledby="ModalDetailPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Poliklinik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailPoliklinik">
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

<!--- Modal Pengguna Poliklinik --->
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


<!--- Modal Edit Poliklinik --->
<div class="modal fade" id="ModalEditPoliklinik" tabindex="-1" aria-labelledby="ModalEditPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditPoliklinik" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Poliklinik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditPoliklinik">
                           <!-- Form Edit Poliklinik Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditPoliklinik">
                           <!-- Notifikasi Edit Poliklinik Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditPoliklinik">
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

<!--- Modal Hapus Poliklinik --->
<div class="modal fade" id="ModalHapusPoliklinik" tabindex="-1" aria-labelledby="ModalHapusPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusPoliklinik" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Hapus Poliklinik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusPoliklinik">
                            <!-- Form Hapus Poliklinik Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusPoliklinik">
                            <!-- Notifikasi Hapus Akses fitur Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusPoliklinik">
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
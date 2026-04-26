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
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option selected value="100">100</option>
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
                                <option value="kode_kelas">Kode Kelas</option>
                                <option value="kelas">Kelas Rawat</option>
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
                                <option value="kode_kelas">Kode Kelas</option>
                                <option value="kelas">Kelas Rawat</option>
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

<!--- Modal Tambah Kelas --->
<div class="modal fade" id="ModalTambahKelas" tabindex="-1" aria-labelledby="ModalTambahKelas" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahKelas" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Kelas Rawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Kode Kelas -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kode_kelas"><small>Kode Kelas</small></label>
                            <select name="kode_kelas" id="kode_kelas" class="form-control" required></select>
                        </div>
                    </div>

                    <!-- Kelas -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kelas"><small>Kelas</small></label>
                            <input type="text" id="kelas" name="kelas" class="form-control" required>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked="">
                                <label class="form-check-label" for="status">
                                    <small>Status Kelas Aktif</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahKelas">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahKelas">
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

<!--- Modal Edit Kelas --->
<div class="modal fade" id="ModalEditKelas" tabindex="-1" aria-labelledby="ModalEditKelas" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditKelas" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Kelas Rawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditKelas">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditKelas">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditKelas">
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

<!--- Modal Hapus Kelas --->
<div class="modal fade" id="ModalHapusKelas" tabindex="-1" aria-labelledby="ModalHapusKelas" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusKelas" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Kelas Rawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapusKelas">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusKelas">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusKelas">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Ruangan Rawat--->
<div class="modal fade" id="ModalRuangRawat" tabindex="-1" aria-labelledby="ModalRuangRawat" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="bi bi-list"></i> Ruang Rawat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormRuangRawat">
                        <!-- Data Akan Muncul Disini -->
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

<!--- Modal Tambah Ruangan --->
<div class="modal fade" id="ModalTambahRuangan" tabindex="-1" aria-labelledby="ModalTambahRuangan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md border-0" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahRuangan" autocomplete="off">
                <div class="modal-header bg-primary-subtle border-0">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Ruang Rawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-primary-subtle border-0">
                    
                    <div class="row">
                        <div class="col-12" id="FormTambahRuangan">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahRuangan">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary-subtle border-0">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahRuangan">
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

<!--- Modal Edit Ruangan --->
<div class="modal fade" id="ModalEditRuangan" tabindex="-1" aria-labelledby="ModalEditRuangan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md border-0" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditRuangan" autocomplete="off">
                <div class="modal-header bg-primary-subtle border-0">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Ruang Rawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-primary-subtle border-0">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditRuangan">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditRuangan">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary-subtle border-0">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditRuangan">
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

<!--- Modal Hapus Ruangan --->
<div class="modal fade" id="ModalHapusRuangan" tabindex="-1" aria-labelledby="ModalHapusRuangan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md border-0" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusRuangan" autocomplete="off">
                <div class="modal-header bg-secondary-subtle border-0">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Ruang Rawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusRuangan">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusRuangan">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-secondary-subtle border-0">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusRuangan">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Tempat Tidur --->
<div class="modal fade" id="ModalTempatTidur" tabindex="-1" aria-labelledby="ModalTempatTidur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title"><i class="bi bi-list"></i> Tempat Tidur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormTempatTidur">
                        <!-- Data Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Tambah Tempat Tidur--->
<div class="modal fade" id="ModalTambahTempatTidur" tabindex="-1" aria-labelledby="ModalTambahTempatTidur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md border-0" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahTempatTidur" autocomplete="off">
                <div class="modal-header bg-info-subtle border-0">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Tempat Tidur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-info-subtle border-0">
                    
                    <div class="row">
                        <div class="col-12" id="FormTambahTempatTidur">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahTempatTidur">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-info-subtle border-0">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahTempatTidur">
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

<!--- Modal Edit Tempat Tidur--->
<div class="modal fade" id="ModalEditTempatTidur" tabindex="-1" aria-labelledby="ModalEditTempatTidur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md border-0" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditTempatTidur" autocomplete="off">
                <div class="modal-header bg-info-subtle border-0">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Tempat Tidur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-info-subtle border-0">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditTempatTidur">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditTempatTidur">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-info-subtle border-0">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditTempatTidur">
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

<!--- Modal Hapus Tempat Tidur --->
<div class="modal fade" id="ModalHapusTempatTidur" tabindex="-1" aria-labelledby="ModalHapusTempatTidur" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md border-0" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusTempatTidur" autocomplete="off">
                <div class="modal-header bg-secondary-subtle border-0">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Tempat Tidur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusTempatTidur">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusTempatTidur">
                           <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-secondary-subtle border-0">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusTempatTidur">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Aplicare --->
<div class="modal fade" id="ModalAplicare" tabindex="-1" aria-labelledby="ModalAplicare" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="bi bi-list"></i> Aplicare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <small>Berikut ini adalah data ketersediaan ruangan dari APLICARE</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12" id="">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center align-middle" rowspan="2">
                                            <small><b>NO</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>RUANGAN</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>KODE RUANGAN</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>KELAS</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>KODE KELAS</b></small>
                                        </td>
                                        <td class="text-center align-middle" colspan="3">
                                            <small><b>KETERSEDIAAN TEMPAT TIDUR</b></small>
                                        </td>
                                        <td class="text-center align-middle" rowspan="2">
                                            <small><b>KAPASITAS</b></small>
                                        </td>
                                        <td class="text-center align-middle" rowspan="2">
                                            <small><b>UPDATETIME</b></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle"> <small><b>PRIA</b></small> </td>
                                        <td class="text-center align-middle"> <small><b>WANITA</b></small> </td>
                                        <td class="text-center align-middle"> <small><b>BEBAS</b></small> </td>
                                    </tr>
                                </thead>
                                <tbody id="FormAplicare">
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <small>No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn-info ms-2" id="ReloadAplicare">
                    <i class="bi bi-repeat"></i> Reload Aplicare
                </button>
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Update Aplicare --->
<div class="modal fade" id="ModalUpdateAplicare" tabindex="-1" aria-labelledby="ModalUpdateAplicare" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="bi bi-repeat"></i> Update Aplicare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <small>
                                Berikut ini adalah data ketersediaan ruangan dari SIMRS. Ketika anda melakukan update, sistem akan melakukan tahapan berikut :
                                <ol>
                                    <li>Menghapus data ruangan dari Aplicare yang tidak terdaftar pada SIMRS</li>
                                    <li>Memperbaharui data ruangan yang sudah ada sebelumnya</li>
                                    <li>Menambahkan data ruangan baru ke Aplicare (Jika belum tersedia sebelumnya)</li>
                                </ol>
                                Data yang diperbaharui adalah data yang <i>Active</i> secara sistem.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="progress" style="height:20px;">
                            <div id="ProgressAplicare" 
                                class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                style="width:0%">
                                0%
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center align-middle" rowspan="2">
                                            <small><b>NO</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>RUANGAN</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>KODE RUANGAN</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>KELAS</b></small>
                                        </td>
                                        <td class="text-left align-middle" rowspan="2">
                                            <small><b>KODE KELAS</b></small>
                                        </td>
                                        <td class="text-center align-middle" colspan="3">
                                            <small><b>KETERSEDIAAN TEMPAT TIDUR</b></small>
                                        </td>
                                        <td class="text-center align-middle" rowspan="2">
                                            <small><b>KAPASITAS</b></small>
                                        </td>
                                        <td class="text-center align-middle" rowspan="2">
                                            <small><b>KETERANGAN</b></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle"> <small><b>PRIA</b></small> </td>
                                        <td class="text-center align-middle"> <small><b>WANITA</b></small> </td>
                                        <td class="text-center align-middle"> <small><b>BEBAS</b></small> </td>
                                    </tr>
                                </thead>
                                <tbody id="FormUpdateAplicare">
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <small>No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn-success ms-2" id="UpdateAplicare">
                    <i class="bi bi-repeat"></i> Update Aplicare
                </button>
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

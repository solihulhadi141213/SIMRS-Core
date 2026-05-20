
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
                                <option value="jenis_kunjungan">Tujuan</option>
                                <option value="datetime_daftar">Tanggal</option>
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
                                <option value="jenis_kunjungan">Tujuan</option>
                                <option value="datetime_daftar">Tanggal</option>
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


<!-- Modal Detail Kunjungan -->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailKunjungan">
                <div class="row">
                    <div class="col-12">
                        <!-- Detaiil Kunjungan Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- Modal Detail Pasien -->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailPasien">
                <div class="row">
                    <div class="col-12">
                        <!-- Detaiil Pasien Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div> 


<!-- MODAL TAMBAH TINDAKAN -->
 <div class="modal fade" id="ModalTambahTindakan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahTindakan">
                <div class="modal-header">
                    <h5 class="modal-title text-primary"><i class="bi bi-file-medical"></i> Tambah Tindakan (Procedure)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormTambahTindakan">
                            <!-- Form Tambah Tindakan -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahTindakan">
                            <!-- Notifikasi Tambah Tindakan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahTindakan">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Tindakan -->
<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Tindakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetail">
                <div class="row">
                    <div class="col-12">
                        <!-- Detaiil Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- MODAL EDIT TINDAKAN -->
<div class="modal fade" id="ModalEditTindakan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTindakan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Tindakan <i>(Procedure)</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormEditTindakan">
                            <!-- Form Edit Tindakan -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiEditTindakan">
                            <!-- Notifikasi Edit Tindakan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditTindakan">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS TINDAKAN -->
 <div class="modal fade" id="ModalHapusTindakan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTindakan">
                <div class="modal-header">
                    <h5 class="modal-title text-primary"><i class="bi bi-trash"></i> Hapus Tindakan <i>(Procedure)</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormHapusTindakan">
                            <!-- Form Edit Tindakan -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusTindakan">
                            <!-- Notifikasi Edit Tindakan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonHapusTindakan">
                        <i class="bi bi-check"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Daftar Performer -->
<div class="modal fade" id="ModalPerformer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Daftar Pelaksana Tindakan <i>(Performer)</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormPerformer">
                <div class="row">
                    <div class="col-12">
                        <!-- Daftar Performer Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- Modal Tambah Performer -->
<div class="modal fade" id="ModalTambahPerformer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPerformer">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus-circle"></i> Tambah Pelaksana Tindakan <i>(Performer)</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormTambahPerformer">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahPerformer">
                            <!-- Notifikasi Tambah Performer -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahPerformer">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Performer -->
<div class="modal fade" id="ModalDetailPerformer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-light"><i class="bi bi-info-circle"></i> Detail Pelaksana <i>(Performer)</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailPerformer">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- Modal Edit Performer -->
<div class="modal fade" id="ModalEditPerformer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPerformer">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-light"><i class="bi bi-plus-circle"></i> Edit Pelaksana Tindakan <i>(Performer)</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-success-subtle">
                    <div class="row">
                        <div class="col-12" id="FormEditPerformer">
                            <!-- Form Edit -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditPerformer">
                            <!-- Notifikasi Edit -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditPerformer">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Performer -->
<div class="modal fade" id="ModalHapusPerformer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPerformer">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-light"><i class="bi bi-trash"></i> Hapus Pelaksana Tindakan <i>(Performer)</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger-subtle">
                    <div class="row">
                        <div class="col-12" id="FormHapusPerformer">
                            <!-- Form Hapus -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusPerformer">
                            <!-- Notifikasi Hapus -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonHapusPerformer">
                        <i class="bi bi-check"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kirim Procedure -->
<div class="modal fade" id="ModalKirimProcedure" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimProcedure">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-send"></i> Kirim Resource <i>Procedure</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormKirimProcedure">
                            <!-- Form Kirim -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiKirimProcedure">
                            <!-- Notifikasi Kirim -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonKirimProcedure">
                        <i class="bi bi-send"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Procedure -->
<div class="modal fade" id="ModalDetailProcedure" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Procedure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailProcedure">
                <div class="row">
                    <div class="col-12">
                        <!-- Detaiil Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- Modal Download -->
<div class="modal fade" id="ModalDownload" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="_page/Tindakan/ProsesDownloadTindakan.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-download"></i> Download Data Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_awal"><small>Periode Awal</small></label>
                            <input type="date" name="periode_awal" id="periode_awal" class="form-control">
                        </div> 
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_akhir"><small>Periode Akhir</small></label>
                            <input type="date" name="periode_akhir" id="periode_akhir" class="form-control">
                        </div> 
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <small>
                                    <b>PENTING!</b><br>
                                    Semakin besar data yang anda download, maka sistem akan membutuhkan waktu lebih lama untuk memprosesnya.
                                </small>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-download"></i> Download
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Informasi Jenis Diagnosis -->
<div class="modal fade" id="ModalInfo" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Informasi Jenis Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormInfo">
                <div class="row">
                    <div class="col-12">
                        <!-- Info Diagnosis Disini -->
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

<!-- Modal Diagnosis -->
 <div class="modal fade" id="ModalDiagnosis" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light"><i class="bi bi-file-medical"></i> Diagnosis Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDiagnosis">
                <!-- Form Diagnosis Disini -->
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Diagnosis -->
<div class="modal fade" id="ModalTambahDiagnosis" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahDiagnosis" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Diagnosis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormTambahDiagnosis">
                            <!-- Form Tambah Diagnosis -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahDiagnosis">
                            <!-- Notifikasi Tambah Diagnosis -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahDiagnosis">
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

<!-- Modal Detail Diagnosis -->
<div class="modal fade" id="ModalDetailDiagnosis" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailDiagnosis">
                <div class="row">
                    <div class="col-12">
                        <!-- Detaiil Diagnosis Disini -->
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

<!-- Edit Diagnosis -->
<div class="modal fade" id="ModalEditDiagnosis" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditDiagnosis" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Diagnosis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormEditDiagnosis">
                            <!-- Form Edit Diagnosis -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditDiagnosis">
                            <!-- Notifikasi Edit Diagnosis -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditDiagnosis">
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

<!-- Hapus Diagnosis -->
<div class="modal fade" id="ModalHapusDiagnosis" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusDiagnosis" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Diagnosis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapusDiagnosis">
                            <!-- Form Hapus Diagnosis -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusDiagnosis">
                            <!-- Notifikasi Hapus Diagnosis -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonHapusDiagnosis">
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

<!-- Kirim Resource Condition -->
<div class="modal fade" id="ModalKirimCondition" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimCondition" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-send"></i> Kirim <i>Condition</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormKirimCondition">
                            <!-- Form Kirim Condition -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiKirimCondition">
                            <!-- Notifikasi Kirim Condition -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonKirimCondition">
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

<!-- Detail Resource Condition -->
<div class="modal fade" id="ModalDetailCondition" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail <i>Condition</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12" id="FormDetailCondition">
                        <!-- Form Detail Condition -->
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

<!-- Edit Resource Condition -->
<div class="modal fade" id="ModalEditCondition" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditCondition" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit <i>Condition</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormEditCondition">
                            <!-- Form Edit Condition -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditCondition">
                            <!-- Notifikasi Edit Condition -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditCondition">
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

<!-- Download Diagnosis -->
<div class="modal fade" id="ModalDownload" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="_Page/Diagnosis/ProsesExportDiagnosis.php" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-download"></i> Download <i>Diagnosis</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_awal">
                                <small>Periode Awal</small>
                            </label>
                            <input type="date" name="periode_awal" id="periode_awal" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="periode_akhir">
                                <small>Periode Akhir</small>
                            </label>
                            <input type="date" name="periode_akhir" id="periode_akhir" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <b>Penting!</b> Semakin besar data maka semakin lama sistem membutuhkan waktu untuk memprosesnya!
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
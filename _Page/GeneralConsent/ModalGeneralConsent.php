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

<!-- Modal General Consent -->
 <div class="modal fade" id="ModalGeneralConsent" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-file-medical"></i> <i>General Consent</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormGeneralConsent">
                <!-- Form Diagnosis Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus General Consent -->
<div class="modal fade" id="ModalHapusGeneralConsent" tabindex="-1" aria-labelledby="ModalHapusGeneralConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusGeneralConsent" autocomplete="off">
                <div class="modal-header bg-danger-subtle">
                    <h5 class="modal-title">
                        <i class="bi bi-trah"></i> Hapus General Consent
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger-subtle">
                    <div class="row mb-2">
                        <div class="col-12" id="FormHapusGeneralConsent">
                            <!-- Form Hapus General Consent -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiHapusGeneralConsent">
                            <!-- Notifikasi Hapus General Consent -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-danger-subtle">
                    <button type="submit" disabled class="btn btn-md btn-primary ms-2" id="ButtonHapusGeneralConsent">
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

<!-- Modal Kirim Consent -->
<div class="modal fade" id="ModalKirimConsent" tabindex="-1" aria-labelledby="ModalKirimConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimConsent" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-send"></i> ID Consent (SATUSEHAT)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="FormKirimConsent">
                            <!-- Form Kirim Consent -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiKirimConsent">
                            <!-- Notifikasi Kirim Consent -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-primary ms-2" id="ButtonKirimConsent">
                        <i class="bi bi-send"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Detail Consent -->
<div class="modal fade" id="ModalDetailConsent" tabindex="-1" aria-labelledby="ModalDetailConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Consent (SATUSEHAT)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12" id="FormDetailConsent">
                        <!-- Form Detail Consent -->
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

<!-- Modal Download Consent -->
<div class="modal fade" id="ModalDownload" tabindex="-1" aria-labelledby="ModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/GeneralConsent/ProsesDownload.php" method="POST" autocomplete="off" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-download"></i> Export / Download</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12 mb-3">
                            <label for="periode_awal">
                                <small>Periode Awal</small>
                            </label>
                            <input type="date" class="form-control" name="periode_awal" id="periode_awal">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="periode_akhir">
                                <small>Periode Akhir</small>
                            </label>
                            <input type="date" class="form-control" name="periode_akhir" id="periode_akhir">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary ms-2" id="ButtonDownload">
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
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
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="datetime_observation">Tanggal</option>
                                <option value="category_name">Kategori</option>
                                <option value="observation_name">Observasi</option>
                                <option value="petugas_id">Petugas Observasi</option>
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
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="datetime_observation">Tanggal</option>
                                <option value="category_name">Kategori</option>
                                <option value="observation_name">Observasi</option>
                                <option value="petugas_id">Petugas Observasi</option>
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

<!--- Modal Tambah Observasi --->
<style>
    #ModalTambah #FormIdPasien .select2-container,
    #ModalTambah #FormIdKunjungan .select2-container,
    #ModalTambah #FormIdPraktisi .select2-container {
        display: block;
        width: 100% !important;
    }

    #ModalTambah #FormIdPasien .select2-selection--single,
    #ModalTambah #FormIdKunjungan .select2-selection--single,
    #ModalTambah #FormIdPraktisi .select2-selection--single {
        height: auto;
        min-height: calc(1.5em + .75rem + 2px);
        display: flex;
        align-items: center;
    }

    #ModalTambah #FormIdPasien .select2-selection--single .select2-selection__rendered,
    #ModalTambah #FormIdKunjungan .select2-selection--single .select2-selection__rendered,
    #ModalTambah #FormIdPraktisi .select2-selection--single .select2-selection__rendered {
        height: auto;
        white-space: normal;
        overflow: visible;
        text-overflow: clip;
        line-height: 1.2;
        padding: 0;
    }

    #ModalTambah #FormIdPasien .select2-selection__arrow,
    #ModalTambah #FormIdKunjungan .select2-selection__arrow,
    #ModalTambah #FormIdPraktisi .select2-selection__arrow {
        height: 100%;
    }
</style>
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambah" autocomplete="off">
                <input type="hidden" name="timezone_user" id="timezone_user" value="">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Hasil Observasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                <b>A. Informasi Pasien & Kunjungan</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_pasien">
                                <small>* No.RM / Nama Pasien</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormIdPasien">
                            <select name="id_pasien" id="id_pasien" class="form-control">
                                <option value="">Cari & Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="id_kunjungan">
                                <small>* ID Kunjungan Pasien</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormIdKunjungan">
                            <select name="id_kunjungan" id="id_kunjungan" class="form-control">
                                <option value="">Cari & Pilih</option>
                            </select>
                        </div>
                    </div>

                    <hr class="mt-3">

                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                <b>B. Petugas Pemeriksa</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="id_praktisi">
                                <small>* Nama Petugas</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormIdPraktisi">
                            <select name="id_praktisi" id="id_praktisi" class="form-control">
                                <option value="">Cari & Pilih</option>
                            </select>
                        </div>
                    </div>

                    <hr class="mt-3">

                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                <b>C. Referensi Observasi</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="category_name">
                                <small>* Kategori Observasi</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormCategpryName">
                            <select name="category_name" id="category_name" class="form-control">
                                <option value="">Cari & Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="id_observation_reference">
                                <small>* Jenis Observasi</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormObservationReference">
                            <select name="id_observation_reference" id="id_observation_reference" class="form-control">
                                <option value="">Cari & Pilih</option>
                            </select>
                        </div>
                    </div>

                    <hr class="mt-3">

                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                <b>D. Hasil / Nilai</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="observation_value">
                                <small>* Nilai / Hasil</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormObservationValue">
                            <!-- Form Dinamis Akan Muncul Disini -->
                        </div>
                    </div>

                    <hr class="mt-3">

                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                <b>E. Waktu Observasi</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_observasi">
                                <small>* Tanggal Observasi</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormTanggalObservasi">
                            <input type="date" required name="tanggal_observasi" id="tanggal_observasi" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jam_observasi">
                                <small>* Jam Observasi</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormJamObservasi">
                            <input type="time" required name="jam_observasi" id="jam_observasi" class="form-control">
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
                        <i class="bi bi-floppy"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

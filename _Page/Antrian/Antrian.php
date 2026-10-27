<!-- Kerangka halaman antrean; baris tabel dan kontrol paginasi diisi oleh Antrian.js. -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-ticket-perforated"></i> Antrian</a>
                    </h5>
                    <p class="m-b-0">Kelola Antrian Pasien</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                
                <!-- Area utama berisi filter, tambah antrean, tabel, dan navigasi halaman. -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                            <i class="bi bi-filter"></i>
                                        </button>
                                        <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambah" title="Tambah Antrian baru">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center"><small>No</small></th>
                                                <th scope="col"><small>Nama</small></th>
                                                <th scope="col"><small>Kode Booking</small></th>
                                                <th scope="col"><small>Daftar</small></th>
                                                <th scope="col"><small>Rencana Kunjungan</small></th>
                                                <th scope="col"><small>Poliklinik</small></th>
                                                <th scope="col"><small>Dokter</small></th>
                                                <th scope="col"><small>Jadwal</small></th>
                                                <th scope="col" class="text-center"><small>RM</small></th>
                                                <th scope="col" class="text-center"><small>Kunjungan</small></th>
                                                <th scope="col" class="text-center"><small>Sumber</small></th>
                                                <th scope="col" class="text-center"><small>Status</small></th>
                                                <th scope="col" class="text-center"><small>Opsi</small></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_antrian">
                                            <!-- JavaScript mengganti placeholder ini dengan baris hasil dari TabelAntrian.php. -->
                                            <tr>
                                                <td align="center" colspan="13">
                                                <span class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Memuat"></span>
                                                <small class="text text-muted">Memuat data antrian...</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Informasi halaman dan tombol navigasi tabel. -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <small id="page_info">0 / 0</small>
                                    </div>
                                    <div class="col-6 text-end icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

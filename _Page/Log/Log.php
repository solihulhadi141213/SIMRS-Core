<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-record"></i> Log Aktivitas Pengguna</a>
                    </h5>
                    <p class="m-b-0">Audit Log Aktivitas Pengguna</p>
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
                
                <div class="row">
                    <div class="col-md-8">

                        <!-- Chart Aktivitas Pengguna -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">
                                            <i class="bi bi-bar-chart"></i> Log Aktivitas
                                        </h5>
                                    </div>
                                    <div class="col-4 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalPeriodeGrafik" title="Periode Grafik">
                                            <i class="bi bi-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="grafik_aktivitas">
                                <!-- Menampilkan Grafik Log Aktivitas -->
                            </div>
                        </div>

                        <!-- Tabel Aktivitas LOG-->
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">
                                            <i class="bi bi-table"></i> Log Aktivitas
                                        </h5>
                                    </div>
                                    <div class="col-4 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ModalExportLog" title="Export Log">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button type="button" class="btn btn-md btn-icon btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalFilterLog" title="Filter Log">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <td align="center"><small><b>No</b></small></td>
                                                <td align="left"><small><b>Nama Pengguna</b></small></td>
                                                <td align="left"><small><b>Kategori</b></small></td>
                                                <td align="cleftnter"><small><b>Aktivitas</b></small></td>
                                                <td align="left"><small><b><i>Datetime</i></b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_log">
                                            <!-- Tabel Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="5">
                                                <span class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Memuat"></span>
                                                <small class="text text-muted">Memuat data trian...</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

                    <div class="col-md-4">
                        <!-- RIWAYAT AKTIVITAS PENGGUNA -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">
                                            <i class="bi bi-person-lines-fill"></i> Riwayat Aktivitas Pengguna
                                        </h5>
                                    </div>
                                    <div class="col-4 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalFilterPengguna" title="Filter Pengguna">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Menampilkan List Pengguna -->
                                <div class="table table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <td align="center"><small><b>No</b></small></td>
                                                <td align="left"><small><b>Pengguna</b></small></td>
                                                <td align="left"><small><b>Log</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="list_pengguna">
                                            <!-- Tabel Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="3">
                                                <span class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Memuat"></span>
                                                <small class="text text-muted">Memuat data ...</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <small id="page_info_pengguna">0 / 0</small>
                                    </div>
                                    <div class="col-6 text-end icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page_pengguna">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page_pengguna">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- LOG BERDASARKAN KATEGORI -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">
                                            <i class="bi bi-tags"></i> Log Kategori
                                        </h5>
                                    </div>
                                    <div class="col-4 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalFilterKategori" title="Filter Kategori">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Menampilkan List Kategori -->
                                <div class="table table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <td align="center"><small><b>No</b></small></td>
                                                <td align="left"><small><b>Kategori</b></small></td>
                                                <td align="left"><small><b>Log</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="list_kategori">
                                            <!-- Tabel Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="3">
                                                <span class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Memuat"></span>
                                                <small class="text text-muted">Memuat data...</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <small id="page_info_pengguna">0 / 0</small>
                                    </div>
                                    <div class="col-6 text-end icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page_kategori">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page_kategori">
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

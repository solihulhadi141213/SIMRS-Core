<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-exclamation-circle"></i> Laporan Kesalahan</a>
                    </h5>
                    <p class="m-b-0">Kelola Laporan Kesalahan Yang Dikirim User, Lakukan Tindak Lanjut Dan Response Laporan</p>
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

                <!-- Apabila ada masalah saat menampilkan dashboard -->
                <div class="dashboard_problem"></div>

                <!-- Card Dashboard -->
                <div class="row mb-2">
                    
                    <!-- Semua -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card stat-card filter_status" style="cursor:pointer;" data-id="Semua">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-secondary">
                                    <i class="bi bi-filetype-doc"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 fw-bold" id="jumlah_semua">-</h4>
                                    Semua
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terkirim -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card stat-card filter_status" style="cursor:pointer;" data-id="Terkirim">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-danger">
                                    <i class="bi bi-bell"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 fw-bold" id="jumlah_terkirim">-</h4>
                                    Terkirim
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dibaca -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card stat-card filter_status" style="cursor:pointer;" data-id="Dibaca">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-warning">
                                    <i class="bi bi-eye"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 fw-bold" id="jumlah_dibaca">-</h4>
                                    Dibaca
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card stat-card filter_status" style="cursor:pointer;" data-id="Selesai">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 fw-bold" id="jumlah_selesai">-</h4>
                                    Selesai
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Tabel Setting -->
                <div class="row mb-3">
                    <div class="col-12" id="data_setting">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                            <i class="bi bi-filter"></i>
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
                                                <td align="left"><small><b>Nama User</b></small></td>
                                                <td align="left"><small><b>Tanggal Laporan</b></small></td>
                                                <td align="left"><small><b>Judul Laporan</b></small></td>
                                                <td align="center"><small><b>Status</b></small></td>
                                                <td align="center"><small><b>Opsi</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_laporan_kesalahan">
                                            <!-- Tabel Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="6">
                                                    <small class="text text-muted">No Data</small>
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
                </div>
                
            </div>
        </div>
    </div>
</div>

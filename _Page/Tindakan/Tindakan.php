<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-file-earmark-medical"></i> Tindakan (<i>Procedure</i>)</a>
                    </h5>
                    <p class="m-b-0">Kelola data Tindakan (<i>Procedure</i>) pasien secara parsial pada setiap kunjungan dan lakukan monitoring capaian kelengkapan informasi.</p>
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
                
                <!-- TABEL VIEW -->
                <div id="table_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <b class="card-title">Tindakan - Kunjungan</b>
                                        </div>
                                        <div class="col-6 text-end icon-btn">
                                            <button type="button" class="btn btn-md btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalInfo" title="Keterangan Tindakan (<i>Procedure</i>)">
                                                <i class="bi bi-info"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalDownload" title="Download Tindakan (<i>Procedure</i>)">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                                <i class="bi bi-filter"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-sm align-middle">
                                            <thead>
                                                <tr>
                                                    <td align="center" class="align-middle"><small><b>No</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Nama</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>RM</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Tanggal</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Tujuan</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Poli</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Kelas</b></small></td>
                                                    <td align="center"><small><b>Tindakan</b></small></td>
                                                    <td align="center"><small><b><i>Procedure</i></b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_tindakan">
                                                <!-- Baris Tabel Akan Tampil Disini -->
                                                <tr>
                                                    <td align="center" colspan="9">
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

                <!-- DETAIL VIEW -->
                <div id="detail_view">
                    <div class="row">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <b class="card-title">
                                                <i class="bi bi-info-circle"></i> Detail Tindakan
                                            </b>
                                        </div>
                                        <div class="col-6 text-end icon-btn">
                                            <button type="button" class="btn btn-md btn-icon btn-dark back_to_data" title="Kembali Ke Data Tindakan">
                                                <i class="bi bi-chevron-double-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-dark reload_tindakan" title="Reload Data">
                                                <i class="bi bi-repeat"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="FormTindakan">
                                    <!-- Form Tindakan Ditampilkan Disini -->
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12" id="footer_detail_tindakan">

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
</div>

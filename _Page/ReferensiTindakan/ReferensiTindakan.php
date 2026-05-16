<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-file-earmark-medical"></i> Referensi Tindakan (<i>Procedure</i>)</a>
                    </h5>
                    <p class="m-b-0">Kelola Referensi Tindakan <i>(Procedure)</i> Serta <i>Mapping</i> Terhadap Referensi ICD9 dan SNOMED</p>
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
                                        <div class="col-12 text-end icon-btn">
                                            <button type="button" class="btn btn-md btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalDownload" title="Download Diagnosis">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                                <i class="bi bi-filter"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambah" title="Filter Data">
                                                <i class="bi bi-plus"></i>
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
                                                    <td align="left" class="align-middle"><small><b>Kategori</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Tindakan</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Lokasi Tubuh</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>ICD 9</b></small></td>
                                                    <td align="center"><small><b>Status</b></small></td>
                                                    <td align="center"><small><b><i>Condition</i></b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_referensi_tindakan">
                                                <!-- Baris Tabel Akan Tampil Disini -->
                                                <tr>
                                                    <td align="center" colspan="7">
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
</div>

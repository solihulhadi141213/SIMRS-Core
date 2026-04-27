<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-book"></i> ICD</a>
                    </h5>
                    <p class="m-b-0">Kelola Referensi Diagnosis dan Procedure ICD 9 dan ICD 10</p>
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
                
                <!-- DATA -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-4">
                                        <button type="button" class="btn btn-sm rounded-1 btn-outline-secondary version_title" data-bs-toggle="dropdown">
                                            <i class="bi bi-chevron-down"></i> ICD10
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li>
                                                <a class="dropdown-item version_icd" href="javascript:void(0)" data-id="ICD9">ICD9</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item version_icd" href="javascript:void(0)" data-id="ICD10">ICD10</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item version_icd" href="javascript:void(0)" data-id="ICD11">ICD11</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-8 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-outline-secondary" data-bs-toggle="dropdown" title="Export Data">
                                            <i class="bi bi-filetype-xlsx"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li>
                                                <a class="dropdown-item modal_download" href="javascript:void(0)" data-id="ICD9">Download / Export ICD</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item modal_upload" href="javascript:void(0)" data-id="ICD10">Upload / Import</a>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                            <i class="bi bi-filter"></i>
                                        </button>
                                        <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahIcd" title="Tambah Data ICD">
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
                                                <td align="center"><small><b>No</b></small></td>
                                                <td align="left"><small><b>ICD</b></small></td>
                                                <td align="left"><small><b>Kode</b></small></td>
                                                <td align="left"><small><b><i>Short Description</i></b></small></td>
                                                <td align="left"><small><b><i>Long Description</i></b></small></td>
                                                <td align="center"><small><b>Opsi</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_icd">
                                            <!-- Konten Google Credential Akan Tampil Disini -->
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

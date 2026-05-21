<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-file-earmark-medical"></i> Referensi Alergen (<i>Allergens</i>)</a>
                    </h5>
                    <p class="m-b-0"><i>Mapping</i> Referensi Alergen <i>(Allergens)</i> Berdasarkan Kode SNOMED CT</p>
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
                                            <button type="button" class="btn btn-md btn-icon btn-outline-dark" data-bs-toggle="dropdown">
                                                <i class="bi bi-filetype-xlsx"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-header text-start"><h6>Option</h6></li>
                                                <li>
                                                    <a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalDownload" title="Download Allergens">
                                                        <i class="bi bi-download"></i> Download / Export
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalUpload" title="Upload Allergens">
                                                        <i class="bi bi-upload"></i> Upload / Import
                                                    </a>
                                                </li>
                                            </ul>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                                <i class="bi bi-filter"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambah" title="Tambah Data">
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
                                                    <td align="left" class="align-middle"><small><b>Alergen</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Kategori</b></small></td>
                                                    <td align="left" class="align-middle"><small><b><i>Code</i></b></small></td>
                                                    <td align="left" class="align-middle"><small><b><i>Display</i></b></small></td>
                                                    <td align="left" class="align-middle"><small><b><i>System</i></b></small></td>
                                                    <td align="center"><small><b><i>Active</i></b></small></td>
                                                    <td align="center"><small><b>Opsi</b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_alergen">
                                                <!-- Baris Tabel Akan Tampil Disini -->
                                                <tr>
                                                    <td align="center" colspan="8">
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

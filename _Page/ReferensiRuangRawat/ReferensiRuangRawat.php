<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-building"></i> Kelas, Ruang Rawat dan Tempat Tidur</a>
                    </h5>
                    <p class="m-b-0">Kelola Referensi Kelas Rawat. Ruangan dan Tempat Tidur Yang Tersedia</p>
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
                                    <div class="col-8">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark rounded-1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i> APlicare
                                        </a>
                                        <ul class="dropdown-menu shadow">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_aplicare">
                                                    <i class="bi bi-list"></i> Preview Aplicare
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_update_aplicare">
                                                    <i class="bi bi-repeat"></i> Update Aplicare
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                            <i class="bi bi-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahKelas" title="Tambah Kelas Rawat">
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
                                                <td align="left"><small><b>Kelas</b></small></td>
                                                <td align="left"><small><b>Kode</b></small></td>
                                                <td align="left"><small><b>Ruangan</b></small></td>
                                                <td align="left"><small><b>Tempat Tidur</b></small></td>
                                                <td align="left"><small><b><i>Updated At</i></b></small></td>
                                                <td align="center"><small><b><i>Status</i></b></small></td>
                                                <td align="center"><small><b>Opsi</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_kelas_rawat">
                                            <!-- Konten Akan Tampil Disini -->
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

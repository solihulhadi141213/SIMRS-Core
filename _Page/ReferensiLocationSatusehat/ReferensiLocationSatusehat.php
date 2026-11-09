<?php
    if(GetStatusAccess($Conn, $SessionIdAkses, 'uYR8rqHLXq')==false){
        include "_Page/Error/no_access_permission.php";
    }else{
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="bi bi-map"></i> Location</a>
                        </h5>
                        <p class="m-b-0">Kelola Data Location Faskes (SATUSEHAT)</p>
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
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambah" title="Tambah Referensi Imunisasi">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        <b>No</b>
                                                    </th>
                                                    <th>
                                                        <b>Nama Lokasi</b>
                                                    </th>
                                                    <th>
                                                        <b>ID Location</b>
                                                    </th>
                                                    <th>
                                                        <b>Mode</b>
                                                    </th>
                                                    <th class="text-center">
                                                        <b>Type</b>
                                                    </th>
                                                    <th class="text-center">
                                                        <small><b>Status</b></small>
                                                    </th>
                                                    <th class="text-center">
                                                        <small><b>Default</b></small>
                                                    </th>
                                                    <th class="text-center">
                                                        <small><b>Opsi</b></small>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_locatiohn">
                                                <!-- JavaScript mengganti placeholder ini dengan baris hasil dari '_Page\ReferensiLocationSatusehat\TabelReferensiLocationSatusehat.php' -->
                                                <tr>
                                                    <td align="center" colspan="8">
                                                    <span class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Memuat"></span>
                                                    <small class="text text-muted">Memuat data...</small>
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
<?php } ?>

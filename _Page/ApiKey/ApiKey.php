<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-key-fill"></i> API Key</a>
                    </h5>
                    <p class="m-b-0">Kelola Data API Key Untuk Mengautentikasi <i>Resource</i> Yang Tersedia</p>
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

                <!-- Tabel Setting -->
                <div class="row mb-3">
                    <div class="col-12" id="data_setting">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahApiKey" title="Tambah API Key">
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
                                                <td align="left"><small><b>Nama API</b></small></td>
                                                <td align="left"><small><b>Client ID</b></small></td>
                                                <td align="left"><small><b><i>Expired Duration</i></b></small></td>
                                                <td align="left"><small><b><i>Creat At</i></b></small></td>
                                                <td align="left"><small><b><i>Update At</i></b></small></td>
                                                <td align="left"><small><b><i>Log Token</i></b></small></td>
                                                <td align="center"><small><b>Opsi</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_api_key">
                                            <!-- Konten API Key Akan Tampil Disini -->
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
                                <small id="page_info">Data : </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    date_default_timezone_set('Asia/Jakarta');
    //memangil setting akses
    // include "_Config/SettingAkses.php";
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'J7pODP9bSV');
    if($StatusAkses!=="Yes"){
        include "_Page/UnPage/ErrorPage.php";
    }else{
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5">
                                <i class="ti ti-plug"></i> Koneksi Analyza
                            </a>
                        </h5>
                        <p class="m-b-0">Pengaturan koneksi dengan aplikasi Analyza</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">

                        <div class="card-header text-end">
                            <button type="button" class="btn btn-md btn-primary btn-round" data-toggle="modal" data-target="#ModalTambah" title="Tambah Profil Pengaturan">
                                <i class="ti ti-plus"></i> Buat Profil Koneksi
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td align="center"><dt>No</dt></td>
                                            <td><dt>Nama Pengaturan</dt></td>
                                            <td><dt>Base URL</dt></td>
                                            <td><dt>Username</dt></td>
                                            <td><dt>Password</dt></td>
                                            <td><dt>Token</dt></td>
                                            <td><dt>Expired At</dt></td>
                                            <td align="center"><dt>Status</dt></td>
                                            <td align="center"><dt>Option</dt></td>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelData">
                                        <tr>
                                            <td colspan="9" class="text-center">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <span id="page_info">Data Count : 0</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php 
    }
?>
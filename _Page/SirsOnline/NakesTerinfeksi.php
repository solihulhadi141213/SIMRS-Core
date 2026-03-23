<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'APzGdlAT7w');
    if($StatusAkses=="Yes"){
        include "_Config/SimrsFunction.php";
        include "_Config/FungsiSirsOnline.php";
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-4 mb-3 text-left">
                                            <h4>
                                                <i class="icofont-search-document"></i> Data Nakes Terinfeksi
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-block btn-md btn-secondary" data-toggle="modal" data-target="#ModalFilterNakesTerinfeksi">
                                                <i class="ti ti-filter"></i> Filter/Cari
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-block btn-md btn-info" data-toggle="modal" data-target="#ModalRekapNakesTerinfeksi">
                                                <i class="ti ti-pie-chart"></i> Rekap
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-block btn-md btn-info" data-toggle="modal" data-target="#ModalNakesTerinfeksiSirsOnline">
                                                <i class="ti ti-world"></i> SIRS Online
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-block btn-md btn-primary" data-toggle="modal" data-target="#ModalTambahNakesTerinfeksi">
                                                <i class="ti ti-plus"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanTabelNakesTerinfeksi"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>
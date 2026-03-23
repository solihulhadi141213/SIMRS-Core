<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'oHfxmmTlbs');
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
                        <div class="col-xl-12 col-md-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-7 mb-3">
                                            <h4>
                                                <i class="ti ti-server"></i> Daftar Laporan Inventaris Oksigen
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilterOksigen">
                                                <i class="ti ti-filter"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahOksigen">
                                                <i class="ti ti-plus"></i> Buat Laporan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanTabelLaporanOksigen">

                                </div>
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
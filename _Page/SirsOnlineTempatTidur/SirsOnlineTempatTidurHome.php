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
                                        <div class="col-md-8 mb-3">
                                            <h4>
                                                <i class="ti ti-server"></i> Daftar Tempat Tidur
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-primary" id="MasterTempatTidur">
                                                <i class="ti ti-server"></i> Tempat Tidur
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-outline-primary" id="SettingTempatTidur">
                                                <i class="ti ti-settings"></i> Setting
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanTabelTempatTidurSirsOnline">

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
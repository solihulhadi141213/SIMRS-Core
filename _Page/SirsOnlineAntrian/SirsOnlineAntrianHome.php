<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'2x0lxkHKI7');
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
                                            <h4 id="TitleHalaman">
                                                <i class="ti ti-server"></i> Antrian SIMRS (Local)
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-info" id="TampilkanAntrianSimrs">
                                                <i class="ti ti-server"></i> SIMRS
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-outline-info" id="TampilkanAntrianSirsOnline">
                                                <i class="ti ti-world"></i> SIRS Online
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanKontenAntrian">

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
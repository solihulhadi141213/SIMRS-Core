<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'MnNZjUXe1h');
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
                                                <i class="ti ti-server"></i> Data Laporan Alkes SIRS Online
                                            </h4>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-outline-info" data-toggle="modal" data-target="#ModalReferensiAlkes">
                                                <i class="ti ti-world"></i> Referensi SIRS Online
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanTabelAlkes">

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
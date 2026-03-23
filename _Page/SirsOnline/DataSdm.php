<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'Ic1Bn4K9BN');
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
                                        <div class="col-md-6 mb-3">
                                            <h4>
                                                <i class="icofont-search-document"></i> Nakes/SDM Fasyankes
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-info" id="TampilkanNakesSimrs">
                                                <i class="ti ti-server"></i> SIMRS
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-outline-info" id="TampilkanNakesSirsOnline">
                                                <i class="ti ti-world"></i> SIRS Online
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="button" class="btn btn-md btn-block btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                                <i class="ti ti-plus"></i> Tambah SDM
                                            </button>
                                            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalTambahNakes">
                                                    <i class="ti-pencil"></i> Tambah Manual
                                                </a>
                                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalPilihPractitioner">
                                                    <i class="ti ti-check-box"></i> Practitioner
                                                </a>
                                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalPilihDokter">
                                                    <i class="ti ti-check-box"></i> Dokter
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanTabelSdm">
                                    
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
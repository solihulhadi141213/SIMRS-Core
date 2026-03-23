<?php
    date_default_timezone_set('Asia/Jakarta');
    //memangil setting akses
    // include "_Config/SettingAkses.php";
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'X24wwoFCTd');
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
                            <a href="" class="h5"><i class="icofont-laboratory"></i> Laboratorium V.2</a>
                        </h5>
                        <p class="m-b-0">Kelola Pelayanan Pemeriksaan Laboratorium Yang Terintegrasi Dengan Aplikasi Analyza</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        // include "_Config/SimrsFunction.php";
        // if(empty($_GET['Sub'])){
        //     include "_Page/Laboratorium2/LaboratoriumHome.php";
        // }else{
        //     $Sub=$_GET['Sub'];
        //     if($Sub=="Tambah"){
        //         include "_Page/Laboratorium2/FormTambah.php";
        //     }else{
        //         if($Sub=="Detail"){
        //             include "_Page/Laboratorium2/_Detail.php";
        //         }else{
        //             include "_Page/Laboratorium2/LaboratoriumHome.php";
        //         }
        //     }
        // }
    ?>
    <div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="data_laboratorium">
                    <div class="row mb-3">
                        <div class="col-md-8 mb-3"></div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilter" title="Filter Data Laboratorium">
                                <i class="ti ti-filter"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary form_tambah_laboratorium" title="Tambah Pendaftaran Laboratorium">
                                <i class="ti-plus text-white"></i> Tambah
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="ListLaboratorium">
                            <!-- Data Laboratorium Akan Muncul Disini -->
                            <div class="alert alert-danger text-center">
                                Load Data From Server ..
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-dark" id="prev_rad">
                                    <i class="ti ti-angle-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-dark" id="page_info_rad">
                                    0 / 0
                                </button>
                                <button type="button" class="btn btn-sm btn-dark" id="next_rad">
                                    <i class="ti ti-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tambah_laboratorium"></div>
                <div class="detail_laboratorium"></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


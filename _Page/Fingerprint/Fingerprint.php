<?php 
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'zjmuixVRWq');
    if($StatusAkses=="Yes"){ 
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="index.php?Page=Fingerprint" class="h5">
                            <i class="icofont-finger-print"></i> Data List Fingerprint
                            </a>
                        </h5>
                        <p class="m-b-0">Kelola Data Finger Print</p>
                    </div>
                </div>
                <div class="col-md-8 text-right">
                    <button type="button" class="btn btn-md btn-primary btn-round mr-2 mt-2" data-toggle="modal" data-target="#ModalCariFingerPrint">
                        <i class="icofont-search-job"></i> Pencarian Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Menampilkan Record Fingerprint Dari Vclaim</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12" id="DataFingerprint">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="styleSelector">

            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
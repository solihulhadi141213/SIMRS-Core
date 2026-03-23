<?php 
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'j94LphHBqV');
    if($StatusAkses=="Yes"){ 
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="index.php?Page=JadwalDokter" class="h5">
                                <i class="icofont-listine-dots"></i> Monitoring
                            </a>
                        </h5>
                        <p class="m-b-0">Menampilkan data monitoring kunjungan, klaim, pelayanan peserta dan klaim jasa raharja</p>
                    </div>
                </div>
                <div class="col-md-7 text-right">
                    <button class="btn btn-md btn-inverse mr-2 mt-2" id="TabKunjungan">
                        Kunjungan
                    </button>
                    <button class="btn btn-md btn-primary mr-2 mt-2" id="TabKlaim">
                        Klaim
                    </button>
                    <button class="btn btn-md btn-primary mr-2 mt-2" id="TabPelayananPeserta">
                        Pelayanan Peserta
                    </button>
                    <button class="btn btn-md btn-primary mr-2 mt-2" id="TabJasaRaharja">
                        Jasa Raharja
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
                                        <div class="col col-md-12">
                                            <h4 id="TitleCard">Monitoring Kunjungan</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="MenampilkanDataMonitoring">
                                    
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
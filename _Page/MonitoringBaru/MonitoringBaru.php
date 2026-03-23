<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-desktop"></i> Laporan Rekam Medis</a>
                    </h5>
                    <p class="m-b-0">Lihat data kunjungan SEP, klaim, klaim, dan rujukan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    //Untuk versi ini routing halaman dilakukan pada file MonitoringBaruHome.php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'L8dpIdlwnb');
    if($StatusAkses=="Yes"){ 
        if(!empty($_GET['Sub'])){
            $SubPage=$_GET['Sub'];
            if($SubPage=="Home"){
                include "_Page/MonitoringBaru/MonitoringBaruHome.php";
            }else{
                
            }
        }else{
            $SubPage="";
            include "_Page/MonitoringBaru/MonitoringBaruHome.php";
        }
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>
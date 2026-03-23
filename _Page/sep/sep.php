<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti-write"></i> Surat Eligibilitas Peserta (SEP)</a>
                    </h5>
                    <p class="m-b-0">Kelola Data SEP, Ubah status SEP, Lihat list data SEP.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'znGzSzLoEs');
    if($StatusAkses=="Yes"){
        if(!empty($_GET['Sub'])){
            $SubPage=$_GET['Sub'];
            if($SubPage=="Home"){
                include "_Page/sep/SepHome.php";
            }else{
                if($SubPage=="BuatSep"){
                    include "_Page/sep/BuatSep.php";
                }else{
                    if($SubPage=="DetailSep"){
                        include "_Page/sep/DetailSep.php";
                    }else{
                        include "_Page/sep/SepHome.php";
                    }
                }
            }
        }else{
            $SubPage="";
            include "_Page/sep/SepHome.php";
        }
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>
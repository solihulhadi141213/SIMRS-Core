<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-comment-alt"></i> Antrian SIRS Online</a>
                    </h5>
                    <p class="m-b-0">Menghubungkan antara data Antrian di SIMRS dengan SIRS online Kemenkes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($_GET['Sub'])){
        $SubPage=$_GET['Sub'];
        if($SubPage=="DetailAntrian"){
            include "_Page/SirsOnlineAntrian/DetailAntrian.php";
        }else{
            include "_Page/SirsOnlineAntrian/SirsOnlineAntrianHome.php";
        }
    }else{
        include "_Page/SirsOnlineAntrian/SirsOnlineAntrianHome.php";
    }
?>
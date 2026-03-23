<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-air-balloon"></i> Inventaris Oksigen</a>
                    </h5>
                    <p class="m-b-0">Daftar laporan oksigen untuk SIRS online Kemenkes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($_GET['Sub'])){
        $SubPage=$_GET['Sub'];
        if($SubPage=="DetailOksigen"){
            include "_Page/SirsOnlineOksigen/DetailOksigen.php";
        }else{
            include "_Page/SirsOnlineOksigen/SirsOnlineOksigenHome.php";
        }
    }else{
        include "_Page/SirsOnlineOksigen/SirsOnlineOksigenHome.php";
    }
?>
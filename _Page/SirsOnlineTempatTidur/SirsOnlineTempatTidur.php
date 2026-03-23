<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-hospital"></i> Tempat Tidur</a>
                    </h5>
                    <p class="m-b-0">Data Tempat Tidur SIRS online Kemenkes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($_GET['Sub'])){
        $SubPage=$_GET['Sub'];
        if($SubPage=="DetailOksigen"){
            include "_Page/SirsOnlineTempatTidur/DetailOksigen.php";
        }else{
            include "_Page/SirsOnlineTempatTidur/SirsOnlineTempatTidurHome.php";
        }
    }else{
        include "_Page/SirsOnlineTempatTidur/SirsOnlineTempatTidurHome.php";
    }
?>
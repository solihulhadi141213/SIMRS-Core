<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-box"></i> Alkes SIRS Online</a>
                    </h5>
                    <p class="m-b-0">Kelola data Alkes di SIRS online Kemenkes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($_GET['Sub'])){
        $SubPage=$_GET['Sub'];
        if($SubPage=="DetailAlkes"){
            include "_Page/SirsOnlineAlkes/DetailAlkes.php";
        }else{
            include "_Page/SirsOnlineAlkes/SirsOnlineAlkesHome.php";
        }
    }else{
        include "_Page/SirsOnlineAlkes/SirsOnlineAlkesHome.php";
    }
?>
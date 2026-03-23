<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="" class="h5"><i class="icofont-ui-social-link"></i> Referensi</a></h5>
                    <p class="m-b-0">Kelola Data Referensi Dan Kelengkapan Rumah Sakit</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(empty($_GET['Sub'])){
        include "_Page/Alergi/AlergiHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailAlergi"){
            include "_Page/Alergi/DetailAlergi.php";
        }else{
            include "_Page/Alergi/AlergiHome.php";
        }
    }
?>
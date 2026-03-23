<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="" class="h5"><i class="icofont-map"></i> Wilayah</a></h5>
                    <p class="m-b-0">Kelola Data Wilayah Administrasi Seluruh Indonesia Berdasarkan Referensi</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(empty($_GET['Sub'])){
        include "_Page/Wilayah/WilayahInternal.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Internal"){
            include "_Page/Wilayah/WilayahInternal.php";
        }else{
            if($Sub=="BPJS"){
                include "_Page/Wilayah/WilayahBpjs.php";
            }else{
                if($Sub=="Mendagri"){
                    include "_Page/Wilayah/WilayahMendagri.php";
                }else{
                    include "_Page/Wilayah/WilayahInternal.php";
                }
            }
        }
    }
?>
<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'c0YwXbjTPo');
    if($StatusAkses=="Yes"){
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-capsule"></i> Obat & Alkes</a>
                    </h5>
                    <p class="m-b-0">
                        Halaman ini digunakan untuk mengelola data obat dan alkes dari mulai jenis item, harga, satuan dan stok.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    if(empty($_GET['Sub'])){
                        include "_Page/Obat/ObatHome.php";
                    }else{
                        $Sub=$_GET['Sub'];
                        if($Sub=="DetailObat"){
                            include "_Page/Obat/DetailObat.php";
                        }else{
                            if($Sub=="TambahMedication"){
                                include "_Page/Obat/DetailObat.php";
                            }else{
                                include "_Page/Obat/ObatHome.php";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
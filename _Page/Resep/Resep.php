<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'olW5uQFC1H');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-notepad"></i> Resep</a>
                        </h5>
                        <p class="m-b-0">Kelola data resep masuk dari dokter, cetak etiket obat dan pencatatan transaksi obat sesuai resep.</p>
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
                            include "_Page/Resep/ResepHome.php";
                        }else{
                            $Sub=$_GET['Sub'];
                            if($Sub=="DetailResep"){
                                include "_Page/Resep/DetailResep.php";
                            }else{
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
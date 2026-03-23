<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'v2BiFR0ehy');
    if($StatusAkses=="Yes"){
        $JumlahLaporan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-box"></i> Stok Opename</a>
                        </h5>
                        <p class="m-b-0">Kelola data rekapitulasi stok, pemeriksaan dan evaluasi jumlah stok barang.</p>
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
                            include "_Page/StokOpename/StokOpenameHome.php";
                        }else{
                            $Sub=$_GET['Sub'];
                            if($Sub=="StokOpenameByStorage"){
                                include "_Page/StokOpename/StokOpenameByStorage.php";
                            }else{
                                if($Sub=="DetailSesiStokOpename"){
                                    include "_Page/StokOpename/DetailSesiStokOpename.php";
                                }else{
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
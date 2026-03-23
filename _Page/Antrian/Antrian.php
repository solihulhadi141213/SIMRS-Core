<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'PfDEKKimeh');
    if($StatusAkses=="Yes"){
        $JumlahLaporan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
        $JumlahResponse=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE response!=''"));
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="ti-ticket"></i> Antrian</a>
                        </h5>
                        <p class="m-b-0">Kelola data antrian pasien offline maupun antrian online.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <?php
                                if(empty($_GET['Sub'])){
                                    include "_Page/Antrian/AntrianHome.php";
                                }else{
                                    $Sub=$_GET['Sub'];
                                    if($Sub=="TambahAntrian"){
                                        include "_Page/Antrian/TambahAntrian.php";
                                    }else{
                                        if($Sub=="DetailAntrian"){
                                            include "_Page/Antrian/DetailAntrian.php";
                                        }else{
                                            include "_Page/Antrian/AntrianHome.php";
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
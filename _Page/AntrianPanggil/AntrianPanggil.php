<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'PfDEKKimeh');
    if($StatusAkses!=="Yes"){
        include "_Page/UnPage/ErrorPage.php";
    }else{
        $JumlahLaporan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
        $JumlahResponse=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE response!=''"));
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="ti-ticket"></i> Antrian Panggil</a>
                        </h5>
                        <p class="m-b-0">Berikut ini adalah halaman antrian panggil yang digunakan untuk mengelola data antrian poli</p>
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
                                    include "_Page/AntrianPanggil/AntrianPanggilHome.php";
                                }else{
                                    $Sub=$_GET['Sub'];
                                    if($Sub=="DetailAntrianPanggil"){
                                        include "_Page/AntrianPanggil/DetailAntrianPanggil.php";
                                    }else{
                                        include "_Page/AntrianPanggil/AntrianPanggilHome.php";
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
    }
?>
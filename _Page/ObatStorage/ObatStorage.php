<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'ScbnsZcVvq');
    if($StatusAkses=="Yes"){
        //Hitung Jumlah Storage
        $JumlaStorage = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_storage"));
        //Jumlah item obat di penyimpanan utama
        $jumlahItemUtama = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
        //Mencari data oat paling tua
        $QryObat = mysqli_query($Conn,"SELECT * FROM obat ORDER BY id_obat ASC")or die(mysqli_error($Conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $updatetime= $DataObat['updatetime'];
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-medical-sign-alt"></i> Penyimpanan (Depot)</a>
                        </h5>
                        <p class="m-b-0">Kelola data lokasi penyimpanan obat dan jumlah alokasi penyimpanan.</p>
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
                                    include "_Page/ObatStorage/DataObatStorage.php";
                                }else{
                                    $Sub=$_GET['Sub'];
                                    if($Sub=="DataRincianObatStorage"){
                                        include "_Page/ObatStorage/DataRincianObatStorage.php";
                                    }else{
                                        if($Sub=="DetailStorage"){
                                            include "_Page/ObatStorage/DetailStorage.php";
                                        }else{
                                            if($Sub=="FormAlokasi"){
                                                include "_Page/ObatStorage/FormAlokasi.php";
                                            }else{
                                                if($Sub=="FormTransferBarang"){
                                                    include "_Page/ObatStorage/FormTransfer.php";
                                                }else{
                                                    if($Sub=="EditTransfer"){
                                                        include "_Page/ObatStorage/FormEditTransfer.php";
                                                    }
                                                }
                                            }
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

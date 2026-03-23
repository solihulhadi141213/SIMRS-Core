<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'6Wq8PdHbcV');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5">
                                <i class="icofont-credit-card"></i> Transaksi
                            </a>
                        </h5>
                        <p class="m-b-0">
                            Kelola semua data transaksi keuangan yang berlangsung baik untuk transaksi pelayanan maupun operasional.
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
                            include "_Page/Transaksi/TransaksiHome.php";
                        }else{
                            $Sub=$_GET['Sub'];
                            if($Sub=="DetailTransaksi"){
                                include "_Page/Transaksi/DetailTransaksi.php";
                            }else{
                                if($Sub=="TambahTransaksi"){
                                    include "_Page/Transaksi/TambahTransaksi.php";
                                }else{
                                    include "_Page/Transaksi/TransaksiHome.php";
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
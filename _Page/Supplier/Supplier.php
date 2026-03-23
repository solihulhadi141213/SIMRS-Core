<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'VhC34wPcG5');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5">
                                <i class="icofont-truck-loaded"></i> Supplier/Distributor
                            </a>
                        </h5>
                        <p class="m-b-0">
                            Kelola data supplier yang melakukan transaksi operasional untuk mempermudah melihat riwayat transaksi.
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
                            include "_Page/Supplier/SupplierHome.php";
                        }else{
                            $Sub=$_GET['Sub'];
                            if($Sub=="DetailSupplier"){
                                include "_Page/Supplier/DetailSupplier.php";
                            }else{
                                include "_Page/Supplier/SupplierHome.php";
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
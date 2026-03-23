<?php
    //Desiossion Pasien
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'Dd6UIUIZxx');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-icu"></i> Jadwal Operasi</a>
                        </h5>
                        <p class="m-b-0">Kelola data jadwal operasi.</p>
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
                            include "_Page/JadwalOperasi/JadwalOperasiHome.php";
                        }else{
                            $Sub=$_GET['Sub'];
                            if($Sub=="DetailJadwalOperasi"){
                                include "_Page/JadwalOperasi/DetailJadwalOperasi.php";
                            }else{
                                if($Sub=="TambahJadwalOperasi"){
                                    include "_Page/JadwalOperasi/TambahJadwalOperasi.php";
                                }else{
                                    if($Sub=="EditJadwalOperasi"){
                                        include "_Page/JadwalOperasi/EditJadwalOperasi.php";
                                    }
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
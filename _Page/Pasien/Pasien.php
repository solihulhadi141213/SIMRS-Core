<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'iTITO449dV');
    if($StatusAkses=="Yes"){
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-patient-file"></i> Pasien</a>
                    </h5>
                    <p class="m-b-0">Kelola data pasien, pendaftaran pasien baru dan lihat rincian informasi pasien.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        if(empty($_GET['Sub'])){
            include "_Page/Pasien/PasienHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="DetailPasien"){
                include "_Page/Pasien/DetailPasien.php";
            }else{
                if($Sub=="TambahPasien"){
                    include "_Page/Pasien/TambahPasien.php";
                }else{
                    if($Sub=="EditPasien"){
                        include "_Page/Pasien/EditPasien.php";
                    }else{
                        if($Sub=="TambahKunjungan"){
                            include "_Page/Pasien/TambahKunjungan.php";
                        }
                    }
                }
            }
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
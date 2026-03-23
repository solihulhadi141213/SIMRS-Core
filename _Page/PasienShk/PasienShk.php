<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'UO0QqDTAtK');
    if($StatusAkses=="Yes"){
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-patient-file"></i> Pasien SHK</a>
                    </h5>
                    <p class="m-b-0">Kelola data pasien SHK, pendaftaran pasien SHK dan lihat rincian informasi pasien SHK.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        if(empty($_GET['Sub'])){
            include "_Page/PasienShk/PasienShkHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="TambahPasienShk"){
                include "_Page/PasienShk/TambahPasienShk.php";
            }else{
                if($Sub=="DetailPasienShk"){
                    include "_Page/PasienShk/DetailPasienShk.php";
                }else{
                    if($Sub=="EditPasienShk"){
                        include "_Page/PasienShk/EditPasienShk.php";
                    }else{
                        include "_Page/PasienShk/PasienShkHome.php";
                    }
                }
            }
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
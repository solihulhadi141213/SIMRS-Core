<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-laboratory"></i> Laboratorium</a>
                    </h5>
                    <p class="m-b-0">Kelola Pelayanan Pemeriksaan Laboratorium</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['Sub'])){
        include "_Page/Laboratorium/LaboratoriumReferensi.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="ReferensiLab"){
            include "_Page/Laboratorium/LaboratoriumReferensi.php";
        }else{
            if($Sub=="PermintaanLab"){
                include "_Page/Laboratorium/PermintaanLab.php";
            }else{
                if($Sub=="TambahPermintaanLab"){
                    include "_Page/Laboratorium/FormPermintaanLab.php";
                }else{
                    if($Sub=="EditPermintaanLab"){
                        include "_Page/Laboratorium/FormEditPermintaanLab.php";
                    }else{
                        if($Sub=="DetailPermintaanLab"){
                            include "_Page/Laboratorium/DetailPermintaanLab.php";
                        }else{
                            if($Sub=="FormSigLaboratorium"){
                                include "_Page/Laboratorium/FormSigLaboratorium.php";
                            }else{
                                if($Sub=="TambahHasilPemeriksaan"){
                                    include "_Page/Laboratorium/TambahHasilPemeriksaan.php";
                                }else{
                                    if($Sub=="LaporanLab"){
                                        include "_Page/Laboratorium/LaporanLab.php";
                                    }else{
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>


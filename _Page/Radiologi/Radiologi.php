<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-xray"></i> Radiologi</a>
                    </h5>
                    <p class="m-b-0">Kelola Pelayanan Pemeriksaan Radiologi</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['Sub'])){
        include "_Page/Radiologi/RadiologiHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahRadiologi"){
            include "_Page/Radiologi/FormTambahRadiologi.php";
        }else{
            if($Sub=="EditRadiologi"){
                include "_Page/Radiologi/FormEditRadiologi.php";
            }else{
                if($Sub=="DetailRadiologi"){
                    include "_Page/Radiologi/DetailRadiologi.php";
                }else{
                    if($Sub=="KesanPenyakit"){
                        include "_Page/Radiologi/FormKesanPenyakit.php";
                    }else{
                        if($Sub=="KlinisPasien"){
                            include "_Page/Radiologi/FormKlinisPasien.php";
                        }else{
                            if($Sub=="TambahHasilPemeriksaan"){
                                include "_Page/Radiologi/FormTambahHasilPemeriksaan.php";
                            }else{
                                if($Sub=="EditHasilPemeriksaan"){
                                    include "_Page/Radiologi/FormEditHasilPemeriksaan.php";
                                }else{
                                    if($Sub=="VerifikasiRadiografer"){
                                        include "_Page/Radiologi/FormVerifikasiRadiografer.php";
                                    }else{
                                        if($Sub=="VerifikasiDokter"){
                                            include "_Page/Radiologi/FormVerifikasiDokter.php";
                                        }else{
                                            if($Sub=="Laporan"){
                                                include "_Page/Radiologi/Laporan.php";
                                            }else{
                                                include "_Page/Radiologi/RadiologiHome.php";
                                            }
                                        }
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


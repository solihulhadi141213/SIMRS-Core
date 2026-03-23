<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-first-aid"></i> Kunjungan Pasien</a>
                    </h5>
                    <p class="m-b-0">Kelola Data Rawat Jalan & Rawat Inap, Pendaftaran dan Status Rawat Jalan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'Zi3QW6vfyi');
    if($StatusAkses=="Yes"){
        if(!empty($_GET['Sub'])){
            $SubPage=$_GET['Sub'];
            if($SubPage=="Home"){
                include "_Page/RawatJalan/RawatJalanHome.php";
            }else{
                if($SubPage=="TambahKunjungan"){
                    include "_Page/RawatJalan/TambahKunjungan.php";
                }else{
                    if($SubPage=="EditKunjungan"){
                        include "_Page/RawatJalan/EditKunjungan.php";
                    }else{
                        if($SubPage=="BuatSep"){
                            include "_Page/RawatJalan/BuatSep.php";
                        }else{
                            if($SubPage=="EditSep"){
                                include "_Page/RawatJalan/FormEditDataSep.php";
                            }else{
                                if($SubPage=="DetailKunjungan"){
                                    include "_Page/RawatJalan/DetailKunjungan.php";
                                }else{
                                    if($SubPage=="TandaTanganGeneralConsent"){
                                        include "_Page/RawatJalan/TandaTanganGeneralConsent.php";
                                    }else{
                                        if($SubPage=="TambahPemeriksaanDasar"){
                                            include "_Page/RawatJalan/TambahPemeriksaanDasar.php";
                                        }else{
                                            if($SubPage=="TandaTanganGeneralConsent2"){
                                                include "_Page/RawatJalan/TandaTanganGeneralConsent2.php";
                                            }else{
                                                if($SubPage=="Edukasi"){
                                                    include "_Page/RawatJalan/Edukasi.php";
                                                }else{
                                                    if($SubPage=="CPPT"){
                                                        include "_Page/RawatJalan/CPPT.php";
                                                    }else{
                                                        if($SubPage=="Resume"){
                                                            include "_Page/RawatJalan/Resume.php";
                                                        }else{
                                                            if($SubPage=="Operasi"){
                                                                include "_Page/RawatJalan/Operasi.php";
                                                            }else{
                                                                include "_Page/RawatJalan/RawatJalanHome.php";
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
                }
            }
        }else{
            $SubPage="";
            include "_Page/RawatJalan/RawatJalanHome.php";
        }
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-hospital"></i> SIRS Online</a>
                    </h5>
                    <p class="m-b-0">Menghubungkan antara data SIMRS pada SIRS online Kemenkes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($_GET['Sub'])){
        $SubPage=$_GET['Sub'];
        if($SubPage=="ReferensiTt"){
            include "_Page/SirsOnline/ReferensiTt.php";
        }else{
            if($SubPage=="DataTt"){
                include "_Page/SirsOnline/DataTt.php";
            }else{
                if($SubPage=="ReferensiSdm"){
                    include "_Page/SirsOnline/ReferensiSdm.php";
                }else{
                    if($SubPage=="DataSdm"){
                        include "_Page/SirsOnline/DataSdm.php";
                    }else{
                        if($SubPage=="ReferensiAlkes"){
                            include "_Page/SirsOnline/ReferensiAlkes.php";
                        }else{
                            if($SubPage=="DataAlkes"){
                                include "_Page/SirsOnline/DataAlkes.php";
                            }else{
                                if($SubPage=="PcrNakes"){
                                    include "_Page/SirsOnline/PcrNakes.php";
                                }else{
                                    if($SubPage=="FormTambahPcrNakes"){
                                        include "_Page/SirsOnline/FormTambahPcrNakes.php";
                                    }else{
                                        if($SubPage=="NakesTerinfeksi"){
                                            include "_Page/SirsOnline/NakesTerinfeksi.php";
                                        }else{
                                            include "_Page/UnPage/ErrorPageSub.php";
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
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>
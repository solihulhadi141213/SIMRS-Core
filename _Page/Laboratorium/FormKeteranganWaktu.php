<?php
    date_default_timezone_set('Asia/Jakarta');
    if(!empty($_POST['periode'])){
        $periode=$_POST['periode'];
        if($periode=="Tahunan"){
            include "../../_Page/Laboratorium/FormTahun.php";
        }else{
            if($periode=="Bulanan"){
                include "../../_Page/Laboratorium/FormBulan.php";
            }else{
                if($periode=="Harian"){
                    include "../../_Page/Laboratorium/FormHari.php";
                }else{
                    if($periode=="Periode"){
                        include "../../_Page/Laboratorium/FormPeriode.php";
                    }else{
                        include "../../_Page/Laboratorium/FormTahun.php";
                    }
                }
            }
        }
    }else{
        include "../../_Page/Laboratorium/FormTahun.php";
    }
?>
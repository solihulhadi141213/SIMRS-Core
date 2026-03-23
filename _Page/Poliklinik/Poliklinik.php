<?php
    // include "_Config/SettingAkses.php";
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'SSpjtfRfDl');
    if($StatusAkses=="Yes"){
        if(empty($_GET['Sub'])){
            include "_Page/Poliklinik/DataPoliklinik.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="TambahPoliklinik"){
                include "_Page/Poliklinik/TambahPoliklinik.php";
            }else{
                if($Sub=="EditPoliklinik"){
                    include "_Page/Poliklinik/FormEditPoliklinik.php";
                }else{
                    if($Sub=="DetailPoliklinik"){
                        include "_Page/Poliklinik/DetailPoliklinik.php";
                    }else{
                        if($Sub=="HFIS"){
                            include "_Page/Poliklinik/HFIS.php";
                        }else{
                            include "_Page/Poliklinik/DataPoliklinik.php";
                        }
                    }
                }
            }
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
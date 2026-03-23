<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'ctLQwPqvCf');
    if($StatusAkses=="Yes"){
        if(!empty($_GET['Sub'])){
            $SubPage=$_GET['Sub'];
            if($SubPage=="Home"){
                include "_Page/SuratKontrol/SuratKontrolHome.php";
            }else{
                if($SubPage=="TambahSuratKontrol"){
                    include "_Page/SuratKontrol/TambahSuratKontrol.php";
                }else{
                    include "_Page/SuratKontrol/SuratKontrolHome.php";
                }
            }
        }else{
            $SubPage="";
            include "_Page/SuratKontrol/SuratKontrolHome.php";
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
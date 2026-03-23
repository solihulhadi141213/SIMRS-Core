<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'3zL8ERMPEe');
    if($StatusAkses=="Yes"){
        if(empty($_GET['Sub'])){
            include "_Page/JadwalDokter/JadwalDokterHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="JadwalByHari"){
                include "_Page/JadwalDokter/JadwalByHari.php";
            }else{
                include "_Page/JadwalDokter/JadwalDokterHome.php";
            }
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
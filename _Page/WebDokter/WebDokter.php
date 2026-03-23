<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebDokter/WebDokterHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahDokter"){
            include "_Page/WebDokter/FormTambahDokter.php";
        }else{
            if($Sub=="DetailDokter"){
                include "_Page/WebDokter/DetailDokter.php";
            }else{
                include "_Page/WebDokter/WebDokterHome.php";
            }
        }
    }
?>
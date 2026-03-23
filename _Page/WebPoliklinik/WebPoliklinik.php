<?php
    include "_Page/WebPoliklinik/WebPoliklinikFunction.php";
    if(empty($_GET['Sub'])){
        include "_Page/WebPoliklinik/WebPoliklinikHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahPoliklinik"){
            include "_Page/WebPoliklinik/FormTambahPoliklinik.php";
        }else{
            if($Sub=="EditPoliklinik"){
                include "_Page/WebPoliklinik/FormEditPoliklinik.php";
            }else{
                include "_Page/WebPoliklinik/WebArtikelHome.php";
            }
        }
    }
?>
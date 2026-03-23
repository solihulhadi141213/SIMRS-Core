<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebArtikel/WebArtikelHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahArtikel"){
            include "_Page/WebArtikel/FormTambahArtikel.php";
        }else{
            if($Sub=="EditArtikel"){
                include "_Page/WebArtikel/FormEditArtikel.php";
            }else{
                include "_Page/WebArtikel/WebArtikelHome.php";
            }
        }
    }
?>
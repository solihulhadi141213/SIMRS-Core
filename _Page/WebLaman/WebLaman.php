<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebLaman/WebLamanHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahLaman"){
            include "_Page/WebLaman/FormTambahLaman.php";
        }else{
            if($Sub=="EditLaman"){
                include "_Page/WebLaman/FormEditLaman.php";
            }
        }
    }
?>
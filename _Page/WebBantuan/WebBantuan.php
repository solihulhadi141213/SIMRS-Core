<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebBantuan/WebBantuanHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahBantuan"){
            include "_Page/WebBantuan/FormTambahBantuan.php";
        }else{
            if($Sub=="EditBantuan"){
                include "_Page/WebBantuan/FormEditBantuan.php";
            }else{
                include "_Page/WebBantuan/WebBantuanHome.php";
            }
        }
    }
?>
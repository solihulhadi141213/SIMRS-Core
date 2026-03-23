<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebLoker/WebLokerHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahLoker"){
            include "_Page/WebLoker/FormTambahLoker.php";
        }else{
            if($Sub=="EditLoker"){
                include "_Page/WebLoker/FormEditLoker.php";
            }else{
                if($Sub=="DetailLoker"){
                    include "_Page/WebLoker/DetailLoker.php";
                }else{
                    include "_Page/WebLoker/WebLokerHome.php";
                }
            }
        }
    }
?>
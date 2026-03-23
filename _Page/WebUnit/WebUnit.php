<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebUnit/WebUnitHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahUnit"){
            include "_Page/WebUnit/FormTambahUnit.php";
        }else{
            if($Sub=="EditUnit"){
                include "_Page/WebUnit/FormEditUnit.php";
            }else{
                if($Sub=="DetailUnit"){
                    include "_Page/WebUnit/DetailUnit.php";
                }else{
                    include "_Page/WebUnit/WebUnitHome.php";
                }
            }
        }
    }
?>
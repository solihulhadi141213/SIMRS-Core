<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebEvent/WebEventHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahEvent"){
            include "_Page/WebEvent/FormTambahEvent.php";
        }else{
            if($Sub=="EditEvent"){
                include "_Page/WebEvent/FormEditEvent.php";
            }else{
                if($Sub=="DetailEvent"){
                    include "_Page/WebEvent/DetailEvent.php";
                }else{
                    include "_Page/WebEvent/WebEventHome.php";
                }
            }
        }
    }
?>
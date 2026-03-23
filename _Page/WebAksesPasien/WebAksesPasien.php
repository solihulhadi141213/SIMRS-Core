<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebAksesPasien/WebAksesPasienHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailPasien"){
            include "_Page/WebAksesPasien/DetailAksesPasien.php";
        }else{
            if($Sub=="TambahPasien"){
                include "_Page/WebAksesPasien/FormTambahPasien.php";
            }else{
                if($Sub=="EditPasien"){
                    include "_Page/WebAksesPasien/FormEditPasien.php";
                }else{
                    
                }
            }
        }
    }
?>
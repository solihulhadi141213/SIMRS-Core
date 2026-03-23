<?php
    if(empty($_GET['Sub'])){
        include "_Page/WebKunjungan/WebKunjunganHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahKunjungan"){
            include "_Page/WebKunjungan/FormTambahKunjungan.php";
        }else{
            if($Sub=="DetailKunjungan"){
                include "_Page/WebKunjungan/DetailKunjungan.php";
            }else{
                if($Sub=="EditKunjungan"){
                    include "_Page/WebKunjungan/FormEditKunjungan.php";
                }else{
                    include "_Page/WebKunjungan/WebKunjunganHome.php";
                }
            }
        }
    }
?>
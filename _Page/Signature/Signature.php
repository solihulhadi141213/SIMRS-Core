<?php
    if(empty($_GET['Sub'])){
        include "_Page/Signature/SignatureHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahSignature"){
            include "_Page/Signature/TambahSignature.php";
        }else{
            include "_Page/Signature/SignatureHome.php";
        }
    }
?>
<?php
    if(empty($_POST['subtotal'])){
        $subtotal=0;
    }else{
        $subtotal=$_POST['subtotal'];
        $subtotal = intval(str_replace('.', '', $subtotal));
    }
    if(empty($_POST['ppn'])){
        $ppn=0;
    }else{
        $ppn=$_POST['ppn'];
        $ppn = intval(str_replace('.', '', $ppn));
    }
    if(empty($_POST['diskon'])){
        $diskon=0;
    }else{
        $diskon=$_POST['diskon'];
        $diskon = intval(str_replace('.', '', $diskon));
    }
    $JumlahAkumulasi=($subtotal+$ppn)-$diskon;
    $JumlahAkumulasi = "" . number_format($JumlahAkumulasi, 0, ',', '.');
    echo $JumlahAkumulasi;
?>
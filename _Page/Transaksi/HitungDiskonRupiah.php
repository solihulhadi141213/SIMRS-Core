<?php
    if(empty($_POST['DiskonPersen'])){
        $DiskonPersen=0;
    }else{
        $DiskonPersen=$_POST['DiskonPersen'];
        $DiskonPersen = intval(str_replace('.', '', $DiskonPersen));
    }
    if(empty($_POST['Harga'])){
        $Harga=0;
    }else{
        $Harga=$_POST['Harga'];
        $Harga = intval(str_replace('.', '', $Harga));
    }
    if(empty($_POST['Qty'])){
        $Qty=0;
    }else{
        $Qty=$_POST['Qty'];
        $Qty = intval(str_replace('.', '', $Qty));
    }
    $Subtotal=$Harga*$Qty;
    $Diskon=($DiskonPersen/100)*$Subtotal;
    $Diskon=round($Diskon);
    $Diskon = "" . number_format($Diskon, 0, ',', '.');
    echo $Diskon;
?>
<?php
    if(empty($_POST['PpnPersen'])){
        $PpnPersen=0;
    }else{
        $PpnPersen=$_POST['PpnPersen'];
        $PpnPersen = intval(str_replace('.', '', $PpnPersen));
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
    $Ppn=($PpnPersen/100)*$Subtotal;
    $Ppn=round($Ppn);
    $Ppn = "" . number_format($Ppn, 0, ',', '.');
    echo $Ppn;
?>
<?php
    if(empty($_POST['QtyRincian'])){
        $QtyRincian=0;
    }else{
        $QtyRincian=$_POST['QtyRincian'];
        $QtyRincian = intval(str_replace('.', '', $QtyRincian));
    }
    if(empty($_POST['HargaRincian'])){
        $HargaRincian=0;
    }else{
        $HargaRincian=$_POST['HargaRincian'];
        $HargaRincian = intval(str_replace('.', '', $HargaRincian));
    }
    if(empty($_POST['PpnRincian'])){
        $PpnRincian=0;
    }else{
        $PpnRincian=$_POST['PpnRincian'];
        $PpnRincian = intval(str_replace('.', '', $PpnRincian));
    }
    if(empty($_POST['DiskonRincian'])){
        $DiskonRincian=0;
    }else{
        $DiskonRincian=$_POST['DiskonRincian'];
        $DiskonRincian = intval(str_replace('.', '', $DiskonRincian));
    }
    $JumlahRincian=(($QtyRincian*$HargaRincian)+$PpnRincian)-$DiskonRincian;
    $JumlahRincian = "" . number_format($JumlahRincian, 0, ',', '.');
    echo $JumlahRincian;
?>
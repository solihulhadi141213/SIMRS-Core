<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($_POST['GetIdData'])){
        $GetIdData=$_POST['GetIdData'];
        if(!empty($_POST['MultiHargaRincian'])){
            $id_obat_harga=$_POST['MultiHargaRincian'];
            $harga=getDataDetail($Conn,'obat_harga','id_obat_harga',$id_obat_harga,'harga');
            $harga = "" . number_format($harga, 0, ',', '.');
            echo "$harga";
        }else{
            $harga=getDataDetail($Conn,'obat','id_obat',$GetIdData,'harga');
            $harga = "" . number_format($harga, 0, ',', '.');
            echo "$harga";
        }
    }else{
        echo "0";
    }
?>
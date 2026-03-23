<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($_POST['MultiSatuanRincian'])){
        $id_obat_multi=$_POST['MultiSatuanRincian'];
        $satuan=getDataDetail($Conn,'obat_satuan','id_obat_multi',$id_obat_multi,'satuan');
        echo "$satuan";
    }
?>
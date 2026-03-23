<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<option value="">No Data</option>';
    }else{
        $id_resep=$_POST['id_resep'];
        $obat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
        $json_decode =json_decode($obat, true);
        echo '<option value="">Pilih</option>';
        //Buka List Obat
        foreach($json_decode as $ListObat){
            $id=$ListObat['id'];
            $id_obat=$ListObat['id_obat'];
            $nama_obat=$ListObat['nama_obat'];
            echo '<option value="'.$id_resep.'-'.$id.'-'.$id_obat.'">'.$nama_obat.'</option>';
        }
    }
?>
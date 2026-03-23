<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['KodePoli'])){
        echo '<option value="">Pilih</option>';
    }else{
        $KodePoli=$_POST['KodePoli'];
        $id_poliklinik=getDataDetail($Conn,'poliklinik','kode',$KodePoli,'id_poliklinik');
        $QryDokter = mysqli_query($Conn, "SELECT DISTINCT id_dokter FROM jadwal_dokter WHERE id_poliklinik='$id_poliklinik' ORDER BY dokter ASC");
        while ($DataDokter = mysqli_fetch_array($QryDokter)) {
            $IdDokter = $DataDokter['id_dokter'];
            $KodeDokter=getDataDetail($Conn,'dokter','id_dokter',$IdDokter,'kode');
            $NamaDokter=getDataDetail($Conn,'dokter','id_dokter',$IdDokter,'nama');
            echo '      <option value="'.$KodeDokter.'">'.$NamaDokter.'</option>';
        }
    }
?>
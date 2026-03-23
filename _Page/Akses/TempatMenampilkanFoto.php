<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses_pengajuan
    if(empty($_POST['id_akses_pengajuan'])){
        echo 'Tidak Ada ID Akses';
    }else{
        $id_akses_pengajuan=$_POST['id_akses_pengajuan'];
        $foto=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'foto');
        echo '<img src="assets/images/PengajuanAkses/'.$foto.'" width="100%">';
    }
?>
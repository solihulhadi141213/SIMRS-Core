<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_perencanaan_pasien'])){
        echo '<span class="text-danger">ID Perencanaan Pasien Tidak dapat ditangkap pada saat proses hapus data</span>';
    }else{
        $id_perencanaan_pasien=$_POST['id_perencanaan_pasien'];
        $HapusPerencanaanPasien = mysqli_query($Conn, "DELETE FROM  perencanaan_pasien WHERE id_perencanaan_pasien='$id_perencanaan_pasien'") or die(mysqli_error($Conn));
        if($HapusPerencanaanPasien){
            echo '<span id="NotifikasiHapusPerencanaanBerhasil" class="text-success">Success</span>';
        }else{
            echo '<span class="text-danger">Proses hapus gagal!!</span>';
        }
    }
?>
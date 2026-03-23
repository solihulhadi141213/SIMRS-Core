<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_resep'])){
        echo '<i class="text-danger">ID Resep Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_resep=$_POST['id_resep'];
        $HapusResep = mysqli_query($Conn, "DELETE FROM resep WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
        if($HapusResep){
            echo '<div id="NotifikasiHapusResepBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
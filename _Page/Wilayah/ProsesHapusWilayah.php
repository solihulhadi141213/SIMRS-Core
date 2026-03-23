<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_wilayah'])){
        echo '<i class="text-danger">ID Wilayah Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_wilayah=$_POST['id_wilayah'];
        $HapusWilayah = mysqli_query($Conn, "DELETE FROM wilayah WHERE id_wilayah='$id_wilayah'") or die(mysqli_error($Conn));
        if($HapusWilayah){
            echo '<span class="text-info" id="NotifikasiHapus">Berhasil</span>';
        }else{
            echo '<span class="text-danger">Error: Ketika Proses Hapus Database Wilayah!!</span>';
        }
    }
?>
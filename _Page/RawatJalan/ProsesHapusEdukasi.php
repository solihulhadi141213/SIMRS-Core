<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_edukasi'])){
        echo '<i class="text-danger">ID Edukasi Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_edukasi=$_POST['id_edukasi'];
        $HapusEdukasi = mysqli_query($Conn, "DELETE FROM edukasi WHERE id_edukasi='$id_edukasi'") or die(mysqli_error($Conn));
        if($HapusEdukasi){
            echo '<div id="NotifikasiHapusEdukasiBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
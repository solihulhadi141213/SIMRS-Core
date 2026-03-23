<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_konsultasi'])){
        echo '<i class="text-danger">ID Konsultasi Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_konsultasi=$_POST['id_konsultasi'];
        $HapusKonsultasi = mysqli_query($Conn, "DELETE FROM konsultasi WHERE id_konsultasi='$id_konsultasi'") or die(mysqli_error($Conn));
        if($HapusKonsultasi){
            echo '<div id="NotifikasiHapusKonsultasiBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<i class="text-danger">ID Kunjungan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $HapusResume = mysqli_query($Conn, "DELETE FROM resume WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($HapusResume){
            echo '<div id="NotifikasiHapusResumeBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
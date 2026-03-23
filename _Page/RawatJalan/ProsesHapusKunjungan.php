<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<i class="text-danger">ID Kunjungan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $HapusKunjungan = mysqli_query($Conn, "DELETE FROM kunjungan_utama WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($HapusKunjungan){
            echo '<div id="NotifikasiHapusKunjunganberhasil" class="text-primary">Berhasil</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
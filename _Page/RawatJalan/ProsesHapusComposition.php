<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_kunjungan_composition'])){
        echo '<i class="text-danger">ID Kunjungan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_kunjungan_composition=$_POST['id_kunjungan_composition'];
        $HapusKunjungan = mysqli_query($Conn, "DELETE FROM kunjungan_composition WHERE id_kunjungan_composition='$id_kunjungan_composition'") or die(mysqli_error($Conn));
        if($HapusKunjungan){
            echo '<div id="NotifikasiHapusKunjunganCompositionBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
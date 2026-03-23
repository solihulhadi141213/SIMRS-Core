<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_riwayat_penggunaan_obat'])){
        echo '<i class="text-danger">ID Riwayat Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_riwayat_penggunaan_obat=$_POST['id_riwayat_penggunaan_obat'];
        $HapusRiwayatPenggunaanObat = mysqli_query($Conn, "DELETE FROM riwayat_penggunaan_obat WHERE id_riwayat_penggunaan_obat='$id_riwayat_penggunaan_obat'") or die(mysqli_error($Conn));
        if($HapusRiwayatPenggunaanObat){
            echo '<div id="NotifikasiHapusRiwayatObatBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
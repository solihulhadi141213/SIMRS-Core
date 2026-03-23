<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak dapat ditangkap pada saat proses hapus data</span>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $HapusTriaseIgd = mysqli_query($Conn, "DELETE FROM  triase_igd WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($HapusTriaseIgd){
            echo '<span id="NotifikasiHapusTriaseIgdBerhasil" class="text-success">Success</span>';
        }else{
            echo '<span class="text-danger">Proses hapus gagal!!</span>';
        }
    }
?>
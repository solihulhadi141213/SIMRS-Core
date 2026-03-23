<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_poliklinik'])){
        echo '<i id="NotifikasiHapus">ID Poli Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_poliklinik=$_POST['id_poliklinik'];
        $HapusPoliklinik = mysqli_query($Conn, "DELETE FROM poliklinik WHERE id_poliklinik='$id_poliklinik'") or die(mysqli_error($Conn));
        if($HapusPoliklinik){
            $_SESSION['NotifikasiSwal']="Hapus Poliklinik Berhasil";
            echo '<div id="NotifikasiHapus" class="text-primary">Berhasil</div>';
        }else{
            $_SESSION['NotifikasiSwal']="Hapus Poliklinik Gagal";
            echo '<div id="NotifikasiHapus" class="text-primary">Proses Hapus Poliklinik Gagal</div>';
        }
    }
?>
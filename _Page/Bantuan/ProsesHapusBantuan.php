<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_bantuan'])){
        echo '<i id="NotifikasiHapus">ID bantuan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_bantuan=$_POST['id_bantuan'];
        $HapusBantuan = mysqli_query($Conn, "DELETE FROM bantuan WHERE id_bantuan='$id_bantuan'") or die(mysqli_error($Conn));
        if($HapusBantuan){
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Hapus Bantuan Berhasil";
            $kategori_log="Bantuan";
            include "../../_Config/Log.php";
            echo '<div id="NotifikasiHapus" class="text-primary">Berhasil</div>';
        }else{
            echo '<div id="NotifikasiHapus" class="text-primary">Proses Hapus Bantuan Gagal</div>';
        }
    }
?>
<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_diagnosa'])){
        echo '<i id="Notifikasi">ID akses Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_diagnosa=$_POST['id_diagnosa'];
        //Proses hapus data
        $query = mysqli_query($Conn, "DELETE FROM diagnosa WHERE id_diagnosa='$id_diagnosa'") or die(mysqli_error($Conn));
        if ($query) {
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Hapus Diagnosa ID $id_diagnosa";
            $kategori_log="Diagnosa";
            include "../../_Config/Log.php";
            echo '<i class="text-success" id="NotifikasiHapusDiagnosaBerhasil">Berhasil</i>';
        }else{
            echo '<i class="text-danger">Hapus Akses Gagal</i>';
        }
    }
?>
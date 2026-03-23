<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_obat'])){
        echo '<i id="Notifikasi">ID Obat Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_obat=$_POST['id_obat'];
        //Proses hapus data
        $query = mysqli_query($Conn, "DELETE FROM obat WHERE id_obat='$id_obat'") or die(mysqli_error($Conn));
        if ($query) {
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Hapus Obat $id_obat";
            $kategori_log="Obat";
            include "../../_Config/Log.php";
            $_SESSION['NotifikasiSwal']="Hapus Obat Berhasil Berhasil";
            echo '<span class="text-success" id="NotifikasiHapusObatBerhasil">Berhasil</span>';
        }else{
            echo '<span class="text-danger">Hapus Obat Gagal</span>';
        }
    }
?>
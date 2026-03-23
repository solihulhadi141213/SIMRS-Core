<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap data
    if(empty($_POST['id_jadwal'])){
        echo '<span class="text-danger">Id Jadwal Tidak Boleh Kosong</span>';
    }else{
        $id_jadwal=$_POST['id_jadwal'];
        $HapusJadwal = mysqli_query($Conn, "DELETE FROM jadwal_dokter WHERE id_jadwal='$id_jadwal'") or die(mysqli_error($Conn));
        if($HapusJadwal){
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Hapus Data Jadwal Dokter Berhasil";
            $kategori_log="Jadwal Dokter";
            include "../../_Config/Log.php";
            echo '<span id="NotifikasiHapusJadwalberhasil">Berhasil</span>';
        }else{
            echo '<span id="NotifikasiHapusJadwalberhasil">Hapus gagal</span>';
        }
    }
?>


<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap data
    if(empty($_POST['id_ruang_rawat'])){
        echo '<span class="text-danger">Id Ruangan Tidak Boleh Kosong</span>';
    }else{
        $id_ruang_rawat=$_POST['id_ruang_rawat'];
        $HapusRuangan = mysqli_query($Conn, "DELETE FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'") or die(mysqli_error($Conn));
        if($HapusRuangan){
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Hapus Data Kelas Berhasil";
            $kategori_log="Kelas Ruangan";
            include "../../_Config/Log.php";
            echo '<span id="NotifikasiHapusKelasBerhasil">Berhasil</span>';
        }else{
            echo '<span id="NotifikasiHapusKelasBerhasil">Hapus gagal</span>';
        }
    }
?>


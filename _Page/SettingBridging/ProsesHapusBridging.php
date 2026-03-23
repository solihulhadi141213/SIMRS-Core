<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_bridging'])){
        echo '<i id="NotifikasiHapus">ID Pasien Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_bridging=$_POST['id_bridging'];
        $HapusBridging = mysqli_query($Conn, "DELETE FROM bridging WHERE id_bridging='$id_bridging'") or die(mysqli_error($Conn));
        if($HapusBridging){
            echo '<span class="text-info" id="NotifikasiHapus">Hapus Bridging Berhasil</span>';
        }else{
            echo '<span class="text-danger">Error: Ketika Proses Hapus Bridging!!</span>';
        }
    }
?>
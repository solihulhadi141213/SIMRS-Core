<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_setting_service'])){
        echo '<span class="text-danger">ID Service Tidak Boleh Kosong</span>';
    }else{
        $id_setting_service=$_POST['id_setting_service'];
        //Proses hapus data
        $HapusService = mysqli_query($Conn, "DELETE FROM setting_service WHERE id_setting_service='$id_setting_service'") or die(mysqli_error($Conn));
        if($HapusService) {
            $HapusServiceRef= mysqli_query($Conn, "DELETE FROM setting_service_ref WHERE id_setting_service='$id_setting_service'") or die(mysqli_error($Conn));
            if($HapusService) {
                echo '<span class="text-success" id="NotifikasiHapusServiceBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Hapus Referensi Service Gagal</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Service Gagal</span>';
        }
    }
?>
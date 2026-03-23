<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_cppt'])){
        echo '<i class="text-danger">ID Edukasi Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_cppt=$_POST['id_cppt'];
        $HapusCppt = mysqli_query($Conn, "DELETE FROM cppt WHERE id_cppt='$id_cppt'") or die(mysqli_error($Conn));
        if($HapusCppt){
            echo '<div id="NotifikasiHapusCpptBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
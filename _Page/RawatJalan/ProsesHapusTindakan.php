<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_tindakan'])){
        echo '<i class="text-danger">ID Tindakan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_tindakan=$_POST['id_tindakan'];
        $Hapus = mysqli_query($Conn, "DELETE FROM tindakan WHERE id_tindakan='$id_tindakan'") or die(mysqli_error($Conn));
        if($Hapus){
            echo '<div id="NotifikasiHapusTindakanBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
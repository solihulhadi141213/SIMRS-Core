<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_persetujuan_tindakan'])){
        echo '<i class="text-danger">ID Persetujuan Tindakan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_persetujuan_tindakan=$_POST['id_persetujuan_tindakan'];
        $Hapus = mysqli_query($Conn, "DELETE FROM persetujuan_tindakan WHERE id_persetujuan_tindakan='$id_persetujuan_tindakan'") or die(mysqli_error($Conn));
        if($Hapus){
            echo '<div id="NotifikasiHapusPersetujuanTindakanBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
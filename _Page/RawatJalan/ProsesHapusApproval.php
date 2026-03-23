<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_approval'])){
        echo '<i class="text-danger">ID Approval Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_approval=$_POST['id_approval'];
        $HapusApproval = mysqli_query($Conn, "DELETE FROM approval WHERE id_approval='$id_approval'") or die(mysqli_error($Conn));
        if($HapusApproval){
            echo '<div id="NotifikasiHapusApprovalBerhasil" class="text-primary">Berhasil</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>
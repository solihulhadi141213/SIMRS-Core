<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_approval'])){
        echo '<i id="Notifikasi">ID Approval Tidak Boleh Kosong!</i>';
    }else{
        $id_approval=$_POST['id_approval'];
        //Proses hapus data
        $HapusApproval = mysqli_query($Conn, "DELETE FROM approval WHERE id_approval='$id_approval'") or die(mysqli_error($Conn));
        if($HapusApproval) {
            echo '<span class="text-success" id="NotifikasiHapusApprovalBerhasil">Success</span>';
        }else{
            echo '<span class="text-danger">Hapus Referensi Akses Gagal!</span>';
        }
    }
?>
<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_obat_expired'])){
        echo '<i class="text-danger">ID Item Expired Tidak Boleh Kosong!</i>';
    }else{
        $id_obat_expired=$_POST['id_obat_expired'];
        $HapusItem = mysqli_query($Conn, "DELETE FROM obat_expired WHERE id_obat_expired='$id_obat_expired'") or die(mysqli_error($Conn));
        if($HapusItem) {
            echo '<span class="text-success" id="NotifikasiHapusExpiredItemBerhasil">Success</span>';
        }else{
            echo '<span class="text-danger">Hapus Data Gagal!</span>';
        }
    }
?>
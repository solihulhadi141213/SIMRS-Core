<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_obat_expired'])){
        echo '<span class="text-danger">ID Expired Tidak Boleh Kosong!</span>';
    }else{
        $id_obat_expired=$_POST['id_obat_expired'];
        //Proses hapus data
        $HapusExpired = mysqli_query($Conn, "DELETE FROM obat_expired WHERE id_obat_expired='$id_obat_expired'") or die(mysqli_error($Conn));
        if ($HapusExpired) {
            echo '<span class="text-success" id="NotifikasiHapusExpiredBerhasil">Success</span>';
        }else{
            echo '<span class="text-danger">Terjadi kesalahan ketika menghapus data!</span>';
        }
    }
?>
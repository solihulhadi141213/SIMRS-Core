<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_rincian'])){
        echo '<span class="text-danger">ID Rincian Tidak Boleh Kosong!!</span>';
    }else{
        $id_rincian=$_POST['id_rincian'];
        $HapusRincian = mysqli_query($Conn, "DELETE FROM transaksi_rincian WHERE id_rincian='$id_rincian'") or die(mysqli_error($Conn));
        if($HapusRincian){
            echo '<span class="text-success" id="NotifikasiHapusRincianBerhasil">Success</span>';
        }else{
            echo '<span class="text-danger">Terjadi kesalahan ketika menghapus data rincian!</span>';
        }
    }
?>
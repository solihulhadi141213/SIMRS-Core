<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $Updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['id_obat_storage'])){
        echo '<span class="text-danger">ID Tempat Penyimpanan Tidak Boleh Kosong!</span>';
    }else{
        $id_obat_storage=$_POST['id_obat_storage'];
        //Hapus Data Penyimpanan
        $HapusDataStorage = mysqli_query($Conn, "DELETE FROM obat_storage WHERE id_obat_storage='$id_obat_storage'") or die(mysqli_error($Conn));
        if($HapusDataStorage){
            //Hapus Data Posisi Obat
            $HapusPosisi = mysqli_query($Conn, "DELETE FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'") or die(mysqli_error($Conn));
            if($HapusPosisi){
                echo '<span class="text-success" id="NotifikasiHapusStorageBerhasil">Berhasil</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Posisi</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Penyimpanan</span>';
        }
    }
?>
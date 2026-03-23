<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['id_tarif'])){
        echo '<small class="text-danger">ID Tarif tindakan tidak boleh kosong!</small>';
    }else{
        $id_tarif=$_POST['id_tarif'];
        //Hapus Tarif tindakan
        $HapusTarifTindakan = mysqli_query($Conn, "DELETE FROM tarif WHERE id_tarif='$id_tarif'") or die(mysqli_error($Conn));
        if($HapusTarifTindakan){
            $HapusUnitCost = mysqli_query($Conn, "DELETE FROM tarif_cost WHERE id_tarif='$id_tarif'") or die(mysqli_error($Conn));
            if($HapusUnitCost){
                echo '<small class="text-success" id="NotifikasiHapusTarifBerhasil">Success</small>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat menghapus unit cost</small>';
            }
        }else{
            echo '<small class="text-danger">Terjadi kesalahan pada saat menghapus data tarif dan tindakan</small>';
        }
    }
?>
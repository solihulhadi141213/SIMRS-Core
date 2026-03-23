<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['id_cost'])){
        echo '<small class="text-danger">ID Unit Cost Tidak Boleh Kosong!</small>';
    }else{
        $id_cost=$_POST['id_cost'];
        //Hapus Tarif tindakan
        $HapusUnitCost = mysqli_query($Conn, "DELETE FROM tarif_cost WHERE id_cost='$id_cost'") or die(mysqli_error($Conn));
        if($HapusUnitCost){
            echo '<small class="text-success" id="NotifikasiHapusUnitCostBerhasil">Success</small>';
        }else{
            echo '<small class="text-danger">Proses Hapus Gagal!</small>';
        }
    }
?>
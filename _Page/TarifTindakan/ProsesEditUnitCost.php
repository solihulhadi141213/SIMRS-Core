<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['id_cost'])){
        echo '<small class="text-danger">ID Unit Cost tidak boleh kosong!</small>';
    }else{
        if(empty($_POST['nama'])){
            echo '<small class="text-danger">Nama unit cost tidak boleh kosong!</small>';
        }else{
            if(empty($_POST['cost'])){
                $cost="0";
            }else{
                $id_cost=$_POST['id_cost'];
                $nama=$_POST['nama'];
                $cost=$_POST['cost'];
                //Simpan Data
                $UpdateCost=mysqli_query($Conn, "UPDATE tarif_cost SET 
                    nama='$nama', 
                    cost='$cost'
                WHERE id_cost='$id_cost'");
                if($UpdateCost){
                    echo '<span class="text-success" id="NotifikasiEditUnitCostBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                }
            }
        }
    }
?>
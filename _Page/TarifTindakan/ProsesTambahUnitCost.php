<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['id_tarif'])){
        echo '<small class="text-danger">ID tarif tindakan tidak boleh kosong!</small>';
    }else{
        if(empty($_POST['nama'])){
            echo '<small class="text-danger">Nama unit cost tidak boleh kosong!</small>';
        }else{
            if(empty($_POST['cost'])){
                $cost="0";
            }else{
                $nama=$_POST['nama'];
                $id_tarif=$_POST['id_tarif'];
                $cost=$_POST['cost'];
                //Simpan Data
                $SimpanData=mysqli_query($Conn,"INSERT INTO tarif_cost (
                    id_tarif,
                    nama,
                    cost
                ) VALUES (
                    '$id_tarif',
                    '$nama',
                    '$cost'
                )");
                if($SimpanData){
                    echo '<span class="text-success" id="NotifikasiTambahUnitCostBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                }
            }
        }
    }
?>
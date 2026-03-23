<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['nama'])){
        echo '<small class="text-danger">Nama tarif tindakan tidak boleh kosong!</small>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori tarif tindakan tidak boleh kosong!</small>';
        }else{
            if(empty($_POST['id_tarif'])){
                echo '<small class="text-danger">ID Tarif tindakan tidak boleh kosong!</small>';
            }else{
                if(empty($_POST['tarif'])){
                    $tarif="0";
                }else{
                    $id_tarif=$_POST['id_tarif'];
                    $nama=$_POST['nama'];
                    $kategori=$_POST['kategori'];
                    $tarif=$_POST['tarif'];
                    //Update Tarif Tindakan
                    $UpdateTarifTindakan=mysqli_query($Conn, "UPDATE tarif SET 
                        nama='$nama', 
                        kategori='$kategori', 
                        tarif='$tarif'
                    WHERE id_tarif='$id_tarif'");
                    if($UpdateTarifTindakan){
                        echo '<span class="text-success" id="NotifikasiEditTarifTindakanBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                    }
                }
            }
        }
    }
?>
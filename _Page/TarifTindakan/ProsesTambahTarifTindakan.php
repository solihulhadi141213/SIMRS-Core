<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['nama'])){
        echo '<small class="text-danger">Nama tarif tindakan tidak boleh kosong!</small>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori tarif tindakan tidak boleh kosong!</small>';
        }else{
            if(empty($_POST['tarif'])){
                $tarif="0";
            }else{
                $nama=$_POST['nama'];
                $kategori=$_POST['kategori'];
                $tarif=$_POST['tarif'];
                //Simpan Data
                $SimpanData=mysqli_query($Conn,"INSERT INTO tarif (
                    nama,
                    kategori,
                    tarif
                ) VALUES (
                    '$nama',
                    '$kategori',
                    '$tarif'
                )");
                if($SimpanData){
                    echo '<span class="text-success" id="NotifikasiTambahTarifTindakanBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                }
            }
        }
    }
?>
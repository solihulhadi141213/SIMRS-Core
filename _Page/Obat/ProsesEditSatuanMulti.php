<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['id_obat_multi'])){
        echo '<span class="text-danger">ID Obat/Alkes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['satuan'])){
            echo '<span class="text-danger">Satuan Obat/Alkes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['isi'])){
                echo '<span class="text-danger">Isi Multi Satuan Obat/Alkes Tidak Boleh Kosong!</span>';
            }else{
                //Variabel
                $id_obat_multi=$_POST['id_obat_multi'];
                $satuan=$_POST['satuan'];
                $isi=$_POST['isi'];
                //validasi format angka
                if(!is_numeric($isi)){
                    echo '<span class="text-danger">Isi Satuan Multi Hanya Boleh Angka</span>';
                }else{
                    //Simpan data
                    $UpdateSatuanMulti=mysqli_query($Conn, "UPDATE obat_satuan SET 
                        satuan='$satuan', 
                        isi='$isi', 
                        updatetime='$updatetime'
                    WHERE id_obat_multi='$id_obat_multi'");
                    if($UpdateSatuanMulti){
                        $_SESSION['NotifikasiSwal']="Update Satuan Multi Berhasil";
                        echo '<span class="text-success" id="NotifikasiEditSatuanMultiBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                    }
                }
            }
        }
    }
?>
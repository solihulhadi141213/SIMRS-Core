<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['id_obat'])){
        echo '<span class="text-danger">ID Obat/Alkes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['satuan'])){
            echo '<span class="text-danger">Satuan Obat/Alkes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['isi'])){
                echo '<span class="text-danger">Isi Multi Satuan Obat/Alkes Tidak Boleh Kosong!</span>';
            }else{
                //Variabel
                $id_obat=$_POST['id_obat'];
                $satuan=$_POST['satuan'];
                $isi=$_POST['isi'];
                //validasi format angka
                if(!is_numeric($isi)){
                    echo '<span class="text-danger">Isi Satuan Multi Hanya Boleh Angka</span>';
                }else{
                    //Simpan data
                    $SimpanData=mysqli_query($Conn,"INSERT INTO obat_satuan (
                        id_obat,
                        satuan,
                        isi,
                        updatetime
                    ) VALUES (
                        '$id_obat',
                        '$satuan',
                        '$isi',
                        '$updatetime'
                    )");
                    if($SimpanData){
                        $_SESSION['NotifikasiSwal']="Tambah Satuan Multi Berhasil";
                        echo '<span class="text-success" id="NotifikasiTambahSatuanMultiBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                    }
                }
            }
        }
    }
?>
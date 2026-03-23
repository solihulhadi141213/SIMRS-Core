<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['id_obat'])){
        echo '<span class="text-danger">ID Obat/Alkes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_obat_storage'])){
            echo '<span class="text-danger">ID Penyimpanan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['qty'])){
                $StokPosisi=0;
            }else{
                $StokPosisi=$_POST['qty'];
            }
            //Variabel
            $id_obat=$_POST['id_obat'];
            $id_obat_storage=$_POST['id_obat_storage'];
            //validasi format angka
            if(!is_numeric($StokPosisi)){
                echo '<span class="text-danger">Isi Stok Posisi Hanya Boleh Angka</span>';
            }else{
                //Buka Detail Obat
                $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
                $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                //Cek apakah sudah ada
                $QryPosisi = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat='$id_obat' AND id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                $DataPosisi = mysqli_fetch_array($QryPosisi);
                if(empty($DataPosisi['id_obat_posisi'])){
                    //Apabila Belum Ada Maka Insert
                    $InsertObatPosisi=mysqli_query($Conn,"INSERT INTO obat_posisi (
                        id_obat_storage,
                        id_obat,
                        kode,
                        nama_obat,
                        stok,
                        updatetime
                    ) VALUES (
                        '$id_obat_storage',
                        '$id_obat',
                        '$kode',
                        '$nama',
                        '$StokPosisi',
                        '$updatetime'
                    )");
                    if($InsertObatPosisi){
                        $_SESSION['NotifikasiSwal']="Update Alokasi Berhasil";
                        echo '<span class="text-success" id="NotifikasiAlokasiBerhasil">Success</span>';
                        echo '<input type="hidden" id="UrlBackAlokasi" value="index.php?Page=ObatStorage&Sub=DetailStorage&id='.$id_obat_storage.'">';
                    }else{
                        echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                    }
                }else{
                    $id_obat_posisi=$DataPosisi['id_obat_posisi'];
                    //Apabila Ada Maka Update
                    $UpdateObatPosisi=mysqli_query($Conn, "UPDATE obat_posisi SET 
                        stok='$StokPosisi', 
                        updatetime='$updatetime'
                    WHERE id_obat_posisi='$id_obat_posisi'");
                    if($UpdateObatPosisi){
                        $_SESSION['NotifikasiSwal']="Update Alokasi Berhasil";
                        echo '<span class="text-success" id="NotifikasiAlokasiBerhasil">Success</span>';
                        echo '<input type="hidden" id="UrlBackAlokasi" value="index.php?Page=ObatStorage&Sub=DetailStorage&id='.$id_obat_storage.'">';
                    }else{
                        echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
                    }
                }
            }
        }
    }
?>
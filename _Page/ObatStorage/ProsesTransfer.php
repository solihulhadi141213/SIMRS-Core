<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_storage1'])){
        echo '<span class="text-danger">Penyimpanan Asal Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_obat_storage2'])){
            echo '<span class="text-danger">Penyimpanan Tujuan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_obat'])){
                echo '<span class="text-danger">ID Obat/Alkes Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal'])){
                    echo '<span class="text-danger">Tanggal Transfer Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['jam'])){
                        echo '<span class="text-danger">Jam Transfer Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['nama_petugas'])){
                            echo '<span class="text-danger">Nama Petugas Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['qty'])){
                                echo '<span class="text-danger">Jumlah Barang Tidak Boleh Kosong!</span>';
                            }else{
                                $id_obat_storage1=$_POST['id_obat_storage1'];
                                $id_obat_storage2=$_POST['id_obat_storage2'];
                                $id_obat=$_POST['id_obat'];
                                $tanggal=$_POST['tanggal'];
                                $jam=$_POST['jam'];
                                $Datetime="$tanggal $jam";
                                $nama_petugas=$_POST['nama_petugas'];
                                $qty=$_POST['qty'];
                                if(empty($_POST['keterangan'])){
                                    $keterangan="";
                                }else{
                                    $keterangan=$_POST['keterangan'];
                                }
                                //Buka Kode Dan Nama Obat
                                $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
                                $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                                //Cek Stok Obat Posisi Asal
                                $QryPosisiAsal = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage1' AND id_obat='$id_obat'")or die(mysqli_error($Conn));
                                $DataPosisiAsal = mysqli_fetch_array($QryPosisiAsal);
                                $id_obat_posisi_asal=$DataPosisiAsal['id_obat_posisi'];
                                $StokAsalLama=$DataPosisiAsal['stok'];
                                $StokAsalBaru=$StokAsalLama-$qty;
                                //Cek apakah pada penyimpanan tujuan ada item barang tersebut
                                $QryPosisi = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage2' AND id_obat='$id_obat'")or die(mysqli_error($Conn));
                                $DataPosisi = mysqli_fetch_array($QryPosisi);
                                if(empty( $DataPosisi['id_obat_posisi'])){
                                    //Apabila Tidak Ada Maka Insert obat_posisi
                                    $InsertObatPosisi=mysqli_query($Conn,"INSERT INTO obat_posisi (
                                        id_obat_storage,
                                        id_obat,
                                        kode,
                                        nama_obat,
                                        stok,
                                        updatetime
                                    ) VALUES (
                                        '$id_obat_storage2',
                                        '$id_obat',
                                        '$kode',
                                        '$nama',
                                        '$qty',
                                        '$Datetime'
                                    )");
                                    if($InsertObatPosisi){
                                        //Insert Data Transfer
                                        $InsertDataTransfer=mysqli_query($Conn,"INSERT INTO obat_transfer_alokasi (
                                            id_obat,
                                            id_akses,
                                            tanggal,
                                            kode,
                                            nama,
                                            keterangan,
                                            storage_from,
                                            storage_to,
                                            qty,
                                            nama_petugas
                                        ) VALUES (
                                            '$id_obat',
                                            '$SessionIdAkses',
                                            '$Datetime',
                                            '$kode',
                                            '$nama',
                                            '$keterangan',
                                            '$id_obat_storage1',
                                            '$id_obat_storage2',
                                            '$qty',
                                            '$nama_petugas'
                                        )");
                                        if($InsertDataTransfer){
                                            //Update Obat Posisi Asal
                                            $UpdateObatPosisiAsal=mysqli_query($Conn, "UPDATE obat_posisi SET 
                                                stok='$StokAsalBaru'
                                            WHERE id_obat_posisi='$id_obat_posisi_asal'");
                                            if($UpdateObatPosisiAsal){
                                                $_SESSION['NotifikasiSwal']="Proses Transfer Berhasil";
                                                echo '<span class="text-success" id="NotifikasiTransferBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Stok Posisi Asal</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Insert Data Transaksi</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Insert Data Posisi</span>';
                                    }
                                }else{
                                    //Apabila ada maka akumulsaikan
                                    $id_obat_posisi= $DataPosisi['id_obat_posisi'];
                                    //Buka QTY Posisi Lama
                                    $StokLama=getDataDetail($Conn,'obat_posisi','id_obat_posisi',$id_obat_posisi,'stok');
                                    $Akumulasi=$StokLama+$qty;
                                    //Update Obat Posisi
                                    $UpdateObatPosisi=mysqli_query($Conn, "UPDATE obat_posisi SET 
                                        stok='$Akumulasi'
                                    WHERE id_obat_posisi='$id_obat_posisi'");
                                    if($UpdateObatPosisi){
                                        $InsertDataTransfer=mysqli_query($Conn,"INSERT INTO obat_transfer_alokasi (
                                            id_obat,
                                            id_akses,
                                            tanggal,
                                            kode,
                                            nama,
                                            keterangan,
                                            storage_from,
                                            storage_to,
                                            qty,
                                            nama_petugas
                                        ) VALUES (
                                            '$id_obat',
                                            '$SessionIdAkses',
                                            '$Datetime',
                                            '$kode',
                                            '$nama',
                                            '$keterangan',
                                            '$id_obat_storage1',
                                            '$id_obat_storage2',
                                            '$qty',
                                            '$nama_petugas'
                                        )");
                                        if($InsertDataTransfer){
                                            //Update Obat Posisi Asal
                                            $UpdateObatPosisiAsal=mysqli_query($Conn, "UPDATE obat_posisi SET 
                                                stok='$StokAsalBaru'
                                            WHERE id_obat_posisi='$id_obat_posisi_asal'");
                                            if($UpdateObatPosisi){
                                                $_SESSION['NotifikasiSwal']="Proses Transfer Berhasil";
                                                echo '<span class="text-success" id="NotifikasiTransferBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Stok Posisi Asal</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Insert Data Transaksi</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Data Posisi</span>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
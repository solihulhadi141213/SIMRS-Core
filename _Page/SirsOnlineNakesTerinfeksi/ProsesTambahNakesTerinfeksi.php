<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes_pcr'])){
        echo '<span class="text-danger">ID Nakes PCR Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama Nakes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['kategori'])){
                echo '<span class="text-danger">Kategori Nakes Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal'])){
                    echo '<span class="text-danger">Tanggal Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['status'])){
                        echo '<span class="text-danger">Status Tidak Boleh Kosong!</span>';
                    }else{
                        $id_nakes_pcr=$_POST['id_nakes_pcr'];
                        $nama=$_POST['nama'];
                        $kategori=$_POST['kategori'];
                        $tanggal=$_POST['tanggal'];
                        $status=$_POST['status'];
                        //Buka id_nakes
                        $id_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'id_nakes');
                        //Validasi Duplikat Data
                        $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE id_nakes='$id_nakes' AND tanggal='$tanggal'"));
                        if(!empty($ValidasiDuplikat)){
                            echo '<span class="text-danger">Data Nakes Tersebut Sudah Terdaftar Di Tanggal Yang Sama!</span>';
                        }else{
                            if(!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
                                echo '<span class="text-danger">Nama Nakes Hanya Boleh Huruf dan Spasi!</span>';
                            }else{
                                if(!preg_match('/^[0-9]+$/', $id_nakes_pcr)) {
                                    echo '<span class="text-danger">ID Nakes PCR Hanya Boleh Angka!</span>';
                                }else{
                                    $entry="INSERT INTO nakes_terinfeksi (
                                        id_nakes,
                                        id_nakes_pcr,
                                        nama,
                                        tanggal,
                                        kategori,
                                        status,
                                        id_akses
                                    ) VALUES (
                                        '$id_nakes',
                                        '$id_nakes_pcr',
                                        '$nama',
                                        '$tanggal',
                                        '$kategori',
                                        '$status',
                                        '$SessionIdAkses'
                                    )";
                                    $Input=mysqli_query($Conn, $entry);
                                    if($Input){
                                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah data nakes terinfeksi","Nakes",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            echo '<span class="text-success" id="NotifikasiTambahNakesTerinfeksiBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Tambah Data Nakes Terinfeksi Gagal!</span>';
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
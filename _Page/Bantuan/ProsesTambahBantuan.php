<?php
    //Keterangan zona waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $Updatetime=date("Y-m-d H:i:s");
    //menangkap data
    if(empty($_POST['judul'])){
        echo '<span class="text-danger">Judul Bantuan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<span class="text-danger">Tanggal Bantuan Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kategori'])){
                echo '<span class="text-danger">Kategori Bantuan Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['status'])){
                    echo '<span class="text-danger">Status Bantuan Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['isi'])){
                        echo '<span class="text-danger">Isi Bantuan Tidak Boleh Kosong</span>';
                    }else{
                        $judul=$_POST['judul'];
                        $tanggal=$_POST['tanggal'];
                        $kategori=$_POST['kategori'];
                        $status=$_POST['status'];
                        $isi=$_POST['isi'];
                        $isi = str_replace("'", "\\'", $_POST['isi']);
                        //Simpan Data di Database
                        $entry="INSERT INTO bantuan (
                            judul,
                            tanggal,
                            kategori,
                            status,
                            isi
                        ) VALUES (
                            '$judul',
                            '$tanggal',
                            '$kategori',
                            '$status',
                            '$isi'
                        )";
                        $Input=mysqli_query($Conn, $entry);
                        if($Input){
                            //Catat Log Aktivitas
                            $MenyimpanLog=getSaveLog($Conn,$Updatetime,$SessionNama,"Tambah Data Bantuan","Bantuan",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Tambah Bantuan Berhasil";
                                echo '<div id="NotifikasiTambahBerhasil" class="text-primary">Berhasil</div>';
                            }else{
                                echo '<span class="text-danger"><dt>Maaf!!</dt> Terjadi Kesalahan Pada Saat Proses simpan log</span>';
                            }
                        }else{
                            echo '<span class="text-danger"><dt>Maaf!!</dt> Terjadi Kesalahan Pada Saat Proses Input Data Ke Database</span>';
                        }
                    }
                }
            }
        }
    }
?>
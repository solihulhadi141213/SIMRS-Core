<?php
    //Keterangan zona waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    //Session akses
    include "../../_Config/Session.php";
    //Menangkap variabel
    if(empty($_POST['nama'])){
        echo '<span class="text-danger"><dt>Maaf!!</dt> Nama Poliklinik Tidak Boleh Kosong!!</span>';
    }else{
        if(empty($_POST['koordinator'])){
            echo '<span class="text-danger"><dt>Maaf!!</dt> Koordinator Poliklinik Tidak Boleh Kosong!!</span>';
        }else{
            if(empty($_POST['status'])){
                echo '<span class="text-danger"><dt>Maaf!!</dt> Status Poliklinik Tidak Boleh Kosong!!</span>';
            }else{
                if(empty($_POST['Deskripsi'])){
                    echo '<span class="text-danger"><dt>Maaf!!</dt> Deskripsi Poliklinik Tidak Boleh Kosong!!</span>';
                }else{
                    //Buat Variabel
                    $GetNama=$_POST['nama'];
                    //Explode nama
                    $Pecah=explode("-" , $GetNama);
                    //Validasi format
                    if(empty($Pecah[0])){
                        echo '<span class="text-danger"><dt>Maaf!!</dt> Format Penulisan Kode/Nama Poli Mungkin Salah!!</span>';
                    }else{
                        if(empty($Pecah[1])){
                            echo '<span class="text-danger"><dt>Maaf!!</dt> Format Penulisan Kode/Nama Poli Mungkin Salah!!</span>';
                        }else{
                            $kode=$Pecah[0];
                            $nama=$Pecah[1];
                            $koordinator=$_POST['koordinator'];
                            $status=$_POST['status'];
                            $Deskripsi=$_POST['Deskripsi'];
                            $updatetime=date('Y-m-d H:i:s');
                            //Insert data variabel
                            $entry="INSERT INTO poliklinik (
                                nama,
                                koordinator,
                                deskripsi,
                                kode,
                                status,
                                updatetime
                            ) VALUES (
                                '$nama',
                                '$koordinator',
                                '$Deskripsi',
                                '$kode',
                                '$status',
                                '$updatetime'
                            )";
                            $Input=mysqli_query($Conn, $entry);
                            if($Input){
                                $_SESSION['NotifikasiSwal']="Tambah Poliklinik Berhasil";
                                echo '<div id="NotifikasiTambahBerhasil" class="text-primary">Berhasil</div>';
                            }else{
                                echo '<span class="text-danger"><dt>Maaf!!</dt> Terjadi Kesalahan Pada Saat Proses Input Data Ke Database</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>
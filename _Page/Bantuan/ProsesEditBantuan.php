<?php
    //Keterangan zona waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    //Session akses
    include "../../_Config/Session.php";
    //menangkap data
    if(empty($_POST['id_bantuan'])){
        echo '<span class="text-danger">ID Bantuan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['judul'])){
            echo '<span class="text-danger">Judul Bantuan Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['tanggal'])){
                echo '<span class="text-danger">Tanggal Bantuan Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kategori'])){
                    echo '<span class="text-danger">Kategori Bantuan Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['isi'])){
                        echo '<span class="text-danger">Isi Bantuan Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Bantuan Tidak Boleh Kosong</span>';
                        }else{
                            $id_bantuan=$_POST['id_bantuan'];
                            $judul=$_POST['judul'];
                            $tanggal=$_POST['tanggal'];
                            $kategori=$_POST['kategori'];
                            $isi = str_replace("'", "\\'", $_POST['isi']);
                            // $isi = htmlspecialchars($isi);
                            $status=$_POST['status'];
                            //Update Bantuan
                            $UpdateBantuan = mysqli_query($Conn,"UPDATE bantuan SET 
                                judul='$judul',
                                tanggal='$tanggal',
                                kategori='$kategori',
                                status='$status',
                                isi='$isi'
                            WHERE id_bantuan='$id_bantuan'") or die(mysqli_error($Conn)); 
                            if($UpdateBantuan){
                                //Catat Log Aktivitas
                                $WaktuLog=date('Y-m-d H:i');
                                $nama_log="Edit Bantuan Berhasil";
                                $kategori_log="Bantuan";
                                include "../../_Config/Log.php";
                                $_SESSION['NotifikasiSwal']="Edit Bantuan Berhasil";
                                echo '<div id="NotifikasiEditBantuanBerhasil" class="text-primary">Berhasil</div>';
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
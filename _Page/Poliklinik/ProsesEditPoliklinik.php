<?php
    //Keterangan zona waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    //Session akses
    include "../../_Config/Session.php";
    //Menangkap variabel
    if(empty($_POST['id_poliklinik'])){
        echo '<span class="text-danger"><dt>Maaf!!</dt> ID Poliklinik Tidak Boleh Kosong!!</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger"><dt>Maaf!!</dt> Nama Poliklinik Tidak Boleh Kosong!!</span>';
        }else{
            if(empty($_POST['koordinator'])){
                echo '<span class="text-danger"><dt>Maaf!!</dt> Koordinator Poliklinik Tidak Boleh Kosong!!</span>';
            }else{
                if(empty($_POST['status'])){
                    echo '<span class="text-danger"><dt>Maaf!!</dt> Status Poliklinik Tidak Boleh Kosong!!</span>';
                }else{
                    //Buat Variabel
                    $GetNama=$_POST['nama'];
                    //Explode nama
                    $Pecah=explode("-" , $GetNama);
                    if(empty($Pecah[0])){
                        echo '<span class="text-danger"><dt>Maaf!!</dt> Format Penulisan Kode/Nama Poli Mungkin Salah!!</span>';
                    }else{
                        if(empty($Pecah[1])){
                            echo '<span class="text-danger"><dt>Maaf!!</dt> Format Penulisan Kode/Nama Poli Mungkin Salah!!</span>';
                        }else{
                            $kode=$Pecah[0];
                            $nama=$Pecah[1];
                            //Buat Variabel
                            $id_poliklinik=$_POST['id_poliklinik'];
                            $koordinator=$_POST['koordinator'];
                            $status=$_POST['status'];
                            $deskripsi=$_POST['deskripsi'];
                            $updatetime=date('Y-m-d H:i:s');
                            //Update data variabel
                            $UpdatePoliklinik = mysqli_query($Conn,"UPDATE poliklinik SET 
                                nama='$nama',
                                koordinator='$koordinator',
                                kode='$kode',
                                status='$status',
                                deskripsi='$deskripsi',
                                updatetime='$updatetime'
                            WHERE id_poliklinik='$id_poliklinik'") or die(mysqli_error($Conn)); 
                            if($UpdatePoliklinik){
                                $_SESSION['NotifikasiSwal']="Edit Poliklinik Berhasil";
                                echo '<div id="NotifikasiEditBerhasil" class="text-primary">Berhasil</div>';
                            }else{
                                echo '<span class="text-danger"><dt>Maaf!!</dt> Terjadi Kesalahan Pada Saat Proses Update Data Ke Database</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>
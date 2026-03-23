<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap data
    if(empty($_POST['Hari'])){
        echo '<span class="text-danger">Hari Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['jam1'])){
            echo '<span class="text-danger">Jam Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['jam2'])){
                echo '<span class="text-danger">Jam Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['id_dokter'])){
                    echo '<span class="text-danger">Data Dokter Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['id_poliklinik'])){
                        echo '<span class="text-danger">Data Poliklinik Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['kuota_non_jkn'])){
                            echo '<span class="text-danger">Kuota Non JKN Tidak Boleh Kosong Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['kuota_jkn'])){
                                echo '<span class="text-danger">Kuota JKN Tidak Boleh Kosong Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['time_max'])){
                                    echo '<span class="text-danger">Batas Waktu Pendaftaran Tidak Boleh Kosong</span>';
                                }else{
                                    //membuat variabel
                                    $kuota_non_jkn=$_POST['kuota_non_jkn'];
                                    $kuota_jkn=$_POST['kuota_jkn'];
                                    $hari=$_POST['Hari'];
                                    $jam1=$_POST['jam1'];
                                    $jam2=$_POST['jam2'];
                                    $id_dokter=$_POST['id_dokter'];
                                    $id_poliklinik=$_POST['id_poliklinik'];
                                    $time_max=$_POST['time_max'];
                                    //Validasi id-Dokter
                                    $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
                                    $DataDokter = mysqli_fetch_array($QryDokter);
                                    $dokter = $DataDokter['nama'];
                                    if(empty($DataDokter['nama'])){
                                        echo '<span class="text-danger">Dokter yang Anda Pilih Tidak Terdaftar</span>';
                                    }else{
                                        $QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
                                        $DataPoli = mysqli_fetch_array($QryPoli);
                                        $poliklinik = $DataPoli['nama'];
                                        if(empty($DataPoli['nama'])){
                                            echo '<span class="text-danger">Poliklinik yang Anda Pilih Tidak Terdaftar</span>';
                                        }else{
                                            $Input="INSERT INTO jadwal_dokter (
                                                id_dokter,
                                                id_poliklinik,
                                                dokter,
                                                poliklinik,
                                                hari,
                                                jam,
                                                kuota_non_jkn,
                                                kuota_jkn,
                                                time_max
                                            ) VALUES (
                                                '$id_dokter',
                                                '$id_poliklinik',
                                                '$dokter',
                                                '$poliklinik',
                                                '$hari',
                                                '$jam1-$jam2',
                                                '$kuota_non_jkn',
                                                '$kuota_jkn',
                                                '$time_max'
                                            )";
                                            $ProsesInput=mysqli_query($Conn, $Input);
                                            if($ProsesInput){
                                                //Catat Log Aktivitas
                                                $WaktuLog=date('Y-m-d H:i');
                                                $nama_log="Tambah Data Jadwal Dokter Berhasil";
                                                $kategori_log="Jadwal Dokter";
                                                include "../../_Config/Log.php";
                                                echo '<span id="NotifikasiTambahJadwalBerhasil">Berhasil</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi kegagalan pada saat input ke database</span>';
                                            }
                                        }
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


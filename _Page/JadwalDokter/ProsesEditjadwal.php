<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap data
    if(empty($_POST['id_jadwal'])){
        echo '<span class="text-danger">Id Jadwal Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['hari'])){
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
                            if(empty($_POST['time_max'])){
                                echo '<span class="text-danger">Batas Waktu Pendaftaran Tidak Boleh Kosong</span>';
                            }else{
                                //membuat variabel
                                $id_jadwal=$_POST['id_jadwal'];
                                $hari=$_POST['hari'];
                                $jam1=$_POST['jam1'];
                                $jam2=$_POST['jam2'];
                                $id_dokter=$_POST['id_dokter'];
                                $id_poliklinik=$_POST['id_poliklinik'];
                                $time_max=$_POST['time_max'];
                                if(empty($_POST['kuota_non_jkn'])){
                                    $kuota_non_jkn=0;
                                }else{
                                    $kuota_non_jkn=$_POST['kuota_non_jkn'];
                                }
                                if(empty($_POST['kuota_jkn'])){
                                    $kuota_jkn=0;
                                }else{
                                    $kuota_jkn=$_POST['kuota_jkn'];
                                }
                                $jam="$jam1-$jam2";
                                //buka data dokter
                                $sql=mysqli_query($Conn, "SELECT * FROM dokter WHERE id_dokter='$id_dokter'");
                                $data=mysqli_fetch_array($sql);
                                $nama_dokter=$data['nama'];
                                //buka data poliklinik
                                $sqlPoli=mysqli_query($Conn, "SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'");
                                $dataPoli=mysqli_fetch_array($sqlPoli);
                                $nama_poliklinik=$dataPoli['nama'];
                                $UpdateJadwal= mysqli_query($Conn,"UPDATE jadwal_dokter SET 
                                    id_dokter='$id_dokter',
                                    id_poliklinik='$id_poliklinik',
                                    dokter='$nama_dokter',
                                    poliklinik='$nama_poliklinik',
                                    hari='$hari',
                                    jam='$jam',
                                    kuota_non_jkn='$kuota_non_jkn',
                                    kuota_jkn='$kuota_jkn',
                                    time_max='$time_max'
                                WHERE id_jadwal='$id_jadwal'") or die(mysqli_error($Conn));
                                if($UpdateJadwal){
                                    //Catat Log Aktivitas
                                    $WaktuLog=date('Y-m-d H:i');
                                    $nama_log="Edit Data Jadwal Dokter Berhasil";
                                    $kategori_log="Jadwal Dokter";
                                    include "../../_Config/Log.php";
                                    echo '<span id="NotifikasiEditJadwalBerhasil">Berhasil</span><br>';
                                    echo 'Hari :<span id="GetDataHari">'.$hari.'</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi kegagalan pada saat update data ke database</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>


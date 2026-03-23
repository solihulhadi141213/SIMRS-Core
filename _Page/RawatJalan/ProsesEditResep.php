<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_resep'])){
        echo '<span class="text-danger">ID Resep Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">ID/No.RM Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama_pasien'])){
                echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_lahir'])){
                    echo '<span class="text-danger">Tanggal Lahir Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['tinggi_badan'])){
                        echo '<span class="text-danger">Tinggi Badan Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['berat_badan'])){
                            echo '<span class="text-danger">Berat Badan Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['luas_tubuh'])){
                                echo '<span class="text-danger">Luas Tubuh Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['tanggal_entry'])){
                                    echo '<span class="text-danger">Tanggal entry Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['jam_entry'])){
                                        echo '<span class="text-danger">Jam entry Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['petugas_entry'])){
                                            echo '<span class="text-danger">Petugas entry Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['tanggal_resep'])){
                                                echo '<span class="text-danger">Tanggal resep Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['jam_resep'])){
                                                    echo '<span class="text-danger">Jam Resep Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['id_dokter'])){
                                                        echo '<span class="text-danger">Dokter Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['isi_kategori'])){
                                                            echo '<span class="text-danger">Kategori Dokter Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['isi_nomor_kontak'])){
                                                                echo '<span class="text-danger">Kontak Dokter Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                //Membuat Variabel
                                                                $id_resep=$_POST['id_resep'];
                                                                $id_pasien=$_POST['id_pasien'];
                                                                $nama_pasien=$_POST['nama_pasien'];
                                                                $tanggal_lahir=$_POST['tanggal_lahir'];
                                                                $tinggi_badan=$_POST['tinggi_badan'];
                                                                $berat_badan=$_POST['berat_badan'];
                                                                $luas_tubuh=$_POST['luas_tubuh'];
                                                                $tanggal_entry=$_POST['tanggal_entry'];
                                                                $jam_entry=$_POST['jam_entry'];
                                                                $petugas_entry=$_POST['petugas_entry'];
                                                                $tanggal_resep=$_POST['tanggal_resep'];
                                                                $jam_resep=$_POST['jam_resep'];
                                                                $id_dokter=$_POST['id_dokter'];
                                                                $kategori_kontak=$_POST['isi_kategori'];
                                                                $nomor_kontak=$_POST['isi_nomor_kontak'];
                                                                //Buka Data Dokter
                                                                $NamaDokter=getDataDetail($Conn,"dokter",'id_dokter',$id_dokter,'nama');
                                                                if(empty($NamaDokter)){
                                                                    echo '<span class="text-danger">Nama Dokter Tidak Boleh Kosong!</span>';
                                                                }else{
                                                                    //Gabungkan Tanggal
                                                                    $tanggal_entry="$tanggal_entry $jam_entry";
                                                                    $tanggal_resep="$tanggal_resep $jam_resep";
                                                                    //Membuat JSON Kontak Dokter
                                                                    $kategori_kontak_array = array();
                                                                    if(!empty(count($kategori_kontak))){
                                                                        $JumlahKontak=count($kategori_kontak);
                                                                        for($i=0; $i<$JumlahKontak; $i++){
                                                                            $j['kategori_kontak'] =$kategori_kontak[$i];
                                                                            $j['nomor_kontak'] =$nomor_kontak[$i];
                                                                            array_push($kategori_kontak_array, $j);
                                                                        }
                                                                    }
                                                                    $JsonKontakDokter = json_encode($kategori_kontak_array);
                                                                    //Pasien
                                                                    $nama_pasien_array = array(
                                                                        "nama_pasien"=>"$nama_pasien",
                                                                        "tanggal_lahir"=>"$tanggal_lahir",
                                                                        "berat_badan"=>"$berat_badan",
                                                                        "tinggi_badan"=>"$tinggi_badan",
                                                                        "luas_tubuh"=>"$luas_tubuh"
                                                                    );
                                                                    $JsonNamaPasien = json_encode($nama_pasien_array);
                                                                    //Simpan Data Ke Database
                                                                    $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
                                                                        id_dokter='$id_dokter',
                                                                        nama_pasien='$JsonNamaPasien',
                                                                        petugas_entry='$petugas_entry',
                                                                        nama_dokter='$NamaDokter',
                                                                        kontak_dokter='$JsonKontakDokter',
                                                                        tanggal_entry='$tanggal_entry',
                                                                        tanggal_resep='$tanggal_resep'
                                                                    WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
                                                                    if($UpdateResep){
                                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Resep","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                        if($MenyimpanLog=="Berhasil"){
                                                                            echo '<span class="text-success" id="NotifikasiEditResepBerhasil">Success</span>';
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                        }
                                                                    }else{
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Resep</span>';
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
                        }
                    }
                }
            }
        }
    }
?>
<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi id_pasien tidak boleh kosong
        if(empty($_POST['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            //Validasi nama_pasien tidak boleh kosong
            if(empty($_POST['nama_pasien'])){
                echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
            }else{
                //Validasi tanggal tidak boleh kosong
                if(empty($_POST['tanggal'])){
                    echo '<small class="text-danger">Tanggal tidak boleh kosong</small>';
                }else{
                    //Validasi jam tidak boleh kosong
                    if(empty($_POST['jam'])){
                        echo '<small class="text-danger">Jam tidak boleh kosong</small>';
                    }else{
                        //Validasi tanggal periksa  boleh kosong
                        if(empty($_POST['tanggal_periksa'])){
                            echo '<small class="text-danger">Tanggal Pemeriksaan tidak boleh kosong</small>';
                        }else{
                            //Validasi jam tidak boleh kosong
                            if(empty($_POST['jam_periksa'])){
                                echo '<small class="text-danger">Jam Pemeriksaan tidak boleh kosong</small>';
                            }else{
                                //Validasi petugas_entry tidak boleh kosong
                                if(empty($_POST['petugas_entry'])){
                                    echo '<small class="text-danger">Petugas Entry tidak boleh kosong</small>';
                                }else{
                                    //Validasi dokter tidak boleh kosong
                                    if(empty($_POST['dokter'])){
                                        echo '<small class="text-danger">Nama dokter pemeriksa tidak boleh kosong</small>';
                                    }else{
                                        //Validasi perawat tidak boleh kosong
                                        if(empty($_POST['perawat'])){
                                            echo '<small class="text-danger">Perawat tidak boleh kosong</small>';
                                        }else{
                                            //Membuat variabel wajib
                                            $id_kunjungan=$_POST['id_kunjungan'];
                                            //Validasi Duplikat
                                            $id_pemeriksaan_fisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'id_pemeriksaan_fisik');
                                            $id_pasien=$_POST['id_pasien'];
                                            $nama_pasien=$_POST['nama_pasien'];
                                            $tanggal_catat=$_POST['tanggal'];
                                            $jam_catat=$_POST['jam'];
                                            $tanggal_periksa=$_POST['tanggal_periksa'];
                                            $jam_periksa=$_POST['jam_periksa'];
                                            $TanggalJam="$tanggal_catat $jam_catat";
                                            $TanggalJamPemeriksaan="$tanggal_periksa $jam_periksa";
                                            $petugas_entry=$_POST['petugas_entry'];
                                            $dokter=$_POST['dokter'];
                                            $perawat=$_POST['perawat'];
                                            $keluhan_utama="";
                                            //Array Petugas
                                            $PetugasEntryArray=Array (
                                                "nama" => $petugas_entry,
                                                "tanda_tangan" => ""
                                            );
                                            $DokterArray=Array (
                                                "nama" => $dokter,
                                                "tanda_tangan" => ""
                                            );
                                            $PerawatArray=Array (
                                                "nama" => $perawat,
                                                "tanda_tangan" => ""
                                            );
                                            //Json Nama Petugas
                                            $nama_petugas=Array (
                                                "petugas_entry" => $PetugasEntryArray,
                                                "dokter" => $DokterArray,
                                                "perawat" => $PerawatArray
                                            );
                                            //Json Riwayat Pengobatan
                                            $JsonPetugas= json_encode($nama_petugas);
                                            //Menyimpan Kedalam Database
                                            $entry="INSERT INTO pemeriksaan_fisik (
                                                id_pasien,
                                                id_kunjungan,
                                                id_akses,
                                                nama_pasien,
                                                nama_petugas,
                                                tanggal_entry,
                                                tanggal_pemeriksaan,
                                                gambar_anatomi,
                                                pemeriksaan_fisik,
                                                tanda_vital
                                            ) VALUES (
                                                '$id_pasien',
                                                '$id_kunjungan',
                                                '$SessionIdAkses',
                                                '$nama_pasien',
                                                '$JsonPetugas',
                                                '$TanggalJam',
                                                '$TanggalJamPemeriksaan',
                                                '',
                                                '',
                                                ''
                                            )";
                                            $hasil=mysqli_query($Conn, $entry);
                                            if($hasil){
                                                $LogJsonFile="../../_Page/Log/Log.json";
                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Pemeriksaan Fisik","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                if($MenyimpanLog=="Berhasil"){
                                                    echo '<span class="text-success" id="NotifikasiTambahPemeriksaanDasarBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                }
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Pemeriksaan dasar</span>';
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

<?php
    //datetime zone
    date_default_timezone_set('Asia/Jakarta');
    //include Connection.php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap data dari form
    if(empty($_POST['id_operasi'])){
        echo '<span class="text-danger">ID Operasi tidak bisa ditangkap oleh sistem</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">No.RM pasien tidak boleh kosong</span>';
        }else{
            if(empty($_POST['nama'])){
                echo '<span class="text-danger">Nama pasien tidak boleh kosong</span>';
            }else{
                if(empty($_POST['nopeserta'])){
                    echo '<span class="text-danger">No.Kartu tidak boleh kosong</span>';
                }else{
                    if(empty($_POST['tanggaloperasi'])){
                        echo '<span class="text-danger">Tanggal Operasi tidak boleh kosong</span>';
                    }else{
                        if(empty($_POST['jamoperasi'])){
                            echo '<span class="text-danger">Jam Operasi tidak boleh kosong</span>';
                        }else{
                            if(empty($_POST['jenistindakan'])){
                                echo '<span class="text-danger">Jenis Tindakan tidak boleh kosong</span>';
                            }else{
                                if(empty($_POST['kodepoli'])){
                                    echo '<span class="text-danger">Kode Poli tidak boleh kosong</span>';
                                }else{
                                    if(empty($_POST['status'])){
                                        $status="0";
                                    }else{
                                        $status=$_POST['status'];
                                    }
                                    if(empty($_POST['keterangan'])){
                                        echo '<span class="text-danger">Keterangan tidak boleh kosong</span>';
                                    }else{
                                        if(empty($_POST['kodebooking'])){
                                            echo '<span class="text-danger">Kode Booking tidak boleh kosong</span>';
                                        }else{
                                            //Buat variabel
                                            $id_operasi=$_POST['id_operasi'];
                                            $id_pasien=$_POST['id_pasien'];
                                            $nama=$_POST['nama'];
                                            $nopeserta=$_POST['nopeserta'];
                                            $tanggaloperasi=$_POST['tanggaloperasi'];
                                            $jamoperasi=$_POST['jamoperasi'];
                                            $jenistindakan=$_POST['jenistindakan'];
                                            $kodepoli=$_POST['kodepoli'];
                                            $status=$_POST['status'];
                                            $keterangan=$_POST['keterangan'];
                                            $kodebooking=$_POST['kodebooking'];
                                            $namapoli =getDataDetail($Conn,"poliklinik",'kode',$kodepoli,'nama');
                                            //tanggal daftar
                                            $tanggal_daftar=date('Y-m-d');
                                            $jam_daftar=date('H:i:s');
                                            $lastupdate=date('Y-m-d H:i:s');
                                            //Query untuk menambahkan data ke tabel jadwal_operasi
                                            $UpdateJadwalOperasi = mysqli_query($Conn,"UPDATE jadwal_operasi SET 
                                                id_pasien='$id_pasien',
                                                nama='$nama',
                                                nopeserta='$nopeserta',
                                                tanggal_daftar='$tanggal_daftar',
                                                jam_daftar='$jam_daftar',
                                                tanggaloperasi='$tanggaloperasi',
                                                jamoperasi='$jamoperasi',
                                                jenistindakan='$jenistindakan',
                                                kodepoli='$kodepoli',
                                                namapoli='$namapoli',
                                                keterangan='$keterangan',
                                                terlaksana='$status',
                                                kodebooking='$kodebooking',
                                                terlaksana='$status',
                                                lastupdate='$lastupdate'
                                            WHERE id_operasi='$id_operasi'") or die(mysqli_error($Conn)); 
                                            //Cek query
                                            if(!$UpdateJadwalOperasi){
                                                echo '<span class="text-danger">Edit Data Gagal</span>';
                                            }else{
                                                $_SESSION['NotifikasiSwal']="Edit Jadwal Operasi Berhasil";
                                                echo '<span class="text-success" id="NotifikasiEditJadwalOperasiBerhasil">Success</span><br>';
                                                echo '<small class="text-success" id="UrlBack">index.php?Page=JadwalOperasi&Sub=DetailJadwalOperasi&id='.$id_operasi.'</small>';
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
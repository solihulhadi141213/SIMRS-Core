<?php
    //datetime zone
    date_default_timezone_set('Asia/Jakarta');
    //include Connection.php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    //Tangkap data dari form
    if(empty($_POST['id_pasien'])){
        echo '<span class="text-danger">No.RM pasien tidak boleh kosong</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama pasien tidak boleh kosong</span>';
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
                                    $id_pasien=$_POST['id_pasien'];
                                    $nama=$_POST['nama'];
                                    $tanggaloperasi=$_POST['tanggaloperasi'];
                                    $jamoperasi=$_POST['jamoperasi'];
                                    $jenistindakan=$_POST['jenistindakan'];
                                    $kodepoli=$_POST['kodepoli'];
                                    $namapoli =getDataDetail($Conn,"poliklinik",'kode',$kodepoli,'nama');
                                    $status=$_POST['status'];
                                    $keterangan=$_POST['keterangan'];
                                    $kodebooking=$_POST['kodebooking'];
                                    //Form tidak wajib
                                    if(empty($_POST['nopeserta'])){
                                        $nopeserta="";
                                    }else{
                                        $nopeserta=$_POST['nopeserta'];
                                    }
                                    //tanggal daftar
                                    $tanggal_daftar=date('Y-m-d');
                                    $jam_daftar=date('H:i:s');
                                    $lastupdate=date('Y-m-d H:i:s');
                                    //Validasi Duplikat Data
                                    $ValidasiDuplikatData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_operasi WHERE id_pasien='$id_pasien' AND jamoperasi='$jamoperasi' AND tanggaloperasi='$tanggaloperasi'"));
                                    if(!empty($ValidasiDuplikatData)){
                                        echo '<span class="text-danger">Data Sudah Ada!</span>';
                                    }else{
                                        //Query untuk menambahkan data ke tabel jadwal_operasi
                                        $entry="INSERT INTO jadwal_operasi (
                                            id_pasien,
                                            nama,
                                            nopeserta,
                                            tanggal_daftar,
                                            jam_daftar,
                                            tanggaloperasi,
                                            jamoperasi,
                                            jenistindakan,
                                            kodepoli,
                                            namapoli,
                                            keterangan,
                                            terlaksana,
                                            kodebooking,
                                            lastupdate
                                        ) VALUES (
                                            '$id_pasien',
                                            '$nama',
                                            '$nopeserta',
                                            '$tanggal_daftar',
                                            '$jam_daftar',
                                            '$tanggaloperasi',
                                            '$jamoperasi',
                                            '$jenistindakan',
                                            '$kodepoli',
                                            '$namapoli',
                                            '$keterangan',
                                            '$status',
                                            '$kodebooking',
                                            '$lastupdate'
                                        )";
                                        $hasil=mysqli_query($Conn,$entry);
                                        //Cek query
                                        if($hasil){
                                            $LogJsonFile="../../_Page/Log/Log.json";
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Jadwal Operasi","Jadwal Operasi",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                $_SESSION['NotifikasiSwal']="Tambah Jadwal Operasi Berhasil";
                                                echo '<span class="text-success" id="NotifikasiTambahJadwalOperasiBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Tambah Jadwal Operasi Gagal! </span>';
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
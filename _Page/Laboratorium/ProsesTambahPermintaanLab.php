<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['tanggal'])){
        echo '<span class="text-danger">Tanggal Permintaan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['waktu'])){
            echo '<span class="text-danger">Jam/Waktu Permintaan Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['id_pasien'])){
                echo '<span class="text-danger">RM Pasien Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['nama_pasien'])){
                    echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['faskes'])){
                        echo '<span class="text-danger">Nama Faskes Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['prioritas'])){
                            echo '<span class="text-danger">Prioritas Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['nama_signature'])){
                                echo '<span class="text-danger">Nama Pemohon Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['signature'])){
                                    echo '<span class="text-danger">Tanda Tangan Tidak Boleh Kosong</span>';
                                }else{
                                    $tanggal=$_POST['tanggal'];
                                    $waktu=$_POST['waktu'];
                                    $Tanggal="$tanggal $waktu";
                                    $id_pasien=$_POST['id_pasien'];
                                    $nama_pasien=$_POST['nama_pasien'];
                                    $faskes=$_POST['faskes'];
                                    $prioritas=$_POST['prioritas'];
                                    $nama_signature=$_POST['nama_signature'];
                                    $signature=$_POST['signature'];
                                    $encoded_image = explode(",", $signature)[1];
                                    $decoded_image = base64_decode($encoded_image);
                                    if(empty($_POST['id_kunjungan'])){
                                        $id_kunjungan="0";
                                    }else{
                                        $id_kunjungan=$_POST['id_kunjungan'];
                                    }
                                    if(empty($_POST['jenis_kunjungan'])){
                                        $jenis_kunjungan="";
                                    }else{
                                        $jenis_kunjungan=$_POST['jenis_kunjungan'];
                                    }
                                    if(empty($_POST['id_dokter'])){
                                        $id_dokter="0";
                                        if(empty($_POST['dokter'])){
                                            $dokter="";
                                        }else{
                                            $dokter=$_POST['dokter'];
                                        }
                                    }else{
                                        $id_dokter=$_POST['id_dokter'];
                                        //Buka Nama Dokter
                                        $QryPasien = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
                                        $DataDokter = mysqli_fetch_array($QryPasien);
                                        if(empty($DataDokter['nama'])){
                                            $dokter="";
                                        }else{
                                            $dokter= $DataDokter['nama'];
                                        }
                                    }
                                    if(empty($_POST['unit'])){
                                        $unit="";
                                    }else{
                                        $unit=$_POST['unit'];
                                    }
                                    if(empty($_POST['diagnosis'])){
                                        $diagnosis="";
                                    }else{
                                        $diagnosis=$_POST['diagnosis'];
                                    }
                                    if(empty($_POST['keterangan_permintaan'])){
                                        $keterangan_permintaan="";
                                    }else{
                                        $keterangan_permintaan=$_POST['keterangan_permintaan'];
                                    }
                                    //simpan  data
                                    $ValidasiDuplikatData=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE id_pasien='$id_pasien' AND tanggal='$tanggal'"));
                                    if(!empty($ValidasiDuplikatData)){
                                        echo '<span class="text-danger">Data Tersebut Sudah Ada</span>';
                                    }else{
                                        //Menyimpan Data Radiologi
                                        $entry="INSERT INTO laboratorium_permintaan (
                                            id_pasien,
                                            id_kunjungan,
                                            id_dokter,
                                            tujuan,
                                            nama_pasien,
                                            nama_dokter,
                                            tanggal,
                                            faskes,
                                            unit,
                                            prioritas,
                                            diagnosis,
                                            keterangan_permintaan,
                                            nama_signature,
                                            signature,
                                            status,
                                            keterangan_status
                                        )VALUES (
                                            '$id_pasien',
                                            '$id_kunjungan',
                                            '$id_dokter',
                                            '$jenis_kunjungan',
                                            '$nama_pasien',
                                            '$dokter',
                                            '$Tanggal',
                                            '$faskes',
                                            '$unit',
                                            '$prioritas',
                                            '$diagnosis',
                                            '$keterangan_permintaan',
                                            '$nama_signature',
                                            '$encoded_image',
                                            'Pending',
                                            ''
                                        )";
                                        $hasil=mysqli_query($Conn, $entry);
                                        if($hasil){
                                            //menyimpan Log
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Permintaan Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                $_SESSION['NotifikasiSwal']="Tambah Permintaan Berhasil";
                                                echo '<span class="text-success" id="NotifikasiTambahPermintaanBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
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
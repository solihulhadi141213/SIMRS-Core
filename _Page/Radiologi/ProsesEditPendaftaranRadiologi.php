<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_rad'])){
        echo '<span class="text-danger">ID Rad Pasien Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">No RM Pasien Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['id_kunjungan'])){
                echo '<span class="text-danger">ID Kunjungan Pasien Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['nama'])){
                    echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['tanggal'])){
                        echo '<span class="text-danger">Tanggal Layanan Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['jam'])){
                            echo '<span class="text-danger">Jam Layanan Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['asal_kiriman'])){
                                echo '<span class="text-danger">Informasi Asal Kiriman Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['alat_pemeriksa'])){
                                    echo '<span class="text-danger">Informasi Alat/Pesawat Pemeriksaan Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['dokter_penerima'])){
                                        echo '<span class="text-danger">Dokter Penerima Tidak Boleh Kosong</span>';
                                    }else{
                                        if(empty($_POST['jenis_pembayaran'])){
                                            echo '<span class="text-danger">Jenis Pembayaran Tidak Boleh Kosong</span>';
                                        }else{
                                            $id_rad=$_POST['id_rad'];
                                            $id_pasien=$_POST['id_pasien'];
                                            $id_kunjungan=$_POST['id_kunjungan'];
                                            $nama=$_POST['nama'];
                                            $tanggal=$_POST['tanggal'];
                                            $jam=$_POST['jam'];
                                            $waktu="$tanggal $jam";
                                            $asal_kiriman=$_POST['asal_kiriman'];
                                            $permintaan_pemeriksaan=$_POST['permintaan_pemeriksaan'];
                                            $alat_pemeriksa=$_POST['alat_pemeriksa'];
                                            $dokter_penerima=$_POST['dokter_penerima'];
                                            $jenis_pembayaran=$_POST['jenis_pembayaran'];
                                            if(empty($_POST['permintaan_pemeriksaan'])){
                                                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan'))){
                                                    $permintaan_pemeriksaan="";
                                                }else{
                                                    $permintaan_pemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
                                                }
                                            }else{
                                                $permintaan_pemeriksaan=$_POST['permintaan_pemeriksaan'];
                                            }
                                            if(empty($_POST['dokter_pengirim'])){
                                                $dokter_pengirim="";
                                            }else{
                                                $dokter_pengirim=$_POST['dokter_pengirim'];
                                            }
                                            if(empty($_POST['kv'])){
                                                $kv="";
                                            }else{
                                                $kv=$_POST['kv'];
                                            }
                                            if(empty($_POST['ma'])){
                                                $ma="";
                                            }else{
                                                $ma=$_POST['ma'];
                                            }
                                            if(empty($_POST['sec'])){
                                                $sec="";
                                            }else{
                                                $sec=$_POST['sec'];
                                            }
                                            if(empty($permintaan_pemeriksaan)){
                                                echo '<span class="text-danger">Permintaan POemeriksaan Tidak Boleh Kosong</span>';
                                            }else{
                                                //Menyimpan Data Radiologi
                                                $UpdatePendaftaranRadiologi=mysqli_query($Conn, "UPDATE radiologi SET 
                                                    id_pasien='$id_pasien', 
                                                    id_kunjungan='$id_kunjungan', 
                                                    nama='$nama', 
                                                    waktu='$waktu', 
                                                    asal_kiriman='$asal_kiriman', 
                                                    permintaan_pemeriksaan='$permintaan_pemeriksaan', 
                                                    alat_pemeriksa='$alat_pemeriksa', 
                                                    jenis_pembayaran='$jenis_pembayaran', 
                                                    dokter_pengirim='$dokter_pengirim', 
                                                    dokter_penerima='$dokter_penerima', 
                                                    kv='$kv', 
                                                    ma='$ma', 
                                                    sec='$sec', 
                                                    sec='$sec'
                                                WHERE id_rad ='$id_rad'");
                                                if($UpdatePendaftaranRadiologi){
                                                    //menyimpan Log
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Pendaftaran Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        $_SESSION['NotifikasiSwal']="Edit Radiologi Berhasil";
                                                        echo '<input type="hidden" name="GetBackUrl" id="GetBackUrl" value="index.php?Page=Radiologi&Sub=DetailRadiologi&id='.$id_rad.'">';
                                                        echo '<span class="text-success" id="NotifikasiEditPendaftaranRadiologiBerhasil">Success</span>';
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
        }
    }
?>
<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Add Kunjungan');
    //Validasi Form Data
    if(empty($_POST['id_web_pasien'])){
        echo '<span class="text-danger">ID Pasien Web Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['tanggal_daftar'])){
            echo '<span class="text-danger">Tanggal Daftar Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['tanggal_kunjungan'])){
                echo '<span class="text-danger">Tanggal Kunjungan Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kodepoli'])){
                    echo '<span class="text-danger">Poliklinik Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['kode_dokter'])){
                        echo '<span class="text-danger">Dokter Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['jam_kunjungan'])){
                            echo '<span class="text-danger">Jam Kunjungan Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['pembayaran'])){
                                echo '<span class="text-danger">Metode Pembayaran Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['status'])){
                                    echo '<span class="text-danger">Status Kunjungan Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['id_pasien'])){
                                        echo '<span class="text-danger">Setidaknya pasien tersebut harus memiliki nomor RM terlebih dulu</span>';
                                    }else{
                                        $id_web_pasien=$_POST['id_web_pasien'];
                                        $tanggal_daftar=$_POST['tanggal_daftar'];
                                        $tanggal_kunjungan=$_POST['tanggal_kunjungan'];
                                        $kodepoli=$_POST['kodepoli'];
                                        $kode_dokter=$_POST['kode_dokter'];
                                        $jam_kunjungan=$_POST['jam_kunjungan'];
                                        $pembayaran=$_POST['pembayaran'];
                                        $status=$_POST['status'];
                                        //Variabel lainnya yang tidak wajib
                                        if(empty($_POST['id_pasien'])){
                                            $id_pasien="";
                                        }else{
                                            $id_pasien=$_POST['id_pasien'];
                                        }
                                        if(empty($_POST['nomorreferensi'])){
                                            $nomorreferensi="";
                                        }else{
                                            $nomorreferensi=$_POST['nomorreferensi'];
                                        }
                                        if(empty($_POST['no_antrian'])){
                                            $no_antrian="";
                                        }else{
                                            $no_antrian=$_POST['no_antrian'];
                                        }
                                        if(empty($_POST['kodebooking'])){
                                            $kodebooking="";
                                        }else{
                                            $kodebooking=$_POST['kodebooking'];
                                        }
                                        if(empty($_POST['keluhan'])){
                                            $keluhan="";
                                        }else{
                                            $keluhan=$_POST['keluhan'];
                                        }
                                        if(empty($_POST['keterangan'])){
                                            $keterangan="";
                                        }else{
                                            $keterangan=$_POST['keterangan'];
                                        }
                                        $KirimData = array(
                                            'api_key' => $api_key,
                                            'id_web_pasien' => $id_web_pasien,
                                            'id_pasien' => $id_pasien,
                                            'tanggal_daftar' => $tanggal_daftar,
                                            'tanggal_kunjungan' => $tanggal_kunjungan,
                                            'jam_kunjungan' => $jam_kunjungan,
                                            'kode_dokter' => $kode_dokter,
                                            'kodepoli' => $kodepoli,
                                            'keluhan' => $keluhan,
                                            'pembayaran' => $pembayaran,
                                            'status' => $status,
                                            'no_antrian' => $no_antrian,
                                            'kodebooking' => $kodebooking,
                                            'keterangan' => $keterangan
                                        );
                                        $json = json_encode($KirimData);
                                        //Mulai CURL
                                        $ch = curl_init();
                                        curl_setopt($ch,CURLOPT_URL, "$Url");
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($ch,CURLOPT_HEADER, 0);
                                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        $content = curl_exec($ch);
                                        $err = curl_error($ch);
                                        curl_close($ch);
                                        if(!empty($err)){
                                            echo '<span class="text-danger">'.$err.'</span>';
                                        }else{
                                            $JsonData =json_decode($content, true);
                                            if(!empty($JsonData['metadata']['massage'])){
                                                $massage=$JsonData['metadata']['massage'];
                                            }else{
                                                $massage="";
                                            }
                                            if(!empty($JsonData['metadata']['code'])){
                                                $code=$JsonData['metadata']['code'];
                                            }else{
                                                $code="";
                                            }
                                            if($code==200){
                                                $_SESSION['NotifikasiSwal']="Tambah Kunjungan Berhasil";
                                                echo '<span class="text-success" id="NotifikasiTambahKunjunganBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">'.$massage.'</span>';
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
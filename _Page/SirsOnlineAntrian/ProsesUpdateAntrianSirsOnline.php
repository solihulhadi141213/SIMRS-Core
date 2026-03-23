<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Log
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['kodebooking'])){
        echo '<span class="text-danger">Kode Booking Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['jenispasien'])){
            echo '<span class="text-danger">Jenis Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nik'])){
                echo '<span class="text-danger">NIK Pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['kodepoli'])){
                    echo '<span class="text-danger">Kode Poli Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['namapoli'])){
                        echo '<span class="text-danger">Nama Poli Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['norm'])){
                            echo '<span class="text-danger">Nomor RM Pasien Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['tanggalperiksa'])){
                                echo '<span class="text-danger">Tanggal Diperiksa Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['kodedokter'])){
                                    echo '<span class="text-danger">Kode Dokter Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['namadokter'])){
                                        echo '<span class="text-danger">Nama Dokter Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['tanggal_praktek_mulai'])){
                                            echo '<span class="text-danger">Tanggal Praktek Awal Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['jam_praktek_mulai'])){
                                                echo '<span class="text-danger">Jam Praktek Awal Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['tanggal_praktek_akhir'])){
                                                    echo '<span class="text-danger">Tanggal Praktek Akhir Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['jam_praktek_akhir'])){
                                                        echo '<span class="text-danger">Jam Praktek Akhir Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['jeniskunjungan'])){
                                                            echo '<span class="text-danger">Jenis Kunjungan Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['nomorantrean'])){
                                                                echo '<span class="text-danger">Nomor Antrean Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                if(empty($_POST['angkaantrean'])){
                                                                    echo '<span class="text-danger">Angka Antrean Tidak Boleh Kosong!</span>';
                                                                }else{
                                                                    if(empty($_POST['tanggal_estimasidilayani'])){
                                                                        echo '<span class="text-danger">Tanggal Estimasi Dilayani Tidak Boleh Kosong!</span>';
                                                                    }else{
                                                                        if(empty($_POST['jam_estimasidilayani'])){
                                                                            echo '<span class="text-danger">Jam Estimasi Dilayani Tidak Boleh Kosong!</span>';
                                                                        }else{
                                                                            $kodebooking=$_POST['kodebooking'];
                                                                            $jenispasien=$_POST['jenispasien'];
                                                                            $nik=$_POST['nik'];
                                                                            $kodepoli=$_POST['kodepoli'];
                                                                            $namapoli=$_POST['namapoli'];
                                                                            $norm=$_POST['norm'];
                                                                            $tanggalperiksa=$_POST['tanggalperiksa'];
                                                                            $kodedokter=$_POST['kodedokter'];
                                                                            $namadokter=$_POST['namadokter'];
                                                                            $tanggal_praktek_mulai=$_POST['tanggal_praktek_mulai'];
                                                                            $jam_praktek_mulai=$_POST['jam_praktek_mulai'];
                                                                            $tanggal_praktek_akhir=$_POST['tanggal_praktek_akhir'];
                                                                            $jam_praktek_akhir=$_POST['jam_praktek_akhir'];
                                                                            $jeniskunjungan=$_POST['jeniskunjungan'];
                                                                            $nomorantrean=$_POST['nomorantrean'];
                                                                            $angkaantrean=$_POST['angkaantrean'];
                                                                            $tanggal_estimasidilayani=$_POST['tanggal_estimasidilayani'];
                                                                            $jam_estimasidilayani=$_POST['jam_estimasidilayani'];
                                                                            $estimasidilayani="$tanggal_estimasidilayani $jam_estimasidilayani";
                                                                            $estimasidilayani=strtotime($estimasidilayani);
                                                                            if(empty($_POST['pasienbaru'])){
                                                                                $pasienbaru="0";
                                                                            }else{
                                                                                $pasienbaru=$_POST['pasienbaru'];
                                                                            }
                                                                            if(empty($_POST['nomorreferensi'])){
                                                                                $nomorreferensi="";
                                                                            }else{
                                                                                $nomorreferensi=$_POST['nomorreferensi'];
                                                                            }
                                                                            if(empty($_POST['keterangan'])){
                                                                                $keterangan="";
                                                                            }else{
                                                                                $keterangan=$_POST['keterangan'];
                                                                            }
                                                                            //Jam Praktek Awal
                                                                            $jampraktekawal ="$tanggal_praktek_mulai $jam_praktek_mulai";
                                                                            //Jam Praktek Akhir
                                                                            $jampraktekakhir ="$tanggal_praktek_akhir $jam_praktek_akhir";
                                                                            //Estimasi Dilayani
                                                                            $estimasidilayani ="$tanggal_estimasidilayani $jam_estimasidilayani";
                                                                            $estimasidilayani =strtotime($estimasidilayani);
                                                                            //Buat json
                                                                            $data = array(
                                                                                'kodebooking' => $kodebooking,
                                                                                'jenispasien' => $jenispasien,
                                                                                'nik' => $nik,
                                                                                'kodepoli' => $kodepoli,
                                                                                'namapoli' => $namapoli,
                                                                                'pasienbaru' => $pasienbaru,
                                                                                'norm' => $norm,
                                                                                'tanggalperiksa' => $tanggalperiksa,
                                                                                'kodedokter' => $kodedokter,
                                                                                'jampraktekawal' => $jampraktekawal,
                                                                                'jampraktekakhir' => $jampraktekakhir,
                                                                                'namadokter' => $namadokter,
                                                                                'jeniskunjungan' => $jeniskunjungan,
                                                                                'nomorreferensi' => $nomorreferensi,
                                                                                'nomorantrean' => $nomorantrean,
                                                                                'angkaantrean' => $angkaantrean,
                                                                                'estimasidilayani' => $estimasidilayani,
                                                                                'keterangan' => $keterangan
                                                                            );
                                                                            $json_data = json_encode($data);
                                                                            //Kirim Data
                                                                            $KirimData=UpdateBookingAntrian($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                                                                            $response = json_decode($KirimData, true);
                                                                            $status=$response['antrian'][0]['status'];
                                                                            if($status=="200"){
                                                                                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Update Booking Antrian","Antrian SIRS Online",$SessionIdAkses,$LogJsonFile);
                                                                                if($MenyimpanLog=="Berhasil"){
                                                                                    echo '<span class="text-success" id="NotifikasiUpdateAntrianSirsOnlineBerhasil">Success</span>';
                                                                                }else{
                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                }
                                                                            }else{
                                                                                echo '<span class="text-danger">Update Booking Antrian Gagal!</span><br>';
                                                                                echo '<span class="text-danger">Keterangan : '.$KirimData.'</span>';
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
        }
    }
?>
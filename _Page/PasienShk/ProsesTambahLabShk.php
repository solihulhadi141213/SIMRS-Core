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
    if(empty($_POST['id_shk'])){
        echo '<span class="text-danger">ID SHK Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['jenis_pemeriksaan'])){
            echo '<span class="text-danger">Jenis Pemeriksaan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['hasil_pemeriksaan'])){
                echo '<span class="text-danger">Hasil Pemeriksaan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['layak_sampel'])){
                    echo '<span class="text-danger">Layak Sample Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['tgl_periksa'])){
                        echo '<span class="text-danger">Tanggal Periksa Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['tgl_hasil'])){
                            echo '<span class="text-danger">Tanggal Hasil Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['tgl_terima'])){
                                echo '<span class="text-danger">Tanggal Terima Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['tgllapor'])){
                                    echo '<span class="text-danger">Tanggal Lapor Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['jamlapor'])){
                                        echo '<span class="text-danger">Jam Lapor Tidak Boleh Kosong!</span>';
                                    }else{
                                        $id_shk=$_POST['id_shk'];
                                        $jenis_pemeriksaan=$_POST['jenis_pemeriksaan'];
                                        $hasil_pemeriksaan=$_POST['hasil_pemeriksaan'];
                                        $layak_sampel=$_POST['layak_sampel'];
                                        $tgl_periksa=$_POST['tgl_periksa'];
                                        $tgl_hasil=$_POST['tgl_hasil'];
                                        $tgl_terima=$_POST['tgl_terima'];
                                        $tgllapor=$_POST['tgllapor'];
                                        $jamlapor=$_POST['jamlapor'];
                                        //Gabungkan tanggal lapor
                                        $tanggal_lapor="$tgllapor $jamlapor";
                                        $tanggal_lapor=strtotime($tanggal_lapor);
                                        $tgllapor=date('Y-m-d H:i:s',$tanggal_lapor);
                                        //Id Lauak
                                        $id_layak=$_POST['layak_sampel'];
                                        //Nama Pemeriksaan
                                        if($jenis_pemeriksaan=="1"){
                                            $nama_pemeriksaan="Pemeriksaan TSH";
                                        }else{
                                            $nama_pemeriksaan="Pemeriksaan Tes Konfirmasi";
                                        }
                                        //nama_hasil
                                        if($hasil_pemeriksaan=="1"){
                                            $nama_hasil="TSH Normal (< 20 μU/mL)";
                                        }else{
                                            if($hasil_pemeriksaan=="2"){
                                                $nama_hasil="TSH Tinggi (? 20 μU/mL)";
                                            }else{
                                                if($hasil_pemeriksaan=="3"){
                                                    $nama_hasil="Positif (Serum FT4 di bawah normal, FT4 normal ATAU TSH >= 20µU/ml (2 kali pemeriksaan))";
                                                }else{
                                                    $nama_hasil="Negatif";
                                                }
                                            }
                                        }
                                        //Buat json
                                        $data = array(
                                            'id_shk' => $id_shk,
                                            'jenis_pemeriksaan' => $jenis_pemeriksaan,
                                            'nama_pemeriksaan' => $nama_pemeriksaan,
                                            'hasil_pemeriksaan' => $hasil_pemeriksaan,
                                            'nama_hasil' => $nama_hasil,
                                            'tgl_periksa' => $tgl_periksa,
                                            'tgl_hasil' => $tgl_hasil,
                                            'layak_sampel' => $layak_sampel,
                                            'id_layak' => $id_layak,
                                            'tgl_terima' => $tgl_terima,
                                            'tgllapor' => $tgllapor
                                        );
                                        $json_data = json_encode($data);
                                        //Kirim Data
                                        $KirimData=TambahHasilLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                                        if(empty($KirimData)){
                                            echo '<span class="text-danger">Tidak ada response apapun dari service SIRS Online</span>';
                                        }else{
                                            $response = json_decode($KirimData, true);
                                            if($response['shk'][0]['status']=="200"){
                                                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah Lab Pasien SHK","Pasien SHK",$SessionIdAkses,$LogJsonFile);
                                                if($MenyimpanLog=="Berhasil"){
                                                    echo '<span class="text-success" id="NotifikasiTambahHasilLabPasienShkBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                }
                                            }else{
                                                echo '<span class="text-danger">'.$KirimData.'</span>';
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
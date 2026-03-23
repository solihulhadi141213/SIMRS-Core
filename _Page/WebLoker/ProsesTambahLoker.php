<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Add Loker');
    //Validasi tanggal_expired tidak boleh kosong
    if(empty($_POST['tanggal_expired'])){
        echo '<span class="text-danger">Tanggal Tidak Boleh Kosong</span>';
    }else{
        //Validasi jam_expired tidak boleh kosong
        if(empty($_POST['jam_expired'])){
            echo '<span class="text-danger">Jam Tidak Boleh Kosong</span>';
        }else{
            //Validasi jumlah_loker tidak boleh kosong
            if(empty($_POST['jumlah_loker'])){
                echo '<span class="text-danger">Jumlah Loker Tidak Boleh Kosong</span>';
            }else{
                //Validasi status_loker tidak boleh kosong
                if(empty($_POST['status_loker'])){
                    echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                }else{
                    //Validasi posisi_jabatan tidak boleh kosong
                    if(empty($_POST['posisi_jabatan'])){
                        echo '<span class="text-danger">Posisi Jabatan Tidak Boleh Kosong</span>';
                    }else{
                        //Validasi deskripsi_loker tidak boleh kosong
                        if(empty($_POST['deskripsi_loker'])){
                            echo '<span class="text-danger">Deskripsi Tidak Boleh Kosong</span>';
                        }else{
                            //Validasi pengumuman tidak boleh kosong
                            if(empty($_POST['pengumuman'])){
                                $pengumuman="";
                            }else{
                                $pengumuman=$_POST['pengumuman'];
                            }
                            $deskripsi_loker=$_POST['deskripsi_loker'];
                            $posisi_jabatan=$_POST['posisi_jabatan'];
                            $status_loker=$_POST['status_loker'];
                            $jumlah_loker=$_POST['jumlah_loker'];
                            $jam_expired=$_POST['jam_expired'];
                            $tanggal_expired=$_POST['tanggal_expired'];
                            $datetime_expired="$tanggal_expired $jam_expired";
                            $datetime_post=date('Y-m-d H:i');
                            //Proses Kirim Data
                            $KirimData = array(
                                'api_key' => $api_key,
                                'datetime_post' => $datetime_post,
                                'datetime_expired' => $datetime_expired,
                                'posisi_jabatan' => $posisi_jabatan,
                                'jumlah_loker' => $jumlah_loker,
                                'deskripsi_loker' => $deskripsi_loker,
                                'status_loker' => $status_loker
                            );
                            $json = json_encode($KirimData);
                            //Mulai CURL
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, "$url");
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
                                if($code!==200){
                                    echo '<span class="text-danger">Gagal!! <br> Pesan: '.$massage.' <br> content: '.$content.'</span>';
                                }else{
                                    $_SESSION['NotifikasiSwal']="Tambah Loker Berhasil";
                                    echo '<span class="text-success" id="NotifikasiTambahLokerBerhasil">Success</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
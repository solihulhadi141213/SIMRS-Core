<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Hubungi Admin');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_pesan'])){
        echo '<span class="text-danger">ID Pesan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['nama_pengirim'])){
            echo '<span class="text-danger">Nama Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['email_pengirim'])){
                echo '<span class="text-danger">Email Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kontak'])){
                    echo '<span class="text-danger">Kontak Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['kategori'])){
                        echo '<span class="text-danger">Kategori Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['subjek'])){
                            echo '<span class="text-danger">Subjek Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['pesan'])){
                                echo '<span class="text-danger">Pesan Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['pesan_balasan'])){
                                    echo '<span class="text-danger">Pesan Balasan Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['status'])){
                                        echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                                    }else{
                                        $id_pesan=$_POST['id_pesan'];
                                        $nama_pengirim=$_POST['nama_pengirim'];
                                        $email_pengirim=$_POST['email_pengirim'];
                                        $kontak=$_POST['kontak'];
                                        $kategori=$_POST['kategori'];
                                        $subjek=$_POST['subjek'];
                                        $pesan=$_POST['pesan'];
                                        $pesan_balasan=$_POST['pesan_balasan'];
                                        $status=$_POST['status'];
                                        $KirimData = array(
                                            'api_key' => $api_key,
                                            'id_pesan' => $id_pesan,
                                            'tanggal' => $updatetime,
                                            'nama_pengirim' => $nama_pengirim,
                                            'email_pengirim' => $email_pengirim,
                                            'kontak' => $kontak,
                                            'kategori' => $kategori,
                                            'subjek' => $subjek,
                                            'pesan' => $pesan,
                                            'pesan_balasan' => $pesan_balasan,
                                            'status' => $status
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
                                                echo '<span class="text-success" id="NotifikasiEditPesanBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">'.$content.'</span>';
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
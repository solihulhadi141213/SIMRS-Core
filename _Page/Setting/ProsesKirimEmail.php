<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['email_tujuan'])){
        echo '<span class="text-danger">Email Tujuan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_tujuan'])){
            echo '<span class="text-danger">Nama Penerima Pesan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['pesan'])){
                echo '<span class="text-danger">Isi Pesan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['subjek'])){
                    echo '<span class="text-danger">Subjek Pesan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['EmailGateway'])){
                        echo '<span class="text-danger">Email Gateway Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['PasswordGateway'])){
                            echo '<span class="text-danger">Password Email Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['UrlProvider'])){
                                echo '<span class="text-danger">URL Provider Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['PortGateway'])){
                                    echo '<span class="text-danger">PORT SMTP Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['NamaPengirim'])){
                                        echo '<span class="text-danger">Nama Pengirim Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['UrlService'])){
                                            echo '<span class="text-danger">URL Service Tidak Boleh Kosong!</span>';
                                        }else{
                                            $email_tujuan=$_POST['email_tujuan'];
                                            $nama_tujuan=$_POST['nama_tujuan'];
                                            $pesan=$_POST['pesan'];
                                            $subjek=$_POST['subjek'];
                                            //Membuka Pengaturan
                                            $EmailGateway=$_POST['EmailGateway'];
                                            $PasswordGateway=$_POST['PasswordGateway'];
                                            $UrlProvider=$_POST['UrlProvider'];
                                            $PortGateway=$_POST['PortGateway'];
                                            $NamaPengirim=$_POST['NamaPengirim'];
                                            $UrlService=$_POST['UrlService'];
                                            //Kirim Email
                                            $KirimData = array(
                                                'subjek' => $subjek,
                                                'email_asal' => $EmailGateway,
                                                'password_email_asal' => $PasswordGateway,
                                                'url_provider' => $UrlProvider,
                                                'nama_pengirim' => $NamaPengirim,
                                                'email_tujuan' => $email_tujuan,
                                                'nama_tujuan' => $nama_tujuan,
                                                'pesan' => $pesan,
                                                'port' => $PortGateway
                                            );
                                            $json = json_encode($KirimData);
                                            //Mulai CURL
                                            $ch = curl_init();
                                            curl_setopt($ch,CURLOPT_URL, "$UrlService");
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
                                                $_SESSION['NotifikasiSwal']="Kirim Email Berhasil";
                                                echo '<span class="text-success" id="NotifikasiKirimEmailBerhasil">Success</span>';
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
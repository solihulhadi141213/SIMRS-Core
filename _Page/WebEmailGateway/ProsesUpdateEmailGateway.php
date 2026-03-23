<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Update Email Gateway');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['id_setting_email_gateway'])){
        echo '<span class="text-danger">ID gateway Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['email_gateway'])){
            echo '<span class="text-danger">Email Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['password_gateway'])){
                echo '<span class="text-danger">Password Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['url_provider'])){
                    echo '<span class="text-danger">URL Provider Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['port_gateway'])){
                        echo '<span class="text-danger">PORT Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['nama_pengirim'])){
                            echo '<span class="text-danger">Nama Pengirim Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['url_service'])){
                                echo '<span class="text-danger">URL Service Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['validasi_email'])){
                                    echo '<span class="text-danger">Status Validasi Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['redirect_validasi'])){
                                        echo '<span class="text-danger">URL Redirect  Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['pesan_validasi_email'])){
                                            echo '<span class="text-danger">Pesan Validasi Tidak Boleh Kosong!</span>';
                                        }else{
                                            $id_setting_email_gateway=$_POST['id_setting_email_gateway'];
                                            $email_gateway=$_POST['email_gateway'];
                                            $password_gateway=$_POST['password_gateway'];
                                            $url_provider=$_POST['url_provider'];
                                            $port_gateway=$_POST['port_gateway'];
                                            $nama_pengirim=$_POST['nama_pengirim'];
                                            $url_service=$_POST['url_service'];
                                            $validasi_email=$_POST['validasi_email'];
                                            $redirect_validasi=$_POST['redirect_validasi'];
                                            $pesan_validasi_email=$_POST['pesan_validasi_email'];
                                            $KirimData = array(
                                                'api_key' => $api_key,
                                                'id_setting_email_gateway' => $id_setting_email_gateway,
                                                'email_gateway' => $email_gateway,
                                                'password_gateway' => $password_gateway,
                                                'url_provider' => $url_provider,
                                                'port_gateway' => $port_gateway,
                                                'nama_pengirim' => $nama_pengirim,
                                                'url_service' => $url_service,
                                                'validasi_email' => $validasi_email,
                                                'redirect_validasi' => $redirect_validasi,
                                                'pesan_validasi_email' => $pesan_validasi_email
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
                                                    $_SESSION['NotifikasiSwal']="Update Email Gateway Berhasil";
                                                    echo '<span class="text-success" id="NotifikasiUpdateEmailGatewayBerhasil">Success</span>';
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
    }
?>
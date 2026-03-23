<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    //URL
    $NamaService="Update Tentang RS";
    $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='Update Tentang RS'")or die(mysqli_error($Conn));
    $DataService = mysqli_fetch_array($QryService);
    if(!empty($DataService['url_service'])){
        $url_update_tentang= $DataService['url_service'];
    }else{
        $url_update_tentang="";
    }
    $updatetime=date('Y-m-d H:i');
    //Validasi GetSejarah tidak boleh kosong
    if(empty($_POST['GetSejarah'])){
        echo '<span class="text-danger">Sejarah Tidak Boleh Kosong</span>';
    }else{
        //Validasi GetVisi tidak boleh kosong
        if(empty($_POST['GetVisi'])){
            echo '<span class="text-danger">Visi Tidak Boleh Kosong</span>';
        }else{
            //Validasi GetMisi tidak boleh kosong
            if(empty($_POST['GetMisi'])){
                echo '<span class="text-danger">Misi Tidak Boleh Kosong</span>';
            }else{
                //Validasi GetLokasi tidak boleh kosong
                if(empty($_POST['GetLokasi'])){
                    echo '<span class="text-danger">Lokasi Tidak Boleh Kosong</span>';
                }else{
                    $GetSejarah=$_POST['GetSejarah'];
                    $GetVisi=$_POST['GetVisi'];
                    $GetMisi=$_POST['GetMisi'];
                    $GetLokasi=$_POST['GetLokasi'];
                    if(empty($api_key)){
                        echo '<span class="text-danger">Api key Kosong, Silahkan atur API key terlebih dulu</span>';
                    }else{
                        if(empty($url_update_tentang)){
                            echo '<span class="text-danger">URL Proses Kosong, Silahkan atur URL proses terlebih dulu</span>';
                        }else{
                            //Akses Data Dari Server Website
                            $KirimData = array(
                                'api_key' => $api_key,
                                'web_sejarah' => $GetSejarah,
                                'web_visi' => $GetVisi,
                                'web_misi' => $GetMisi,
                                'web_lokasi' => $GetLokasi,
                            );
                            $json = json_encode($KirimData);
                            //Mulai CURL
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, "$url_update_tentang");
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
                                    echo '<span class="text-danger">'.$massage.'</span>';
                                }else{
                                    $_SESSION['NotifikasiSwal']="Update Tentang";
                                    echo '<span class="text-success" id="NotifikasiUpdateTentangBerhasil">Success</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Page/WebSlider/FungsiSlider.php";
    $Url=urlService('Edit Slider');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_web_hero'])){
        echo '<span class="text-danger">ID Slider Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['hero_title'])){
            echo '<span class="text-danger">Judul Slider Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['hero_button'])){
                echo '<span class="text-danger">Text Tombol Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['hero_url'])){
                    echo '<span class="text-danger">URL Tombol Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['hero_deskripsi'])){
                        echo '<span class="text-danger">Deskripsi Slider Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_FILES['hero_img']['name'])){
                            $hex_string ="";
                            $ValidasiGambar="Valid";
                        }else{
                            //Validasi Tipe File
                            $tipe_gambar = $_FILES['hero_img']['type']; 
                            //ukuran gambar
                            $ukuran_gambar = $_FILES['hero_img']['size']; 
                            //Ukurn Maksiman 1mb
                            $UkuranMaksimal=2000*1000;
                            //Konversi Ke Base64
                            $TmpFile=$_FILES['hero_img']['tmp_name'];
                            $bin_string = file_get_contents($TmpFile);
                            $hex_string = base64_encode($bin_string);
                            //Validasi Ukuran File
                            if($ukuran_gambar>$UkuranMaksimal){
                                $ValidasiGambar="Untuk slider sebaiknya tidak lebih dari 2 Mb";
                            }else{
                                //Validasi Tipe File
                                if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                                    $ValidasiGambar="Valid";
                                }else{
                                    $ValidasiGambar="logo hanya boleh berformat jpg, jpg, gif atau png";
                                }
                            }
                        }
                        if($ValidasiGambar!=="Valid"){
                            echo '<span class="text-danger">'.$ValidasiGambar.'</span>';
                        }else{
                            $id_web_hero=$_POST['id_web_hero'];
                            $hero_title=$_POST['hero_title'];
                            $hero_button=$_POST['hero_button'];
                            $hero_url=$_POST['hero_url'];
                            $hero_deskripsi=$_POST['hero_deskripsi'];
                            $KirimData = array(
                                'api_key' => $api_key,
                                'id_web_hero' => $id_web_hero,
                                'hero_title' => $hero_title,
                                'hero_deskripsi' => $hero_deskripsi,
                                'hero_button' => $hero_button,
                                'hero_url' => $hero_url,
                                'hero_img' => $hex_string
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
                                    echo '<span class="text-success" id="NotifikasiEditSliderBerhasil">Success</span>';
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
?>
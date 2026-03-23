<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingAkses.php";
    //Tangkap Data Dari Form
    if(empty($_POST['access_key'])){
        echo '<small class="text-danger">Access Key Tidak Boleh Kosong!</small>';
    }else{
        if(empty($_POST['title_credential'])){
            echo '<small class="text-danger"> Title Credential Tidak Boleh Kosong!</small>';
        }else{
            if(empty($_POST['sub_title_credential'])){
                echo '<small class="text-danger">Sub Title Credential Tidak Boleh Kosong!</small>';
            }else{
                //Buat Variabel
                $access_key_form=$_POST['access_key'];
                $title_credential=$_POST['title_credential'];
                $sub_title_credential=$_POST['sub_title_credential'];
                //Buka Data Setting
                $settingsFile="setting-koneksi.json";
                if(!file_exists($settingsFile)) {
                    echo '<small class="text-danger">File Setting Tidak Ditemukan!</small>';
                }else{
                    $settingsData = json_decode(file_get_contents($settingsFile), true);
                    $base_url_monitor=$settingsData['base-url-monitor'];
                    $access_key=$settingsData['access-key'];
                    //Validasi $access_key dari form
                    if($access_key!==$access_key_form){
                        echo '<small class="text-danger">Access Key Pada Form Tidak Valid!</small>';
                    }else{
                        //Persiapan Kirim Data
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => ''.$base_url_monitor.'/_Api/creat-credential.php',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                            "access-key":"'.$access_key.'",
                            "title":"'.$title_credential.'",
                            "sub-title":"'.$sub_title_credential.'",
                            "antrian-position":"00"
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        if(empty($response)){
                            echo '<small class="text-danger">Tidak ada response Dari Monitor!</small>';
                        }else{
                            $arry=json_decode($response,true);
                            if(empty($arry['success'])){
                                echo '<small class="text-danger">Terjadi kesalahan pada saat mengirimkan data ke monitor!</small>';
                            }else{
                                if($arry['success']!==true){
                                    echo '<small class="text-danger">'.$arry['success'].'</small>';
                                }else{
                                    echo '<small id="NotifikasiTambahCredentialBerhasil" class="text-success">Success</small>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
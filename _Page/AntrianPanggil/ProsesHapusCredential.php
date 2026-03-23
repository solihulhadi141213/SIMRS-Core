<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingAkses.php";
    //Tangkap Data Dari Form
    if(empty($_POST['kode_akses'])){
        echo '<small class="text-danger">Kode Akses Tidak Boleh Kosong!</small>';
    }else{
        //Buat Variabel
        $kode_akses=$_POST['kode_akses'];
        //Buka Data Setting
        $settingsFile="setting-koneksi.json";
        if(!file_exists($settingsFile)) {
            echo '<small class="text-danger">File Setting Tidak Ditemukan!</small>';
        }else{
            $settingsData = json_decode(file_get_contents($settingsFile), true);
            $base_url_monitor=$settingsData['base-url-monitor'];
            $access_key=$settingsData['access-key'];
            //Persiapan Kirim Data
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => ''.$base_url_monitor.'/_Api/delete-credential.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "access-key":"'.$access_key.'",
                    "kode-akses":"'.$kode_akses.'"
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
                if(empty($arry['code'])){
                    echo '<small class="text-danger">Terjadi kesalahan pada saat mengirimkan data ke monitor!</small>';
                }else{
                    if($arry['code']!==200){
                        echo '<small class="text-danger">'.$arry['message'].'</small>';
                    }else{
                        echo '<small id="NotifikasiHapusCredentialBerhasil" class="text-success">Success</small>';
                    }
                }
            }
        }
    }
?>
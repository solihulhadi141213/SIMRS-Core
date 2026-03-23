<?php
    //Zona Waktu
    include "_Config/Connection.php";
    include "_Config/SimrsFunction.php";
    include "_Config/SettingBridging.php";
    include "vendor/autoload.php";
    if(empty($_GET['parameter'])){
        echo "Nomor Kartu Tidak Boleh Kosong";
    }else{
        if(empty($_GET['kodedokter'])){
            echo "Kode Dokter Tidak Boleh Kosong";
        }else{
            $nomor_kartu=$_GET['parameter'];
            $kode_dokter=$_GET['kodedokter'];
            date_default_timezone_set('UTC');
            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
            //Creat Signature
            $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
            $signature = base64_encode($signature);
            // base64 encode…
            $encodedSignature = base64_encode($signature);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apijkn.bpjs-kesehatan.go.id/wsihs/api/rs/validate',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "param": "'.$nomor_kartu.'",
                "kodedokter": '.$kode_dokter.'
            }',
            CURLOPT_HTTPHEADER => array(
                'X-signature: '.$signature.'',
                'X-timestamp: '.$timestamp.'',
                'X-cons-id: '.$consid.'',
                'user_key: '.$user_key.'',
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo 'No-Kartu: '.$nomor_kartu.'<br>';
            // echo 'Kode Dokter: '.$kode_dokter.'<br>';
            // echo 'Cons ID : '.$consid.'<br>';
            // echo 'Timestamp : '.$timestamp.'<br>';
            // echo 'secret_key : '.$secret_key.'<br>';
            // echo 'SIGN : '.$signature.'<br>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <dt>Response: </dt>';
            echo '      <textarea class="form-control">'.$response.'</textarea>';
            echo '  </div>';
            echo '</div>';
            //Proses decode dan dekompresi
            $ambil_json =json_decode($response, true);
            $string=$ambil_json["response"];
            //--membuat key
            $key="$consid$secret_key$timestamp";
            //--masukan ke fungsi
            $FileDeskripsi=stringDecrypt("$key", "$string");
            $FileDekompresi=decompress("$FileDeskripsi");
            //--konveris json to raw
            // $JsonData =json_decode($FileDekompresi, true);
            
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <dt>Dekompress: </dt>';
            echo '      <textarea class="form-control">'.$FileDekompresi.'</textarea>';
            echo '  </div>';
            echo '</div>';
            $ambil_json =json_decode($FileDekompresi, true);
            $url=$ambil_json['url'];
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <a href="'.$url.'" class="btn btn-md btn-block btn-outline-info">Go To iCare</a>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>
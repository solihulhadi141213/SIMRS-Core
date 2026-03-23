<?php
    //Arraykan data
    $url ="$url_aplicare/rest/bed/delete/$kode_ppk";
    //KONFIGURASI
    date_default_timezone_set('UTC');
    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    //Creat Signature
    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
    // base64 encode…
    $encodedSignature = base64_encode($signature);
    $ch=curl_init();
    $headers = array(
        'X-signature: '.$encodedSignature.'',
        'X-timestamp: '.$timestamp.'' ,
        'X-cons-id: '.$consid .'',
        'user_key: '.$user_key.'',
        'Content-Type: Application/JSON',          
        'Accept: Application/JSON'     
    ); 
    $arr = array(
        "kodekelas" => "$kodekelas",
        "koderuang" => "$koderuang"
    );
    $json = json_encode($arr);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if($content==false){
        echo 'Tidak ada koneksi <br>';
    }else{
        $get =json_decode($content, true);
        $pesan=$get["metadata"]["message"];
        $code=$get["metadata"]["code"];
        echo ''.$pesan.'<br>';
    }
?>
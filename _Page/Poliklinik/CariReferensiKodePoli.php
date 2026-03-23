<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    // function decrypt
    function stringDecrypt($key, $string){
        $encrypt_method = 'AES-256-CBC';
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }
    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    function decompress($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
    //menangkap string
    if(!empty($_POST['nama'])){
        $nama=$_POST['nama'];
        //Timestamp
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        //Membuat header
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type:Application/x-www-form-urlencoded'         
        ); 
        //Membuat URL
        $URLUtama=$url_vclaim;
        $URLKatalog="referensi/poli/$nama";
        $url="$URLUtama$URLKatalog";
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $ambil_json =json_decode($content, true);
        $string=$ambil_json["response"];
        //Proses decode dan dekompresi
        //--membuat key
        $key="$consid$secret_key$timestamp";
        //--masukan ke fungsi
        $FileDeskripsi=stringDecrypt("$key", "$string");
        $FileDekompresi=decompress("$FileDeskripsi");
        //--konveris json to raw
        $JsonData =json_decode($FileDekompresi, true);
        //--Get row poli
        $Poli=$JsonData['poli'];
        //--Hitung jumlah list
        $JumlahPoli=count($Poli);
        for($a=0; $a<$JumlahPoli; $a++){
            $kode=$Poli[$a]['kode'];
            $nama=$Poli[$a]['nama'];
            echo '<option value="'.$kode.'">';
        }
    }
    
?>
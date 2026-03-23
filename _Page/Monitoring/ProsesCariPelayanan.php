<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //menangkap data dari form
    if(empty($_POST['NoKartu'])){
        $NoKartu="";
    }else{
        $NoKartu=$_POST['NoKartu'];
    }
    if(empty($_POST['Tgl1'])){
        $Tgl1="";
    }else{
        $Tgl1=$_POST['Tgl1'];
    }
    if(empty($_POST['Tgl2'])){
        $Tgl2="";
    }else{
        $Tgl2=$_POST['Tgl2'];
    }
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
    $TanggalSekarang=date('Y-m-d');
    $URLUtama=$url_vclaim;
    $URLKatalog="monitoring/HistoriPelayanan/NoKartu/$NoKartu/tglMulai/$Tgl1/tglAkhir/$Tgl2";
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
    $code=$ambil_json["metaData"]["code"];
    $message=$ambil_json["metaData"]["message"];
    $string=$ambil_json["response"];
    //Proses decode dan dekompresi
    //--membuat key
    $key="$consid$secret_key$timestamp";
    //--masukan ke fungsi
    $FileDeskripsi=stringDecrypt("$key", "$string");
    $FileDekompresi=decompress("$FileDeskripsi");
    //--konveris json to raw
    $JsonData =json_decode($FileDekompresi, true);
    $list=$JsonData['histori'];
    //--Hitung jumlah sep
    $Jumlah=count($list);
    if(empty($Jumlah)){
        echo "<tr><td align='center' colspan='5'>$message</td></tr>";
    }else{
        $no=1;
        for($a=0; $a<$Jumlah; $a++){
            $diagnosa=$list[$a]['diagnosa'];
            $jnsPelayanan=$list[$a]['jnsPelayanan'];
            $kelasRawat=$list[$a]['kelasRawat'];
            $namaPeserta=$list[$a]['namaPeserta'];
            $noKartu=$list[$a]['noKartu'];
            $noSep=$list[$a]['noSep'];
            $noRujukan=$list[$a]['noRujukan'];
            $poli=$list[$a]['poli'];
            $ppkPelayanan=$list[$a]['ppkPelayanan'];
            $tglPlgSep=$list[$a]['tglPlgSep'];
            $tglSep=$list[$a]['tglSep'];
            echo '<tr>';
            echo '  <td align="center">'.$no.'</td>';
            echo '  <td align="left">';
            echo '      <dt>'.$noSep.'</dt>';
            echo '      '.$jnsPelayanan.'';
            echo '      '.$diagnosa.'';
            echo '  </td>';
            echo '  <td align="left">'.$noKartu.'</td>';
            echo '  <td align="left">'.$namaPeserta.'</td>';
            echo '  <td align="left">'.$tglSep.' - '.$tglPlgSep.'</td>';
            echo '</tr>';
        $no++;}
    }
?>
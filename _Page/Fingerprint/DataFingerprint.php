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
    $URLKatalog="SEP/FingerPrint/List/Peserta/TglPelayanan/$TanggalSekarang";
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
    //--Get row poli
    $list=$JsonData['list'];
    //--Hitung jumlah list
    $Jumlah=count($list);
    if(empty($Jumlah)){
        echo "Sistem Tidak Menemukan Data<br>";
        echo "<dt>KETERANGAN :</dt>$message<br>";
    }else{
?>
<div class="table table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>No.Kartu</th>
                <th>No.SEP</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $no=1;
            for($a=0; $a<$Jumlah; $a++){
                $noKartu=$list[$a]['noKartu'];
                $noSEP=$list[$a]['noSEP'];
                echo '<tr>';
                echo '  <td class="text-center">'.$no.'</td>';
                echo '  <td>'.$noKartu.'</td>';
                echo '  <td>'.$noSEP.'</td>';
                echo '</tr>';
            $no++;}
        ?>
        </tbody>
    </table>
</div>
<?php } ?>
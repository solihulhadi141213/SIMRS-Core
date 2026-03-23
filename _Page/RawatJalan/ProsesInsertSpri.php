<?php
    //Pengaturan waktu
    date_default_timezone_set('UTC');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Inisiasi masing-masing variabel
    if(empty($_POST['noKartu'])){
        $noKartu="";
    }else{
        $noKartu=$_POST['noKartu'];
    }
    if(empty($_POST['kodeDokter'])){
        $kodeDokter="";
    }else{
        $kodeDokter=$_POST['kodeDokter'];
    }
    if(empty($_POST['poliKontrol'])){
        $poliKontrol="";
    }else{
        $poliKontrol=$_POST['poliKontrol'];
    }
    if(empty($_POST['tglRencanaKontrol'])){
        $tglRencanaKontrol="";
    }else{
        $tglRencanaKontrol=$_POST['tglRencanaKontrol'];
    }
    if(empty($_POST['user'])){
        $user="";
    }else{
        $user=$_POST['user'];
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
    $arr = array("request" =>
        array(
            "noKartu"=> "$noKartu",
            "kodeDokter"=> "$kodeDokter",
            "poliKontrol"=> "$poliKontrol",
            "tglRencanaKontrol"=>"$tglRencanaKontrol",
            "user"=>"$user"
        )
    );
    
    $json = json_encode($arr);
    //Membuat URL
    $TanggalSekarang=date('Y-m-d');
    $URLUtama=$url_vclaim;
    $URLKatalog="RencanaKontrol/InsertSPRI";
    $url="$URLUtama$URLKatalog";
    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
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
    $JsonData =json_decode($FileDekompresi, true);
    //--konveris json to raw
    if($code=="200"){
        //Menangkap data json menjadi variabel
        $noSPRI=$JsonData["noSPRI"];
        $tglRencanaKontrol=$JsonData["tglRencanaKontrol"];
        $namaDokter=$JsonData["namaDokter"];
        $noKartu=$JsonData["noKartu"];
        $nama=$JsonData["nama"];
        $kelamin=$JsonData["kelamin"];
        $tglLahir=$JsonData["tglLahir"];
        $namaDiagnosa=$JsonData["tglLahir"];
        if(!empty($string)){
            //Menyimpan data ke data approval
            $entry="INSERT INTO rencana_kontrol (
                kategori,
                noSuratKontrol,
                noSPRI,
                noSEP,
                kodeDokter,
                namaDokter,
                noKartu,
                nama,
                kelamin,
                tglLahir,
                poliKontrol,
                tglRencanaKontrol,
                user,
                namaDiagnosa
            ) VALUES (
                'SPRI',
                '',
                '$noSPRI',
                '',
                '$kodeDokter',
                '$namaDokter',
                '$noKartu',
                '$nama',
                '$kelamin',
                '$tglLahir',
                '$poliKontrol',
                '$tglRencanaKontrol',
                '$user',
                '$namaDiagnosa'
            )";
            $hasil=mysqli_query($Conn, $entry);
            if($hasil){
                echo '<span class="text-info" id="NotifikasiInsertSpriBerhasil">Berhasil</span><br>';
            }else{
                echo '<span class="text-danger">Menyimpan SPRI gagal!!</span><br>';
            }
        }
    }else{
        echo '<span class="text-danger">Maaf, kirim SPRI gagal!!</span><br>';
        echo '<span class="text-danger">Keterangan :'.$message.'<br>';
    }
?>
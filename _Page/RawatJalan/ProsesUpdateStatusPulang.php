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
    if(empty($_POST['noSep'])){
        $noSep="";
    }else{
        $noSep=$_POST['noSep'];
    }
    if(empty($_POST['statusPulang'])){
        $statusPulang="";
    }else{
        $statusPulang=$_POST['statusPulang'];
    }
    if(empty($_POST['tglMeninggal'])){
        $tglMeninggal="";
    }else{
        $tglMeninggal=$_POST['tglMeninggal'];
    }
    if(empty($_POST['tglPulang'])){
        $tglPulang="";
    }else{
        $tglPulang=$_POST['tglPulang'];
    }
    if(empty($_POST['noSuratMeninggal'])){
        $noSuratMeninggal="";
    }else{
        $noSuratMeninggal=$_POST['noSuratMeninggal'];
    }
    if(empty($_POST['noLPManual'])){
        $noLPManual="";
    }else{
        $noLPManual=$_POST['noLPManual'];
    }
    if(empty($_POST['user'])){
        $user="";
    }else{
        $user=$_POST['user'];
    }
    //Inisiasi status
    if($statusPulang!=="4"){
        $status="Pulang";
    }else{
        $status="Meninggal";
    }
    //Inisiasi cara keluar
    if($statusPulang!=="1"){
        $CaraKeluar="Atas Persetujuan Dokter";
    }else{
        if($statusPulang!=="3"){
            $CaraKeluar="Atas Permintaan Sendiri";
        }else{
            if($statusPulang!=="4"){
                $CaraKeluar="Meninggal";
            }else{
                if($statusPulang!=="4"){
                    $CaraKeluar="Lain-lain";
                }else{
                    $CaraKeluar="Lain-lain";
                }
            }
        }
    }
    //Inisiasi updatetime
    $updatetime=date('Y-m-d H:i:s');
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
        array("t_sep"=>
            array(
                "noSep"=> "$noSep",
                "statusPulang"=> "$statusPulang",
                "noSuratMeninggal"=> "$noSuratMeninggal",
                "tglMeninggal"=> "$tglMeninggal",
                "tglPulang"=>"$tglPulang",
                "noLPManual"=>"$noLPManual",
                "user"=>"$user"
            )
        )
    );
    $json = json_encode($arr);
    //Membuat URL
    $TanggalSekarang=date('Y-m-d');
    $URLUtama=$url_vclaim;
    $URLKatalog="SEP/2.0/updtglplg";
    $url="$URLUtama$URLKatalog";
    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
    $noSep=$JsonData["sep"]["noSep"];
    //--konveris json to raw
    if($code=="200"){
        $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
            cara_keluar='$CaraKeluar',
            tanggal_keluar='$tglPulang',
            status='$status',
            updatetime='$updatetime'
        WHERE sep='$noSep'") or die(mysqli_error($Conn));
        if($UpdateKunjungan){
            echo '<span class="text-info" id="NotifikasiUpdateStatusPulangBerhasil">Berhasil</span><br>';
        }else{
            echo '<span class="text-danger">Update data Kunjungan pada SIMRS Gagal!!</span><br>';
        }
    }else{
        echo '<span class="text-danger">Maaf, Update Status Pulang gagal!!</span><br>';
        echo '<span class="text-danger">Keterangan :'.$message.'<br>';
    }
?>
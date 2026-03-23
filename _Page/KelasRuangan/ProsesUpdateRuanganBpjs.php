<?php
    //Koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    if(empty($_POST['namaruang'])){
        $namaruang="";
    }else{
        $namaruang=$_POST['namaruang'];
    }
    if(empty($_POST['namakelas'])){
        $namakelas="";
    }else{
        $namakelas=$_POST['namakelas'];
    }
    if(empty($_POST['kapasitas'])){
        $kapasitas=0;
    }else{
        $kapasitas=$_POST['kapasitas'];
    }
    if(empty($_POST['tersediapria'])){
        $tersediapria=0;
    }else{
        $tersediapria=$_POST['tersediapria'];
    }
    if(empty($_POST['tersediawanita'])){
        $tersediawanita=0;
    }else{
        $tersediawanita=$_POST['tersediawanita'];
    }
    if(empty($_POST['tersediapriawanita'])){
        $tersediapriawanita=0;
    }else{
        $tersediapriawanita=$_POST['tersediapriawanita'];
    }
    if(empty($_POST['lastupdate'])){
        $lastupdate="";
    }else{
        $lastupdate=$_POST['lastupdate'];
    }
    if(empty($_POST['kodekelas'])){
        $kodekelas="";
    }else{
        $kodekelas=$_POST['kodekelas'];
    }
    $tersedia=$tersediapria+$tersediawanita+$tersediapriawanita;
    //Melakukan tambah data BPJS
    $url ="$url_aplicare/rest/bed/update/$kode_ppk";
    //KONFIGURASI
    date_default_timezone_set('UTC');
    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
    // base64 encode…
    $encodedSignature = base64_encode($signature);
    $ch = curl_init();
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
        "koderuang" => "$namaruang",
        "namaruang" => "$namaruang",
        "kapasitas" => "$kapasitas",
        "tersedia" => "$tersedia",
        "tersediapria" => "$tersediapria",
        "tersediawanita" => "$tersediawanita",
        "tersediapriawanita" => "$tersediapriawanita"
    );
    $json = json_encode($arr);
    curl_setopt($ch, CURLOPT_URL, "$url_aplicare/rest/bed/update/$kode_ppk");
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
        $pesan="<i class='danger'>Koneksi Gagal-Update Data</i>";
    }else{
        $get =json_decode($content, true);
        $pesan=$get["metadata"]["message"];
        $code=$get["metadata"]["code"];
        if($code=="200"){
            echo '<span id="NotifikasiUpdateRuanganBpjsBerhasil">Success</span>';
        }else{
            echo "$pesan";
        }
    }
?>
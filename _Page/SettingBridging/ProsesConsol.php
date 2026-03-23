<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //Menangkap parameter
    if(empty($_POST['url'])){
        $url="";
    }else{
        $url=$_POST['url'];
    }
    if(empty($_POST['consid'])){
        $consid="";
    }else{
        $consid=$_POST['consid'];
    }
    if(empty($_POST['user_key'])){
        $user_key="";
    }else{
        $user_key=$_POST['user_key'];
    }
    if(empty($_POST['secret_key'])){
        $secret_key="";
    }else{
        $secret_key=$_POST['secret_key'];
    }
    if(empty($_POST['kode_ppk'])){
        $kode_ppk="";
    }else{
        $kode_ppk=$_POST['kode_ppk'];
    }
    if(empty($_POST['timestamp'])){
        $timestamp="";
    }else{
        $timestamp=$_POST['timestamp'];
    }
    if(empty($_POST['signature'])){
        $signature="";
    }else{
        $signature=$_POST['signature'];
    }
    if(empty($_POST['method'])){
        $method="";
    }else{
        $method=$_POST['method'];
    }
    if(empty($_POST['request'])){
        $request="";
    }else{
        $request=$_POST['request'];
    }
    $ch = curl_init();
    $headers = array(
        'X-signature: '.$signature.'',
        'X-timestamp: '.$timestamp.'' ,
        'X-cons-id: '.$consid .'',
        'user_key: '.$user_key.'',
        'Content-Type:Application/x-www-form-urlencoded'         
    ); 
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "$method");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    $ambil_json =json_decode($content, true);
    if(empty($ambil_json["metaData"]['message'])){
        $metadata=$ambil_json["metadata"]['message'];
    }else{
        $metadata=$ambil_json["metaData"]['message'];
    }
    $string=$ambil_json["response"];
    $key="$consid$secret_key$timestamp";
    if($content==false){
        echo "<dt>Notif:</dt> ERROR<br>";
        echo "<dt>Kontent:</dt> $content<br>";
        echo "<dt>Metadata:</dt> $metadata<br>";
    }else{
        echo "<dt>Notif:</dt> BERHASIL<br>";
        echo "<dt>Kontent:</dt> $content<br>";
        echo "<dt>Metadata:</dt> $metadata<br>";
    }
?>
<?php
    //Error Display dan koneksi database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //Arraykan data
    $url ="$url_aplicare/rest/bed/read/$kode_ppk/0/100";
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
    $headers = array(
        'X-signature: '.$encodedSignature.'',
        'X-timestamp: '.$timestamp.'' ,
        'X-cons-id: '.$consid .'',
        'user_key: '.$user_key.'',
        'Content-Type: Application/JSON',          
        'Accept: Application/JSON'
    );
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
    $data =json_decode($content, true);
    if(empty($data["response"]["list"])){
        $list="";
    }else{
        $list=$data["response"]["list"];
    }
    $totalitems=$data["metadata"]["totalitems"];
    if($content==false){
        echo "Maaf, Tidak ada koneksi!! $send $data2 $data";
    }else{
        if(empty($totalitems)){
        }else{
            for($a=0; $a<$totalitems; $a++){
                $tersedia=$list[$a]['tersedia'];
                $kodekelas=$list[$a]['kodekelas'];
                $namakelas=$list[$a]['namakelas'];
                $tersediapria=$list[$a]['tersediapria'];
                $tersediawanita=$list[$a]['tersediawanita'];
                $koderuang=$list[$a]['koderuang'];
                $tersediapriawanita=$list[$a]['tersediapriawanita'];
                $namaruang=$list[$a]['namaruang'];
                $rownumber=$list[$a]['rownumber'];
                $kapasitas=$list[$a]['kapasitas'];
                $lastupdate=$list[$a]['lastupdate'];
                //Proses Hapusnya Disini
                include "DeleteRuangBpjs.php";
            }
        }
        //Catat Log Aktivitas
        $WaktuLog=date('Y-m-d H:i');
        $nama_log="Hapus Semua Data Aplicare Berhasil";
        $kategori_log="Kelas Ruangan";
        include "../../_Config/Log.php";
    }
?>
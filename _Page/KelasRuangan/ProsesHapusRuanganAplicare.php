<?php
    //Error Display dan koneksi database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //tangkap data kodekelas
    if(empty($_POST['kodekelas'])){
        $kodekelas="";
        echo '<span class="text-danger">Kode Kelas Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['koderuang'])){
            $koderuang="";
            echo '<span class="text-danger">Kode Ruangan Tidak Boleh Kosong!</span>';
        }else{
            $kodekelas=$_POST['kodekelas'];
            $koderuang=$_POST['koderuang'];
        }
    }
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
        echo '<div class="alert alert-danger" role="alert">';
        echo "  <b>Hapus Data Aplicare Gagal!!</b><br>";
        echo "  <small>$content</small><br>";
        echo '</div>';
    }else{
        $get =json_decode($content, true);
        $pesan=$get["metadata"]["message"];
        $code=$get["metadata"]["code"];
        if($pesan!=="Data berhasil dihapus."){
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Hapus Ruangan Aplicare Berhasil";
            $kategori_log="Kelas Ruangan";
            include "../../_Config/Log.php";
            echo '<div class="alert alert-danger" role="alert">';
            echo "  <b>Hapus Data Aplicare Gagal!!</b><br>";
            echo "  <small>$pesan</small><br>";
            echo '</div>';
        }else{
            echo '<div class="alert alert-info" role="alert">';
            echo "  <b>HAPUS BERHASIL!!</b><br>";
            echo "  <input type='hidden' id='NotifikasiHapusRuanganAplicareBerhasil' value='Berhasil'>";
            echo '</div>';
        }
    }
?>
<?php
    
    // Connection, Function, Session AND autoload
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    include "../../vendor/autoload.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo ' 
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Validasi no_bpjs
    if(empty($_POST['no_bpjs'])){
        echo ' 
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>NIK Tidak Boleh Kosong.</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }
    
    // Creat Variable
    $no_bpjs = validateAndSanitizeInput($_POST['no_bpjs']);

    // Mencari Pengaturan Bridging BPJS Yang Aktif
    $stmt = mysqli_prepare($Conn,"SELECT * FROM setting_bpjs WHERE status = 1 ORDER BY id_setting_bpjs DESC LIMIT 1");
    if (!$stmt) {
        echo ' 
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>Terjadi kesalahan pada saat membuka pengaturan koneksi bridging BPJS</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (empty($setting)) {
        echo ' 
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>Pengaturan Koneksi Bridging BPJS Tidak Ditemukan</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabelnya
    $consid          = trim($setting['consid'] ?? '');
    $user_key        = trim($setting['user_key'] ?? '');
    $user_key_antrol = trim($setting['user_key_antrol'] ?? '');
    $secret_key      = trim($setting['secret_key'] ?? '');
    $kode_ppk        = trim($setting['kode_ppk'] ?? '');
    $url_vclaim      = rtrim(trim($setting['url_vclaim'] ?? ''), '/');
    $url_antrol      = $setting['url_antrol'];

    //Timestamp
    date_default_timezone_set('UTC');
    $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

    //Creat Signature
    $signature = hash_hmac('sha256', $consid."&".$tStamp, $secret_key, true);
    $encodedSignature = base64_encode($signature);
    $urlencodedSignature = urlencode($encodedSignature);

    // base64 encode…
    $key="$consid$secret_key$tStamp";

    //Membuat header
    $headers = array(
        'Content-Type:Application/x-www-form-urlencoded',
        'X-cons-id: '.$consid .'',
        'X-timestamp: '.$tStamp.'' ,
        'X-signature: '.$encodedSignature.'',
        'user_key: '.$user_key_antrol.''
    ); 
    //Membuat URL
    $tglSEP = date('Y-m-d');
    $url="$url_vclaim/Peserta/nokartu/$no_bpjs/tglSEP/$tglSEP";

    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    $response_arry   = json_decode($response, true);
    $response_string = $response_arry["response"];
    $metadata        = $response_arry["metaData"];
    $code            = $metadata["code"];
    $message         = $metadata["message"];

    // Response Error
    if($code!=="200"){
        echo ' 
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>'.$message.'</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    $Decrypted    = stringDecrypt($key, $response_string);
    $decompressed = decompress("$Decrypted");
    $json_decode  = json_decode($decompressed, true);

    // Buat Variabel Informasi Pasien
    $noKartu   = $json_decode['peserta']['noKartu'];
    $nama      = $json_decode['peserta']['nama'];
    $nik_bpjs  = $json_decode['peserta']['nik'];
    $tglLahir  = $json_decode['peserta']['tglLahir'];
    $sex       = $json_decode['peserta']['sex'];
    $noTelepon = $json_decode['peserta']['mr']['noTelepon'];

    echo ' 
       <div class="row mb-2 mb-2">
            <div class="col-4"><small>Nomor Kartu</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$noKartu.'</small></div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$nama.'</small></div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-4"><small>NIK</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$nik_bpjs.'</small></div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-4"><small>Tanggal Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$tglLahir.'</small></div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-4"><small>Sex</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$sex.'</small></div>
        </div>
        <div class="row mb-2 mb-3">
            <div class="col-4"><small>Kontak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$noTelepon.'</small></div>
        </div>
    ';
    exit;
?>
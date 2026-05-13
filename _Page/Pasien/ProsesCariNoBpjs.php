<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function, Session AND autoload
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    include "../../vendor/autoload.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo json_encode(["status"  => "Error", "message" => "Sesi Akses Sudah Berakhir! Silahkan Login Ulang."]);
        exit;
    }

    // Validasi no_bpjs
    if(empty($_POST['no_bpjs'])){
        echo json_encode(["status"  => "Error", "message" => "NIK Tidak Boleh Kosong"]);
        exit;
    }
    
    // Creat Variable
    $no_bpjs = validateAndSanitizeInput($_POST['no_bpjs']);

    // Mencari Pengaturan Bridging BPJS Yang Aktif
    $stmt = mysqli_prepare($Conn,"SELECT * FROM setting_bpjs WHERE status = 1 ORDER BY id_setting_bpjs DESC LIMIT 1");
    if (!$stmt) {
        echo "Terjadi kesalahan pada saat membuka pengaturan koneksi bridging BPJS";
        exit;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (empty($setting)) {
        echo "Pengaturan Koneksi Bridging BPJS Tidak Ditemukan";
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
        echo json_encode(["status"  => "Error", "message" => $message]);
        exit;
    }

    $Decrypted    = stringDecrypt($key, $response_string);
    $decompressed = decompress("$Decrypted");
    $json_decode  = json_decode($decompressed, true);

    // Buat Variabel Informasi Pasien
    $noKartu      = $json_decode['peserta']['noKartu'];
    $nama         = $json_decode['peserta']['nama'];
    $nik_bpjs     = $json_decode['peserta']['nik'];
    $tglLahir     = $json_decode['peserta']['tglLahir'];
    $sex          = $json_decode['peserta']['sex'];
    $noTelepon    = $json_decode['peserta']['mr']['noTelepon'];
    $jenisPeserta = $json_decode['peserta']['jenisPeserta']['keterangan'];

    // Metadata Response
    $metadata = [
        "noKartu"      => $noKartu,
        "nama"         => $nama,
        "nik_bpjs"     => $nik_bpjs,
        "tglLahir"     => $tglLahir,
        "sex"          => $sex,
        "noTelepon"    => $noTelepon,
        "jenisPeserta" => $jenisPeserta,
        "raw"          => "$decompressed",
    ];

    // Response Success
    echo json_encode([
        "status"   => "Success",
        "message"  => "Data Berhasil Ditemukan",
        "metadata" => $metadata
    ]);
    exit;
?>
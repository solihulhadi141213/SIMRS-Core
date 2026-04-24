<?php
    // Koneksi Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/HelperBridging.php";
    include "../../_Config/Session.php";

    //Fungsi Autoload
    include "../../vendor/autoload.php";

    // Validasi Poliklinik dan Tanggal Praktek
    if(empty($_POST['id_poliklinik'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Kode Poli Tidak Boleh Kosong!
                </small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['tanggal_praktek'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Tanggal Praktek Tidak Boleh Kosong!
                </small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan sanitasi
    $id_poliklinik   = validateAndSanitizeInput($_POST['id_poliklinik']);
    $tanggal_praktek = validateAndSanitizeInput($_POST['tanggal_praktek']);

    // Buka Kode Poli
    $kode_poli = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'kode');
    if(empty($kode_poli)){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Poliklinik Yang Anda Pilih Tidak Memiliki Kode!<br>
                    Silahkan buka referensi poliklinik dan tambahkan kode pada poliklinik yang anda pilih.
                </small>
            </div>
        ';
        exit;
    }

    // Buka Pengaturan Bridging BPJS Yang Aktif
    $stmt = mysqli_prepare($Conn,"SELECT * FROM setting_bpjs WHERE status = 1 ORDER BY id_setting_bpjs DESC LIMIT 1");
    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Terjadi kesalahan pada saat membuka pengaturan koneksi bridging BPJS!
                </small>
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
            <div class="alert alert-danger text-center">
                <small>
                    Pengaturan Koneksi Bridging BPJS Tidak Ditemukan!<br> Atur pengaturan koneksi brdiging BPJS terlebih dulu.
                </small>
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

    //UTC
    date_default_timezone_set('UTC');

    //Timestamp
    $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

    //Creat Signature
    $signature           = hash_hmac('sha256', $consid."&".$tStamp, $secret_key, true);
    $encodedSignature    = base64_encode($signature);
    $urlencodedSignature = urlencode($encodedSignature);

    // Creat Key
    $key="$consid$secret_key$tStamp";

    //Prepare Header
    $headers = array(
        'Content-Type:Application/x-www-form-urlencoded',
        'X-cons-id: '.$consid .'',
        'X-timestamp: '.$tStamp.'' ,
        'X-signature: '.$encodedSignature.'',
        'user_key: '.$user_key_antrol.''
    ); 

    //Membuat URL
    $url="$url_antrol/jadwaldokter/kodepoli/$kode_poli/tanggal/$tanggal_praktek";

    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Creat Variabel Response
    $content    = curl_exec($ch);
    $err        = curl_error($ch);
    $ambil_json = json_decode($content, true);

    // Apabila Tidak Ada Response
    if(empty($ambil_json["response"])){
        $pesan=$ambil_json["metadata"]["message"];
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Response Tidak Ditemukan!<br>
                    <b>'.$pesan.'</b>
                </small>
            </div>
        ';
        exit;
    }

    // Tangkap Response Dari Server
    $response = $ambil_json["response"];
    $metadata = $ambil_json["metadata"];
    $code     = $metadata["code"];
    $message  = $metadata["message"];

    // Decrypt String Response
    $string_decrypted = decrypt_string_aes256cbc($key, $response);

    // Decomppress
    $string_decompressed = decompress_stirng("$string_decrypted");

    // JSON Decode
    $JsonData     = json_decode($string_decompressed, true);

    // Hitung Jumlah Data
    $JumlahJadwal = count($JsonData);

    // Looping
    $no=1;
    for($a=0; $a<$JumlahJadwal; $a++){
        $kodesubspesialis = $JsonData[$a]['kodesubspesialis'];
        $hari             = $JsonData[$a]['hari'];
        $kapasitaspasien  = $JsonData[$a]['kapasitaspasien'];
        $libur            = $JsonData[$a]['libur'];
        $namahari         = $JsonData[$a]['namahari'];
        $jadwal           = $JsonData[$a]['jadwal'];
        $namasubspesialis = $JsonData[$a]['namasubspesialis'];
        $namadokter       = $JsonData[$a]['namadokter'];
        $kodedokter       = $JsonData[$a]['kodedokter'];
        $kodepoli         = $JsonData[$a]['kodepoli'];
        $namapoli         = $JsonData[$a]['namapoli'];

        // Rouitng Nama Hari
        if($hari=="1"){
            $hari="Senin";
        }else{
            if($hari=="2"){
                $hari="Selasa";
            }else{
                if($hari=="3"){
                    $hari="Rabu";
                }else{
                    if($hari=="4"){
                        $hari="Kamis";
                    }else{
                        if($hari=="5"){
                            $hari="Jumat";
                        }else{
                            if($hari=="6"){
                                $hari="Sabtu";
                            }else{
                                if($hari=="7"){
                                    $hari="Minggu";
                                }
                            }
                        }
                    }
                }
            }
        }

        // Tampilkan Data
        echo '
            <div class="row mb-3 border-1 border-top">
                <div class="col-12 mb-2 mt-3">
                    
                    <div class="row mb-2">
                        <div class="col-12">
                            <small>
                                <b>'.$no.'. '.$namadokter.'</b>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Kode Dokter</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$kodedokter.'</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Kode Poli</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$kodepoli.'</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Poliklinik</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$namapoli.'</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Sub Spesialis</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$namasubspesialis.'</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Hari</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$namahari.'</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Jadwal</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$jadwal.'</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><small>Kapasitas</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <small class="text text-muted">'.$kapasitaspasien.'</small>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $no++;
    }

    // Tutup Curl
    curl_close($ch);
?>
<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Autoload
    include "../../vendor/autoload.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi nik
    if (empty($_POST['nik'])) {
        echo '
            <div class="alert alert-danger">
                <small>NIK tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi Input
    $nik = validateAndSanitizeInput($_POST['nik']);
    
    // ===================================================
    // DARI DATABASE PASIEN
    // ===================================================

    // Query Detail Pasien
    $query = "SELECT * FROM pasien WHERE nik = ? LIMIT 1 ";
    $stmt = mysqli_prepare($Conn, $query);

    // Debug Query Prepare
    if (!$stmt) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal mempersiapkan query : '.mysqli_error($Conn).'</small>
            </div>
        ';
        exit;
    }
    mysqli_stmt_bind_param($stmt, "s", $nik);

    // Debug Execute
    if (!mysqli_stmt_execute($stmt)) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menjalankan query : '.mysqli_stmt_error($stmt).'</small>
            </div>
        ';
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);

    // Validasi Data
    if (mysqli_num_rows($result) == 0) {
        echo '
            <div class="alert alert-danger">
                <small>NIK Tidak Ditemukan Pada Database!</small>
            </div>
        ';
        exit;
    }

    // Fetch Data
    $row = mysqli_fetch_assoc($result);

    echo '
        <div class="row mb-2">
            <div class="col-12"><small><b>A. Rekam Medis</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor RM Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$row['id_pasien'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$row['nama'].'</small></div>
        </div>
        <div class="row mb-2 mb-3">
            <div class="col-4"><small>Status Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$row['status'].'</small></div>
        </div>
        <hr>
    ';

    echo ' 
        <div class="row mb-2">
            <div class="col-12"><small><b>B. BPJS</b></small></div>
        </div>
    ';

    // ===================================================
    // DARI BRIDGING BPJS
    // ===================================================

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
    }else{
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
        }else{
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
            $url="$url_vclaim/Peserta/nik/$nik/tglSEP/$tglSEP";

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
                echo ' 
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                <small><b>Opss!</b> Pesan : '.$message.'</small>
                            </div>
                        </div>
                    </div>
                ';
            }else{
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

                // Tampilkan
                echo '
                    <div class="row mb-2 mb-2">
                        <div class="col-4"><small>No.Kartu</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">'.$noKartu.'</small></div>
                    </div>
                    <div class="row mb-2 mb-2">
                        <div class="col-4"><small>Nama Terdaftar</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">'.$nama.'</small></div>
                    </div>
                    <div class="row mb-2 mb-2">
                        <div class="col-4"><small>NIK</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">'.$nik_bpjs.'</small></div>
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
                    <hr>
                ';
            }
        }
    }

    // ===================================================
    // DARI SATU SEHAT
    // ===================================================
    // Open Configuration SATUSEHAT Active
    $stmt_satusehat = mysqli_prepare($Conn,"SELECT url_satusehat FROM setting_satusehat WHERE status_setting_satusehat = 1 LIMIT 1");
    if (!$stmt_satusehat) {
        echo ' 
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>Terjadi Kesalahan Pada Saat Membuka Pengaturan Koneksi SATUSEHAT</small>
                    </div>
                </div>
            </div>
        ';
    }else{

        mysqli_stmt_execute($stmt_satusehat);
        $result_satusehat = mysqli_stmt_get_result($stmt_satusehat);
        $setting_satusehat = mysqli_fetch_assoc($result_satusehat);
        mysqli_stmt_close($stmt_satusehat);

        // Validation Configuration Info
        $baseurl_satusehat = rtrim(trim($setting_satusehat['url_satusehat'] ?? ''), '/');
        if ($baseurl_satusehat === '') {
            echo ' 
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            <small>Terjadi Kesalahan Pada Saat Membuka Pengaturan Koneksi SATUSEHAT</small>
                        </div>
                    </div>
                </div>
            ';
        }else{

            // Generate Token
            $tokenResult = generateTokenSatuSehat($Conn);
            if (($tokenResult['status'] ?? 'error') !== 'success') {
                $message = $tokenResult['message'];
                echo ' 
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                <small>Terjadi kessalahan pada saat generate token SATUSEHAT.<br> Pesan : '.$message.'</small>
                            </div>
                        </div>
                    </div>
                ';
            }else{

                // Validate Token NULL
                $token = $tokenResult['token'] ?? '';
                if ($token === '') {
                    echo ' 
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="alert alert-danger text-center">
                                    <small>Terjadi kessalahan pada saat generate token SATUSEHAT.<br> Pesan : '.$message.'</small>
                                </div>
                            </div>
                        </div>
                    ';
                }else{

                    // Buat URL
                    $url = "$baseurl_satusehat/fhir-r4/v1/Patient?identifier=https://fhir.kemkes.go.id/id/nik|$nik";

                    // Mulai CURL
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => ''.$url.'',
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => 0,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,

                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer '.$token.''
                    ),
                    ));
                    $response = curl_exec($curl);

                    // Error CURL
                    if(curl_errno($curl)){
                        $error_curl = curl_error($curl);
                        echo ' 
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="alert alert-danger text-center">
                                        <small>CURL Error : '.$error_curl.' <br> Response : '.$response.'</small>
                                    </div>
                                </div>
                            </div>
                        ';
                    }else{
                        // Decode JSON
                        $data = json_decode($response, true);

                        // Validasi JSON Response
                        if(json_last_error() !== JSON_ERROR_NONE){
                            echo ' 
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="alert alert-danger text-center">
                                            <small>Response Dari SATUSEHAT tidak valid. <br> Response : '.$url.'</small>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }else{
                            // Validasi Error FHIR
                            if(isset($data['resourceType']) && $data['resourceType'] === 'OperationOutcome'){
                               
                                echo ' 
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="alert alert-danger text-center">
                                                <small>Response Dari SATUSEHAT tidak valid. <br> Response : '.$data.'</small>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }else{
                                // Response Berhasil
                                // Validasi entry tersedia
                                if (!isset($data['entry']) || !is_array($data['entry']) || count($data['entry']) == 0) {
                                    
                                    echo ' 
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="alert alert-danger text-center">
                                                    <small>Data pasien tidak ditemukan di SATUSEHAT</small>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    // Ambil resource patient pertama
                                    $resource = $data['entry'][0]['resource'] ?? [];

                                    // Ambil ID SATUSEHAT
                                    $id = $resource['id'] ?? '';

                                    // Ambil Nama Pasien
                                    $name = '';

                                    if (
                                        isset($resource['name'][0]['text']) &&
                                        !empty($resource['name'][0]['text'])
                                    ) {
                                        $name = $resource['name'][0]['text'];
                                    } elseif (
                                        isset($resource['name'][0]['given'][0])
                                    ) {
                                        $name = $resource['name'][0]['given'][0];
                                    }

                                    // Ambil NIK dari identifier
                                    $nik_pasien = '';

                                    if (isset($resource['identifier']) && is_array($resource['identifier'])) {

                                        foreach ($resource['identifier'] as $identifier) {

                                            $system = $identifier['system'] ?? '';
                                            $value  = $identifier['value'] ?? '';

                                            if ($system == 'https://fhir.kemkes.go.id/id/nik') {
                                                $nik_pasien = $value;
                                                break;
                                            }
                                        }
                                    }
                                    echo '
                                        <div class="row mb-2 mb-2">
                                            <div class="col-4"><small>IHS Pasien</small></div>
                                            <div class="col-1"><small>:</small></div>
                                            <div class="col-7"><small class="text-muted">'.$id.'</small></div>
                                        </div>
                                        <div class="row mb-2 mb-3">
                                            <div class="col-4"><small>Nama</small></div>
                                            <div class="col-1"><small>:</small></div>
                                            <div class="col-7"><small class="text-muted">'.$name.'</small></div>
                                        </div>
                                        <div class="row mb-2 mb-3">
                                            <div class="col-4"><small>NIK Pasien</small></div>
                                            <div class="col-1"><small>:</small></div>
                                            <div class="col-7"><small class="text-muted">'.$nik_pasien.'</small></div>
                                        </div>
                                    ';
                                }
                            }
                        }
                    }
                }

            }
        }
    }
    

    

    

    

    

    

    

    
    

    

    

    
?>
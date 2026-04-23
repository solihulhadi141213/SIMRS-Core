<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // menangkap ID Practitioner
    if(empty($_POST['id_ihs_practitioner'])){
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>ID Practitioner Tidak Boleh Kosong!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Validasi Sesi Akses
     if (empty($SessionIdAkses)) {
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>Sesi akses sudah berakhir! Silahkan Login Ulang.</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel
    $id_practitioner = $_POST['id_ihs_practitioner'];

    // Cari Pengaturan Satu Sehat Yang Aktif
    $stmt = mysqli_prepare($Conn,"SELECT url_satusehat FROM setting_satusehat WHERE status_setting_satusehat = 1 LIMIT 1");
    if (!$stmt) {
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>Terjadi Kesalahan Pada Saat Membuka Pengaturan Koneksi SATUSEHAT</small>
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

    // Apabila Pengaturan Satu Sehat Tidak Lengkap
    $baseurl_satusehat = rtrim(trim($setting['url_satusehat'] ?? ''), '/');
    if ($baseurl_satusehat === '') {
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>Pengaturan Koneksi SATUSEHAT tidak lengkap! Silahkan perbaiki parameter endpoint SATUSEHAT terlebih dulu.</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Generate Token
    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>
                            Terjadi kessalahan pada saat generate token SATUSEHAT.<br>
                            Pesan : <i>'.$tokenResult['message'].'</i>
                        </small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Jika Token Gagal Dibuat
    $token = $tokenResult['token'] ?? '';
    if ($token === '') {
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>
                            Terjadi kessalahan pada saat generate token SATUSEHAT.<br>
                            Pesan : <i>'.$tokenResult['message'].'</i>
                        </small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat URL
    $url = "$baseurl_satusehat/fhir-r4/v1/Practitioner/$id_practitioner";

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
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>
                           CURL ERROR: '.curl_error($curl).'<br>
                           RESPONSE: '.$response.'<br>
                        </small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Decode JSON
    $data = json_decode($response, true);

    // Validasi JSON Response
    if(json_last_error() !== JSON_ERROR_NONE){
       echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>
                            Response bukan JSON valid<br>
                            Response: '.$response.'
                        </small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Validasi Error FHIR
    if(isset($data['resourceType']) && $data['resourceType'] === 'OperationOutcome'){
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>
                            SATUSEHAT ERROR<br>
                            '.json_encode($data, JSON_PRETTY_PRINT).'
                        </small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }
    
    // PARSING DATA PRACTITIONER
    $id        = $data['id'] ?? '-';
    $nama      = $data['name'][0]['text'] ?? '-';
    $gender    = ($data['gender'] ?? '-') === 'male' ? 'Laki-laki' : 'Perempuan';
    $birthDate = $data['birthDate'] ?? '-';

    // Ambil NIK dari identifier
    $nik_satusehat = '-';
    if (!empty($data['identifier'])) {
        foreach ($data['identifier'] as $idn) {
            if (($idn['system'] ?? '') === 'https://fhir.kemkes.go.id/id/nik') {
                $nik_satusehat = $idn['value'] ?? '-';
            }
        }
    }

    // Ambil alamat
    $alamat = '-';
    if (!empty($data['address'][0])) {
        $addr = $data['address'][0];

        $line = isset($addr['line'][0]) ? $addr['line'][0] : '';
        $city = $addr['city'] ?? '';
        $country = $addr['country'] ?? '';

        $alamat = trim("$line, $city, $country", ', ');
    }

    // Ambil STR terakhir (ambil yang paling akhir saja)
    $str_number = '-';
    $str_start  = '-';
    $str_end    = '-';

    if (!empty($data['qualification'])) {
        $last = end($data['qualification']);

        $str_number = $last['identifier'][0]['value'] ?? '-';
        $str_start  = $last['period']['start'] ?? '-';
        $str_end    = $last['period']['end'] ?? '-';
    }

    // =============================
    // TAMPILAN UI
    // =============================
    echo '
        <div class="row mb-2">
            <div class="col-5"><small>ID Practitioner</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text-muted">'.$id.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>Nama</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$nama.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>Gender</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$gender.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>Tanggal Lahir</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$birthDate.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>NIK (SATUSEHAT)</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$nik_satusehat.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>Alamat</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$alamat.'</small></div>
        </div>

        <hr>

        <div class="row mb-2">
            <div class="col-12">
                <small><b>Informasi STR</b></small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>No STR</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$str_number.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>Berlaku Dari</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$str_start.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-5"><small>Berlaku Sampai</small></div>
            <div class="col-1">:</div>
            <div class="col-6"><small class="text-muted">'.$str_end.'</small></div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-12">
                <small>RAW</small>
                <textarea name="" class="form-control">'.$response.'</textarea>
            </div>
        </div>
    ';
    curl_close($curl);
?>
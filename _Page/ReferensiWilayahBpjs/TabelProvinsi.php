<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    header('Content-Type: text/html; charset=UTF-8');

    include "../../vendor/autoload.php";

    // Zona Waktu
    date_default_timezone_set('UTC');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Helper Bridging
    include "../../_Config/HelperBridging.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    Sesi Akses Sudah Berakhir! Silahkan Login Ulang.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // AMBIL KEYWORD
    // =========================================================
    $keyword = trim($_POST['keyword'] ?? '');

    // =========================================================
    // AMBIL SETTING BPJS
    // =========================================================
    $status = 1;

    $stmt = $Conn->prepare("SELECT * FROM setting_bpjs WHERE status = ?");
    $stmt->bind_param("i", $status);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Setting BPJS tidak ditemukan.
                </div>
            </div>
        ';
        exit;
    }

    $data = $result->fetch_assoc();

    // =========================================================
    // VARIABLE BPJS
    // =========================================================
    $consid      = $data['consid'] ?? '';
    $user_key    = $data['user_key'] ?? '';
    $secret_key  = $data['secret_key'] ?? '';
    $url_vclaim  = rtrim($data['url_vclaim'] ?? '', '/');

    // =========================================================
    // VALIDASI CONFIG
    // =========================================================
    if (empty($consid) || empty($user_key) || empty($secret_key) || empty($url_vclaim)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    Konfigurasi BPJS belum lengkap.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // TIMESTAMP & SIGNATURE
    // =========================================================
    $timestamp = strval(time());

    $signature = hash_hmac(
        'sha256',
        $consid . "&" . $timestamp,
        $secret_key,
        true
    );

    $encodedSignature = base64_encode($signature);

    // =========================================================
    // URL API
    // =========================================================
    $url = $url_vclaim . "/referensi/propinsi";

    // =========================================================
    // HEADER API
    // =========================================================
    $headers = array(
        'X-cons-id: ' . $consid,
        'X-timestamp: ' . $timestamp,
        'X-signature: ' . $encodedSignature,
        'user_key: ' . $user_key,
        'Content-Type: application/x-www-form-urlencoded'
    );

    // =========================================================
    // CURL API
    // =========================================================
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $content = curl_exec($ch);

    // Debug CURL
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    curl_close($ch);

    // =========================================================
    // VALIDASI CURL ERROR
    // =========================================================
    if (!empty($curlError)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger">
                    <b>CURL Error :</b><br>
                    ' . htmlspecialchars($curlError) . '
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI RESPONSE KOSONG
    // =========================================================
    if (empty($content)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    Response API kosong.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // JSON DECODE AWAL
    // =========================================================
    $responseArray = json_decode($content, true);

    if (!is_array($responseArray)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger">
                    Response API tidak valid.<br><br>
                    <pre>' . htmlspecialchars($content) . '</pre>
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI META DATA
    // =========================================================
    $metaCode    = $responseArray['metaData']['code'] ?? '';
    $metaMessage = $responseArray['metaData']['message'] ?? '';

    if ($metaCode != 200) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger">
                    <b>API BPJS Error</b><br>
                    Code : ' . htmlspecialchars($metaCode) . '<br>
                    Message : ' . htmlspecialchars($metaMessage) . '
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI RESPONSE
    // =========================================================
    if (empty($responseArray['response'])) {

        echo '
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Data response tidak tersedia.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // DECRYPT
    // =========================================================
    $encryptedResponse = $responseArray['response'];

    $key = $consid . $secret_key . $timestamp;

    $decrypted = stringDecrypt($key, $encryptedResponse);

    if (empty($decrypted)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger">
                    Gagal decrypt response API.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // DECOMPRESS
    // =========================================================
    $decompressed = decompress($decrypted);

    if (empty($decompressed)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger">
                    Gagal decompress response API.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // JSON DECODE FINAL
    // =========================================================
    $JsonData = json_decode($decompressed, true);

    if (!is_array($JsonData)) {

        echo '
            <div class="col-12">
                <div class="alert alert-danger">
                    Format data akhir tidak valid.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // LIST DATA
    // =========================================================
    $list = $JsonData['list'] ?? array();

    if (empty($list)) {

        echo '
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Data provinsi tidak ditemukan.
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // FILTER PENCARIAN
    // =========================================================
    if (!empty($keyword)) {

        $filtered = array();

        foreach ($list as $item) {

            $nama = $item['nama'] ?? '';
            $kode = $item['kode'] ?? '';

            if (
                stripos($nama, $keyword) !== false ||
                stripos($kode, $keyword) !== false
            ) {
                $filtered[] = $item;
            }
        }

        $list = $filtered;
    }

    // =========================================================
    // VALIDASI HASIL FILTER
    // =========================================================
    if (empty($list)) {

        echo '
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Data provinsi tidak ditemukan untuk keyword :
                    <b>' . htmlspecialchars($keyword) . '</b>
                </div>
            </div>
        ';
        exit;
    }

    // =========================================================
    // TAMPILKAN DATA
    // =========================================================
    $no = 1;

    foreach ($list as $item) {

        $kode = $item['kode'] ?? '';
        $nama = $item['nama'] ?? '';

        // Cek Apakah Sudah Ada Di SIMRS
        $id_wilayah = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs1', $kode, 'id_wilayah');
        if(empty($id_wilayah)){
            $text_color = "text-danger";
        }else{
            $text_color = "text-primary";
        }

        if(empty($id_wilayah)){
            $id_wilayah = "-";
        }

        echo '
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                <a href="javascript:void(0);" class="modal_kabupaten text-decoration-none" data-nama_prov="' . htmlspecialchars($nama) . '" data-kode_prov="' . htmlspecialchars($kode) . '">

                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">

                            <small class="'.$text_color.'">
                                <b>' . $no . '. ' . htmlspecialchars($nama) . '</b>
                                <br>

                                Kode BPJS :
                                <span class="text-muted">
                                    ' . htmlspecialchars($kode) . '
                                </span>
                                
                            </small><br>
                            <small>
                                ID Wilayah :
                                <span class="text-muted">
                                    ' . $id_wilayah . '
                                </span>
                            </small>

                        </div>
                    </div>

                </a>
            </div>
        ';

        $no++;
    }
?>
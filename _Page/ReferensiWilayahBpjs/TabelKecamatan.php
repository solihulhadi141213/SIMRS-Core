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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</small>
                </td>
            </tr>
        ';
        exit;
    }
    // AMBIL NAMA DAN KODE PROVINSI DAN KABUPATEN
    if(empty($_POST['nama_prov'])){
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger">Nama Provinsi Tidak Boleh Kosong!</small>
                </td>
            </tr>
        ';
        exit;
    }
    if(empty($_POST['kode_prov'])){
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger">Kode Provinsi Tidak Boleh Kosong!</small>
                </td>
            </tr>
        ';
        exit;
    }
    if(empty($_POST['nama_kab'])){
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger">Nama Kabupaten Tidak Boleh Kosong!</small>
                </td>
            </tr>
        ';
        exit;
    }
    if(empty($_POST['kode_kab'])){
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger">Kode Kabupaten Tidak Boleh Kosong!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // AMBIL KEYWORD
    $nama_prov = trim($_POST['nama_prov'] ?? '');
    $kode_prov = trim($_POST['kode_prov'] ?? '');
    $nama_kab = trim($_POST['nama_kab'] ?? '');
    $kode_kab = trim($_POST['kode_kab'] ?? '');
    $keyword   = trim($_POST['keyword_kecamatan'] ?? '');

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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> Pengaturan Bridging BPJS Tidak Ditemukan</small>
                </td>
            </tr>
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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> Konfigurasi Bridging BPJS Tidak Lengkap</small>
                </td>
            </tr>
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
    $url = $url_vclaim . "/referensi/kecamatan/kabupaten/$kode_kab";

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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        <b>CURL Error :</b><br>
                        ' . htmlspecialchars($curlError) . '
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI RESPONSE KOSONG
    // =========================================================
    if (empty($content)) {

        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Response API kosong.
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // JSON DECODE AWAL
    // =========================================================
    $responseArray = json_decode($content, true);

    if (!is_array($responseArray)) {

        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Response API tidak valid.<br><br>
                        <pre>' . htmlspecialchars($content) . '</pre>
                    </small>
                </td>
            </tr>
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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        <b>API BPJS Error</b><br>
                        Code : ' . htmlspecialchars($metaCode) . '<br>
                        Message : ' . htmlspecialchars($metaMessage) . '
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI RESPONSE
    // =========================================================
    if (empty($responseArray['response'])) {
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Data response tidak tersedia.
                    </small>
                </td>
            </tr>
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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Gagal decrypt response API.
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // DECOMPRESS
    // =========================================================
    $decompressed = decompress($decrypted);

    if (empty($decompressed)) {
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Gagal decompress response API.
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // JSON DECODE FINAL
    // =========================================================
    $JsonData = json_decode($decompressed, true);

    if (!is_array($JsonData)) {
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Format data akhir tidak valid.
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // LIST DATA
    // =========================================================
    $list = $JsonData['list'] ?? array();
    if (empty($list)) {
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Data provinsi tidak ditemukan.
                    </small>
                </td>
            </tr>
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
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger"> 
                        Data provinsi tidak ditemukan untuk keyword :
                        <b>' . htmlspecialchars($keyword) . '</b>
                    </small>
                </td>
            </tr>
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
        $id_wilayah_prov = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs1', $kode_prov, 'id_wilayah');
        $id_wilayah_kab  = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs2', $kode_kab, 'id_wilayah');
        $id_wilayah_kec  = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs3', $kode, 'id_wilayah');
        
        if(empty($id_wilayah_prov)){
            $text_color_prov = "text-danger";
        }else{
            $text_color_prov = "text-primary";
        }

        if(empty($id_wilayah_kab)){
            $text_color_kab = "text-danger";
        }else{
            $text_color_kab = "text-primary";
        }

        if(empty($id_wilayah_kec)){
            $text_color_kec = "text-danger";
        }else{
            $text_color_kec = "text-primary";
        }
        echo '
            <tr>
                <td><small>'.$no.'</small></td>
                <td><small class="'.$text_color_prov.'">'.$kode_prov.'</small></td>
                <td><small class="'.$text_color_prov.'">'.$nama_prov.'</small></td>
                <td><small class="'.$text_color_prov.'">'.$kode_kab.'</small></td>
                <td><small class="'.$text_color_prov.'">'.$nama_kab.'</small></td>
                <td><small class="'.$text_color_kec.'">'.$kode.'</small></td>
                <td><small class="'.$text_color_kec.'">'.$nama.'</small></td>
                <td class="icon-btn">
                    <button type="button" class="btn btn-md btn-icon btn-secondary modal_tambah_simrs" data-nama_prov="' . htmlspecialchars($nama_prov) . '" data-kode_prov="' . htmlspecialchars($kode_prov) . '" data-nama_kab="' . htmlspecialchars($nama_kab) . '" data-kode_kab="' . htmlspecialchars($kode_kab) . '" data-nama_kec="' . htmlspecialchars($nama) . '" data-kode_kec="' . htmlspecialchars($kode) . '">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </td>
            </tr>
        ';
        $no++;
    }
?>
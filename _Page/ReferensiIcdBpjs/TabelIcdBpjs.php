<?php
    // Autoload 
    include "../../vendor/autoload.php";

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/HelperBridging.php";

    // Validasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Sesi akses berakhir! Silakan login ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Buka Pengaturan Bridging BPJS
    $status = 1;
    $stmt = $Conn->prepare("SELECT * FROM setting_bpjs WHERE status = ?");
    $stmt->bind_param("i", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Bridging BPJS Belum Diatur!</small>
                </td>
            </tr>
        ';
        exit;
    }
    $data = $result->fetch_assoc();

    // Variabel Setting Koneksi BPJS
    $consid      = $data['consid'] ?? '';
    $user_key    = $data['user_key'] ?? '';
    $secret_key  = $data['secret_key'] ?? '';
    $url_vclaim  = rtrim($data['url_vclaim'] ?? '', '/');

    // Validasi Pengaturan
    if (empty($consid) || empty($user_key) || empty($secret_key) || empty($url_vclaim)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Koneksi Bridging BPJS Belum Lengkap!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Timestamp & Signature
    $timestamp = strval(time());
    $signature = hash_hmac(
        'sha256',
        $consid . "&" . $timestamp,
        $secret_key,
        true
    );
    $encodedSignature = base64_encode($signature);

    //Version
    if(empty($_POST['version'])){
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Pilih ICD terlebih Dulu!</small>
                </td>
            </tr>
        ';
        exit;
    }

    //keyword
    if(empty($_POST['keyword'])){
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Masukan Kata Kunci Pencarian Terlebih Dulu!</small>
                </td>
            </tr>
        ';
        exit;
    }

    $version = $_POST['version'];
    $keyword = $_POST['keyword'];

    // URL By Version
    if($version!=="ICD10" && $version!=="ICD9"){
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Versi ICD Tidak Valid!</small>
                </td>
            </tr>
        ';
        exit;
    }

    if($version=="ICD10"){
        $url = "$url_vclaim/referensi/diagnosa/$keyword";
    }
    if($version=="ICD9"){
        $url = "$url_vclaim/referensi/procedure/$keyword";
    }

    // Header
    $headers = array(
        'X-cons-id: ' . $consid,
        'X-timestamp: ' . $timestamp,
        'X-signature: ' . $encodedSignature,
        'user_key: ' . $user_key,
        'Content-Type: application/x-www-form-urlencoded'
    );

    // CURL
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

    // Curl Error
    if (!empty($curlError)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">
                        <b>CURL Error :</b><br>
                    ' . htmlspecialchars($curlError) . '
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // Empty Response
    if (empty($content)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Response API kosong.</small>
                </td>
            </tr>
        ';
        exit;
    }

    // JSON Decode
    $responseArray = json_decode($content, true);
    if (!is_array($responseArray)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">
                        Response API tidak valid.<br><br>
                        <pre>' . htmlspecialchars($content) . '</pre>
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // Validaste Metadata
    $metaCode    = $responseArray['metaData']['code'] ?? '';
    $metaMessage = $responseArray['metaData']['message'] ?? '';
    if ($metaCode != 200) {
        echo '
            <tr>
                <td align="center" colspan="5">
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

    // Validate Response
    if (empty($responseArray['response'])) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">
                       Data response tidak tersedia.
                    </small>
                </td>
            </tr>
        ';
        exit;
    }

    // DECRYPT
    $encryptedResponse = $responseArray['response'];
    $key               = $consid . $secret_key . $timestamp;
    $decrypted         = decrypt_string_aes256cbc($key, $encryptedResponse);
    if (empty($decrypted)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Gagal decrypt response API.</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Decompress
    $decompressed = decompress_stirng($decrypted);
    if (empty($decompressed)) {
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text-danger">Gagal decompress response API.</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Decode Final
    $JsonData = json_decode($decompressed, true);

    if($version=="ICD9"){
        $data_arry = $JsonData['procedure'] ?? [];
    }else{
        $data_arry = $JsonData['diagnosa'] ?? [];
    }
    
    if(empty($data_arry)){
        echo '
            <tr>
                <td colspan="5" align="center">
                    <small class="text-danger">Data tidak ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    foreach($data_arry as $item){

        $kode = $item['kode'] ?? '';
        $nama = $item['nama'] ?? '';
        $nama = preg_replace('/^' . preg_quote($kode, '/') . '\s*-\s*/', '', $nama);

        // Cek Apakah Ada pada Simrs
        $stmt_check = $Conn->prepare("SELECT * FROM icd WHERE kode = ? AND icd = ?");
        $stmt_check->bind_param("ss", $kode, $version);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows == 0) {
            $button_icd = '
                <button type="button" class="btn btn-sm btn-floating modal_tambah_icd" data-icd="'.$version.'" data-kode="'.$kode.'" data-nama="'.$nama.'">
                    <i class="bi bi-plus"></i>
                </button>
            ';
        }
        $data_check = $result_check->fetch_assoc();
        $id_icd     = $data_check['id_icd'] ?? '';

        if(empty($id_icd)){
            $button_icd = '
                <button type="button" class="btn btn-sm btn-icon btn-outline-danger modal_tambah_icd" data-icd="'.$version.'" data-kode="'.$kode.'" data-nama="'.$nama.'">
                    <i class="bi bi-plus"></i>
                </button>
            ';
        }else{
            $button_icd = '
                <button type="button" class="btn btn-sm btn-icon btn-outline-info modal_detail" data-id="'.$id_icd.'">
                    <i class="bi bi-arrow-up-right"></i>
                </button>
            ';
        }
        

        // Show Row Table
        echo '
            <tr>
                <td class="text-center"><small>'.$no.'</small></td>
                <td class="text-left"><small>'.$version.'</small></td>
                <td><small>'.$kode.'</small></td>
                <td><small class="text text-muted">'.$nama.'</small></td>
                <td class="text-center icon-btn">'.$button_icd.'</td>
            </tr>
        ';
        $no++;
    }

?>
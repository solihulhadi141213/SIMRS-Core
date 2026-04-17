<?php
    function formatTimestampMs($ms) {
        return date('d/m/Y H:i:s', substr($ms, 0, 10));
    }

    function maskString($str, $start = 6, $end = 4) {
        if (strlen($str) <= ($start + $end)) return $str;
        return substr($str, 0, $start) . '****' . substr($str, -$end);
    }

    // Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_setting_satusehat'])) {
        echo '<div class="alert alert-danger">ID Setting Satu Sehat tidak boleh kosong.</div>';
        exit;
    }

    $id_setting_satusehat = (int) $_POST['id_setting_satusehat'];

    // Ambil data detail
    $query = "SELECT * FROM setting_satusehat WHERE id_setting_satusehat = ?";
    $stmt  = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_satusehat);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-warning">Data Setting Satu Sehat tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    // Status badge
    $nama_setting_satusehat   = $data['nama_setting_satusehat'] ?? '' ;
    $url_satusehat            = $data['url_satusehat'] ?? '' ;
    $organization_id          = $data['organization_id'] ?? '' ;
    $client_key               = $data['client_key'] ?? '' ;
    $secret_key               = $data['secret_key'] ?? '' ;
    $token                    = $data['token'] ?? '' ;
    $datetime_expired         = $data['datetime_expired'] ?? '' ;
    $status_setting_satusehat = $data['status_setting_satusehat'] ?? '' ;

    // =======================
    // REQUEST TOKEN (cURL)
    // =======================
    $payload = http_build_query([
        'grant_type'    => 'client_credentials',
        'client_id'     => $client_key,
        'client_secret' => $secret_key
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url_satusehat . '/oauth2/v1/accesstoken?grant_type=client_credentials',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS      => 'client_id='.$client_key.'&client_secret='.$secret_key.'',
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 10,

        // DEV ONLY
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $response     = curl_exec($curl);
    $curl_error   = curl_error($curl);
    $http_code    = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    // =======================
    // DEBUGGING CURL
    // =======================
    if ($response === false) {
        echo '
            <div class="alert alert-danger">
                <small>
                    <b>Gagal menghubungi API Satu Sehat</b><br>
                    Error: '.$curl_error.'
                </small>
            </div>
        ';
        exit;
    }

    if ($http_code !== 200) {
        echo '
            <div class="alert alert-danger">
                <small>
                    <b>HTTP Error</b><br>
                    Status Code: '.$http_code.'
                </small>
            </div>
        ';
        exit;
    }

    // =======================
    // VALIDASI JSON
    // =======================
    $arry = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo '
            <div class="alert alert-danger">
                <small>Response API bukan JSON valid.</small>
            </div>
        ';
        exit;
    }

    // =======================
    // VALIDASI RESPONSE API
    // =======================
    if (!isset($arry['status'])) {
        echo '
            <div class="alert alert-danger">
                <small>Format response API tidak dikenali.</small>
            </div>
        ';
        exit;
    }

    if ($arry['status'] !== 'approved') {
        echo '
            <div class="alert alert-danger">
                <small>'.$arry['status'].'</small>
            </div>
        ';
        exit;
    }

    // =======================
    // DATA TOKEN
    // =======================
    $api_product_list_json = $arry['api_product_list_json'];

    $display = [
        'Status'                => $arry['status'],
        'Organization'          => $arry['organization_name'],
        'API Environment'       => implode(', ', $arry['api_product_list_json']),
        'Token Type'            => $arry['token_type'],
        'Expires In'            => $arry['expires_in'].' detik',
        'Issued At'             => formatTimestampMs($arry['issued_at']),
        'Refresh Token Count'   => $arry['refresh_count'],
        'Developer Email'       => $arry['developer.email'],
        'Client ID'             => maskString($arry['client_id']),
        'Access Token'          => maskString($arry['access_token'])
    ];

    foreach ($display as $label => $value) {
        echo '
            <div class="row mb-1">
                <div class="col-4">
                    <small class="text-dark">'.$label.'</small>
                </div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$value.'</small>
                </div>
            </div>
        ';
    }
    mysqli_stmt_close($stmt);
?>
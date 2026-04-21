<?php
    header('Content-Type: application/json');

    include "../../vendor/autoload.php";

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'results' => [],
        'pagination' => ['more' => false]
    ];

    if (empty($SessionIdAkses)) {
        echo json_encode($response);
        exit;
    }

    $keyword = trim($_POST['keyword'] ?? '');
    $page    = (int) ($_POST['page'] ?? 1);
    $page    = $page > 0 ? $page : 1;
    $limit   = 10;

    if ($keyword === '') {
        echo json_encode($response);
        exit;
    }

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT consid, user_key, secret_key, url_vclaim
         FROM setting_bpjs
         WHERE status = 1
         ORDER BY id_setting_bpjs DESC
         LIMIT 1"
    );

    if (!$stmt) {
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (empty($setting)) {
        echo json_encode($response);
        exit;
    }

    $consid     = trim($setting['consid'] ?? '');
    $user_key   = trim($setting['user_key'] ?? '');
    $secret_key = trim($setting['secret_key'] ?? '');
    $url_vclaim = rtrim(trim($setting['url_vclaim'] ?? ''), '/');

    if ($consid === '' || $user_key === '' || $secret_key === '' || $url_vclaim === '') {
        echo json_encode($response);
        exit;
    }

    date_default_timezone_set('UTC');
    $timestamp        = strval(time() - strtotime('1970-01-01 00:00:00'));
    $signature        = hash_hmac('sha256', $consid . "&" . $timestamp, $secret_key, true);
    $encodedSignature = base64_encode($signature);

    $url_request = $url_vclaim . '/referensi/poli/' . rawurlencode($keyword);

    $headers = [
        'X-signature: ' . $encodedSignature,
        'X-timestamp: ' . $timestamp,
        'X-cons-id: ' . $consid,
        'user_key: ' . $user_key,
        'Content-Type: Application/JSON',
        'Accept: Application/JSON'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_request);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $content = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if (!empty($curl_error) || empty($content)) {
        echo json_encode($response);
        exit;
    }

    $json = json_decode($content, true);

    if (!is_array($json)) {
        echo json_encode($response);
        exit;
    }

    $meta_code = (string) ($json['metaData']['code'] ?? '');
    if ($meta_code !== '200') {
        echo json_encode($response);
        exit;
    }

    $payload = $json['response'] ?? null;

    if (is_string($payload) && $payload !== '') {
        $key = $consid . $secret_key . $timestamp;
        $decrypted = stringDecrypt($key, $payload);

        if (!empty($decrypted)) {
            $decompressed = decompress($decrypted);
            $decoded = json_decode($decompressed, true);

            if (is_array($decoded)) {
                $payload = $decoded;
            }
        }
    }

    $list = [];

    if (isset($payload['poli']) && is_array($payload['poli'])) {
        $list = $payload['poli'];
    } elseif (isset($payload['list']) && is_array($payload['list'])) {
        $list = $payload['list'];
    } elseif (is_array($payload)) {
        $list = $payload;
    }

    if (isset($list['kode']) || isset($list['nama'])) {
        $list = [$list];
    }

    $results = [];
    foreach ($list as $item) {
        if (!is_array($item)) {
            continue;
        }

        $kode = trim((string) ($item['kode'] ?? ''));
        $nama = trim((string) ($item['nama'] ?? ''));

        if ($kode === '' && $nama === '') {
            continue;
        }

        $results[] = [
            'id' => $kode !== '' ? $kode : $nama,
            'text' => trim($kode . ' - ' . $nama, ' -'),
            'kode' => $kode,
            'nama' => $nama
        ];
    }

    $offset = ($page - 1) * $limit;
    $paged_results = array_slice($results, $offset, $limit);

    $response['results'] = $paged_results;
    $response['pagination']['more'] = count($results) > ($offset + $limit);

    echo json_encode($response);
?>

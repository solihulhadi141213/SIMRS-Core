<?php
    header('Content-Type: application/json');

    include "../../vendor/autoload.php";

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'no process',
        'results' => [],
        'pagination' => ['more' => false]
    ];

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi Akses Berakhir! Silahkan Login Ulang!';
        echo json_encode($response);
        exit;
    }

    $keyword = trim($_POST['keyword'] ?? '');
    $page    = max(1, (int) ($_POST['page'] ?? 1));
    $limit   = 10;

    if ($keyword === '') {
        $response['message'] = 'Silahkan ketik nama dokter untuk pencarian';
        echo json_encode($response);
        exit;
    }

    $stmt = mysqli_prepare($Conn, "SELECT * FROM setting_bpjs WHERE status = 1 ORDER BY id_setting_bpjs DESC LIMIT 1");
    if (!$stmt) {
        $response['message'] = 'Terjadi kesalahan pada saat membuka pengaturan koneksi bridging BPJS';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (empty($setting)) {
        $response['message'] = 'Pengaturan Koneksi Bridging BPJS Tidak Ditemukan';
        echo json_encode($response);
        exit;
    }

    $consid          = trim($setting['consid'] ?? '');
    $user_key_antrol = trim($setting['user_key_antrol'] ?? '');
    $secret_key      = trim($setting['secret_key'] ?? '');
    $url_antrol      = rtrim(trim($setting['url_antrol'] ?? ''), '/');

    if ($consid === '' || $user_key_antrol === '' || $secret_key === '' || $url_antrol === '') {
        $response['message'] = 'Parameter koneksi HFIS/HFIZ belum lengkap.';
        echo json_encode($response);
        exit;
    }

    date_default_timezone_set('UTC');
    $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
    $signature = hash_hmac('sha256', $consid . "&" . $tStamp, $secret_key, true);
    $encodedSignature = base64_encode($signature);
    $key = $consid . $secret_key . $tStamp;

    $headers = [
        'Content-Type:Application/x-www-form-urlencoded',
        'X-cons-id: ' . $consid,
        'X-timestamp: ' . $tStamp,
        'X-signature: ' . $encodedSignature,
        'user_key: ' . $user_key_antrol
    ];

    $url = $url_antrol . '/ref/dokter';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
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
        $response['message'] = 'Gagal mengambil data dokter HFIS/HFIZ.';
        echo json_encode($response);
        exit;
    }

    $ambil_json = json_decode($content, true);
    if (!is_array($ambil_json)) {
        $response['message'] = 'Response HFIS/HFIZ tidak valid.';
        echo json_encode($response);
        exit;
    }

    $metadata = $ambil_json['metadata'] ?? [];
    $message  = trim((string) ($metadata['message'] ?? ''));

    if (strtoupper($message) !== 'OK') {
        $response['message'] = $message !== '' ? $message : 'Gagal mengambil data dokter HFIS/HFIZ.';
        echo json_encode($response);
        exit;
    }

    $string = $ambil_json['response'] ?? '';
    if ($string === '') {
        echo json_encode($response);
        exit;
    }

    $terjemahkan    = stringDecrypt($key, $string);
    $fileDekompresi = decompress($terjemahkan);
    $jsonData       = json_decode($fileDekompresi, true);

    if (!is_array($jsonData)) {
        $response['message'] = 'Gagal mendekripsi data dokter HFIS/HFIZ.';
        echo json_encode($response);
        exit;
    }

    $filtered = [];
    $jumlahDokter = count($jsonData);
    foreach ($jsonData as $item) {
        if (!is_array($item)) {
            continue;
        }

        $kodedokter = trim((string) ($item['kodedokter'] ?? ''));
        $namadokter = trim((string) ($item['namadokter'] ?? ''));

        if ($kodedokter === '' && $namadokter === '') {
            continue;
        }

        $haystack = strtolower($kodedokter . ' ' . $namadokter);
        if (strpos($haystack, strtolower($keyword)) === false) {
            continue;
        }

        $filtered[] = [
            'id' => $kodedokter !== '' ? $kodedokter : $namadokter,
            'text' => trim($kodedokter . ' - ' . $namadokter, ' -'),
            'kode' => $kodedokter,
            'nama' => $namadokter
        ];
    }

    $offset = ($page - 1) * $limit;
    $response['status'] = 'success';
    if (empty($filtered)) {
        $response['message'] = 'Data dokter HFIS/HFIZ berhasil dimuat (' . $jumlahDokter . ' data), tetapi tidak ada yang cocok dengan keyword "' . $keyword . '".';
    } else {
        $response['message'] = 'Ditemukan ' . count($filtered) . ' data dokter yang cocok dari ' . $jumlahDokter . ' data HFIS/HFIZ.';
    }
    $response['results'] = array_slice($filtered, $offset, $limit);
    $response['pagination']['more'] = count($filtered) > ($offset + $limit);

    echo json_encode($response);
?>

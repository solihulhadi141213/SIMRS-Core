<?php
    header('Content-Type: application/json');

    include "../../vendor/autoload.php";
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ==============================
    // DEFAULT RESPONSE
    // ==============================
    $response = [
        'results' => [],
        'pagination' => ['more' => false]
    ];

    // ==============================
    // VALIDASI SESSION
    // ==============================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'results' => [],
            'pagination' => ['more' => false],
            'message' => 'Sesi berakhir'
        ]);
        exit;
    }

    // ==============================
    // PARAMETER SELECT2
    // ==============================
    $keyword = trim($_POST['search'] ?? '');
    $page    = (int)($_POST['page'] ?? 1);

    $limit = 10;
    $offset = ($page - 1) * $limit;

    // ==============================
    // AMBIL SETTING BPJS
    // ==============================
    $stmt = mysqli_prepare($Conn, "SELECT * FROM setting_bpjs WHERE status = 1 LIMIT 1");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (empty($setting)) {
        echo json_encode($response);
        exit;
    }

    // ==============================
    // KONFIGURASI
    // ==============================
    $consid       = trim($setting['consid']);
    $user_key     = trim($setting['user_key']);
    $secret_key   = trim($setting['secret_key']);
    $url_aplicare = rtrim(trim($setting['url_aplicare']), '/');

    // ==============================
    // HEADER BPJS
    // ==============================
    date_default_timezone_set('UTC');

    $tStamp    = strval(time() - strtotime('1970-01-01 00:00:00'));
    $signature = base64_encode(hash_hmac('sha256', $consid . "&" . $tStamp, $secret_key, true));

    $headers = [
        'Content-Type: application/json',
        'X-cons-id: ' . $consid,
        'X-timestamp: ' . $tStamp,
        'X-signature: ' . $signature,
        'user_key: ' . $user_key
    ];

    // ==============================
    // CURL KE BPJS
    // ==============================
    $url = "$url_aplicare/rest/ref/kelas";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30
    ]);

    $response_curl = curl_exec($ch);
    curl_close($ch);

    if (empty($response_curl)) {
        echo json_encode($response);
        exit;
    }

    // ==============================
    // PARSING RESPONSE
    // ==============================
    $data_json = json_decode($response_curl, true);

    if (!isset($data_json['response']['list'])) {
        echo json_encode($response);
        exit;
    }

    $list = $data_json['response']['list'];

    // ==============================
    // FILTER SEARCH (LOCAL)
    // ==============================
    $filtered = [];

    foreach ($list as $item) {
        $kode = $item['kodekelas'];
        $nama = $item['namakelas'];

        if ($keyword === '' || 
            stripos($kode, $keyword) !== false || 
            stripos($nama, $keyword) !== false
        ) {
            $filtered[] = [
                'id' => $kode,
                'text' => $kode . ' - ' . $nama
            ];
        }
    }

    // ==============================
    // PAGING MANUAL
    // ==============================
    $total = count($filtered);
    $paged = array_slice($filtered, $offset, $limit);

    $response = [
        'results' => $paged,
        'pagination' => [
            'more' => ($offset + $limit) < $total
        ]
    ];

    // ==============================
    echo json_encode($response);
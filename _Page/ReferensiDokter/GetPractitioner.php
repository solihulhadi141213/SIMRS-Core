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
    if ($keyword === '') {
        echo json_encode($response);
        exit;
    }

    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        echo json_encode($response);
        exit;
    }

    $token = $tokenResult['token'] ?? '';
    if ($token === '') {
        echo json_encode($response);
        exit;
    }

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT url_satusehat
         FROM setting_satusehat
         WHERE status_setting_satusehat = 1
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

    $baseurl_satusehat = rtrim(trim($setting['url_satusehat'] ?? ''), '/');
    if ($baseurl_satusehat === '') {
        echo json_encode($response);
        exit;
    }

    $results = [];

    if (strpos($keyword, ' ') === false && strlen($keyword) >= 10) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $baseurl_satusehat . '/Practitioner/' . rawurlencode($keyword),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $singleResponse = curl_exec($curl);
        curl_close($curl);
        $singleData = json_decode((string) $singleResponse, true);

        if (is_array($singleData) && ($singleData['resourceType'] ?? '') === 'Practitioner' && !empty($singleData['id'])) {
            $namaPractitioner = '-';
            if (!empty($singleData['name'][0])) {
                $nameParts = [];
                if (!empty($singleData['name'][0]['prefix']) && is_array($singleData['name'][0]['prefix'])) {
                    $nameParts[] = implode(' ', $singleData['name'][0]['prefix']);
                }
                if (!empty($singleData['name'][0]['text'])) {
                    $nameParts[] = $singleData['name'][0]['text'];
                } elseif (!empty($singleData['name'][0]['given']) || !empty($singleData['name'][0]['family'])) {
                    $given = !empty($singleData['name'][0]['given']) && is_array($singleData['name'][0]['given']) ? implode(' ', $singleData['name'][0]['given']) : '';
                    $family = $singleData['name'][0]['family'] ?? '';
                    $nameParts[] = trim($given . ' ' . $family);
                }
                $namaPractitioner = trim(implode(' ', array_filter($nameParts)));
                if ($namaPractitioner === '') {
                    $namaPractitioner = '-';
                }
            }

            $results[$singleData['id']] = [
                'id' => $singleData['id'],
                'text' => $singleData['id'] . ' - ' . $namaPractitioner
            ];
        }
    }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseurl_satusehat . '/Practitioner?name=' . rawurlencode($keyword) . '&_count=20',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $bundleResponse = curl_exec($curl);
    curl_close($curl);
    $bundle = json_decode((string) $bundleResponse, true);

    if (is_array($bundle) && !empty($bundle['entry']) && is_array($bundle['entry'])) {
        foreach ($bundle['entry'] as $entry) {
            $resource = $entry['resource'] ?? [];
            $id = trim((string) ($resource['id'] ?? ''));
            if ($id === '') {
                continue;
            }

            $namaPractitioner = '-';
            if (!empty($resource['name'][0])) {
                $nameParts = [];
                if (!empty($resource['name'][0]['prefix']) && is_array($resource['name'][0]['prefix'])) {
                    $nameParts[] = implode(' ', $resource['name'][0]['prefix']);
                }
                if (!empty($resource['name'][0]['text'])) {
                    $nameParts[] = $resource['name'][0]['text'];
                } else {
                    $given = !empty($resource['name'][0]['given']) && is_array($resource['name'][0]['given']) ? implode(' ', $resource['name'][0]['given']) : '';
                    $family = $resource['name'][0]['family'] ?? '';
                    $nameParts[] = trim($given . ' ' . $family);
                }
                $namaPractitioner = trim(implode(' ', array_filter($nameParts)));
                if ($namaPractitioner === '') {
                    $namaPractitioner = '-';
                }
            }

            $results[$id] = [
                'id' => $id,
                'text' => $id . ' - ' . $namaPractitioner
            ];
        }
    }

    $response['results'] = array_values($results);
    echo json_encode($response);
?>

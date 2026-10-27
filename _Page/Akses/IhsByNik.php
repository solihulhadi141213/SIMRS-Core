<?php
header('Content-Type: application/json; charset=UTF-8');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "../../_Config/SimrsFunction.php";

$response = ['status' => 'error', 'message' => 'Data Practitioner tidak dapat dimuat.'];
if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi berakhir.'], JSON_UNESCAPED_UNICODE);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$nik = $_POST['nik'] ?? null;
if (!is_string($nik) || !preg_match('/^[0-9]{16}$/', $nik)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'NIK harus terdiri dari 16 digit angka.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $tokenResult = generateTokenSatuSehat($Conn);
    if (!is_array($tokenResult) || ($tokenResult['status'] ?? '') !== 'success' || empty($tokenResult['token'])) {
        throw new RuntimeException('Token SATUSEHAT tidak tersedia.');
    }

    $stmt = $Conn->prepare(
        'SELECT url_satusehat FROM setting_satusehat
         WHERE status_setting_satusehat = 1 LIMIT 1'
    );
    if (!$stmt || !$stmt->execute()) {
        if ($stmt) {
            $stmt->close();
        }
        throw new RuntimeException('Konfigurasi SATUSEHAT gagal dimuat.');
    }
    $setting = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $baseUrl = rtrim((string) ($setting['url_satusehat'] ?? ''), '/');
    if (!$setting || !filter_var($baseUrl, FILTER_VALIDATE_URL) || !in_array(parse_url($baseUrl, PHP_URL_SCHEME), ['https'], true)) {
        throw new RuntimeException('Konfigurasi URL SATUSEHAT tidak valid.');
    }

    $query = http_build_query(
        ['identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik],
        '',
        '&',
        PHP_QUERY_RFC3986
    );
    $curl = curl_init($baseUrl . '/fhir-r4/v1/Practitioner?' . $query);
    if ($curl === false) {
        throw new RuntimeException('Koneksi SATUSEHAT gagal disiapkan.');
    }

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $tokenResult['token'],
            'Accept: application/json',
        ],
        CURLOPT_TIMEOUT => 20,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $apiResponse = curl_exec($curl);
    $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($apiResponse === false) {
        $curlError = curl_error($curl);
        curl_close($curl);
        error_log('Akses IHS: request SATUSEHAT gagal: ' . $curlError);
        throw new RuntimeException('Koneksi ke SATUSEHAT gagal.');
    }
    curl_close($curl);

    if ($httpCode !== 200) {
        error_log('Akses IHS: SATUSEHAT mengembalikan HTTP ' . $httpCode . '.');
        throw new RuntimeException('SATUSEHAT tidak dapat menemukan data Practitioner.');
    }

    $result = json_decode($apiResponse, true);
    if (!is_array($result)) {
        throw new RuntimeException('Response SATUSEHAT tidak valid.');
    }

    $ihs = $result['entry'][0]['resource']['id'] ?? '';
    if (!is_string($ihs) || $ihs === '') {
        $response['message'] = 'Data Practitioner tidak ditemukan di SATUSEHAT.';
    } else {
        $response = ['status' => 'success', 'ihs' => $ihs];
    }
} catch (Throwable $error) {
    error_log('Akses IHS: ' . $error->getMessage());
    $response['message'] = $error->getMessage() === 'Koneksi ke SATUSEHAT gagal.'
        || $error->getMessage() === 'SATUSEHAT tidak dapat menemukan data Practitioner.'
        ? $error->getMessage()
        : 'Pencarian Practitioner ke SATUSEHAT gagal.';
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

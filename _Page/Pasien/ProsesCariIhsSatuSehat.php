<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function And Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "Error",
            "message" => "Sesi Akses Sudah Berakhir! Silahkan Login Ulang."
        ]);
        exit;
    }

    // =====================================================
    // VALIDASI IHS
    // =====================================================
    if (empty($_POST['id_ihs'])) {
        echo json_encode([
            "status"  => "Error",
            "message" => "IHS Pasien Tidak Boleh Kosong"
        ]);
        exit;
    }

    // =====================================================
    // CREATE VARIABLE
    // =====================================================
    $ihs = validateAndSanitizeInput($_POST['id_ihs']);

    // =====================================================
    // OPEN CONFIG SATUSEHAT
    // =====================================================
    $stmt = mysqli_prepare($Conn, "
        SELECT url_satusehat
        FROM setting_satusehat
        WHERE status_setting_satusehat = 1
        LIMIT 1
    ");

    if (!$stmt) {
        echo json_encode([
            "status"  => "Error",
            "message" => "Gagal membuka konfigurasi SATUSEHAT"
        ]);
        exit;
    }

    mysqli_stmt_execute($stmt);

    $result  = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    // =====================================================
    // VALIDASI BASE URL
    // =====================================================
    $baseurl_satusehat = rtrim(trim($setting['url_satusehat'] ?? ''), '/');

    if ($baseurl_satusehat === '') {
        echo json_encode([
            "status"  => "Error",
            "message" => "Base URL SATUSEHAT tidak ditemukan"
        ]);
        exit;
    }

    // =====================================================
    // GENERATE TOKEN
    // =====================================================
    $tokenResult = generateTokenSatuSehat($Conn);

    if (($tokenResult['status'] ?? 'error') !== 'success') {

        $message = $tokenResult['message'] ?? 'Unknown Error';

        echo json_encode([
            "status"  => "Error",
            "message" => "Gagal generate token SATUSEHAT : $message"
        ]);
        exit;
    }

    // =====================================================
    // VALIDASI TOKEN
    // =====================================================
    $token = $tokenResult['token'] ?? '';

    if ($token === '') {
        echo json_encode([
            "status"  => "Error",
            "message" => "Token SATUSEHAT tidak valid"
        ]);
        exit;
    }

    // =====================================================
    // URL SEARCH PATIENT BY IHS
    // =====================================================
    $url = "$baseurl_satusehat/fhir-r4/v1/Patient/$ihs";

    // =====================================================
    // CURL REQUEST
    // =====================================================
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    // =====================================================
    // CURL ERROR
    // =====================================================
    if (curl_errno($curl)) {

        $error_curl = curl_error($curl);

        curl_close($curl);

        echo json_encode([
            "status"  => "Error",
            "message" => "CURL Error : $error_curl"
        ]);
        exit;
    }

    // HTTP CODE
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    // =====================================================
    // DECODE JSON
    // =====================================================
    $data = json_decode($response, true);

    // =====================================================
    // VALIDASI JSON
    // =====================================================
    if (json_last_error() !== JSON_ERROR_NONE) {

        echo json_encode([
            "status"  => "Error",
            "message" => "Response SATUSEHAT tidak valid JSON",
            "response" => $response
        ]);
        exit;
    }

    // =====================================================
    // VALIDASI HTTP ERROR
    // =====================================================
    if ($httpcode >= 400) {

        $message = $data['issue'][0]['diagnostics'] ?? 'Terjadi kesalahan pada SATUSEHAT';

        echo json_encode([
            "status"  => "Error",
            "message" => $message
        ]);
        exit;
    }

    // =====================================================
    // VALIDASI RESOURCE TYPE
    // =====================================================
    if (($data['resourceType'] ?? '') !== 'Patient') {

        echo json_encode([
            "status"  => "Error",
            "message" => "Resource Patient tidak ditemukan"
        ]);
        exit;
    }

    // =====================================================
    // AMBIL DATA PATIENT
    // =====================================================
    $id = $data['id'] ?? '';

    // Nama
    $name = '';

    if (
        isset($data['name'][0]['text']) &&
        !empty($data['name'][0]['text'])
    ) {

        $name = $data['name'][0]['text'];

    } elseif (
        isset($data['name'][0]['given'][0])
    ) {

        $name = $data['name'][0]['given'][0];
    }

    // Cari NIK
    $nik_pasien = '';

    if (isset($data['identifier']) && is_array($data['identifier'])) {

        foreach ($data['identifier'] as $identifier) {

            $system = $identifier['system'] ?? '';
            $value  = $identifier['value'] ?? '';

            if ($system == 'https://fhir.kemkes.go.id/id/nik') {

                $nik_pasien = $value;
                break;
            }
        }
    }

    // =====================================================
    // METADATA
    // =====================================================
    $metadata = [
        "id"   => $id,
        "name" => $name,
        "nik"  => $nik_pasien,
        "raw"  => "$response",
    ];

    // =====================================================
    // SUCCESS RESPONSE
    // =====================================================
    echo json_encode([
        "status"   => "Success",
        "message"  => "Data pasien berhasil ditemukan",
        "metadata" => $metadata
    ]);
    exit;
?>
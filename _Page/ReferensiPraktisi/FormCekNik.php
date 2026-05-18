<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Connection & Function
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php"; // pastikan fungsi generateToken ada di sini

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // ==============================
    // VALIDASI SESSION
    // ==============================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi berakhir.';
        echo json_encode($response);
        exit;
    }

    // ==============================
    // VALIDASI INPUT
    // ==============================
    $nik = $_POST['nik'] ?? '';

    if (empty($nik)) {
        $response['message'] = 'NIK wajib diisi.';
        echo json_encode($response);
        exit;
    }

    try {

        // ==============================
        // AMBIL TOKEN SATUSEHAT
        // ==============================
        $tokenResult = generateTokenSatuSehat($Conn);

        if ($tokenResult['status'] !== 'success') {
            echo json_encode($tokenResult);
            exit;
        }

        $token = $tokenResult['token'];

        // ==============================
        // AMBIL URL SATUSEHAT AKTIF
        // ==============================
        $stmt = $Conn->prepare("
            SELECT url_satusehat 
            FROM setting_satusehat 
            WHERE status_setting_satusehat = 1 
            LIMIT 1
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        if (!$data) {
            $response['message'] = 'Konfigurasi SATUSEHAT tidak ditemukan.';
            echo json_encode($response);
            exit;
        }

        $base_url = rtrim($data['url_satusehat'], '/');

        // ==============================
        // REQUEST KE API SATUSEHAT
        // ==============================
        $url = $base_url . "/fhir-r4/v1/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|".$nik;

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ],
            CURLOPT_TIMEOUT => 20,
            CURLOPT_CONNECTTIMEOUT => 10,

            // DEV ONLY
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $apiResponse = curl_exec($ch);
        $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError   = curl_error($ch);
        curl_close($ch);

        if ($apiResponse === false) {
            $response['message'] = 'Gagal koneksi ke SATUSEHAT: ' . $curlError;
            echo json_encode($response);
            exit;
        }

        if ($httpCode !== 200) {
            $response['message'] = 'HTTP Error ' . $httpCode;
            echo json_encode($response);
            exit;
        }

        $result = json_decode($apiResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $response['message'] = 'Response tidak valid.';
            echo json_encode($response);
            exit;
        }

        // ==============================
        // PARSING HASIL
        // ==============================
        if (!empty($result['entry'][0]['resource']['id'])) {

            $ihs = $result['entry'][0]['resource']['id'];

            $response = [
                'status' => 'success',
                'ihs'    => $ihs
            ];

        } else {
            $response['message'] = 'Data Practitioner tidak ditemukan di SATUSEHAT.';
        }

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
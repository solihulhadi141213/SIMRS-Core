<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    date_default_timezone_set('Asia/Jakarta');

    if (empty($SessionIdAkses)) {
        $response = [
            'status' => 'error',
            'message' => 'Sesi Akses Sudah Berakhir! Silahkan Login Ulang!',
            'payload' => [],
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    // Validasi Mandatori
    if(empty($_POST['id_alergi'])){
        $response = [
            'status' => 'error',
            'message' => 'ID Alergi Tidak Boleh Kosong',
            'payload' => [],
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    if(empty($_POST['id_kunjungan'])){
        $response = [
            'status' => 'error',
            'message' => 'ID Kunjungan Tidak Boleh Kosong',
            'payload' => [],
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    if(empty($_POST['patient_reference'])){
        $response = [
            'status' => 'error',
            'message' => 'ID pasien Tidak Boleh Kosong',
            'payload' => [],
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    if(empty($_POST['encounter_reference'])){
        $response = [
            'status' => 'error',
            'message' => 'ID Encounter Tidak Boleh Kosong',
            'payload' => [],
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }


    // SANITASI VARIABEL
    $id_alergi                  = validateAndSanitizeInput($_POST['id_alergi']);
    $id_kunjungan               = validateAndSanitizeInput($_POST['id_kunjungan']);
    $organization_id            = validateAndSanitizeInput($_POST['organization_id']);
    $clinicalStatus_system      = validateAndSanitizeInput($_POST['clinicalStatus_system']);
    $clinicalStatus_code        = validateAndSanitizeInput($_POST['clinicalStatus_code']);
    $clinicalStatus_display     = validateAndSanitizeInput($_POST['clinicalStatus_display']);
    $verificationStatus_system  = validateAndSanitizeInput($_POST['verificationStatus_system']);
    $verificationStatus_code    = validateAndSanitizeInput($_POST['verificationStatus_code']);
    $verificationStatus_display = validateAndSanitizeInput($_POST['verificationStatus_display']);
    $category                   = validateAndSanitizeInput($_POST['category']);
    $code_coding_system         = validateAndSanitizeInput($_POST['code_coding_system']);
    $code_coding_code           = validateAndSanitizeInput($_POST['code_coding_code']);
    $code_coding_display        = validateAndSanitizeInput($_POST['code_coding_display']);
    $patient_reference          = validateAndSanitizeInput($_POST['patient_reference']);
    $patient_display            = validateAndSanitizeInput($_POST['patient_display']);
    $encounter_reference        = validateAndSanitizeInput($_POST['encounter_reference']);
    $encounter_display          = validateAndSanitizeInput($_POST['encounter_display']);
    $recordedDate               = validateAndSanitizeInput($_POST['recordedDate']);
    $recorder_reference         = validateAndSanitizeInput($_POST['recorder_reference']);
    $recorder_display           = validateAndSanitizeInput($_POST['recorder_display']);
    $formatFHIR                 = date('Y-m-d\TH:i:sP', strtotime($recordedDate));

    // Ubah $category
    $category = strtolower($category);
    // Membuat Payload
    $payload = [
        "resourceType" => "AllergyIntolerance",
        "identifier"   => [
            [
                "system" => "http://sys-ids.kemkes.go.id/allergy/$organization_id",
                "use"    => "official",
                "value"  => "$id_alergi"
            ]
        ],
        "clinicalStatus" => [
            "coding" => [
                [
                    "system"  => "$clinicalStatus_system",
                    "code"    => "$clinicalStatus_code",
                    "display" => "$clinicalStatus_display",
                ]
            ]
        ],
        "verificationStatus" => [
            "coding" => [
                [
                    "system"  => "$verificationStatus_system",
                    "code"    => "$verificationStatus_code",
                    "display" => "$verificationStatus_display",
                ]
            ]
        ],
        "category" => [
           "$category"
        ],
        "code" => [
            "coding" => [
                [
                    "system"  => "$code_coding_system",
                    "code"    => "$code_coding_code",
                    "display" => "$code_coding_display",
                ]
            ]
        ],
        "patient" => [
            "reference" => "$patient_reference",
            "display" => "$patient_display"
        ],
        "encounter" => [
            "reference" => "$encounter_reference",
            "display" => "$encounter_display"
        ],
        "recordedDate" => "$formatFHIR",
        "recorder" => [
            "reference" => "$recorder_reference",
            "display" => "$recorder_display"
        ]
    ];

    // Ubah Payload menjadi JSON
    $json_payload = json_encode($payload,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    // Buka Pengaturan SATUSEHAT
    $query_setting     = mysqli_query($Conn,"SELECT * FROM setting_satusehat WHERE status_setting_satusehat='1' LIMIT 1");
    $setting           = mysqli_fetch_assoc($query_setting);
    $baseurl_satusehat = rtrim($setting['url_satusehat'] ?? '', '/');
    if (empty($baseurl_satusehat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'URL SATUSEHAT tidak ditemukan!',
            'payload' => [],
        ]);
        exit;
    }

    // Generate Token
    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? '') !== 'success') {
        echo json_encode([
            'status'  => 'error',
            'message' => $tokenResult['message'] ?? 'Generate token gagal!',
            'payload' => [],
        ]);
        exit;
    }
    $token = $tokenResult['token'];
    
    // URL
    $url = $baseurl_satusehat . '/fhir-r4/v1/AllergyIntolerance';

    // CURL
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 60,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $json_payload,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]
    ]);

    $response      = curl_exec($ch);
    $httpcode      = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error    = curl_error($ch);

    curl_close($ch);

    // CURL ERROR
    if (!empty($curl_error)) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Curl Error : '.$curl_error,
            'payload' => $payload
        ]);
        exit;
    }

    // PARSING RESPONSE
    $responseData = json_decode($response, true);

    // VALIDASI RESPONSE
    if ($httpcode != 200 && $httpcode != 201) {
        $message = $response;
        if (!empty($responseData['issue'][0]['diagnostics'])) {
            $message = $responseData['issue'][0]['diagnostics'];
        }
        echo json_encode([
            'status'  => 'error',
            'message' => $message,
            'payload' => $json_payload
        ]);
        exit;
    }

    // UUID AllergyIntolerance
    $AllergyIntolerance_uuid = $responseData['id'] ?? '';
    if (empty($AllergyIntolerance_uuid)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'UUID Alergi tidak ditemukan!',
            'payload' => [],
        ]);
        exit;
    }

    // UPDATE DATABASE
    $stmt_update = $Conn->prepare("UPDATE alergi SET AllergyIntolerance=? WHERE id_alergi=?");
    $stmt_update->bind_param(
        "ss",
        $AllergyIntolerance_uuid,
        $id_alergi
    );
    $update = $stmt_update->execute();
    if (!$update) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal update database!',
            'payload' => [],
        ]);
        exit;
    }

    // SUCCESS
    echo json_encode([
        'status'        => 'success',
        'message'       => 'Kirim Alergi SATUSEHAT berhasil',
        'id_kunjungan'  => $id_kunjungan,
        'AllergyIntolerance_uuid'  => $AllergyIntolerance_uuid,
        'payload' => []
    ]);

?>
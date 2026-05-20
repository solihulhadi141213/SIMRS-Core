<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

    // =========================================================
    // TIMEZONE
    // =========================================================
    date_default_timezone_set('Asia/Jakarta');

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir, silahkan login ulang!'
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI METHOD
    // =========================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid!'
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI MANDATORY
    // =========================================================
    $mandatory = [
        'id_tindakan',
        'resourceType',
        'status',
        'code_coding_code',
        'subject_reference',
        'performedPeriod_start'
    ];

    foreach ($mandatory as $field) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Field '.$field.' tidak boleh kosong!'
            ]);
            exit;
        }
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    function post($key){
        return validateAndSanitizeInput($_POST[$key] ?? '');
    }

    $id_tindakan             = post('id_tindakan');
    $resourceType            = post('resourceType');
    $status                  = post('status');

    $category_coding_code    = post('category_coding_code');
    $category_coding_display = post('category_coding_display');
    $category_coding_text    = post('category_coding_text');
    $category_coding_system  = post('category_coding_system');

    $code_coding_code        = post('code_coding_code');
    $code_coding_display     = post('code_coding_display');
    $code_coding_text        = post('code_coding_text');
    $code_coding_system      = post('code_coding_system');

    $subject_reference       = post('subject_reference');
    $subject_display         = post('subject_display');

    $encounter_reference     = post('encounter_reference');
    $encounter_display       = post('encounter_display');

    $performedPeriod_start   = post('performedPeriod_start');
    $performedPeriod_end     = post('performedPeriod_end');

    $reasonCodeSystem        = post('reasonCodeSystem');
    $reasonCodeCode          = post('reasonCodeCode');
    $reasonCodeDisplay       = post('reasonCodeDisplay');

    $bodySiteSystem          = post('bodySiteSystem');
    $bodySiteCode            = post('bodySiteCode');
    $bodySiteDisplay         = post('bodySiteDisplay');

    $note_text               = post('note_text');

    // =========================================================
    // VALIDASI DATA TINDAKAN
    // =========================================================
    $stmt = $Conn->prepare("SELECT * FROM tindakan WHERE id_tindakan=? LIMIT 1");
    $stmt->bind_param("i", $id_tindakan);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Data tindakan tidak ditemukan!'
        ]);
        exit;
    }

    $data_tindakan = $result->fetch_assoc();

    $id_kunjungan = $data_tindakan['id_kunjungan'];

    // =========================================================
    // VALIDASI PERFORMER
    // =========================================================
    $performer_reference = $_POST['performer_reference'] ?? [];
    $performer_display   = $_POST['performer_display'] ?? [];

    if (empty($performer_reference)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Minimal harus ada 1 performer!'
        ]);
        exit;
    }

    // =========================================================
    // GENERATE PERFORMER
    // =========================================================
    $performer = [];

    foreach ($performer_reference as $key => $reference) {

        $reference = trim($reference);
        $display   = trim($performer_display[$key] ?? '');

        if (!empty($reference)) {

            $performer[] = [
                "actor" => [
                    "reference" => $reference,
                    "display"   => $display
                ]
            ];
        }
    }

    // =========================================================
    // VALIDASI PENGATURAN SATUSEHAT
    // =========================================================
    $query_setting = mysqli_query($Conn,"
        SELECT * FROM setting_satusehat 
        WHERE status_setting_satusehat='1'
        LIMIT 1
    ");

    $setting = mysqli_fetch_assoc($query_setting);

    $baseurl_satusehat = rtrim($setting['url_satusehat'] ?? '', '/');

    if (empty($baseurl_satusehat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'URL SATUSEHAT tidak ditemukan!'
        ]);
        exit;
    }

    // =========================================================
    // GENERATE TOKEN
    // =========================================================
    $tokenResult = generateTokenSatuSehat($Conn);

    if (($tokenResult['status'] ?? '') !== 'success') {

        echo json_encode([
            'status'  => 'error',
            'message' => $tokenResult['message'] ?? 'Generate token gagal!'
        ]);
        exit;
    }

    $token = $tokenResult['token'];

    // =========================================================
    // GENERATE PAYLOAD
    // =========================================================
    $payload = [
        "resourceType" => $resourceType,
        "status"       => $status,

        "category" => [
            "coding" => [[
                "system"  => $category_coding_system,
                "code"    => $category_coding_code,
                "display" => $category_coding_display
            ]],
            "text" => $category_coding_text
        ],

        "code" => [
            "coding" => [[
                "system"  => $code_coding_system,
                "code"    => $code_coding_code,
                "display" => $code_coding_display
            ]],
            "text" => $code_coding_text
        ],

        "subject" => [
            "reference" => "Patient/".$subject_reference,
            "display"   => $subject_display
        ],

        "encounter" => [
            "reference" => "Encounter/".$encounter_reference,
            "display"   => $encounter_display
        ],

        "performedPeriod" => [
            "start" => $performedPeriod_start,
            "end"   => $performedPeriod_end
        ],

        "performer" => $performer
    ];

    // OPTIONAL : REASON CODE
    if (!empty($reasonCodeCode)) {

        $payload['reasonCode'] = [[
            "coding" => [[
                "system"  => $reasonCodeSystem,
                "code"    => $reasonCodeCode,
                "display" => $reasonCodeDisplay
            ]]
        ]];
    }

    // OPTIONAL : BODY SITE
    if (!empty($bodySiteCode)) {

        $payload['bodySite'] = [[
            "coding" => [[
                "system"  => $bodySiteSystem,
                "code"    => $bodySiteCode,
                "display" => $bodySiteDisplay
            ]]
        ]];
    }

    // OPTIONAL : NOTE
    if (!empty($note_text)) {

        $payload['note'] = [[
            "text" => $note_text
        ]];
    }

    // CONVERT JSON
    $json_payload = json_encode(
        $payload,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
    );

    // URL
    $url = $baseurl_satusehat . '/fhir-r4/v1/Procedure';

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

    // UUID PROCEDURE
    $procedure_uuid = $responseData['id'] ?? '';

    if (empty($procedure_uuid)) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'UUID Procedure tidak ditemukan!'
        ]);
        exit;
    }

    // UPDATE DATABASE
    $stmt_update = $Conn->prepare("UPDATE tindakan SET id_procedure=? WHERE id_tindakan=?");
    $stmt_update->bind_param(
        "si",
        $procedure_uuid,
        $id_tindakan
    );
    $update = $stmt_update->execute();
    if (!$update) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal update database!'
        ]);
        exit;
    }

    // SUCCESS
    echo json_encode([
        'status'        => 'success',
        'message'       => 'Kirim Procedure SATUSEHAT berhasil',
        'id_tindakan'   => $id_tindakan,
        'id_kunjungan'  => $id_kunjungan,
        'procedure_id'  => $procedure_uuid
    ]);
?>
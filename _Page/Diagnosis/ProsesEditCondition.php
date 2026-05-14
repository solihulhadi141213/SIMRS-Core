<?php
    header('Content-Type: application/json; charset=utf-8');

    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // RESPONSE DEFAULT
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    // FUNCTION RESPONSE JSON
    function sendEditConditionResponse($response){
        echo json_encode($response);
        exit;
    }

    // FUNCTION SANITASI DATA FORM
    function cleanEditConditionInput($value){
        return trim(strip_tags(stripslashes($value ?? '')));
    }

    // FUNCTION PESAN ERROR DARI OPERATION OUTCOME
    function getEditConditionOutcomeMessage($data){
        $diagnostics = $data['issue'][0]['diagnostics'] ?? '';
        $details     = $data['issue'][0]['details']['text'] ?? '';

        if(!empty($diagnostics)){
            return $diagnostics;
        }
        if(!empty($details)){
            return $details;
        }
        return 'SATUSEHAT menolak payload Condition';
    }

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses sudah berakhir!';
        sendEditConditionResponse($response);
    }

    // TANGKAP DATA
    // Validasi Data Dari Form Satu Per Satu Agar Jelas Mana Yang Belum Diisi
    $requiredFields = [
        'id_diagnosis'                   => 'ID Diagnosis',
        'id_condition'                   => 'ID Condition',
        'clinical_status_coding_system'  => 'Clinical Status System',
        'clinical_status_coding_code'    => 'Clinical Status Code',
        'clinical_status_coding_display' => 'Clinical Status Display',
        'category_coding_system'         => 'Category System',
        'category_coding_code'           => 'Category Code',
        'category_coding_display'        => 'Category Display',
        'code_coding_system'             => 'Code System',
        'code_coding_code'               => 'Code',
        'code_coding_display'            => 'Code Display',
        'subject_reference'              => 'Subject Reference',
        'subject_display'                => 'Subject Display',
        'encounter_reference'            => 'Encounter Reference',
        'encounter_display'              => 'Encounter Display'
    ];

    foreach($requiredFields as $field => $label){
        if(empty($_POST[$field])){
            $response['message'] = $label.' Tidak Boleh Kosong';
            sendEditConditionResponse($response);
        }
    }

    // Buat Variabel Masing-masing Data Dan Sanitasi
    $id_diagnosis                   = cleanEditConditionInput($_POST['id_diagnosis']);
    $id_condition                   = cleanEditConditionInput($_POST['id_condition']);
    $clinical_status_coding_system  = cleanEditConditionInput($_POST['clinical_status_coding_system']);
    $clinical_status_coding_code    = cleanEditConditionInput($_POST['clinical_status_coding_code']);
    $clinical_status_coding_display = cleanEditConditionInput($_POST['clinical_status_coding_display']);
    $category_coding_system         = cleanEditConditionInput($_POST['category_coding_system']);
    $category_coding_code           = cleanEditConditionInput($_POST['category_coding_code']);
    $category_coding_display        = cleanEditConditionInput($_POST['category_coding_display']);
    $code_coding_system             = cleanEditConditionInput($_POST['code_coding_system']);
    $code_coding_code               = cleanEditConditionInput($_POST['code_coding_code']);
    $code_coding_display            = cleanEditConditionInput($_POST['code_coding_display']);
    $subject_reference              = cleanEditConditionInput($_POST['subject_reference']);
    $subject_display                = cleanEditConditionInput($_POST['subject_display']);
    $encounter_reference            = cleanEditConditionInput($_POST['encounter_reference']);
    $encounter_display              = cleanEditConditionInput($_POST['encounter_display']);

    if(!ctype_digit((string)$id_diagnosis)){
        $response['message'] = 'ID Diagnosis Tidak Valid';
        sendEditConditionResponse($response);
    }

    // BUKA DATA DIAGNOSIS
    $sql = "SELECT id_kunjungan, id_condition FROM diagnosis WHERE id_diagnosis = ? LIMIT 1";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_diagnosis);
    $stmt->execute();
    $result = $stmt->get_result();
    $Diagnosis = $result->fetch_assoc();
    $stmt->close();

    if(empty($Diagnosis)){
        $response['message'] = 'Data Diagnosis tidak ditemukan!';
        sendEditConditionResponse($response);
    }

    $id_kunjungan          = $Diagnosis['id_kunjungan'] ?? '';
    $id_condition_database = $Diagnosis['id_condition'] ?? '';

    if(empty($id_condition_database)){
        $response['message'] = 'Data Diagnosis belum memiliki ID Condition SATUSEHAT!';
        sendEditConditionResponse($response);
    }

    if($id_condition_database != $id_condition){
        $response['message'] = 'ID Condition tidak sesuai dengan data Diagnosis!';
        sendEditConditionResponse($response);
    }

    // KONEKSI SATUSEHAT YANG AKTIF
    $status_setting_satusehat = 1;
    $sql = "SELECT * FROM setting_satusehat WHERE status_setting_satusehat = ? LIMIT 1";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $status_setting_satusehat);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();
    $stmt->close();

    if (empty($Data)) {
        $response['message'] = 'Seting Koneksi SATUSEHAT tidak ditemukan!';
        sendEditConditionResponse($response);
    }

    $url_satusehat    = rtrim($Data['url_satusehat'] ?? '', '/');
    $token            = $Data['token'] ?? '';
    $datetime_expired = $Data['datetime_expired'] ?? '';

    if(empty($url_satusehat)){
        $response['message'] = 'Konfigurasi URL SATUSEHAT belum lengkap!';
        sendEditConditionResponse($response);
    }

    // MENETAPKAN TOKEN
    // Apabila Token Tidak Ada Atau Expired Maka Panggil Function Dari SimrsFunction.php Untuk Membuat Token Ulang
    if(empty($token) || strtotime($datetime_expired) <= time()){
        $tokenResult = generateTokenSatuSehat($Conn);

        if(($tokenResult['status'] ?? '') !== 'success'){
            $response['message'] = $tokenResult['message'] ?? 'Gagal membuat token SATUSEHAT';
            sendEditConditionResponse($response);
        }

        $token = $tokenResult['token'] ?? '';
    }

    if(empty($token)){
        $response['message'] = 'Token SATUSEHAT tidak tersedia!';
        sendEditConditionResponse($response);
    }

    // Buat Payload
    $payload = [
        'resourceType'   => 'Condition',
        'id'             => $id_condition,
        'clinicalStatus' => [
            'coding' => [[
                'system'  => $clinical_status_coding_system,
                'code'    => $clinical_status_coding_code,
                'display' => $clinical_status_coding_display
            ]]
        ],
        'category' => [[
            'coding' => [[
                'system'  => $category_coding_system,
                'code'    => $category_coding_code,
                'display' => $category_coding_display
            ]]
        ]],
        'code' => [
            'coding' => [[
                'system'  => $code_coding_system,
                'code'    => $code_coding_code,
                'display' => $code_coding_display
            ]]
        ],
        'subject' => [
            'reference' => $subject_reference,
            'display'   => $subject_display
        ],
        'encounter' => [
            'reference' => $encounter_reference,
            'display'   => $encounter_display
        ]
    ];

    $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    if($json === false){
        $response['message'] = 'Gagal membuat payload Condition: '.json_last_error_msg();
        sendEditConditionResponse($response);
    }

    // Kirim Perubahan Ke Satusehat
    $content = EditCondition($url_satusehat, $json, $token, $id_condition);
    $data    = json_decode($content, true);

    if(json_last_error() !== JSON_ERROR_NONE){
        $response['message'] = 'Response SATUSEHAT bukan JSON valid: '.json_last_error_msg();
        sendEditConditionResponse($response);
    }

    if(($data['resourceType'] ?? '') === 'OperationOutcome'){
        $response['message'] = getEditConditionOutcomeMessage($data);
        sendEditConditionResponse($response);
    }

    if(($data['resourceType'] ?? '') !== 'Condition' || ($data['id'] ?? '') != $id_condition){
        $response['message'] = 'Response SATUSEHAT tidak memuat ID Condition yang sesuai';
        sendEditConditionResponse($response);
    }

    $response = [
        'status'       => 'success',
        'message'      => 'Condition berhasil diperbarui di SATUSEHAT',
        'id_kunjungan' => $id_kunjungan,
        'id_condition' => $id_condition
    ];

    sendEditConditionResponse($response);
?>

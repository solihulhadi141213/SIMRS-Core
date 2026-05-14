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
    function sendConditionResponse($response){
        echo json_encode($response);
        exit;
    }

    // FUNCTION SANITASI DATA FORM
    function cleanConditionInput($value){
        return trim(strip_tags(stripslashes($value ?? '')));
    }

    // FUNCTION PESAN ERROR DARI OPERATION OUTCOME
    function getConditionOutcomeMessage($data){
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
        sendConditionResponse($response);
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
        sendConditionResponse($response);
    }

    $url_satusehat    = rtrim($Data['url_satusehat'] ?? '', '/');
    $token            = $Data['token'] ?? '';
    $datetime_expired = $Data['datetime_expired'] ?? '';

    if(empty($url_satusehat)){
        $response['message'] = 'Konfigurasi URL SATUSEHAT belum lengkap!';
        sendConditionResponse($response);
    }

    // MENETAPKAN TOKEN
    // Apabila Token Tidak Ada Atau Expired Maka Panggil Function Dari SimrsFunction.php Untuk Membuat Token Ulang
    if(empty($token) || strtotime($datetime_expired) <= time()){
        $tokenResult = generateTokenSatuSehat($Conn);

        if(($tokenResult['status'] ?? '') !== 'success'){
            $response['message'] = $tokenResult['message'] ?? 'Gagal membuat token SATUSEHAT';
            sendConditionResponse($response);
        }

        $token = $tokenResult['token'] ?? '';
    }

    if(empty($token)){
        $response['message'] = 'Token SATUSEHAT tidak tersedia!';
        sendConditionResponse($response);
    }

    // TANGKAP DATA
    // Validasi Data Dari Form Satu Per Satu Agar Jelas Mana Yang Belum Diisi
    $requiredFields = [
        'id_diagnosis'                   => 'ID Diagnosis',
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
            sendConditionResponse($response);
        }
    }

    // Buat Variabel Masing-masing Data Dan Sanitasi
    $id_diagnosis                   = cleanConditionInput($_POST['id_diagnosis']);
    $clinical_status_coding_system  = cleanConditionInput($_POST['clinical_status_coding_system']);
    $clinical_status_coding_code    = cleanConditionInput($_POST['clinical_status_coding_code']);
    $clinical_status_coding_display = cleanConditionInput($_POST['clinical_status_coding_display']);
    $category_coding_system         = cleanConditionInput($_POST['category_coding_system']);
    $category_coding_code           = cleanConditionInput($_POST['category_coding_code']);
    $category_coding_display        = cleanConditionInput($_POST['category_coding_display']);
    $code_coding_system             = cleanConditionInput($_POST['code_coding_system']);
    $code_coding_code               = cleanConditionInput($_POST['code_coding_code']);
    $code_coding_display            = cleanConditionInput($_POST['code_coding_display']);
    $subject_reference              = cleanConditionInput($_POST['subject_reference']);
    $subject_display                = cleanConditionInput($_POST['subject_display']);
    $encounter_reference            = cleanConditionInput($_POST['encounter_reference']);
    $encounter_display              = cleanConditionInput($_POST['encounter_display']);

    if(!ctype_digit((string)$id_diagnosis)){
        $response['message'] = 'ID Diagnosis Tidak Valid';
        sendConditionResponse($response);
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
        sendConditionResponse($response);
    }

    $id_kunjungan = $Diagnosis['id_kunjungan'] ?? '';
    $id_condition = $Diagnosis['id_condition'] ?? '';

    if(!empty($id_condition)){
        $response['message'] = 'Diagnosis ini sudah memiliki ID Condition SATUSEHAT!';
        sendConditionResponse($response);
    }

    // Buat Payload
    $payload = [
        'resourceType'   => 'Condition',
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
        $response['message'] = 'Gagal membuat payload Condition (): '.json_last_error_msg();
        sendConditionResponse($response);
    }

    // Kirim Ke Satusehat
    $content = CreatCondition($url_satusehat, $json, $token);
    $data    = json_decode($content, true);

    if(json_last_error() !== JSON_ERROR_NONE){
        $response['message'] = 'Response SATUSEHAT bukan JSON valid ('.$url_satusehat.'): '.json_last_error_msg();
        sendConditionResponse($response);
    }

    if(($data['resourceType'] ?? '') === 'OperationOutcome'){
        $response['message'] = getConditionOutcomeMessage($data);
        sendConditionResponse($response);
    }

    if(($data['resourceType'] ?? '') !== 'Condition' || empty($data['id'])){
        $response['message'] = 'Response SATUSEHAT tidak memuat ID Condition';
        sendConditionResponse($response);
    }

    // Update Tabel Diagnosis
    $id_condition = $data['id'];
    $sql = "UPDATE diagnosis SET id_condition = ? WHERE id_diagnosis = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("si", $id_condition, $id_diagnosis);

    if(!$stmt->execute()){
        $response['message'] = 'Condition berhasil dikirim, tetapi gagal update ID Condition: '.$stmt->error;
        $stmt->close();
        sendConditionResponse($response);
    }

    $stmt->close();

    $response = [
        'status'       => 'success',
        'message'      => 'Condition berhasil dikirim ke SATUSEHAT',
        'id_kunjungan' => $id_kunjungan,
        'id_condition' => $id_condition
    ];

    sendConditionResponse($response);
?>

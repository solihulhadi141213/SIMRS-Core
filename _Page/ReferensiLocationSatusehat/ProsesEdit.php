<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $sendResponse = static function ($status, $message, $data = [], $httpStatus = 200) {
        http_response_code($httpStatus);
        echo json_encode(
            array_merge([
                'status' => $status,
                'message' => $message
            ], $data),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        exit;
    };

    if (empty($SessionIdAkses)) {
        $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.', [], 401);
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        $sendResponse('error', 'Metode request tidak valid.', [], 405);
    }

    $getPostValue = static function ($key, $default = '') {
        $value = $_POST[$key] ?? $default;
        return is_scalar($value) ? trim((string)$value) : null;
    };

    $idLocation = $getPostValue('id_location');
    $locationName = $getPostValue('name');
    $modeInput = $getPostValue('mode');
    $typeInput = $getPostValue('type');
    $description = $getPostValue('description', '');

    if (
        $idLocation === null ||
        $locationName === null ||
        $modeInput === null ||
        $typeInput === null ||
        $description === null
    ) {
        $sendResponse('error', 'Data Location tidak valid.', [], 400);
    }
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idLocation)) {
        $sendResponse('error', 'ID Location tidak valid.', [], 400);
    }
    if ($locationName === '') {
        $sendResponse('error', 'Nama lokasi tidak boleh kosong.', [], 400);
    }

    $allowedModes = [
        'instance' => 'Instance',
        'kind' => 'Kind'
    ];
    $modeParts = explode('|', $modeInput, 2);
    $modeCode = $modeParts[0] ?? '';
    if (
        count($modeParts) !== 2 ||
        !isset($allowedModes[$modeCode]) ||
        $modeParts[1] !== $allowedModes[$modeCode]
    ) {
        $sendResponse('error', 'Mode lokasi tidak valid.', [], 400);
    }

    $allowedTypes = [
        'si' => 'Site',
        'bu' => 'Building',
        'wi' => 'Wing',
        'wa' => 'Ward',
        'lvl' => 'Level',
        'co' => 'Corridor',
        'ro' => 'Room',
        'bd' => 'Bed',
        've' => 'Vehicle',
        'ho' => 'House',
        'ca' => 'Cabinet',
        'rd' => 'Road',
        'area' => 'Area',
        'jdn' => 'Jurisdiction'
    ];
    $typeParts = explode('|', $typeInput, 2);
    $typeCode = $typeParts[0] ?? '';
    if (
        count($typeParts) !== 2 ||
        !isset($allowedTypes[$typeCode]) ||
        $typeParts[1] !== $allowedTypes[$typeCode]
    ) {
        $sendResponse('error', 'Tipe lokasi tidak valid.', [], 400);
    }

    $baseUrl = rtrim(trim((string)getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'url_satusehat'
    )), '/');
    if ($baseUrl === '') {
        $sendResponse('error', 'Base URL SATUSEHAT tidak ditemukan. Silakan periksa konfigurasi.', [], 500);
    }

    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        $sendResponse(
            'error',
            'Gagal membuat token SATUSEHAT: ' .
            ($tokenResult['message'] ?? 'Terjadi kesalahan yang tidak diketahui.'),
            [],
            502
        );
    }
    $token = trim((string)($tokenResult['token'] ?? ''));
    if ($token === '') {
        $sendResponse('error', 'Token SATUSEHAT tidak tersedia.', [], 502);
    }

    // PUT membutuhkan representasi resource lengkap; pertahankan properti yang tidak diedit.
    $currentResponse = locationById($baseUrl, $token, $idLocation);
    if (!is_string($currentResponse) || $currentResponse === '') {
        $sendResponse('error', 'Tidak menerima response Location dari SATUSEHAT.', [], 502);
    }
    $location = json_decode($currentResponse, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($location)) {
        $sendResponse('error', 'Response SATUSEHAT bukan JSON yang valid.', [], 502);
    }
    if (($location['resourceType'] ?? '') === 'OperationOutcome') {
        $issue = $location['issue'][0] ?? [];
        $message = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
        if (!is_scalar($message) || trim((string)$message) === '') {
            $message = 'SATUSEHAT tidak mengembalikan detail error.';
        }
        $sendResponse('error', (string)$message, [], 502);
    }
    $currentId = $location['id'] ?? '';
    if (
        ($location['resourceType'] ?? '') !== 'Location' ||
        !is_scalar($currentId) ||
        trim((string)$currentId) !== $idLocation
    ) {
        $sendResponse('error', 'Response SATUSEHAT bukan Location yang diminta.', [], 502);
    }

    $location['name'] = $locationName;
    $location['mode'] = $modeCode;
    $location['physicalType'] = [
        'coding' => [[
            'system' => 'http://terminology.hl7.org/CodeSystem/location-physical-type',
            'code' => $typeCode,
            'display' => $allowedTypes[$typeCode]
        ]]
    ];
    if ($description === '') {
        unset($location['description']);
    } else {
        $location['description'] = $description;
    }

    $payloadJson = json_encode(
        $location,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
    if ($payloadJson === false) {
        $sendResponse(
            'error',
            'Gagal membuat payload Location: ' . json_last_error_msg(),
            [],
            500
        );
    }

    $apiResponse = UpdateLocation($baseUrl, $payloadJson, $token, rawurlencode($idLocation));
    if (!is_string($apiResponse) || $apiResponse === '') {
        $sendResponse('error', 'Tidak menerima response update dari SATUSEHAT.', [], 502);
    }

    $responseData = json_decode($apiResponse, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($responseData)) {
        $sendResponse('error', 'Response SATUSEHAT bukan JSON valid.', [], 502);
    }
    if (($responseData['resourceType'] ?? '') === 'OperationOutcome') {
        $issue = $responseData['issue'][0] ?? [];
        $message = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
        if (!is_scalar($message) || trim((string)$message) === '') {
            $message = 'SATUSEHAT menolak perubahan Location.';
        }
        $sendResponse('error', (string)$message, [], 502);
    }

    $updatedId = $responseData['id'] ?? '';
    if (
        ($responseData['resourceType'] ?? '') !== 'Location' ||
        !is_scalar($updatedId) ||
        trim((string)$updatedId) !== $idLocation
    ) {
        $sendResponse('error', 'Response SATUSEHAT tidak mengonfirmasi update Location.', [], 502);
    }
    $updatedId = trim((string)$updatedId);

    // Simpan log aktivitas edit location referensi
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        'Edit Location Referensi',
        'Referensi Location',
        [
            'id_location' => $idLocation,
            'nama_lokasi' => $locationName,
            'mode' => $modeCode,
            'type' => $typeCode
        ]
    );

    $sendResponse(
        'success',
        'Location berhasil diperbarui di SATUSEHAT.',
        ['id_location' => $updatedId]
    );
?>
<?php
    header('Content-Type: application/json; charset=utf-8');

    // Load koneksi, helper SATUSEHAT, dan sesi pengguna.
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Kirim response JSON dengan HTTP status yang sesuai.
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

    // Pastikan request berasal dari pengguna yang memiliki sesi aktif.
    if (empty($SessionIdAkses)) {
        $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.', [], 401);
    }

    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        $sendResponse('error', 'Metode request tidak valid.', [], 405);
    }

    // Baca nilai form sebagai teks dan tolak input berbentuk array.
    $getPostValue = static function ($key, $default = '') {
        $value = $_POST[$key] ?? $default;
        return is_scalar($value) ? trim((string)$value) : null;
    };

    $locationName = $getPostValue('name');
    $modeInput = $getPostValue('mode');
    $typeInput = $getPostValue('type');
    $description = $getPostValue('description', '');

    if ($locationName === null || $modeInput === null || $typeInput === null || $description === null) {
        $sendResponse('error', 'Data Location tidak valid.', [], 400);
    }
    if ($locationName === '') {
        $sendResponse('error', 'Nama lokasi tidak boleh kosong.', [], 400);
    }

    // Validasi dan pisahkan kode/display mode dari opsi form.
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

    // Validasi kode dan display physical type yang tersedia pada form.
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

    // Baca URL dan Organization ID dari konfigurasi aktif SATUSEHAT.
    $baseUrl = rtrim(trim((string)getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'url_satusehat'
    )), '/');
    $organizationId = trim((string)getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'organization_id'
    ));

    if ($baseUrl === '' || $organizationId === '') {
        $sendResponse(
            'error',
            'URL atau Organization ID SATUSEHAT belum dikonfigurasi.',
            [],
            500
        );
    }
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $organizationId)) {
        $sendResponse('error', 'Organization ID SATUSEHAT tidak valid.', [], 500);
    }

    // Buat token SATUSEHAT dan hentikan proses jika token tidak tersedia.
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

    // Generate kode identifier Location dan susun payload sesuai dokumentasi.
    $locationCode = 'LOC-' . GenerateRandomeToken(12);
    $payload = [
        'resourceType' => 'Location',
        'identifier' => [[
            'use' => 'official',
            'system' => 'http://sys-ids.kemkes.go.id/location/' . $organizationId,
            'value' => $locationCode
        ]],
        'status' => 'active',
        'name' => $locationName,
        'mode' => $modeCode,
        'physicalType' => [
            'coding' => [[
                'system' => 'http://terminology.hl7.org/CodeSystem/location-physical-type',
                'code' => $typeCode,
                'display' => $allowedTypes[$typeCode]
            ]]
        ],
        'managingOrganization' => [
            'reference' => 'Organization/' . $organizationId
        ]
    ];
    if ($description !== '') {
        $payload['description'] = $description;
    }

    $payloadJson = json_encode(
        $payload,
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

    // Kirim Location menggunakan helper SATUSEHAT bersama.
    $apiResponse = CreatLocation($baseUrl, $payloadJson, $token);
    if (!is_string($apiResponse) || $apiResponse === '') {
        $sendResponse('error', 'Tidak menerima response dari SATUSEHAT.', [], 502);
    }

    $responseData = json_decode($apiResponse, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($responseData)) {
        $sendResponse('error', 'Response SATUSEHAT bukan JSON valid.', [], 502);
    }

    // Tampilkan pesan validasi SATUSEHAT jika request ditolak.
    if (($responseData['resourceType'] ?? '') === 'OperationOutcome') {
        $issue = $responseData['issue'][0] ?? [];
        $message = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
        if (!is_scalar($message) || trim((string)$message) === '') {
            $message = 'SATUSEHAT menolak payload Location.';
        }
        $sendResponse('error', (string)$message, [], 502);
    }

    // Pastikan response sukses berisi resource Location beserta ID.
    $locationId = trim((string)($responseData['id'] ?? ''));
    if (($responseData['resourceType'] ?? '') !== 'Location' || $locationId === '') {
        $sendResponse(
            'error',
            'Response SATUSEHAT tidak memuat ID Location.',
            [],
            502
        );
    }

    // Simpan log aktivitas tambah location referensi
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        'Tambah Location Referensi',
        'Referensi Location',
        [
            'id_location' => $locationId,
            'identifier' => $locationCode,
            'nama_lokasi' => $locationName,
            'mode' => $modeCode,
            'type' => $typeCode
        ]
    );

    $sendResponse(
        'success',
        'Location berhasil dibuat di SATUSEHAT.',
        [
            'id_location' => $locationId,
            'identifier' => $locationCode
        ]
    );
?>

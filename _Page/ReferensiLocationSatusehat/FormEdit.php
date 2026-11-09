<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $sendResponse = static function ($status, $message, $editFormHtml = '', $httpStatus = 200) {
        http_response_code($httpStatus);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'EditFormHtml' => $editFormHtml
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    };

    if (empty($SessionIdAkses)) {
        $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.', '', 401);
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        $sendResponse('error', 'Metode request tidak valid.', '', 405);
    }

    $idLocationInput = $_POST['id_location'] ?? '';
    if (!is_scalar($idLocationInput)) {
        $sendResponse('error', 'ID Location tidak valid.', '', 400);
    }
    $idLocation = trim((string)$idLocationInput);
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idLocation)) {
        $sendResponse('error', 'ID Location tidak valid.', '', 400);
    }

    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        $sendResponse(
            'error',
            'Gagal membuat token SATUSEHAT: ' .
            ($tokenResult['message'] ?? 'Terjadi kesalahan yang tidak diketahui.'),
            '',
            502
        );
    }
    $token = trim((string)($tokenResult['token'] ?? ''));
    if ($token === '') {
        $sendResponse('error', 'Token SATUSEHAT tidak tersedia.', '', 502);
    }

    $baseUrl = rtrim(trim((string)getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'url_satusehat'
    )), '/');
    if ($baseUrl === '') {
        $sendResponse('error', 'Base URL SATUSEHAT tidak ditemukan. Silakan periksa konfigurasi.', '', 500);
    }

    $response = locationById($baseUrl, $token, $idLocation);
    if (!is_string($response) || $response === '') {
        $sendResponse('error', 'Tidak menerima response Location dari SATUSEHAT.', '', 502);
    }

    $location = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($location)) {
        $sendResponse('error', 'Response SATUSEHAT bukan JSON yang valid.', '', 502);
    }
    if (($location['resourceType'] ?? '') === 'OperationOutcome') {
        $issue = $location['issue'][0] ?? [];
        $message = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
        if (!is_scalar($message) || trim((string)$message) === '') {
            $message = 'SATUSEHAT tidak mengembalikan detail error.';
        }
        $sendResponse('error', (string)$message, '', 502);
    }
    if (
        ($location['resourceType'] ?? '') !== 'Location' ||
        trim((string)($location['id'] ?? '')) !== $idLocation
    ) {
        $sendResponse('error', 'Response SATUSEHAT bukan Location yang diminta.', '', 502);
    }

    $escape = static function ($value) {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    };

    $mode = $location['mode'] ?? 'instance';
    if (!is_scalar($mode)) {
        $mode = 'instance';
    }

    $typeCode = '';
    $physicalType = $location['physicalType'] ?? [];
    $coding = is_array($physicalType) ? ($physicalType['coding'] ?? []) : [];
    if (is_array($coding) && isset($coding[0]) && is_array($coding[0])) {
        $typeCode = $coding[0]['code'] ?? '';
    }
    if (!is_scalar($typeCode)) {
        $typeCode = '';
    }

    $modeOptions = [
        'instance' => 'Lokasi spesifik yang dapat diidentifikasi secara individual.',
        'kind' => 'Kategori atau kelompok dari suatu jenis lokasi.'
    ];
    $typeOptions = [
        'si' => 'Area kompleks atau kawasan',
        'bu' => 'Bangunan',
        'wi' => 'Sayap atau bagian gedung',
        'wa' => 'Areal Bangsal Perawat',
        'lvl' => 'Tingkat atau lantai',
        'co' => 'Koridor',
        'ro' => 'Ruangan',
        'bd' => 'Area Tempat Tidur',
        've' => 'Kendaraan',
        'ho' => 'Rumah Atau Hunian',
        'ca' => 'Lemari Atau Tempat Penyimpanan',
        'rd' => 'Jalan',
        'area' => 'Area',
        'jdn' => 'Wilayah kewenangan'
    ];
    $typeDisplays = [
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

    $formHtml = '<input type="hidden" name="id_location" id="id_location_edit" value="' . $escape($idLocation) . '">';
    $formHtml .= '
        <div class="row mb-3">
            <div class="col-12">
                <label for="name_edit">Nama Lokasi</label>
                <input type="text" name="name" id="name_edit" class="form-control" value="' .
                    $escape($location['name'] ?? '') . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="mode_edit">Mode Lokasi</label>
                <select name="mode" id="mode_edit" class="form-control">';
    foreach ($modeOptions as $code => $description) {
        $selected = (string)$mode === $code ? ' selected' : '';
        $formHtml .= '<option value="' . $escape($code . '|' . ucfirst($code)) . '"' . $selected . '>'
            . $escape($description) . '</option>';
    }
    $formHtml .= '
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="type_edit">Tipe Lokasi</label>
                <select name="type" id="type_edit" class="form-control">';
    foreach ($typeOptions as $code => $label) {
        $selected = (string)$typeCode === $code ? ' selected' : '';
        $formHtml .= '<option value="' . $escape($code . '|' . $typeDisplays[$code]) . '"' . $selected . '>'
            . $escape($label) . '</option>';
    }
    $formHtml .= '
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="description_edit">Deskripsi</label>
                <textarea name="description" id="description_edit" class="form-control">' .
                    $escape($location['description'] ?? '') . '</textarea>
            </div>
        </div>';

    $sendResponse('success', 'Form edit Location berhasil dimuat.', $formHtml);
?>
<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $sendResponse = static function ($status, $message, $formStatusHtml = '', $httpStatus = 200) {
        http_response_code($httpStatus);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'FormStatusHtml' => $formStatusHtml
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

    $apiResponse = locationById($baseUrl, $token, $idLocation);
    if (!is_string($apiResponse) || $apiResponse === '') {
        $sendResponse('error', 'Tidak menerima response Location dari SATUSEHAT.', '', 502);
    }
    $location = json_decode($apiResponse, true);
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

    $resourceId = $location['id'] ?? '';
    if (
        ($location['resourceType'] ?? '') !== 'Location' ||
        !is_scalar($resourceId) ||
        trim((string)$resourceId) !== $idLocation
    ) {
        $sendResponse('error', 'Response SATUSEHAT bukan Location yang diminta.', '', 502);
    }

    $currentStatus = $location['status'] ?? 'active';
    if (!is_string($currentStatus) || !in_array($currentStatus, ['active', 'suspended', 'inactive'], true)) {
        $currentStatus = 'active';
    }
    $statusOptions = [
        'active' => 'Aktif',
        'suspended' => 'Ditangguhkan',
        'inactive' => 'Tidak Aktif'
    ];
    $escape = static function ($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    };

    $formHtml = '<input type="hidden" name="id_location" id="id_location_status" value="' .
        $escape($idLocation) . '">';
    foreach ($statusOptions as $value => $label) {
        $checked = $currentStatus === $value ? ' checked' : '';
        $formHtml .= '
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="status" id="status_' .
                    $escape($value) . '" value="' . $escape($value) . '"' . $checked . '>
                <label class="form-check-label" for="status_' . $escape($value) . '">' .
                    $escape($label) . ' <small class="text-muted">(' . $escape($value) . ')</small>
                </label>
            </div>';
    }

    $sendResponse('success', 'Form status Location berhasil dimuat.', $formHtml);
?>
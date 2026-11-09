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

    $idLocationInput = $_POST['id_location'] ?? '';
    $statusInput = $_POST['status'] ?? '';
    if (!is_scalar($idLocationInput) || !is_scalar($statusInput)) {
        $sendResponse('error', 'Data status Location tidak valid.', [], 400);
    }
    $idLocation = trim((string)$idLocationInput);
    $newStatus = trim((string)$statusInput);
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idLocation)) {
        $sendResponse('error', 'ID Location tidak valid.', [], 400);
    }
    if (!in_array($newStatus, ['active', 'suspended', 'inactive'], true)) {
        $sendResponse('error', 'Status Location tidak valid.', [], 400);
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

    // PUT membutuhkan resource lengkap agar properti Location lainnya tetap terjaga.
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
    $resourceId = $location['id'] ?? '';
    if (
        ($location['resourceType'] ?? '') !== 'Location' ||
        !is_scalar($resourceId) ||
        trim((string)$resourceId) !== $idLocation
    ) {
        $sendResponse('error', 'Response SATUSEHAT bukan Location yang diminta.', [], 502);
    }

    $location['status'] = $newStatus;
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
            $message = 'SATUSEHAT menolak perubahan status Location.';
        }
        $sendResponse('error', (string)$message, [], 502);
    }
    $updatedId = $responseData['id'] ?? '';
    if (
        ($responseData['resourceType'] ?? '') !== 'Location' ||
        !is_scalar($updatedId) ||
        trim((string)$updatedId) !== $idLocation
    ) {
        $sendResponse('error', 'Response SATUSEHAT tidak mengonfirmasi update status Location.', [], 502);
    }

    // Simpan log aktivitas ubah status location referensi
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        'Ubah Status Location Referensi',
        'Referensi Location',
        [
            'id_location' => $idLocation,
            'status_location' => $newStatus
        ]
    );

    $sendResponse(
        'success',
        'Status Location berhasil diperbarui di SATUSEHAT.',
        [
            'id_location' => $idLocation,
            'status_location' => $newStatus
        ]
    );
?>
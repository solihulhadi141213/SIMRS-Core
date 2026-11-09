<?php
// Koneksi, helper, dan session
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

header('Content-Type: application/json; charset=utf-8');

// Mengirim response JSON untuk proses pemuatan form
$sendResponse = static function (string $status, string $message, string $htmlForm = ''): void {
    $jsonResponse = json_encode([
        'status' => $status,
        'message' => $message,
        'htmlForm' => $htmlForm,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

    if ($jsonResponse === false) {
        http_response_code(500);
        echo '{"status":"error","message":"Gagal membuat response JSON.","htmlForm":""}';
        exit;
    }

    echo $jsonResponse;
    exit;
};

// Memastikan sesi dan ID Encounter tersedia
if (empty($SessionIdAkses)) {
    $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.');
}

$idEncounterInput = $_POST['id_encounter'] ?? '';
if (!is_scalar($idEncounterInput)) {
    $sendResponse('error', 'ID Encounter tidak valid.');
}

$idEncounter = trim((string)$idEncounterInput);
if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idEncounter)) {
    $sendResponse('error', 'ID Encounter tidak boleh kosong atau tidak valid.');
}

// Membaca referensi class dan status yang digunakan pada pilihan form
$classJson = file_get_contents(__DIR__ . '\\encounter_class.json');
$statusJson = file_get_contents(__DIR__ . '\\encounter_status.json');
if ($classJson === false || $statusJson === false) {
    error_log('Encounter edit reference files could not be read.');
    $sendResponse('error', 'Referensi class atau status Encounter tidak dapat dibaca.');
}

$classReference = json_decode($classJson, true);
$statusReference = json_decode($statusJson, true);
if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($classReference) ||
    !is_array($classReference['data'] ?? null) ||
    !is_array($statusReference)
) {
    error_log('Encounter edit reference files contain invalid JSON.');
    $sendResponse('error', 'Referensi class atau status Encounter tidak valid.');
}

// Mengambil token SATUSEHAT
$tokenResult = generateTokenSatuSehat($Conn);
if (($tokenResult['status'] ?? 'error') !== 'success') {
    $sendResponse(
        'error',
        'Gagal membuat token SATUSEHAT: ' .
        (string)($tokenResult['message'] ?? 'Terjadi kesalahan yang tidak diketahui.')
    );
}

$token = trim((string)($tokenResult['token'] ?? ''));
if ($token === '') {
    $sendResponse('error', 'Token SATUSEHAT tidak tersedia.');
}

// Mengambil URL SATUSEHAT aktif
$baseUrl = rtrim(trim((string)getDataDetail(
    $Conn,
    'setting_satusehat',
    'status_setting_satusehat',
    1,
    'url_satusehat'
)), '/');

if ($baseUrl === '') {
    $sendResponse('error', 'Base URL SATUSEHAT tidak ditemukan. Silakan periksa konfigurasi.');
}

// Mengambil resource Encounter yang akan diedit
$responseBody = EncounterById($baseUrl, $token, $idEncounter);
if (!is_string($responseBody) || $responseBody === '') {
    $sendResponse('error', 'Tidak menerima response Encounter dari SATUSEHAT.');
}

$encounter = json_decode($responseBody, true);
if (json_last_error() !== JSON_ERROR_NONE || !is_array($encounter)) {
    $sendResponse('error', 'Response SATUSEHAT bukan JSON yang valid.');
}

if (($encounter['resourceType'] ?? '') === 'OperationOutcome') {
    $issue = $encounter['issue'][0] ?? [];
    $apiMessage = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
    if (!is_scalar($apiMessage) || trim((string)$apiMessage) === '') {
        $apiMessage = 'SATUSEHAT gagal mengambil resource Encounter.';
    }
    $sendResponse('error', (string)$apiMessage);
}

if (
    ($encounter['resourceType'] ?? '') !== 'Encounter' ||
    trim((string)($encounter['id'] ?? '')) !== $idEncounter
) {
    $sendResponse('error', 'Response SATUSEHAT bukan Encounter yang diminta.');
}

// Membaca kode class dan status resource saat ini
$currentClass = $encounter['class'] ?? [];
if (!is_array($currentClass)) {
    $currentClass = [];
}
$currentClassCode = $currentClass['code'] ?? $currentClass['coding'][0]['code'] ?? '';
$currentStatus = $encounter['status'] ?? '';
if (!is_scalar($currentClassCode) || !is_scalar($currentStatus)) {
    $sendResponse('error', 'Class atau status Encounter saat ini tidak valid.');
}
$currentClassCode = (string)$currentClassCode;
$currentStatus = (string)$currentStatus;

// Membuat pilihan select dengan nilai yang aman untuk HTML
$escape = static function ($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};

$htmlForm = '<input type="hidden" name="id_encounter" value="' . $escape($idEncounter) . '">';
$htmlForm .= '
    <div class="row mb-3">
        <div class="col-12">
            <label for="class_code_edit"><small>Class Encounter</small></label>
            <select name="class_code" id="class_code_edit" class="form-control" required>';

$classFound = false;
foreach ($classReference['data'] as $class) {
    if (!is_array($class) || !isset($class['code'], $class['display'])) {
        continue;
    }

    $classCode = (string)$class['code'];
    $selected = $classCode === $currentClassCode ? ' selected' : '';
    $classFound = $classFound || $selected !== '';
    $htmlForm .= '<option value="' . $escape($classCode) . '"' . $selected . '>'
        . $escape($classCode . ' - ' . $class['display'])
        . '</option>';
}

if (!$classFound && $currentClassCode !== '') {
    $htmlForm .= '<option value="' . $escape($currentClassCode) . '" selected>'
        . $escape($currentClassCode . ' - Class saat ini (tidak tersedia pada referensi)')
        . '</option>';
}

$htmlForm .= '
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <label for="status_edit"><small>Status Encounter</small></label>
            <select name="status" id="status_edit" class="form-control" required>';

$statusFound = false;
foreach ($statusReference as $statusOption) {
    if (!is_array($statusOption) || !isset($statusOption['code'], $statusOption['display'])) {
        continue;
    }

    $statusCode = (string)$statusOption['code'];
    $selected = $statusCode === $currentStatus ? ' selected' : '';
    $statusFound = $statusFound || $selected !== '';
    $htmlForm .= '<option value="' . $escape($statusCode) . '"' . $selected . '>'
        . $escape($statusOption['display'] . ' (' . $statusCode . ')')
        . '</option>';
}

if (!$statusFound && $currentStatus !== '') {
    $htmlForm .= '<option value="' . $escape($currentStatus) . '" selected>'
        . $escape($currentStatus . ' - Status saat ini (tidak tersedia pada referensi)')
        . '</option>';
}

$htmlForm .= '
            </select>
        </div>
    </div>';

$sendResponse('success', 'Form edit Encounter berhasil dimuat.', $htmlForm);

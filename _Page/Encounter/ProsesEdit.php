<?php
// Koneksi, helper, dan session
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

header('Content-Type: application/json; charset=utf-8');

// Mengirim response JSON untuk proses update Encounter
$sendResponse = static function (string $status, string $message): void {
    $jsonResponse = json_encode([
        'status' => $status,
        'message' => $message,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

    if ($jsonResponse === false) {
        http_response_code(500);
        echo '{"status":"error","message":"Gagal membuat response JSON."}';
        exit;
    }

    echo $jsonResponse;
    exit;
};

// Memastikan sesi dan seluruh input form valid
if (empty($SessionIdAkses)) {
    $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.');
}

$idEncounterInput = $_POST['id_encounter'] ?? '';
$classCodeInput = $_POST['class_code'] ?? '';
$statusInput = $_POST['status'] ?? '';
if (!is_scalar($idEncounterInput) || !is_scalar($classCodeInput) || !is_scalar($statusInput)) {
    $sendResponse('error', 'Data form Encounter tidak valid.');
}

$idEncounter = trim((string)$idEncounterInput);
$classCode = trim((string)$classCodeInput);
$status = trim((string)$statusInput);

if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idEncounter)) {
    $sendResponse('error', 'ID Encounter tidak boleh kosong atau tidak valid.');
}

if ($classCode === '' || $status === '') {
    $sendResponse('validation_error', 'Class dan status Encounter wajib dipilih.');
}

// Memastikan pilihan form termasuk referensi yang disediakan
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

$selectedClass = null;
foreach ($classReference['data'] as $classOption) {
    if (is_array($classOption) && (string)($classOption['code'] ?? '') === $classCode) {
        $selectedClass = $classOption;
        break;
    }
}

$selectedStatus = null;
foreach ($statusReference as $statusOption) {
    if (is_array($statusOption) && (string)($statusOption['code'] ?? '') === $status) {
        $selectedStatus = $statusOption;
        break;
    }
}

if ($selectedClass === null || $selectedStatus === null) {
    $sendResponse('validation_error', 'Class atau status yang dipilih tidak tersedia pada referensi.');
}

// Mengambil token dan URL SATUSEHAT aktif
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

// Membaca resource terbaru agar field lain tetap dipertahankan pada PUT
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

// Mengubah hanya class dan status sesuai pilihan form
$encounter['class'] = [
    'system' => (string)($classReference['system'] ?? ''),
    'code' => (string)$selectedClass['code'],
    'display' => (string)$selectedClass['display'],
];
$encounter['status'] = (string)$selectedStatus['code'];

$jsonPayload = json_encode(
    $encounter,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
);
if ($jsonPayload === false) {
    error_log('Encode Encounter update payload failed: ' . json_last_error_msg());
    $sendResponse('error', 'Gagal membuat payload update Encounter.');
}

// Mengirim resource Encounter yang telah diperbarui
$updateResponseBody = UpdateEncounter($baseUrl, $jsonPayload, $token, $idEncounter);
if (!is_string($updateResponseBody) || $updateResponseBody === '') {
    $sendResponse('error', 'Tidak menerima response update Encounter dari SATUSEHAT.');
}

$updatedEncounter = json_decode($updateResponseBody, true);
if (json_last_error() !== JSON_ERROR_NONE || !is_array($updatedEncounter)) {
    $sendResponse('error', 'Response update SATUSEHAT bukan JSON yang valid.');
}

if (($updatedEncounter['resourceType'] ?? '') === 'OperationOutcome') {
    $issue = $updatedEncounter['issue'][0] ?? [];
    $apiMessage = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
    if (!is_scalar($apiMessage) || trim((string)$apiMessage) === '') {
        $apiMessage = 'SATUSEHAT menolak update Encounter.';
    }
    $sendResponse('error', (string)$apiMessage);
}

if (
    ($updatedEncounter['resourceType'] ?? '') !== 'Encounter' ||
    trim((string)($updatedEncounter['id'] ?? '')) !== $idEncounter
) {
    $sendResponse('error', 'SATUSEHAT tidak mengembalikan Encounter yang telah diperbarui.');
}

$sendResponse('success', 'Class dan status Encounter berhasil diperbarui di SATUSEHAT.');

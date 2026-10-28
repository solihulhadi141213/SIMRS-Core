<?php
header('Content-Type: application/json; charset=utf-8');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "../../_Config/SimrsFunction.php";
include __DIR__ . '/ObservationPayload.php';

$observationLockName = null;

function observationReleaseLock(): void
{
    global $Conn, $observationLockName;
    if ($observationLockName === null) {
        return;
    }
    $stmt = mysqli_prepare($Conn, 'SELECT RELEASE_LOCK(?)');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $observationLockName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    $observationLockName = null;
}

function observationSendResponse(string $status, string $message, array $extra = [], int $httpStatus = 200): void
{
    observationReleaseLock();
    http_response_code($httpStatus);
    echo json_encode(
        array_merge(['status' => $status, 'message' => $message], $extra),
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

function observationOutcomeMessage(array $response): string
{
    $diagnostics = trim((string) ($response['issue'][0]['diagnostics'] ?? ''));
    if ($diagnostics !== '') {
        if (preg_match('/Wrong reference ID format:\s*Patient\/([^\s(]+)/i', $diagnostics, $match)) {
            return 'SATUSEHAT menolak ID Patient ' . $match[1] . '. Periksa kolom pasien.id_ihs dan gunakan ID Patient dari MPI SATUSEHAT; jangan gunakan No. RM atau NIK.';
        }
        return $diagnostics;
    }
    $details = trim((string) ($response['issue'][0]['details']['text'] ?? ''));
    if ($details !== '') {
        return $details;
    }
    return 'SATUSEHAT menolak payload Observation.';
}

if (empty($SessionIdAkses)) {
    observationSendResponse('error', 'Sesi akses berakhir. Silakan login kembali.', [], 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observationSendResponse('error', 'Metode request tidak valid.', [], 405);
}

$idObservation = filter_var(
    $_POST['id_observation'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($idObservation === false || $idObservation === null) {
    observationSendResponse('error', 'ID observasi tidak valid.', [], 400);
}
$idObservation = (int) $idObservation;

// Hindari pengiriman ganda apabila pengguna menekan tombol lebih dari sekali.
$observationLockName = 'satusehat_observation_' . $idObservation;
$lockStmt = mysqli_prepare($Conn, 'SELECT GET_LOCK(?, 0)');
if (!$lockStmt) {
    error_log('Observasi SATUSEHAT: gagal menyiapkan advisory lock: ' . mysqli_error($Conn));
    $observationLockName = null;
    observationSendResponse('error', 'Gagal mengunci proses pengiriman observasi.', [], 500);
}
mysqli_stmt_bind_param($lockStmt, 's', $observationLockName);
mysqli_stmt_execute($lockStmt);
$lockResult = mysqli_stmt_get_result($lockStmt);
$lockRow = $lockResult ? mysqli_fetch_row($lockResult) : null;
mysqli_stmt_close($lockStmt);
if ((int) ($lockRow[0] ?? 0) !== 1) {
    $observationLockName = null;
    observationSendResponse('error', 'Observasi ini sedang diproses. Silakan tunggu sebentar.', [], 409);
}

$stmt = mysqli_prepare(
    $Conn,
    'SELECT
        o.id_observation,
        o.observation_id,
        o.id_pasien,
        o.id_kunjungan,
        o.id_praktisi,
        o.observation_value,
        o.datetime_observation,
        o.datetime_entry,
        p.nama AS nama_pasien,
        p.id_ihs AS patient_ihs,
        k.id_encounter AS encounter_ihs,
        k.jenis_kunjungan,
        pr.nama_praktisi,
        pr.id_practitioner AS practitioner_ihs,
        r.category_name,
        r.category_code,
        r.category_display,
        r.category_system,
        r.observation_name,
        r.observation_code,
        r.observation_display,
        r.observation_system,
        r.unit_name,
        r.unit_code,
        r.unit_display,
        r.unit_system,
        r.result_type,
        r.result_coded
     FROM observation o
     LEFT JOIN pasien p ON p.id_pasien = o.id_pasien
     LEFT JOIN kunjungan k ON k.id_kunjungan = o.id_kunjungan
     LEFT JOIN praktisi pr ON pr.id_praktisi = o.id_praktisi
     LEFT JOIN observation_reference r ON r.id_observation_reference = o.id_observation_reference
     WHERE o.id_observation = ?
     LIMIT 1'
);
if (!$stmt) {
    error_log('Observasi SATUSEHAT: gagal menyiapkan query: ' . mysqli_error($Conn));
    observationSendResponse('error', 'Gagal mengambil data observasi.', [], 500);
}
mysqli_stmt_bind_param($stmt, 'i', $idObservation);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi SATUSEHAT: gagal mengambil data: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    observationSendResponse('error', 'Gagal mengambil data observasi.', [], 500);
}
$observation = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$observation) {
    observationSendResponse('error', 'Data observasi tidak ditemukan.', [], 404);
}

$payloadStatus = buildObservationPayload($observation);
if (!$payloadStatus['ready']) {
    observationSendResponse(
        'error',
        'Payload Observation belum layak dikirim.',
        ['missing' => $payloadStatus['missing']],
        422
    );
}
$payloadJson = json_encode(
    $payloadStatus['payload'],
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
);
if ($payloadJson === false) {
    error_log('Observasi SATUSEHAT: gagal membuat JSON payload: ' . json_last_error_msg());
    observationSendResponse('error', 'Gagal menyusun payload Observation.', [], 500);
}

$configStmt = mysqli_prepare(
    $Conn,
    'SELECT url_satusehat FROM setting_satusehat WHERE status_setting_satusehat = 1 LIMIT 1'
);
if (!$configStmt || !mysqli_stmt_execute($configStmt)) {
    error_log('Observasi SATUSEHAT: gagal membaca konfigurasi aktif: ' . mysqli_error($Conn));
    if ($configStmt) {
        mysqli_stmt_close($configStmt);
    }
    observationSendResponse('error', 'Gagal membaca konfigurasi koneksi SATUSEHAT.', [], 500);
}
$configResult = mysqli_stmt_get_result($configStmt);
$config = $configResult ? mysqli_fetch_assoc($configResult) : null;
mysqli_stmt_close($configStmt);
$baseUrl = rtrim(trim((string) ($config['url_satusehat'] ?? '')), '/');
if ($baseUrl === '') {
    observationSendResponse('error', 'Konfigurasi URL SATUSEHAT belum tersedia.', [], 422);
}

$tokenResult = generateTokenSatuSehat($Conn);
if (($tokenResult['status'] ?? '') !== 'success' || trim((string) ($tokenResult['token'] ?? '')) === '') {
    observationSendResponse(
        'error',
        (string) ($tokenResult['message'] ?? 'Gagal memperoleh token SATUSEHAT.'),
        [],
        502
    );
}
$token = trim((string) $tokenResult['token']);
$url = $baseUrl . '/fhir-r4/v1/Observation';

$curl = curl_init($url);
if ($curl === false) {
    observationSendResponse('error', 'Tidak dapat memulai koneksi ke SATUSEHAT.', [], 500);
}
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payloadJson,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
        'Accept: application/fhir+json, application/json',
    ],
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 45,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);
$apiBody = curl_exec($curl);
$curlError = curl_error($curl);
$httpStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($apiBody === false) {
    error_log('Observasi SATUSEHAT: request gagal: ' . $curlError);
    observationSendResponse('error', 'Koneksi ke SATUSEHAT gagal: ' . $curlError, [], 502);
}
$apiResponse = json_decode($apiBody, true);
if (!is_array($apiResponse)) {
    error_log('Observasi SATUSEHAT: response bukan JSON valid. HTTP ' . $httpStatus . '.');
    observationSendResponse('error', 'Respons SATUSEHAT tidak dapat dibaca sebagai JSON (HTTP ' . $httpStatus . ').', [], 502);
}
if ($httpStatus < 200 || $httpStatus >= 300) {
    $apiMessage = ($apiResponse['resourceType'] ?? '') === 'OperationOutcome'
        ? observationOutcomeMessage($apiResponse)
        : 'SATUSEHAT mengembalikan HTTP ' . $httpStatus . '.';
    observationSendResponse('error', $apiMessage, ['http_status' => $httpStatus], 502);
}
if (($apiResponse['resourceType'] ?? '') !== 'Observation' || trim((string) ($apiResponse['id'] ?? '')) === '') {
    $apiMessage = ($apiResponse['resourceType'] ?? '') === 'OperationOutcome'
        ? observationOutcomeMessage($apiResponse)
        : 'Respons SATUSEHAT tidak memuat ID Observation.';
    observationSendResponse('error', $apiMessage, ['http_status' => $httpStatus], 502);
}

$observationId = trim((string) $apiResponse['id']);
$updateStmt = mysqli_prepare(
    $Conn,
    "UPDATE observation SET observation_id = ? WHERE id_observation = ? AND COALESCE(observation_id, '') = ''"
);
if (!$updateStmt) {
    error_log('Observasi SATUSEHAT: Observation terkirim dengan ID ' . $observationId . ', tetapi update lokal gagal: ' . mysqli_error($Conn));
    observationSendResponse(
        'error',
        'Observation sudah diterima SATUSEHAT, tetapi ID gagal disimpan ke database lokal. Hubungi administrator untuk sinkronisasi.',
        ['observation_id' => $observationId],
        500
    );
}
mysqli_stmt_bind_param($updateStmt, 'si', $observationId, $idObservation);
$updateSucceeded = mysqli_stmt_execute($updateStmt);
$affectedRows = mysqli_stmt_affected_rows($updateStmt);
$updateError = mysqli_stmt_error($updateStmt);
mysqli_stmt_close($updateStmt);
if (!$updateSucceeded || $affectedRows !== 1) {
    error_log('Observasi SATUSEHAT: Observation terkirim dengan ID ' . $observationId . ', tetapi update lokal gagal: ' . $updateError);
    observationSendResponse(
        'error',
        'Observation sudah diterima SATUSEHAT, tetapi ID gagal disimpan ke database lokal. Hubungi administrator untuk sinkronisasi.',
        ['observation_id' => $observationId],
        500
    );
}

observationSendResponse(
    'success',
    'Observation berhasil dikirim ke SATUSEHAT.',
    ['observation_id' => $observationId],
    200
);
?>

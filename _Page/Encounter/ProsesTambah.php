<?php
// Koneksi, helper, dan session
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

header('Content-Type: application/json; charset=utf-8');

// Mengirim response JSON untuk proses pengiriman Encounter
function sendEncounterProcessResponse(string $status, string $message, array $data = []): void
{
    $response = array_merge([
        'status' => $status,
        'message' => $message,
    ], $data);
    $jsonResponse = json_encode(
        $response,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );

    if ($jsonResponse === false) {
        http_response_code(500);
        echo '{"status":"error","message":"Gagal membuat response JSON."}';
        exit;
    }

    echo $jsonResponse;
    exit;
}

// Memastikan sesi dan ID kunjungan tersedia
if (empty($SessionIdAkses)) {
    sendEncounterProcessResponse('error', 'Sesi akses sudah berakhir! Silahkan login ulang.');
}

if (!isset($_POST['id_kunjungan']) || !is_scalar($_POST['id_kunjungan'])) {
    sendEncounterProcessResponse('error', 'ID Kunjungan tidak valid.');
}

$idKunjungan = filter_var(
    trim((string)$_POST['id_kunjungan']),
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

if ($idKunjungan === false) {
    sendEncounterProcessResponse('error', 'ID Kunjungan tidak valid.');
}

// Mengambil data yang digunakan oleh payload Encounter
$stmtKunjungan = $Conn->prepare(
    "SELECT
        k.id_kunjungan,
        k.id_encounter,
        k.jenis_kunjungan,
        k.datetime_daftar,
        p.nama AS nama_pasien,
        p.id_ihs,
        d.nama AS nama_practitioner,
        d.id_ihs_practitioner
     FROM kunjungan k
     LEFT JOIN pasien p ON p.id_pasien = k.id_pasien
     LEFT JOIN dokter d ON d.id_dokter = k.dpjp_id
     WHERE k.id_kunjungan = ?
     LIMIT 1"
);

if (!$stmtKunjungan) {
    error_log('Prepare Encounter visit query failed: ' . $Conn->error);
    sendEncounterProcessResponse('error', 'Gagal menyiapkan data kunjungan.');
}

$stmtKunjungan->bind_param('i', $idKunjungan);
if (!$stmtKunjungan->execute()) {
    error_log('Execute Encounter visit query failed: ' . $stmtKunjungan->error);
    $stmtKunjungan->close();
    sendEncounterProcessResponse('error', 'Gagal mengambil data kunjungan.');
}

$dataKunjungan = $stmtKunjungan->get_result()->fetch_assoc();
$stmtKunjungan->close();

if (!$dataKunjungan) {
    sendEncounterProcessResponse('error', 'Data kunjungan tidak ditemukan.');
}

if (!empty($dataKunjungan['id_encounter'])) {
    sendEncounterProcessResponse('error', 'Kunjungan ini sudah memiliki ID Encounter SATUSEHAT.');
}

// Mengambil konfigurasi SATUSEHAT aktif
$stmtSetting = $Conn->prepare(
    "SELECT
        nama_setting_satusehat,
        url_satusehat,
        organization_id,
        default_location_id
     FROM setting_satusehat
     WHERE status_setting_satusehat = 1
     LIMIT 1"
);

if (!$stmtSetting) {
    error_log('Prepare Encounter setting query failed: ' . $Conn->error);
    sendEncounterProcessResponse('error', 'Gagal menyiapkan pengaturan SATUSEHAT.');
}

if (!$stmtSetting->execute()) {
    error_log('Execute Encounter setting query failed: ' . $stmtSetting->error);
    $stmtSetting->close();
    sendEncounterProcessResponse('error', 'Gagal mengambil pengaturan SATUSEHAT.');
}

$dataSetting = $stmtSetting->get_result()->fetch_assoc();
$stmtSetting->close();

if (!$dataSetting) {
    sendEncounterProcessResponse('error', 'Pengaturan SATUSEHAT aktif tidak ditemukan.');
}

// Memvalidasi mandatory data dan mengubah waktu UTC ke format ISO 8601 UTC
$datetimeDaftar = trim((string)($dataKunjungan['datetime_daftar'] ?? ''));
$tanggalDaftar = $datetimeDaftar === ''
    ? false
    : DateTimeImmutable::createFromFormat(
        '!Y-m-d H:i:s',
        $datetimeDaftar,
        new DateTimeZone('UTC')
    );
$tanggalError = DateTime::getLastErrors();
$tanggalValid = $tanggalDaftar !== false
    && $tanggalDaftar->format('Y-m-d H:i:s') === $datetimeDaftar
    && ($tanggalError === false || ($tanggalError['warning_count'] === 0 && $tanggalError['error_count'] === 0));

$idKunjungan = (int)$dataKunjungan['id_kunjungan'];
$jenisKunjungan = trim((string)($dataKunjungan['jenis_kunjungan'] ?? ''));
$namaPasien = trim((string)($dataKunjungan['nama_pasien'] ?? ''));
$idIhsPasien = trim((string)($dataKunjungan['id_ihs'] ?? ''));
$namaPractitioner = trim((string)($dataKunjungan['nama_practitioner'] ?? ''));
$idIhsPractitioner = trim((string)($dataKunjungan['id_ihs_practitioner'] ?? ''));
$namaOrganization = trim((string)($dataSetting['nama_setting_satusehat'] ?? ''));
$organizationId = trim((string)($dataSetting['organization_id'] ?? ''));
$locationId = trim((string)($dataSetting['default_location_id'] ?? ''));
$baseUrlSatusehat = rtrim(trim((string)($dataSetting['url_satusehat'] ?? '')), '/');

$missingRequirements = [];
if ($namaPasien === '' || $idIhsPasien === '') {
    $missingRequirements[] = 'data pasien dan ID IHS';
}
if ($namaPractitioner === '' || $idIhsPractitioner === '') {
    $missingRequirements[] = 'data Practitioner DPJP dan ID IHS';
}
if (!$tanggalValid) {
    $missingRequirements[] = 'datetime_daftar yang valid';
}
if (!in_array($jenisKunjungan, ['Rajal', 'Ranap'], true)) {
    $missingRequirements[] = 'jenis kunjungan Rajal atau Ranap';
}
if ($organizationId === '' || $namaOrganization === '') {
    $missingRequirements[] = 'Organization SATUSEHAT';
}
if ($locationId === '') {
    $missingRequirements[] = 'Default Location SATUSEHAT';
}
if ($baseUrlSatusehat === '') {
    $missingRequirements[] = 'URL SATUSEHAT';
}

if (!empty($missingRequirements)) {
    sendEncounterProcessResponse(
        'validation_error',
        'Data mandatory belum lengkap: ' . implode(', ', $missingRequirements) . '.'
    );
}

// Menyusun payload Encounter mengikuti struktur contoh FHIR
$datetimeStart = $tanggalDaftar->format('Y-m-d\TH:i:s\Z');
$classEncounter = $jenisKunjungan === 'Rajal'
    ? [
        'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
        'code' => 'AMB',
        'display' => 'Ambulatory',
    ]
    : [
        'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
        'code' => 'IMP',
        'display' => 'Inpatient Encounter',
    ];

$payload = [
    'resourceType' => 'Encounter',
    'status' => 'arrived',
    'class' => $classEncounter,
    'subject' => [
        'reference' => 'Patient/' . $idIhsPasien,
        'display' => $namaPasien,
    ],
    'participant' => [
        [
            'type' => [
                [
                    'coding' => [
                        [
                            'system' => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                            'code' => 'ATND',
                            'display' => 'Attender',
                        ],
                    ],
                ],
            ],
            'individual' => [
                'reference' => 'Practitioner/' . $idIhsPractitioner,
                'display' => $namaPractitioner,
            ],
        ],
    ],
    'period' => [
        'start' => $datetimeStart,
    ],
    'location' => [
        [
            'location' => [
                'reference' => 'Location/' . $locationId,
            ],
        ],
    ],
    'statusHistory' => [
        [
            'status' => 'arrived',
            'period' => [
                'start' => $datetimeStart,
            ],
        ],
    ],
    'serviceProvider' => [
        'reference' => 'Organization/' . $organizationId,
        'display' => $namaOrganization,
    ],
    'identifier' => [
        [
            'system' => 'http://sys-ids.kemkes.go.id/encounter/' . $organizationId,
            'value' => 'ENC-' . $idKunjungan,
        ],
    ],
];

$jsonPayload = json_encode(
    $payload,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
);

if ($jsonPayload === false) {
    error_log('Encode Encounter payload failed: ' . json_last_error_msg());
    sendEncounterProcessResponse('error', 'Gagal membuat payload Encounter.');
}

// Memperoleh token SATUSEHAT dan mengirim payload melalui helper
$tokenResult = generateTokenSatuSehat($Conn);
if (($tokenResult['status'] ?? '') !== 'success' || empty($tokenResult['token'])) {
    error_log('Generate SATUSEHAT token failed: ' . (string)($tokenResult['message'] ?? 'Token tidak tersedia.'));
    sendEncounterProcessResponse(
        'error',
        'Gagal memperoleh token SATUSEHAT: ' . (string)($tokenResult['message'] ?? 'Token tidak tersedia.')
    );
}

$responseBody = CreatEncounter($baseUrlSatusehat, $jsonPayload, $tokenResult['token']);
if (!is_string($responseBody) || $responseBody === '') {
    error_log('CreatEncounter returned an empty response.');
    sendEncounterProcessResponse('error', 'Tidak ada response dari SATUSEHAT saat mengirim Encounter.');
}

$responseResource = json_decode($responseBody, true);
if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($responseResource) ||
    ($responseResource['resourceType'] ?? '') !== 'Encounter' ||
    empty($responseResource['id'])
) {
    $apiMessage = $responseResource['issue'][0]['diagnostics']
        ?? $responseResource['issue'][0]['details']['text']
        ?? 'SATUSEHAT tidak mengembalikan resource Encounter yang valid.';
    if (!is_scalar($apiMessage)) {
        $apiMessage = 'SATUSEHAT tidak mengembalikan resource Encounter yang valid.';
    }
    error_log('SATUSEHAT Encounter response invalid: ' . (string)$apiMessage);
    sendEncounterProcessResponse('error', (string)$apiMessage);
}

// Simpan ID resource setelah SATUSEHAT mengembalikan Encounter yang valid
$idEncounter = trim((string)$responseResource['id']);
$stmtUpdate = $Conn->prepare(
    "UPDATE kunjungan
     SET id_encounter = ?
     WHERE id_kunjungan = ?
       AND (id_encounter IS NULL OR TRIM(id_encounter) = '')"
);

if (!$stmtUpdate) {
    error_log('Prepare Encounter ID update failed: ' . $Conn->error);
    sendEncounterProcessResponse(
        'error',
        'Encounter berhasil dikirim ke SATUSEHAT, tetapi ID Encounter gagal disiapkan untuk disimpan.'
    );
}

$stmtUpdate->bind_param('si', $idEncounter, $idKunjungan);
if (!$stmtUpdate->execute()) {
    error_log('Execute Encounter ID update failed: ' . $stmtUpdate->error);
    $stmtUpdate->close();
    sendEncounterProcessResponse(
        'error',
        'Encounter berhasil dikirim ke SATUSEHAT, tetapi ID Encounter gagal disimpan.'
    );
}

$updatedRows = $stmtUpdate->affected_rows;
$stmtUpdate->close();

if ($updatedRows !== 1) {
    sendEncounterProcessResponse(
        'error',
        'Encounter berhasil dikirim ke SATUSEHAT, tetapi data kunjungan sudah berubah dan ID Encounter tidak dapat disimpan.'
    );
}

sendEncounterProcessResponse(
    'success',
    'Encounter berhasil dikirim ke SATUSEHAT.',
    ['id_encounter' => $idEncounter]
);

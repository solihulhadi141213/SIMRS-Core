<?php
// Koneksi, helper, dan session
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

header('Content-Type: application/json; charset=utf-8');

// Mengirim response dengan struktur yang digunakan Encounter.js
function sendEncounterFormResponse(array $response): void
{
    $defaultResponse = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memvalidasi data kunjungan.',
        'htmlForm' => '',
    ];
    $jsonResponse = json_encode(
        array_merge($defaultResponse, $response),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );

    if ($jsonResponse === false) {
        http_response_code(500);
        echo '{"status":"error","message":"Gagal membuat response JSON.","htmlForm":""}';
        exit;
    }

    echo $jsonResponse;
    exit;
}

// Memastikan sesi dan ID kunjungan tersedia
if (empty($SessionIdAkses)) {
    sendEncounterFormResponse([
        'message' => 'Sesi akses sudah berakhir! Silahkan login ulang.',
    ]);
}

if (!isset($_POST['id_kunjungan']) || !is_scalar($_POST['id_kunjungan'])) {
    sendEncounterFormResponse([
        'message' => 'ID Kunjungan tidak valid.',
    ]);
}

$idKunjungan = filter_var(
    trim((string)$_POST['id_kunjungan']),
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

if ($idKunjungan === false) {
    sendEncounterFormResponse([
        'message' => 'ID Kunjungan tidak valid.',
    ]);
}

// Mengambil kunjungan, pasien, dan DPJP melalui relasi pada skema database
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
     LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
     LEFT JOIN dokter d ON k.dpjp_id = d.id_dokter
     WHERE k.id_kunjungan = ?
     LIMIT 1"
);

if (!$stmtKunjungan) {
    sendEncounterFormResponse([
        'message' => 'Gagal menyiapkan pemeriksaan data kunjungan.',
    ]);
}

$stmtKunjungan->bind_param('i', $idKunjungan);
if (!$stmtKunjungan->execute()) {
    $stmtKunjungan->close();
    sendEncounterFormResponse([
        'message' => 'Gagal mengambil data kunjungan.',
    ]);
}

$resultKunjungan = $stmtKunjungan->get_result();
$dataKunjungan = $resultKunjungan->fetch_assoc();
$stmtKunjungan->close();

if (!$dataKunjungan) {
    sendEncounterFormResponse([
        'message' => 'Data kunjungan tidak ditemukan.',
    ]);
}

// Mengambil konfigurasi SATUSEHAT yang sedang aktif
$stmtSetting = $Conn->prepare(
    "SELECT organization_id, default_location_id
     FROM setting_satusehat
     WHERE status_setting_satusehat = 1
     LIMIT 1"
);

if (!$stmtSetting) {
    sendEncounterFormResponse([
        'message' => 'Gagal menyiapkan pemeriksaan pengaturan SATUSEHAT.',
    ]);
}

if (!$stmtSetting->execute()) {
    $stmtSetting->close();
    sendEncounterFormResponse([
        'message' => 'Gagal mengambil pengaturan SATUSEHAT.',
    ]);
}

$resultSetting = $stmtSetting->get_result();
$dataSetting = $resultSetting->fetch_assoc() ?: [];
$stmtSetting->close();

// Database menyimpan datetime dalam UTC; Encounter menerima timestamp ISO 8601 UTC
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
$datetimeStart = $tanggalValid ? $tanggalDaftar->format('Y-m-d\TH:i:s\Z') : '';

$namaPasien = trim((string)($dataKunjungan['nama_pasien'] ?? ''));
$idIhsPasien = trim((string)($dataKunjungan['id_ihs'] ?? ''));
$namaPractitioner = trim((string)($dataKunjungan['nama_practitioner'] ?? ''));
$idIhsPractitioner = trim((string)($dataKunjungan['id_ihs_practitioner'] ?? ''));
$jenisKunjungan = trim((string)($dataKunjungan['jenis_kunjungan'] ?? ''));
$organizationId = trim((string)($dataSetting['organization_id'] ?? ''));
$locationId = trim((string)($dataSetting['default_location_id'] ?? ''));

// Menyusun hasil pemeriksaan sesuai referensi yang wajib pada payload Encounter
$fulfillmentItems = [
    [
        'key' => 'pasien_lengkap',
        'title' => 'Data Pasien',
        'fulfilled' => $namaPasien !== '' && $idIhsPasien !== '',
        'description' => $namaPasien !== '' && $idIhsPasien !== ''
            ? 'Nama dan ID Patient SATUSEHAT tersedia.'
            : 'Nama pasien atau ID Patient SATUSEHAT belum tersedia.',
    ],
    [
        'key' => 'practitioner_lengkap',
        'title' => 'Practitioner DPJP',
        'fulfilled' => $namaPractitioner !== '' && $idIhsPractitioner !== '',
        'description' => $namaPractitioner !== '' && $idIhsPractitioner !== ''
            ? 'Nama dan ID Practitioner SATUSEHAT tersedia.'
            : 'DPJP atau ID Practitioner SATUSEHAT belum tersedia.',
    ],
    [
        'key' => 'tanggal_kunjungan',
        'title' => 'Tanggal Kunjungan',
        'fulfilled' => $tanggalValid,
        'description' => $tanggalValid
            ? 'Tanggal pendaftaran valid dan telah diformat sebagai UTC.'
            : 'Tanggal pendaftaran belum terisi atau tidak valid.',
    ],
    [
        'key' => 'default_location',
        'title' => 'Default Location',
        'fulfilled' => $locationId !== '',
        'description' => $locationId !== ''
            ? 'Default Location SATUSEHAT tersedia.'
            : 'Default Location ID belum diatur pada konfigurasi SATUSEHAT aktif.',
    ],
    [
        'key' => 'organization',
        'title' => 'Organization',
        'fulfilled' => $organizationId !== '',
        'description' => $organizationId !== ''
            ? 'Organization SATUSEHAT tersedia.'
            : 'Organization ID belum diatur pada konfigurasi SATUSEHAT aktif.',
    ],
    [
        'key' => 'jenis_kunjungan',
        'title' => 'Jenis Kunjungan',
        'fulfilled' => in_array($jenisKunjungan, ['Rajal', 'Ranap'], true),
        'description' => in_array($jenisKunjungan, ['Rajal', 'Ranap'], true)
            ? 'Jenis kunjungan valid.'
            : 'Jenis kunjungan belum diisi atau tidak valid.',
    ],
];

$allFulfilled = true;
$failedRequirements = [];
$htmlFulfillmentItems = '';

foreach ($fulfillmentItems as $item) {
    if (!$item['fulfilled']) {
        $allFulfilled = false;
        $failedRequirements[] = $item['title'];
    }

    $itemClass = $item['fulfilled'] ? 'text-success' : 'text-danger';
    $icon = $item['fulfilled'] ? '✅' : '❌';
    $titleHtml = htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8');
    $descriptionHtml = htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');
    $htmlFulfillmentItems .= '<li class="list-group-item ' . $itemClass . '">'
        . '<strong>' . $icon . ' ' . $titleHtml . ':</strong> ' . $descriptionHtml
        . '</li>';
}

$message = $allFulfilled
    ? 'Syarat pengiriman Encounter ke SATUSEHAT terpenuhi.'
    : 'Syarat pengiriman Encounter belum terpenuhi: ' . implode(', ', $failedRequirements) . '.';

$alertClass = $allFulfilled ? 'alert-success' : 'alert-danger';
$alertTitle = $allFulfilled ? 'Validasi berhasil.' : 'Validasi belum terpenuhi.';
$htmlForm = '<ul class="list-group list-group-flush mb-3">'
    . $htmlFulfillmentItems
    . '</ul>'
    . '<div class="alert ' . $alertClass . ' mb-0" role="alert">'
    . '<strong>' . $alertTitle . '</strong> '
    . htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
    . '</div>'
    . ($allFulfilled
        ? '<input type="hidden" name="id_kunjungan" value="' . (int)$dataKunjungan['id_kunjungan'] . '">'
        : '');

// Mengirim hasil validasi sesuai kontrak response yang digunakan Encounter.js
sendEncounterFormResponse([
    'status' => $allFulfilled ? 'success' : 'validation_error',
    'message' => $message,
    'htmlForm' => $htmlForm,
    'id_kunjungan' => (int)$dataKunjungan['id_kunjungan'],
    'data_pasien' => [
        'nama' => $namaPasien,
        'id_ihs' => $idIhsPasien,
        'datetime_daftar' => $datetimeDaftar,
        'jenis_kunjungan' => $jenisKunjungan,
    ],
    'datetime_start' => $datetimeStart,
    'data_practitioner' => [
        'nama' => $namaPractitioner,
        'id_ihs' => $idIhsPractitioner,
    ],
    'setting_satusehat' => [
        'has_default_location' => $locationId !== '',
        'default_location_id' => $locationId,
        'organization_id' => $organizationId,
    ],
    'fulfillment_items' => array_map(
        static function (array $item): array {
            $item['status'] = $item['fulfilled'] ? '✅' : '❌';
            unset($item['fulfilled']);
            return $item;
        },
        $fulfillmentItems
    ),
]);

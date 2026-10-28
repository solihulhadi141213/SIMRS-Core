<?php
header('Content-Type: text/html; charset=utf-8');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "../../_Config/SimrsFunction.php";

function detailObservationMessage(string $message, int $status = 200, string $type = 'danger'): void
{
    http_response_code($status);
    echo '<div class="alert alert-' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . ' mb-0">'
        . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</div>';
    exit;
}

function detailObservationEscape($value): string
{
    return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function detailObservationRow(string $label, $value): string
{
    if (is_bool($value)) {
        $value = $value ? 'true' : 'false';
    } elseif (is_array($value) || is_object($value)) {
        $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    $value = trim((string) ($value ?? ''));
    if ($value === '') {
        $value = '-';
    }

    return '<div class="row mb-2">'
        . '<div class="col-4"><small>' . detailObservationEscape($label) . '</small></div>'
        . '<div class="col-1"><small>:</small></div>'
        . '<div class="col-7"><small class="text-muted text-break">' . detailObservationEscape($value) . '</small></div>'
        . '</div>';
}

function detailObservationSection(string $title): string
{
    return '<div class="row mb-2"><div class="col-12"><small><b>'
        . detailObservationEscape($title)
        . '</b></small></div></div>';
}

function detailObservationCodingText(array $concept): string
{
    $parts = [];
    foreach (($concept['coding'] ?? []) as $coding) {
        if (!is_array($coding)) {
            continue;
        }
        $display = trim((string) ($coding['display'] ?? ''));
        $code = trim((string) ($coding['code'] ?? ''));
        $value = $display !== '' ? $display : $code;
        if ($display !== '' && $code !== '' && $display !== $code) {
            $value .= ' (' . $code . ')';
        }
        if ($value !== '') {
            $parts[] = $value;
        }
    }
    if (!$parts && !empty($concept['text'])) {
        $parts[] = (string) $concept['text'];
    }
    return implode('; ', $parts);
}

function detailObservationLocalDateTime($value, DateTimeZone $timezone): string
{
    $value = trim((string) ($value ?? ''));
    if ($value === '') {
        return '-';
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
        return $value;
    }
    try {
        return (new DateTimeImmutable($value, new DateTimeZone('UTC')))
            ->setTimezone($timezone)
            ->format('d/m/Y H:i T');
    } catch (Throwable $exception) {
        return $value;
    }
}

if (empty($SessionIdAkses)) {
    detailObservationMessage('Sesi akses berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    detailObservationMessage('Metode request tidak valid.', 405);
}

$observationId = trim((string) ($_POST['observation_id'] ?? ''));
// FHIR resource ID permits letters, digits, hyphen and period, with at most 64 characters.
if ($observationId === '' || preg_match('/^[A-Za-z0-9.-]{1,64}$/D', $observationId) !== 1) {
    detailObservationMessage('ID Observation SATUSEHAT tidak valid.', 400);
}

$configStmt = mysqli_prepare(
    $Conn,
    'SELECT url_satusehat FROM setting_satusehat WHERE status_setting_satusehat = 1 LIMIT 1'
);
if (!$configStmt || !mysqli_stmt_execute($configStmt)) {
    error_log('Detail Observation SATUSEHAT: gagal membaca konfigurasi: ' . mysqli_error($Conn));
    if ($configStmt) {
        mysqli_stmt_close($configStmt);
    }
    detailObservationMessage('Gagal membaca konfigurasi koneksi SATUSEHAT.', 500);
}
$configResult = mysqli_stmt_get_result($configStmt);
$config = $configResult ? mysqli_fetch_assoc($configResult) : null;
mysqli_stmt_close($configStmt);
$baseUrl = rtrim(trim((string) ($config['url_satusehat'] ?? '')), '/');
if ($baseUrl === '') {
    detailObservationMessage('Konfigurasi URL SATUSEHAT belum tersedia.', 422);
}

$tokenResult = generateTokenSatuSehat($Conn);
if (($tokenResult['status'] ?? '') !== 'success' || trim((string) ($tokenResult['token'] ?? '')) === '') {
    detailObservationMessage(
        (string) ($tokenResult['message'] ?? 'Gagal memperoleh token SATUSEHAT.'),
        502
    );
}
$token = trim((string) $tokenResult['token']);
$url = $baseUrl . '/fhir-r4/v1/Observation/' . rawurlencode($observationId);

$curl = curl_init($url);
if ($curl === false) {
    detailObservationMessage('Tidak dapat memulai koneksi ke SATUSEHAT.', 500);
}
curl_setopt_array($curl, [
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
    error_log('Detail Observation SATUSEHAT: request gagal: ' . $curlError);
    detailObservationMessage('Koneksi ke SATUSEHAT gagal: ' . $curlError, 502);
}
$observation = json_decode($apiBody, true);
if (!is_array($observation)) {
    error_log('Detail Observation SATUSEHAT: response bukan JSON valid. HTTP ' . $httpStatus . '.');
    detailObservationMessage('Respons SATUSEHAT tidak dapat dibaca sebagai JSON (HTTP ' . $httpStatus . ').', 502);
}
if ($httpStatus < 200 || $httpStatus >= 300) {
    $apiMessage = trim((string) ($observation['issue'][0]['diagnostics'] ?? ''));
    if ($apiMessage === '') {
        $apiMessage = trim((string) ($observation['issue'][0]['details']['text'] ?? ''));
    }
    if ($apiMessage === '') {
        $apiMessage = 'SATUSEHAT mengembalikan HTTP ' . $httpStatus . '.';
    }
    detailObservationMessage($apiMessage, 502);
}
if (($observation['resourceType'] ?? '') !== 'Observation') {
    detailObservationMessage('Respons SATUSEHAT bukan resource Observation.', 502);
}

$timezoneName = trim((string) ($SessionUserTimezone ?? ''));
if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
    $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
}
try {
    $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
} catch (Throwable $exception) {
    $userTimezone = new DateTimeZone('UTC');
}

$categoryDisplay = [];
foreach (($observation['category'] ?? []) as $category) {
    if (is_array($category)) {
        $text = detailObservationCodingText($category);
        if ($text !== '') {
            $categoryDisplay[] = $text;
        }
    }
}
$code = is_array($observation['code'] ?? null) ? $observation['code'] : [];
$codeDisplay = detailObservationCodingText($code);
$codeSystem = trim((string) ($code['coding'][0]['system'] ?? ''));
$subject = is_array($observation['subject'] ?? null) ? $observation['subject'] : [];
$encounter = is_array($observation['encounter'] ?? null) ? $observation['encounter'] : [];
$valueDisplay = '-';
$valueUnit = '';
$valueSystem = '';
$valueCode = '';
foreach ($observation as $valueKey => $valueData) {
    if (strpos((string) $valueKey, 'value') !== 0 || !is_array($valueData) && !is_scalar($valueData)) {
        continue;
    }
    if ($valueKey === 'valueQuantity' && is_array($valueData)) {
        $valueDisplay = trim((string) ($valueData['value'] ?? ''));
        $valueUnit = trim((string) ($valueData['unit'] ?? ''));
        $valueSystem = trim((string) ($valueData['system'] ?? ''));
        $valueCode = trim((string) ($valueData['code'] ?? ''));
        if ($valueUnit !== '') {
            $valueDisplay .= ' ' . $valueUnit;
        }
    } elseif ($valueKey === 'valueCodeableConcept' && is_array($valueData)) {
        $valueDisplay = detailObservationCodingText($valueData);
    } elseif ($valueKey === 'valueBoolean') {
        $valueDisplay = $valueData ? 'true (1)' : 'false (0)';
    } elseif (is_scalar($valueData)) {
        $valueDisplay = (string) $valueData;
    } else {
        $valueDisplay = json_encode($valueData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    break;
}

$performers = [];
foreach (($observation['performer'] ?? []) as $performer) {
    if (!is_array($performer)) {
        continue;
    }
    $performerText = trim((string) ($performer['display'] ?? ''));
    $performerReference = trim((string) ($performer['reference'] ?? ''));
    if ($performerText !== '' && $performerReference !== '') {
        $performerText .= ' (' . $performerReference . ')';
    } elseif ($performerText === '') {
        $performerText = $performerReference;
    }
    if ($performerText !== '') {
        $performers[] = $performerText;
    }
}

$effectiveDateTime = $observation['effectiveDateTime'] ?? '';
if (is_array($observation['effectivePeriod'] ?? null)) {
    $period = $observation['effectivePeriod'];
    $effectiveDateTime = trim((string) ($period['start'] ?? ''));
    if (!empty($period['end'])) {
        $effectiveDateTime .= ' — ' . trim((string) $period['end']);
    }
}
$issued = detailObservationLocalDateTime($observation['issued'] ?? '', $userTimezone);
$effectiveDisplay = trim((string) $effectiveDateTime) === ''
    ? '-'
    : (strpos((string) $effectiveDateTime, ' — ') !== false
        ? implode(' — ', array_map(static function ($part) use ($userTimezone) {
            return detailObservationLocalDateTime($part, $userTimezone);
        }, explode(' — ', (string) $effectiveDateTime)))
        : detailObservationLocalDateTime($effectiveDateTime, $userTimezone));
$payloadJson = json_encode(
    $observation,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
);
?>
<div>
    <?php echo detailObservationSection('A. Identitas Resource'); ?>
    <?php
        echo detailObservationRow('Resource', $observation['resourceType'] ?? 'Observation')
            . detailObservationRow('ID Observation', $observation['id'] ?? $observationId)
            . detailObservationRow('Status', $observation['status'] ?? '')
            . detailObservationRow('Versi', $observation['meta']['versionId'] ?? '')
            . detailObservationRow('Terakhir diperbarui', detailObservationLocalDateTime($observation['meta']['lastUpdated'] ?? '', $userTimezone));
    ?>
    <hr>

    <?php echo detailObservationSection('B. Pasien Dan Kunjungan'); ?>
    <?php
        echo detailObservationRow('Pasien', $subject['display'] ?? '')
            . detailObservationRow('Referensi pasien', $subject['reference'] ?? '')
            . detailObservationRow('Referensi kunjungan', $encounter['reference'] ?? '')
            . detailObservationRow('Kunjungan', $encounter['display'] ?? '');
    ?>
    <hr>

    <?php echo detailObservationSection('C. Informasi Observation'); ?>
    <?php
        echo detailObservationRow('Kategori', implode('; ', $categoryDisplay))
            . detailObservationRow('Kode observation', $codeDisplay)
            . detailObservationRow('System kode', $codeSystem)
            . detailObservationRow('Hasil', $valueDisplay)
            . detailObservationRow('System satuan', $valueSystem)
            . detailObservationRow('Kode satuan', $valueCode)
            . detailObservationRow('Waktu observasi', $effectiveDisplay)
            . detailObservationRow('Waktu pencatatan', $issued);
    ?>
    <hr>

    <?php echo detailObservationSection('D. Petugas Pemeriksa'); ?>
    <?php echo detailObservationRow('Performer', implode('; ', $performers)); ?>

    <?php if (!empty($observation['component']) && is_array($observation['component'])): ?>
        <hr>
        <?php echo detailObservationSection('E. Komponen Tambahan'); ?>
        <?php foreach ($observation['component'] as $index => $component): ?>
            <?php
                if (!is_array($component)) {
                    continue;
                }
                $componentCode = is_array($component['code'] ?? null) ? detailObservationCodingText($component['code']) : '';
                $componentValue = '-';
                foreach ($component as $componentKey => $componentData) {
                    if (strpos((string) $componentKey, 'value') === 0) {
                        $componentValue = is_array($componentData)
                            ? (string) (detailObservationCodingText($componentData) ?: json_encode($componentData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                            : (is_bool($componentData) ? ($componentData ? 'true' : 'false') : (string) $componentData);
                        break;
                    }
                }
                echo detailObservationRow('Komponen ' . ((int) $index + 1), $componentCode . ' — ' . $componentValue);
            ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($payloadJson !== false): ?>
        <details class="mt-3">
            <summary><small><b>Payload FHIR lengkap</b></small></summary>
            <textarea readonly class="form-control font-monospace mt-2" rows="14"><?php echo detailObservationEscape($payloadJson); ?></textarea>
        </details>
    <?php endif; ?>
</div>

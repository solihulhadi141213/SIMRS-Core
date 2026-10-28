<?php
header('Content-Type: text/html; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include __DIR__ . '/ObservationPayload.php';

function observasiKirimMessage(string $message, int $status = 200, string $type = 'danger'): void
{
    http_response_code($status);
    echo '<div class="alert alert-' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . ' mb-0">'
        . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</div>';
    exit;
}

function observasiKirimEscape($value): string
{
    return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function observasiKirimRow(string $label, $value): string
{
    $value = trim((string) ($value ?? ''));
    if ($value === '') {
        $value = '-';
    }
    return '<div class="row mb-2">'
        . '<div class="col-4"><small>' . observasiKirimEscape($label) . '</small></div>'
        . '<div class="col-1"><small>:</small></div>'
        . '<div class="col-7"><small class="text-muted">' . observasiKirimEscape($value) . '</small></div>'
        . '</div>';
}

function observasiKirimDateTime($value, DateTimeZone $timezone): ?DateTimeImmutable
{
    $value = trim((string) ($value ?? ''));
    if ($value === '') {
        return null;
    }
    try {
        return (new DateTimeImmutable($value, new DateTimeZone('UTC')))->setTimezone($timezone);
    } catch (Throwable $exception) {
        return null;
    }
}

if (empty($SessionIdAkses)) {
    observasiKirimMessage('Sesi akses berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiKirimMessage('Metode request tidak valid.', 405);
}

$idObservation = filter_var(
    $_POST['id_observation'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($idObservation === false || $idObservation === null) {
    observasiKirimMessage('ID observasi tidak valid.');
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
    observasiKirimMessage('Gagal menyiapkan data payload observasi.', 500);
}
$idObservation = (int) $idObservation;
mysqli_stmt_bind_param($stmt, 'i', $idObservation);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi SATUSEHAT: gagal mengambil data: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    observasiKirimMessage('Gagal mengambil data observasi.', 500);
}
$observation = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$observation) {
    observasiKirimMessage('Data observasi tidak ditemukan.', 404);
}

$payloadStatus = buildObservationPayload($observation);
$payloadJson = json_encode(
    $payloadStatus['payload'],
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
);
if ($payloadJson === false) {
    error_log('Observasi SATUSEHAT: gagal membuat JSON payload: ' . json_last_error_msg());
    observasiKirimMessage('Gagal menyusun JSON payload observasi.', 500);
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
$effectiveLocal = observasiKirimDateTime($observation['datetime_observation'] ?? '', $userTimezone);
$issuedLocal = observasiKirimDateTime($observation['datetime_entry'] ?? '', $userTimezone);
$isReady = $payloadStatus['ready'];
?>
<div data-observation-ready="<?php echo $isReady ? '1' : '0'; ?>">
    <div class="row mb-2"><div class="col-12"><small><b>Ringkasan Observation</b></small></div></div>
    <?php
        echo observasiKirimRow('ID Observasi', $observation['id_observation'])
            . observasiKirimRow('Pasien', ($observation['nama_pasien'] ?? '-') . ' (No. RM: ' . $observation['id_pasien'] . ')')
            . observasiKirimRow('ID Patient SATUSEHAT', $observation['patient_ihs'])
            . observasiKirimRow('ID Encounter SATUSEHAT', $observation['encounter_ihs'])
            . observasiKirimRow('ID Practitioner SATUSEHAT', $observation['practitioner_ihs'])
            . observasiKirimRow('Kategori', $observation['category_display'] ?: $observation['category_name'])
            . observasiKirimRow('Observation', $observation['observation_display'] ?: $observation['observation_name'])
            . observasiKirimRow('Hasil', $observation['observation_value'])
            . observasiKirimRow('Waktu observasi', $effectiveLocal ? $effectiveLocal->format('d/m/Y H:i T') : '-')
            . observasiKirimRow('Waktu pencatatan', $issuedLocal ? $issuedLocal->format('d/m/Y H:i T') : '');
    ?>

    <?php if ($isReady): ?>
        <div class="alert alert-success mt-3 mb-3">
            <i class="bi bi-check-circle"></i> Data lengkap dan payload layak untuk dikirim ke SATUSEHAT.
        </div>
    <?php else: ?>
        <div class="alert alert-danger mt-3 mb-3">
            <strong>Payload belum layak dikirim.</strong>
            <ul class="mb-0 mt-2">
                <?php foreach ($payloadStatus['missing'] as $item): ?>
                    <li><?php echo observasiKirimEscape($item); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row mb-2">
        <div class="col-12"><label for="payload_observation_preview"><small><b>Payload FHIR Observation (waktu UTC)</b></small></label></div>
        <div class="col-12">
            <textarea readonly id="payload_observation_preview" class="form-control font-monospace" rows="18"><?php echo observasiKirimEscape($payloadJson); ?></textarea>
        </div>
    </div>
</div>

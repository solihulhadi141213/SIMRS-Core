<?php
header('Content-Type: text/html; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiHapusFormMessage(string $message, int $status = 200): void
{
    http_response_code($status);
    echo '<div class="alert alert-danger mb-0">'
        . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</div>';
    exit;
}

function observasiHapusFormEscape($value): string
{
    return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function observasiHapusFormRow(string $label, $value): string
{
    $value = trim((string) ($value ?? ''));
    if ($value === '') {
        $value = '-';
    }
    return '<div class="row mb-2">'
        . '<div class="col-4"><small>' . observasiHapusFormEscape($label) . '</small></div>'
        . '<div class="col-1"><small>:</small></div>'
        . '<div class="col-7"><small class="text-muted">' . observasiHapusFormEscape($value) . '</small></div>'
        . '</div>';
}

if (empty($SessionIdAkses)) {
    observasiHapusFormMessage('Sesi akses berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiHapusFormMessage('Metode request tidak valid.', 405);
}

$idObservation = filter_var(
    $_POST['id_observation'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($idObservation === false || $idObservation === null) {
    observasiHapusFormMessage('ID observasi tidak valid.');
}

$stmt = mysqli_prepare(
    $Conn,
    'SELECT
        o.id_observation,
        o.id_pasien,
        o.id_kunjungan,
        o.id_praktisi,
        o.nama_praktisi,
        o.observation_value,
        o.datetime_observation,
        p.nama AS nama_pasien,
        k.jenis_kunjungan,
        r.category_name,
        r.observation_name,
        r.unit_name,
        r.result_type,
        r.result_coded
     FROM observation o
     LEFT JOIN pasien p ON p.id_pasien = o.id_pasien
     LEFT JOIN kunjungan k ON k.id_kunjungan = o.id_kunjungan
     LEFT JOIN observation_reference r ON r.id_observation_reference = o.id_observation_reference
     WHERE o.id_observation = ?
     LIMIT 1'
);
if (!$stmt) {
    error_log('Observasi hapus: gagal menyiapkan query preview: ' . mysqli_error($Conn));
    observasiHapusFormMessage('Gagal menyiapkan preview data observasi.', 500);
}
$idObservation = (int) $idObservation;
mysqli_stmt_bind_param($stmt, 'i', $idObservation);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi hapus: gagal mengambil preview: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    observasiHapusFormMessage('Gagal mengambil data observasi.', 500);
}
$observation = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$observation) {
    observasiHapusFormMessage('Data observasi tidak ditemukan.', 404);
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
$storedObservationDateTime = trim((string) ($observation['datetime_observation'] ?? ''));
try {
    if ($storedObservationDateTime === '') {
        throw new RuntimeException('Waktu observasi tidak tersedia.');
    }
    $observationDateTime = (new DateTimeImmutable(
        $storedObservationDateTime,
        new DateTimeZone('UTC')
    ))->setTimezone($userTimezone)->format('d/m/Y H:i T');
} catch (Throwable $exception) {
    $observationDateTime = '-';
}

$valueDisplay = (string) $observation['observation_value'];
if ($observation['result_type'] === 'Coded') {
    $codedOptions = json_decode((string) ($observation['result_coded'] ?? ''), true);
    if (is_array($codedOptions)) {
        foreach ($codedOptions as $option) {
            if (is_array($option) && (string) ($option['value'] ?? '') === $valueDisplay) {
                $valueDisplay = (string) ($option['label'] ?? $valueDisplay);
                break;
            }
        }
    }
} elseif ($observation['result_type'] === 'Boolean' && in_array($valueDisplay, ['0', '1'], true)) {
    $valueDisplay = $valueDisplay === '1' ? '1 (Ya)' : '0 (Tidak)';
}
if (!empty($observation['unit_name'])) {
    $valueDisplay .= ' ' . $observation['unit_name'];
}
?>
<div class="row mb-2"><div class="col-12"><small><b>Preview Data Observasi</b></small></div></div>
<?php
echo observasiHapusFormRow('No. RM', $observation['id_pasien'])
    . observasiHapusFormRow('Nama pasien', $observation['nama_pasien'])
    . observasiHapusFormRow('ID kunjungan', $observation['id_kunjungan'])
    . observasiHapusFormRow('Jenis kunjungan', $observation['jenis_kunjungan'])
    . observasiHapusFormRow('Kategori / observasi', $observation['category_name'] . ' / ' . $observation['observation_name'])
    . observasiHapusFormRow('Hasil', $valueDisplay)
    . observasiHapusFormRow('Waktu observasi', $observationDateTime)
    . observasiHapusFormRow('Praktisi', $observation['nama_praktisi']);
?>
<div class="alert alert-danger mt-3 mb-0">
    <p class="mb-2"><strong>Apakah Anda yakin akan menghapus data observasi ini?</strong> Data yang dihapus tidak dapat dikembalikan.</p>
    <hr>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="pernyataan_petugas_penghapus" name="pernyataan_petugas_penghapus" value="1">
        <label class="form-check-label" for="pernyataan_petugas_penghapus">
            <small>Saya telah memeriksa data observasi di atas dan menyetujui penghapusannya.</small>
        </label>
    </div>
</div>

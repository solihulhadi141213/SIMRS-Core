<?php
header('Content-Type: text/html; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiEditFormMessage(string $message, int $status = 200): void
{
    http_response_code($status);
    echo '<div class="alert alert-danger mb-0">'
        . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</div>';
    exit;
}

if (empty($SessionIdAkses)) {
    observasiEditFormMessage('Sesi akses berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiEditFormMessage('Metode request tidak valid.', 405);
}

$idObservation = filter_var(
    $_POST['id_observation'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($idObservation === false || $idObservation === null) {
    observasiEditFormMessage('ID observasi tidak valid.');
}

$stmt = mysqli_prepare(
    $Conn,
    'SELECT
        o.id_observation,
        o.id_pasien,
        o.id_kunjungan,
        o.id_praktisi,
        o.id_observation_reference,
        o.observation_value,
        o.datetime_observation,
        p.nama AS nama_pasien,
        k.jenis_kunjungan,
        k.datetime_daftar,
        pr.nama_praktisi,
        r.category_name,
        r.observation_name,
        r.unit_name
     FROM observation o
     LEFT JOIN pasien p ON p.id_pasien = o.id_pasien
     LEFT JOIN kunjungan k ON k.id_kunjungan = o.id_kunjungan
     LEFT JOIN praktisi pr ON pr.id_praktisi = o.id_praktisi
     LEFT JOIN observation_reference r ON r.id_observation_reference = o.id_observation_reference
     WHERE o.id_observation = ?
     LIMIT 1'
);
if (!$stmt) {
    error_log('Observasi edit: gagal menyiapkan query form: ' . mysqli_error($Conn));
    observasiEditFormMessage('Gagal menyiapkan form edit observasi.', 500);
}
$idObservation = (int) $idObservation;
mysqli_stmt_bind_param($stmt, 'i', $idObservation);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi edit: gagal mengambil data form: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    observasiEditFormMessage('Gagal mengambil data observasi.', 500);
}
$observation = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$observation) {
    observasiEditFormMessage('Data observasi tidak ditemukan.', 404);
}

$escape = static function ($value): string {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
};

$timezoneName = trim((string) ($SessionUserTimezone ?? ''));
if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
    $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
}
try {
    $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
} catch (Throwable $exception) {
    $userTimezone = new DateTimeZone('UTC');
}
try {
    $storedObservationDateTime = trim((string) ($observation['datetime_observation'] ?? ''));
    if ($storedObservationDateTime === '') {
        throw new RuntimeException('Tanggal observasi tidak tersedia.');
    }
    $localObservationDateTime = (new DateTimeImmutable(
        $storedObservationDateTime,
        new DateTimeZone('UTC')
    ))->setTimezone($userTimezone);
    $observationDate = $localObservationDateTime->format('Y-m-d');
    $observationTime = $localObservationDateTime->format('H:i');
} catch (Throwable $exception) {
    $observationDate = '';
    $observationTime = '';
}

$visitDate = '-';
if (!empty($observation['datetime_daftar'])) {
    try {
        $visitDate = (new DateTimeImmutable((string) $observation['datetime_daftar']))->format('d-m-Y H:i');
    } catch (Throwable $exception) {
        $visitDate = (string) $observation['datetime_daftar'];
    }
}
$visitText = $visitDate . ' | ' . (string) ($observation['jenis_kunjungan'] ?? '-');
$practitionerText = trim((string) ($observation['nama_praktisi'] ?? ''));
if ($practitionerText === '') {
    $practitionerText = 'Praktisi ID ' . (int) $observation['id_praktisi'];
}
$referenceText = (string) $observation['observation_name'];
if (!empty($observation['unit_name'])) {
    $referenceText .= ' (' . $observation['unit_name'] . ')';
}
?>
<input type="hidden" id="edit_initial_reference_id" value="<?php echo (int) $observation['id_observation_reference']; ?>">
<input type="hidden" id="edit_initial_observation_value" value="<?php echo $escape($observation['observation_value']); ?>">

<div class="row mb-2"><div class="col-12"><small><b>A. Informasi Pasien &amp; Kunjungan</b></small></div></div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_id_pasien"><small>* No. RM / Nama Pasien</small></label></div>
    <div class="col-md-8" id="FormEditIdPasien">
        <select required name="id_pasien" id="edit_id_pasien" class="form-control">
            <option value=""></option>
            <option value="<?php echo (int) $observation['id_pasien']; ?>" selected><?php echo $escape($observation['nama_pasien'] . ' (No. RM: ' . $observation['id_pasien'] . ')'); ?></option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_id_kunjungan"><small>* Kunjungan</small></label></div>
    <div class="col-md-8" id="FormEditIdKunjungan">
        <select required name="id_kunjungan" id="edit_id_kunjungan" class="form-control">
            <option value=""></option>
            <option value="<?php echo (int) $observation['id_kunjungan']; ?>" selected><?php echo $escape($visitText); ?></option>
        </select>
    </div>
</div>

<hr>
<div class="row mb-2"><div class="col-12"><small><b>B. Petugas Pemeriksa</b></small></div></div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_id_praktisi"><small>* Nama Petugas</small></label></div>
    <div class="col-md-8" id="FormEditIdPraktisi">
        <select required name="id_praktisi" id="edit_id_praktisi" class="form-control">
            <option value=""></option>
            <option value="<?php echo (int) $observation['id_praktisi']; ?>" selected><?php echo $escape($practitionerText); ?></option>
        </select>
    </div>
</div>

<hr>
<div class="row mb-2"><div class="col-12"><small><b>C. Referensi Observasi</b></small></div></div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_category_name"><small>* Kategori Observasi</small></label></div>
    <div class="col-md-8" id="FormEditCategoryName">
        <select required name="category_name" id="edit_category_name" class="form-control">
            <option value=""></option>
            <option value="<?php echo $escape($observation['category_name']); ?>" selected><?php echo $escape($observation['category_name']); ?></option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_id_observation_reference"><small>* Jenis Observasi</small></label></div>
    <div class="col-md-8" id="FormEditObservationReference">
        <select required name="id_observation_reference" id="edit_id_observation_reference" class="form-control">
            <option value=""></option>
            <option value="<?php echo (int) $observation['id_observation_reference']; ?>" selected><?php echo $escape($referenceText); ?></option>
        </select>
    </div>
</div>

<hr>
<div class="row mb-2"><div class="col-12"><small><b>D. Hasil / Nilai</b></small></div></div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_observation_value"><small>* Nilai / Hasil</small></label></div>
    <div class="col-md-8" id="FormEditObservationValue">
        <small class="text-muted">Memuat form hasil...</small>
    </div>
</div>

<hr>
<div class="row mb-2"><div class="col-12"><small><b>E. Waktu Observasi</b></small></div></div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_tanggal_observasi"><small>* Tanggal Observasi</small></label></div>
    <div class="col-md-8"><input type="date" required name="tanggal_observasi" id="edit_tanggal_observasi" class="form-control" value="<?php echo $escape($observationDate); ?>"></div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><label for="edit_jam_observasi"><small>* Jam Observasi</small></label></div>
    <div class="col-md-8"><input type="time" required name="jam_observasi" id="edit_jam_observasi" class="form-control" value="<?php echo $escape($observationTime); ?>"></div>
</div>

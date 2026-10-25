<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi login tidak valid.']);
    exit;
}

$period = $_POST['periode'] ?? 'Tahunan';
$currentYear = (int) gmdate('Y');
$yearInput = filter_var($_POST['tahun'] ?? $currentYear, FILTER_VALIDATE_INT);
$year = $yearInput === false ? 0 : (int) $yearInput;
$monthInput = filter_var($_POST['bulan'] ?? gmdate('n'), FILTER_VALIDATE_INT);
$month = $monthInput === false ? 0 : (int) $monthInput;

if (!in_array($period, ['Tahunan', 'Bulanan'], true) || $year < 1900 || $year > 2100 || ($period === 'Bulanan' && ($month < 1 || $month > 12))) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Periode grafik tidak valid.']);
    exit;
}

$utc = new DateTimeZone('UTC');
if ($period === 'Tahunan') {
    $start = new DateTimeImmutable(sprintf('%04d-01-01 00:00:00', $year), $utc);
    $end = $start->modify('+1 year');
    $bucketCount = 12;
    $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
} else {
    $start = new DateTimeImmutable(sprintf('%04d-%02d-01 00:00:00', $year, $month), $utc);
    $end = $start->modify('+1 month');
    $bucketCount = (int) $start->format('t');
    $labels = range(1, $bucketCount);
}

$data = array_fill(0, $bucketCount, 0);
try {
    $stmt = mysqli_prepare(
        $Conn,
        'SELECT ' . ($period === 'Tahunan' ? 'MONTH(datetime_daftar)' : 'DAY(datetime_daftar)') . ' AS bucket, COUNT(*) AS jumlah
         FROM kunjungan
         WHERE datetime_daftar >= ? AND datetime_daftar < ?
         GROUP BY bucket
         ORDER BY bucket'
    );
} catch (mysqli_sql_exception $exception) {
    error_log('Dashboard visit chart prepare failed: ' . $exception->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Grafik kunjungan gagal dimuat.']);
    exit;
}

if (!$stmt) {
    error_log('Dashboard visit chart prepare failed: ' . mysqli_error($Conn));
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Grafik kunjungan gagal dimuat.']);
    exit;
}

$startValue = $start->format('Y-m-d H:i:s');
$endValue = $end->format('Y-m-d H:i:s');
$queryResult = false;
try {
    mysqli_stmt_bind_param($stmt, 'ss', $startValue, $endValue);
    $queryResult = mysqli_stmt_execute($stmt);
    if ($queryResult) {
        $result = mysqli_stmt_get_result($stmt);
    }
} catch (mysqli_sql_exception $exception) {
    error_log('Dashboard visit chart query failed: ' . $exception->getMessage());
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Grafik kunjungan gagal dimuat.']);
    exit;
}

if (!$queryResult) {
    error_log('Dashboard visit chart query failed: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Grafik kunjungan gagal dimuat.']);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $data[(int) $row['bucket'] - 1] = (int) $row['jumlah'];
}
mysqli_stmt_close($stmt);

echo json_encode([
    'status' => 'success',
    'periode' => $period,
    'tahun' => $year,
    'bulan' => $period === 'Bulanan' ? $month : null,
    'kategori' => $labels,
    'data' => $data,
]);

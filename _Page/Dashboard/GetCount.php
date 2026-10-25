<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi login tidak valid.']);
    exit;
}

$query = "
    SELECT
        (SELECT COUNT(*) FROM dokter WHERE status = 1) AS dokter,
        (SELECT COUNT(*) FROM poliklinik WHERE status = 1) AS poliklinik,
        (SELECT COUNT(*) FROM rr_tempat_tidur WHERE status = 1) AS bed_total,
        (SELECT COUNT(*) FROM pasien) AS pasien
";
try {
    $result = mysqli_query($Conn, $query);
} catch (mysqli_sql_exception $exception) {
    error_log('Dashboard count query failed: ' . $exception->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Jumlah data dashboard gagal dimuat.']);
    exit;
}

if (!$result) {
    error_log('Dashboard count query failed: ' . mysqli_error($Conn));
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Jumlah data dashboard gagal dimuat.']);
    exit;
}

$counts = mysqli_fetch_assoc($result);
echo json_encode([
    'status' => 'success',
    'dokter' => (int) $counts['dokter'],
    'poliklinik' => (int) $counts['poliklinik'],
    'bed_total' => (int) $counts['bed_total'],
    'pasien' => (int) $counts['pasien'],
]);

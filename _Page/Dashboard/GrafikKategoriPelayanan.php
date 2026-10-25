<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi login tidak valid.']);
    exit;
}

try {
    $result = mysqli_query(
        $Conn,
        "SELECT
            COALESCE(SUM(jenis_kunjungan = 'Rajal'), 0) AS rajal,
            COALESCE(SUM(jenis_kunjungan = 'Ranap'), 0) AS ranap
         FROM kunjungan"
    );
} catch (mysqli_sql_exception $exception) {
    error_log('Dashboard service category query failed: ' . $exception->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Kategori pelayanan gagal dimuat.']);
    exit;
}

if (!$result) {
    error_log('Dashboard service category query failed: ' . mysqli_error($Conn));
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Kategori pelayanan gagal dimuat.']);
    exit;
}

$counts = mysqli_fetch_assoc($result);
echo json_encode([
    'status' => 'success',
    'labels' => ['Rajal', 'Ranap'],
    'series' => [(int) $counts['rajal'], (int) $counts['ranap']],
]);
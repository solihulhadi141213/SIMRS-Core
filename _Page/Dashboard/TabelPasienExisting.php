<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi login tidak valid.']);
    exit;
}

$offsetInput = filter_var($_GET['offset'] ?? 0, FILTER_VALIDATE_INT);
if ($offsetInput === false || $offsetInput < 0 || $offsetInput > 1000000) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Posisi data tidak valid.']);
    exit;
}

$limit = 20;
$fetchLimit = $limit + 1;
try {
    $stmt = mysqli_prepare(
        $Conn,
        "SELECT k.id_kunjungan, k.id_pasien, p.nama, k.jenis_kunjungan, k.datetime_daftar
         FROM kunjungan AS k
         INNER JOIN pasien AS p ON p.id_pasien = k.id_pasien
         WHERE k.status = 'Terdaftar'
         ORDER BY k.datetime_daftar DESC, k.id_kunjungan DESC
         LIMIT ? OFFSET ?"
    );
} catch (mysqli_sql_exception $exception) {
    error_log('Dashboard existing patient prepare failed: ' . $exception->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Daftar pasien gagal dimuat.']);
    exit;
}

if (!$stmt) {
    error_log('Dashboard existing patient prepare failed: ' . mysqli_error($Conn));
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Daftar pasien gagal dimuat.']);
    exit;
}

try {
    mysqli_stmt_bind_param($stmt, 'ii', $fetchLimit, $offsetInput);
    $executed = mysqli_stmt_execute($stmt);
    if ($executed) {
        $result = mysqli_stmt_get_result($stmt);
    }
} catch (mysqli_sql_exception $exception) {
    error_log('Dashboard existing patient query failed: ' . $exception->getMessage());
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Daftar pasien gagal dimuat.']);
    exit;
}

if (!$executed) {
    error_log('Dashboard existing patient query failed: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Daftar pasien gagal dimuat.']);
    exit;
}
$visits = [];
while ($row = mysqli_fetch_assoc($result)) {
    $visits[] = [
        'id_pasien' => (int) $row['id_pasien'],
        'nama' => $row['nama'],
        'jenis_kunjungan' => $row['jenis_kunjungan'],
        'datetime_daftar' => $row['datetime_daftar'],
    ];
}
mysqli_stmt_close($stmt);

$hasMore = count($visits) > $limit;
if ($hasMore) {
    array_pop($visits);
}

echo json_encode([
    'status' => 'success',
    'data' => $visits,
    'hasMore' => $hasMore,
    'nextOffset' => $offsetInput + count($visits),
]);

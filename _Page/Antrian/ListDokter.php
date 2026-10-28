<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function listAntrianDokterResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

if (empty($SessionIdAkses)) {
    listAntrianDokterResponse(['error' => 'Sesi berakhir. Silakan login kembali.'], 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    listAntrianDokterResponse(['error' => 'Metode request tidak valid.'], 405);
}

$idPoliklinik = filter_var($_GET['id_poliklinik'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($idPoliklinik === false || $idPoliklinik === null) {
    listAntrianDokterResponse(['results' => [], 'pagination' => ['more' => false]]);
}
$term = $_GET['term'] ?? '';
$keyword = is_scalar($term) ? trim((string) $term) : '';
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$page = $page === false || $page === null ? 1 : min((int) $page, 100000);
$pageSize = 20;
$offset = ($page - 1) * $pageSize;
$search = '%' . $keyword . '%';
$fetchLimit = $pageSize + 1;

$stmt = mysqli_prepare(
    $Conn,
    "SELECT DISTINCT d.id_dokter, d.kode, d.nama
     FROM jadwal_dokter jd
     INNER JOIN dokter d ON d.id_dokter = jd.id_dokter
     INNER JOIN poliklinik p ON p.id_poliklinik = jd.id_poliklinik
     WHERE jd.id_poliklinik = ?
       AND jd.status <> 0 AND d.status = 1 AND p.status = 1
       AND (? = '' OR d.nama LIKE ? OR d.kode LIKE ? OR CAST(d.id_dokter AS CHAR) LIKE ?)
     ORDER BY d.nama ASC, d.id_dokter ASC
     LIMIT ? OFFSET ?"
);
if (!$stmt) {
    error_log('Daftar dokter antrean: gagal menyiapkan query: ' . mysqli_error($Conn));
    listAntrianDokterResponse(['error' => 'Gagal menyiapkan pencarian dokter.'], 500);
}
mysqli_stmt_bind_param($stmt, 'issssii', $idPoliklinik, $keyword, $search, $search, $search, $fetchLimit, $offset);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Daftar dokter antrean: gagal menjalankan query: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    listAntrianDokterResponse(['error' => 'Gagal mencari data dokter.'], 500);
}

$result = mysqli_stmt_get_result($stmt);
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = [
        'id' => (string) $row['id_dokter'],
        'text' => (string) $row['nama'],
        'kode' => (string) ($row['kode'] ?? ''),
        'nama' => (string) $row['nama'],
    ];
}
mysqli_stmt_close($stmt);

$hasMore = count($items) > $pageSize;
if ($hasMore) {
    array_pop($items);
}

listAntrianDokterResponse([
    'results' => $items,
    'pagination' => ['more' => $hasMore],
]);
?>

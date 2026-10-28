<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function listAntrianPoliklinikResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

if (empty($SessionIdAkses)) {
    listAntrianPoliklinikResponse(['error' => 'Sesi berakhir. Silakan login kembali.'], 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    listAntrianPoliklinikResponse(['error' => 'Metode request tidak valid.'], 405);
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
    "SELECT id_poliklinik, kode, poliklinik
     FROM poliklinik
     WHERE status = 1
       AND (? = '' OR poliklinik LIKE ? OR kode LIKE ? OR CAST(id_poliklinik AS CHAR) LIKE ?)
     ORDER BY poliklinik ASC, id_poliklinik ASC
     LIMIT ? OFFSET ?"
);
if (!$stmt) {
    error_log('Daftar poliklinik antrean: gagal menyiapkan query: ' . mysqli_error($Conn));
    listAntrianPoliklinikResponse(['error' => 'Gagal menyiapkan pencarian poliklinik.'], 500);
}
mysqli_stmt_bind_param($stmt, 'ssssii', $keyword, $search, $search, $search, $fetchLimit, $offset);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Daftar poliklinik antrean: gagal menjalankan query: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    listAntrianPoliklinikResponse(['error' => 'Gagal mencari data poliklinik.'], 500);
}

$result = mysqli_stmt_get_result($stmt);
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = [
        'id' => (string) $row['id_poliklinik'],
        'text' => (string) $row['poliklinik'],
        'kode' => (string) ($row['kode'] ?? ''),
        'nama' => (string) $row['poliklinik'],
    ];
}
mysqli_stmt_close($stmt);

$hasMore = count($items) > $pageSize;
if ($hasMore) {
    array_pop($items);
}

listAntrianPoliklinikResponse([
    'results' => $items,
    'pagination' => ['more' => $hasMore],
]);
?>

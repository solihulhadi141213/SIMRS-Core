<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function listPasienResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

if (empty($SessionIdAkses)) {
    listPasienResponse(['error' => 'Sesi berakhir. Silakan login kembali.'], 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    listPasienResponse(['error' => 'Metode request tidak valid.'], 405);
}

$term = $_GET['term'] ?? '';
$keyword = is_scalar($term) ? trim((string) $term) : '';
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($page === false || $page === null) {
    $page = 1;
}
$page = min((int) $page, 100000);
$pageSize = 20;
$offset = ($page - 1) * $pageSize;
$search = '%' . $keyword . '%';

// Fetch one extra row so Select2 can determine whether another page is available.
$stmt = mysqli_prepare(
    $Conn,
    "SELECT id_pasien, nama, nik, no_bpjs, gender, kontak
     FROM pasien
     WHERE status = 'Active'
       AND (? = '' OR nama LIKE ? OR nik LIKE ? OR CAST(id_pasien AS CHAR) LIKE ?)
     ORDER BY nama ASC, id_pasien ASC
     LIMIT ? OFFSET ?"
);
if (!$stmt) {
    error_log('Daftar pasien antrean: gagal menyiapkan query: ' . mysqli_error($Conn));
    listPasienResponse(['error' => 'Gagal menyiapkan pencarian pasien.'], 500);
}
$fetchLimit = $pageSize + 1;
mysqli_stmt_bind_param($stmt, 'ssssii', $keyword, $search, $search, $search, $fetchLimit, $offset);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Daftar pasien antrean: gagal menjalankan query: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    listPasienResponse(['error' => 'Gagal mencari data pasien.'], 500);
}

$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    error_log('Daftar pasien antrean: gagal membaca hasil query: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    listPasienResponse(['error' => 'Gagal membaca data pasien.'], 500);
}
$patients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $idPasien = (string) $row['id_pasien'];
    $nama = (string) $row['nama'];
    $patients[] = [
        // Select2 uses `id` as the option value; it is the patient's id_pasien.
        'id' => $idPasien,
        'id_pasien' => $idPasien,
        'text' => 'No. RM ' . $idPasien . ' — ' . $nama,
        'nama' => $nama,
        'nik' => (string) ($row['nik'] ?? ''),
        'no_bpjs' => (string) ($row['no_bpjs'] ?? ''),
        'gender' => (string) ($row['gender'] ?? ''),
        'kontak' => (string) ($row['kontak'] ?? ''),
    ];
}
mysqli_stmt_close($stmt);

$hasMore = count($patients) > $pageSize;
if ($hasMore) {
    array_pop($patients);
}

listPasienResponse([
    'results' => $patients,
    'pagination' => ['more' => $hasMore],
]);

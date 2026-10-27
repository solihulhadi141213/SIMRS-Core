<?php
// Menyediakan hasil pencarian pasien aktif dalam format untuk Select2.
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['error' => 'Sesi berakhir. Silakan login kembali.']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Metode request tidak valid.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$keyword = trim((string) ($_GET['term'] ?? ''));
$search = '%' . $keyword . '%';
// Cari berdasarkan nama, NIK, atau nomor rekam medis; hasil dibatasi agar ringan.
$stmt = mysqli_prepare(
    $Conn,
    "SELECT id_pasien, nama, nik, no_bpjs, gender, kontak
     FROM pasien
     WHERE status = 'Active'
       AND (? = '' OR nama LIKE ? OR nik LIKE ? OR CAST(id_pasien AS CHAR) LIKE ?)
     ORDER BY nama ASC
     LIMIT 20"
);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menyiapkan pencarian pasien.']);
    exit;
}
mysqli_stmt_bind_param($stmt, 'ssss', $keyword, $search, $search, $search);
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mencari data pasien.']);
    exit;
}

// Susun data hasil menjadi properti yang dipakai form antrean.
$result = mysqli_stmt_get_result($stmt);
$patients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $patients[] = [
        'id' => (int) $row['id_pasien'],
        'text' => $row['id_pasien'] . ' | ' . $row['nama'] . ' | NIK ' . ($row['nik'] ?: '-'),
        'nama' => $row['nama'],
        'nik' => $row['nik'],
        'no_bpjs' => $row['no_bpjs'],
        'gender' => $row['gender'],
        'kontak' => $row['kontak'],
    ];
}
mysqli_stmt_close($stmt);
echo json_encode(['results' => $patients], JSON_UNESCAPED_UNICODE);
?>

<?php
// Menyediakan pilihan jadwal aktif sesuai poliklinik dan tanggal yang dipilih.
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

// Batasi pencarian jadwal untuk sesi aktif dan request GET.
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

$idPoliklinik = (int) ($_GET['id_poliklinik'] ?? 0);
$tanggal = trim((string) ($_GET['tanggal_kunjungan'] ?? ''));
$selectedSchedule = (int) ($_GET['selected_id'] ?? 0);
$date = DateTime::createFromFormat('!Y-m-d', $tanggal);
// Tanggal yang valid diperlukan untuk menentukan hari praktik dokter.
if (!$idPoliklinik || !$date || $date->format('Y-m-d') !== $tanggal) {
    echo json_encode(['results' => []], JSON_UNESCAPED_UNICODE);
    exit;
}

$dayNames = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu',
];
$day = $dayNames[$date->format('l')];
// Untuk proses edit, jadwal tersimpan tetap disertakan meskipun kini tidak aktif.
$stmt = mysqli_prepare(
    $Conn,
    "SELECT
        jd.id_jadwal, jd.id_dokter, jd.hari, jd.jam_mulai, jd.jam_selesai,
        d.nama AS nama_dokter
     FROM jadwal_dokter jd
     INNER JOIN dokter d ON d.id_dokter = jd.id_dokter
     INNER JOIN poliklinik p ON p.id_poliklinik = jd.id_poliklinik
     WHERE jd.id_poliklinik = ?
       AND jd.hari = ?
       AND ((jd.status = 1 AND d.status = 1 AND p.status = 1)
            OR (jd.id_jadwal = ? AND jd.id_poliklinik = ?))
     ORDER BY jd.jam_mulai ASC, d.nama ASC"
);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menyiapkan daftar jadwal dokter.']);
    exit;
}
mysqli_stmt_bind_param($stmt, 'isii', $idPoliklinik, $day, $selectedSchedule, $idPoliklinik);
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil jadwal dokter.']);
    exit;
}

// Ubah hasil query menjadi struktur yang dibaca Select2.
$result = mysqli_stmt_get_result($stmt);
$schedules = [];
while ($row = mysqli_fetch_assoc($result)) {
    $schedules[] = [
        'id' => (int) $row['id_jadwal'],
        'text' => $row['nama_dokter'] . ' | ' . substr($row['jam_mulai'], 0, 5) . ' - ' . substr($row['jam_selesai'], 0, 5),
        'id_dokter' => (int) $row['id_dokter'],
        'nama_dokter' => $row['nama_dokter'],
        'hari' => $row['hari'],
        'jam_mulai' => $row['jam_mulai'],
        'jam_selesai' => $row['jam_selesai'],
    ];
}
mysqli_stmt_close($stmt);
echo json_encode(['results' => $schedules], JSON_UNESCAPED_UNICODE);
?>

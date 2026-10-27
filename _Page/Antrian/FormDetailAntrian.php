<?php
// Menyiapkan data antrean dan riwayat status untuk ditampilkan pada modal detail.
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

// Validasi sesi, metode request, dan ID sebelum membaca data.
if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo '<div class="alert alert-danger">Sesi berakhir. Silakan login kembali.</div>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
    exit;
}
$idAntrian = (int) ($_POST['id_antrian'] ?? 0);
if (!$idAntrian) {
    http_response_code(400);
    echo '<div class="alert alert-danger">ID antrian tidak valid.</div>';
    exit;
}

// Ambil antrean beserta informasi rekam medis, kunjungan, poliklinik, dokter, dan jadwal.
$stmt = mysqli_prepare(
    $Conn,
    "SELECT a.*, p.id_pasien AS pasien_terdaftar, k.id_kunjungan AS kunjungan_terdaftar,
            poli.id_poliklinik AS poliklinik_terdaftar, d.id_dokter AS dokter_terdaftar,
            jd.jam_mulai, jd.jam_selesai
     FROM antrian a
     LEFT JOIN pasien p ON p.id_pasien = a.id_pasien
     LEFT JOIN kunjungan k ON k.id_kunjungan = a.id_kunjungan
     LEFT JOIN poliklinik poli ON poli.id_poliklinik = a.id_poliklinik
     LEFT JOIN dokter d ON d.id_dokter = a.id_dokter
     LEFT JOIN jadwal_dokter jd ON jd.id_jadwal = a.id_jadwal
     WHERE a.id_antrian = ?
     LIMIT 1"
);
if (!$stmt) {
    http_response_code(500);
    echo '<div class="alert alert-danger">Gagal menyiapkan detail antrian.</div>';
    exit;
}
mysqli_stmt_bind_param($stmt, 'i', $idAntrian);
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo '<div class="alert alert-danger">Gagal mengambil detail antrian.</div>';
    exit;
}
$result = mysqli_stmt_get_result($stmt);
$queue = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if (!$queue) {
    http_response_code(404);
    echo '<div class="alert alert-warning">Data antrian tidak ditemukan.</div>';
    exit;
}

// Siapkan nilai waktu, label status, dan helper escaping untuk keluaran HTML.
$escape = static fn($value): string => htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
$createdUtc = str_replace(' ', 'T', (string) $queue['datetime_creat']) . 'Z';
$schedule = !empty($queue['jam_mulai'])
    ? substr($queue['jam_mulai'], 0, 5) . ' - ' . substr($queue['jam_selesai'], 0, 5)
    : '-';
$statusColors = [
    'Terdaftar' => 'warning',
    'Batal' => 'danger',
    'Checkin' => 'primary',
    'Panggil Admisi' => 'info',
    'Tunggu Poli' => 'secondary',
    'Layanan Poli' => 'primary',
    'Tunggu Farmasi' => 'secondary',
    'Layanan Farmasi' => 'primary',
    'Selesai' => 'success',
];
$statusColor = $statusColors[$queue['status_antrian']] ?? 'dark';
// Ambil riwayat perubahan status secara berurutan untuk bagian riwayat pelayanan.
$stmtLog = mysqli_prepare(
    $Conn,
    "SELECT status_antrian, datetime_rs, datetime_bpjs
     FROM antrian_log
     WHERE id_antrian = ?
     ORDER BY datetime_rs ASC, id_antrian_log ASC"
);
$logs = [];
$logError = !$stmtLog;
if ($stmtLog) {
    mysqli_stmt_bind_param($stmtLog, 'i', $idAntrian);
    if (mysqli_stmt_execute($stmtLog)) {
        $logResult = mysqli_stmt_get_result($stmtLog);
        while ($log = mysqli_fetch_assoc($logResult)) {
            $logs[] = $log;
        }
    } else {
        $logError = true;
        error_log('Antrian detail: gagal memuat riwayat: ' . mysqli_stmt_error($stmtLog));
    }
    mysqli_stmt_close($stmtLog);
} else {
    error_log('Antrian detail: gagal menyiapkan riwayat: ' . mysqli_error($Conn));
}
?>
<!-- Bagian A menampilkan identitas pasien yang tercatat pada antrean. -->
<div class="row mb-2">
    <div class="col-12"><b><small>A. Identitas Pasien</small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nama Pasien</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['nama_pasien']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor RM</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo !empty($queue['id_pasien']) ? (int) $queue['id_pasien'] : 'Belum terdaftar'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Jenis Kelamin</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['gender']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>NIK</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['nik']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>No. BPJS</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['no_bpjs']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kontak</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['kontak']); ?></small></div>
</div>
<hr>

<!-- Bagian B merangkum nomor, waktu, status, dan pembayaran antrean. -->
<div class="row mb-2">
    <div class="col-12"><b><small>B. Informasi Antrian</small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor Antrian</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo (int) $queue['no_antrian']; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kode Booking</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted font-monospace text-break"><?php echo $escape($queue['kode_booking']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Tanggal Daftar</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><time class="js-date-time" data-utc="<?php echo $escape($createdUtc); ?>">-</time></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Rencana Kunjungan</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><time class="js-local-date" data-date="<?php echo $escape($queue['tanggal_kunjungan']); ?>">-</time></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Status</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><span class="badge text-bg-<?php echo $statusColor; ?>"><?php echo $escape($queue['status_antrian']); ?></span></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Sumber</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['sumber_antrian']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Pembayaran</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['pembayaran']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>ID Kunjungan</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo !empty($queue['id_kunjungan']) ? (int) $queue['id_kunjungan'] : 'Belum dibuat'; ?></small></div>
</div>
<hr>

<!-- Bagian C menunjukkan tujuan pelayanan dan keluhan pasien. -->
<div class="row mb-2">
    <div class="col-12"><b><small>C. Tujuan Pelayanan</small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Poliklinik</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['nama_poliklinik']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Dokter</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['nama_dokter']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Jadwal</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($schedule); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor Referensi</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($queue['nomor_referensi']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Keluhan</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted text-break"><?php echo nl2br($escape($queue['keluhan'])); ?></small></div>
</div>
<hr>

<!-- Bagian D menampilkan riwayat perubahan status atau pesan jika riwayat gagal dimuat. -->
<div class="row mb-2">
    <div class="col-12"><b><small>D. Riwayat Pelayanan</small></b></div>
</div>
<?php if ($logError): ?>
    <div class="row mb-2">
        <div class="col-12"><small class="text-danger">Riwayat status gagal dimuat. Silakan coba kembali.</small></div>
    </div>
<?php elseif (!$logs): ?>
    <div class="row mb-2">
        <div class="col-12"><small class="text-muted">Belum ada catatan perubahan status.</small></div>
    </div>
<?php else: ?>
    <?php foreach ($logs as $log): ?>
        <?php $logUtc = str_replace(' ', 'T', (string) $log['datetime_rs']) . 'Z'; ?>
        <div class="row mb-2">
            <div class="col-5"><small><?php echo $escape($log['status_antrian']); ?></small></div>
            <div class="col-1 text-center"><small>:</small></div>
            <div class="col-6"><small class="text-muted"><time class="js-date-time" data-utc="<?php echo $escape($logUtc); ?>">-</time></small></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (empty($queue['id_pasien'])): ?>
    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-success js-daftarkan-pasien"
            data-id="<?php echo (int) $queue['id_antrian']; ?>"
            data-nama="<?php echo $escape($queue['nama_pasien']); ?>"
            data-gender="<?php echo $escape($queue['gender']); ?>"
            data-nik="<?php echo $escape($queue['nik']); ?>"
            data-no-bpjs="<?php echo $escape($queue['no_bpjs']); ?>"
            data-kontak="<?php echo $escape($queue['kontak']); ?>">
            <i class="bi bi-person-plus"></i> Daftarkan ke Rekam Medis
        </button>
    </div>
<?php endif; ?>

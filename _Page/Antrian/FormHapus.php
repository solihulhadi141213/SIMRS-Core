<?php
// Memuat dan menampilkan detail serta pernyataan konfirmasi penghapusan antrean.
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

// Periksa sesi dan metode request sebelum membuka data antrean.
if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir. Silakan login ulang.</small></div>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<div class="alert alert-danger"><small>Metode request tidak valid.</small></div>';
    exit;
}

// Validasi ID sebelum mengambil informasi yang akan dikonfirmasi petugas.
$idAntrian = (int) ($_POST['id_antrian'] ?? 0);
if (!$idAntrian) {
    echo '<div class="alert alert-danger"><small>ID antrian tidak valid.</small></div>';
    exit;
}

// Ambil ringkasan antrean menggunakan prepared statement.
$stmt = mysqli_prepare(
    $Conn,
    "SELECT id_antrian, no_antrian, kode_booking, nama_pasien, datetime_creat,
            tanggal_kunjungan, nama_poliklinik, nama_dokter, status_antrian,
            sumber_antrian, pembayaran
     FROM antrian
     WHERE id_antrian = ?
     LIMIT 1"
);
if (!$stmt) {
    echo '<div class="alert alert-danger"><small>Gagal menyiapkan detail antrian.</small></div>';
    exit;
}
mysqli_stmt_bind_param($stmt, 'i', $idAntrian);
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    echo '<div class="alert alert-danger"><small>Gagal mengambil detail antrian.</small></div>';
    exit;
}
$result = mysqli_stmt_get_result($stmt);
$queue = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if (!$queue) {
    echo '<div class="alert alert-warning"><small>Data antrian tidak ditemukan.</small></div>';
    exit;
}

// Siapkan escaping dan konversi zona waktu tanggal sesuai sesi pengguna.
$escape = static fn($value): string => htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
try {
    $timezoneUser = new DateTimeZone($SessionUserTimezone ?: 'UTC');
} catch (Throwable $error) {
    $timezoneUser = new DateTimeZone('UTC');
}
$tanggal_daftar = '-';
if (!empty($queue['datetime_creat'])) {
    $tanggalDaftarUtc = new DateTimeImmutable(
        (string) $queue['datetime_creat'],
        new DateTimeZone('UTC')
    );
    $tanggal_daftar = $tanggalDaftarUtc
        ->setTimezone($timezoneUser)
        ->format('d/m/Y H:i T');
}
$tanggal_kunjungan = '-';
if (!empty($queue['tanggal_kunjungan'])) {
    $dateObj = DateTime::createFromFormat('!Y-m-d', $queue['tanggal_kunjungan']);
    $tanggal_kunjungan = $dateObj ? $dateObj->format('d/m/Y') : (string) $queue['tanggal_kunjungan'];
}
?>
<!-- ID dan detail ini dikirim bersama persetujuan pada saat form dihapus. -->
<input type="hidden" name="id_antrian" id="hapus_antrian_id" value="<?php echo (int) $queue['id_antrian']; ?>">

<!-- Ringkasan antrean ditampilkan sebelum petugas menyetujui penghapusan. -->
<div class="row mb-2">
    <div class="col-5"><small>Nomor Antrian</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo (int) $queue['no_antrian']; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kode Booking</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal font-monospace text-break"><?php echo $escape($queue['kode_booking']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nama Pasien</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal text-break"><?php echo $escape($queue['nama_pasien']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Tanggal Daftar</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($tanggal_daftar); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Rencana Kunjungan</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($tanggal_kunjungan); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Poliklinik</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal text-break"><?php echo $escape($queue['nama_poliklinik']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Dokter</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal text-break"><?php echo $escape($queue['nama_dokter']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Status</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($queue['status_antrian']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Sumber</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($queue['sumber_antrian']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Pembayaran</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($queue['pembayaran']); ?></small></div>
</div>

<!-- Konfirmasi mengikuti pola hapus pasien dan wajib disetujui sebelum tombol aktif. -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <div class="alert alert-danger">
            <small class="mb-4">
                <b>PENTING!!</b><br>
                Penghapusan data antrian akan menghapus catatan antrian beserta riwayat aktivitas antrian secara permanen.
                Pastikan detail antrian yang ditampilkan sudah sesuai.<br>
            </small>
            <hr>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="pernyataan_petugas_penghapus_antrian" name="pernyataan_petugas_penghapus_antrian" value="1">
                <label class="form-check-label" for="pernyataan_petugas_penghapus_antrian">
                    <small>
                        <b>Pernyataan Petugas</b><br>
                        Saya telah membaca informasi penting tentang penghapusan data antrian dan saya bersedia menerima konsekuensi atas tindakan ini.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>

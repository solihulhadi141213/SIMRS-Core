<?php
// Menampilkan informasi poliklinik atau dokter yang ditautkan ke antrean.
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

// Batasi request detail untuk sesi aktif dan metode POST.
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
$type = (string) ($_POST['jenis'] ?? '');
$id = (int) ($_POST['id'] ?? 0);
// Nama tabel dan kolom berasal dari pilihan tetap, bukan langsung dari input pengguna.
$table = $type === 'poliklinik' ? 'poliklinik' : ($type === 'dokter' ? 'dokter' : '');
$idColumn = $type === 'poliklinik' ? 'id_poliklinik' : 'id_dokter';
if (!$table || !$id) {
    http_response_code(400);
    echo '<div class="alert alert-danger">Referensi tidak valid.</div>';
    exit;
}

// Query mengambil satu baris dari tabel yang telah dipilih melalui daftar yang diizinkan.
$stmt = mysqli_prepare($Conn, "SELECT * FROM $table WHERE $idColumn = ? LIMIT 1");
if (!$stmt) {
    http_response_code(500);
    echo '<div class="alert alert-danger">Gagal menyiapkan detail referensi.</div>';
    exit;
}
mysqli_stmt_bind_param($stmt, 'i', $id);
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    http_response_code(500);
    echo '<div class="alert alert-danger">Gagal mengambil detail referensi.</div>';
    exit;
}
$result = mysqli_stmt_get_result($stmt);
$reference = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if (!$reference) {
    http_response_code(404);
    echo '<div class="alert alert-warning">Data referensi sudah tidak tersedia.</div>';
    exit;
}
// Escape nilai referensi sebelum dicetak ke markup detail.
$escape = static fn($value): string => htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
?>
<!-- Judul dan isi bagian menyesuaikan jenis referensi yang diminta. -->
<div class="row mb-2">
    <div class="col-12"><b><small><?php echo $type === 'poliklinik' ? 'A. Informasi Poliklinik' : 'A. Informasi Dokter'; ?></small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>ID</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $id; ?></small></div>
</div>
<?php if ($type === 'poliklinik'): ?>
    <div class="row mb-2">
        <div class="col-5"><small>Nama Poliklinik</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['poliklinik']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><small>Kode</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['kode']); ?></small></div>
    </div>
<?php else: ?>
    <div class="row mb-2">
        <div class="col-5"><small>Nama Dokter</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['nama']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><small>Kode</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['kode']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><small>Kategori</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['kategori']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><small>Jenis Kelamin</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['gender']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><small>Kontak</small></div>
        <div class="col-1 text-center"><small>:</small></div>
        <div class="col-6"><small class="text-muted"><?php echo $escape($reference['kontak']); ?></small></div>
    </div>
<?php endif; ?>
<div class="row mb-2">
    <div class="col-5"><small>Status</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo !empty($reference['status']) ? 'Aktif' : 'Tidak aktif'; ?></small></div>
</div>

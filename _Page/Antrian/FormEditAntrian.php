<?php
// Mengambil data antrean dan merender field edit berdasarkan ID yang dikirim modal.
header('Content-Type: text/html; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

/** Mengirim pesan HTML dengan status HTTP yang sesuai lalu menghentikan proses. */
function antrianEditFormError(string $message, int $statusCode = 400): void
{
    http_response_code($statusCode);
    echo '<div class="alert alert-danger mb-0"><small>'
        . htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
        . '</small></div>';
    exit;
}

// Validasi sesi, metode, dan ID sebelum membaca data antrean.
if (empty($SessionIdAkses)) {
    antrianEditFormError('Sesi berakhir. Silakan login kembali.', 401);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    antrianEditFormError('Metode request tidak valid.', 405);
}
$idAntrian = (int) ($_POST['id_antrian'] ?? 0);
if (!$idAntrian) {
    antrianEditFormError('ID antrian tidak valid.');
}

// Ambil nilai antrean menggunakan prepared statement.
$stmtAntrian = mysqli_prepare($Conn, "SELECT * FROM antrian WHERE id_antrian = ? LIMIT 1");
if (!$stmtAntrian) {
    antrianEditFormError('Gagal menyiapkan data antrian.', 500);
}
mysqli_stmt_bind_param($stmtAntrian, 'i', $idAntrian);
if (!mysqli_stmt_execute($stmtAntrian)) {
    mysqli_stmt_close($stmtAntrian);
    antrianEditFormError('Gagal mengambil data antrian.', 500);
}
$resultAntrian = mysqli_stmt_get_result($stmtAntrian);
$queue = mysqli_fetch_assoc($resultAntrian);
mysqli_stmt_close($stmtAntrian);
if (!$queue) {
    antrianEditFormError('Data antrian tidak ditemukan.', 404);
}

// Sertakan poliklinik aktif dan poliklinik antrean ini agar data lama tetap dapat diedit.
$idPoliklinik = (int) ($queue['id_poliklinik'] ?? 0);
$stmtPoliklinik = mysqli_prepare(
    $Conn,
    "SELECT id_poliklinik, poliklinik
     FROM poliklinik
     WHERE status = 1 OR id_poliklinik = ?
     ORDER BY poliklinik ASC"
);
if (!$stmtPoliklinik) {
    antrianEditFormError('Gagal menyiapkan daftar poliklinik.', 500);
}
mysqli_stmt_bind_param($stmtPoliklinik, 'i', $idPoliklinik);
if (!mysqli_stmt_execute($stmtPoliklinik)) {
    mysqli_stmt_close($stmtPoliklinik);
    antrianEditFormError('Gagal mengambil daftar poliklinik.', 500);
}
$resultPoliklinik = mysqli_stmt_get_result($stmtPoliklinik);

// Siapkan pilihan pasien, nilai form, dan jadwal yang saat ini tersimpan.
$escape = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
$idPasien = (int) ($queue['id_pasien'] ?? 0);
$pasienTerdaftar = $idPasien > 0;
$modePasien = $pasienTerdaftar ? 'lama' : 'baru';
$dataPasienClass = $pasienTerdaftar ? 'd-none' : '';
$dataPasienDisabled = $pasienTerdaftar ? ' disabled' : '';
$pilihPasienClass = $pasienTerdaftar ? '' : ' d-none';
$idJadwal = (int) ($queue['id_jadwal'] ?? 0);
$labelJadwal = trim((string) ($queue['nama_dokter'] ?? ''));
$stmtJadwal = mysqli_prepare($Conn, "SELECT jam_mulai, jam_selesai FROM jadwal_dokter WHERE id_jadwal = ? LIMIT 1");
if ($stmtJadwal) {
    mysqli_stmt_bind_param($stmtJadwal, 'i', $idJadwal);
    if (mysqli_stmt_execute($stmtJadwal)) {
        $resultJadwal = mysqli_stmt_get_result($stmtJadwal);
        $jadwalTersimpan = mysqli_fetch_assoc($resultJadwal);
        if ($jadwalTersimpan) {
            $labelJadwal .= ' | ' . substr((string) $jadwalTersimpan['jam_mulai'], 0, 5)
                . ' - ' . substr((string) $jadwalTersimpan['jam_selesai'], 0, 5);
        }
    }
    mysqli_stmt_close($stmtJadwal);
}
if ($labelJadwal === '') {
    $labelJadwal = 'Jadwal tersimpan';
}
?>
<!-- ID dan mode pasien menyertai field edit saat form dikirim ke endpoint penyimpanan. -->
<input type="hidden" name="id_antrian" value="<?php echo (int) $queue['id_antrian']; ?>">
<input type="hidden" name="id_pasien" value="<?php echo $idPasien ?: ''; ?>">

<div class="row g-2 g-lg-3">
    <!-- Bagian A mengatur pilihan rekam medis atau identitas pasien baru. -->
    <div class="col-12">
        <h6 class="fw-semibold text-primary mb-0">A. Identitas Pasien</h6>
    </div>
    <div class="col-12 col-lg-4">
        <label class="form-label mb-1 d-block">Jenis pasien</label>
        <div class="d-flex flex-wrap gap-2 pt-1">
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input js-mode-pasien" type="radio" name="mode_pasien" id="mode_pasien_edit_lama" value="lama" <?php echo $modePasien === 'lama' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="mode_pasien_edit_lama">Pilih pasien terdaftar</label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input js-mode-pasien" type="radio" name="mode_pasien" id="mode_pasien_edit_baru" value="baru" <?php echo $modePasien === 'baru' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="mode_pasien_edit_baru">Pasien baru</label>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8 js-pilih-pasien-field<?php echo $pilihPasienClass; ?>" id="pilih_pasien_edit_field">
        <label for="pilih_pasien_edit" class="form-label mb-1">Cari pasien <span class="text-danger">*</span></label>
        <select id="pilih_pasien_edit" class="form-control js-pilih-pasien-antrian">
            <?php if ($pasienTerdaftar): ?>
                <option value="<?php echo $idPasien; ?>" selected><?php echo $escape($idPasien . ' | ' . $queue['nama_pasien']); ?></option>
            <?php endif; ?>
        </select>
    </div>
    <!-- Field identitas pasien baru dinonaktifkan saat antrean terkait rekam medis lama. -->
    <div class="col-12 <?php echo $dataPasienClass; ?> js-data-pasien-field" id="data_pasien_edit_field">
        <div class="row g-2 g-lg-3">
            <div class="col-6">
                <label for="nama_pasien_edit" class="form-label mb-1">Nama lengkap pasien <span class="text-danger">*</span></label>
                <input type="text" name="nama_pasien" id="nama_pasien_edit" class="form-control" maxlength="255" value="<?php echo $escape($queue['nama_pasien']); ?>" required<?php echo $dataPasienDisabled; ?>>
            </div>
            <div class="col-6">
                <label for="gender_antrian_edit" class="form-label mb-1">Jenis kelamin <span class="text-danger">*</span></label>
                <select name="gender" id="gender_antrian_edit" class="form-select" required<?php echo $dataPasienDisabled; ?>>
                    <option value="">Pilih</option>
                    <option value="Laki-laki" <?php echo ($queue['gender'] ?? '') === 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($queue['gender'] ?? '') === 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-6 col-lg-4">
                <label for="nik_antrian_edit" class="form-label mb-1">NIK</label>
                <input type="text" name="nik" id="nik_antrian_edit" class="form-control" maxlength="16" inputmode="numeric" value="<?php echo $escape($queue['nik']); ?>"<?php echo $dataPasienDisabled; ?>>
            </div>
            <div class="col-6 col-lg-4">
                <label for="no_bpjs_antrian_edit" class="form-label mb-1">Nomor BPJS</label>
                <input type="text" name="no_bpjs" id="no_bpjs_antrian_edit" class="form-control" maxlength="13" inputmode="numeric" value="<?php echo $escape($queue['no_bpjs']); ?>"<?php echo $dataPasienDisabled; ?>>
            </div>
            <div class="col-6 col-lg-4">
                <label for="kontak_antrian_edit" class="form-label mb-1">Kontak</label>
                <input type="text" name="kontak" id="kontak_antrian_edit" class="form-control" maxlength="20" inputmode="tel" value="<?php echo $escape($queue['kontak']); ?>"<?php echo $dataPasienDisabled; ?>>
            </div>
        </div>
    </div>

    <!-- Bagian B menampilkan tanggal kunjungan, poliklinik, dan jadwal tersimpan. -->
    <div class="col-12"><hr class="my-1"></div>
    <div class="col-12">
        <h6 class="fw-semibold text-primary mb-0">B. Tujuan Kunjungan</h6>
    </div>
    <div class="col-6 col-lg-4">
        <label for="tanggal_kunjungan_edit" class="form-label mb-1">Rencana kunjungan <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan_edit" class="form-control js-antrian-schedule-filter" value="<?php echo $escape($queue['tanggal_kunjungan']); ?>" required>
    </div>
    <div class="col-6 col-lg-4">
        <label for="id_poliklinik_edit" class="form-label mb-1">Poliklinik <span class="text-danger">*</span></label>
        <select name="id_poliklinik" id="id_poliklinik_edit" class="form-select js-antrian-schedule-filter" required>
            <option value="">Pilih poliklinik</option>
            <?php while ($poliAntrian = mysqli_fetch_assoc($resultPoliklinik)): ?>
                <option value="<?php echo (int) $poliAntrian['id_poliklinik']; ?>" <?php echo (int) $poliAntrian['id_poliklinik'] === $idPoliklinik ? 'selected' : ''; ?>><?php echo $escape($poliAntrian['poliklinik']); ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-12 col-lg-4">
        <label for="id_jadwal_edit" class="form-label mb-1">Jadwal dokter <span class="text-danger">*</span></label>
        <select name="id_jadwal" id="id_jadwal_edit" class="form-select" required>
            <option value="">Pilih jadwal dokter</option>
            <?php if ($idJadwal): ?>
                <option value="<?php echo $idJadwal; ?>" selected><?php echo $escape($labelJadwal); ?></option>
            <?php endif; ?>
        </select>
    </div>

    <!-- Bagian C mengelompokkan pembayaran, nomor referensi, status, dan keluhan. -->
    <div class="col-12"><hr class="my-1"></div>
    <div class="col-12">
        <h6 class="fw-semibold text-primary mb-0">C. Informasi Antrian</h6>
    </div>
    <div class="col-6">
        <label for="pembayaran_edit" class="form-label mb-1">Pembayaran <span class="text-danger">*</span></label>
        <select name="pembayaran" id="pembayaran_edit" class="form-select" required>
            <?php foreach (['UMUM', 'BPJS', 'ASURANSI'] as $jenisPembayaran): ?>
                <option value="<?php echo $jenisPembayaran; ?>" <?php echo ($queue['pembayaran'] ?? '') === $jenisPembayaran ? 'selected' : ''; ?>><?php echo $jenisPembayaran; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-6">
        <label for="nomor_referensi_edit" class="form-label mb-1">Nomor referensi</label>
        <input type="text" name="nomor_referensi" id="nomor_referensi_edit" class="form-control" maxlength="255" value="<?php echo $escape($queue['nomor_referensi'] ?: 'MANUAL'); ?>">
    </div>
    <div class="col-12 col-md-6">
        <label for="status_antrian_edit" class="form-label mb-1">Status antrian</label>
        <select name="status_antrian" id="status_antrian_edit" class="form-select">
            <?php foreach (['Terdaftar', 'Batal', 'Checkin', 'Panggil Admisi', 'Tunggu Poli', 'Layanan Poli', 'Tunggu Farmasi', 'Layanan Farmasi', 'Selesai'] as $statusAntrian): ?>
                <option value="<?php echo $escape($statusAntrian); ?>" <?php echo ($queue['status_antrian'] ?? '') === $statusAntrian ? 'selected' : ''; ?>><?php echo $escape($statusAntrian); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12">
        <label for="keluhan_antrian_edit" class="form-label mb-1">Keluhan <span class="text-danger">*</span></label>
        <textarea name="keluhan" id="keluhan_antrian_edit" class="form-control" rows="3" required><?php echo $escape($queue['keluhan']); ?></textarea>
    </div>
</div>
<?php
mysqli_stmt_close($stmtPoliklinik);
?>

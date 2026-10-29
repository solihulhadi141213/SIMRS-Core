<?php
    // Memuat dan menampilkan detail serta pernyataan konfirmasi penghapusan referensi imunisasi.
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Periksa sesi dan metode request sebelum membuka data.
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir. Silakan login ulang.</small></div>';
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger"><small>Metode request tidak valid.</small></div>';
        exit;
    }

    // Validasi ID sebelum mengambil informasi yang akan dikonfirmasi petugas.
    $idImunisasi = (int) ($_POST['id_imunisasi_referensi'] ?? 0);
    if (!$idImunisasi) {
        echo '<div class="alert alert-danger"><small>ID referensi imunisasi tidak valid.</small></div>';
        exit;
    }

    // Ambil data referensi imunisasi menggunakan prepared statement.
    $stmt = mysqli_prepare(
        $Conn,
        "SELECT id_imunisasi_referensi, nama_vaksin, kode_cvx, kode_kemenkes,
                display_vaksin, system_vaksin, target_penyakit, status,
                datetime_creat, author_name
         FROM imunisasi_referensi
         WHERE id_imunisasi_referensi = ?
         LIMIT 1"
    );
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Gagal menyiapkan detail referensi imunisasi.</small></div>';
        exit;
    }
    mysqli_stmt_bind_param($stmt, 'i', $idImunisasi);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        echo '<div class="alert alert-danger"><small>Gagal mengambil detail referensi imunisasi.</small></div>';
        exit;
    }
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (!$data) {
        echo '<div class="alert alert-warning"><small>Data referensi imunisasi tidak ditemukan.</small></div>';
        exit;
    }

    // Siapkan escaping.
    $escape = static fn($value): string => htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');

    $statusLabel = ((int) ($data['status'] ?? 1) === 0) ? 'Non-Aktif' : 'Aktif';
?>
<!-- ID dan detail ini dikirim bersama persetujuan pada saat form dihapus. -->
<input type="hidden" name="id_imunisasi_referensi" id="hapus_imunisasi_id" value="<?php echo (int) $data['id_imunisasi_referensi']; ?>">

<!-- Ringkasan data referensi imunisasi ditampilkan sebelum petugas menyetujui penghapusan. -->
<div class="row mb-2">
    <div class="col-5"><small>Nama Vaksin</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['nama_vaksin']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kode CVX</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['kode_cvx']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kode Kemenkes</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['kode_kemenkes']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Display Vaksin</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['display_vaksin']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>System Vaksin</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal text-break"><?php echo $escape($data['system_vaksin']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Target Penyakit</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['target_penyakit']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Status</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($statusLabel); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Author</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['author_name']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Datetime Creat</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted fw-normal"><?php echo $escape($data['datetime_creat']); ?></small></div>
</div>

<!-- Konfirmasi penghapusan referensi imunisasi. -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <div class="alert alert-danger">
            <small class="mb-4">
                <b>PENTING!!</b><br>
                Penghapusan data referensi imunisasi akan menghapus data secara permanen.
                Pastikan detail referensi yang ditampilkan sudah sesuai.<br>
            </small>
            <hr>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="pernyataan_petugas_penghapus_imunisasi" name="pernyataan_petugas_penghapus_imunisasi" value="1">
                <label class="form-check-label" for="pernyataan_petugas_penghapus_imunisasi">
                    <small>
                        <b>Pernyataan Petugas</b><br>
                        Saya telah membaca informasi penting tentang penghapusan data referensi imunisasi dan saya bersedia menerima konsekuensi atas tindakan ini.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>


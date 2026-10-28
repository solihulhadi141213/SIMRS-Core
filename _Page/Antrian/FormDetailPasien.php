<?php
    // Memuat ringkasan rekam medis untuk ditampilkan dari modal detail antrean.
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Pastikan sesi, metode request, dan ID pasien valid sebelum menjalankan query.
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
    $idPasien = (int) ($_POST['id_pasien'] ?? 0);
    
    // Ambil satu rekam medis menggunakan ID yang diikat pada prepared statement.
    $stmt = mysqli_prepare($Conn, "SELECT * FROM pasien WHERE id_pasien = ? LIMIT 1");
    if (!$idPasien || !$stmt) {
        http_response_code($idPasien ? 500 : 400);
        echo '<div class="alert alert-danger">ID pasien tidak valid.</div>';
        exit;
    }
    mysqli_stmt_bind_param($stmt, 'i', $idPasien);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        http_response_code(500);
        echo '<div class="alert alert-danger">Gagal mengambil data pasien.</div>';
        exit;
    }

    $result  = mysqli_stmt_get_result($stmt);
    $patient = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (!$patient) {
        http_response_code(404);
        echo '<div class="alert alert-warning">Data pasien tidak ditemukan.</div>';
        exit;
    }
   
    // Siapkan escaping keluaran dan gabungkan komponen alamat yang tersedia.
    $escape  = static fn($value): string => htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
    $address = array_filter([$patient['street'], $patient['village'], $patient['subdistrict'], $patient['regency'], $patient['province'], $patient['postal_code']]);
?>
<!-- Bagian A memuat nomor rekam medis dan status pasien. -->
<div class="row mb-2">
    <div class="col-12"><b><small>A. Rekam Medis</small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor RM Pasien</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo (int) $patient['id_pasien']; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Status Pasien</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($patient['status']); ?></small></div>
</div>
<hr>

<!-- Bagian B memuat identitas umum yang tersimpan pada rekam medis. -->
<div class="row mb-2">
    <div class="col-12"><b><small>B. Identitas Umum</small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nama Pasien</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($patient['nama']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>NIK / No. KTP</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($patient['nik']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>No. BPJS</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($patient['no_bpjs']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Jenis Kelamin</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($patient['gender']); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Tempat, Tanggal Lahir</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text-muted"><?php echo $escape(trim(($patient['tempat_lahir'] ?? '') . ', ' . ($patient['tanggal_lahir'] ?? ''))); ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kontak</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape($patient['kontak']); ?></small></div>
</div>
<hr>

<!-- Bagian C menampilkan alamat dari komponen wilayah dan alamat pasien. -->
<div class="row mb-2">
    <div class="col-12"><b><small>C. Alamat</small></b></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Alamat Lengkap</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $escape(implode(', ', $address)); ?></small></div>
</div>

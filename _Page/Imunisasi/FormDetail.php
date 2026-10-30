<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir, silahkan login ulang.</small></div>';
        exit;
    }

    $id_imunisasi = validateAndSanitizeInput($_POST['id_imunisasi'] ?? '');

    if (empty($id_imunisasi) || !is_numeric($id_imunisasi)) {
        echo '<div class="alert alert-danger"><small>ID imunisasi tidak valid.</small></div>';
        exit;
    }

    $query = "
        SELECT
            i.*,
            p.nama AS nama_pasien,
            p.nik AS nik_pasien,
            p.no_bpjs,
            p.kontak AS kontak_pasien,
            p.gender,
            p.tanggal_lahir,
            k.datetime_daftar,
            k.jenis_kunjungan,
            k.poliklinik,
            k.dokter,
            r.nama_vaksin AS ref_nama_vaksin,
            r.kode_cvx,
            r.kode_kemenkes,
            r.display_vaksin,
            r.system_vaksin,
            r.target_penyakit,
            pr.nama_praktisi,
            pr.tipe_praktisi,
            pr.profesi_praktisi,
            pr.id_practitioner
        FROM imunisasi i
        LEFT JOIN pasien p ON i.id_pasien = p.id_pasien
        LEFT JOIN kunjungan k ON i.id_kunjungan = k.id_kunjungan
        LEFT JOIN imunisasi_referensi r ON i.id_imunisasi_referensi = r.id_imunisasi_referensi
        LEFT JOIN praktisi pr ON i.id_praktisi = pr.id_praktisi
        WHERE i.id_imunisasi = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_imunisasi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data imunisasi tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // =========================================================
    // DATA
    // =========================================================
    $id_immunization   = html_entity_decode($data['id_immunization'] ?? '', ENT_QUOTES, 'UTF-8');
    $id_pasien         = $data['id_pasien'] ?? '';
    $nama_pasien       = html_entity_decode($data['nama_pasien'] ?? '', ENT_QUOTES, 'UTF-8');
    $nik_pasien        = html_entity_decode($data['nik_pasien'] ?? '', ENT_QUOTES, 'UTF-8');
    $no_bpjs           = html_entity_decode($data['no_bpjs'] ?? '', ENT_QUOTES, 'UTF-8');
    $kontak_pasien     = html_entity_decode($data['kontak_pasien'] ?? '', ENT_QUOTES, 'UTF-8');
    $gender            = html_entity_decode($data['gender'] ?? '', ENT_QUOTES, 'UTF-8');
    $tanggal_lahir     = !empty($data['tanggal_lahir']) ? date('d/m/Y', strtotime((string)$data['tanggal_lahir'])) : '-';

    $id_kunjungan      = $data['id_kunjungan'] ?? '';
    $datetime_daftar   = !empty($data['datetime_daftar']) ? date('d/m/Y H:i', strtotime((string)$data['datetime_daftar'])) : '-';
    $jenis_kunjungan   = html_entity_decode($data['jenis_kunjungan'] ?? '', ENT_QUOTES, 'UTF-8');
    $poliklinik        = html_entity_decode($data['poliklinik'] ?? '', ENT_QUOTES, 'UTF-8');
    $dokter            = html_entity_decode($data['dokter'] ?? '', ENT_QUOTES, 'UTF-8');

    $tanggal_pemberian = !empty($data['tanggal_pemberian']) ? date('d/m/Y', strtotime((string)$data['tanggal_pemberian'])) : '-';
    $status_imunisasi  = html_entity_decode($data['status_imunisasi'] ?? '', ENT_QUOTES, 'UTF-8');
    $dosis_ke          = $data['dosis_ke'] ?? '';
    $nomor_batch       = html_entity_decode($data['nomor_batch'] ?? '', ENT_QUOTES, 'UTF-8');
    $produsen_vaksin   = html_entity_decode($data['produsen_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');

    $nama_vaksin       = html_entity_decode($data['ref_nama_vaksin'] ?? $data['nama_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $kode_cvx          = html_entity_decode($data['kode_cvx'] ?? '', ENT_QUOTES, 'UTF-8');
    $kode_kemenkes     = html_entity_decode($data['kode_kemenkes'] ?? '', ENT_QUOTES, 'UTF-8');
    $display_vaksin    = html_entity_decode($data['display_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $system_vaksin     = html_entity_decode($data['system_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $target_penyakit   = html_entity_decode($data['target_penyakit'] ?? '', ENT_QUOTES, 'UTF-8');

    $body_site_nama    = html_entity_decode($data['body_site_nama'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_display = html_entity_decode($data['body_site_display'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_code    = html_entity_decode($data['body_site_code'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_system  = html_entity_decode($data['body_site_system'] ?? '', ENT_QUOTES, 'UTF-8');

    $praktisi_nama     = html_entity_decode($data['praktisi_nama'] ?? '', ENT_QUOTES, 'UTF-8');
    $praktisi_ihs      = html_entity_decode($data['praktisi_ihs'] ?? '', ENT_QUOTES, 'UTF-8');
    $tipe_praktisi     = html_entity_decode($data['tipe_praktisi'] ?? '', ENT_QUOTES, 'UTF-8');
    $profesi_praktisi  = html_entity_decode($data['profesi_praktisi'] ?? '', ENT_QUOTES, 'UTF-8');
    $praktisi_id_pract = html_entity_decode($data['id_practitioner'] ?? '', ENT_QUOTES, 'UTF-8');

    $catatan           = html_entity_decode($data['catatan'] ?? '', ENT_QUOTES, 'UTF-8');
    $author_name       = html_entity_decode($data['author_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $datetime_creat    = $data['datetime_creat'] ?? '';
    $datetime_update   = $data['datetime_update'] ?? '';

    // Zona waktu user
    $timezoneName = trim((string)($SessionUserTimezone ?? ''));
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
        $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
    }
    try {
        $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
    } catch (Throwable $e) {
        $userTimezone = new DateTimeZone('UTC');
    }
    $formatUtcToUser = static function ($value) use ($userTimezone) {
        if (empty($value)) {
            return '-';
        }
        try {
            $dt = new DateTimeImmutable((string)$value, new DateTimeZone('UTC'));
            return $dt->setTimezone($userTimezone)->format('d/m/Y H:i T');
        } catch (Throwable $e) {
            return (string)$value;
        }
    };
    $datetime_creat_user  = $formatUtcToUser($datetime_creat);
    $datetime_update_user = $formatUtcToUser($datetime_update);

    $escape = static function ($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    };
?>

<!-- Identitas Pasien -->
<div class="row mb-2">
    <div class="col-12"><small class="fw-bold">A. Identitas Pasien</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>No. RM</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($id_pasien); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Pasien</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($nama_pasien); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>KTP/NIK</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($nik_pasien); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>No. BPJS</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($no_bpjs); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nomor Kontak</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($kontak_pasien); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Jenis Kelamin (Gender)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($gender); ?></small></div>
</div>
<div class="row mb-4">
    <div class="col-4"><small>Tanggal Lahir</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($tanggal_lahir); ?></small></div>
</div>
<hr>
<!-- Kunjungan -->
<div class="row mb-2 mt-2">
    <div class="col-12"><small class="fw-bold">B. Informasi Kunjungan</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Kunjungan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($id_kunjungan); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal Daftar</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($datetime_daftar); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Jenis Kunjungan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($jenis_kunjungan); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Poliklinik</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($poliklinik); ?></small></div>
</div>
<div class="row mb-4">
    <div class="col-4"><small>Dokter</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($dokter); ?></small></div>
</div>
<hr>
<!-- Imunisasi -->
<div class="row mb-2 mt-2">
    <div class="col-12"><small class="fw-bold">C. Informasi Pemberian Imunisasi</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Immunization</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($id_immunization); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal Pemberian</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($tanggal_pemberian); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($status_imunisasi); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Dosis Ke</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($dosis_ke); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nomor Batch</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($nomor_batch); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Produsen Vaksin</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($produsen_vaksin); ?></small></div>
</div>
<div class="row mb-4">
    <div class="col-4"><small>Catatan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($catatan); ?></small></div>
</div>
<hr>
<!-- Vaksin -->
<div class="row mb-2 mt-2">
    <div class="col-12"><small class="fw-bold">D. Referensi Nama / Jenis Vaksin</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Vaksin</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($nama_vaksin); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode CVX</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($kode_cvx); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode Kemenkes</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($kode_kemenkes); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($display_vaksin); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>System</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($system_vaksin); ?></small></div>
</div>
<div class="row mb-4">
    <div class="col-4"><small>Target Penyakit</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($target_penyakit); ?></small></div>
</div>
<hr>
<!-- Body Site -->
<div class="row mb-2 mt-2">
    <div class="col-12"><small class="fw-bold">E. Lokasi Tubuh (Body Site)</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_nama); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_display); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Code</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_code); ?></small></div>
</div>
<div class="row mb-4">
    <div class="col-4"><small>System</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_system); ?></small></div>
</div>
<hr>
<!-- Praktisi -->
<div class="row mb-2 mt-2">
    <div class="col-12"><small class="fw-bold">F. Petugas Pemberi Imunisasi</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Petugas</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($praktisi_nama); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tipe Praktisi</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($tipe_praktisi); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Profesi/Jabatan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($profesi_praktisi); ?></small></div>
</div>
<div class="row mb-4">
    <div class="col-4"><small>ID Practitioner</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($praktisi_ihs); ?></small></div>
</div>
<hr>
<!-- Metadata -->
<div class="row mb-2 mt-2">
    <div class="col-12"><small class="fw-bold">G. Metadata</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Author</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($author_name); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Datetime Creat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($datetime_creat_user); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Datetime Update</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($datetime_update_user); ?></small></div>
</div>
<?php
?>


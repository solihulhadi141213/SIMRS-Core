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
        SELECT i.*, p.nama AS nama_pasien,
               k.datetime_daftar, k.jenis_kunjungan,
               r.nama_vaksin AS ref_nama_vaksin,
               pr.nama_praktisi
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

    // Data
    $id_pasien = (int)($data['id_pasien'] ?? 0);
    $id_kunjungan = (int)($data['id_kunjungan'] ?? 0);
    $id_imunisasi_referensi = (int)($data['id_imunisasi_referensi'] ?? 0);

    // body_site id from nama
    $body_site_nama = (string)($data['body_site_nama'] ?? '');
    $id_body_site = '';
    if ($body_site_nama !== '') {
        $stmtBs = mysqli_prepare($Conn, "SELECT id_body_site FROM body_site WHERE body_site_nama = ? LIMIT 1");
        if ($stmtBs) {
            mysqli_stmt_bind_param($stmtBs, "s", $body_site_nama);
            mysqli_stmt_execute($stmtBs);
            $resBs = mysqli_stmt_get_result($stmtBs);
            $rowBs = mysqli_fetch_assoc($resBs);
            mysqli_stmt_close($stmtBs);
            if ($rowBs) { $id_body_site = (string)$rowBs['id_body_site']; }
        }
    }

    $id_praktisi = (int)($data['id_praktisi'] ?? 0);
    $praktisi_nama = (string)($data['nama_praktisi'] ?? '');
    $nama_pasien = (string)($data['nama_pasien'] ?? '');
    $kunjungan_text = 'Kunjungan #' . $id_kunjungan;
    if (!empty($data['datetime_daftar'])) {
        $kunjungan_text .= ' - ' . date('d/m/Y H:i', strtotime((string)$data['datetime_daftar']));
    }
    if (!empty($data['jenis_kunjungan'])) {
        $kunjungan_text .= ' - ' . $data['jenis_kunjungan'];
    }
    $ref_nama_vaksin = (string)($data['ref_nama_vaksin'] ?? '');

    $dosis_ke = $data['dosis_ke'] ?? 1;
    $nomor_batch = (string)($data['nomor_batch'] ?? '');
    $produsen_vaksin = (string)($data['produsen_vaksin'] ?? '');
    $catatan = (string)($data['catatan'] ?? '');

    // Convert tanggal UTC -> user
    $timezoneName = trim((string)($SessionUserTimezone ?? ''));
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
        $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
    }
    try {
        $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
    } catch (Throwable $e) {
        $userTimezone = new DateTimeZone('UTC');
    }
    $tanggal_value = '';
    $jam_value = '';
    if (!empty($data['tanggal_pemberian'])) {
        try {
            $dt = new DateTimeImmutable((string)$data['tanggal_pemberian'], new DateTimeZone('UTC'));
            $dt = $dt->setTimezone($userTimezone);
            $tanggal_value = $dt->format('Y-m-d');
            $jam_value = $dt->format('H:i');
        } catch (Throwable $e) {
            $tanggal_value = date('Y-m-d', strtotime((string)$data['tanggal_pemberian']));
        }
    }

    $escape = static function ($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    };
?>
<!-- Group Form pasien -->
<div class="row mb-3">
    <div class="col-12">
        <small><b>A. Data Pasien</b></small>
    </div>
</div>

<input type="hidden" name="id_imunisasi" value="<?php echo $escape($id_imunisasi); ?>">

<!-- Form Pencarian Pasien -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="id_pasien"><small>No.RM</small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="select_id_pasien_edit">
        <select name="id_pasien" id="id_pasien" class="form-control" required>
            <?php if ($id_pasien > 0): ?>
                <option value="<?php echo $escape($id_pasien); ?>" selected>No. RM <?php echo $escape($id_pasien); ?> — <?php echo $escape($nama_pasien); ?></option>
            <?php else: ?>
                <option value="">Pilih Pasien</option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="id_kunjungan"><small>Kunjungan</small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="select_id_kunjungan_edit">
        <select name="id_kunjungan" id="id_kunjungan" class="form-control" required>
            <?php if ($id_kunjungan > 0): ?>
                <option value="<?php echo $escape($id_kunjungan); ?>" selected><?php echo $escape($kunjungan_text); ?></option>
            <?php else: ?>
                <option value="">Pilih Kunjungan</option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>B. Pemberian Imunisasi</b></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="tanggal_pemberian"><small>Tanggal & Jam Pemberian</small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-4">
        <input type="date" name="tanggal_pemberian" id="tanggal_pemberian" class="form-control" value="<?php echo $escape($tanggal_value); ?>" required>
    </div>
    <div class="col-md-4">
        <input type="time" name="jam_pemberian" id="jam_pemberian" class="form-control" value="<?php echo $escape($jam_value); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="select_imunisasi_referensi_edit"><small>Jenis/Nama Vaksin</small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="select_imunisasi_referensi_edit">
        <select name="id_imunisasi_referensi" id="id_imunisasi_referensi_edit" class="form-select" required>
            <?php if ($id_imunisasi_referensi > 0): ?>
                <option value="<?php echo $escape($id_imunisasi_referensi); ?>" selected><?php echo $escape($ref_nama_vaksin); ?></option>
            <?php else: ?>
                <option value="">Pilih Vaksin</option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="dosis_ke"><small>Dosis Ke</small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="number" min="1" step="1" name="dosis_ke" id="dosis_ke" class="form-control" value="<?php echo $escape($data['dosis_ke'] ?? 1); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="nomor_batch"><small>Nomor Batch</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="nomor_batch" id="nomor_batch" class="form-control" value="<?php echo $escape($data['nomor_batch'] ?? ''); ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="produsen_vaksin"><small>Produsen Vaksin</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="produsen_vaksin" id="produsen_vaksin" class="form-control" value="<?php echo $escape($data['produsen_vaksin'] ?? ''); ?>">
    </div>
</div>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>C. Lokasi Tubuh (Body Site)</b></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="id_body_site"><small>Lokasi Tubuh (<i>Body Site</i>)</small></label>
    </div>
    <div class="col-md-8" id="select_body_site_edit">
        <select name="id_body_site" id="id_body_site" class="form-select">
            <?php if ($id_body_site !== ''): ?>
                <option value="<?php echo $escape($id_body_site); ?>" selected><?php echo $escape($body_site_nama); ?></option>
            <?php else: ?>
                <option value="">Pilih</option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>D. Petugas / Praktisi Medis</b></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="id_praktisi_edit"><small>Petugas Medis</small></label>
    </div>
    <div class="col-md-8" id="select_praktisi_edit">
        <select name="id_praktisi" id="id_praktisi_edit" class="form-select">
            <?php if ($id_praktisi > 0): ?>
                <option value="<?php echo $escape($id_praktisi); ?>" selected><?php echo $escape($praktisi_nama); ?></option>
            <?php else: ?>
                <option value="">Pilih</option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="catatan"><small>Catatan</small></label>
    </div>
    <div class="col-md-8">
        <textarea name="catatan" id="catatan" class="form-control"><?php echo $escape($data['catatan'] ?? ''); ?></textarea>
    </div>
</div>
<?php
?>


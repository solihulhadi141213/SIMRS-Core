<?php
    // Error reporting
    error_reporting(0);
    ini_set('display_errors', 0);

    // Load config
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir, silahkan login ulang.</small></div>';
        exit;
    }

    // Tangkap ID
    $id_imunisasi_referensi = validateAndSanitizeInput($_POST['id_imunisasi_referensi'] ?? '');

    // Validasi ID
    if (empty($id_imunisasi_referensi) || !is_numeric($id_imunisasi_referensi)) {
        echo '<div class="alert alert-danger"><small>ID referensi imunisasi tidak valid.</small></div>';
        exit;
    }

    // Query data
    $query = "SELECT * FROM imunisasi_referensi WHERE id_imunisasi_referensi = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);

    // Validasi query
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }

    // Bind
    mysqli_stmt_bind_param($stmt, "i", $id_imunisasi_referensi);

    // Execute
    mysqli_stmt_execute($stmt);

    // Result
    $result = mysqli_stmt_get_result($stmt);

    // Validasi data
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data referensi imunisasi tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }

    // Fetch data
    $data = mysqli_fetch_assoc($result);

    // Close
    mysqli_stmt_close($stmt);

    // Data
    $nama_vaksin     = html_entity_decode($data['nama_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $kode_cvx        = html_entity_decode($data['kode_cvx'] ?? '', ENT_QUOTES, 'UTF-8');
    $kode_kemenkes   = html_entity_decode($data['kode_kemenkes'] ?? '', ENT_QUOTES, 'UTF-8');
    $display_vaksin  = html_entity_decode($data['display_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $system_vaksin   = html_entity_decode($data['system_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $target_penyakit = html_entity_decode($data['target_penyakit'] ?? '', ENT_QUOTES, 'UTF-8');
    $author_name     = html_entity_decode($data['author_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $datetime_creat  = html_entity_decode($data['datetime_creat'] ?? '', ENT_QUOTES, 'UTF-8');
    $status          = $data['status'] ?? '1';

    // Routing Status
    if ($status == 0) {
        $label_status = '<span class="text-danger">Non-Aktif</span>';
    } else {
        $label_status = '<span class="text-success">Aktif</span>';
    }
?>
<input type="hidden" name="id_imunisasi_referensi" value="<?php echo $id_imunisasi_referensi; ?>">

<!-- Nama Vaksin -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="nama_vaksin_edit"><small>Nama Vaksin </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="nama_vaksin" id="nama_vaksin_edit" class="form-control" value="<?php echo htmlspecialchars($nama_vaksin, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Kode CVX -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="kode_cvx_edit"><small>Kode CVX </small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="kode_cvx" id="kode_cvx_edit" class="form-control" value="<?php echo htmlspecialchars($kode_cvx, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Kode Kemenkes -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="kode_kemenkes_edit">
            <small>Kode Kemenkes</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="kode_kemenkes" id="kode_kemenkes_edit" class="form-control" value="<?php echo htmlspecialchars($kode_kemenkes, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Display Vaksin -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="display_vaksin_edit">
            <small><i>Display</i> Vaksin</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="display_vaksin" id="display_vaksin_edit" class="form-control" value="<?php echo htmlspecialchars($display_vaksin, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- System Vaksin -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="system_vaksin_edit">
            <small><i>System</i> Vaksin</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="system_vaksin" id="system_vaksin_edit" class="form-control" value="<?php echo htmlspecialchars($system_vaksin, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Target Penyakit -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="target_penyakit_edit">
            <small>Target Penyakit</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="target_penyakit" id="target_penyakit_edit" class="form-control" value="<?php echo htmlspecialchars($target_penyakit, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="status_vaksin_edit">
            <small>Status</small> <span class="text-danger">*</span>
        </label>
    </div>
    <div class="col-md-8">
        <div class="d-flex flex-wrap gap-2 pt-1">
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input js-mode-pasien" type="radio" name="status" id="status_inactive_edit" value="0" <?php echo ((string)$status === '0') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="status_inactive_edit">
                    <small>Inactive</small>
                </label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input js-mode-pasien" type="radio" name="status" id="status_active_edit" value="1" <?php echo ((string)$status !== '0') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="status_active_edit">
                    <small>Active</small>
                </label>
            </div>
        </div>
    </div>
</div>

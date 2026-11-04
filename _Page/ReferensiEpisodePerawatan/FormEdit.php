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
    $id_episode_perawatan_kode = validateAndSanitizeInput($_POST['id_episode_perawatan_kode'] ?? '');

    // Validasi ID
    if (empty($id_episode_perawatan_kode) || !is_numeric($id_episode_perawatan_kode)) {
        echo '<div class="alert alert-danger"><small>ID referensi episode perawatan tidak valid.</small></div>';
        exit;
    }

    // Query data
    $query = "SELECT * FROM episode_perawatan_kode WHERE id_episode_perawatan_kode = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);

    // Validasi query
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }

    // Bind
    mysqli_stmt_bind_param($stmt, "i", $id_episode_perawatan_kode);

    // Execute
    mysqli_stmt_execute($stmt);

    // Result
    $result = mysqli_stmt_get_result($stmt);

    // Validasi data
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data referensi episode perawatan tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }

    // Fetch data
    $data = mysqli_fetch_assoc($result);

    // Close
    mysqli_stmt_close($stmt);

    // Data
    $episode_category = html_entity_decode($data['episode_category'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_name     = html_entity_decode($data['episode_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_display  = html_entity_decode($data['episode_display'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_code     = html_entity_decode($data['episode_code'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_system   = html_entity_decode($data['episode_system'] ?? '', ENT_QUOTES, 'UTF-8');
    $source           = html_entity_decode($data['source'] ?? '', ENT_QUOTES, 'UTF-8');
    $status           = $data['status'] ?? '1';
?>
<input type="hidden" name="id_episode_perawatan_kode" value="<?php echo $id_episode_perawatan_kode; ?>">

<!-- Kategori Episode -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="episode_category_edit"><small>Kategori Episode </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <select name="episode_category" id="episode_category_edit" class="form-control" required>
            <option value="">Pilih / Ketik Kategori</option>
            <?php if (!empty($episode_category)) { ?>
                <!-- Menampilkan data yang sudah ada agar terpilih otomatis saat form dimuat -->
                <option value="<?php echo htmlspecialchars($episode_category, ENT_QUOTES, 'UTF-8'); ?>" selected>
                    <?php echo htmlspecialchars($episode_category, ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<!-- Nama Episode (Lokal) -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="episode_name_edit"><small>Nama Episode (Lokal) </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="episode_name" id="episode_name_edit" class="form-control" value="<?php echo htmlspecialchars($episode_name, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Nama Episode (Standar) -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="episode_display_edit"><small>Nama Episode (Standar) </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="episode_display" id="episode_display_edit" class="form-control" value="<?php echo htmlspecialchars($episode_display, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Kode Episode -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="episode_code_edit"><small>Kode Episode </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="episode_code" id="episode_code_edit" class="form-control" value="<?php echo htmlspecialchars($episode_code, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- System Referensi -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="episode_system_edit"><small>System Referensi </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="episode_system" id="episode_system_edit" class="form-control" value="<?php echo htmlspecialchars($episode_system, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Sumber Data -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="source_edit"><small>Sumber Data </small> <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="source" id="source_edit" class="form-control" value="<?php echo htmlspecialchars($source, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="status_edit">
            <small>Status</small> <span class="text-danger">*</span>
        </label>
    </div>
    <div class="col-md-8">
        <div class="d-flex flex-wrap gap-2 pt-1">
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="radio" name="status" id="status_inactive_edit" value="0" <?php echo ((string)$status === '0') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="status_inactive_edit">
                    <small>Inactive</small>
                </label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="radio" name="status" id="status_active_edit" value="1" <?php echo ((string)$status !== '0') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="status_active_edit">
                    <small>Active</small>
                </label>
            </div>
        </div>
    </div>
</div>
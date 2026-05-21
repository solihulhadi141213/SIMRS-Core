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
    $id_alergi_alergen = validateAndSanitizeInput($_POST['id_alergi_alergen'] ?? '');

    // Validasi ID
    if (empty($id_alergi_alergen) || !is_numeric($id_alergi_alergen)) {
        echo '<div class="alert alert-danger"><small>ID alergen tidak valid.</small></div>';
        exit;
    }

    // Query data
    $query = "SELECT * FROM alergi_alergen WHERE id_alergi_alergen = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);

    // Validasi query
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }

    // Bind
    mysqli_stmt_bind_param($stmt, "i", $id_alergi_alergen);

    // Execute
    mysqli_stmt_execute($stmt);

    // Result
    $result = mysqli_stmt_get_result($stmt);

    // Validasi data
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data alergen tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }

    // Fetch data
    $data = mysqli_fetch_assoc($result);

    // Close
    mysqli_stmt_close($stmt);

    // Data
    $kategori_alergen = $data['kategori_alergen'] ?? '';
    $nama_alergen     = html_entity_decode($data['nama_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $code_alergen     = html_entity_decode($data['code_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $display_alergen  = html_entity_decode($data['display_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $system_alergen   = html_entity_decode($data['system_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $status           = $data['status'] ?? '1';

    // Checked status
    $checked = ($status == '1') ? 'checked' : '';
?>

<input type="hidden" name="id_alergi_alergen" value="<?php echo $id_alergi_alergen; ?>">

<div class="row mb-3">
    <div class="col-12">
        <label for="kategori_alergen_edit"><small>Kategori Alergen</small></label>
        <select name="kategori_alergen" id="kategori_alergen_edit" class="form-control" required>
            <option value="">Pilih</option>
            <option value="Food" <?php if($kategori_alergen=='Food'){echo 'selected';} ?>>Makanan (Food)</option>
            <option value="Medication" <?php if($kategori_alergen=='Medication'){echo 'selected';} ?>>Obat (Medication)</option>
            <option value="Environment" <?php if($kategori_alergen=='Environment'){echo 'selected';} ?>>Alergen Lingkungan (Environment)</option>
            <option value="Biologic" <?php if($kategori_alergen=='Biologic'){echo 'selected';} ?>>Biologis (Biologic)</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="nama_alergen_edit"><small>Nama/Jenis Alergen</small></label>
        <input type="text" name="nama_alergen" id="nama_alergen_edit" class="form-control" value="<?php echo htmlspecialchars($nama_alergen, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="code_alergen_edit"><small>Kode Alergen (Code)</small></label>
        <input type="text" name="code_alergen" id="code_alergen_edit" class="form-control" value="<?php echo htmlspecialchars($code_alergen, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="display_alergen_edit"><small>Deskripsi (Display)</small></label>
        <input type="text" name="display_alergen" id="display_alergen_edit" class="form-control" value="<?php echo htmlspecialchars($display_alergen, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="system_alergen_edit"><small>Referensi (System)</small></label>
        <input type="text" name="system_alergen" id="system_alergen_edit" class="form-control" value="<?php echo htmlspecialchars($system_alergen, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label for="status_data"><small>Status Data</small></label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="status" id="status_edit" value="1" <?php echo $checked; ?>>
            <label class="form-check-label" for="status_edit">
                <small>Aktif</small>
            </label>
        </div>
    </div>
</div>
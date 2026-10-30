<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir, silahkan login ulang.</small></div>';
        exit;
    }

    // =========================================================
    // TANGKAP ID
    // =========================================================
    $id_body_site = validateAndSanitizeInput($_POST['id_body_site'] ?? '');

    if (empty($id_body_site) || !is_numeric($id_body_site)) {
        echo '<div class="alert alert-danger"><small>ID body site tidak valid.</small></div>';
        exit;
    }

    // =========================================================
    // QUERY DATA
    // =========================================================
    $query = "SELECT * FROM body_site WHERE id_body_site = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_body_site);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data body site tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // =========================================================
    // DATA
    // =========================================================
    $body_site_category = html_entity_decode($data['body_site_category'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_nama     = html_entity_decode($data['body_site_nama'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_display  = html_entity_decode($data['body_site_display'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_code     = html_entity_decode($data['body_site_code'] ?? '', ENT_QUOTES, 'UTF-8');
    $body_site_system   = html_entity_decode($data['body_site_system'] ?? '', ENT_QUOTES, 'UTF-8');

    // =========================================================
    // ENUM KATEGORI
    // =========================================================
    $enum_values = [];
    $qEnum = mysqli_query($Conn, "SHOW COLUMNS FROM body_site WHERE Field = 'body_site_category'");
    if ($qEnum) {
        $rEnum = mysqli_fetch_assoc($qEnum);
        $type = $rEnum['Type'] ?? '';
        if (preg_match("/^enum\((.*)\)$/i", $type, $matches)) {
            $values = str_getcsv($matches[1], ',', "'", '');
            foreach ($values as $value) {
                $value = trim($value, " '");
                if ($value !== '') {
                    $enum_values[] = $value;
                }
            }
        }
    }

    $escape = static function ($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    };
?>
<input type="hidden" name="id_body_site" value="<?php echo $escape($id_body_site); ?>">

<div class="row mb-3">
    <div class="col-12">
        <label for="body_site_category_edit"><small>Kategori Body Site</small></label>
        <select name="body_site_category" id="body_site_category_edit" class="form-control" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($enum_values as $value): ?>
                <option value="<?php echo $escape($value); ?>" <?php if ($value === $body_site_category) { echo 'selected'; } ?>>
                    <?php echo $escape($value); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="body_site_nama_edit"><small>Nama Lokal</small></label>
        <input type="text" name="body_site_nama" id="body_site_nama_edit" class="form-control" value="<?php echo $escape($body_site_nama); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="body_site_display_edit"><small>Display</small></label>
        <input type="text" name="body_site_display" id="body_site_display_edit" class="form-control" value="<?php echo $escape($body_site_display); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="body_site_code_edit"><small>Code</small></label>
        <input type="text" name="body_site_code" id="body_site_code_edit" class="form-control" value="<?php echo $escape($body_site_code); ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="body_site_system_edit"><small>System</small></label>
        <input type="text" name="body_site_system" id="body_site_system_edit" class="form-control" value="<?php echo $escape($body_site_system); ?>">
    </div>
</div>

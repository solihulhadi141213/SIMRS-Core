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
<div class="row mb-2">
    <div class="col-4"><small>Nama Vaksin</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $nama_vaksin ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode CVX</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $kode_cvx ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode Kemenkes</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $kode_kemenkes ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Display Vaksin</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $display_vaksin ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>System Vaksin</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $system_vaksin ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Target Penyakit</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $target_penyakit ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Author</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $author_name ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Datetime Creat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $datetime_creat ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $label_status; ?></small></div>
</div>

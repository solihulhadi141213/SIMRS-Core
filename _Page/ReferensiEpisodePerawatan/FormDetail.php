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
    $episode_category  = html_entity_decode($data['episode_category'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_name      = html_entity_decode($data['episode_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_display   = html_entity_decode($data['episode_display'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_code      = html_entity_decode($data['episode_code'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode_system    = html_entity_decode($data['episode_system'] ?? '', ENT_QUOTES, 'UTF-8');
    $source            = html_entity_decode($data['source'] ?? '', ENT_QUOTES, 'UTF-8');
    $creat_by_name     = html_entity_decode($data['creat_by_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $creat_at          = html_entity_decode($data['creat_at'] ?? '', ENT_QUOTES, 'UTF-8');
    $status            = $data['status'] ?? '1';

    // Routing Status
    if ($status == 0) {
        $label_status = '<span class="text-danger">Non-Aktif</span>';
    } else {
        $label_status = '<span class="text-success">Aktif</span>';
    }
?>
<div class="row mb-2">
    <div class="col-4"><small>Kategori Episode</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $episode_category ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Episode (Lokal)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $episode_name ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Episode (Standar)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $episode_display ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode Episode</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $episode_code ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>System Referensi</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $episode_system ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Sumber Data</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $source ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Dibuat Oleh</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $creat_by_name ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Datetime Dibuat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $creat_at ?: '-'; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $label_status; ?></small></div>
</div>
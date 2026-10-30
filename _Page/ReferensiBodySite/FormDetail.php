<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

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

    // Validasi ID
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
    $author_name        = html_entity_decode($data['author_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $datetime_creat     = $data['datetime_creat'] ?? '';
    $datetime_update    = $data['datetime_update'] ?? '';

    // =========================================================
    // ZONA WAKTU USER (database UTC -> zona user)
    // =========================================================
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
<div class="row mb-2">
    <div class="col-4"><small>Kategori</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_category); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Lokal</small></div>
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
<div class="row mb-2">
    <div class="col-4"><small>System</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_system); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Author</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($author_name); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Datetime Creat (User Timezone)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($datetime_creat_user); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Datetime Update (User Timezone)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($datetime_update_user); ?></small></div>
</div>
<?php
?>


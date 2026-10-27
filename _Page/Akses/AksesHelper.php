<?php

function aksesEscapeHtml($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function aksesImageDirectory()
{
    return __DIR__ . '/../../assets/img/user';
}

function aksesStoreUploadedImage(array $file)
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload foto gagal.');
    }

    if (
        !isset($file['size'], $file['tmp_name'])
        || $file['size'] > 2 * 1024 * 1024
        || !is_uploaded_file($file['tmp_name'])
    ) {
        throw new RuntimeException('Ukuran foto maksimal 2MB atau file upload tidak valid.');
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ];
    $imageInfo = @getimagesize($file['tmp_name']);

    if (
        !isset($allowedTypes[$extension])
        || $imageInfo === false
        || $imageInfo['mime'] !== $allowedTypes[$extension]
    ) {
        throw new RuntimeException('Foto harus berupa JPG, PNG, atau GIF yang valid.');
    }

    $directory = aksesImageDirectory();
    if (!is_dir($directory) || !is_writable($directory)) {
        throw new RuntimeException('Direktori foto pengguna tidak tersedia atau tidak dapat ditulis.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    if (!move_uploaded_file($file['tmp_name'], $directory . DIRECTORY_SEPARATOR . $filename)) {
        throw new RuntimeException('Foto pengguna gagal disimpan.');
    }

    return $filename;
}

function aksesImageUrl($filename)
{
    $filename = (string) $filename;
    if ($filename === '' || basename($filename) !== $filename) {
        return 'assets/img/user/No-Image.png';
    }

    $newPath = aksesImageDirectory() . DIRECTORY_SEPARATOR . $filename;
    if (is_file($newPath)) {
        return 'assets/img/user/' . rawurlencode($filename);
    }

    $legacyPath = __DIR__ . '/../../assets/images/user/' . $filename;
    if (is_file($legacyPath)) {
        return 'assets/images/user/' . rawurlencode($filename);
    }

    return 'assets/img/user/No-Image.png';
}

// Normalisasi datetime database UTC ke format ISO-8601 yang dikenali browser.
function aksesUtcDateIso($value)
{
    if (!is_string($value) || trim($value) === '') {
        return '';
    }

    $date = DateTimeImmutable::createFromFormat('!Y-m-d H:i:s', trim($value), new DateTimeZone('UTC'));
    $errors = DateTimeImmutable::getLastErrors();
    if ($date === false || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
        return '';
    }

    return $date->format('Y-m-d\TH:i:s\Z');
}

// Sediakan nilai UTC awal agar tanggal tetap terlihat sebelum JavaScript memformat zona waktu browser.
function aksesUtcDateDisplay($value)
{
    $isoDate = aksesUtcDateIso($value);
    if ($isoDate === '') {
        return '-';
    }

    return (new DateTimeImmutable($isoDate))->format('d/m/Y H:i:s');
}

function aksesRemoveImage($filename)
{
    $filename = (string) $filename;
    if ($filename === '' || basename($filename) !== $filename) {
        return;
    }

    foreach ([
        aksesImageDirectory() . DIRECTORY_SEPARATOR . $filename,
        __DIR__ . '/../../assets/images/user/' . $filename,
    ] as $path) {
        if (is_file($path) && !unlink($path)) {
            error_log('Akses: gagal menghapus file foto pengguna ' . basename($path));
        }
    }
}

function aksesWriteAuditLog(mysqli $Conn, $actorId, $actorName, $title, array $metadata)
{
    $datetime = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $metadataJson = json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    $stmt = $Conn->prepare(
        'INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, metadata_log)
         VALUES (?, ?, ?, ?, ?)'
    );

    if (!$stmt) {
        throw new RuntimeException('Gagal menyiapkan pencatatan aktivitas akses.');
    }

    $stmt->bind_param('issss', $actorId, $datetime, $actorName, $title, $metadataJson);
    if (!$stmt->execute()) {
        $stmt->close();
        throw new RuntimeException('Gagal mencatat aktivitas akses.');
    }

    $stmt->close();
}

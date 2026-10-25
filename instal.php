<?php

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Installer hanya dapat dijalankan melalui PHP CLI.\n");
    exit(1);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function readRequiredInput(string $prompt): string
{
    fwrite(STDOUT, $prompt);
    $input = fgets(STDIN);

    if ($input === false) {
        throw new RuntimeException('Input tidak dapat dibaca dari terminal.');
    }

    return trim($input);
}

function countRows(mysqli $connection, string $table): int
{
    $result = $connection->query("SELECT COUNT(*) AS row_count FROM `{$table}`");
    $row = $result->fetch_assoc();
    $result->free();

    if ($row === null || $row === false) {
        throw new RuntimeException("Gagal membaca jumlah data tabel {$table}.");
    }

    return (int) $row['row_count'];
}

function loadFeatureReference(string $path): array
{
    if (!is_file($path) || !is_readable($path)) {
        throw new RuntimeException("File referensi fitur tidak ditemukan atau tidak dapat dibaca: {$path}");
    }

    $json = file_get_contents($path);
    if ($json === false) {
        throw new RuntimeException("Gagal membaca file referensi fitur: {$path}");
    }

    try {
        $features = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        throw new RuntimeException("JSON referensi fitur tidak valid: {$exception->getMessage()}", 0, $exception);
    }

    if (!is_array($features) || $features === []) {
        throw new RuntimeException('JSON referensi fitur harus berisi array fitur yang tidak kosong.');
    }

    $requiredFields = ['id_akses_fitur', 'nama_fitur', 'kategori', 'kode', 'keterangan'];
    $seenIds = [];

    foreach ($features as $index => $feature) {
        if (!is_array($feature)) {
            throw new RuntimeException('Setiap item JSON referensi fitur harus berupa objek.');
        }

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $feature)) {
                throw new RuntimeException("Kolom {$field} tidak ditemukan pada JSON referensi fitur.");
            }
        }

        $id = filter_var($feature['id_akses_fitur'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0 || $id > 4294967295 || isset($seenIds[$id])) {
            throw new RuntimeException('ID fitur pada JSON harus berupa bilangan bulat positif yang unik.');
        }

        foreach (array_slice($requiredFields, 1) as $field) {
            if (!is_string($feature[$field])) {
                throw new RuntimeException("Nilai {$field} pada JSON referensi fitur harus berupa teks.");
            }
        }

        $features[$index]['id_akses_fitur'] = $id;
        $seenIds[$id] = true;
    }

    usort(
        $features,
        static fn(array $left, array $right): int =>
            $left['id_akses_fitur'] <=> $right['id_akses_fitur']
    );

    return $features;
}

function verifyExistingFeatures(mysqli $connection, array $features): void
{
    if (countRows($connection, 'akses_fitur') !== count($features)) {
        throw new RuntimeException(
            'Tabel akses_fitur sudah berisi data yang berbeda dari file referensi. ' .
            'Periksa database dan file JSON sebelum menjalankan installer.'
        );
    }

    $result = $connection->query(
        'SELECT `id_akses_fitur`, `nama_fitur`, `kategori`, `kode`, `keterangan` ' .
        'FROM `akses_fitur` ORDER BY `id_akses_fitur`'
    );

    foreach ($features as $feature) {
        $row = $result->fetch_assoc();
        if (
            $row === null ||
            $row === false ||
            (int) $row['id_akses_fitur'] !== $feature['id_akses_fitur'] ||
            $row['nama_fitur'] !== $feature['nama_fitur'] ||
            $row['kategori'] !== $feature['kategori'] ||
            $row['kode'] !== $feature['kode'] ||
            $row['keterangan'] !== $feature['keterangan']
        ) {
            $result->free();
            throw new RuntimeException(
                'Data tabel akses_fitur tidak cocok dengan file referensi. ' .
                'Periksa database dan file JSON sebelum menjalankan installer.'
            );
        }
    }

    $result->free();
}

try {
    $referencePath = __DIR__ . DIRECTORY_SEPARATOR . '_Database' . DIRECTORY_SEPARATOR .
        'referance' . DIRECTORY_SEPARATOR . 'default_reference_feature_code.json';
    $features = loadFeatureReference($referencePath);

    $email = readRequiredInput('Email Admin: ');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Format email tidak valid.');
    }

    $adminPassword = readRequiredInput('Password Admin: ');
    if (strlen($adminPassword) < 8 || strlen($adminPassword) > 20) {
        throw new RuntimeException('Password harus memiliki panjang 8 sampai 20 karakter.');
    }

    require __DIR__ . DIRECTORY_SEPARATOR . '_Config' . DIRECTORY_SEPARATOR . 'Connection.php';
    if (!$Conn->set_charset('utf8mb4')) {
        throw new RuntimeException('Gagal mengatur charset database ke utf8mb4.');
    }
    $Conn->begin_transaction();

    foreach (['akses', 'akses_entitas', 'akses_entitas_acc', 'akses_acc'] as $table) {
        if (countRows($Conn, $table) !== 0) {
            throw new RuntimeException(
                "Tabel {$table} sudah berisi data. Installer hanya dapat dijalankan pada database awal."
            );
        }
    }

    if (countRows($Conn, 'akses_fitur') === 0) {
        $insertFeature = $Conn->prepare(
            'INSERT INTO `akses_fitur` ' .
            '(`id_akses_fitur`, `nama_fitur`, `kategori`, `kode`, `keterangan`) ' .
            'VALUES (?, ?, ?, ?, ?)'
        );

        foreach ($features as $feature) {
            $featureId = $feature['id_akses_fitur'];
            $featureName = $feature['nama_fitur'];
            $category = $feature['kategori'];
            $code = $feature['kode'];
            $description = $feature['keterangan'];
            $insertFeature->bind_param(
                'issss',
                $featureId,
                $featureName,
                $category,
                $code,
                $description
            );
            $insertFeature->execute();
        }

        $insertFeature->close();
    } else {
        verifyExistingFeatures($Conn, $features);
    }

    $entityName = 'Admin';
    $entityDescription = 'User Default Level';
    $insertEntity = $Conn->prepare(
        'INSERT INTO `akses_entitas` (`akses`, `deskripsi`) VALUES (?, ?)'
    );
    $insertEntity->bind_param('ss', $entityName, $entityDescription);
    $insertEntity->execute();
    $entityId = $insertEntity->insert_id;
    $insertEntity->close();

    $assignEntityFeatures = $Conn->prepare(
        'INSERT INTO `akses_entitas_acc` (`id_akses_entitas`, `id_akses_fitur`) ' .
        'SELECT ?, `id_akses_fitur` FROM `akses_fitur` ORDER BY `id_akses_fitur`'
    );
    $assignEntityFeatures->bind_param('i', $entityId);
    $assignEntityFeatures->execute();
    $entityFeatureCount = $assignEntityFeatures->affected_rows;
    $assignEntityFeatures->close();

    $nowUtc = gmdate('Y-m-d H:i:s');
    $adminName = 'Admin Faskes';
    $emptyValue = '';
    $passwordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
    if ($passwordHash === false) {
        throw new RuntimeException('Password admin gagal diproses.');
    }

    $insertAdmin = $Conn->prepare(
        'INSERT INTO `akses` ' .
        '(`id_akses_pengajuan`, `id_akses_entitas`, `tanggal`, `nama`, `nik`, `ihs`, ' .
        '`email`, `kontak`, `password`, `akses`, `gambar`, `updatetime`) ' .
        'VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $insertAdmin->bind_param(
        'issssssssss',
        $entityId,
        $nowUtc,
        $adminName,
        $emptyValue,
        $emptyValue,
        $email,
        $emptyValue,
        $passwordHash,
        $entityName,
        $emptyValue,
        $nowUtc
    );
    $insertAdmin->execute();
    $adminId = $insertAdmin->insert_id;
    $insertAdmin->close();

    $assignAdminFeatures = $Conn->prepare(
        'INSERT INTO `akses_acc` (`id_akses`, `id_akses_fitur`) ' .
        'SELECT ?, `id_akses_fitur` FROM `akses_fitur` ORDER BY `id_akses_fitur`'
    );
    $assignAdminFeatures->bind_param('i', $adminId);
    $assignAdminFeatures->execute();
    $adminFeatureCount = $assignAdminFeatures->affected_rows;
    $assignAdminFeatures->close();

    if ($entityFeatureCount !== count($features) || $adminFeatureCount !== count($features)) {
        throw new RuntimeException('Jumlah relasi fitur yang dibuat tidak sesuai dengan data referensi.');
    }

    $Conn->commit();
    $Conn->close();

    fwrite(
        STDOUT,
        "Instalasi berhasil. Admin Faskes dibuat untuk {$email}; " .
        count($features) . " fitur diberikan ke akun dan entitas Admin.\n"
    );
} catch (Throwable $exception) {
    if (isset($Conn) && $Conn instanceof mysqli) {
        if ($Conn->thread_id !== 0) {
            try {
                $Conn->rollback();
            } catch (Throwable $rollbackException) {
                fwrite(STDERR, "Rollback transaksi gagal: {$rollbackException->getMessage()}\n");
            }
            $Conn->close();
        }
    }

    fwrite(STDERR, "Instalasi gagal: {$exception->getMessage()}\n");
    exit(1);
}
?>
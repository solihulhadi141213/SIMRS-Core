<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit("Script ini hanya dapat dijalankan melalui CLI.\n");
}

const REGION_DATASET_BASE_URL = 'https://raw.githubusercontent.com/danikz/valtera-indonesia-regions/main/dist/csv/';
const REGION_DATASET_EXPECTED_COUNTS = [
    'provinces.csv' => 37,
    'regencies.csv' => 514,
    'districts.csv' => 7272,
    'villages.csv' => 83763,
];

function readRegionCsv(string $filename, array $expectedHeaders, callable $handleRow): int
{
    $url = REGION_DATASET_BASE_URL . $filename;
    $context = stream_context_create([
        'http' => [
            'timeout' => 60,
            'user_agent' => 'SIMRS-Core wilayah data generator',
        ],
        'https' => [
            'timeout' => 60,
            'user_agent' => 'SIMRS-Core wilayah data generator',
        ],
    ]);
    $stream = fopen($url, 'rb', false, $context);

    if ($stream === false) {
        throw new RuntimeException("Tidak dapat mengunduh dataset: {$url}");
    }

    try {
        $metadata = stream_get_meta_data($stream);
        $responseHeaders = $metadata['wrapper_data'] ?? [];
        $statusLines = array_values(array_filter(
            $responseHeaders,
            static fn ($header): bool => is_string($header) && str_starts_with($header, 'HTTP/')
        ));
        $lastStatus = $statusLines === [] ? '' : end($statusLines);

        if (!is_string($lastStatus) || !preg_match('/\s200(?:\s|$)/', $lastStatus)) {
            throw new RuntimeException("Server dataset mengembalikan respons tidak berhasil untuk {$filename}.");
        }

        $headers = fgetcsv($stream, null, ',', '"', '');
        if ($headers !== $expectedHeaders) {
            throw new RuntimeException("Header {$filename} tidak sesuai dengan spesifikasi dataset.");
        }

        $count = 0;
        while (($fields = fgetcsv($stream, null, ',', '"', '')) !== false) {
            if (count($fields) !== count($expectedHeaders)) {
                throw new RuntimeException("Baris ke-" . ($count + 2) . " pada {$filename} tidak valid.");
            }

            $handleRow(array_combine($expectedHeaders, $fields));
            $count++;
        }

        if (stream_get_meta_data($stream)['timed_out']) {
            throw new RuntimeException("Gagal membaca seluruh data dari {$filename}.");
        }
    } finally {
        fclose($stream);
    }

    $expectedCount = REGION_DATASET_EXPECTED_COUNTS[$filename];
    if ($count !== $expectedCount) {
        throw new RuntimeException(
            "{$filename} berisi {$count} baris; jumlah yang diharapkan dari spesifikasi dataset adalah {$expectedCount}."
        );
    }

    return $count;
}

function requireRegionCode(string $code, int $length, string $filename): void
{
    if (strlen($code) !== $length || !ctype_digit($code)) {
        throw new RuntimeException("Kode wilayah tidak valid pada {$filename}: {$code}");
    }
}

function regionRecordKey(array $record): string
{
    return mb_strtolower(implode("\0", array_slice($record, 0, 4)), 'UTF-8');
}

function insertRegionBatch(mysqli $connection, array $records): void
{
    if ($records === []) {
        return;
    }

    $columns = '(province, regency, subdistrict, village, tipe_level2, tipe_level4, kode_mendagri_1, kode_mendagri_2, kode_mendagri_3, kode_mendagri_4)';
    $rowPlaceholders = '(' . implode(', ', array_fill(0, 10, '?')) . ')';
    $sql = 'INSERT INTO wilayah ' . $columns . ' VALUES '
        . implode(', ', array_fill(0, count($records), $rowPlaceholders));
    $values = [];

    foreach ($records as $record) {
        array_push($values, ...$record);
    }

    $statement = $connection->prepare($sql);
    $arguments = [str_repeat('s', count($values))];
    foreach ($values as &$value) {
        $arguments[] = &$value;
    }
    unset($value);

    call_user_func_array([$statement, 'bind_param'], $arguments);
    $statement->execute();
    $statement->close();
}

function updateRegionBatch(mysqli $connection, array $records): void
{
    if ($records === []) {
        return;
    }

    $columns = [
        'tipe_level2',
        'tipe_level4',
        'kode_mendagri_1',
        'kode_mendagri_2',
        'kode_mendagri_3',
        'kode_mendagri_4',
    ];
    $assignments = [];
    $values = [];

    foreach ($columns as $index => $column) {
        $case = "`{$column}` = CASE `id_wilayah`";
        foreach ($records as $record) {
            $case .= ' WHEN ? THEN ?';
            $values[] = $record[0];
            $values[] = $record[$index + 1];
        }
        $assignments[] = $case . " ELSE `{$column}` END";
    }

    $ids = array_column($records, 0);
    $values = array_merge($values, $ids);
    $placeholders = implode(', ', array_fill(0, count($ids), '?'));
    $sql = 'UPDATE wilayah SET ' . implode(', ', $assignments)
        . " WHERE id_wilayah IN ({$placeholders})";
    $statement = $connection->prepare($sql);
    $arguments = [str_repeat('s', count($values))];
    foreach ($values as &$value) {
        $arguments[] = &$value;
    }
    unset($value);

    call_user_func_array([$statement, 'bind_param'], $arguments);
    $statement->execute();
    $statement->close();
}

$arguments = array_slice($argv, 1);
if (array_diff($arguments, ['--dry-run']) !== [] || count($arguments) > 1) {
    fwrite(STDERR, "Penggunaan: php _Database/generate_wilayah.php [--dry-run]\n");
    exit(2);
}

$dryRun = in_array('--dry-run', $arguments, true);
$Conn = null;
$transactionStarted = false;

try {
    $provinces = [];
    readRegionCsv('provinces.csv', ['code', 'name'], static function (array $row) use (&$provinces): void {
        requireRegionCode($row['code'], 2, 'provinces.csv');
        $provinces[$row['code']] = trim($row['name']);
    });

    $regencies = [];
    readRegionCsv('regencies.csv', ['code', 'province_code', 'name'], static function (array $row) use (&$regencies, $provinces): void {
        requireRegionCode($row['code'], 4, 'regencies.csv');
        requireRegionCode($row['province_code'], 2, 'regencies.csv');
        if (!isset($provinces[$row['province_code']]) || substr($row['code'], 0, 2) !== $row['province_code']) {
            throw new RuntimeException("Relasi provinsi tidak valid pada kode kabupaten/kota {$row['code']}.");
        }

        $regencies[$row['code']] = [
            'province_code' => $row['province_code'],
            'name' => trim($row['name']),
        ];
    });

    $districts = [];
    readRegionCsv('districts.csv', ['code', 'regency_code', 'name'], static function (array $row) use (&$districts, $regencies): void {
        requireRegionCode($row['code'], 6, 'districts.csv');
        requireRegionCode($row['regency_code'], 4, 'districts.csv');
        if (
            !isset($regencies[$row['regency_code']])
            || substr($row['code'], 0, 4) !== $row['regency_code']
        ) {
            throw new RuntimeException("Relasi kabupaten/kota tidak valid pada kode kecamatan {$row['code']}.");
        }

        $districts[$row['code']] = [
            'regency_code' => $row['regency_code'],
            'name' => trim($row['name']),
        ];
    });

    if (!$dryRun) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        require dirname(__DIR__) . '/_Config/Connection.php';
        $Conn->set_charset('utf8mb4');
        $Conn->query('SELECT province, regency, subdistrict, village FROM wilayah LIMIT 0');

        $existingRecords = $Conn->query(
            'SELECT id_wilayah, province, regency, subdistrict, village, tipe_level2, tipe_level4, '
            . 'kode_mendagri_1, kode_mendagri_2, kode_mendagri_3, kode_mendagri_4 FROM wilayah'
        );
        $existingKeys = [];
        while ($existing = $existingRecords->fetch_row()) {
            $existingKeys[regionRecordKey(array_slice($existing, 1, 4))] = [
                'id' => (string) $existing[0],
                'source_fields' => array_slice($existing, 5, 6),
            ];
        }
        $existingRecords->free();

        $Conn->begin_transaction();
        $transactionStarted = true;
    } else {
        $existingKeys = [];
    }

    $batch = [];
    $updateBatch = [];
    $processedKeys = [];
    $insertedCount = 0;
    $updatedCount = 0;
    $skippedCount = 0;
    readRegionCsv('villages.csv', ['code', 'district_code', 'name', 'postal_code'], static function (array $row) use (
        &$batch,
        &$updateBatch,
        &$existingKeys,
        &$processedKeys,
        &$insertedCount,
        &$updatedCount,
        &$skippedCount,
        $districts,
        $regencies,
        $provinces,
        $Conn,
        $dryRun
    ): void {
        requireRegionCode($row['code'], 10, 'villages.csv');
        requireRegionCode($row['district_code'], 6, 'villages.csv');

        if (
            substr($row['code'], 0, 6) !== $row['district_code']
            || !isset($districts[$row['district_code']])
        ) {
            throw new RuntimeException("Relasi kecamatan tidak valid pada kode desa/kelurahan {$row['code']}.");
        }

        $district = $districts[$row['district_code']];
        $regencyCode = $district['regency_code'];
        $regency = $regencies[$regencyCode];
        $provinceCode = $regency['province_code'];
        $regencyNumber = (int) substr($regencyCode, 2, 2);
        $villageTypeCode = substr($row['code'], 6, 1);

        $villageType = match ($villageTypeCode) {
            '1' => 'Kelurahan',
            '2', '3' => 'Desa',
            default => throw new RuntimeException(
                "Jenis kode desa/kelurahan tidak dikenal pada kode {$row['code']}."
            ),
        };

        $record = [
            $provinces[$provinceCode],
            $regency['name'],
            $district['name'],
            trim($row['name']),
            $regencyNumber >= 71 ? 'Kota' : 'Kabupaten',
            $villageType,
            $provinceCode,
            $regencyCode,
            $row['district_code'],
            $row['code'],
        ];
        $recordKey = regionRecordKey($record);

        if (isset($processedKeys[$recordKey])) {
            $skippedCount++;
            return;
        }
        $processedKeys[$recordKey] = true;

        if (isset($existingKeys[$recordKey])) {
            $sourceFields = array_slice($record, 4, 6);
            $currentFields = array_map(
                static fn ($value): string => (string) ($value ?? ''),
                $existingKeys[$recordKey]['source_fields']
            );

            if ($currentFields === $sourceFields) {
                $skippedCount++;
                return;
            }

            $updateBatch[] = array_merge(
                [$existingKeys[$recordKey]['id']],
                $sourceFields
            );
            $existingKeys[$recordKey]['source_fields'] = $sourceFields;

            if (!$dryRun && count($updateBatch) >= 500) {
                updateRegionBatch($Conn, $updateBatch);
                $updatedCount += count($updateBatch);
                $updateBatch = [];
            }
            return;
        }

        $batch[] = $record;

        if (!$dryRun && count($batch) >= 500) {
            insertRegionBatch($Conn, $batch);
            $insertedCount += count($batch);
            $batch = [];
        }
    });

    if (!$dryRun && $batch !== []) {
        insertRegionBatch($Conn, $batch);
        $insertedCount += count($batch);
    }

    if (!$dryRun && $updateBatch !== []) {
        updateRegionBatch($Conn, $updateBatch);
        $updatedCount += count($updateBatch);
    }

    if ($dryRun) {
        fwrite(STDOUT, "Validasi selesai: " . REGION_DATASET_EXPECTED_COUNTS['villages.csv'] . " data desa/kelurahan, tidak ada perubahan pada basis data.\n");
    } else {
        $Conn->commit();
        $transactionStarted = false;
        fwrite(STDOUT, "Data wilayah berhasil dibuat. Ditambahkan: {$insertedCount}; diperbarui: {$updatedCount}; tidak berubah: {$skippedCount}.\n");
    }
} catch (Throwable $error) {
    if ($transactionStarted && $Conn instanceof mysqli) {
        $Conn->rollback();
    }

    fwrite(STDERR, "Gagal membuat data wilayah: {$error->getMessage()}\n");
    exit(1);
}

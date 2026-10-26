<?php
header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__, 2) . '/_Config/Connection.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$Conn->set_charset('utf8mb4');

$level = $_POST['level'] ?? 'province';
$level = is_string($level) ? $level : '';
$parentCode = $_POST['parent_code'] ?? '';
$parentCode = is_string($parentCode) ? trim($parentCode) : '';

$queries = [
    'province' => [
        'sql' => "
            SELECT
                kode_mendagri_1 AS code,
                province AS name,
                COUNT(DISTINCT kode_mendagri_2) AS regency_count,
                COUNT(DISTINCT kode_mendagri_3) AS district_count,
                COUNT(DISTINCT kode_mendagri_4) AS village_count
            FROM wilayah
            WHERE kode_mendagri_1 IS NOT NULL
            GROUP BY kode_mendagri_1, province
            ORDER BY province, kode_mendagri_1
        ",
        'code_length' => 0,
    ],
    'regency' => [
        'sql' => "
            SELECT
                kode_mendagri_2 AS code,
                regency AS name,
                tipe_level2 AS type,
                COUNT(DISTINCT kode_mendagri_3) AS district_count,
                COUNT(DISTINCT kode_mendagri_4) AS village_count
            FROM wilayah
            WHERE kode_mendagri_1 = ?
            GROUP BY kode_mendagri_2, regency, tipe_level2
            ORDER BY regency, kode_mendagri_2
        ",
        'code_length' => 2,
    ],
    'district' => [
        'sql' => "
            SELECT
                kode_mendagri_3 AS code,
                subdistrict AS name,
                COUNT(DISTINCT kode_mendagri_4) AS village_count
            FROM wilayah
            WHERE kode_mendagri_2 = ?
            GROUP BY kode_mendagri_3, subdistrict
            ORDER BY subdistrict, kode_mendagri_3
        ",
        'code_length' => 4,
    ],
    'village' => [
        'sql' => "
            SELECT
                kode_mendagri_4 AS code,
                village AS name,
                tipe_level4 AS type
            FROM wilayah
            WHERE kode_mendagri_3 = ?
            GROUP BY kode_mendagri_4, village, tipe_level4
            ORDER BY village, kode_mendagri_4
        ",
        'code_length' => 6,
    ],
];

try {
    if (!isset($queries[$level])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Tingkat wilayah tidak valid.']);
        exit;
    }

    $query = $queries[$level];
    if (
        $level !== 'province'
        && (
            strlen($parentCode) !== $query['code_length']
            || !ctype_digit($parentCode)
        )
    ) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Kode wilayah induk tidak valid.']);
        exit;
    }

    $statement = $Conn->prepare($query['sql']);
    if ($query['code_length'] > 0) {
        $statement->bind_param('s', $parentCode);
    }
    $statement->execute();
    $result = $statement->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $statement->close();

    echo json_encode([
        'status' => 'success',
        'level' => $level,
        'rows' => $rows,
    ], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
} catch (Throwable $error) {
    error_log('Gagal memuat daftar grup wilayah: ' . $error->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Data wilayah gagal dimuat. Periksa koneksi basis data dan coba lagi.',
    ], JSON_UNESCAPED_UNICODE);
}

<?php
// Mengimpor file XLSX ICD secara langsung tanpa menyimpan status unggahan pada tabel terpisah.
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

/** Mengirim respons JSON error lalu menghentikan proses impor. */
function icdImportError(string $message, int $statusCode = 400): void
{
    http_response_code($statusCode);
    echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// Periksa sesi, metode request, dan berkas sebelum membuka spreadsheet.
if (empty($SessionIdAkses)) {
    icdImportError('Sesi berakhir. Silakan login kembali.', 401);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    icdImportError('Metode request tidak valid.', 405);
}
if (empty($_FILES['file_upload']) || !is_array($_FILES['file_upload'])) {
    icdImportError('File tidak ditemukan.');
}
$file = $_FILES['file_upload'];
if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    icdImportError('File gagal diunggah.');
}
if (($file['size'] ?? 0) > 10 * 1024 * 1024) {
    icdImportError('Ukuran file maksimal 10 MB.');
}
if (strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION)) !== 'xlsx') {
    icdImportError('File harus berformat XLSX.');
}

require '../../vendor/autoload.php';

try {
    // Baca isi file sementara langsung dari PHP agar tidak perlu disimpan atau dicatat pada tabel log.
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($file['tmp_name']);
    $rows = $spreadsheet->getActiveSheet()->toArray();
    array_shift($rows);

    // Siapkan statement sekali untuk seluruh baris impor.
    $stmtCheck = mysqli_prepare($Conn, 'SELECT id_icd FROM icd WHERE kode = ? LIMIT 1');
    $stmtInsert = mysqli_prepare($Conn, 'INSERT INTO icd (kode, short_des, long_des, icd) VALUES (?, ?, ?, ?)');
    if (!$stmtCheck || !$stmtInsert) {
        if ($stmtCheck) {
            mysqli_stmt_close($stmtCheck);
        }
        if ($stmtInsert) {
            mysqli_stmt_close($stmtInsert);
        }
        throw new RuntimeException('Gagal menyiapkan proses impor ICD.');
    }

    if (!mysqli_begin_transaction($Conn)) {
        mysqli_stmt_close($stmtCheck);
        mysqli_stmt_close($stmtInsert);
        throw new RuntimeException('Gagal memulai proses impor ICD.');
    }

    $inserted = 0;
    $skipped = 0;
    foreach ($rows as $row) {
        $icd = trim((string) ($row[1] ?? ''));
        $kode = trim((string) ($row[2] ?? ''));
        $shortDescription = trim((string) ($row[3] ?? ''));
        $longDescription = trim((string) ($row[4] ?? ''));
        if ($kode === '') {
            $skipped++;
            continue;
        }
        if (!in_array($icd, ['ICD9', 'ICD10', 'ICD11'], true)) {
            throw new DomainException('Versi ICD untuk kode ' . $kode . ' tidak valid.');
        }

        mysqli_stmt_bind_param($stmtCheck, 's', $kode);
        if (!mysqli_stmt_execute($stmtCheck)) {
            throw new RuntimeException('Gagal memeriksa kode ICD ' . $kode . '.');
        }
        mysqli_stmt_store_result($stmtCheck);
        if (mysqli_stmt_num_rows($stmtCheck) > 0) {
            $skipped++;
            continue;
        }

        mysqli_stmt_bind_param($stmtInsert, 'ssss', $kode, $shortDescription, $longDescription, $icd);
        if (!mysqli_stmt_execute($stmtInsert)) {
            throw new RuntimeException('Gagal menyimpan kode ICD ' . $kode . '.');
        }
        $inserted++;
    }

    mysqli_stmt_close($stmtCheck);
    mysqli_stmt_close($stmtInsert);
    if (!mysqli_commit($Conn)) {
        throw new RuntimeException('Gagal menyelesaikan proses impor ICD.');
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Import selesai. ' . $inserted . ' data ditambahkan, ' . $skipped . ' baris dilewati.',
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $exception) {
    mysqli_rollback($Conn);
    error_log('Import ICD: ' . $exception->getMessage());
    icdImportError('Import data ICD gagal diproses.', 500);
}

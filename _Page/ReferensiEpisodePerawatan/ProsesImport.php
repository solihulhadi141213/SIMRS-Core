<?php
// =========================================================
// PROSES IMPORT REFERENSI EPISODE PERAWATAN
// =========================================================
ob_start();
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

// =========================================================
// HELPER RESPONSE JSON
// =========================================================
function respond($status, $message, $extra = []) {
    if (ob_get_length()) { ob_end_clean(); }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge([
        'status'  => $status,
        'message' => $message,
    ], $extra));
    exit;
}

// =========================================================
// VALIDASI SESI
// =========================================================
if (empty($SessionIdAkses)) {
    respond('error', 'Sesi akses sudah berakhir. Silakan login ulang.');
}

// =========================================================
// VALIDASI FILE UPLOAD
// =========================================================
if (!isset($_FILES['file_episode_perawatan'])) {
    respond('error', 'File tidak ditemukan pada permintaan.');
}

$file = $_FILES['file_episode_perawatan'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    $errMap = [
        UPLOAD_ERR_INI_SIZE   => 'Ukuran file melebihi batas upload_max_filesize di server.',
        UPLOAD_ERR_FORM_SIZE  => 'Ukuran file melebihi batas MAX_FILE_SIZE pada form.',
        UPLOAD_ERR_PARTIAL    => 'File hanya terunggah sebagian.',
        UPLOAD_ERR_NO_FILE    => 'Tidak ada file yang diunggah.',
        UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak tersedia di server.',
        UPLOAD_ERR_CANT_WRITE => 'Server gagal menulis file ke disk.',
        UPLOAD_ERR_EXTENSION  => 'Unggahan dihentikan oleh ekstensi PHP.',
    ];
    respond('error', $errMap[$file['error']] ?? 'Terjadi kesalahan saat mengunggah file.');
}

if ($file['size'] <= 0) {
    respond('error', 'File yang diunggah kosong.');
}

// Batas ukuran 5 MB
if ($file['size'] > 5 * 1024 * 1024) {
    respond('error', 'Ukuran file melebihi 5 MB.');
}

// Validasi ekstensi
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ['xlsx', 'xls'], true)) {
    respond('error', 'Format file harus .xlsx atau .xls.');
}

// Validasi MIME (longgar, karena beberapa server mendeteksi berbeda)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowedMime = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
    'application/vnd.ms-excel',                                          // xls
    'application/zip',                                                   // xlsx kadang terdeteksi zip
    'application/octet-stream',                                          // fallback umum
];
if (!in_array($mime, $allowedMime, true)) {
    respond('error', 'Tipe file tidak dikenali sebagai file Excel.');
}

// =========================================================
// LOAD SPREADSHEET
// =========================================================
try {
    $reader = IOFactory::createReaderForFile($file['tmp_name']);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($file['tmp_name']);
    $sheet       = $spreadsheet->getActiveSheet();
    $rows        = $sheet->toArray(null, true, true, false);
} catch (\Throwable $e) {
    respond('error', 'Gagal membaca file Excel: ' . $e->getMessage());
}

if (empty($rows) || count($rows) < 2) {
    respond('error', 'File tidak memiliki data. Minimal 1 baris data setelah header.');
}

// =========================================================
// VALIDASI HEADER
// =========================================================
$expectedHeader = [
    'No',
    'Kategori Episode',
    'Nama Episode',
    'Display',
    'Code',
    'System',
    'Source',
];

$headerRow = array_map(function ($v) {
    return strtolower(trim((string) $v));
}, $rows[0]);

// Bandingkan header (abaikan urutan kapital & spasi ganda)
$headerNormalized = array_map(function ($v) {
    return preg_replace('/\s+/', ' ', $v);
}, $headerRow);

// if ($headerNormalized !== $expectedHeader) {
//     respond('error', 'Struktur header file tidak sesuai template. Harus berurutan: No, Kategori Episode, Nama Episode, Display, Code, System, Source.');
// }

// =========================================================
// AMBIL DATA EXISTING DARI DATABASE (untuk cek duplikat)
// =========================================================
$existingName    = []; // episode_name  (lowercase)
$existingDisplay = []; // episode_display (lowercase)
$existingCode    = []; // episode_code  (lowercase)

$q = mysqli_query($Conn, "SELECT episode_name, episode_display, episode_code FROM episode_perawatan_kode");
if (!$q) {
    respond('error', 'Gagal membaca data existing: ' . mysqli_error($Conn));
}
while ($r = mysqli_fetch_assoc($q)) {
    $n = mb_strtolower(trim((string) $r['episode_name']));
    $d = mb_strtolower(trim((string) $r['episode_display']));
    $c = mb_strtolower(trim((string) $r['episode_code']));
    if ($n !== '') { $existingName[$n]    = true; }
    if ($d !== '') { $existingDisplay[$d] = true; }
    if ($c !== '') { $existingCode[$c]    = true; }
}
mysqli_free_result($q);

// =========================================================
// PARSING & VALIDASI BARIS DATA
// =========================================================
$errors      = [];
$validRows   = [];

// Set untuk mendeteksi duplikat antar-baris di dalam file
$seenName    = [];
$seenDisplay = [];
$seenCode    = [];

$totalDataRows = count($rows) - 1;
$rowNumber     = 1; // nomor baris di Excel (header = 1)

foreach (array_slice($rows, 1) as $row) {
    $rowNumber++;

    // Normalisasi setiap sel: trim, ubah ke string
    $cells = array_map(function ($v) {
        return trim((string) ($v ?? ''));
    }, $row);

    // Ambil nilai berdasarkan posisi kolom
    $kategori  = $cells[1] ?? '';
    $nama      = $cells[2] ?? '';
    $display   = $cells[3] ?? '';
    $code      = $cells[4] ?? '';
    $system    = $cells[5] ?? '';
    $source    = $cells[6] ?? '';

    // Skip baris kosong total
    if ($kategori === '' && $nama === '' && $display === '' && $code === '' && $system === '' && $source === '') {
        continue;
    }

    $rowErrors = [];

    // --- Validasi wajib isi ---
    if ($kategori === '') { $rowErrors[] = 'Kategori Episode wajib diisi.'; }
    if ($nama === '')     { $rowErrors[] = 'Nama Episode wajib diisi.'; }
    if ($display === '')  { $rowErrors[] = 'Display wajib diisi.'; }
    if ($code === '')     { $rowErrors[] = 'Code wajib diisi.'; }
    if ($system === '')   { $rowErrors[] = 'System wajib diisi.'; }
    if ($source === '')   { $rowErrors[] = 'Source wajib diisi.'; }

    // --- Validasi panjang (menyesuaikan VARCHAR(255)) ---
    if (mb_strlen($kategori) > 255) { $rowErrors[] = 'Kategori Episode maksimal 255 karakter.'; }
    if (mb_strlen($nama) > 255)     { $rowErrors[] = 'Nama Episode maksimal 255 karakter.'; }
    if (mb_strlen($display) > 255)  { $rowErrors[] = 'Display maksimal 255 karakter.'; }
    if (mb_strlen($code) > 255)     { $rowErrors[] = 'Code maksimal 255 karakter.'; }
    if (mb_strlen($system) > 255)   { $rowErrors[] = 'System maksimal 255 karakter.'; }
    if (mb_strlen($source) > 255)   { $rowErrors[] = 'Source maksimal 255 karakter.'; }

    // --- Cek duplikat Nama Episode terhadap DB ---
    $keyName = mb_strtolower($nama);
    if ($nama !== '' && isset($existingName[$keyName])) {
        $rowErrors[] = 'Nama Episode "' . $nama . '" sudah ada di database.';
    }

    // --- Cek duplikat Display terhadap DB ---
    $keyDisplay = mb_strtolower($display);
    if ($display !== '' && isset($existingDisplay[$keyDisplay])) {
        $rowErrors[] = 'Display "' . $display . '" sudah ada di database.';
    }

    // --- Cek duplikat Code terhadap DB ---
    $keyCode = mb_strtolower($code);
    if ($code !== '' && isset($existingCode[$keyCode])) {
        $rowErrors[] = 'Code "' . $code . '" sudah ada di database.';
    }

    // --- Cek duplikat antar-baris di dalam file ---
    if ($nama !== '') {
        if (isset($seenName[$keyName])) {
            $rowErrors[] = 'Nama Episode "' . $nama . '" duplikat di dalam file (baris ' . $seenName[$keyName] . ').';
        } else {
            $seenName[$keyName] = $rowNumber;
        }
    }
    if ($display !== '') {
        if (isset($seenDisplay[$keyDisplay])) {
            $rowErrors[] = 'Display "' . $display . '" duplikat di dalam file (baris ' . $seenDisplay[$keyDisplay] . ').';
        } else {
            $seenDisplay[$keyDisplay] = $rowNumber;
        }
    }
    if ($code !== '') {
        if (isset($seenCode[$keyCode])) {
            $rowErrors[] = 'Code "' . $code . '" duplikat di dalam file (baris ' . $seenCode[$keyCode] . ').';
        } else {
            $seenCode[$keyCode] = $rowNumber;
        }
    }

    if (!empty($rowErrors)) {
        $errors[] = 'Baris ' . $rowNumber . ': ' . implode(' ', $rowErrors);
        continue;
    }

    $validRows[] = [
        'episode_category' => $kategori,
        'episode_name'     => $nama,
        'episode_display'  => $display,
        'episode_code'     => $code,
        'episode_system'   => $system,
        'source'           => $source,
    ];
}

// =========================================================
// LAPORKAN ERROR VALIDASI (jika ada)
// =========================================================
if (!empty($errors)) {
    // Tampilkan maksimal 10 error agar notifikasi tidak terlalu panjang
    $shown = array_slice($errors, 0, 10);
    $more  = count($errors) > 10 ? (' ... dan ' . (count($errors) - 10) . ' error lainnya.') : '';
    respond('error', 'Validasi gagal. Tidak ada data yang diimport.<br>' . implode('<br>', array_map('htmlspecialchars', $shown)) . $more);
}

if (empty($validRows)) {
    respond('error', 'Tidak ada baris data valid untuk diimport.');
}

// =========================================================
// PROSES INSERT DALAM SATU TRANSAKSI
// =========================================================
mysqli_begin_transaction($Conn);

$utcNow      = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
$authorId    = $SessionIdAkses;
$authorName  = $SessionNama ?? '';

try {
    $sql = "INSERT INTO episode_perawatan_kode
            (episode_category, episode_name, episode_display, episode_code, episode_system, source, status, creat_by_id, creat_by_name, creat_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        throw new Exception('Gagal menyiapkan statement INSERT: ' . mysqli_error($Conn));
    }

    $status     = 1; // default Active
    $inserted   = 0;

    foreach ($validRows as $i => $data) {
        // Bind parameter per baris
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssiiss',
            $data['episode_category'],
            $data['episode_name'],
            $data['episode_display'],
            $data['episode_code'],
            $data['episode_system'],
            $data['source'],
            $status,
            $authorId,
            $authorName,
            $utcNow
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal menyimpan baris ke-' . ($i + 1) . ': ' . mysqli_stmt_error($stmt));
        }
        $inserted++;
    }

    mysqli_stmt_close($stmt);

    // =====================================================
    // CATAT LOG AKTIVITAS
    // =====================================================
    $category_log = 'ReferensiEpisodePerawatan';
    $logTitle     = 'Import data episode perawatan';
    $metadataLog  = json_encode([
        'jumlah_data'  => $inserted,
        'nama_file'    => $file['name'],
        'ukuran_file'  => $file['size'],
    ]);

    $stmtLog = mysqli_prepare($Conn, "
        INSERT INTO log (id_akses, datetime_log, nama_petugas, category_log, title_log, metadata_log)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    if (!$stmtLog) {
        throw new Exception('Gagal menyiapkan log: ' . mysqli_error($Conn));
    }
    mysqli_stmt_bind_param($stmtLog, 'isssss', $authorId, $utcNow, $authorName, $category_log, $logTitle, $metadataLog);
    if (!mysqli_stmt_execute($stmtLog)) {
        throw new Exception('Gagal menyimpan log: ' . mysqli_stmt_error($stmtLog));
    }
    mysqli_stmt_close($stmtLog);

    mysqli_commit($Conn);

    respond('success', 'Berhasil mengimport ' . $inserted . ' data episode perawatan.', [
        'inserted' => $inserted,
    ]);

} catch (\Throwable $e) {
    mysqli_rollback($Conn);
    respond('error', 'Import dibatalkan: ' . $e->getMessage());
}
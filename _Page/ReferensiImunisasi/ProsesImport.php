<?php
    // =========================================================
    // IMPORT DATA REFERENSI IMUNISASI
    // =========================================================

    header('Content-Type: application/json; charset=utf-8');
    ob_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    function sendResponse($data)
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (empty($SessionIdAkses)) {
        sendResponse(['status' => 'error', 'message' => 'Sesi akses sudah berakhir!']);
    }

    if (empty($_FILES['import_file']['tmp_name'])) {
        sendResponse(['status' => 'error', 'message' => 'File excel tidak ditemukan!']);
    }

    $fileTmp  = $_FILES['import_file']['tmp_name'];
    $fileName = $_FILES['import_file']['name'];
    $fileSize = (int) ($_FILES['import_file']['size'] ?? 0);
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, ['xlsx', 'xls'])) {
        sendResponse(['status' => 'error', 'message' => 'Format file harus xlsx atau xls!']);
    }
    if ($fileSize > 5 * 1024 * 1024) {
        sendResponse(['status' => 'error', 'message' => 'Maksimal ukuran file adalah 5 MB!']);
    }

    try {
        $spreadsheet = IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false);
    } catch (Exception $e) {
        sendResponse(['status' => 'error', 'message' => 'Gagal membaca file excel!', 'debug' => $e->getMessage()]);
    }

    if (count($rows) <= 1) {
        sendResponse(['status' => 'error', 'message' => 'Data excel kosong!']);
    }

    $expectedHeader = ['No','Nama Vaksin','Kode CVX','Kode Kemenkes','Display Vaksin','System Vaksin','Target Penyakit'];
    $header = array_map(function ($v) { return trim((string)$v); }, $rows[0]);
    $normalizedHeader = array_map('mb_strtolower', $header);
    $expectedNormalized = array_map('mb_strtolower', $expectedHeader);
    if ($normalizedHeader !== $expectedNormalized) {
        sendResponse(['status' => 'error', 'message' => 'Struktur header template tidak sesuai! Harus: ' . implode(', ', $expectedHeader)]);
    }

    function normalizeValue($value) {
        $value = trim((string)$value);
        if ($value === '' || $value === '-') return null;
        return $value;
    }

    $inserted = 0;
    $failed   = 0;
    $detail   = [];
    $seenCvx      = [];
    $seenKemenkes = [];
    $existingCvx      = [];
    $existingKemenkes = [];
    $resExisting = mysqli_query($Conn, "SELECT kode_cvx, kode_kemenkes FROM imunisasi_referensi");
    if ($resExisting) {
        while ($rExist = mysqli_fetch_assoc($resExisting)) {
            if (!empty($rExist['kode_cvx'])) $existingCvx[] = (string)$rExist['kode_cvx'];
            if (!empty($rExist['kode_kemenkes'])) $existingKemenkes[] = (string)$rExist['kode_kemenkes'];
        }
    }
    $authorId   = (int)$SessionIdAkses;
    $authorName = (string)($SessionNama ?? '');

    // =========================================================
    // LOOP DATA
    // =========================================================

    for ($i = 1; $i < count($rows); $i++) {
        $row = $rows[$i];
        $excelRow = $i + 1;

        $allEmpty = true;
        foreach ($row as $v) {
            if (trim((string)$v) !== '') { $allEmpty = false; break; }
        }
        if ($allEmpty) continue;

        $nama_vaksin     = normalizeValue($row[1] ?? null);
        $kode_cvx        = normalizeValue($row[2] ?? null);
        $kode_kemenkes   = normalizeValue($row[3] ?? null);
        $display_vaksin  = normalizeValue($row[4] ?? null);
        $system_vaksin   = normalizeValue($row[5] ?? null);
        $target_penyakit = normalizeValue($row[6] ?? null);

        if (empty($nama_vaksin)) {
            $failed++;
            $detail[] = ['no'=>$excelRow,'nama_vaksin'=>'-','status'=>'GAGAL','keterangan'=>'Nama vaksin kosong (mandatory)'];
            continue;
        }

        $dupMsg = null;
        if (!empty($kode_cvx)) {
            if (in_array($kode_cvx, $existingCvx, true) || in_array($kode_cvx, $seenCvx, true)) {
                $dupMsg = 'Kode CVX duplikat: ' . $kode_cvx;
            }
        }
        if ($dupMsg === null && !empty($kode_kemenkes)) {
            if (in_array($kode_kemenkes, $existingKemenkes, true) || in_array($kode_kemenkes, $seenKemenkes, true)) {
                $dupMsg = 'Kode Kemenkes duplikat: ' . $kode_kemenkes;
            }
        }
        if ($dupMsg !== null) {
            $failed++;
            $detail[] = ['no'=>$excelRow,'nama_vaksin'=>$nama_vaksin,'status'=>'GAGAL','keterangan'=>$dupMsg];
            continue;
        }

        if (!empty($kode_cvx)) $seenCvx[] = $kode_cvx;
        if (!empty($kode_kemenkes)) $seenKemenkes[] = $kode_kemenkes;

        $stmt = mysqli_prepare($Conn, "INSERT INTO imunisasi_referensi (nama_vaksin, kode_cvx, kode_kemenkes, display_vaksin, system_vaksin, target_penyakit, status, datetime_creat, author_id, author_name) VALUES (?,?,?,?,?,?,?,?,?,?)");
        if (!$stmt) {
            $failed++;
            $detail[] = ['no'=>$excelRow,'nama_vaksin'=>$nama_vaksin,'status'=>'GAGAL','keterangan'=>'Gagal menyiapkan query: ' . mysqli_error($Conn)];
            continue;
        }
        $status = 1;
        $datetime_creat = date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($stmt, 'ssssssisis', $nama_vaksin, $kode_cvx, $kode_kemenkes, $display_vaksin, $system_vaksin, $target_penyakit, $status, $datetime_creat, $authorId, $authorName);
        if (!mysqli_stmt_execute($stmt)) {
            $failed++;
            $detail[] = ['no'=>$excelRow,'nama_vaksin'=>$nama_vaksin,'status'=>'GAGAL','keterangan'=>mysqli_stmt_error($stmt)];
            mysqli_stmt_close($stmt);
            continue;
        }
        $inserted++;
        $detail[] = ['no'=>$excelRow,'nama_vaksin'=>$nama_vaksin,'status'=>'INSERT','keterangan'=>'Berhasil insert data'];
        mysqli_stmt_close($stmt);
    }

    sendResponse(['status'=>'success','message'=>"Insert : $inserted | Gagal : $failed",'detail'=>$detail]);
?>

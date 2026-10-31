<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    if (empty($SessionIdAkses)) {
        if (ob_get_length()) { ob_end_clean(); }
        if (($_POST['mode'] ?? $_GET['mode'] ?? '') === 'count') {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['jumlah' => 0]);
            exit;
        }
        exit('Sesi akses sudah berakhir');
    }

    $mode = (string)($_POST['mode'] ?? $_GET['mode'] ?? '');
    $periodeData = (string)($_POST['periode_data'] ?? $_GET['periode_data'] ?? 'Semua');

    // Build where based on datetime_creat
    $where = [];
    $params = [];
    $types = '';

    if ($periodeData === 'Tahun') {
        $tahun = trim((string)($_POST['tahun'] ?? $_GET['tahun'] ?? ''));
        if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
            if ($mode === 'count') {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['jumlah' => 0]);
                exit;
            }
            if (ob_get_length()) { ob_end_clean(); }
            exit('Tahun tidak valid');
        }
        $where[] = 'YEAR(i.datetime_creat) = ?';
        $params[] = (int)$tahun;
        $types .= 'i';
    } elseif ($periodeData === 'Bulan') {
        $tahun = trim((string)($_POST['tahun'] ?? $_GET['tahun'] ?? ''));
        $bulan = trim((string)($_POST['bulan'] ?? $_GET['bulan'] ?? ''));
        if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
            if ($mode === 'count') { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['jumlah' => 0]); exit; }
            if (ob_get_length()) { ob_end_clean(); } exit('Tahun tidak valid');
        }
        if ($bulan === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) {
            if ($mode === 'count') { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['jumlah' => 0]); exit; }
            if (ob_get_length()) { ob_end_clean(); } exit('Bulan tidak valid');
        }
        $where[] = 'YEAR(i.datetime_creat) = ? AND MONTH(i.datetime_creat) = ?';
        $params[] = (int)$tahun;
        $params[] = (int)$bulan;
        $types .= 'ii';
    } elseif ($periodeData === 'Periodik') {
        $awal = trim((string)($_POST['periode_awal'] ?? $_GET['periode_awal'] ?? ''));
        $akhir = trim((string)($_POST['periode_akhir'] ?? $_GET['periode_akhir'] ?? ''));
        $dAwal = DateTime::createFromFormat('Y-m-d', $awal);
        $dAkhir = DateTime::createFromFormat('Y-m-d', $akhir);
        if (!$dAwal || $dAwal->format('Y-m-d') !== $awal || !$dAkhir || $dAkhir->format('Y-m-d') !== $akhir) {
            if ($mode === 'count') { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['jumlah' => 0]); exit; }
            if (ob_get_length()) { ob_end_clean(); } exit('Format periode tidak valid');
        }
        if ($dAwal > $dAkhir) {
            if ($mode === 'count') { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['jumlah' => 0]); exit; }
            if (ob_get_length()) { ob_end_clean(); } exit('Periode awal tidak boleh lebih besar dari periode akhir');
        }
        $where[] = 'DATE(i.datetime_creat) >= ? AND DATE(i.datetime_creat) <= ?';
        $params[] = $awal;
        $params[] = $akhir;
        $types .= 'ss';
    } elseif ($periodeData !== 'Semua') {
        if ($mode === 'count') { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['jumlah' => 0]); exit; }
        if (ob_get_length()) { ob_end_clean(); } exit('Periode data tidak valid');
    }

    $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // =========================================================
    // MODE COUNT
    // =========================================================
    if ($mode === 'count') {
        $queryCount = "SELECT COUNT(*) AS total FROM imunisasi i $whereSql";
        $stmtCount = mysqli_prepare($Conn, $queryCount);
        if (!$stmtCount) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['jumlah' => 0]);
            exit;
        }
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmtCount, $types, ...$params);
        }
        mysqli_stmt_execute($stmtCount);
        $resultCount = mysqli_stmt_get_result($stmtCount);
        $dataCount = mysqli_fetch_assoc($resultCount);
        mysqli_stmt_close($stmtCount);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['jumlah' => (int)($dataCount['total'] ?? 0)]);
        exit;
    }

    // =========================================================
    // EXPORT
    // =========================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        if (ob_get_length()) { ob_end_clean(); }
        exit('Metode request tidak valid');
    }

    // =========================================================
    // QUERY DATA
    // =========================================================
    $query = "
        SELECT
            i.id_imunisasi,
            i.id_pasien,
            p.nama AS nama_pasien,
            i.tanggal_pemberian,
            i.id_immunization,
            r.nama_vaksin,
            i.status_imunisasi,
            i.body_site_nama,
            i.praktisi_nama,
            i.datetime_creat
        FROM imunisasi i
        LEFT JOIN pasien p ON i.id_pasien = p.id_pasien
        LEFT JOIN imunisasi_referensi r ON i.id_imunisasi_referensi = r.id_imunisasi_referensi
        $whereSql
        ORDER BY i.id_imunisasi ASC
    ";

    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        if (ob_get_length()) { ob_end_clean(); }
        exit('Gagal menyiapkan query export.');
    }
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // =========================================================
    // SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Imunisasi');

    $header = ['No','No. RM','Nama Pasien','Tanggal Pemberian','ID Imunization','Nama Vaksin','Status','Body Site','Praktisi','Datetime Creat'];
    $lastCol = 'J';

    $col = 'A';
    foreach ($header as $item) {
        $sheet->setCellValue($col . '1', $item);
        $col++;
    }

    $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN]
        ]
    ]);

    $rowNum = 2;
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNum, $no);
        $sheet->setCellValue('B' . $rowNum, $row['id_pasien'] ?? '');
        $sheet->setCellValue('C' . $rowNum, html_entity_decode((string)($row['nama_pasien'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('D' . $rowNum, !empty($row['tanggal_pemberian']) ? date('d/m/Y', strtotime((string)$row['tanggal_pemberian'])) : '');
        $sheet->setCellValue('E' . $rowNum, html_entity_decode((string)($row['id_immunization'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('F' . $rowNum, html_entity_decode((string)($row['nama_vaksin'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('G' . $rowNum, html_entity_decode((string)($row['status_imunisasi'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('H' . $rowNum, html_entity_decode((string)($row['body_site_nama'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('I' . $rowNum, html_entity_decode((string)($row['praktisi_nama'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('J' . $rowNum, $row['datetime_creat'] ?? '');

        $sheet->getStyle('A' . $rowNum . ':' . $lastCol . $rowNum)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $rowNum++;
        $no++;
    }

    mysqli_stmt_close($stmt);

    foreach (range('A', $lastCol) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->freezePane('A2');

    if (ob_get_length()) {
        ob_end_clean();
    }

    $suffix = 'Semua_' . date('YmdHis');
    if ($periodeData === 'Tahun') {
        $suffix = trim((string)($_POST['tahun'] ?? $_GET['tahun'] ?? '')) . '_' . date('YmdHis');
    } elseif ($periodeData === 'Bulan') {
        $suffix = trim((string)($_POST['tahun'] ?? $_GET['tahun'] ?? '')) . trim((string)($_POST['bulan'] ?? $_GET['bulan'] ?? '')) . '_' . date('YmdHis');
    } elseif ($periodeData === 'Periodik') {
        $suffix = trim((string)($_POST['periode_awal'] ?? $_GET['periode_awal'] ?? '')) . '_sd_' . trim((string)($_POST['periode_akhir'] ?? $_GET['periode_akhir'] ?? '')) . '_' . date('YmdHis');
    }

    $filename = 'Data_Imunisasi_' . $suffix . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>


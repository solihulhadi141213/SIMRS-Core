<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        exit('Sesi akses sudah berakhir');
    }

    // =========================================================
    // HELPER STOP
    // =========================================================
    function stopExportReferensiImunisasi(string $message): void
    {
        if (ob_get_length()) {
            ob_end_clean();
        }
        exit($message);
    }

    // =========================================================
    // TANGKAP INPUT (POST / GET)
    // =========================================================
    $periodeData = trim((string) ($_POST['periode_data'] ?? $_GET['periode_data'] ?? 'Semua'));

    // =========================================================
    // BUILD WHERE (berdasarkan datetime_creat)
    // =========================================================
    $where  = [];
    $params = [];
    $types  = '';

    if ($periodeData === 'Tahun') {
        $tahun = trim((string) ($_POST['tahun'] ?? $_GET['tahun'] ?? ''));
        if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
            stopExportReferensiImunisasi('Tahun tidak valid!');
        }
        $where[]  = 'YEAR(datetime_creat) = ?';
        $params[] = (int) $tahun;
        $types   .= 'i';
    } elseif ($periodeData === 'Bulan') {
        $tahun = trim((string) ($_POST['tahun'] ?? $_GET['tahun'] ?? ''));
        $bulan = trim((string) ($_POST['bulan'] ?? $_GET['bulan'] ?? ''));
        if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
            stopExportReferensiImunisasi('Tahun tidak valid!');
        }
        if ($bulan === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) {
            stopExportReferensiImunisasi('Bulan tidak valid!');
        }
        $where[]  = 'YEAR(datetime_creat) = ? AND MONTH(datetime_creat) = ?';
        $params[] = (int) $tahun;
        $params[] = (int) $bulan;
        $types   .= 'ii';
    } elseif ($periodeData === 'Periodik') {
        $awal  = trim((string) ($_POST['periode_awal'] ?? $_GET['periode_awal'] ?? ''));
        $akhir = trim((string) ($_POST['periode_akhir'] ?? $_GET['periode_akhir'] ?? ''));
        $dAwal  = DateTime::createFromFormat('Y-m-d', $awal);
        $dAkhir = DateTime::createFromFormat('Y-m-d', $akhir);
        if (!$dAwal || $dAwal->format('Y-m-d') !== $awal || !$dAkhir || $dAkhir->format('Y-m-d') !== $akhir) {
            stopExportReferensiImunisasi('Format periode tidak valid!');
        }
        if ($dAwal > $dAkhir) {
            stopExportReferensiImunisasi('Periode awal tidak boleh lebih besar dari periode akhir!');
        }
        $where[]  = 'DATE(datetime_creat) >= ? AND DATE(datetime_creat) <= ?';
        $params[] = $awal;
        $params[] = $akhir;
        $types   .= 'ss';
    } elseif ($periodeData !== 'Semua') {
        stopExportReferensiImunisasi('Periode data tidak valid!');
    }

    $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // =========================================================
    // BUAT SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Referensi Imunisasi');

    // =========================================================
    // HEADER TABEL
    // =========================================================
    $headers = [
        'No',
        'ID Referensi',
        'Nama Vaksin',
        'Kode CVX',
        'Kode Kemenkes',
        'Display Vaksin',
        'System Vaksin',
        'Target Penyakit',
        'Status',
        'Tanggal Dibuat',
        'Author'
    ];

    $col = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($col . '1', $h);
        $col++;
    }
    $lastCol = chr(ord('A') + count($headers) - 1);

    $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '0D6EFD']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN]
        ]
    ]);

    // =========================================================
    // QUERY DATA
    // =========================================================
    $sql = "
        SELECT
            id_imunisasi_referensi,
            nama_vaksin,
            kode_cvx,
            kode_kemenkes,
            display_vaksin,
            system_vaksin,
            target_penyakit,
            status,
            datetime_creat,
            author_name
        FROM imunisasi_referensi
        " . $whereSql . "
        ORDER BY id_imunisasi_referensi DESC
    ";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        stopExportReferensiImunisasi('Gagal menyiapkan query export: ' . mysqli_error($Conn));
    }
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        stopExportReferensiImunisasi('Gagal mengambil data export: ' . mysqli_stmt_error($stmt));
    }
    $result = mysqli_stmt_get_result($stmt);

    // =========================================================
    // LOOP DATA
    // =========================================================
    $rowNum = 2;
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $status = ((int) ($row['status'] ?? 0) === 1) ? 'Aktif' : 'Non-aktif';

        $sheet->setCellValue('A' . $rowNum, $no);
        $sheet->setCellValue('B' . $rowNum, $row['id_imunisasi_referensi'] ?? '');
        $sheet->setCellValue('C' . $rowNum, html_entity_decode((string)($row['nama_vaksin'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('D' . $rowNum, html_entity_decode((string)($row['kode_cvx'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('E' . $rowNum, html_entity_decode((string)($row['kode_kemenkes'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('F' . $rowNum, html_entity_decode((string)($row['display_vaksin'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('G' . $rowNum, html_entity_decode((string)($row['system_vaksin'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('H' . $rowNum, html_entity_decode((string)($row['target_penyakit'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('I' . $rowNum, $status);
        $sheet->setCellValue('J' . $rowNum, $row['datetime_creat'] ?? '');
        $sheet->setCellValue('K' . $rowNum, html_entity_decode((string)($row['author_name'] ?? ''), ENT_QUOTES, 'UTF-8'));

        $sheet->getStyle('A' . $rowNum . ':' . $lastCol . $rowNum)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP]
        ]);
        $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $rowNum++;
        $no++;
    }
    mysqli_stmt_close($stmt);

    // =========================================================
    // AUTO SIZE
    // =========================================================
    foreach (range('A', $lastCol) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('C')->setWidth(25);
    $sheet->getColumnDimension('F')->setWidth(30);
    $sheet->getColumnDimension('G')->setWidth(30);
    $sheet->getColumnDimension('H')->setWidth(20);
    $sheet->getColumnDimension('K')->setWidth(20);

    $sheet->freezePane('A2');

    // =========================================================
    // NAMA FILE & HEADER DOWNLOAD
    // =========================================================
    $suffix = 'Semua';
    if ($periodeData === 'Tahun') {
        $suffix = trim((string) ($_POST['tahun'] ?? $_GET['tahun'] ?? '')) . '_' . date('YmdHis');
    } elseif ($periodeData === 'Bulan') {
        $suffix = trim((string) ($_POST['tahun'] ?? $_GET['tahun'] ?? '')) . trim((string) ($_POST['bulan'] ?? $_GET['bulan'] ?? '')) . '_' . date('YmdHis');
    } elseif ($periodeData === 'Periodik') {
        $suffix = trim((string) ($_POST['periode_awal'] ?? $_GET['periode_awal'] ?? '')) . '_sd_' . trim((string) ($_POST['periode_akhir'] ?? $_GET['periode_akhir'] ?? '')) . '_' . date('YmdHis');
    } else {
        $suffix = 'Semua_' . date('YmdHis');
    }
    $filename = 'Data_Referensi_Imunisasi_' . $suffix . '.xlsx';

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>

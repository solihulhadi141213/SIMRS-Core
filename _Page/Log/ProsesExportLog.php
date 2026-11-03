<?php
    // =========================================================
    // EXPORT DATA LOG EXCEL
    // =========================================================

    // =========================================================
    // ERROR REPORT (OPTIONAL DEBUG)
    // =========================================================
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    // =========================================================
    // START BUFFER
    // =========================================================
    ob_start();

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // PHPSPREADSHEET
    // =========================================================
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;

    // =========================================================
    // FUNCTION STOP EXPORT
    // =========================================================
    function stopExportLog($message){
        if (ob_get_length()) {
            ob_end_clean();
        }

        echo $message;
        exit;
    }

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        stopExportLog('Sesi akses sudah berakhir!');
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    if (empty($_POST['periode_awal'])) {
        stopExportLog('Periode awal tidak boleh kosong!');
    }

    if (empty($_POST['periode_akhir'])) {
        stopExportLog('Periode akhir tidak boleh kosong!');
    }

    // =========================================================
    // SANITASI
    // =========================================================
    $periode_awal  = validateAndSanitizeInput($_POST['periode_awal']);
    $periode_akhir = validateAndSanitizeInput($_POST['periode_akhir']);

    // =========================================================
    // VALIDASI FORMAT TANGGAL
    // =========================================================
    $date_awal  = DateTime::createFromFormat('Y-m-d', $periode_awal);
    $date_akhir = DateTime::createFromFormat('Y-m-d', $periode_akhir);

    if (
        !$date_awal ||
        !$date_akhir ||
        $date_awal->format('Y-m-d') !== $periode_awal ||
        $date_akhir->format('Y-m-d') !== $periode_akhir
    ) {
        stopExportLog('Format periode tidak valid!');
    }

    if ($date_awal > $date_akhir) {
        stopExportLog('Periode awal tidak boleh lebih besar dari periode akhir!');
    }

    // =========================================================
    // QUERY DATA LOG
    // =========================================================
    $sql = "
        SELECT
            id_log,
            nama_petugas,
            category_log,
            title_log,
            datetime_log
        FROM log
        WHERE DATE(datetime_log) >= ? AND DATE(datetime_log) <= ?
        ORDER BY datetime_log DESC
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    if (!$stmt) {
        stopExportLog('Gagal mempersiapkan query data log.');
    }

    mysqli_stmt_bind_param($stmt, 'ss', $periode_awal, $periode_akhir);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    // =========================================================
    // BUAT SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Log');

    // =========================================================
    // HEADER KOLOM (Baris 4)
    // =========================================================
    $headers = [
        'No',
        'ID Log',
        'Nama Petugas',
        'Kategori',
        'Aktivitas',
        'Tanggal Waktu'
    ];

    $col = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($col . '4', $h);
        $col++;
    }

    // Style header
    $lastHeaderCol = chr(ord('A') + count($headers) - 1);
    $sheet->getStyle('A4:' . $lastHeaderCol . '4')->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER,
            'wrapText'   => true
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4472C4']
        ]
    ]);

    // =========================================================
    // ISI DATA
    // =========================================================
    $row = 5;
    $no = 1;

    while ($Data = mysqli_fetch_assoc($result)) {
        // Format tanggal dan waktu log
        $tanggal_waktu = '-';

        if (!empty($Data['datetime_log'])) {
            $timezoneName = trim((string)(isset($SessionUserTimezone) ? $SessionUserTimezone : ''));
            try {
                $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
            } catch (Throwable $e) {
                $userTimezone = new DateTimeZone('UTC');
            }

            try {
                $dt = new DateTimeImmutable((string)$Data['datetime_log'], new DateTimeZone('UTC'));
                $tanggal_waktu = $dt->setTimezone($userTimezone)->format('d/m/Y H:i');
            } catch (Throwable $e) {
                $tanggal_waktu = date('d/m/Y H:i', strtotime((string)$Data['datetime_log']));
            }
        }

        $rowData = [
            $no,
            $Data['id_log'] ?? '-',
            $Data['nama_petugas'] ?? '-',
            $Data['category_log'] ?? '-',
            $Data['title_log'] ?? '-',
            $tanggal_waktu
        ];

        $col = 'A';
        foreach ($rowData as $value) {
            $sheet->setCellValueExplicit(
                $col . $row,
                (string)$value,
                DataType::TYPE_STRING
            );

            $sheet->getStyle($col . $row)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP)
                ->setWrapText(true);

            $col++;
        }

        $row++;
        $no++;
    }

    mysqli_stmt_close($stmt);


    // =========================================================
    // LAST ROW
    // =========================================================
    $lastRow = max($row - 1, 4);

    // =========================================================
    // BORDER DATA
    // =========================================================
    $sheet->getStyle('A4:' . $lastHeaderCol . $lastRow)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // Alignment kolom No (center)
    if ($lastRow >= 5) {
        $sheet->getStyle('A5:A' . $lastRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // =========================================================
    // AUTO SIZE COLUMN
    // =========================================================
    foreach (range('A', $lastHeaderCol) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // =========================================================
    // FREEZE HEADER
    // =========================================================
    $sheet->freezePane('A5');

    // =========================================================
    // CATAT LOG EKSPOR
    // =========================================================
    $utcNow = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $category_log = 'Log';
    $logTitle = 'Mengexport data log aktivitas';
    $logMetadata = json_encode([
        'periode_awal'  => $periode_awal,
        'periode_akhir' => $periode_akhir,
        'jumlah_data'   => $no - 1
    ]);

    $stmtAudit = mysqli_prepare($Conn, "
        INSERT INTO log (id_akses, datetime_log, nama_petugas, category_log, title_log, metadata_log)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    if ($stmtAudit && $logMetadata !== false) {
        mysqli_stmt_bind_param($stmtAudit, 'isssss', $SessionIdAkses, $utcNow, $SessionNama, $category_log, $logTitle, $logMetadata);
        mysqli_stmt_execute($stmtAudit);
        mysqli_stmt_close($stmtAudit);
    }

    // =========================================================
    // NAMA FILE
    // =========================================================
    $filename = 'Data_Log_' . $periode_awal . '_sd_' . $periode_akhir . '_' . date('YmdHis') . '.xlsx';

    // =========================================================
    // BERSIHKAN OUTPUT BUFFER
    // =========================================================
    if (ob_get_length()) {
        ob_end_clean();
    }

    // =========================================================
    // HEADER DOWNLOAD
    // =========================================================
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // =========================================================
    // OUTPUT EXCEL
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
?>
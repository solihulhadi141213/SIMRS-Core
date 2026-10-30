<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    ob_start();

    error_reporting(0);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    require '../../vendor/autoload.php';

    // Validasi session
    if (empty($SessionIdAkses)) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        exit('Sesi akses sudah berakhir');
    }

    // Validasi koneksi
    if (empty($Conn)) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        exit('Koneksi database gagal');
    }

    // Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Referensi Body Site');

    // Header table (sesuai template upload)
    $header = ['No', 'Kategori', 'Nama Body Site', 'Display', 'Code', 'System'];

    // Tulis header
    $col = 'A';
    foreach ($header as $item) {
        $sheet->setCellValue($col . '1', $item);
        $col++;
    }

    // Style header
    $lastCol = 'F';
    $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // Query data
    $query = "
        SELECT
            body_site_category,
            body_site_nama,
            body_site_display,
            body_site_code,
            body_site_system
        FROM body_site
        ORDER BY id_body_site ASC
    ";

    $result = mysqli_query($Conn, $query);

    // Row awal
    $rowNum = 2;
    $no = 1;

    // Loop data
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('A' . $rowNum, $no);
            $sheet->setCellValue('B' . $rowNum, html_entity_decode($row['body_site_category'] ?? '', ENT_QUOTES, 'UTF-8'));
            $sheet->setCellValue('C' . $rowNum, html_entity_decode($row['body_site_nama'] ?? '', ENT_QUOTES, 'UTF-8'));
            $sheet->setCellValue('D' . $rowNum, html_entity_decode($row['body_site_display'] ?? '', ENT_QUOTES, 'UTF-8'));
            $sheet->setCellValue('E' . $rowNum, html_entity_decode($row['body_site_code'] ?? '', ENT_QUOTES, 'UTF-8'));
            $sheet->setCellValue('F' . $rowNum, html_entity_decode($row['body_site_system'] ?? '', ENT_QUOTES, 'UTF-8'));

            // Border row
            $sheet->getStyle('A' . $rowNum . ':' . $lastCol . $rowNum)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ]);

            $rowNum++;
            $no++;
        }
    }

    // Auto width
    foreach (range('A', $lastCol) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Freeze header
    $sheet->freezePane('A2');

    // Bersihkan output buffer
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Nama file
    $filename = 'Referensi_Body_Site_' . date('Ymd_His') . '.xlsx';

    // Header download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    // Output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>


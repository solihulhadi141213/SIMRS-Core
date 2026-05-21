<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    ob_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    require '../../vendor/autoload.php';

    // Validasi session
    if (empty($SessionIdAkses)) {
        exit('Sesi akses sudah berakhir');
    }

    // Validasi koneksi
    if (empty($Conn)) {
        exit('Koneksi database gagal');
    }

    // Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Referensi Alergen');

    // Header table
    $header = ['No','Kategori','Nama Alergen','Code','Display','System','Author','Datetime'];

    // Tulis header
    $col = 'A';
    foreach ($header as $item) {
        $sheet->setCellValue($col.'1', $item);
        $col++;
    }

    // Style header
    $sheet->getStyle('A1:H1')->applyFromArray([
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

    // Mapping kategori
    $kategori_map = [
        'food'        => 'Makanan',
        'medication'  => 'Obat',
        'environment' => 'Lingkungan',
        'biologic'    => 'Biologis'
    ];

    // Query data aktif
    $query = "
        SELECT 
            kategori_alergen,
            nama_alergen,
            code_alergen,
            display_alergen,
            system_alergen,
            author_name,
            datetime_creat
        FROM alergi_alergen
        WHERE status='1'
        ORDER BY nama_alergen ASC
    ";

    $result = mysqli_query($Conn, $query);

    // Row awal
    $rowNum = 2;
    $no = 1;

    // Loop data
    while ($row = mysqli_fetch_assoc($result)) {

        $kategori = $kategori_map[$row['kategori_alergen']] ?? $row['kategori_alergen'];

        $sheet->setCellValue('A'.$rowNum, $no);
        $sheet->setCellValue('B'.$rowNum, $kategori);
        $sheet->setCellValue('C'.$rowNum, html_entity_decode($row['nama_alergen'] ?? '', ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('D'.$rowNum, html_entity_decode($row['code_alergen'] ?? '', ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('E'.$rowNum, html_entity_decode($row['display_alergen'] ?? '', ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('F'.$rowNum, html_entity_decode($row['system_alergen'] ?? '', ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('G'.$rowNum, html_entity_decode($row['author_name'] ?? '', ENT_QUOTES, 'UTF-8'));
        $sheet->setCellValue('H'.$rowNum, $row['datetime_creat'] ?? '');

        // Border row
        $sheet->getStyle('A'.$rowNum.':H'.$rowNum)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        $rowNum++;
        $no++;
    }

    // Auto width
    foreach (range('A', 'H') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Freeze header
    $sheet->freezePane('A2');

    // Bersihkan output buffer
    ob_end_clean();

    // Nama file
    $filename = 'Referensi_Alergen_'.date('Ymd_His').'.xlsx';

    // Header download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    // Output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>
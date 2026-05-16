<?php
    // =========================================================
    // ERROR REPORTING (Disarankan aktifkan jika sedang dev)
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // LOAD CONNECTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // =========================================================
    // AUTOLOAD PHPSPREADSHEET
    // =========================================================
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
        die('Sesi akses sudah berakhir');
    }

    // =========================================================
    // BUAT SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // =========================================================
    // JUDUL
    // =========================================================
    $sheet->setCellValue('A1', 'DATA REFERENSI TINDAKAN');
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 14
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER
        ]
    ]);

    // =========================================================
    // HEADER TABEL
    // =========================================================
    $sheet->setCellValue('A3', 'Nomor');
    $sheet->setCellValue('B3', 'Kategori Tindakan');
    $sheet->setCellValue('C3', 'Jenis/Nama Tindakan');
    $sheet->setCellValue('D3', 'Body Site');
    $sheet->setCellValue('E3', 'ICD 9');

    // Style Header
    $sheet->getStyle('A3:E3')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => [
                'rgb' => 'FFFFFF'
            ]
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => '0D6EFD'
            ]
        ],
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

    // =========================================================
    // QUERY DATA
    // =========================================================
    $query = "
        SELECT 
            kategori_tindakan,
            kategori_tindakan_display,
            nama_tindakan,
            nama_tindakan_display,
            lokasi_tubuh,
            lokasi_tubuh_display,
            icd9_code,
            icd9_description
        FROM tindakan_referensi
        WHERE status = '1'
        ORDER BY id_tindakan_referensi DESC
    ";

    $result = mysqli_query($Conn, $query);

    // =========================================================
    // LOOP DATA
    // =========================================================
    $rowNumber = 4;
    $no = 1;

    // Style template untuk mempersingkat baris kode di dalam loop
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ],
        'alignment' => [
            'vertical' => Alignment::VERTICAL_TOP
        ]
    ];

    while ($row = mysqli_fetch_assoc($result)) {

        // Kategori
        $kategori = $row['kategori_tindakan'] ?? '-';
        if (!empty($row['kategori_tindakan_display'])) {
            $kategori .= "\n(" . $row['kategori_tindakan_display'] . ")";
        }

        // Nama Tindakan
        $tindakan = $row['nama_tindakan'] ?? '-';
        if (!empty($row['nama_tindakan_display'])) {
            $tindakan .= "\n(" . $row['nama_tindakan_display'] . ")";
        }

        // Body Site
        $body_site = $row['lokasi_tubuh'] ?? '-';
        if (!empty($row['lokasi_tubuh_display'])) {
            $body_site .= "\n(" . $row['lokasi_tubuh_display'] . ")";
        }

        // ICD9
        $icd9 = $row['icd9_code'] ?? '-';
        if (!empty($row['icd9_description'])) {
            $icd9 .= "\n(" . $row['icd9_description'] . ")";
        }

        // Set Data
        $sheet->setCellValue('A' . $rowNumber, $no);
        $sheet->setCellValue('B' . $rowNumber, $kategori);
        $sheet->setCellValue('C' . $rowNumber, $tindakan);
        $sheet->setCellValue('D' . $rowNumber, $body_site);
        $sheet->setCellValue('E' . $rowNumber, $icd9);

        // Terapkan Style & Wrap Text sekaligus
        $sheet->getStyle('A'.$rowNumber.':E'.$rowNumber)->applyFromArray($styleArray);
        $sheet->getStyle('B'.$rowNumber.':E'.$rowNumber)->getAlignment()->setWrapText(true);

        // Center alignment khusus untuk nomor tabel
        $sheet->getStyle('A'.$rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $rowNumber++;
        $no++;
    }

    // =========================================================
    // AUTO SIZE COLUMN & SET WIDTH DEFAULT
    // =========================================================
    // Catatan: Efek '\n' (wrap text) terkadang membuat autoSize membaca string terlalu panjang.
    // Set manual width atau kombinasi autoSize disarankan untuk kolom text panjang.
    foreach (range('A', 'E') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    
    // Memberikan ruang lebih pada kolom ber-wrap text agar tidak terlalu sempit
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->getColumnDimension('C')->setWidth(35);
    $sheet->getColumnDimension('D')->setWidth(25);

    // =========================================================
    // NAMA FILE & HEADER DOWNLOAD
    // =========================================================
    $filename = 'Data_Referensi_Tindakan_' . date('YmdHis') . '.xlsx';

    // Bersihkan buffer sebelum mengirimkan file untuk mencegah file corrupt
    if (ob_get_contents()) ob_end_clean();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    header('Expires: Fri, 11 Nov 2011 11:11:11 GMT'); // Masa lampau
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Pragma: public');

    // =========================================================
    // OUTPUT (PERBAIKAN UTAMA)
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output'); // Menulis output ke browser

    exit;
?>
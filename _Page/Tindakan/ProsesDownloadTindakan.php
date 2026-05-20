<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // LOAD PHP SPREADSHEET
    // =========================================================
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Cell\DataType; // Tambahan untuk mematikan auto-formatting No.RM

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        die("Sesi akses sudah berakhir!");
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    $periode_awal  = $_POST['periode_awal'] ?? '';
    $periode_akhir = $_POST['periode_akhir'] ?? '';

    $periode_awal  = validateAndSanitizeInput($periode_awal);
    $periode_akhir = validateAndSanitizeInput($periode_akhir);

    if (empty($periode_awal) || empty($periode_akhir)) {
        die("Periode awal dan periode akhir tidak boleh kosong!");
    }

    // =========================================================
    // VALIDASI FORMAT TANGGAL
    // =========================================================
    if (!strtotime($periode_awal) || !strtotime($periode_akhir)) {
        die("Format tanggal tidak valid!");
    }

    // =========================================================
    // VALIDASI PERIODE
    // =========================================================
    if ($periode_awal > $periode_akhir) {
        die("Periode awal tidak boleh lebih besar dari periode akhir!");
    }

    // =========================================================
    // FORMAT DATETIME
    // =========================================================
    $datetime_awal  = $periode_awal . ' 00:00:00';
    $datetime_akhir = $periode_akhir . ' 23:59:59';

    // =========================================================
    // QUERY DATA
    // =========================================================
    $sql = "
        SELECT 
            t.id_tindakan,
            t.datetime_start,

            k.datetime_daftar,
            k.jenis_kunjungan,

            p.id_pasien,
            p.nama,

            tr.kategori_tindakan,
            tr.nama_tindakan

        FROM tindakan t

        LEFT JOIN kunjungan k
            ON t.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON t.id_pasien = p.id_pasien

        LEFT JOIN tindakan_referensi tr
            ON t.id_tindakan_referensi = tr.id_tindakan_referensi

        WHERE t.datetime_start BETWEEN ? AND ?

        ORDER BY t.datetime_start ASC
    ";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        die("Query gagal dipersiapkan!");
    }

    $stmt->bind_param("ss", $datetime_awal, $datetime_akhir);
    $stmt->execute();

    $result = $stmt->get_result();

    // =========================================================
    // SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    // =========================================================
    // JUDUL FILE
    // =========================================================
    $judul = "DATA TINDAKAN";
    $sheet->setCellValue('A1', $judul);

    // Merge title
    $sheet->mergeCells('A1:H1');

    // Style title
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
    // HEADER
    // =========================================================
    $headerRow = 3;

    $headers = [
        'A' => 'No',
        'B' => 'No.RM',
        'C' => 'Nama Pasien',
        'D' => 'Tanggal Kunjungan',
        'E' => 'Jenis Kunjungan',
        'F' => 'Kategori Tindakan',
        'G' => 'Jenis Tindakan',
        'H' => 'Tanggal / Waktu Tindakan'
    ];

    foreach ($headers as $column => $title) {
        $sheet->setCellValue($column . $headerRow, $title);
    }

    // =========================================================
    // STYLE HEADER
    // =========================================================
    $sheet->getStyle('A3:H3')->applyFromArray([
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
    // ISI DATA
    // =========================================================
    $row = 4;
    $no  = 1;

    while ($data = $result->fetch_assoc()) {

        $sheet->setCellValue('A' . $row, $no);
        
        // Memastikan No. RM tetap bertipe STRING agar angka '0' di depan tidak hilang
        $sheet->setCellValueExplicit('B' . $row, $data['id_pasien'], DataType::TYPE_STRING);
        
        $sheet->setCellValue('C' . $row, $data['nama']);
        $sheet->setCellValue('D' . $row, $data['datetime_daftar']);
        $sheet->setCellValue('E' . $row, $data['jenis_kunjungan']);
        $sheet->setCellValue('F' . $row, $data['kategori_tindakan']);
        $sheet->setCellValue('G' . $row, $data['nama_tindakan']);
        $sheet->setCellValue('H' . $row, $data['datetime_start']);

        // Border
        $sheet->getStyle('A'.$row.':H'.$row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // Vertical Align
        $sheet->getStyle('A'.$row.':H'.$row)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        $row++;
        $no++;
    }

    // =========================================================
    // AUTO SIZE COLUMN
    // =========================================================
    foreach (range('A', 'H') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // =========================================================
    // WRAP TEXT
    // =========================================================
    $sheet->getStyle('A:H')->getAlignment()->setWrapText(true);

    // =========================================================
    // FREEZE HEADER
    // =========================================================
    $sheet->freezePane('A4');

    // =========================================================
    // NAMA FILE
    // =========================================================
    $filename = 'Data_Tindakan_' . date('YmdHis') . '.xlsx';

    // =========================================================
    // HEADER DOWNLOAD & CLEAN BUFFER (Kunci Perbaikan)
    // =========================================================
    if (ob_get_length()) {
        ob_end_clean(); // Menghapus spasi / output bocor sebelum baris ini
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // =========================================================
    // OUTPUT
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

    // SENGJA TIDAK MENGGUNAKAN ?> UNTUK MENGHINDARI WHITESPACE BENGKONG DI AKHIR FILE
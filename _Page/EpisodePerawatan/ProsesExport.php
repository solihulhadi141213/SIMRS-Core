<?php
    // ==========================================
    // ProsesExport.php - Export Episode Perawatan ke Excel
    // ==========================================

    // Load konfigurasi, helper, session, dan autoload Composer (PhpSpreadsheet)
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    require '../../vendor/autoload.php'; // Sesuaikan path vendor/autoload.php di server Anda

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    // 1. Validasi Session Login
    if (empty($SessionIdAkses)) {
        die("Sesi akses sudah berakhir. Silakan login ulang.");
    }

    // 2. Validasi Metode Request (Harus POST)
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Metode request tidak valid.");
    }

    // 3. Ambil dan Validasi Parameter Periode
    $periode_awal  = trim($_POST['periode_awal'] ?? '');
    $periode_akhir = trim($_POST['periode_akhir'] ?? '');

    // Validasi format tanggal YYYY-MM-DD
    $cekAwal  = DateTime::createFromFormat('Y-m-d', $periode_awal);
    $cekAkhir = DateTime::createFromFormat('Y-m-d', $periode_akhir);

    if (!$cekAwal || $cekAwal->format('Y-m-d') !== $periode_awal || !$cekAkhir || $cekAkhir->format('Y-m-d') !== $periode_akhir) {
        die("Periode tanggal awal dan akhir wajib diisi dengan format yang valid.");
    }

    if ($periode_awal > $periode_akhir) {
        die("Periode awal tidak boleh lebih besar dari periode akhir.");
    }

    // 4. Query Data Episode Perawatan berdasarkan rentang tanggal date_start
    $sql = "
        SELECT 
            e.*, 
            p.nama AS nama_pasien, 
            p.nik, 
            p.no_bpjs,
            d.nama AS nama_dokter,
            dg.icd_kode,
            dg.icd_deskripsi
        FROM episode_perawatan e
        LEFT JOIN pasien p ON p.id_pasien = e.id_pasien
        LEFT JOIN dokter d ON d.id_dokter = e.id_dokter
        LEFT JOIN diagnosis dg ON dg.id_diagnosis = e.id_diagnosis
        WHERE e.date_start BETWEEN ? AND ?
        ORDER BY e.date_start ASC, e.id_episode_perawatan ASC
    ";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        die("Gagal mempersiapkan query database.");
    }

    mysqli_stmt_bind_param($stmt, "ss", $periode_awal, $periode_akhir);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 5. Inisialisasi PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Laporan Episode Perawatan');

    // Set Default Font
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

    // --- HEADER LAPORAN ---
    $sheet->setCellValue('A1', 'LAPORAN DATA EPISODE PERAWATAN');
    $sheet->mergeCells('A1:K1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Periode: ' . date('d/m/Y', strtotime($periode_awal)) . ' s/d ' . date('d/m/Y', strtotime($periode_akhir)));
    $sheet->mergeCells('A2:K2');
    $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // --- TABEL HEADER ---
    $headers = [
        'No', 
        'Kode Episode', 
        'ID EpisodeOfCare', 
        'No. RM', 
        'Nama Pasien', 
        'NIK', 
        'Nama Episode', 
        'Diagnosis (ICD)', 
        'Dokter DPJP', 
        'Tanggal Mulai', 
        'Status'
    ];

    $rowNum = 4;
    $sheet->fromArray($headers, NULL, 'A' . $rowNum);

    // Styling Header Tabel
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4E73DF'], // Warna biru profesional
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle('A' . $rowNum . ':K' . $rowNum)->applyFromArray($headerStyle);
    $sheet->getRowDimension($rowNum)->setRowHeight(25);

    // --- ISI DATA ---
    $rowNum = 5;
    $no = 1;

    $dataStyle = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => 'DDDDDD'],
            ],
        ],
        'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
        ]
    ];

    while ($row = mysqli_fetch_assoc($result)) {
        // Format Tanggal Mulai
        $tgl_mulai = '-';
        if (!empty($row['date_start']) && $row['date_start'] !== '0000-00-00') {
            $dt = DateTime::createFromFormat('Y-m-d', $row['date_start']);
            $tgl_mulai = $dt ? $dt->format('d/m/Y') : $row['date_start'];
        }

        // Format Diagnosis
        $diagnosis = '-';
        if (!empty($row['icd_kode'])) {
            $diagnosis = '[' . $row['icd_kode'] . '] ' . $row['icd_deskripsi'];
        }

        $sheet->setCellValue('A' . $rowNum, $no);
        $sheet->setCellValue('B' . $rowNum, $row['kode_episode_perawatan'] ?? '-');
        $sheet->setCellValue('C' . $rowNum, $row['IdEpisodeOfCare'] ?? '-');
        $sheet->setCellValue('D' . $rowNum, $row['id_pasien'] ?? '-');
        $sheet->setCellValue('E' . $rowNum, $row['nama_pasien'] ?? '-');
        $sheet->setCellValue('F' . $rowNum, "\t" . ($row['nik'] ?? '-')); // Format string agar NIK tidak terpotong
        $sheet->setCellValue('G' . $rowNum, $row['episode_name'] ?? '-');
        $sheet->setCellValue('H' . $rowNum, $diagnosis);
        $sheet->setCellValue('I' . $rowNum, $row['nama_dokter'] ?? '-');
        $sheet->setCellValue('J' . $rowNum, $tgl_mulai);
        $sheet->setCellValue('K' . $rowNum, ucfirst($row['status'] ?? '-'));

        // Alignment kolom tertentu
        $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A' . $rowNum . ':K' . $rowNum)->applyFromArray($dataStyle);
        $sheet->getRowDimension($rowNum)->setRowHeight(20);

        $no++;
        $rowNum++;
    }

    mysqli_stmt_close($stmt);

    // Auto-size kolom agar pas dan rapi
    foreach (range('A', 'K') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // 6. Output File Excel untuk Download
    $filename = "Laporan_Episode_Perawatan_" . $periode_awal . "_hingga_" . $periode_akhir . ".xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>
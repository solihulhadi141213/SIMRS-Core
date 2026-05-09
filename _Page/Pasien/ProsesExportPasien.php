<?php
    // =========================================================
    // EXPORT DATA PASIEN EXCEL
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
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        die('Sesi akses sudah berakhir!');
    }

    // =========================================================
    // VALIDASI HAK AKSES
    // =========================================================
    $ijin_akses = GetStatusAccess($Conn, $SessionIdAkses, 'wrA8sp3Y4r');

    if ($ijin_akses !== true) {
        die('Anda tidak memiliki ijin export data pasien!');
    }

    // =========================================================
    // FILTER
    // =========================================================
    $periode_data  = validateAndSanitizeInput($_GET['periode_data'] ?? 'Semua');
    $periode_awal  = validateAndSanitizeInput($_GET['periode_awal'] ?? '');
    $periode_akhir = validateAndSanitizeInput($_GET['periode_akhir'] ?? '');

    // =========================================================
    // QUERY
    // =========================================================
    $query = "SELECT * FROM pasien";

    // Filter Periode
    if (
        $periode_data == 'Periode' &&
        !empty($periode_awal) &&
        !empty($periode_akhir)
    ) {

        $query .= "
            WHERE DATE(registered_at)
            BETWEEN '$periode_awal' AND '$periode_akhir'
        ";
    }

    // Order
    $query .= " ORDER BY id_pasien DESC";

    // Execute
    $result = mysqli_query($Conn, $query);

    // Debug Query
    if (!$result) {
        die('Query Error : ' . mysqli_error($Conn));
    }

    // =========================================================
    // OBJECT SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // =========================================================
    // JUDUL SHEET
    // =========================================================
    $sheet->setTitle('Data Pasien');

    // =========================================================
    // HEADER TABLE
    // =========================================================
    $headers = [

        'A1'  => 'ID Pasien',
        'B1'  => 'ID IHS',
        'C1'  => 'NIK',
        'D1'  => 'No BPJS',
        'E1'  => 'Nama',
        'F1'  => 'Gender',
        'G1'  => 'Tempat Lahir',
        'H1'  => 'Tanggal Lahir',
        'I1'  => 'Provinsi',
        'J1'  => 'Kabupaten/Kota',
        'K1'  => 'Kecamatan',
        'L1'  => 'Desa/Kelurahan',
        'M1'  => 'Alamat',
        'N1'  => 'Kode Pos',
        'O1'  => 'Kontak',
        'P1'  => 'Golongan Darah',
        'Q1'  => 'Status Pernikahan',
        'R1'  => 'Pekerjaan',
        'S1'  => 'Photo File',
        'T1'  => 'Status',
        'U1'  => 'ID Pasien Relasi',
        'V1'  => 'Status Relasi',
        'W1'  => 'ID Akses',
        'X1'  => 'Petugas Pendaftaran',
        'Y1'  => 'Registered At',
        'Z1'  => 'Updated At'

    ];

    // =========================================================
    // SET HEADER
    // =========================================================
    foreach ($headers as $cell => $value) {
        $sheet->setCellValue($cell, $value);
    }

    // =========================================================
    // STYLE HEADER
    // =========================================================
    $sheet->getStyle('A1:Z1')->applyFromArray([
        'font' => [
            'bold'  => true,
            'color' => [
                'rgb' => 'FFFFFF'
            ],
            'size' => 11
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => '4472C4'
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
    // LOOP DATA
    // =========================================================
    $rowNumber = 2;

    while ($row = mysqli_fetch_assoc($result)) {

        $data = [

            $row['id_pasien'] ?? '-',
            $row['id_ihs'] ?? '-',
            $row['nik'] ?? '-',
            $row['no_bpjs'] ?? '-',
            $row['nama'] ?? '-',
            $row['gender'] ?? '-',
            $row['tempat_lahir'] ?? '-',
            $row['tanggal_lahir'] ?? '-',
            $row['province'] ?? '-',
            $row['regency'] ?? '-',
            $row['subdistrict'] ?? '-',
            $row['village'] ?? '-',
            $row['street'] ?? '-',
            $row['postal_code'] ?? '-',
            $row['kontak'] ?? '-',
            $row['golongan_darah'] ?? '-',
            $row['pernikahan'] ?? '-',
            $row['pekerjaan'] ?? '-',
            $row['photo_file_name'] ?? '-',
            $row['status'] ?? '-',
            $row['id_pasien_relasi'] ?? '-',
            $row['status_relasi'] ?? '-',
            $row['id_akses'] ?? '-',
            $row['petugas_pendaftaran'] ?? '-',
            $row['registered_at'] ?? '-',
            $row['updated_at'] ?? '-'

        ];

        $column = 'A';

        foreach ($data as $value) {

            // =====================================================
            // FORCE STRING
            // Menjaga:
            // - NIK tidak scientific
            // - datetime tidak berubah
            // - leading zero aman
            // =====================================================
            $sheet->setCellValueExplicit(
                $column . $rowNumber,
                (string)$value,
                DataType::TYPE_STRING
            );

            // Vertical Align
            $sheet->getStyle($column . $rowNumber)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);

            $column++;
        }

        $rowNumber++;
    }

    // =========================================================
    // LAST ROW
    // =========================================================
    $lastRow = $rowNumber - 1;

    // =========================================================
    // BORDER DATA
    // =========================================================
    $sheet->getStyle('A1:Z' . $lastRow)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // =========================================================
    // AUTO SIZE COLUMN
    // =========================================================
    foreach (range('A', 'Z') as $columnID) {
        $sheet->getColumnDimension($columnID)
            ->setAutoSize(true);
    }

    // =========================================================
    // FREEZE HEADER
    // =========================================================
    $sheet->freezePane('A2');

    // =========================================================
    // FILE NAME
    // =========================================================
    $file_name = 'Data_Pasien_' . date('Ymd_His') . '.xlsx';

    // =========================================================
    // CLEAN BUFFER
    // =========================================================
    if (ob_get_length()) {
        ob_end_clean();
    }

    // =========================================================
    // HEADER DOWNLOAD
    // =========================================================
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // =========================================================
    // OUTPUT EXCEL
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // =========================================================
    // EXIT
    // =========================================================
    exit;
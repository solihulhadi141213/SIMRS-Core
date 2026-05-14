<?php
    // =========================================================
    // EXPORT DATA DIAGNOSIS EXCEL
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
    function stopExportDiagnosis($message){
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
        stopExportDiagnosis('Sesi akses sudah berakhir!');
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    if (empty($_GET['periode_awal'])) {
        stopExportDiagnosis('Periode awal tidak boleh kosong!');
    }

    if (empty($_GET['periode_akhir'])) {
        stopExportDiagnosis('Periode akhir tidak boleh kosong!');
    }

    // =========================================================
    // SANITASI
    // =========================================================
    $periode_awal  = validateAndSanitizeInput($_GET['periode_awal']);
    $periode_akhir = validateAndSanitizeInput($_GET['periode_akhir']);

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
        stopExportDiagnosis('Format periode tidak valid!');
    }

    if ($date_awal > $date_akhir) {
        stopExportDiagnosis('Periode awal tidak boleh lebih besar dari periode akhir!');
    }

    // =========================================================
    // QUERY
    // =========================================================
    $sql = "
        SELECT
            diagnosis.datetime_creat,
            diagnosis.jenis_diagnosis,
            diagnosis.dokter_nama,
            diagnosis.diagnosis_text,
            diagnosis.icd_version,
            diagnosis.icd_kode,
            diagnosis.icd_deskripsi,
            diagnosis.status_kasus,
            diagnosis.status_kepastian,
            diagnosis.petugas_nama,

            pasien.nama AS nama_pasien,
            pasien.id_pasien AS no_rm,

            kunjungan.jenis_kunjungan

        FROM diagnosis

        LEFT JOIN pasien
            ON diagnosis.id_pasien = pasien.id_pasien

        LEFT JOIN kunjungan
            ON diagnosis.id_kunjungan = kunjungan.id_kunjungan

        WHERE DATE(diagnosis.datetime_creat) BETWEEN ? AND ?

        ORDER BY diagnosis.datetime_creat ASC, diagnosis.id_diagnosis ASC
    ";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        stopExportDiagnosis('Query Error : '.$Conn->error);
    }

    $stmt->bind_param("ss", $periode_awal, $periode_akhir);
    $stmt->execute();
    $result = $stmt->get_result();

    // =========================================================
    // SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Diagnosis');

    // =========================================================
    // HEADER JUDUL
    // =========================================================
    $sheet->setCellValue('A1', 'DATA DIAGNOSIS');
    $sheet->mergeCells('A1:N1');

    $sheet->setCellValue('A2', 'Periode : '.$periode_awal.' s/d '.$periode_akhir);
    $sheet->mergeCells('A2:N2');

    $sheet->getStyle('A1:N2')->applyFromArray([
        'font' => [
            'bold' => true
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER
        ]
    ]);

    // =========================================================
    // HEADER TABEL
    // =========================================================
    $headers = [
        'No',
        'Nama Pasien',
        'No.RM',
        'Jenis Kunjungan',
        'Tanggal Diagnosis',
        'Jenis/Kategori Diagnosis',
        'Nama Dokter',
        'Diagnosis Text',
        'Versi ICD',
        'Kode ICD',
        'Deskripsi ICD',
        'Status Kasus',
        'Status Kepastian',
        'Nama Petugas'
    ];

    $col = 'A';

    foreach ($headers as $header) {
        $sheet->setCellValue($col.'4', $header);
        $col++;
    }

    // =========================================================
    // STYLE HEADER
    // =========================================================
    $sheet->getStyle('A4:N4')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => [
                'rgb' => 'FFFFFF'
            ]
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => '4472C4'
            ]
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER
        ]
    ]);

    // =========================================================
    // DATA
    // =========================================================
    $row = 5;
    $no  = 1;

    while($Data = $result->fetch_assoc()){
        $datetime_creat = $Data['datetime_creat'] ?? '';

        if(!empty($datetime_creat)){
            $datetime_creat = date('d/m/Y H:i', strtotime($datetime_creat));
        }

        $rowData = [
            $no,
            $Data['nama_pasien'] ?? '-',
            $Data['no_rm'] ?? '-',
            $Data['jenis_kunjungan'] ?? '-',
            $datetime_creat,
            $Data['jenis_diagnosis'] ?? '-',
            $Data['dokter_nama'] ?? '-',
            $Data['diagnosis_text'] ?? '-',
            $Data['icd_version'] ?? '-',
            $Data['icd_kode'] ?? '-',
            $Data['icd_deskripsi'] ?? '-',
            $Data['status_kasus'] ?? '-',
            $Data['status_kepastian'] ?? '-',
            $Data['petugas_nama'] ?? '-'
        ];

        $col = 'A';

        foreach($rowData as $value){
            $sheet->setCellValueExplicit(
                $col.$row,
                (string)$value,
                DataType::TYPE_STRING
            );

            $sheet->getStyle($col.$row)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP)
                ->setWrapText(true);

            $col++;
        }

        $row++;
        $no++;
    }

    $stmt->close();

    // =========================================================
    // LAST ROW
    // =========================================================
    $lastRow = max($row - 1, 4);

    // =========================================================
    // BORDER DATA
    // =========================================================
    $sheet->getStyle('A4:N'.$lastRow)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // =========================================================
    // ALIGNMENT DATA
    // =========================================================
    if ($lastRow >= 5) {
        $sheet->getStyle('A5:A'.$lastRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // =========================================================
    // AUTO SIZE COLUMN
    // =========================================================
    foreach(range('A','N') as $columnID){
        $sheet->getColumnDimension($columnID)
            ->setAutoSize(true);
    }

    // =========================================================
    // FREEZE HEADER
    // =========================================================
    $sheet->freezePane('A5');

    // =========================================================
    // FILE NAME
    // =========================================================
    $filename = 'Data_Diagnosis_'.$periode_awal.'_sd_'.$periode_akhir.'_'.date('YmdHis').'.xlsx';

    // =========================================================
    // CLEAN OUTPUT BUFFER
    // =========================================================
    if (ob_get_length()) {
        ob_end_clean();
    }

    // =========================================================
    // HEADER DOWNLOAD
    // =========================================================
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
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

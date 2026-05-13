<?php
    // Bersihkan output buffer
    if (ob_get_length()) {
        ob_end_clean();
    }

    // =========================================================
    // AUTOLOAD
    // =========================================================
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        exit;
    }

    // =========================================================
    // VALIDASI IJIN
    // =========================================================
    $ijin_akses = GetStatusAccess($Conn, $SessionIdAkses, 'AF4RhT3jlD');
    if($ijin_akses==false){
        exit;
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    if (empty($_POST['periode_awal'])) {
        exit;
    }

    if (empty($_POST['periode_akhir'])) {
        exit;
    }

    // =========================================================
    // SANITASI
    // =========================================================
    $periode_awal  = validateAndSanitizeInput($_POST['periode_awal']);
    $periode_akhir = validateAndSanitizeInput($_POST['periode_akhir']);

    // =========================================================
    // QUERY
    // =========================================================
    $sql = "
        SELECT 
            kunjungan.*,

            pasien.nama AS nama_pasien,
            pasien.nik,
            pasien.gender,
            pasien.tanggal_lahir

        FROM kunjungan

        LEFT JOIN pasien 
            ON kunjungan.id_pasien = pasien.id_pasien

        WHERE DATE(kunjungan.datetime_daftar) BETWEEN ? AND ?

        ORDER BY kunjungan.datetime_daftar DESC
    ";

    $stmt = $Conn->prepare($sql);

    $stmt->bind_param(
        "ss",
        $periode_awal,
        $periode_akhir
    );

    $stmt->execute();

    $result = $stmt->get_result();

    // =========================================================
    // SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // =========================================================
    // HEADER JUDUL
    // =========================================================
    $sheet->setCellValue('A1', 'DATA KUNJUNGAN');
    $sheet->mergeCells('A1:N1');

    $sheet->setCellValue(
        'A2',
        'Periode : '.$periode_awal.' s/d '.$periode_akhir
    );

    $sheet->mergeCells('A2:N2');

    // =========================================================
    // HEADER TABEL
    // =========================================================
    $headers = [
        'No',
        'Tanggal',
        'RM',
        'Nama Pasien',
        'NIK',
        'Gender',
        'Tanggal Lahir',
        'Jenis',
        'Poliklinik',
        'Kelas',
        'Ruangan',
        'Dokter',
        'DPJP',
        'Status'
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
            'horizontal' => Alignment::HORIZONTAL_CENTER
        ]
    ]);

    // =========================================================
    // DATA
    // =========================================================
    $row = 5;
    $no  = 1;

    while($Data = $result->fetch_assoc()){

        $sheet->setCellValue('A'.$row, $no);
        $sheet->setCellValue('B'.$row, $Data['datetime_daftar']);
        $sheet->setCellValue('C'.$row, $Data['id_pasien']);
        $sheet->setCellValue('D'.$row, $Data['nama_pasien']);
        $sheet->setCellValue('E'.$row, $Data['nik']);
        $sheet->setCellValue('F'.$row, $Data['gender']);
        $sheet->setCellValue('G'.$row, $Data['tanggal_lahir']);
        $sheet->setCellValue('H'.$row, $Data['jenis_kunjungan']);
        $sheet->setCellValue('I'.$row, $Data['poliklinik']);
        $sheet->setCellValue('J'.$row, $Data['kelas']);
        $sheet->setCellValue('K'.$row, $Data['ruang_rawat']);
        $sheet->setCellValue('L'.$row, $Data['dokter']);
        $sheet->setCellValue('M'.$row, $Data['dpjp_nama']);
        $sheet->setCellValue('N'.$row, $Data['status']);

        $row++;
        $no++;
    }

    // =========================================================
    // BORDER DATA
    // =========================================================
    $sheet->getStyle('A4:N'.($row-1))->applyFromArray([

        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // =========================================================
    // AUTO SIZE
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
    // NAMA FILE
    // =========================================================
    $filename = 'Data_Kunjungan_'.date('YmdHis').'.xlsx';

    // =========================================================
    // CLEAN OUTPUT BUFFER LAGI
    // =========================================================
    if (ob_get_length()) {
        ob_end_clean();
    }

    // =========================================================
    // HEADER EXCEL
    // =========================================================
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    // =========================================================
    // OUTPUT
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
<?php
    // =========================================================
    // EXPORT GENERAL CONSENT EXCEL
    // =========================================================
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ob_start();

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // AUTOLOAD PHP SPREADSHEET
    // =========================================================
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

    // =========================================================
    // FUNCTION STOP EXPORT
    // =========================================================
    function stopExportGeneralConsent($message){
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
        stopExportGeneralConsent("Sesi akses sudah berakhir!");
    }

    // =========================================================
    // FILTER PERIODE
    // =========================================================
    $periode_awal  = validateAndSanitizeInput($_POST['periode_awal'] ?? '');
    $periode_akhir = validateAndSanitizeInput($_POST['periode_akhir'] ?? '');

    $where = "";
    $types = "";
    $params = [];

    if (!empty($periode_awal) || !empty($periode_akhir)) {
        if (empty($periode_awal)) {
            stopExportGeneralConsent("Periode awal tidak boleh kosong!");
        }

        if (empty($periode_akhir)) {
            stopExportGeneralConsent("Periode akhir tidak boleh kosong!");
        }

        $date_awal  = DateTime::createFromFormat('Y-m-d', $periode_awal);
        $date_akhir = DateTime::createFromFormat('Y-m-d', $periode_akhir);

        if (
            !$date_awal ||
            !$date_akhir ||
            $date_awal->format('Y-m-d') !== $periode_awal ||
            $date_akhir->format('Y-m-d') !== $periode_akhir
        ) {
            stopExportGeneralConsent("Format periode tidak valid!");
        }

        if ($date_awal > $date_akhir) {
            stopExportGeneralConsent("Periode awal tidak boleh lebih besar dari periode akhir!");
        }

        $where = " WHERE DATE(gc.datetime_creat) BETWEEN ? AND ? ";
        $types = "ss";

        $params[] = $periode_awal;
        $params[] = $periode_akhir;
    }

    // =========================================================
    // QUERY DATA
    // =========================================================
    $query = "
        SELECT 
            gc.id_general_consent,
            gc.id_consent,
            gc.id_kunjungan,
            gc.id_pasien,
            gc.metode_consent,
            gc.petugas_edukasi_id,
            gc.petugas_edukasi_nama,
            gc.petugas_edukasi_nik,
            gc.penandatangan_tipe,
            gc.penandatangan_nama,
            gc.penandatangan_nik,
            gc.policy_rule,
            gc.status AS status_general_consent,
            gc.datetime_creat,
            gc.datetime_update,

            k.id_encounter,
            k.sep,
            k.prioritas,
            k.keluhan,
            k.jenis_kunjungan,
            k.dokter,
            k.dpjp_nama,
            k.poliklinik,
            k.kelas,
            k.ruang_rawat,
            k.tempat_tidur,
            k.pembayaran_metode,
            k.pembayaran_penanggung,
            k.kontak_darurat_nomor,
            k.kontak_darurat_nama,
            k.kontak_darurat_hubungan,
            k.status AS status_kunjungan,
            k.petugas_nama,
            k.datetime_daftar,
            k.datetime_pelayanan,
            k.datetime_selesai,

            p.id_ihs,
            p.nik,
            p.no_bpjs,
            p.nama,
            p.gender,
            p.tempat_lahir,
            p.tanggal_lahir,
            p.province,
            p.regency,
            p.subdistrict,
            p.village,
            p.street,
            p.postal_code,
            p.kontak,
            p.golongan_darah,
            p.pernikahan,
            p.pekerjaan,
            p.status AS status_pasien,
            p.registered_at

        FROM general_consent gc

        LEFT JOIN kunjungan k
            ON gc.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON gc.id_pasien = p.id_pasien

        $where

        ORDER BY gc.datetime_creat DESC
    ";

    $stmt = $Conn->prepare($query);

    if (!$stmt) {
        stopExportGeneralConsent("Query Error : ".$Conn->error);
    }

    // =========================================================
    // BIND PARAMETER
    // =========================================================
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    // =========================================================
    // SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setTitle('General Consent');

    // =========================================================
    // HEADER KOLOM
    // =========================================================
    $headers = [

        // GENERAL CONSENT
        'ID GENERAL CONSENT',
        'ID CONSENT SATUSEHAT',
        'ID KUNJUNGAN',
        'ID PASIEN',
        'METODE CONSENT',
        'PETUGAS EDUKASI ID',
        'PETUGAS EDUKASI NAMA',
        'PETUGAS EDUKASI NIK',
        'PENANDATANGAN TIPE',
        'PENANDATANGAN NAMA',
        'PENANDATANGAN NIK',
        'POLICY RULE',
        'STATUS GENERAL CONSENT',
        'DATETIME CREATE',
        'DATETIME UPDATE',

        // KUNJUNGAN
        'ID ENCOUNTER',
        'SEP',
        'PRIORITAS',
        'KELUHAN',
        'JENIS KUNJUNGAN',
        'DOKTER',
        'DPJP',
        'POLIKLINIK',
        'KELAS',
        'RUANG RAWAT',
        'TEMPAT TIDUR',
        'PEMBAYARAN METODE',
        'PEMBAYARAN PENANGGUNG',
        'KONTAK DARURAT NOMOR',
        'KONTAK DARURAT NAMA',
        'KONTAK DARURAT HUBUNGAN',
        'STATUS KUNJUNGAN',
        'PETUGAS PENDAFTARAN',
        'DATETIME DAFTAR',
        'DATETIME PELAYANAN',
        'DATETIME SELESAI',

        // PASIEN
        'ID IHS',
        'NIK',
        'NO BPJS',
        'NAMA PASIEN',
        'GENDER',
        'TEMPAT LAHIR',
        'TANGGAL LAHIR',
        'PROVINSI',
        'KABUPATEN/KOTA',
        'KECAMATAN',
        'DESA/KELURAHAN',
        'ALAMAT',
        'KODE POS',
        'KONTAK',
        'GOLONGAN DARAH',
        'STATUS PERNIKAHAN',
        'PEKERJAAN',
        'STATUS PASIEN',
        'REGISTERED AT'
    ];

    // =========================================================
    // TULIS HEADER
    // =========================================================
    $columnNumber = 1;

    foreach ($headers as $header) {
        $cell = Coordinate::stringFromColumnIndex($columnNumber) . '1';

        $sheet->setCellValue($cell, $header);

        $sheet->getStyle($cell)->applyFromArray([
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
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        $columnNumber++;
    }

    // =========================================================
    // ISI DATA
    // =========================================================
    $rowNumber = 2;

    while ($row = $result->fetch_assoc()) {

        $rowData = [

            // GENERAL CONSENT
            $row['id_general_consent'] ?? '-',
            $row['id_consent'] ?? '-',
            $row['id_kunjungan'] ?? '-',
            $row['id_pasien'] ?? '-',
            $row['metode_consent'] ?? '-',
            $row['petugas_edukasi_id'] ?? '-',
            $row['petugas_edukasi_nama'] ?? '-',
            $row['petugas_edukasi_nik'] ?? '-',
            $row['penandatangan_tipe'] ?? '-',
            $row['penandatangan_nama'] ?? '-',
            $row['penandatangan_nik'] ?? '-',
            $row['policy_rule'] ?? '-',
            $row['status_general_consent'] ?? '-',
            $row['datetime_creat'] ?? '-',
            $row['datetime_update'] ?? '-',

            // KUNJUNGAN
            $row['id_encounter'] ?? '-',
            $row['sep'] ?? '-',
            $row['prioritas'] ?? '-',
            $row['keluhan'] ?? '-',
            $row['jenis_kunjungan'] ?? '-',
            $row['dokter'] ?? '-',
            $row['dpjp_nama'] ?? '-',
            $row['poliklinik'] ?? '-',
            $row['kelas'] ?? '-',
            $row['ruang_rawat'] ?? '-',
            $row['tempat_tidur'] ?? '-',
            $row['pembayaran_metode'] ?? '-',
            $row['pembayaran_penanggung'] ?? '-',
            $row['kontak_darurat_nomor'] ?? '-',
            $row['kontak_darurat_nama'] ?? '-',
            $row['kontak_darurat_hubungan'] ?? '-',
            $row['status_kunjungan'] ?? '-',
            $row['petugas_nama'] ?? '-',
            $row['datetime_daftar'] ?? '-',
            $row['datetime_pelayanan'] ?? '-',
            $row['datetime_selesai'] ?? '-',

            // PASIEN
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
            $row['status_pasien'] ?? '-',
            $row['registered_at'] ?? '-'
        ];

        $columnNumber = 1;

        foreach ($rowData as $value) {
            $cell = Coordinate::stringFromColumnIndex($columnNumber) . $rowNumber;

            $sheet->setCellValueExplicit(
                $cell,
                (string)$value,
                DataType::TYPE_STRING
            );

            $sheet->getStyle($cell)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP)
                ->setWrapText(true);

            $columnNumber++;
        }

        // BORDER DATA
        $lastColumn = $sheet->getHighestColumn();

        $sheet->getStyle('A'.$rowNumber.':'.$lastColumn.$rowNumber)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $rowNumber++;
    }

    // =========================================================
    // AUTO SIZE KOLOM
    // =========================================================
    $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());

    for ($columnNumber = 1; $columnNumber <= $highestColumnIndex; $columnNumber++) {
        $sheet->getColumnDimensionByColumn($columnNumber)->setAutoSize(true);
    }

    // =========================================================
    // FREEZE HEADER
    // =========================================================
    $sheet->freezePane('A2');

    // =========================================================
    // FILE NAME
    // =========================================================
    $filename = 'Audit_General_Consent_' . date('YmdHis') . '.xlsx';

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
    // OUTPUT FILE
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
?>

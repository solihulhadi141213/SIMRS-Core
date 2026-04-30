<?php
require '../../vendor/autoload.php';
include "../../_Config/Connection.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// ================== PARAMETER ==================
$province    = $_GET['province'] ?? '';
$regency     = $_GET['regency'] ?? '';
$subdistrict = $_GET['subdistrict'] ?? '';
$village     = $_GET['village'] ?? '';
$tipe_level4 = $_GET['tipe_level4'] ?? '';
$format      = $_GET['format'] ?? 'excel';

// ================== QUERY ==================
$where = [];
$params = [];
$types  = '';

if (!empty($province)) {
    $where[] = "province LIKE ?";
    $params[] = "%$province%";
    $types .= 's';
}
if (!empty($regency)) {
    $where[] = "regency LIKE ?";
    $params[] = "%$regency%";
    $types .= 's';
}
if (!empty($subdistrict)) {
    $where[] = "subdistrict LIKE ?";
    $params[] = "%$subdistrict%";
    $types .= 's';
}
if (!empty($village)) {
    $where[] = "village LIKE ?";
    $params[] = "%$village%";
    $types .= 's';
}
if (!empty($tipe_level4)) {
    $where[] = "tipe_level4 = ?";
    $params[] = $tipe_level4;
    $types .= 's';
}

$sql = "SELECT * FROM wilayah";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY province, regency, subdistrict, village";

$stmt = $Conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();


// ================== CSV ==================
if ($format == 'csv') {

    if (ob_get_length()) ob_end_clean();

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="wilayah.csv"');

    $output = fopen('php://output', 'w');

    // HEADER
    fputcsv($output, [
        'No',
        'Kode Provinsi','Nama Provinsi',
        'Kode Kabupaten/Kota','Tipe Kabupaten/Kota','Nama Kabupaten/Kota',
        'Kode Kecamatan','Nama Kecamatan',
        'Kode Desa/Kelurahan','Tipe Desa/Kelurahan','Nama Desa/Kelurahan'
    ]);

    $no = 1;
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $no++,
            $row['kode_mendagri_1'], $row['province'],
            $row['kode_mendagri_2'], $row['tipe_level2'], $row['regency'],
            $row['kode_mendagri_3'], $row['subdistrict'],
            $row['kode_mendagri_4'], $row['tipe_level4'], $row['village']
        ]);
    }

    fclose($output);
    exit;
}


// ================== EXCEL ==================
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// HEADER
$headers = [
    'No',
    'Kode Provinsi','Nama Provinsi',
    'Kode Kabupaten/Kota','Tipe Kabupaten/Kota','Nama Kabupaten/Kota',
    'Kode Kecamatan','Nama Kecamatan',
    'Kode Desa/Kelurahan','Tipe Desa/Kelurahan','Nama Desa/Kelurahan'
];

$sheet->fromArray($headers, NULL, 'A1');

// STYLE HEADER (BOLD + CENTER)
$sheet->getStyle('A1:K1')->getFont()->setBold(true);
$sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// DATA
$rowNum = 2;
$no = 1;

while ($row = $result->fetch_assoc()) {

    $sheet->fromArray([
        $no++,
        $row['kode_mendagri_1'], $row['province'],
        $row['kode_mendagri_2'], $row['tipe_level2'], $row['regency'],
        $row['kode_mendagri_3'], $row['subdistrict'],
        $row['kode_mendagri_4'], $row['tipe_level4'], $row['village']
    ], NULL, 'A' . $rowNum);

    $rowNum++;
}

// ALIGN CENTER SEMUA DATA
$sheet->getStyle('A2:K' . ($rowNum-1))
    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// AUTO WIDTH
foreach (range('A','K') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}


// ================== OUTPUT ==================
if (ob_get_length()) ob_end_clean();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="wilayah.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
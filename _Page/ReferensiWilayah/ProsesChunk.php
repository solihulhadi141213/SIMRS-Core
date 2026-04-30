<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$id_upload = $_POST['id_upload'] ?? '';

if (empty($id_upload)) {
    echo json_encode(["status"=>"error"]);
    exit;
}

$folder = "../../_Upload/wilayah/";
$meta_file = $folder.$id_upload.".json";

if (!file_exists($meta_file)) {
    echo json_encode(["status"=>"error"]);
    exit;
}

$meta = json_decode(file_get_contents($meta_file), true);
$file_path = $folder.$meta['file'];

$spreadsheet = IOFactory::load($file_path);
$sheet = $spreadsheet->getActiveSheet();

$highestRow = $sheet->getHighestRow();

if ($meta['total_row'] == 0) {
    $meta['total_row'] = $highestRow;
}

// ================= CHUNK =================
$limit = 50;
$start = $meta['last_row'] + 1;
$end   = min($start + $limit - 1, $highestRow);

// ================= LOAD EXISTING DATA =================
// 🔥 ambil data yang sudah ada sekali saja
$existing = [];

$q = $Conn->query("
    SELECT 
        MD5(CONCAT(
            province, regency, subdistrict, village,
            tipe_level2, tipe_level4,
            kode_mendagri_1, kode_mendagri_2,
            kode_mendagri_3, kode_mendagri_4
        )) as hash_key
    FROM wilayah
");

while ($r = $q->fetch_assoc()) {
    $existing[$r['hash_key']] = true;
}

// 🔥 TRANSACTION
$Conn->begin_transaction();

$stmt = $Conn->prepare("
    INSERT INTO wilayah 
    (province, regency, subdistrict, village,
     tipe_level2, tipe_level4,
     kode_mendagri_1, kode_mendagri_2,
     kode_mendagri_3, kode_mendagri_4)
    VALUES (?,?,?,?,?,?,?,?,?,?)
");

// ================= LOOP =================
for ($i = $start; $i <= $end; $i++) {

    $kode1 = trim($sheet->getCell('B'.$i)->getValue());
    $prov  = trim($sheet->getCell('C'.$i)->getValue());
    $kode2 = trim($sheet->getCell('D'.$i)->getValue());
    $tipe2 = trim($sheet->getCell('E'.$i)->getValue());
    $kab   = trim($sheet->getCell('F'.$i)->getValue());
    $kode3 = trim($sheet->getCell('G'.$i)->getValue());
    $kec   = trim($sheet->getCell('H'.$i)->getValue());
    $kode4 = trim($sheet->getCell('I'.$i)->getValue());
    $tipe4 = trim($sheet->getCell('J'.$i)->getValue());
    $desa  = trim($sheet->getCell('K'.$i)->getValue());

    // skip kosong
    if (empty($prov) || empty($kab) || empty($kec) || empty($desa)) {
        continue;
    }

    // 🔥 buat hash unik
    $hash = md5(
        $prov.$kab.$kec.$desa.
        $tipe2.$tipe4.
        $kode1.$kode2.$kode3.$kode4
    );

    // 🔥 cek apakah sudah ada
    if (isset($existing[$hash])) {
        continue; // skip
    }

    // simpan ke cache biar tidak double dalam file yg sama
    $existing[$hash] = true;

    $stmt->bind_param(
        "ssssssssss",
        $prov, $kab, $kec, $desa,
        $tipe2, $tipe4,
        $kode1, $kode2, $kode3, $kode4
    );

    $stmt->execute();
}

$Conn->commit();

// ================= UPDATE META =================
$meta['last_row'] = $end;
file_put_contents($meta_file, json_encode($meta));

// ================= PROGRESS =================
$progress = round(($end / $highestRow) * 100);

// ================= RESPONSE =================
if ($end >= $highestRow) {

    unlink($file_path);
    unlink($meta_file);

    echo json_encode([
        "status" => "selesai",
        "progress" => 100
    ]);

} else {

    echo json_encode([
        "status" => "lanjut",
        "progress" => $progress
    ]);
}
<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";

// ================== RESPONSE DEFAULT ==================
$response = [
    "status"  => "error",
    "message" => "Terjadi kesalahan"
];

// ================== AMBIL DATA ==================
$province         = trim($_POST['province'] ?? '');
$regency          = trim($_POST['regency'] ?? '');
$subdistrict      = trim($_POST['subdistrict'] ?? '');
$village          = trim($_POST['village'] ?? '');

$tipe_level2      = $_POST['tipe_level2'] ?? '';
$tipe_level4      = $_POST['tipe_level4'] ?? '';

$kode_mendagri_1  = trim($_POST['kode_mendagri_1'] ?? '');
$kode_mendagri_2  = trim($_POST['kode_mendagri_2'] ?? '');
$kode_mendagri_3  = trim($_POST['kode_mendagri_3'] ?? '');
$kode_mendagri_4  = trim($_POST['kode_mendagri_4'] ?? '');

// ================== NORMALISASI INPUT MANUAL ==================
// (kalau pakai prefix new_ atau manual dari select2)
function cleanInput($val) {
    return preg_replace('/^new_/i', '', $val);
}

$province    = cleanInput($province);
$regency     = cleanInput($regency);
$subdistrict = cleanInput($subdistrict);
$village     = cleanInput($village);

// ================== VALIDASI ==================
if (
    empty($province) ||
    empty($regency) ||
    empty($subdistrict) ||
    empty($village)
) {
    $response['message'] = "Semua field wilayah wajib diisi!";
    echo json_encode($response);
    exit;
}

// ================== CEK DUPLIKAT ==================
$cek = $Conn->prepare("
    SELECT id_wilayah 
    FROM wilayah
    WHERE province = ?
    AND regency = ?
    AND subdistrict = ?
    AND village = ?
    LIMIT 1
");

$cek->bind_param("ssss", $province, $regency, $subdistrict, $village);
$cek->execute();
$cek_result = $cek->get_result();

if ($cek_result->num_rows > 0) {
    $response['message'] = "Wilayah sudah ada di database!";
    echo json_encode($response);
    exit;
}

// ================== INSERT DATA ==================
$insert = $Conn->prepare("
    INSERT INTO wilayah (
        province,
        regency,
        subdistrict,
        village,
        tipe_level2,
        tipe_level4,
        kode_mendagri_1,
        kode_mendagri_2,
        kode_mendagri_3,
        kode_mendagri_4
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insert->bind_param(
    "ssssssssss",
    $province,
    $regency,
    $subdistrict,
    $village,
    $tipe_level2,
    $tipe_level4,
    $kode_mendagri_1,
    $kode_mendagri_2,
    $kode_mendagri_3,
    $kode_mendagri_4
);

// ================== EKSEKUSI ==================
if ($insert->execute()) {

    $response['status']  = "success";
    $response['message'] = "Data wilayah berhasil disimpan";

} else {

    $response['message'] = "Gagal menyimpan data: " . $Conn->error;
}

// ================== OUTPUT ==================
echo json_encode($response);
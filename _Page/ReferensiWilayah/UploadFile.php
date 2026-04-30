<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";

date_default_timezone_set("Asia/Jakarta");

// ================= VALIDASI =================
if (!isset($_FILES['file_upload'])) {
    echo json_encode([
        "status" => "error",
        "message" => "File tidak ditemukan"
    ]);
    exit;
}

$file = $_FILES['file_upload'];

if ($file['error'] != 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Upload gagal"
    ]);
    exit;
}

// validasi size (10MB)
if ($file['size'] > 10 * 1024 * 1024) {
    echo json_encode([
        "status" => "error",
        "message" => "File terlalu besar (maks 10MB)"
    ]);
    exit;
}

// validasi ekstensi
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext != 'xlsx') {
    echo json_encode([
        "status" => "error",
        "message" => "File harus .xlsx"
    ]);
    exit;
}

// ================= SIMPAN FILE =================
$id_upload = uniqid('upload_');

$folder = "../../_Upload/wilayah/";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$filename = $id_upload . ".xlsx";
$path = $folder . $filename;

if (!move_uploaded_file($file['tmp_name'], $path)) {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menyimpan file"
    ]);
    exit;
}

// ================= SIMPAN SESSION =================
// gunakan file json sederhana (lebih ringan dari DB untuk ini)
file_put_contents($folder.$id_upload.".json", json_encode([
    "file" => $filename,
    "last_row" => 1,
    "total_row" => 0
]));

echo json_encode([
    "status" => "success",
    "id_upload" => $id_upload
]);
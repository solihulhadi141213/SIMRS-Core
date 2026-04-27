<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header('Content-Type: application/json');

    // ===================== ROOT PATH =====================
    $ROOT = dirname(__DIR__, 2);
    $uploadDir = $ROOT . '/_FileUpload/';

    // ===================== INCLUDE =====================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // ===================== SET MYSQL SESSION =====================
    mysqli_query($Conn, "SET SESSION wait_timeout=28800");

    // ===================== VALIDASI SESSION =====================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Session habis, silakan login ulang'
        ]);
        exit;
    }

    // ===================== VALIDASI FILE =====================
    if (!isset($_FILES['file_upload'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'File tidak ditemukan'
        ]);
        exit;
    }

    $file = $_FILES['file_upload'];

    // cek error upload
    if ($file['error'] !== 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal upload file (error code: '.$file['error'].')'
        ]);
        exit;
    }

    // ===================== VALIDASI EXTENSION =====================
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($ext !== 'xlsx') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'File harus format XLSX'
        ]);
        exit;
    }

    // ===================== VALIDASI SIZE =====================
    $maxSize = 10 * 1024 * 1024; // 10MB

    if ($file['size'] > $maxSize) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Ukuran file maksimal 10MB'
        ]);
        exit;
    }

    // ===================== PASTIKAN FOLDER ADA =====================
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // ===================== RENAME FILE AMAN =====================
    $nama_file = 'ICD_' . date('Ymd_His') . '_' . random_int(1000,9999) . '.xlsx';
    $path = $uploadDir . $nama_file;

    // ===================== UPLOAD FILE =====================
    if (!move_uploaded_file($file['tmp_name'], $path)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menyimpan file ke server'
        ]);
        exit;
    }

    // ===================== HITUNG TOTAL BARIS =====================
    require '../../vendor/autoload.php';

    try {

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getActiveSheet();

        $total = $sheet->getHighestRow();

        // kurangi header
        $total = max(0, $total - 1);

    } catch (Exception $e) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal membaca file: ' . $e->getMessage()
        ]);
        exit;
    }

    // ===================== SIMPAN LOG =====================
    $stmt = mysqli_prepare($Conn, "
        INSERT INTO icd_upload_log 
        (file_name, total_rows, processed_rows, status, created_at)
        VALUES (?, ?, 0, 'process', NOW())
    ");

    mysqli_stmt_bind_param($stmt, "si", $nama_file, $total);
    mysqli_stmt_execute($stmt);

    $id_upload = mysqli_insert_id($Conn);

    // ===================== RESPONSE =====================
    echo json_encode([
        'status'    => 'success',
        'id_upload' => $id_upload,
        'total'     => $total
    ]);
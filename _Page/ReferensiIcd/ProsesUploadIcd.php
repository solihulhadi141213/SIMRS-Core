<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo json_encode(['status'=>'error','message'=>'Session habis']);
        exit;
    }

    // VALIDASI FILE
    if (!isset($_FILES['file_upload'])) {
        echo json_encode(['status'=>'error','message'=>'File tidak ditemukan']);
        exit;
    }

    $file = $_FILES['file_upload'];

    // VALIDASI SIZE (10MB)
    if ($file['size'] > 10 * 1024 * 1024) {
        echo json_encode(['status'=>'error','message'=>'File maksimal 10MB']);
        exit;
    }

    // VALIDASI EXTENSION
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (strtolower($ext) != 'xlsx') {
        echo json_encode(['status'=>'error','message'=>'Hanya file .xlsx']);
        exit;
    }

    // LOAD LIBRARY
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // LOAD FILE
    $spreadsheet = IOFactory::load($file['tmp_name']);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // SKIP HEADER
    array_shift($rows);

    mysqli_begin_transaction($Conn);

    try {

        $inserted = 0;

        foreach ($rows as $row) {

            $icd        = trim($row[1] ?? '');
            $kode       = trim($row[2] ?? '');
            $short_des  = trim($row[3] ?? '');
            $long_des   = trim($row[4] ?? '');

            if (empty($kode)) continue;

            // CEK DUPLIKAT
            $cek = mysqli_prepare($Conn, "SELECT id_icd FROM icd WHERE kode=? AND icd=?");
            mysqli_stmt_bind_param($cek, "ss", $kode, $icd);
            mysqli_stmt_execute($cek);
            mysqli_stmt_store_result($cek);

            if (mysqli_stmt_num_rows($cek) > 0) {
                continue;
            }

            // INSERT
            $stmt = mysqli_prepare($Conn, "INSERT INTO icd (kode, short_des, long_des, icd) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $kode, $short_des, $long_des, $icd);
            mysqli_stmt_execute($stmt);

            $inserted++;
        }

        mysqli_commit($Conn);

        echo json_encode([
            'status' => 'success',
            'message' => "Berhasil upload $inserted data"
        ]);

    } catch (Exception $e) {

        mysqli_rollback($Conn);

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
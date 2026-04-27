<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    if (empty($_POST['id_upload'])) {
        echo json_encode(['status'=>'error','message'=>'ID upload kosong']);
        exit;
    }

    $id_upload = (int)$_POST['id_upload'];

    $q = mysqli_query($Conn, "SELECT * FROM icd_upload_log WHERE id_upload='$id_upload'");
    $data = mysqli_fetch_assoc($q);

    if (!$data) {
        echo json_encode(['status'=>'error','message'=>'Data tidak ditemukan']);
        exit;
    }

    $ROOT = dirname(__DIR__, 2);
    $file = $ROOT . '/_FileUpload/' . $data['file_name'];

    if (!file_exists($file)) {
        echo json_encode(['status'=>'error','message'=>'File tidak ditemukan']);
        exit;
    }

    require '../../vendor/autoload.php';

    try {

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();

        $start = (int)$data['processed_rows'] + 2;
        $limit = 200; // diperbesar biar lebih cepat
        $end   = $start + $limit - 1;
        $total = (int)$data['total_rows'];

        for ($i = $start; $i <= $end && $i <= $total; $i++) {

            $icd   = trim($sheet->getCell("B$i")->getValue());
            $kode  = trim($sheet->getCell("C$i")->getValue());
            $short = trim($sheet->getCell("D$i")->getValue());
            $long  = trim($sheet->getCell("E$i")->getValue());

            if (!$kode) continue;

            mysqli_query($Conn,"
                INSERT IGNORE INTO icd (icd,kode,short_des,long_des)
                VALUES (
                    '".mysqli_real_escape_string($Conn,$icd)."',
                    '".mysqli_real_escape_string($Conn,$kode)."',
                    '".mysqli_real_escape_string($Conn,$short)."',
                    '".mysqli_real_escape_string($Conn,$long)."'
                )
            ");
        }

        $processed = min($end, $total);

        mysqli_query($Conn,"
            UPDATE icd_upload_log 
            SET processed_rows='$processed'
            WHERE id_upload='$id_upload'
        ");

        $progress = ($total > 0) ? round(($processed / $total) * 100) : 0;

        if ($processed >= $total) {

            mysqli_query($Conn,"
                UPDATE icd_upload_log SET status='done'
                WHERE id_upload='$id_upload'
            ");

            echo json_encode([
                'status'=>'selesai',
                'progress'=>100
            ]);

        } else {

            echo json_encode([
                'status'=>'lanjut',
                'progress'=>$progress
            ]);
        }

    } catch (Exception $e) {

        echo json_encode([
            'status'=>'error',
            'message'=>$e->getMessage()
        ]);
    }
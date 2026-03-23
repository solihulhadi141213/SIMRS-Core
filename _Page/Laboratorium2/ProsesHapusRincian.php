<?php
    /* Header JSON */
    header('Content-Type: application/json');

    /* Koneksi Database */
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiLaboratorium.php";

    // Validasi Sesi Akses
    if(empty($_SESSION['id_akses'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi Akses Sudah Berakhir! Silahkan Login Ulang!'
        ]);
        exit;
    }

    // Validasi Data Wajib
    if (empty($_POST['id_laboratorium_rincian'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Pemeriksaan Laboratorium Tidak Boleh Kosong!'
        ]);
        exit;
    }

    // Validasi Data Wajib
    if (empty($_POST['id_laboratorium'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Laboratorium Tidak Boleh Kosong!'
        ]);
        exit;
    }
    // Buat Variabel Dari Data Yang Ditangkap
    $id_laboratorium_rincian = validateAndSanitizeInput($_POST['id_laboratorium_rincian']);
    $id_laboratorium         = validateAndSanitizeInput($_POST['id_laboratorium']);
    

    // BUAT Token API
    $tokenData = getAnalyzaToken($Conn);
    if ($tokenData['status'] !== 'success') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Token Error: '.$tokenData['message'].''
        ]);
        exit;
    }

    // CURL API
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $tokenData['base_url'].'/_API/DeleteRincianPemeriksaan.php?id='.$id_laboratorium_rincian.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer '.$tokenData['token'],
            'Content-Type: application/json'
        ]
    ]);
    $response = curl_exec($curl);
    $errorCurl = curl_error($curl);
    curl_close($curl);

    // Debug CURL error
    if($errorCurl){
        echo json_encode([
            'status'  => 'error',
            'message' => 'CURL Error: '.$errorCurl.''
        ]);
        exit;
    }
    $response_arry = json_decode($response, true);

    // Debug API response format
    if(empty($response_arry)){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Response API tidak valid:<pre>'.$response.'</pre>'
        ]);
        exit;
    }

    if($response_arry['status'] !== "success"){
        $message = $response_arry['message'];
        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi Kesalahan Pada Saat Mengirim Data. <br> Keterangan : '.$message.' <br><pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre>'
        ]);
        exit;
    }
    echo json_encode([
        'status'          => 'success',
        'message'         => 'Rincian Pemeriksaan Laboratorium Berhasil Dihapus!',
        'id_laboratorium' => $id_laboratorium
    ]);
    exit;
?>

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
    if (empty($_POST['id_laboratorium'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Pemeriksaan Laboratorium Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if (empty($_POST['id_referensi_pemeriksaan'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Anda belum Memilih Referensi Pemeriksaan Apapaun!'
        ]);
        exit;
    }

    // Buat Variabel Dari Data Yang Ditangkap
    $id_laboratorium          = validateAndSanitizeInput($_POST['id_laboratorium']);
    $id_referensi_pemeriksaan = $_POST['id_referensi_pemeriksaan'];
    
    // Buat Payload
    $referensi_pemeriksaan = [];
    foreach ($id_referensi_pemeriksaan as $list_pemeriksaan){
        $pecah                    = explode('|', $list_pemeriksaan);
        $id_referensi_pemeriksaan = $pecah[0];
        $nama_pemeriksaan         = $pecah[1];
        $category_pemeriksaan     = $pecah[2];

        $referensi_pemeriksaan[] = [
            'id_referensi_pemeriksaan' => $id_referensi_pemeriksaan,
            'nama_pemeriksaan'         => $nama_pemeriksaan,
            'category_pemeriksaan'     => $category_pemeriksaan
        ];
    }
    $payload_json = json_encode($referensi_pemeriksaan, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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
        CURLOPT_URL => $tokenData['base_url'].'/_API/TambahRincian.php?id='.$id_laboratorium.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload_json,
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
        echo json_encode([
            'status'  => 'error',
            'message' => 'API Success tetapi ID Lab kosong <BR><pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre>'
        ]);
        exit;
    }
    echo json_encode([
        'status'          => 'success',
        'message'         => 'Rincian Pemeriksaan Laboratorium Berhasil Ditambahkan!',
        'id_laboratorium' => $id_laboratorium
    ]);
    exit;
?>

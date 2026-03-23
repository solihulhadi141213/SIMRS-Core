<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiRadiologi.php";
    
    // Validasi Akses
    if(empty($_SESSION['id_akses'])){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</div>';
        exit;
    }

    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_POST['id_radiologi'])){
        echo '<div class="alert alert-danger">ID Radiologi Tidak Boleh Kosong!</div>';
        exit;
    }

    // Buat variabel
    $id_radiologi = $_POST['id_radiologi'];

    // Token API
    $tokenData = getRadixToken($Conn);
    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger">Token Error: '.$tokenData['message'].'</div>';
        exit;
    }

    // CURL API
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $tokenData['base_url'].'/_API/CancleOrder?id_radiologi='.$id_radiologi.'',
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
        echo '<div class="alert alert-danger">CURL Error: '.$errorCurl.'</div>';
        exit;
    }

    $response_arry = json_decode($response, true);

    // Debug API response format
    if(empty($response_arry)){
        echo '<div class="alert alert-danger">Response API tidak valid:<pre>'.$response.'</pre></div>';
        exit;
    }

    if($response_arry['status'] === "success"){
        echo '
            <div class="alert alert-success">
                Data <i id="InsertNotif">Berhasil</i> Dihapus
            </div>
        ';
        exit;
    }else{

        // Kesalahan Pada API
        echo '
            <div class="alert alert-danger">
                API Gagal:<br>
                <pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre><br>
            </div>
        ';
        exit;
    }
?>
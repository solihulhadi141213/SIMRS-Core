<?php
    // Koneksi dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Session Akses
    if(empty($_SESSION['id_akses'])){
        echo '
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <div class="alert alert-danger"><small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</small></div>
                </div>
            </div>
        ';
        exit;
    }

    // id_setting_analyza wajib terisi
    if(empty($_POST['id_setting_analyza'])){
        echo '
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <div class="alert alert-danger"><small>ID Koneksi Tidak Boleh Kosong!</small></div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat variabel id_setting_analyza dan sanitasi
    $id_setting_analyza = (int) $_POST['id_setting_analyza'];

    // Buka Detail Koneksi
    $Qry = $Conn->prepare("SELECT * FROM setting_analyza WHERE id_setting_analyza = ?");
    $Qry->bind_param("i", $id_setting_analyza);

    if (!$Qry->execute()) {
        $error = $Conn->error;
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan membuka data!<br>Keterangan : '.$error.'</small>
            </div>
        ';
        exit;
    }

    $Result = $Qry->get_result();
    $Data = $Result->fetch_assoc();
    $Qry->close();

    // Validasi Data Ditemukan
    if(empty($Data)){
        echo '
            <div class="alert alert-danger">
                <small>Data setting_analyza tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Ambil kredensial
    $base_url = rtrim($Data['base_url'], '/');
    $username = $Data['username'];
    $password = $Data['password'];

    $url_request = "$base_url/_API/GenerateToken.php";

    // CURL REQUEST
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url_request,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query([
            'username' => $username,
            'password' => $password
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
    ));

    $response = curl_exec($curl);
    $curl_error = curl_error($curl);
    curl_close($curl);

    // Validasi CURL Error
    if ($curl_error) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menghubungi API!<br>Error: '.$curl_error.'</small>
            </div>
        ';
        exit;
    }

    // Decode JSON
    $response_array = json_decode($response, true);

    // Validasi JSON Response
    if (!$response_array) {
        echo '
            <div class="alert alert-danger">
                <small>Response API tidak valid!<br>Raw Response: '.$response.'</small>
            </div>
        ';
        exit;
    }

    // Echo Response API (Debug UI)
    echo '
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                <small><b>Response API:</b></small>
                <pre>'.json_encode($response_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>
            </div>
        </div>
    </div>
    ';

    // Validasi status sukses
    if ($response_array['status'] !== 'success') {
        echo '
            <div class="alert alert-danger">
                <small>Gagal membuat token!<br>Pesan: '.$response_array['message'].'</small>
            </div>
        ';
        exit;
    }

    // Ambil data token
    $token      = $response_array['token'];
    $created_at = date('Y-m-d H:i:s', strtotime($response_array['created_at']));
    $expired_at = date('Y-m-d H:i:s', strtotime($response_array['token_expired_at']));

    // UPDATE DATABASE
    $Update = $Conn->prepare("
        UPDATE setting_analyza 
        SET token = ?, creat_at = ?, expired_at = ?, status = 1
        WHERE id_setting_analyza = ?
    ");

    $Update->bind_param("sssi", $token, $created_at, $expired_at, $id_setting_analyza);

    if (!$Update->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menyimpan token ke database!<br>Error: '.$Conn->error.'</small>
            </div>
        ';
        exit;
    }

    $Update->close();

    // SUCCESS OUTPUT
    echo '
        <div class="alert alert-success text-center">
            <small>Token berhasil dibuat & disimpan ke database.</small>
        </div>
    ';
?>

<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VValidasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "message" => "Sesi Akses Sudah Berakhir! Silahkan Login Ulang!"
        ]);
        exit;
    }

    // Validasi Data Mandatory
    if(empty($_POST['id_pasien'])){
        echo json_encode([
            "status" => "error",
            "message" => "Nomor RM Pasien Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($_POST['nama'])){
        echo json_encode([
            "status" => "error",
            "message" => "Nama Pasien Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($_POST['gender'])){
        echo json_encode([
            "status" => "error",
            "message" => "Gender Pasien Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($_POST['id_kunjungan'])){
        echo json_encode([
            "status" => "error",
            "message" => "ID Kunjungan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($_POST['tujuan'])){
        echo json_encode([
            "status" => "error",
            "message" => "Tujuan Kunjungan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($_POST['pembayaran'])){
        echo json_encode([
            "status" => "error",
            "message" => "Metode Pembayaran Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($_POST['id_referensi_pemeriksaan'])){
        echo json_encode([
            "status" => "error",
            "message" => "Jenis Pemeriksaan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    // Buat Variabel
    $id_pasien                = $_POST['id_pasien'];
    $nama                     = $_POST['nama'];
    $gender                   = $_POST['gender'];
    $tanggal_lahir            = $_POST['tanggal_lahir'];
    $ihs_pasien               = $_POST['ihs_pasien'];
    $id_kunjungan             = $_POST['id_kunjungan'];
    $tujuan                   = $_POST['tujuan'];
    $pembayaran               = $_POST['pembayaran'];
    $fakses                   = $_POST['fakses'];
    $unit                     = $_POST['unit'];
    $id_encounter             = $_POST['id_encounter'];
    $nama_dokter_pengirim     = $_POST['nama_dokter_pengirim'];
    $kode_dokter_pengirim     = $_POST['kode_dokter_pengirim'];
    $ihs_dokter_pengirim      = $_POST['ihs_dokter_pengirim'];
    $nama_diagnosis           = $_POST['nama_diagnosis'];
    $kode_diagnosis           = $_POST['kode_diagnosis'];
    $system_diagnosis         = $_POST['system_diagnosis'];
    $id_referensi_pemeriksaan = $_POST['id_referensi_pemeriksaan'];

    // Validasi Token
    // Buka Pengaturan Analyza yang aktif
    $status_setting = 1;
    $query          = "SELECT * FROM setting_analyza WHERE status = ?";
    $stmt           = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal <i>prepare query</i> saat membuka setting koneksi Analyza"
        ]);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $status_setting);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result || mysqli_num_rows($result) == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal <i>prepare query</i> saat membuka setting koneksi Analyza"
        ]);
        exit;
    }
    $data = mysqli_fetch_assoc($result);

    // Status badge
    $base_url   = $data['base_url'];
    $username   = $data['username'];
    $password   = $data['password'];
    $token      = $data['token'];
    $creat_at   = $data['creat_at'];
    $expired_at = $data['expired_at'];

    // Validasi Expired Token
    $Now = date('Y-m-d H:i:s');
    if ($expired_at <= $Now) {

        // Buat Token Baru

        // Tentukan Url
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

        // Validasi CURL Error
        if ($curl_error) {
            echo json_encode([
                "status" => "error",
                "message" => 'Gagal menghubungi API!<br>Error: '.$curl_error.''
            ]);
            exit;
        }

        // Decode JSON
        $response_array = json_decode($response, true);

        // Validasi JSON Response
        if (!$response_array) {
            echo json_encode([
                "status" => "error",
                "message" => 'Response API tidak valid!<br>Raw Response: '.$response.''
            ]);
            exit;
        }

        // Validasi status sukses
        if ($response_array['status'] !== 'success') {
            echo json_encode([
                "status" => "error",
                "message" => 'Gagal membuat token!<br>Pesan: '.$response_array['message'].''
            ]);
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
            WHERE status = ?
        ");
        $Update->bind_param("sssi", $token, $created_at, $expired_at, $status_setting);
        if (!$Update->execute()) {
            echo json_encode([
                "status" => "error",
                "message" => 'Gagal menyimpan token ke database!<br>Error: '.$Conn->error.''
            ]);
            exit;
            $Update->close();
            mysqli_stmt_close($stmt);
            exit;
        }
        $Update->close();
        mysqli_stmt_close($stmt);
    }

    // Referensi Pemeriksaan
    $referensi_pemeriksaan = [];
    if (is_array($id_referensi_pemeriksaan)) {
        foreach ($id_referensi_pemeriksaan as $id_referensi) {
            $id_referensi = (int)$id_referensi;
            if ($id_referensi <= 0) {
                continue;
            }
            $referensi_pemeriksaan[] = [
                "id_referensi_pemeriksaan" => (int)$id_referensi
            ];
        }
    }

    // Buat Payload
    $payload_data = [
        "id_pasien" => $id_pasien,

        "id_kunjungan" => $id_kunjungan,

        "ihs_pasien" => $ihs_pasien,

        "id_encounter" => $id_encounter,

        "nama" => $nama,

        "gender" => $gender,

        "tanggal_lahir" => $tanggal_lahir,

        "tujuan" => $tujuan,

        "pembayaran" => $pembayaran,

        "fakses" => $fakses,

        "unit" => $unit,

        "priority" => "routine",

        "kode_dokter_pengirim" => $kode_dokter_pengirim,

        "ihs_dokter_pengirim" => $ihs_dokter_pengirim,

        "nama_dokter_pengirim" => $nama_dokter_pengirim,

        "kode_petugas" => "",

        "ihs_petugas" => "",

        "nama_petugas" => "",

        "nama_diagnosis" => $nama_diagnosis,

        "kode_diagnosis" => $kode_diagnosis,

        "system_diagnosis" => $system_diagnosis,

        "keterangan" => "Permintaan untuk " . $tujuan,

        "referensi_pemeriksaan" => $referensi_pemeriksaan
    ];

    $payload = json_encode(
        $payload_data,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    // Kirim data Ke Analyza
    $url_request = $base_url . '/_API/KirimPermintaan.php';
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url_request,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',

        CURLOPT_POSTFIELDS => $payload,

        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ],
    ]);
    $response = curl_exec($curl);
    $curl_error = curl_error($curl);
    $http_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($curl_error) {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menghubungi API: " . $curl_error
        ]);
        exit;
    }
    $response_array = json_decode($response, true);
    if ($http_code < 200 || $http_code >= 300) {
        echo json_encode([
            "status" => "error",
            "message" => "API mengembalikan HTTP " . $http_code,
            "response" => $response_array
        ]);
        exit;
    }

    // Response Berhasil
    echo json_encode([
        "status" => "success",
        "message" => "Data Permintaan Berhasil Terkirim!"
    ]);


?>

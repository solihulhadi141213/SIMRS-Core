<?php
    // Atur Format File Response
    header('Content-Type: application/json');
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: false');
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");

    // Zona Waktu Untuk Token
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // Tanggal dan Service Name
    $now          = date('Y-m-d H:i:s');
    $service_name = "Generate Token";

    // Definisikan Variabel
    $code = 404;
    $keterangan ="Error Tidak Diketahui";

    //Validasi Metode Pengiriman data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["response" => ["message" => "Metode request tidak diizinkan", "code" => 405],"metadata" => []]);
        exit;
    }

    // Tangkap Data Dari Body
    $fp = fopen('php://input', 'r');
    $raw = stream_get_contents($fp);
    $Tangkap = json_decode($raw, true);

    //Validasi Format JSON
    if (!is_array($Tangkap)) {
        http_response_code(400);
        echo json_encode(["response" => ["message" => "Format JSON tidak valid","code" => 400],"metadata" => []]);
        exit;
    }

    //Validasi Kelengkapan Data
    if (empty($Tangkap['client_id'])) {
        http_response_code(422);
        echo json_encode(["response" => ["message" => "Client ID Tidak Boleh Kosong", "code" => 422],"metadata" => []]);
        exit;
    }
    if (empty($Tangkap['client_key'])) {
        http_response_code(422);
        echo json_encode(["response" => ["message" => "Client Key Tidak Boleh Kosong", "code" => 422],"metadata" => []]);
        exit;
    }
            
    //Bersihkan Variabel Dengan Sanitasi menggunakan Fungsi yang sudah diatur
    $client_id = validateAndSanitizeInput($Tangkap['client_id']);
    $client_key = validateAndSanitizeInput($Tangkap['client_key']);
            
    //Validasi 'client_id' dan 'client_key' berdasarkan database 'api_access'
    $stmt = $Conn->prepare("SELECT id_api_access, api_name, api_description, expired_duration FROM api_access WHERE client_id = ? AND client_key = ?");
    $stmt->bind_param("ss", $client_id, $client_key);
    $stmt->execute();
    $result = $stmt->get_result();
    $DataValidasiApi = $result->fetch_assoc();

    if (empty($DataValidasiApi['id_api_access'])) {
        http_response_code(401);
        echo json_encode(["response" => ["message" => "Client ID atau Client Key tidak valid", "code" => 401],"metadata" => []]);
        exit;
    }
    $id_api_access    = $DataValidasiApi['id_api_access'];
    $api_name         = $DataValidasiApi['api_name'];
    $api_description  = $DataValidasiApi['api_description'];
    $expired_duration = $DataValidasiApi['expired_duration'];
                
    //Buat Token Dan Expired Duration Nya
    $token = bin2hex(random_bytes(16));      
    $expired_duration_in_seconds = 24 * 60 * 60;
    $datetime_expired = date(
        'Y-m-d H:i:s',
        strtotime($now) + $expired_duration_in_seconds
    );

    // Menyimpan Data Dengan prepared Statment
    $query = "INSERT INTO api_token (
        id_api_access,
        client_id,
        token,
        datetime_creat,
        datetime_expired
    ) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $Conn->prepare($query)) {
        // Binding parameter dengan tipe data yang sesuai
        $stmt->bind_param("issss", $id_api_access, $client_id, $token, $now, $datetime_expired);

        // Eksekusi query
        if ($stmt->execute()) {

            //Jika Berhasil Catat Dalam 'api_log'
            $EntryLog = "INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) VALUES (?, ?, ?, ?, ?)";
            $stmtLog = $Conn->prepare($EntryLog);
            $stmtLog->bind_param("sssis", $id_api_access, $now, $service_name, $code, $keterangan);
            $stmtLog->execute();

            //Persiapkan Response
            $metadata = [
                "id_api_access" => $id_api_access,
                "api_name" => $api_name,
                "api_description" => $api_description,
                "expired_duration" => $expired_duration,
                "datetime_creat" => $now,
                "datetime_expired" => $datetime_expired,
                "token" => $token
            ];
            http_response_code(200);
            echo json_encode(["response" => ["message" => 'Berhasil', "code" => 200],"metadata" => $metadata]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["response" => ["message" => 'Terjadi Kesalahan Pada Saat Menyimpan Token Ke Database: '. $stmt->error.'', "code" => 500],"metadata" => []]);
            exit;
        }

        // Tutup statement
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(["response" => ["message" => 'Gagal menyiapkan query: '.$Conn->error.'', "code" => 500],"metadata" => []]);
        exit;
    }
    // Pastikan koneksi ditutup setelah selesai digunakan
    $Conn->close();
?>

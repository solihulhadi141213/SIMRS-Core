<?php
    ob_start(); // Start output buffering
    header('Content-Type: application/json');
    // Set timezone
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";

    // Current date and service name
    $now = date('Y-m-d H:i:s');
    $service_name = "Pencarian NIK Pasien";

    // Initialize variables for response
    $response_message = "";
    $code = 200;
    $metadata = [];

    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $response_message = "Methode yang digunakan tidak valid";
        $code = 405;
    } else {
        // Retrieve token from headers
        $headers = getallheaders();
        $token = isset($headers['token']) ? validateAndSanitizeInput($headers['token']) : null;

        // Validate token
        if (empty($token)) {
            $response_message = "Token Tidak Boleh Kosong";
            $code = 400;
        } else {
            // Validate token in the database using prepared statement
            $stmt = $Conn->prepare("SELECT * FROM api_access WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $DataValidasiApi = $result->fetch_assoc();

            if (empty($DataValidasiApi['id_api_access'])) {
                $response_message = "Token yang anda gunakan tidak valid atau tidak ditemukan pada database";
                $code = 401;
            } else {
                $id_api_access = $DataValidasiApi['id_api_access'];
                $datetime_expired = $DataValidasiApi['datetime_expired'];
                $current_time = date('Y-m-d H:i:s');
                // Nomor Kartu Tidak Boleh Kosong
                if (empty($_GET['nomor_kartu'])) {
                    $response_message = "Nomor Kartu BPJS Tidak Boleh Kosong";
                    $code = 400;
                } else {
                    $nomor_kartu = validateAndSanitizeInput($_GET['nomor_kartu']);
                    // Retrieve
                    $metadata = [];
                    $pencarian_peserta=PesertaByNoKa($url_vclaim,$consid,$secret_key,$user_key,$nomor_kartu);
                    date_default_timezone_set('UTC');
                    $ambil_json =json_decode($pencarian_peserta, true);
                    if($ambil_json["metaData"]["code"]!=="200"){
                        $code = $ambil_json["metaData"]["code"];
                        $response_message = $ambil_json["metaData"]["message"];
                    }else{
                        $string=$ambil_json["response"];
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        $key="$consid$secret_key$timestamp";
                        $FileDeskripsi=stringDecrypt("$key", "$string");
                        $FileDekompresi=decompress("$FileDeskripsi");
                        $JsonData =json_decode($FileDekompresi, true);
                        // Set success response
                        $response_message = "Success";
                        $metadata = $JsonData['peserta'];
                    }
                }
            }
        }
    }

    // Log the request in the database
    $stmtLog = $Conn->prepare("INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) 
        VALUES (?, ?, ?, ?, ?)");
    $stmtLog->bind_param("sssis", $id_api_access, $now, $service_name, $code, $response_message);
    $stmtLog->execute();

    // Prepare the response
    $response = [
        "message" => $response_message,
        "code" => $code,
    ];

    $Array = [
        "response" => $response,
        "metadata" => $metadata
    ];

    // Send response in JSON format
    echo json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    // Set headers
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");

    exit();
?>

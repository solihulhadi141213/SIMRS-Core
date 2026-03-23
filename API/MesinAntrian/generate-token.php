<?php
    // Atur Format File Response
    header('Content-Type: application/json');
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    
    // Tanggal dan Service Name
    $now = date('Y-m-d H:i:s');
    $service_name = "Generate Token";
    
    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $metode = $_SERVER['REQUEST_METHOD'];
        $id_api_access = 0;
        $response_message = "Metode request tidak diizinkan";
        $code = 405;
        $metadata = [];
    } else {
        // Tangkap data dan decode
        $fp = fopen('php://input', 'r');
        $raw = stream_get_contents($fp);
        $Tangkap = json_decode($raw, true);
        
        // Validasi client_id tidak boleh kosong
        if (empty($Tangkap['client_id'])) {
            $id_api_access = 0;
            $keterangan = "Client ID Tidak Boleh Kosong";
            $code = 400;
            $metadata = [];
        } else {
            // Validasi client_key tidak boleh kosong
            if (empty($Tangkap['client_key'])) {
                $id_api_access = 0;
                $keterangan = "Client Key Tidak Boleh Kosong";
                $code = 400;
                $metadata = [];
            } else {
                // Bersihkan input
                $client_id = validateAndSanitizeInput($Tangkap['client_id']);
                $client_key = validateAndSanitizeInput($Tangkap['client_key']);
                
                // Validasi Data dengan Prepared Statement
                $stmt = $Conn->prepare("SELECT * FROM api_access WHERE client_id = ? AND client_key = ?");
                $stmt->bind_param("ss", $client_id, $client_key);
                $stmt->execute();
                $result = $stmt->get_result();
                $DataValidasiApi = $result->fetch_assoc();
                
                if (empty($DataValidasiApi['id_api_access'])) {
                    $id_api_access = 0;
                    $keterangan = "client_id dan client_key Tidak Valid";
                    $code = 401;
                    $metadata = [];
                } else {
                    $id_api_access = $DataValidasiApi['id_api_access'];
                    $api_name = $DataValidasiApi['api_name'];
                    $api_description = $DataValidasiApi['api_description'];
                    $expired_duration = $DataValidasiApi['expired_duration'];
                    $datetime_creat = $DataValidasiApi['datetime_creat'];
                    $datetime_update = date('Y-m-d H:i:s');
                    
                    // Membuat Token
                    $token = bin2hex(random_bytes(16)); // Secure Token Generation
                    
                    // Menghitung Expired Time
                    $datetime_expired ="2600-12-12 12:12:12";
                    
                    // Menyimpan token pada database dengan Prepared Statement
                    $stmtUpdate = $Conn->prepare("UPDATE api_access SET token = ?, datetime_update = ?, datetime_expired = ? WHERE id_api_access = ?");
                    $stmtUpdate->bind_param("ssss", $token, $datetime_update, $datetime_expired, $id_api_access);
                    if (!$stmtUpdate->execute()) {
                        $keterangan = "Terjadi kesalahan pada saat melakukan update data";
                        $code = 500;
                        $metadata = [];
                    } else {
                        $keterangan = "success";
                        $code = 200;
                        $metadata = [
                            "id_api_access" => $id_api_access,
                            "api_name" => $api_name,
                            "api_description" => $api_description,
                            "expired_duration" => $expired_duration,
                            "datetime_creat" => $datetime_creat,
                            "datetime_update" => $datetime_update,
                            "datetime_expired" => $datetime_expired,
                            "token" => $token
                        ];
                    }
                }
            }
        }
    }
    
    // Logging
    $EntryLog = "INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) VALUES (?, ?, ?, ?, ?)";
    $stmtLog = $Conn->prepare($EntryLog);
    $stmtLog->bind_param("sssis", $id_api_access, $now, $service_name, $code, $keterangan);
    $stmtLog->execute();
    
    if ($stmtLog) {
        $response = [
            "message" => $keterangan,
            "code" => $code,
        ];
        $metadata = $metadata;
    } else {
        $response = [
            "message" => "Terjadi kesalahan pada saat menyimpan Log",
            "code" => 500,
        ];
        $metadata = [];
    }
    
    $Array = [
        "response" => $response,
        "metadata" => $metadata
    ];
    
    $json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    
    echo $json;
    exit();
?>

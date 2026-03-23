<?php
    // Set response format to JSON
    header('Content-Type: application/json');

    // Set timezone
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";

    // Current date and service name
    $now = date('Y-m-d H:i:s');
    $service_name = "List Poliklinik";

    // Initialize variables for response
    $response_message = "";
    $code = 200;
    $metadata = [];

    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response_message = "Method Yang Digunakan Tidak Diijinkan";
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
                $response_message = "Token Yang Anda Gunakan Tidak Valid";
                $code = 401;
            } else {
                $id_api_access = $DataValidasiApi['id_api_access'];
                $datetime_expired = $DataValidasiApi['datetime_expired'];
                $current_time = date('Y-m-d H:i:s');
                $fp = fopen('php://input', 'r');
                $raw = stream_get_contents($fp);
                $data = json_decode($raw,true);
                //Tangkap Data id_dokter
                if(empty($data['id_dokter'])){
                    $response_message = "ID Dokter Tidak Boleh Kosong!";
                    $code = 401;
                }else{
                    if(empty($data['tanggal'])){
                        $response_message = "Tanggal Kunjungan Tidak Boleh Kosong!";
                        $code = 401;
                    }else{
                        $id_dokter=validateAndSanitizeInput($data['id_dokter']);
                        $tanggal=validateAndSanitizeInput($data['tanggal']);
                        //Buka nama hari
                        $nama_hari=NamaHariJadwal($tanggal);
                        // Retrieve jadwal list
                        $list_jadwal = [];
                        $stmt_jadwal = $Conn->prepare("SELECT * FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND hari='$nama_hari' ORDER BY id_jadwal  ASC");
                        $stmt_jadwal->execute();
                        $result_jadwal = $stmt_jadwal->get_result();
                        $jumlah_data = $result_jadwal->num_rows;
                        while ($row_jadwal = $result_jadwal->fetch_assoc()) {
                            $id_jadwal  = $row_jadwal['id_jadwal'];
                            $id_poliklinik = $row_jadwal['id_poliklinik'];
                            $dokter = $row_jadwal['dokter'];
                            $poliklinik = $row_jadwal['poliklinik'];
                            $hari = $row_jadwal['hari'];
                            $jam = $row_jadwal['jam'];
                            $kuota_non_jkn = $row_jadwal['kuota_non_jkn'];
                            $kuota_jkn = $row_jadwal['kuota_jkn'];
                            $time_max = $row_jadwal['time_max'];

                            $list_jadwal[] = [
                                'id_jadwal' => $id_jadwal,
                                'id_poliklinik' => $id_poliklinik,
                                'dokter' => $dokter,
                                'poliklinik' => $poliklinik,
                                'hari' => $hari,
                                'jam' => $jam,
                                'kuota_non_jkn' => $kuota_non_jkn,
                                'kuota_jkn' => $kuota_jkn,
                                'time_max' => $time_max
                            ];
                        }

                        $response_message = "Success";
                        $metadata = [
                            "hari" => $nama_hari,
                            "jumlah_data" => $jumlah_data,
                            "list_jadwal" => $list_jadwal
                        ];
                    }
                }
            }
        }
    }

    // Log the request in the database
    $stmtLog = $Conn->prepare("INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) VALUES (?, ?, ?, ?, ?)");
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

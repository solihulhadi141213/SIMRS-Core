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
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $response_message = "Metode Yang Digunakan Tidak Diizinkan";
        $code = 405;
    } else {
        // Retrieve token from headers
        $headers = getallheaders();
        $token = isset($headers['token']) ? validateAndSanitizeInput($headers['token']) : null;

        // Validate token
        if (empty($token)) {
            $response_message = "Token Tidak Boleh Kosong!";
            $code = 400;
        } else {
            // Validate token in the database using prepared statement
            $stmt = $Conn->prepare("SELECT * FROM api_access WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $DataValidasiApi = $result->fetch_assoc();

            if (empty($DataValidasiApi['id_api_access'])) {
                $response_message = "Token Tidak Valid";
                $code = 401;
            } else {
                $id_api_access = $DataValidasiApi['id_api_access'];
                $datetime_expired = $DataValidasiApi['datetime_expired'];
                $current_time = date('Y-m-d H:i:s');
                // Retrieve poliklinik list
                $list_poliklinik = [];
                $stmt_poli = $Conn->prepare("SELECT DISTINCT id_poliklinik FROM jadwal_dokter ORDER BY poliklinik ASC");
                $stmt_poli->execute();
                $result_poli = $stmt_poli->get_result();
                $jumlah_data = $result_poli->num_rows;

                while ($row_poli = $result_poli->fetch_assoc()) {
                    $id_poliklinik = $row_poli['id_poliklinik'];
                    $nama_poli = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'nama');
                    $kode_poli = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'kode');

                    // Retrieve doctors for this poliklinik
                    $list_dokter = [];
                    $stmt_dokter = $Conn->prepare("SELECT DISTINCT id_dokter FROM jadwal_dokter WHERE id_poliklinik = ? ORDER BY poliklinik ASC");
                    $stmt_dokter->bind_param("i", $id_poliklinik);
                    $stmt_dokter->execute();
                    $result_dokter = $stmt_dokter->get_result();

                    while ($row_dokter = $result_dokter->fetch_assoc()) {
                        $id_dokter = $row_dokter['id_dokter'];
                        $nama_dokter = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');
                        $kode_dokter = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'kode');
                        $list_dokter[] = [
                            'id_dokter' => $id_dokter,
                            'kode' => $kode_dokter,
                            'nama' => $nama_dokter
                        ];
                    }

                    $list_poliklinik[] = [
                        'id_poliklinik' => $id_poliklinik,
                        'kode_poli' => $kode_poli,
                        'nama_poli' => $nama_poli,
                        'list_dokter' => $list_dokter
                    ];
                }

                $response_message = "Success";
                $metadata = [
                    "jumlah_data" => $jumlah_data,
                    "list_poliklinik" => $list_poliklinik
                ];
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

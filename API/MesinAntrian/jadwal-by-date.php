<?php
    ob_start(); // Start output buffering
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
        $response_message = "Metode Yang Anda Gunakan Tidak Valid";
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
                // Check if 'tanggal' parameter is provided
                if (empty($_GET['tanggal'])) {
                    $response_message = "Tanggal Tidak Boleh Kosong";
                    $code = 400;
                } else {
                    $tanggal = validateAndSanitizeInput($_GET['tanggal']);
                    $nama_hari = NamaHariJadwal($tanggal);

                    // Retrieve poliklinik list and associated doctors
                    $list_poliklinik = [];
                    $stmt_poli = $Conn->prepare("SELECT DISTINCT p.id_poliklinik, p.kode, p.nama 
                        FROM poliklinik p
                        JOIN jadwal_dokter jd ON jd.id_poliklinik = p.id_poliklinik
                        WHERE jd.hari = ? ORDER BY p.nama ASC");
                    $stmt_poli->bind_param("s", $nama_hari);
                    $stmt_poli->execute();
                    $result_poli = $stmt_poli->get_result();
                    $jumlah_data = $result_poli->num_rows;

                    // Fetch poliklinik and associated doctors
                    while ($row_poli = $result_poli->fetch_assoc()) {
                        $id_poliklinik = $row_poli['id_poliklinik'];
                        $kode_poli = $row_poli['kode'];
                        $nama_poli = $row_poli['nama'];

                        // Retrieve doctors for this poliklinik
                        $list_dokter = [];
                        $stmt_dokter = $Conn->prepare("SELECT jd.id_jadwal, jd.id_dokter, jd.jam, jd.kuota_non_jkn, jd.kuota_jkn, 
                                                        d.kode AS kode_dokter, d.nama AS nama_dokter
                            FROM jadwal_dokter jd
                            JOIN dokter d ON jd.id_dokter = d.id_dokter
                            WHERE jd.id_poliklinik = ? AND jd.hari = ?
                            ORDER BY jd.jam ASC");
                        $stmt_dokter->bind_param("is", $id_poliklinik, $nama_hari);
                        $stmt_dokter->execute();
                        $result_dokter = $stmt_dokter->get_result();

                        while ($row_dokter = $result_dokter->fetch_assoc()) {
                            $list_dokter[] = [
                                'id_jadwal' => $row_dokter['id_jadwal'],
                                'id_dokter' => $row_dokter['id_dokter'],
                                'kode' => $row_dokter['kode_dokter'],
                                'nama' => $row_dokter['nama_dokter'],
                                'jam' => $row_dokter['jam'],
                                'kuota_non_jkn' => $row_dokter['kuota_non_jkn'],
                                'kuota_jkn' => $row_dokter['kuota_jkn']
                            ];
                        }

                        $list_poliklinik[] = [
                            'id_poliklinik' => $id_poliklinik,
                            'kode_poli' => $kode_poli,
                            'nama_poli' => $nama_poli,
                            'list_dokter' => $list_dokter
                        ];
                    }

                    // Set success response
                    $response_message = "Success";
                    $metadata = [
                        "hari" => $nama_hari,
                        "jumlah_data" => $jumlah_data,
                        "list_poliklinik" => $list_poliklinik
                    ];
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

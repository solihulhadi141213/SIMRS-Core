<?php
    // Set timezone dan header JSON
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Include konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";

    // Nama layanan dan waktu saat ini
    $now = date('Y-m-d H:i:s');
    $service_name = "Pencarian Pasien";

    // Inisialisasi variabel respon
    $response_message = "";
    $code = 200;
    $metadata = [];

    // Validasi metode permintaan
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response_message = "Method not allowed";
        $code = 405;
    } else {
        // Ambil token dari header
        $headers = getallheaders();
        $token = isset($headers['token']) ? validateAndSanitizeInput($headers['token']) : null;

        // Validasi token
        if (empty($token)) {
            $response_message = "Token is required";
            $code = 400;
        } else {
            // Validasi token di database
            $stmt = $Conn->prepare("SELECT * FROM api_access WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $DataValidasiApi = $result->fetch_assoc();

            if (!$DataValidasiApi) {
                $response_message = "Invalid token";
                $code = 401;
            } else {
                $id_api_access = $DataValidasiApi['id_api_access'];
                $datetime_expired = $DataValidasiApi['datetime_expired'];
                $current_time = date('Y-m-d H:i:s');
                // Ambil data dari body permintaan
                $raw = file_get_contents('php://input');
                $data = json_decode($raw, true);

                if (empty($data['keyword_by']) || empty($data['keyword'])) {
                    $response_message = "Kategori dan keyword pencarian tidak boleh kosong!";
                    $code = 400;
                } else {
                    $keyword_by = validateAndSanitizeInput($data['keyword_by']);
                    $keyword = validateAndSanitizeInput($data['keyword']);

                    // Validasi kolom pencarian
                    $allowed_columns = ['id_pasien', 'id_ihs', 'nik', 'no_bpjs'];
                    if (!in_array($keyword_by, $allowed_columns)) {
                        $response_message = "Kategori pencarian tidak valid";
                        $code = 400;
                    } else {
                        // Query ke database menggunakan parameter bind
                        $query = "SELECT * FROM pasien WHERE $keyword_by = ?";
                        $stmt_pasien = $Conn->prepare($query);
                        $stmt_pasien->bind_param("s", $keyword);
                        $stmt_pasien->execute();
                        $result_pasien = $stmt_pasien->get_result();

                        if ($result_pasien->num_rows === 0) {
                            $response_message = "Tidak ada data pasien ditemukan";
                            $code = 200;
                        } else {
                            $response_message = "Success";
                            $code = 200;
                            $metadata = $result_pasien->fetch_assoc();
                        }
                    }
                }
            }
        }
    }

    // Catat log permintaan
    $stmtLog = $Conn->prepare("INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) VALUES (?, ?, ?, ?, ?)");
    $stmtLog->bind_param("sssis", $id_api_access, $now, $service_name, $code, $response_message);
    $stmtLog->execute();

    // Siapkan respon
    $response = [
        "response" => [
            "message" => $response_message,
            "code" => $code
        ],
        "metadata" => $metadata
    ];

    // Kirim respon
    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    // Tambahkan header tambahan
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");

    exit();
?>

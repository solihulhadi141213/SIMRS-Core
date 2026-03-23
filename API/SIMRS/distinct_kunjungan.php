<?php
    // Zona Waktu
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";
    // Tanggal dan Service Name
    $now = date('Y-m-d H:i:s');
    $service_name = "List Distinct Kunjungan";
    
    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(["response" => ["message" => "Metode request tidak diizinkan", "code" => 405],"metadata" => []]);
        exit;
    }
    // Tangkap Header Token
    $headers = getallheaders();
    
    // Validasi token tidak boleh kosong
    if (!isset($headers['token'])) {
        http_response_code(404);
        echo json_encode(["response" => ["message" => "Token Tidak Boleh Kosong", "code" => 404],"metadata" => []]);
        exit;
    }
    // Bersihkan dan validasi token
    $token = validateAndSanitizeInput($headers['token']);
    
    // Validasi Token dari tabel 'api_token' dengan Prepared Statement
    $stmt = $Conn->prepare("SELECT * FROM api_token WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $DataValidasiApi = $result->fetch_assoc();
    
    if (empty($DataValidasiApi['id_api_token'])) {
        http_response_code(401);
        echo json_encode(["response" => ["message" => "Token Yang Anda Gunakan Tidak Valid", "code" => 401],"metadata" => []]);
        exit;
    }
    $id_api_token     = $DataValidasiApi['id_api_token'];
    $id_api_access    = $DataValidasiApi['id_api_access'];
    $client_id        = $DataValidasiApi['client_id'];
    $datetime_expired = $DataValidasiApi['datetime_expired'];

    //Apakah token Sudah Expired
    if($datetime_expired<$now){
        http_response_code(401);
        echo json_encode(["response" => ["message" => "Token Expired", "code" => 401],"metadata" => []]);
        exit;
    }

    //Buka Data 'api_access'
    $api_name        = getDataDetail_v2($Conn, 'api_access', 'id_api_access', $id_api_access, 'api_name');
    $api_description = getDataDetail_v2($Conn, 'api_access', 'id_api_access', $id_api_access, 'api_description');

    //Parameter Kolom Tidak Boleh Kosong
    if(empty($_GET['colom'])){
        http_response_code(404);
        echo json_encode(["response" => ["message" => "Nama Kolom Tidak Boleh Kosong", "code" => 404],"metadata" => []]);
        exit;
    }
    //Nilai Kolom
    // Daftar nama kolom yang diperbolehkan (whitelist)
    $allowed_columns = ['tujuan', 'status', 'poliklinik', 'dokter'];

    $colom = validateAndSanitizeInput($_GET['colom']);

    // Pastikan nama kolom valid dan tidak kosong
    if (!in_array($colom, $allowed_columns)) {
        http_response_code(404);
        echo json_encode(["response" => ["message" => "Kolom tidak valid atau tidak diperbolehkan.", "code" => 404],"metadata" => []]);
        exit;
    }

    $list_kolom = [];
    $query = "SELECT DISTINCT `$colom` FROM kunjungan_utama ORDER BY `$colom` ASC";
    if ($Qry = mysqli_query($Conn, $query)) {
        while ($Data = mysqli_fetch_assoc($Qry)) {
            $DataOption = $Data[$colom];
            $list_kolom[] = $DataOption;
        }
        $metadata = [
            "list_kolom" => $list_kolom
        ];
        http_response_code(200);
        echo json_encode(["response" => ["message" => 'Berhasil', "code" => 200],"metadata" => $metadata],JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    } else {
        $error = "Query Error: " . mysqli_error($Conn);
        http_response_code(500);
        echo json_encode(["response" => ["message" => $error, "code" => 500],"metadata" => []],JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
    
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    exit();
?>

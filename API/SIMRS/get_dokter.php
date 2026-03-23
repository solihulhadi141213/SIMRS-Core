<?php
    // Atur Format File Response
    header('Content-Type: application/json');
    // Zona Waktu
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";
    // Tanggal dan Service Name
    $now = date('Y-m-d H:i:s');
    $service_name = "List Dokter";
    
    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $metode = $_SERVER['REQUEST_METHOD'];
        $id_api_access = 0;
        $response_message = "Metode request tidak diizinkan";
        $code = 405;
        $metadata = [];
    } else {
        // Tangkap Header Token
        $headers = getallheaders();
        
        // Validasi token tidak boleh kosong
        if (!isset($headers['token'])) {
            $id_api_access = 0;
            $keterangan = "Token Tidak Boleh Kosong";
            $code = 400;
            $metadata = [];
        } else {
            // Bersihkan dan validasi token
            $token = validateAndSanitizeInput($headers['token']);
            
            // Validasi Token dari tabel 'api_token' dengan Prepared Statement
            $stmt = $Conn->prepare("SELECT * FROM api_token WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $DataValidasiApi = $result->fetch_assoc();
            
            if (empty($DataValidasiApi['id_api_token'])) {
                $id_api_access = 0;
                $keterangan = "Token Yang Anda Gunakan Tidak Valid";
                $code = 401;
                $metadata = [];
            } else {
                $id_api_token = $DataValidasiApi['id_api_token'];
                $id_api_access = $DataValidasiApi['id_api_access'];
                $client_id = $DataValidasiApi['client_id'];
                $datetime_expired = $DataValidasiApi['datetime_expired'];

                //Apakah token Sudah Expired
                if($datetime_expired<$now){
                    $id_api_access = 0;
                    $keterangan = "Token Yang Anda Gunakan Sudah Expired";
                    $code = 401;
                    $metadata = [];
                }else{

                    //Buka Data 'api_access'
                    $api_name = getDataDetail_v2($Conn, 'api_access', 'id_api_access', $id_api_access, 'api_name');
                    $api_description = getDataDetail_v2($Conn, 'api_access', 'id_api_access', $id_api_access, 'api_description');
                    
                    // Menampilkan Data Poliklinik
                    $stmtDokter = $Conn->prepare("SELECT * FROM dokter WHERE status = 'Aktiv'");
                    $stmtDokter->execute();
                    $resultDokter = $stmtDokter->get_result();
                    $list_dokter = [];
                    $jumlah_data = $resultDokter->num_rows; // Count number of active doctors
                    while ($x = $resultDokter->fetch_assoc()) {
                        $list_dokter[] = [
                            'id_dokter' => $x["id_dokter"],
                            'id_ihs_practitioner' => $x["id_ihs_practitioner"],
                            'kode' => $x["kode"],
                            'nama' => $x["nama"],
                            'kategori' => $x["kategori"],
                            'kategori_identitas' => $x["kategori_identitas"],
                            'no_identitas' => $x["no_identitas"],
                            'alamat' => $x["alamat"],
                            'kontak' => $x["kontak"],
                            'email' => $x["email"],
                            'SIP' => $x["SIP"],
                            'status' => $x["status"],
                            'foto' => $x["foto"],
                        ];
                    }
                    
                    $keterangan = "success";
                    $code = 200;
                    $metadata = [
                        "jumlah_data" => $jumlah_data,
                        "list_dokter" => $list_dokter
                    ];
                }
            }
        }
    }
    
    // Log API Request
    $EntryLog = "INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) 
                VALUES (?, ?, ?, ?, ?)";
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

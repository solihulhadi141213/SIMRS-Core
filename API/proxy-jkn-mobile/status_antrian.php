<?php
    ob_start();
    // Set timezone dan header JSON
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Include konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";

    // Nama layanan dan waktu saat ini
    $now = date('Y-m-d H:i:s');
    $service_name = "Status Antrian";

    // Inisialisasi variabel respon
    $message = "";
    $code = 200;
    $response = [];

    // Validasi metode permintaan
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $message = "Method not allowed";
        $code = 405;
    } else {
        // Ambil client_id dan client_key dari header
        $headers = getallheaders();
        $client_id = isset($headers['client_id']) ? validateAndSanitizeInput($headers['client_id']) : null;
        $client_key = isset($headers['client_key']) ? validateAndSanitizeInput($headers['client_key']) : null;

        // Validasi credential
        if (empty($client_id)) {
            $message = "Client ID is required";
            $code = 400;
        } else {
            if (empty($client_key)) {
                $message = "Client Key is required";
                $code = 400;
            } else {
                // Validasi credential di database
                $stmt = $Conn->prepare("SELECT id_api_access FROM api_access WHERE client_id = ? AND client_key = ?");
                $stmt->bind_param("ss", $client_id, $client_key);
                $stmt->execute();
                $result = $stmt->get_result();
                $DataValidasiApi = $result->fetch_assoc();

                if (!$DataValidasiApi) {
                    $message = "Invalid Credential";
                    $code = 401;
                } else {
                    $id_api_access = $DataValidasiApi['id_api_access'];
                    
                    // Jika Valid Ambil data dari body permintaan
                    $raw = file_get_contents('php://input');
                    $data = json_decode($raw, true);

                    if (empty($data['kodepoli']) || empty($data['kodedokter'])|| empty($data['tanggalperiksa'])|| empty($data['jampraktek'])) {
                        $message = "Parameter yang dikirim harus lengkap (kodepoli, kodedokter, tanggalperiksa, jampraktek)";
                        $code = 400;
                    } else {
                        //Tangkap Data Dan Buat Dalam Bentuk Variabel
                        $kodepoli = validateAndSanitizeInput($data['kodepoli']);
                        $kodedokter = validateAndSanitizeInput($data['kodedokter']);
                        $tanggalperiksa = validateAndSanitizeInput($data['tanggalperiksa']);
                        $jampraktek = validateAndSanitizeInput($data['jampraktek']);
                        
                        //Ubah Tanggal Periksa Menjadi hari
                        $hari=NamaHariJadwal($tanggalperiksa);
                        
                        //Buka Dokter
                        $id_dokter=getDataDetail_v2($Conn, 'dokter', 'kode', $kodedokter, 'id_dokter');
                        $namadokter=getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');
                        
                        //Buka Poliklinik
                        $id_poliklinik=getDataDetail_v2($Conn, 'poliklinik', 'kode', $kodepoli, 'id_poliklinik');
                        $namapoli=getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'nama');
                        
                        //Buka Jadwal
                        $query = "SELECT * FROM jadwal_dokter WHERE hari = ? AND id_dokter = ? AND id_poliklinik = ? AND jam = ?";
                        $stmt_jadwal = $Conn->prepare($query);
                        $stmt_jadwal->bind_param("ssss", $hari, $id_dokter, $id_poliklinik, $jampraktek);
                        $stmt_jadwal->execute();
                        $result_jadwal = $stmt_jadwal->get_result();
                        if (!$result_jadwal) {
                            $message = "Error fetching schedule data: " . $Conn->error;
                            $code = 500;
                        }else{
                            //Apabila Data Tidak Ditemukan
                            if ($result_jadwal->num_rows === 0) {
                                $message = "Tidak ada data jadwal ditemukan";
                                $code = 500;
                            } else {
                                $data_jadwal = $result_jadwal->fetch_assoc();
                                //Kuota jkn dan kuota non jkn dari database
                                $kuotajkn=$data_jadwal['kuota_jkn'];
                                $kuotanonjkn=$data_jadwal['kuota_non_jkn'];

                                //Mencari Data Antrian Yang sedang dipanggil
                                $QryAntrian = mysqli_query($Conn, "SELECT * FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kodepoli='$kodepoli' AND kode_dokter='$kodedokter' AND status='Tunggu Poli'") or die(mysqli_error($Conn));
                                if ($QryAntrian && mysqli_num_rows($QryAntrian) > 0) {
                                    $DataAntrian = mysqli_fetch_array($QryAntrian);
                                    $id_antrian = isset($DataAntrian['id_antrian']) ? $DataAntrian['id_antrian'] : null;
                                    $no_antrian = isset($DataAntrian['no_antrian']) ? $DataAntrian['no_antrian'] : null;
                                } else {
                                    $id_antrian="";
                                    $no_antrian="";
                                }
                                
                                //Jumlah antran
                                $queryJumlahAntrian = "SELECT id_antrian FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kodepoli='$kodepoli'";
                                $resultJumlahAntrian = mysqli_query($Conn, $queryJumlahAntrian);
                                // Periksa apakah query berhasil
                                if ($resultJumlahAntrian) {
                                    $JumlahAntrian = mysqli_num_rows($resultJumlahAntrian);
                                    // Validasi nilai $no_antrian, $kuotanonjkn, dan $kuotajkn
                                    $no_antrian = isset($no_antrian) ? (int)$no_antrian : 0;
                                    $kuotanonjkn = isset($kuotanonjkn) ? (int)$kuotanonjkn : 0;
                                    $kuotajkn = isset($kuotajkn) ? (int)$kuotajkn : 0;
                                    // Hitung sisa antrian dan kuota
                                    $SisaAntrian = $JumlahAntrian - $no_antrian;
                                    $sisakuotanonjkn = $kuotanonjkn - $JumlahAntrian;
                                    $sisakuotajkn = $kuotajkn - $JumlahAntrian;
                                    
                                    //Bentuk Array
                                    $response = Array (
                                        "namapoli" => "$namapoli",
                                        "namadokter" => "$namadokter",
                                        "totalantrean" => "$JumlahAntrian",
                                        "sisaantrean" => "$SisaAntrian",
                                        "antreanpanggil" => "$no_antrian",
                                        "sisakuotajkn" => "$sisakuotajkn",
                                        "kuotajkn" => "$kuotajkn",
                                        "sisakuotanonjkn" => "$sisakuotanonjkn",
                                        "kuotanonjkn" => "$kuotanonjkn",
                                        "keterangan" => "Hubungi Syamsul El-Syifa Jika Ada Masalah"
                                    );
                                    $message = "Success";
                                    $code = 200;
                                } else {
                                    // Tangani kesalahan jika query gagal
                                    $message = "Gagal menghitung jumlah antrian: " . mysqli_error($Conn);
                                    $code = 401;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Catat log permintaan
    $stmtLog = $Conn->prepare("INSERT INTO api_log (id_api_access, datetime_log, service_name, response_code, response_message) VALUES (?, ?, ?, ?, ?)");
    $stmtLog->bind_param("sssis", $id_api_access, $now, $service_name, $code, $message);
    $stmtLog->execute();

    // Siapkan respon
    $send_data = [
        "metadata" => [
            "message" => $message,
            "code" => $code
        ],
        "response" => $response
    ];

    // Kirim respon
    echo json_encode($send_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    // Tambahkan header tambahan
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    header_remove('X-Powered-By');
    exit();
?>

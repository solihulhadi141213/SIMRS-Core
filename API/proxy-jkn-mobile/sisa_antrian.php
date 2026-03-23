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

                    if (empty($data['kodebooking'])) {
                        $message = "Kode Booking Tidak Boleh Kosong!";
                        $code = 400;
                    } else {
                        //Tangkap Data Dan Buat Dalam Bentuk Variabel
                        $kodebooking = validateAndSanitizeInput($data['kodebooking']);
                        $QryKodeBooking = mysqli_query($Conn,"SELECT * FROM antrian WHERE kodebooking='$kodebooking'")or die(mysqli_error($Conn));
                        $DataBooking = mysqli_fetch_array($QryKodeBooking);
                        if(empty($DataBooking['id_antrian'])){
                            $message = "Kode Booking Tidak Ditemukan";
                            $code = 400;
                        }else{
                            $id_antrian  = $DataBooking['id_antrian'];
                            $no_antrian  = $DataBooking['no_antrian'];
                            $namapoli  = $DataBooking['namapoli'];
                            $nama_dokter  = $DataBooking['nama_dokter'];
                            $kode_dokter  = $DataBooking['kode_dokter'];
                            $tanggal_kunjungan  = $DataBooking['tanggal_kunjungan'];
                            $kodepoli  = $DataBooking['kodepoli'];
                            $SisaAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal_kunjungan' AND kodepoli='$kodepoli' AND kode_dokter='$kode_dokter' AND status='Terdaftar' AND no_antrian<'$no_antrian'"));
                            //Antrian Panggil
                            $QryAntrianPanggil = mysqli_query($Conn,"SELECT no_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal_kunjungan' AND kodepoli='$kodepoli' AND kode_dokter='$kode_dokter' AND status='Layanan Poli'")or die(mysqli_error($Conn));
                            $DataPanggilan = mysqli_fetch_array($QryAntrianPanggil);
                            $AntrianPanggil=$DataPanggilan['no_antrian'];
                            if(empty($SisaAntrian)){
                                $KaliWaktuTunggu=1;
                            }else{
                                $KaliWaktuTunggu=$SisaAntrian+1;
                            }
                            $waktutunggu=(1000*10*60)*$KaliWaktuTunggu;
                            //Bentuk Array
                            $response = Array (
                                "nomorantrean" => "$no_antrian",
                                "namapoli" => "$namapoli",
                                "namadokter" => "$nama_dokter",
                                "sisaantrean" => "$SisaAntrian",
                                "antreanpanggil" => "$AntrianPanggil",
                                "waktutunggu" => "$waktutunggu",
                                "keterangan" => "Hubungi Syamsul El-Syifa Jika Ada Masalah"
                            );
                            $message = "Success";
                            $code = 200;
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

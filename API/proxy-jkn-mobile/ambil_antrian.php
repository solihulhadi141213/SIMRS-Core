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

                    if (empty($data['nomorkartu'])||empty($data['nik'])||empty($data['nohp'])||empty($data['kodepoli'])||empty($data['norm'])||empty($data['tanggalperiksa'])||empty($data['kodedokter'])||empty($data['jampraktek'])||empty($data['jeniskunjungan'])||empty($data['nomorreferensi'])) {
                        $message = "Parameter yang dikirim harus lengkap (nomor kartu, Nik, Nomor HP, kode poli, no rm, tanggal periksa, kode dokter, jam praktek, jenis kunjungan, nomor referensi)";
                        $code = 400;
                    } else {
                        //Tangkap Data Dan Buat Dalam Bentuk Variabel
                        $nomorkartu = validateAndSanitizeInput($data['nomorkartu']);
                        $nik = validateAndSanitizeInput($data['nik']);
                        $nohp = validateAndSanitizeInput($data['nohp']);
                        $kodepoli = validateAndSanitizeInput($data['kodepoli']);
                        $norm = validateAndSanitizeInput($data['norm']);
                        $tanggalperiksa = validateAndSanitizeInput($data['tanggalperiksa']);
                        $kodedokter = validateAndSanitizeInput($data['kodedokter']);
                        $jampraktek = validateAndSanitizeInput($data['jampraktek']);
                        $jeniskunjungan = validateAndSanitizeInput($data['jeniskunjungan']);
                        $nomorreferensi = validateAndSanitizeInput($data['nomorreferensi']);
                        
                        //Validasi RM pasien
                        $id_pasien=getDataDetail_v2($Conn, 'pasien', 'id_pasien', $norm, 'id_pasien');
                        if(empty($id_pasien)){
                            $message = "Nomor RM Pasien Tidak Terdaftar";
                            $code = 202;
                        }else{
                            
                            //Apakah ID pasien tersebut sudah terdaftar di hari yang sama
                            $query_same_day = $Conn->prepare("SELECT COUNT(*) as jumlah FROM antrian WHERE id_pasien = ? AND tanggal_kunjungan = ?");
                            $query_same_day->bind_param("ss", $norm, $tanggalperiksa);
                            // Eksekusi query_same_day
                            $query_same_day->execute();
                            $result_same_day = $query_same_day->get_result();
                            $row_same_day = $result_same_day->fetch_assoc();
                            // Mengecek hasil
                            if ($row_same_day['jumlah'] > 0) {
                                $message = "Pasien sudah terdaftar di hari yang sama";
                                $code = 202;
                            } else {
                                
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
                                    //Apabila Data jadwal dokter/poliklinik Tidak Ditemukan
                                    if ($result_jadwal->num_rows === 0) {
                                        $message = "Tidak ada data jadwal ditemukan";
                                        $code = 500;
                                    } else {
                                        $data_jadwal = $result_jadwal->fetch_assoc();
                                        //Kuota jkn dan kuota non jkn dari database
                                        $kuotajkn=$data_jadwal['kuota_jkn'];
                                        $kuotanonjkn=$data_jadwal['kuota_non_jkn'];
                                        $JamPraktek=$data_jadwal['jam'];

                                        //Validasi Tanggal Pendaftaran Antrian
                                        $tanggalSekarang=date('Y-m-d');
                                        if($tanggalperiksa<=$tanggalSekarang){
                                            $message = "Tanggal antrian tidak boleh kurang dari hari sekarang";
                                            $code = 500;
                                        }else{
                                            
                                            //Validasi Tanggal Pendaftaran Maksimal 7 Hari Dari Sekarang
                                            $tgl1 = new DateTime("$tanggalSekarang");
                                            $tgl2 = new DateTime("$tanggalperiksa");
                                            $d = $tgl2->diff($tgl1)->days + 1;
                                            if($d>7){
                                                $message = "Pendaftaran online maksimal 7 hari dari sekarang";
                                                $code = 500;
                                            }else{

                                                //Cari kapan mulai prakteknya
                                                $explode = explode("-" , $JamPraktek);
                                                $AwalPraktek=$explode[0];
                                                //Ada berapa orang yang daftar untuk poli tersebut pada hari yang sama pada poli dan dokter yang sama
                                                $CekAdaBerapa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kode_dokter='$kodedokter' AND kodepoli='$kodepoli'"));
                                                //Satu layanan dihitung 10 menit
                                                $LamaLayanan=$CekAdaBerapa*10;
                                                $AwalPraktek = date('H:i:s', strtotime("+$LamaLayanan minute", strtotime($AwalPraktek)));
                                                //Ubah Tanggal Periksa menjadi milsecon
                                                date_default_timezone_set('Asia/Jakarta');
                                                $estimasi="$tanggalperiksa $AwalPraktek";
                                                $estimasi=strtotime(''.$estimasi.'');
                                                $estimasi=$estimasi*1000;
                                                $kodebooking=rand(100000,999999);
                                                $kodebooking="$estimasi$kodebooking";
                                                //Mencari nomor antrian
                                                $QueryAntrian=mysqli_query($Conn, "SELECT MAX(no_antrian) as no_antrian FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa'")or die(mysqli_error($Conn));
                                                while($DataAntrian=mysqli_fetch_array($QueryAntrian)){
                                                    $max_antrian=$DataAntrian['no_antrian'];
                                                }
                                                $no_antrian=$max_antrian+1;
                                                $JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kodepoli='$kodepoli' AND kode_dokter='$kodedokter'"));
                                                $SisaAntrian=($kuotanonjkn+$kuotajkn)-$JumlahAntrian;
                                                $sisakuotanonjkn=$kuotanonjkn-$JumlahAntrian;
                                                $sisakuotajkn=$kuotajkn-$JumlahAntrian;
                                                
                                                //Simpan Ke Database Antrian
                                                $id_kunjungan="0";
                                                $nama_pasien=getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'nama');
                                                $jenisrequest="0";
                                                $polieksekutif="0";
                                                $tanggal_daftar=date('Y-m-d H:i:s');
                                                $jam_checkin="";
                                                $kelas="None";
                                                $keluhan="None";
                                                $pembayaran="BPJS";
                                                $status="Terdaftar";
                                                $sumber_antrian="JKN Mobile";
                                                $ws_bpjs=1;
                                                $QryAntrian="INSERT INTO antrian (
                                                    id_kunjungan,
                                                    no_antrian,
                                                    kodebooking,
                                                    id_pasien,
                                                    nama_pasien,
                                                    nomorkartu,
                                                    nik,
                                                    notelp,
                                                    nomorreferensi,
                                                    jenisreferensi,
                                                    jenisrequest,
                                                    polieksekutif,
                                                    tanggal_daftar,
                                                    tanggal_kunjungan,
                                                    jam_kunjungan,
                                                    jam_checkin,
                                                    kode_dokter,
                                                    nama_dokter,
                                                    kodepoli,
                                                    namapoli,
                                                    kelas,
                                                    keluhan,
                                                    pembayaran,
                                                    no_rujukan,
                                                    status,
                                                    sumber_antrian,
                                                    ws_bpjs
                                                ) VALUES (
                                                    '$id_kunjungan',
                                                    '$no_antrian',
                                                    '$kodebooking',
                                                    '$id_pasien',
                                                    '$nama_pasien',
                                                    '$nomorkartu',
                                                    '$nik',
                                                    '$nohp',
                                                    '$nomorreferensi',
                                                    '$jeniskunjungan',
                                                    '$jenisrequest',
                                                    '$polieksekutif',
                                                    '$tanggal_daftar',
                                                    '$tanggalperiksa',
                                                    '$jampraktek',
                                                    '$jam_checkin',
                                                    '$kodedokter',
                                                    '$namadokter',
                                                    '$kodepoli',
                                                    '$namapoli',
                                                    '$kelas',
                                                    '$keluhan',
                                                    '$pembayaran',
                                                    '$nomorreferensi',
                                                    '$status',
                                                    '$sumber_antrian',
                                                    '$ws_bpjs'
                                                )";
                                                $InputAntrian=mysqli_query($Conn, $QryAntrian);
                                                if(!$InputAntrian){
                                                    $message = "Terjadi kesalahan pada saat menyimpan data antrian ke database";
                                                    $code = 500;
                                                }else{
                                                    //Bentuk Array
                                                    $response = Array (
                                                        "nomorantrean" => "A-$no_antrian",
                                                        "angkaantrean" => "$no_antrian",
                                                        "kodebooking" => "$kodebooking",
                                                        "norm" => "$id_pasien",
                                                        "namapoli" => "$namapoli",
                                                        "namadokter" => "$namadokter",
                                                        "estimasidilayani" => "$estimasi",
                                                        "sisakuotajkn" => "$sisakuotajkn",
                                                        "kuotajkn" => "$kuotajkn",
                                                        "sisakuotanonjkn" => "$sisakuotanonjkn",
                                                        "kuotanonjkn" => "$kuotanonjkn",
                                                        "keterangan" => "Peserta harap 60 menit lebih awal guna pencatatan administrasi."
                                                    );
                                                    $message = "Success";
                                                    $code = 200;
                                                }
                                            }
                                        }
                                    }
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

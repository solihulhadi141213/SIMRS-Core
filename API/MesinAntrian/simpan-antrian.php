<?php
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
    $service_name = "Simpan Antrian";

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

                //Validasi Data Yang Wajib Terisi
                if (empty($data['nama_pasien'])){
                    $response_message = "Nama pasien tidak boleh kosong!";
                    $code = 400;
                }else{
                    if (empty($data['tanggal_kunjungan'])){
                        $response_message = "Tanggal kunjungan tidak boleh kosong!";
                        $code = 400;
                    }else{
                        if (empty($data['jam_kunjungan'])){
                            $response_message = "Jam kunjungan tidak boleh kosong!";
                            $code = 400;
                        }else{
                            if (empty($data['id_jadwal'])){
                                $response_message = "ID jadwal tidak boleh kosong!";
                                $code = 400;
                            }else{
                                if (empty($data['keluhan'])){
                                    $response_message = "Keluhan pasien tidak boleh kosong!";
                                    $code = 400;
                                }else{
                                    if (empty($data['pembayaran'])){
                                        $response_message = "Jenis pembayaran tidak boleh kosong!";
                                        $code = 400;
                                    }else{
                                        //Buat Variabel
                                        $nama_pasien=$data['nama_pasien'];
                                        $tanggal_kunjungan=$data['tanggal_kunjungan'];
                                        $jam_kunjungan=$data['jam_kunjungan'];
                                        $id_jadwal=$data['id_jadwal'];
                                        $keluhan=$data['keluhan'];
                                        $pembayaran=$data['pembayaran'];
                                        if ($code==400){
                                            $response_message = $response_message;
                                            $code = $code;
                                        }else{
                                            //id_kunjungan kosong karena belum ditetapkan berkunjung
                                            $id_kunjungan=0;

                                            //Buat kode booking
                                            $kodebooking=rand(100000,999999);

                                            //notelp boleh kosong karena ada kemungkinan pasien belum punya HP
                                            if(empty($data['notelp'])){
                                                $notelp="";
                                            }else{
                                                $notelp=$data['notelp'];
                                            }

                                            //nomorreferensi boleh kosong karena ada kemungkinan pasien belum punya rujukan
                                            if(empty($data['nomorreferensi'])){
                                                $nomorreferensi="";
                                                $no_rujukan="";
                                            }else{
                                                $nomorreferensi=$data['nomorreferensi'];
                                                $no_rujukan=$data['nomorreferensi'];
                                            }

                                            //jenisreferensi boleh kosong karena ada kemungkinan pasien belum punya rujukan
                                            if(empty($data['jenisreferensi'])){
                                                $jenisreferensi=0;
                                            }else{
                                                $jenisreferensi=$data['jenisreferensi'];
                                            }

                                            //jenisrequest Ditentukan Apakah Pasien Memiliki id_pasien atau tidak
                                            if(empty($data['id_pasien'])){
                                                $jenisrequest=1;
                                            }else{
                                                $jenisrequest=0;
                                            }

                                            //polieksekutif secara defult 0
                                            $polieksekutif=0;

                                            //tanggal_daftar default Sekarang
                                            $tanggal_daftar=date('Y-m-d H:i:s');

                                            //jam_checkin secara default kosong
                                            $jam_checkin="";

                                            //Buka Informasi Dokter dan Poli Dari id_jadwal
                                            $id_jadwal_valid=getDataDetail_v2($Conn, 'jadwal_dokter', 'id_jadwal', $id_jadwal, 'id_jadwal');
                                            if(empty($id_jadwal_valid)){
                                                $response_message = "Jadwal $id_jadwal Tidak Valid, Atau Tidak Ditemukan Pada Database";
                                                $code = 400;
                                            }
                                            $id_dokter=getDataDetail_v2($Conn, 'jadwal_dokter', 'id_jadwal', $id_jadwal, 'id_dokter');
                                            $id_poliklinik=getDataDetail_v2($Conn, 'jadwal_dokter', 'id_jadwal', $id_jadwal, 'id_poliklinik');
                                            $kode_dokter=getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'kode');
                                            $nama_dokter=getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');
                                            $kodepoli=getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'kode');
                                            $namapoli=getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'nama');

                                            //id_pasien boleh kosong karena ada kemungkinan pasien belum punya RM
                                            if(empty($data['id_pasien'])){
                                                $id_pasien=0;
                                                $validasi_duplikat_by_id_pasien =0;
                                            }else{
                                                $id_pasien=$data['id_pasien'];
                                                // Query untuk validasi duplikasi
                                                $query = "SELECT COUNT(*) AS jumlah FROM antrian WHERE tanggal_kunjungan = ? AND id_pasien = ? AND namapoli = ? AND nama_dokter = ?";
                                                $stmt = $Conn->prepare($query);

                                                // Bind parameter
                                                $stmt->bind_param("ssss", $tanggal_kunjungan, $id_pasien, $namapoli, $nama_dokter);

                                                // Eksekusi query
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                // Ambil jumlah baris yang cocok
                                                $row = $result->fetch_assoc();
                                                $validasi_duplikat_by_id_pasien = $row['jumlah'];
                                            }
                                            if(!empty($validasi_duplikat_by_id_pasien)){
                                                $response_message = "No RM Tersebut Sudah Terdaftar Di Hari Yang Sama";
                                                $code = 400;
                                            }

                                            //nik boleh kosong karena ada kemungkinan pasien belum punya kartu KTP
                                            if(empty($data['nik'])){
                                                $nik="";
                                                $validasi_duplikat_by_nik=0;
                                            }else{
                                                $nik=$data['nik'];
                                                // Query untuk validasi duplikasi
                                                $query_nik = "SELECT COUNT(*) AS jumlah FROM antrian WHERE tanggal_kunjungan = ? AND nik = ? AND namapoli = ? AND nama_dokter = ?";
                                                $stmt_nik = $Conn->prepare($query_nik);
                                                // Bind parameter
                                                $stmt_nik->bind_param("ssss", $tanggal_kunjungan, $nik, $namapoli, $nama_dokter);
                                                // Eksekusi query
                                                $stmt_nik->execute();
                                                $result_nik = $stmt_nik->get_result();
                                                // Ambil jumlah baris yang cocok
                                                $row_nik = $result_nik->fetch_assoc();
                                                $validasi_duplikat_by_nik = $row_nik['jumlah'];
                                            }
                                            if(!empty($validasi_duplikat_by_nik)){
                                                $response_message = "NIK Tersebut Sudah Terdaftar Di Hari Yang Sama";
                                                $code = 400;
                                            }

                                            //nomorkartu boleh kosong karena ada kemungkinan pasien belum punya kartu BPJS
                                            if(empty($data['nomorkartu'])){
                                                $nomorkartu="";
                                                $validasi_duplikat_by_nokartu=0;
                                            }else{
                                                $nomorkartu=$data['nomorkartu'];
                                                // Query untuk validasi duplikasi
                                                $query_noka = "SELECT COUNT(*) AS jumlah FROM antrian WHERE tanggal_kunjungan = ? AND nomorkartu = ? AND namapoli = ? AND nama_dokter = ?";
                                                $stmt_noka = $Conn->prepare($query_noka);
                                                // Bind parameter
                                                $stmt_noka->bind_param("ssss", $tanggal_kunjungan, $nomorkartu, $namapoli, $nama_dokter);
                                                // Eksekusi query
                                                $stmt_noka->execute();
                                                $result_noka = $stmt_noka->get_result();
                                                // Ambil jumlah baris yang cocok
                                                $row_noka = $result_noka->fetch_assoc();
                                                $validasi_duplikat_by_nokartu = $row_noka['jumlah'];
                                            }
                                            if(!empty($validasi_duplikat_by_nokartu)){
                                                $response_message = "Nomor Kartu Tersebut Sudah Terdaftar Di Hari Yang Sama";
                                                $code = 400;
                                            }

                                            //kelas secara defaukt kosong
                                            $kelas="";

                                            //Status Secara Default Terdaftar
                                            $status="Terdaftar";

                                            //sumber_antrian secara default 
                                            $sumber_antrian="Mesin Antrian";

                                            //Tidak Melakukan Update Ke WS BPJS
                                            $ws_bpjs=0;

                                            //Membuat Nomor Antrian
                                            // Query untuk mencari nomor antrian terbesar
                                            $stmt_no_antrian = $Conn->prepare("
                                                SELECT MAX(no_antrian) AS max_nomor_antrian 
                                                FROM Antrian 
                                                WHERE 
                                                    tanggal_kunjungan = ? 
                                                    AND jam_kunjungan = ? 
                                                    AND kode_dokter = ? 
                                                    AND kodepoli = ?
                                            ");

                                            // Bind parameter
                                            $stmt_no_antrian->bind_param("ssss", $tanggal_kunjungan, $jam_kunjungan, $kode_dokter, $kodepoli);

                                            // Eksekusi query
                                            $stmt_no_antrian->execute();
                                            $result_no_antrian = $stmt_no_antrian->get_result();
                                            $row = $result_no_antrian->fetch_assoc();

                                            // Ambil nomor antrian terbesar dan tambahkan 1
                                            $max_nomor_antrian = $row['max_nomor_antrian'] ?? 0;
                                            $next_nomor_antrian = $max_nomor_antrian + 1;

                                            //Jika Tidak Ada Masalah Dalam Validasi Data
                                            if($code==200){
                                                //Simpan Data Antrian
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
                                                    '$next_nomor_antrian',
                                                    '$kodebooking',
                                                    '$id_pasien',
                                                    '$nama_pasien',
                                                    '$nomorkartu',
                                                    '$nik',
                                                    '$notelp',
                                                    '$nomorreferensi',
                                                    '$jenisreferensi',
                                                    '$jenisrequest',
                                                    '$polieksekutif',
                                                    '$tanggal_daftar',
                                                    '$tanggal_kunjungan',
                                                    '$jam_kunjungan',
                                                    '$jam_checkin',
                                                    '$kode_dokter',
                                                    '$nama_dokter',
                                                    '$kodepoli',
                                                    '$namapoli',
                                                    '$kelas',
                                                    '$keluhan',
                                                    '$pembayaran',
                                                    '$no_rujukan',
                                                    '$status',
                                                    '$sumber_antrian',
                                                    '$ws_bpjs'
                                                )";
                                                $InputAntrian=mysqli_query($Conn, $QryAntrian);
                                                if($InputAntrian){
                                                    $response_message = "Success";
                                                    $code = 200;
                                                    $metadata = [
                                                        "id_kunjungan" => $id_kunjungan,
                                                        "no_antrian" => $next_nomor_antrian,
                                                        "kodebooking" => $kodebooking,
                                                        "id_pasien" => $id_pasien,
                                                        "nama_pasien" => $nama_pasien,
                                                        "nomorkartu" => $nomorkartu,
                                                        "nik" => $nik,
                                                        "notelp" => $notelp,
                                                        "nomorreferensi" => $nomorreferensi,
                                                        "jenisreferensi" => $jenisreferensi,
                                                        "jenisrequest" => $jenisrequest,
                                                        "polieksekutif" => $polieksekutif,
                                                        "tanggal_daftar" => $tanggal_daftar,
                                                        "tanggal_kunjungan" => $tanggal_kunjungan,
                                                        "jam_kunjungan" => $jam_kunjungan,
                                                        "jam_checkin" => $jam_checkin,
                                                        "kode_dokter" => $kode_dokter,
                                                        "nama_dokter" => $nama_dokter,
                                                        "kodepoli" => $kodepoli,
                                                        "namapoli" => $namapoli,
                                                        "kelas" => $kelas,
                                                        "keluhan" => $keluhan,
                                                        "pembayaran" => $pembayaran,
                                                        "no_rujukan" => $no_rujukan,
                                                        "status" => $status,
                                                        "sumber_antrian" => $sumber_antrian,
                                                        "ws_bpjs" => $ws_bpjs
                                                    ];
                                                }else{
                                                    $response_message = "Terjadi kesalahan pada saat menyimpan data antrian!$jam_kunjungan";
                                                    $code = 400;
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
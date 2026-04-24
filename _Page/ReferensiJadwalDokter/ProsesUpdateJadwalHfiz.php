<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/HelperBridging.php";
    include "../../_Config/Session.php";

    //Fungsi Autoload
    include "../../vendor/autoload.php";

    // Default Response
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // Validasi Sesi Akses
     if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // Validasi Data Dari Form
    if(empty($_POST['id_dokter'])){
        $response['message'] = 'Silahkan Pilih Dokter Terlebih Dulu!';
        echo json_encode($response);
        exit;
    }
    if(empty($_POST['id_poliklinik'])){
        $response['message'] = 'Silahkan Pilih Poliklinik Terlebih Dulu!';
        echo json_encode($response);
        exit;
    }
           
    //Buat Variabel Dan Sanitasi
    $id_poliklinik = validateAndSanitizeInput($_POST['id_poliklinik']);
    $id_dokter     = validateAndSanitizeInput($_POST['id_dokter']);

    // Hitung Jumlah Data
    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_jadwal FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'"));
    
    //Jika Data Tidak Ada
    if(empty($JumlahData)){
        $response['message'] = 'Tidak Ada Jadwal Untuk Dikirim!';
        echo json_encode($response);
        exit;
    }

    // Buka Kode Dokter Dan Kode Poli
    $kode_poliklinik = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'kode');
    $kode_dokter     = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'kode');

    if(empty($kode_poliklinik)){
        $response['message'] = 'Poliklinik Yang Anda Pilih Tidak Memiliki Kode! Silahkan Kelola Referensi Poliklinik Dengan Benar Terlebih Dulu';
        echo json_encode($response);
        exit;
    }

    if(empty($kode_dokter)){
        $response['message'] = 'Dokter Yang Anda Pilih Tidak Memiliki Kode! Silahkan Kelola Referensi Dokter Dengan Benar Terlebih Dulu';
        echo json_encode($response);
        exit;
    }
            
    // Membuat Payload Jadwal Dokter
    $QryJadwalDokter = "SELECT * FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'";
    $DataJadwalDokter  =mysqli_query($Conn, $QryJadwalDokter);
    $jadwal = array();
    $jadwal['jadwal'] = array();
    while($x = mysqli_fetch_array($DataJadwalDokter)){
        //Buat variabel
        $NamaHari= $x['hari'];
        if($NamaHari=="Senin"){
            $KodeHari="1";
        }else{
            if($NamaHari=="Selasa"){
                $KodeHari="2";
            }else{
                if($NamaHari=="Rabu"){
                    $KodeHari="3";
                }else{
                    if($NamaHari=="Kamis"){
                        $KodeHari="4";
                    }else{
                        if($NamaHari=="Jumat"){
                            $KodeHari="5";
                        }else{
                            if($NamaHari=="Sabtu"){
                                $KodeHari="6";
                            }else{
                                if($NamaHari=="Minggu"){
                                    $KodeHari="7";
                                }
                            }
                        }
                    }
                }
            }
        }
        
        $JamMulai   = date('H:i',strtotime($x['jam_mulai']));
        $JamSelesai = date('H:i',strtotime($x['jam_selesai']));

        // Format jam

        //Buat array
        $h['hari']  = $KodeHari;
        $h['buka']  = $JamMulai;
        $h['tutup'] = $JamSelesai;
        array_push($jadwal['jadwal'], $h);
    }

    // Buka Pengaturan Bridging BPJS Yang Aktif
    $stmt = mysqli_prepare($Conn,"SELECT * FROM setting_bpjs WHERE status = 1 ORDER BY id_setting_bpjs DESC LIMIT 1");
    if (!$stmt) {
        $response['message'] = 'Terjadi kesalahan pada saat membuka pengaturan koneksi bridging BPJS!';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (empty($setting)) {
        $response['message'] = 'Pengaturan Koneksi Bridging BPJS Tidak Ditemukan!<br> Atur pengaturan koneksi brdiging BPJS terlebih dulu.';
        echo json_encode($response);
        exit;
    }

    // Buat Variabelnya
    $consid          = trim($setting['consid'] ?? '');
    $user_key        = trim($setting['user_key'] ?? '');
    $user_key_antrol = trim($setting['user_key_antrol'] ?? '');
    $secret_key      = trim($setting['secret_key'] ?? '');
    $kode_ppk        = trim($setting['kode_ppk'] ?? '');
    $url_vclaim      = rtrim(trim($setting['url_vclaim'] ?? ''), '/');
    $url_antrol      = $setting['url_antrol'];

    //Time zone
    date_default_timezone_set('UTC');
    $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

    //Creat Signature
    $signature = hash_hmac('sha256', $consid."&".$tStamp, $secret_key, true);
    $encodedSignature = base64_encode($signature);
    $urlencodedSignature = urlencode($encodedSignature);

    // Creat Key
    $key="$consid$secret_key$tStamp";

    //Membuat header
    $headers = array(
        'Content-Type:Application/x-www-form-urlencoded',
        'X-cons-id: '.$consid .'',
        'X-timestamp: '.$tStamp.'' ,
        'X-signature: '.$encodedSignature.'',
        'user_key: '.$user_key_antrol.''
    ); 

    // Build Payload
    $arr = array(
        "kodepoli"         => "$kode_poliklinik",
        "kodesubspesialis" => "$kode_poliklinik",
        "kodedokter"       => $kode_dokter,
        "jadwal"           => $jadwal['jadwal']
    );
    $json = json_encode($arr);

    //Membuat URL
    $url="$url_antrol/jadwaldokter/updatejadwaldokter";

    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $err      = curl_error($ch);
    curl_close($ch);

    // Build Response Variabel
    $response_json = json_decode($response, true);
    $code       = $response_json["metadata"]["code"];
    $message    = $response_json["metadata"]["message"];
    if($code!=="200"){
        $response = [
            'status' => 'error',
            'message' => 'Response : <pre>Update Jadwal Ke HFIZ Gagal</pre> <br>Message : <pre>'.$message.'</pre> <br>RAW RESPONSE <pre>'.$response.'</pre> <br>RAW SEND <pre>'.$json.'</pre>'
        ];
        echo json_encode($response);
        exit;
    }

    // Jika Berhasil
    $response = [
        'status' => 'success',
        'message' => 'Update Jadwal Berhasil!'
    ];
    echo json_encode($response);
    exit;
?>
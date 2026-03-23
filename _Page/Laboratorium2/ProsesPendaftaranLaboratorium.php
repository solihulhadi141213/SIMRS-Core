<?php
    // Dalam penulisan komentar tidak diperkenankan menggunakan garis, komentar di tulis singakt, jelas dan relevan dengan konteks
    
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiLaboratorium.php";
    
    // Validasi Akses
    if(empty($_SESSION['id_akses'])){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</div>';
        exit;
    }

    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_POST['id_pasien'])){
        echo '<div class="alert alert-danger">ID Pasien Tidak Boleh Kosong!</div>';
        exit;
    }
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['nama'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['priority'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['gender'])){
        echo '<div class="alert alert-danger">Gender Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['dokter_pengirim'])){
        echo '<div class="alert alert-danger">Dokter Pengirim Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['tanggal_lahir'])){
         echo '<div class="alert alert-danger">Tanggal Lahir Pasien Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['pembayaran'])){
        echo '<div class="alert alert-danger">Metode Pembayaran Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['tanggal'])){
        echo '<div class="alert alert-danger">Tanggal Permintaan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['tujuan'])){
        echo '<div class="alert alert-danger">Tujuan Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['jam'])){
        echo '<div class="alert alert-danger">Jam Permintaan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['fakses'])){
        echo '<div class="alert alert-danger">Faskes Pengirim Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['unit'])){
        echo '<div class="alert alert-danger">Unit/Instalasi Pengirim Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['diagnosis'])){
        echo '<div class="alert alert-danger">Diagnosis Awal Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['id_referensi_pemeriksaan'])){
        echo '<div class="alert alert-danger">Parameter Pemeriksaan Tidak Boleh Kosong!</div>';
        exit;
    }
    
    // Buat Variabel Masing-masing data yang ditangkap
    $id_akses                 = $_SESSION['id_akses'];
    $id_pasien                = $_POST['id_pasien'];
    $id_kunjungan             = $_POST['id_kunjungan'];
    $nama                     = $_POST['nama'];
    $priority                 = $_POST['priority'];
    $gender                   = $_POST['gender'];
    $dokter_pengirim          = $_POST['dokter_pengirim'];
    $tanggal_lahir            = $_POST['tanggal_lahir'];
    $pembayaran               = $_POST['pembayaran'];
    $tanggal                  = $_POST['tanggal'];
    $jam                      = $_POST['jam'];
    $tujuan                   = $_POST['tujuan'];
    $fakses                   = $_POST['fakses'];
    $unit                     = $_POST['unit'];
    $diagnosis                = $_POST['diagnosis'];
    $id_referensi_pemeriksaan = $_POST['id_referensi_pemeriksaan'];
    $ihs_pasien               = $_POST['ihs_pasien'] ?? "";
    $id_encounter             = $_POST['id_encounter'] ?? "";
    $keterangan               = $_POST['keterangan'] ?? "";

    // Data Dokter
    $kode_dokter_pengirim = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'kode') ?? "";
    $ihs_dokter_pengirim  = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'id_ihs_practitioner') ?? "";
    $nama_dokter_pengirim = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'nama') ?? "";

    $referensi_pemeriksaan = [];
    foreach ($id_referensi_pemeriksaan as $list_pemeriksaan){
        $pecah                    = explode('|', $list_pemeriksaan);
        $id_referensi_pemeriksaan = $pecah[0];
        $nama_pemeriksaan         = $pecah[1];
        $category_pemeriksaan     = $pecah[2];

        $referensi_pemeriksaan[] = [
            'id_referensi_pemeriksaan' => $id_referensi_pemeriksaan,
            'nama_pemeriksaan'         => $nama_pemeriksaan,
            'category_pemeriksaan'     => $category_pemeriksaan
        ];
    }

    // Pecah Diagnosis
    $pecah_diagnosis = explode('|', $diagnosis);

    // Validasi Format Diagnosis
    if(empty($pecah_diagnosis[0])||empty($pecah_diagnosis[1])){
        echo '<div class="alert alert-danger">Format Penulisan Diagnosis Tidak Valid!</div>';
        exit;
    }
    $kode_diagnosis = $pecah_diagnosis[0];
    $nama_diagnosis = $pecah_diagnosis[1];
    $kode_petugas = "";
    $nama_petugas = "";
    $ihs_petugas = "";
    $system_diagnosis = "http://hl7.org/fhir/sid/icd-10";
    
    // Build Payload Utama
    $payload = [
        "id_pasien"             => $id_pasien,
        "id_kunjungan"          => $id_kunjungan,
        "ihs_pasien"            => $ihs_pasien,
        "id_encounter"          => $id_encounter,
        "nama"                  => $nama,
        "gender"                => $gender,
        "tanggal_lahir"         => $tanggal_lahir,
        "tujuan"                => $tujuan,
        "pembayaran"            => $pembayaran,
        "fakses"                => $fakses,
        "unit"                  => $unit,
        "priority"              => $priority,
        "kode_dokter_pengirim"  => $kode_dokter_pengirim,
        "ihs_dokter_pengirim"   => $ihs_dokter_pengirim,
        "nama_dokter_pengirim"  => $nama_dokter_pengirim,
        "kode_petugas"          => $kode_petugas,
        "ihs_petugas"           => $ihs_petugas,
        "nama_petugas"          => $nama_petugas,
        "nama_diagnosis"        => $nama_diagnosis,
        "kode_diagnosis"        => $kode_diagnosis,
        "system_diagnosis"      => $system_diagnosis,
        "keterangan"            => $keterangan,
        "referensi_pemeriksaan" => $referensi_pemeriksaan
    ];

    $payload_json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Token API
    $tokenData = getAnalyzaToken($Conn);
    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger">Token Error: '.$tokenData['message'].'</div>';
        exit;
    }

    // CURL API
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $tokenData['base_url'].'/_API/KirimPermintaan.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload_json,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer '.$tokenData['token'],
            'Content-Type: application/json'
        ]
    ]);
    $response = curl_exec($curl);
    $errorCurl = curl_error($curl);
    curl_close($curl);

    // Debug CURL error
    if($errorCurl){
        echo '<div class="alert alert-danger">CURL Error: '.$errorCurl.'</div>';
        exit;
    }
    $response_arry = json_decode($response, true);

    // Debug API response format
    if(empty($response_arry)){
        echo '<div class="alert alert-danger">Response API tidak valid:<pre>'.$response.'</pre></div>';
        exit;
    }

    if($response_arry['status'] === "success"){

        $id_laboratorium = $response_arry['data']['id_laboratorium'] ?? null;

        if(empty($id_laboratorium)){
            echo '<div class="alert alert-danger">
                API Success tetapi ID Lab kosong
                <pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre>
            </div>';
            exit;
        }

        $permintaan_laboratorium = $response_arry['data']['permintaan_laboratorium'];
        

        echo '
            <div class="alert alert-success">
                Data <i id="InsertNotif">Berhasil</i> Disimpan
            </div>
        ';
        exit;

    } else {

        echo '<div class="alert alert-danger">
            API Gagal:<br>
            <pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre><br>
            Payload Dikirim:<pre>'.$payload_json.'</pre>
        </div>';
        exit;
    }

    
?>
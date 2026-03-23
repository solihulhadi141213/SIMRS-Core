<?php
    // Dalam penulisan komentar tidak diperkenankan menggunakan garis, komentar di tulis singakt, jelas dan relevan dengan konteks
    
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiRadiologi.php";
    
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
    if(empty($_POST['asal_kiriman'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['dokter_pengirim'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['permintaan_pemeriksaan_value'])){
         echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['jenis_pembayaran'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['alat_pemeriksa'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['tujuan_kunjungan'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['klinis'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['klinis_value'])){
        echo '<div class="alert alert-danger">ID Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    
    // Buat Variabel Masing-masing data yang ditangkap
    // Assign Data
    $id_akses                     = $_SESSION['id_akses'];
    $id_pasien                    = $_POST['id_pasien'];
    $id_kunjungan                 = $_POST['id_kunjungan'];
    $nama                         = $_POST['nama'];
    $priority                     = $_POST['priority'];
    $tanggal                      = date('Y-m-d H:i');
    $asal_kiriman                 = $_POST['asal_kiriman'];
    $dokter_pengirim              = $_POST['dokter_pengirim'];
    $permintaan_pemeriksaan_value = $_POST['permintaan_pemeriksaan_value'];
    $jenis_pembayaran             = $_POST['jenis_pembayaran'];
    $alat_pemeriksa               = $_POST['alat_pemeriksa'];
    $tujuan_kunjungan             = $_POST['tujuan_kunjungan'];
    $klinis_value                 = $_POST['klinis_value'];
    $keterangan                   = $_POST['keterangan'] ?? "";

    // Data Dokter
    $kode_dokter_pengirim = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'kode') ?? "";
    $ihs_dokter_pengirim  = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'id_ihs_practitioner') ?? "";
    $nama_dokter_pengirim = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'nama') ?? "";

    // Decode JSON Klinis
    $klinis_arry = json_decode($klinis_value, true);
    if(json_last_error() !== JSON_ERROR_NONE){
        echo '<div class="alert alert-danger">JSON Klinis Tidak Valid: '.json_last_error_msg().'<br><pre>'.$klinis_value.'</pre></div>';
        exit;
    }

    // Decode JSON Pemeriksaan
    $permintaan_array = json_decode($permintaan_pemeriksaan_value, true);
    if(json_last_error() !== JSON_ERROR_NONE){
        echo '<div class="alert alert-danger">JSON Pemeriksaan Tidak Valid: '.json_last_error_msg().'<br><pre>'.$permintaan_pemeriksaan_value.'</pre></div>';
        exit;
    }

    // Validasi struktur JSON Klinis
    $requiredKlinis = ['id_master_klinis','nama_klinis','snomed_code','snomed_display','kategori'];
    foreach($requiredKlinis as $field){
        if(!isset($klinis_arry[$field])){
            echo '<div class="alert alert-danger">Struktur Klinis Tidak Sesuai. Field hilang: '.$field.'<pre>'.json_encode($klinis_arry, JSON_PRETTY_PRINT).'</pre></div>';
            exit;
        }
    }

    // Validasi struktur Pemeriksaan
    $requiredPemeriksaan = ['id_master_pemeriksaan','nama_pemeriksaan','modalitas','pemeriksaan_code'];
    foreach($requiredPemeriksaan as $field){
        if(!isset($permintaan_array[$field])){
            echo '<div class="alert alert-danger">Struktur Pemeriksaan Tidak Sesuai. Field hilang: '.$field.'<pre>'.json_encode($permintaan_array, JSON_PRETTY_PRINT).'</pre></div>';
            exit;
        }
    }

    // Build Payload Klinis
    $klinis_payload = [
        [
            "kategori"         => $klinis_arry['kategori'],
            "id_klinis"        => $klinis_arry['id_master_klinis'],
            "nama_klinis"      => $klinis_arry['nama_klinis'],
            "snomed_code"      => $klinis_arry['snomed_code'],
            "snomed_display"   => $klinis_arry['snomed_display'],
            "id_master_klinis" => $klinis_arry['id_master_klinis']
        ]
    ];

    // Build Payload Pemeriksaan
    $permintaan_payload = [
        [
            "modalitas"               => $permintaan_array['modalitas'],
            "bodysite_sys"            => $permintaan_array['bodysite_sys'] ?? "",
            "bodysite_code"           => $permintaan_array['bodysite_code'] ?? "",
            "pemeriksaan_sys"         => $permintaan_array['pemeriksaan_sys'] ?? "",
            "nama_pemeriksaan"        => $permintaan_array['nama_pemeriksaan'],
            "pemeriksaan_code"        => $permintaan_array['pemeriksaan_code'],
            "bodysite_description"    => $permintaan_array['bodysite_description'] ?? "",
            "id_master_pemeriksaan"   => $permintaan_array['id_master_pemeriksaan'],
            "pemeriksaan_description" => $permintaan_array['pemeriksaan_description'] ?? ""
        ]
    ];

    // Build Payload Utama
    $payload = [
        "id_pasien"              => $id_pasien,
        "id_kunjungan"           => $id_kunjungan,
        "nama_pasien"            => $nama,
        "priority"               => $priority,
        "asal_kiriman"           => $asal_kiriman,
        "alat_pemeriksa"         => $alat_pemeriksa,
        "kode_dokter_pengirim"   => $kode_dokter_pengirim,
        "ihs_dokter_pengirim"    => $ihs_dokter_pengirim,
        "nama_dokter_pengirim"   => $nama_dokter_pengirim,
        "pesan"                  => $keterangan,
        "klinis"                 => $klinis_payload,
        "permintaan_pemeriksaan" => $permintaan_payload,
        "tujuan"                 => $tujuan_kunjungan,
        "pembayaran"             => $jenis_pembayaran
    ];

    $payload_json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Token API
    $tokenData = getRadixToken($Conn);
    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger">Token Error: '.$tokenData['message'].'</div>';
        exit;
    }

    // CURL API
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $tokenData['base_url'].'/_API/SendOrder',
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

        $id_radiologi = $response_arry['data']['id_radiologi'] ?? null;

        if(empty($id_radiologi)){
            echo '<div class="alert alert-danger">
                API Success tetapi ID Radiologi kosong
                <pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre>
            </div>';
            exit;
        }

        $klinis_nama = $klinis_arry['nama_klinis'];
        $nama_pemeriksaan_db = $permintaan_array['nama_pemeriksaan'];

        // Prepared Statement Insert
        $stmt = $Conn->prepare("
            INSERT INTO radiologi (
                id_pasien,
                id_kunjungan,
                id_akses,
                nama,
                waktu,
                asal_kiriman,
                permintaan_pemeriksaan,
                alat_pemeriksa,
                status_pemeriksaan,
                jenis_pembayaran,
                dokter_pengirim,
                klinis
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if(!$stmt){
            echo '<div class="alert alert-danger">
                Prepare Statement Gagal:<br>
                '.mysqli_error($Conn).'
            </div>';
            exit;
        }

        $status_pemeriksaan = "Terdaftar";

        $stmt->bind_param(
            "ssssssssssss",
            $id_pasien,
            $id_kunjungan,
            $id_akses,
            $nama,
            $tanggal,
            $asal_kiriman,
            $nama_pemeriksaan_db,
            $alat_pemeriksa,
            $status_pemeriksaan,
            $jenis_pembayaran,
            $dokter_pengirim,
            $klinis_nama
        );

        $execute = $stmt->execute();

        if(!$execute){
            echo '<div class="alert alert-danger">
                Insert DB Gagal:<br>
                <b>Error:</b> '.$stmt->error.'<br>
            </div>';
            exit;
        }

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
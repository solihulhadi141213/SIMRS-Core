<?php
     /* Header JSON */
    header('Content-Type: application/json');

    /* Koneksi Database */
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiLaboratorium.php";

    // Validasi Sesi Akses
    if(empty($_SESSION['id_akses'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi Akses Sudah Berakhir! Silahkan Login Ulang!'
        ]);
        exit;
    }
    
    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_POST['id_laboratorium'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Laboratorium Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['id_pasien'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Pasien Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['id_kunjungan'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Kunjungan Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['nama'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama Pasien Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['priority'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Informasi priority Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['gender'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gender Pasien Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['dokter_pengirim'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Dokter Pengirim Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['tanggal_lahir'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Tanggal Lahir Pasien Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['pembayaran'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode Pembayaran Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['tujuan'])){
        echo '<div class="alert alert-danger">Tujuan Kunjungan Tidak Boleh Kosong</div>';
        exit;
    }
    if(empty($_POST['tanggal'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Tanggal Permintaan Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['jam'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Jam Permintaan Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['fakses'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Faskes Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['unit'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Unit / Instalasi Tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['diagnosis'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Informasi Diagnosis Tidak Boleh Kosong!'
        ]);
        exit;
    }
    
    // Buat Variabel Masing-masing data yang ditangkap
    $id_laboratorium          = $_POST['id_laboratorium'];
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
    $ihs_pasien               = $_POST['ihs_pasien'] ?? "";
    $id_encounter             = $_POST['id_encounter'] ?? "";
    $keterangan               = $_POST['keterangan'] ?? "";

    // Data Dokter
    $kode_dokter_pengirim = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'kode') ?? "";
    $ihs_dokter_pengirim  = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'id_ihs_practitioner') ?? "";
    $nama_dokter_pengirim = getDataDetail_v2($Conn,'dokter','id_dokter',$dokter_pengirim,'nama') ?? "";

    // Pecah Diagnosis
    $pecah_diagnosis = explode('|', $diagnosis);

    // Validasi Format Diagnosis
    if(empty($pecah_diagnosis[0])||empty($pecah_diagnosis[1])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Format Diagnosis Tidak Valid!'
        ]);
        exit;
    }
    $kode_diagnosis = $pecah_diagnosis[0];
    $nama_diagnosis = $pecah_diagnosis[1];
    $system_diagnosis = "http://hl7.org/fhir/sid/icd-10";

    // Petugas
    $kode_petugas = $_POST['kode_petugas'] ?? "";
    $nama_petugas = $_POST['nama_petugas'] ?? "";
    $ihs_petugas  = $_POST['ihs_petugas'] ?? "";
    
    // Build Payload
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
        "keterangan"            => $keterangan
    ];

    $payload_json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Token API
    $tokenData = getAnalyzaToken($Conn);
    if ($tokenData['status'] !== 'success') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Token Error: '.$tokenData['message'].''
        ]);
        exit;
    }

    // CURL API
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $tokenData['base_url'].'/_API/EditPemeriksaan.php?id='.$id_laboratorium.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
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
        echo json_encode([
            'status'  => 'error',
            'message' => 'CURL Error: '.$errorCurl.''
        ]);
        exit;
    }
    $response_arry = json_decode($response, true);

    // Debug API response format
    if(empty($response_arry)){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Response API tidak valid:<pre>'.$response.''
        ]);
        exit;
    }

    if($response_arry['status'] === "success"){
        echo json_encode([
            'status'  => 'success',
            'message' => 'Edit Permintaan Pemeriksaan Berhasi',
            'id_laboratorium' => $id_laboratorium
        ]);
        exit;
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'API Gagal:<br><pre>'.json_encode($response_arry, JSON_PRETTY_PRINT).'</pre><br>Payload Dikirim:<pre>'.$payload_json.'</pre>'
        ]);
        exit;
    }
?>
<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // inisiasi $id agar tidak error
    $id = "";
    // Ambil NIK
    $nik = trim($_POST['nik'] ?? '');
    if ($nik === '') {
        echo '<div class="alert alert-danger">Silahkan isi NIK terlebih dulu</div>';
        exit;
    }

    // Token
    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        echo '<div class="alert alert-danger">Gagal generate token</div>';
        echo '<pre class="bg bg-white text-dark">'.print_r($tokenResult, true).'</pre>';
        exit;
    }
    $token = $tokenResult['token'] ?? '';

    // Base URL
    $stmt = mysqli_prepare($Conn,"SELECT url_satusehat FROM setting_satusehat WHERE status_setting_satusehat = 1 LIMIT 1");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $baseurl = rtrim($setting['url_satusehat'] ?? '', '/');
    if ($baseurl === '') {
        echo '<div class="alert alert-danger">Endpoint SATUSEHAT belum diatur dengan benar!</div>';
        exit;
    }

    // URL Request
    $url = $baseurl.'/fhir-r4/v1/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|'.$nik;

    // CURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer '.$token,
            'Accept: application/json'
        ],
    ]);

    $response = curl_exec($curl);

    // Error CURL
    if(curl_errno($curl)){
        echo '<div class="alert alert-danger">CURL ERROR: '.curl_error($curl).'</div>';
        exit;
    }

    curl_close($curl);

    // =============================
    // DECODE JSON
    // =============================
    $data = json_decode($response, true);

    if(json_last_error() !== JSON_ERROR_NONE){
        echo '<div class="alert alert-danger">Response bukan JSON valid</div>';
        echo '<pre class="bg bg-white text-dark">'.$response.'</pre>';
        exit;
    }

    // =============================
    // HANDLE ERROR FHIR
    // =============================
    if(isset($data['resourceType']) && $data['resourceType'] === 'OperationOutcome'){
        echo '<div class="alert alert-warning">SATUSEHAT ERROR</div>';
        echo '<pre class="bg bg-white text-dark">'.json_encode($data, JSON_PRETTY_PRINT).'</pre>';
        exit;
    }

    // =============================
    // PARSING DATA PRACTITIONER
    // =============================
    if(!empty($data['entry'][0]['resource'])){
        $res       = $data['entry'][0]['resource'];
        $id        = $res['id'] ?? '';
        $nama      = $res['name'][0]['text'] ?? '';
        $gender    = $res['gender'] ?? '';
        $birthDate = $res['birthDate'] ?? '';
        
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-success text-center">
                        <b><i class="bi bi-check-circle"></i> Data Ditemukan</b><br>
                        ID Practitioner melalui NIK <b>'.$nik.'</b> Berhasil Ditemukan!
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4"><small>ID Practitioner</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-muted">'.$id.'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Nama Dokter</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-muted">'.$nama.'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Gender</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-muted">'.$gender.'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Tanggal Lahir</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-muted">'.$birthDate.'</small></div>
            </div>
        ';
    } else {

        // Apabila Data Tidak Ditemukan
        echo '
            <div class="alert alert-danger">
                Pencarian ID practitioner melalui NIK <b>'.$nik.'</b> tidak ditemukan
            </div>
        ';
    }
?>

<script>
    var id_practitioner = '<?php echo $id; ?>';

    // Tempelkan ke form
    $('#id_ihs_practitioner').val(id_practitioner);
</script>

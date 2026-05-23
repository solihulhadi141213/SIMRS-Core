<?php
    // Koneksi Session Dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI AllergyIntolerance
    if (empty($_POST['AllergyIntolerance'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID AllergyIntolerance tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }
    $AllergyIntolerance = $_POST['AllergyIntolerance'];

    // Buka Pengaturan SATUSEHAT
    $query_setting     = mysqli_query($Conn,"SELECT * FROM setting_satusehat WHERE status_setting_satusehat='1' LIMIT 1");
    $setting           = mysqli_fetch_assoc($query_setting);
    $baseurl_satusehat = rtrim($setting['url_satusehat'] ?? '', '/');
    if (empty($baseurl_satusehat)) {
        echo '
            <div class="alert alert-danger">
                <small>URL SATUSEHAT tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Generate Token
    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? '') !== 'success') {
        echo '
            <div class="alert alert-danger">
                <small>Generate token gagal! <br>'.$tokenResult['message'].'</small>
            </div>
        ';
        exit;
    }
    $token = $tokenResult['token'];
    
    // URL
    $url = $baseurl_satusehat . '/fhir-r4/v1/AllergyIntolerance/'.$AllergyIntolerance.'';

    // CURL
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST  => 'GET',
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ],
    ]);

    // Response
    $response   = curl_exec($ch);
    $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    // Curl Error
    if (!empty($curl_error)) {
        echo '
            <div class="alert alert-warning text-center mt-3">
                <small>
                    CURL Error : '.$curl_error.'
                </small>
            </div>
        ';
        exit;
    }

    // Decode JSON
    $result = json_decode($response, true);

    // Vlidasi Data JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo '
            <div class="alert alert-warning text-center mt-3">
                <small>Response SATUSEHAT tidak valid!</small>
            </div>
        ';
        exit;
    }
    if ($httpcode >= 400) {
        $issue_text = $result['issue'][0]['details']['text'] ?? 'Terjadi kesalahan pada SATUSEHAT';
        echo '
            <div class="alert alert-danger">
                <small>
                    <b>HTTP CODE :</b> '.$httpcode.'<br>
                    <b>Message :</b> '.$issue_text.'
                </small>
            </div>
        ';
        exit;
    }

    $responseData = json_decode($response, true);
?>

<div class="row mb-2">
    <div class="col-4"><small>ID</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $AllergyIntolerance;  ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Recorded Date</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $result['recordedDate'];  ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Recorder Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $result['recorder']['display'];  ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Recorder Reference</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $result['recorder']['reference'];  ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Category</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $result['category'][0];  ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Clinical Status Code</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $result['clinicalStatus']['coding'][0]['code'];  ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <small>RAW Data</small>
        <textarea class="form-control" rows="15"><?php echo json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?></textarea>
    </div>
</div>
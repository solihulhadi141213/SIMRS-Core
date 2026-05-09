<?php
    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // AUTOLOAD
    // =========================================================
    include "../../vendor/autoload.php";

    // =========================================================
    // FUNCTION ALERT
    // =========================================================
    function showAlert($message){
        echo '
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>'.$message.'</small>
                    </div>
                </div>
            </div>
        ';
    }

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        showAlert('Sesi akses sudah berakhir! Silahkan login ulang.');
        exit;
    }

    // =========================================================
    // VALIDASI ID IHS
    // =========================================================
    if (empty($_POST['id_ihs'])) {
        showAlert('ID IHS tidak boleh kosong!');
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_ihs = validateAndSanitizeInput($_POST['id_ihs']);

    // =========================================================
    // OPEN CONFIG SATUSEHAT
    // =========================================================
    $stmt_satusehat = mysqli_prepare($Conn,"
        SELECT url_satusehat
        FROM setting_satusehat
        WHERE status_setting_satusehat = 1
        LIMIT 1
    ");

    if (!$stmt_satusehat) {

        showAlert('Terjadi kesalahan saat membuka pengaturan SATUSEHAT.');
        exit;
    }

    mysqli_stmt_execute($stmt_satusehat);

    $result_satusehat = mysqli_stmt_get_result($stmt_satusehat);

    $setting_satusehat = mysqli_fetch_assoc($result_satusehat);

    mysqli_stmt_close($stmt_satusehat);

    // =========================================================
    // VALIDASI BASE URL
    // =========================================================
    $baseurl_satusehat = rtrim(trim($setting_satusehat['url_satusehat'] ?? ''), '/');

    if (empty($baseurl_satusehat)) {

        showAlert('URL SATUSEHAT tidak ditemukan.');
        exit;
    }

    // =========================================================
    // GENERATE TOKEN
    // =========================================================
    $tokenResult = generateTokenSatuSehat($Conn);

    if (($tokenResult['status'] ?? 'error') !== 'success') {

        $message = $tokenResult['message'] ?? 'Generate token gagal';

        showAlert('Terjadi kesalahan generate token SATUSEHAT.<br>'.$message);
        exit;
    }

    // =========================================================
    // TOKEN
    // =========================================================
    $token = $tokenResult['token'] ?? '';

    if (empty($token)) {

        showAlert('Token SATUSEHAT kosong.');
        exit;
    }

    // =========================================================
    // URL PATIENT BY ID
    // =========================================================
    $url = $baseurl_satusehat . '/fhir-r4/v1/Patient/' . $id_ihs;

    // =========================================================
    // CURL
    // =========================================================
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    // =========================================================
    // CURL ERROR
    // =========================================================
    if (curl_errno($curl)) {

        $error_curl = curl_error($curl);

        curl_close($curl);

        showAlert('CURL Error : '.$error_curl);
        exit;
    }

    // =========================================================
    // HTTP CODE
    // =========================================================
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    // =========================================================
    // DECODE JSON
    // =========================================================
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {

        showAlert('Response SATUSEHAT tidak valid.');
        exit;
    }

    // =========================================================
    // OPERATION OUTCOME
    // =========================================================
    if (
        isset($data['resourceType']) &&
        $data['resourceType'] === 'OperationOutcome'
    ) {

        $issue = $data['issue'][0]['details']['text']
            ?? $data['issue'][0]['diagnostics']
            ?? 'Unknown Error';

        showAlert($issue);
        exit;
    }

    // =========================================================
    // VALIDASI RESPONSE
    // =========================================================
    if ($httpcode != 200) {

        showAlert('Gagal mengambil data pasien dari SATUSEHAT.');
        exit;
    }

    // =========================================================
    // AMBIL DATA PASIEN
    // =========================================================

    // ID IHS
    $id = $data['id'] ?? '-';

    // Status Active
    $active = $data['active'] ?? false;

    if ($active == true) {
        $active = 'Active';
    } else {
        $active = 'Non Active';
    }

    // =========================================================
    // NAMA PASIEN
    // =========================================================
    $name = '-';

    if (isset($data['name']) && is_array($data['name'])) {

        foreach ($data['name'] as $nameData) {

            // Prioritas text
            if (!empty($nameData['text'])) {

                $name = $nameData['text'];
                break;
            }

            // Given
            $given = '';

            if (isset($nameData['given']) && is_array($nameData['given'])) {
                $given = implode(' ', $nameData['given']);
            }

            // Family
            $family = $nameData['family'] ?? '';

            // Gabungkan
            $namaGabung = trim($given . ' ' . $family);

            if (!empty($namaGabung)) {

                $name = $namaGabung;
                break;
            }
        }
    }

    // =========================================================
    // NIK PASIEN
    // =========================================================
    $nik_pasien = '-';

    if (isset($data['identifier']) && is_array($data['identifier'])) {

        foreach ($data['identifier'] as $identifier) {

            $system = $identifier['system'] ?? '';
            $value  = $identifier['value'] ?? '';

            if ($system == 'https://fhir.kemkes.go.id/id/nik') {

                $nik_pasien = $value;
                break;
            }
        }
    }

    // =========================================================
    // GENDER
    // =========================================================
    $gender = $data['gender'] ?? '-';

    if ($gender == 'male') {

        $gender = 'Laki-Laki';

    } elseif ($gender == 'female') {

        $gender = 'Perempuan';
    }

    // =========================================================
    // TANGGAL LAHIR
    // =========================================================
    $birthDate = $data['birthDate'] ?? '-';

    // =========================================================
    // META
    // =========================================================
    $lastUpdated = $data['meta']['lastUpdated'] ?? '-';

    $versionId = $data['meta']['versionId'] ?? '-';

    // =========================================================
    // RESOURCE TYPE
    // =========================================================
    $resourceType = $data['resourceType'] ?? '-';

    // =========================================================
    // TAMPILKAN DATA
    // =========================================================
    echo '
        <div class="row mb-2">
            <div class="col-4"><small>IHS Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$id.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$active.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Nama</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$name.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>NIK Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$nik_pasien.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Gender</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$gender.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$birthDate.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Resource Type</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$resourceType.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Version ID</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$versionId.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Last Updated</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$lastUpdated.'</small>
            </div>
        </div>

        <div class="row mb-2 mt-3">
            <div class="col-12">
                <small class="text-muted">Raw JSON Response</small>

                <pre class="small bg-light p-3 rounded border mt-2" style="max-height:300px; overflow:auto;">'.
                    json_encode(
                        $data,
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                    )
                .'</pre>
            </div>
        </div>
    ';
?>
<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // TIMEZONE
    // =========================================================
    date_default_timezone_set('Asia/Jakarta');

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI METHOD
    // =========================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI ID PROCEDURE
    // =========================================================
    if (empty($_POST['id_procedure'])) {

        echo '
            <div class="alert alert-danger text-center">
                <small>ID Procedure tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_procedure = validateAndSanitizeInput($_POST['id_procedure']);

    // =========================================================
    // VALIDASI PENGATURAN SATUSEHAT
    // =========================================================
    $query_setting = mysqli_query(
        $Conn,
        "SELECT * FROM setting_satusehat 
        WHERE status_setting_satusehat='1' 
        LIMIT 1"
    );

    $setting = mysqli_fetch_assoc($query_setting);

    $baseurl_satusehat = rtrim($setting['url_satusehat'] ?? '', '/');

    if (empty($baseurl_satusehat)) {

        echo '
            <div class="alert alert-danger text-center">
                <small>URL SATUSEHAT tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // GENERATE TOKEN
    // =========================================================
    $tokenResult = generateTokenSatuSehat($Conn);

    if (($tokenResult['status'] ?? '') !== 'success') {

        $message = $tokenResult['message'] ?? 'Generate token gagal!';

        echo '
            <div class="alert alert-danger text-center">
                <small>'.$message.'</small>
            </div>
        ';
        exit;
    }

    $token = $tokenResult['token'] ?? '';

    // =========================================================
    // VALIDASI TOKEN
    // =========================================================
    if (empty($token)) {

        echo '
            <div class="alert alert-danger text-center">
                <small>Token SATUSEHAT tidak valid!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // URL API
    // =========================================================
    $url = $baseurl_satusehat . '/fhir-r4/v1/Procedure/' . $id_procedure;

    // =========================================================
    // CURL
    // =========================================================
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

    // =========================================================
    // RESPONSE
    // =========================================================
    $response   = curl_exec($ch);
    $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    // =========================================================
    // CURL ERROR
    // =========================================================
    if (!empty($curl_error)) {

        echo '
            <div class="alert alert-danger text-center">
                <small>CURL Error : '.$curl_error.'</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // DECODE JSON
    // =========================================================
    $result = json_decode($response, true);

    // =========================================================
    // VALIDASI JSON
    // =========================================================
    if (json_last_error() !== JSON_ERROR_NONE) {

        echo '
            <div class="alert alert-danger text-center">
                <small>Response SATUSEHAT tidak valid!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // JIKA GAGAL
    // =========================================================
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

    // =========================================================
    // MAPPING DATA
    // =========================================================
    $resourceType = $result['resourceType'] ?? '-';
    $id           = $result['id'] ?? '-';
    $status       = $result['status'] ?? '-';

    // CATEGORY
    $category_display = $result['category']['coding'][0]['display'] ?? '-';
    $category_code    = $result['category']['coding'][0]['code'] ?? '-';
    $category_system  = $result['category']['coding'][0]['system'] ?? '-';

    // PROCEDURE
    $procedure_display = $result['code']['coding'][0]['display'] ?? '-';
    $procedure_code    = $result['code']['coding'][0]['code'] ?? '-';
    $procedure_system  = $result['code']['coding'][0]['system'] ?? '-';

    // SUBJECT
    $subject_reference = $result['subject']['reference'] ?? '-';
    $subject_display   = $result['subject']['display'] ?? '-';

    // ENCOUNTER
    $encounter_reference = $result['encounter']['reference'] ?? '-';
    $encounter_display   = $result['encounter']['display'] ?? '-';

    // PERFORMED PERIOD
    $performed_start = $result['performedPeriod']['start'] ?? '-';
    $performed_end   = $result['performedPeriod']['end'] ?? '-';

    // BODY SITE
    $bodySite_display = $result['bodySite'][0]['coding'][0]['display'] ?? '-';
    $bodySite_code    = $result['bodySite'][0]['coding'][0]['code'] ?? '-';
    $bodySite_system  = $result['bodySite'][0]['coding'][0]['system'] ?? '-';

    // REASON CODE
    $reason_display = $result['reasonCode'][0]['coding'][0]['display'] ?? '-';
    $reason_code    = $result['reasonCode'][0]['coding'][0]['code'] ?? '-';
    $reason_system  = $result['reasonCode'][0]['coding'][0]['system'] ?? '-';

    // NOTE
    $note_text = $result['note'][0]['text'] ?? '-';

?>

<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-success">
            <small>
                <b>Procedure SATUSEHAT ditemukan</b><br>
                Resource ID :
                <code><?php echo $id; ?></code>
            </small>
        </div>
    </div>
</div>

<!-- INFORMASI UMUM -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>A. Informasi Umum</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Resource Type</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $resourceType; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $status; ?></small>
    </div>
</div>

<!-- CATEGORY -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>B. Category</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $category_display; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Code</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $category_code; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>System</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-break"><?php echo $category_system; ?></small>
    </div>
</div>

<!-- PROCEDURE -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>C. Procedure</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $procedure_display; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Code</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $procedure_code; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>System</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-break"><?php echo $procedure_system; ?></small>
    </div>
</div>

<!-- SUBJECT -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>D. Subject</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Reference</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $subject_reference; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $subject_display; ?></small>
    </div>
</div>

<!-- ENCOUNTER -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>E. Encounter</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Reference</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-break"><?php echo $encounter_reference; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $encounter_display; ?></small>
    </div>
</div>

<!-- PERFORMED -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>F. Performed Period</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Start</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $performed_start; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>End</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $performed_end; ?></small>
    </div>
</div>

<!-- REASON -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>G. Reason Code</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $reason_display; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Code</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $reason_code; ?></small>
    </div>
</div>

<!-- BODY SITE -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>H. Body Site</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Display</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $bodySite_display; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Code</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small><?php echo $bodySite_code; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>System</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-break"><?php echo $bodySite_system; ?></small>
    </div>
</div>

<!-- PERFORMER -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>I. Performer</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><small>No</small></th>
                        <th><small>Reference</small></th>
                        <th><small>Display</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($result['performer'])) {

                            $no = 1;

                            foreach ($result['performer'] as $performer) {

                                $reference = $performer['actor']['reference'] ?? '-';
                                $display   = $performer['actor']['display'] ?? '-';

                                echo '
                                    <tr>
                                        <td class="text-center">
                                            <small>'.$no.'</small>
                                        </td>
                                        <td>
                                            <small>'.$reference.'</small>
                                        </td>
                                        <td>
                                            <small>'.$display.'</small>
                                        </td>
                                    </tr>
                                ';

                                $no++;
                            }

                        } else {

                            echo '
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <small class="text-danger">
                                            Tidak ada data performer
                                        </small>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- NOTE -->
<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>J. Note</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <textarea class="form-control" rows="5" readonly><?php echo $note_text; ?></textarea>
    </div>
</div>

<!-- RAW JSON -->
<div class="row mb-3 mt-4">
    <div class="col-12">
        <small><b>K. Raw JSON Response</b></small>
        <hr class="mt-1">
    </div>
</div>

<div class="row">
    <div class="col-12">
        <textarea 
            class="form-control"
            rows="15"
            readonly
        ><?php echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?></textarea>
    </div>
</div>
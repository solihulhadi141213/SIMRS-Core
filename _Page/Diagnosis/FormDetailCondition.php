<?php
    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // FUNCTION ALERT
    function showConditionAlert($message){
        $message = htmlspecialchars((string)$message, ENT_QUOTES, 'UTF-8');

        echo '
            <div class="alert alert-danger text-center">
                <small>'.$message.'</small>
            </div>
        ';
        exit;
    }

    // FUNCTION ESCAPE OUTPUT
    function eCondition($value){
        return htmlspecialchars((string)($value ?? '-'), ENT_QUOTES, 'UTF-8');
    }

    // FUNCTION BARIS DETAIL
    function rowCondition($label, $value){
        echo '
            <div class="row mb-2">
                <div class="col-4"><small>'.$label.'</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text-muted">'.eCondition($value).'</small></div>
            </div>
        ';
    }

    // FUNCTION AMBIL CODING PERTAMA
    function getConditionCoding($data){
        $coding = $data['coding'][0] ?? [];

        return [
            'system'  => $coding['system'] ?? '-',
            'code'    => $coding['code'] ?? '-',
            'display' => $coding['display'] ?? '-'
        ];
    }

    // FUNCTION PESAN ERROR DARI OPERATION OUTCOME
    function getConditionOutcomeMessage($data){
        $diagnostics = $data['issue'][0]['diagnostics'] ?? '';
        $details     = $data['issue'][0]['details']['text'] ?? '';

        if(!empty($diagnostics)){
            return $diagnostics;
        }
        if(!empty($details)){
            return $details;
        }
        return 'SATUSEHAT tidak mengembalikan detail error.';
    }

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        showConditionAlert('Sesi Akses Sudah Berakhir! Silahkan Login Ulang!');
    }

    // VALIDASI ID CONDITION
    if(empty($_POST['id_condition'])){
        showConditionAlert('ID Condition Tidak Boleh Kosong!');
    }

    // VARIABEL DAN SANITASI
    $id_condition = trim(strip_tags(stripslashes($_POST['id_condition'])));

    if(empty($id_condition)){
        showConditionAlert('ID Condition Tidak Valid!');
    }

    // KONEKSI SATUSEHAT YANG AKTIF
    $status_setting_satusehat = 1;
    $sql = "SELECT * FROM setting_satusehat WHERE status_setting_satusehat = ? LIMIT 1";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $status_setting_satusehat);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();
    $stmt->close();

    if (empty($Data)) {
        showConditionAlert('Setting Koneksi Dengan SATUSEHAT Tidak Ditemukan!');
    }

    $url_satusehat    = rtrim($Data['url_satusehat'] ?? '', '/');
    $token            = $Data['token'] ?? '';
    $datetime_expired = $Data['datetime_expired'] ?? '';

    if(empty($url_satusehat)){
        showConditionAlert('Konfigurasi URL SATUSEHAT belum lengkap!');
    }

    // MENETAPKAN TOKEN
    // Apabila Token Tidak Ada Atau Expired Maka Panggil Function Dari SimrsFunction.php Untuk Membuat Token Ulang
    if(empty($token) || strtotime($datetime_expired) <= time()){
        $tokenResult = generateTokenSatuSehat($Conn);

        if(($tokenResult['status'] ?? '') !== 'success'){
            showConditionAlert($tokenResult['message'] ?? 'Gagal Membuat Token SATUSEHAT!');
        }

        $token = $tokenResult['token'] ?? '';
    }

    if(empty($token)){
        showConditionAlert('Token SATUSEHAT tidak tersedia! Kemungkinan Disebabkan Karena Kegagalan sistem!');
    }

    // MEMBUKA DATA CONDITION DARI SATUSEHAT
    $ConditionById = ConditionById($url_satusehat, $token, $id_condition);
    $data = json_decode($ConditionById, true);

    if(json_last_error() !== JSON_ERROR_NONE){
        showConditionAlert('Response SATUSEHAT bukan JSON valid.');
    }

    if(($data['resourceType'] ?? '') === 'OperationOutcome'){
        showConditionAlert(getConditionOutcomeMessage($data));
    }

    if(($data['resourceType'] ?? '') !== 'Condition'){
        showConditionAlert('Response SATUSEHAT tidak sesuai dengan Resource Condition.');
    }

    // =====================================================
    // MAPPING DATA CONDITION
    // =====================================================
    $id                = $data['id'] ?? '-';
    $resourceType      = $data['resourceType'] ?? '-';
    $versionId         = $data['meta']['versionId'] ?? '-';
    $lastUpdated       = $data['meta']['lastUpdated'] ?? '-';
    $clinicalStatus    = getConditionCoding($data['clinicalStatus'] ?? []);
    $category          = getConditionCoding($data['category'][0] ?? []);
    $code              = getConditionCoding($data['code'] ?? []);
    $codeText          = $data['code']['text'] ?? '-';
    $subjectReference  = $data['subject']['reference'] ?? '-';
    $subjectDisplay    = $data['subject']['display'] ?? '-';
    $encounterRef      = $data['encounter']['reference'] ?? '-';
    $encounterDisplay  = $data['encounter']['display'] ?? '-';
    $onsetDateTime     = $data['onsetDateTime'] ?? '-';
    $recordedDate      = $data['recordedDate'] ?? '-';
    $asserterReference = $data['asserter']['reference'] ?? '-';
    $asserterDisplay   = $data['asserter']['display'] ?? '-';
    $rawJson           = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>A. Informasi Resource</i></b></small>
    </div>
</div>
<?php
    rowCondition('ID Condition', $id);
    rowCondition('Resource Type', $resourceType);
    rowCondition('Version ID', $versionId);
    rowCondition('Last Updated', $lastUpdated);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>B. Clinical Status</i></b></small>
    </div>
</div>
<?php
    rowCondition('System', $clinicalStatus['system']);
    rowCondition('Code', $clinicalStatus['code']);
    rowCondition('Display', $clinicalStatus['display']);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>C. Category</i></b></small>
    </div>
</div>
<?php
    rowCondition('System', $category['system']);
    rowCondition('Code', $category['code']);
    rowCondition('Display', $category['display']);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>D. Diagnosis Code</i></b></small>
    </div>
</div>
<?php
    rowCondition('System', $code['system']);
    rowCondition('Code', $code['code']);
    rowCondition('Display', $code['display']);
    rowCondition('Text', $codeText);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>E. Subject & Encounter</i></b></small>
    </div>
</div>
<?php
    rowCondition('Subject Reference', $subjectReference);
    rowCondition('Subject Display', $subjectDisplay);
    rowCondition('Encounter Reference', $encounterRef);
    rowCondition('Encounter Display', $encounterDisplay);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>F. Waktu & Asserter</i></b></small>
    </div>
</div>
<?php
    rowCondition('Onset DateTime', $onsetDateTime);
    rowCondition('Recorded Date', $recordedDate);
    rowCondition('Asserter Reference', $asserterReference);
    rowCondition('Asserter Display', $asserterDisplay);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>G. Raw JSON Response</i></b></small>
        <pre class="small bg-light p-3 rounded border mt-2" style="max-height:300px; overflow:auto;"><?php echo eCondition($rawJson); ?></pre>
    </div>
</div>

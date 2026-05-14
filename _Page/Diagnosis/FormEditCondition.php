<?php
    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // FUNCTION ALERT
    function showEditConditionAlert($message){
        $message = htmlspecialchars((string)$message, ENT_QUOTES, 'UTF-8');

        echo '
            <div class="alert alert-danger">
                <small>'.$message.'</small>
            </div>
        ';
        exit;
    }

    // FUNCTION ESCAPE OUTPUT
    function eEditCondition($value){
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    // FUNCTION AMBIL CODING PERTAMA
    function getEditConditionCoding($data){
        $coding = $data['coding'][0] ?? [];

        return [
            'system'  => $coding['system'] ?? '',
            'code'    => $coding['code'] ?? '',
            'display' => $coding['display'] ?? ''
        ];
    }

    // FUNCTION PESAN ERROR DARI OPERATION OUTCOME
    function getEditConditionOutcomeMessage($data){
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
        showEditConditionAlert('Sesi akses sudah berakhir! Silahkan login ulang.');
    }

    // VALIDASI ID CONDITION
    if (empty($_POST['id_condition'])) {
        showEditConditionAlert('ID Condition tidak boleh kosong!');
    }

    // SANITASI INPUT
    $id_condition = trim(strip_tags(stripslashes($_POST['id_condition'])));

    if(empty($id_condition)){
        showEditConditionAlert('ID Condition tidak valid!');
    }

    // BUKA DATA DIAGNOSIS BERDASARKAN ID CONDITION
    $sql  = "SELECT id_diagnosis, id_kunjungan FROM diagnosis WHERE id_condition = ? LIMIT 1";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("s", $id_condition);
    $stmt->execute();
    $result = $stmt->get_result();
    $Diagnosis = $result->fetch_assoc();
    $stmt->close();

    if (empty($Diagnosis)) {
        showEditConditionAlert('Data Diagnosis dengan ID Condition tersebut tidak ditemukan!');
    }

    $id_diagnosis = $Diagnosis['id_diagnosis'] ?? '';

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
        showEditConditionAlert('Setting Koneksi Dengan SATUSEHAT Tidak Ditemukan!');
    }

    $url_satusehat    = rtrim($Data['url_satusehat'] ?? '', '/');
    $token            = $Data['token'] ?? '';
    $datetime_expired = $Data['datetime_expired'] ?? '';

    if(empty($url_satusehat)){
        showEditConditionAlert('Konfigurasi URL SATUSEHAT belum lengkap!');
    }

    // MENETAPKAN TOKEN
    // Apabila Token Tidak Ada Atau Expired Maka Panggil Function Dari SimrsFunction.php Untuk Membuat Token Ulang
    if(empty($token) || strtotime($datetime_expired) <= time()){
        $tokenResult = generateTokenSatuSehat($Conn);

        if(($tokenResult['status'] ?? '') !== 'success'){
            showEditConditionAlert($tokenResult['message'] ?? 'Gagal membuat token SATUSEHAT');
        }

        $token = $tokenResult['token'] ?? '';
    }

    if(empty($token)){
        showEditConditionAlert('Token SATUSEHAT tidak tersedia!');
    }

    // MEMBUKA DATA CONDITION DARI SATUSEHAT
    $ConditionById = ConditionById($url_satusehat, $token, $id_condition);
    $data = json_decode($ConditionById, true);

    if(json_last_error() !== JSON_ERROR_NONE){
        showEditConditionAlert('Response SATUSEHAT bukan JSON valid.');
    }

    if(($data['resourceType'] ?? '') === 'OperationOutcome'){
        showEditConditionAlert(getEditConditionOutcomeMessage($data));
    }

    if(($data['resourceType'] ?? '') !== 'Condition'){
        showEditConditionAlert('Response SATUSEHAT tidak sesuai dengan Resource Condition.');
    }

    // =====================================================
    // MAPPING DATA CONDITION
    // =====================================================
    $clinicalStatus   = getEditConditionCoding($data['clinicalStatus'] ?? []);
    $category         = getEditConditionCoding($data['category'][0] ?? []);
    $code             = getEditConditionCoding($data['code'] ?? []);
    $subjectReference = $data['subject']['reference'] ?? '';
    $subjectDisplay   = $data['subject']['display'] ?? '';
    $encounterRef     = $data['encounter']['reference'] ?? '';
    $encounterDisplay = $data['encounter']['display'] ?? '';
?>
<input type="hidden" name="id_diagnosis" value="<?php echo eEditCondition($id_diagnosis); ?>">
<input type="hidden" name="id_condition" value="<?php echo eEditCondition($id_condition); ?>">
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b><i>A. Clinical Status</i></b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_clinical_status_coding_system"><i>System</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="clinical_status_coding_system" id="edit_clinical_status_coding_system" class="form-control edit-condition-required" required value="<?php echo eEditCondition($clinicalStatus['system']); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_clinical_status_coding_code"><i>Code</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="clinical_status_coding_code" id="edit_clinical_status_coding_code" class="form-control edit-condition-required" required value="<?php echo eEditCondition($clinicalStatus['code']); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_clinical_status_coding_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="clinical_status_coding_display" id="edit_clinical_status_coding_display" class="form-control edit-condition-required" required value="<?php echo eEditCondition($clinicalStatus['display']); ?>">
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b><i>B. Category</i></b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_category_coding_system"><i>System</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="category_coding_system" id="edit_category_coding_system" class="form-control edit-condition-required" required value="<?php echo eEditCondition($category['system']); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_category_coding_code"><i>Code</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="category_coding_code" id="edit_category_coding_code" class="form-control edit-condition-required" required value="<?php echo eEditCondition($category['code']); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_category_coding_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="category_coding_display" id="edit_category_coding_display" class="form-control edit-condition-required" required value="<?php echo eEditCondition($category['display']); ?>">
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b><i>C. Code</i></b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_code_coding_system"><i>System</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="code_coding_system" id="edit_code_coding_system" class="form-control edit-condition-required" required value="<?php echo eEditCondition($code['system']); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_code_coding_code"><i>Code</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="code_coding_code" id="edit_code_coding_code" class="form-control edit-condition-required" required value="<?php echo eEditCondition($code['code']); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_code_coding_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="code_coding_display" id="edit_code_coding_display" class="form-control edit-condition-required" required value="<?php echo eEditCondition($code['display']); ?>">
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b><i>D. Subject</i></b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_subject_reference"><i>Reference</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="subject_reference" id="edit_subject_reference" class="form-control edit-condition-required" required value="<?php echo eEditCondition($subjectReference); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_subject_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="subject_display" id="edit_subject_display" class="form-control edit-condition-required" required value="<?php echo eEditCondition($subjectDisplay); ?>">
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b><i>E. Encounter</i></b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_encounter_reference"><i>Reference</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="encounter_reference" id="edit_encounter_reference" class="form-control edit-condition-required" required value="<?php echo eEditCondition($encounterRef); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_encounter_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="encounter_display" id="edit_encounter_display" class="form-control edit-condition-required" required value="<?php echo eEditCondition($encounterDisplay); ?>">
    </div>
</div>
<script>
    $('#ButtonEditCondition').prop('disabled', false);
</script>

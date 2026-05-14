<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI ID DIAGNOSIS
    if (empty($_POST['id_diagnosis'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Diagnosis tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_diagnosis = validateAndSanitizeInput($_POST['id_diagnosis']);

    // Buka Data Diagnosis
    $sql  = "SELECT * FROM diagnosis WHERE id_diagnosis = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_diagnosis);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data Diagnosis tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // =====================================================
    // MAPPING DATA
    // =====================================================
    $id_kunjungan     = $Data['id_kunjungan'] ?? null;
    $id_pasien        = $Data['id_pasien'] ?? null;
    $id_condition     = $Data['id_condition'] ?? null;
    $dokter_id        = $Data['dokter_id'] ?? null;
    $dokter_kode      = $Data['dokter_kode'] ?? null;
    $dokter_nama      = $Data['dokter_nama'] ?? null;
    $jenis_diagnosis  = $Data['jenis_diagnosis'] ?? null;
    $icd_version      = $Data['icd_version'] ?? null;
    $icd_kode         = $Data['icd_kode'] ?? null;
    $icd_deskripsi    = $Data['icd_deskripsi'] ?? null;
    $diagnosis_text   = $Data['diagnosis_text'] ?? null;
    $status_kasus     = $Data['status_kasus'] ?? null;
    $status_kepastian = $Data['status_kepastian'] ?? null;
    $datetime_creat   = $Data['datetime_creat'] ?? null;
    $petugas_id       = $Data['petugas_id'] ?? null;
    $petugas_nama     = $Data['petugas_nama'] ?? null;

    $stmt->close();

    // Buka id encounter kunjungan
    $id_encounter = getDataDetail_v2($Conn, 'kunjungan', 'id_kunjungan', $id_kunjungan, 'id_encounter');
    if(empty($id_encounter)){
        echo '
            <div class="alert alert-danger">
                <small>
                    <b>Data Kunjungan Pada Diagnosis Tersebut Belum Memiliki ID Encounter!</b><br>
                    Ketahui bahwa syarat pengiriman <i>Resource Condition</i> adalah kunjungan sudah dibuatkan ID Encounter.
                </small>
            </div>
        ';
        exit;
    }

    // Buka ID IHS dan Nama pasien
    $id_ihs = getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'id_ihs');
    if(empty($id_ihs)){
        echo '
            <div class="alert alert-danger">
                <small>
                    <b>Pasien Belum Memiliki IHS</b><br>
                    Ketahui bahwa syarat pengiriman <i>Resource Condition</i> adalah pasien sudah memiliki IHS.
                </small>
            </div>
        ';
        exit;
    }
    $nama_pasien = getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'nama');

    // Mapping Status Kasus
    if($status_kasus=="Kambuh"){
        $clinical_status_code    = "recurrence";
        $clinical_status_display = "Kambuh";
    }else{
        $clinical_status_code    = "active";
        $clinical_status_display = $status_kasus;
    }
?>
<input type="hidden" name="id_diagnosis" value="<?php echo $id_diagnosis; ?>">
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b><i>A. Clinical Status</i></b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="clinical_status_coding_system"><i>System</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="clinical_status_coding_system" id="clinical_status_coding_system" class="form-control" required value="http://terminology.hl7.org/CodeSystem/condition-clinical">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="clinical_status_coding_code"><i>Code</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="clinical_status_coding_code" id="clinical_status_coding_code" class="form-control" required value="<?php echo $clinical_status_code;?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="clinical_status_coding_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="clinical_status_coding_display" id="clinical_status_coding_display" class="form-control" required value="<?php echo $clinical_status_display;?>">
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
        <label for="category_coding_system"><i>System</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="category_coding_system" id="category_coding_system" class="form-control" required value="http://terminology.hl7.org/CodeSystem/condition-category">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="category_coding_code"><i>Code</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="category_coding_code" id="category_coding_code" class="form-control" required value="encounter-diagnosis">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="category_coding_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="category_coding_display" id="category_coding_display" class="form-control" required value="Encounter Diagnosis">
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
        <label for="code_coding_system"><i>System</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="code_coding_system" id="code_coding_system" class="form-control" required value="http://hl7.org/fhir/sid/icd-10">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="code_coding_code"><i>Code</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="code_coding_code" id="code_coding_code" class="form-control" required value="<?php echo $icd_kode;?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="code_coding_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="code_coding_display" id="code_coding_display" class="form-control" required value="<?php echo $icd_deskripsi;?>">
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
        <label for="subject_reference"><i>Reference</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="subject_reference" id="subject_reference" class="form-control" required value="Patient/<?php echo $id_ihs; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="subject_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="subject_display" id="subject_display" class="form-control" required value="<?php echo $nama_pasien; ?>">
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
        <label for="encounter_reference"><i>Reference</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="encounter_reference" id="encounter_reference" class="form-control" required value="Encounter/<?php echo $id_encounter; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="encounter_display"><i>Display</i></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="encounter_display" id="encounter_display" class="form-control" required value="Kunjungan <?php echo $nama_pasien; ?> Pada Tanggal <?php echo $datetime_creat; ?>">
    </div>
</div>

<script>
    $('#ButtonKirimCondition').prop('disabled', false);
</script>
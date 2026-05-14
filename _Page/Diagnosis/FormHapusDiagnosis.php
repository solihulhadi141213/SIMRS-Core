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

    // Null Label
    if(empty($id_condition)){
        $id_condition = '-';
    }

    if(empty($diagnosis_text)){
        $diagnosis_text = '-';
    }
    if(empty($icd_version)){
        $icd_version = '-';
    }
    if(empty($icd_kode)){
        $diagnosis_icd = '-';
    }else{
        $diagnosis_icd = "$icd_kode - $icd_deskripsi";
    }
?>
<input type="hidden" name="id_diagnosis" value="<?php echo $id_diagnosis; ?>">
<div class="row mb-2">
    <div class="col-4"><small>Tanggal & Waktu</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo date('d/m/Y H:i', strtotime($datetime_creat)); ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Kategori Diagnosis</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $jenis_diagnosis; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Dokter Pemberi Pernyataan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$dokter_kode | $dokter_nama"; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Diagnosis (Text)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $diagnosis_text; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small><i>ICD</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $icd_version; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Code & Description</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$diagnosis_icd"; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Status Kasus</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $status_kasus; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Status Kepastian</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $status_kepastian; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>ID Condition (SATUSEHAT)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_condition; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <div class="alert alert-danger text-center">
            <small>Apakah Anda Yakin Akan Menghapus Data Tersebut?</small>
        </div>
    </div>
</div>
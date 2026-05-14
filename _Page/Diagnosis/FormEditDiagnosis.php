<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // =====================================================
    // VALIDASI ID DIAGNOSIS
    // =====================================================
    if (empty($_POST['id_diagnosis'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Diagnosis tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // =====================================================
    // SANITASI INPUT
    // =====================================================
    $id_diagnosis = validateAndSanitizeInput($_POST['id_diagnosis']);

    // =====================================================
    // AMBIL DATA DIAGNOSIS
    // =====================================================
    $sql = "
        SELECT *
        FROM diagnosis
        WHERE id_diagnosis = ?
        LIMIT 1
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_diagnosis);
    $stmt->execute();

    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    $stmt->close();

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
    $id_kunjungan     = $Data['id_kunjungan'] ?? '';
    $dokter_id        = $Data['dokter_id'] ?? '';
    $dokter_kode      = $Data['dokter_kode'] ?? '';
    $dokter_nama      = $Data['dokter_nama'] ?? '';
    $jenis_diagnosis  = $Data['jenis_diagnosis'] ?? '';
    $icd_version      = $Data['icd_version'] ?? '';
    $icd_kode         = $Data['icd_kode'] ?? '';
    $icd_deskripsi    = $Data['icd_deskripsi'] ?? '';
    $diagnosis_text   = $Data['diagnosis_text'] ?? '';
    $status_kasus     = $Data['status_kasus'] ?? '';
    $status_kepastian = $Data['status_kepastian'] ?? '';

    // =====================================================
    // AMBIL ID ICD BERDASARKAN KODE DAN VERSI
    // =====================================================
    $id_icd = '';

    if (!empty($icd_version) && !empty($icd_kode)) {
        $sqlIcd = "
            SELECT id_icd
            FROM icd
            WHERE icd = ? AND kode = ?
            LIMIT 1
        ";

        $stmtIcd = $Conn->prepare($sqlIcd);
        $stmtIcd->bind_param("ss", $icd_version, $icd_kode);
        $stmtIcd->execute();

        $resultIcd = $stmtIcd->get_result();
        $dataIcd   = $resultIcd->fetch_assoc();

        $stmtIcd->close();

        if (!empty($dataIcd)) {
            $id_icd = $dataIcd['id_icd'];
        }
    }

    // =====================================================
    // HELPER
    // =====================================================
    function selectedOption($value, $selectedValue)
    {
        return ($value == $selectedValue) ? 'selected' : '';
    }

    function checkedOption($value, $selectedValue)
    {
        return ($value == $selectedValue) ? 'checked' : '';
    }

    $dokter_label = trim($dokter_nama);

    if (!empty($dokter_kode)) {
        $dokter_label .= ' (' . $dokter_kode . ')';
    }

    $icd_label = '';

    if (!empty($icd_kode)) {
        $icd_label = $icd_kode;

        if (!empty($icd_deskripsi)) {
            $icd_label .= ' - ' . $icd_deskripsi;
        }
    }
?>
<input type="hidden" name="id_diagnosis" value="<?php echo htmlspecialchars($id_diagnosis); ?>">
<input type="hidden" name="id_kunjungan" value="<?php echo htmlspecialchars($id_kunjungan); ?>">

<div class="row mb-3">
    <div class="col-12">
        <label for="jenis_diagnosis_edit">* Kategori Diagnosis</label>
        <input type="text" readonly name="jenis_diagnosis" id="jenis_diagnosis_edit" class="form-control bg-secondary-subtle" value="<?php echo htmlspecialchars($jenis_diagnosis); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="id_dokter_edit_diagnosis">* Dokter</label>
        <select name="id_dokter" id="id_dokter_edit_diagnosis" class="form-control" required>
            <option value=""></option>
            <?php if (!empty($dokter_id)) { ?>
                <option value="<?php echo htmlspecialchars($dokter_id); ?>" selected>
                    <?php echo htmlspecialchars($dokter_label); ?>
                </option>
            <?php } ?>
        </select>
        <small>
            <small class="text-muted">Dokter yang memberikan pernyataan terkait diagnosis yang ditetapkan. Bisa diisi oleh dokter pemeriksa atau dokter DPJP</small>
        </small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="diagnosis_text_edit">Diagnosis (<i>Text</i>)</label>
        <textarea name="diagnosis_text" id="diagnosis_text_edit" class="form-control"><?php echo htmlspecialchars($diagnosis_text); ?></textarea>
        <small>
            <small class="text-muted">Pernyataan diagnosis dokter dalam bentuk text bebas. Dapat membantu petugas dalam menetapkan kode ICD yang tepat.</small>
        </small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="status_kasus_edit">Status Kasus</label>
        <select name="status_kasus" id="status_kasus_edit" class="form-control">
            <option value="">Pilih</option>
            <option value="Baru" <?php echo selectedOption('Baru', $status_kasus); ?>>Baru</option>
            <option value="Lama" <?php echo selectedOption('Lama', $status_kasus); ?>>Lama</option>
            <option value="Kambuh" <?php echo selectedOption('Kambuh', $status_kasus); ?>>Kambuh</option>
            <option value="Kronis" <?php echo selectedOption('Kronis', $status_kasus); ?>>Kronis</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="icd_version_edit">Versi ICD</label>
        <select name="icd_version" id="icd_version_edit" class="form-control">
            <option value="">Pilih</option>
            <option value="ICD10" <?php echo selectedOption('ICD10', $icd_version); ?>>ICD10</option>
            <option value="ICD11" <?php echo selectedOption('ICD11', $icd_version); ?>>ICD11</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="id_icd_edit">Kode ICD</label>
        <select name="id_icd" id="id_icd_edit" class="form-control">
            <option value="">Pilih</option>
            <?php if (!empty($id_icd)) { ?>
                <option value="<?php echo htmlspecialchars($id_icd); ?>" selected>
                    <?php echo htmlspecialchars($icd_label); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="status_kepastian_edit_1" class="mb-3">* Status Diagnosis</label>
        <div class="d-flex flex-wrap gap-3 mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_kepastian" id="status_kepastian_edit_1" value="Provisional" <?php echo checkedOption('Provisional', $status_kepastian); ?> required>
                <label class="form-check-label" for="status_kepastian_edit_1">
                    <small class="text-dark">Sementara (<i>Provisional</i>)</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_kepastian" id="status_kepastian_edit_2" value="Final" <?php echo checkedOption('Final', $status_kepastian); ?> required>
                <label class="form-check-label" for="status_kepastian_edit_2">
                    <small class="text-dark">Selesai (<i>Final</i>)</small>
                </label>
            </div>
        </div>
    </div>
</div>

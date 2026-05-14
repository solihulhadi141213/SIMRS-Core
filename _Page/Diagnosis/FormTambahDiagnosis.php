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
    // VALIDASI ID KUNJUNGAN
    // =====================================================
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    if (empty($_POST['kategori'])) {
        echo '
            <div class="alert alert-danger">
                <small>Kategori Diagnosis tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // =====================================================
    // SANITASI INPUT
    // =====================================================
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);
    $kategori = validateAndSanitizeInput($_POST['kategori']);
?>
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<div class="row mb-3">
    <div class="col-12">
        <label for="jenis_diagnosis">* Kategori Diagnosis</label>
        <input type="text" readonly name="jenis_diagnosis" id="jenis_diagnosis" class="form-control bg-secondary-subtle" value="<?php echo $kategori; ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="id_dokter">* Dokter</label>
        <select name="id_dokter" id="id_dokter" class="form-control" required>
            <option value=""></option>
        </select>
        <small>
            <small class="text-muted">Dokter yang memberikan pernyataan terkait diagnosis yang ditetapkan. Bisa diisi oleh dokter pemeriksa atau dokter DPJP</small>
        </small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="diagnosis_text">Diagnosis (<i>Text</i>)</label>
        <textarea name="diagnosis_text" id="diagnosis_text" class="form-control"></textarea>
        <small>
            <small class="text-muted">Pernyataan diagnosis dokter dalam bentuk text bebas. Dapat membantu petugas dalam menetapkan kode ICD yang tepat.</small>
        </small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="status_kasus">Status Kasus</label>
        <select name="status_kasus" id="status_kasus" class="form-control">
            <option value="Baru">Baru</option>
            <option value="Lama">Lama</option>
            <option value="Kambuh">Kambuh</option>
            <option value="Kronis">Kronis</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="icd_version">Versi ICD</label>
        <select name="icd_version" id="icd_version" class="form-control">
            <option value="">Pilih</option>
            <option value="ICD10">ICD10</option>
            <option value="ICD11">ICD11</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="id_icd">Kode ICD</label>
        <select name="id_icd" id="id_icd" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="status_kepastian" class="mb-3">* Status Diagnosis</label>
        <div class="d-flex flex-wrap gap-3 mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_kepastian" id="status_kepastian1" value="Provisional" checked>
                <label class="form-check-label" for="status_kepastian1">
                    <small class="text-dark">Sementara (<i>Provisional</i>)</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_kepastian" id="status_kepastian2" value="Final">
                <label class="form-check-label" for="status_kepastian2">
                    <small class="text-dark">Selesai (<i>Final</i>)</small>
                </label>
            </div>
        </div>
    </div>
</div>


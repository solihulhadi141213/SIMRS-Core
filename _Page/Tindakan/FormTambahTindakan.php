<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

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

    // VALIDASI ID KUNJUNGAN
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // DETAIL KUNJUNGAN & PASIEN
    $sql = "
        SELECT 
            k.*,
            k.status AS status_kunjungan,

            p.id_pasien,
            p.nama,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.status AS status_pasien

        FROM kunjungan k

        LEFT JOIN pasien p 
            ON k.id_pasien = p.id_pasien

        WHERE k.id_kunjungan = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_kunjungan);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();
    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data kunjungan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    /// MAPPING DATA PASIEN
    $id_pasien       = $Data['id_pasien'] ?? null;
    $nama            = $Data['nama'] ?? null;
    $gender          = $Data['gender'] ?? null;
    $id_ihs          = $Data['id_ihs'] ?? null;
    

    // MAPPING DATA KUNJUNGAN
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;
    $id_encounter = $Data['id_encounter'] ?? null;

    // Close
    $stmt->close();
?>
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b>A. Informasi Tindakan</b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12" id="form_tindakan_referensi">
        <label for="id_tindakan_referensi"><small>Cari Data Tindakan</small></label>
        <select name="id_tindakan_referensi" id="id_tindakan_referensi"  class="form-select">
            <option value="">Pilih</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="kategori_tindakan"><small>Kategori <i>(Category Code System)</i></small></label>
        <input type="text" name="kategori_tindakan" id="kategori_tindakan" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="nama_tindakan"><small>Nama / Jenis <i>(Procedure)</i></small></label>
        <input type="text" name="nama_tindakan" id="nama_tindakan" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="lokasi_tubuh"><small>Lokasi Tubuh <i>(Body Site)</i></small></label>
        <input type="text" name="lokasi_tubuh" id="lokasi_tubuh" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_icd9_code">
        <label for="icd9_code"><small>Referensi ICD 9</small></label>
        <input type="hidden" name="icd9_description" id="icd9_description">
        <select name="icd9_code" id="icd9_code" class="form-select">
            <option value="">Pilih</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="date_start"><small>Waktu Mulai Tindakan</small></label>
        <div class="input-group">
            <input type="date" name="date_start" id="date_start" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            <input type="time" name="time_start" id="time_start" class="form-control" value="<?php echo date('H:i'); ?>">
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="date_end"><small>Waktu Selesai Tindakan</small></label>
        <div class="input-group">
            <input type="date" name="date_end" id="date_end" class="form-control">
            <input type="time" name="time_end" id="time_end" class="form-control">
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_reson_code">
        <label for="reson_code">
            <small>Diagnosis / Alasan Pemberian Tindakan <i>(Reason Code)</i></small>
        </label>
        <input type="hidden" name="reson_display" id="reson_display">
        <select name="reson_code" id="reson_code" class="form-select">
            <option value="">Pilih</option>
        </select>
        <div class="d-flex flex-wrap gap-3 mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="reson_reference" id="reson_reference_icd10" value="ICD10" checked="">
                <label class="form-check-label" for="reson_reference_icd10">
                    <small>ICD 10</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="reson_reference" id="reson_reference_icd11" value="ICD11">
                <label class="form-check-label" for="reson_reference_icd11">
                    <small>ICD 11</small>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="post_tindakan"><small>Keterangan (Post Tindakan)</small></label>
        <textarea name="post_tindakan" id="post_tindakan" class="form-control" ></textarea>
    </div>
</div>
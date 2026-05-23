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

<div class="row mb-3">
    <div class="col-12" id="form_kategori_alergen">
        <label for="kategori_alergen"><small>Kategori Alergen</small></label>
        <select name="kategori_alergen" id="kategori_alergen"  class="form-select">
            <option value="Food">Makanan (Food)</option>
            <option value="Medication">Obat-obatan (Medication)</option>
            <option value="Environment">Lingkungan (Environment)</option>
            <option value="Biologic">Biologis (Biologic)</option>
        </select>
    </div>
</div>


<div class="row mb-3">
    <div class="col-12" id="form_jenis_alergen">
        <label for="id_alergi_alergen"><small>Nama/Jenis Alergen</small></label>
        <select name="id_alergi_alergen" id="id_alergi_alergen"  class="form-select">
            <option value="">Pilih Alergen</option>
        </select>
        <input type="hidden" name="manual_alergen" id="manual_alergen">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_clinical_status">
        <label for="clinical_status"><small>Status Klinis</small></label>
        <select name="clinical_status" id="clinical_status"  class="form-select">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="resolved">Resolved</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_verification_status">
        <label for="verification_status"><small>Status Verifikasi</small></label>
        <select name="verification_status" id="verification_status" class="form-select" required>
            <option value="unconfirmed">Unconfirmed</option>
            <option value="presumed">Presumed</option>
            <option value="confirmed">Confirmed</option>
            <option value="refuted">Refuted</option>
            <option value="entered-in-error">Entered-in-error</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_id_praktisi">
        <label for="id_praktisi"><small>Dokter Yang Menetapkan</small></label>
        <select name="id_praktisi" id="id_praktisi"  class="form-select">
            <option value="">Pilih Praktisi</option>
        </select>
    </div>
</div>


<div class="row mb-3">
    <div class="col-12" id="form_keterangan_alergi">
        <label for="keterangan_alergi"><small>Keterangan / Reaksi Alergi</small></label>
        <textarea name="keterangan_alergi" id="keterangan_alergi" class="form-control"></textarea>
    </div>
</div>
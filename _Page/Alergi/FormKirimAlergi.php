<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    date_default_timezone_set('Asia/Jakarta');

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses berakhir!</small></div>';
        exit;
    }

    // VALIDASI
    if (empty($_POST['id_alergi'])) {
        echo '<div class="alert alert-danger"><small>ID alergi tidak boleh kosong!</small></div>';
        exit;
    }

    $id_alergi = validateAndSanitizeInput($_POST['id_alergi']);

    // QUERY
    $sql = "
        SELECT 
            ag.*,

            -- KUNJUNGAN
            k.id_kunjungan,
            k.id_dokter,
            k.jenis_kunjungan,
            k.datetime_daftar,
            k.id_encounter,
            k.status AS status_kunjungan,

            -- PASIEN
            p.id_pasien,
            p.nama AS nama_pasien,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.tanggal_lahir,
            p.status AS status_pasien,

            -- REFERENSI ALERGEN
            aa.kategori_alergen AS kategori_alergen_ref,
            aa.nama_alergen AS nama_alergen_ref,
            aa.code_alergen AS kode_alergen,
            aa.display_alergen AS display_alergen,
            aa.system_alergen AS system_alergen,

            -- PRAKTISI
            pr.nama_praktisi,
            pr.id_practitioner,

            -- AKSES/PETUGAS
            ak.nama AS nama_petugas_input

        FROM alergi ag

        LEFT JOIN kunjungan k
            ON ag.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON ag.id_pasien = p.id_pasien

        LEFT JOIN alergi_alergen aa
            ON ag.id_alergi_alergen = aa.id_alergi_alergen

        LEFT JOIN praktisi pr
            ON ag.id_praktisi = pr.id_praktisi

        LEFT JOIN akses ak
            ON ag.author_id = ak.id_akses

        WHERE ag.id_alergi = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("s", $id_alergi);
    $stmt->execute();

    $result = $stmt->get_result();
    $data   = $result->fetch_assoc();

    if (empty($data)) {
        echo '<div class="alert alert-danger"><small>Data alergi tidak ditemukan!</small></div>';
        exit;
    }

    // MAPPING
    $id_pasien           = $data['id_pasien'];
    $id_kunjungan        = $data['id_kunjungan'];
    $id_alergi_alergen   = $data['id_alergi_alergen'];
    $kategori_alergen    = $data['kategori_alergen'];
    $nama_alergen        = $data['nama_alergen'];
    $clinical_status     = $data['clinical_status'];
    $verification_status = $data['verification_status'];
    $id_praktisi         = $data['id_praktisi'];
    $nama_praktisi       = $data['nama_praktisi'];
    $keterangan_alergi   = $data['keterangan_alergi'];
    $datetime_creat      = $data['datetime_creat'];

    // Fixed String
    $clinical_status_display     = ucfirst($clinical_status);
    $verification_status_display = ucfirst($verification_status);

    // Buka Pengaturan Satusehat yang Aktif
    $query_setting = mysqli_query($Conn,"SELECT * FROM setting_satusehat WHERE status_setting_satusehat='1' LIMIT 1");
    $setting = mysqli_fetch_assoc($query_setting);
    $organization_id = $setting['organization_id'];

    // variabel Alergen
    // aa.kategori_alergen AS kategori_alergen_ref,
    // aa.nama_alergen AS nama_alergen_ref,
    // aa.code_alergen AS kode_alergen,
    // aa.display_alergen AS display_alergen,
    // aa.system_alergen AS system_alergen,

    $kategori_alergen_ref = $data['kategori_alergen_ref'];
    $nama_alergen_ref     = $data['nama_alergen_ref'];
    $kode_alergen         = $data['kode_alergen'];
    $display_alergen      = $data['display_alergen'];
    $system_alergen       = $data['system_alergen'];

    // variabel Pasien
    // p.id_pasien,
    // p.nama AS nama_pasien,
    // p.nik,
    // p.no_bpjs,
    // p.id_ihs,
    // p.gender,
    // p.tanggal_lahir,
    // p.status AS status_pasien,

    $id_ihs      = $data['id_ihs'];
    $nama_pasien = $data['nama_pasien'];

    // variabel Kunjungan
    // k.id_kunjungan,
    // k.id_dokter,
    // k.jenis_kunjungan,
    // k.datetime_daftar,
    // k.id_encounter,
    // k.status AS status_kunjungan,

    $id_encounter      = $data['id_encounter'];
    $jenis_kunjungan      = $data['jenis_kunjungan'];

    // Praktisi
    $id_practitioner      = $data['id_practitioner'];
?>
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<div class="row mb-2">
    <div class="col-12">
        <small><b>A. Identifier</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="id_alergi"><small>ID Alergi</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" readonly name="id_alergi" id="id_alergi" class="form-control" value="<?php echo $id_alergi; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="organization_id"><small>Organization ID</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="organization_id" id="organization_id" class="form-control" value="<?php echo $organization_id; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>B. Clinical Status</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="clinicalStatus_system"><small>System</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" readonly name="clinicalStatus_system" id="clinicalStatus_system" class="form-control" value="http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="clinicalStatus_code"><small>Code</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="clinicalStatus_code" id="clinicalStatus_code" class="form-control" value="<?php echo $clinical_status; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="clinicalStatus_display"><small>Display</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="clinicalStatus_display" id="clinicalStatus_display" class="form-control" value="<?php echo $clinical_status_display; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>C. Verification Status</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="verificationStatus_system"><small>System</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" readonly name="verificationStatus_system" id="verificationStatus_system" class="form-control" value="http://terminology.hl7.org/CodeSystem/allergyintolerance-verification">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="verificationStatus_code"><small>Code</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="verificationStatus_code" id="verificationStatus_code" class="form-control" value="<?php echo $verification_status; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="verificationStatus_display"><small>Display</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="verificationStatus_display" id="verificationStatus_display" class="form-control" value="<?php echo $verification_status_display; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>D. Alergen</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="category"><small>Kategori</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" readonly name="category" id="category" class="form-control" value="<?php echo $kategori_alergen; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="code_coding_system"><small>System</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_system" id="code_coding_system" class="form-control" value="<?php echo $system_alergen; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="code_coding_code"><small>Code</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_code" id="code_coding_code" class="form-control" value="<?php echo $kode_alergen; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="code_coding_display"><small>Display</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_display" id="code_coding_display" class="form-control" value="<?php echo $display_alergen; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>E. Pasien</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="patient_reference"><small>ID IHS Pasien</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="patient_reference" id="patient_reference" class="form-control" value="<?php echo "Patient/$id_ihs"; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="patient_display"><small>Nama Pasien</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="patient_display" id="patient_display" class="form-control" value="<?php echo $nama_pasien; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>F. Kunjungan</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="encounter_reference"><small>ID Encounter</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="encounter_reference" id="encounter_reference" class="form-control" value="<?php echo "Encounter/$id_encounter"; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="encounter_display"><small>Display</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="encounter_display" id="encounter_display" class="form-control" value="<?php echo $jenis_kunjungan; ?>">
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b>G. Praktisi</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="recordedDate"><small>Tanggal & Jam Record</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="recordedDate" id="recordedDate" class="form-control" value="<?php echo $datetime_creat; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="recorder_reference"><small>ID Praktisi</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="recorder_reference" id="recorder_reference" class="form-control" value="<?php echo "Practitioner/$id_practitioner"; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><label for="recorder_display"><small>Nama Praktisi</small></label></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="recorder_display" id="recorder_display" class="form-control" value="<?php echo $nama_praktisi; ?>">
    </div>
</div>
<?php
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
            <div class="alert alert-danger mb-0">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI ID
    // =========================================================
    if (empty($_POST['id_general_consent'])) {
        echo '
            <div class="alert alert-danger mb-0">
                <small>ID General Consent tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // SANITASI
    // =========================================================
    $id_general_consent = validateAndSanitizeInput($_POST['id_general_consent']);

    // =========================================================
    // QUERY GENERAL CONSENT
    // =========================================================
    $sql = "
        SELECT 
            gc.*,
            p.nama AS nama_pasien,
            p.nik AS nik_pasien,
            k.id_encounter,
            k.jenis_kunjungan,
            k.datetime_daftar

        FROM general_consent gc

        LEFT JOIN pasien p 
            ON gc.id_pasien = p.id_pasien

        LEFT JOIN kunjungan k 
            ON gc.id_kunjungan = k.id_kunjungan

        WHERE gc.id_general_consent = ?
        LIMIT 1
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_general_consent);
    $stmt->execute();

    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // =========================================================
    // VALIDASI DATA
    // =========================================================
    if (empty($Data)) {
        echo '
            <div class="alert alert-danger mb-0">
                <small>Data General Consent tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // MAPPING DATA
    // =========================================================
    $id_kunjungan         = $Data['id_kunjungan'] ?? '';
    $id_pasien            = $Data['id_pasien'] ?? '';
    $nama_pasien          = $Data['nama_pasien'] ?? '';
    $nik_pasien           = $Data['nik_pasien'] ?? '';
    $jenis_kunjungan      = $Data['jenis_kunjungan'] ?? '';
    $id_encounter         = $Data['id_encounter'] ?? '';

    $metode_consent       = $Data['metode_consent'] ?? '';
    $policy_rule          = $Data['policy_rule'] ?? '';

    $petugas_edukasi_nama = $Data['petugas_edukasi_nama'] ?? '';
    $petugas_edukasi_nik  = $Data['petugas_edukasi_nik'] ?? '';

    $penandatangan_tipe   = $Data['penandatangan_tipe'] ?? '';
    $penandatangan_nama   = $Data['penandatangan_nama'] ?? '';
    $penandatangan_nik    = $Data['penandatangan_nik'] ?? '';

    $datetime_creat       = $Data['datetime_creat'] ?? '';

    // =========================================================
    // FORMAT DATETIME
    // =========================================================
    if (!empty($datetime_creat)) {
        $datetime_creat = date('d/m/Y H:i', strtotime($datetime_creat));
    }

    // CLOSE
    $stmt->close();
?>

<input type="hidden" name="id_general_consent" value="<?php echo $id_general_consent; ?>">

<div class="alert alert-warning border-warning mb-4">
    <small>
        <b>Peringatan!</b><br>
        Data <i>General Consent</i> yang sudah dihapus tidak dapat dikembalikan lagi.
        Pastikan data yang akan dihapus sudah benar.
    </small>
</div>
<hr>
<!-- ===================================================== -->
<!-- INFORMASI PASIEN -->
<!-- ===================================================== -->
<div class="row mb-3">
    <div class="col-12">
        <b>A. Informasi Pasien</b>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>No.RM</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $id_pasien; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Nama Pasien</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $nama_pasien; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>NIK Pasien</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $nik_pasien; ?>
        </small>
    </div>
</div>

<hr>

<!-- ===================================================== -->
<!-- INFORMASI KUNJUNGAN -->
<!-- ===================================================== -->
<div class="row mb-3">
    <div class="col-12">
        <b>B. Informasi Kunjungan</b>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>No.REG</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $id_kunjungan; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Jenis Kunjungan</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $jenis_kunjungan; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>ID Encounter</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $id_encounter; ?>
        </small>
    </div>
</div>

<hr>

<!-- ===================================================== -->
<!-- GENERAL CONSENT -->
<!-- ===================================================== -->
<div class="row mb-3">
    <div class="col-12">
        <b>C. General Consent</b>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Tanggal Dibuat</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $datetime_creat; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Metode Consent</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $metode_consent; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Policy Rule</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <?php
            if ($policy_rule == 'opt-in') {
                echo '<span class="badge bg-success">OPT-IN</span>';
            } else {
                echo '<span class="badge bg-danger">OPT-OUT</span>';
            }
        ?>
    </div>
</div>

<hr>

<!-- ===================================================== -->
<!-- PETUGAS -->
<!-- ===================================================== -->
<div class="row mb-3">
    <div class="col-12">
        <b>D. Petugas Edukasi</b>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Nama Petugas</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $petugas_edukasi_nama; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>NIK Petugas</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $petugas_edukasi_nik; ?>
        </small>
    </div>
</div>

<hr>

<!-- ===================================================== -->
<!-- PENANDATANGAN -->
<!-- ===================================================== -->
<div class="row mb-3">
    <div class="col-12">
        <b>E. Penanggung Jawab</b>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Tipe</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $penandatangan_tipe; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <small>Nama Lengkap</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $penandatangan_nama; ?>
        </small>
    </div>
</div>

<div class="row mb-0">
    <div class="col-4">
        <small>NIK / KTP</small>
    </div>
    <div class="col-1">
        <small>:</small>
    </div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $penandatangan_nik; ?>
        </small>
    </div>
</div>
<script>
    $('#ButtonHapusGeneralConsent').prop('disabled', false);
</script>
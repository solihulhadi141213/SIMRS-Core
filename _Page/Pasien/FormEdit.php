<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi ID Pasien
    if (empty($_POST['id_pasien'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Pasien tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi
    $id_pasien = validateAndSanitizeInput($_POST['id_pasien']);

    // Query Pasien
    $query = "
        SELECT * 
        FROM pasien 
        WHERE id_pasien = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);

    // Debug Prepare
    if (!$stmt) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal prepare query : '.mysqli_error($Conn).'</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_pasien);

    // Debug Execute
    if (!mysqli_stmt_execute($stmt)) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal execute query : '.mysqli_stmt_error($stmt).'</small>
            </div>
        ';
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);

    // Validasi Data
    if (mysqli_num_rows($result) == 0) {
        echo '
            <div class="alert alert-danger">
                <small>Data pasien tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Fetch
    $row = mysqli_fetch_assoc($result);

    // Escape Output
    function safe($value){
        return htmlspecialchars($value ?? '');
    }

    // Variable
    $id_ihs         = safe($row['id_ihs']);
    $nik            = safe($row['nik']);
    $no_bpjs        = safe($row['no_bpjs']);
    $nama           = safe($row['nama']);
    $gender         = safe($row['gender']);
    $tempat_lahir   = safe($row['tempat_lahir']);
    $tanggal_lahir  = safe($row['tanggal_lahir']);
    $province       = safe($row['province']);
    $regency        = safe($row['regency']);
    $subdistrict    = safe($row['subdistrict']);
    $village        = safe($row['village']);
    $street         = safe($row['street']);
    $postal_code    = safe($row['postal_code']);
    $kontak         = safe($row['kontak']);
    $golongan_darah = safe($row['golongan_darah']);
    $pernikahan     = safe($row['pernikahan']);
    $pekerjaan      = safe($row['pekerjaan']);

?>

<input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">

<!-- IDENTITAS -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>A. Nomor Identitas</b></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="edit_nik"><small>NIK (KTP)</small></label>
        <input type="text" name="nik" id="edit_nik" class="form-control" value="<?php echo $nik; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="edit_id_ihs"><small>ID IHS (SATUSEHAT)</small></label>
        <input type="text" name="id_ihs" id="edit_id_ihs" class="form-control" value="<?php echo $id_ihs; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="edit_no_bpjs"><small>No.BPJS</small></label>
        <input type="text" name="no_bpjs" id="edit_no_bpjs" class="form-control" value="<?php echo $no_bpjs; ?>">
    </div>
</div>

<hr>

<!-- INFORMASI UTAMA -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>B. Informasi Utama</b></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="edit_nama"><small>* Nama Lengkap</small></label>
        <input type="text" name="nama" id="edit_nama" class="form-control" value="<?php echo $nama; ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="edit_gender"><small>* Gender</small></label>
        <select name="gender" id="edit_gender" class="form-control" required>
            <option value="">Pilih</option>
            <option value="Laki-laki" <?php if($gender=='Laki-laki'){ echo 'selected'; } ?>>Laki-laki</option>
            <option value="Perempuan" <?php if($gender=='Perempuan'){ echo 'selected'; } ?>>Perempuan</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="edit_tempat_lahir"><small>Tempat Lahir</small></label>
        <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="form-control" value="<?php echo $tempat_lahir; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="edit_tanggal_lahir"><small>Tanggal Lahir</small></label>
        <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control" value="<?php echo $tanggal_lahir; ?>">
    </div>
</div>

<hr>

<!-- ALAMAT -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>C. Alamat Tempat Tinggal</b></small>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="edit_province"><small>Provinsi</small></label>
        <input type="text" name="province" id="edit_province" class="form-control" value="<?php echo $province; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="edit_regency"><small>Kabupaten/Kota</small></label>
        <input type="text" name="regency" id="edit_regency" class="form-control" value="<?php echo $regency; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="edit_subdistrict"><small>Kecamatan</small></label>
        <input type="text" name="subdistrict" id="edit_subdistrict" class="form-control" value="<?php echo $subdistrict; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="edit_village"><small>Desa/Kelurahan</small></label>
        <input type="text" name="village" id="edit_village" class="form-control" value="<?php echo $village; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label for="edit_street"><small>Jalan, Nomor Rumah, RT/RW</small></label>
        <input type="text" name="street" id="edit_street" class="form-control" value="<?php echo $street; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="edit_postal_code"><small>Kode POS</small></label>
        <input type="text" name="postal_code" id="edit_postal_code" class="form-control" value="<?php echo $postal_code; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="edit_kontak"><small>Nomor Kontak</small></label>
        <input type="text" name="kontak" id="edit_kontak" class="form-control" value="<?php echo $kontak; ?>">
    </div>
</div>

<hr>

<!-- INFORMASI PENDUKUNG -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>D. Informasi Pendukung</b></small>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label for="edit_golongan_darah"><small>Golongan Darah</small></label>

        <select name="golongan_darah" id="edit_golongan_darah" class="form-control">
            <option value="">Pilih</option>
            <option value="A" <?php if($golongan_darah=='A'){ echo 'selected'; } ?>>A</option>
            <option value="B" <?php if($golongan_darah=='B'){ echo 'selected'; } ?>>B</option>
            <option value="AB" <?php if($golongan_darah=='AB'){ echo 'selected'; } ?>>AB</option>
            <option value="O" <?php if($golongan_darah=='O'){ echo 'selected'; } ?>>O</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label for="edit_pernikahan"><small>Status Pernikahan</small></label>

        <select name="pernikahan" id="edit_pernikahan" class="form-control">
            <option value="">Pilih</option>
            <option value="Lajang" <?php if($pernikahan=='Lajang'){ echo 'selected'; } ?>>Belum Menikah</option>
            <option value="Menikah" <?php if($pernikahan=='Menikah'){ echo 'selected'; } ?>>Menikah</option>
            <option value="Janda" <?php if($pernikahan=='Janda'){ echo 'selected'; } ?>>Janda</option>
            <option value="Duda" <?php if($pernikahan=='Duda'){ echo 'selected'; } ?>>Duda</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label for="edit_pekerjaan"><small>Pekerjaan</small></label>

        <select name="pekerjaan" id="edit_pekerjaan" class="form-control">
            <option value="">Pilih</option>
            <option value="Tidak Bekerja" <?php if($pekerjaan=='Tidak Bekerja'){ echo 'selected'; } ?>>Tidak Bekerja</option>
            <option value="Karyawan Swasta" <?php if($pekerjaan=='Karyawan Swasta'){ echo 'selected'; } ?>>Karyawan Swasta</option>
            <option value="Wirausaha" <?php if($pekerjaan=='Wirausaha'){ echo 'selected'; } ?>>Wirausaha</option>
            <option value="PNS" <?php if($pekerjaan=='PNS'){ echo 'selected'; } ?>>ASN TNI/POLRI</option>
        </select>
    </div>
</div>

<script>
    // Enable Button Edit
    $('#ButtonEdit').prop('disabled', false);

    // Autofocus
    setTimeout(function () {
        $('#edit_nik').focus();
    }, 300);
</script>

<?php
    mysqli_stmt_close($stmt);
?>
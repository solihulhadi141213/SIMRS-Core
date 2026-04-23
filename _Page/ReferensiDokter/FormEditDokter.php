<?php
include "../../_Config/Connection.php";

if (empty($_POST['id_dokter'])) {
    echo '<div class="alert alert-danger">ID tidak valid</div>';
    exit;
}

$id_dokter = $_POST['id_dokter'];

$stmt = mysqli_prepare($Conn, "SELECT * FROM dokter WHERE id_dokter=?");
mysqli_stmt_bind_param($stmt, "i", $id_dokter);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
    exit;
}

$d = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// helper
function val($v){
    return (!empty($v)) ? htmlspecialchars($v) : '';
}

// foto
$foto = "assets/images/no-image.png";
if (!empty($d['foto']) && file_exists("../../assets/images/Dokter/".$d['foto'])) {
    $foto = "assets/images/Dokter/".$d['foto'];
}
?>

<input type="hidden" name="id_dokter" value="<?php echo $d['id_dokter']; ?>">

<!-- Nama -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Nama Dokter</small></label>
        <input type="text" name="nama" class="form-control" value="<?php echo val($d['nama']); ?>" required>
    </div>
</div>

<!-- Kode -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Kode Dokter</small></label>
        <select name="kode" id="edit_kode" class="form-control" required></select>
    </div>
</div>

<!-- Gender -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Jenis Kelamin</small></label>
        <select name="gender" class="form-control" required>
            <option value="">Pilih</option>
            <option value="Laki-laki" <?php if($d['gender']=='Laki-laki') echo 'selected'; ?>>Laki-laki</option>
            <option value="Perempuan" <?php if($d['gender']=='Perempuan') echo 'selected'; ?>>Perempuan</option>
        </select>
    </div>
</div>

<!-- Tanggal -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Tanggal Lahir</small></label>
        <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo val($d['tanggal_lahir']); ?>">
    </div>
</div>

<!-- Kategori -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Kategori Spesialistik</small></label>
        <select name="kategori" id="edit_kategori" class="form-control" required></select>
    </div>
</div>

<!-- Identitas -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Identitas (NIK)</small></label>
        <input type="text" name="no_identitas" id="edit_no_identitas" class="form-control" value="<?php echo val($d['no_identitas']); ?>" required>
    </div>
</div>

<!-- IHS -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>ID Practitioner</small></label>
        <div class="input-group">
            <input type="text" name="id_ihs_practitioner" id="edit_id_ihs" class="form-control" value="<?php echo val($d['id_ihs_practitioner']); ?>">
            <button type="button" class="input-group-text modal_cari_practitioner_edit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
</div>

<!-- Alamat -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Alamat</small></label>
        <textarea name="alamat" class="form-control"><?php echo val($d['alamat']); ?></textarea>
    </div>
</div>

<!-- Kontak -->
<div class="row mb-3">
    <div class="col-md-12">
        <label><small>Nomor Kontak</small></label>
        <input type="text" name="kontak" class="form-control" value="<?php echo val($d['kontak']); ?>">
    </div>
</div>

<!-- Kontak -->
<div class="row mb-3">
    <div class="col-md-12">
        <label><small>Alamat Email</small></label>
        <input type="email" name="email" class="form-control" value="<?php echo val($d['email']); ?>">
    </div>
</div>

<!-- SIP -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>SIP</small></label>
        <input type="text" name="SIP" class="form-control" value="<?php echo val($d['SIP']); ?>">
    </div>
</div>

<!-- FOTO -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Foto</small></label>
        <input type="file" name="foto" class="form-control mt-2">
        <small class="text text-muted">
            Foto Maksimal 2 Mb (File Type : JPG, JPEG, PNG dan GIF)
        </small>
    </div>
</div>

<!-- STATUS -->
<div class="row mb-3">
    <div class="col-12">
        <input type="checkbox" name="status" id="status_edit" value="1" <?php if($d['status']==1) echo 'checked'; ?>>
        <label for="status_edit"><small>Status Dokter Aktif</small></label>
    </div>
</div>




<!-- SIMPAN DATA LAMA UNTUK SELECT2 -->
<input type="hidden" id="old_kode" value="<?php echo val($d['kode']); ?>">
<input type="hidden" id="old_kategori" value="<?php echo val($d['kategori']); ?>">
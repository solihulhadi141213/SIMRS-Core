<?php
// Koneksi & Session
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

// ===================== VALIDASI SESSION =====================
if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger text-center"><small>Sesi akses berakhir!</small></div>';
    exit;
}

// ===================== VALIDASI INPUT =====================
if (empty($_POST['id_icd'])) {
    echo '<div class="alert alert-danger text-center"><small>ID ICD tidak valid!</small></div>';
    exit;
}

$id_icd = (int) $_POST['id_icd'];

// ===================== AMBIL DATA =====================
$sql = "SELECT * FROM icd WHERE id_icd = ? LIMIT 1";
$stmt = mysqli_prepare($Conn, $sql);

if (!$stmt) {
    echo '<div class="alert alert-danger text-center"><small>Gagal memproses data!</small></div>';
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id_icd);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-danger text-center"><small>Data tidak ditemukan!</small></div>';
    exit;
}

$data = mysqli_fetch_assoc($result);

// ===================== AMBIL DATA FIELD =====================
$kode      = htmlspecialchars($data['kode']);
$short_des = htmlspecialchars($data['short_des']);
$long_des  = htmlspecialchars($data['long_des']);
$icd       = htmlspecialchars($data['icd']);

mysqli_stmt_close($stmt);

// ===================== OUTPUT FORM =====================
?>

<input type="hidden" name="id_icd" value="<?php echo $id_icd; ?>">

<!-- Versi ICD -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>ICD / Version</small></label>
        <input type="text" readonly name="icd" class="form-control" value="<?php echo $icd; ?>">
    </div>
</div>

<!-- Kode -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Kode ICD</small></label>
        <input type="text" name="kode" class="form-control" value="<?php echo $kode; ?>" required>
    </div>
</div>

<!-- Short Description -->
<div class="row mb-3">
    <div class="col-12">
        <label><small><i>Short Description</i></small></label>
        <input type="text" name="short_des" class="form-control" value="<?php echo $short_des; ?>" required>
    </div>
</div>

<!-- Long Description -->
<div class="row mb-3">
    <div class="col-12">
        <label><small><i>Long Description</i></small></label>
        <textarea name="long_des" class="form-control" required><?php echo $long_des; ?></textarea>
    </div>
</div>
<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir, silahkan login ulang.</small></div>';
        exit;
    }

    $id_imunisasi = validateAndSanitizeInput($_POST['id_imunisasi'] ?? '');
    if (empty($id_imunisasi) || !is_numeric($id_imunisasi)) {
        echo '<div class="alert alert-danger"><small>ID imunisasi tidak valid.</small></div>';
        exit;
    }

    $query = "
        SELECT i.*, p.nama AS nama_pasien, r.nama_vaksin AS ref_nama_vaksin
        FROM imunisasi i
        LEFT JOIN pasien p ON i.id_pasien = p.id_pasien
        LEFT JOIN imunisasi_referensi r ON i.id_imunisasi_referensi = r.id_imunisasi_referensi
        WHERE i.id_imunisasi = ?
        LIMIT 1
    ";
    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id_imunisasi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data imunisasi tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $id_immunization   = html_entity_decode($data['id_immunization'] ?? '', ENT_QUOTES, 'UTF-8');
    $nama_pasien       = html_entity_decode($data['nama_pasien'] ?? '', ENT_QUOTES, 'UTF-8');
    $id_pasien         = $data['id_pasien'] ?? '';
    $tanggal_pemberian = !empty($data['tanggal_pemberian']) ? date('d/m/Y', strtotime((string)$data['tanggal_pemberian'])) : '-';
    $nama_vaksin       = html_entity_decode($data['ref_nama_vaksin'] ?? '', ENT_QUOTES, 'UTF-8');
    $status            = html_entity_decode($data['status_imunisasi'] ?? '', ENT_QUOTES, 'UTF-8');
    $dosis_ke          = $data['dosis_ke'] ?? '';
    $body_site_nama    = html_entity_decode($data['body_site_nama'] ?? '', ENT_QUOTES, 'UTF-8');

    $escape = static function ($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    };
?>
<input type="hidden" name="id_imunisasi" value="<?php echo $escape($id_imunisasi); ?>">

<div class="row mb-2">
    <div class="col-4"><small>ID Immunization</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($id_immunization); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>No. RM</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($id_pasien); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Pasien</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($nama_pasien); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal Pemberian</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($tanggal_pemberian); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Vaksin</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($nama_vaksin); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Dosis Ke</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($dosis_ke); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Lokasi Tubuh</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($body_site_nama); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $escape($status); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-12 text-center">
        <div class="alert alert-warning">
            <small>
                <b>PENTING!</b><br>
                Menghapus data imunisasi mungkin akan menyebabkan riwayat pemberian vaksin pasien tidak terdefinisikan.<br>
                <i>Apakah anda yakin akan menghapus data ini?</i>
            </small>
        </div>
    </div>
</div>
<?php
?>


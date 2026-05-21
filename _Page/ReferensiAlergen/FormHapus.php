<?php
    // Error reporting
    error_reporting(0);
    ini_set('display_errors', 0);

    // Load config
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir, silahkan login ulang.</small></div>';
        exit;
    }

    // Tangkap ID
    $id_alergi_alergen = validateAndSanitizeInput($_POST['id_alergi_alergen'] ?? '');

    // Validasi ID
    if (empty($id_alergi_alergen) || !is_numeric($id_alergi_alergen)) {
        echo '<div class="alert alert-danger"><small>ID alergen tidak valid.</small></div>';
        exit;
    }

    // Query data
    $query = "SELECT * FROM alergi_alergen WHERE id_alergi_alergen = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);

    // Validasi query
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan query.</small></div>';
        exit;
    }

    // Bind
    mysqli_stmt_bind_param($stmt, "i", $id_alergi_alergen);

    // Execute
    mysqli_stmt_execute($stmt);

    // Result
    $result = mysqli_stmt_get_result($stmt);

    // Validasi data
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger"><small>Data alergen tidak ditemukan.</small></div>';
        mysqli_stmt_close($stmt);
        exit;
    }

    // Fetch data
    $data = mysqli_fetch_assoc($result);

    // Close
    mysqli_stmt_close($stmt);

    // Data
    $kategori_alergen = $data['kategori_alergen'] ?? '';
    $nama_alergen     = html_entity_decode($data['nama_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $code_alergen     = html_entity_decode($data['code_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $display_alergen  = html_entity_decode($data['display_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $system_alergen   = html_entity_decode($data['system_alergen'] ?? '', ENT_QUOTES, 'UTF-8');
    $author_name      = html_entity_decode($data['author_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $datetime_creat   = html_entity_decode($data['datetime_creat'] ?? '', ENT_QUOTES, 'UTF-8');
    $status           = $data['status'] ?? '1';

    // Routing Status
    if($status==0){
        $label_status = '<span class="text-danger">Deleted</span>';
    }else{
        $label_status = '<span class="text-success">Active</span>';
    }
?>

<input type="hidden" name="id_alergi_alergen" value="<?php echo $id_alergi_alergen; ?>">

<div class="row mb-2">
    <div class="col-4"><small>Kategori Alergen</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $kategori_alergen; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Alergen</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $nama_alergen; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode Alergen (<i>Code</i>)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $code_alergen; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Deskripsi (<i>Display</i>)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $display_alergen; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Referensi (<i>System</i>)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $system_alergen; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Author</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $author_name; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Datetime</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $datetime_creat; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Status</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $label_status; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-12 text-center">
        <div class="alert alert-warning">
            <small>
                <b>PENTING!</b><br>
                Menghapus referensi alergen mungkin akan menyebabkan data riwayat alergi pasien tidak akan terdefinisikan.<br>
                <i>Apakah anda yakin akan menghapus data ini?</i>
            </small>
        </div>
    </div>
</div>
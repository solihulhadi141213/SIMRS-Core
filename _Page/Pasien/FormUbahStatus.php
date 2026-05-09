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

    // Variable
    $status = $row['status'];

    // Helper Empty Value
    function showValue($value){
        return (!empty($value)) ? htmlspecialchars($value) : '-';
    }

    // Format Tanggal Lahir
    $tanggal_lahir = '-';
    if (!empty($row['tanggal_lahir']) && $row['tanggal_lahir'] != '0000-00-00') {
        $tanggal_lahir = date('d/m/Y', strtotime($row['tanggal_lahir']));
    }

    // Format Datetime
    $registered_at = '-';
    if (!empty($row['registered_at'])) {
        $registered_at = date('d/m/Y H:i', strtotime($row['registered_at']));
    }

    $updated_at = '-';
    if (!empty($row['updated_at'])) {
        $updated_at = date('d/m/Y H:i', strtotime($row['updated_at']));
    }

    // Alamat Lengkap
    $alamat = trim(
        showValue($row['street']).', '.
        showValue($row['village']).', '.
        showValue($row['subdistrict']).', '.
        showValue($row['regency']).', '.
        showValue($row['province']).' '.
        showValue($row['postal_code'])
    );

    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Nomor RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['id_pasien']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['nama']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>ID IHS SATUSEHAT</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['id_ihs']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>NIK / No. KTP</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['nik']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>No. BPJS</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['no_bpjs']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Jenis Kelamin</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['gender']).'</small></div>
        </div>

        <hr>

        <div class="row mb-2">
            <div class="col-4"><small>Petugas Pendaftaran</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['petugas_pendaftaran']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Terdaftar Sejak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$registered_at.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Terakhir Update</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$updated_at.'</small></div>
        </div>
    ';
    $status = $row['status'];
    if($status=="Active"){
        $status_1 = "checked";
        $status_2 = "";
        $status_3 = "";
    }else{
        if($status=="Inactive"){
            $status_1 = "";
            $status_2 = "checked";
            $status_3 = "";
        }else{
             if($status=="Deceased"){
                $status_1 = "";
                $status_2 = "";
                $status_3 = "checked";
            }else{
                $status_1 = "";
                $status_2 = "";
                $status_3 = "";
            }
        }
    }
?>

<input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
<hr>
<div class="row mt-3">
    <div class="col-4">
        <label for="status_pasien">
            <small>Status Pasien</small>
        </label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_pasien" id="status_pasien_1" value="Active" <?php echo $status_1; ?> >
            <label class="form-check-label" for="status_pasien_1">
                <small class="text-muted">Active</small>
            </label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_pasien" id="status_pasien_2" value="Inactive" <?php echo $status_2; ?> >
            <label class="form-check-label" for="status_pasien_2">
                <small class="text-muted">Inactive</small>
            </label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_pasien" id="status_pasien_3" value="Deceased" <?php echo $status_3; ?> >
            <label class="form-check-label" for="status_pasien_3">
                <small class="text-muted">Deceased (Meninggal)</small>
            </label>
        </div>
    </div>
</div>

<?php
    mysqli_stmt_close($stmt);
?>
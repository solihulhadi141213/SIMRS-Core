<?php
    // ======================================================
    // TIME ZONE
    // ======================================================
    date_default_timezone_set('Asia/Jakarta');

    // ======================================================
    // CONNECTION, FUNCTION & SESSION
    // ======================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ======================================================
    // VALIDASI SESSION
    // ======================================================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    // ======================================================
    // VALIDASI METHOD
    // ======================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid.</small>
            </div>
        ';
        exit;
    }

    // ======================================================
    // VALIDASI ID WILAYAH
    // ======================================================
    if (empty($_POST['id_wilayah'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Wilayah tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    // ======================================================
    // SANITIZE INPUT
    // ======================================================
    $id_wilayah = (int) validateAndSanitizeInput($_POST['id_wilayah']);

    // ======================================================
    // AMBIL DATA WILAYAH
    // ======================================================
    $query = "
        SELECT * FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal menyiapkan query database.</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_wilayah);

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal mengeksekusi query database.</small>
            </div>
        ';
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {

        mysqli_stmt_close($stmt);

        echo '
            <div class="alert alert-warning text-center">
                <small>Data wilayah tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    // ======================================================
    // VARIABLE DATA
    // ======================================================
    $subdistrict     = htmlspecialchars($data['subdistrict'] ?? '');
    $kode_mendagri_3 = htmlspecialchars($data['kode_mendagri_3'] ?? '');
?>

<input type="hidden" name="id_wilayah" value="<?php echo $id_wilayah; ?>">



<div class="row mb-3">
    <div class="col-md-12">
        <label for="subdistrict_edit">
            <small>Nama Kecamatan</small>
        </label>

        <input 
            type      = "text"
            name      = "subdistrict"
            id        = "subdistrict_edit"
            class     = "form-control"
            value     = "<?php echo $subdistrict; ?>"
            maxlength = "255"
            required
        >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="kode_mendagri_3_edit">
            <small>Kode Kecamatan (Mendagri)</small>
        </label>

        <input 
            type      = "text"
            name      = "kode_mendagri_3"
            id        = "kode_mendagri_3_edit"
            class     = "form-control"
            value     = "<?php echo $kode_mendagri_3; ?>"
            maxlength = "255"
        >
    </div>
</div>
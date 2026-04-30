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
    // VALIDASI INPUT
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
    // QUERY DATA
    // ======================================================
    $query = "
        SELECT 
            province,
            kode_mendagri_1
        FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal mempersiapkan query database.</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_wilayah);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {

        mysqli_stmt_close($stmt);

        echo '
            <div class="alert alert-warning text-center">
                <small>Data tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    $province         = htmlspecialchars($data['province'] ?? '');
    $kode_mendagri_1  = htmlspecialchars($data['kode_mendagri_1'] ?? '');
?>

<input type="hidden" name="id_wilayah" value="<?php echo $id_wilayah; ?>">

<div class="row mb-3">
    <div class="col-md-12">
        <label for="province_edit">
            <small>Nama Provinsi</small>
        </label>

        <input 
            type      = "text"
            name      = "province"
            id        = "province_edit"
            class     = "form-control"
            value     = "<?php echo $province; ?>"
            maxlength = "255"
            required
        >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="kode_mendagri_1_edit">
            <small>Kode Provinsi (Mendagri)</small>
        </label>

        <input 
            type      = "text"
            name      = "kode_mendagri_1"
            id        = "kode_mendagri_1_edit"
            class     = "form-control"
            value     = "<?php echo $kode_mendagri_1; ?>"
            maxlength = "255"
        >
    </div>
</div>
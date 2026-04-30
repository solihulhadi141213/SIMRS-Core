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
    $regency         = htmlspecialchars($data['regency'] ?? '');
    $tipe_level2     = htmlspecialchars($data['tipe_level2'] ?? '');
    $kode_mendagri_2 = htmlspecialchars($data['kode_mendagri_2'] ?? '');
?>

<input type="hidden" name="id_wilayah" value="<?php echo $id_wilayah; ?>">


<div class="row mb-3">
    <div class="col-md-12">
        <label for="tipe_level2_edit">
            <small>Tipe Kabupaten / Kota</small>
        </label>

        <select 
            name="tipe_level2" 
            id="tipe_level2_edit" 
            class="form-control"
            required
        >
            <option value="">-- Pilih --</option>

            <option value="Kabupaten" <?php echo ($tipe_level2 == 'Kabupaten') ? 'selected' : ''; ?>>
                Kabupaten
            </option>

            <option value="Kota" <?php echo ($tipe_level2 == 'Kota') ? 'selected' : ''; ?>>
                Kota
            </option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="regency_edit">
            <small>Nama Kabupaten/Kota</small>
        </label>

        <input 
            type      = "text"
            name      = "regency"
            id        = "regency_edit"
            class     = "form-control"
            value     = "<?php echo $regency; ?>"
            maxlength = "255"
            required
        >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="kode_mendagri_2_edit">
            <small>Kode Kecamatan (Mendagri)</small>
        </label>

        <input 
            type      = "text"
            name      = "kode_mendagri_2"
            id        = "kode_mendagri_2_edit"
            class     = "form-control"
            value     = "<?php echo $kode_mendagri_2; ?>"
            maxlength = "255"
        >
    </div>
</div>
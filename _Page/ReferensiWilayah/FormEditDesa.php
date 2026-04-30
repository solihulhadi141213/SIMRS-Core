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
        SELECT 
            id_wilayah,
            tipe_level4,
            village,
            kode_mendagri_4
        FROM wilayah
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
    $tipe_level4     = htmlspecialchars($data['tipe_level4'] ?? '');
    $village         = htmlspecialchars($data['village'] ?? '');
    $kode_mendagri_4 = htmlspecialchars($data['kode_mendagri_4'] ?? '');

?>

<input type="hidden" name="id_wilayah" value="<?php echo $id_wilayah; ?>">

<div class="row mb-3">
    <div class="col-md-12">
        <label for="tipe_level4_edit">
            <small>Tipe Desa / Kelurahan</small>
        </label>

        <select 
            name="tipe_level4" 
            id="tipe_level4_edit" 
            class="form-control"
            required
        >
            <option value="">-- Pilih --</option>

            <option value="Desa" <?php echo ($tipe_level4 == 'Desa') ? 'selected' : ''; ?>>
                Desa
            </option>

            <option value="Kelurahan" <?php echo ($tipe_level4 == 'Kelurahan') ? 'selected' : ''; ?>>
                Kelurahan
            </option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="village_edit">
            <small>Nama Desa / Kelurahan</small>
        </label>

        <input 
            type      = "text"
            name      = "village"
            id        = "village_edit"
            class     = "form-control"
            value     = "<?php echo $village; ?>"
            maxlength = "255"
            required
        >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="kode_mendagri_4_edit">
            <small>Kode Desa / Kelurahan (Mendagri)</small>
        </label>

        <input 
            type      = "text"
            name      = "kode_mendagri_4"
            id        = "kode_mendagri_4_edit"
            class     = "form-control"
            value     = "<?php echo $kode_mendagri_4; ?>"
            maxlength = "255"
        >
    </div>
</div>
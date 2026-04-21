<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid.</small>
            </div>
        ';
        exit;
    }

    if (empty($_POST['id_poliklinik'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID poliklinik tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    $id_poliklinik = (int) $_POST['id_poliklinik'];

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT * FROM poliklinik WHERE id_poliklinik = ?"
    );

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal menyiapkan query data.</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_poliklinik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-warning text-center">
                <small>Data poliklinik tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $poliklinik   = htmlspecialchars($data['poliklinik'] ?? '', ENT_QUOTES, 'UTF-8');
    $kode         = htmlspecialchars($data['kode'] ?? '', ENT_QUOTES, 'UTF-8');
    $check_status = !empty($data['status']) ? 'checked' : '';
?>
    <input type="hidden" name="id_poliklinik" value="<?php echo $id_poliklinik; ?>">

    <div class="row mb-3">
        <div class="col-12">
            <label for="poliklinik_edit"><small>Nama Poliklinik</small></label>
            <input
                type="text"
                name="poliklinik"
                id="poliklinik_edit"
                class="form-control"
                placeholder="Contoh : Penyakit Dalam"
                value="<?php echo $poliklinik; ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="kode_edit"><small>Kode Poli</small></label>
            <select name="kode" id="kode_edit" class="form-control" required>
                <?php if (!empty($kode)) { ?>
                    <option value="<?php echo $kode; ?>" selected><?php echo $kode; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="form-check mb-2">
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="status_edit"
                    name="status"
                    value="1"
                    <?php echo $check_status; ?>
                >
                <label class="form-check-label" for="status_edit">
                    <small>Status Poliklinik Aktif</small>
                </label>
            </div>
        </div>
    </div>

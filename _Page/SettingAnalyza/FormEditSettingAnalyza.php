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

    if (empty($_POST['id_setting_analyza'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID setting Analyza tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    $id_setting_analyza = (int) $_POST['id_setting_analyza'];

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT * FROM setting_analyza WHERE id_setting_analyza = ?"
    );

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal menyiapkan query data.</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_analyza);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-warning text-center">
                <small>Data setting Analyza tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    $setting_name = htmlspecialchars($data['setting_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $base_url     = htmlspecialchars($data['base_url'] ?? '', ENT_QUOTES, 'UTF-8');
    $username     = htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8');
    $password     = htmlspecialchars($data['password'] ?? '', ENT_QUOTES, 'UTF-8');
    $check_status = !empty($data['status']) ? 'checked' : '';
?>
    <input type="hidden" name="id_setting_analyza" value="<?php echo $id_setting_analyza; ?>">

    <div class="row mb-3">
        <div class="col-12">
            <label for="nama_setting_analyza_edit"><small>Profil Pengaturan</small></label>
            <input
                type="text"
                name="nama_setting_analyza"
                id="nama_setting_analyza_edit"
                class="form-control"
                placeholder="Contoh : Development"
                value="<?php echo $setting_name; ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="url_analyza_edit"><small><i>URL (ENDPOINT)</i></small></label>
            <input
                type="url"
                name="url_analyza"
                id="url_analyza_edit"
                class="form-control"
                value="<?php echo $base_url; ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="username_edit"><small><i>Username</i></small></label>
            <input
                type="text"
                name="username"
                id="username_edit"
                class="form-control"
                value="<?php echo $username; ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="password_edit"><small><i>Password</i></small></label>
            <input
                type="text"
                name="password"
                id="password_edit"
                class="form-control"
                value="<?php echo $password; ?>"
                required
            >
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
                    <small>Aktifkan Profil Pengaturan Ini</small>
                </label>
            </div>
        </div>
    </div>
<?php
    mysqli_stmt_close($stmt);
?>

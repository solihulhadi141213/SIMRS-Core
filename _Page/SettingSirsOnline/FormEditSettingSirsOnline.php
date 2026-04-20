<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_setting_sirs_online'])) {
        echo '<div class="alert alert-danger">ID Setting Satu Sehat tidak boleh kosong.</div>';
        exit;
    }

    $id_setting_sirs_online = (int) $_POST['id_setting_sirs_online'];

    // Ambil data detail
    $query = "SELECT * FROM setting_sirs_online WHERE id_setting_sirs_online = ?";
    $stmt  = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_sirs_online);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-warning">Data Setting Satu Sehat tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    // Buat variabel
    $nama_setting_sirs_online = $data['nama_setting_sirs_online'] ?? '';
    $url_sirs_online          = $data['url_sirs_online'] ?? '';
    $id_rs                    = $data['id_rs'] ?? '';
    $password_sirs_online     = $data['password_sirs_online'] ?? '';

    // Routing Status
    if(empty($data['status'])){
        $check_status = "";
    }else{
        $check_status = "checked";
    }

?>
    <input type="hidden" name="id_setting_sirs_online" value="<?php echo $id_setting_sirs_online; ?>">
    <div class="row mb-3">
        <div class="col-12">
            <label for="nama_setting_sirs_online_edit"><small>Profil Pengaturan</small></label>
            <input type="text" name="nama_setting_sirs_online" id="nama_setting_sirs_online_edit" class="form-control" placeholder="Contoh : Development" value="<?php echo $nama_setting_sirs_online; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <label for="url_sirs_online_edit"><small><i>URL (ENDPOINT)</i></small></label>
            <input type="url" name="url_sirs_online" id="url_sirs_online_edit" class="form-control" value="<?php echo $url_sirs_online; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <label for="id_rs_edit"><small>ID Rumah Sakit</small></label>
            <input type="text" name="id_rs" id="id_rs_edit" class="form-control" value="<?php echo $id_rs; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <label for="password_sirs_online_edit"><small><i>Password</i></small></label>
            <input type="text" name="password_sirs_online" id="password_sirs_online_edit" class="form-control" value="<?php echo $password_sirs_online; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="status_edit" name="status" value="1" <?php echo $check_status; ?> >
                <label class="form-check-label" for="status_edit">
                    <small>Aktifkan Profil Pengaturan Ini</small>
                </label>
            </div>
        </div>
    </div>
<?php
    mysqli_stmt_close($stmt);
?>
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

    // Status badge
    $status_badge = ($data['status'] == 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';

?>
    <input type="hidden" name="id_setting_sirs_online" value="<?php echo $id_setting_sirs_online; ?>">
    <div class="row mb-2">
        <div class="col-4"><small>ID</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $data['id_setting_sirs_online']; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Profil Pengaturan</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($data['nama_setting_sirs_online']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>URL (Endpoint)</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($data['url_sirs_online']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>ID Rumah Sakit</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($data['id_rs']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Password</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($data['password_sirs_online']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $status_badge; ?></div>
    </div>
    <div class="row mb-2 mt-4">
        <div class="col-12">
            <div class="alert alert-danger text-center">
                <b>PENTING!</b><br>
                <small>
                    Menghapus Pengaturan Ini Mungkin Akan Menyebabkan Sistem Tidak Dapat Terhubung Dengan SIRS Online.<br>
                    <b>Apakah Anda Yakin Akan Tetap Menghapus Data Ini?</b>
                </small>
            </div>
        </div>
    </div>
<?php
    mysqli_stmt_close($stmt);
?>
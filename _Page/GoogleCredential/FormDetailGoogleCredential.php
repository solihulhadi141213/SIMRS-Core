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
    if (empty($_POST['id_setting_google'])) {
        echo '<div class="alert alert-danger">ID Google Credential tidak boleh kosong.</div>';
        exit;
    }

    $id_setting_google = (int) $_POST['id_setting_google'];

    // Ambil data detail
    $query = "SELECT * FROM setting_google WHERE id_setting_google = ?";
    $stmt  = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_google);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-warning">Data Google Credential tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    // Status badge
    $status_badge = ($data['status'] == 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';

    // Masking client secret
    $masked_secret = str_repeat('*', max(strlen($data['client_secret']) - 4, 8)) .
                     substr($data['client_secret'], -4);

?>
    <div class="row mb-2">
        <div class="col-4"><small>ID</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $data['id_setting_google']; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Nama Kredensial</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($data['credential_env']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Client ID</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($data['client_id']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Client Secret</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($masked_secret); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $status_badge; ?></div>
    </div>
<?php
    mysqli_stmt_close($stmt);
?>
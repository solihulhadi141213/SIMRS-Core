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
    if (empty($_POST['id_setting_satusehat'])) {
        echo '<div class="alert alert-danger">ID Setting Satu Sehat tidak boleh kosong.</div>';
        exit;
    }

    $id_setting_satusehat = (int) $_POST['id_setting_satusehat'];

    // Ambil data detail
    $query = "SELECT * FROM setting_satusehat WHERE id_setting_satusehat = ?";
    $stmt  = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_satusehat);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-warning">Data Setting Satu Sehat tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    // Status badge
    $status_badge = ($data['status_setting_satusehat'] == 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';

    // Masking client secret
    $masked_secret = str_repeat('*', max(strlen($data['secret_key']) - 4, 8)) .
                     substr($data['secret_key'], -4);

    // Token
    $token = $data['token'] ?? '-' ;
    $datetime_expired = $data['datetime_expired'] ?? '-' ;

?>
    <div class="row mb-2">
        <div class="col-4"><small>ID</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $data['id_setting_satusehat']; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Profil Pengaturan</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($data['nama_setting_satusehat']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Organizatiion ID</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($data['organization_id']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Client Key</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($data['client_key']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Secret Key</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($masked_secret); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Token</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $token; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Token Expired</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $datetime_expired; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $status_badge; ?></div>
    </div>
<?php
    mysqli_stmt_close($stmt);
?>
<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir</div>';
        exit;
    }

    // Ambil ID
    $id_setting_satusehat = $_POST['id_setting_satusehat'] ?? '';

    if (empty($id_setting_satusehat)) {
        echo '<div class="alert alert-danger">ID tidak valid</div>';
        exit;
    }

    // Ambil data
    $stmt = $Conn->prepare("SELECT * FROM setting_satusehat WHERE id_setting_satusehat = ?");
    $stmt->bind_param("i", $id_setting_satusehat);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
        exit;
    }
?>

    <input type="hidden" name="id_setting_satusehat" value="<?= $data['id_setting_satusehat'] ?>">

    <div class="row mb-3">
        <div class="col-12">
            <label><small>Profil Pengaturan</small></label>
            <input type="text" name="nama_setting_satusehat" class="form-control"
                value="<?= htmlspecialchars($data['nama_setting_satusehat']) ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label><small>URL Endpoint</small></label>
            <input type="url" name="url_satusehat" class="form-control"
                value="<?= htmlspecialchars($data['url_satusehat']) ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label><small>Organization ID</small></label>
            <input type="text" name="organization_id" class="form-control"
                value="<?= htmlspecialchars($data['organization_id']) ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label><small>Client Key</small></label>
            <input type="text" name="client_key" class="form-control"
                value="<?= htmlspecialchars($data['client_key']) ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label><small>Secret Key</small></label>
            <input type="text" name="secret_key" class="form-control"
                value="<?= htmlspecialchars($data['secret_key']) ?>" required>
        </div>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="status" id="status_edit<?php echo $id_setting_satusehat; ?>" value="1"
            <?= ($data['status_setting_satusehat'] == 1) ? 'checked' : '' ?>>
        <label for="status_edit<?php echo $id_setting_satusehat; ?>" class="form-check-label">
            <small>Aktifkan Profil Ini</small>
        </label>
    </div>
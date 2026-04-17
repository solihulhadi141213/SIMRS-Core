<?php
include "../../_Config/Connection.php";
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

<div class="alert alert-warning">
    <b>Apakah Anda yakin ingin menghapus data berikut?</b>
</div>

<table class="table table-sm">
    <tr>
        <td><small>Nama Profil</small></td>
        <td><b><?= htmlspecialchars($data['nama_setting_satusehat']) ?></b></td>
    </tr>
    <tr>
        <td><small>URL</small></td>
        <td><?= htmlspecialchars($data['url_satusehat']) ?></td>
    </tr>
    <tr>
        <td><small>Organization ID</small></td>
        <td><?= htmlspecialchars($data['organization_id']) ?></td>
    </tr>
    <tr>
        <td><small>Status</small></td>
        <td>
            <?php if ($data['status_setting_satusehat'] == 1): ?>
                <span class="badge bg-success">Aktif</span>
            <?php else: ?>
                <span class="badge bg-secondary">Nonaktif</span>
            <?php endif; ?>
        </td>
    </tr>
</table>

<div class="alert alert-danger">
    <small>Data yang dihapus tidak dapat dikembalikan.</small>
</div>
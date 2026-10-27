<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "AksesHelper.php";

if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger">Sesi berakhir.</div>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
    exit;
}

$idAkses = filter_input(INPUT_POST, 'id_akses', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$idAkses) {
    echo '<div class="alert alert-danger">ID akses tidak valid.</div>';
    exit;
}

$stmtUser = $Conn->prepare(
    'SELECT a.id_akses, a.id_akses_entitas, a.nama, a.email, e.akses
     FROM akses a
     LEFT JOIN akses_entitas e ON a.id_akses_entitas = e.id_akses_entitas
     WHERE a.id_akses = ?'
);
if (!$stmtUser) {
    error_log('Akses: gagal menyiapkan form izin akses.');
    echo '<div class="alert alert-danger">Form izin akses gagal dimuat.</div>';
    exit;
}
$stmtUser->bind_param('i', $idAkses);
if (!$stmtUser->execute()) {
    $stmtUser->close();
    error_log('Akses: gagal memuat data pengguna untuk izin akses.');
    echo '<div class="alert alert-danger">Form izin akses gagal dimuat.</div>';
    exit;
}
$data = $stmtUser->get_result()->fetch_assoc();
$stmtUser->close();

if (!$data) {
    echo '<div class="alert alert-danger">Data akses tidak ditemukan.</div>';
    exit;
}

$stmtCustom = $Conn->prepare('SELECT id_akses_fitur FROM akses_acc WHERE id_akses = ?');
if (!$stmtCustom) {
    error_log('Akses: gagal menyiapkan daftar izin khusus.');
    echo '<div class="alert alert-danger">Daftar izin akses gagal dimuat.</div>';
    exit;
}
$stmtCustom->bind_param('i', $idAkses);
if (!$stmtCustom->execute()) {
    $stmtCustom->close();
    error_log('Akses: gagal memuat daftar izin khusus.');
    echo '<div class="alert alert-danger">Daftar izin akses gagal dimuat.</div>';
    exit;
}
$userAkses = [];
$resultCustom = $stmtCustom->get_result();
while ($row = $resultCustom->fetch_assoc()) {
    $userAkses[] = (int) $row['id_akses_fitur'];
}
$stmtCustom->close();

if ($userAkses) {
    $finalAkses = $userAkses;
} else {
    $stmtDefault = $Conn->prepare('SELECT id_akses_fitur FROM akses_entitas_acc WHERE id_akses_entitas = ?');
    if (!$stmtDefault) {
        error_log('Akses: gagal menyiapkan izin default entitas.');
        echo '<div class="alert alert-danger">Daftar izin akses gagal dimuat.</div>';
        exit;
    }
    $idEntitas = (int) $data['id_akses_entitas'];
    $stmtDefault->bind_param('i', $idEntitas);
    if (!$stmtDefault->execute()) {
        $stmtDefault->close();
        error_log('Akses: gagal memuat izin default entitas.');
        echo '<div class="alert alert-danger">Daftar izin akses gagal dimuat.</div>';
        exit;
    }
    $finalAkses = [];
    $resultDefault = $stmtDefault->get_result();
    while ($row = $resultDefault->fetch_assoc()) {
        $finalAkses[] = (int) $row['id_akses_fitur'];
    }
    $stmtDefault->close();
}

$stmtFeatures = $Conn->prepare(
    'SELECT id_akses_fitur, nama_fitur, kategori
     FROM akses_fitur
     ORDER BY kategori ASC, nama_fitur ASC'
);
if (!$stmtFeatures || !$stmtFeatures->execute()) {
    if ($stmtFeatures) {
        $stmtFeatures->close();
    }
    error_log('Akses: gagal memuat referensi fitur.');
    echo '<div class="alert alert-danger">Daftar fitur gagal dimuat.</div>';
    exit;
}
$featuresByCategory = [];
$resultFeatures = $stmtFeatures->get_result();
while ($feature = $resultFeatures->fetch_assoc()) {
    $featuresByCategory[$feature['kategori']][] = $feature;
}
$stmtFeatures->close();
?>
<input type="hidden" name="id_akses" value="<?= aksesEscapeHtml($idAkses) ?>">

<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1">:</div>
    <div class="col-6"><small class="text-muted"><?= aksesEscapeHtml($data['nama']) ?></small></div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Email</small></div>
    <div class="col-1">:</div>
    <div class="col-6"><small class="text-muted"><?= aksesEscapeHtml($data['email']) ?></small></div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Entitas</small></div>
    <div class="col-1">:</div>
    <div class="col-6"><small class="text-muted"><?= aksesEscapeHtml($data['akses'] ?? '-') ?></small></div>
</div>

<hr>
<label class="mb-3"><b>Pengaturan Izin Akses</b></label>
<div class="row">
    <?php foreach ($featuresByCategory as $category => $features): ?>
        <div class="col-md-4 mb-4">
            <div class="fw-bold mb-2"><?= aksesEscapeHtml($category) ?></div>
            <div class="ms-2">
                <?php foreach ($features as $feature): ?>
                    <?php $featureId = (int) $feature['id_akses_fitur']; ?>
                    <div class="form-check mb-1">
                        <input class="form-check-input child-checkbox" type="checkbox"
                            name="id_akses_fitur[]" value="<?= $featureId ?>"
                            id="fitur_<?= $featureId ?>"
                            <?= in_array($featureId, $finalAkses, true) ? 'checked' : '' ?>>
                        <label class="form-check-label text-muted" for="fitur_<?= $featureId ?>">
                            <small><?= aksesEscapeHtml($feature['nama_fitur']) ?></small>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

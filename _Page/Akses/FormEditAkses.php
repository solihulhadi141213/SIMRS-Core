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

$stmt = $Conn->prepare('SELECT * FROM akses WHERE id_akses = ?');
if (!$stmt) {
    error_log('Akses: gagal menyiapkan data form edit.');
    echo '<div class="alert alert-danger">Data akses gagal dimuat.</div>';
    exit;
}
$stmt->bind_param('i', $idAkses);
if (!$stmt->execute()) {
    $stmt->close();
    error_log('Akses: gagal memuat data form edit.');
    echo '<div class="alert alert-danger">Data akses gagal dimuat.</div>';
    exit;
}
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    echo '<div class="alert alert-danger">Data tidak ditemukan.</div>';
    exit;
}

$stmtEntitas = $Conn->prepare('SELECT id_akses_entitas, akses, deskripsi FROM akses_entitas ORDER BY akses ASC');
if (!$stmtEntitas || !$stmtEntitas->execute()) {
    if ($stmtEntitas) {
        $stmtEntitas->close();
    }
    error_log('Akses: gagal memuat daftar entitas pada form edit.');
    echo '<div class="alert alert-danger">Daftar entitas akses gagal dimuat.</div>';
    exit;
}
$entitas = $stmtEntitas->get_result();
?>
<input type="hidden" name="id_akses" value="<?= aksesEscapeHtml($data['id_akses']) ?>">

<div class="row mb-3">
    <div class="col-12">
        <label for="nama_edit" class="form-label"><small>Nama Lengkap <span class="text-danger">*</span></small></label>
        <input type="text" name="nama" id="nama_edit" class="form-control" value="<?= aksesEscapeHtml($data['nama']) ?>" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="nik_edit" class="form-label"><small>NIK / KTP <span class="text-danger">*</span></small></label>
        <input type="text" name="nik" id="nik_edit" class="form-control" value="<?= aksesEscapeHtml($data['nik']) ?>" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="ihs_edit" class="form-label"><small>ID Practitioner (IHS)</small></label>
        <div class="input-group">
            <input type="text" name="ihs" id="ihs_edit" class="form-control" value="<?= aksesEscapeHtml($data['ihs']) ?>">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="SearchByNikEdit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="email_edit" class="form-label"><small>Alamat Email <span class="text-danger">*</span></small></label>
        <input type="email" name="email" id="email_edit" class="form-control" value="<?= aksesEscapeHtml($data['email']) ?>" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="kontak_edit" class="form-label"><small>Nomor Kontak <span class="text-danger">*</span></small></label>
        <input type="text" name="kontak" id="kontak_edit" class="form-control" value="<?= aksesEscapeHtml($data['kontak']) ?>" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <label for="id_akses_entitas_edit" class="form-label"><small>Entitas Akses <span class="text-danger">*</span></small></label>
        <select name="id_akses_entitas" id="id_akses_entitas_edit" class="form-select" required>
            <option value="">Pilih</option>
            <?php while ($row = $entitas->fetch_assoc()): ?>
                <option value="<?= aksesEscapeHtml($row['id_akses_entitas']) ?>"
                    <?= (int) $row['id_akses_entitas'] === (int) $data['id_akses_entitas'] ? 'selected' : '' ?>>
                    <?= aksesEscapeHtml($row['akses']) ?> - <?= aksesEscapeHtml($row['deskripsi']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <label for="password_edit" class="form-label"><small>Password Baru (opsional)</small></label>
        <div class="input-group">
            <input type="password" name="password" id="password_edit" class="form-control" autocomplete="new-password">
            <button type="button" class="btn btn-sm btn-secondary" id="GeneratePasswordEdit">
                <i class="bi bi-arrow-left-right"></i> Generate
            </button>
        </div>
        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="gambar_edit" class="form-label"><small>Ganti Foto (opsional)</small></label>
        <input type="file" name="gambar" id="gambar_edit" class="form-control" accept=".jpg,.jpeg,.png,.gif">
        <small class="text-muted">Maksimal 2MB (JPG, PNG, GIF).</small>
    </div>
</div>
<?php $stmtEntitas->close(); ?>

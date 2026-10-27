<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "AksesHelper.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo '<div class="alert alert-danger">Sesi berakhir.</div>';
    exit;
}

$keywordBy = isset($_POST['keyword_by']) && is_string($_POST['keyword_by'])
    ? trim($_POST['keyword_by'])
    : '';
$allowedColumns = ['nama', 'email', 'id_akses_entitas', 'tanggal', 'updatetime'];
if ($keywordBy !== '' && !in_array($keywordBy, $allowedColumns, true)) {
    http_response_code(400);
    echo '<div class="alert alert-danger">Kolom pencarian tidak valid.</div>';
    exit;
}

if ($keywordBy === 'id_akses_entitas') {
    $stmt = $Conn->prepare('SELECT id_akses_entitas, akses FROM akses_entitas ORDER BY akses ASC');
    if (!$stmt || !$stmt->execute()) {
        if ($stmt) {
            $stmt->close();
        }
        error_log('Akses: gagal memuat pilihan filter entitas.');
        echo '<div class="alert alert-danger">Pilihan entitas gagal dimuat.</div>';
        exit;
    }
    ?>
    <select name="keyword" id="keyword" class="form-select">
        <option value="">Pilih</option>
        <?php $result = $stmt->get_result(); ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?= aksesEscapeHtml($row['id_akses_entitas']) ?>"><?= aksesEscapeHtml($row['akses']) ?></option>
        <?php endwhile; ?>
    </select>
    <?php
    $stmt->close();
    exit;
}

$inputType = in_array($keywordBy, ['tanggal', 'updatetime'], true) ? 'date' : 'search';
?>
<input type="<?= $inputType ?>" name="keyword" id="keyword" class="form-control">

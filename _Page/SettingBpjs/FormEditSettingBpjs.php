<?php
    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sesi
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</div>';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_setting_bpjs'])) {
        echo '<div class="alert alert-danger">ID tidak valid.</div>';
        exit;
    }

    $id = intval($_POST['id_setting_bpjs']);

    // Ambil data
    $stmt = $Conn->prepare("SELECT * FROM setting_bpjs WHERE id_setting_bpjs = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
        exit;
    }

    $data = $result->fetch_assoc();

    // Escape helper
    function e($str){
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
?>

<!-- HIDDEN ID -->
<input type="hidden" name="id_setting_bpjs" value="<?= $id ?>">

<div class="row mb-3">
    <div class="col-12">
        <label><small>Profil Pengaturan</small></label>
        <input type="text" name="nama_setting_bpjs" class="form-control"
            value="<?= e($data['nama_setting_bpjs']) ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small><i>Cons ID</i></small></label>
        <input type="text" name="consid" class="form-control"
            value="<?= e($data['consid']) ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small><i>User Key (Vclaim)</i></small></label>
        <input type="text" name="user_key" class="form-control"
            value="<?= e($data['user_key']) ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small><i>User Key (Antrol)</i></small></label>
        <input type="text" name="user_key_antrol" class="form-control"
            value="<?= e($data['user_key_antrol']) ?>" required>
    </div>
</div>

<!-- SECRET KEY (pakai toggle show/hide) -->
<div class="row mb-3">
    <div class="col-12">
        <label><small><i>Secret Key</i></small></label>
        <div class="input-group">
            <input type="password" name="secret_key" id="secret_key_edit"
                class="form-control"
                value="<?= e($data['secret_key']) ?>" required>
            <button type="button" class="btn btn-outline-secondary toggle-secret">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small>Kode PPK</small></label>
        <input type="text" name="kode_ppk" class="form-control"
            value="<?= e($data['kode_ppk']) ?>" required>
    </div>
</div>

<!-- URL dengan UX lebih baik -->
<div class="row mb-3">
    <div class="col-12">
        <label><small><i>URL Vclaim</i></small></label>
        <input type="url" name="url_vclaim" class="form-control"
            value="<?= e($data['url_vclaim']) ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small><i>URL Aplicare</i></small></label>
        <input type="url" name="url_aplicare" class="form-control"
            value="<?= e($data['url_aplicare']) ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small><i>URL Antrol</i></small></label>
        <input type="url" name="url_antrol" class="form-control"
            value="<?= e($data['url_antrol']) ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small><i>URL iCare</i></small></label>
        <input type="url" name="url_icare" class="form-control"
            value="<?= e($data['url_icare']) ?>" required>
    </div>
</div>

<!-- STATUS -->
<div class="row mb-3">
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="status" value="1"
                id="status_edit"
                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="status_edit">
                <small>Aktifkan Profil Pengaturan Ini</small>
            </label>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    // toggle show/hide secret key
    $(document).off('click', '.toggle-secret').on('click', '.toggle-secret', function () {
        let input = $('#secret_key_edit');
        let type = input.attr('type');

        input.attr('type', type === 'password' ? 'text' : 'password');
    });
</script>
<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "AksesHelper.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir</div>';
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }

    // Ambil ID
    $id_akses = filter_input(INPUT_POST, 'id_akses', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    if (empty($id_akses)) {
        echo '<div class="alert alert-danger">ID tidak valid</div>';
        exit;
    }

    // Ambil data + join entitas
    $stmt = $Conn->prepare("
        SELECT 
            a.*,
            e.deskripsi AS entitas_deskripsi
        FROM akses a
        LEFT JOIN akses_entitas e 
            ON a.id_akses_entitas = e.id_akses_entitas
        WHERE a.id_akses = ?
    ");
    if (!$stmt) {
        error_log('Akses: gagal menyiapkan konfirmasi penghapusan.');
        echo '<div class="alert alert-danger">Data akses gagal dimuat.</div>';
        exit;
    }
    $stmt->bind_param("i", $id_akses);
    if (!$stmt->execute()) {
        $stmt->close();
        error_log('Akses: gagal memuat konfirmasi penghapusan.');
        echo '<div class="alert alert-danger">Data akses gagal dimuat.</div>';
        exit;
    }
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if (!$data) {
        echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
        exit;
    }

    // Path gambar
    $gambar = aksesImageUrl($data['gambar']);
?>
<input type="hidden" name="id_akses" value="<?php echo $id_akses; ?>">
<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= aksesEscapeHtml($data['nama']) ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>NIK / KTP</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['nik']) ? aksesEscapeHtml($data['nik']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>ID Practitioner (IHS)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['ihs']) ? aksesEscapeHtml($data['ihs']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Alamat Email</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['email']) ? aksesEscapeHtml($data['email']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div> 
<div class="row mb-3">
    <div class="col-5"><small>Nomor Kontak</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['kontak']) ? aksesEscapeHtml($data['kontak']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Entitas Akses</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['akses']) ? aksesEscapeHtml($data['akses']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Tanggal Dibuat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><time class="js-akses-date" data-utc="<?= aksesEscapeHtml(str_replace(' ', 'T', $data['tanggal']) . 'Z') ?>"></time></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Update Terakhir</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><time class="js-akses-date" data-utc="<?= aksesEscapeHtml(str_replace(' ', 'T', $data['updatetime']) . 'Z') ?>"></time></small>
    </div>
</div>
 <div class="row mt-3">
    <div class="col-12 text-center">
        <div class="alert alert-warning">
            <b>PENTING!</b><br>
            <small>Menghapus data akses akan menyebabkan pengguna bersangkutan tidak memiliki ijin akses.</small><br>
            <small><b>Apakah Anda Yakin Akan Menghapus Data Tersebut?</b></small>
        </div>
    </div>
</div>
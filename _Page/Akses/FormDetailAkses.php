<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir</div>';
        exit;
    }

    // Ambil ID
    $id_akses = $_POST['id_akses'] ?? '';

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
    $stmt->bind_param("i", $id_akses);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if (!$data) {
        echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
        exit;
    }

    // Path gambar
    $gambar = !empty($data['gambar']) ? "assets/images/user/" . $data['gambar'] : "assets/images/user/no-image.png";

    // CEK APAKAH USER PUNYA CUSTOM AKSES
    $stmtCek = $Conn->prepare("
        SELECT COUNT(*) as total 
        FROM akses_acc 
        WHERE id_akses = ?
    ");
    $stmtCek->bind_param("i", $id_akses);
    $stmtCek->execute();
    $resultCek = $stmtCek->get_result();
    $rowCek = $resultCek->fetch_assoc();
    $stmtCek->close();

    $pakaiCustom = $rowCek['total'] > 0;

    // AMBIL FITUR
    if ($pakaiCustom) {

        // 🔹 Ambil dari akses_acc (CUSTOM USER)
        $stmtFitur = $Conn->prepare("
            SELECT f.nama_fitur, f.kategori
            FROM akses_acc ac
            JOIN akses_fitur f ON ac.id_akses_fitur = f.id_akses_fitur
            WHERE ac.id_akses = ?
            ORDER BY f.kategori ASC, f.nama_fitur ASC
        ");
        $stmtFitur->bind_param("i", $id_akses);

    } else {

        // 🔹 Fallback ke entitas
        $stmtFitur = $Conn->prepare("
            SELECT f.nama_fitur, f.kategori
            FROM akses_entitas_acc ae
            JOIN akses_fitur f ON ae.id_akses_fitur = f.id_akses_fitur
            WHERE ae.id_akses_entitas = ?
            ORDER BY f.kategori ASC, f.nama_fitur ASC
        ");
        $stmtFitur->bind_param("i", $data['id_akses_entitas']);
    }

    $stmtFitur->execute();
    $resultFitur = $stmtFitur->get_result();

   // KELOMPOKKAN
    $fiturByKategori = [];

    while ($row = $resultFitur->fetch_assoc()) {
        $fiturByKategori[$row['kategori']][] = $row['nama_fitur'];
    }

    $stmtFitur->close();
?>
<!-- Foto -->
<div class="row mb-4 border-1 border-bottom">
    <div class="col-md-12 text-center mb-3">
        <img src="<?= $gambar ?>" class="img-radius" width="200px" height="200px">
    </div>
</div>

<!-- DETAIL -->
<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= htmlspecialchars($data['nama']) ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>NIK / KTP</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['nik']) ? htmlspecialchars($data['nik']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>ID Practitioner (IHS)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['ihs']) ? htmlspecialchars($data['ihs']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Alamat Email</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['email']) ? htmlspecialchars($data['email']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div> 
<div class="row mb-3">
    <div class="col-5"><small>Nomor Kontak</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['kontak']) ? htmlspecialchars($data['kontak']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Entitas Akses</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= !empty($data['akses']) ? htmlspecialchars($data['akses']) : '<span class="text-muted">-</span>' ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Tanggal Dibuat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= date('d/m/Y H:i', strtotime($data['tanggal'])) ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Update Terakhir</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?= date('d/m/Y H:i', strtotime($data['updatetime'])) ?></small>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <?php if (!empty($fiturByKategori)) { ?>
            <div class="row mt-3">
                <?php foreach ($fiturByKategori as $kategori => $fiturList) { ?>
                    <div class="col-md-12 mb-3">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <small><b><?= htmlspecialchars($kategori) ?></b></small>
                            </div>
                            <div class="card-body p-2">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($fiturList as $fitur) { ?>
                                        <li>
                                            <small class="text-muted">
                                                <?= htmlspecialchars($fitur) ?>
                                            </small>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning mt-2">
                <small>Belum ada fitur yang diizinkan untuk entitas ini</small>
            </div>
        <?php } ?>
    </div>
</div>
<div class="alert alert-info mt-3">
    <small>
        <?php if ($pakaiCustom) { ?>
            Menggunakan <b>akses khusus user (custom)</b>
        <?php } else { ?>
            Menggunakan <b>akses default entitas</b>
        <?php } ?>
    </small>
</div>
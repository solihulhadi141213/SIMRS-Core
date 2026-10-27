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
        error_log('Akses: gagal menyiapkan detail akses.');
        echo '<div class="alert alert-danger">Data akses gagal dimuat.</div>';
        exit;
    }
    $stmt->bind_param("i", $id_akses);
    if (!$stmt->execute()) {
        $stmt->close();
        error_log('Akses: gagal memuat detail akses.');
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

    // Tampilkan hanya foto pengguna yang valid, bukan gambar fallback.
    $namaGambar = trim((string) ($data['gambar'] ?? ''));
    $gambar = '';
    if ($namaGambar !== '' && !preg_match('/^no-image\.(png|jpe?g|gif)$/i', basename($namaGambar))) {
        $urlGambar = aksesImageUrl($namaGambar);
        if ($urlGambar !== 'assets/img/user/No-Image.png') {
            $gambar = $urlGambar;
        }
    }

    // CEK APAKAH USER PUNYA CUSTOM AKSES
    $stmtCek = $Conn->prepare("
        SELECT COUNT(*) as total 
        FROM akses_acc 
        WHERE id_akses = ?
    ");
    if (!$stmtCek) {
        error_log('Akses: gagal menyiapkan pemeriksaan akses khusus.');
        echo '<div class="alert alert-danger">Izin akses gagal dimuat.</div>';
        exit;
    }
    $stmtCek->bind_param("i", $id_akses);
    if (!$stmtCek->execute()) {
        $stmtCek->close();
        error_log('Akses: gagal memeriksa akses khusus.');
        echo '<div class="alert alert-danger">Izin akses gagal dimuat.</div>';
        exit;
    }
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
        $idUntukFitur = $id_akses;

    } else {

        // 🔹 Fallback ke entitas
        $stmtFitur = $Conn->prepare("
            SELECT f.nama_fitur, f.kategori
            FROM akses_entitas_acc ae
            JOIN akses_fitur f ON ae.id_akses_fitur = f.id_akses_fitur
            WHERE ae.id_akses_entitas = ?
            ORDER BY f.kategori ASC, f.nama_fitur ASC
        ");
        $idUntukFitur = (int) $data['id_akses_entitas'];
    }

    if (!$stmtFitur) {
        error_log('Akses: gagal memuat daftar fitur akses.');
        echo '<div class="alert alert-danger">Daftar izin akses gagal dimuat.</div>';
        exit;
    }
    $stmtFitur->bind_param('i', $idUntukFitur);
    if (!$stmtFitur->execute()) {
        $stmtFitur->close();
        error_log('Akses: gagal memuat daftar fitur akses.');
        echo '<div class="alert alert-danger">Daftar izin akses gagal dimuat.</div>';
        exit;
    }
    $resultFitur = $stmtFitur->get_result();

   // KELOMPOKKAN
    $fiturByKategori = [];

    while ($row = $resultFitur->fetch_assoc()) {
        $fiturByKategori[$row['kategori']][] = $row['nama_fitur'];
    }

    $stmtFitur->close();
?>
<!-- Foto pengguna ditampilkan sebelum identitas dengan ukuran tetap dan crop melingkar. -->
<?php if ($gambar !== '') { ?>
<div class="text-center mb-3">
    <img src="<?= aksesEscapeHtml($gambar) ?>" class="akses-detail-photo" alt="Foto <?= aksesEscapeHtml($data['nama']) ?>">
</div>
<?php } ?>

<!-- Informasi identitas mengikuti pola baris detail yang digunakan halaman lain. -->
<div class="row mb-2">
    <div class="col-12"><b><small>A. Identitas Pengguna</small></b></div>
</div>
<?php
    $detailAkses = [
        'Nama Pengguna' => $data['nama'] ?? '',
        'NIK / KTP' => $data['nik'] ?? '',
        'ID Practitioner (IHS)' => $data['ihs'] ?? '',
        'Alamat Email' => $data['email'] ?? '',
        'Nomor Kontak' => $data['kontak'] ?? '',
        'Entitas Akses' => $data['akses'] ?? '',
    ];
    foreach ($detailAkses as $label => $value) {
?>
    <div class="row mb-2">
        <div class="col-4"><small><?= aksesEscapeHtml($label) ?></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted text-break"><?= $value !== '' ? aksesEscapeHtml($value) : '-' ?></small></div>
    </div>
<?php
}
?>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal Dibuat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <?php $tanggalIso = aksesUtcDateIso($data['tanggal'] ?? null); ?>
        <small class="text-muted"><time class="js-akses-date" <?= $tanggalIso !== '' ? 'datetime="' . aksesEscapeHtml($tanggalIso) . '" data-utc="' . aksesEscapeHtml($tanggalIso) . '"' : '' ?>><?= aksesEscapeHtml(aksesUtcDateDisplay($data['tanggal'] ?? null)) ?></time></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Update Terakhir</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <?php $updatetimeIso = aksesUtcDateIso($data['updatetime'] ?? null); ?>
        <small class="text-muted"><time class="js-akses-date" <?= $updatetimeIso !== '' ? 'datetime="' . aksesEscapeHtml($updatetimeIso) . '" data-utc="' . aksesEscapeHtml($updatetimeIso) . '"' : '' ?>><?= aksesEscapeHtml(aksesUtcDateDisplay($data['updatetime'] ?? null)) ?></time></small>
    </div>
</div>

<!-- Role akses disusun per kategori dalam accordion, dengan fitur di dalam list group. -->
<section class="mt-4" aria-labelledby="judul-role-akses">
    <div class="row mb-2">
        <div class="col-12"><b><small id="judul-role-akses">B. Role Akses</small></b></div>
    </div>
    <?php if (!empty($fiturByKategori)) { ?>
        <?php $accordionId = 'accordion-role-akses-' . (int) $id_akses; ?>
        <div class="accordion accordion-flush border rounded" id="<?= aksesEscapeHtml($accordionId) ?>">
            <?php $indexKategori = 0; ?>
            <?php foreach ($fiturByKategori as $kategori => $fiturList) { ?>
                <?php
                $indexKategori++;
                $collapseId = $accordionId . '-kategori-' . $indexKategori;
                ?>
                <div class="accordion-item">
                    <h3 class="accordion-header" id="<?= aksesEscapeHtml($collapseId) ?>-heading">
                        <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#<?= aksesEscapeHtml($collapseId) ?>" aria-expanded="false" aria-controls="<?= aksesEscapeHtml($collapseId) ?>">
                            <span><?= aksesEscapeHtml($kategori) ?></span>
                            <span class="badge rounded-pill text-bg-secondary ms-2"><?= count($fiturList) ?></span>
                        </button>
                    </h3>
                    <div id="<?= aksesEscapeHtml($collapseId) ?>" class="accordion-collapse collapse" aria-labelledby="<?= aksesEscapeHtml($collapseId) ?>-heading" data-bs-parent="#<?= aksesEscapeHtml($accordionId) ?>">
                        <div class="accordion-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($fiturList as $fitur) { ?>
                                    <li class="list-group-item py-2 small text-muted"><?= aksesEscapeHtml($fitur) ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <ul class="list-group">
            <li class="list-group-item text-muted">Belum ada fitur yang diizinkan untuk entitas ini.</li>
        </ul>
    <?php } ?>
</section>

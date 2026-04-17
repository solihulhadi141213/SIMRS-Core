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

// ==========================
// AMBIL DATA AKSES
// ==========================
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

// ==========================
// AMBIL DEFAULT ENTITAS
// ==========================
$defaultAkses = [];
$qDefault = mysqli_query($Conn, "
    SELECT id_akses_fitur 
    FROM akses_entitas_acc 
    WHERE id_akses_entitas = '{$data['id_akses_entitas']}'
");

while ($row = mysqli_fetch_assoc($qDefault)) {
    $defaultAkses[] = $row['id_akses_fitur'];
}

// ==========================
// AMBIL AKSES USER (OVERRIDE)
// ==========================
$userAkses = [];
$qUser = mysqli_query($Conn, "
    SELECT id_akses_fitur 
    FROM akses_acc 
    WHERE id_akses = '{$id_akses}'
");

while ($row = mysqli_fetch_assoc($qUser)) {
    $userAkses[] = $row['id_akses_fitur'];
}

// Jika user punya akses custom → pakai itu
$finalAkses = !empty($userAkses) ? $userAkses : $defaultAkses;


// ==========================
// AMBIL SEMUA FITUR
// ==========================
$query = mysqli_query($Conn, "
    SELECT id_akses_fitur, nama_fitur, kategori
    FROM akses_fitur
    ORDER BY kategori ASC, nama_fitur ASC
");

// Grouping kategori
$fiturByKategori = [];
while ($row = mysqli_fetch_assoc($query)) {
    $fiturByKategori[$row['kategori']][] = $row;
}
?>

<input type="hidden" name="id_akses" value="<?= $id_akses ?>">

<!-- INFO USER -->
<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1">:</div>
    <div class="col-6">
        <small class="text-muted"><?= htmlspecialchars($data['nama']) ?></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-5"><small>Email</small></div>
    <div class="col-1">:</div>
    <div class="col-6">
        <small class="text-muted"><?= htmlspecialchars($data['email']) ?></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-5"><small>Entitas</small></div>
    <div class="col-1">:</div>
    <div class="col-6">
        <small class="text-muted"><?= htmlspecialchars($data['akses']) ?></small>
    </div>
</div>

<hr>

<!-- FITUR -->
<div class="row">
    <div class="col-12">
        <label class="mb-3"><b>Pengaturan Ijin Akses</b></label>

        <div class="row">
            <?php foreach ($fiturByKategori as $kategori => $fiturList): ?>
                
                <div class="col-md-4 mb-4">

                    <!-- Judul Kategori -->
                    <div class="fw-bold mb-2">
                        <?= htmlspecialchars($kategori) ?>
                    </div>

                    <!-- Checkbox -->
                    <div class="ms-2">
                        <?php foreach ($fiturList as $fitur): 
                            $checked = in_array($fitur['id_akses_fitur'], $finalAkses) ? 'checked' : '';
                        ?>
                            <div class="form-check mb-1">
                                <input class="form-check-input child-checkbox"
                                       type="checkbox"
                                       name="id_akses_fitur[]"
                                       value="<?= $fitur['id_akses_fitur'] ?>"
                                       id="fitur_<?= $fitur['id_akses_fitur'] ?>"
                                       <?= $checked ?>>

                                <label class="form-check-label text-muted"
                                       for="fitur_<?= $fitur['id_akses_fitur'] ?>">
                                    <small><?= htmlspecialchars($fitur['nama_fitur']) ?></small>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>
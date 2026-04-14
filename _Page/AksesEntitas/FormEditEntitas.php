<?php
date_default_timezone_set('Asia/Jakarta');

// Connection
include "../../_Config/Connection.php";

// Function
include "../../_Config/SimrsFunction.php";

// Session
include "../../_Config/Session.php";

// Validasi session
if (empty($SessionIdAkses)) {
    echo '
        <div class="alert alert-danger">
            Sesi akses berakhir
        </div>
    ';
    exit;
}

// Validasi ID
if (empty($_POST['id_akses_entitas'])) {
    echo '
        <div class="alert alert-danger">
            ID entitas tidak valid
        </div>
    ';
    exit;
}

$id_akses_entitas = intval($_POST['id_akses_entitas']);

// Ambil data entitas
$query_entitas = mysqli_prepare(
    $Conn,
    "SELECT * FROM akses_entitas WHERE id_akses_entitas = ?"
);

mysqli_stmt_bind_param($query_entitas, "i", $id_akses_entitas);
mysqli_stmt_execute($query_entitas);
$result_entitas = mysqli_stmt_get_result($query_entitas);

if (mysqli_num_rows($result_entitas) == 0) {
    echo '
        <div class="alert alert-danger">
            Data entitas tidak ditemukan
        </div>
    ';
    exit;
}

$data_entitas = mysqli_fetch_assoc($result_entitas);

// Ambil daftar fitur yang sudah dipilih
$selected_fitur = [];

$query_selected = mysqli_prepare(
    $Conn,
    "SELECT id_akses_fitur 
     FROM akses_entitas_acc 
     WHERE id_akses_entitas = ?"
);

mysqli_stmt_bind_param($query_selected, "i", $id_akses_entitas);
mysqli_stmt_execute($query_selected);
$result_selected = mysqli_stmt_get_result($query_selected);

while ($row = mysqli_fetch_assoc($result_selected)) {
    $selected_fitur[] = $row['id_akses_fitur'];
}

// Ambil semua fitur
$query_fitur = mysqli_query(
    $Conn,
    "SELECT id_akses_fitur, nama_fitur, kategori
     FROM akses_fitur
     ORDER BY kategori ASC, nama_fitur ASC"
);

// Kelompokkan per kategori
$fiturByKategori = [];

while ($row = mysqli_fetch_assoc($query_fitur)) {
    $fiturByKategori[$row['kategori']][] = $row;
}
?>

<input type="hidden" 
       name="id_akses_entitas" 
       value="<?= $id_akses_entitas ?>">

<div class="row mb-3">
    <div class="col-12">
        <label><small>Nama Entitas</small></label>
        <input type="text"
               name="akses"
               id="edit_entitas_akses"
               class="form-control"
               value="<?= htmlspecialchars($data_entitas['akses']) ?>"
               required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label><small>Deskripsi</small></label>
        <textarea name="deskripsi"
                  class="form-control"
                  rows="3"
                  required><?= htmlspecialchars($data_entitas['deskripsi']) ?></textarea>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label class="mb-3">
            <small><b>Fitur Entitas</b></small>
        </label>

        <div class="border rounded p-3">

            <?php $no = 1; ?>
            <?php foreach ($fiturByKategori as $kategori => $fiturList): ?>

                <?php
                $allChecked = true;
                foreach ($fiturList as $fitur) {
                    if (!in_array($fitur['id_akses_fitur'], $selected_fitur)) {
                        $allChecked = false;
                        break;
                    }
                }
                ?>

                <div class="mb-3 kategori-group">

                    <div class="form-check">
                        <input class="form-check-input kategori-checkbox"
                               type="checkbox"
                               id="edit_kategori_<?= $no ?>"
                               <?= $allChecked ? 'checked' : '' ?>>

                        <label class="form-check-label fw-bold"
                               for="edit_kategori_<?= $no ?>">
                            <?= htmlspecialchars($kategori) ?>
                        </label>
                    </div>

                    <div class="ms-4 mt-2">

                        <?php foreach ($fiturList as $fitur): ?>

                            <div class="form-check mb-1">
                                <input class="form-check-input child-checkbox"
                                       type="checkbox"
                                       name="id_akses_fitur[]"
                                       value="<?= $fitur['id_akses_fitur'] ?>"
                                       id="fitur_<?= $fitur['id_akses_fitur'] ?>"
                                       <?= in_array($fitur['id_akses_fitur'], $selected_fitur) ? 'checked' : '' ?>>

                                <label class="form-check-label"
                                       for="fitur_<?= $fitur['id_akses_fitur'] ?>">
                                    <small class="text-muted">
                                        <?= htmlspecialchars($fitur['nama_fitur']) ?>
                                    </small>
                                </label>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

                <?php $no++; ?>

            <?php endforeach; ?>

        </div>
    </div>
</div>
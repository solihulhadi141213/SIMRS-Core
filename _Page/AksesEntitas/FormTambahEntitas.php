<?php
date_default_timezone_set('Asia/Jakarta');

// Connection
include "../../_Config/Connection.php";

// Function
include "../../_Config/SimrsFunction.php";

// Session
include "../../_Config/Session.php";

// Validasi Session
if (empty($SessionIdAkses)) {
    echo '
        <div class="alert alert-danger text-center">
            <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
        </div>
    ';
    exit;
}

// Ambil semua fitur sekaligus (lebih optimal)
$query = mysqli_query($Conn, "
    SELECT id_akses_fitur, nama_fitur, kategori
    FROM akses_fitur
    ORDER BY kategori ASC, nama_fitur ASC
");

// Kelompokkan data berdasarkan kategori
$fiturByKategori = [];

while ($row = mysqli_fetch_assoc($query)) {
    $fiturByKategori[$row['kategori']][] = $row;
}
?>

<div class="row mb-3">
    <div class="col-12">
        <label for="entitas_akses"><small>Nama Entitas</small></label>
        <input type="text" 
               name="akses" 
               id="entitas_akses" 
               class="form-control" 
               placeholder="Contoh : Admin, Perawat" 
               required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="deskripsi"><small>Deskripsi</small></label>
        <textarea name="deskripsi" 
                  id="deskripsi" 
                  class="form-control" 
                  rows="3"
                  required></textarea>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label class="mb-3">
            <b>Fitur Entitas</b>
        </label>

        <div class="border rounded p-3">
            <?php $no = 1; ?>
            <?php foreach ($fiturByKategori as $kategori => $fiturList): ?>
                
                <div class="mb-3 kategori-group">
                    
                    <!-- Parent Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input kategori-checkbox"
                               type="checkbox"
                               id="kategori_<?= $no ?>"
                               value="<?= htmlspecialchars($kategori) ?>">
                        
                        <label class="form-check-label fw-bold"
                               for="kategori_<?= $no ?>">
                            <?= htmlspecialchars($kategori) ?>
                        </label>
                    </div>

                    <!-- Child Checkbox -->
                    <div class="ms-4 mt-2 child-wrapper">
                        <?php foreach ($fiturList as $fitur): ?>
                            <div class="form-check mb-1">
                                <input class="form-check-input child-checkbox"
                                       type="checkbox"
                                       name="id_akses_fitur[]"
                                       value="<?= $fitur['id_akses_fitur'] ?>"
                                       data-kategori="<?= htmlspecialchars($kategori) ?>"
                                       id="fitur_<?= $fitur['id_akses_fitur'] ?>">
                                
                                <label class="form-check-label text-muted"
                                       for="fitur_<?= $fitur['id_akses_fitur'] ?>">
                                    <small><?= htmlspecialchars($fitur['nama_fitur']) ?></small>
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
<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir</div>';
        exit;
    }

    $id_akses = $_POST['id_akses'] ?? '';

    if (empty($id_akses)) {
        echo '<div class="alert alert-danger">ID tidak valid</div>';
        exit;
    }

    // Ambil data akses
    $stmt = $Conn->prepare("SELECT * FROM akses WHERE id_akses=?");
    $stmt->bind_param("i", $id_akses);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$data) {
        echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
        exit;
    }

    // Ambil entitas
    $entitas = $Conn->query("SELECT * FROM akses_entitas ORDER BY akses ASC");

    // Gambar
    $gambar = (!empty($data['gambar']) && file_exists("../../assets/images/user/".$data['gambar']))
        ? "assets/images/user/".$data['gambar']
        : "assets/images/user/no-image.png";
?>

<input type="hidden" name="id_akses" value="<?= $data['id_akses'] ?>">



<!-- NAMA -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Nama Lengkap</small></label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
    </div>
</div>

<!-- NIK + IHS -->
<div class="row mb-3">
    <div class="col-md-12">
        <label for="nik_edit"><small>NIK / KTP</small></label>
        <input type="text" name="nik" id="nik_edit" class="form-control" value="<?php echo $data['nik']; ?>" required>
    </div>
</div>

<!-- ID Practitioner (IHS) -->
<div class="row mb-3">
    <div class="col-md-12">
        <label for="ihs_edit"><small>ID Practitioner (IHS)</small></label>
        <div class="input-group">
            <input type="text" name="ihs" id="ihs_edit" class="form-control" value="<?php echo $data['ihs']; ?>">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="SearchByNikEdit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </div>
</div>

<!-- EMAIL -->
<div class="row mb-3">
    <div class="col-md-12">
        <label for="email_edit"><small>Alamat Email</small></label>
        <input type="email" name="email" id="email_edit" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
    </div>
</div>

<!-- EKONTAK -->
<div class="row mb-3">
    <div class="col-md-12">
        <label for="kontak_edit"><small>Nomor Kontak</small></label>
        <input type="text" name="kontak" id="kontak_edit" class="form-control" value="<?= htmlspecialchars($data['kontak']) ?>" required>
    </div>
</div>

<!-- AKSES -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Entitas Akses</small></label>
        <select name="id_akses_entitas" class="form-control" required>
            <option value="">Pilih</option>
            <?php while($row = $entitas->fetch_assoc()){ ?>
                <option value="<?= $row['id_akses_entitas'] ?>"
                    <?= $row['id_akses_entitas'] == $data['id_akses_entitas'] ? 'selected' : '' ?>>
                    <?= $row['akses'] ?> - <?= $row['deskripsi'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<!-- PASSWORD -->
<div class="row mb-3">
    <div class="col-12">
        <label><small>Password Baru (opsional)</small></label>
        <div class="input-group">
            <input type="text" name="password" id="password_edit" class="form-control">
            <button type="button" class="btn btn-sm btn-secondary" id="GeneratePasswordEdit">
                <i class="bi bi-arrow-left-right"></i> Generate
            </button>
        </div>
        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
    </div>
</div>

<!-- FOTO -->
<div class="row mb-3">
    <div class="col-md-12">
        <label><small>Ganti Foto (opsional)</small></label>
        <input type="file" name="gambar" class="form-control">
        <small class="text-muted">Max 2MB (JPG, PNG, GIF)</small>
    </div>
</div>
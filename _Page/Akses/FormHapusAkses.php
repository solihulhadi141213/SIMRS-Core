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
?>
<input type="hidden" name="id_akses" value="<?php echo $id_akses; ?>">
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
 <div class="row mt-3">
    <div class="col-12 text-center">
        <div class="alert alert-warning">
            <b>PENTING!</b><br>
            <small>Menghapus data akses akan menyebabkan pengguna bersangkutan tidak memiliki ijin akses.</small><br>
            <small><b>Apakah Anda Yakin Akan Menghapus Data Tersebut?</b></small>
        </div>
    </div>
</div>
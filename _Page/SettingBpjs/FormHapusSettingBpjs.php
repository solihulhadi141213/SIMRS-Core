<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir, silakan login ulang.</div>';
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

    function e($str){
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
?>

<input type="hidden" name="id_setting_bpjs" value="<?= $id ?>">

<!-- INFO DATA -->
<div class="mb-3">
    <label><small>Profil Pengaturan</small></label>
    <div class="form-control bg-light"><?= e($data['nama_setting_bpjs']) ?></div>
</div>

<div class="mb-3">
    <label><small>Cons ID</small></label>
    <div class="form-control bg-light"><?= e($data['consid']) ?></div>
</div>

<div class="mb-3">
    <label><small>Kode PPK</small></label>
    <div class="form-control bg-light"><?= e($data['kode_ppk']) ?></div>
</div>

<!-- ALERT KONDISI -->
<?php if ($data['status'] == 1) { ?>

    <div class="alert alert-danger">
        <b>Perhatian!</b><br>
        Profil ini sedang <b>AKTIF</b>.<br>
        Jika Anda menghapusnya, maka <b>koneksi bridging BPJS akan terputus</b> dan dapat mengganggu layanan sistem.<br><br>
        Pastikan Anda benar-benar yakin sebelum melanjutkan.
    </div>

<?php } else { ?>

    <div class="alert alert-warning">
        Profil ini tidak aktif.<br>
        Jika dihapus, Anda <b>tidak dapat menggunakan pengaturan ini kembali</b> di masa mendatang.
    </div>

<?php } ?>
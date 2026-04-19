<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir</div>';
        exit;
    }

    // Ambil ID
    $id_akses_pengajuan = $_POST['id_akses_pengajuan'] ?? '';

    if (empty($id_akses_pengajuan)) {
        echo '<div class="alert alert-danger text-center">ID Pengajuan Tidak Boleh Kosng!</div>';
        exit;
    }

    // Buka Data Dengan Prepared Statment
    $stmt = $Conn->prepare("SELECT * FROM akses_pengajuan WHERE id_akses_pengajuan = ?");
    $stmt->bind_param("i", $id_akses_pengajuan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    // Jika Data Tidak Ditemukan
    if (!$data) {
        echo '<div class="alert alert-danger text-center">Data tidak ditemukan</div>';
        exit;
    }

    // Path gambar
    $gambar = !empty($data['foto']) ? "assets/images/PengajuanAkses/" . $data['foto'] : "assets/images/user/no-image.png";

    // Lainnya
    $nama      = $data['nama'] ?? '';
    $nik       = $data['nik'] ?? '';
    $email     = $data['email'] ?? '';
    $kontak    = $data['kontak'] ?? '';
    $alamat    = $data['alamat'] ?? '';
    $tanggal   = $data['tanggal'];
    $deskripsi = $data['deskripsi'] ?? '';
    $status    = $data['status'];
    
    if($status=="Pending"){
        $label_status = '<span class="py-1 px-2 bg-warning rounded-2"><small>Pending</small></span>';
    }else{
        if($status=="Ditolak"){
            $label_status = '<span class="py-1 px-2 bg-danger rounded-2"><small>Ditolak</small></span>';
        }else{
            if($status=="Diterima"){
                $label_status = '<span class="py-1 px-2 bg-success rounded-2"><small>Diterima</small></span>';
            }else{
                $label_status = '<span class="py-1 px-2 bg-dark rounded-2"><small>None</small></span>';
            }
        }
    }
?>
<!-- FORM -->
<input type="hidden" name="id_akses_pengajuan" value="<?php echo $id_akses_pengajuan; ?>">
<div class="row mb-3">
    <div class="col-md-12">
        <label for="nama_edit">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_edit" name="nama" value="<?php echo $nama; ?>" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="nik">Nomor KTP/NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik; ?>" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="kontak_edit">Nomor Kontak</label>
        <input type="text" class="form-control" id="kontak_edit" name="kontak" placeholder="62" value="<?php echo $kontak; ?>" required>
        <small class="text-muted">Gunakan nomor kontak yang valid, untuk mempermudah admin menghubungi anda menghubungi anda.</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="email_edit">Alamat Email</label>
        <input type="email" class="form-control" id="email_edit" name="email" placeholder="email@domain.com" value="<?php echo $email; ?>" required>
        <small class="text-muted">Informasi kredensial akses akan di kirim ke email anda</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="alamat_edit">Alamat Tinggal</label>
        <textarea name="alamat" id="alamat_edit" class="form-control" cols="30" rows="3" maxlength="200" required><?php echo $alamat; ?></textarea>
        <small class="text-muted">
            <small class="text-muted" id="jumlah_karakter_alamat">(0 / 200)</small>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="deskripsi_edit">
            Kebutuhan Akses
        </label>
        <textarea name="deskripsi" id="deskripsi_edit" class="form-control" cols="30" rows="3" maxlength="200" required><?php echo $deskripsi; ?></textarea>
        <small class="text-muted">
            <small class="text-muted" id="jumlah_karakter_deskripsi">(0 / 200)</small>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="foto_edit">Ganti Pas Foto</label>
        <input type="file" class="form-control" id="foto_edit" name="foto">
        <small class="text-muted">Gunakan foto jelas diri anda dengan format JPG, JPEG, GIF atau PNG (maksimal 2 mb)</small>
    </div>
</div>
<script>
    // ==========================================
    // HITUNG KARAKTER ALAMAT
    // ==========================================
    $(document).on('input', '#alamat_edit', function () {
        let maxLength = 200;
        let currentLength = $(this).val().length;

        $('#jumlah_karakter_alamat').text(`(${currentLength} / ${maxLength})`);
    });

    // ==========================================
    // HITUNG KARAKTER DESKRIPSI
    // ==========================================
    $(document).on('input', '#deskripsi_edit', function () {
        let maxLength = 200;
        let currentLength = $(this).val().length;

        $('#jumlah_karakter_deskripsi').text(`(${currentLength} / ${maxLength})`);
    });
</script>
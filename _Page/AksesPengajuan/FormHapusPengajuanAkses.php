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
    $nama      = $data['nama'] ?? '-';
    $nik       = $data['nik'] ?? '-';
    $email     = $data['email'] ?? '-';
    $kontak    = $data['kontak'] ?? '-';
    $alamat    = $data['alamat'] ?? '-';
    $tanggal   = date('d/m/Y H:i', strtotime($data['tanggal']));
    $deskripsi = $data['deskripsi'] ?? '-';
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

<!-- DETAIL -->
<input type="hidden" name="id_akses_pengajuan" value="<?php echo $id_akses_pengajuan; ?>">
<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $nama; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>NIK / KTP</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $nik; ?></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-5"><small>Alamat Email</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $email; ?></small>
    </div>
</div> 
<div class="row mb-3">
    <div class="col-5"><small>Nomor Kontak</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $kontak; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Alamat</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $alamat; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Tanggal Pengajuan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $tanggal; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Tujuan Pengajuan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $deskripsi; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <?php echo $label_status; ?>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-warning text-center">
            <h4>PENTING!</h4>
            <small>
                Menghapus Pengajuan Akses Memungkinkan Pengguna Yang Sama Mengirimkan Pengajuan Akses Kembali.<br>
                <b>Apakah anda yakin akan menghapus data tersebut?</b>
            </small>
        </div>
    </div>
</div>


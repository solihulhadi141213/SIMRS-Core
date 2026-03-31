<?php
    // Koneksi Dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Hitung ringkasan dengan query agregasi agar lebih ringan
    $JumlahLogProfile = (int) mysqli_fetch_assoc(mysqli_query($Conn, "SELECT COUNT(*) AS total FROM log WHERE id_akses='$SessionIdAkses'"))['total'];
    $JumlahLogProfileFormat = number_format($JumlahLogProfile, 0, ',', '.');
    $JumlahLaporanPengguna = (int) mysqli_fetch_assoc(mysqli_query($Conn, "SELECT COUNT(*) AS total FROM laporan_pengguna WHERE id_akses='$SessionIdAkses'"))['total'];
    $JumlahLaporanPenggunaFormat = number_format($JumlahLaporanPengguna, 0, ',', '.');

    // Menentukan Link Gambar/Foto Profil ($SessionGambar dari Session.php)
    if(empty($SessionGambar)){
        $link_foto = "$base_url/assets/images/No-Image.png";
    }else{
        $link_foto = "$base_url/assets/images/user/$SessionGambar";
    }
?>
<div class="row mb-3">
    <div class="col-md-12 mb-4 text-center">
        <img src="<?php echo $link_foto;?>" width="150px" height="150px" class="img-radius">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 mb-4">
        <?php
            echo '
                <div class="row mb-2">
                    <div class="col-5"><small>Nama</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$SessionNama.'</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Kontak</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$SessionKontak.'</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Email</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$SessionEmail.'</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Level/Entitas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$SessionAkses.'</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Daftar</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.date('d/m/Y H:i', strtotime($SessionTanggal)).'</small>
                    </div>
                </div>
                    <div class="row mb-2">
                    <div class="col-5"><small>Updatetime Terakhir</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.date('d/m/Y H:i', strtotime($SessionUpdatetime)).'</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Aktivitas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$JumlahLogProfileFormat.' Record</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Laporan User</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$JumlahLaporanPenggunaFormat.' Record</small>
                    </div>
                </div>
            ';
        ?>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-12 icon-btn text-center">
        <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalEditFoto" title="Ubah Foto Profile">
            <i class="bi bi-image"></i>
        </button>
        <button type="button" class="btn btn-round btn-sm btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalEditProfile" title="Edit Profile">
            <i class="bi bi-pencil"></i>
        </button>
        <button type="button" class="btn btn-round btn-sm btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalGantiPassword" title="Ganti Password">
            <i class="bi bi-lock"></i>
        </button>
    </div>
</div>
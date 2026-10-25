<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi Dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Validasi Sesi Login
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang</div>
        ';
        exit;
    }

    // Routing IHS dan NIK
    if(empty($SessionNik)){
        $SessionNik = "-";
    }

    if(empty($SessionIhs)){
        $SessionIhs = "-";
    }

    // Menampilkan foto profil dari penyimpanan saat ini, dengan dukungan gambar lama.
    $nama_foto = basename((string) $SessionGambar);
    $path_foto = __DIR__ . "/../../assets/img/user/$nama_foto";
    $path_foto_lama = __DIR__ . "/../../assets/images/user/$nama_foto";

    if ($nama_foto !== '' && is_file($path_foto)) {
        $link_foto = "$base_url/assets/img/user/" . rawurlencode($nama_foto);
    } elseif ($nama_foto !== '' && is_file($path_foto_lama)) {
        $link_foto = "$base_url/assets/images/user/" . rawurlencode($nama_foto);
    } else {
        $link_foto = "$base_url/assets/img/user/No-Image.png";
    }
?>
<div class="row mb-3">
    <div class="col-md-12 mb-4 text-center">
        <img src="<?php echo htmlspecialchars($link_foto, ENT_QUOTES, 'UTF-8'); ?>" width="150" height="150" class="img-radius" alt="Foto profil pengguna">
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
                    <div class="col-5"><small>NIK/KTP</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$SessionNik.'</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>IHS - SATUSEHAT</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted">'.$SessionIhs.'</small>
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
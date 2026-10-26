<?php
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
    $SessionTanggalIso = htmlspecialchars(str_replace(' ', 'T', (string) $SessionTanggal) . 'Z', ENT_QUOTES, 'UTF-8');
    $SessionTanggalFallback = htmlspecialchars((string) $SessionTanggal . ' UTC', ENT_QUOTES, 'UTF-8');
    $SessionUpdatetimeIso = htmlspecialchars(str_replace(' ', 'T', (string) $SessionUpdatetime) . 'Z', ENT_QUOTES, 'UTF-8');
    $SessionUpdatetimeFallback = htmlspecialchars((string) $SessionUpdatetime . ' UTC', ENT_QUOTES, 'UTF-8');

    // Menampilkan foto profil dari penyimpanan saat ini, dengan dukungan gambar lama.
    $nama_foto = basename((string) $SessionGambar);
    $path_foto = __DIR__ . "/../../assets/img/user/$nama_foto";
    $path_foto_lama = __DIR__ . "/../../assets/images/user/$nama_foto";

    if ($nama_foto !== '' && is_file($path_foto)) {
        $link_foto = "assets/img/user/" . rawurlencode($nama_foto);
    } elseif ($nama_foto !== '' && is_file($path_foto_lama)) {
        $link_foto = "assets/images/user/" . rawurlencode($nama_foto);
    } else {
        $link_foto = "assets/img/user/No-Image.png";
    }
    $barisNama = '';
    if (trim((string) $SessionNama) !== 'Admin Faskes') {
        $barisNama = '
            <div class="row mb-2">
                <div class="col-5"><small>Nama</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-muted">' . htmlspecialchars((string) $SessionNama, ENT_QUOTES, 'UTF-8') . '</small>
                </div>
            </div>
        ';
    }
?>
<div class="row mb-3">
    <div class="col-md-12 mb-4 text-center">
        <img src="<?php echo htmlspecialchars($link_foto, ENT_QUOTES, 'UTF-8'); ?>" width="150" height="150" class="img-radius" alt="Foto profil pengguna" onerror="this.onerror=null;this.src='assets/img/user/No-Image.png';">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 mb-4">
        <?php
            echo '
                ' . $barisNama . '
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
                        <small class="text text-muted"><time class="profile-local-datetime" datetime="'.$SessionTanggalIso.'">'.$SessionTanggalFallback.'</time></small>
                    </div>
                </div>
                    <div class="row mb-2">
                    <div class="col-5"><small>Updatetime Terakhir</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-muted"><time class="profile-local-datetime" datetime="'.$SessionUpdatetimeIso.'">'.$SessionUpdatetimeFallback.'</time></small>
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
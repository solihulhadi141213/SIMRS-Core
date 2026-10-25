<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi
    include "_Config/Connection.php";

    // Include Setting
    include "_Config/SettingGeneral.php";

    // Simrs Function
    include "_Config/SimrsFunction.php";

    // Session
    include "_Config/Session.php";

    // Jika Sesi Akses Belum Ada Maka Redirect
    if(empty($SessionIdAkses)||empty($SessionNama)){
        include "_Page/Login/login.php";
        exit;
    }

    if(empty($SessionGambar)){
        $LinkFotoProfile="avatar-blank.jpg";
    }else{
        $LinkFotoProfile="user/$SessionGambar";
    }

    // Routing Page
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
    }else{
        $Page="";
    }

    // List Halaman : Berfungsi Untuk Menentukan Title Halaman Yang Sesuai
    $list_halaman = [
        "Profile"               => "Profile",
        "Setting"               => "Setting",
        "ApiKey"                => "API Key",
        "EmailGateway"          => "Email Gateway",
        "AksesFitur"            => "Fitur Aplikasi",
        "AksesEntitas"          => "Entitas Akses",
        "Akses"                 => "Akses Pengguna",
        "AksesPengajuan"        => "Pengajuan Akses",
        "SettingSatuSehat"      => "Setting SATUSEHAT",
        "SettingBpjs"           => "Setting BPJS",
        "SettingRadix"          => "Setting Radix",
        "SettingAnalyza"        => "Setting Analyza",
        "SettingSifarma"        => "Setting Sifarma",
        "LaporanKesalahan"      => "Laporan Kesalahan",
        "ReferensiPoliklinik"   => "Poliklinik",
        "ReferensiDokter"       => "Dokter",
        "ReferensiJadwalDokter" => "Jadwal Praktek",
        "ReferensiPraktisi"     => "Praktisi / SDM",
        "ReferensiRuangRawat"   => "Ruang Rawat",
        "ReferensiIcd"          => "ICD",
        "ReferensiTindakan"     => "Referensi Tindakan",
        "ReferensiAlergen"      => "Allergens",
        "ReferensiObservation"  => "Referensi Observation",
        "ReferensiWilayah"      => "Wilayah",
        "Pasien"                => "Pasien",
        "Kunjungan"             => "Kunjungan",
        "GeneralConsent"        => "General Consent",
        "Diagnosis"             => "Diagnosis",
        "Tindakan"              => "Tindakan",
        "Alergi"                => "Alergi",
        "Laboratorium"          => "Laboratorium",
    ];
    
    // Menentukan Judul Halaman
    $judul_halaman = isset($list_halaman[$Page]) 
    ? $list_halaman[$Page] 
    : "Dashboard";
?>
<!DOCTYPE html>
<html lang="id">
    <?php
        include "_Partial/Head.php";
    ?>
    <body class="application-shell">
        <?php
            // Untuk menampilkan Pre Loader Disini
            include "_Partial/PreLoader.php";
        ?>
        <div id="pcoded" class="pcoded" theme-layout="vertical" vertical-nav-type="expanded" vertical-effect="push" vertical-placement="left" vertical-layout="wide" pcoded-device-type="desktop">
            <button type="button" class="pcoded-overlay-box" aria-label="Tutup menu"></button>
            <div class="pcoded-container navbar-wrapper">
                <header class="navbar header-navbar pcoded-header bg-primary">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <button type="button" class="mobile-menu sidebar-menu-toggle" data-layout-toggle="sidebar" aria-label="Buka menu" aria-controls="main-navigation" aria-expanded="false">
                                <i class="bi bi-list" aria-hidden="true"></i>
                            </button>
                            <a href="index.php" class="brand-link" aria-label="Beranda <?php echo htmlspecialchars($hospital_name, ENT_QUOTES, 'UTF-8'); ?>">
                                <span><?php echo htmlspecialchars($hospital_name, ENT_QUOTES, 'UTF-8'); ?></span>
                            </a>
                        </div>
                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <li>
                                    <button type="button" class="sidebar_toggle sidebar-menu-toggle" data-layout-toggle="sidebar" aria-label="Tutup menu" aria-controls="main-navigation" aria-expanded="true">
                                        <i class="bi bi-list" aria-hidden="true"></i>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="header-action" data-fullscreen-toggle aria-label="Tampilan layar penuh">
                                        <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
                                    </button>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <?php
                                    //Menampilkan Dropdown Notifikasi
                                    include "_Partial/Notification.php";
                                ?>

                                <!-- Menampilkan Dropdown Profil -->
                                <li class="user-profile header-notification">
                                    <a href="javascript:void(0);" class="profile-toggle" aria-expanded="false" aria-label="Menu pengguna <?php echo htmlspecialchars($SessionNama, ENT_QUOTES, 'UTF-8'); ?>">
                                        <img src="assets/img/<?php echo htmlspecialchars($LinkFotoProfile, ENT_QUOTES, 'UTF-8'); ?>" class="img-radius" width="40" height="40" alt="">
                                        <span><?php echo htmlspecialchars($SessionNama, ENT_QUOTES, 'UTF-8'); ?></span>
                                        <i class="bi bi-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="show-notification profile-notification">
                                        <li class="waves-effect waves-light border-bottom border-1 border-bottom-default">
                                            <a href="index.php?Page=Profile" class="profile-menu-link">
                                                <i class="bi bi-person" aria-hidden="true"></i> <span>Profile</span>
                                            </a>
                                        </li>
                                        <li class="waves-effect waves-light border-bottom border-1 border-bottom-default">
                                            <a href="index.php?Page=Help" class="profile-menu-link">
                                                <i class="bi bi-question-circle" aria-hidden="true"></i> <span>Bantuan</span>
                                            </a>
                                        </li>
                                        <li class="waves-effect waves-light border-bottom border-1 border-bottom-default">
                                            <a href="javascript:void(0);" class="profile-menu-link" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                                                <i class="bi bi-box-arrow-right" aria-hidden="true"></i> <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Menampilkan Dropdown Profil / END -->
                            </ul>
                        </div>
                    </div>
                </header>
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar" id="main-navigation" aria-label="Menu utama">
                            <?php
                                // Menampilkan Menu Kiri
                                include "_Partial/Menu.php";
                            ?>
                        </nav>
                        <main class="pcoded-content" id="main-content">
                            <?php
                                // Routing Halaman
                                include "_Partial/RoutingPage.php";
                            ?>
                        </main>
                    </div>
                </div>
            </div>
        </div>   
        <footer id="app-footer" class="application-footer">
            <?php include "_Partial/Copyright.php"; ?>
        </footer>
        <?php
            // Footer JS
            include "_Partial/FooterJs.php";

            //Routing Modal
            include "_Partial/Modal.php";

            // Include Toast
            include "_Partial/Toast.php";

            //Routing Page JS
            include "_Partial/RoutingJs.php";

            //RoutingSwall
            include "_Partial/RoutingSwal.php";
        ?>
    </body>
</html>
<?php
    $routes = [
        'Dashboard'             => '_Page/Dashboard/Dashboard.php',
        'Profile'               => '_Page/ProfileUser/ProfileUser.php',
        'Setting'               => '_Page/Setting/Setting.php',
        'ApiKey'                => '_Page/ApiKey/ApiKey.php',
        'EmailGateway'          => '_Page/EmailGateway/EmailGateway.php',
        'GoogleCredential'      => '_Page/GoogleCredential/GoogleCredential.php',
        'AksesFitur'            => '_Page/AksesFitur/AksesFitur.php',
        'AksesEntitas'          => '_Page/AksesEntitas/AksesEntitas.php',
        'Akses'                 => '_Page/Akses/Akses.php',
        'AksesPengajuan'        => '_Page/AksesPengajuan/AksesPengajuan.php',
        'SettingSatuSehat'      => '_Page/SettingSatuSehat/SettingSatuSehat.php',
        'SettingBpjs'           => '_Page/SettingBpjs/SettingBpjs.php',
        'SettingSirsOnline'     => '_Page/SettingSirsOnline/SettingSirsOnline.php',
        'SettingRadix'          => '_Page/SettingRadix/SettingRadix.php',
        'SettingAnalyza'        => '_Page/SettingAnalyza/SettingAnalyza.php',
        'SettingSifarma'        => '_Page/SettingSifarma/SettingSifarma.php',
        'LaporanKesalahan'      => '_Page/LaporanKesalahan/LaporanKesalahan.php',
        'ReferensiPoliklinik'   => '_Page/ReferensiPoliklinik/ReferensiPoliklinik.php',
        'ReferensiDokter'       => '_Page/ReferensiDokter/ReferensiDokter.php',
        'ReferensiJadwalDokter' => '_Page/ReferensiJadwalDokter/ReferensiJadwalDokter.php',
        'ReferensiPraktisi'     => '_Page/ReferensiPraktisi/ReferensiPraktisi.php',
        'ReferensiRuangRawat'   => '_Page/ReferensiRuangRawat/ReferensiRuangRawat.php',
        'ReferensiIcd'          => '_Page/ReferensiIcd/ReferensiIcd.php',
        'ReferensiTindakan'     => '_Page/ReferensiTindakan/ReferensiTindakan.php',
        'ReferensiAlergen'      => '_Page/ReferensiAlergen/ReferensiAlergen.php',
        'ReferensiObservation'  => '_Page/ReferensiObservation/ReferensiObservation.php',
        'ReferensiWilayah'      => '_Page/ReferensiWilayah/ReferensiWilayah.php',
        'ReferensiWilayahBpjs'  => '_Page/ReferensiWilayahBpjs/ReferensiWilayahBpjs.php',
        'ReferensiIcdBpjs'      => '_Page/ReferensiIcdBpjs/ReferensiIcdBpjs.php',
        'ReferensiDpho'         => '_Page/ReferensiDpho/ReferensiDpho.php',
        'ReferensiImunisasi'    => '_Page/ReferensiImunisasi/ReferensiImunisasi.php',
        'ReferensiBodySite'    => '_Page/ReferensiBodySite/ReferensiBodySite.php',
        'Pasien'                => '_Page/Pasien/Pasien.php',
        'Kunjungan'             => '_Page/Kunjungan/Kunjungan.php',
        'Antrian'               => '_Page/Antrian/Antrian.php',
        'GeneralConsent'        => '_Page/GeneralConsent/GeneralConsent.php',
        'Observasi'             => '_Page/Observasi/Observasi.php',
        'Diagnosis'             => '_Page/Diagnosis/Diagnosis.php',
        'Tindakan'              => '_Page/Tindakan/Tindakan.php',
        'Alergi'                => '_Page/Alergi/Alergi.php',
        'Imunisasi'             => '_Page/Imunisasi/Imunisasi.php',
        'Laboratorium'          => '_Page/Laboratorium/Laboratorium.php',
    ];

    // Berikut ini adalah array yang berisi informasi breadcrumb untuk setiap halaman. Setiap entri memiliki format:
    // 'NamaHalaman' => ['NamaFitur', 'NamaHalamanFitur', 'NamaSubFitur']
    $breadcrumbRoutes = [
        'Setting'               => ['Pengaturan', 'Setting', null],
        'ApiKey'                => ['Pengaturan', 'Setting', 'API Key'],
        'EmailGateway'          => ['Pengaturan', 'Setting', 'Email Gateway'],
        'GoogleCredential'      => ['Pengaturan', 'Setting', 'Google Credential'],
        'AksesFitur'            => ['Aksesibilitas', 'Akses', 'Fitur Aplikasi'],
        'AksesEntitas'          => ['Aksesibilitas', 'Akses', 'Entitas Akses'],
        'Akses'                 => ['Aksesibilitas', 'Akses', 'Akun Akses'],
        'AksesPengajuan'        => ['Aksesibilitas', 'Akses', 'Pengajuan Akses'],
        'SettingSatuSehat'      => ['Pengaturan Integrasi', 'Setting', 'SATUSEHAT'],
        'SettingBpjs'           => ['Pengaturan Integrasi', 'Setting', 'BPJS'],
        'SettingSirsOnline'     => ['Pengaturan Integrasi', 'Setting', 'SIRS Online'],
        'SettingRadix'          => ['Pengaturan Integrasi', 'Setting', 'Radix'],
        'SettingAnalyza'        => ['Pengaturan Integrasi', 'Setting', 'Analyza'],
        'SettingSifarma'        => ['Pengaturan Integrasi', 'Setting', 'Sifarma'],
        'LaporanKesalahan'      => ['Laporan Kesalahan', null, null],
        'ReferensiPoliklinik'   => ['Referensi Lokal', 'ReferensiPoliklinik', 'Poliklinik'],
        'ReferensiDokter'       => ['Referensi Lokal', 'ReferensiPoliklinik', 'Dokter'],
        'ReferensiJadwalDokter' => ['Menu Utama', 'Dashboard', 'Jadwal Dokter'],
        'ReferensiPraktisi'     => ['Referensi Lokal', 'ReferensiPoliklinik', 'Tenaga Medis'],
        'ReferensiRuangRawat'   => ['Referensi Lokal', 'ReferensiPoliklinik', 'Ruang Rawat'],
        'ReferensiIcd'          => ['Referensi Lokal', 'ReferensiPoliklinik', 'ICD'],
        'ReferensiTindakan'     => ['Referensi Lokal', 'ReferensiPoliklinik', 'Procedure'],
        'ReferensiAlergen'      => ['Referensi Lokal', 'ReferensiPoliklinik', 'Alergen'],
        'ReferensiObservation'  => ['Referensi Lokal', 'ReferensiPoliklinik', 'Observation'],
        'ReferensiWilayah'      => ['Referensi Lokal', 'ReferensiPoliklinik', 'Wilayah'],
        'ReferensiWilayahBpjs'  => ['Referensi BPJS', 'ReferensiWilayahBpjs', 'Wilayah'],
        'ReferensiIcdBpjs'      => ['Referensi BPJS', 'ReferensiWilayahBpjs', 'ICD'],
        'ReferensiDpho'         => ['Referensi BPJS', 'ReferensiWilayahBpjs', 'DPHO'],
        'ReferensiImunisasi'    => ['Dashboard', 'Referensi Imunisasi', null],
        'ReferensiBodySite'    => ['Dashboard', 'Referensi Body Site', null],
        'Pasien'                => ['Menu Utama', 'Dashboard', 'Pasien'],
        'Kunjungan'             => ['Menu Utama', 'Dashboard', 'Kunjungan'],
        'Antrian'               => ['Menu Utama', 'Dashboard', 'Antrian'],
        'GeneralConsent'        => ['Rekam Medis', 'GeneralConsent', 'General Consent'],
        'Observasi'             => ['Dashboard', 'Observasi', null],
        'Diagnosis'             => ['Rekam Medis', 'GeneralConsent', 'Diagnosis'],
        'Tindakan'              => ['Rekam Medis', 'GeneralConsent', 'Tindakan'],
        'Alergi'                => ['Rekam Medis', 'GeneralConsent', 'Alergi'],
        'Imunisasi'             => ['Imunisasi', 'Dashboard', null],
        'Laboratorium'          => ['Rekam Medis', 'GeneralConsent', 'Laboratorium'],
    ];

    $page = trim($_GET['Page'] ?? '');

    if ($page === '') {
        include $routes['Dashboard'];
    } elseif (isset($routes[$page])) {
        if (in_array($page, ['Dashboard', 'Profile'], true)) {
            include $routes[$page];
        } else {
            [$feature, $featurePage, $subFeature] = $breadcrumbRoutes[$page];
            // Header route menyatukan judul halaman dan breadcrumb dalam satu tata letak.
            echo '<div class="routed-page"><div class="route-breadcrumb">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                ';
            if ($subFeature !== null) {
                if ($featurePage !== null) {
                    echo '<li class="breadcrumb-item"><a href="index.php?Page=' . rawurlencode($featurePage) . '">' . htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') . '</a></li>';
                } else {
                    echo '<li class="breadcrumb-item">' . htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') . '</li>';
                }
                echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($subFeature, ENT_QUOTES, 'UTF-8') . '</li>';
            } else {
                echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') . '</li>';
            }
            echo '</ol></nav></div>';
            include $routes[$page];
            echo '</div>';
        }
    } else {
        echo '<div class="routed-page"><div class="route-breadcrumb">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Halaman Tidak Ditemukan</li>
                    </ol>
                </nav>
            </div>';
        include '_Page/Error/PageNotFound.php';
        echo '</div>';
    }
?>
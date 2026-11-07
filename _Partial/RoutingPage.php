<?php
    $routes = [
        'Dashboard'                 => '_Page/Dashboard/Dashboard.php',
        'Profile'                   => '_Page/ProfileUser/ProfileUser.php',
        'Setting'                   => '_Page/Setting/Setting.php',
        'Log'                       => '_Page/Log/Log.php',
        'ApiKey'                    => '_Page/ApiKey/ApiKey.php',
        'EmailGateway'              => '_Page/EmailGateway/EmailGateway.php',
        'GoogleCredential'          => '_Page/GoogleCredential/GoogleCredential.php',
        'AksesFitur'                => '_Page/AksesFitur/AksesFitur.php',
        'AksesEntitas'              => '_Page/AksesEntitas/AksesEntitas.php',
        'Akses'                     => '_Page/Akses/Akses.php',
        'AksesPengajuan'            => '_Page/AksesPengajuan/AksesPengajuan.php',
        'SettingSatuSehat'          => '_Page/SettingSatuSehat/SettingSatuSehat.php',
        'SettingBpjs'               => '_Page/SettingBpjs/SettingBpjs.php',
        'SettingSirsOnline'         => '_Page/SettingSirsOnline/SettingSirsOnline.php',
        'SettingRadix'              => '_Page/SettingRadix/SettingRadix.php',
        'SettingAnalyza'            => '_Page/SettingAnalyza/SettingAnalyza.php',
        'SettingSifarma'            => '_Page/SettingSifarma/SettingSifarma.php',
        'LaporanKesalahan'          => '_Page/LaporanKesalahan/LaporanKesalahan.php',
        'ReferensiPoliklinik'       => '_Page/ReferensiPoliklinik/ReferensiPoliklinik.php',
        'ReferensiDokter'           => '_Page/ReferensiDokter/ReferensiDokter.php',
        'ReferensiJadwalDokter'     => '_Page/ReferensiJadwalDokter/ReferensiJadwalDokter.php',
        'ReferensiPraktisi'         => '_Page/ReferensiPraktisi/ReferensiPraktisi.php',
        'ReferensiRuangRawat'       => '_Page/ReferensiRuangRawat/ReferensiRuangRawat.php',
        'ReferensiIcd'              => '_Page/ReferensiIcd/ReferensiIcd.php',
        'ReferensiTindakan'         => '_Page/ReferensiTindakan/ReferensiTindakan.php',
        'ReferensiAlergen'          => '_Page/ReferensiAlergen/ReferensiAlergen.php',
        'ReferensiObservation'      => '_Page/ReferensiObservation/ReferensiObservation.php',
        'ReferensiWilayah'          => '_Page/ReferensiWilayah/ReferensiWilayah.php',
        'ReferensiWilayahBpjs'      => '_Page/ReferensiWilayahBpjs/ReferensiWilayahBpjs.php',
        'ReferensiIcdBpjs'          => '_Page/ReferensiIcdBpjs/ReferensiIcdBpjs.php',
        'ReferensiDpho'             => '_Page/ReferensiDpho/ReferensiDpho.php',
        'ReferensiImunisasi'        => '_Page/ReferensiImunisasi/ReferensiImunisasi.php',
        'ReferensiBodySite'         => '_Page/ReferensiBodySite/ReferensiBodySite.php',
        'ReferensiEpisodePerawatan' => '_Page/ReferensiEpisodePerawatan/ReferensiEpisodePerawatan.php',
        'Pasien'                    => '_Page/Pasien/Pasien.php',
        'Kunjungan'                 => '_Page/Kunjungan/Kunjungan.php',
        'Antrian'                   => '_Page/Antrian/Antrian.php',
        'GeneralConsent'            => '_Page/GeneralConsent/GeneralConsent.php',
        'Observasi'                 => '_Page/Observasi/Observasi.php',
        'Diagnosis'                 => '_Page/Diagnosis/Diagnosis.php',
        'Tindakan'                  => '_Page/Tindakan/Tindakan.php',
        'Alergi'                    => '_Page/Alergi/Alergi.php',
        'Imunisasi'                 => '_Page/Imunisasi/Imunisasi.php',
        'Laboratorium'              => '_Page/Laboratorium/Laboratorium.php',
        'Encounter'                 => '_Page/Encounter/Encounter.php',
        'EpisodePerawatan'          => '_Page/EpisodePerawatan/EpisodePerawatan.php',
    ];

    // Berikut ini adalah array yang berisi informasi breadcrumb untuk setiap halaman. Setiap entri memiliki format:
    // 'NamaHalaman' => ['NamaFitur', 'NamaHalamanFitur', 'NamaSubFitur']
    $breadcrumbRoutes = [
        'Setting'                   => ['Setting', null, null],
        'Log'                       => ['Log', null, null],
        'ApiKey'                    => ['API Key', null, null],
        'EmailGateway'              => ['Email Gateway', null, null],
        'GoogleCredential'          => ['Google Credential', null, null],
        'AksesFitur'                => ['Fitur Aplikasi', null, null],
        'AksesEntitas'              => ['Entitas Akses', null, null],
        'Akses'                     => ['Akun Akses', null, null],
        'AksesPengajuan'            => ['Pengajuan Akses', null, null],
        'SettingSatuSehat'          => ['Setting SATUSEHAT', null, null],
        'SettingBpjs'               => ['Setting BPJS', null, null],
        'SettingSirsOnline'         => ['Setting SIRS Online', null, null],
        'SettingRadix'              => ['Setting Radix', null, null],
        'SettingAnalyza'            => ['Setting Analyza', null, null],
        'SettingSifarma'            => ['Setting Sifarma', null, null],
        'LaporanKesalahan'          => ['Laporan Kesalahan', null, null],
        'ReferensiPoliklinik'       => ['Referensi Poliklinik', null, null],
        'ReferensiDokter'           => ['Referensi Dokter', null, null],
        'ReferensiJadwalDokter'     => ['Jadwal Dokter', null, null],
        'ReferensiPraktisi'         => ['Referensi Praktisi', null, null],
        'ReferensiRuangRawat'       => ['Ruang Rawat', null, null],
        'ReferensiIcd'              => ['Referensi Icd', null, null],
        'ReferensiTindakan'         => ['Referensi Tindakan', null, null],
        'ReferensiAlergen'          => ['Referensi Alergen', null, null],
        'ReferensiObservation'      => ['Referensi Observation', null, null],
        'ReferensiWilayah'          => ['Referensi Wilayah', null, null],
        'ReferensiWilayahBpjs'      => ['Referensi Wilayah Bpjs', null, null],
        'ReferensiIcdBpjs'          => ['Referensi ICD Bpjs', null, null],
        'ReferensiDpho'             => ['Referensi DPHO', null, null],
        'ReferensiImunisasi'        => ['Referensi Imunisasi', null, null],
        'ReferensiBodySite'         => ['Referensi Body Site', null, null],
        'ReferensiEpisodePerawatan' => ['Referensi Episode Perawatan', null, null],
        'Pasien'                    => ['Pasien', null, null],
        'Kunjungan'                 => ['Kunjungan', null, null],
        'Antrian'                   => ['Antrian', null, null],
        'GeneralConsent'            => ['General Consent', null, null],
        'Observasi'                 => ['Observasi', null, null],
        'Diagnosis'                 => ['Diagnosis', null, null],
        'Tindakan'                  => ['Tindakan', null, null],
        'Alergi'                    => ['Alergi', null, null],
        'Imunisasi'                 => ['Imunisasi', null, null],
        'Laboratorium'              => ['Laboratorium', null, null],
        'Encounter'                 => ['Encounter', null, null],
        'EpisodePerawatan'          => ['Episode Perawatan', null, null],
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
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
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
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
        'Pasien'                => '_Page/Pasien/Pasien.php',
        'Kunjungan'             => '_Page/Kunjungan/Kunjungan.php',
        'GeneralConsent'        => '_Page/GeneralConsent/GeneralConsent.php',
        'Diagnosis'             => '_Page/Diagnosis/Diagnosis.php',
        'Tindakan'              => '_Page/Tindakan/Tindakan.php',
        'Alergi'                => '_Page/Alergi/Alergi.php',
    ];

    $page = trim($_GET['Page'] ?? '');

    if ($page === '') {
        include $routes['Dashboard'];
    } elseif (isset($routes[$page])) {
        include $routes[$page];
    } else {
        include '_Page/Error/PageNotFound.php';
    }
?>
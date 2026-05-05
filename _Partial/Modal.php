<?php
    // Routing modal yang mudah dirawat dan lebih cepat diproses.
    // Global modals: selalu disertakan.
    $globalModals = [
        '_Page/Dashboard/ModalDashboard.php',
        '_Page/Logout/ModalLogout.php',
    ];

    // Peta halaman -> file modal; gunakan satu sumber kebenaran agar mudah ditambah.
    $modalRoutes = [
        'Profile'               => '_Page/ProfileUser/ModalProfileUser.php',
        'Setting'               => '_Page/Setting/ModalSetting.php',
        'ApiKey'                => '_Page/ApiKey/ModalApiKey.php',
        'EmailGateway'          => '_Page/EmailGateway/ModalEmailGateway.php',
        'GoogleCredential'      => '_Page/GoogleCredential/ModalGoogleCredential.php',
        'AksesFitur'            => '_Page/AksesFitur/ModalAksesFitur.php',
        'AksesEntitas'          => '_Page/AksesEntitas/ModalAksesEntitas.php',
        'Akses'                 => '_Page/Akses/ModalAkses.php',
        'AksesPengajuan'        => '_Page/AksesPengajuan/ModalAksesPengajuan.php',
        'SettingSatuSehat'      => '_Page/SettingSatuSehat/ModalSettingSatuSehat.php',
        'SettingBpjs'           => '_Page/SettingBpjs/ModalSettingBpjs.php',
        'SettingSirsOnline'     => '_Page/SettingSirsOnline/ModalSettingSirsOnline.php',
        'SettingRadix'          => '_Page/SettingRadix/ModalSettingRadix.php',
        'SettingAnalyza'        => '_Page/SettingAnalyza/ModalSettingAnalyza.php',
        'SettingSifarma'        => '_Page/SettingSifarma/ModalSettingSifarma.php',
        'LaporanKesalahan'      => '_Page/LaporanKesalahan/ModalLaporanKesalahan.php',
        'ReferensiPoliklinik'   => '_Page/ReferensiPoliklinik/ModalReferensiPoliklinik.php',
        'ReferensiDokter'       => '_Page/ReferensiDokter/ModalReferensiDokter.php',
        'ReferensiJadwalDokter' => '_Page/ReferensiJadwalDokter/ModalReferensiJadwalDokter.php',
        'ReferensiRuangRawat'   => '_Page/ReferensiRuangRawat/ModalReferensiRuangRawat.php',
        'ReferensiIcd'          => '_Page/ReferensiIcd/ModalReferensiIcd.php',
        'ReferensiWilayah'      => '_Page/ReferensiWilayah/ModalReferensiWilayah.php',
        'ReferensiWilayahBpjs'  => '_Page/ReferensiWilayahBpjs/ModalReferensiWilayahBpjs.php',
        'ReferensiIcdBpjs'      => '_Page/ReferensiIcdBpjs/ModalReferensiIcdBpjs.php',
    ];

    /**
     * Sertakan file jika ada. Membungkus include agar aman saat file hilang.
     */
    $safeInclude = static function (string $path): void {
        if (is_file($path)) {
            include $path;
        }
    };

    foreach ($globalModals as $modalPath) {
        $safeInclude($modalPath);
    }

    if (!empty($Page) && isset($modalRoutes[$Page])) {
        $safeInclude($modalRoutes[$Page]);
    }
?>

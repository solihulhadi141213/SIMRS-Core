<?php
    // Routing modal yang mudah dirawat dan lebih cepat diproses.
    // Global modals: selalu disertakan.
    $globalModals = [
        '_Page/Dashboard/ModalDashboard.php',
        '_Page/Logout/ModalLogout.php',
    ];

    // Peta halaman -> file modal; gunakan satu sumber kebenaran agar mudah ditambah.
    $modalRoutes = [
        'ProfileUser'               => '_Page/ProfileUser/ModalProfileUser.php',
        'Bantuan'                   => '_Page/Bantuan/ModalBantuan.php',
        'Help'                      => '_Page/Bantuan/ModalBantuan.php',
        'Akses'                     => '_Page/Akses/ModalAkses.php',
        'Aksesibilitas'             => '_Page/Aksesibilitas/ModalAksesibilitas.php',
        'SettingProfile'            => '_Page/ProfileFaskes/ModalSettingProfileFaskes.php',
        'Referensi'                 => '_Page/Referensi/ModalReferensi.php',
        'SettingBridging'           => '_Page/SettingBridging/ModalSettingBridging.php',
        'Log'                       => '_Page/Log/ModalLog.php',
        'Database'                  => '_Page/Database/ModalDatabase.php',
        'Poliklinik'                => '_Page/Poliklinik/ModalPoliklinik.php',
        'Dokter'                    => '_Page/Dokter/ModalDokter.php',
        'JadwalDokter'              => '_Page/JadwalDokter/ModalJadwalDokter.php',
        'Wilayah'                   => '_Page/Wilayah/ModalWilayah.php',
        'KelasRuangan'              => '_Page/KelasRuangan/ModalKelasRuangan.php',
        'Pasien'                    => '_Page/Pasien/ModalPasien.php',
        'RawatJalan'                => '_Page/RawatJalan/ModalRawatJalan.php',
        'SuratKontrol'              => '_Page/SuratKontrol/ModalSuratKontrol.php',
        'Approval'                  => '_Page/Approval/ModalApproval.php',
        'Rujukan'                   => '_Page/Rujukan/ModalRujukan.php',
        'Fingerprint'               => '_Page/Fingerprint/ModalFingerprint.php',
        'Antrian'                   => '_Page/Antrian/ModalAntrian.php',
        'MonitorAntrian'            => '_Page/MonitorAntrian/ModalMonitorAntrian.php',
        'AntrianPanggil'            => '_Page/AntrianPanggil/ModalAntrianPanggil.php',
        'JadwalOperasi'             => '_Page/JadwalOperasi/ModalJadwalOperasi.php',
        'MonitoringBaru'            => '_Page/MonitoringBaru/ModalMonitoringBaru.php',
        'Signature'                 => '_Page/Signature/ModalSignature.php',
        'Diagnosa'                  => '_Page/Diagnosa/ModalDiagnosa.php',
        'SettingPercetakan'         => '_Page/SettingPercetakan/ModalSettingPercetakan.php',
        'Obat'                      => '_Page/Obat/ModalObat.php',
        'ObatStorage'               => '_Page/ObatStorage/ModalObatStorage.php',
        'WebSetting'                => '_Page/WebSetting/ModalWebSetting.php',
        'WebTentang'                => '_Page/WebTentang/ModalWebTentang.php',
        'WebMetaTag'                => '_Page/WebMetaTag/ModalWebMetaTag.php',
        'WebSlider'                 => '_Page/WebSlider/ModalWebSlider.php',
        'WebFAQ'                    => '_Page/WebFAQ/ModalWebFAQ.php',
        'WebMedsos'                 => '_Page/WebMedsos/ModalWebMedsos.php',
        'WebSo'                     => '_Page/WebSo/ModalWebSo.php',
        'WebArtikel'                => '_Page/WebArtikel/ModalWebArtikel.php',
        'WebEvent'                  => '_Page/WebEvent/ModalWebEvent.php',
        'WebArsip'                  => '_Page/WebArsip/ModalWebArsip.php',
        'WebDokter'                 => '_Page/WebDokter/ModalWebDokter.php',
        'WebPoliklinik'             => '_Page/WebPoliklinik/ModalWebPoliklinik.php',
        'WebSambutan'               => '_Page/WebSambutan/ModalWebSambutan.php',
        'WebRuangRawat'             => '_Page/WebRuangRawat/ModalWebRuangRawat.php',
        'WebUnit'                   => '_Page/WebUnit/ModalWebUnit.php',
        'WebTestimoni'              => '_Page/WebTestimoni/ModalWebTestimoni.php',
        'WebEmailGateway'           => '_Page/WebEmailGateway/ModalWebEmailGateway.php',
        'WebLoker'                  => '_Page/WebLoker/ModalWebLoker.php',
        'WebBantuan'                => '_Page/WebBantuan/ModalWebBantuan.php',
        'WebHubungiAdmin'           => '_Page/WebHubungiAdmin/ModalWebHubungiAdmin.php',
        'WebSiteMap'                => '_Page/WebSiteMap/ModalWebSiteMap.php',
        'WebFooter'                 => '_Page/WebFooter/ModalWebFooter.php',
        'WebLaman'                  => '_Page/WebLaman/ModalWebLaman.php',
        'WebAksesPasien'            => '_Page/WebAksesPasien/ModalWebAksesPasien.php',
        'WebKunjungan'              => '_Page/WebKunjungan/ModalWebKunjungan.php',
        'Radiologi'                 => '_Page/Radiologi/ModalRadiologi.php',
        'Laboratorium'              => '_Page/Laboratorium/ModalLaboratorium.php',
        'Setting'                   => '_Page/Setting/ModalSetting.php',
        'sep'                       => '_Page/sep/ModalSep.php',
        'LaporanPengguna'           => '_Page/LaporanPengguna/ModalLaporanPengguna.php',
        'DashboardAntrol'           => '_Page/DashboardAntrol/ModalDashboardAntrol.php',
        'StokOpename'               => '_Page/StokOpename/ModalStokOpename.php',
        'Resep'                     => '_Page/Resep/ModalResep.php',
        'ExpiredLimit'              => '_Page/ExpiredLimit/ModalExpiredLimit.php',
        'TarifTindakan'             => '_Page/TarifTindakan/ModalTarifTindakan.php',
        'Supplier'                  => '_Page/Supplier/ModalSupplier.php',
        'AkunPerkiraan'             => '_Page/AkunPerkiraan/ModalAkunPerkiraan.php',
        'Transaksi'                 => '_Page/Transaksi/ModalTransaksi.php',
        'SirsOnline'                => '_Page/SirsOnline/ModalSirsOnline.php',
        'SirsOnlineAntrian'         => '_Page/SirsOnlineAntrian/ModalSirsOnlineAntrian.php',
        'PasienShk'                 => '_Page/PasienShk/ModalPasienShk.php',
        'SirsOnlineOksigen'         => '_Page/SirsOnlineOksigen/ModalSirsOnlineOksigen.php',
        'SirsOnlineTempatTidur'     => '_Page/SirsOnlineTempatTidur/ModalSirsOnlineTempatTidur.php',
        'SirsOnlineAlkes'           => '_Page/SirsOnlineAlkes/ModalSirsOnlineAlkes.php',
        'SirsOnlineNakesTerinfeksi' => '_Page/SirsOnlineNakesTerinfeksi/ModalSirsOnlineNakesTerinfeksi.php',
        'Alergi'                    => '_Page/Alergi/ModalAlergi.php',
        'Kfa'                       => '_Page/Kfa/ModalKfa.php',
        'Medication'                => '_Page/Medication/ModalMedication.php',
        'Api'                       => '_Page/Api/ModalApi.php',
        'KelasRuangan2'             => '_Page/KelasRuangan2/ModalKelasRuangan2.php',
        'Radix'                     => '_Page/Radix/ModalRadix.php',
        'Jurnal'                    => '_Page/Jurnal/ModalJurnal.php',
        'BukuBesar'                 => '_Page/BukuBesar/ModalBukuBesar.php',
        'NeracaSaldo'               => '_Page/NeracaSaldo/ModalNeracaSaldo.php',
        'Anggaran'                  => '_Page/Anggaran/ModalAnggaran.php',
        'Persediaan'                => '_Page/Persediaan/ModalPersediaan.php',
        'Kas'                       => '_Page/Kas/ModalKas.php',
        'PersediaanFarmasi'         => '_Page/PersediaanFarmasi/ModalPersediaanFarmasi.php',
        'Analyza'                   => '_Page/Analyza/ModalAnalyza.php',
        'Laboratorium2'             => '_Page/Laboratorium2/ModalLaboratorium2.php',
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

<?php
    //Routing modal di sini
    //Gunakan kondisi Page agar lebih ringan
    //Global 
    include "_Page/Dashboard/ModalDashboard.php";
    include "_Page/Logout/ModalLogout.php";

    // Berdasarkan $Page
    if($Page=="ProfileUser"){
        include "_Page/ProfileUser/ModalProfileUser.php";
    }elseif($Page=="Bantuan"||$Page=="Help"){
        include "_Page/Bantuan/ModalBantuan.php";
    }elseif($Page=="Akses"){
        include "_Page/Akses/ModalAkses.php";
    }elseif($Page=="Aksesibilitas"){
        include "_Page/Aksesibilitas/ModalAksesibilitas.php";
    }elseif($Page=="SettingProfile"){
        include "_Page/ProfileFaskes/ModalSettingProfileFaskes.php";
    }elseif($Page=="Referensi"){
        include "_Page/Referensi/ModalReferensi.php";
    }elseif($Page=="SettingBridging"){
        include "_Page/SettingBridging/ModalSettingBridging.php";
    }elseif($Page=="Log"){
        include "_Page/Log/ModalLog.php";
    }elseif($Page=="Database"){
        include "_Page/Database/ModalDatabase.php";
    }elseif($Page=="Poliklinik"){
        include "_Page/Poliklinik/ModalPoliklinik.php";
    }elseif($Page=="Dokter"){
        include "_Page/Dokter/ModalDokter.php";
    }elseif($Page=="JadwalDokter"){
        include "_Page/JadwalDokter/ModalJadwalDokter.php";
    }elseif($Page=="Wilayah"){
        include "_Page/Wilayah/ModalWilayah.php";
    }elseif($Page=="KelasRuangan"){
        include "_Page/KelasRuangan/ModalKelasRuangan.php";
    }elseif($Page=="Pasien"){
        include "_Page/Pasien/ModalPasien.php";
    }elseif($Page=="RawatJalan"){
        include "_Page/RawatJalan/ModalRawatJalan.php";
    }elseif($Page=="SuratKontrol"){
        include "_Page/SuratKontrol/ModalSuratKontrol.php";
    }elseif($Page=="Approval"){
        include "_Page/Approval/ModalApproval.php";
    }elseif($Page=="Rujukan"){
        include "_Page/Rujukan/ModalRujukan.php";
    }elseif($Page=="Fingerprint"){
        include "_Page/Fingerprint/ModalFingerprint.php";
    }elseif($Page=="Antrian"){
        include "_Page/Antrian/ModalAntrian.php";
    }elseif($Page=="MonitorAntrian"){
        include "_Page/MonitorAntrian/ModalMonitorAntrian.php";
    }elseif($Page=="AntrianPanggil"){
        include "_Page/AntrianPanggil/ModalAntrianPanggil.php";
    }elseif($Page=="JadwalOperasi"){
        include "_Page/JadwalOperasi/ModalJadwalOperasi.php";
    }elseif($Page=="MonitoringBaru"){
        include "_Page/MonitoringBaru/ModalMonitoringBaru.php";
    }elseif($Page=="Signature"){
        include "_Page/Signature/ModalSignature.php";
    }elseif($Page=="Diagnosa"){
        include "_Page/Diagnosa/ModalDiagnosa.php";
    }elseif($Page=="SettingPercetakan"){
        include "_Page/SettingPercetakan/ModalSettingPercetakan.php";
    }elseif($Page=="Obat"){
        include "_Page/Obat/ModalObat.php";
    }elseif($Page=="ObatStorage"){
        include "_Page/ObatStorage/ModalObatStorage.php";
    }elseif($Page=="WebSetting"){
        include "_Page/WebSetting/ModalWebSetting.php";
    }elseif($Page=="WebTentang"){
            include "_Page/WebTentang/ModalWebTentang.php";
    }elseif($Page=="WebMetaTag"){
        include "_Page/WebMetaTag/ModalWebMetaTag.php";
    }elseif($Page=="WebSlider"){
        include "_Page/WebSlider/ModalWebSlider.php";
    }elseif($Page=="WebFAQ"){
        include "_Page/WebFAQ/ModalWebFAQ.php";
    }elseif($Page=="WebMedsos"){
        include "_Page/WebMedsos/ModalWebMedsos.php";
    }elseif($Page=="WebSo"){
            include "_Page/WebSo/ModalWebSo.php";
    }elseif($Page=="WebArtikel"){
        include "_Page/WebArtikel/ModalWebArtikel.php";
    }elseif($Page=="WebEvent"){
        include "_Page/WebEvent/ModalWebEvent.php";
    }elseif($Page=="WebArsip"){
        include "_Page/WebArsip/ModalWebArsip.php";
    }elseif($Page=="WebDokter"){
        include "_Page/WebDokter/ModalWebDokter.php";
    }elseif($Page=="WebPoliklinik"){
        include "_Page/WebPoliklinik/ModalWebPoliklinik.php";
    }elseif($Page=="WebSambutan"){
        include "_Page/WebSambutan/ModalWebSambutan.php";
    }elseif($Page=="WebRuangRawat"){
        include "_Page/WebRuangRawat/ModalWebRuangRawat.php";
    }elseif($Page=="WebUnit"){
        include "_Page/WebUnit/ModalWebUnit.php";
    }elseif($Page=="WebTestimoni"){
        include "_Page/WebTestimoni/ModalWebTestimoni.php";
    }elseif($Page=="WebEmailGateway"){
        include "_Page/WebEmailGateway/ModalWebEmailGateway.php";
    }elseif($Page=="WebLoker"){
        include "_Page/WebLoker/ModalWebLoker.php";
    }elseif($Page=="WebBantuan"){
        include "_Page/WebBantuan/ModalWebBantuan.php";
    }elseif($Page=="WebHubungiAdmin"){
        include "_Page/WebHubungiAdmin/ModalWebHubungiAdmin.php";
    }elseif($Page=="WebSiteMap"){
        include "_Page/WebSiteMap/ModalWebSiteMap.php";
    }elseif($Page=="WebFooter"){
        include "_Page/WebFooter/ModalWebFooter.php";
    }elseif($Page=="WebLaman"){
        include "_Page/WebLaman/ModalWebLaman.php";
    }elseif($Page=="WebAksesPasien"){
        include "_Page/WebAksesPasien/ModalWebAksesPasien.php";
    }elseif($Page=="WebKunjungan"){
        include "_Page/WebKunjungan/ModalWebKunjungan.php";
    }elseif($Page=="Radiologi"){
        include "_Page/Radiologi/ModalRadiologi.php";
    }elseif($Page=="Laboratorium"){
        include "_Page/Laboratorium/ModalLaboratorium.php";
    }elseif($Page=="Setting"){
        include "_Page/Setting/ModalSetting.php";
    }elseif($Page=="sep"){
        include "_Page/sep/ModalSep.php";
    }elseif($Page=="LaporanPengguna"){
        include "_Page/LaporanPengguna/ModalLaporanPengguna.php";
    }elseif($Page=="DashboardAntrol"){
        include "_Page/DashboardAntrol/ModalDashboardAntrol.php";
    }elseif($Page=="StokOpename"){
        include "_Page/StokOpename/ModalStokOpename.php";
    }elseif($Page=="Resep"){
        include "_Page/Resep/ModalResep.php";
    }elseif($Page=="ExpiredLimit"){
        include "_Page/ExpiredLimit/ModalExpiredLimit.php";
    }elseif($Page=="TarifTindakan"){
        include "_Page/TarifTindakan/ModalTarifTindakan.php";
    }elseif($Page=="Supplier"){
        include "_Page/Supplier/ModalSupplier.php";
    }elseif($Page=="AkunPerkiraan"){
        include "_Page/AkunPerkiraan/ModalAkunPerkiraan.php";
    }elseif($Page=="Transaksi"){
        include "_Page/Transaksi/ModalTransaksi.php";
    }elseif($Page=="SirsOnline"){
        include "_Page/SirsOnline/ModalSirsOnline.php";
    }elseif($Page=="SirsOnlineAntrian"){
        include "_Page/SirsOnlineAntrian/ModalSirsOnlineAntrian.php";
    }elseif($Page=="PasienShk"){
        include "_Page/PasienShk/ModalPasienShk.php";
    }elseif($Page=="SirsOnlineOksigen"){
        include "_Page/SirsOnlineOksigen/ModalSirsOnlineOksigen.php";
    }elseif($Page=="SirsOnlineTempatTidur"){
        include "_Page/SirsOnlineTempatTidur/ModalSirsOnlineTempatTidur.php";
    }elseif($Page=="SirsOnlineAlkes"){
        include "_Page/SirsOnlineAlkes/ModalSirsOnlineAlkes.php";
    }elseif($Page=="SirsOnlineNakesTerinfeksi"){
        include "_Page/SirsOnlineNakesTerinfeksi/ModalSirsOnlineNakesTerinfeksi.php";
    }elseif($Page=="Alergi"){
        include "_Page/Alergi/ModalAlergi.php";
    }elseif($Page=="Kfa"){
        include "_Page/Kfa/ModalKfa.php";
    }elseif($Page=="Medication"){
        include "_Page/Medication/ModalMedication.php";
    }elseif($Page=="Api"){
        include "_Page/Api/ModalApi.php";
    }elseif($Page=="KelasRuangan2"){
        include "_Page/KelasRuangan2/ModalKelasRuangan2.php";
    }elseif($Page=="Radix"){
        include "_Page/Radix/ModalRadix.php";
    }elseif($Page=="Jurnal"){
        include "_Page/Jurnal/ModalJurnal.php";
    }elseif($Page=="BukuBesar"){
        include "_Page/BukuBesar/ModalBukuBesar.php";
    }elseif($Page=="NeracaSaldo"){
        include "_Page/NeracaSaldo/ModalNeracaSaldo.php";
    }elseif($Page=="Anggaran"){
        include "_Page/Anggaran/ModalAnggaran.php";
    }elseif($Page=="Persediaan"){
        include "_Page/Persediaan/ModalPersediaan.php";
    }elseif($Page=="Kas"){
        include "_Page/Kas/ModalKas.php";
    }elseif($Page=="PersediaanFarmasi"){
        include "_Page/PersediaanFarmasi/ModalPersediaanFarmasi.php";
    }elseif($Page=="Analyza"){
        include "_Page/Analyza/ModalAnalyza.php";
    }elseif($Page=="Laboratorium2"){
        include "_Page/Laboratorium2/ModalLaboratorium2.php";
    }else{
        // Tidak Include Apapun
    }
?>
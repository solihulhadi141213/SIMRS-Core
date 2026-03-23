<?php
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
        if($Page=="ProfileUser"){
            include "_Page/ProfileUser/ProfileUser.php";
        }elseif($Page=="Dashboard"){
            include "_Page/Dashboard/Dashboard.php";
        }elseif($Page=="Bantuan"){
            include "_Page/Bantuan/Bantuan.php";
        }elseif($Page=="Help"){
            include "_Page/Bantuan/Help.php";
        }elseif($Page=="Akses"){
            include "_Page/Akses/Akses.php";
        }elseif($Page=="Aksesibilitas"){
            include "_Page/Aksesibilitas/Aksesibilitas.php";
        }elseif($Page=="SettingProfile"){
            include "_Page/ProfileFaskes/SettingFaskes.php";
        }elseif($Page=="Referensi"){
            include "_Page/Referensi/Referensi.php";
        }elseif($Page=="SettingBridging"){
            include "_Page/SettingBridging/SettingBridging.php";
        }elseif($Page=="Log"){
            include "_Page/Log/Log.php";
        }elseif($Page=="Database"){
            include "_Page/Database/Database.php";
        }elseif($Page=="Poliklinik"){
            include "_Page/Poliklinik/Poliklinik.php";
        }elseif($Page=="Dokter"){
            include "_Page/Dokter/Dokter.php";
        }elseif($Page=="JadwalDokter"){
            include "_Page/JadwalDokter/JadwalDokter.php";
        }elseif($Page=="Wilayah"){
            include "_Page/Wilayah/Wilayah.php";
        }elseif($Page=="KelasRuangan"){
            include "_Page/KelasRuangan/KelasRuangan.php";
        }elseif($Page=="Pasien"){
            include "_Page/Pasien/Pasien.php";
        }elseif($Page=="RawatJalan"){
            include "_Page/RawatJalan/RawatJalan.php";
        }elseif($Page=="Approval"){
            include "_Page/Approval/Approval.php";
        }elseif($Page=="SuratKontrol"){
            include "_Page/SuratKontrol/SuratKontrol.php";
        }elseif($Page=="Rujukan"){
            include "_Page/Rujukan/Rujukan.php";
        }elseif($Page=="Fingerprint"){
            include "_Page/Fingerprint/Fingerprint.php";
        }elseif($Page=="Monitoring"){
            include "_Page/Monitoring/Monitoring.php";
        }elseif($Page=="MonitoringBaru"){
            include "_Page/MonitoringBaru/MonitoringBaru.php";
        }elseif($Page=="Signature"){
            include "_Page/Signature/Signature.php";
        }elseif($Page=="Antrian"){
            include "_Page/Antrian/Antrian.php";
        }elseif($Page=="MonitorAntrian"){
            include "_Page/MonitorAntrian/MonitorAntrian.php";
        }elseif($Page=="AntrianPanggil"){
            include "_Page/AntrianPanggil/AntrianPanggil.php";
        }elseif($Page=="MonitorRuangan"){
            include "_Page/MonitorRuangan/MonitorRuangan.php";
        }elseif($Page=="JadwalOperasi"){
            include "_Page/JadwalOperasi/JadwalOperasi.php";
        }elseif($Page=="Diagnosa"){
            include "_Page/Diagnosa/Diagnosa.php";
        }elseif($Page=="DashboardAntrol"){
            include "_Page/DashboardAntrol/DashboardAntrol.php";
        }elseif($Page=="SettingPercetakan"){
            include "_Page/SettingPercetakan/SettingPercetakan.php";
        }elseif($Page=="Obat"){
            include "_Page/Obat/Obat.php";
        }elseif($Page=="ObatStorage"){
            include "_Page/ObatStorage/ObatStorage.php";
        }elseif($Page=="WebSetting"){
            include "_Page/WebSetting/WebSetting.php";
        }elseif($Page=="WebTentang"){
            include "_Page/WebTentang/WebTentang.php";
        }elseif($Page=="WebMetaTag"){
            include "_Page/WebMetaTag/WebMetaTag.php";
        }elseif($Page=="WebSlider"){
            include "_Page/WebSlider/WebSlider.php";
        }elseif($Page=="WebFAQ"){
            include "_Page/WebFAQ/WebFAQ.php";
        }elseif($Page=="WebMedsos"){
            include "_Page/WebMedsos/WebMedsos.php";
        }elseif($Page=="WebSo"){
            include "_Page/WebSo/WebSo.php";
        }elseif($Page=="WebArtikel"){
            include "_Page/WebArtikel/WebArtikel.php";
        }elseif($Page=="WebEvent"){
            include "_Page/WebEvent/WebEvent.php";
        }elseif($Page=="WebArsip"){
            include "_Page/WebArsip/WebArsip.php";
        }elseif($Page=="WebDokter"){
            include "_Page/WebDokter/WebDokter.php";
        }elseif($Page=="WebPoliklinik"){
            include "_Page/WebPoliklinik/WebPoliklinik.php";
        }elseif($Page=="WebSambutan"){
            include "_Page/WebSambutan/WebSambutan.php";
        }elseif($Page=="WebRuangRawat"){
            include "_Page/WebRuangRawat/WebRuangRawat.php";
        }elseif($Page=="WebUnit"){
            include "_Page/WebUnit/WebUnit.php";
        }elseif($Page=="WebTestimoni"){
            include "_Page/WebTestimoni/WebTestimoni.php";
        }elseif($Page=="WebEmailGateway"){
            include "_Page/WebEmailGateway/WebEmailGateway.php";
        }elseif($Page=="WebLoker"){
            include "_Page/WebLoker/WebLoker.php";
        }elseif($Page=="WebBantuan"){
            include "_Page/WebBantuan/WebBantuan.php";
        }elseif($Page=="WebHubungiAdmin"){
            include "_Page/WebHubungiAdmin/WebHubungiAdmin.php";
        }elseif($Page=="WebSiteMap"){
            include "_Page/WebSiteMap/WebSiteMap.php";
        }elseif($Page=="WebMonitoring"){
            include "_Page/WebMonitoring/WebMonitoring.php";
        }elseif($Page=="WebFooter"){
            include "_Page/WebFooter/WebFooter.php";
        }elseif($Page=="WebLaman"){
            include "_Page/WebLaman/WebLaman.php";
        }elseif($Page=="WebAksesPasien"){
            include "_Page/WebAksesPasien/WebAksesPasien.php";
        }elseif($Page=="WebKunjungan"){
            include "_Page/WebKunjungan/WebKunjungan.php";
        }elseif($Page=="Radiologi"){
            include "_Page/Radiologi/Radiologi.php";
        }elseif($Page=="Laboratorium"){
            include "_Page/Laboratorium/Laboratorium.php";
        }elseif($Page=="Setting"){
            include "_Page/Setting/Setting.php";
        }elseif($Page=="sep"){
            include "_Page/sep/sep.php";
        }elseif($Page=="LaporanPengguna"){
            include "_Page/LaporanPengguna/LaporanPengguna.php";
        }elseif($Page=="StokOpename"){
            include "_Page/StokOpename/StokOpename.php";
        }elseif($Page=="Resep"){
            include "_Page/Resep/Resep.php";
        }elseif($Page=="ExpiredLimit"){
            include "_Page/ExpiredLimit/ExpiredLimit.php";
        }elseif($Page=="TarifTindakan"){
            include "_Page/TarifTindakan/TarifTindakan.php";
        }elseif($Page=="Supplier"){
            include "_Page/Supplier/Supplier.php";
        }elseif($Page=="AkunPerkiraan"){
            include "_Page/AkunPerkiraan/AkunPerkiraan.php";
        }elseif($Page=="Transaksi"){
            include "_Page/Transaksi/Transaksi.php";
        }elseif($Page=="SirsOnline"){
            include "_Page/SirsOnline/SirsOnline.php";
        }elseif($Page=="SirsOnlineAntrian"){
            include "_Page/SirsOnlineAntrian/SirsOnlineAntrian.php";
        }elseif($Page=="PasienShk"){
            include "_Page/PasienShk/PasienShk.php";
        }elseif($Page=="SirsOnlineOksigen"){
            include "_Page/SirsOnlineOksigen/SirsOnlineOksigen.php";
        }elseif($Page=="SirsOnlineTempatTidur"){
            include "_Page/SirsOnlineTempatTidur/SirsOnlineTempatTidur.php";
        }elseif($Page=="SirsOnlineAlkes"){
            include "_Page/SirsOnlineAlkes/SirsOnlineAlkes.php";
        }elseif($Page=="SirsOnlineNakesTerinfeksi"){
            include "_Page/SirsOnlineNakesTerinfeksi/SirsOnlineNakesTerinfeksi.php";
        }elseif($Page=="Alergi"){
            include "_Page/Alergi/Alergi.php";
        }elseif($Page=="Kfa"){
            include "_Page/Kfa/Kfa.php";
        }elseif($Page=="Medication"){
            include "_Page/Medication/Medication.php";
        }elseif($Page=="Api"){
            include "_Page/Api/Api.php";
        }elseif($Page=="TopDiagnosa"){
            include "_Page/TopDiagnosa/TopDiagnosa.php";
        }elseif($Page=="KelasRuangan2"){
            include "_Page/KelasRuangan2/KelasRuangan2.php";
        }elseif($Page=="Radix"){
            include "_Page/Radix/Radix.php";
        }elseif($Page=="Jurnal"){
            include "_Page/Jurnal/Jurnal.php";
        }elseif($Page=="BukuBesar"){
            include "_Page/BukuBesar/BukuBesar.php";
        }elseif($Page=="NeracaSaldo"){
            include "_Page/NeracaSaldo/NeracaSaldo.php";
        }elseif($Page=="Anggaran"){
            include "_Page/Anggaran/Anggaran.php";
        }elseif($Page=="Persediaan"){
            include "_Page/Persediaan/Persediaan.php";
        }elseif($Page=="Kas"){
            include "_Page/Kas/Kas.php";
        }elseif($Page=="PersediaanFarmasi"){
            include "_Page/PersediaanFarmasi/PersediaanFarmasi.php";
        }elseif($Page=="Analyza"){
            include "_Page/Analyza/Analyza.php";
        }elseif($Page=="Laboratorium2"){
            include "_Page/Laboratorium2/Laboratorium2.php";
        }else{
            include "_Page/Dashboard/Dashboard.php";
        }
    }else{
        $Page="";
        include "_Page/Dashboard/Dashboard.php";
    }
?>
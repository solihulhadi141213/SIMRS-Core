<?php
    if(!empty($_SESSION['NotifikasiSwal'])){
        $NotifikasiSwal=$_SESSION['NotifikasiSwal'];
        if($Page=="Akses"){
            include "_Page/Akses/NotifikasiAkses.php";
        }
        if($Page=="Setting"){
            include "_Page/Setting/NotifikasiSetting.php";
        }
        if($Page=="ProfileUser"){
            include "_Page/ProfileUser/NotifikasiProfile.php";
        }
        if($Page=="Referensi"){
            include "_Page/Referensi/NotifikasiReferensi.php";
        }
        if($Page=="Pasien"){
            include "_Page/pasien/NotifikasiPasien.php";
        }
        if($Page=="Antrian"){
            include "_Page/Antrian/NotifikasiAntrian.php";
        }
        if($Page=="sep"){
            include "_Page/sep/NotifikasiSep.php";
        }
        if($Page=="MonitoringBaru"){
            include "_Page/MonitoringBaru/NotifikasiMonitoringBaru.php";
        }
        if($Page=="Approval"){
            include "_Page/Approval/NotifikasiApproval.php";
        }
        if($Page=="JadwalOperasi"){
            include "_Page/JadwalOperasi/NotifikasiJadwalOperasi.php";
        }
        if($Page=="Obat"){
            include "_Page/Obat/NotifikasiObat.php";
        }
        if($Page=="ObatStorage"){
            include "_Page/ObatStorage/NotifikasiObatStorage.php";
        }
        if($Page=="LaporanPengguna"){
            include "_Page/LaporanPengguna/NotifikasiLaporanPengguna.php";
        }
        if($Page=="StokOpename"){
            include "_Page/StokOpename/NotifikasiStokOpename.php";
        }
        if($Page=="Resep"){
            include "_Page/Resep/NotifikasiResep.php";
        }
        if($Page=="ExpiredLimit"){
            include "_Page/ExpiredLimit/NotifikasiExpiredLimit.php";
        }
        if($Page=="SirsOnline"){
            include "_Page/SirsOnline/NotifikasiSirsOnline.php";
        }
        if($Page=="SirsOnlineAntrian"){
            include "_Page/SirsOnlineAntrian/NotifikasiSirsOnlineAntrian.php";
        }
        if($Page=="PasienShk"){
            include "_Page/PasienShk/NotifikasiPasienShk.php";
        }
        if($Page=="SirsOnlineOksigen"){
            include "_Page/SirsOnlineOksigen/NotifikasiSirsOnlineOksigen.php";
        }
        if($Page=="SirsOnlineTempatTidur"){
            include "_Page/SirsOnlineTempatTidur/NotifikasiSirsOnlineTempatTidur.php";
        }
        if($Page=="SirsOnlineAlkes"){
            include "_Page/SirsOnlineAlkes/NotifikasiSirsOnlineAlkes.php";
        }
        if($Page=="SirsOnlineNakesTerinfeksi"){
            include "_Page/SirsOnlineNakesTerinfeksi/NotifikasiSirsOnlineNakesTerinfeksi.php";
        }
        if($Page=="Alergi"){
            include "_Page/Alergi/NotifikasiAlergi.php";
        }
        if($Page=="Kfa"){
            include "_Page/Kfa/NotifikasiKfa.php";
        }
        if($Page=="Medication"){
            include "_Page/Medication/NotifikasiMedication.php";
        }
        //Tambahkan semua file Notifikasi Swall Disini
        include "_Page/Poliklinik/NotifikasiSwal.php";
        include "_Page/Dokter/NotifikasiDokter.php";
        include "_Page/Bantuan/NotifikasiBantuan.php";
        include "_Page/JadwalDokter/NotifikasiJadwalDokter.php";
        include "_Page/Wilayah/NotifikasiWilayah.php";
        include "_Page/KelasRuangan/NotifikasiKelasRuangan.php";
        include "_Page/RawatJalan/NotifikasiKunjungan.php";
        // include "_Page/Approval/NotifikasiApproval.php";
        include "_Page/SuratKontrol/NotifikasiSuratKontrol.php";
        include "_Page/Rujukan/NotifikasiRujukan.php";
        include "_Page/SettingPercetakan/NotifikasiPercetakan.php";
        include "_Page/WebSetting/NotifikasiWebSetting.php";
        include "_Page/WebTentang/NotifikasiWebTentang.php";
        include "_Page/WebMetaTag/NotifikasiWebMetaTag.php";
        include "_Page/WebSlider/NotifikasiWebSlider.php";
        include "_Page/WebFAQ/NotifikasiWebFAQ.php";
        include "_Page/WebMedsos/NotifikasiWebMedsos.php";
        include "_Page/WebSo/NotifikasiWebSo.php";
        include "_Page/WebArtikel/NotifikasiWebArtikel.php";
        include "_Page/WebDokter/NotifikasiWebDokter.php";
        include "_Page/WebPoliklinik/NotifikasiWebPoliklinik.php";
        include "_Page/WebSambutan/NotifikasiWebSambutan.php";
        include "_Page/WebEvent/NotifikasiWebEvent.php";
        include "_Page/WebRuangRawat/NotifikasiWebRuangRawat.php";
        include "_Page/WebUnit/NotifikasiWebUnit.php";
        include "_Page/WebTestimoni/NotifikasiWebTestimoni.php";
        include "_Page/WebEmailGateway/NotifikasiWebEmailGateway.php";
        include "_Page/WebLoker/NotifikasiWebLoker.php";
        include "_Page/WebBantuan/NotifikasiWebBantuan.php";
        include "_Page/WebHubungiAdmin/NotifikasiWebHubungiAdmin.php";
        include "_Page/WebLaman/NotifikasiWebLaman.php";
        include "_Page/WebAksesPasien/NotifikasiWebAksesPasien.php";
        include "_Page/WebKunjungan/NotifikasiWebKunjungan.php";
        include "_Page/Radiologi/NotifikasiRadiologi.php";
        include "_Page/Laboratorium/NotifikasiLaboratorium.php";
        include "_Page/Login/NotifikasiLogin.php";
        unset($_SESSION['NotifikasiSwal']);
    }
?>
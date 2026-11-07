# Perbaikan PHP (Prepared Statement)
Lakukan perbaikan pada beberapa script berikut ini dengan sangat hati-hati. 
Pahami ketentuan dan aturan yang ditetapkan.

## Aturan Penting
- Jangan ubah alur sistem.
- Jangan ubah bagian script lain yang tidak bermasalah.
- Tambahkan komentar pada bagian yang diubah / diperbaiki dengan redaksi bahwa penggunaan query menggunakan Prepared Statment.

## Bagian yang Perlu Diperbaiki
- Cari bagian script yang tidak menggunakan **Prepared Statement** atau menggunakan `mysqli_query()` secara langsung.
- Ubah script yang bermasalah tersebut sehingga menggunakan **Prepared Statement**.

## Daftar Script Yang harus diperiksa dan Diperbaiki
- `_Page/ReferensiImunisasi/ProsesImport.php`
- `_Page/ReferensiObservation/SelectUnit.php`
- `_Page/ReferensiObservation/ProsesTambah.php`
- `_Page/Dashboard/GetCount.php`
- `_Page/Dashboard/GrafikPembiayaan.php`
- `_Page/Dashboard/GrafikKategoriPelayanan.php`
- `_Page/Laboratorium/TabelKunjungan.php`
- `_Page/Laboratorium/TabelPasien.php`
- `_Page/Laboratorium/TabelDokter.php`
- `_Page/Laboratorium/TabelDiagnosis.php`
- `_Page/Kunjungan/TabelRuangan.php`
- `_Page/Kunjungan/TabelKelasRawat.php`
- `_Page/Kunjungan/TabelPasien.php`
- `_Page/Kunjungan/TabelTempatTidur.php`
- `_Page/Kunjungan/ProsesImportKunjungan.php`
- `_Page/ApiKey/TabelApiKey.php`
- `_Page/ApiKey/FormHapusLogToken.php`
- `_Page/SettingSifarma/TabelSettingSifarma.php`
- `_Page/EmailGateway/ProsesEditEmailGateway.php`
- `_Page/EmailGateway/TabelEmailGateway.php`
- `_Page/EmailGateway/ProsesTambahEmailGateway.php`
- `_Page/SettingBpjs/TabelSettingBpjs.php`
- `_Page/SettingRadix/TabelSettingRadix.php`
- `_Page/ReferensiPraktisi/FormFilter.php`
- `_Page/ReferensiPraktisi/ListDokter.php`
- `_Page/ReferensiPraktisi/ListProfesi.php`
- `_Page/ReferensiPraktisi/ListAkses.php`
- `_Page/ReferensiPraktisi/ProsesTambah.php`
- `_Page/ReferensiPraktisi/ProsesEdit.php`
- `_Page/ReferensiEpisodePerawatan/ProsesImport.php`
- `_Page/AksesEntitas/FormEditEntitas.php`
- `_Page/AksesEntitas/FormTambahEntitas.php`
- `_Page/ReferensiDokter/SearchKodeDokter.php`
- `_Page/ReferensiWilayahBpjs/option_subdistrict.php`
- `_Page/ReferensiWilayahBpjs/FormTambahSimrs.php`
- `_Page/ReferensiWilayahBpjs/option_regency.php`
- `_Page/GeneralConsent/TabelGeneralConsent.php`
- `_Page/SettingSirsOnline/ProsesEditSettingSirsOnline.php`
- `_Page/SettingSirsOnline/TabelSettingSirsOnline.php`
- `_Page/ReferensiRuangRawat/ProsesUpdateAplicare.php`
- `_Page/ReferensiRuangRawat/FormUpdateAplicare.php`
- `_Page/ReferensiRuangRawat/FormTempatTidur.php`
- `_Page/ReferensiBodySite/FormFilter.php`
- `_Page/ReferensiBodySite/ProsesExport.php`
- `_Page/ReferensiBodySite/FormEdit.php`
- `_Page/ReferensiBodySite/body_site_category.php`
- `_Page/ReferensiBodySite/ProsesImport.php`
- `_Page/ReferensiTindakan/ProsesExport.php`
- `_Page/Log/GrafikLog.php`
- `_Page/Alergi/ProsesKirimAlergi.php`
- `_Page/Alergi/DetailView.php`
- `_Page/Alergi/FormKirimAlergi.php`
- `_Page/Alergi/TabelAlergi.php`
- `_Page/Alergi/FormAllergyIntolerance.php`
- `_Page/Diagnosis/TabelDiagnosis.php`
- `_Page/AksesPengajuan/FormAksesDiterima.php`
- `_Page/Pasien/GetRegency.php`
- `_Page/Pasien/GetVillage.php`
- `_Page/Pasien/GetSubdistrict.php`
- `_Page/Pasien/GetProvince.php`
- `_Page/Pasien/TabelPasien.php`
- `_Page/Pasien/ProsesExportPasien.php`
- `_Page/Pasien/ProsesImport.php`
- `_Page/SettingAnalyza/TabelSettingAnalyza.php`
- `_Page/ReferensiJadwalDokter/CalculateJadwal.php`
- `_Page/ReferensiJadwalDokter/DataUpdateJadwalHfiz.php`
- `_Page/ReferensiJadwalDokter/ProsesUpdateJadwalHfiz.php`
- `_Page/ReferensiJadwalDokter/TabelJadwalDokter.php`
- `_Page/Tindakan/ProsesHapusPerformer.php`
- `_Page/Tindakan/FormTindakan.php`
- `_Page/Tindakan/ProsesKirimProcedure.php`
- `_Page/Tindakan/ProsesEditPerformer.php`
- `_Page/Tindakan/FormDetailProcedure.php`
- `_Page/Tindakan/ListPraktisi.php`
- `_Page/Tindakan/ProsesTambahPerformer.php`
- `_Page/Tindakan/TabelTindakan.php`
- `_Page/GoogleCredential/ProsesTambahGoogleCredential.php`
- `_Page/GoogleCredential/TabelGoogleCredential.php`
- `_Page/ProfileUser/MenampilkanGrafikLog.php`
- `_Page/ProfileUser/TableDetailAktivitas.php`
- `_Page/ProfileUser/TabelIjinAkses.php`
- `_Page/ProfileUser/TabelLaporanKesalahan.php`
- `_Page/ProfileUser/DaftarFiturSaya.php`
- `_Page/ProfileUser/TabelLog.php`
- `_Page/ProfileUser/MyLog.php`
- `_Page/ProfileUser/LaporanPengguna.php`
- `_Page/ProfileUser/FormListIjinAkses.php`
- `_Page/ProfileUser/TabelRekapLog.php`
- `_Page/Observasi/ProsesExport.php`
- `_Page/Observasi/FormExport.php`
- `_Page/ReferensiAlergen/ProsesExport.php`
- `_Partial/Notification.php`

## Keterangan Lain
Jangan ubah script lain yang tidak ada di daftar.
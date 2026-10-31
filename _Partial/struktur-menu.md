Berikut ini adalah catatan struktur menu kiri yang diharapkan:
- Section menunjukan pcoded-navigation-label
- daftar dengan tanda + menunjukan menu level 1
- daftar dengan tanda - menunjukan menu level 2

Section 1 : Menu Utama
+ [icon: bi bi-grid] Dashboard -> (URL : `index.php`)
+ [icon: bi bi-ticket-perforated] Antrian -> (URL : `index.php?Page=Antrian`)
+ [icon: bi bi-people] Pasien -> (URL : `index.php?Page=Pasien`)
+ [icon: bi bi-clipboard2-pulse] Kunjungan -> (URL : `index.php?Page=Kunjungan`)
+ [icon: bi bi-calendar] Jadwal Dokter -> (URL : `index.php?Page=ReferensiJadwalDokter`)

Section 2 : Master Data
+ [icon: bi bi-clipboard2-check] Rekam Medis
  - [icon: bi bi-dot] General Consent -> (URL : `index.php?Page=GeneralConsent`)
  - [icon: bi bi-dot] Observasi -> (URL : `index.php?Page=Observasi`)
  - [icon: bi bi-dot] Diagnosis -> (URL : `index.php?Page=Diagnosis`)
  - [icon: bi bi-dot] Tindakan -> (URL : `index.php?Page=Tindakan`)
  - [icon: bi bi-dot] Alergi -> (URL : `index.php?Page=Alergi`)
  - [icon: bi bi-dot] Imunisasi -> (URL : `index.php?Page=Imunisasi`)
  - [icon: bi bi-dot] Episode Perawatan -> (URL : `index.php?Page=EpisodePerawatan`)
  - [icon: bi bi-dot] Rencana Perawatan -> (URL : `index.php?Page=RencanaPerawatan`)
  - [icon: bi bi-dot] Laboratorium -> (URL : `index.php?Page=Laboratorium`)
  - [icon: bi bi-dot] Radiologi -> (URL : `index.php?Page=Radiologi`)
  - [icon: bi bi-dot] Fisioterapi -> (URL : `index.php?Page=Fisioterapi`)
  - [icon: bi bi-dot] Hemodialisa -> (URL : `index.php?Page=Hemodialisa`)
  - [icon: bi bi-dot] Operasi -> (URL : `index.php?Page=Operasi`)
  - [icon: bi bi-dot] Peresepan -> (URL : `index.php?Page=Peresepan`)
  - [icon: bi bi-dot] Resume -> (URL : `index.php?Page=Resume`)

+ [icon: bi bi-journal-medical] Referensi Lokal
  - [icon: bi bi-dot] Poliklinik -> (URL : `index.php?Page=ReferensiPoliklinik`)
  - [icon: bi bi-dot] Dokter -> (URL : `index.php?Page=ReferensiDokter`)
  - [icon: bi bi-dot] Tenaga Medis -> (URL : `index.php?Page=ReferensiPraktisi`)
  - [icon: bi bi-dot] Ruang Rawat -> (URL : `index.php?Page=ReferensiRuangRawat`)
  - [icon: bi bi-dot] ICD -> (URL : `index.php?Page=ReferensiIcd`)
  - [icon: bi bi-dot] Body Site -> (URL : `index.php?Page=ReferensiBodySite`)
  - [icon: bi bi-dot] Procedure -> (URL : `index.php?Page=ReferensiTindakan`)
  - [icon: bi bi-dot] Alergen -> (URL : `index.php?Page=ReferensiAlergen`)
  - [icon: bi bi-dot] Observation -> (URL : `index.php?Page=ReferensiObservation`)
  - [icon: bi bi-dot] Imunisasi -> (URL : `index.php?Page=ReferensiImunisasi`)
  - [icon: bi bi-dot] Wilayah -> (URL : `index.php?Page=ReferensiWilayah`)

Section 3 : Laporan & Monitoring
+ [icon: bi bi-file-earmark] Indikator Pelayanan
  - [icon: bi bi-dot] Demografi -> (URL : `index.php?Page=Demografi`)
  - [icon: bi bi-dot] Rawat Jalan -> (URL : `index.php?Page=LaporanRajal`)
  - [icon: bi bi-dot] Rawat Inap -> (URL : `index.php?Page=LaporanRanap`)

+ [icon: bi bi-file-earmark] Log SATUSEHAT
  - [icon: bi bi-dot] Encounter -> (URL : `index.php?Page=Encounter`)
  - [icon: bi bi-dot] Condition -> (URL : `index.php?Page=Condition`)
  - [icon: bi bi-dot] Observation -> (URL : `index.php?Page=Observation`)
  - [icon: bi bi-dot] Procedure -> (URL : `index.php?Page=Procedure`)

Section 4 : System
+ [icon: bi bi-gear] Pengaturan
  - [icon: bi bi-dot] Pengaturan Umum -> (URL : `index.php?Page=Setting`)
  - [icon: bi bi-dot] API Key -> (URL : `index.php?Page=ApiKey`)
  - [icon: bi bi-dot] Email Gateway -> (URL : `index.php?Page=EmailGateway`)
  - [icon: bi bi-dot] Google Credential -> (URL : `index.php?Page=GoogleCredential`)

+ [icon: bi bi-person] Aksesibilitas
  - [icon: bi bi-dot] Fitur Aplikasi -> (URL : `index.php?Page=AksesFitur`)
  - [icon: bi bi-dot] Entitas Akses -> (URL : `index.php?Page=AksesEntitas`)
  - [icon: bi bi-dot] Akun Akses -> (URL : `index.php?Page=Akses`)
  - [icon: bi bi-dot] Pengajuan Akses -> (URL : `index.php?Page=AksesPengajuan`)

+ [icon: bi bi-diagram-3] Integrasi
  - [icon: bi bi-dot] Bridging BPJS -> (URL : `index.php?Page=SettingBpjs`)
  - [icon: bi bi-dot] SATUSEHAT -> (URL : `index.php?Page=SettingSatuSehat`)
  - [icon: bi bi-dot] SIRS Online -> (URL : `index.php?Page=SettingSirsOnline`)
  - [icon: bi bi-dot] Radix -> (URL : `index.php?Page=SettingRadix`)
  - [icon: bi bi-dot] Analyza -> (URL : `index.php?Page=SettingAnalyza`)
  - [icon: bi bi-dot] Sifarma -> (URL : `index.php?Page=SettingSifarma`)

+ [icon: bi bi-database] Migrasi -> (URL : `index.php?Page=Migrasi`)
+ [icon: bi bi-record] Log -> (URL : `index.php?Page=Log`)
+ [icon: bi bi-bookmark] Dokumentasi -> (URL : `index.php?Page=Dokumentasi`)

Section 5 : Lainnya
+ [icon: bi bi-question-circle] Bantuan -> (URL : `index.php?Page=Bantuan`)
+ [icon: bi bi-box-arrow-right] Logout -> (URL : `javascript:void(0);` data-bs-toggle="modal" data-bs-target="#ModalLogout")

# SIMRS Core V3

SIMRS Core adalah aplikasi web Sistem Informasi Manajemen Rumah Sakit untuk membantu fasilitas kesehatan mengelola data operasional dan rekam medis secara terpusat. Aplikasi menyediakan pengelolaan pasien, kunjungan, diagnosis, tindakan, alergi, laboratorium, referensi, serta akses pengguna. Integrasi dengan layanan kesehatan eksternal membantu mengurangi pengisian data berulang dan mendukung pertukaran informasi antar sistem.

Repositori ini berisi aplikasi PHP dengan antarmuka HTML, CSS, dan JavaScript, serta integrasi ke basis data MySQL dan layanan eksternal. Sistem akses berbasis akun, entitas, dan hak akses fitur.

## Fitur Aktif

- **Gaya tampilan:** seluruh input, textarea, dan select dengan atribut `readonly` kini memiliki latar abu-abu secara konsisten (menyesuaikan tampilan input nonaktif) melalui aturan CSS global pada `assets/css/style.css`.

Fitur yang tersedia pada aplikasi mencakup:

- **Dashboard dan monitoring:** dashboard menampilkan kartu profil fasilitas kesehatan dengan logo, nama, alamat, direktur/manajer, kode, email, dan nomor telepon; kartu profil, teks informasi, serta jarak antarbaris disesuaikan untuk desktop. Judul dan breadcrumb Dashboard/Profil disejajarkan dengan gutter kartu utama. Semua halaman route dan 404 memakai tata letak header bersama yang mempertahankan judul/deskripsi halaman, menempatkan breadcrumb sejajar di desktop dan setelah judul di mobile tanpa celah tambahan di bawah header. Beranda dapat diklik menuju Dashboard, fitur dapat diklik menuju halaman utama fitur jika memiliki subfitur, dan subfitur menjadi penanda aktif yang tidak dapat diklik. Empat kartu rekap dokter, poliklinik, tempat tidur, dan pasien menggunakan ikon kategori yang relevan, label, serta angka ringkas mengikuti desain dashboard. Dashboard juga menampilkan grafik donut kunjungan rawat jalan/rawat inap dan metode pembiayaan, serta grafik kunjungan pasien dengan ApexCharts. Grafik tahunan mencakup Januari–Desember; periode tahun atau bulan dapat dipilih melalui modal. Daftar pasien existing memuat kunjungan berstatus Terdaftar terbaru secara bertahap saat panel digulir. Navigasi aplikasi dibagi menjadi lima bagian: Menu Utama, Master Data, Laporan & Monitoring, System, dan Lainnya; item level 2 aktif memakai latar `#435f66` dan teks `#448aff`. Navigasi juga menyediakan tema gelap, notifikasi, fullscreen, sidebar ringkas berbentuk ikon, foto profil pengguna dengan fallback `assets/img/user/No-Image.png`, dan dropdown pengguna tanpa nama akun di samping foto profil. Pada tampilan mobile, navbar mengatur ruang kanan secara khusus agar foto profil tidak terpotong di tepi layar.
- **Profil pengguna:** halaman profil memakai Bootstrap Icons dan header dengan breadcrumb yang konsisten dengan dashboard. Nama bawaan “Admin Faskes” tidak ditampilkan pada ringkasan profil, sementara nama pengguna lain tetap terlihat. Foto yang kosong atau tidak dapat dimuat menggunakan `assets/img/user/No-Image.png`. Ringkasan aktivitas berdasarkan periode diambil dari tabel pasien, kunjungan, SEP, diagnosis, tindakan, alergi, observation, dan general consent. Setelah foto, email/kontak, atau password berhasil diperbarui, halaman dimuat ulang dan menampilkan konfirmasi SweetAlert satu kali. Timestamp pendaftaran dan pembaruan baru disimpan dalam UTC, lalu ditampilkan sesuai zona waktu browser; perubahan email/kontak, password, foto profil, dan pengiriman laporan memperbarui timestamp menggunakan UTC.
- **Aksesibilitas:** akun pengguna, entitas akses, pengelolaan fitur, dan pengajuan akses. Pengelolaan akses langsung memvalidasi data form, memakai prepared statement dan transaksi untuk perubahan akun serta izin, memvalidasi fitur yang dipilih, dan menampilkan pesan server sebagai teks aman. Tanggal dibuat dan diperbarui tampil pada tabel dan detail menurut zona waktu browser. Informasi identitas detail mengikuti pola baris label dan nilai dengan judul bagian tebal, sedangkan role akses dikelompokkan dalam accordion dengan daftar fitur berbentuk list group berukuran kecil dan berwarna sekunder. Header dan isi accordion memiliki latar berbeda di seluruh aplikasi. Foto pengguna yang tersedia tampil sebelum identitas dalam bingkai lingkaran dengan crop terpusat.
- **Navbar responsif:** pada viewport mobile, kontainer aksi header menyesuaikan lebar isi agar foto profil tetap berada di dalam layar dan memiliki jarak dari tepi kanan.
- **Antrian pasien:** daftar antrian dengan pagination dan filter per kolom; tambah manual untuk pasien terdaftar atau pasien baru melalui Select2 bertema Bootstrap 5; edit melalui form server-rendered dari `_Page/Antrian/FormEdit.php` berdasarkan ID antrean dengan element ID terpisah agar tidak bentrok dengan modal tambah, input hidden ID antrian, serta perilaku form dinamis (pencarian pasien Select2, cascade poliklinik/dokter/jadwal, dan toggle referensi); pemrosesan submit edit ditangani oleh handler AJAX jQuery di `_Page/Antrian/Antrian.js` menuju endpoint khusus `_Page/Antrian/ProsesEdit.php` yang memvalidasi data menggunakan prepared statement dan transaksi database, memperbarui nomor antrean jika jadwal/tanggal kunjungan berubah, mencatat riwayat perubahan status ke `antrian_log`, dan mencatat aktivitas audit ke `log`; hapus antrean dikelola melalui `#ModalHapus` yang ditangani oleh jQuery di `_Page/Antrian/Antrian.js` dengan menangkap `data-id` pemicu, memuat form validasi dan preview data dari `_Page/Antrian/FormHapus.php` lengkap dengan input hidden `id_antrian` untuk disubmit, serta kontrol aktifasi tombol konfirmasi berdasarkan checklist pernyataan petugas. Tampilan tabel dan detail mengikuti pola ringkas Referensi Dokter; pesan kesalahan tampil di dalam modal dan keberhasilan menggunakan toast. Detail dan riwayat pelayanan juga dapat dilihat, dan pasien baru dapat didaftarkan menjadi rekam medis. Form tambah/edit mengelompokkan identitas pasien, tujuan kunjungan, dan informasi antrean dengan label di atas kontrol serta susunan responsif. Form tidak memakai area modal scrollable agar tombol aksi tetap mudah dijangkau saat Select2 digunakan. Modal detail antrian, pasien, poliklinik, dan dokter menampilkan informasi dengan susunan baris label/nilai tanpa kartu bertumpuk. Daftar jadwal hanya menampilkan kombinasi poliklinik, dokter, dan jadwal aktif; jadwal tidak aktif yang sudah dipakai antrian tetap dapat dipertahankan ketika data tersebut diedit. Pasien tidak aktif tidak dapat dipakai untuk membuat antrian baru. Nomor booking dibuat otomatis dan nomor antrian berurutan menurut jadwal dokter dan tanggal kunjungan; waktu pendaftaran disimpan dalam UTC dan ditampilkan menurut zona waktu browser. Aktivitas tambah, ubah, hapus, dan pendaftaran rekam medis dicatat pada log aplikasi.
- **Observasi pasien:** tabel observasi memuat nomor rekam medis, pasien, waktu pemeriksaan, kategori, jenis observasi, dan petugas. Data mendukung filter, urutan, serta pagination menggunakan query terikat.
- **Rekam medis dan pelayanan:** pasien, kunjungan, general consent, diagnosis, tindakan, alergi, dan laboratorium.
- **Referensi:** poliklinik, dokter, jadwal dokter, praktisi, ruang rawat, ICD, tindakan, alergen, observation, serta data wilayah. Import ICD dari XLSX memproses data langsung dalam satu transaksi tanpa memakai tabel `icd_upload_log`; kode yang sudah ada dilewati. Daftar wilayah pada modal dapat ditelusuri bertahap dari provinsi hingga desa/kelurahan, dilengkapi kode dan jumlah wilayah di bawahnya, tabel responsif, serta tombol kembali. Nama wilayah tetap berupa teks yang dapat dipilih dan disalin. Data wilayah dapat dihasilkan melalui skrip CLI dari dataset Valtera Indonesia Regions; skrip memvalidasi relasi kode, menambahkan wilayah yang belum ada, dan memperbarui kode serta tipe pada wilayah yang sudah cocok.
- **Pengaturan:** profil fasilitas kesehatan dengan lingkungan `Development`, `Staging`, atau `Production`; hanya satu profil dapat aktif pada satu waktu. Menu opsi tabel ditampilkan di luar batas overflow tabel responsif saat dibuka. Logo faskes disimpan di `assets/img/logo/` dengan fallback `assets/img/logo/no-image.jpg`. Tersedia juga pengaturan API key, email gateway, kredensial Google, percetakan, dan konfigurasi integrasi.
- **Integrasi:** BPJS/VClaim, SATUSEHAT, SIRS Online, Radix, Analyza, dan Sifarma sesuai konfigurasi fasilitas kesehatan.
- **Ikon dan tombol antarmuka:** halaman menggunakan Bootstrap Icons yang valid, termasuk ikon untuk tombol modal, tindakan, login, dan referensi. Semua tombol “Tutup” pada modal menggunakan gaya `btn-secondary`.
- **Halaman login responsif:** panel brand desktop menggunakan tekstur noise halus dan bayangan tipis pada batas dengan panel form; tombol Login memiliki bayangan lembut.
- **Tampilan responsif:** dashboard dan navigasi menyesuaikan ukuran layar, dengan menu samping yang dapat dibuka atau ditutup pada perangkat mobile.

Daftar hak akses awal tersedia di [`_Database/referance/default_reference_feature_code.json`](_Database/referance/default_reference_feature_code.json). Daftar tersebut berisi fitur yang digunakan installer untuk mengisi referensi hak akses; ketersediaan integrasi tetap bergantung pada konfigurasi dan kredensial layanan eksternal.

## Requirements
- PHP **8.5 atau lebih baru** dengan ekstensi `mysqli` dan `gd` aktif.
- Ekstensi PHP yang diperlukan dependensi Composer, termasuk `mbstring`, `dom`, `xml`, `xmlreader`, `xmlwriter`, `zip`, dan `zlib`.
- MySQL **8.4.7 atau lebih baru**. Skema menggunakan collation `utf8mb4_0900_ai_ci` dan dump skema dibuat dari MySQL 8.4.7.
- Apache 2.4.65 atau web server lain yang dapat menjalankan PHP.
- Composer 2.10.3 dan Node.js/npm untuk memasang dependensi aplikasi.
- Akses jaringan dan kredensial yang sesuai untuk integrasi eksternal yang akan digunakan.

Pastikan versi PHP CLI yang dipakai Composer dan installer sama dengan versi PHP yang dipakai web server.
Halaman login saat ini memuat font Open Sans dari Google Fonts, sehingga akses jaringan dibutuhkan agar font tersebut tersedia.

## Instalasi dan Persiapan

1. Pasang aplikasi di document root web server, lalu pastikan PHP, MySQL, Composer, dan Node.js/npm tersedia.
2. Buat basis data kosong bernama `elsyifa_core`, lalu impor [`_Database/schema.sql`](_Database/schema.sql). **Impor skema hanya pada basis data baru**, karena file tersebut menghapus dan membuat ulang tabel yang didefinisikan di dalamnya.
3. Sesuaikan host, nama pengguna, kata sandi, dan nama basis data pada [`_Config/Connection.php`](_Config/Connection.php). Nilai bawaan saat ini adalah `localhost`, pengguna `root`, kata sandi kosong, dan basis data `elsyifa_core`.
4. Dari direktori utama proyek, pasang dependensi PHP dan JavaScript:

   ```sh
   composer install
   npm ci
   ```

   Dependensi Composer dipasang ke `vendor/`, sedangkan dependensi JavaScript dipasang ke `node_modules/`. Kedua direktori tersebut tidak disimpan di version control.

5. Jalankan installer **satu kali** dari CLI di direktori utama proyek:

   ```sh
   php instal.php
   ```

   Masukkan email administrator yang valid dan kata sandi sepanjang 8–20 karakter saat diminta. Input kata sandi ditampilkan oleh terminal ketika diketik; jalankan installer di terminal yang aman.

6. Installer membuat entitas `Admin` dan akun `Admin Faskes`, menyimpan kata sandi sebagai hash, serta memberikan fitur yang tersedia pada file referensi kepada entitas dan akun administrator. Waktu pembuatan dan pembaruan disimpan dalam UTC.
7. Jalankan Apache/web server dan buka alamat proyek melalui browser. Konfigurasikan kredensial layanan eksternal melalui halaman pengaturan aplikasi sebelum menggunakan integrasi terkait.
8. Untuk mengisi atau melengkapi data wilayah, jalankan skrip CLI dari direktori utama proyek saat koneksi internet tersedia:

   ```sh
   php _Database/generate_wilayah.php --dry-run
   php _Database/generate_wilayah.php
   ```

   Mode `--dry-run` memvalidasi seluruh CSV tanpa mengubah basis data. Proses normal menambahkan baris yang belum ada dan memperbarui kode serta tipe pada baris dengan nama wilayah yang cocok, dalam satu transaksi; data dan kode BPJS yang sudah ada tidak dihapus. Kode wilayah digunakan sebagai kode Mendagri, jenis kabupaten/kota diturunkan dari kode wilayah, dan kode jenis desa/kelurahan dipetakan ke enum tabel. Kode pos tidak disimpan karena tabel `wilayah` tidak memiliki kolom kode pos. Sumber CSV: [Valtera Indonesia Regions](https://github.com/danikz/valtera-indonesia-regions), berlisensi MIT.

Installer hanya ditujukan untuk basis data awal. Installer menolak berjalan jika tabel akun atau entitas akses sudah berisi data, dan memeriksa kecocokan referensi fitur yang sudah tersedia. Jangan menghapus atau mengosongkan data produksi untuk menjalankannya kembali.

## Dependensi

### JavaScript/npm

Dependensi langsung yang dikelola melalui `package.json` dan `package-lock.json`:

- `apexcharts` ^5.10.4
- `bootstrap` ^5.3.8
- `bootstrap-icons` ^1.13.1
- `driver.js` ^1.10.2
- `jquery` ^4.0.0
- `jquery-mask-plugin` ^1.14.16
- `jquery-ui` ^1.14.2
- `mdb-ui-kit` ^9.3.0
- `qrcodejs` ^1.0.0
- `quill` ^2.0.3
- `select2` ^4.1.0
- `select2-bootstrap-5-theme` ^1.3.0
- `signature_pad` ^5.1.3
- `sweetalert2` ^11.26.24
- `tinymce` ^8.3.2

### PHP/Composer

Dependensi langsung yang dikelola melalui `composer.json` dan `composer.lock`:

- `nullpunkt/lz-string-php` ^1.3
- `mpdf/mpdf` ^8.1
- `ezyang/htmlpurifier` ^4.19
- `phpoffice/phpspreadsheet` ^1.30
- `vlucas/phpdotenv` ^5.7

Versi terpasang yang terkunci dicatat pada kedua file lock. Aset pustaka tambahan yang tidak dikelola npm atau Composer disimpan di `assets/lib/`.

## Pengujian

Pemeriksaan sintaks seluruh file PHP aplikasi (tanpa memindai `vendor/` dan `node_modules/`) dapat dijalankan dengan:

```sh
php tests/run.php
```

## Panduan Perubahan

- Perbarui bagian fitur aktif dan dokumentasi terkait di README setiap kali ada perubahan fitur.
- Gunakan dependensi yang dipasang melalui npm atau Composer; jangan menambahkan dependensi CDN tanpa persetujuan.
- Hindari menambahkan fitur yang tidak diminta dan pertimbangkan dampak perubahan terhadap performa serta alur kerja.
- Gunakan HTML semantik dan CSS responsif; letakkan pustaka tambahan yang tidak dikelola npm atau Composer di `assets/lib/`.

## Struktur Proyek

- `_Config/` — koneksi basis data, konfigurasi aplikasi, sesi, dan fungsi bersama.
- `_Database/` — skema serta data referensi awal.
- `_Page/` — halaman, modul, dan proses aplikasi.
- `_Partial/` — komponen halaman yang digunakan bersama.
- `assets/` — CSS, JavaScript, ikon, gambar, dan pustaka antarmuka.
- `tests/` — skrip pemeriksaan proyek.
- `vendor/` — dependensi PHP hasil Composer.
- `node_modules/` — dependensi JavaScript hasil npm.

## Referensi

- Dokumentasi pengguna: [SIMRS Core di GitBook](https://rsu-el-syifa.gitbook.io/rsu-el-syifa-docs)
- Integrasi BPJS: [Portal Developer BPJS Kesehatan](https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/portal.html)

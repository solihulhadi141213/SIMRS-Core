# SIMRS Core V3

SIMRS Core adalah aplikasi web Sistem Informasi Manajemen Rumah Sakit untuk membantu fasilitas kesehatan mengelola data operasional dan rekam medis secara terpusat. Aplikasi menyediakan pengelolaan pasien, kunjungan, diagnosis, tindakan, alergi, laboratorium, referensi, serta akses pengguna. Integrasi dengan layanan kesehatan eksternal membantu mengurangi pengisian data berulang dan mendukung pertukaran informasi antar sistem.

Repositori ini berisi aplikasi PHP dengan antarmuka HTML, CSS, dan JavaScript, serta integrasi ke basis data MySQL dan layanan eksternal. Sistem akses berbasis akun, entitas, dan hak akses fitur.

## Fitur Aktif

Fitur yang tersedia pada aplikasi mencakup:

- **Dashboard dan monitoring:** dashboard menampilkan kartu profil fasilitas kesehatan dengan logo, nama, alamat, direktur/manajer, kode, email, dan nomor telepon; kartu profil, teks informasi, serta jarak antarbaris disesuaikan untuk desktop. Empat kartu rekap dokter, poliklinik, tempat tidur, dan pasien menggunakan ikon kategori yang relevan, label, serta angka ringkas mengikuti desain dashboard. Dashboard juga menampilkan grafik donut kunjungan rawat jalan/rawat inap dan metode pembiayaan, serta grafik kunjungan pasien dengan ApexCharts. Grafik tahunan mencakup Januari–Desember; periode tahun atau bulan dapat dipilih melalui modal. Daftar pasien existing memuat kunjungan berstatus Terdaftar terbaru secara bertahap saat panel digulir. Header semua halaman yang dirutekan memakai tampilan terang, tipografi, dan jarak yang konsisten dengan dashboard; header dashboard menyediakan breadcrumb. Navigasi aplikasi dibagi menjadi lima bagian: Menu Utama, Master Data, Laporan & Monitoring, System, dan Lainnya; item level 2 aktif memakai latar `#435f66` dan teks `#448aff`. Navigasi juga menyediakan tema gelap, notifikasi, fullscreen, sidebar ringkas berbentuk ikon, foto profil pengguna dengan fallback `assets/img/user/No-Image.png`, dan dropdown pengguna tanpa garis pemisah di bawah opsi terakhir.
- **Profil pengguna:** halaman profil memakai Bootstrap Icons dan header dengan breadcrumb yang konsisten dengan dashboard. Foto yang kosong atau tidak dapat dimuat menggunakan `assets/img/user/No-Image.png`. Ringkasan aktivitas berdasarkan periode diambil dari tabel pasien, kunjungan, SEP, diagnosis, tindakan, alergi, observation, dan general consent. Setelah foto, email/kontak, atau password berhasil diperbarui, halaman dimuat ulang dan menampilkan konfirmasi SweetAlert satu kali. Timestamp pendaftaran dan pembaruan baru disimpan dalam UTC, lalu ditampilkan sesuai zona waktu browser; perubahan email/kontak, password, foto profil, dan pengiriman laporan memperbarui timestamp menggunakan UTC.
- **Aksesibilitas:** akun pengguna, entitas akses, pengelolaan fitur, dan pengajuan akses.
- **Rekam medis dan pelayanan:** pasien, kunjungan, general consent, diagnosis, tindakan, alergi, dan laboratorium.
- **Referensi:** poliklinik, dokter, jadwal dokter, praktisi, ruang rawat, ICD, tindakan, alergen, observation, serta data wilayah.
- **Pengaturan:** profil fasilitas kesehatan, API key, email gateway, kredensial Google, percetakan, dan konfigurasi integrasi.
- **Integrasi:** BPJS/VClaim, SATUSEHAT, SIRS Online, Radix, Analyza, dan Sifarma sesuai konfigurasi fasilitas kesehatan.
- **Ikon dan tombol antarmuka:** halaman menggunakan Bootstrap Icons yang valid, termasuk ikon untuk tombol modal, tindakan, login, dan referensi. Semua tombol “Tutup” pada modal menggunakan gaya `btn-secondary`.
- **Halaman login responsif:** panel brand desktop menggunakan tekstur noise halus dan bayangan tipis pada batas dengan panel form; tombol Login memiliki bayangan lembut.
- **Tampilan responsif:** dashboard dan navigasi menyesuaikan ukuran layar, dengan menu samping yang dapat dibuka atau ditutup pada perangkat mobile.

Daftar hak akses awal tersedia di [`_Database/referance/default_reference_feature_code.json`](_Database/referance/default_reference_feature_code.json). Daftar tersebut berisi fitur yang digunakan installer untuk mengisi referensi hak akses; ketersediaan integrasi tetap bergantung pada konfigurasi dan kredensial layanan eksternal.

## Requirements

- PHP **8.2 atau lebih baru** dengan ekstensi `mysqli` dan `gd` aktif.
- Ekstensi PHP yang diperlukan dependensi Composer, termasuk `mbstring`, `dom`, `xml`, `xmlreader`, `xmlwriter`, `zip`, dan `zlib`.
- MySQL **8.0 atau lebih baru**. Skema menggunakan collation `utf8mb4_0900_ai_ci` dan dump skema dibuat dari MySQL 8.4.7.
- Apache 2.4 atau web server lain yang dapat menjalankan PHP.
- Composer 2 dan Node.js/npm untuk memasang dependensi aplikasi.
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

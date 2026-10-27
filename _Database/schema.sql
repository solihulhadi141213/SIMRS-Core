-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 26 Okt 2026 pada 16.55
-- Versi server: 8.4.7
-- Versi PHP: 8.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `elsyifa_core`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses`
--

DROP TABLE IF EXISTS `akses`;
CREATE TABLE IF NOT EXISTS `akses` (
  `id_akses` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses_pengajuan` int UNSIGNED DEFAULT NULL,
  `id_akses_entitas` int UNSIGNED DEFAULT NULL,
  `tanggal` datetime NOT NULL COMMENT 'Pertama kali akun dibuat',
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ihs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'ID IHS SATUSEHAT',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'akan menyimpan hash',
  `akses` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `updatetime` datetime NOT NULL COMMENT 'Update terakhir',
  PRIMARY KEY (`id_akses`),
  KEY `id_akses_pengajuan` (`id_akses_pengajuan`),
  KEY `id_akses_entitas` (`id_akses_entitas`),
  KEY `nama` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan data akun pengguna';

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_acc`
--

DROP TABLE IF EXISTS `akses_acc`;
CREATE TABLE IF NOT EXISTS `akses_acc` (
  `id_akses_acc` int NOT NULL AUTO_INCREMENT,
  `id_akses` int UNSIGNED NOT NULL,
  `id_akses_fitur` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_akses_acc`),
  KEY `id_akses` (`id_akses`),
  KEY `id_akses_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mapping akses ke akses_fitur';

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_entitas`
--

DROP TABLE IF EXISTS `akses_entitas`;
CREATE TABLE IF NOT EXISTS `akses_entitas` (
  `id_akses_entitas` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `akses` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama akses yang ada pada data akses',
  `deskripsi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Gambaran umum akses',
  PRIMARY KEY (`id_akses_entitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan data entitas akses';

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_entitas_acc`
--

DROP TABLE IF EXISTS `akses_entitas_acc`;
CREATE TABLE IF NOT EXISTS `akses_entitas_acc` (
  `id_akses_entitas_acc` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses_entitas` int UNSIGNED NOT NULL,
  `id_akses_fitur` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_akses_entitas_acc`),
  KEY `entitas_acc_to_entitas` (`id_akses_entitas`),
  KEY `entitas_acc_to_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='akses standar yang dimiliki entitas akses';

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_fitur`
--

DROP TABLE IF EXISTS `akses_fitur`;
CREATE TABLE IF NOT EXISTS `akses_fitur` (
  `id_akses_fitur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_fitur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL COMMENT 'kode akses fitur',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Penjelasan fitur/halaman',
  PRIMARY KEY (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='daftar fitur aplikasi';

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_laporan`
--

DROP TABLE IF EXISTS `akses_laporan`;
CREATE TABLE IF NOT EXISTS `akses_laporan` (
  `id_akses_laporan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `laporan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Isi laporan',
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Response dari admin',
  `status` enum('Terkirim','Dibaca','Selesai','Draft') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_akses_laporan`),
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_login`
--

DROP TABLE IF EXISTS `akses_login`;
CREATE TABLE IF NOT EXISTS `akses_login` (
  `id_akses_login` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses` int UNSIGNED NOT NULL,
  `login_token` varchar(255) NOT NULL,
  `creat_at` datetime NOT NULL COMMENT 'Token dibuat',
  `expired_at` datetime NOT NULL COMMENT 'Token Expired',
  PRIMARY KEY (`id_akses_login`),
  KEY `akses_to_login` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_pengajuan`
--

DROP TABLE IF EXISTS `akses_pengajuan`;
CREATE TABLE IF NOT EXISTS `akses_pengajuan` (
  `id_akses_pengajuan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL COMMENT 'tanggal pengajuan',
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Ex: 6289601154726',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Tujuan pengajuan',
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('Pending','Diterima','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Pending, Diterima, Ditolak',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'keterangan penolakan',
  PRIMARY KEY (`id_akses_pengajuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_reset`
--

DROP TABLE IF EXISTS `akses_reset`;
CREATE TABLE IF NOT EXISTS `akses_reset` (
  `id_akses_reset` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses` int UNSIGNED NOT NULL,
  `datetime_creat` datetime NOT NULL COMMENT 'UTC',
  `datetime_expired` datetime NOT NULL COMMENT 'UTC',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'hasing',
  PRIMARY KEY (`id_akses_reset`),
  KEY `reset_to_access` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `alergi`
--

DROP TABLE IF EXISTS `alergi`;
CREATE TABLE IF NOT EXISTS `alergi` (
  `id_alergi` varchar(255) NOT NULL COMMENT 'uid',
  `id_pasien` int UNSIGNED NOT NULL,
  `id_kunjungan` int UNSIGNED NOT NULL,
  `id_alergi_alergen` int UNSIGNED DEFAULT NULL,
  `AllergyIntolerance` varchar(255) DEFAULT NULL,
  `kategori_alergen` varchar(255) NOT NULL,
  `nama_alergen` varchar(255) NOT NULL,
  `clinical_status` enum('active','inactive','resolved') NOT NULL,
  `verification_status` enum('unconfirmed','presumed','confirmed','refuted','entered-in-error') NOT NULL,
  `id_praktisi` int UNSIGNED DEFAULT NULL,
  `nama_praktisi` varchar(255) NOT NULL,
  `keterangan_alergi` text COMMENT 'Keterangan, reaksi yang dialamai pasien',
  `author_id` int UNSIGNED DEFAULT NULL COMMENT 'id_akses petugas entry',
  `author_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'nama petugas',
  `datetime_creat` datetime NOT NULL,
  PRIMARY KEY (`id_alergi`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_alergi_alergen` (`id_alergi_alergen`),
  KEY `author_id` (`author_id`),
  KEY `id_praktisi` (`id_praktisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `alergi_alergen`
--

DROP TABLE IF EXISTS `alergi_alergen`;
CREATE TABLE IF NOT EXISTS `alergi_alergen` (
  `id_alergi_alergen` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_alergen` enum('Food','Medication','Environment','Biologic') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_alergen` varchar(255) NOT NULL,
  `code_alergen` varchar(255) DEFAULT NULL,
  `display_alergen` varchar(255) DEFAULT NULL,
  `system_alergen` text COMMENT 'http://snomed.info/sct',
  `author_id` int UNSIGNED DEFAULT NULL COMMENT 'ID akses pembuat',
  `author_name` varchar(255) NOT NULL COMMENT 'Nama pembuat',
  `datetime_creat` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_alergi_alergen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Referensi zat alergen';

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

DROP TABLE IF EXISTS `antrian`;
CREATE TABLE IF NOT EXISTS `antrian` (
  `id_antrian` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pasien` int UNSIGNED DEFAULT NULL COMMENT 'Jika kosong maka pasien baru',
  `id_kunjungan` int UNSIGNED DEFAULT NULL COMMENT 'Jika kosong maka belum ada kunjungan',
  `id_poliklinik` int UNSIGNED DEFAULT NULL COMMENT 'Jika kosong maka poli dihapus',
  `id_dokter` int UNSIGNED DEFAULT NULL COMMENT 'Jika kosong maka dokter dihapus',
  `id_jadwal` int UNSIGNED DEFAULT NULL COMMENT 'Jika kosong maka jadwal dihapus',
  `no_antrian` int UNSIGNED NOT NULL COMMENT 'Nomor urutan antrian',
  `kode_booking` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kode acak booking',
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama lengkap pasien',
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Identitas KTP',
  `no_bpjs` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nomor BPJS',
  `kontak` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kontak pasien',
  `gender` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jenis Kelamin',
  `nomor_referensi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomor dokumen yang mereferensikan',
  `jenis_referensi` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT ' 	1.Rujukan FKTP 2.Rujukan Internal 3.Kontrol 4.Rujukan Antar RS ',
  `jenis_request` tinyint(1) NOT NULL COMMENT 'Pasien Baru? 0=Tidak, 1=Ya ',
  `poli_eksekutif` tinyint(1) NOT NULL COMMENT 'Apakah Polieksekutif? 0. Tidak 1. Ya ',
  `pembayaran` enum('UMUM','BPJS','ASURANSI') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Metode pembayaran yang digunakan',
  `keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Keluhan yang dirasakan pasien',
  `nama_dokter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama dokter sesuai tabel dokter',
  `nama_poliklinik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'nama poli sesuai poliklinik',
  `tanggal_kunjungan` date NOT NULL COMMENT 'Tanggal Rencana Kunjungan',
  `datetime_creat` datetime NOT NULL COMMENT 'Tanggal & Jam Pendaftaran antrian dibuat (UTC)',
  `status_antrian` enum('Terdaftar','Batal','Checkin','Panggil Admisi','Tunggu Poli','Layanan Poli','Tunggu Farmasi','Layanan Farmasi','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Posisi status pelayanan pasien',
  `sumber_antrian` enum('JKN Mobile','Website','Mesin Antrian','Manual') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Dari mana data ini berasal',
  `ws_bpjs` tinyint(1) NOT NULL COMMENT 'Apakahh antrian sudah dikirim ke antrol BPJS',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Misalnya keterangan penyebab pembatalan',
  `update_by_id` int UNSIGNED DEFAULT NULL COMMENT 'ID Akses yang melakukan update',
  `update_by_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nama akses yang melakukan update',
  `update_at` datetime DEFAULT NULL COMMENT 'Waktu update (kosong, jika belum pernah diubah)',
  PRIMARY KEY (`id_antrian`),
  KEY `antrian_pasien` (`id_pasien`),
  KEY `antrian_to_kunjungan` (`id_kunjungan`),
  KEY `antrian_to_poliklinik` (`id_poliklinik`),
  KEY `antrian_dokter` (`id_dokter`),
  KEY `antrian_to_jadwal` (`id_jadwal`),
  KEY `antrian_to_akses` (`update_by_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian_log`
--

DROP TABLE IF EXISTS `antrian_log`;
CREATE TABLE IF NOT EXISTS `antrian_log` (
  `id_antrian_log` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_antrian` int UNSIGNED NOT NULL COMMENT 'Dari tabel antrian',
  `status_antrian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sesuai Enum status antrian',
  `datetime_rs` datetime NOT NULL COMMENT 'Tanggal & Jam Rumah Sakit',
  `datetime_bpjs` datetime DEFAULT NULL COMMENT 'Tanggal & Jam BPJS',
  PRIMARY KEY (`id_antrian_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Catatan layanan antrian';

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_key`
--

DROP TABLE IF EXISTS `api_key`;
CREATE TABLE IF NOT EXISTS `api_key` (
  `id_api_key` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama API',
  `api_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Penjelasan Singkat',
  `client_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'ID Pengguna (Username)',
  `client_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Hasing / Password',
  `expired_duration` int UNSIGNED NOT NULL COMMENT 'Hour / Jam',
  `datetime_creat` datetime NOT NULL COMMENT 'Kapan API Key Dibuat',
  `datetime_update` datetime NOT NULL COMMENT 'Kapan Terakhir Kali API Key Diubah',
  PRIMARY KEY (`id_api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_token`
--

DROP TABLE IF EXISTS `api_token`;
CREATE TABLE IF NOT EXISTS `api_token` (
  `id_api_token` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_api_key` int UNSIGNED NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  PRIMARY KEY (`id_api_token`),
  KEY `id_api_access` (`id_api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Untuk menampung API token';

-- --------------------------------------------------------

--
-- Struktur dari tabel `body_site`
--

DROP TABLE IF EXISTS `body_site`;
CREATE TABLE IF NOT EXISTS `body_site` (
  `id_body_site` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `body_site_nama` varchar(255) NOT NULL COMMENT 'Nama Body Site Dalam istilah Lokal',
  `body_site_display` varchar(255) DEFAULT NULL COMMENT 'Nama Body Site Berdasarkan standar referensi yang digunakan',
  `body_site_code` varchar(255) DEFAULT NULL COMMENT 'Kode Body Site Berdasarkan standar referensi yang digunakan',
  `body_site_system` text COMMENT 'System Sumber',
  `datetime_creat` datetime NOT NULL COMMENT 'Keterangan waktu pembuatan data',
  `datetime_update` datetime NOT NULL COMMENT 'Keterangan waktu kapan diubah',
  `author_id` int UNSIGNED DEFAULT NULL COMMENT 'ID akses autohor',
  `author_name` varchar(255) DEFAULT NULL COMMENT 'Nama Author',
  PRIMARY KEY (`id_body_site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Daftar Referensi Lokasi Tubuh';

-- --------------------------------------------------------

--
-- Struktur dari tabel `captcha`
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE IF NOT EXISTS `captcha` (
  `id_captcha` varchar(255) NOT NULL,
  `feature_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Ex: Login, Pendaftaran',
  `code_captcha` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creat_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  PRIMARY KEY (`id_captcha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan kode captcha sekali pakai';

-- --------------------------------------------------------

--
-- Struktur dari tabel `diagnosis`
--

DROP TABLE IF EXISTS `diagnosis`;
CREATE TABLE IF NOT EXISTS `diagnosis` (
  `id_diagnosis` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int UNSIGNED NOT NULL,
  `id_pasien` int UNSIGNED NOT NULL,
  `id_condition` varchar(255) DEFAULT NULL,
  `dokter_id` int UNSIGNED DEFAULT NULL COMMENT 'ID Dokter Yang Menyatakan',
  `dokter_kode` varchar(255) NOT NULL COMMENT 'Kode Dokter Yang Menyatakan',
  `dokter_nama` varchar(255) NOT NULL COMMENT 'Nama Dokter Yang Menyatakan',
  `jenis_diagnosis` enum('Admission','Provisional','Primary','Secondary','Working','Differential','Final') NOT NULL COMMENT 'Masuk, Awal, Utama, ',
  `icd_version` enum('ICD9','ICD10','ICD11') NOT NULL,
  `icd_kode` varchar(255) NOT NULL,
  `icd_deskripsi` text NOT NULL,
  `diagnosis_text` text COMMENT 'text bebas dari pernyataan dokter',
  `status_kasus` enum('Baru','Lama','Kambuh','Kronis') NOT NULL,
  `status_kepastian` enum('Provisional','Final') NOT NULL COMMENT 'Sementara, Tetap (selesai)',
  `datetime_creat` datetime NOT NULL,
  `petugas_id` int UNSIGNED DEFAULT NULL COMMENT 'ID akses Petugas',
  `petugas_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama Petugas',
  PRIMARY KEY (`id_diagnosis`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `dokter_id` (`dokter_id`),
  KEY `id_condition` (`id_condition`),
  KEY `diagnosis_akses` (`petugas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

DROP TABLE IF EXISTS `dokter`;
CREATE TABLE IF NOT EXISTS `dokter` (
  `id_dokter` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_ihs_practitioner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'id IHS Satu sehat (Jika ada)',
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode unik dokter, bisa untuk BPJS',
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Ex: Spesialis Penyakit Dalam',
  `kategori_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'KTP, KK, Passport dll',
  `no_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nomor identitas yg dipilih',
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'untuk kirim notifikasi',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'untuk kirim notifikasi',
  `SIP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_dokter`),
  KEY `nama` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `general_consent`
--

DROP TABLE IF EXISTS `general_consent`;
CREATE TABLE IF NOT EXISTS `general_consent` (
  `id_general_consent` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_consent` varchar(255) NOT NULL COMMENT 'SATUSEHAT',
  `id_kunjungan` int UNSIGNED NOT NULL,
  `id_pasien` int UNSIGNED NOT NULL,
  `metode_consent` enum('Manual','Digital') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Manual (Cetak), Digital (Signature)',
  `petugas_edukasi_id` int UNSIGNED DEFAULT NULL COMMENT 'ID Akses Petugas',
  `petugas_edukasi_nama` varchar(255) NOT NULL COMMENT 'Nama Petugas (text)',
  `petugas_edukasi_nik` varchar(255) DEFAULT NULL COMMENT 'Dari tabel akses',
  `petugas_edukasi_ttd` longtext COMMENT 'bas64',
  `penandatangan_tipe` enum('Pasien','Keluarga','Penanggung Jawab') NOT NULL,
  `penandatangan_nama` varchar(255) NOT NULL,
  `penandatangan_nik` varchar(255) DEFAULT NULL COMMENT 'Jika pasien maka dari tabel ''Pasien''',
  `penandatangan_ttd` longtext,
  `policy_rule` enum('opt-in','opt-out') NOT NULL,
  `pernyataan_pasien` json NOT NULL,
  `status` tinyint(1) NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  PRIMARY KEY (`id_general_consent`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `petugas_edukasi_id` (`petugas_edukasi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `icd`
--

DROP TABLE IF EXISTS `icd`;
CREATE TABLE IF NOT EXISTS `icd` (
  `id_icd` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `long_des` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `short_des` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `icd` enum('ICD9','ICD10','ICD11') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_icd`),
  UNIQUE KEY `kode_2` (`kode`),
  KEY `kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_dokter`
--

DROP TABLE IF EXISTS `jadwal_dokter`;
CREATE TABLE IF NOT EXISTS `jadwal_dokter` (
  `id_jadwal` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_dokter` int UNSIGNED NOT NULL,
  `id_poliklinik` int UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_non_jkn` int UNSIGNED DEFAULT NULL,
  `kuota_jkn` int UNSIGNED DEFAULT NULL,
  `time_max` int UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `jadwal_dokter_to_poli` (`id_poliklinik`),
  KEY `id_dokter` (`id_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

DROP TABLE IF EXISTS `kunjungan`;
CREATE TABLE IF NOT EXISTS `kunjungan` (
  `id_kunjungan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_encounter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_pasien` int UNSIGNED NOT NULL,
  `sep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'SEP BPJS',
  `prioritas` enum('Normal','Urgent','Emergency') NOT NULL,
  `keluhan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Menjelaskan latar belakang kunjungan',
  `jenis_kunjungan` enum('Rajal','Ranap') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Rajal / Ranap',
  `id_dokter` int UNSIGNED DEFAULT NULL COMMENT 'Dari Tabel Dokter (penerima)',
  `kode_dokter` varchar(255) DEFAULT NULL,
  `dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Dokter Penerima',
  `dpjp_id` int UNSIGNED DEFAULT NULL COMMENT 'id_dokter DPJP',
  `dpjp_kode` varchar(255) DEFAULT NULL,
  `dpjp_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'nama dokter DPJP',
  `id_poliklinik` int UNSIGNED DEFAULT NULL COMMENT 'dari Tabel Poliklinik',
  `kode_poliklinik` varchar(255) DEFAULT NULL,
  `poliklinik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Poliklinik',
  `kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Dari Tabel rr_kelas_rawat',
  `ruang_rawat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Dari tabel rr_ruang_rawat',
  `tempat_tidur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'dari tabel rr_tempat_tidur',
  `pembayaran_metode` enum('UMUM','ASURANSI') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pembayaran_penanggung` varchar(255) DEFAULT NULL COMMENT 'Nama perusahaan asuransi, paket asuransi',
  `kontak_darurat_nomor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nomor Kontak Darurat',
  `kontak_darurat_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Pemilik Kontak Darurat',
  `kontak_darurat_hubungan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Hubungan Kontak Darurat Dengan pasien',
  `cara_keluar` enum('Atas Permintaan Sendiri','Atas Persetujuan Dokter','Dirujuk','Meninggal','Lain-lain') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('Terdaftar','Selesai','Batal','Meninggal') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Status kunjungan',
  `petugas_id` int UNSIGNED DEFAULT NULL COMMENT 'ID Akses Petugas Dari tabel akses',
  `petugas_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama petugas yang input pertama kali',
  `datetime_daftar` datetime NOT NULL,
  `datetime_pelayanan` datetime DEFAULT NULL,
  `datetime_selesai` datetime DEFAULT NULL,
  PRIMARY KEY (`id_kunjungan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_encounter` (`id_encounter`),
  KEY `id_poliklinik` (`id_poliklinik`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_akses` (`petugas_id`),
  KEY `sep` (`sep`),
  KEY `dpjp_id` (`dpjp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses` int UNSIGNED DEFAULT NULL COMMENT 'ID akses pengguna yang melakukan aktivitas',
  `datetime_log` datetime NOT NULL COMMENT 'tanggal dan waktu kejadian',
  `nama_petugas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Sesuai Tabel Akses Pada saat kejadian',
  `title_log` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'diisi dengan informasi fitur atau nama aktifitas',
  `metadata_log` json DEFAULT NULL COMMENT 'Untuk aktifitas yang melibatkan penghapusan data sensitif',
  PRIMARY KEY (`id_log`),
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mencatat kejadian penting';

-- --------------------------------------------------------

--
-- Struktur dari tabel `observation`
--

DROP TABLE IF EXISTS `observation`;
CREATE TABLE IF NOT EXISTS `observation` (
  `id_observation` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_observation_reference` int UNSIGNED NOT NULL COMMENT 'Dari tabel observation_reference',
  `observation_id` varchar(255) DEFAULT NULL COMMENT 'Dari SATUSEHAT',
  `id_pasien` int UNSIGNED NOT NULL COMMENT 'Dari tabel pasien',
  `id_kunjungan` int UNSIGNED NOT NULL COMMENT 'dari tabel kunjungan',
  `id_praktisi` int UNSIGNED DEFAULT NULL COMMENT 'dari tabel praktisi',
  `nama_praktisi` varchar(255) NOT NULL,
  `observation_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `datetime_observation` datetime NOT NULL COMMENT 'Tanggal/Waktu pemeriksaan',
  `datetime_entry` datetime NOT NULL COMMENT 'Tanggal/Waktu entry',
  `petugas_id` int UNSIGNED DEFAULT NULL COMMENT 'dari tabel akses',
  `petugas_nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_observation`),
  KEY `observation_reference` (`id_observation_reference`),
  KEY `observation_pasien` (`id_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `observation_reference`
--

DROP TABLE IF EXISTS `observation_reference`;
CREATE TABLE IF NOT EXISTS `observation_reference` (
  `id_observation_reference` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL COMMENT 'Kategori observasi lokal',
  `category_code` varchar(255) DEFAULT NULL,
  `category_display` varchar(255) DEFAULT NULL,
  `category_system` varchar(255) DEFAULT NULL,
  `observation_name` varchar(255) NOT NULL COMMENT 'Nama observasi lokal',
  `observation_code` varchar(255) DEFAULT NULL,
  `observation_display` varchar(255) DEFAULT NULL,
  `observation_system` varchar(255) DEFAULT NULL,
  `unit_name` varchar(255) NOT NULL COMMENT 'Nama satuan lokal',
  `unit_code` varchar(255) DEFAULT NULL,
  `unit_display` varchar(255) DEFAULT NULL,
  `unit_system` varchar(255) DEFAULT NULL,
  `result_type` enum('Numeric','Decimal','Coded','Text','Boolean') NOT NULL,
  `result_coded` json DEFAULT NULL COMMENT '[{"label":"x","value":"Y"}]',
  PRIMARY KEY (`id_observation_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Referensi observation atau pemeriksaan';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

DROP TABLE IF EXISTS `pasien`;
CREATE TABLE IF NOT EXISTS `pasien` (
  `id_pasien` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_ihs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'id_patient dari SATUSEHAT',
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_bpjs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nomor Kartu BPJS',
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Provinsi',
  `regency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kabupaten / Kota',
  `subdistrict` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kecamatan',
  `village` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Desa Kelurahan',
  `street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Jalan + RT RW',
  `postal_code` varchar(255) DEFAULT NULL COMMENT 'Kode Pos',
  `kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nomor Kontak Pribadi pasien',
  `golongan_darah` enum('A','B','AB','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pernikahan` enum('Lajang','Menikah','Janda','Duda') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pekerjaan` enum('Tidak Bekerja','Karyawan Swasta','Wirausaha','PNS') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `photo_file_name` varchar(255) DEFAULT NULL COMMENT 'Foto pasien',
  `status` enum('Active','Inactive','Deceased') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_pasien_relasi` int DEFAULT NULL COMMENT 'No RM Ibu (Pasien Bayi)',
  `status_relasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Keterangan hubungan dengan pasien id_pasien_relasi siapa.',
  `id_akses` int UNSIGNED DEFAULT NULL COMMENT 'id_akses petugas yang melakukan input',
  `petugas_pendaftaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama petugas yang mendaftarkan',
  `registered_at` datetime NOT NULL COMMENT 'Pertama kali daftar',
  `updated_at` datetime NOT NULL COMMENT 'Terakhir kali update',
  PRIMARY KEY (`id_pasien`),
  KEY `id_akses` (`id_akses`),
  KEY `id_ihs` (`id_ihs`),
  KEY `nik` (`nik`),
  KEY `no_bpjs` (`no_bpjs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `poliklinik`
--

DROP TABLE IF EXISTS `poliklinik`;
CREATE TABLE IF NOT EXISTS `poliklinik` (
  `id_poliklinik` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `poliklinik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_poliklinik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `praktisi`
--

DROP TABLE IF EXISTS `praktisi`;
CREATE TABLE IF NOT EXISTS `praktisi` (
  `id_praktisi` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_practitioner` varchar(255) DEFAULT NULL COMMENT 'SATUSEHAT',
  `tipe_praktisi` enum('Medis','Non Medis') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profesi_praktisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Dokter, Perawat, Bidan, Rekam Medis, IT DLL',
  `nama_praktisi` varchar(255) NOT NULL,
  `nik_praktisi` varchar(255) DEFAULT NULL,
  `kontak_praktisi` varchar(255) DEFAULT NULL,
  `email_praktisi` varchar(255) DEFAULT NULL,
  `id_akses` int UNSIGNED DEFAULT NULL COMMENT 'Jika Punya Akses',
  `id_dokter` int UNSIGNED DEFAULT NULL COMMENT 'Jika Dokter, Ini Wajib Diisi',
  PRIMARY KEY (`id_praktisi`),
  KEY `praktisi_akses` (`id_akses`),
  KEY `praktisi_dokter` (`id_dokter`),
  KEY `profesi_praktisi` (`profesi_praktisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data praktisi kesehatan yang terlibat dalam RME';

-- --------------------------------------------------------

--
-- Struktur dari tabel `rr_kelas_rawat`
--

DROP TABLE IF EXISTS `rr_kelas_rawat`;
CREATE TABLE IF NOT EXISTS `rr_kelas_rawat` (
  `id_kelas_rawat` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_kelas_rawat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rr_ruang_rawat`
--

DROP TABLE IF EXISTS `rr_ruang_rawat`;
CREATE TABLE IF NOT EXISTS `rr_ruang_rawat` (
  `id_ruang_rawat` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kelas_rawat` int UNSIGNED NOT NULL,
  `ruang_rawat` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_ruang_rawat`),
  KEY `ruang_to_kelas` (`id_kelas_rawat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rr_tempat_tidur`
--

DROP TABLE IF EXISTS `rr_tempat_tidur`;
CREATE TABLE IF NOT EXISTS `rr_tempat_tidur` (
  `id_tempat_tidur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kelas_rawat` int UNSIGNED NOT NULL,
  `id_ruang_rawat` int UNSIGNED NOT NULL,
  `tempat_tidur` varchar(255) NOT NULL,
  `pria` tinyint(1) NOT NULL,
  `wanita` tinyint(1) NOT NULL,
  `bebas` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_tempat_tidur`),
  KEY `tt_to_kelas` (`id_kelas_rawat`),
  KEY `tt_to_ruang_rawat` (`id_ruang_rawat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_rawat`
--

DROP TABLE IF EXISTS `ruang_rawat`;
CREATE TABLE IF NOT EXISTS `ruang_rawat` (
  `id_ruang_rawat` int NOT NULL AUTO_INCREMENT,
  `kategori` enum('Kelas','Ruangan','Tempat Tidur','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kodekelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ruangan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bed` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pria` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `wanita` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bebas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tarif` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_ruang_rawat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id_setting` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_name` enum('Development','Staging','Production') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Lingkungan pengaturan',
  `base_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Base URL Aplikasi',
  `hospital_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama Faskes',
  `hospital_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Alamat Faskes',
  `hospital_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Kontak RS',
  `hospital_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Email Resmi RS Untuk Kop',
  `hospital_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode Faskes Kemenkes',
  `hospital_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama direktur/manajer RS',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama File Logo RS/Faskes',
  `status` tinyint(1) NOT NULL COMMENT '0: Inactive|1:Active',
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Pengaturan umum aplikasi';

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_analyza`
--

DROP TABLE IF EXISTS `setting_analyza`;
CREATE TABLE IF NOT EXISTS `setting_analyza` (
  `id_setting_analyza` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `base_url` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `creat_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_setting_analyza`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_bpjs`
--

DROP TABLE IF EXISTS `setting_bpjs`;
CREATE TABLE IF NOT EXISTS `setting_bpjs` (
  `id_setting_bpjs` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_setting_bpjs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `consid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_key_antrol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `secret_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode_ppk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_vclaim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url_aplicare` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url_antrol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url_icare` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_setting_bpjs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_email_gateway`
--

DROP TABLE IF EXISTS `setting_email_gateway`;
CREATE TABLE IF NOT EXISTS `setting_email_gateway` (
  `id_setting_email_gateway` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_provider` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `port_gateway` int NOT NULL,
  `nama_pengirim` varchar(2555) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_service` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1/0',
  PRIMARY KEY (`id_setting_email_gateway`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_google`
--

DROP TABLE IF EXISTS `setting_google`;
CREATE TABLE IF NOT EXISTS `setting_google` (
  `id_setting_google` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `credential_env` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `client_id` text NOT NULL,
  `client_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_setting_google`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_radix`
--

DROP TABLE IF EXISTS `setting_radix`;
CREATE TABLE IF NOT EXISTS `setting_radix` (
  `id_setting_radix` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `base_url` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `creat_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'true or false',
  PRIMARY KEY (`id_setting_radix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_satusehat`
--

DROP TABLE IF EXISTS `setting_satusehat`;
CREATE TABLE IF NOT EXISTS `setting_satusehat` (
  `id_setting_satusehat` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_setting_satusehat` varchar(255) NOT NULL,
  `url_satusehat` varchar(255) NOT NULL,
  `organization_id` varchar(255) NOT NULL,
  `client_key` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `datetime_expired` datetime NOT NULL,
  `status_setting_satusehat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_setting_satusehat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_sifarma`
--

DROP TABLE IF EXISTS `setting_sifarma`;
CREATE TABLE IF NOT EXISTS `setting_sifarma` (
  `id_setting_sifarma` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `base_url` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `creat_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_setting_sifarma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_sirs_online`
--

DROP TABLE IF EXISTS `setting_sirs_online`;
CREATE TABLE IF NOT EXISTS `setting_sirs_online` (
  `id_setting_sirs_online` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_setting_sirs_online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_sirs_online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_rs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_sirs_online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/1',
  PRIMARY KEY (`id_setting_sirs_online`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_sisrute`
--

DROP TABLE IF EXISTS `setting_sisrute`;
CREATE TABLE IF NOT EXISTS `setting_sisrute` (
  `id_setting_sisrute` int NOT NULL AUTO_INCREMENT,
  `nama_setting` text NOT NULL,
  `id_rs` varchar(20) NOT NULL,
  `password_sisrute` varchar(20) NOT NULL,
  `url_sisrute` text NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Aktiv/Non-Aktiv',
  PRIMARY KEY (`id_setting_sisrute`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_web`
--

DROP TABLE IF EXISTS `setting_web`;
CREATE TABLE IF NOT EXISTS `setting_web` (
  `id_setting_web` int NOT NULL AUTO_INCREMENT,
  `user_key` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `access_key` varchar(36) NOT NULL,
  `base_url_service` text NOT NULL,
  `last_update` varchar(30) NOT NULL,
  PRIMARY KEY (`id_setting_web`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan`
--

DROP TABLE IF EXISTS `tindakan`;
CREATE TABLE IF NOT EXISTS `tindakan` (
  `id_tindakan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pasien` int UNSIGNED NOT NULL,
  `id_kunjungan` int UNSIGNED NOT NULL,
  `id_tindakan_referensi` int UNSIGNED DEFAULT NULL,
  `id_procedure` varchar(255) DEFAULT NULL COMMENT 'SATUSEHAT',
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `reson_reference` enum('ICD10','ICD11') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Sumber reson code',
  `reson_code` varchar(255) DEFAULT NULL COMMENT 'Kode ICD10 - Alasan tindakan',
  `reson_display` varchar(255) DEFAULT NULL COMMENT 'Description ICD10 - Alasan tindakan',
  `post_tindakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Keterangan/Catatan kondisi setelah tindakan',
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  `petugas_id` int UNSIGNED DEFAULT NULL,
  `petugas_nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_tindakan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_tindakan_referensi` (`id_tindakan_referensi`),
  KEY `petugas_id` (`petugas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data tindakan yang diberikan kepada pasien';

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan_performer`
--

DROP TABLE IF EXISTS `tindakan_performer`;
CREATE TABLE IF NOT EXISTS `tindakan_performer` (
  `id_tindakan_performer` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tindakan` int UNSIGNED NOT NULL COMMENT 'Dari tabel tindakan',
  `id_praktisi` int UNSIGNED DEFAULT NULL COMMENT 'dari tabel praktisi',
  `performer_type` enum('Utama','Pendamping') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `performer_ihs` varchar(255) DEFAULT NULL COMMENT 'ID Practitioner Pelaksana (SATUSEHAT)',
  `performer_nik` varchar(255) DEFAULT NULL COMMENT 'NIK Pelaksana',
  `performer_nama` varchar(255) NOT NULL COMMENT 'Nama lengkap pelaksana',
  `performer_notes` text COMMENT 'Catatan dari performer',
  PRIMARY KEY (`id_tindakan_performer`),
  KEY `id_tindakan` (`id_tindakan`),
  KEY `id_praktisi` (`id_praktisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Untuk mencatat siapa saja yang terlibat dalam tindakan';

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan_referensi`
--

DROP TABLE IF EXISTS `tindakan_referensi`;
CREATE TABLE IF NOT EXISTS `tindakan_referensi` (
  `id_tindakan_referensi` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_tindakan` varchar(255) NOT NULL COMMENT 'Kategori Istilah lokal',
  `kategori_tindakan_code` varchar(255) DEFAULT NULL COMMENT 'kode kategori SNOMED',
  `kategori_tindakan_display` varchar(255) DEFAULT NULL COMMENT 'Desktipsi kategori SNOMED',
  `kategori_tindakan_system` varchar(255) DEFAULT NULL COMMENT 'http://snomed.info/sct',
  `nama_tindakan` varchar(255) NOT NULL COMMENT 'Nama tindakan (lokal)',
  `nama_tindakan_code` varchar(255) DEFAULT NULL COMMENT 'Kode Tindakan (SNOMED)',
  `nama_tindakan_display` varchar(255) DEFAULT NULL COMMENT 'NamaTindakan (SNOMED)',
  `nama_tindakan_system` varchar(255) DEFAULT NULL COMMENT 'Sistem Yang Digunakan',
  `lokasi_tubuh` varchar(255) NOT NULL COMMENT 'Lokasi tubuh (Lokal)',
  `lokasi_tubuh_code` varchar(255) DEFAULT NULL COMMENT 'Kode lokasi tubuh (SNOMED)',
  `lokasi_tubuh_display` varchar(255) DEFAULT NULL COMMENT 'nama lokasi tubuh (SNOMED)',
  `lokasi_tubuh_system` varchar(255) DEFAULT NULL COMMENT 'Sistem yang digunakan',
  `icd9_code` varchar(255) DEFAULT NULL COMMENT 'kode ICD9',
  `icd9_description` varchar(255) DEFAULT NULL COMMENT 'Deskripsi ICD9',
  `status` tinyint(1) NOT NULL COMMENT 'Soft Delete',
  `datetime_creat` datetime NOT NULL COMMENT 'Datetime Data Dibuat',
  `author_id` int UNSIGNED DEFAULT NULL COMMENT 'ID Akses Author',
  `author_name` varchar(255) NOT NULL COMMENT 'Nama Author',
  PRIMARY KEY (`id_tindakan_referensi`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mencatat referensi tindakan';

-- --------------------------------------------------------

--
-- Struktur dari tabel `wilayah`
--

DROP TABLE IF EXISTS `wilayah`;
CREATE TABLE IF NOT EXISTS `wilayah` (
  `id_wilayah` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `regency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subdistrict` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `village` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipe_level2` enum('Kabupaten','Kota','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tipe_level4` enum('Desa','Kelurahan','') DEFAULT NULL,
  `kode_mendagri_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode Provinsi - Mendagri',
  `kode_mendagri_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode Kabupaten/Kota- Mendagri',
  `kode_mendagri_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode Kecamatan - Mendagri',
  `kode_mendagri_4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode Desa/Kelurahan- Mendagri',
  `kode_bpjs1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_bpjs2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_bpjs3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_wilayah`),
  KEY `province` (`province`),
  KEY `regency` (`regency`),
  KEY `subdistrict` (`subdistrict`),
  KEY `village` (`village`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_to_entitas` FOREIGN KEY (`id_akses_entitas`) REFERENCES `akses_entitas` (`id_akses_entitas`) ON DELETE SET NULL,
  ADD CONSTRAINT `akses_to_pengajuan` FOREIGN KEY (`id_akses_pengajuan`) REFERENCES `akses_pengajuan` (`id_akses_pengajuan`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `akses_acc`
--
ALTER TABLE `akses_acc`
  ADD CONSTRAINT `acc_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acc_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `akses_entitas_acc`
--
ALTER TABLE `akses_entitas_acc`
  ADD CONSTRAINT `entitas_acc_to_entitas` FOREIGN KEY (`id_akses_entitas`) REFERENCES `akses_entitas` (`id_akses_entitas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entitas_acc_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `akses_login`
--
ALTER TABLE `akses_login`
  ADD CONSTRAINT `login_to_access` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `akses_reset`
--
ALTER TABLE `akses_reset`
  ADD CONSTRAINT `reset_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `alergi`
--
ALTER TABLE `alergi`
  ADD CONSTRAINT `alergi_akses` FOREIGN KEY (`author_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `alergi_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alergi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alergi_to_alergen` FOREIGN KEY (`id_alergi_alergen`) REFERENCES `alergi_alergen` (`id_alergi_alergen`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  ADD CONSTRAINT `antrian_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE SET NULL,
  ADD CONSTRAINT `antrian_to_akses` FOREIGN KEY (`update_by_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `antrian_to_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_dokter` (`id_jadwal`) ON DELETE SET NULL,
  ADD CONSTRAINT `antrian_to_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE SET NULL,
  ADD CONSTRAINT `antrian_to_poliklinik` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `api_token`
--
ALTER TABLE `api_token`
  ADD CONSTRAINT `api_key_to_token` FOREIGN KEY (`id_api_key`) REFERENCES `api_key` (`id_api_key`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD CONSTRAINT `diagnosis_akses` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `diagnosis_dokter` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  ADD CONSTRAINT `diagnosis_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diagnosis_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `general_consent`
--
ALTER TABLE `general_consent`
  ADD CONSTRAINT `gc_to_akses` FOREIGN KEY (`petugas_edukasi_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `gc_to_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_to_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `jadwal_dokter_to_poli` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_to_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  ADD CONSTRAINT `kunjungan_dpjp` FOREIGN KEY (`dpjp_id`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  ADD CONSTRAINT `kunjungan_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kunjungan_petugas_id` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `kunjungan_poliklinik` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `observation`
--
ALTER TABLE `observation`
  ADD CONSTRAINT `observation_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `observation_reference` FOREIGN KEY (`id_observation_reference`) REFERENCES `observation_reference` (`id_observation_reference`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `praktisi`
--
ALTER TABLE `praktisi`
  ADD CONSTRAINT `praktisi_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `praktisi_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rr_ruang_rawat`
--
ALTER TABLE `rr_ruang_rawat`
  ADD CONSTRAINT `ruang_to_kelas` FOREIGN KEY (`id_kelas_rawat`) REFERENCES `rr_kelas_rawat` (`id_kelas_rawat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rr_tempat_tidur`
--
ALTER TABLE `rr_tempat_tidur`
  ADD CONSTRAINT `tt_to_kelas` FOREIGN KEY (`id_kelas_rawat`) REFERENCES `rr_kelas_rawat` (`id_kelas_rawat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tt_to_ruang_rawat` FOREIGN KEY (`id_ruang_rawat`) REFERENCES `rr_ruang_rawat` (`id_ruang_rawat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  ADD CONSTRAINT `tindakan_akses` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `tindakan_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tindakan_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tindakan_to_referensi` FOREIGN KEY (`id_tindakan_referensi`) REFERENCES `tindakan_referensi` (`id_tindakan_referensi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tindakan_performer`
--
ALTER TABLE `tindakan_performer`
  ADD CONSTRAINT `performer_praktisi` FOREIGN KEY (`id_praktisi`) REFERENCES `praktisi` (`id_praktisi`) ON DELETE SET NULL,
  ADD CONSTRAINT `performer_tindakan` FOREIGN KEY (`id_tindakan`) REFERENCES `tindakan` (`id_tindakan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tindakan_referensi`
--
ALTER TABLE `tindakan_referensi`
  ADD CONSTRAINT `tindakan_referensi_to_akses` FOREIGN KEY (`author_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

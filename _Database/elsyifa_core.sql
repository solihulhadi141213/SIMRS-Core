-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 30, 2026 at 08:27 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elsyifa_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
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
  KEY `id_akses_entitas` (`id_akses_entitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan data akun pengguna';

-- --------------------------------------------------------

--
-- Table structure for table `akses_acc`
--

DROP TABLE IF EXISTS `akses_acc`;
CREATE TABLE IF NOT EXISTS `akses_acc` (
  `id_akses_acc` int NOT NULL AUTO_INCREMENT,
  `id_akses` int UNSIGNED NOT NULL,
  `id_akses_fitur` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_akses_acc`),
  KEY `id_akses` (`id_akses`),
  KEY `id_akses_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akses_entitas`
--

DROP TABLE IF EXISTS `akses_entitas`;
CREATE TABLE IF NOT EXISTS `akses_entitas` (
  `id_akses_entitas` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `akses` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama akses yang ada pada data akses',
  `deskripsi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Gambaran umum akses',
  PRIMARY KEY (`id_akses_entitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akses_entitas_acc`
--

DROP TABLE IF EXISTS `akses_entitas_acc`;
CREATE TABLE IF NOT EXISTS `akses_entitas_acc` (
  `id_akses_entitas_acc` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_akses_entitas` int UNSIGNED NOT NULL,
  `id_akses_fitur` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_akses_entitas_acc`),
  KEY `entitas_acc_to_entitas` (`id_akses_entitas`),
  KEY `entitas_acc_to_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akses_fitur`
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
-- Table structure for table `akses_laporan`
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
-- Table structure for table `akses_login`
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
-- Table structure for table `akses_pengajuan`
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
-- Table structure for table `akses_reset`
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
-- Table structure for table `api_key`
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
-- Table structure for table `api_token`
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
-- Table structure for table `captcha`
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
-- Table structure for table `dokter`
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
  PRIMARY KEY (`id_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd`
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
-- Table structure for table `icd_upload_log`
--

DROP TABLE IF EXISTS `icd_upload_log`;
CREATE TABLE IF NOT EXISTS `icd_upload_log` (
  `id_upload` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `total_rows` int DEFAULT NULL,
  `processed_rows` int DEFAULT '0',
  `status` enum('pending','processing','done','error') DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_upload`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
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
-- Table structure for table `kunjungan_utama`
--

DROP TABLE IF EXISTS `kunjungan_utama`;
CREATE TABLE IF NOT EXISTS `kunjungan_utama` (
  `id_kunjungan` int NOT NULL AUTO_INCREMENT,
  `id_encounter` text CHARACTER SET latin1,
  `id_pasien` int NOT NULL,
  `no_antrian` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `nik` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `no_bpjs` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `sep` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `noRujukan` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `skdp` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nama` text CHARACTER SET latin1 NOT NULL,
  `tanggal` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `propinsi` text CHARACTER SET latin1,
  `kabupaten` text CHARACTER SET latin1,
  `kecamatan` text CHARACTER SET latin1,
  `desa` text CHARACTER SET latin1,
  `alamat` text CHARACTER SET latin1,
  `keluhan` text CHARACTER SET latin1,
  `tujuan` varchar(20) CHARACTER SET latin1 NOT NULL,
  `id_dokter` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `dokter` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `id_poliklinik` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `poliklinik` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `kelas` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `ruangan` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `id_kasur` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `DiagAwal` text CHARACTER SET latin1,
  `rujukan_dari` text CHARACTER SET latin1,
  `rujukan_ke` text CHARACTER SET latin1,
  `pembayaran` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `cara_keluar` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `tanggal_keluar` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `status` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `id_akses` int DEFAULT NULL,
  `nama_petugas` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  UNIQUE KEY `id_kunjungan_2` (`id_kunjungan`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_pasien` (`id_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `waktu` varchar(30) CHARACTER SET latin1 NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 NOT NULL,
  `nama_log` varchar(100) CHARACTER SET latin1 NOT NULL,
  `kategori` varchar(100) CHARACTER SET latin1 NOT NULL,
  `id_akses` int NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

DROP TABLE IF EXISTS `pasien`;
CREATE TABLE IF NOT EXISTS `pasien` (
  `id_pasien` int NOT NULL AUTO_INCREMENT,
  `id_ihs` text,
  `tanggal_daftar` varchar(30) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `no_bpjs` varchar(20) DEFAULT NULL,
  `nama` text NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` varchar(20) DEFAULT NULL,
  `propinsi` varchar(50) DEFAULT NULL,
  `kabupaten` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `desa` varchar(50) DEFAULT NULL,
  `alamat` text,
  `kontak` varchar(50) DEFAULT NULL,
  `kontak_darurat` varchar(50) DEFAULT NULL,
  `penanggungjawab` varchar(50) DEFAULT NULL,
  `golongan_darah` varchar(10) DEFAULT NULL,
  `perkawinan` varchar(20) DEFAULT NULL,
  `pekerjaan` varchar(20) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `id_pasien_relasi` int DEFAULT NULL,
  `status_relasi` varchar(20) DEFAULT NULL COMMENT 'Keterangan id_pasien_relasi siapa.',
  `id_akses` int DEFAULT NULL COMMENT 'id_akses petugas yang melakukan input',
  `nama_petugas` text,
  `updatetime` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poliklinik`
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
-- Table structure for table `rr_kelas_rawat`
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
-- Table structure for table `rr_ruang_rawat`
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
-- Table structure for table `rr_tempat_tidur`
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
-- Table structure for table `ruang_rawat`
--

DROP TABLE IF EXISTS `ruang_rawat`;
CREATE TABLE IF NOT EXISTS `ruang_rawat` (
  `id_ruang_rawat` int NOT NULL AUTO_INCREMENT,
  `kategori` enum('Kelas','Ruangan','Tempat Tidur','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kodekelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ruangan` varchar(50) CHARACTER SET latin1 NOT NULL,
  `bed` varchar(25) CHARACTER SET latin1 NOT NULL,
  `pria` varchar(20) CHARACTER SET latin1 NOT NULL,
  `wanita` varchar(20) CHARACTER SET latin1 NOT NULL,
  `bebas` varchar(20) CHARACTER SET latin1 NOT NULL,
  `tarif` varchar(20) CHARACTER SET latin1 NOT NULL,
  `status` varchar(20) CHARACTER SET latin1 NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_ruang_rawat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id_setting` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `aplication_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aplication_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `aplication_keyword` json DEFAULT NULL COMMENT 'contoh : [''RSU'',''EL-Syifa'']',
  `aplication_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama pembuat aplikasi',
  `base_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hospital_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hospital_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hospital_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hospital_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Email Resmi RS Untuk Kop',
  `hospital_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode Faskes Kemenkes',
  `hospital_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_analyza`
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
-- Table structure for table `setting_bpjs`
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
-- Table structure for table `setting_email_gateway`
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
-- Table structure for table `setting_google`
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
-- Table structure for table `setting_radix`
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
-- Table structure for table `setting_satusehat`
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
-- Table structure for table `setting_sifarma`
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
-- Table structure for table `setting_sirs_online`
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
-- Table structure for table `setting_sisrute`
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
-- Table structure for table `setting_web`
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
-- Table structure for table `wilayah`
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
  `kode_mendagri_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_mendagri_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_mendagri_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_mendagri_4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_wilayah`),
  KEY `province` (`province`),
  KEY `regency` (`regency`),
  KEY `subdistrict` (`subdistrict`),
  KEY `village` (`village`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_to_entitas` FOREIGN KEY (`id_akses_entitas`) REFERENCES `akses_entitas` (`id_akses_entitas`) ON DELETE SET NULL,
  ADD CONSTRAINT `akses_to_pengajuan` FOREIGN KEY (`id_akses_pengajuan`) REFERENCES `akses_pengajuan` (`id_akses_pengajuan`) ON DELETE SET NULL;

--
-- Constraints for table `akses_acc`
--
ALTER TABLE `akses_acc`
  ADD CONSTRAINT `acc_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acc_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_entitas_acc`
--
ALTER TABLE `akses_entitas_acc`
  ADD CONSTRAINT `entitas_acc_to_entitas` FOREIGN KEY (`id_akses_entitas`) REFERENCES `akses_entitas` (`id_akses_entitas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entitas_acc_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_login`
--
ALTER TABLE `akses_login`
  ADD CONSTRAINT `login_to_access` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_reset`
--
ALTER TABLE `akses_reset`
  ADD CONSTRAINT `reset_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `api_token`
--
ALTER TABLE `api_token`
  ADD CONSTRAINT `api_key_to_token` FOREIGN KEY (`id_api_key`) REFERENCES `api_key` (`id_api_key`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `jadwal_dokter_to_poli` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_to_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rr_ruang_rawat`
--
ALTER TABLE `rr_ruang_rawat`
  ADD CONSTRAINT `ruang_to_kelas` FOREIGN KEY (`id_kelas_rawat`) REFERENCES `rr_kelas_rawat` (`id_kelas_rawat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rr_tempat_tidur`
--
ALTER TABLE `rr_tempat_tidur`
  ADD CONSTRAINT `tt_to_kelas` FOREIGN KEY (`id_kelas_rawat`) REFERENCES `rr_kelas_rawat` (`id_kelas_rawat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tt_to_ruang_rawat` FOREIGN KEY (`id_ruang_rawat`) REFERENCES `rr_ruang_rawat` (`id_ruang_rawat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

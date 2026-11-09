-- MySQL dump 10.13  Distrib 8.4.7, for Win64 (x86_64)
--
-- Host: localhost    Database: elsyifa_core
-- ------------------------------------------------------
-- Server version	8.4.7

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `akses`
--

DROP TABLE IF EXISTS `akses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses` (
  `id_akses` int unsigned NOT NULL AUTO_INCREMENT,
  `id_akses_pengajuan` int unsigned DEFAULT NULL,
  `id_akses_entitas` int unsigned DEFAULT NULL,
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
  KEY `nama` (`nama`),
  CONSTRAINT `akses_to_entitas` FOREIGN KEY (`id_akses_entitas`) REFERENCES `akses_entitas` (`id_akses_entitas`) ON DELETE SET NULL,
  CONSTRAINT `akses_to_pengajuan` FOREIGN KEY (`id_akses_pengajuan`) REFERENCES `akses_pengajuan` (`id_akses_pengajuan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan data akun pengguna';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_acc`
--

DROP TABLE IF EXISTS `akses_acc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_acc` (
  `id_akses_acc` int NOT NULL AUTO_INCREMENT,
  `id_akses` int unsigned NOT NULL,
  `id_akses_fitur` int unsigned NOT NULL,
  PRIMARY KEY (`id_akses_acc`),
  KEY `id_akses` (`id_akses`),
  KEY `id_akses_fitur` (`id_akses_fitur`),
  CONSTRAINT `acc_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `acc_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8023 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mapping akses ke akses_fitur';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_entitas`
--

DROP TABLE IF EXISTS `akses_entitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_entitas` (
  `id_akses_entitas` int unsigned NOT NULL AUTO_INCREMENT,
  `akses` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama akses yang ada pada data akses',
  `deskripsi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Gambaran umum akses',
  PRIMARY KEY (`id_akses_entitas`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan data entitas akses';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_entitas_acc`
--

DROP TABLE IF EXISTS `akses_entitas_acc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_entitas_acc` (
  `id_akses_entitas_acc` int unsigned NOT NULL AUTO_INCREMENT,
  `id_akses_entitas` int unsigned NOT NULL,
  `id_akses_fitur` int unsigned NOT NULL,
  PRIMARY KEY (`id_akses_entitas_acc`),
  KEY `entitas_acc_to_entitas` (`id_akses_entitas`),
  KEY `entitas_acc_to_fitur` (`id_akses_fitur`),
  CONSTRAINT `entitas_acc_to_entitas` FOREIGN KEY (`id_akses_entitas`) REFERENCES `akses_entitas` (`id_akses_entitas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entitas_acc_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=291 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='akses standar yang dimiliki entitas akses';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_fitur`
--

DROP TABLE IF EXISTS `akses_fitur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_fitur` (
  `id_akses_fitur` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_fitur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL COMMENT 'kode akses fitur',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Penjelasan fitur/halaman',
  PRIMARY KEY (`id_akses_fitur`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='daftar fitur aplikasi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_laporan`
--

DROP TABLE IF EXISTS `akses_laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_laporan` (
  `id_akses_laporan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `laporan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Isi laporan',
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Response dari admin',
  `status` enum('Terkirim','Dibaca','Selesai','Draft') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_akses_laporan`),
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_login`
--

DROP TABLE IF EXISTS `akses_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_login` (
  `id_akses_login` int unsigned NOT NULL AUTO_INCREMENT,
  `id_akses` int unsigned NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Token yang tercipta saat login',
  `creat_at` datetime NOT NULL COMMENT 'Token dibuat',
  `expired_at` datetime NOT NULL COMMENT 'Token Expired',
  `local_timezone_user` varchar(255) NOT NULL COMMENT 'Informasi timezone pengguna',
  PRIMARY KEY (`id_akses_login`),
  KEY `akses_to_login` (`id_akses`),
  CONSTRAINT `login_to_access` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_pengajuan`
--

DROP TABLE IF EXISTS `akses_pengajuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_pengajuan` (
  `id_akses_pengajuan` int unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akses_reset`
--

DROP TABLE IF EXISTS `akses_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_reset` (
  `id_akses_reset` int unsigned NOT NULL AUTO_INCREMENT,
  `id_akses` int unsigned NOT NULL,
  `datetime_creat` datetime NOT NULL COMMENT 'UTC',
  `datetime_expired` datetime NOT NULL COMMENT 'UTC',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'hasing',
  PRIMARY KEY (`id_akses_reset`),
  KEY `reset_to_access` (`id_akses`),
  CONSTRAINT `reset_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alergi`
--

DROP TABLE IF EXISTS `alergi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alergi` (
  `id_alergi` varchar(255) NOT NULL COMMENT 'uid',
  `id_pasien` int unsigned NOT NULL,
  `id_kunjungan` int unsigned NOT NULL,
  `id_alergi_alergen` int unsigned DEFAULT NULL,
  `AllergyIntolerance` varchar(255) DEFAULT NULL,
  `kategori_alergen` varchar(255) NOT NULL,
  `nama_alergen` varchar(255) NOT NULL,
  `clinical_status` enum('active','inactive','resolved') NOT NULL,
  `verification_status` enum('unconfirmed','presumed','confirmed','refuted','entered-in-error') NOT NULL,
  `id_praktisi` int unsigned DEFAULT NULL,
  `nama_praktisi` varchar(255) NOT NULL,
  `keterangan_alergi` text COMMENT 'Keterangan, reaksi yang dialamai pasien',
  `author_id` int unsigned DEFAULT NULL COMMENT 'id_akses petugas entry',
  `author_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'nama petugas',
  `datetime_creat` datetime NOT NULL,
  PRIMARY KEY (`id_alergi`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_alergi_alergen` (`id_alergi_alergen`),
  KEY `author_id` (`author_id`),
  KEY `id_praktisi` (`id_praktisi`),
  CONSTRAINT `alergi_akses` FOREIGN KEY (`author_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `alergi_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `alergi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `alergi_to_alergen` FOREIGN KEY (`id_alergi_alergen`) REFERENCES `alergi_alergen` (`id_alergi_alergen`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alergi_alergen`
--

DROP TABLE IF EXISTS `alergi_alergen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alergi_alergen` (
  `id_alergi_alergen` int unsigned NOT NULL AUTO_INCREMENT,
  `kategori_alergen` enum('Food','Medication','Environment','Biologic') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_alergen` varchar(255) NOT NULL,
  `code_alergen` varchar(255) DEFAULT NULL,
  `display_alergen` varchar(255) DEFAULT NULL,
  `system_alergen` text COMMENT 'http://snomed.info/sct',
  `author_id` int unsigned DEFAULT NULL COMMENT 'ID akses pembuat',
  `author_name` varchar(255) NOT NULL COMMENT 'Nama pembuat',
  `datetime_creat` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_alergi_alergen`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Referensi zat alergen';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `antrian`
--

DROP TABLE IF EXISTS `antrian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `antrian` (
  `id_antrian` int unsigned NOT NULL AUTO_INCREMENT,
  `id_pasien` int unsigned DEFAULT NULL COMMENT 'Jika kosong maka pasien baru',
  `id_kunjungan` int unsigned DEFAULT NULL COMMENT 'Jika kosong maka belum ada kunjungan',
  `id_poliklinik` int unsigned DEFAULT NULL COMMENT 'Jika kosong maka poli dihapus',
  `id_dokter` int unsigned DEFAULT NULL COMMENT 'Jika kosong maka dokter dihapus',
  `id_jadwal` int unsigned DEFAULT NULL COMMENT 'Jika kosong maka jadwal dihapus',
  `no_antrian` int unsigned NOT NULL COMMENT 'Nomor urutan antrian',
  `kode_booking` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kode acak booking',
  `nama_pasien` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama lengkap pasien',
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Identitas KTP',
  `no_bpjs` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nomor BPJS',
  `kontak` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kontak pasien',
  `gender` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jenis Kelamin',
  `nomor_referensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomor dokumen yang mereferensikan',
  `jenis_referensi` enum('1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT ' 	1.Rujukan FKTP 2.Rujukan Internal 3.Kontrol 4.Rujukan Antar RS ',
  `jenis_request` tinyint(1) NOT NULL COMMENT 'Pasien Baru? 0=Tidak, 1=Ya ',
  `poli_eksekutif` tinyint(1) NOT NULL COMMENT 'Apakah Polieksekutif? 0. Tidak 1. Ya ',
  `pembayaran` enum('UMUM','BPJS','ASURANSI') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Metode pembayaran yang digunakan',
  `keluhan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Keluhan yang dirasakan pasien',
  `nama_dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama dokter sesuai tabel dokter',
  `nama_poliklinik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'nama poli sesuai poliklinik',
  `tanggal_kunjungan` date NOT NULL COMMENT 'Tanggal Rencana Kunjungan',
  `datetime_creat` datetime NOT NULL COMMENT 'Tanggal & Jam Pendaftaran antrian dibuat (UTC)',
  `status_antrian` enum('Terdaftar','Batal','Checkin','Panggil Admisi','Tunggu Poli','Layanan Poli','Tunggu Farmasi','Layanan Farmasi','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Posisi status pelayanan pasien',
  `sumber_antrian` enum('JKN Mobile','Website','Mesin Antrian','Manual') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Dari mana data ini berasal',
  `ws_bpjs` tinyint(1) NOT NULL COMMENT 'Apakahh antrian sudah dikirim ke antrol BPJS',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Misalnya keterangan penyebab pembatalan',
  `update_by_id` int unsigned DEFAULT NULL COMMENT 'ID Akses yang melakukan update',
  `update_by_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nama akses yang melakukan update',
  `update_at` datetime DEFAULT NULL COMMENT 'Waktu update (kosong, jika belum pernah diubah)',
  PRIMARY KEY (`id_antrian`),
  KEY `antrian_pasien` (`id_pasien`),
  KEY `antrian_to_kunjungan` (`id_kunjungan`),
  KEY `antrian_to_poliklinik` (`id_poliklinik`),
  KEY `antrian_dokter` (`id_dokter`),
  KEY `antrian_to_jadwal` (`id_jadwal`),
  KEY `antrian_to_akses` (`update_by_id`),
  CONSTRAINT `antrian_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  CONSTRAINT `antrian_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE SET NULL,
  CONSTRAINT `antrian_to_akses` FOREIGN KEY (`update_by_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `antrian_to_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_dokter` (`id_jadwal`) ON DELETE SET NULL,
  CONSTRAINT `antrian_to_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE SET NULL,
  CONSTRAINT `antrian_to_poliklinik` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `antrian_log`
--

DROP TABLE IF EXISTS `antrian_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `antrian_log` (
  `id_antrian_log` int unsigned NOT NULL AUTO_INCREMENT,
  `id_antrian` int unsigned NOT NULL COMMENT 'Dari tabel antrian',
  `status_antrian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Sesuai Enum status antrian',
  `datetime_rs` datetime NOT NULL COMMENT 'Tanggal & Jam Rumah Sakit',
  `datetime_bpjs` datetime DEFAULT NULL COMMENT 'Tanggal & Jam BPJS',
  PRIMARY KEY (`id_antrian_log`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Catatan layanan antrian';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `api_key`
--

DROP TABLE IF EXISTS `api_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_key` (
  `id_api_key` int unsigned NOT NULL AUTO_INCREMENT,
  `api_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama API',
  `api_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Penjelasan Singkat',
  `client_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'ID Pengguna (Username)',
  `client_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Hasing / Password',
  `expired_duration` int unsigned NOT NULL COMMENT 'Hour / Jam',
  `datetime_creat` datetime NOT NULL COMMENT 'Kapan API Key Dibuat',
  `datetime_update` datetime NOT NULL COMMENT 'Kapan Terakhir Kali API Key Diubah',
  PRIMARY KEY (`id_api_key`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `api_token`
--

DROP TABLE IF EXISTS `api_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_token` (
  `id_api_token` int unsigned NOT NULL AUTO_INCREMENT,
  `id_api_key` int unsigned NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  PRIMARY KEY (`id_api_token`),
  KEY `id_api_access` (`id_api_key`),
  CONSTRAINT `api_key_to_token` FOREIGN KEY (`id_api_key`) REFERENCES `api_key` (`id_api_key`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Untuk menampung API token';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `body_site`
--

DROP TABLE IF EXISTS `body_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `body_site` (
  `id_body_site` int unsigned NOT NULL AUTO_INCREMENT,
  `body_site_category` enum('Kepala dan leher','Dada dan toraks','Abdomen dan panggul','Punggung dan tulang belakang','Ekstremitas atas','Ekstremitas bawah','Kulit dan permukaan tubuh','Organ internal dan struktur spesifik','Seluruh tubuh atau lokasi umum') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `body_site_nama` varchar(255) NOT NULL COMMENT 'Nama Body Site Dalam istilah Lokal',
  `body_site_display` varchar(255) DEFAULT NULL COMMENT 'Nama Body Site Berdasarkan standar referensi yang digunakan',
  `body_site_code` varchar(255) DEFAULT NULL COMMENT 'Kode Body Site Berdasarkan standar referensi yang digunakan',
  `body_site_system` text COMMENT 'System Sumber',
  `datetime_creat` datetime NOT NULL COMMENT 'Keterangan waktu pembuatan data',
  `datetime_update` datetime NOT NULL COMMENT 'Keterangan waktu kapan diubah',
  `author_id` int unsigned DEFAULT NULL COMMENT 'ID akses autohor',
  `author_name` varchar(255) DEFAULT NULL COMMENT 'Nama Author',
  PRIMARY KEY (`id_body_site`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Daftar Referensi Lokasi Tubuh';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `captcha` (
  `id_captcha` varchar(255) NOT NULL,
  `feature_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Ex: Login, Pendaftaran',
  `code_captcha` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creat_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  PRIMARY KEY (`id_captcha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan kode captcha sekali pakai';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `diagnosis`
--

DROP TABLE IF EXISTS `diagnosis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnosis` (
  `id_diagnosis` int unsigned NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int unsigned NOT NULL,
  `id_pasien` int unsigned NOT NULL,
  `id_condition` varchar(255) DEFAULT NULL,
  `dokter_id` int unsigned DEFAULT NULL COMMENT 'ID Dokter Yang Menyatakan',
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
  `petugas_id` int unsigned DEFAULT NULL COMMENT 'ID akses Petugas',
  `petugas_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama Petugas',
  PRIMARY KEY (`id_diagnosis`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `dokter_id` (`dokter_id`),
  KEY `id_condition` (`id_condition`),
  KEY `diagnosis_akses` (`petugas_id`),
  CONSTRAINT `diagnosis_akses` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `diagnosis_dokter` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  CONSTRAINT `diagnosis_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `diagnosis_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dokter`
--

DROP TABLE IF EXISTS `dokter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokter` (
  `id_dokter` int unsigned NOT NULL AUTO_INCREMENT,
  `id_ihs_practitioner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'id IHS Satu sehat (Jika ada)',
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode unik dokter, bisa untuk BPJS',
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama lengkap',
  `gender` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Jenis kelamin',
  `tanggal_lahir` date NOT NULL COMMENT 'Tanggal lahir dokter',
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Ex: Spesialis Penyakit Dalam',
  `kategori_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'KTP, KK, Passport dll',
  `no_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nomor identitas yg dipilih',
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Informasi alamat dokter',
  `kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'untuk kirim notifikasi',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'untuk kirim notifikasi',
  `SIP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nomor surat SIP',
  `status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active',
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama file foto',
  `creat_by_id` int unsigned DEFAULT NULL COMMENT 'ID akses yang membuat',
  `creat_by_name` varchar(255) NOT NULL COMMENT 'Nama akses yang membuat',
  `creat_at` datetime NOT NULL COMMENT 'Tanggal dan waktu Input data',
  `update_by_id` int unsigned DEFAULT NULL COMMENT 'ID akses yang update',
  `update_by_name` varchar(255) NOT NULL COMMENT 'Nama akses yang melakukan update',
  `update_at` datetime NOT NULL COMMENT 'Tanggal dan waktu diperbaharui',
  PRIMARY KEY (`id_dokter`),
  KEY `nama` (`nama`),
  KEY `dokter_to_akses_1` (`creat_by_id`),
  KEY `dokter_to_akses_2` (`update_by_id`),
  CONSTRAINT `dokter_to_akses_1` FOREIGN KEY (`creat_by_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `dokter_to_akses_2` FOREIGN KEY (`update_by_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan referensi data dokter tanpa terikat dengan data akses';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `episode_perawatan`
--

DROP TABLE IF EXISTS `episode_perawatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `episode_perawatan` (
  `id_episode_perawatan` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID Episode Perawatan',
  `kode_episode_perawatan` varchar(255) NOT NULL COMMENT 'Kode Unik Episode Perawatan',
  `IdEpisodeOfCare` varchar(255) DEFAULT NULL COMMENT 'Dari Satusehat',
  `id_pasien` int unsigned NOT NULL COMMENT 'Dari tabel pasien',
  `id_episode_perawatan_kode` int unsigned DEFAULT NULL COMMENT 'dari tabel episode_perawatan_kode',
  `episode_name` varchar(255) NOT NULL COMMENT 'Nama episode',
  `episode_display` varchar(255) NOT NULL COMMENT 'Display episode',
  `episode_code` varchar(255) NOT NULL COMMENT 'Code Episode',
  `episode_system` varchar(255) NOT NULL COMMENT 'System Episode',
  `id_diagnosis` int unsigned DEFAULT NULL COMMENT 'Dari tabel diagnosis',
  `id_dokter` int unsigned DEFAULT NULL COMMENT 'Dati tabel dokter',
  `date_start` date NOT NULL COMMENT 'Periode mulai episode perawatan',
  `date_end` date DEFAULT NULL COMMENT 'Selesai episode perawatan',
  `status` enum('planned','waitlist','active','onhold','finished','cancelled','entered-in-error') NOT NULL COMMENT 'Status Periode Perawatan',
  `creat_by_id` int unsigned DEFAULT NULL COMMENT 'Dari tabel akses (ID)',
  `creat_by_name` varchar(255) NOT NULL COMMENT 'Dari tabel akses (Nama)',
  `creat_at` datetime NOT NULL COMMENT 'Tanggal data dibuat',
  PRIMARY KEY (`id_episode_perawatan`),
  UNIQUE KEY `uq_episode_perawatan_kode` (`kode_episode_perawatan`),
  KEY `episode_perawatan_to_pasien` (`id_pasien`),
  KEY `episode_perawatan_to_kode` (`id_episode_perawatan_kode`),
  KEY `episode_perawatan_to_diagnosis` (`id_diagnosis`),
  KEY `episode_perawatan_to_dokter` (`id_dokter`),
  KEY `episode_perawatan_to_akses` (`creat_by_id`),
  CONSTRAINT `episode_perawatan_to_akses` FOREIGN KEY (`creat_by_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `episode_perawatan_to_diagnosis` FOREIGN KEY (`id_diagnosis`) REFERENCES `diagnosis` (`id_diagnosis`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `episode_perawatan_to_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `episode_perawatan_to_kode` FOREIGN KEY (`id_episode_perawatan_kode`) REFERENCES `episode_perawatan_kode` (`id_episode_perawatan_kode`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `episode_perawatan_to_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Episode Perawatan Kunjungan pasien';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `episode_perawatan_kode`
--

DROP TABLE IF EXISTS `episode_perawatan_kode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `episode_perawatan_kode` (
  `id_episode_perawatan_kode` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID Induk referensi episode perawatan',
  `episode_category` varchar(255) NOT NULL COMMENT 'Kategori episode perawatan (ex: TB)',
  `episode_name` varchar(255) NOT NULL COMMENT 'Nama episode perawatan (istilah lokal, Ex: TB Paru Sensitif Obat)',
  `episode_display` varchar(255) NOT NULL COMMENT 'Nama episode perawatan (istilah standar, Ex: Tuberkulosis Sensitif Obat)',
  `episode_code` varchar(255) NOT NULL COMMENT 'Kode episode berdasarkan referensi',
  `episode_system` varchar(255) NOT NULL COMMENT 'System referensi yang digunakan (ex: http://terminology.kemkes.go.id/CodeSystem/episodeofcare-type)',
  `source` varchar(255) NOT NULL COMMENT 'Sumber data (Ex:Dokumentasi Satusehat)',
  `status` tinyint(1) NOT NULL COMMENT '0:Inactive|1:Active',
  `creat_by_id` int unsigned DEFAULT NULL COMMENT 'ID Akses Pembuat',
  `creat_by_name` varchar(255) NOT NULL COMMENT 'Nama User Pembuat',
  `creat_at` datetime NOT NULL COMMENT 'Datetime Dibuat (UTC)',
  PRIMARY KEY (`id_episode_perawatan_kode`),
  KEY `episode_perawatan_kode_to_akses` (`creat_by_id`),
  CONSTRAINT `episode_perawatan_kode_to_akses` FOREIGN KEY (`creat_by_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Referensi kode episode of care';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `general_consent`
--

DROP TABLE IF EXISTS `general_consent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `general_consent` (
  `id_general_consent` int unsigned NOT NULL AUTO_INCREMENT,
  `id_consent` varchar(255) NOT NULL COMMENT 'SATUSEHAT',
  `id_kunjungan` int unsigned NOT NULL,
  `id_pasien` int unsigned NOT NULL,
  `metode_consent` enum('Manual','Digital') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Manual (Cetak), Digital (Signature)',
  `petugas_edukasi_id` int unsigned DEFAULT NULL COMMENT 'ID Akses Petugas',
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
  KEY `petugas_edukasi_id` (`petugas_edukasi_id`),
  CONSTRAINT `gc_to_akses` FOREIGN KEY (`petugas_edukasi_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `gc_to_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_to_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `icd`
--

DROP TABLE IF EXISTS `icd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `icd` (
  `id_icd` int unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `long_des` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `short_des` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `icd` enum('ICD9','ICD10','ICD11') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_icd`),
  UNIQUE KEY `kode_2` (`kode`),
  KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imunisasi`
--

DROP TABLE IF EXISTS `imunisasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imunisasi` (
  `id_imunisasi` int unsigned NOT NULL AUTO_INCREMENT,
  `id_immunization` varchar(255) DEFAULT NULL COMMENT 'ID Immunization dari SATUSEHAT',
  `id_pasien` int unsigned NOT NULL COMMENT 'Dari tabel pasien',
  `id_kunjungan` int unsigned NOT NULL COMMENT 'Dari tabel kunjungan (Encounter)',
  `id_imunisasi_referensi` int unsigned DEFAULT NULL COMMENT 'Dari tabel imunisasi_referensi',
  `tanggal_pemberian` datetime NOT NULL COMMENT 'Waktu imunisasi diberikan',
  `status_imunisasi` enum('completed','entered-in-error','not-done') NOT NULL DEFAULT 'completed',
  `dosis_ke` int unsigned DEFAULT NULL COMMENT 'Urutan dosis, misal: 1, 2, booster',
  `nomor_batch` varchar(255) DEFAULT NULL COMMENT 'Nomor batch vaksin',
  `produsen_vaksin` varchar(255) DEFAULT NULL COMMENT 'Nama pabrik/produsen vaksin',
  `body_site_nama` varchar(255) DEFAULT NULL COMMENT 'Nama lokal lokasi tubuh',
  `body_site_display` varchar(255) DEFAULT NULL COMMENT 'Nama lokasi tubuh berdasarkan referensi',
  `body_site_code` varchar(255) DEFAULT NULL COMMENT 'Kode lokasi tubuh sesuai referensi',
  `body_site_system` varchar(255) DEFAULT NULL COMMENT 'System referensi yang digunakan',
  `id_praktisi` int unsigned DEFAULT NULL COMMENT 'Dari tabel praktisi (pemberi vaksin)',
  `praktisi_ihs` varchar(255) DEFAULT NULL COMMENT 'ID Practitioner SatuSehat pemberi vaksin',
  `praktisi_nama` varchar(255) NOT NULL COMMENT 'Nama praktisi',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Catatan reaksi atau keterangan tambahan',
  `author_id` int unsigned DEFAULT NULL COMMENT 'ID akses petugas entry',
  `author_name` varchar(255) NOT NULL COMMENT 'Nama petugas entry',
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  PRIMARY KEY (`id_imunisasi`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_imunisasi_referensi` (`id_imunisasi_referensi`),
  KEY `id_praktisi` (`id_praktisi`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `imunisasi_akses` FOREIGN KEY (`author_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `imunisasi_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `imunisasi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `imunisasi_praktisi` FOREIGN KEY (`id_praktisi`) REFERENCES `praktisi` (`id_praktisi`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `imunisasi_to_referensi` FOREIGN KEY (`id_imunisasi_referensi`) REFERENCES `imunisasi_referensi` (`id_imunisasi_referensi`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Menyimpan data transaksi imunisasi pasien';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imunisasi_referensi`
--

DROP TABLE IF EXISTS `imunisasi_referensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imunisasi_referensi` (
  `id_imunisasi_referensi` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_vaksin` varchar(255) NOT NULL COMMENT 'Nama lokal vaksin, misal: BCG, Polio, Hepatitis B',
  `kode_cvx` varchar(50) DEFAULT NULL COMMENT 'Kode CVX standar vaksin CDC/SatuSehat',
  `kode_kemenkes` varchar(50) DEFAULT NULL COMMENT 'Kode referensi Kemenkes jika ada',
  `display_vaksin` varchar(255) DEFAULT NULL COMMENT 'Deskripsi display standar SatuSehat',
  `system_vaksin` text COMMENT 'System URI, misal: http://hl7.org/fhir/sid/cvx',
  `target_penyakit` varchar(255) DEFAULT NULL COMMENT 'Penyakit sasaran, misal: Tuberculosis',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Aktif, 0: Non-aktif',
  `datetime_creat` datetime NOT NULL,
  `author_id` int unsigned DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_imunisasi_referensi`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `imunisasi_ref_akses` FOREIGN KEY (`author_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Master referensi jenis vaksin imunisasi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jadwal_dokter`
--

DROP TABLE IF EXISTS `jadwal_dokter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal_dokter` (
  `id_jadwal` int unsigned NOT NULL AUTO_INCREMENT,
  `id_dokter` int unsigned NOT NULL,
  `id_poliklinik` int unsigned NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_non_jkn` int unsigned DEFAULT NULL,
  `kuota_jkn` int unsigned DEFAULT NULL,
  `time_max` int unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `jadwal_dokter_to_poli` (`id_poliklinik`),
  KEY `id_dokter` (`id_dokter`),
  CONSTRAINT `jadwal_dokter_to_poli` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jadwal_to_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kunjungan`
--

DROP TABLE IF EXISTS `kunjungan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kunjungan` (
  `id_kunjungan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_encounter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_pasien` int unsigned NOT NULL,
  `sep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'SEP BPJS',
  `prioritas` enum('Normal','Urgent','Emergency') NOT NULL,
  `keluhan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Menjelaskan latar belakang kunjungan',
  `jenis_kunjungan` enum('Rajal','Ranap') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Rajal / Ranap',
  `id_dokter` int unsigned DEFAULT NULL COMMENT 'Dari Tabel Dokter (penerima)',
  `kode_dokter` varchar(255) DEFAULT NULL,
  `dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Dokter Penerima',
  `dpjp_id` int unsigned DEFAULT NULL COMMENT 'id_dokter DPJP',
  `dpjp_kode` varchar(255) DEFAULT NULL,
  `dpjp_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'nama dokter DPJP',
  `id_poliklinik` int unsigned DEFAULT NULL COMMENT 'dari Tabel Poliklinik',
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
  `status` enum('Terdaftar','Dilayani','Selesai','Batal','Meninggal') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Status kunjungan',
  `petugas_id` int unsigned DEFAULT NULL COMMENT 'ID Akses Petugas Dari tabel akses',
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
  KEY `dpjp_id` (`dpjp_id`),
  CONSTRAINT `kunjungan_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  CONSTRAINT `kunjungan_dpjp` FOREIGN KEY (`dpjp_id`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  CONSTRAINT `kunjungan_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kunjungan_petugas_id` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `kunjungan_poliklinik` FOREIGN KEY (`id_poliklinik`) REFERENCES `poliklinik` (`id_poliklinik`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=30564 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id_log` int unsigned NOT NULL AUTO_INCREMENT,
  `id_akses` int unsigned DEFAULT NULL COMMENT 'ID akses pengguna yang melakukan aktivitas',
  `datetime_log` datetime NOT NULL COMMENT 'tanggal dan waktu kejadian',
  `nama_petugas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Sesuai Tabel Akses Pada saat kejadian',
  `category_log` varchar(255) NOT NULL COMMENT 'Kategori Log / Nama Fitur',
  `title_log` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'diisi dengan informasi fitur atau nama aktifitas',
  `metadata_log` json DEFAULT NULL COMMENT 'Untuk aktifitas yang melibatkan penghapusan data sensitif',
  PRIMARY KEY (`id_log`),
  KEY `id_akses` (`id_akses`),
  CONSTRAINT `log_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mencatat kejadian penting';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `observation`
--

DROP TABLE IF EXISTS `observation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `observation` (
  `id_observation` int unsigned NOT NULL AUTO_INCREMENT,
  `id_observation_reference` int unsigned NOT NULL COMMENT 'Dari tabel observation_reference',
  `observation_id` varchar(255) DEFAULT NULL COMMENT 'Dari SATUSEHAT',
  `id_pasien` int unsigned NOT NULL COMMENT 'Dari tabel pasien',
  `id_kunjungan` int unsigned NOT NULL COMMENT 'dari tabel kunjungan',
  `id_praktisi` int unsigned DEFAULT NULL COMMENT 'dari tabel praktisi',
  `nama_praktisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama praktisi sesuai tabel praktisi',
  `observation_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nilai hasil observasi',
  `datetime_observation` datetime NOT NULL COMMENT 'Tanggal/Waktu pemeriksaan',
  `datetime_entry` datetime NOT NULL COMMENT 'Tanggal/Waktu entry',
  `petugas_id` int unsigned DEFAULT NULL COMMENT 'dari tabel akses',
  `petugas_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'nama petugas entry sesuai tabel akses',
  PRIMARY KEY (`id_observation`),
  KEY `observation_reference` (`id_observation_reference`),
  KEY `observation_pasien` (`id_pasien`),
  CONSTRAINT `observation_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `observation_reference` FOREIGN KEY (`id_observation_reference`) REFERENCES `observation_reference` (`id_observation_reference`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `observation_reference`
--

DROP TABLE IF EXISTS `observation_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `observation_reference` (
  `id_observation_reference` int unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL COMMENT 'Kategori observasi lokal',
  `category_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode kategori sesuai referensi',
  `category_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Kategori sesuai referensi',
  `category_system` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Referensi kategori yang digunakan',
  `observation_name` varchar(255) NOT NULL COMMENT 'Nama observasi lokal',
  `observation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode observasi sesuai referensi',
  `observation_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama observasi sesuai referensi',
  `observation_system` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'System Referensi yang digunakan',
  `unit_name` varchar(255) NOT NULL COMMENT 'Nama satuan lokal',
  `unit_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode unit satuan sesuai referensi',
  `unit_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'nama unit satuan sesuai referensi',
  `unit_system` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'System referensi satuan yang digunakan ',
  `result_type` enum('Numeric','Decimal','Coded','Text','Boolean') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Tipe data hasil',
  `result_coded` json DEFAULT NULL COMMENT '[{"label":"x","value":"Y"}]',
  PRIMARY KEY (`id_observation_reference`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Referensi observation atau pemeriksaan';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pasien`
--

DROP TABLE IF EXISTS `pasien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasien` (
  `id_pasien` int unsigned NOT NULL AUTO_INCREMENT,
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
  `id_akses` int unsigned DEFAULT NULL COMMENT 'id_akses petugas yang melakukan input',
  `petugas_pendaftaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama petugas yang mendaftarkan',
  `registered_at` datetime NOT NULL COMMENT 'Pertama kali daftar',
  `updated_at` datetime NOT NULL COMMENT 'Terakhir kali update',
  PRIMARY KEY (`id_pasien`),
  KEY `id_akses` (`id_akses`),
  KEY `id_ihs` (`id_ihs`),
  KEY `nik` (`nik`),
  KEY `no_bpjs` (`no_bpjs`),
  CONSTRAINT `pasien_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=56960 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poliklinik`
--

DROP TABLE IF EXISTS `poliklinik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poliklinik` (
  `id_poliklinik` int unsigned NOT NULL AUTO_INCREMENT,
  `poliklinik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_poliklinik`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `praktisi`
--

DROP TABLE IF EXISTS `praktisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `praktisi` (
  `id_praktisi` int unsigned NOT NULL AUTO_INCREMENT,
  `id_practitioner` varchar(255) DEFAULT NULL COMMENT 'SATUSEHAT',
  `tipe_praktisi` enum('Medis','Non Medis') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profesi_praktisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Dokter, Perawat, Bidan, Rekam Medis, IT DLL',
  `nama_praktisi` varchar(255) NOT NULL,
  `nik_praktisi` varchar(255) DEFAULT NULL,
  `kontak_praktisi` varchar(255) DEFAULT NULL,
  `email_praktisi` varchar(255) DEFAULT NULL,
  `id_akses` int unsigned DEFAULT NULL COMMENT 'Jika Punya Akses',
  `id_dokter` int unsigned DEFAULT NULL COMMENT 'Jika Dokter, Ini Wajib Diisi',
  PRIMARY KEY (`id_praktisi`),
  KEY `praktisi_akses` (`id_akses`),
  KEY `praktisi_dokter` (`id_dokter`),
  KEY `profesi_praktisi` (`profesi_praktisi`),
  CONSTRAINT `praktisi_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `praktisi_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data praktisi kesehatan yang terlibat dalam RME';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rencana_perawatan`
--

DROP TABLE IF EXISTS `rencana_perawatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rencana_perawatan` (
  `id_rencana_perawatan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_care_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kunjungan` int unsigned NOT NULL,
  `id_pasien` int unsigned NOT NULL,
  `id_dokter` int unsigned DEFAULT NULL,
  `rencana_perawatan_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rencana_perawatan_description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','active','on-hold','revoked','completed','entered-in-error','unknown') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `intent` enum('proposal','plan','order','option') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'plan',
  `period_start` datetime DEFAULT NULL,
  `period_end` datetime DEFAULT NULL,
  `created_by_id` int unsigned DEFAULT NULL,
  `created_by_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rencana_perawatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rencana_perawatan_category`
--

DROP TABLE IF EXISTS `rencana_perawatan_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rencana_perawatan_category` (
  `id_rencana_perawatan_category` int unsigned NOT NULL AUTO_INCREMENT,
  `id_rencana_perawatan` int unsigned NOT NULL,
  `id_rencana_perawatan_referensi` int unsigned NOT NULL,
  `rencana_perawatan_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rencana_perawatan_display` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rencana_perawatan_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rencana_perawatan_system` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_rencana_perawatan_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Menghubungkan rencana perawatan dengan referensi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rencana_perawatan_referensi`
--

DROP TABLE IF EXISTS `rencana_perawatan_referensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rencana_perawatan_referensi` (
  `id_rencana_perawatan_referensi` int unsigned NOT NULL AUTO_INCREMENT,
  `rencana_perawatan_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama kategori rencana perawatan dalam istilah lokal',
  `rencana_perawatan_display` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama rencana perawatan sesuai referensi standar',
  `rencana_perawatan_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kode referensi sesuai standar',
  `rencana_perawatan_system` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'System yang digunakan',
  `status` tinyint(1) NOT NULL COMMENT '0:Inactive|1:Active',
  `crate_by_id` int unsigned NOT NULL COMMENT 'ID akses pembuat',
  `crate_by_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama pembuat',
  `crate_at` datetime NOT NULL COMMENT 'Tanggal & Jam Dibuat',
  `update_at` datetime NOT NULL COMMENT 'Tanggal & Jam terakhir Di Update',
  PRIMARY KEY (`id_rencana_perawatan_referensi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Menampung referensi category rencana perawatan';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rr_kelas_rawat`
--

DROP TABLE IF EXISTS `rr_kelas_rawat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rr_kelas_rawat` (
  `id_kelas_rawat` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_kelas_rawat`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rr_ruang_rawat`
--

DROP TABLE IF EXISTS `rr_ruang_rawat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rr_ruang_rawat` (
  `id_ruang_rawat` int unsigned NOT NULL AUTO_INCREMENT,
  `id_kelas_rawat` int unsigned NOT NULL,
  `ruang_rawat` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_ruang_rawat`),
  KEY `ruang_to_kelas` (`id_kelas_rawat`),
  CONSTRAINT `ruang_to_kelas` FOREIGN KEY (`id_kelas_rawat`) REFERENCES `rr_kelas_rawat` (`id_kelas_rawat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rr_tempat_tidur`
--

DROP TABLE IF EXISTS `rr_tempat_tidur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rr_tempat_tidur` (
  `id_tempat_tidur` int unsigned NOT NULL AUTO_INCREMENT,
  `id_kelas_rawat` int unsigned NOT NULL,
  `id_ruang_rawat` int unsigned NOT NULL,
  `tempat_tidur` varchar(255) NOT NULL,
  `pria` tinyint(1) NOT NULL,
  `wanita` tinyint(1) NOT NULL,
  `bebas` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_tempat_tidur`),
  KEY `tt_to_kelas` (`id_kelas_rawat`),
  KEY `tt_to_ruang_rawat` (`id_ruang_rawat`),
  CONSTRAINT `tt_to_kelas` FOREIGN KEY (`id_kelas_rawat`) REFERENCES `rr_kelas_rawat` (`id_kelas_rawat`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tt_to_ruang_rawat` FOREIGN KEY (`id_ruang_rawat`) REFERENCES `rr_ruang_rawat` (`id_ruang_rawat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ruang_rawat`
--

DROP TABLE IF EXISTS `ruang_rawat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ruang_rawat` (
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
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting` (
  `id_setting` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_name` enum('Development','Staging','Production') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Lingkungan pengaturan',
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Pengaturan umum aplikasi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_analyza`
--

DROP TABLE IF EXISTS `setting_analyza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_analyza` (
  `id_setting_analyza` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `base_url` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `creat_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_setting_analyza`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_bpjs`
--

DROP TABLE IF EXISTS `setting_bpjs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_bpjs` (
  `id_setting_bpjs` int unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_email_gateway`
--

DROP TABLE IF EXISTS `setting_email_gateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_email_gateway` (
  `id_setting_email_gateway` int unsigned NOT NULL AUTO_INCREMENT,
  `email_gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_provider` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `port_gateway` int NOT NULL,
  `nama_pengirim` varchar(2555) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_service` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1/0',
  PRIMARY KEY (`id_setting_email_gateway`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_google`
--

DROP TABLE IF EXISTS `setting_google`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_google` (
  `id_setting_google` int unsigned NOT NULL AUTO_INCREMENT,
  `credential_env` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `client_id` text NOT NULL,
  `client_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_setting_google`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_radix`
--

DROP TABLE IF EXISTS `setting_radix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_radix` (
  `id_setting_radix` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `base_url` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `creat_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'true or false',
  PRIMARY KEY (`id_setting_radix`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_satusehat`
--

DROP TABLE IF EXISTS `setting_satusehat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_satusehat` (
  `id_setting_satusehat` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_setting_satusehat` varchar(255) NOT NULL,
  `url_satusehat` varchar(255) NOT NULL,
  `organization_id` varchar(255) NOT NULL,
  `default_location_id` varchar(255) DEFAULT NULL,
  `client_key` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `datetime_expired` datetime NOT NULL,
  `status_setting_satusehat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_setting_satusehat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_sifarma`
--

DROP TABLE IF EXISTS `setting_sifarma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_sifarma` (
  `id_setting_sifarma` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `base_url` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `creat_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_setting_sifarma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting_sirs_online`
--

DROP TABLE IF EXISTS `setting_sirs_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_sirs_online` (
  `id_setting_sirs_online` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_setting_sirs_online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url_sirs_online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_rs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_sirs_online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/1',
  PRIMARY KEY (`id_setting_sirs_online`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tindakan`
--

DROP TABLE IF EXISTS `tindakan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tindakan` (
  `id_tindakan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_pasien` int unsigned NOT NULL,
  `id_kunjungan` int unsigned NOT NULL,
  `id_tindakan_referensi` int unsigned DEFAULT NULL,
  `id_procedure` varchar(255) DEFAULT NULL COMMENT 'SATUSEHAT',
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `reson_reference` enum('ICD10','ICD11') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Sumber reson code',
  `reson_code` varchar(255) DEFAULT NULL COMMENT 'Kode ICD10 - Alasan tindakan',
  `reson_display` varchar(255) DEFAULT NULL COMMENT 'Description ICD10 - Alasan tindakan',
  `post_tindakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Keterangan/Catatan kondisi setelah tindakan',
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  `petugas_id` int unsigned DEFAULT NULL,
  `petugas_nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_tindakan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_tindakan_referensi` (`id_tindakan_referensi`),
  KEY `petugas_id` (`petugas_id`),
  CONSTRAINT `tindakan_akses` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  CONSTRAINT `tindakan_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tindakan_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tindakan_to_referensi` FOREIGN KEY (`id_tindakan_referensi`) REFERENCES `tindakan_referensi` (`id_tindakan_referensi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data tindakan yang diberikan kepada pasien';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tindakan_performer`
--

DROP TABLE IF EXISTS `tindakan_performer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tindakan_performer` (
  `id_tindakan_performer` int unsigned NOT NULL AUTO_INCREMENT,
  `id_tindakan` int unsigned NOT NULL COMMENT 'Dari tabel tindakan',
  `id_praktisi` int unsigned DEFAULT NULL COMMENT 'dari tabel praktisi',
  `performer_type` enum('Utama','Pendamping') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `performer_ihs` varchar(255) DEFAULT NULL COMMENT 'ID Practitioner Pelaksana (SATUSEHAT)',
  `performer_nik` varchar(255) DEFAULT NULL COMMENT 'NIK Pelaksana',
  `performer_nama` varchar(255) NOT NULL COMMENT 'Nama lengkap pelaksana',
  `performer_notes` text COMMENT 'Catatan dari performer',
  PRIMARY KEY (`id_tindakan_performer`),
  KEY `id_tindakan` (`id_tindakan`),
  KEY `id_praktisi` (`id_praktisi`),
  CONSTRAINT `performer_praktisi` FOREIGN KEY (`id_praktisi`) REFERENCES `praktisi` (`id_praktisi`) ON DELETE SET NULL,
  CONSTRAINT `performer_tindakan` FOREIGN KEY (`id_tindakan`) REFERENCES `tindakan` (`id_tindakan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Untuk mencatat siapa saja yang terlibat dalam tindakan';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tindakan_referensi`
--

DROP TABLE IF EXISTS `tindakan_referensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tindakan_referensi` (
  `id_tindakan_referensi` int unsigned NOT NULL AUTO_INCREMENT,
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
  `author_id` int unsigned DEFAULT NULL COMMENT 'ID Akses Author',
  `author_name` varchar(255) NOT NULL COMMENT 'Nama Author',
  PRIMARY KEY (`id_tindakan_referensi`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `tindakan_referensi_to_akses` FOREIGN KEY (`author_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mencatat referensi tindakan';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wilayah`
--

DROP TABLE IF EXISTS `wilayah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wilayah` (
  `id_wilayah` int unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=83733 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'elsyifa_core'
--

--
-- Dumping routines for database 'elsyifa_core'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-10  1:19:18

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 14, 2026 at 11:43 AM
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
-- Table structure for table `diagnosis`
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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD CONSTRAINT `diagnosis_akses` FOREIGN KEY (`petugas_id`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL,
  ADD CONSTRAINT `diagnosis_dokter` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL,
  ADD CONSTRAINT `diagnosis_kunjungan` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diagnosis_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

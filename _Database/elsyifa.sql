-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 23, 2026 at 07:11 PM
-- Server version: 9.1.0
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elsyifa`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

DROP TABLE IF EXISTS `akses`;
CREATE TABLE IF NOT EXISTS `akses` (
  `id_akses` int NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(30) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `akses` text NOT NULL,
  `gambar` text,
  `updatetime` varchar(30) NOT NULL,
  PRIMARY KEY (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_acc`
--

DROP TABLE IF EXISTS `akses_acc`;
CREATE TABLE IF NOT EXISTS `akses_acc` (
  `id_akses_acc` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `id_akses_ref` int NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Yes, No',
  PRIMARY KEY (`id_akses_acc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_entitas`
--

DROP TABLE IF EXISTS `akses_entitas`;
CREATE TABLE IF NOT EXISTS `akses_entitas` (
  `id_akses_entitas` int NOT NULL AUTO_INCREMENT,
  `akses` varchar(20) NOT NULL COMMENT 'Nama akses yang ada pada data akses',
  `deskripsi` varchar(50) NOT NULL COMMENT 'Gambaran umum akses',
  `standar_referensi` text NOT NULL COMMENT 'Referensi standar ketika akses dihubungkan pertama kali (json)',
  PRIMARY KEY (`id_akses_entitas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_pengajuan`
--

DROP TABLE IF EXISTS `akses_pengajuan`;
CREATE TABLE IF NOT EXISTS `akses_pengajuan` (
  `id_akses_pengajuan` int NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(30) NOT NULL COMMENT 'tanggal pengajuan',
  `nik` varchar(30) NOT NULL,
  `nama` text NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `alamat` text NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` text NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Pending, Diterima, Ditolak',
  `keterangan` text COMMENT 'keterangan penolakan',
  PRIMARY KEY (`id_akses_pengajuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_ref`
--

DROP TABLE IF EXISTS `akses_ref`;
CREATE TABLE IF NOT EXISTS `akses_ref` (
  `id_akses_ref` int NOT NULL AUTO_INCREMENT,
  `nama_fitur` text NOT NULL,
  `kategori` text NOT NULL,
  `kode` varchar(20) NOT NULL COMMENT 'kode akses fitur',
  `keterangan` text NOT NULL COMMENT 'Penjelasan fitur/halaman',
  PRIMARY KEY (`id_akses_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akun_perkiraan`
--

DROP TABLE IF EXISTS `akun_perkiraan`;
CREATE TABLE IF NOT EXISTS `akun_perkiraan` (
  `id_perkiraan` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(100) NOT NULL,
  `rank` int DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL,
  `saldo_normal` varchar(50) NOT NULL,
  `kd1` varchar(50) DEFAULT NULL,
  `kd2` varchar(50) DEFAULT NULL,
  `kd3` varchar(50) DEFAULT NULL,
  `kd4` varchar(50) DEFAULT NULL,
  `kd5` varchar(50) DEFAULT NULL,
  `kd6` varchar(50) DEFAULT NULL,
  `kd7` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_perkiraan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anamnesis`
--

DROP TABLE IF EXISTS `anamnesis`;
CREATE TABLE IF NOT EXISTS `anamnesis` (
  `id_anamnesis` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i\r\n(Tanggal entry)',
  `nama_pasien` text NOT NULL COMMENT 'JSON\r\n1. Nama\r\n2. No.RM\r\n3. TTL\r\nDLL',
  `nama_petugas` text NOT NULL COMMENT 'JSON\r\n1. Petugas Entry\r\n2. Nakes Pemeriksa\r\n3. Perawat',
  `keluhan_utama` text COMMENT 'Rich Text',
  `riwayat_penyakit` text COMMENT 'JSON\r\n1. sekarang\r\n2. dahulu',
  `riwayat_alergi` text COMMENT 'JSON\r\n1. Kategori\r\n2. Jenis\r\n3. Reaksi',
  `riwayat_pengobatan` text COMMENT 'rich text',
  `habitus_kebiasaan` text COMMENT 'Richtext',
  PRIMARY KEY (`id_anamnesis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

DROP TABLE IF EXISTS `antrian`;
CREATE TABLE IF NOT EXISTS `antrian` (
  `id_antrian` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int DEFAULT NULL,
  `no_antrian` int NOT NULL,
  `kodebooking` varchar(20) NOT NULL,
  `id_pasien` int DEFAULT NULL COMMENT 'Untuk antrian yang bersumber dari JKN mobile memungkinkan pasien belum terdaftar',
  `nama_pasien` text NOT NULL,
  `nomorkartu` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `notelp` varchar(15) DEFAULT NULL,
  `nomorreferensi` varchar(30) DEFAULT NULL COMMENT 'Nomor rujukan, SPRI, kontrol',
  `jenisreferensi` int DEFAULT NULL COMMENT '1.Rujukan FKTP\r\n2.Rujukan Internal\r\n3.Kontrol\r\n4.Rujukan Antar RS',
  `jenisrequest` int DEFAULT NULL COMMENT 'Pasien Baru\r\n0. Tidak\r\n1. Ya',
  `polieksekutif` int DEFAULT NULL COMMENT 'Apakah Polieksekutif?\r\n0. Tidak\r\n1. Ya',
  `tanggal_daftar` varchar(30) DEFAULT NULL COMMENT 'YYYY-mm-dd H:i:s',
  `tanggal_kunjungan` date DEFAULT NULL COMMENT 'YYYY-mm-dd',
  `jam_kunjungan` varchar(25) DEFAULT NULL COMMENT 'H:i-H:i',
  `jam_checkin` varchar(20) DEFAULT NULL COMMENT 'Apabila terisi berarti pasien sudah checkin\r\n(H:i)',
  `kode_dokter` varchar(20) DEFAULT NULL,
  `nama_dokter` text,
  `kodepoli` varchar(20) DEFAULT NULL,
  `namapoli` text,
  `kelas` varchar(50) DEFAULT NULL COMMENT 'Kelas Ruangan',
  `keluhan` text COMMENT 'text bebas untuk mengisi keluhan pasien dari ws',
  `pembayaran` varchar(5) NOT NULL COMMENT 'UMUM, BPJS',
  `no_rujukan` varchar(30) DEFAULT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Terdaftar, Checkin, Batal, Panggil, Tunggu Poli, Layanan Poli, Tunggu Farmasi, Layanan Farmasi, Selesai',
  `sumber_antrian` varchar(20) NOT NULL COMMENT 'Manual, Website, JKN Mobile, Mesin Antrian',
  `ws_bpjs` int DEFAULT NULL COMMENT '0. Tidak\r\n1. Ya',
  PRIMARY KEY (`id_antrian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_log`
--

DROP TABLE IF EXISTS `antrian_log`;
CREATE TABLE IF NOT EXISTS `antrian_log` (
  `id_antrian_log` int NOT NULL AUTO_INCREMENT,
  `id_antrian` int NOT NULL,
  `keterangan` varchar(25) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `waktu` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_antrian_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_task_id`
--

DROP TABLE IF EXISTS `antrian_task_id`;
CREATE TABLE IF NOT EXISTS `antrian_task_id` (
  `taskid` int NOT NULL,
  `taskname` text NOT NULL,
  `kodebooking` varchar(20) NOT NULL,
  `wakturs` varchar(30) NOT NULL,
  `waktu` varchar(30) NOT NULL,
  `keterangan` text COMMENT 'Hanya untuk antrian yang dibatalkan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_access`
--

DROP TABLE IF EXISTS `api_access`;
CREATE TABLE IF NOT EXISTS `api_access` (
  `id_api_access` int NOT NULL AUTO_INCREMENT,
  `api_name` varchar(30) NOT NULL,
  `api_description` text,
  `client_id` varchar(36) NOT NULL,
  `client_key` varchar(36) NOT NULL,
  `token` varchar(36) DEFAULT NULL,
  `expired_duration` int NOT NULL COMMENT 'milisecond',
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  `datetime_expired` datetime DEFAULT NULL,
  PRIMARY KEY (`id_api_access`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_log`
--

DROP TABLE IF EXISTS `api_log`;
CREATE TABLE IF NOT EXISTS `api_log` (
  `id_api_log` int NOT NULL AUTO_INCREMENT,
  `id_api_access` int DEFAULT NULL,
  `datetime_log` datetime NOT NULL,
  `service_name` varchar(20) NOT NULL,
  `response_code` int DEFAULT NULL,
  `response_message` text NOT NULL,
  PRIMARY KEY (`id_api_log`),
  KEY `id_api_access` (`id_api_access`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_token`
--

DROP TABLE IF EXISTS `api_token`;
CREATE TABLE IF NOT EXISTS `api_token` (
  `id_api_token` int NOT NULL AUTO_INCREMENT,
  `id_api_access` int NOT NULL,
  `client_id` char(36) NOT NULL,
  `token` char(36) NOT NULL,
  `datetime_creat` timestamp NOT NULL,
  `datetime_expired` timestamp NOT NULL,
  PRIMARY KEY (`id_api_token`),
  KEY `id_api_access` (`id_api_access`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Untuk menampung API token';

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

DROP TABLE IF EXISTS `approval`;
CREATE TABLE IF NOT EXISTS `approval` (
  `id_approval` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `noKartu` varchar(25) NOT NULL,
  `tglSep` varchar(25) NOT NULL,
  `jnsPelayanan` int DEFAULT NULL,
  `jnsPengajuan` int DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `user` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id_approval`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `arus_kas`
--

DROP TABLE IF EXISTS `arus_kas`;
CREATE TABLE IF NOT EXISTS `arus_kas` (
  `tanggal` varchar(255) DEFAULT NULL,
  `no_bukti` varchar(255) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `nama_akun` varchar(255) DEFAULT NULL,
  `no_akun` varchar(255) DEFAULT NULL,
  `debet` varchar(255) DEFAULT NULL,
  `kredit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bantuan`
--

DROP TABLE IF EXISTS `bantuan`;
CREATE TABLE IF NOT EXISTS `bantuan` (
  `id_bantuan` int NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(30) NOT NULL COMMENT 'tanggal dibuat',
  `judul` text NOT NULL,
  `kategori` text NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Terbit, Draft',
  `isi` text NOT NULL,
  PRIMARY KEY (`id_bantuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billing_pasien`
--

DROP TABLE IF EXISTS `billing_pasien`;
CREATE TABLE IF NOT EXISTS `billing_pasien` (
  `id_billing` int NOT NULL AUTO_INCREMENT,
  `id_pasien` varchar(50) NOT NULL,
  `id_kunjungan` varchar(50) NOT NULL,
  `id_petugas` varchar(50) NOT NULL,
  `id_dokter` varchar(50) NOT NULL,
  `id_tarif` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `qty` varchar(50) NOT NULL,
  `dsc` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id_billing`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billing_rekap`
--

DROP TABLE IF EXISTS `billing_rekap`;
CREATE TABLE IF NOT EXISTS `billing_rekap` (
  `id_rekap` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` varchar(50) NOT NULL,
  `id_pasien` varchar(50) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `jumlah_total` varchar(50) NOT NULL,
  `pembayaran` varchar(50) NOT NULL,
  `selisih` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id_rekap`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bridging`
--

DROP TABLE IF EXISTS `bridging`;
CREATE TABLE IF NOT EXISTS `bridging` (
  `id_bridging` int NOT NULL AUTO_INCREMENT,
  `nama_bridging` varchar(50) NOT NULL,
  `consid` varchar(20) DEFAULT NULL,
  `cons_id_antrol` varchar(20) DEFAULT NULL,
  `user_key` varchar(50) DEFAULT NULL,
  `user_key_antrol` varchar(50) DEFAULT NULL,
  `secret_key` varchar(50) DEFAULT NULL,
  `secret_key_antrol` varchar(50) DEFAULT NULL,
  `kode_ppk` varchar(20) DEFAULT NULL,
  `url_vclaim` text,
  `url_aplicare` text,
  `url_antrol` text,
  `url_faskes` text,
  `url_icare` text,
  `kategori_ppk` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_bridging`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cppt`
--

DROP TABLE IF EXISTS `cppt`;
CREATE TABLE IF NOT EXISTS `cppt` (
  `id_cppt` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `nakes` text NOT NULL COMMENT 'JSON\r\n1.nama\r\n2.kategori\r\n3.kontak\r\n4.identitas\r\n5.no_identitas\r\n6.ttd',
  `dokter` text NOT NULL COMMENT 'JSON\r\n1.nama\r\n2.sip\r\n3.kontak\r\n4.identitas\r\n5.no_identitas\r\n6.ttd',
  `subjective` text,
  `objective` text,
  `assessment` text,
  `plan` text,
  `catatan` text,
  `status` varchar(30) NOT NULL COMMENT 'Pending, Valid',
  PRIMARY KEY (`id_cppt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosa`
--

DROP TABLE IF EXISTS `diagnosa`;
CREATE TABLE IF NOT EXISTS `diagnosa` (
  `id_diagnosa` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(25) NOT NULL,
  `long_des` text NOT NULL,
  `short_des` text NOT NULL,
  `versi` varchar(20) NOT NULL,
  PRIMARY KEY (`id_diagnosa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosarujukankhusus`
--

DROP TABLE IF EXISTS `diagnosarujukankhusus`;
CREATE TABLE IF NOT EXISTS `diagnosarujukankhusus` (
  `id_diagnosa` int NOT NULL AUTO_INCREMENT,
  `rujukan` varchar(25) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_diagnosa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_pasien`
--

DROP TABLE IF EXISTS `diagnosis_pasien`;
CREATE TABLE IF NOT EXISTS `diagnosis_pasien` (
  `id_diagnosis_pasien` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `petugas_entry` text COMMENT 'nama petugas sesuai id_akses',
  `kategori` text NOT NULL COMMENT '1. Diagnosa Awal\r\n2. Diagnosis Kerja\r\n3. Diagnosis Banding\r\n4. Diagnosis Akhir\r\n4.1 Diagnosis Primer\r\n4.2 Diagnosos Sekunder\r\n5. Diagnosis Eksjuvantibus',
  `kode` varchar(20) NOT NULL,
  `diagnosis` text NOT NULL,
  `referensi` varchar(30) NOT NULL COMMENT 'ICD10, ICD9 DLL',
  PRIMARY KEY (`id_diagnosis_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

DROP TABLE IF EXISTS `dokter`;
CREATE TABLE IF NOT EXISTS `dokter` (
  `id_dokter` int NOT NULL AUTO_INCREMENT,
  `id_ihs_practitioner` text COMMENT 'id IHS Satu sehat (Jika ada)',
  `kode` varchar(20) NOT NULL COMMENT 'Kode unik dokter, bisa untuk BPJS',
  `nama` text NOT NULL,
  `kategori` text NOT NULL,
  `kategori_identitas` varchar(20) NOT NULL COMMENT 'KTP, KK, Passport dll',
  `no_identitas` text NOT NULL COMMENT 'Nomor identitas yg dipilih',
  `alamat` text,
  `kontak` varchar(20) DEFAULT NULL COMMENT 'untuk kirim notifikasi',
  `email` text COMMENT 'untuk kirim notifikasi',
  `SIP` text,
  `status` varchar(20) NOT NULL,
  `foto` text,
  PRIMARY KEY (`id_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `edukasi`
--

DROP TABLE IF EXISTS `edukasi`;
CREATE TABLE IF NOT EXISTS `edukasi` (
  `id_edukasi` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `petugas_entry` text NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd HH:ii',
  `tanggal_edukasi` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd HH:ii',
  `kategori_edukasi` text NOT NULL,
  `materi_edukasi` text NOT NULL,
  `pemberi_edukasi` text NOT NULL COMMENT 'JSON\r\n1.nama\r\n2.kontak\r\n3.kategori_identitas\r\n4.no_identitas\r\n5.ttd',
  `penerima_edukasi` text NOT NULL COMMENT 'JSON\r\n1.nama\r\n2.kontak\r\n3.kategori_identitas\r\n4.no_identitas\r\n5.ttd',
  `keterangan_edukasi` text NOT NULL COMMENT 'JSON\r\n1.bahasa\r\n2.penerjemah\r\n3.hambatan\r\n4.durasi',
  `status_edukasi` varchar(20) NOT NULL COMMENT 'Sudah Mengereti, Re Edukasi, Re Demonstrasi',
  PRIMARY KEY (`id_edukasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file_bukti`
--

DROP TABLE IF EXISTS `file_bukti`;
CREATE TABLE IF NOT EXISTS `file_bukti` (
  `id_file` int NOT NULL AUTO_INCREMENT,
  `kode_trans` varchar(50) NOT NULL,
  `nama_file` varchar(100) NOT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `general_consent`
--

DROP TABLE IF EXISTS `general_consent`;
CREATE TABLE IF NOT EXISTS `general_consent` (
  `id_general_consent` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `nama_petugas` text NOT NULL COMMENT 'JSON:\r\n1. Nama\r\n2. NIK\r\n3. Kontak\r\n4. Alamat\r\n5. ttd',
  `penanggung_jawab` text COMMENT 'JSON:\r\n1. Nama\r\n2. NIK\r\n3. Kontak\r\n4. Alamat\r\n5. ttd',
  `tanggal` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `general_consent` text COMMENT 'JSON',
  PRIMARY KEY (`id_general_consent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
--

DROP TABLE IF EXISTS `jadwal_dokter`;
CREATE TABLE IF NOT EXISTS `jadwal_dokter` (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `id_dokter` int NOT NULL,
  `id_poliklinik` int NOT NULL,
  `dokter` varchar(100) NOT NULL,
  `poliklinik` varchar(50) NOT NULL,
  `hari` varchar(25) NOT NULL,
  `jam` varchar(25) NOT NULL,
  `kuota_non_jkn` int DEFAULT NULL,
  `kuota_jkn` int DEFAULT NULL,
  `time_max` int NOT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_operasi`
--

DROP TABLE IF EXISTS `jadwal_operasi`;
CREATE TABLE IF NOT EXISTS `jadwal_operasi` (
  `id_operasi` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `nama` text NOT NULL,
  `nopeserta` varchar(30) NOT NULL,
  `tanggal_daftar` varchar(30) NOT NULL,
  `jam_daftar` varchar(30) NOT NULL,
  `tanggaloperasi` varchar(30) NOT NULL,
  `jamoperasi` varchar(30) NOT NULL,
  `jenistindakan` text NOT NULL,
  `kodepoli` varchar(30) NOT NULL,
  `namapoli` text NOT NULL,
  `keterangan` text NOT NULL,
  `terlaksana` int NOT NULL,
  `kodebooking` varchar(30) NOT NULL,
  `lastupdate` varchar(30) NOT NULL,
  PRIMARY KEY (`id_operasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

DROP TABLE IF EXISTS `jurnal`;
CREATE TABLE IF NOT EXISTS `jurnal` (
  `id_jurnal` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL,
  `tanggal` varchar(20) NOT NULL,
  `kode_perkiraan` varchar(50) NOT NULL,
  `d_k` varchar(50) NOT NULL,
  `nilai` int NOT NULL,
  `updatetime` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jurnal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

DROP TABLE IF EXISTS `konsultasi`;
CREATE TABLE IF NOT EXISTS `konsultasi` (
  `id_konsultasi` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `petugas_entry` text NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd HH:ii',
  `tanggal_permintaan` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd HH:ii',
  `tanggal_jawaban` varchar(30) DEFAULT NULL COMMENT 'YYYY-mm-dd HH:ii',
  `dokter_asal` text NOT NULL COMMENT 'JSON\r\n1.uinit\r\n2.id_dokter\r\n3.nama\r\n4.ttd',
  `dokter_tujuan` text NOT NULL COMMENT 'JSON\r\n1.uinit\r\n2.id_dokter\r\n3.nama\r\n4.ttd',
  `permintaan_konsultasi` text NOT NULL COMMENT 'JSON\r\n1.diagnosa_kerja\r\n2.ikhtisar_klinis\r\n3.konsul_diminta\r\n',
  `jawaban_konsultasi` text COMMENT 'JSON\r\n1.penemuan\r\n2.diagnosa\r\n3.saran',
  `status_konsultasi` varchar(30) NOT NULL COMMENT 'Pending, Konsul Ulang, Konsul Selesai, Konsul Bersama, Alih Rawat',
  PRIMARY KEY (`id_konsultasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_alergi`
--

DROP TABLE IF EXISTS `kunjungan_alergi`;
CREATE TABLE IF NOT EXISTS `kunjungan_alergi` (
  `id_kunjungan_alergi` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_encounter` text NOT NULL COMMENT 'id kunjungan satu sehat',
  `id_allergy` text NOT NULL COMMENT 'id alergi intoleran',
  `raw` text NOT NULL COMMENT 'raw satu sehat',
  `id_akses` int NOT NULL,
  `updatetime` timestamp NOT NULL,
  PRIMARY KEY (`id_kunjungan_alergi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_composition`
--

DROP TABLE IF EXISTS `kunjungan_composition`;
CREATE TABLE IF NOT EXISTS `kunjungan_composition` (
  `id_kunjungan_composition` int NOT NULL AUTO_INCREMENT,
  `uniqIdComposition` varchar(30) NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_composition` text,
  `id_pasien` int NOT NULL,
  `id_ihs_pasien` text,
  `status` varchar(20) NOT NULL,
  `type_code` varchar(30) NOT NULL COMMENT 'dari http://loinc.org',
  `type_display` text NOT NULL COMMENT 'dari http://loinc.org',
  `category_code` varchar(30) NOT NULL COMMENT 'dari http://loinc.org',
  `category_display` text NOT NULL COMMENT 'dari http://loinc.org',
  `tanggal` varchar(30) NOT NULL,
  `id_ihs_practitioner` text NOT NULL,
  `title` text NOT NULL,
  `ID_Org` text NOT NULL,
  `section_code` varchar(30) NOT NULL COMMENT 'dari http://loinc.org',
  `section_display` text NOT NULL COMMENT 'dari http://loinc.org',
  `section_status` varchar(30) NOT NULL COMMENT 'dari http://loinc.org',
  `section_div` text NOT NULL COMMENT 'dari http://loinc.org',
  PRIMARY KEY (`id_kunjungan_composition`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_condition`
--

DROP TABLE IF EXISTS `kunjungan_condition`;
CREATE TABLE IF NOT EXISTS `kunjungan_condition` (
  `id_kunjungan_condition` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_ihs` text NOT NULL,
  `id_encounter` text NOT NULL,
  `id_condition` text NOT NULL,
  `category` text NOT NULL,
  `clinicalStatus` text NOT NULL,
  `code_system` text NOT NULL,
  PRIMARY KEY (`id_kunjungan_condition`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_encounter`
--

DROP TABLE IF EXISTS `kunjungan_encounter`;
CREATE TABLE IF NOT EXISTS `kunjungan_encounter` (
  `id_kunjungan_encounter` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int NOT NULL,
  `id_encounter` text NOT NULL,
  `id_pasien` int NOT NULL,
  `id_ihs` text NOT NULL,
  `resource_name` text NOT NULL,
  `IdSatuSehat` text NOT NULL,
  PRIMARY KEY (`id_kunjungan_encounter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_med_dis`
--

DROP TABLE IF EXISTS `kunjungan_med_dis`;
CREATE TABLE IF NOT EXISTS `kunjungan_med_dis` (
  `id_kunjungan_med_dis` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_resep` int NOT NULL,
  `id_item_resep` text NOT NULL,
  `id_medication_dis` text NOT NULL,
  `raw_med_dis` text NOT NULL,
  `id_akses` int NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_kunjungan_med_dis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_med_req`
--

DROP TABLE IF EXISTS `kunjungan_med_req`;
CREATE TABLE IF NOT EXISTS `kunjungan_med_req` (
  `id_kunjungan_med_req` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_resep` int NOT NULL,
  `id_item_resep` text NOT NULL,
  `id_medication_req` text NOT NULL,
  `raw_med_req` longtext NOT NULL,
  `id_akses` int NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_kunjungan_med_req`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_observation`
--

DROP TABLE IF EXISTS `kunjungan_observation`;
CREATE TABLE IF NOT EXISTS `kunjungan_observation` (
  `id_kunjungan_observation` int NOT NULL AUTO_INCREMENT,
  `id_observation` text NOT NULL,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_ihs` text NOT NULL,
  `id_encounter` text NOT NULL,
  `id_ihs_practitioner` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `observation_code` varchar(20) NOT NULL,
  `observation_display` text NOT NULL,
  `tipe_value` text NOT NULL,
  `raw_value` text NOT NULL,
  `raw_interpertation` text,
  PRIMARY KEY (`id_kunjungan_observation`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_procedure`
--

DROP TABLE IF EXISTS `kunjungan_procedure`;
CREATE TABLE IF NOT EXISTS `kunjungan_procedure` (
  `id_kunjungan_procedure` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int NOT NULL,
  `id_procedure` text NOT NULL,
  `id_ihs` text NOT NULL,
  `id_pasien` int NOT NULL,
  `status` text NOT NULL,
  `category` text NOT NULL,
  `code` text NOT NULL,
  `subject` text NOT NULL,
  `encounter` text NOT NULL,
  `performedPeriod` text NOT NULL,
  `performer` text NOT NULL,
  `reasonCode` text NOT NULL,
  `bodySite` text NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id_kunjungan_procedure`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_utama`
--

DROP TABLE IF EXISTS `kunjungan_utama`;
CREATE TABLE IF NOT EXISTS `kunjungan_utama` (
  `id_kunjungan` int NOT NULL AUTO_INCREMENT,
  `id_encounter` text,
  `id_pasien` int NOT NULL,
  `no_antrian` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `no_bpjs` varchar(20) DEFAULT NULL,
  `sep` varchar(30) DEFAULT NULL,
  `noRujukan` varchar(30) DEFAULT NULL,
  `skdp` varchar(30) DEFAULT NULL,
  `nama` text NOT NULL,
  `tanggal` varchar(20) DEFAULT NULL,
  `propinsi` text,
  `kabupaten` text,
  `kecamatan` text,
  `desa` text,
  `alamat` text,
  `keluhan` text,
  `tujuan` varchar(20) NOT NULL,
  `id_dokter` varchar(20) DEFAULT NULL,
  `dokter` varchar(200) DEFAULT NULL,
  `id_poliklinik` varchar(20) DEFAULT NULL,
  `poliklinik` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `ruangan` varchar(50) DEFAULT NULL,
  `id_kasur` varchar(20) DEFAULT NULL,
  `DiagAwal` text,
  `rujukan_dari` text,
  `rujukan_ke` text,
  `pembayaran` varchar(50) DEFAULT NULL,
  `cara_keluar` varchar(50) DEFAULT NULL,
  `tanggal_keluar` varchar(50) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `id_akses` int DEFAULT NULL,
  `nama_petugas` varchar(255) DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  UNIQUE KEY `id_kunjungan_2` (`id_kunjungan`),
  KEY `id_kunjungan` (`id_kunjungan`),
  KEY `id_pasien` (`id_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium_parameter`
--

DROP TABLE IF EXISTS `laboratorium_parameter`;
CREATE TABLE IF NOT EXISTS `laboratorium_parameter` (
  `id_laboratorium_parameter` int NOT NULL AUTO_INCREMENT,
  `parameter` text NOT NULL,
  `kategori_parameter` text NOT NULL,
  `tipe_data` varchar(20) NOT NULL COMMENT 'Numerik, Text, Datetime',
  `alternatif` text COMMENT 'json data',
  `nilai_rujukan` varchar(25) DEFAULT NULL,
  `nilai_kritis` varchar(25) DEFAULT NULL,
  `satuan` varchar(30) DEFAULT NULL COMMENT 'Satuan Ukur',
  `keterangan` text,
  PRIMARY KEY (`id_laboratorium_parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium_pemeriksaan`
--

DROP TABLE IF EXISTS `laboratorium_pemeriksaan`;
CREATE TABLE IF NOT EXISTS `laboratorium_pemeriksaan` (
  `id_lab` int NOT NULL AUTO_INCREMENT,
  `id_permintaan` int NOT NULL,
  `waktu_pendaftaran` varchar(30) NOT NULL COMMENT 'waktu pendaftaran diterima',
  `pengambilan_sample` varchar(30) DEFAULT NULL COMMENT 'waktu pengambilan sample',
  `pemeriksaan_sample` varchar(30) DEFAULT NULL COMMENT 'waktu pemeriksaan sample',
  `keluar_hasil` varchar(30) DEFAULT NULL COMMENT 'waktu keluar hasil',
  `hasil_diserahkan` varchar(30) DEFAULT NULL COMMENT 'waktu hasil diserahkan',
  `metode_penyerahan` int DEFAULT NULL COMMENT '1.penyerahan langsung\r\n2. Surel',
  `interpertasi_hasil` text COMMENT 'Pembacaan oleh dokter spesialis di\r\nbidang laboratorium yang terkait',
  `dokter_interpertasi` text COMMENT 'Nama Dokter yang\r\nMenginterpretasi Hasil Pemeriksaa',
  `dokter_validator` text COMMENT 'Nama Dokter yang\r\nMemvalidasi/Memverifikasi Hasil Pemeriksaan',
  `petugas_analis` text COMMENT 'Nama Petugas yang Menganalisis Spesimen Klinis 	',
  `sig_dokter_intr` text COMMENT 'TTD dokter interpertasi',
  `sig_dokter_validator` text COMMENT 'TTD dokter Validator',
  `sig_petugas_analis` text COMMENT 'TTD petugas analis',
  PRIMARY KEY (`id_lab`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium_permintaan`
--

DROP TABLE IF EXISTS `laboratorium_permintaan`;
CREATE TABLE IF NOT EXISTS `laboratorium_permintaan` (
  `id_permintaan` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int DEFAULT NULL COMMENT 'Apabila dari kunjungan Ranap/Rajal',
  `id_dokter` int DEFAULT NULL COMMENT 'Apabila Mengetahui nama dokter',
  `tujuan` varchar(20) DEFAULT NULL COMMENT 'Rajal/Ranap',
  `nama_pasien` text,
  `nama_dokter` text,
  `tanggal` varchar(30) NOT NULL,
  `faskes` text,
  `unit` text,
  `prioritas` varchar(20) NOT NULL COMMENT 'CITO, Non Cito',
  `diagnosis` text COMMENT 'diagnosis penyakit, keterangan masalah',
  `keterangan_permintaan` text,
  `nama_signature` text COMMENT 'nama yang mengajukan',
  `signature` text COMMENT 'tanda tangan yang mengajukan',
  `status` varchar(20) NOT NULL COMMENT 'Pending, Diterima, Ditolak, Selesai',
  `keterangan_status` text COMMENT 'Ketika ditolak maka jelaskan alasannya',
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium_rincian`
--

DROP TABLE IF EXISTS `laboratorium_rincian`;
CREATE TABLE IF NOT EXISTS `laboratorium_rincian` (
  `id_rincian_lab` int NOT NULL AUTO_INCREMENT,
  `id_permintaan` int DEFAULT NULL,
  `id_lab` int DEFAULT NULL,
  `id_laboratorium_sample` int DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `id_kunjungan` int DEFAULT NULL,
  `parameter` text NOT NULL,
  `kategori_parameter` text NOT NULL,
  `hasil` text NOT NULL,
  `interpertasi` text,
  `keterangan` text,
  PRIMARY KEY (`id_rincian_lab`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium_sample`
--

DROP TABLE IF EXISTS `laboratorium_sample`;
CREATE TABLE IF NOT EXISTS `laboratorium_sample` (
  `id_laboratorium_sample` int NOT NULL AUTO_INCREMENT,
  `id_lab` int NOT NULL,
  `waktu_pengambilan` varchar(30) DEFAULT NULL COMMENT 'Waktu pengambilan sample YYYY-mm-dd H:i',
  `sumber` text COMMENT 'darah, urine, dll',
  `lokasi_pengambilan` text COMMENT 'Bagian anggota tubuh dimana\r\njaringan diambil',
  `jumlah_sample` text COMMENT 'jumlah slice',
  `volume_sample` text COMMENT 'Jumlah kuantitas spesimen yang\r\nakan diperiksa',
  `metode` text COMMENT 'eksisi, kerokan, operasi,\r\naspirasi/biopsi, dan\r\nlain-lain (free text)',
  `kondisi` text COMMENT 'Kualitas fisik pada saat pengambilan\r\nspesimen/jaringan (warna, bau,\r\nkekeruhan, dst)',
  `waktu_fiksasi` varchar(30) DEFAULT NULL,
  `cairan_fiksasi` text COMMENT 'Nama bahan cairan fiksasi yang\r\ndigunakan untuk fiksasi pada\r\njaringan',
  `volume_fiksasi` text COMMENT 'Jumlah kuantitas dari cairan fiksasi\r\nyang digunakan pada spesimen',
  `petugas_sample` text COMMENT 'Petugas Yang Mengambil sample',
  `petugas_pengantar` text COMMENT 'Petugas yang mengantar sample',
  `petugas_penerima` text COMMENT 'petugas yang menerima sample',
  `status` varchar(20) NOT NULL COMMENT 'Terdaftar, Selesai',
  PRIMARY KEY (`id_laboratorium_sample`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_pengguna`
--

DROP TABLE IF EXISTS `laporan_pengguna`;
CREATE TABLE IF NOT EXISTS `laporan_pengguna` (
  `id_laporan_pengguna` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `nama` text NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `laporan` text NOT NULL,
  `response` text,
  PRIMARY KEY (`id_laporan_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `waktu` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_log` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `id_akses` int NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loinc`
--

DROP TABLE IF EXISTS `loinc`;
CREATE TABLE IF NOT EXISTS `loinc` (
  `loinc_num` varchar(255) NOT NULL,
  `component` varchar(255) DEFAULT NULL,
  `property` varchar(255) DEFAULT NULL,
  `time_aspct` varchar(255) DEFAULT NULL,
  `system` varchar(255) DEFAULT NULL,
  `scale_typ` varchar(255) DEFAULT NULL,
  `method_typ` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`loinc_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `nakes`
--

DROP TABLE IF EXISTS `nakes`;
CREATE TABLE IF NOT EXISTS `nakes` (
  `id_nakes` int NOT NULL AUTO_INCREMENT,
  `ihs` text NOT NULL,
  `nik` varchar(20) NOT NULL,
  `kode` varchar(20) DEFAULT NULL COMMENT 'kode dokter',
  `nama` text NOT NULL,
  `kategori` varchar(25) NOT NULL,
  `referensi_sdm` text NOT NULL,
  `id_akses` int NOT NULL,
  PRIMARY KEY (`id_nakes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nakes_pcr`
--

DROP TABLE IF EXISTS `nakes_pcr`;
CREATE TABLE IF NOT EXISTS `nakes_pcr` (
  `id_nakes_pcr` int NOT NULL AUTO_INCREMENT,
  `id_nakes` int NOT NULL,
  `tanggal` date NOT NULL,
  `nama_nakes` text NOT NULL,
  `kategori_nakes` text NOT NULL COMMENT 'dokter_spesialis, dokter_umum',
  `hasil_pcr` varchar(10) NOT NULL COMMENT 'Positif/Negatif',
  `id_akses` int NOT NULL COMMENT 'id_akses petugas',
  PRIMARY KEY (`id_nakes_pcr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nakes_terinfeksi`
--

DROP TABLE IF EXISTS `nakes_terinfeksi`;
CREATE TABLE IF NOT EXISTS `nakes_terinfeksi` (
  `id_nakes_terinfeksi` int NOT NULL AUTO_INCREMENT,
  `id_nakes` int NOT NULL,
  `id_nakes_pcr` int NOT NULL COMMENT 'wajib diisi',
  `nama` text NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(20) NOT NULL COMMENT 'co_ass, dokter_umum, dll',
  `status` varchar(20) NOT NULL COMMENT 'Isoman, Sembuh, Dirawat, Meninggal',
  `id_akses` int NOT NULL,
  PRIMARY KEY (`id_nakes_terinfeksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `neraca_saldo`
--

DROP TABLE IF EXISTS `neraca_saldo`;
CREATE TABLE IF NOT EXISTS `neraca_saldo` (
  `id_neraca_saldo` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `level` int DEFAULT NULL,
  `akun_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `akun_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tahun_2023` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tahun_2024` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tahun_2025` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kategori` varchar(255) NOT NULL,
  PRIMARY KEY (`id_neraca_saldo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

DROP TABLE IF EXISTS `obat`;
CREATE TABLE IF NOT EXISTS `obat` (
  `id_obat` int NOT NULL AUTO_INCREMENT,
  `id_medication` text COMMENT 'satu sehat',
  `kode` varchar(30) NOT NULL COMMENT 'kode unik obat (barcode)',
  `nama` text NOT NULL COMMENT 'Tidak boleh ilegal string',
  `kelompok` varchar(30) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `isi` int DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `harga` int DEFAULT NULL COMMENT 'harga beli',
  `stok_min` int DEFAULT NULL COMMENT 'untuk memberikan warning',
  `keterangan` text COMMENT 'Keterangan/catatan penting',
  `tanggal` varchar(30) NOT NULL COMMENT 'Tanggal input\r\nYYYY-mm-dd HH:ii:ss',
  `updatetime` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd HH:ii:ss',
  PRIMARY KEY (`id_obat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_expired`
--

DROP TABLE IF EXISTS `obat_expired`;
CREATE TABLE IF NOT EXISTS `obat_expired` (
  `id_obat_expired` int NOT NULL AUTO_INCREMENT,
  `id_obat` int NOT NULL,
  `batch` varchar(30) DEFAULT NULL,
  `nama` text NOT NULL,
  `qty` int NOT NULL,
  `satuan` varchar(30) DEFAULT NULL,
  `expired` date NOT NULL COMMENT 'YYYY-mm-dd',
  `ingatkan` date NOT NULL COMMENT 'YYYY-mm-dd',
  `status` varchar(20) NOT NULL COMMENT 'Terjual, Tersedia',
  PRIMARY KEY (`id_obat_expired`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_harga`
--

DROP TABLE IF EXISTS `obat_harga`;
CREATE TABLE IF NOT EXISTS `obat_harga` (
  `id_obat_harga` int NOT NULL AUTO_INCREMENT,
  `id_obat` int NOT NULL,
  `id_kategori_harga` int NOT NULL,
  `kategori_harga` varchar(30) NOT NULL COMMENT 'nama hara (Ex: eceran, medis) 	',
  `harga` int NOT NULL COMMENT 'RP',
  PRIMARY KEY (`id_obat_harga`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_kategori_harga`
--

DROP TABLE IF EXISTS `obat_kategori_harga`;
CREATE TABLE IF NOT EXISTS `obat_kategori_harga` (
  `id_kategori_harga` int NOT NULL AUTO_INCREMENT,
  `kategori_harga` varchar(30) NOT NULL COMMENT 'nama hara (Ex: eceran, medis)',
  `keterangan` text COMMENT 'Untuk memperjelas harga apa',
  PRIMARY KEY (`id_kategori_harga`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_medication`
--

DROP TABLE IF EXISTS `obat_medication`;
CREATE TABLE IF NOT EXISTS `obat_medication` (
  `id_obat_medication` int NOT NULL AUTO_INCREMENT,
  `id_obat` int NOT NULL,
  `id_medication` text NOT NULL COMMENT 'id medication satu sehat',
  `kode` varchar(30) NOT NULL COMMENT 'kode obat',
  `nama` text NOT NULL COMMENT 'nama obat',
  `raw_medication` text NOT NULL,
  `id_akses` int NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_obat_medication`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_posisi`
--

DROP TABLE IF EXISTS `obat_posisi`;
CREATE TABLE IF NOT EXISTS `obat_posisi` (
  `id_obat_posisi` int NOT NULL AUTO_INCREMENT,
  `id_obat_storage` int NOT NULL,
  `id_obat` int NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama_obat` text NOT NULL,
  `stok` int NOT NULL,
  `updatetime` varchar(30) NOT NULL,
  PRIMARY KEY (`id_obat_posisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_satuan`
--

DROP TABLE IF EXISTS `obat_satuan`;
CREATE TABLE IF NOT EXISTS `obat_satuan` (
  `id_obat_multi` int NOT NULL AUTO_INCREMENT,
  `id_obat` int NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `isi` int NOT NULL,
  `updatetime` varchar(30) NOT NULL,
  PRIMARY KEY (`id_obat_multi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_so`
--

DROP TABLE IF EXISTS `obat_so`;
CREATE TABLE IF NOT EXISTS `obat_so` (
  `id_obat_so` int NOT NULL AUTO_INCREMENT,
  `id_obat_storage` int DEFAULT NULL COMMENT 'apabila kosong maka penyimpanan utama',
  `id_obat` int NOT NULL,
  `tanggal` date NOT NULL COMMENT 'tanggal pelaksanaan SO (YYYY-mm-dd)',
  `nama_penyimpanan` text,
  `kode` varchar(30) NOT NULL,
  `nama` text NOT NULL COMMENT 'nama/merek obat',
  `satuan` varchar(30) NOT NULL COMMENT 'menggunakan satuan utama',
  `harga` int DEFAULT NULL COMMENT 'Harga ketika SO',
  `stok_awal` int DEFAULT NULL COMMENT 'stok yang tercatat',
  `stok_akhir` int DEFAULT NULL COMMENT 'stok yang terhitung saat SO',
  `stok_selisih` int DEFAULT NULL,
  `keterangan` text NOT NULL COMMENT 'Penyebab/alasan dari adanya selisih',
  `updatetime` datetime NOT NULL COMMENT 'YYYY-mm-dd H:i:s',
  PRIMARY KEY (`id_obat_so`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_storage`
--

DROP TABLE IF EXISTS `obat_storage`;
CREATE TABLE IF NOT EXISTS `obat_storage` (
  `id_obat_storage` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL COMMENT 'ID Akses Petugas Input',
  `tanggal` varchar(30) NOT NULL COMMENT 'Tanggal Input',
  `nama_petugas` text NOT NULL COMMENT 'Nama petugas input',
  `nama_penyimpanan` text NOT NULL COMMENT 'Nama Tempat penyimpanan',
  `deskripsi_tempat` text COMMENT 'Gambaran lokasi penyimpanan',
  `updatetime` varchar(30) NOT NULL COMMENT 'Terakhir kali terjadi perubahan',
  PRIMARY KEY (`id_obat_storage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat_transfer_alokasi`
--

DROP TABLE IF EXISTS `obat_transfer_alokasi`;
CREATE TABLE IF NOT EXISTS `obat_transfer_alokasi` (
  `id_obat_transfer_alokasi` int NOT NULL AUTO_INCREMENT,
  `id_obat` int NOT NULL,
  `id_akses` int NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` text NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `storage_from` int DEFAULT NULL COMMENT 'id_obat_storage asal',
  `storage_to` int DEFAULT NULL COMMENT 'id_obat_storage tujuan',
  `qty` int NOT NULL,
  `nama_petugas` text NOT NULL,
  PRIMARY KEY (`id_obat_transfer_alokasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operasi`
--

DROP TABLE IF EXISTS `operasi`;
CREATE TABLE IF NOT EXISTS `operasi` (
  `id_operasi` int NOT NULL AUTO_INCREMENT,
  `id_jadwal_operasi` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `tanggal_mulai` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `tanggal_selesai` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `petugas_entry` text NOT NULL,
  `pelaksana` mediumtext COMMENT 'JSON\r\n1.kategori\r\n2.nama\r\n3.sip\r\n4.kontak\r\n5.kategori_identitas\r\n6.nomor_identitas\r\n7.ttd',
  `diagnosa_operasi` text COMMENT 'JSON\r\n1.kategori\r\n2.kode\r\n3.deskripsi',
  `body_site` text COMMENT 'JSON\r\n1.body_site\r\n2.keterangan',
  `tindakan_operasi` text COMMENT 'JSON\r\n1.kode\r\n2.deskripsi',
  `instrumen` text COMMENT 'JSON\r\n1.instrumen',
  `keterangan_dokter` text COMMENT 'JSON\r\n1.dokter\r\n2.catatan',
  `anastesi` text COMMENT 'JSON\r\n1.durasi\r\n2.diagnosis_kerja\r\n3.diagnosis_banding\r\n4.tindakan\r\n5.tata_cara\r\n6.tujuan\r\n7.resiko\r\n8.komplikasi\r\n9.prognosis\r\n10.alternatif\r\n11.lain-lain',
  `persetujuan` text COMMENT 'JSON\r\n1.hubungan\r\n2.nama\r\n3.kontak\r\n4.kategori_identitas\r\n5.nomor_identitas\r\n6.ttd',
  PRIMARY KEY (`id_operasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `pasien_shk`
--

DROP TABLE IF EXISTS `pasien_shk`;
CREATE TABLE IF NOT EXISTS `pasien_shk` (
  `id_pasien_shk` int NOT NULL AUTO_INCREMENT,
  `id_shk` varchar(20) DEFAULT NULL COMMENT 'dari SIRS online',
  `id_pasien_ibu` int DEFAULT NULL COMMENT 'no rm ibu',
  `nik_ibu` varchar(20) NOT NULL,
  `nama_ibu` text,
  `id_pasien_anak` int DEFAULT NULL,
  `nik_anak` varchar(20) DEFAULT NULL,
  `nama_anak` text,
  `tgllahir` date DEFAULT NULL,
  `gender_anak` varchar(20) DEFAULT NULL,
  `alamat` text,
  `provinsi` varchar(20) DEFAULT NULL,
  `kabkota` varchar(20) DEFAULT NULL,
  `kecamatan` varchar(20) DEFAULT NULL,
  `tgl_ambil_sampel` date DEFAULT NULL,
  `tgl_kirim_sampel` date DEFAULT NULL,
  `tgl_lapor` date DEFAULT NULL,
  `kode_perujuk` varchar(20) DEFAULT NULL,
  `nama_fayankes_perujuk` text,
  `jenis_fasyankes` varchar(20) DEFAULT NULL,
  `id_akses` varchar(30) DEFAULT NULL COMMENT 'akses petugas',
  PRIMARY KEY (`id_pasien_shk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pcr_nakes`
--

DROP TABLE IF EXISTS `pcr_nakes`;
CREATE TABLE IF NOT EXISTS `pcr_nakes` (
  `id_pcr_nakes` int NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(30) NOT NULL,
  `tanggal_laporan` varchar(30) NOT NULL,
  `jumlah` int NOT NULL,
  `raw_json` text NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Syn/None',
  `id_akses` int NOT NULL,
  PRIMARY KEY (`id_pcr_nakes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_fisik`
--

DROP TABLE IF EXISTS `pemeriksaan_fisik`;
CREATE TABLE IF NOT EXISTS `pemeriksaan_fisik` (
  `id_pemeriksaan_fisik` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `nama_petugas` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'Waktu saat data di entry\r\nYYYY-mm-dd',
  `tanggal_pemeriksaan` varchar(30) NOT NULL COMMENT 'Waktu ketika dilakukan pemeriksaan\r\nYYYY-mm-dd\r\nYYYY-mm-dd',
  `gambar_anatomi` longtext COMMENT 'dokter curat-coret',
  `pemeriksaan_fisik` text COMMENT 'JSON\r\n1. Kepala\r\n2. Leher\r\n3. Thorax\r\n4.Abdomen\r\n5. Extremitas\r\n6.Genitourinaria',
  `tanda_vital` text COMMENT 'json\r\n1.Value\r\n2. Type Data\r\n3.Type Form\r\n4. Unit\r\n5. Interpertasi',
  PRIMARY KEY (`id_pemeriksaan_fisik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perencanaan_pasien`
--

DROP TABLE IF EXISTS `perencanaan_pasien`;
CREATE TABLE IF NOT EXISTS `perencanaan_pasien` (
  `id_perencanaan_pasien` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL,
  `kategori_perencanaan` text NOT NULL,
  `perencanaan` text NOT NULL,
  PRIMARY KEY (`id_perencanaan_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `persediaan`
--

DROP TABLE IF EXISTS `persediaan`;
CREATE TABLE IF NOT EXISTS `persediaan` (
  `id_persediaan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `group_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_persediaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_tahunan`
--

DROP TABLE IF EXISTS `persediaan_tahunan`;
CREATE TABLE IF NOT EXISTS `persediaan_tahunan` (
  `id_persediaan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` int DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `harga` int DEFAULT NULL,
  PRIMARY KEY (`id_persediaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persetujuan_tindakan`
--

DROP TABLE IF EXISTS `persetujuan_tindakan`;
CREATE TABLE IF NOT EXISTS `persetujuan_tindakan` (
  `id_persetujuan_tindakan` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `nama_petugas` text NOT NULL,
  `dokter` mediumtext COMMENT 'JSON',
  `pemberi_pernyataan` mediumtext NOT NULL COMMENT 'JSON',
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `tanggal_penjelasan` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `persetujuan` varchar(20) NOT NULL COMMENT 'Ya/Tidak',
  `tindakan` text NOT NULL COMMENT 'JSON List tindakan',
  `konsekuensi` text COMMENT 'Free Text',
  `saksi` mediumtext COMMENT 'JSON',
  PRIMARY KEY (`id_persetujuan_tindakan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poliklinik`
--

DROP TABLE IF EXISTS `poliklinik`;
CREATE TABLE IF NOT EXISTS `poliklinik` (
  `id_poliklinik` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `koordinator` varchar(50) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `updatetime` varchar(20) NOT NULL,
  PRIMARY KEY (`id_poliklinik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `psikosos`
--

DROP TABLE IF EXISTS `psikosos`;
CREATE TABLE IF NOT EXISTS `psikosos` (
  `id_psikosos` int NOT NULL AUTO_INCREMENT,
  `id_kunjungan` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL,
  `tanggal_wawancara` varchar(30) NOT NULL,
  `nama_petugas` text NOT NULL COMMENT 'JSON\r\n1. Petugas Entry\r\n2. Penanya\r\n3. Object',
  `psikologi` text NOT NULL COMMENT 'JSON\r\n1. Status prsikologis\r\n2. Keterangan',
  `sosial` text NOT NULL COMMENT 'JSON\r\n1. Pendidikan\r\n2. Penghasilan\r\n3. Pekerjaan\r\n4. Tempat Kerja\r\n5. Suku Bangsa\r\n6. Bahasa',
  `spiritual` text NOT NULL COMMENT 'JSON\r\n1. Agama\r\n2. Nilai ',
  PRIMARY KEY (`id_psikosos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radiologi`
--

DROP TABLE IF EXISTS `radiologi`;
CREATE TABLE IF NOT EXISTS `radiologi` (
  `id_rad` int NOT NULL AUTO_INCREMENT,
  `id_pasien` varchar(50) NOT NULL,
  `id_kunjungan` varchar(50) NOT NULL,
  `id_akses` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `asal_kiriman` varchar(50) NOT NULL,
  `permintaan_pemeriksaan` text NOT NULL,
  `alat_pemeriksa` varchar(100) NOT NULL,
  `status_pemeriksaan` varchar(100) NOT NULL,
  `jenis_pembayaran` varchar(50) NOT NULL,
  `dokter_pengirim` varchar(100) NOT NULL,
  `dokter_penerima` varchar(100) NOT NULL,
  `radiografer` varchar(100) DEFAULT NULL,
  `kesan` text,
  `klinis` text,
  `selesai` varchar(30) DEFAULT NULL,
  `kv` varchar(20) DEFAULT NULL,
  `ma` varchar(20) DEFAULT NULL,
  `sec` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_rad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radiologi_file`
--

DROP TABLE IF EXISTS `radiologi_file`;
CREATE TABLE IF NOT EXISTS `radiologi_file` (
  `id_radiologi_file` int NOT NULL AUTO_INCREMENT,
  `id_rad` int NOT NULL,
  `id_akses` int NOT NULL COMMENT 'Internal, Eksternal',
  `tanggal` varchar(30) NOT NULL,
  `internal_eksternal` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `deskripsi` text,
  `filesize` int DEFAULT NULL COMMENT 'byte',
  `url_file` text COMMENT 'jika dari eksternal',
  `filename` text COMMENT 'jika dari internal',
  PRIMARY KEY (`id_radiologi_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radiologi_rincian`
--

DROP TABLE IF EXISTS `radiologi_rincian`;
CREATE TABLE IF NOT EXISTS `radiologi_rincian` (
  `id_rincian` int NOT NULL AUTO_INCREMENT,
  `id_rad` int NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `pemeriksaan` text NOT NULL,
  `hasil` text NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_rincian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radiologi_sig`
--

DROP TABLE IF EXISTS `radiologi_sig`;
CREATE TABLE IF NOT EXISTS `radiologi_sig` (
  `id_radiologi_sig` int NOT NULL AUTO_INCREMENT,
  `id_rad` int NOT NULL,
  `id_askes` int NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `nama` text NOT NULL,
  `kategori` varchar(30) NOT NULL COMMENT 'Radiografer, Dokter Spesialis',
  `signature` text NOT NULL COMMENT 'base64',
  PRIMARY KEY (`id_radiologi_sig`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referensi_alergi`
--

DROP TABLE IF EXISTS `referensi_alergi`;
CREATE TABLE IF NOT EXISTS `referensi_alergi` (
  `id_referensi_alergi` int NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `display` text NOT NULL,
  `sumber` text NOT NULL,
  PRIMARY KEY (`id_referensi_alergi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referensi_location`
--

DROP TABLE IF EXISTS `referensi_location`;
CREATE TABLE IF NOT EXISTS `referensi_location` (
  `id_referensi_location` int NOT NULL AUTO_INCREMENT,
  `id_location` text,
  `nama` text NOT NULL,
  `kode` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` text,
  `url` text,
  `address_use` varchar(20) NOT NULL,
  `address_line` text,
  `address_city` text,
  `address_postalCode` varchar(20) DEFAULT NULL,
  `physicalType_code` varchar(20) NOT NULL,
  `physicalType_display` varchar(20) NOT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `altitude` varchar(30) DEFAULT NULL,
  `managingOrganization` text,
  PRIMARY KEY (`id_referensi_location`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referensi_organisasi`
--

DROP TABLE IF EXISTS `referensi_organisasi`;
CREATE TABLE IF NOT EXISTS `referensi_organisasi` (
  `id_referensi_organisasi` int NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `identifier` varchar(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `part_of_ID` text,
  `ID_Org` text,
  PRIMARY KEY (`id_referensi_organisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referensi_practitioner`
--

DROP TABLE IF EXISTS `referensi_practitioner`;
CREATE TABLE IF NOT EXISTS `referensi_practitioner` (
  `id_practitioner` int NOT NULL AUTO_INCREMENT,
  `id_ihs_practitioner` text NOT NULL,
  `kategori` text NOT NULL,
  `nik` varchar(20) DEFAULT NULL COMMENT 'NIK maksimal 20 karakter',
  `nama` text NOT NULL,
  `gender` varchar(20) NOT NULL COMMENT 'male, female',
  `tanggal_lahir` varchar(30) DEFAULT NULL,
  `kontak` varchar(30) DEFAULT NULL,
  `email` text,
  `status` varchar(20) NOT NULL COMMENT 'Aktif, Tidak Aktif',
  PRIMARY KEY (`id_practitioner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rencana_kontrol`
--

DROP TABLE IF EXISTS `rencana_kontrol`;
CREATE TABLE IF NOT EXISTS `rencana_kontrol` (
  `id_rencana_kontrol` int NOT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `noSuratKontrol` varchar(40) DEFAULT NULL,
  `noSPRI` varchar(40) DEFAULT NULL,
  `noSEP` varchar(25) DEFAULT NULL,
  `kodeDokter` varchar(20) DEFAULT NULL,
  `namaDokter` varchar(50) DEFAULT NULL,
  `noKartu` varchar(25) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kelamin` varchar(20) DEFAULT NULL,
  `tglLahir` varchar(20) DEFAULT NULL,
  `poliKontrol` varchar(20) DEFAULT NULL,
  `tglRencanaKontrol` varchar(20) DEFAULT NULL,
  `user` varchar(30) DEFAULT NULL,
  `namaDiagnosa` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

DROP TABLE IF EXISTS `resep`;
CREATE TABLE IF NOT EXISTS `resep` (
  `id_resep` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `id_dokter` int NOT NULL,
  `nama_pasien` text NOT NULL COMMENT 'JSON\r\nnama, berat, tinggi, lebar',
  `petugas_entry` text NOT NULL,
  `nama_dokter` text NOT NULL,
  `ttd_dokter` text,
  `kontak_dokter` text COMMENT 'JSON\r\n1.Kategori\r\n2.Nomor',
  `tanggal_entry` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `tanggal_resep` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i',
  `obat` text COMMENT 'JSON',
  `catatan` text,
  `status` varchar(30) NOT NULL COMMENT 'Pending/Diberikan',
  `pengkajian` text COMMENT 'JSON',
  PRIMARY KEY (`id_resep`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

DROP TABLE IF EXISTS `resume`;
CREATE TABLE IF NOT EXISTS `resume` (
  `id_resume` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL,
  `tanggal_pulang` varchar(30) NOT NULL,
  `petugas` text NOT NULL COMMENT 'JSON\r\n1.nama\r\n2.kategori\r\n3.kontak\r\n4.kategori_identitas\r\n5.no_identitas\r\n6.ttd',
  `dokter` text NOT NULL COMMENT 'JSON\r\n1.nama\r\n2.SIP\r\n3.kontak\r\n4.kategori_identitas\r\n5.no_identitas\r\n6.ttd',
  `resume` varchar(30) DEFAULT NULL COMMENT '1.Atas Persetujuan Dokter\r\n2.Dirujuk\r\n3.Atas Permintaan Sendiri\r\n4.Meninggal\r\n5.Lain-lain',
  `pasca_pulang` varchar(30) DEFAULT NULL COMMENT '1.Sembuh\r\n2.Belum Sembuh\r\n3.Meninggal',
  `nasehat` text,
  `evaluasi` text,
  `terapi_pulang` text COMMENT 'Rich Text Dari Resep/Tindakan',
  `rencana_kontrol` text NOT NULL COMMENT 'JSON\r\n1.no_surat\r\n2.tanggal\r\n3.nama_poli\r\n4.nama_dokter',
  `meninggal` text NOT NULL COMMENT 'Apabila pasien meninggal',
  `pengaturan_lampiran` text NOT NULL COMMENT 'JSON\r\n1.diagnosa\r\n2.operasi\r\n3.pemeriksaan_fisik\r\n4.tanda_vital\r\n5.riwayat_tindakan\r\n6.riwayat_obat\r\n7.laboratorium\r\n8.radiologi\r\n9.konsultasi',
  PRIMARY KEY (`id_resume`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_penggunaan_obat`
--

DROP TABLE IF EXISTS `riwayat_penggunaan_obat`;
CREATE TABLE IF NOT EXISTS `riwayat_penggunaan_obat` (
  `id_riwayat_penggunaan_obat` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal_entry` varchar(30) NOT NULL,
  `id_obat` int DEFAULT NULL COMMENT 'Hanya apabila obat berasal dari database',
  `nama_obat` text NOT NULL COMMENT 'JSON\r\n1. Nama Obat\r\n2. Sediaan\r\n3. Dosis\r\n4. Aturan Pakai\r\n5. Waktu Penggunaan',
  `waktu_penggunaan` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i T\r\nWaktu penggunaan dalam keterangan waktu',
  PRIMARY KEY (`id_riwayat_penggunaan_obat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ruang_rawat`
--

DROP TABLE IF EXISTS `ruang_rawat`;
CREATE TABLE IF NOT EXISTS `ruang_rawat` (
  `id_ruang_rawat` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(25) NOT NULL,
  `kodekelas` varchar(20) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `ruangan` varchar(50) NOT NULL,
  `bed` varchar(25) NOT NULL,
  `pria` varchar(20) NOT NULL,
  `wanita` varchar(20) NOT NULL,
  `bebas` varchar(20) NOT NULL,
  `tarif` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_ruang_rawat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ruang_rawat_sirs`
--

DROP TABLE IF EXISTS `ruang_rawat_sirs`;
CREATE TABLE IF NOT EXISTS `ruang_rawat_sirs` (
  `id_ruang_rawat_sirs` int NOT NULL AUTO_INCREMENT,
  `id_ruang_rawat` int DEFAULT NULL,
  `id_tt` int NOT NULL COMMENT 'id_tt dari sirs online',
  `tt` text NOT NULL COMMENT 'nama tempat tidur di SIRS online',
  PRIMARY KEY (`id_ruang_rawat_sirs`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rujukan`
--

DROP TABLE IF EXISTS `rujukan`;
CREATE TABLE IF NOT EXISTS `rujukan` (
  `id_rujukan` int NOT NULL AUTO_INCREMENT,
  `id_pasien` varchar(25) DEFAULT NULL,
  `id_kunjungan` varchar(25) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `nik` varchar(25) DEFAULT NULL,
  `no_bpjs` varchar(25) DEFAULT NULL,
  `noSep` varchar(25) DEFAULT NULL,
  `noRujukan` varchar(25) DEFAULT NULL,
  `tglRujukan` varchar(25) DEFAULT NULL,
  `tglRencanaKunjungan` varchar(25) DEFAULT NULL,
  `ppkDirujuk` varchar(25) DEFAULT NULL,
  `jnsPelayanan` varchar(25) DEFAULT NULL,
  `catatan` text,
  `diagRujukan` varchar(25) DEFAULT NULL,
  `tipeRujukan` varchar(25) DEFAULT NULL,
  `poliRujukan` varchar(25) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rujukan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `screening`
--

DROP TABLE IF EXISTS `screening`;
CREATE TABLE IF NOT EXISTS `screening` (
  `id_screening` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `nama_petugas` text NOT NULL COMMENT 'JSON\r\n1. Petugas Entry\r\n2. Pemeriksa\r\n3. Dokter',
  `tanggal_entry` varchar(30) NOT NULL,
  `tanggal_periksa` varchar(30) NOT NULL,
  `decubitus` text NOT NULL COMMENT 'JSON',
  `batuk` text NOT NULL COMMENT 'JSON',
  `gizi` text NOT NULL COMMENT 'JSON',
  PRIMARY KEY (`id_screening`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id_personalisasi` int NOT NULL AUTO_INCREMENT,
  `judul_tab` varchar(100) NOT NULL,
  `judul_halaman` varchar(100) NOT NULL,
  `warna` varchar(100) NOT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `jenis_font` varchar(25) DEFAULT NULL,
  `warna_font` varchar(25) DEFAULT NULL,
  `ukuran_font` int DEFAULT NULL,
  `panjang_x` int DEFAULT NULL,
  `lebar_y` int DEFAULT NULL,
  PRIMARY KEY (`id_personalisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_a`
--

DROP TABLE IF EXISTS `setting_a`;
CREATE TABLE IF NOT EXISTS `setting_a` (
  `id_setting_a` int NOT NULL AUTO_INCREMENT,
  `akses` varchar(50) NOT NULL,
  `bantuan` varchar(20) DEFAULT NULL,
  `aksesibilitas` varchar(20) DEFAULT NULL,
  `SettingProfile` varchar(20) DEFAULT NULL,
  `Personalisasi` varchar(20) DEFAULT NULL,
  `SettingBridging` varchar(20) DEFAULT NULL,
  `LogAktivitas` varchar(20) DEFAULT NULL,
  `RefPoli` varchar(20) DEFAULT NULL,
  `RefDokter` varchar(20) DEFAULT NULL,
  `JadwalPraktek` varchar(20) DEFAULT NULL,
  `Wilayah` varchar(20) DEFAULT NULL,
  `KelasRuangan` varchar(20) DEFAULT NULL,
  `MasterPasien` varchar(20) DEFAULT NULL,
  `Kunjungan` varchar(20) DEFAULT NULL,
  `Rujukan` varchar(20) DEFAULT NULL,
  `SpriSkdp` varchar(20) DEFAULT NULL,
  `FingerPrint` varchar(20) DEFAULT NULL,
  `Monitoring` varchar(20) DEFAULT NULL,
  `Antrian` varchar(20) DEFAULT NULL,
  `JadwalOperasi` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_setting_a`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `setting_b`
--

DROP TABLE IF EXISTS `setting_b`;
CREATE TABLE IF NOT EXISTS `setting_b` (
  `id_setting_b` int NOT NULL AUTO_INCREMENT,
  `akses` varchar(50) NOT NULL,
  `DIG` varchar(50) DEFAULT NULL,
  `PG` varchar(50) DEFAULT NULL,
  `DIS` varchar(50) DEFAULT NULL,
  `SA` varchar(50) DEFAULT NULL,
  `PNB` varchar(50) DEFAULT NULL,
  `DA` varchar(50) DEFAULT NULL,
  `DK` varchar(50) DEFAULT NULL,
  `WK` varchar(50) DEFAULT NULL,
  `SK` varchar(50) DEFAULT NULL,
  `DP` varchar(50) DEFAULT NULL,
  `JP` varchar(50) DEFAULT NULL,
  `BP` varchar(50) DEFAULT NULL,
  `SM` varchar(50) DEFAULT NULL,
  `AP` varchar(50) DEFAULT NULL,
  `BYP` varchar(50) DEFAULT NULL,
  `BT` varchar(50) DEFAULT NULL,
  `TGH` varchar(50) DEFAULT NULL,
  `TSS` varchar(50) DEFAULT NULL,
  `JRK` varchar(50) DEFAULT NULL,
  `BKB` varchar(50) DEFAULT NULL,
  `NRS` varchar(50) DEFAULT NULL,
  `DTI` varchar(50) DEFAULT NULL,
  `KLMS` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_setting_b`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_cetak_kartu`
--

DROP TABLE IF EXISTS `setting_cetak_kartu`;
CREATE TABLE IF NOT EXISTS `setting_cetak_kartu` (
  `id_setting_cetak` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `tanggal_setting` varchar(30) NOT NULL,
  `nama_font` text NOT NULL,
  `ukuran_font` varchar(20) NOT NULL,
  `warna_font` varchar(20) NOT NULL,
  `panjang_x` varchar(20) NOT NULL,
  `lebar_y` varchar(20) NOT NULL,
  `margin_atas` varchar(20) NOT NULL,
  `margin_bawah` varchar(20) NOT NULL,
  `margin_kiri` varchar(20) NOT NULL,
  `margin_kanan` varchar(20) NOT NULL,
  `tampilkan_logo` varchar(10) NOT NULL,
  `panjang_logo` varchar(20) DEFAULT NULL,
  `lebar_logo` varchar(20) DEFAULT NULL,
  `tampilkan_barcode` varchar(10) NOT NULL,
  `ukuran_barcode` varchar(20) NOT NULL,
  `tampilkan_foto` varchar(10) NOT NULL,
  `panjang_foto` varchar(20) DEFAULT NULL,
  `lebar_foto` varchar(20) DEFAULT NULL,
  `kutipan_bawah` varchar(20) NOT NULL,
  `isi_kutipan` text,
  PRIMARY KEY (`id_setting_cetak`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_cetak_label`
--

DROP TABLE IF EXISTS `setting_cetak_label`;
CREATE TABLE IF NOT EXISTS `setting_cetak_label` (
  `id_setting_cetak_label` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `tanggal_setting` varchar(20) NOT NULL,
  `nama_font` text,
  `ukuran_font` varchar(20) DEFAULT NULL,
  `warna_font` varchar(20) DEFAULT NULL,
  `satuan` varchar(15) NOT NULL,
  `panjang_x` varchar(20) DEFAULT NULL,
  `lebar_y` varchar(20) DEFAULT NULL,
  `margin_atas` varchar(20) DEFAULT NULL,
  `margin_bawah` varchar(20) DEFAULT NULL,
  `margin_kiri` varchar(20) DEFAULT NULL,
  `margin_kanan` varchar(20) DEFAULT NULL,
  `tampilkan_kode_obat` varchar(10) DEFAULT NULL,
  `tampilkan_nama_obat` varchar(10) DEFAULT NULL,
  `tampilkan_harga_obat` varchar(10) DEFAULT NULL,
  `ukuran_barcode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_setting_cetak_label`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_dinamis`
--

DROP TABLE IF EXISTS `setting_dinamis`;
CREATE TABLE IF NOT EXISTS `setting_dinamis` (
  `id_setting_dinamis` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `nama_fitur` text COMMENT 'Untuk membedakan fungsi setting antar fitur (ex: lab, Rad dll)',
  `nama_setting` text COMMENT 'nama setting yang berlaku',
  `value_setting` text COMMENT 'isi atau nilai dari nama setting',
  PRIMARY KEY (`id_setting_dinamis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_email_gateway`
--

DROP TABLE IF EXISTS `setting_email_gateway`;
CREATE TABLE IF NOT EXISTS `setting_email_gateway` (
  `id_setting_email_gateway` int NOT NULL AUTO_INCREMENT,
  `email_gateway` text NOT NULL,
  `password_gateway` text NOT NULL,
  `url_provider` text NOT NULL,
  `port_gateway` int NOT NULL,
  `nama_pengirim` text NOT NULL,
  `url_service` text NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Active, Non-Active',
  PRIMARY KEY (`id_setting_email_gateway`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_profile`
--

DROP TABLE IF EXISTS `setting_profile`;
CREATE TABLE IF NOT EXISTS `setting_profile` (
  `id_profile` int NOT NULL AUTO_INCREMENT,
  `kode_faskes` varchar(20) NOT NULL,
  `nama_faskes` varchar(50) NOT NULL,
  `alamat_faskes` text NOT NULL,
  `kontak_faskes` varchar(20) NOT NULL,
  `email_faskes` text NOT NULL,
  `link_website` text,
  `base_url` text NOT NULL,
  `tahun_berdiri` int NOT NULL,
  `direktur_faskes` text NOT NULL,
  `visi_faskes` text NOT NULL,
  `misi_faskes` text NOT NULL,
  `judul_tab` varchar(20) NOT NULL COMMENT 'Ditampilkan pada tab aplikasi/browser',
  `judul_halaman` varchar(20) NOT NULL COMMENT 'Ditampilkan pada judul aplikasi',
  `warna` varchar(20) NOT NULL COMMENT 'warna header',
  `favicon` text NOT NULL,
  `logo` text NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Active, Non-Active',
  PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `id_setting_satusehat` int NOT NULL AUTO_INCREMENT,
  `nama_setting` text NOT NULL,
  `oauth_baseurl` text NOT NULL,
  `baseurl` text NOT NULL,
  `consent_url` text NOT NULL,
  `kfa_url` text,
  `masterdata_url` text NOT NULL,
  `organization_id` text NOT NULL,
  `client_key` text NOT NULL,
  `secret_key` text NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Active, Non-Active',
  `updatetime` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i:s',
  PRIMARY KEY (`id_setting_satusehat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_service`
--

DROP TABLE IF EXISTS `setting_service`;
CREATE TABLE IF NOT EXISTS `setting_service` (
  `id_setting_service` int NOT NULL AUTO_INCREMENT,
  `service_name` text NOT NULL,
  `service_category` varchar(30) NOT NULL,
  `url_service` text NOT NULL,
  `last_update` text NOT NULL,
  PRIMARY KEY (`id_setting_service`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_sirs_online`
--

DROP TABLE IF EXISTS `setting_sirs_online`;
CREATE TABLE IF NOT EXISTS `setting_sirs_online` (
  `id_setting_sirs_online` int NOT NULL AUTO_INCREMENT,
  `nama_setting` text NOT NULL,
  `url_sirs_online` text NOT NULL,
  `id_rs` varchar(20) NOT NULL,
  `password_sirs_online` varchar(20) NOT NULL COMMENT 'No Md5 (real)',
  `status` varchar(20) NOT NULL COMMENT 'Aktiv/NON Aktiv',
  PRIMARY KEY (`id_setting_sirs_online`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `sirs_online_task`
--

DROP TABLE IF EXISTS `sirs_online_task`;
CREATE TABLE IF NOT EXISTS `sirs_online_task` (
  `id_sirs_online_task` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL COMMENT 'update fitur',
  `updatetime` varchar(20) NOT NULL,
  `kategori` varchar(20) NOT NULL COMMENT 'Nama laporan',
  `keterangan` text COMMENT 'Bisa diisi dengan raw',
  `id_akses` int NOT NULL COMMENT 'id_akses petugas yang input',
  PRIMARY KEY (`id_sirs_online_task`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snomed`
--

DROP TABLE IF EXISTS `snomed`;
CREATE TABLE IF NOT EXISTS `snomed` (
  `id_snomed` int NOT NULL AUTO_INCREMENT,
  `active` int DEFAULT NULL,
  `conceptId` varchar(30) NOT NULL,
  `languageCode` varchar(10) NOT NULL,
  `typeId` varchar(30) NOT NULL,
  `term` text NOT NULL,
  PRIMARY KEY (`id_snomed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snomed_definition`
--

DROP TABLE IF EXISTS `snomed_definition`;
CREATE TABLE IF NOT EXISTS `snomed_definition` (
  `id_definition` int NOT NULL AUTO_INCREMENT,
  `conceptId` varchar(30) DEFAULT NULL,
  `term` text,
  PRIMARY KEY (`id_definition`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` int NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL COMMENT 'Nama delegasi, petugas supplier',
  `alamat` text NOT NULL COMMENT 'alamat operasional',
  `kontak` varchar(20) NOT NULL COMMENT 'kontak delegasi atau kantor',
  `email` text COMMENT 'email delegasi atau kantor',
  `company` text NOT NULL COMMENT 'Nama perusahaan',
  PRIMARY KEY (`id_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

DROP TABLE IF EXISTS `tarif`;
CREATE TABLE IF NOT EXISTS `tarif` (
  `id_tarif` int NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `kategori` text NOT NULL,
  `tarif` int NOT NULL,
  PRIMARY KEY (`id_tarif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tarif_cost`
--

DROP TABLE IF EXISTS `tarif_cost`;
CREATE TABLE IF NOT EXISTS `tarif_cost` (
  `id_cost` int NOT NULL AUTO_INCREMENT,
  `id_tarif` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `cost` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cost`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tindakan`
--

DROP TABLE IF EXISTS `tindakan`;
CREATE TABLE IF NOT EXISTS `tindakan` (
  `id_tindakan` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `nama_pasien` text NOT NULL,
  `nama_petugas` text NOT NULL COMMENT 'petugas entry',
  `tanggal_entry` varchar(30) NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `kode_tindakan` varchar(20) NOT NULL,
  `nama_tindakan` text NOT NULL,
  `alat_medis` text COMMENT 'JSON',
  `bmhp` text COMMENT 'JSON',
  `nakes` text NOT NULL COMMENT 'JSON',
  PRIMARY KEY (`id_tindakan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL,
  `transaksi` varchar(15) NOT NULL,
  `tanggal` datetime NOT NULL,
  `label` varchar(30) DEFAULT NULL COMMENT 'label',
  `karyawan` varchar(30) DEFAULT NULL COMMENT 'nama karyawan',
  `id_akses` int NOT NULL,
  `nama_akses` text NOT NULL,
  `id_supplier` int DEFAULT NULL,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nama_pasien` text NOT NULL,
  `id_kunjungan` int DEFAULT NULL,
  `tujuan` varchar(20) DEFAULT NULL COMMENT 'Rajal/Ranap',
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` text NOT NULL,
  `subtotal` varchar(20) NOT NULL,
  `ppn` varchar(20) DEFAULT NULL,
  `diskon` varchar(20) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `kunci` varchar(20) NOT NULL,
  `catatan` text,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_anggaran`
--

DROP TABLE IF EXISTS `transaksi_anggaran`;
CREATE TABLE IF NOT EXISTS `transaksi_anggaran` (
  `id_transaksi_anggaran` int NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(20) NOT NULL,
  `id_akses` int NOT NULL,
  `nama_akses` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `token` int NOT NULL,
  `status` varchar(20) NOT NULL,
  `updatetime` varchar(50) NOT NULL,
  PRIMARY KEY (`id_transaksi_anggaran`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_jasa`
--

DROP TABLE IF EXISTS `transaksi_jasa`;
CREATE TABLE IF NOT EXISTS `transaksi_jasa` (
  `id_transaksi_jasa` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `id_dokter` int NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `id_tarif` int NOT NULL,
  `nama_tarif` varchar(100) NOT NULL,
  `jasa` int NOT NULL,
  `petugas` varchar(50) NOT NULL,
  PRIMARY KEY (`id_transaksi_jasa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_nota`
--

DROP TABLE IF EXISTS `transaksi_nota`;
CREATE TABLE IF NOT EXISTS `transaksi_nota` (
  `id_transaksi_nota` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `TerimaDari` varchar(100) NOT NULL,
  `UangSebesar` varchar(50) NOT NULL,
  `NoReferensi` varchar(50) NOT NULL,
  `Untuk` varchar(100) NOT NULL,
  `lampiran` varchar(100) NOT NULL,
  `updatetime` varchar(50) NOT NULL,
  PRIMARY KEY (`id_transaksi_nota`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_rincian`
--

DROP TABLE IF EXISTS `transaksi_rincian`;
CREATE TABLE IF NOT EXISTS `transaksi_rincian` (
  `id_rincian` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(40) NOT NULL,
  `transaksi` varchar(20) NOT NULL COMMENT 'Nama transaksi',
  `kategori` varchar(20) NOT NULL COMMENT 'Obat, Tindakan, Lainnya',
  `id_obat_tindakan` int NOT NULL,
  `id_inventori_posisi` int NOT NULL,
  `nama` text NOT NULL COMMENT 'Nama obat, barang, tindakan',
  `qty` int NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `harga` varchar(20) DEFAULT NULL,
  `ppn` varchar(15) DEFAULT NULL,
  `diskon` varchar(15) DEFAULT NULL,
  `jumlah` varchar(20) DEFAULT NULL,
  `klaim` varchar(10) NOT NULL,
  `retur` varchar(10) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_rincian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `triase_igd`
--

DROP TABLE IF EXISTS `triase_igd`;
CREATE TABLE IF NOT EXISTS `triase_igd` (
  `id_triase_igd` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_kunjungan` int NOT NULL,
  `id_akses` int NOT NULL,
  `tanggal` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i\r\n(Tanggal Jam Pencatatan)',
  `nama_pasien` text NOT NULL,
  `nama_petugas` text NOT NULL,
  `tanggal_jam_masuk` varchar(30) NOT NULL COMMENT 'YYYY-mm-dd H:i\r\n(Tanggal Jam pasien masuk)',
  `triase_igd` text NOT NULL COMMENT 'JSON\r\n1. Sarana Transportasi\r\n2. Surat Rujukan\r\n3. Kondisi Pasien Tiba\r\n4. Identitas Pengantar',
  PRIMARY KEY (`id_triase_igd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

DROP TABLE IF EXISTS `wilayah`;
CREATE TABLE IF NOT EXISTS `wilayah` (
  `id_wilayah` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  `propinsi` varchar(50) DEFAULT NULL,
  `kabupaten` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `desa` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_wilayah`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah_mendagri`
--

DROP TABLE IF EXISTS `wilayah_mendagri`;
CREATE TABLE IF NOT EXISTS `wilayah_mendagri` (
  `id_wilayah_mendagri` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(15) NOT NULL,
  `kategori` varchar(25) NOT NULL,
  `nama` text NOT NULL,
  PRIMARY KEY (`id_wilayah_mendagri`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `api_token`
--
ALTER TABLE `api_token`
  ADD CONSTRAINT `to_api_access` FOREIGN KEY (`id_api_access`) REFERENCES `api_access` (`id_api_access`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

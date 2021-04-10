-- --------------------------------------------------------
-- Host:                         10.1.44.61
-- Server version:               5.5.62-0+deb8u1-log - (Debian)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for imidesk
CREATE DATABASE IF NOT EXISTS `imidesk` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `imidesk`;

-- Dumping structure for view imidesk.instansi
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `instansi` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`lokasi` VARCHAR(32) NOT NULL COMMENT '@lokasi_daerah (kode)' COLLATE 'utf8_general_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`tipe` ENUM('Imigrasi','Vendor') NOT NULL COLLATE 'utf8_general_ci',
	`logo` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.lokasi
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `lokasi` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`provinsi` VARCHAR(32) NOT NULL COMMENT '@lokasi_provinsi (kode)' COLLATE 'utf8_general_ci',
	`label` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.negara
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `negara` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`label` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.provinsi
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `provinsi` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`negara` VARCHAR(32) NOT NULL COMMENT '@lokasi_negara (kode)' COLLATE 'utf8_general_ci',
	`label` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.tiket_transfer
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `tiket_transfer` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`aduan` VARCHAR(32) NOT NULL COMMENT '@pengaduan_isi (kode)' COLLATE 'utf8_general_ci',
	`jenis` VARCHAR(32) NOT NULL COMMENT '@pengaduan_jenis (kode)' COLLATE 'utf8_general_ci',
	`pemohon` VARCHAR(32) NOT NULL COMMENT '@profil (kode)' COLLATE 'utf8_general_ci',
	`penerima` VARCHAR(32) NOT NULL COMMENT '@profil (kode) atau \'-\' jika belum ditentukan' COLLATE 'utf8_general_ci',
	`vendor_asal` VARCHAR(32) NOT NULL COMMENT '@organisasi (kode){tipe:Vendor}' COLLATE 'utf8_general_ci',
	`vendor_tuju` VARCHAR(32) NOT NULL COMMENT '@organisasi (kode){tipe:Vendor}' COLLATE 'utf8_general_ci',
	`alasan` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`waktu` DATETIME NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.user
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `user` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`id` VARCHAR(25) NOT NULL COLLATE 'utf8_general_ci',
	`sandi` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`status` ENUM('aktif','blok') NOT NULL COLLATE 'utf8_general_ci',
	`otoritas` ENUM('admin','helpdesk','pengadu','monitor') NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.view_pengaduan_isi
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pengaduan_isi` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`jenis` VARCHAR(32) NOT NULL COMMENT '@pengaduan_jenis (kode)' COLLATE 'utf8_general_ci',
	`pengadu` VARCHAR(32) NOT NULL COMMENT '@profil (kode)' COLLATE 'utf8_general_ci',
	`penerima` VARCHAR(32) NOT NULL COMMENT '@profil (kode) atau \'-\' jika belum ditentukan' COLLATE 'utf8_general_ci',
	`nomor` VARCHAR(15) NOT NULL COLLATE 'utf8_general_ci',
	`perihal` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`deskripsi` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`prioritas` ENUM('rendah','normal','tinggi') NOT NULL COLLATE 'utf8_general_ci',
	`status` ENUM('open','progress','close') NOT NULL COLLATE 'utf8_general_ci',
	`waktu` DATETIME NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.view_pengaduan_jenis
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pengaduan_jenis` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`vendor` VARCHAR(32) NOT NULL COMMENT '@organisasi (kode){tipe:Vendor}' COLLATE 'utf8_general_ci',
	`induk` VARCHAR(32) NOT NULL COMMENT '@pengaduan_jenis (kode) jika sama, maka top level, jika beda maka sebagai child' COLLATE 'utf8_general_ci',
	`jenis` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`deskripsi` TEXT NULL COLLATE 'utf8_general_ci',
	`status` ENUM('aktif','blok') NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.view_pengaduan_pindah
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pengaduan_pindah` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`aduan` VARCHAR(32) NOT NULL COMMENT '@pengaduan_isi (kode)' COLLATE 'utf8_general_ci',
	`jenis` VARCHAR(32) NOT NULL COMMENT '@pengaduan_jenis (kode)' COLLATE 'utf8_general_ci',
	`pemohon` VARCHAR(32) NOT NULL COMMENT '@profil (kode)' COLLATE 'utf8_general_ci',
	`penerima` VARCHAR(32) NOT NULL COMMENT '@profil (kode) atau \'-\' jika belum ditentukan' COLLATE 'utf8_general_ci',
	`vendor_asal` VARCHAR(32) NOT NULL COMMENT '@organisasi (kode){tipe:Vendor}' COLLATE 'utf8_general_ci',
	`vendor_tuju` VARCHAR(32) NOT NULL COMMENT '@organisasi (kode){tipe:Vendor}' COLLATE 'utf8_general_ci',
	`alasan` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`waktu` DATETIME NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.view_pengaduan_respon
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pengaduan_respon` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`aduan` VARCHAR(32) NOT NULL COMMENT '@pengaduan_isi (kode)' COLLATE 'utf8_general_ci',
	`penulis` VARCHAR(32) NOT NULL COMMENT '@profil (kode)' COLLATE 'utf8_general_ci',
	`isi` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`jenis` ENUM('respon','sisipan') NOT NULL COMMENT 'sisipan merupakan respon yang disisipi oleh sistem sebagai tagline/timeline jika terjadi perubahan pada respon oleh sistem' COLLATE 'utf8_general_ci',
	`waktu` DATETIME NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.view_pengguna
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pengguna` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`id` VARCHAR(25) NOT NULL COLLATE 'utf8_general_ci',
	`sandi` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`status` ENUM('aktif','blok') NOT NULL COLLATE 'utf8_general_ci',
	`otoritas` ENUM('admin','helpdesk','pengadu','monitor') NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.view_profil
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_profil` (
	`entitas` INT(11) NOT NULL,
	`kode` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`organisasi` VARCHAR(32) NOT NULL COMMENT '@organisasi (kode)' COLLATE 'utf8_general_ci',
	`akun` VARCHAR(32) NOT NULL COMMENT '@pengguna (kode)' COLLATE 'utf8_general_ci',
	`id` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`kelamin` ENUM('Laki-Laki','Perempuan') NOT NULL COLLATE 'utf8_general_ci',
	`tempat_lahir` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`tanggal_lahir` DATE NULL,
	`alamat` TEXT NULL COLLATE 'utf8_general_ci',
	`telepon` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`foto` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view imidesk.instansi
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `instansi`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `instansi` AS select `organisasi_backup`.`entitas` AS `entitas`,`organisasi_backup`.`kode` AS `kode`,`organisasi_backup`.`lokasi` AS `lokasi`,`organisasi_backup`.`nama` AS `nama`,`organisasi_backup`.`tipe` AS `tipe`,`organisasi_backup`.`logo` AS `logo` from `organisasi_backup`;

-- Dumping structure for view imidesk.lokasi
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `lokasi`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `lokasi` AS select `lokasi_daerah`.`entitas` AS `entitas`,`lokasi_daerah`.`kode` AS `kode`,`lokasi_daerah`.`provinsi` AS `provinsi`,`lokasi_daerah`.`label` AS `label`,`lokasi_daerah`.`nama` AS `nama` from `lokasi_daerah`;

-- Dumping structure for view imidesk.negara
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `negara`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `negara` AS select `lokasi_negara`.`entitas` AS `entitas`,`lokasi_negara`.`kode` AS `kode`,`lokasi_negara`.`label` AS `label`,`lokasi_negara`.`nama` AS `nama` from `lokasi_negara`;

-- Dumping structure for view imidesk.provinsi
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `provinsi`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `provinsi` AS select `lokasi_provinsi`.`entitas` AS `entitas`,`lokasi_provinsi`.`kode` AS `kode`,`lokasi_provinsi`.`negara` AS `negara`,`lokasi_provinsi`.`label` AS `label`,`lokasi_provinsi`.`nama` AS `nama` from `lokasi_provinsi`;

-- Dumping structure for view imidesk.tiket_transfer
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `tiket_transfer`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `tiket_transfer` AS select `pengaduan_pindah`.`entitas` AS `entitas`,`pengaduan_pindah`.`kode` AS `kode`,`pengaduan_pindah`.`aduan` AS `aduan`,`pengaduan_pindah`.`jenis` AS `jenis`,`pengaduan_pindah`.`pemohon` AS `pemohon`,`pengaduan_pindah`.`penerima` AS `penerima`,`pengaduan_pindah`.`vendor_asal` AS `vendor_asal`,`pengaduan_pindah`.`vendor_tuju` AS `vendor_tuju`,`pengaduan_pindah`.`alasan` AS `alasan`,`pengaduan_pindah`.`waktu` AS `waktu` from `pengaduan_pindah`;

-- Dumping structure for view imidesk.user
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `user` AS select `pengguna_backup`.`entitas` AS `entitas`,`pengguna_backup`.`kode` AS `kode`,`pengguna_backup`.`id` AS `id`,`pengguna_backup`.`sandi` AS `sandi`,`pengguna_backup`.`status` AS `status`,`pengguna_backup`.`otoritas` AS `otoritas` from `pengguna_backup`;

-- Dumping structure for view imidesk.view_pengaduan_isi
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pengaduan_isi`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pengaduan_isi` AS select `pengaduan_isi`.`entitas` AS `entitas`,`pengaduan_isi`.`kode` AS `kode`,`pengaduan_isi`.`jenis` AS `jenis`,`pengaduan_isi`.`pengadu` AS `pengadu`,`pengaduan_isi`.`penerima` AS `penerima`,`pengaduan_isi`.`nomor` AS `nomor`,`pengaduan_isi`.`perihal` AS `perihal`,`pengaduan_isi`.`deskripsi` AS `deskripsi`,`pengaduan_isi`.`prioritas` AS `prioritas`,`pengaduan_isi`.`status` AS `status`,`pengaduan_isi`.`waktu` AS `waktu` from `pengaduan_isi`;

-- Dumping structure for view imidesk.view_pengaduan_jenis
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pengaduan_jenis`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pengaduan_jenis` AS select `pengaduan_jenis`.`entitas` AS `entitas`,`pengaduan_jenis`.`kode` AS `kode`,`pengaduan_jenis`.`vendor` AS `vendor`,`pengaduan_jenis`.`induk` AS `induk`,`pengaduan_jenis`.`jenis` AS `jenis`,`pengaduan_jenis`.`deskripsi` AS `deskripsi`,`pengaduan_jenis`.`status` AS `status` from `pengaduan_jenis`;

-- Dumping structure for view imidesk.view_pengaduan_pindah
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pengaduan_pindah`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pengaduan_pindah` AS select `pengaduan_pindah`.`entitas` AS `entitas`,`pengaduan_pindah`.`kode` AS `kode`,`pengaduan_pindah`.`aduan` AS `aduan`,`pengaduan_pindah`.`jenis` AS `jenis`,`pengaduan_pindah`.`pemohon` AS `pemohon`,`pengaduan_pindah`.`penerima` AS `penerima`,`pengaduan_pindah`.`vendor_asal` AS `vendor_asal`,`pengaduan_pindah`.`vendor_tuju` AS `vendor_tuju`,`pengaduan_pindah`.`alasan` AS `alasan`,`pengaduan_pindah`.`waktu` AS `waktu` from `pengaduan_pindah`;

-- Dumping structure for view imidesk.view_pengaduan_respon
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pengaduan_respon`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pengaduan_respon` AS select `pengaduan_respon`.`entitas` AS `entitas`,`pengaduan_respon`.`kode` AS `kode`,`pengaduan_respon`.`aduan` AS `aduan`,`pengaduan_respon`.`penulis` AS `penulis`,`pengaduan_respon`.`isi` AS `isi`,`pengaduan_respon`.`jenis` AS `jenis`,`pengaduan_respon`.`waktu` AS `waktu` from `pengaduan_respon`;

-- Dumping structure for view imidesk.view_pengguna
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pengguna`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pengguna` AS select `pengguna`.`entitas` AS `entitas`,`pengguna`.`kode` AS `kode`,`pengguna`.`id` AS `id`,`pengguna`.`sandi` AS `sandi`,`pengguna`.`status` AS `status`,`pengguna`.`otoritas` AS `otoritas` from `pengguna`;

-- Dumping structure for view imidesk.view_profil
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_profil`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_profil` AS select `profil`.`entitas` AS `entitas`,`profil`.`kode` AS `kode`,`profil`.`organisasi` AS `organisasi`,`profil`.`akun` AS `akun`,`profil`.`id` AS `id`,`profil`.`nama` AS `nama`,`profil`.`kelamin` AS `kelamin`,`profil`.`tempat_lahir` AS `tempat_lahir`,`profil`.`tanggal_lahir` AS `tanggal_lahir`,`profil`.`alamat` AS `alamat`,`profil`.`telepon` AS `telepon`,`profil`.`email` AS `email`,`profil`.`foto` AS `foto` from `profil`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

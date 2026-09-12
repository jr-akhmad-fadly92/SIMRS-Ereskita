/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 5.7.30 : Database - itbar_simrs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`itbar_simrs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `itbar_simrs`;

/*Table structure for table `activity_log` */

DROP TABLE IF EXISTS `activity_log`;

CREATE TABLE `activity_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `agamas` */

DROP TABLE IF EXISTS `agamas`;

CREATE TABLE `agamas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `akun_keuangan` */

DROP TABLE IF EXISTS `akun_keuangan`;

CREATE TABLE `akun_keuangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_keuangan` varchar(10) DEFAULT NULL,
  `nama_akun` varchar(50) DEFAULT NULL,
  `tipe` varchar(11) DEFAULT NULL,
  `balance` varchar(11) DEFAULT NULL,
  `aktiva` varchar(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Table structure for table `antrian_apoteks` */

DROP TABLE IF EXISTS `antrian_apoteks`;

CREATE TABLE `antrian_apoteks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `loket` int(11) DEFAULT NULL,
  `kelompok` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `antrian_poli` */

DROP TABLE IF EXISTS `antrian_poli`;

CREATE TABLE `antrian_poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `antrian` varchar(255) DEFAULT NULL,
  `ruang` int(11) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `status_panggil` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `antrians` */

DROP TABLE IF EXISTS `antrians`;

CREATE TABLE `antrians` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `loket` int(11) DEFAULT NULL,
  `kelompok` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `apotekers` */

DROP TABLE IF EXISTS `apotekers`;

CREATE TABLE `apotekers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` int(11) NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `asuransis` */

DROP TABLE IF EXISTS `asuransis`;

CREATE TABLE `asuransis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diskon` int(11) NOT NULL,
  `plafon` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `aturanetikets` */

DROP TABLE IF EXISTS `aturanetikets`;

CREATE TABLE `aturanetikets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aturan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konversi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `beds` */

DROP TABLE IF EXISTS `beds`;

CREATE TABLE `beds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kamar_id` int(10) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reserved` enum('Y','N','AP') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `beds_kamar_id_foreign` (`kamar_id`),
  CONSTRAINT `beds_ibfk_1` FOREIGN KEY (`kamar_id`) REFERENCES `kamars` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `biayaregistrasis` */

DROP TABLE IF EXISTS `biayaregistrasis`;

CREATE TABLE `biayaregistrasis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipe` enum('E','R','I') COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_id` int(10) unsigned NOT NULL,
  `tahuntarif_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `biayaregistrasis_tarif_id_foreign` (`tarif_id`),
  KEY `biayaregistrasis_tahuntarif_id_foreign` (`tahuntarif_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `carabayars` */

DROP TABLE IF EXISTS `carabayars`;

CREATE TABLE `carabayars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `carabayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `configs` */

DROP TABLE IF EXISTS `configs`;

CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bayardepan` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kasirtindakan` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `antrianfooter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahuntarif` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `panjangkodepasien` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipsep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usersep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipinacbg` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pt` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npwp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tlp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `data_karyawan_perusahaan` */

DROP TABLE IF EXISTS `data_karyawan_perusahaan`;

CREATE TABLE `data_karyawan_perusahaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT NULL,
  `pasien_id` int(11) DEFAULT NULL,
  `nik_karyawan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `data_order_operasi` */

DROP TABLE IF EXISTS `data_order_operasi`;

CREATE TABLE `data_order_operasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `id_tindakan_operasi` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `data_order_radiologi` */

DROP TABLE IF EXISTS `data_order_radiologi`;

CREATE TABLE `data_order_radiologi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `id_tindakan_radiologi` int(11) DEFAULT NULL,
  `mastermapping_biaya_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  `no_foto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `data_surat_ket_sehat` */

DROP TABLE IF EXISTS `data_surat_ket_sehat`;

CREATE TABLE `data_surat_ket_sehat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `keperluan` varchar(255) DEFAULT NULL,
  `berat_badan` int(11) DEFAULT NULL,
  `tinggi_badan` int(11) DEFAULT NULL,
  `tekanan_darah` varchar(50) DEFAULT NULL,
  `golongan_darah` varchar(5) DEFAULT NULL,
  `riwayat_penyakit` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `data_surat_persetujuan_tindakan` */

DROP TABLE IF EXISTS `data_surat_persetujuan_tindakan`;

CREATE TABLE `data_surat_persetujuan_tindakan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `penanggung_jawab` varchar(100) DEFAULT NULL,
  `hubungan_penanggung_jawab` varchar(50) DEFAULT NULL,
  `umur_penanggung_jawab` date DEFAULT NULL,
  `kelamin_penanggung_jawab` varchar(1) DEFAULT NULL,
  `alamat_penanggung_jawab` varchar(255) DEFAULT NULL,
  `no_bukti_diri` int(20) DEFAULT NULL,
  `jenis_tanda_pengenal` varchar(100) DEFAULT NULL,
  `telp_penanggung_jawab` int(16) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `data_visum` */

DROP TABLE IF EXISTS `data_visum`;

CREATE TABLE `data_visum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `instansi_pemohon` varchar(100) DEFAULT NULL,
  `pemohon` varchar(100) DEFAULT NULL,
  `jabatan_pemohon` varchar(100) DEFAULT NULL,
  `hasil_pemeriksaan` text,
  `kesimpulan` varchar(255) DEFAULT NULL,
  `nomor_permohonan` varchar(100) DEFAULT NULL,
  `dokter_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `departemen` */

DROP TABLE IF EXISTS `departemen`;

CREATE TABLE `departemen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departemen` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `depo_masterobats` */

DROP TABLE IF EXISTS `depo_masterobats`;

CREATE TABLE `depo_masterobats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_depo` int(11) DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuanjual_id` int(10) unsigned DEFAULT NULL,
  `satuanbeli_id` int(10) unsigned DEFAULT NULL,
  `kategoriobat_id` int(10) unsigned NOT NULL,
  `hargajual` int(11) NOT NULL,
  `hargajual_jkn` int(10) DEFAULT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `aktif` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `masterobats_satuanjual_id_foreign` (`satuanjual_id`),
  KEY `masterobats_satuanbeli_id_foreign` (`satuanbeli_id`),
  KEY `masterobats_kategoriobat_id_foreign` (`kategoriobat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1837 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `depo_po_details` */

DROP TABLE IF EXISTS `depo_po_details`;

CREATE TABLE `depo_po_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `no_po` varchar(45) DEFAULT NULL,
  `kode_item` varchar(45) DEFAULT NULL,
  `nama_item` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `kode_item_pemberian` varchar(45) DEFAULT NULL,
  `nama_item_pemberian` varchar(100) DEFAULT NULL,
  `jumlah_pemberian` varchar(255) DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `depo_po_inv` */

DROP TABLE IF EXISTS `depo_po_inv`;

CREATE TABLE `depo_po_inv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_depo` int(11) DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `supplier` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tgl_penerimaan` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `catatan` text,
  `user_create` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `depo_po_inv_detail` */

DROP TABLE IF EXISTS `depo_po_inv_detail`;

CREATE TABLE `depo_po_inv_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `ruangan` int(11) DEFAULT NULL,
  `kode_barang_pemberian` varchar(100) DEFAULT NULL,
  `nama_barang_pemberian` varchar(255) DEFAULT NULL,
  `jumlah_pemberian` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `depo_po_nonmedis` */

DROP TABLE IF EXISTS `depo_po_nonmedis`;

CREATE TABLE `depo_po_nonmedis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_depo` int(11) DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `supplier` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tgl_penerimaan` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `catatan` text,
  `user_create` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `depo_po_nonmedis_detail` */

DROP TABLE IF EXISTS `depo_po_nonmedis_detail`;

CREATE TABLE `depo_po_nonmedis_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `ruangan` int(11) DEFAULT NULL,
  `kode_barang_pemberian` varchar(100) DEFAULT NULL,
  `nama_barang_pemberian` varchar(255) DEFAULT NULL,
  `jumlah_pemberian` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `depo_pos` */

DROP TABLE IF EXISTS `depo_pos`;

CREATE TABLE `depo_pos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_depo` int(11) DEFAULT NULL,
  `no_po` varchar(45) DEFAULT NULL,
  `supplier` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tgl_penerimaan` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `user_create` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `depos` */

DROP TABLE IF EXISTS `depos`;

CREATE TABLE `depos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_depo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Table structure for table `detailradiologis` */

DROP TABLE IF EXISTS `detailradiologis`;

CREATE TABLE `detailradiologis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hasilradiologi_id` int(11) NOT NULL,
  `resum` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `districts` */

DROP TABLE IF EXISTS `districts`;

CREATE TABLE `districts` (
  `id` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `regency_id` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_id_index` (`regency_id`),
  CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`regency_id`) REFERENCES `regencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `farmasi_faktur` */

DROP TABLE IF EXISTS `farmasi_faktur`;

CREATE TABLE `farmasi_faktur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `supplier_id` varchar(45) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `no_transaksi` varchar(45) DEFAULT NULL,
  `sumber_dana` varchar(45) DEFAULT NULL,
  `user_create` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `farmasi_faktur_detail` */

DROP TABLE IF EXISTS `farmasi_faktur_detail`;

CREATE TABLE `farmasi_faktur_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faktur_id` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `harga_ppn` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `farmasi_po` */

DROP TABLE IF EXISTS `farmasi_po`;

CREATE TABLE `farmasi_po` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_po` varchar(45) DEFAULT NULL,
  `supplier` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tgl_penerimaan` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `user_create` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `farmasi_po_detail` */

DROP TABLE IF EXISTS `farmasi_po_detail`;

CREATE TABLE `farmasi_po_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `no_po` varchar(45) DEFAULT NULL,
  `kode_item` varchar(45) DEFAULT NULL,
  `nama_item` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `kode_item_pemberian` varchar(45) DEFAULT NULL,
  `nama_item_pemberian` varchar(100) DEFAULT NULL,
  `jumlah_pemberian` varchar(255) DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `fasilitas` */

DROP TABLE IF EXISTS `fasilitas`;

CREATE TABLE `fasilitas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fasilitas` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `foliopelaksanas` */

DROP TABLE IF EXISTS `foliopelaksanas`;

CREATE TABLE `foliopelaksanas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folio_id` int(11) DEFAULT NULL,
  `dpjp` int(11) DEFAULT NULL,
  `dokter_pelaksana` int(11) DEFAULT NULL,
  `dokter_anestesi` int(11) DEFAULT NULL,
  `perawat_anestesi1` int(11) DEFAULT NULL,
  `perawat_anestesi2` int(11) DEFAULT NULL,
  `perawat_anestesi3` int(11) DEFAULT NULL,
  `dokter_operator1` int(11) DEFAULT NULL,
  `dokter_operator2` int(11) DEFAULT NULL,
  `dokter_lab` int(11) DEFAULT NULL,
  `analis_lab` int(11) DEFAULT NULL,
  `dokter_radiologi` int(11) DEFAULT NULL,
  `radiografer` int(11) DEFAULT NULL,
  `perawat` int(10) DEFAULT NULL,
  `dokter_bedah` int(11) DEFAULT NULL,
  `perawat_ibs1` int(11) DEFAULT NULL,
  `perawat_ibs2` int(11) DEFAULT NULL,
  `perawat_ibs3` int(11) DEFAULT NULL,
  `perawat_ibs4` int(11) DEFAULT NULL,
  `perawat_ibs5` int(11) DEFAULT NULL,
  `dokter_anak` int(11) DEFAULT NULL,
  `bidan1` int(11) DEFAULT NULL,
  `bidan2` int(11) DEFAULT NULL,
  `fisioterapi` int(11) DEFAULT NULL,
  `dokter_visit` int(11) DEFAULT NULL,
  `pelaksana_tipe` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `foliopelaksanas_2` */

DROP TABLE IF EXISTS `foliopelaksanas_2`;

CREATE TABLE `foliopelaksanas_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folio_id` int(11) DEFAULT NULL,
  `dpjp` int(11) DEFAULT NULL,
  `pelaksana` int(11) DEFAULT NULL,
  `pelaksana_tipe` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Table structure for table `folios` */

DROP TABLE IF EXISTS `folios`;

CREATE TABLE `folios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(10) unsigned DEFAULT NULL,
  `namatarif` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_bayar_id` int(5) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tarif_id` int(11) DEFAULT NULL,
  `jenis` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lunas` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibayar` int(11) DEFAULT NULL,
  `waktu_dibayar` timestamp NULL DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pasien` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kuitansi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `pembulatan_penjualan` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `pasien_id` int(10) unsigned DEFAULT NULL,
  `dokter_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `poli_id` int(10) unsigned DEFAULT NULL,
  `poli_tipe` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagihan_id` int(10) unsigned DEFAULT NULL,
  `dijamin` int(11) DEFAULT NULL,
  `subsidi` int(11) DEFAULT NULL,
  `iur_bayar` int(11) DEFAULT NULL,
  `harus_bayar` int(11) DEFAULT NULL,
  `dijamin1` int(11) DEFAULT NULL,
  `dijamin2` int(11) DEFAULT NULL,
  `pembatal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_batal` datetime DEFAULT NULL,
  `is_batal` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_rj` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `verif_rj_user` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_kasa` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `verif_kasa_user` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kelompokkelas_id` int(11) DEFAULT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `folios_registrasi_id_foreign` (`registrasi_id`),
  KEY `folios_pasien_id_foreign` (`pasien_id`),
  KEY `folios_user_id_foreign` (`user_id`),
  KEY `folios_poli_id_foreign` (`poli_id`),
  KEY `folios_tagihan_id_foreign` (`tagihan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `gizis` */

DROP TABLE IF EXISTS `gizis`;

CREATE TABLE `gizis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `dokter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  `bed_id` int(11) DEFAULT NULL,
  `pagi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siang` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `malam` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who_update` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `hapus-dokters` */

DROP TABLE IF EXISTS `hapus-dokters`;

CREATE TABLE `hapus-dokters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poli_id` int(10) unsigned NOT NULL,
  `dokterlab` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokterrad` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokters_user_id_foreign` (`user_id`),
  KEY `dokters_poli_id_foreign` (`poli_id`),
  CONSTRAINT `hapus-dokters_ibfk_1` FOREIGN KEY (`poli_id`) REFERENCES `polis` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `hapus-pasien_langsung` */

DROP TABLE IF EXISTS `hapus-pasien_langsung`;

CREATE TABLE `hapus-pasien_langsung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `nama` varchar(199) DEFAULT NULL,
  `alamat` varchar(199) DEFAULT NULL,
  `politype` char(1) DEFAULT NULL,
  `pemeriksaan` varchar(199) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `hapus-tagihans` */

DROP TABLE IF EXISTS `hapus-tagihans`;

CREATE TABLE `hapus-tagihans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `dokter_id` int(10) unsigned NOT NULL,
  `diskon` int(11) NOT NULL,
  `pasien_id` int(10) unsigned NOT NULL,
  `harus_dibayar` int(11) NOT NULL,
  `subsidi` int(11) NOT NULL,
  `dijamin` int(11) NOT NULL,
  `selisih_positif` int(11) NOT NULL,
  `selisih_negatif` int(11) NOT NULL,
  `approval_tanggal` date NOT NULL,
  `user_approval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembulatan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagihans_user_id_foreign` (`user_id`),
  KEY `tagihans_dokter_id_foreign` (`dokter_id`,`pasien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `hasillabs` */

DROP TABLE IF EXISTS `hasillabs`;

CREATE TABLE `hasillabs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_lab` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int(10) unsigned NOT NULL,
  `pasien_id` int(10) unsigned NOT NULL,
  `dokter_id` int(10) unsigned NOT NULL,
  `penanggungjawab` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pemeriksaan` date NOT NULL,
  `tgl_bahanditerima` date NOT NULL,
  `tgl_hasilselesai` date NOT NULL,
  `tgl_cetak` date NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `jam` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sample` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hasillabs_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `hasilradiologis` */

DROP TABLE IF EXISTS `hasilradiologis`;

CREATE TABLE `hasilradiologis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_order_radiologi_id` int(11) DEFAULT NULL,
  `registrasi_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `hasil_pemeriksaan` text COLLATE utf8mb4_unicode_ci,
  `kesan` text COLLATE utf8mb4_unicode_ci,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `histori_alergi_pasien` */

DROP TABLE IF EXISTS `histori_alergi_pasien`;

CREATE TABLE `histori_alergi_pasien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `pasien_id` int(11) DEFAULT NULL,
  `dokter_id` int(11) DEFAULT NULL,
  `jenis_alergi` int(11) DEFAULT NULL,
  `detail_alergi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_icu` */

DROP TABLE IF EXISTS `histori_icu`;

CREATE TABLE `histori_icu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rawatinap_id` int(11) NOT NULL,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `no_rm` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompokkelas_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `kamar_id` int(11) NOT NULL,
  `bed_id` int(11) NOT NULL,
  `dokter_id` int(10) DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `tarif` int(11) DEFAULT NULL,
  `carabayar_id` int(11) NOT NULL,
  `rencana_pulang` date DEFAULT NULL,
  `dirujuk` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `lari` enum('YN','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `mati` int(1) DEFAULT NULL,
  `mutasi` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `histori_kesehatan` */

DROP TABLE IF EXISTS `histori_kesehatan`;

CREATE TABLE `histori_kesehatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pegawai_id` int(11) DEFAULT NULL,
  `riwayat_penyakit` varchar(50) DEFAULT NULL,
  `opnam` varchar(10) DEFAULT NULL,
  `masuk_opnam` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_kunjungan_ber` */

DROP TABLE IF EXISTS `histori_kunjungan_ber`;

CREATE TABLE `histori_kunjungan_ber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `pasien_asal` enum('TA','TI','TG') DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `histori_kunjungan_fis` */

DROP TABLE IF EXISTS `histori_kunjungan_fis`;

CREATE TABLE `histori_kunjungan_fis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `pasien_asal` enum('TA','TI','TG') DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `histori_kunjungan_igd` */

DROP TABLE IF EXISTS `histori_kunjungan_igd`;

CREATE TABLE `histori_kunjungan_igd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `triage_nama` varchar(45) NOT NULL,
  `doa` enum('Y','N') DEFAULT 'N',
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `histori_kunjungan_irj` */

DROP TABLE IF EXISTS `histori_kunjungan_irj`;

CREATE TABLE `histori_kunjungan_irj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `histori_kunjungan_lab` */

DROP TABLE IF EXISTS `histori_kunjungan_lab`;

CREATE TABLE `histori_kunjungan_lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `pasien_asal` enum('TA','TI','TG') DEFAULT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `histori_kunjungan_rad` */

DROP TABLE IF EXISTS `histori_kunjungan_rad`;

CREATE TABLE `histori_kunjungan_rad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `pasien_asal` enum('TA','TI','TG') DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `histori_log_user` */

DROP TABLE IF EXISTS `histori_log_user`;

CREATE TABLE `histori_log_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `log_masuk` timestamp NULL DEFAULT NULL,
  `log_keluar` timestamp NULL DEFAULT NULL,
  `sif` varchar(11) DEFAULT NULL,
  `status` varchar(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=265 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_pemeriksaan_fisik` */

DROP TABLE IF EXISTS `histori_pemeriksaan_fisik`;

CREATE TABLE `histori_pemeriksaan_fisik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `tensi` varchar(10) DEFAULT NULL,
  `sistolik` int(11) DEFAULT NULL,
  `diastolik` int(11) DEFAULT NULL,
  `suhu` int(11) DEFAULT NULL,
  `berat` int(11) DEFAULT NULL,
  `tinggi` int(11) DEFAULT NULL,
  `respirasi` int(11) DEFAULT NULL,
  `status_gizi` varchar(20) DEFAULT NULL,
  `anamnesis` varchar(255) DEFAULT NULL,
  `keluhan_pasien` varchar(255) DEFAULT NULL,
  `tingkat_keluhan_pasien` int(11) DEFAULT NULL,
  `diagnosa_awal` varchar(255) DEFAULT NULL,
  `diagnosa_akhir` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=227 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_pemeriksaan_object` */

DROP TABLE IF EXISTS `histori_pemeriksaan_object`;

CREATE TABLE `histori_pemeriksaan_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `pasien_id` int(11) DEFAULT NULL,
  `kategori_pemeriksaan` varchar(30) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_pendidikan` */

DROP TABLE IF EXISTS `histori_pendidikan`;

CREATE TABLE `histori_pendidikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pegawai_id` int(11) DEFAULT NULL,
  `pendidikan_id` int(11) DEFAULT NULL,
  `institut` varchar(50) DEFAULT NULL,
  `masuk_pendidikan` date DEFAULT NULL,
  `keluar_pendidikan` date DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_pengajuan_inv_rusak` */

DROP TABLE IF EXISTS `histori_pengajuan_inv_rusak`;

CREATE TABLE `histori_pengajuan_inv_rusak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_inv` varchar(20) DEFAULT NULL,
  `asal_ruangan` int(11) DEFAULT NULL,
  `alasan` varchar(50) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `nama_peminta` varchar(255) DEFAULT NULL,
  `petugas` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

/*Table structure for table `histori_pengunjung` */

DROP TABLE IF EXISTS `histori_pengunjung`;

CREATE TABLE `histori_pengunjung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) DEFAULT NULL,
  `politipe` enum('J','G','I') NOT NULL,
  `status_pasien` enum('LAMA','BARU') DEFAULT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8;

/*Table structure for table `histori_rawatinap` */

DROP TABLE IF EXISTS `histori_rawatinap`;

CREATE TABLE `histori_rawatinap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rawatinap_id` int(11) NOT NULL,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `no_rm` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompokkelas_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `kamar_id` int(11) NOT NULL,
  `bed_id` int(11) NOT NULL,
  `dokter_id` int(10) DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `tarif` int(11) DEFAULT NULL,
  `carabayar_id` int(11) NOT NULL,
  `rencana_pulang` date DEFAULT NULL,
  `dirujuk` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `lari` enum('YN','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `mati` int(1) DEFAULT NULL,
  `mutasi` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `histori_rujukan` */

DROP TABLE IF EXISTS `histori_rujukan`;

CREATE TABLE `histori_rujukan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `ppk_dirujuk` varchar(255) DEFAULT NULL,
  `penanggung_jawab_ppk` varchar(100) DEFAULT NULL,
  `kasus_rujuk` varchar(255) DEFAULT NULL,
  `diagnosa` varchar(255) DEFAULT NULL,
  `terapi_pasien` varchar(255) DEFAULT NULL,
  `obat_pasien` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `histori_statuses` */

DROP TABLE IF EXISTS `histori_statuses`;

CREATE TABLE `histori_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(10) unsigned NOT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poli_id` int(10) unsigned DEFAULT NULL,
  `bed_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `histori_statuses_registrasi_id_foreign` (`registrasi_id`),
  KEY `histori_statuses_poli_id_foreign` (`poli_id`),
  KEY `histori_statuses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `history_inventaris` */

DROP TABLE IF EXISTS `history_inventaris`;

CREATE TABLE `history_inventaris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_inv` varchar(50) DEFAULT NULL,
  `asal_ruangan` int(11) DEFAULT NULL,
  `update_ruangan` int(11) DEFAULT NULL,
  `tanggal_pindah` date DEFAULT NULL,
  `kondisi_barang` varchar(50) DEFAULT NULL,
  `petugas` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `icd10s` */

DROP TABLE IF EXISTS `icd10s`;

CREATE TABLE `icd10s` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18501 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `icd9s` */

DROP TABLE IF EXISTS `icd9s`;

CREATE TABLE `icd9s` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4268 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `id_perusahaan` */

DROP TABLE IF EXISTS `id_perusahaan`;

CREATE TABLE `id_perusahaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `inacbgs` */

DROP TABLE IF EXISTS `inacbgs`;

CREATE TABLE `inacbgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pasien_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_kelamin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_tgllahir` date NOT NULL,
  `jenis_pembayaran` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kartu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pasien` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_perawatan` int(11) NOT NULL,
  `los` int(11) DEFAULT NULL,
  `cara_keluar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat` int(11) DEFAULT '0',
  `total_rs` int(11) NOT NULL,
  `surat_rujukan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bhp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `severity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adl` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drugs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_cmg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `registrasi_id` int(11) NOT NULL,
  `dijamin` int(11) DEFAULT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_klaim` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_update` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_final_klaim` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topup` int(11) DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `kirim_dc` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_grouper` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versi_eklaim` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kirim_lpk` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `instalasis` */

DROP TABLE IF EXISTS `instalasis`;

CREATE TABLE `instalasis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `inventaris_global` */

DROP TABLE IF EXISTS `inventaris_global`;

CREATE TABLE `inventaris_global` (
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `produsen` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `tahun_produksi` int(11) DEFAULT NULL,
  `harga_unit` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `kategori_barang` varchar(20) DEFAULT NULL,
  `jenis_barang` int(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `invetaris_detail` */

DROP TABLE IF EXISTS `invetaris_detail`;

CREATE TABLE `invetaris_detail` (
  `no_inv` varchar(100) NOT NULL,
  `kode_barang` varchar(100) DEFAULT NULL,
  `ruangan` int(11) DEFAULT NULL,
  `lokasi` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `tanggal_pengadaan` date DEFAULT NULL,
  `kondisi_barang` varchar(25) DEFAULT NULL,
  `harga_barang` double DEFAULT NULL,
  `asal_barang` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`no_inv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `jadwaldokters` */

DROP TABLE IF EXISTS `jadwaldokters`;

CREATE TABLE `jadwaldokters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poli` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_berakhir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `jasa_medis` */

DROP TABLE IF EXISTS `jasa_medis`;

CREATE TABLE `jasa_medis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dokter` int(11) DEFAULT NULL,
  `perawat` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `jenis_racikan` */

DROP TABLE IF EXISTS `jenis_racikan`;

CREATE TABLE `jenis_racikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_racikan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `jenisjkns` */

DROP TABLE IF EXISTS `jenisjkns`;

CREATE TABLE `jenisjkns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `jurnal` */

DROP TABLE IF EXISTS `jurnal`;

CREATE TABLE `jurnal` (
  `id` double NOT NULL AUTO_INCREMENT,
  `no_jurnal` varchar(50) DEFAULT NULL,
  `no_bukti` varchar(50) DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `keterangan` text,
  `kode_keuangan` varchar(11) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `balance` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

/*Table structure for table `kamars` */

DROP TABLE IF EXISTS `kamars`;

CREATE TABLE `kamars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` int(10) unsigned NOT NULL,
  `kelompokkelas_id` int(11) DEFAULT NULL,
  `tarif` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kamars_kelas_id_foreign` (`kelas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `kategoriheaders` */

DROP TABLE IF EXISTS `kategoriheaders`;

CREATE TABLE `kategoriheaders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `kategoriobats` */

DROP TABLE IF EXISTS `kategoriobats`;

CREATE TABLE `kategoriobats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `kategoripegawais` */

DROP TABLE IF EXISTS `kategoripegawais`;

CREATE TABLE `kategoripegawais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Table structure for table `kategoritarifs` */

DROP TABLE IF EXISTS `kategoritarifs`;

CREATE TABLE `kategoritarifs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namatarif` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategoriheader_id` int(10) unsigned NOT NULL,
  `jenis` enum('TA','TG','TI') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kategoritarifs_kategoriheader_id_foreign` (`kategoriheader_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `kelompok_kelas` */

DROP TABLE IF EXISTS `kelompok_kelas`;

CREATE TABLE `kelompok_kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kelompok` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `kondisi_akhir_pasiens` */

DROP TABLE IF EXISTS `kondisi_akhir_pasiens`;

CREATE TABLE `kondisi_akhir_pasiens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namakondisi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `labkategoris` */

DROP TABLE IF EXISTS `labkategoris`;

CREATE TABLE `labkategoris` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labsection_id` int(10) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `labkategoris_labsection_id_foreign` (`labsection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `laboratoria` */

DROP TABLE IF EXISTS `laboratoria`;

CREATE TABLE `laboratoria` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mastermapping_biaya_id` int(10) unsigned DEFAULT '0',
  `tarif_id` int(11) NOT NULL,
  `nilairujukanbawah` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilairujukanatas` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilairujukanbawahwanita` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilairujukanataswanita` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilairujukanbawahanak` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilairujukanatasanak` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `laboratoria_labkategori_id_foreign` (`mastermapping_biaya_id`)
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `labsections` */

DROP TABLE IF EXISTS `labsections`;

CREATE TABLE `labsections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `margin_hargaobat` */

DROP TABLE IF EXISTS `margin_hargaobat`;

CREATE TABLE `margin_hargaobat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rawatinap` varchar(255) DEFAULT NULL,
  `rawatjalan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `master_alergi` */

DROP TABLE IF EXISTS `master_alergi`;

CREATE TABLE `master_alergi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_alergi` int(5) DEFAULT NULL,
  `macam_alergi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `master_dana_sosial` */

DROP TABLE IF EXISTS `master_dana_sosial`;

CREATE TABLE `master_dana_sosial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jumlah` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `master_etikets` */

DROP TABLE IF EXISTS `master_etikets`;

CREATE TABLE `master_etikets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `master_iuran_bpjs` */

DROP TABLE IF EXISTS `master_iuran_bpjs`;

CREATE TABLE `master_iuran_bpjs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_keanggotaan` varchar(10) DEFAULT NULL,
  `biaya_bpjs` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `master_iuran_jamsostek` */

DROP TABLE IF EXISTS `master_iuran_jamsostek`;

CREATE TABLE `master_iuran_jamsostek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_keanggotaan` varchar(20) DEFAULT NULL,
  `biaya_jamsostek` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `master_iuran_koperasi` */

DROP TABLE IF EXISTS `master_iuran_koperasi`;

CREATE TABLE `master_iuran_koperasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_keanggotaan` varchar(20) DEFAULT NULL,
  `simpanan_wajib` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `master_jenis_alergi` */

DROP TABLE IF EXISTS `master_jenis_alergi`;

CREATE TABLE `master_jenis_alergi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_alergi` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `master_jenis_barang` */

DROP TABLE IF EXISTS `master_jenis_barang`;

CREATE TABLE `master_jenis_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_barang` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Table structure for table `master_lokasi_ruangan` */

DROP TABLE IF EXISTS `master_lokasi_ruangan`;

CREATE TABLE `master_lokasi_ruangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruangan_id` int(11) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Table structure for table `master_nonmedis` */

DROP TABLE IF EXISTS `master_nonmedis`;

CREATE TABLE `master_nonmedis` (
  `kode_barang` varchar(11) NOT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `satuan` varchar(11) DEFAULT NULL,
  `jenis` varchar(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `master_produsen_inv` */

DROP TABLE IF EXISTS `master_produsen_inv`;

CREATE TABLE `master_produsen_inv` (
  `id_produsen` varchar(11) NOT NULL,
  `nama_produsen` varchar(50) DEFAULT NULL,
  `alamat_produsen` varchar(255) DEFAULT NULL,
  `pimpinan` varchar(50) DEFAULT NULL COMMENT 'Pimpinan  / PIC',
  `telp` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL COMMENT 'medis,non medis',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produsen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `master_ruangan` */

DROP TABLE IF EXISTS `master_ruangan`;

CREATE TABLE `master_ruangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruangan` varchar(50) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Table structure for table `master_telaah` */

DROP TABLE IF EXISTS `master_telaah`;

CREATE TABLE `master_telaah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uraian` varchar(255) DEFAULT NULL,
  `aspek_telaah` int(11) DEFAULT NULL,
  `perubahan_resep` int(11) DEFAULT NULL,
  `telaah_obat` int(11) DEFAULT NULL,
  `pelayanan_resep` int(11) DEFAULT NULL,
  `uraian_interaksi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Table structure for table `masterbidang` */

DROP TABLE IF EXISTS `masterbidang`;

CREATE TABLE `masterbidang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(24) DEFAULT NULL,
  `nama_bidang` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `masterdietpasien` */

DROP TABLE IF EXISTS `masterdietpasien`;

CREATE TABLE `masterdietpasien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_menu` varchar(30) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `energi_kkal` int(11) DEFAULT NULL,
  `protein_gr` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Table structure for table `mastergizis` */

DROP TABLE IF EXISTS `mastergizis`;

CREATE TABLE `mastergizis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gizi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `energi_kkal` int(11) DEFAULT NULL,
  `protein_gr` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `masterjabatan` */

DROP TABLE IF EXISTS `masterjabatan`;

CREATE TABLE `masterjabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_jabatan` varchar(25) DEFAULT NULL,
  `nama_jabatan` varchar(50) DEFAULT NULL,
  `tunjangan_jabatan` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `mastermapping` */

DROP TABLE IF EXISTS `mastermapping`;

CREATE TABLE `mastermapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mapping` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `mastermapping_biaya` */

DROP TABLE IF EXISTS `mastermapping_biaya`;

CREATE TABLE `mastermapping_biaya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategoritarif_id` int(11) DEFAULT NULL,
  `labsection_id` int(11) DEFAULT NULL,
  `tindakan_radiologi_id` int(11) DEFAULT NULL,
  `kelompok` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

/*Table structure for table `masterobats` */

DROP TABLE IF EXISTS `masterobats`;

CREATE TABLE `masterobats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuanjual_id` int(10) unsigned NOT NULL,
  `satuanbeli_id` int(10) unsigned NOT NULL,
  `kategoriobat_id` int(10) unsigned NOT NULL,
  `hargajual` int(11) NOT NULL,
  `hargajual_jkn` int(10) DEFAULT NULL,
  `hargabeli` int(11) NOT NULL,
  `stok` int(11) DEFAULT NULL,
  `dosis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `komposisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `jenis` enum('OBAT MINUM','OBAT LUAR','ALKES','INJEKSI','INFUS','DARAH','GIZI','REAGEN','SUSU') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `masterobats_satuanjual_id_foreign` (`satuanjual_id`),
  KEY `masterobats_satuanbeli_id_foreign` (`satuanbeli_id`),
  KEY `masterobats_kategoriobat_id_foreign` (`kategoriobat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2559 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `mastersplits` */

DROP TABLE IF EXISTS `mastersplits`;

CREATE TABLE `mastersplits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tahuntarif_id` int(10) unsigned NOT NULL,
  `kategoriheader_id` int(10) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mastersplits_tahuntarif_id_foreign` (`tahuntarif_id`),
  KEY `mastersplits_kategoriheader_id_foreign` (`kategoriheader_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `nomorrms` */

DROP TABLE IF EXISTS `nomorrms`;

CREATE TABLE `nomorrms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pasien_id` int(11) NOT NULL,
  `no_rm` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `obat_racikan` */

DROP TABLE IF EXISTS `obat_racikan`;

CREATE TABLE `obat_racikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `operasis` */

DROP TABLE IF EXISTS `operasis`;

CREATE TABLE `operasis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `rawatinap_id` int(11) NOT NULL,
  `no_rm` int(11) NOT NULL,
  `rencana_operasi` date NOT NULL,
  `jam_operasi` varchar(28) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suspect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ppi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  `suhu_tubuh` int(11) DEFAULT NULL,
  `tensi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tinggi` int(11) DEFAULT NULL,
  `berat` int(11) DEFAULT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemerikasaan_fisik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nadi` int(11) DEFAULT NULL,
  `respirasi` int(11) DEFAULT NULL,
  `GCS` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penilaian` text COLLATE utf8mb4_unicode_ci,
  `tindak_lanjut` text COLLATE utf8mb4_unicode_ci,
  `alergi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_operasi` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_bedah` int(11) DEFAULT NULL,
  `dokter_anastesi` int(11) DEFAULT NULL,
  `dokter_anak` int(11) DEFAULT NULL,
  `perawat_1` int(11) DEFAULT NULL,
  `perawat_2` int(11) DEFAULT NULL,
  `perawat_3` int(11) DEFAULT NULL,
  `perawat_4` int(11) DEFAULT NULL,
  `perawat_5` int(11) DEFAULT NULL,
  `operator` int(11) DEFAULT NULL,
  `operator2` int(11) DEFAULT NULL,
  `operator_single` int(11) DEFAULT NULL,
  `perawat_single` int(11) DEFAULT NULL,
  `diagnosa_awal` text COLLATE utf8mb4_unicode_ci,
  `jaringan_tubuh` text COLLATE utf8mb4_unicode_ci,
  `diagnosa_pasca_op` text COLLATE utf8mb4_unicode_ci,
  `tipe_anastesi` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemeriksaan_pa` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_operasi` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `laporan_operasi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `order_fisioterapi` */

DROP TABLE IF EXISTS `order_fisioterapi`;

CREATE TABLE `order_fisioterapi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `pemeriksaan` text,
  `user_id` int(11) DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `order_kamarbersalin` */

DROP TABLE IF EXISTS `order_kamarbersalin`;

CREATE TABLE `order_kamarbersalin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `pemeriksaan` text,
  `user_id` int(11) DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `order_lab` */

DROP TABLE IF EXISTS `order_lab`;

CREATE TABLE `order_lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `pemeriksaan` text,
  `user_id` int(11) DEFAULT NULL,
  `status_proses` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `order_radiologi` */

DROP TABLE IF EXISTS `order_radiologi`;

CREATE TABLE `order_radiologi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) DEFAULT NULL,
  `pemeriksaan` text,
  `user_id` int(11) DEFAULT NULL,
  `status_proses` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `pasiens` */

DROP TABLE IF EXISTS `pasiens`;

CREATE TABLE `pasiens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_rm` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm_lama` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmplahir` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` int(10) unsigned DEFAULT NULL,
  `regency_id` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `village_id` int(10) unsigned DEFAULT NULL,
  `nohp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notlp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negara` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_id` int(10) unsigned DEFAULT NULL,
  `agama_id` int(10) unsigned DEFAULT NULL,
  `perusahaan_id` int(10) unsigned DEFAULT NULL,
  `pendidikan_id` int(10) unsigned DEFAULT NULL,
  `nama_kk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_identitas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sktm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jaminan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sep` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_asal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_paket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ibu_kandung` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_marital` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_orangtua` int(11) DEFAULT NULL,
  `pasien_luar` int(11) DEFAULT NULL,
  `user_create` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_update` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggung_jawab` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur_penanggung_jawab` date DEFAULT NULL,
  `kelamin_penanggung_jawab` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_bukti_diri` int(20) DEFAULT NULL,
  `alamat_penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telp_penanggung_jawab` int(30) DEFAULT NULL,
  `jenis_tanda_pengenal` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hubungan_penanggung_jawab` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `asuransi` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_asuransi` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pasiens_no_rm_unique` (`no_rm`),
  KEY `pasiens_perusahaan_id_foreign` (`perusahaan_id`),
  KEY `pasiens_agama_id_foreign` (`agama_id`),
  KEY `pasiens_pekerjaan_id_foreign` (`pekerjaan_id`),
  KEY `pasiens_pendidikan_id_foreign` (`pendidikan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=174424 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pegawais` */

DROP TABLE IF EXISTS `pegawais`;

CREATE TABLE `pegawais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_pegawai` int(11) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `tmplahir` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masa_sip` date DEFAULT NULL,
  `str` varchar(161) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masa_str` date DEFAULT NULL,
  `kompetensi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tupoksi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_ktp_pegawai` int(11) DEFAULT NULL,
  `status_pegawai` int(11) DEFAULT NULL,
  `mulai_kerja` date DEFAULT NULL,
  `jabatan` int(11) DEFAULT NULL,
  `departemen` int(11) DEFAULT NULL,
  `status_gaji` int(11) DEFAULT NULL,
  `aktif` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pegawais_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pekerjaans` */

DROP TABLE IF EXISTS `pekerjaans`;

CREATE TABLE `pekerjaans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pemakaiandetails` */

DROP TABLE IF EXISTS `pemakaiandetails`;

CREATE TABLE `pemakaiandetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemakaian_id` int(10) unsigned NOT NULL,
  `masterobat_id` int(10) unsigned NOT NULL,
  `jumlah` int(10) NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hargajual` int(10) NOT NULL,
  `etiket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `tipe_rawat` enum('TA','TI','TG') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualandetails_penjualan_id_foreign` (`pemakaian_id`),
  KEY `penjualandetails_masterobat_id_foreign` (`masterobat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pemakaians` */

DROP TABLE IF EXISTS `pemakaians`;

CREATE TABLE `pemakaians` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penjualans_no_resep_unique` (`no_resep`),
  KEY `penjualans_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pembayarans` */

DROP TABLE IF EXISTS `pembayarans`;

CREATE TABLE `pembayarans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jenis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `total` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL,
  `flag` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int(10) unsigned NOT NULL,
  `dokter_id` int(10) unsigned NOT NULL,
  `diskon_persen` double(8,2) DEFAULT NULL,
  `diskon_rupiah` int(11) DEFAULT NULL,
  `no_kwitansi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_id` int(10) unsigned NOT NULL,
  `service_cash` int(11) DEFAULT NULL,
  `titipan` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hrs_bayar` int(11) DEFAULT NULL,
  `subsidi` int(11) DEFAULT NULL,
  `iur` int(11) DEFAULT NULL,
  `diskon_asuransi` int(11) DEFAULT NULL,
  `selisih_positif` int(11) DEFAULT NULL,
  `selisih_negatif` int(11) DEFAULT NULL,
  `tgl_apprv` date DEFAULT NULL,
  `user_apprv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reminder` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembulatan` int(11) DEFAULT NULL,
  `metode_bayar` enum('tunai','edc','transfer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edc_nomor_kartu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edc_nama_kartu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_no_bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayarans_user_id_foreign` (`user_id`),
  KEY `pembayarans_registrasi_id_foreign` (`registrasi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pendidikans` */

DROP TABLE IF EXISTS `pendidikans`;

CREATE TABLE `pendidikans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pendidikan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `penggajian` */

DROP TABLE IF EXISTS `penggajian`;

CREATE TABLE `penggajian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jabatan` int(11) DEFAULT NULL,
  `status_pegawai` int(11) DEFAULT NULL,
  `status_ktp_pegawai` int(11) DEFAULT NULL,
  `gaji_pokok` double DEFAULT NULL,
  `total_gaji` double DEFAULT NULL,
  `gaji_kontrak` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `penjualanbebas` */

DROP TABLE IF EXISTS `penjualanbebas`;

CREATE TABLE `penjualanbebas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_rm` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm_lama` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmplahir` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` int(10) unsigned DEFAULT NULL,
  `regency_id` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `village_id` int(10) unsigned DEFAULT NULL,
  `nohp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notlp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negara` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_id` int(10) unsigned DEFAULT NULL,
  `agama_id` int(10) unsigned DEFAULT NULL,
  `perusahaan_id` int(10) unsigned DEFAULT NULL,
  `pendidikan_id` int(10) unsigned DEFAULT NULL,
  `nama_kk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_identitas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sktm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jaminan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sep` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_asal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_paket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ibu_kandung` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `status_marital` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_orangtua` int(11) DEFAULT NULL,
  `user_create` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_update` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pasiens_no_rm_unique` (`no_rm`),
  KEY `pasiens_perusahaan_id_foreign` (`perusahaan_id`),
  KEY `pasiens_agama_id_foreign` (`agama_id`),
  KEY `pasiens_pekerjaan_id_foreign` (`pekerjaan_id`),
  KEY `pasiens_pendidikan_id_foreign` (`pendidikan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `penjualandetails` */

DROP TABLE IF EXISTS `penjualandetails`;

CREATE TABLE `penjualandetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_id` int(10) unsigned NOT NULL,
  `permintaan_masterobat_id` int(11) DEFAULT NULL,
  `masterobat_id` int(10) unsigned NOT NULL,
  `permintaan_jumlah` int(10) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `hargasatuan` int(11) DEFAULT NULL,
  `hargajual` int(11) NOT NULL,
  `aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konversi_aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan_aturanpakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_aturanpakai` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `tipe_rawat` enum('TA','TI','TG') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_racikan` int(1) DEFAULT NULL,
  `obat_racikan_id` int(11) DEFAULT NULL,
  `informasi1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_obat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_did` int(1) DEFAULT NULL,
  `retur` int(1) DEFAULT NULL,
  `retur_jumlah` int(11) DEFAULT NULL,
  `retur_bayar` int(1) DEFAULT NULL,
  `hapus` int(1) DEFAULT NULL,
  `alasan_hapus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualandetails_penjualan_id_foreign` (`penjualan_id`),
  KEY `penjualandetails_masterobat_id_foreign` (`masterobat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `penjualans` */

DROP TABLE IF EXISTS `penjualans`;

CREATE TABLE `penjualans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `apoteker` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `alergi` int(1) DEFAULT NULL,
  `keterangan_alergi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','proses','selesai') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_pasien_luar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `proses_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `selesai_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penjualans_no_resep_unique` (`no_resep`),
  KEY `penjualans_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `perawatan_icd10s` */

DROP TABLE IF EXISTS `perawatan_icd10s`;

CREATE TABLE `perawatan_icd10s` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icd10` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_diagnosa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int(10) unsigned NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `carabayar_id` int(10) unsigned NOT NULL,
  `jenis` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `perawatan_icd10s_registrasi_id_foreign` (`registrasi_id`),
  KEY `perawatan_icd10s_carabayar_id_foreign` (`carabayar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `perawatan_icd9s` */

DROP TABLE IF EXISTS `perawatan_icd9s`;

CREATE TABLE `perawatan_icd9s` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icd9` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int(10) unsigned NOT NULL,
  `carabayar_id` int(10) unsigned NOT NULL,
  `jenis` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perawatan_icd9s_registrasi_id_foreign` (`registrasi_id`),
  KEY `perawatan_icd9s_carabayar_id_foreign` (`carabayar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `permintaan_obat_details` */

DROP TABLE IF EXISTS `permintaan_obat_details`;

CREATE TABLE `permintaan_obat_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permintaan_id` int(10) unsigned NOT NULL,
  `permintaan_masterobat_id` int(11) DEFAULT NULL,
  `masterobat_id` int(10) unsigned NOT NULL,
  `permintaan_jumlah` int(10) DEFAULT NULL,
  `jumlah` int(10) NOT NULL,
  `hargajual` int(10) NOT NULL,
  `aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konversi_aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan_aturanpakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_aturanpakai` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `tipe_rawat` enum('TA','TI','TG') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_racikan` int(1) DEFAULT NULL,
  `obat_racikan_id` int(11) DEFAULT NULL,
  `informasi1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Diproses','Retur ke Apotek','Terima Retur','Diserahkan','Sudah Diminum Pasien') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_obat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retur` int(1) DEFAULT NULL,
  `alasan_hapus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retur_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terima_retur_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualandetails_penjualan_id_foreign` (`permintaan_id`),
  KEY `penjualandetails_masterobat_id_foreign` (`masterobat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `permintaan_obats` */

DROP TABLE IF EXISTS `permintaan_obats`;

CREATE TABLE `permintaan_obats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `apoteker` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `alergi` int(1) DEFAULT NULL,
  `keterangan_alergi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','proses','selesai') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `proses_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `selesai_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penjualans_no_resep_unique` (`no_resep`),
  KEY `penjualans_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `permission_user` */

DROP TABLE IF EXISTS `permission_user`;

CREATE TABLE `permission_user` (
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  KEY `permission_user_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `piutangs` */

DROP TABLE IF EXISTS `piutangs`;

CREATE TABLE `piutangs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` int(11) NOT NULL,
  `dibayar` int(11) DEFAULT NULL,
  `tglbayar` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `polis` */

DROP TABLE IF EXISTS `polis`;

CREATE TABLE `polis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `politype` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `bpjs` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instalasi_id` int(10) unsigned NOT NULL,
  `kamar_id` int(10) unsigned NOT NULL,
  `kuota` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT '20',
  `terisi` int(11) DEFAULT '0',
  `loket` int(11) DEFAULT NULL,
  `cetak_antrian` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `polis_instalasi_id_foreign` (`instalasi_id`),
  KEY `polis_kamar_id_foreign` (`kamar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `politypes` */

DROP TABLE IF EXISTS `politypes`;

CREATE TABLE `politypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `posisiberkas` */

DROP TABLE IF EXISTS `posisiberkas`;

CREATE TABLE `posisiberkas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `provinces` */

DROP TABLE IF EXISTS `provinces`;

CREATE TABLE `provinces` (
  `id` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `rawatinaps` */

DROP TABLE IF EXISTS `rawatinaps`;

CREATE TABLE `rawatinaps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `kelompokkelas_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `kamar_id` int(11) NOT NULL,
  `bed_id` int(11) NOT NULL,
  `dokter_id` int(10) DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `carabayar_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `ref_obat_all` */

DROP TABLE IF EXISTS `ref_obat_all`;

CREATE TABLE `ref_obat_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_obat` varchar(14) NOT NULL,
  `no_batch` varchar(50) DEFAULT NULL,
  `nomor_registrasi` varchar(50) DEFAULT NULL,
  `barcode` varchar(30) DEFAULT NULL,
  `kode_binfar` varchar(16) DEFAULT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `kekuatan` varchar(20) DEFAULT NULL,
  `nama_generik` text,
  `id_generik` varchar(12) DEFAULT NULL,
  `tipe_sediaan` varchar(50) DEFAULT NULL,
  `gol_obat` varchar(20) DEFAULT NULL,
  `detil_kemasan` varchar(50) DEFAULT NULL,
  `kemasan_unit` varchar(30) DEFAULT NULL,
  `komposisi` text CHARACTER SET latin5,
  `indikasi` varchar(255) DEFAULT NULL,
  `dosis` varchar(255) DEFAULT NULL,
  `konsep` varchar(255) DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `satuan_besar` varchar(255) DEFAULT NULL,
  `satuan_besar_unit` varchar(30) DEFAULT NULL,
  `satuanjual` varchar(255) DEFAULT NULL,
  `satuan_jual_unit` varchar(30) DEFAULT NULL,
  `satuan_klinis` varchar(30) DEFAULT NULL,
  `satuan_klinis_unit` varchar(30) DEFAULT NULL,
  `satuanbeli` int(11) DEFAULT NULL,
  `tgl_out` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `katagori_obat` varchar(50) DEFAULT NULL,
  `jenis_obat` varchar(30) DEFAULT NULL,
  `kategori_objek` varchar(10) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `stokmax` int(11) DEFAULT NULL,
  `stokmin` int(11) DEFAULT NULL,
  `hargajual` int(11) DEFAULT NULL,
  `hargajual_jkn` int(11) DEFAULT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `status_update` smallint(2) DEFAULT '0',
  `expired_date` date DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `aktif` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_obat`,`nama_obat`)
) ENGINE=InnoDB AUTO_INCREMENT=2559 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Table structure for table `ref_obat_gol` */

DROP TABLE IF EXISTS `ref_obat_gol`;

CREATE TABLE `ref_obat_gol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_golongan` varchar(56) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `ref_obatprogram` */

DROP TABLE IF EXISTS `ref_obatprogram`;

CREATE TABLE `ref_obatprogram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_program` varchar(150) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Table structure for table `regencies` */

DROP TABLE IF EXISTS `regencies`;

CREATE TABLE `regencies` (
  `id` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regencies_province_id_index` (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `regencys` */

DROP TABLE IF EXISTS `regencys`;

CREATE TABLE `regencys` (
  `id` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regencys_province_id_index` (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `registrasis` */

DROP TABLE IF EXISTS `registrasis`;

CREATE TABLE `registrasis` (
  `pasien_id` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reg_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pasien` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Baru','Lama') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rujukan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_reg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_ugd` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apotik_rawatinap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_rawat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_loket` int(11) DEFAULT NULL,
  `batal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_cetak_kartu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periksa_gratis` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masuk_apotik` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` int(10) unsigned DEFAULT NULL,
  `kartu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bayar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_layanan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sebabsakit_id` int(10) unsigned DEFAULT NULL,
  `tingkat_kegawatan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` int(10) unsigned DEFAULT NULL,
  `keluar_inap` date DEFAULT NULL,
  `diagnosa_inap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sep` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_jkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hak_kelas_inap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_naik_kelas` int(1) DEFAULT NULL,
  `tgl_rujukan` date DEFAULT NULL,
  `no_rujukan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ppk_rujukan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ppk_rujukan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa_awal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat_badan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tekanan_darah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sistolik` int(11) DEFAULT NULL,
  `diastolik` int(11) DEFAULT NULL,
  `respirasi` int(11) DEFAULT NULL,
  `tinggi` int(11) DEFAULT NULL,
  `suhu` int(11) DEFAULT NULL,
  `status_gizi` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_sep` date DEFAULT NULL,
  `poli_bpjs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifikasi_tindakan` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_mandiri` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_update` date DEFAULT NULL,
  `id_klinik_waktu_tunggu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operasi` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_akhir_pasien` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instalasi_id` int(10) unsigned DEFAULT NULL,
  `pulang` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radiologi` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_bersyarat` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_paket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pulang` datetime DEFAULT NULL,
  `cara_keluar_inap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keadaan_keluar_inap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keadaan_pasca_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asuransi_id` int(10) unsigned DEFAULT NULL,
  `user_create` int(10) unsigned NOT NULL,
  `antrian_id` int(10) unsigned DEFAULT NULL,
  `antrian_apotek_id` int(11) DEFAULT NULL,
  `rjtl` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepesertaan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pasien_text_dirujuk` longtext COLLATE utf8mb4_unicode_ci,
  `pasien_no_dirujuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pasien_tipe_dirujuk` int(1) DEFAULT NULL,
  `catatan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecelakaan` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lunas` enum('Y','N','P') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `posisiberkas_id` int(10) DEFAULT NULL,
  `antrian_poli` int(11) DEFAULT NULL,
  `tracer` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `verif_rj` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `verif_kasa` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `cetak_sep` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `cetak_barcode` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `cetak_rm` int(1) DEFAULT '0',
  `diagnosa_akhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemerikasaan_fisik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tingkat_keluhan_pasien` int(11) DEFAULT NULL,
  `anamnesis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posisi_pasien` enum('menunggu antrian','sedang diperiksa','menunggu persalinan','rawat inap','selesai diperiksa','antrian apotek','konfirmasi farmasi','selesai pembayaran','menunggu resep','selesai','pengembalian uang retur') COLLATE utf8mb4_unicode_ci DEFAULT 'menunggu antrian',
  `penjualan_bebas_apotek` int(11) DEFAULT NULL,
  `tanggal_kontrol` date DEFAULT NULL,
  `no_surat_kontrol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bayi` int(11) DEFAULT NULL,
  `bayi_sakit` int(11) DEFAULT NULL,
  `kehamilan_gpa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kasus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sebab_kematian` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_edit` int(1) DEFAULT NULL,
  `supervisor_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `supervisor_userid` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrasis_poli_id_foreign` (`poli_id`),
  KEY `registrasis_sebabsakit_id_foreign` (`sebabsakit_id`),
  KEY `registrasis_kelas_id_foreign` (`kelas_id`),
  KEY `registrasis_instalasi_id_foreign` (`instalasi_id`),
  KEY `registrasis_user_create_foreign` (`user_create`),
  KEY `registrasis_posisiberkas_id_foreign` (`posisiberkas_id`),
  KEY `registrasis_perusahaan_id_foreign` (`asuransi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `resep_klinik` */

DROP TABLE IF EXISTS `resep_klinik`;

CREATE TABLE `resep_klinik` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `alergi` int(1) DEFAULT NULL,
  `keterangan_alergi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `proses_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `selesai_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resep_klinik_no_resep_unique` (`no_resep`),
  KEY `resep_klinik_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `resep_klinik_detail` */

DROP TABLE IF EXISTS `resep_klinik_detail`;

CREATE TABLE `resep_klinik_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resep_klinik_id` int(10) unsigned NOT NULL,
  `permintaan_masterobat_id` int(11) DEFAULT NULL,
  `masterobat_id` int(10) unsigned NOT NULL,
  `permintaan_jumlah` int(10) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konversi_aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan_aturanpakai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_aturanpakai` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `tipe_rawat` enum('TA','TI','TG') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_racikan` int(1) DEFAULT NULL,
  `obat_racikan_id` int(11) DEFAULT NULL,
  `informasi1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_obat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hapus` int(1) DEFAULT NULL,
  `alasan_hapus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resep_klinik_detail_resep_klinik_id_foreign` (`resep_klinik_id`),
  KEY `resep_klinik_detail_masterobat_id_foreign` (`masterobat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `resep_telaahs` */

DROP TABLE IF EXISTS `resep_telaahs`;

CREATE TABLE `resep_telaahs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `telaah_id` int(11) DEFAULT NULL,
  `jawaban` text,
  `registrasi_id` int(11) DEFAULT NULL,
  `penjualan_id` int(11) DEFAULT NULL,
  `jenis` enum('epo','resep') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

/*Table structure for table `retur_log` */

DROP TABLE IF EXISTS `retur_log`;

CREATE TABLE `retur_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(45) DEFAULT NULL,
  `supplier` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tanggal_penerimaan` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `user_create` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `retur_log_detail` */

DROP TABLE IF EXISTS `retur_log_detail`;

CREATE TABLE `retur_log_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(45) DEFAULT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `kode_pemberian` varchar(45) DEFAULT NULL,
  `nama_pemberian` varchar(100) DEFAULT NULL,
  `jumlah_pemberian` varchar(255) DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `rincian_hasillabs` */

DROP TABLE IF EXISTS `rincian_hasillabs`;

CREATE TABLE `rincian_hasillabs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hasillab_id` int(10) unsigned DEFAULT NULL,
  `labsection_id` int(10) unsigned DEFAULT NULL,
  `tarif_id` int(11) DEFAULT NULL,
  `labkategori_id` int(10) unsigned DEFAULT NULL,
  `laboratoria_id` int(10) unsigned DEFAULT NULL,
  `hasil` double(11,2) DEFAULT NULL,
  `lh` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasiltext` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `cetak` int(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rincian_hasillabs_labkategori_id_foreign` (`labkategori_id`),
  KEY `rincian_hasillabs_laboratoria_id_foreign` (`laboratoria_id`),
  KEY `rincian_hasillabs_user_id_foreign` (`user_id`),
  KEY `rincian_hasillabs_hasillab_id_foreign` (`hasillab_id`),
  KEY `rincian_hasillabs_labsection_id_foreign` (`labsection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `rujukans` */

DROP TABLE IF EXISTS `rujukans`;

CREATE TABLE `rujukans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `satuan` */

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_satuan` varchar(50) DEFAULT NULL,
  `nama_satuan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Table structure for table `satuanbelis` */

DROP TABLE IF EXISTS `satuanbelis`;

CREATE TABLE `satuanbelis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `satuanjuals` */

DROP TABLE IF EXISTS `satuanjuals`;

CREATE TABLE `satuanjuals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `sebabsakits` */

DROP TABLE IF EXISTS `sebabsakits`;

CREATE TABLE `sebabsakits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `sif_user` */

DROP TABLE IF EXISTS `sif_user`;

CREATE TABLE `sif_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sif` varchar(10) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `slideshows` */

DROP TABLE IF EXISTS `slideshows`;

CREATE TABLE `slideshows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `splits` */

DROP TABLE IF EXISTS `splits`;

CREATE TABLE `splits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tahuntarif_id` int(10) unsigned NOT NULL,
  `kategoriheader_id` int(10) unsigned NOT NULL,
  `tarif_id` int(10) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `splits_tahuntarif_id_foreign` (`tahuntarif_id`),
  KEY `splits_kategoriheader_id_foreign` (`kategoriheader_id`),
  KEY `splits_tarif_id_foreign` (`tarif_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `status_ktp_pegawai` */

DROP TABLE IF EXISTS `status_ktp_pegawai`;

CREATE TABLE `status_ktp_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `tunjangan` int(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `status_pegawai` */

DROP TABLE IF EXISTS `status_pegawai`;

CREATE TABLE `status_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) DEFAULT NULL,
  `keterangan` varchar(20) DEFAULT NULL,
  `index_status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `statuses` */

DROP TABLE IF EXISTS `statuses`;

CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `supliyers` */

DROP TABLE IF EXISTS `supliyers`;

CREATE TABLE `supliyers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tlp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pimpinan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `tagihans` */

DROP TABLE IF EXISTS `tagihans`;

CREATE TABLE `tagihans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `diskon` int(11) DEFAULT NULL,
  `registrasi_id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `harus_dibayar` int(11) DEFAULT NULL,
  `subsidi` int(11) DEFAULT NULL,
  `dijamin` int(11) DEFAULT NULL,
  `selisih_positif` int(11) DEFAULT NULL,
  `selisih_negatif` int(11) DEFAULT NULL,
  `approval_tanggal` date NOT NULL,
  `user_approval` varchar(50) DEFAULT NULL,
  `pembulatan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tahuntarifs` */

DROP TABLE IF EXISTS `tahuntarifs`;

CREATE TABLE `tahuntarifs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `takaranobat_etikets` */

DROP TABLE IF EXISTS `takaranobat_etikets`;

CREATE TABLE `takaranobat_etikets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `tarifs` */

DROP TABLE IF EXISTS `tarifs`;

CREATE TABLE `tarifs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_rj` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_rd` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_ri` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_kelas_vip` int(10) DEFAULT NULL,
  `tarif_kelas_1` int(11) DEFAULT NULL,
  `tarif_kelas_2` int(11) DEFAULT NULL,
  `tarif_kelas_3` int(11) DEFAULT NULL,
  `tarif_kelas_rj` int(11) DEFAULT NULL,
  `kategoriheader_id` int(10) NOT NULL,
  `kategoritarif_id` int(10) unsigned NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahuntarif_id` int(10) unsigned NOT NULL,
  `mastermapping_id` int(11) DEFAULT NULL,
  `mapping_biaya_id` text COLLATE utf8mb4_unicode_ci,
  `mapping_pemeriksaan` enum('KS','PM','TN','') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `labsection_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tarif_tindakanpr` double DEFAULT NULL,
  `tarif_tindakandr` double DEFAULT NULL,
  `managemen` double DEFAULT NULL,
  `tarif_tindakandrpr` double DEFAULT NULL,
  `poli` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarifs_kategoritarif_id_foreign` (`kategoritarif_id`),
  KEY `tarifs_tahuntarif_id_foreign` (`tahuntarif_id`)
) ENGINE=InnoDB AUTO_INCREMENT=852 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `tb_detail_faktur` */

DROP TABLE IF EXISTS `tb_detail_faktur`;

CREATE TABLE `tb_detail_faktur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(30) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama_obj` varchar(255) DEFAULT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `jumlah_diterima` int(11) DEFAULT NULL,
  `selisih` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `no_batch` varchar(30) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `harga_jual` double DEFAULT NULL,
  `diskon_item_persen` int(11) DEFAULT NULL,
  `diskon_item_rupiah` int(11) DEFAULT NULL,
  `diskon_faktur_persen` int(11) DEFAULT NULL,
  `diskon_faktur_rupiah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_detail_lplpo` */

DROP TABLE IF EXISTS `tb_detail_lplpo`;

CREATE TABLE `tb_detail_lplpo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lplpo` int(11) DEFAULT NULL,
  `no_batch` varchar(255) DEFAULT NULL,
  `kode_obat` varchar(20) DEFAULT NULL,
  `nama_obj` varchar(255) DEFAULT NULL,
  `id_stok_pemberian` int(11) DEFAULT NULL,
  `kode_obat_pemberian` varchar(20) DEFAULT NULL,
  `nama_obj_pemberian` varchar(255) DEFAULT NULL,
  `stok_awal` int(11) DEFAULT NULL,
  `permintaan` int(11) DEFAULT '0',
  `pemberian` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_detail_purchase` */

DROP TABLE IF EXISTS `tb_detail_purchase`;

CREATE TABLE `tb_detail_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dpo_id` int(11) NOT NULL,
  `dpo_no_purchaseorder` varchar(255) DEFAULT NULL,
  `dpo_item_id` varchar(255) DEFAULT NULL,
  `dpo_item_name` varchar(255) DEFAULT NULL,
  `dpo_pbf` varchar(255) DEFAULT NULL,
  `dpo_price` int(20) DEFAULT NULL,
  `dpo_qty` int(11) DEFAULT NULL,
  `dpo_item_unit` varchar(255) DEFAULT NULL,
  `dpo_qty_item` int(11) DEFAULT NULL,
  `dpo_qty_unit` int(11) DEFAULT NULL,
  `dpo_conv_unit` varchar(255) DEFAULT NULL,
  `dpo_total_price` decimal(20,2) DEFAULT NULL,
  `dpo_diskon` decimal(20,2) DEFAULT NULL,
  `dpo_total_bayar` int(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_detail_retur` */

DROP TABLE IF EXISTS `tb_detail_retur`;

CREATE TABLE `tb_detail_retur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(100) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `nama_obj` varchar(50) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_detail_stok_opnam` */

DROP TABLE IF EXISTS `tb_detail_stok_opnam`;

CREATE TABLE `tb_detail_stok_opnam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_stok_opnam` varchar(50) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `stok_sebelum` int(11) DEFAULT NULL,
  `stok_sesudah` int(11) DEFAULT NULL,
  `selisih` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_lplpo` */

DROP TABLE IF EXISTS `tb_lplpo`;

CREATE TABLE `tb_lplpo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_po` varchar(255) DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `create_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_pelaksana_tarif` */

DROP TABLE IF EXISTS `tb_pelaksana_tarif`;

CREATE TABLE `tb_pelaksana_tarif` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pelaksana` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_penerimaan` */

DROP TABLE IF EXISTS `tb_penerimaan`;

CREATE TABLE `tb_penerimaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(30) DEFAULT NULL,
  `no_po` varchar(30) DEFAULT NULL,
  `no_batch` varchar(30) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_penerima` varchar(50) DEFAULT NULL,
  `supplier` varchar(250) DEFAULT NULL,
  `no_kontrak` varchar(150) DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_purchase` */

DROP TABLE IF EXISTS `tb_purchase`;

CREATE TABLE `tb_purchase` (
  `po_id` int(11) NOT NULL AUTO_INCREMENT,
  `po_no_purchaseorder` varchar(255) DEFAULT NULL,
  `po_nama_pemohon` varchar(255) DEFAULT NULL,
  `po_bagian` varchar(255) DEFAULT NULL,
  `po_tanggal_pemesanan` date DEFAULT NULL,
  `po_hargatotal` int(11) DEFAULT NULL,
  `po_diskon_fak` decimal(11,2) DEFAULT NULL,
  `po_diskon_item` decimal(11,2) DEFAULT NULL,
  `po_hargabayar` int(11) DEFAULT NULL,
  `po_catatan` text,
  `po_supplier` varchar(50) DEFAULT NULL,
  `po_kategori_order` varchar(50) DEFAULT NULL,
  `po_status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_retur` */

DROP TABLE IF EXISTS `tb_retur`;

CREATE TABLE `tb_retur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(50) DEFAULT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `supplier` varchar(50) DEFAULT NULL,
  `petugas` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `ket_retur` text,
  `sub_harga` int(11) DEFAULT NULL,
  `materai` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_stok_obat` */

DROP TABLE IF EXISTS `tb_stok_obat`;

CREATE TABLE `tb_stok_obat` (
  `id_stok` int(11) NOT NULL AUTO_INCREMENT,
  `id_faktur` int(11) DEFAULT NULL,
  `no_faktur` varchar(30) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `kode_obat` varchar(20) DEFAULT NULL,
  `nama_obj` varchar(255) DEFAULT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `kode_generik` varchar(10) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `satuanjual_id` int(10) DEFAULT NULL,
  `satuanbeli_id` int(10) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `harga_jual` double DEFAULT NULL,
  `sumber_dana` varchar(11) DEFAULT NULL,
  `no_batch` varchar(30) DEFAULT NULL,
  `flag` varchar(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_stok`)
) ENGINE=InnoDB AUTO_INCREMENT=19142 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_stok_obat_retur` */

DROP TABLE IF EXISTS `tb_stok_obat_retur`;

CREATE TABLE `tb_stok_obat_retur` (
  `id_stok` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(30) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `no_batch` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_stok`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_stok_opnam` */

DROP TABLE IF EXISTS `tb_stok_opnam`;

CREATE TABLE `tb_stok_opnam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_stok_opnam` varchar(20) DEFAULT NULL,
  `petugas` varchar(50) DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `tanggal_pelaksanaan` date DEFAULT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `catatan` text,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tindakan_operasi` */

DROP TABLE IF EXISTS `tindakan_operasi`;

CREATE TABLE `tindakan_operasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tindakan_operasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Table structure for table `tindakan_radiologi` */

DROP TABLE IF EXISTS `tindakan_radiologi`;

CREATE TABLE `tindakan_radiologi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tindakan_radiologi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `tipelayanans` */

DROP TABLE IF EXISTS `tipelayanans`;

CREATE TABLE `tipelayanans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipelayanan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `uang_muka` */

DROP TABLE IF EXISTS `uang_muka`;

CREATE TABLE `uang_muka` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(11) NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_cetak` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(56) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelompokkelas_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `villages` */

DROP TABLE IF EXISTS `villages`;

CREATE TABLE `villages` (
  `id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `district_id` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `villages_district_id_index` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `waktutunggus` */

DROP TABLE IF EXISTS `waktutunggus`;

CREATE TABLE `waktutunggus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registrasi_id` int(10) unsigned NOT NULL,
  `antrian_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `waktutunggus_registrasi_id_foreign` (`registrasi_id`),
  KEY `waktutunggus_antrian_id_foreign` (`antrian_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

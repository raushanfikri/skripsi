/*
SQLyog Enterprise - MySQL GUI v7.14 
MySQL - 5.5.5-10.1.32-MariaDB : Database - db_fikri
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_fikri` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_fikri`;

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(25) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `penerbit` varchar(75) NOT NULL,
  `isbn` char(35) NOT NULL,
  `halaman` char(11) NOT NULL,
  `file` varchar(75) NOT NULL,
  `keterangan` char(35) NOT NULL,
  `Date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_buku` (`nidn`),
  CONSTRAINT `FK_buku` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `buku` */

insert  into `buku`(`id`,`nidn`,`judul`,`penerbit`,`isbn`,`halaman`,`file`,`keterangan`,`Date`) values (7,'123','kita','lokal','192819298','90','Chapter_10_-_Report_Kwitansi2.pdf','Belum Disetujui',NULL),(9,'123','fgfa','672','tryu2','ew','293-553-1-SM1.pdf','Menunggu Verifikasi',NULL),(11,'15311579','lakdlak','klklk','lklkk','opop','3972-7607-1-PB.pdf','Disetujui','2019-07-24 06:58:30'),(12,'123','raushan','fikri','90999','90','Chapter_10_-_Report_Kwitansi3.pdf','','2019-07-24 18:27:12');

/*Table structure for table `buku_pkm` */

DROP TABLE IF EXISTS `buku_pkm`;

CREATE TABLE `buku_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(25) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `penerbit` varchar(75) NOT NULL,
  `isbn` char(35) NOT NULL,
  `halaman` char(11) NOT NULL,
  `file` varchar(75) NOT NULL,
  `keterangan` char(35) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `buku_pkm` */

insert  into `buku_pkm`(`id`,`nidn`,`judul`,`penerbit`,`isbn`,`halaman`,`file`,`keterangan`,`date`) values (2,'123','67','67','67','0','2016_Ankep_08_-_AHP.pdf','Disetujui',NULL),(3,'123','66','66','66','9','617-2163-1-PB1.pdf','Disetujui',NULL);

/*Table structure for table `dosen` */

DROP TABLE IF EXISTS `dosen`;

CREATE TABLE `dosen` (
  `nidn` char(12) NOT NULL,
  `nik` char(12) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `jurusan` varchar(75) DEFAULT NULL,
  `Fakultas` varchar(75) DEFAULT NULL,
  `level` varchar(35) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nidn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dosen` */

insert  into `dosen`(`nidn`,`nik`,`namadosen`,`jurusan`,`Fakultas`,`level`,`password`) values ('123','123','fikri','INFORMATIKA','FTIK','dosen','202cb962ac59075b964b07152d234b70'),('15311579','15311579','raushan fikri','INFORMATIKA','FTIK','dosen','202cb962ac59075b964b07152d234b70'),('admin','admin','Jono','SASTRA INGGRIS','FSIP','Admin','202cb962ac59075b964b07152d234b70');

/*Table structure for table `hki` */

DROP TABLE IF EXISTS `hki`;

CREATE TABLE `hki` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(35) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(75) NOT NULL,
  `nomorpendaftaran` char(35) NOT NULL,
  `status` char(34) NOT NULL,
  `nohki` char(45) NOT NULL,
  `file` varchar(255) NOT NULL,
  `keterangan` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `hki` */

insert  into `hki`(`id`,`nidn`,`judul`,`jenis`,`nomorpendaftaran`,`status`,`nohki`,`file`,`keterangan`,`date`) values (4,'123','7','7','7','7','7','617-2163-1-PB4.pdf','Belum Disetujui',NULL),(6,'123','lplp','lplp','lplp','lplplp','lplp','Chapter_8_-_Coding_Form_Master_Pelanggan_(Customer).pdf','','2019-07-24 17:42:57');

/*Table structure for table `hki_pkm` */

DROP TABLE IF EXISTS `hki_pkm`;

CREATE TABLE `hki_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(35) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(75) NOT NULL,
  `nomorpendaftaran` char(35) NOT NULL,
  `status` char(34) NOT NULL,
  `nohki` char(45) NOT NULL,
  `file` varchar(77) NOT NULL,
  `keterangan` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `hki_pkm` */

insert  into `hki_pkm`(`id`,`nidn`,`judul`,`jenis`,`nomorpendaftaran`,`status`,`nohki`,`file`,`keterangan`,`date`) values (1,'123','gdfgfd','321','1212121','Disetujui','dsadsadsa','617-2163-1-PB1.pdf','Disetujui',NULL),(2,'123','8','8','8','8','8','617-2163-1-PB.pdf','Belum Disetujui',NULL);

/*Table structure for table `jurnal` */

DROP TABLE IF EXISTS `jurnal`;

CREATE TABLE `jurnal` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(25) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `jurnal` */

insert  into `jurnal`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`,`date`) values (1,'123','4','4','4','4','4','4','4','4','4','4','617-2163-1-PB.pdf','Disetujui',NULL),(2,'123','seketika','internasional','juni','juli','jntti','9892291','90','90','10','www.tteetet.wqew','938-953-3-PB.pdf','Disetujui',NULL),(3,'123','restu ibu','nasional 1','kiki','koko','jntti','90099','100','90','80','wwww','2243-4534-1-PB.pdf','Disetujui',NULL),(4,'15311579','asdasd','lll','pppp','ooooo','lp','900','90','09','90','www.tteetet.wqew','181-176-1-PB2.pdf','Disetujui','2019-07-24 06:42:17');

/*Table structure for table `jurnal_pkm` */

DROP TABLE IF EXISTS `jurnal_pkm`;

CREATE TABLE `jurnal_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(25) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `jurnal_pkm` */

insert  into `jurnal_pkm`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`,`date`) values (1,'123','4','4','4','4','4','4','4','4','4','4','617-2163-1-PB.pdf','Disetujui',NULL);

/*Table structure for table `penelitian` */

DROP TABLE IF EXISTS `penelitian`;

CREATE TABLE `penelitian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nidn` char(12) DEFAULT NULL,
  `judul` varchar(75) DEFAULT NULL,
  `anggota_1` varchar(75) DEFAULT NULL,
  `anggota_2` varchar(75) DEFAULT NULL,
  `jenis` varchar(35) DEFAULT NULL,
  `bidang` varchar(45) DEFAULT NULL,
  `tm` varchar(45) DEFAULT NULL,
  `sumber` varchar(45) DEFAULT NULL,
  `institusi` varchar(45) DEFAULT NULL,
  `jumlah` char(15) DEFAULT NULL,
  `file` varbinary(55) DEFAULT NULL,
  `keterangan` varchar(64) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nidn` (`nidn`),
  CONSTRAINT `penelitian_ibfk_1` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `penelitian` */

insert  into `penelitian`(`id`,`nidn`,`judul`,`anggota_1`,`anggota_2`,`jenis`,`bidang`,`tm`,`sumber`,`institusi`,`jumlah`,`file`,`keterangan`,`date`) values (2,'123','qwer','qwertyu','ldsl','wert1','LKDLSKA','LDKALSKD','DSKDLS','FLSFLSL','KFJKJS','938-953-3-PB.pdf','Disetujui',NULL);

/*Table structure for table `penelitian_pkm` */

DROP TABLE IF EXISTS `penelitian_pkm`;

CREATE TABLE `penelitian_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `judul` varchar(75) NOT NULL,
  `nidn` char(12) NOT NULL,
  `anggota_1` varchar(75) DEFAULT NULL,
  `anggota_2` varchar(75) DEFAULT NULL,
  `jenis` varchar(35) NOT NULL,
  `bidang` varchar(45) NOT NULL,
  `tm` varchar(45) NOT NULL,
  `sumber` varchar(45) NOT NULL,
  `institusi` varchar(45) NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `file` varbinary(55) NOT NULL,
  `keterangan` varchar(64) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penelitian_pkm` */

/*Table structure for table `publikasiilmiah` */

DROP TABLE IF EXISTS `publikasiilmiah`;

CREATE TABLE `publikasiilmiah` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(15) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `institusi` varchar(45) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(75) NOT NULL,
  `file` varchar(155) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `publikasiilmiah` */

insert  into `publikasiilmiah`(`id`,`nidn`,`judul`,`institusi`,`tanggal`,`tempat`,`file`,`status`,`date`) values (5,'123','Oren','UTI','2019-07-20','kklklklkl1','617-2163-1-PB3.pdf','Disetujui',NULL),(7,'123',' lkdlksdlk','ielele','2019-07-24','lslsks','2238-4532-1-PB1.pdf','Belum Disetujui','2019-07-20 03:19:22'),(8,'15311579','hei','tekno1','2019-07-24','sini','189747-ID-analisis-dan-perancangan-sistem-informas.pdf','Disetujui','2019-07-24 06:30:00'),(33,'123','qwerty','uti','2019-07-01','uti','Chapter_1_-_Membuat_Database9.pdf','','2019-07-25 02:06:21');

/*Table structure for table `publikasiilmiah_pkm` */

DROP TABLE IF EXISTS `publikasiilmiah_pkm`;

CREATE TABLE `publikasiilmiah_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(15) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `institusi` varchar(45) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(75) NOT NULL,
  `file` varchar(155) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `publikasiilmiah_pkm` */

insert  into `publikasiilmiah_pkm`(`id`,`nidn`,`judul`,`institusi`,`tanggal`,`tempat`,`file`,`status`,`date`) values (8,'123','owpel','pworl','2019-07-10','3i4p4','882.pdf','Belum Disetujui',NULL),(9,'123','osl','2o32','2019-07-24','popq','2238-4532-1-PB.pdf','Belum Disetujui',NULL),(10,'123','hi','uti','2019-07-25','ioo','Chapter_4_-_Form_Transaksi.pdf','','2019-07-25 01:24:31');

/*Table structure for table `seminar` */

DROP TABLE IF EXISTS `seminar`;

CREATE TABLE `seminar` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(25) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `seminar` */

insert  into `seminar`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`,`date`) values (6,'123','2','266','2','2','2','2','2','2','44','2','617-2163-1-PB1.pdf','Disetujui',NULL),(7,'123','rttyui','lkaksdkasl1','LSKLA','ALSKL','SDKLSDKLAK','SLKDAL','sdsklkds','dakldkla','sdkalkd','sdkalskda','1193-1213-2-PB.pdf','Disetujui',NULL);

/*Table structure for table `seminar_pkm` */

DROP TABLE IF EXISTS `seminar_pkm`;

CREATE TABLE `seminar_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` char(25) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `seminar_pkm` */

insert  into `seminar_pkm`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`,`date`) values (2,'123','5','55','5','5','5','55','55k','5','5','5','617-2163-1-PB2.pdf','Disetujui',NULL);

/*Table structure for table `t_admin` */

DROP TABLE IF EXISTS `t_admin`;

CREATE TABLE `t_admin` (
  `iduser` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8 NOT NULL,
  `password` varchar(75) CHARACTER SET utf8 NOT NULL,
  `namauser` varchar(75) CHARACTER SET utf8 NOT NULL,
  `nip` varchar(25) NOT NULL,
  `level` enum('Super Admin','Admin','Pimpinan','Dosen') CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `t_admin` */

insert  into `t_admin`(`iduser`,`username`,`password`,`namauser`,`nip`,`level`) values (1,'admin','202cb962ac59075b964b07152d234b70','Admin','123','Super Admin'),(6,'123','202cb962ac59075b964b07152d234b70','fikt','123','Dosen'),(8,'234','289dff07669d7a23de0ef88d2f7129e7','rrwtw','234','Dosen'),(9,'15311579','3839cfc34db8d8a934def9fbd0f9b573','raushan fikri','15311579','Dosen'),(10,'15311159','bdef081118ce2f8546cc15ee86e827eb','dodol','15311159','Dosen'),(15,'0212108601','f43fd545028cb2b0254595157c5d5482','Heni Sulistiani','022130211','Dosen'),(16,'1234','81dc9bdb52d04dc20036dbd8313ed055','tea','1235','Dosen'),(17,'15311159','bdef081118ce2f8546cc15ee86e827eb','juli','15311159','Dosen'),(18,'15311159','bdef081118ce2f8546cc15ee86e827eb','juli','15311159','Dosen');

/*Table structure for table `tr_instansi` */

DROP TABLE IF EXISTS `tr_instansi`;

CREATE TABLE `tr_instansi` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `pimpinan` varchar(100) NOT NULL,
  `nrp_pimpinan` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tr_instansi` */

insert  into `tr_instansi`(`id`,`nama`,`alamat`,`pimpinan`,`nrp_pimpinan`,`logo`) values (1,'Universitas Teknokrat Indonesia','Disiplin, Bermutu, Kreatif dan Inovatif','Dr. Nasrulah Yusuf, S.E., M.BA.','123','UNIVERSITASTEKNOKRAT.png');

/* Procedure structure for procedure `Sp_Export` */

/*!50003 DROP PROCEDURE IF EXISTS  `Sp_Export` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Export`(`tabel` varchar (50) , `awal` VARCHAR (50) ,`akhir` VARCHAR (50))
BEGIN
	SELECT * from `tabel` where date BETWEEN awal and akhir;
    END */$$
DELIMITER ;

/*Table structure for table `v_buku` */

DROP TABLE IF EXISTS `v_buku`;

/*!50001 DROP VIEW IF EXISTS `v_buku` */;
/*!50001 DROP TABLE IF EXISTS `v_buku` */;

/*!50001 CREATE TABLE `v_buku` (
  `id` int(3) NOT NULL,
  `nidn` char(25) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `penerbit` varchar(75) NOT NULL,
  `isbn` char(35) NOT NULL,
  `halaman` char(11) NOT NULL,
  `file` varchar(75) NOT NULL,
  `keterangan` char(35) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_bukupkm` */

DROP TABLE IF EXISTS `v_bukupkm`;

/*!50001 DROP VIEW IF EXISTS `v_bukupkm` */;
/*!50001 DROP TABLE IF EXISTS `v_bukupkm` */;

/*!50001 CREATE TABLE `v_bukupkm` (
  `nidn` char(25) NOT NULL,
  `id` int(3) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `penerbit` varchar(75) NOT NULL,
  `isbn` char(35) NOT NULL,
  `halaman` char(11) NOT NULL,
  `file` varchar(75) NOT NULL,
  `keterangan` char(35) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_hki` */

DROP TABLE IF EXISTS `v_hki`;

/*!50001 DROP VIEW IF EXISTS `v_hki` */;
/*!50001 DROP TABLE IF EXISTS `v_hki` */;

/*!50001 CREATE TABLE `v_hki` (
  `nidn` char(35) NOT NULL,
  `id` int(3) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(75) NOT NULL,
  `nomorpendaftaran` char(35) NOT NULL,
  `status` char(34) NOT NULL,
  `nohki` char(45) NOT NULL,
  `file` varchar(255) NOT NULL,
  `keterangan` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_hkipkm` */

DROP TABLE IF EXISTS `v_hkipkm`;

/*!50001 DROP VIEW IF EXISTS `v_hkipkm` */;
/*!50001 DROP TABLE IF EXISTS `v_hkipkm` */;

/*!50001 CREATE TABLE `v_hkipkm` (
  `nidn` char(35) NOT NULL,
  `id` int(3) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(75) NOT NULL,
  `nomorpendaftaran` char(35) NOT NULL,
  `status` char(34) NOT NULL,
  `nohki` char(45) NOT NULL,
  `file` varchar(77) NOT NULL,
  `keterangan` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_jurnal` */

DROP TABLE IF EXISTS `v_jurnal`;

/*!50001 DROP VIEW IF EXISTS `v_jurnal` */;
/*!50001 DROP TABLE IF EXISTS `v_jurnal` */;

/*!50001 CREATE TABLE `v_jurnal` (
  `id` int(3) NOT NULL,
  `nidn` char(25) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_jurnalpkm` */

DROP TABLE IF EXISTS `v_jurnalpkm`;

/*!50001 DROP VIEW IF EXISTS `v_jurnalpkm` */;
/*!50001 DROP TABLE IF EXISTS `v_jurnalpkm` */;

/*!50001 CREATE TABLE `v_jurnalpkm` (
  `nidn` char(25) NOT NULL,
  `id` int(3) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_penelitian` */

DROP TABLE IF EXISTS `v_penelitian`;

/*!50001 DROP VIEW IF EXISTS `v_penelitian` */;
/*!50001 DROP TABLE IF EXISTS `v_penelitian` */;

/*!50001 CREATE TABLE `v_penelitian` (
  `nidn` char(12) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) DEFAULT NULL,
  `anggota_1` varchar(75) DEFAULT NULL,
  `anggota_2` varchar(75) DEFAULT NULL,
  `jenis` varchar(35) DEFAULT NULL,
  `bidang` varchar(45) DEFAULT NULL,
  `tm` varchar(45) DEFAULT NULL,
  `sumber` varchar(45) DEFAULT NULL,
  `institusi` varchar(45) DEFAULT NULL,
  `jumlah` char(15) DEFAULT NULL,
  `file` varbinary(55) DEFAULT NULL,
  `keterangan` varchar(64) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_publikasi` */

DROP TABLE IF EXISTS `v_publikasi`;

/*!50001 DROP VIEW IF EXISTS `v_publikasi` */;
/*!50001 DROP TABLE IF EXISTS `v_publikasi` */;

/*!50001 CREATE TABLE `v_publikasi` (
  `id` int(3) NOT NULL,
  `nidn` char(15) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `institusi` varchar(45) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(75) NOT NULL,
  `file` varchar(155) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_publikasipkm` */

DROP TABLE IF EXISTS `v_publikasipkm`;

/*!50001 DROP VIEW IF EXISTS `v_publikasipkm` */;
/*!50001 DROP TABLE IF EXISTS `v_publikasipkm` */;

/*!50001 CREATE TABLE `v_publikasipkm` (
  `id` int(3) NOT NULL,
  `nidn` char(15) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `institusi` varchar(45) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(75) NOT NULL,
  `file` varchar(155) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_seminar` */

DROP TABLE IF EXISTS `v_seminar`;

/*!50001 DROP VIEW IF EXISTS `v_seminar` */;
/*!50001 DROP TABLE IF EXISTS `v_seminar` */;

/*!50001 CREATE TABLE `v_seminar` (
  `id` int(3) NOT NULL,
  `nidn` char(25) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*Table structure for table `v_seminarpkm` */

DROP TABLE IF EXISTS `v_seminarpkm`;

/*!50001 DROP VIEW IF EXISTS `v_seminarpkm` */;
/*!50001 DROP TABLE IF EXISTS `v_seminarpkm` */;

/*!50001 CREATE TABLE `v_seminarpkm` (
  `id` int(3) NOT NULL,
  `nidn` char(25) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `jenis` varchar(45) NOT NULL,
  `penulis_2` varchar(75) DEFAULT NULL,
  `penulis_3` varchar(75) DEFAULT NULL,
  `jurnal` varchar(34) NOT NULL,
  `issn` varchar(45) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `no` varchar(25) NOT NULL,
  `halaman` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 */;

/*View structure for view v_buku */

/*!50001 DROP TABLE IF EXISTS `v_buku` */;
/*!50001 DROP VIEW IF EXISTS `v_buku` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_buku` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`penerbit` AS `penerbit`,`p`.`isbn` AS `isbn`,`p`.`halaman` AS `halaman`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`Date` AS `date` from (`buku` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_bukupkm */

/*!50001 DROP TABLE IF EXISTS `v_bukupkm` */;
/*!50001 DROP VIEW IF EXISTS `v_bukupkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_bukupkm` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`penerbit` AS `penerbit`,`p`.`isbn` AS `isbn`,`p`.`halaman` AS `halaman`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`buku_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_hki */

/*!50001 DROP TABLE IF EXISTS `v_hki` */;
/*!50001 DROP VIEW IF EXISTS `v_hki` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hki` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`nomorpendaftaran` AS `nomorpendaftaran`,`p`.`status` AS `status`,`p`.`nohki` AS `nohki`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`hki` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_hkipkm */

/*!50001 DROP TABLE IF EXISTS `v_hkipkm` */;
/*!50001 DROP VIEW IF EXISTS `v_hkipkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hkipkm` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`nomorpendaftaran` AS `nomorpendaftaran`,`p`.`status` AS `status`,`p`.`nohki` AS `nohki`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`hki_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_jurnal */

/*!50001 DROP TABLE IF EXISTS `v_jurnal` */;
/*!50001 DROP VIEW IF EXISTS `v_jurnal` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jurnal` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`penulis_2` AS `penulis_2`,`p`.`penulis_3` AS `penulis_3`,`p`.`jurnal` AS `jurnal`,`p`.`issn` AS `issn`,`p`.`volume` AS `volume`,`p`.`no` AS `no`,`p`.`halaman` AS `halaman`,`p`.`url` AS `url`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`jurnal` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_jurnalpkm */

/*!50001 DROP TABLE IF EXISTS `v_jurnalpkm` */;
/*!50001 DROP VIEW IF EXISTS `v_jurnalpkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jurnalpkm` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`penulis_2` AS `penulis_2`,`p`.`penulis_3` AS `penulis_3`,`p`.`jurnal` AS `jurnal`,`p`.`issn` AS `issn`,`p`.`volume` AS `volume`,`p`.`no` AS `no`,`p`.`halaman` AS `halaman`,`p`.`url` AS `url`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan` from (`jurnal_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_penelitian */

/*!50001 DROP TABLE IF EXISTS `v_penelitian` */;
/*!50001 DROP VIEW IF EXISTS `v_penelitian` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penelitian` AS select `penelitian`.`nidn` AS `nidn`,`penelitian`.`id` AS `id`,`dosen`.`namadosen` AS `namadosen`,`penelitian`.`judul` AS `judul`,`penelitian`.`anggota_1` AS `anggota_1`,`penelitian`.`anggota_2` AS `anggota_2`,`penelitian`.`jenis` AS `jenis`,`penelitian`.`bidang` AS `bidang`,`penelitian`.`tm` AS `tm`,`penelitian`.`sumber` AS `sumber`,`penelitian`.`institusi` AS `institusi`,`penelitian`.`jumlah` AS `jumlah`,`penelitian`.`file` AS `file`,`penelitian`.`keterangan` AS `keterangan`,`penelitian`.`date` AS `date` from (`penelitian` join `dosen`) where (`penelitian`.`nidn` = `dosen`.`nidn`) */;

/*View structure for view v_publikasi */

/*!50001 DROP TABLE IF EXISTS `v_publikasi` */;
/*!50001 DROP VIEW IF EXISTS `v_publikasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_publikasi` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`institusi` AS `institusi`,`p`.`tanggal` AS `tanggal`,`p`.`tempat` AS `tempat`,`p`.`file` AS `file`,`p`.`status` AS `status`,`p`.`date` AS `date` from (`publikasiilmiah` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_publikasipkm */

/*!50001 DROP TABLE IF EXISTS `v_publikasipkm` */;
/*!50001 DROP VIEW IF EXISTS `v_publikasipkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_publikasipkm` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`institusi` AS `institusi`,`p`.`tanggal` AS `tanggal`,`p`.`tempat` AS `tempat`,`p`.`file` AS `file`,`p`.`status` AS `status`,`p`.`date` AS `date` from (`publikasiilmiah_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_seminar */

/*!50001 DROP TABLE IF EXISTS `v_seminar` */;
/*!50001 DROP VIEW IF EXISTS `v_seminar` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_seminar` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`penulis_2` AS `penulis_2`,`p`.`penulis_3` AS `penulis_3`,`p`.`jurnal` AS `jurnal`,`p`.`issn` AS `issn`,`p`.`volume` AS `volume`,`p`.`no` AS `no`,`p`.`halaman` AS `halaman`,`p`.`url` AS `url`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`seminar` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_seminarpkm */

/*!50001 DROP TABLE IF EXISTS `v_seminarpkm` */;
/*!50001 DROP VIEW IF EXISTS `v_seminarpkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_seminarpkm` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`penulis_2` AS `penulis_2`,`p`.`penulis_3` AS `penulis_3`,`p`.`jurnal` AS `jurnal`,`p`.`issn` AS `issn`,`p`.`volume` AS `volume`,`p`.`no` AS `no`,`p`.`halaman` AS `halaman`,`p`.`url` AS `url`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`seminar_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

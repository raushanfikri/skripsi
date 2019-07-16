/*
SQLyog Enterprise - MySQL GUI v7.14 
MySQL - 5.5.36 : Database - db_fikri
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `buku` */

insert  into `buku`(`id`,`nidn`,`judul`,`penerbit`,`isbn`,`halaman`,`file`,`keterangan`) values (2,'123','67','67','67','0','2016_Ankep_08_-_AHP.pdf','Disetujui'),(3,'123','66','66','66','','617-2163-1-PB1.pdf','Disetujui'),(5,'123','1','','','1','617-2163-1-PB3.pdf','Menunggu Verifikasi');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `buku_pkm` */

insert  into `buku_pkm`(`id`,`nidn`,`judul`,`penerbit`,`isbn`,`halaman`,`file`,`keterangan`) values (2,'123','67','67','67','0','2016_Ankep_08_-_AHP.pdf','Disetujui'),(3,'123','66','66','66','','617-2163-1-PB1.pdf','Disetujui'),(4,'123','777','777','7777','7777','617-2163-1-PB.pdf','Disetujui');

/*Table structure for table `dosen` */

DROP TABLE IF EXISTS `dosen`;

CREATE TABLE `dosen` (
  `nidn` char(12) NOT NULL,
  `nik` char(12) NOT NULL,
  `namadosen` varchar(45) NOT NULL,
  `jurusan` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`nidn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dosen` */

insert  into `dosen`(`nidn`,`nik`,`namadosen`,`jurusan`) values ('123','123','fikt','INFORMATIKA');

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
  `file` varchar(77) NOT NULL,
  `keterangan` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `hki` */

insert  into `hki`(`id`,`nidn`,`judul`,`jenis`,`nomorpendaftaran`,`status`,`nohki`,`file`,`keterangan`) values (1,'123','gdfgfd','321','1212121','Disetujui','dsadsadsa','617-2163-1-PB1.pdf','Disetujui'),(3,'123','gdfgfd','ERWRWR','1212121','dsadsa','dsadsadsa','617-2163-1-PB3.pdf','Menunggu Verifikasi'),(4,'123','7','7','7','7','7','617-2163-1-PB4.pdf','Menunggu Verifikasi');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `hki_pkm` */

insert  into `hki_pkm`(`id`,`nidn`,`judul`,`jenis`,`nomorpendaftaran`,`status`,`nohki`,`file`,`keterangan`) values (1,'123','gdfgfd','321','1212121','Disetujui','dsadsadsa','617-2163-1-PB1.pdf','Disetujui'),(2,'123','8','8','8','8','8','617-2163-1-PB.pdf','Disetujui');

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
  `file` varchar(75) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `jurnal` */

insert  into `jurnal`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`) values (1,'123','4','4','4','4','4','4','4','4','4','4','617-2163-1-PB.pdf','Disetujui');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `jurnal_pkm` */

insert  into `jurnal_pkm`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`) values (1,'123','4','4','4','4','4','4','4','4','4','4','617-2163-1-PB.pdf','Disetujui'),(3,'123','9','9','9','9','9','9','9','9','99','9','617-2163-1-PB1.pdf','Disetujui');

/*Table structure for table `penelitian` */

DROP TABLE IF EXISTS `penelitian`;

CREATE TABLE `penelitian` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `judul` varchar(75) NOT NULL,
  `nidn` char(15) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `penelitian` */

insert  into `penelitian`(`id`,`judul`,`nidn`,`anggota_1`,`anggota_2`,`jenis`,`bidang`,`tm`,`sumber`,`institusi`,`jumlah`,`file`,`keterangan`) values (1,'123','9','','','9','9','9','9','9','9','617-2163-1-PB3.pdf','Disetujui'),(2,'123','6','','','6','6','6','6','66','6','617-2163-1-PB4.pdf','Disetujui');

/*Table structure for table `penelitian_pkm` */

DROP TABLE IF EXISTS `penelitian_pkm`;

CREATE TABLE `penelitian_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `judul` varchar(75) NOT NULL,
  `nidn` char(15) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `penelitian_pkm` */

insert  into `penelitian_pkm`(`id`,`judul`,`nidn`,`anggota_1`,`anggota_2`,`jenis`,`bidang`,`tm`,`sumber`,`institusi`,`jumlah`,`file`,`keterangan`) values (4,'123','3','','','3','3','3','3','3','3','','Disetujui');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `publikasiilmiah` */

insert  into `publikasiilmiah`(`id`,`nidn`,`judul`,`institusi`,`tanggal`,`tempat`,`file`,`status`) values (3,'123','gdfgfd','fgdgdfg','2019-03-28','gfdgdfgd','617-2163-1-PB1.pdf','Disetujui'),(4,'123','r','r','2019-03-28','a','2016_Ankep_08_-_AHP.pdf','Disetujui'),(5,'123','6546','7','0000-00-00','','617-2163-1-PB3.pdf','Menunggu Verifikasi');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `publikasiilmiah_pkm` */

insert  into `publikasiilmiah_pkm`(`id`,`nidn`,`judul`,`institusi`,`tanggal`,`tempat`,`file`,`status`) values (6,'123','fgfhgf','hfhgfhf','2019-03-28','a','617-2163-1-PB3.pdf','Disetujui'),(7,'123','gdfgfd','fgdgdfg','2019-03-28','gfdgdfgd','617-2163-1-PB4.pdf','Disetujui');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `seminar` */

insert  into `seminar`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`) values (5,'123','1','1','1','1','1','1','1','1','1','1','617-2163-1-PB.pdf','Disetujui'),(6,'123','2','2','2','2','2','2','2','2','2','2','617-2163-1-PB1.pdf','Disetujui');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `seminar_pkm` */

insert  into `seminar_pkm`(`id`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`) values (1,'123','4','4','4','4','4','4','4','4','4','4','617-2163-1-PB.pdf','Disetujui'),(2,'123','5','5','5','5','5','55','55','5','5','5','617-2163-1-PB2.pdf','Disetujui');

/*Table structure for table `t_admin` */

DROP TABLE IF EXISTS `t_admin`;

CREATE TABLE `t_admin` (
  `iduser` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8 NOT NULL,
  `password` varchar(75) CHARACTER SET utf8 NOT NULL,
  `namauser` varchar(75) CHARACTER SET utf8 NOT NULL,
  `nip` varchar(25) CHARACTER SET utf8 NOT NULL,
  `level` enum('Super Admin','Admin','Pimpinan','Dosen') CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `t_admin` */

insert  into `t_admin`(`iduser`,`username`,`password`,`namauser`,`nip`,`level`) values (1,'admin','202cb962ac59075b964b07152d234b70','Admin','123','Super Admin'),(6,'123','202cb962ac59075b964b07152d234b70','fikt','123','Dosen');

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

insert  into `tr_instansi`(`id`,`nama`,`alamat`,`pimpinan`,`nrp_pimpinan`,`logo`) values (1,'Universitas Teknokrat Indonesia','Jalan Z.A. Pagar Alam No. 9-11 Kedaton Bandar Lampung','Dr. Nasrulah Yusuf, S.E., M.BA.','123','logo.jpg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

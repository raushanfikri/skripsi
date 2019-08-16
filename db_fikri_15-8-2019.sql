/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.25-MariaDB : Database - db_fikri
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_fikri` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_fikri`;

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `isbn` char(255) NOT NULL,
  `halaman` char(11) NOT NULL,
  `file` text NOT NULL,
  `keterangan` text NOT NULL,
  `Date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_buku` (`nidn`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `buku` */

insert  into `buku`(`id`,`idpenelitian`,`nidn`,`judul`,`penerbit`,`isbn`,`halaman`,`file`,`keterangan`,`Date`) values (7,2,'123','kita','lokal','192819298','90','Chapter_10_-_Report_Kwitansi2.pdf','Belum Disetujui',NULL),(9,NULL,'123','fgfa','672','tryu2','ew','293-553-1-SM1.pdf','Menunggu Verifikasi',NULL),(11,NULL,'15311579','lakdlak','klklk','lklkk','opop','3972-7607-1-PB.pdf','Disetujui','2019-07-24 06:58:30'),(12,NULL,'123','raushan','fikri','90999','90','Chapter_10_-_Report_Kwitansi3.pdf','','2019-07-24 18:27:12');

/*Table structure for table `buku_pkm` */

DROP TABLE IF EXISTS `buku_pkm`;

CREATE TABLE `buku_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `halaman` varchar(255) NOT NULL,
  `file` text NOT NULL,
  `keterangan` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `buku_pkm` */

insert  into `buku_pkm`(`id`,`idpenelitian`,`nidn`,`judul`,`penerbit`,`isbn`,`halaman`,`file`,`keterangan`,`date`) values (2,NULL,'123','67','67','67','0','2016_Ankep_08_-_AHP.pdf','Disetujui',NULL),(3,NULL,'123','66','66','66','9','617-2163-1-PB1.pdf','Disetujui',NULL);

/*Table structure for table `detail_anggotapenelitian` */

DROP TABLE IF EXISTS `detail_anggotapenelitian`;

CREATE TABLE `detail_anggotapenelitian` (
  `idpenelitian` int(11) NOT NULL AUTO_INCREMENT,
  `nidn` varchar(12) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  KEY `id` (`idpenelitian`),
  KEY `detail_anggotapenelitian_ibfk_2` (`nidn`),
  CONSTRAINT `detail_anggotapenelitian_ibfk_1` FOREIGN KEY (`idpenelitian`) REFERENCES `penelitian` (`idpenelitian`) ON DELETE CASCADE,
  CONSTRAINT `detail_anggotapenelitian_ibfk_2` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `detail_anggotapenelitian` */

insert  into `detail_anggotapenelitian`(`idpenelitian`,`nidn`,`ket`) values (2,'123','ketua'),(3,'15311579','ketua'),(3,'123','anggota'),(4,'123','ketua'),(4,'15311579','anggota'),(5,'15311579','ketua'),(6,'123','ketua');

/*Table structure for table `dosen` */

DROP TABLE IF EXISTS `dosen`;

CREATE TABLE `dosen` (
  `nidn` varchar(12) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `namadosen` varchar(255) NOT NULL,
  `level` varchar(35) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `kodejurusan` char(5) DEFAULT NULL,
  PRIMARY KEY (`nidn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dosen` */

insert  into `dosen`(`nidn`,`nik`,`namadosen`,`level`,`password`,`kodejurusan`) values ('123','123','fikri','dosen','202cb962ac59075b964b07152d234b70','KJ10'),('15311579','15311579','raushan fikri','dosen','202cb962ac59075b964b07152d234b70','KJ2'),('admin','admin','Jono','admin','202cb962ac59075b964b07152d234b70','KJ10');

/*Table structure for table `fakultas` */

DROP TABLE IF EXISTS `fakultas`;

CREATE TABLE `fakultas` (
  `kodefakultas` char(5) NOT NULL,
  `namafakultas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kodefakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fakultas` */

insert  into `fakultas`(`kodefakultas`,`namafakultas`) values ('F001','FTIK'),('F002','FSIP'),('F003','FEB');

/*Table structure for table `hki` */

DROP TABLE IF EXISTS `hki`;

CREATE TABLE `hki` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `jenis` text NOT NULL,
  `nomorpendaftaran` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `nohki` varchar(255) NOT NULL,
  `file` text NOT NULL,
  `keterangan` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `hki` */

/*Table structure for table `hki_pkm` */

DROP TABLE IF EXISTS `hki_pkm`;

CREATE TABLE `hki_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `jenis` text NOT NULL,
  `nomorpendaftaran` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `nohki` varchar(255) NOT NULL,
  `file` text NOT NULL,
  `keterangan` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `hki_pkm` */

insert  into `hki_pkm`(`id`,`idpenelitian`,`nidn`,`judul`,`jenis`,`nomorpendaftaran`,`status`,`nohki`,`file`,`keterangan`,`date`) values (1,NULL,'123','gdfgfd','321','1212121','Disetujui','dsadsadsa','617-2163-1-PB1.pdf','Disetujui',NULL),(2,NULL,'123','8','8','8','8','8','617-2163-1-PB.pdf','Belum Disetujui',NULL);

/*Table structure for table `jurnal` */

DROP TABLE IF EXISTS `jurnal`;

CREATE TABLE `jurnal` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text,
  `namajurnal` text,
  `jenis` text,
  `peranpenulis` varchar(255) DEFAULT NULL,
  `tahun` char(6) DEFAULT NULL,
  `volume` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `url` text,
  `issn` varchar(255) DEFAULT NULL,
  `file` text,
  `keterangan` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `jurnal` */

insert  into `jurnal`(`id`,`idpenelitian`,`nidn`,`judul`,`namajurnal`,`jenis`,`peranpenulis`,`tahun`,`volume`,`no`,`url`,`issn`,`file`,`keterangan`,`date`) values (1,2,'123','4','hahahaha','4','4','2012','4','4','4','p000999','617-2163-1-PB.pdf','Disetujui',NULL),(2,NULL,'123','seketika',NULL,'internasional','jntti',NULL,'90','90','www.tteetet.wqew',NULL,'938-953-3-PB.pdf','Disetujui',NULL),(3,NULL,'123','restu ibu',NULL,'nasional 1','jntti',NULL,'100','90','wwww',NULL,'2243-4534-1-PB.pdf','Disetujui',NULL),(4,NULL,'15311579','asdasd',NULL,'lll','lp',NULL,'90','09','www.tteetet.wqew',NULL,'181-176-1-PB2.pdf','Disetujui','2019-07-24 06:42:17');

/*Table structure for table `jurnal_pkm` */

DROP TABLE IF EXISTS `jurnal_pkm`;

CREATE TABLE `jurnal_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `penulis_2` varchar(255) DEFAULT NULL,
  `penulis_3` varchar(255) DEFAULT NULL,
  `jurnal` varchar(255) NOT NULL,
  `issn` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `no` varchar(255) NOT NULL,
  `halaman` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `file` text,
  `keterangan` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `jurnal_pkm` */

insert  into `jurnal_pkm`(`id`,`idpenelitian`,`nidn`,`judul`,`jenis`,`penulis_2`,`penulis_3`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`,`date`) values (1,NULL,'123','4','4','4','4','4','4','4','4','4','4','617-2163-1-PB.pdf','Disetujui',NULL);

/*Table structure for table `jurusan` */

DROP TABLE IF EXISTS `jurusan`;

CREATE TABLE `jurusan` (
  `kodejurusan` char(5) NOT NULL,
  `namajurusan` varchar(255) DEFAULT NULL,
  `kodefakultas` char(5) DEFAULT NULL,
  PRIMARY KEY (`kodejurusan`),
  KEY `kodefakultas` (`kodefakultas`),
  CONSTRAINT `jurusan_ibfk_1` FOREIGN KEY (`kodefakultas`) REFERENCES `fakultas` (`kodefakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jurusan` */

insert  into `jurusan`(`kodejurusan`,`namajurusan`,`kodefakultas`) values ('KJ1','Sistem Informasi','F001'),('KJ10','Pendidikan Bahasa Inggris','F001'),('KJ11','Pendidikan Olahraga','F002'),('KJ12','Akuntansi','F003'),('KJ13','Manajemen','F003'),('KJ2','Informatika','F001'),('KJ3','Sistem Informasi Akuntansi','F001'),('KJ4','Teknologi Informasi','F001'),('KJ5','Teknik Komputer','F001'),('KJ6','Teknik Sipil','F001'),('KJ7','Teknik Elektro','F001'),('KJ8','Sastra Inggris','F002'),('KJ9','Pendidikan Matematika','F002');

/*Table structure for table `penelitian` */

DROP TABLE IF EXISTS `penelitian`;

CREATE TABLE `penelitian` (
  `idpenelitian` int(11) NOT NULL AUTO_INCREMENT,
  `judulpenelitian` text,
  `jenis` text,
  `bidang` varchar(255) DEFAULT NULL,
  `tse` varchar(255) DEFAULT NULL,
  `sumber` varchar(255) DEFAULT NULL,
  `institusi` varchar(255) DEFAULT NULL,
  `jumlah` char(15) DEFAULT NULL,
  `file` text,
  `keterangan` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idpenelitian`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `penelitian` */

insert  into `penelitian`(`idpenelitian`,`judulpenelitian`,`jenis`,`bidang`,`tse`,`sumber`,`institusi`,`jumlah`,`file`,`keterangan`,`date`) values (2,'qwerty','wert1','LKDLSKA','LDKALSKD','DSKDLS','FLSFLSL','KFJKJS','938-953-3-PB.pdf','Menunggu Verifikasi',NULL),(3,'909','90','90','990','90','9090','0','jpmanajemendd16143211.pdf','Menunggu Verifikasi','2019-08-13 07:09:40'),(4,'pppp','190','ppp','pp','p','pp','990','jpmanajemendd16143212.pdf','Disetujui','2019-08-13 12:37:20'),(5,'opopo','oop','ooo','ppp','pp','pp','90','jpmanajemendd16143213.pdf','Menunggu Verifikasi','2019-08-13 15:18:27'),(6,'tete','djskajKJKJ','KJKJkj','kjkjk','kjk','kjk','90000','jpmanajemendd16143215.pdf','Menunggu Verifikasi','2019-08-14 15:36:21');

/*Table structure for table `penelitian_pkm` */

DROP TABLE IF EXISTS `penelitian_pkm`;

CREATE TABLE `penelitian_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `jenis` text NOT NULL,
  `bidang` varchar(255) NOT NULL,
  `tse` varchar(255) NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `institusi` varchar(255) NOT NULL,
  `jumlah` char(15) NOT NULL,
  `file` text NOT NULL,
  `keterangan` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penelitian_pkm` */

/*Table structure for table `pengabdian` */

DROP TABLE IF EXISTS `pengabdian`;

CREATE TABLE `pengabdian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dosen_id` int(11) NOT NULL,
  `nidn` int(20) NOT NULL,
  `judul_abmas` varchar(100) NOT NULL,
  `lokasi_abmas` varchar(100) NOT NULL,
  `tempat_publikasi` varchar(100) NOT NULL,
  `tahun_pelaksanaan` int(10) NOT NULL,
  `sumber_dana` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dosen_id` (`dosen_id`),
  CONSTRAINT `pengabdian_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `pengabdian` */

insert  into `pengabdian`(`id`,`dosen_id`,`nidn`,`judul_abmas`,`lokasi_abmas`,`tempat_publikasi`,`tahun_pelaksanaan`,`sumber_dana`,`foto`) values (3,5,87638,'ini judul yang sudah di perbaiki','sdkg','bkj',76,'fle','01062018082130amin_jaya.jpg');

/*Table structure for table `publikasiilmiah` */

DROP TABLE IF EXISTS `publikasiilmiah`;

CREATE TABLE `publikasiilmiah` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `institusi` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `file` text NOT NULL,
  `status` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `publikasiilmiah` */

insert  into `publikasiilmiah`(`id`,`idpenelitian`,`nidn`,`judul`,`institusi`,`tanggal`,`tempat`,`file`,`status`,`date`) values (5,2,'123','Oren','UTI','2019-07-20','kklklklkl1','617-2163-1-PB3.pdf','Disetujui',NULL),(7,3,'123','lkdlksdlk','ielele','2019-07-24','lslsks','2238-4532-1-PB1.pdf','Menunggu Verifikasi','2019-07-20 03:19:22');

/*Table structure for table `publikasiilmiah_pkm` */

DROP TABLE IF EXISTS `publikasiilmiah_pkm`;

CREATE TABLE `publikasiilmiah_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `judul` text NOT NULL,
  `institusi` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `file` text NOT NULL,
  `status` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `publikasiilmiah_pkm` */

insert  into `publikasiilmiah_pkm`(`id`,`idpenelitian`,`nidn`,`judul`,`institusi`,`tanggal`,`tempat`,`file`,`status`,`date`) values (8,NULL,'123','owpel','pworl','2019-07-10','3i4p4','882.pdf','Belum Disetujui',NULL),(9,NULL,'123','osl','2o32','2019-07-24','popq','2238-4532-1-PB.pdf','Belum Disetujui',NULL),(10,NULL,'123','hi','uti','2019-07-25','ioo','Chapter_4_-_Form_Transaksi.pdf','','2019-07-25 01:24:31');

/*Table structure for table `seminar` */

DROP TABLE IF EXISTS `seminar`;

CREATE TABLE `seminar` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` varchar(12) NOT NULL,
  `namaprosiding` text NOT NULL,
  `tahunprosiding` text NOT NULL,
  `peranpenulis` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `no` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `jenisprosiding` text,
  `file` text,
  `keterangan` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `seminar` */

insert  into `seminar`(`id`,`idpenelitian`,`nidn`,`namaprosiding`,`tahunprosiding`,`peranpenulis`,`volume`,`no`,`isbn`,`url`,`jenisprosiding`,`file`,`keterangan`,`date`) values (6,2,'123','2','266','2','2','2','44','2',NULL,'617-2163-1-PB1.pdf','Disetujui',NULL),(7,NULL,'123','rttyui','2012','SDKLSDKLAK','sdsklkds','12','sdkalkd','sdkalskda','41','1193-1213-2-PB.pdf','Menunggu Verifikasi',NULL),(8,2,'15311579','oo','2018','CO Author','90','90','90','ww','Terindeks','jpmanajemendd1614325.pdf','Belum Disetujui',NULL),(9,2,'123','kito','2019','First Author','hihihi','hihih','ihihi','hihi','Tidak Diketahui','jpmanajemendd1614326.pdf','Menunggu Verifikasi','2019-08-15 03:12:49'),(11,2,'123','dajkdjak','askdka','First Author','dasdadasdada','dasd','dasda','dads','Tidak Diketahui','jpmanajemendd1614328.pdf','Menunggu Verifikasi','2019-08-15 03:20:02');

/*Table structure for table `seminar_pkm` */

DROP TABLE IF EXISTS `seminar_pkm`;

CREATE TABLE `seminar_pkm` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idpenelitian` int(11) DEFAULT NULL,
  `nidn` char(25) NOT NULL,
  `judul` text NOT NULL,
  `jenis` text NOT NULL,
  `jurnal` varchar(255) NOT NULL,
  `issn` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `no` varchar(255) NOT NULL,
  `halaman` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `file` text,
  `keterangan` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `seminar_pkm` */

insert  into `seminar_pkm`(`id`,`idpenelitian`,`nidn`,`judul`,`jenis`,`jurnal`,`issn`,`volume`,`no`,`halaman`,`url`,`file`,`keterangan`,`date`) values (2,NULL,'123','5','55','5','55','55k','5','5','5','617-2163-1-PB2.pdf','Disetujui',NULL);

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

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','dosen') NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`nama_lengkap`,`username`,`password`,`level`,`foto`) values (3,'Super Admin','admin','admin','admin','29052018171228dfg.png'),(5,'sopekk','sopek','sopek','dosen','30052018042103logo.jpg');

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

/*!50001 CREATE TABLE  `v_buku`(
 `id` int(3) ,
 `nidn` varchar(12) ,
 `idpenelitian` int(11) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `penerbit` varchar(255) ,
 `isbn` char(255) ,
 `halaman` char(11) ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_bukupkm` */

DROP TABLE IF EXISTS `v_bukupkm`;

/*!50001 DROP VIEW IF EXISTS `v_bukupkm` */;
/*!50001 DROP TABLE IF EXISTS `v_bukupkm` */;

/*!50001 CREATE TABLE  `v_bukupkm`(
 `nidn` varchar(12) ,
 `id` int(3) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `penerbit` varchar(255) ,
 `isbn` varchar(255) ,
 `halaman` varchar(255) ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_dosen` */

DROP TABLE IF EXISTS `v_dosen`;

/*!50001 DROP VIEW IF EXISTS `v_dosen` */;
/*!50001 DROP TABLE IF EXISTS `v_dosen` */;

/*!50001 CREATE TABLE  `v_dosen`(
 `nidn` varchar(12) ,
 `nik` varchar(10) ,
 `namadosen` varchar(255) ,
 `namafakultas` varchar(255) ,
 `namajurusan` varchar(255) ,
 `level` varchar(35) ,
 `password` varchar(255) 
)*/;

/*Table structure for table `v_hki` */

DROP TABLE IF EXISTS `v_hki`;

/*!50001 DROP VIEW IF EXISTS `v_hki` */;
/*!50001 DROP TABLE IF EXISTS `v_hki` */;

/*!50001 CREATE TABLE  `v_hki`(
 `nidn` varchar(12) ,
 `id` int(3) ,
 `idpenelitian` int(11) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `jenis` text ,
 `nomorpendaftaran` varchar(255) ,
 `status` varchar(255) ,
 `nohki` varchar(255) ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_hkipkm` */

DROP TABLE IF EXISTS `v_hkipkm`;

/*!50001 DROP VIEW IF EXISTS `v_hkipkm` */;
/*!50001 DROP TABLE IF EXISTS `v_hkipkm` */;

/*!50001 CREATE TABLE  `v_hkipkm`(
 `nidn` varchar(12) ,
 `id` int(3) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `jenis` text ,
 `nomorpendaftaran` varchar(255) ,
 `status` varchar(255) ,
 `nohki` varchar(255) ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_jurnal` */

DROP TABLE IF EXISTS `v_jurnal`;

/*!50001 DROP VIEW IF EXISTS `v_jurnal` */;
/*!50001 DROP TABLE IF EXISTS `v_jurnal` */;

/*!50001 CREATE TABLE  `v_jurnal`(
 `id` int(3) ,
 `idpenelitian` int(11) ,
 `nidn` varchar(12) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `namajurnal` text ,
 `jenis` text ,
 `peranpenulis` varchar(255) ,
 `tahun` char(6) ,
 `volume` varchar(255) ,
 `no` varchar(255) ,
 `url` text ,
 `issn` varchar(255) ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_jurnalpkm` */

DROP TABLE IF EXISTS `v_jurnalpkm`;

/*!50001 DROP VIEW IF EXISTS `v_jurnalpkm` */;
/*!50001 DROP TABLE IF EXISTS `v_jurnalpkm` */;

/*!50001 CREATE TABLE  `v_jurnalpkm`(
 `nidn` varchar(12) ,
 `id` int(3) ,
 `namadosen` varchar(255) ,
 `judul` varchar(255) ,
 `jenis` varchar(255) ,
 `jurnal` varchar(255) ,
 `issn` varchar(255) ,
 `volume` varchar(255) ,
 `no` varchar(255) ,
 `halaman` varchar(255) ,
 `url` text ,
 `file` text ,
 `keterangan` text 
)*/;

/*Table structure for table `v_jurusan` */

DROP TABLE IF EXISTS `v_jurusan`;

/*!50001 DROP VIEW IF EXISTS `v_jurusan` */;
/*!50001 DROP TABLE IF EXISTS `v_jurusan` */;

/*!50001 CREATE TABLE  `v_jurusan`(
 `kodejurusan` char(5) ,
 `namafakultas` varchar(255) ,
 `namajurusan` varchar(255) 
)*/;

/*Table structure for table `v_penelitian` */

DROP TABLE IF EXISTS `v_penelitian`;

/*!50001 DROP VIEW IF EXISTS `v_penelitian` */;
/*!50001 DROP TABLE IF EXISTS `v_penelitian` */;

/*!50001 CREATE TABLE  `v_penelitian`(
 `idpenelitian` int(11) ,
 `nidn` varchar(12) ,
 `namadosen` varchar(255) ,
 `ket` varchar(255) ,
 `judulpenelitian` text ,
 `jenis` text ,
 `bidang` varchar(255) ,
 `tse` varchar(255) ,
 `sumber` varchar(255) ,
 `institusi` varchar(255) ,
 `jumlah` char(15) ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_publikasi` */

DROP TABLE IF EXISTS `v_publikasi`;

/*!50001 DROP VIEW IF EXISTS `v_publikasi` */;
/*!50001 DROP TABLE IF EXISTS `v_publikasi` */;

/*!50001 CREATE TABLE  `v_publikasi`(
 `id` int(3) ,
 `nidn` varchar(12) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `institusi` varchar(255) ,
 `tanggal` date ,
 `tempat` varchar(255) ,
 `file` text ,
 `status` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_publikasi1` */

DROP TABLE IF EXISTS `v_publikasi1`;

/*!50001 DROP VIEW IF EXISTS `v_publikasi1` */;
/*!50001 DROP TABLE IF EXISTS `v_publikasi1` */;

/*!50001 CREATE TABLE  `v_publikasi1`(
 `id` int(3) ,
 `idpenelitian` int(11) ,
 `nidn` varchar(12) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `institusi` varchar(255) ,
 `tanggal` date ,
 `tempat` varchar(255) ,
 `file` text ,
 `status` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_publikasipkm` */

DROP TABLE IF EXISTS `v_publikasipkm`;

/*!50001 DROP VIEW IF EXISTS `v_publikasipkm` */;
/*!50001 DROP TABLE IF EXISTS `v_publikasipkm` */;

/*!50001 CREATE TABLE  `v_publikasipkm`(
 `id` int(3) ,
 `nidn` varchar(12) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `institusi` varchar(255) ,
 `tanggal` date ,
 `tempat` varchar(255) ,
 `file` text ,
 `status` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_seminar` */

DROP TABLE IF EXISTS `v_seminar`;

/*!50001 DROP VIEW IF EXISTS `v_seminar` */;
/*!50001 DROP TABLE IF EXISTS `v_seminar` */;

/*!50001 CREATE TABLE  `v_seminar`(
 `id` int(3) ,
 `idpenelitian` int(11) ,
 `nidn` varchar(12) ,
 `namadosen` varchar(255) ,
 `namaprosiding` text ,
 `peranpenulis` varchar(255) ,
 `tahunprosiding` text ,
 `volume` varchar(255) ,
 `no` varchar(255) ,
 `isbn` varchar(255) ,
 `url` text ,
 `jenisprosiding` text ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*Table structure for table `v_seminarpkm` */

DROP TABLE IF EXISTS `v_seminarpkm`;

/*!50001 DROP VIEW IF EXISTS `v_seminarpkm` */;
/*!50001 DROP TABLE IF EXISTS `v_seminarpkm` */;

/*!50001 CREATE TABLE  `v_seminarpkm`(
 `id` int(3) ,
 `nidn` char(25) ,
 `namadosen` varchar(255) ,
 `judul` text ,
 `jenis` text ,
 `jurnal` varchar(255) ,
 `issn` varchar(255) ,
 `volume` varchar(255) ,
 `no` varchar(255) ,
 `halaman` varchar(255) ,
 `url` text ,
 `file` text ,
 `keterangan` text ,
 `date` timestamp 
)*/;

/*View structure for view v_buku */

/*!50001 DROP TABLE IF EXISTS `v_buku` */;
/*!50001 DROP VIEW IF EXISTS `v_buku` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_buku` AS select `buku`.`id` AS `id`,`buku`.`nidn` AS `nidn`,`penelitian`.`idpenelitian` AS `idpenelitian`,`dosen`.`namadosen` AS `namadosen`,`buku`.`judul` AS `judul`,`buku`.`penerbit` AS `penerbit`,`buku`.`isbn` AS `isbn`,`buku`.`halaman` AS `halaman`,`buku`.`file` AS `file`,`buku`.`keterangan` AS `keterangan`,`buku`.`Date` AS `date` from ((`dosen` join `penelitian`) join `buku`) where ((`buku`.`nidn` = `dosen`.`nidn`) and (`buku`.`idpenelitian` = `penelitian`.`idpenelitian`)) */;

/*View structure for view v_bukupkm */

/*!50001 DROP TABLE IF EXISTS `v_bukupkm` */;
/*!50001 DROP VIEW IF EXISTS `v_bukupkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_bukupkm` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`penerbit` AS `penerbit`,`p`.`isbn` AS `isbn`,`p`.`halaman` AS `halaman`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`buku_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_dosen */

/*!50001 DROP TABLE IF EXISTS `v_dosen` */;
/*!50001 DROP VIEW IF EXISTS `v_dosen` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_dosen` AS select `dosen`.`nidn` AS `nidn`,`dosen`.`nik` AS `nik`,`dosen`.`namadosen` AS `namadosen`,`fakultas`.`namafakultas` AS `namafakultas`,`jurusan`.`namajurusan` AS `namajurusan`,`dosen`.`level` AS `level`,`dosen`.`password` AS `password` from ((`dosen` join `jurusan`) join `fakultas`) where ((`dosen`.`kodejurusan` = `jurusan`.`kodejurusan`) and (`jurusan`.`kodefakultas` = `fakultas`.`kodefakultas`)) */;

/*View structure for view v_hki */

/*!50001 DROP TABLE IF EXISTS `v_hki` */;
/*!50001 DROP VIEW IF EXISTS `v_hki` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hki` AS select `hki`.`nidn` AS `nidn`,`hki`.`id` AS `id`,`penelitian`.`idpenelitian` AS `idpenelitian`,`dosen`.`namadosen` AS `namadosen`,`hki`.`judul` AS `judul`,`hki`.`jenis` AS `jenis`,`hki`.`nomorpendaftaran` AS `nomorpendaftaran`,`hki`.`status` AS `status`,`hki`.`nohki` AS `nohki`,`hki`.`file` AS `file`,`hki`.`keterangan` AS `keterangan`,`hki`.`date` AS `date` from ((`dosen` join `penelitian`) join `hki`) where ((`hki`.`nidn` = `dosen`.`nidn`) and (`hki`.`idpenelitian` = `penelitian`.`idpenelitian`)) */;

/*View structure for view v_hkipkm */

/*!50001 DROP TABLE IF EXISTS `v_hkipkm` */;
/*!50001 DROP VIEW IF EXISTS `v_hkipkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hkipkm` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`nomorpendaftaran` AS `nomorpendaftaran`,`p`.`status` AS `status`,`p`.`nohki` AS `nohki`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`hki_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_jurnal */

/*!50001 DROP TABLE IF EXISTS `v_jurnal` */;
/*!50001 DROP VIEW IF EXISTS `v_jurnal` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jurnal` AS select `jurnal`.`id` AS `id`,`penelitian`.`idpenelitian` AS `idpenelitian`,`jurnal`.`nidn` AS `nidn`,`dosen`.`namadosen` AS `namadosen`,`jurnal`.`judul` AS `judul`,`jurnal`.`namajurnal` AS `namajurnal`,`jurnal`.`jenis` AS `jenis`,`jurnal`.`peranpenulis` AS `peranpenulis`,`jurnal`.`tahun` AS `tahun`,`jurnal`.`volume` AS `volume`,`jurnal`.`no` AS `no`,`jurnal`.`url` AS `url`,`jurnal`.`issn` AS `issn`,`jurnal`.`file` AS `file`,`jurnal`.`keterangan` AS `keterangan`,`jurnal`.`date` AS `date` from ((`dosen` join `penelitian`) join `jurnal`) where ((`jurnal`.`nidn` = `dosen`.`nidn`) and (`jurnal`.`idpenelitian` = `penelitian`.`idpenelitian`)) */;

/*View structure for view v_jurnalpkm */

/*!50001 DROP TABLE IF EXISTS `v_jurnalpkm` */;
/*!50001 DROP VIEW IF EXISTS `v_jurnalpkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jurnalpkm` AS select `p`.`nidn` AS `nidn`,`p`.`id` AS `id`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`jurnal` AS `jurnal`,`p`.`issn` AS `issn`,`p`.`volume` AS `volume`,`p`.`no` AS `no`,`p`.`halaman` AS `halaman`,`p`.`url` AS `url`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan` from (`jurnal_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_jurusan */

/*!50001 DROP TABLE IF EXISTS `v_jurusan` */;
/*!50001 DROP VIEW IF EXISTS `v_jurusan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jurusan` AS select `jurusan`.`kodejurusan` AS `kodejurusan`,`fakultas`.`namafakultas` AS `namafakultas`,`jurusan`.`namajurusan` AS `namajurusan` from (`jurusan` join `fakultas`) where (`jurusan`.`kodefakultas` = `fakultas`.`kodefakultas`) */;

/*View structure for view v_penelitian */

/*!50001 DROP TABLE IF EXISTS `v_penelitian` */;
/*!50001 DROP VIEW IF EXISTS `v_penelitian` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penelitian` AS select `penelitian`.`idpenelitian` AS `idpenelitian`,`detail_anggotapenelitian`.`nidn` AS `nidn`,`dosen`.`namadosen` AS `namadosen`,`detail_anggotapenelitian`.`ket` AS `ket`,`penelitian`.`judulpenelitian` AS `judulpenelitian`,`penelitian`.`jenis` AS `jenis`,`penelitian`.`bidang` AS `bidang`,`penelitian`.`tse` AS `tse`,`penelitian`.`sumber` AS `sumber`,`penelitian`.`institusi` AS `institusi`,`penelitian`.`jumlah` AS `jumlah`,`penelitian`.`file` AS `file`,`penelitian`.`keterangan` AS `keterangan`,`penelitian`.`date` AS `date` from ((`penelitian` join `dosen`) join `detail_anggotapenelitian`) where ((`detail_anggotapenelitian`.`idpenelitian` = `penelitian`.`idpenelitian`) and (`detail_anggotapenelitian`.`nidn` = `dosen`.`nidn`)) */;

/*View structure for view v_publikasi */

/*!50001 DROP TABLE IF EXISTS `v_publikasi` */;
/*!50001 DROP VIEW IF EXISTS `v_publikasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_publikasi` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`institusi` AS `institusi`,`p`.`tanggal` AS `tanggal`,`p`.`tempat` AS `tempat`,`p`.`file` AS `file`,`p`.`status` AS `status`,`p`.`date` AS `date` from (`publikasiilmiah` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_publikasi1 */

/*!50001 DROP TABLE IF EXISTS `v_publikasi1` */;
/*!50001 DROP VIEW IF EXISTS `v_publikasi1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_publikasi1` AS select `publikasiilmiah`.`id` AS `id`,`penelitian`.`idpenelitian` AS `idpenelitian`,`publikasiilmiah`.`nidn` AS `nidn`,`dosen`.`namadosen` AS `namadosen`,`publikasiilmiah`.`judul` AS `judul`,`publikasiilmiah`.`institusi` AS `institusi`,`publikasiilmiah`.`tanggal` AS `tanggal`,`publikasiilmiah`.`tempat` AS `tempat`,`publikasiilmiah`.`file` AS `file`,`publikasiilmiah`.`status` AS `status`,`publikasiilmiah`.`date` AS `date` from ((`dosen` join `penelitian`) join `publikasiilmiah`) where ((`publikasiilmiah`.`nidn` = `dosen`.`nidn`) and (`publikasiilmiah`.`idpenelitian` = `penelitian`.`idpenelitian`)) */;

/*View structure for view v_publikasipkm */

/*!50001 DROP TABLE IF EXISTS `v_publikasipkm` */;
/*!50001 DROP VIEW IF EXISTS `v_publikasipkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_publikasipkm` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`institusi` AS `institusi`,`p`.`tanggal` AS `tanggal`,`p`.`tempat` AS `tempat`,`p`.`file` AS `file`,`p`.`status` AS `status`,`p`.`date` AS `date` from (`publikasiilmiah_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*View structure for view v_seminar */

/*!50001 DROP TABLE IF EXISTS `v_seminar` */;
/*!50001 DROP VIEW IF EXISTS `v_seminar` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_seminar` AS select `seminar`.`id` AS `id`,`penelitian`.`idpenelitian` AS `idpenelitian`,`seminar`.`nidn` AS `nidn`,`dosen`.`namadosen` AS `namadosen`,`seminar`.`namaprosiding` AS `namaprosiding`,`seminar`.`peranpenulis` AS `peranpenulis`,`seminar`.`tahunprosiding` AS `tahunprosiding`,`seminar`.`volume` AS `volume`,`seminar`.`no` AS `no`,`seminar`.`isbn` AS `isbn`,`seminar`.`url` AS `url`,`seminar`.`jenisprosiding` AS `jenisprosiding`,`seminar`.`file` AS `file`,`seminar`.`keterangan` AS `keterangan`,`seminar`.`date` AS `date` from ((`dosen` join `penelitian`) join `seminar`) where ((`seminar`.`nidn` = `dosen`.`nidn`) and (`seminar`.`idpenelitian` = `penelitian`.`idpenelitian`)) */;

/*View structure for view v_seminarpkm */

/*!50001 DROP TABLE IF EXISTS `v_seminarpkm` */;
/*!50001 DROP VIEW IF EXISTS `v_seminarpkm` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_seminarpkm` AS select `p`.`id` AS `id`,`p`.`nidn` AS `nidn`,`d`.`namadosen` AS `namadosen`,`p`.`judul` AS `judul`,`p`.`jenis` AS `jenis`,`p`.`jurnal` AS `jurnal`,`p`.`issn` AS `issn`,`p`.`volume` AS `volume`,`p`.`no` AS `no`,`p`.`halaman` AS `halaman`,`p`.`url` AS `url`,`p`.`file` AS `file`,`p`.`keterangan` AS `keterangan`,`p`.`date` AS `date` from (`seminar_pkm` `p` join `dosen` `d` on((`p`.`nidn` = `d`.`nidn`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

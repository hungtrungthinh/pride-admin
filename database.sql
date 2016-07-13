/*
SQLyog Community v11.52 (64 bit)
MySQL - 5.6.28 : Database - pride_admin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pride_admin` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pride_admin`;

/*Table structure for table `tbl_adjusters` */

DROP TABLE IF EXISTS `tbl_adjusters`;

CREATE TABLE `tbl_adjusters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) DEFAULT NULL,
  `gender` enum('0','1') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `geolocation` varchar(40) DEFAULT NULL,
  `phone_number` varchar(16) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `home_phone` varchar(12) DEFAULT NULL,
  `bio` varchar(100) DEFAULT NULL,
  `avator` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_adjusters` */

insert  into `tbl_adjusters`(`id`,`full_name`,`gender`,`birthday`,`address`,`geolocation`,`phone_number`,`email`,`home_phone`,`bio`,`avator`) values (11,'amdnf','0','2016-05-20','','34.2342,-20.342535','123415315','www@www.www',NULL,NULL,'1461935954_malecostume.png');

/*Table structure for table `tbl_claims` */

DROP TABLE IF EXISTS `tbl_claims`;

CREATE TABLE `tbl_claims` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_claims` */

/*Table structure for table `tbl_messages` */

DROP TABLE IF EXISTS `tbl_messages`;

CREATE TABLE `tbl_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(140) DEFAULT NULL,
  `phone_number` varchar(14) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `claim_id` int(11) DEFAULT NULL,
  `request_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `adjuster_id` int(11) DEFAULT NULL,
  `message` text,
  `is_read` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_messages` */

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary id',
  `user_id` varchar(40) DEFAULT NULL COMMENT 'login id',
  `user_pass` varchar(100) DEFAULT NULL COMMENT 'password',
  `full_name` varchar(100) DEFAULT NULL COMMENT 'full name',
  `allow` tinyint(4) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL COMMENT 'date of registed',
  `access_count` bigint(20) DEFAULT NULL COMMENT 'total access count',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`user_id`,`user_pass`,`full_name`,`allow`,`reg_date`,`access_count`) values (2,'root','92eb5ffee6ae2fec3ad71c777531578f','Administrator',1,'0000-00-00 00:00:00',0),(9,'admin','0cc175b9c0f1b6a831c399e269772661','',1,'2016-05-02 00:00:00',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

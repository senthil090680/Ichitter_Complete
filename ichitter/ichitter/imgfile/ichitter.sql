/*
SQLyog Community- MySQL GUI v8.22 
MySQL - 5.5.8-log : Database - ichitter
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ichitter` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ichitter`;

/*Table structure for table `chat` */

DROP TABLE IF EXISTS `chat`;

CREATE TABLE `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

/*Data for the table `chat` */

insert  into `chat`(`id`,`from`,`to`,`message`,`sent`,`recd`) values (83,'12','11','good','2012-03-15 20:14:27',2);

/*Table structure for table `tbl_addfriend` */

DROP TABLE IF EXISTS `tbl_addfriend`;

CREATE TABLE `tbl_addfriend` (
  `addfrnd_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_user_id` int(11) NOT NULL,
  `response_user_id` int(11) NOT NULL,
  `addfrnd_flag` int(1) NOT NULL,
  `requested_date` datetime NOT NULL,
  `accepted_date` datetime DEFAULT NULL,
  `deny_flag` int(1) DEFAULT NULL,
  PRIMARY KEY (`addfrnd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_addfriend` */

insert  into `tbl_addfriend`(`addfrnd_id`,`request_user_id`,`response_user_id`,`addfrnd_flag`,`requested_date`,`accepted_date`,`deny_flag`) values (28,4,1,1,'2011-12-28 22:01:02','2012-01-11 16:08:32',1),(29,1,2,1,'2011-12-29 20:21:58',NULL,0),(30,1,15,1,'2012-01-11 15:17:26',NULL,0),(31,1,11,0,'2012-01-11 20:45:46',NULL,0),(32,18,4,0,'2012-01-12 21:21:41','2012-01-12 21:29:49',0),(39,4,52,0,'2012-01-25 16:12:55','2012-01-25 16:17:47',0),(40,39,12,0,'2012-01-25 16:24:07','2012-01-25 16:24:43',0);

/*Table structure for table `tbl_badwords` */

DROP TABLE IF EXISTS `tbl_badwords`;

CREATE TABLE `tbl_badwords` (
  `bw_id` int(11) NOT NULL AUTO_INCREMENT,
  `bw_word` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`bw_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_badwords` */

insert  into `tbl_badwords`(`bw_id`,`bw_word`) values (1,'asshole'),(2,'ass'),(3,'bitch'),(4,'bastard'),(5,'cunt'),(6,'dick'),(7,'dike'),(8,'dildo'),(9,'fuck'),(10,'gay'),(11,'hoe'),(12,'nigger'),(13,'pussy'),(14,'slut'),(15,'whore'),(16,'god damn'),(17,'goddamn');

/*Table structure for table `tbl_chat` */

DROP TABLE IF EXISTS `tbl_chat`;

CREATE TABLE `tbl_chat` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `message` text,
  `time_stamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_chat` */

insert  into `tbl_chat`(`id`,`group_id`,`user_id`,`message`,`time_stamp`) values (51,32,18,'hi arun and tom','2012-03-13 16:12:49'),(52,32,11,'hi guys','2012-03-13 16:13:14'),(53,32,12,'ok man','2012-03-13 16:13:34'),(54,32,12,'you are not focused','2012-03-13 16:14:01'),(61,21,12,'good pa','2012-03-15 17:05:13'),(62,21,11,'ok da','2012-03-15 17:05:32');

/*Table structure for table `tbl_contacts` */

DROP TABLE IF EXISTS `tbl_contacts`;

CREATE TABLE `tbl_contacts` (
  `cont_id` int(11) NOT NULL AUTO_INCREMENT,
  `cont_user_id` varchar(11) NOT NULL,
  `cont_user_joined_id` varchar(11) NOT NULL,
  PRIMARY KEY (`cont_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_contacts` */

insert  into `tbl_contacts`(`cont_id`,`cont_user_id`,`cont_user_joined_id`) values (20,'1','11'),(21,'1','4'),(22,'1','9'),(23,'1','12'),(24,'1','13'),(25,'1','3'),(26,'3','1'),(28,'3','9'),(29,'3','12'),(30,'3','13'),(31,'4','1'),(32,'4','11'),(33,'4','9'),(34,'4','12'),(35,'4','13'),(37,'11','1'),(38,'11','4'),(39,'11','9'),(40,'11','12'),(41,'11','13'),(42,'11','3'),(43,'12','11'),(44,'12','1'),(45,'12','4'),(46,'12','9'),(47,'12','13'),(48,'12','3'),(49,'13','1'),(50,'13','4'),(51,'13','11'),(52,'13','9'),(53,'13','12'),(54,'13','3'),(89,'4','3'),(90,'3','4'),(105,'52','4'),(106,'4','52'),(107,'12','39'),(108,'39','12');

/*Table structure for table `tbl_discussion` */

DROP TABLE IF EXISTS `tbl_discussion`;

CREATE TABLE `tbl_discussion` (
  `discussion_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `sub_topic_id` int(11) DEFAULT NULL,
  `for_discussion_id` int(11) DEFAULT NULL,
  `discussion_content` mediumtext,
  `reply_count` int(11) DEFAULT '0',
  `posted_on` datetime DEFAULT NULL,
  `is_archived` bit(1) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`discussion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_discussion` */

insert  into `tbl_discussion`(`discussion_id`,`user_id`,`post_id`,`topic_id`,`sub_topic_id`,`for_discussion_id`,`discussion_content`,`reply_count`,`posted_on`,`is_archived`,`is_active`) values (1,11,3,3,5,0,'New Discussion started',1,'2012-01-11 16:06:17','\0','\0'),(2,4,3,3,5,1,'Thank you',0,'2012-01-11 16:07:20','\0','\0'),(3,11,3,3,5,0,'I am making public response again',0,'2012-01-11 16:12:04','\0','\0'),(4,1,4,3,5,0,'hdhfhfhfhfhfdhfhffd',2,'2012-01-12 18:33:59','\0','\0'),(5,1,4,3,5,4,'hello',1,'2012-01-13 13:22:27','\0','\0'),(6,1,4,3,5,5,'this is a test message',0,'2012-01-13 13:22:39','\0','\0'),(7,12,4,3,5,4,'I am not sure that I agree with your opinion.',0,'2012-01-15 23:52:28','\0','\0'),(8,12,4,3,5,0,'But maybe you just have to explain your position better and present additional arguments so let us discuss this topic more!',1,'2012-01-15 23:54:33','\0','\0'),(9,1,4,3,5,8,'OK, let us do some more discussing!',0,'2012-01-16 00:03:55','\0','\0');

/*Table structure for table `tbl_discussion_read` */

DROP TABLE IF EXISTS `tbl_discussion_read`;

CREATE TABLE `tbl_discussion_read` (
  `disc_read_id` int(11) NOT NULL AUTO_INCREMENT,
  `discussion_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `opened_on` datetime DEFAULT NULL,
  PRIMARY KEY (`disc_read_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_discussion_read` */

insert  into `tbl_discussion_read`(`disc_read_id`,`discussion_id`,`user_id`,`opened_on`) values (1,1,11,'2012-01-11 16:27:55'),(2,1,4,'2012-01-11 16:07:08'),(3,2,11,'2012-01-11 16:16:59'),(4,3,11,'2012-01-11 16:27:50'),(5,4,1,'2012-01-16 00:02:16'),(6,1,1,'2012-01-13 14:40:45'),(7,3,1,'2012-01-13 14:40:51'),(8,4,12,'2012-01-15 23:54:57'),(9,7,12,'2012-01-15 23:55:10'),(10,5,12,'2012-01-15 23:55:17'),(11,8,12,'2012-01-15 23:55:42'),(12,7,1,'2012-01-16 00:02:37'),(13,5,1,'2012-01-16 00:04:43'),(14,8,1,'2012-01-16 00:04:22');

/*Table structure for table `tbl_gender` */

DROP TABLE IF EXISTS `tbl_gender`;

CREATE TABLE `tbl_gender` (
  `gender_id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_abbreviation` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gender_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_gender` */

insert  into `tbl_gender`(`gender_id`,`gender_abbreviation`,`gender_name`) values (1,'m','Male'),(2,'f','Female');

/*Table structure for table `tbl_group_members` */

DROP TABLE IF EXISTS `tbl_group_members`;

CREATE TABLE `tbl_group_members` (
  `gm_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_id_joined` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_id_joined_date` datetime DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  PRIMARY KEY (`gm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_group_members` */

insert  into `tbl_group_members`(`gm_id`,`user_id`,`group_id`,`user_id_joined`,`user_id_joined_date`,`is_active`) values (1,1,3,'11','2011-12-01 15:17:36',1),(2,1,4,'11','2011-12-01 16:06:15',1),(3,11,16,'1','2011-12-01 16:17:26',1),(4,11,16,'4','2011-12-01 16:18:54',1),(5,1,15,'3','2011-12-01 17:35:59',1),(6,1,2,'11','2011-12-01 17:47:45',0),(7,1,20,'1','2011-12-01 17:48:12',1),(8,11,16,'9','2011-12-02 15:47:25',1),(9,1,19,'11','2011-12-05 15:15:49',1),(10,1,2,'12','2011-12-07 14:17:44',1),(11,1,20,'12','2011-12-07 14:31:14',1),(12,1,15,'12','2011-12-07 14:35:47',1),(13,11,16,'13','2011-12-10 12:00:24',1),(14,1,17,'13','2011-12-10 12:01:06',1),(15,12,21,'12','2011-12-10 12:01:22',1),(16,1,2,'13','2011-12-10 12:15:06',1),(17,11,16,'12','2011-12-12 14:55:00',1),(18,1,2,'4','2011-12-12 16:33:38',1),(19,1,4,'12','2011-12-12 17:17:30',1),(20,11,16,'3','2011-12-13 10:28:59',1),(21,1,20,'4','2011-12-22 17:22:01',1),(22,1,15,'4','2011-12-22 17:22:39',1),(23,12,21,'11','2012-01-16 13:22:42',1),(26,4,38,'11','2012-01-23 15:44:38',1),(27,1,20,'3','2012-01-23 15:44:38',1),(28,NULL,NULL,NULL,NULL,1),(29,4,30,'3','2012-02-08 15:59:13',1),(30,3,40,'4','2012-02-09 21:13:47',1),(31,4,37,'3','2012-02-15 15:44:35',1),(32,1,41,'1','2012-03-08 18:00:04',1),(33,12,21,'18','2012-03-08 21:02:42',1),(34,11,32,'18','2012-03-08 21:03:42',1),(35,11,32,'12','2012-03-08 21:04:44',1),(36,11,32,'11','2012-03-08 18:00:04',1),(37,18,42,'18','2012-03-09 19:48:15',1),(38,11,43,'11','2012-03-14 17:51:56',1),(39,4,37,'11','2012-03-14 17:52:29',1);

/*Table structure for table `tbl_groups` */

DROP TABLE IF EXISTS `tbl_groups`;

CREATE TABLE `tbl_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `whoweare` text,
  `isay` text,
  `description` text,
  `created_date` datetime DEFAULT NULL,
  `is_deleted` int(1) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `is_archived` bit(1) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_groups` */

insert  into `tbl_groups`(`group_id`,`user_id`,`group_name`,`whoweare`,`isay`,`description`,`created_date`,`is_deleted`,`deleted_date`,`is_archived`) values (1,1,'Test','We are test group','Testing ',NULL,'2011-11-30 16:17:25',NULL,NULL,NULL),(2,1,'Environment','We will oppose everything happening against environment','we love our ecology',NULL,'2011-11-30 16:20:06',NULL,NULL,NULL),(3,1,'News Group','World News broadcasting group','News changes the world',NULL,'2011-11-30 17:10:34',NULL,NULL,NULL),(4,1,'Fiends','close friends','friends',NULL,'2011-11-30 17:14:04',NULL,NULL,NULL),(15,1,'ABC Group','Group','Group',NULL,'2011-12-01 14:03:15',NULL,NULL,NULL),(16,11,'Economy','Indian economy compared with world economy','we are economist',NULL,'2011-12-01 14:21:36',NULL,NULL,NULL),(17,1,'my new','my new','my nwew',NULL,'2011-12-01 16:20:51',NULL,NULL,NULL),(18,1,'Test','test','test',NULL,'2011-12-01 16:33:56',NULL,NULL,NULL),(19,1,'US IRAQ','Bilateral relations between US and IRAQ','Truth alone triumphs\n',NULL,'2011-12-01 16:35:37',NULL,NULL,NULL),(20,1,'asdf','sdf','sdf',NULL,'2011-12-01 17:24:05',NULL,NULL,NULL),(21,12,'Party of NO','We say NO to everything.','Proud',NULL,'2011-12-07 14:34:19',NULL,NULL,NULL),(22,13,'Fun','We celebrate Fun','Life is Fun',NULL,'2011-12-10 12:02:08',NULL,NULL,NULL),(23,11,'Regional Affairs','Speaks about the regional affairs','Save regional provinces',NULL,'2011-12-12 10:37:29',NULL,NULL,NULL),(24,1,'Paula Jones Group','Paula Jones Group','Paula Jones Group',NULL,'2011-12-14 16:37:05',NULL,NULL,NULL),(25,1,'PaulaJonesGroup','Paula Jones Group','Paula Jones Group',NULL,'2011-12-14 16:37:18',NULL,NULL,NULL),(26,4,'flowers','nature','flowers for all',NULL,'2012-01-20 15:09:16',NULL,NULL,NULL),(28,4,'test','test','I say',NULL,'2012-01-20 20:26:40',NULL,NULL,NULL),(29,4,'test','test','test',NULL,'2012-01-20 20:29:09',NULL,NULL,NULL),(30,4,'123test','test','test',NULL,'2012-01-20 20:29:42',NULL,NULL,NULL),(31,4,'789','789','789',NULL,'2012-01-20 20:33:19',NULL,NULL,NULL),(32,11,'xyz','xyz','xyz',NULL,'2012-01-20 20:48:01',NULL,NULL,NULL),(33,4,'abcd','abcd','abcd',NULL,'2012-01-20 20:49:47',NULL,NULL,NULL),(34,4,'456','456','456',NULL,'2012-01-20 20:53:51',NULL,NULL,NULL),(35,11,'159','159','159',NULL,'2012-01-20 20:55:01',NULL,NULL,NULL),(36,4,'21012012','21012012','21012012',NULL,'2012-01-21 12:59:55',NULL,NULL,NULL),(37,4,'2301212','2301212','2301212',NULL,'2012-01-23 14:40:58',NULL,NULL,NULL),(38,4,'nature','nature','nature',NULL,'2012-01-23 14:48:53',NULL,NULL,NULL),(40,3,'Great Group','This is great group','I would like to say that this group is going to be rocking.',NULL,'2012-02-09 21:12:03',NULL,NULL,NULL),(41,1,'Emantras Group','You','I',NULL,'2012-03-08 18:00:04',NULL,NULL,NULL),(42,18,'Good Group','We','You',NULL,'2012-03-09 19:48:15',NULL,NULL,NULL),(43,11,'hello group','this is hello group','hi guys',NULL,'2012-03-14 17:51:56',NULL,NULL,NULL);

/*Table structure for table `tbl_igallery` */

DROP TABLE IF EXISTS `tbl_igallery`;

CREATE TABLE `tbl_igallery` (
  `igallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `igallery_name` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `date_last_updated` datetime DEFAULT NULL,
  `is_deleted` int(1) DEFAULT NULL,
  `igallery_description` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `is_archieved` bit(1) DEFAULT NULL,
  PRIMARY KEY (`igallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_igallery` */

insert  into `tbl_igallery`(`igallery_id`,`user_id`,`igallery_name`,`date_uploaded`,`date_last_updated`,`is_deleted`,`igallery_description`,`is_active`,`is_archieved`) values (5,1,'Nature_1','2011-11-30 16:28:55','2011-11-30 16:28:55',NULL,NULL,'',NULL),(6,1,'for testing_1','2011-12-01 14:03:51','2011-12-01 14:03:51',NULL,NULL,'',NULL),(8,1,'Universe_1','2011-12-02 02:49:52','2011-12-02 02:49:52',NULL,NULL,'',NULL),(11,13,'Test_13','2011-12-10 10:16:05','2011-12-10 10:16:05',NULL,NULL,'',NULL),(12,4,'fortesting_4','2011-12-15 14:34:09','2011-12-15 14:34:09',NULL,NULL,'',NULL);

/*Table structure for table `tbl_images` */

DROP TABLE IF EXISTS `tbl_images`;

CREATE TABLE `tbl_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `igallery_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `date_last_updated` datetime DEFAULT NULL,
  `image_description` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `is_archieved` bit(1) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_images` */

insert  into `tbl_images`(`image_id`,`igallery_id`,`user_id`,`image_name`,`date_uploaded`,`date_last_updated`,`image_description`,`is_active`,`is_archieved`) values (7,5,1,'Sunset_11302011105914.jpg','2011-11-30 16:29:15','2011-11-30 16:29:15',NULL,'',NULL),(9,6,1,'Winter_12012011083420.jpg','2011-12-01 14:04:20','2011-12-01 14:04:20',NULL,'',NULL),(14,8,1,'a43_Crab_12012011212556.jpg','2011-12-02 02:55:56','2011-12-02 02:55:56',NULL,'',NULL),(15,8,1,'a43_eskimo_12012011212557.jpg','2011-12-02 02:55:57','2011-12-02 02:55:57',NULL,'',NULL),(17,8,1,'a43_1987A_12012011212837.jpg','2011-12-02 02:58:38','2011-12-02 02:58:38',NULL,'',NULL),(18,8,1,'a43_catseye_12012011212838.jpg','2011-12-02 02:58:38','2011-12-02 02:58:38',NULL,'',NULL),(19,8,1,'a43_pillars_12012011212838.jpg','2011-12-02 02:58:39','2011-12-02 02:58:39',NULL,'',NULL),(20,5,1,'nature_1_12012011220038.jpg','2011-12-02 03:30:39','2011-12-02 03:30:39',NULL,'',NULL),(21,5,1,'nature_2_12012011220043.jpg','2011-12-02 03:30:44','2011-12-02 03:30:44',NULL,'',NULL),(22,5,1,'Nature_3_12012011220046.jpg','2011-12-02 03:30:47','2011-12-02 03:30:47',NULL,'',NULL),(23,5,1,'Nature_4_12012011220047.jpg','2011-12-02 03:30:48','2011-12-02 03:30:48',NULL,'',NULL),(24,5,1,'Nature_5_12012011220050.jpg','2011-12-02 03:30:51','2011-12-02 03:30:51',NULL,'',NULL),(43,11,13,'photo____12102011044622.jpg','2011-12-10 10:16:22','2011-12-10 10:16:22',NULL,'',NULL),(44,11,13,'photo09_12102011044622.jpg','2011-12-10 10:16:22','2011-12-10 10:16:22',NULL,'',NULL),(47,0,13,'photo06_12102011060024.jpg','2011-12-10 11:30:24','2011-12-10 11:30:24',NULL,'',NULL),(50,0,4,'images_12122011111357.jpeg','2011-12-12 16:43:57','2011-12-12 16:43:57',NULL,'',NULL),(51,0,4,'Winter_12122011111955.jpg','2011-12-12 16:49:55','2011-12-12 16:49:55',NULL,'',NULL),(52,0,4,'cute_smile_baby_photo_002_12122011112403.jpg','2011-12-12 16:54:03','2011-12-12 16:54:03',NULL,'',NULL),(53,0,4,'Sunset_12122011113419.jpg','2011-12-12 17:04:20','2011-12-12 17:04:20',NULL,'',NULL),(54,0,4,'Winter_12122011120330.jpg','2011-12-12 17:33:31','2011-12-12 17:33:31',NULL,'',NULL),(55,0,1,'Blue______12142011094137.jpg','2011-12-14 15:11:37','2011-12-14 15:11:37',NULL,'',NULL),(56,0,1,'Water_lilies_12142011100445.jpg','2011-12-14 15:34:46','2011-12-14 15:34:46',NULL,'',NULL),(57,12,4,'cute_smile_baby_photo_002_12152011090448.jpg','2011-12-15 14:34:48','2011-12-15 14:34:48',NULL,'',NULL),(58,0,1,'Winter_12152011093646.jpg','2011-12-15 15:06:47','2011-12-15 15:06:47',NULL,'',NULL),(59,0,1,'Sunset_12152011093703.jpg','2011-12-15 15:07:03','2011-12-15 15:07:03',NULL,'',NULL),(60,0,11,'Winter_12152011105924.jpg','2011-12-15 16:29:24','2011-12-15 16:29:24',NULL,'',NULL),(61,0,4,'Sunset_12152011111638.jpg','2011-12-15 16:46:39','2011-12-15 16:46:39',NULL,'',NULL),(62,0,4,'Sunset_12152011111650.jpg','2011-12-15 16:46:51','2011-12-15 16:46:51',NULL,'',NULL),(63,0,17,'cute_smile_baby_photo_002_12152011125432.jpg','2011-12-15 18:24:32','2011-12-15 18:24:32',NULL,'',NULL),(64,0,1,'Winter_12192011094458.jpg','2011-12-19 15:14:59','2011-12-19 15:14:59',NULL,'',NULL),(65,0,1,'Sunset_12192011094509.jpg','2011-12-19 15:15:10','2011-12-19 15:15:10',NULL,'',NULL),(66,0,12,'face4_01152012232809.jpg','2012-01-16 04:58:09','2012-01-16 04:58:09',NULL,'',NULL),(67,0,12,'face6_01152012232854.jpg','2012-01-16 04:58:54','2012-01-16 04:58:54',NULL,'',NULL),(69,0,12,'face5_01152012233025.jpg','2012-01-16 05:00:25','2012-01-16 05:00:25',NULL,'',NULL),(71,0,12,'face4_01162012024013.jpg','2012-01-16 08:10:14','2012-01-16 08:10:14',NULL,'',NULL),(72,0,12,'face3_01162012024047.jpg','2012-01-16 08:10:47','2012-01-16 08:10:47',NULL,'',NULL),(73,0,12,'face4_01162012024118.jpg','2012-01-16 08:11:18','2012-01-16 08:11:18',NULL,'',NULL),(74,0,12,'face6_01162012024131.jpg','2012-01-16 08:11:32','2012-01-16 08:11:32',NULL,'',NULL),(75,0,1,'face5_01162012024635.jpg','2012-01-16 08:16:36','2012-01-16 08:16:36',NULL,'',NULL),(76,0,1,'face2_01242012012728.jpg','2012-01-24 06:57:29','2012-01-24 06:57:29',NULL,'',NULL),(77,0,1,'face1_01242012012837.jpg','2012-01-24 06:58:38','2012-01-24 06:58:38',NULL,'',NULL),(78,0,39,'face3_01242012013804.jpg','2012-01-24 07:08:04','2012-01-24 07:08:04',NULL,'',NULL),(79,0,4,'Winter_01242012083749.jpg','2012-01-24 14:07:50','2012-01-24 14:07:50',NULL,'',NULL),(80,0,4,'Winter_01242012083827.jpg','2012-01-24 14:08:28','2012-01-24 14:08:28',NULL,'',NULL),(82,0,39,'photo_3_01252012054407.jpg','2012-01-25 11:14:07','2012-01-25 11:14:07',NULL,'',NULL);

/*Table structure for table `tbl_login` */

DROP TABLE IF EXISTS `tbl_login`;

CREATE TABLE `tbl_login` (
  `login_id` int(11) NOT NULL,
  `user_name` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_login` */

insert  into `tbl_login`(`login_id`,`user_name`,`password`,`role_id`,`last_loggedin`) values (1,'admin','password01',1,'2012-01-25 06:45:11');

/*Table structure for table `tbl_marked` */

DROP TABLE IF EXISTS `tbl_marked`;

CREATE TABLE `tbl_marked` (
  `mark_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `sub_topic_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `marked_on` datetime DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT NULL,
  `is_archived` bit(1) DEFAULT NULL,
  PRIMARY KEY (`mark_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_marked` */

insert  into `tbl_marked`(`mark_id`,`post_id`,`sub_topic_id`,`user_id`,`marked_on`,`is_active`,`is_archived`) values (74,34,5,1,'2011-12-20 17:08:24','\0','\0'),(75,33,3,1,'2011-12-20 17:08:24','\0','\0'),(76,32,2,1,'2011-12-20 17:08:24','\0','\0'),(77,31,2,1,'2011-12-20 17:08:24','\0','\0'),(92,4,5,1,'2011-12-21 16:39:36','\0','\0'),(94,37,3,11,'2011-12-22 15:13:58','\0','\0'),(95,5,3,11,'2011-12-22 15:14:00','\0','\0'),(97,5,3,1,'2012-01-16 02:57:30','\0','\0'),(102,5,3,39,'2012-01-25 00:55:39','\0','\0'),(103,40,14,1,'2012-01-25 16:26:47','\0','\0'),(104,39,14,1,'2012-01-25 16:26:54','\0','\0');

/*Table structure for table `tbl_msg` */

DROP TABLE IF EXISTS `tbl_msg`;

CREATE TABLE `tbl_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_user_id` int(11) NOT NULL,
  `receiver_user_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `msg_sent_time` datetime NOT NULL,
  `msg_flag` int(1) NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_msg` */

insert  into `tbl_msg`(`msg_id`,`sender_user_id`,`receiver_user_id`,`msg`,`msg_sent_time`,`msg_flag`) values (1,4,11,'hi','2012-01-05 15:47:32',1),(2,11,4,'hello','2012-01-05 16:42:16',1),(3,4,11,'2nd msg<br />3rd msg','2012-01-05 16:44:10',1),(4,11,4,'i sent only hi','2012-01-05 16:48:28',1),(5,4,11,'hi hi','2012-01-05 16:48:44',1),(6,11,4,'123','2012-01-05 19:08:05',1),(7,1,11,'Hi Arun<br />How are you<br />How are you<br />test at 6.17pm','2012-01-11 18:03:29',1),(8,11,1,'send msg 9.01<br />for test user<br />Hello How are you .... I am good. good to go with the ichitter profile','2012-01-11 21:02:12',1),(9,11,4,'for noor<br />Hello how are yo','2012-01-11 21:05:32',1),(10,4,11,'9.22','2012-01-11 21:08:06',1),(11,11,4,'9.27','2012-01-11 21:13:14',1),(12,4,11,'9.35','2012-01-11 21:21:28',1),(13,11,4,'Hello Noor<br />How are you<br />When will you complete the projectjQuery16104394434441069063_1326297976869','2012-01-11 21:23:40',1),(14,4,11,'jQuery161041946712257898233_1326298475453?','2012-01-11 21:30:47',1),(15,18,4,'hi','2012-01-13 14:36:19',1),(16,4,18,'how are you?<br />how did you find me?','2012-01-13 14:37:56',1),(17,18,4,'this s from detailedmsg','2012-01-13 14:40:08',1),(18,4,11,'hi','2012-01-20 20:50:50',0),(19,4,11,'gh','2012-01-24 16:46:56',0),(20,4,18,'hi<br />hi hi','2012-01-24 23:08:29',1),(21,1,12,'Hi Tom!','2012-01-25 12:32:32',0),(22,18,4,'hi','2012-01-25 15:48:19',1),(23,4,18,'how r u?<br />test<br />now','2012-01-25 15:56:10',1),(24,18,4,'for test','2012-01-25 15:51:58',1),(25,4,18,'klsdfjklsdjf','2012-01-25 15:58:09',0),(26,18,4,'ljklksdjfklsdj','2012-01-25 15:58:29',0),(27,39,12,'hi','2012-01-25 16:25:47',1),(28,12,39,'how r u?','2012-01-25 16:26:13',1),(29,39,12,'ya fine','2012-01-25 16:27:12',1);

/*Table structure for table `tbl_news` */

DROP TABLE IF EXISTS `tbl_news`;

CREATE TABLE `tbl_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_user_id` int(11) NOT NULL,
  `news` varchar(200) NOT NULL,
  `news_flag` int(1) NOT NULL,
  `news_added_time` datetime NOT NULL,
  `news_rel_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_news` */

insert  into `tbl_news`(`news_id`,`news_user_id`,`news`,`news_flag`,`news_added_time`,`news_rel_id`) values (1,4,'Profile',0,'2012-01-10 17:00:16',0),(2,4,'Private',0,'2012-01-10 19:50:40',0),(3,1,'Private',0,'2012-01-11 15:11:01',0),(4,1,'Private',0,'2012-01-11 15:11:04',0),(5,1,'Private',0,'2012-01-11 15:11:06',0),(6,11,'Profile',0,'2012-01-11 17:51:02',0),(7,1,'Private',0,'2012-01-11 20:20:14',0),(8,11,'Profile',0,'2012-01-11 20:52:24',0),(9,1,'Private',0,'2012-01-13 15:47:58',0),(10,12,'Profile',0,'2012-01-16 04:59:19',0),(11,12,'Profile',0,'2012-01-16 05:01:24',0),(12,12,'Profile',0,'2012-01-16 05:01:43',0),(13,12,'Profile',0,'2012-01-16 05:13:33',0),(14,12,'Profile',0,'2012-01-16 08:07:25',0),(15,12,'Profile',0,'2012-01-16 08:13:17',0),(16,12,'Profile',0,'2012-01-16 08:13:31',0),(17,1,'Profile',0,'2012-01-16 08:16:47',0),(18,1,'Profile',0,'2012-01-16 08:17:30',0),(19,1,'Profile',0,'2012-01-16 08:18:13',0),(20,1,'Profile',0,'2012-01-16 08:18:42',0),(21,12,'Public',0,'2012-01-16 14:55:01',0),(22,12,'Public',0,'2012-01-16 14:55:05',0),(23,12,'Public',0,'2012-01-16 14:55:08',0),(24,12,'Public',0,'2012-01-16 14:55:14',0),(25,12,'Public',0,'2012-01-16 14:55:22',0),(26,12,'Public',0,'2012-01-16 14:55:35',0),(27,1,'Public',0,'2012-01-16 15:25:53',0),(28,4,'Profile',0,'2012-01-17 14:40:12',0),(33,4,'Groups',0,'2012-01-20 20:33:19',31),(34,11,'Groups',0,'2012-01-20 20:48:01',32),(35,4,'Groups',0,'2012-01-20 20:49:47',33),(36,4,'Groups',0,'2012-01-20 20:53:51',34),(37,11,'Groups',0,'2012-01-20 20:55:01',35),(38,4,'Groups',0,'2012-01-21 12:59:55',36),(39,4,'Groups',0,'2012-01-23 14:40:58',37),(40,4,'Groups',0,'2012-01-23 14:48:53',38),(51,4,'Group Members',0,'2012-01-23 15:44:38',26),(52,1,'Profile',0,'2012-01-24 06:51:19',0),(53,1,'Profile',0,'2012-01-24 06:57:37',0),(54,1,'Profile',0,'2012-01-24 06:57:40',0),(55,1,'Profile',0,'2012-01-24 06:58:45',0),(56,1,'Profile',0,'2012-01-24 06:58:47',0),(57,1,'Profile',0,'2012-01-24 06:59:43',0),(58,39,'Profile',0,'2012-01-24 07:08:11',0),(59,39,'Profile',0,'2012-01-24 07:08:14',0),(60,39,'Profile',0,'2012-01-24 07:10:42',0),(61,39,'Profile',0,'2012-01-24 07:10:44',0),(62,39,'Profile',0,'2012-01-24 07:13:44',0),(63,1,'Public',0,'2012-01-24 08:42:45',0),(64,1,'Private',0,'2012-01-24 08:42:50',0),(65,4,'Profile',0,'2012-01-24 12:51:33',0),(66,4,'Profile',0,'2012-01-24 12:52:13',0),(69,4,'Profile',0,'2012-01-24 13:15:17',0),(70,4,'Profile',0,'2012-01-24 13:15:19',0),(72,4,'Profile',0,'2012-01-24 13:16:42',0),(73,4,'Profile',0,'2012-01-24 13:16:44',0),(75,4,'Profile',0,'2012-01-24 13:17:38',0),(76,4,'Profile',0,'2012-01-24 13:17:40',0),(77,4,'Profile',0,'2012-01-24 13:21:20',0),(78,4,'Profile',0,'2012-01-24 13:21:22',0),(79,4,'Profile',0,'2012-01-24 13:23:23',0),(80,4,'Profile',0,'2012-01-24 14:06:30',0),(81,4,'Profile',0,'2012-01-24 14:38:14',0),(85,4,'4',0,'2012-01-24 16:25:49',4),(86,4,'4',0,'2012-01-24 16:26:24',4),(87,52,'Public',0,'2012-01-24 20:58:56',0),(89,4,'Profile',0,'2012-01-25 15:01:22',0),(90,4,'Group Members',0,'2012-02-08 15:59:13',29),(91,3,'Groups',0,'2012-02-09 18:38:54',39),(92,3,'Groups',0,'2012-02-09 21:12:03',40),(93,3,'Group Members',0,'2012-02-09 21:13:47',30),(94,4,'Group Members',0,'2012-02-15 15:44:35',31),(95,1,'Groups',0,'2012-03-08 18:00:04',41),(96,12,'Group Members',0,'2012-03-08 21:02:42',33),(97,11,'Group Members',0,'2012-03-08 21:03:42',34),(98,11,'Group Members',0,'2012-03-08 21:04:44',35),(99,18,'Groups',0,'2012-03-09 19:48:15',42),(100,11,'Groups',0,'2012-03-14 17:51:56',43),(101,4,'Group Members',0,'2012-03-14 17:52:29',39);

/*Table structure for table `tbl_news_read` */

DROP TABLE IF EXISTS `tbl_news_read`;

CREATE TABLE `tbl_news_read` (
  `read_id` int(11) NOT NULL AUTO_INCREMENT,
  `read_user_id` int(11) NOT NULL,
  `read_time` datetime NOT NULL,
  PRIMARY KEY (`read_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_news_read` */

insert  into `tbl_news_read`(`read_id`,`read_user_id`,`read_time`) values (1,11,'2012-01-21 11:41:03'),(2,4,'2012-01-21 12:51:29'),(3,1,'2012-01-24 07:55:06'),(4,4,'2012-01-24 16:30:18');

/*Table structure for table `tbl_posting` */

DROP TABLE IF EXISTS `tbl_posting`;

CREATE TABLE `tbl_posting` (
  `posting_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK_Posting ID',
  `topic_id` int(11) DEFAULT NULL,
  `sub_topic_id` int(11) DEFAULT NULL COMMENT 'FK_sub topic id',
  `user_id` int(11) DEFAULT NULL,
  `title` tinytext,
  `post_content` mediumtext,
  `graphic_type` char(1) DEFAULT 'I',
  `image_id` int(11) DEFAULT '0',
  `igallery_id` int(11) DEFAULT '0',
  `video_id` int(11) DEFAULT '0',
  `vgallery_id` int(11) DEFAULT '0',
  `disc_total` int(11) DEFAULT '0',
  `total_read` int(11) DEFAULT '0',
  `recently_viewed` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_on` datetime DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `is_archived` bit(1) DEFAULT NULL,
  PRIMARY KEY (`posting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_posting` */

insert  into `tbl_posting`(`posting_id`,`topic_id`,`sub_topic_id`,`user_id`,`title`,`post_content`,`graphic_type`,`image_id`,`igallery_id`,`video_id`,`vgallery_id`,`disc_total`,`total_read`,`recently_viewed`,`posted_on`,`is_active`,`is_archived`) values (1,3,5,1,'United States federal budget','The Budget of the United States Government is the President\'s proposal to the U.S. Congress which recommends funding levels for the next fiscal year, beginning October 1. Congressional decisions are governed by rules and legislation regarding the federal budget process. Budget committees set spending limits for the House and Senate committees and for Appropriations subcommittees, which then approve individual appropriations bills to allocate funding to various federal programs.<br />\r\n<br />\r\nAfter Congress approves an appropriations bill, it is sent to the President, who may sign it into law, or may veto it. A vetoed bill is sent back to Congress, which can pass it into law with a two-thirds majority in each chamber. Congress may also combine all or some appropriations bills into an omnibus reconciliation bill. In addition, the president may request and the Congress may pass supplemental appropriations bills or emergency supplemental appropriations bills.','I',7,0,0,0,160,161,'2012-01-11 10:16:16','2011-11-30 14:33:59','\0','\0'),(2,3,2,1,'Deficit','A deficit is the amount by which a sum falls short of some reference amount.<br />\r\n<br />\r\nIn economics, a deficit is a shortfall in revenue; in more specific cases it may refer to:<br />\r\n<br />\r\n    Government budget deficit<br />\r\n        Deficit spending<br />\r\n        Primary deficit, the pure deficit derived after deducting the interest payments<br />\r\n        Structural and cyclical deficit, parts of the public sector deficit<br />\r\n    Income deficit, the difference between family income and the poverty threshold<br />\r\n    Trade deficit, when the value of imports exceed the value of exports<br />\r\n    Balance of payments deficit, when the balance of payments is negative<br />\r\n<br />\r\nDeficit may also refer to:<br />\r\n<br />\r\n    Attention deficit hyperactivity disorder, a developmental disorder characterized by attentional problems and hyperactivity<br />\r\n    Cognitive deficit, any characteristic that acts as a barrier to cognitive performance<br />\r\n    Defect (geometry), angular deficit<br />\r\n    Df0069cit, a 2007 Mexican film by Gael Garca0020Bernal<br />\r\n','V',0,0,9,0,15,108,'2012-01-20 13:39:21','2011-12-23 10:24:29','\0','\0'),(3,3,5,1,'House prepares to vote on balanced budget proposal','WASHINGTON (AP) 0 Frustrated by their own failure to halt mounting federal red ink, lawmakers are voting on a balanced budget amendment to the Constitution that would force Congress to hold the fiscal line.<br />\r\n<br />\r\nThe first House vote on a balanced budget amendment in 16 years comes as the separate bipartisan supercommittee appears to be sputtering in its attempt to find at least $1.2 trillion in deficit reduction over the next decade.<br />\r\n<br />\r\nWith the national debt now topping $15 trillion and the deficit for the just-ended fiscal year passing $1 trillion, supporters of the amendment declared it the only way to stop out-of-control spending. The government now must borrow 36 cents for every dollar it spends.<br />\r\n<br />\r\n&quot;It is our last line of defense against Congress\' unending desire to overspend and overtax,&quot; Judiciary Committee Chairman Lamar Smith, R-Texas, said as the House debated the measure.<br />\r\n<br />\r\nBut Democratic leaders have aggressively worked to defeat the measure, saying that such a requirement could cause devastating cuts to social programs during economic downturns and that disputes over what to cut could result in Congress ceding its power of the purse to the courts.<br />\r\n<br />\r\nEven if it passes the House, it faces an uphill fight in the Democratic-controlled Senate.<br />\r\n<br />\r\nThe Democratic argument was joined by 16-term congressman David Dreier of California, who broke ranks with his fellow Republicans to speak against the measure. The Rules Committee chairman said lawmakers should be able to find common ground on deficit reduction without changing the Constitution, and he expressed concern that lawsuits filed when Congress fails to balance the budget could result in courts making decisions on cutting spending or raising taxes.<br />\r\n<br />\r\nThe House passed a similar measure in 1995, with the help of 72 Democrats, but Democratic opposition this time may make it more difficult to reach the needed two-thirds majority for a constitutional amendment. In 1995, the measure fell one vote short of passing the Senate.<br />\r\n<br />\r\nIf approved by both houses, amendments still must also be ratified by three-fourths of the states. The last constitutional amendment ratified, in 1992, concerned lawmaker pay increases.<br />\r\n<br />\r\nThe second-ranking Democrat, Steny Hoyer of Maryland, voted for the amendment in 1995 but said the situation has vastly changed since then. &quot;Republicans have been fiscally reckless,&quot; he asserted, saying the George W. Bush administration would not cut spending elsewhere to pay for the wars in Iraq and Afghanistan, major tax cuts and a Medicare prescription drug benefit.<br />\r\n<br />\r\n&quot;A constitutional amendment is not a path to a balanced budget,&quot; said Rep. Lloyd Doggett, D-Texas. &quot;It is only an excuse for members of this body failing to cast votes to achieve one.&quot;<br />\r\n<br />\r\nDreier is not expected to be the only Republican to defect. Conservatives in the party had pressed for a tougher version that would have also set tight caps on annual spending and required a supermajority to raise taxes.<br />\r\n<br />\r\nThe measure on the floor Friday, sponsored by Rep. Robert Goodlatte, R-Va., mirrors the 1995 resolution in stating that federal spending cannot exceed revenues in any one year. It would require a three-fifths majority to raise the debt ceiling or waive the balanced budget requirement in any year. Congress would be able to let the budget go into deficit with a simple majority if there was a serious military conflict.<br />\r\n<br />\r\nThe Republicans\' hope was that the Goodlatte version would attract more Democratic supporters, and the &quot;Blue Dogs,&quot; a group of fiscally conservative Democrats, said they were on board. But there are now only 25 Blue Dogs, half the number of several years ago when there were more moderate Democrats, mainly from rural areas, in the House.<br />\r\n<br />\r\nRep. Peter DeFazio, an Oregon Democrat who is not a Blue Dog member, said he was supporting the amendment because &quot;there\'s an infinite capacity in this Congress to kick the can down the road. ... We are going to have to force people to make tough decisions.&quot;<br />\r\n<br />\r\nBut other Democrats pointed to a letter from some 275 labor and other mostly liberal groups saying that forcing spending cuts or higher taxes to balance the budget when the economy was slow &quot;would risk tipping a faltering economy into recession or worsening an ongoing downturn, costing large numbers of jobs.&quot;<br />\r\n<br />\r\nDemocrats also cited a report by the liberal Center on Budget and Policy Priorities estimating that, if there is not an increase in revenues, the amendment could force Congress to cut all programs by an average of 17.3 percent by 2018.<br />\r\n<br />\r\nThe amendment would not go into effect until 2017, or two years after it was ratified, and supporters say that would give Congress time to avoid dramatic spending cuts.<br />\r\n<br />\r\nForty-nine states have some sort of balanced budget requirement, although opponents note that states do not have national security and defense costs. States also can still borrow for their capital-spending budgets for long-term infrastructure projects.<br />\r\n<br />\r\nThe federal government has balanced its budget only six times in the past half-century, four times during the Clinton presidency.','I',14,0,0,0,20,121,'2012-01-25 16:19:48','2012-01-25 16:19:47','\0','\0'),(4,3,5,1,'House rejects balanced budget proposal ','WASHINGTON (AP) 2  The House has rejected a proposal to amend the Constitution to require a balanced budget, seen by many as the only way to force lawmakers to hold the fiscal line and reverse the flow of federal red ink.<br />\r\n<br />\r\nThe 261-165 vote was 23 short of the two-thirds majority needed to advance a constitutional amendment. Democrats, swayed by the arguments of their leaders that a balanced budget requirement would force Congress to make devastating cuts to social programs, overwhelmingly voted against it.<br />\r\n<br />\r\nFour Republicans joined the Democrats in opposing the measure.<br />\r\n<br />\r\nThe first House vote on a balanced budget amendment in 16 years comes as the separate bipartisan supercommittee appears to be sputtering in its attempt to find at least $1.2 trillion in deficit reduction over the next decade.<br />\r\n<br />\r\nWith the national debt now topping $15 trillion and the deficit for the just-ended fiscal year passing $1 trillion, supporters of the amendment declared it the only way to stop out-of-control spending. The government now must borrow 36 cents for every dollar it spends.<br />\r\n<br />\r\n&quot;It is our last line of defense against Congress\\\' unending desire to overspend and overtax,&quot; Judiciary Committee Chairman Lamar Smith, R-Texas, said as the House debated the measure.<br />\r\n<br />\r\nBut Democratic leaders worked aggressively to defeat it, saying that such a requirement could force Congress to cut billions from social programs during times of economic downturn and that disputes over what to cut could result in Congress ceding its power of the purse to the courts.<br />\r\n<br />\r\nEven had it passed, the measure would have faced an uphill fight in the Democratic-controlled Senate.<br />\r\n<br />\r\nThe Democratic argument was joined by 16-term congressman David Dreier of California, who broke ranks with his fellow Republicans to speak against the measure. The Rules Committee chairman said lawmakers should be able to find common ground on deficit reduction without changing the Constitution, and he expressed concern that lawsuits filed when Congress fails to balance the budget could result in courts making decisions on cutting spending or raising taxes.<br />\r\n<br />\r\nThe House passed a similar measure in 1995, with the help of 72 Democrats. That year, the measure fell one vote short of passing the Senate. This year, only 25 Democrats supported the proposal.<br />\r\n<br />\r\nConstitutional amendments must get two-thirds majorities in both houses and be ratified by three-fourths of the states. The last constitutional amendment ratified, in 1992, concerned lawmaker pay increases.<br />\r\n<br />\r\nThe second-ranking Democrat, Steny Hoyer of Maryland, voted for the amendment in 1995 but said the situation has vastly changed since then. &quot;Republicans have been fiscally reckless,&quot; he asserted, saying the George W. Bush administration would not cut spending elsewhere to pay for the wars in Iraq and Afghanistan, major tax cuts and a Medicare prescription drug benefit.<br />\r\n<br />\r\n&quot;A constitutional amendment is not a path to a balanced budget,&quot; said Rep. Lloyd Doggett, D-Texas. &quot;It is only an excuse for members of this body failing to cast votes to achieve one.&quot;<br />\r\n<br />\r\nConservatives had pressed for a tougher version of the amendment that would have also set tight caps on annual spending and required a supermajority to raise taxes.<br />\r\n<br />\r\nThe measure on the floor Friday, sponsored by Rep. Robert Goodlatte, R-Va., mirrors the 1995 resolution in stating that federal spending cannot exceed revenues in any one year. It would require a three-fifths majority to raise the debt ceiling or waive the balanced budget requirement in any year. But Congress would be able to let the budget go into deficit with a simple majority if there was a serious military conflict.<br />\r\n<br />\r\nThe Republicans\\\' hope was that the Goodlatte version would attract more Democratic supporters, and the &quot;Blue Dogs,&quot; a group of fiscally conservative Democrats, said they were on board. But there are now only 25 Blue Dogs, half the number of several years ago when there were more moderate Democrats, mainly from rural areas, in the House.<br />\r\n<br />\r\nRep. Peter DeFazio, an Oregon Democrat who is not a Blue Dog member, said he was supporting the amendment because &quot;there\\\'s an infinite capacity in this Congress to kick the can down the road. ... We are going to have to force people to make tough decisions.&quot;<br />\r\n<br />\r\nBut other Democrats pointed to a letter from some 275 labor and other mostly liberal groups saying that forcing spending cuts or higher taxes to balance the budget when the economy was slow &quot;would risk tipping a faltering economy into recession or worsening an ongoing downturn, costing large numbers of jobs.&quot;<br />\r\n<br />\r\nDemocrats also cited a report by the liberal Center on Budget and Policy Priorities estimating that, if there is not an increase in revenues, the amendment could force Congress to cut all programs by an average of 17.3 percent by 2018.<br />\r\n<br />\r\nThe amendment would not have gone into effect until 2017, or two years after it was ratified, and supporters said that would give Congress time to avoid dramatic spending cuts.<br />\r\n<br />\r\nForty-nine states have some sort of balanced budget requirement, although opponents note that states do not have national security and defense costs. States also can still borrow for their capital-spending budgets for long-term infrastructure projects.<br />\r\n<br />\r\nThe federal government has balanced its budget only six times in the past half-century, four times during Bill Clinton\\\'s presidency.','V',0,0,9,0,12,85,'2012-01-25 14:21:36','2012-01-13 13:21:58','\0','\0'),(5,3,3,1,'Provisions of the House balanced budget amendment','AP By The Associated Press | AP  Fri, Nov 18, 2011<br />\r\n<br />\r\nProvisions of the balanced budget amendment rejected by the House on Friday:<br />\r\n<br />\r\nTotal outlays for any fiscal year shall not exceed total receipts.<br />\r\n<br />\r\nA three-fifths majority of both the House and Senate is needed to waive the balanced budget requirement.<br />\r\n<br />\r\nA three-fifths majority of both houses is needed to raise the federal debt limit.<br />\r\n<br />\r\nThe president each year must transmit a balanced budget proposal to Congress.<br />\r\n<br />\r\nCongress can waive the balanced budget requirement by simple majorities when a declaration of war is in effect or there is a serious military threat to national security.<br />\r\n<br />\r\nThe amendment would go into effect the second fiscal year after its ratification or at the beginning of 2017, whichever comes later. There is no deadline imposed for three-fourths of the states to ratify the amendment.<br />\r\n','I',21,0,0,0,18,195,'2012-01-25 15:28:01','2011-12-21 14:10:15','\0','\0'),(37,3,3,1,'222','222','I',7,0,0,0,50,162,'2012-01-18 16:12:24','2011-12-21 14:22:45','\0','\0'),(39,6,14,1,'dsf','sdf','I',24,0,0,0,0,0,'0000-00-00 00:00:00','2012-01-25 16:23:08','\0','\0'),(40,6,14,1,'sdf','sdf','I',23,0,0,0,0,0,'0000-00-00 00:00:00','2012-01-25 16:24:59','\0','\0');

/*Table structure for table `tbl_reply` */

DROP TABLE IF EXISTS `tbl_reply`;

CREATE TABLE `tbl_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `reply_msg_id` int(11) NOT NULL,
  `reply_time` datetime NOT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_reply` */

insert  into `tbl_reply`(`reply_id`,`msg_id`,`reply_msg_id`,`reply_time`) values (1,1,2,'2012-01-05 16:42:16'),(2,3,4,'2012-01-05 16:48:28'),(3,5,6,'2012-01-05 19:08:05'),(4,9,10,'2012-01-11 21:08:06'),(5,10,11,'2012-01-11 21:13:14'),(6,11,12,'2012-01-11 21:21:28'),(7,12,13,'2012-01-11 21:23:18'),(8,13,14,'2012-01-11 21:30:47'),(9,15,16,'2012-01-13 14:37:16'),(10,16,17,'2012-01-13 14:40:08'),(11,17,20,'2012-01-24 23:00:22'),(12,20,22,'2012-01-25 15:48:19'),(13,22,23,'2012-01-25 15:51:13'),(14,23,24,'2012-01-25 15:51:58'),(15,24,25,'2012-01-25 15:58:09'),(16,27,28,'2012-01-25 16:26:13'),(17,28,29,'2012-01-25 16:27:12');

/*Table structure for table `tbl_security_private` */

DROP TABLE IF EXISTS `tbl_security_private`;

CREATE TABLE `tbl_security_private` (
  `private_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `priv_name` int(1) NOT NULL,
  `priv_place` int(1) NOT NULL,
  `priv_status` int(1) NOT NULL,
  `priv_poltifical_affiliation` int(1) NOT NULL,
  `priv_active_involment` int(1) NOT NULL,
  `priv_issues_close_to_heart` int(1) NOT NULL,
  `priv_education` int(1) NOT NULL,
  `priv_profession` int(1) NOT NULL,
  `priv_career` int(1) NOT NULL,
  `priv_hobbies` int(1) NOT NULL,
  `priv_interest` int(1) NOT NULL,
  `priv_family` int(1) NOT NULL,
  `priv_news_stream` int(1) NOT NULL,
  `priv_photographs` int(1) NOT NULL,
  `priv_movies` int(1) NOT NULL,
  `priv_contacts` int(1) NOT NULL,
  `priv_i_Author` int(1) NOT NULL,
  `priv_recommend` int(1) NOT NULL,
  `priv_my_premise` int(1) NOT NULL,
  PRIMARY KEY (`private_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_security_private` */

insert  into `tbl_security_private`(`private_id`,`user_id`,`priv_name`,`priv_place`,`priv_status`,`priv_poltifical_affiliation`,`priv_active_involment`,`priv_issues_close_to_heart`,`priv_education`,`priv_profession`,`priv_career`,`priv_hobbies`,`priv_interest`,`priv_family`,`priv_news_stream`,`priv_photographs`,`priv_movies`,`priv_contacts`,`priv_i_Author`,`priv_recommend`,`priv_my_premise`) values (1,1,1,1,0,1,0,0,1,1,1,0,1,1,1,1,0,1,0,1,1),(2,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(3,3,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(4,4,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(5,6,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(6,9,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(7,11,1,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,1,1,1),(8,12,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(9,30,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(10,31,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(14,35,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(16,37,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(17,38,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(18,39,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(19,40,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(20,41,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(21,42,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(22,43,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(23,44,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(24,45,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(25,46,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(26,47,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(27,48,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(28,49,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(29,50,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(30,51,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(31,52,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(32,53,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(33,54,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(34,55,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(35,56,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(36,57,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(37,58,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(38,59,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(39,60,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(40,61,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(41,62,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(42,63,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(43,64,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(44,65,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(45,66,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(46,67,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(47,68,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(48,69,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(49,70,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(50,71,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(51,72,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(52,73,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(53,74,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(54,75,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(55,76,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(56,77,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(57,78,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(58,79,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(59,80,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(60,81,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(61,82,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(62,83,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(63,84,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(64,85,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(65,86,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(66,87,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(67,88,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(68,53,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(69,54,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);

/*Table structure for table `tbl_security_public` */

DROP TABLE IF EXISTS `tbl_security_public`;

CREATE TABLE `tbl_security_public` (
  `public_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pub_name` int(1) NOT NULL,
  `pub_place` int(1) NOT NULL,
  `pub_status` int(1) NOT NULL,
  `pub_poltifical_affiliation` int(1) NOT NULL,
  `pub_active_involment` int(1) NOT NULL,
  `pub_issues_close_to_heart` int(1) NOT NULL,
  `pub_education` int(1) NOT NULL,
  `pub_profession` int(1) NOT NULL,
  `pub_career` int(1) NOT NULL,
  `pub_hobbies` int(1) NOT NULL,
  `pub_interest` int(1) NOT NULL,
  `pub_family` int(1) NOT NULL,
  `pub_news_stream` int(1) NOT NULL,
  `pub_photographs` int(1) NOT NULL,
  `pub_movies` int(1) NOT NULL,
  `pub_contacts` int(1) NOT NULL,
  `pub_i_Author` int(1) NOT NULL,
  `pub_recommend` int(1) NOT NULL,
  `pub_my_premise` int(1) NOT NULL,
  PRIMARY KEY (`public_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_security_public` */

insert  into `tbl_security_public`(`public_id`,`user_id`,`pub_name`,`pub_place`,`pub_status`,`pub_poltifical_affiliation`,`pub_active_involment`,`pub_issues_close_to_heart`,`pub_education`,`pub_profession`,`pub_career`,`pub_hobbies`,`pub_interest`,`pub_family`,`pub_news_stream`,`pub_photographs`,`pub_movies`,`pub_contacts`,`pub_i_Author`,`pub_recommend`,`pub_my_premise`) values (1,1,1,1,0,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1),(2,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(3,3,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(4,4,0,1,1,1,0,0,1,1,1,1,1,1,1,1,1,1,0,1,1),(5,6,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(6,9,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(7,11,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(8,12,1,1,1,0,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1),(9,30,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(10,31,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(14,35,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(16,37,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(17,38,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(18,39,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(19,40,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(20,41,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(21,42,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(22,43,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(23,44,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(24,45,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(25,46,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(26,47,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(27,48,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(28,49,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(29,50,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(30,51,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(31,52,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(32,53,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(33,54,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(34,55,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(35,56,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(36,57,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(37,58,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(38,59,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(39,60,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(40,61,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(41,62,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(42,63,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(43,64,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(44,65,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(45,66,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(46,67,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(47,68,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(48,69,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(49,70,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(50,71,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(51,72,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(52,73,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(53,74,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(54,75,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(55,76,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(56,77,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(57,78,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(58,79,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(59,80,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(60,81,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(61,82,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(62,83,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(63,84,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(64,85,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(65,86,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(66,87,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(67,88,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(68,53,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(69,54,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);

/*Table structure for table `tbl_session` */

DROP TABLE IF EXISTS `tbl_session`;

CREATE TABLE `tbl_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(100) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sess_start` datetime DEFAULT NULL,
  `sess_expire` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `user_agent` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_session` */

/*Table structure for table `tbl_state` */

DROP TABLE IF EXISTS `tbl_state`;

CREATE TABLE `tbl_state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_abbreviation` varchar(10) NOT NULL,
  `state_name` varchar(200) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_state` */

insert  into `tbl_state`(`state_id`,`state_abbreviation`,`state_name`) values (1,'AL','Alabama'),(2,'AK','Alaska'),(3,'AZ','Arizona'),(4,'AR','Arkansas'),(5,'CA','California'),(6,'CO','Colorado'),(7,'CT','Connecticut'),(8,'DE','Delaware'),(9,'DC','District of Columbia'),(10,'FL','Florida'),(11,'GA','Georgia'),(12,'HI','Hawaii'),(13,'ID','Idaho'),(14,'IL','Illinois'),(15,'IN','Indiana'),(16,'IA','Iowa'),(17,'KS','Kansas'),(18,'KY','Kentucky'),(19,'LA','Louisiana'),(20,'ME','Maine'),(21,'MD','Maryland'),(22,'MA','Massachusetts'),(23,'MI','Michigan'),(24,'MN','Minnesota'),(25,'MS','Mississippi'),(26,'MO','Missouri'),(27,'MT','Montana'),(28,'NE','Nebraska'),(29,'NV','Nevada'),(30,'NH','New Hampshire'),(31,'NJ','New Jersey'),(32,'NM','New Mexico'),(33,'NY','New York'),(34,'NC','North Carolina'),(35,'ND','North Dakota'),(36,'OH','Ohio'),(37,'OK','Oklahoma'),(38,'OR','Oregon'),(39,'PA','Pennsylvania'),(40,'RI','Rhode Island'),(41,'SC','South Carolina'),(42,'SD','South Dakota'),(43,'TN','Tennessee'),(44,'TX','Texas'),(45,'UT','Utah'),(46,'VT','Vermont'),(47,'VA','Virginia'),(48,'WA','Washington'),(49,'WV','West Virginia'),(50,'WI','Wisconsin'),(51,'WY','Wyoming');

/*Table structure for table `tbl_sub_topics` */

DROP TABLE IF EXISTS `tbl_sub_topics`;

CREATE TABLE `tbl_sub_topics` (
  `sub_topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(200) NOT NULL,
  `priority` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  `is_archieved` bit(1) NOT NULL,
  PRIMARY KEY (`sub_topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_sub_topics` */

insert  into `tbl_sub_topics`(`sub_topic_id`,`topic_id`,`user_id`,`title`,`description`,`image`,`priority`,`created_date`,`is_active`,`is_archieved`) values (2,3,0,'HISTORY','HISTORY','tarp.jpg',2,'2011-10-14','','\0'),(3,3,0,'STRUCTURE','STRUCTURE','useconomy.jpg',3,'2011-10-14','','\0'),(4,3,0,'CAUSES','CAUSES','tarp.jpg',1,'2011-10-14','','\0'),(5,3,0,'CONSEQUENCE','CONSEQUENCE ','uscurrency.jpg',4,'2011-10-14','','\0'),(7,2,0,'US Currency','US Currency','uscurrency.jpg',2,'2011-10-14','','\0'),(9,10,0,'ORIGINS','Why?','Water_lilies_12202011081247.jpg',2,'2011-12-20','','\0'),(10,10,0,'OUTLOOK','What awaits us?','Zakynthos_Navagio_Beach_12202011082226.jpg',1,'2011-12-20','','\0'),(13,9,1,'werwer','werwr','Winter_01252012142613.jpg',1,'2012-01-25','','\0'),(14,6,1,'ff','ff','Blue_hills_01252012162013.jpg',1,'2012-01-25','','\0');

/*Table structure for table `tbl_themes` */

DROP TABLE IF EXISTS `tbl_themes`;

CREATE TABLE `tbl_themes` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `for_section` int(11) DEFAULT NULL,
  `img_background` int(1) DEFAULT NULL,
  `pattern` int(1) DEFAULT NULL,
  `defined` int(1) DEFAULT NULL,
  `color_bg` char(10) DEFAULT NULL,
  `color_menu` char(10) DEFAULT NULL,
  `color_sec` char(10) DEFAULT NULL,
  `font_style` char(15) DEFAULT NULL,
  `font_option` char(10) DEFAULT NULL,
  `font_color` char(10) DEFAULT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_themes` */

/*Table structure for table `tbl_topics` */

DROP TABLE IF EXISTS `tbl_topics`;

CREATE TABLE `tbl_topics` (
  `topics_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `title` varchar(50) DEFAULT NULL,
  `description` mediumtext,
  `image` varchar(100) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_archieved` bit(1) DEFAULT b'0',
  PRIMARY KEY (`topics_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_topics` */

insert  into `tbl_topics`(`topics_id`,`user_id`,`title`,`description`,`image`,`priority`,`created_date`,`is_active`,`is_archieved`) values (2,0,'US Currency','US Currency description ','uscurrency.jpg',11,'2011-10-11 00:00:00','','\0'),(3,0,'Federal Budget DeficiT','Federal Budget Deficit description','federal.jpg',8,'2011-10-11 00:00:00','','\0'),(4,0,'US Government','Cras id elit. Integer quis urna. Ut ante enim, dapibus malesuada, fringilla eu, condimentum quis, tellus. Aenean porttitor eros vel dolor. Donec convallis pede venenatis n....\r\n\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\n\r\nDonec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.\r\n\r\nNullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.\r\n\r\nPhasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus.\r\n\r\nMaecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,\r\n','usgovt.jpg',14,'2011-10-11 00:00:00','','\0'),(5,0,'War In Afganistan','','war.jpg',10,'2011-10-11 00:00:00','','\0'),(6,0,'Us Economy','','useconomy.jpg',9,'2011-10-12 00:00:00','','\0'),(7,0,'World Economy','','worldeconomy.jpg',7,'2011-10-12 00:00:00','','\0'),(9,0,'World Population','','worldpop.jpg',13,'2011-10-12 00:00:00','','\0'),(10,0,'Global Climate Change','Global weather change patterns.','Sunset_12202011081712.jpg',12,'2011-12-20 00:00:00','','\0'),(11,0,'U.S. Presidential Elections','Elections','electionIMG_01232012030139.jpg',15,'2012-01-16 00:00:00','','\0'),(12,0,'2012 Elections','','img2012election_01232012030913.jpg',16,'2012-01-23 00:00:00','','\0');

/*Table structure for table `tbl_user_profile` */

DROP TABLE IF EXISTS `tbl_user_profile`;

CREATE TABLE `tbl_user_profile` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_Name` varchar(255) DEFAULT NULL,
  `last_Name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `gender` char(1) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `passw` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `personal_data` mediumtext,
  `interests` mediumtext,
  `favorites` mediumtext,
  `professional_background` varchar(255) DEFAULT NULL,
  `junior_high_school` varchar(255) DEFAULT NULL,
  `high_school` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `postgraduate_college` varchar(255) DEFAULT NULL,
  `previous_employer` varchar(255) DEFAULT NULL,
  `current_employer` varchar(255) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `marital_status` char(1) DEFAULT NULL,
  `languages_known` varchar(255) DEFAULT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  `security_question_id` int(11) DEFAULT NULL,
  `own_question` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `security_question_answer` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `basic_info` mediumtext,
  `is_archieved` bit(1) DEFAULT NULL,
  `career` varchar(255) DEFAULT NULL,
  `political_affiliation` varchar(255) DEFAULT NULL,
  `active_involment` varchar(255) DEFAULT NULL,
  `hobbies` varchar(255) DEFAULT NULL,
  `family` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `issues_close_at_heart` varchar(255) DEFAULT NULL,
  `login_flag` int(1) DEFAULT NULL,
  `ip` varchar(20) DEFAULT '000.000.000.000',
  `session` varchar(100) DEFAULT '',
  `user_agent` varchar(255) DEFAULT '',
  `loggedout` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user_profile` */

insert  into `tbl_user_profile`(`user_id`,`first_Name`,`last_Name`,`date_of_birth`,`email`,`gender`,`location`,`phone`,`passw`,`profile_image`,`profession`,`personal_data`,`interests`,`favorites`,`professional_background`,`junior_high_school`,`high_school`,`college`,`postgraduate_college`,`previous_employer`,`current_employer`,`theme_id`,`marital_status`,`languages_known`,`last_loggedin`,`security_question_id`,`own_question`,`state`,`security_question_answer`,`is_active`,`basic_info`,`is_archieved`,`career`,`political_affiliation`,`active_involment`,`hobbies`,`family`,`status`,`issues_close_at_heart`,`login_flag`,`ip`,`session`,`user_agent`,`loggedout`) values (1,'Test','User',NULL,'test@test.com','f','California',NULL,'password01','77','CFO','','','','',NULL,NULL,'UCLA, Accounting major',NULL,NULL,NULL,NULL,NULL,NULL,'2012-03-14 09:52:54',NULL,NULL,'CA',NULL,'','',NULL,'Cool Enterprises, LLC.','','Animal rescue projects','Books, Movies, Politics','','Offline','Environment protection. Democracy and equality for all.',0,'127.0.0.1','5efcf7f4296d6e2a979c4536d80113e5','ff892f0781e777be7f9959b2f50f62f85fca33de','0000-00-00 00:00:00'),(2,'Srikrishnan','R',NULL,'sri@gmail.com',NULL,NULL,NULL,'welcome123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-04 08:34:24',NULL,NULL,'AL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(3,'Sri','Krishnan',NULL,'sri@e.com','m',NULL,NULL,'123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-03-08 13:08:17',NULL,NULL,'IN',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Offline',NULL,0,'127.0.0.1','3a5ac5a6a7af6900ee7406a9a8f5f619','a9d8fe65955d23ba6bb74078a0cc75bc23bb5a7a','0000-00-00 00:00:00'),(4,'noor','mohamed',NULL,'noormohamed.a@emantras.com','m','AL',NULL,'123','50','web developer','personal',NULL,NULL,NULL,NULL,NULL,'test',NULL,NULL,NULL,NULL,NULL,NULL,'2012-03-13 10:36:39',NULL,NULL,'AL',NULL,'','basic info',NULL,'','','','','','Offline','',0,'127.0.0.1','1a6224081beefabff8cc98c2c8f052f4','4116cf996e127367526acc2cb902c912c260b5e4','0000-00-00 00:00:00'),(6,'abcd','abcd',NULL,'abcd@abcd.com',NULL,NULL,NULL,'abcd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-19 12:30:30',NULL,NULL,'AL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'127.0.0.1','cb1d44718b0309fa7f8515e88b00cff1','076e3553805ad5a1d98880e82b2de186eb63b911','0000-00-00 00:00:00'),(9,'vijay','raj',NULL,'vj@emantras.com','m','Alabama',NULL,'abc',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2011-12-13 06:45:22',NULL,NULL,'AL',NULL,NULL,NULL,NULL,'','','','','','Online','',0,'000.000.000.000','','','0000-00-00 00:00:00'),(11,'Arun','Kumar',NULL,'ar@e.com',NULL,'Alabama',NULL,'123','60','',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2012-03-15 14:44:15',NULL,NULL,'AL',NULL,NULL,'basic',NULL,'','','','','','Online','',0,'127.0.0.1','f5c6991a60ae8cb11a62f8cf6c16c06b','ff892f0781e777be7f9959b2f50f62f85fca33de','2012-03-14 18:14:40'),(12,'Tom','Maher',NULL,'tm@live.com','m','California',NULL,'123','67','Software developer',NULL,NULL,NULL,NULL,NULL,NULL,'Postgraduate',NULL,NULL,NULL,NULL,NULL,NULL,'2012-03-15 14:44:09',NULL,NULL,'CA',NULL,'',NULL,NULL,'NPSys Corp.','Independent','Libertarian Party','History, Writing','Wife Becky & 2 children: Peter and Mary','Online','American democracy heritage.',0,'127.0.0.1','5092481276e991863cd9d4a3d0d59bb2','4116cf996e127367526acc2cb902c912c260b5e4','0000-00-00 00:00:00'),(13,'Sam ','John',NULL,'sam@john.com','m',NULL,NULL,'test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2011-12-10 04:26:25',NULL,NULL,'AL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(14,'test','test',NULL,'tyest@test.com',NULL,NULL,NULL,'123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'*',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'000.000.000.000','','','0000-00-00 00:00:00'),(15,'test','tst',NULL,'14789@test.com',NULL,NULL,NULL,'123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-11 10:30:22',NULL,NULL,'*',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(16,'test','test',NULL,'tewet@yu.co',NULL,NULL,NULL,'789',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'*',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Online',NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(17,'one','one',NULL,'one@one.com','m',NULL,NULL,'one',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2011-12-27 08:49:47',NULL,NULL,'ID',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(18,'present','future',NULL,'p@f.com','m',NULL,NULL,'123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-03-14 10:14:19',NULL,NULL,'IN',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Offline',NULL,0,'127.0.0.1','32b5152b89b4944c48baa4bde0a29c66','a9d8fe65955d23ba6bb74078a0cc75bc23bb5a7a','0000-00-00 00:00:00'),(20,'red','rose',NULL,'red@rose.com','f',NULL,NULL,'redrose',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-13 10:06:41',NULL,NULL,'MI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(30,'sun','flower',NULL,'sunflower@test.com','f',NULL,NULL,'sunflower',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-13 11:09:24',NULL,NULL,'OR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(31,'one','two',NULL,'one@test.com','m',NULL,NULL,'one',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'IN',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(35,'test123','test123',NULL,'test123@test.com','f',NULL,NULL,'test123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'IA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(37,'xyz','123',NULL,'xyz@123.com','f',NULL,NULL,'123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(38,'Senthil','kumar',NULL,'senthil090680@gmail.com','m',NULL,NULL,'sen123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'TX',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'000.000.000.000','','','0000-00-00 00:00:00'),(39,'Lilian','Young',NULL,'mhoccal@live.com','f',NULL,NULL,'lili222','78','Accountant',NULL,NULL,NULL,NULL,NULL,NULL,'B.c.',NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 10:52:20',NULL,NULL,'FL',NULL,NULL,NULL,NULL,'Ernst&Young','','Save the Whales','Animal rescue','Single','Online','Preservation and protection of life in global oceans.',0,'118.102.230.227','1c35f79bfaf2083b083c97836d2e7fd0','ff892f0781e777be7f9959b2f50f62f85fca33de','0000-00-00 00:00:00'),(40,'Peter','Orski',NULL,'mikeoccal@hotmail1.com','m',NULL,NULL,'t927801',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'000.000.000.000','','','0000-00-00 00:00:00'),(41,'Peter','Orski',NULL,'mikeoccal@hotmail.com','m',NULL,NULL,'t92780',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 09:41:05',NULL,NULL,'CO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'118.102.230.227','1c35f79bfaf2083b083c97836d2e7fd0','ff892f0781e777be7f9959b2f50f62f85fca33de','0000-00-00 00:00:00'),(52,'hi','hello',NULL,'hi@hello.com','m',NULL,NULL,'hihello',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 10:42:18',NULL,NULL,'ID',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'118.102.230.227','4e096d96bd9025105fc3e08e0d82ed0e','076e3553805ad5a1d98880e82b2de186eb63b911','0000-00-00 00:00:00'),(53,'Good','One',NULL,'senthil_aya@yahoo.com','m',NULL,NULL,'pass1234',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'TX',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'000.000.000.000','','','0000-00-00 00:00:00'),(54,'Good','One',NULL,'senthil_aya@yahoo.com','m',NULL,NULL,'pass1234',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'TX',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'000.000.000.000','','','0000-00-00 00:00:00');

/*Table structure for table `tbl_vgallery` */

DROP TABLE IF EXISTS `tbl_vgallery`;

CREATE TABLE `tbl_vgallery` (
  `vgallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `vgallery_name` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `date_last_updated` datetime DEFAULT NULL,
  `is_deleted` int(1) DEFAULT NULL,
  `vgallery_description` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `is_archieved` bit(1) DEFAULT NULL,
  PRIMARY KEY (`vgallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_vgallery` */

insert  into `tbl_vgallery`(`vgallery_id`,`user_id`,`vgallery_name`,`date_uploaded`,`date_last_updated`,`is_deleted`,`vgallery_description`,`is_active`,`is_archieved`) values (1,1,'Cars_1','2011-11-29 22:37:08','2011-11-29 22:37:08',NULL,NULL,'',NULL),(2,13,'Videos_13','2011-12-10 11:51:15','2011-12-10 11:51:15',NULL,NULL,'',NULL),(3,13,'Test_13','2011-12-10 11:53:18','2011-12-10 11:53:18',NULL,NULL,'',NULL),(6,13,'Cool_13','2011-12-10 11:53:53','2011-12-10 11:53:53',NULL,NULL,'',NULL),(7,13,'Tour_13','2011-12-10 11:58:13','2011-12-10 11:58:13',NULL,NULL,'',NULL);

/*Table structure for table `tbl_videos` */

DROP TABLE IF EXISTS `tbl_videos`;

CREATE TABLE `tbl_videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `vgallery_id` int(11) NOT NULL,
  `video_name` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `date_last_updated` datetime DEFAULT NULL,
  `video_description` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `is_archieved` bit(1) DEFAULT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_videos` */

insert  into `tbl_videos`(`video_id`,`user_id`,`vgallery_id`,`video_name`,`date_uploaded`,`date_last_updated`,`video_description`,`is_active`,`is_archieved`) values (9,1,1,'1322586534_Audi1_8213_11292011170908.flv','2011-11-29 22:39:08','2011-11-29 22:39:08',NULL,'',NULL),(20,13,0,'1323499323_Audi1_8213_12102011064221.flv','2011-12-10 12:12:21','2011-12-10 12:12:21',NULL,'',NULL),(21,13,0,'1323499382_ext_6386_12102011064303.flv','2011-12-10 12:13:03','2011-12-10 12:13:03',NULL,'',NULL),(22,11,0,'1324035564_chevy1_12162011113932.flv','2011-12-16 17:09:35','2011-12-16 17:09:35',NULL,'',NULL);

/* Procedure structure for procedure `get_gender` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_gender` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `get_gender`()
BEGIN
	SELECT gender_abbreviation,gender_name FROM tbl_gender;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `get_states` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_states` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `get_states`()
BEGIN
	SELECT state_abbreviation,state_name FROM tbl_state;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

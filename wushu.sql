/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.8-log : Database - wushu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wushu` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `wushu`;

/*Table structure for table `acceso` */

DROP TABLE IF EXISTS `acceso`;

CREATE TABLE `acceso` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegPer` int(11) NOT NULL,
  `NRegMen` int(11) NOT NULL,
  `Opciones` varchar(50) NOT NULL,
  `Estatus` varchar(50) NOT NULL,
  PRIMARY KEY (`NRegistro`),
  KEY `NRegPer` (`NRegPer`),
  KEY `NRegMen` (`NRegMen`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=latin1;

/*Data for the table `acceso` */

insert  into `acceso`(`NRegistro`,`NRegPer`,`NRegMen`,`Opciones`,`Estatus`) values (1,16,3,'S-S-S-S-S-S-S-S','ACTIVO'),(2,16,4,'S-S-S-S-S-S-S-S','ACTIVO'),(3,16,5,'S-S-S-S-S-S-S-S','ACTIVO'),(4,16,6,'S-S-S-S-S-S-S-S','ACTIVO'),(5,16,7,'S-S-S-S-S-S-S-S','ACTIVO'),(6,16,8,'S-S-S-S-S-S-S-S','ACTIVO'),(7,16,9,'S-S-S-S-S-S-S-S','ACTIVO'),(8,16,10,'S-N-S-N-S-N-N-S','ACTIVO'),(9,16,11,'S-S-S-S-S-S-S-S','ACTIVO'),(10,16,12,'S-S-S-S-S-S-S-S','ACTIVO'),(11,16,13,'S-S-S-S-S-S-S-S','ACTIVO'),(12,16,14,'S-S-S-S-S-S-S-S','ACTIVO'),(13,17,3,'S-S-S-S-S-S-S-S','ACTIVO'),(14,17,4,'S-S-S-S-S-S-S-S','ACTIVO'),(15,17,5,'S-S-S-S-S-S-S-S','ACTIVO'),(16,17,6,'S-S-S-S-S-S-S-S','ACTIVO'),(17,17,7,'S-S-S-S-S-S-S-S','ACTIVO'),(18,17,8,'S-S-S-S-S-S-S-S','ACTIVO'),(19,17,9,'S-S-S-S-S-S-S-S','INACTIVO'),(20,17,10,'S-N-S-N-S-N-N-S','ACTIVO'),(21,17,11,'S-S-S-S-S-S-S-S','ACTIVO'),(22,17,12,'S-S-S-S-S-S-S-S','ACTIVO'),(23,17,13,'S-S-S-S-S-S-S-S','ACTIVO'),(24,17,14,'S-S-S-S-S-S-S-S','ACTIVO'),(97,16,45,'S-S-S-S-S-S-S-S','ACTIVO'),(98,16,46,'S-S-S-S-S-S-S-S','ACTIVO'),(99,16,47,'S-S-S-S-S-S-S-S','ACTIVO'),(100,17,45,'S-S-S-S-S-S-S-S','ACTIVO'),(101,17,46,'S-S-S-S-S-S-S-S','ACTIVO'),(102,17,47,'S-S-S-S-S-S-S-S','ACTIVO'),(104,43,4,'S-S-S-S-S-S-S-S','ACTIVO'),(105,43,5,'S-S-S-S-S-S-S-S','ACTIVO'),(106,43,8,'S-S-S-S-S-S-S-S','ACTIVO'),(107,43,13,'S-S-S-S-S-S-S-S','ACTIVO'),(108,43,14,'S-S-S-S-S-S-S-S','ACTIVO'),(112,44,5,'S-S-S-S-S-S-S-S','ACTIVO'),(113,44,8,'S-S-S-S-S-S-S-S','ACTIVO'),(114,44,13,'S-S-S-S-S-S-S-S','ACTIVO'),(115,44,14,'S-S-S-S-S-S-S-S','ACTIVO'),(117,16,49,'S-S-S-S-S-S-S-S','ACTIVO'),(118,16,50,'S-S-S-S-S-S-S-S','ACTIVO'),(119,16,51,'S-S-S-S-S-S-S-S','ACTIVO'),(120,16,52,'S-S-S-S-S-S-S-S','ACTIVO'),(121,16,53,'S-S-S-S-S-S-S-S','ACTIVO'),(122,16,54,'S-S-S-S-S-S-S-S','ACTIVO'),(123,16,55,'S-S-S-S-S-S-S-S','ACTIVO'),(124,16,56,'S-S-S-S-S-S-S-S','ACTIVO'),(125,17,49,'S-S-S-S-S-S-S-S','ACTIVO'),(126,17,50,'S-S-S-S-S-S-S-S','ACTIVO'),(127,17,51,'S-S-S-S-S-S-S-S','ACTIVO'),(128,17,52,'S-S-S-S-S-S-S-S','ACTIVO'),(129,17,53,'S-S-S-S-S-S-S-S','ACTIVO'),(130,17,54,'S-S-S-S-S-S-S-S','ACTIVO'),(131,17,55,'S-S-S-S-S-S-S-S','ACTIVO'),(132,17,56,'S-S-S-S-S-S-S-S','ACTIVO'),(133,43,49,'S-S-S-S-S-S-S-S','ACTIVO'),(134,43,50,'S-S-S-S-S-S-S-S','ACTIVO'),(135,43,51,'S-S-S-S-S-S-S-S','ACTIVO'),(141,16,57,'S-S-S-S-S-S-S-S','ACTIVO'),(142,16,58,'S-S-S-S-S-S-S-S','ACTIVO'),(143,16,59,'S-S-S-S-S-S-S-S','ACTIVO'),(144,16,60,'S-S-S-S-S-S-S-S','ACTIVO'),(145,17,57,'S-S-S-S-S-S-S-S','ACTIVO'),(146,17,58,'S-S-S-S-S-S-S-S','ACTIVO'),(147,17,59,'S-S-S-S-S-S-S-S','ACTIVO'),(148,17,60,'S-S-S-S-S-S-S-S','ACTIVO'),(149,43,57,'S-S-S-S-S-S-S-S','ACTIVO'),(153,16,61,'S-S-S-S-S-S-S-S','ACTIVO'),(154,17,61,'S-S-S-S-S-S-S-S','ACTIVO'),(155,16,62,'S-S-S-S-S-S-S-S','ACTIVO'),(156,17,62,'S-S-S-S-S-S-S-S','ACTIVO'),(157,16,63,'S-S-S-S-S-S-S-S','ACTIVO'),(158,17,63,'S-S-S-S-S-S-S-S','ACTIVO'),(159,16,64,'S-S-S-S-S-S-S-S','ACTIVO'),(160,17,64,'S-S-S-S-S-S-S-S','ACTIVO'),(161,16,65,'S-S-S-S-S-S-S-S','ACTIVO'),(162,16,66,'S-S-S-S-S-S-S-S','ACTIVO'),(163,17,65,'S-S-S-S-S-S-S-S','ACTIVO'),(164,17,66,'S-S-S-S-S-S-S-S','ACTIVO'),(165,43,63,'S-S-S-S-S-S-S-S','ACTIVO'),(166,43,65,'S-S-S-S-S-S-S-S','ACTIVO'),(167,43,66,'S-S-S-S-S-S-S-S','ACTIVO'),(168,43,64,'S-S-S-S-S-S-S-S','ACTIVO'),(169,44,57,'S-S-S-S-S-S-S-S','ACTIVO'),(170,44,63,'S-S-S-S-S-S-S-S','ACTIVO'),(171,44,64,'S-S-S-S-S-S-S-S','ACTIVO'),(172,44,65,'S-S-S-S-S-S-S-S','ACTIVO'),(173,44,66,'S-S-S-S-S-S-S-S','ACTIVO');

/*Table structure for table `asociaciones` */

DROP TABLE IF EXISTS `asociaciones`;

CREATE TABLE `asociaciones` (
  `id_asociacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `representante` varchar(50) NOT NULL,
  `cod_telrep` int(11) DEFAULT NULL,
  `tel_rep` varchar(7) NOT NULL,
  `email_rep` varchar(50) NOT NULL,
  `estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`id_asociacion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `asociaciones` */

insert  into `asociaciones`(`id_asociacion`,`nombre`,`cod_telefono`,`telefono`,`email`,`direccion`,`representante`,`cod_telrep`,`tel_rep`,`email_rep`,`estatus`) values (1,'Aragua',1,'2677554','aragua@gmail.com','Maracay','Jorge Ramos',3,'6690401','jorge@gmail.com','Activo'),(2,'Merida',2,'6564545','merida@gmail.com','El Vijia','Luis Marcano',2,'5455454','luism@hotmail.com','Inactivo'),(3,'Anzoategui',4,'1254879','solmar@gmail.com','dgfgf','Marisol Gomez',2,'4554545','mar@hotmail.com','Activo'),(4,'Maracaibo',2,'5676576','taecon@hotmailcom','Caja Seca','Luis Perez',2,'6787878','luis@gmail.com','Inactivo'),(5,'',0,'','','','',0,'','','Activo');

/*Table structure for table `atletas` */

DROP TABLE IF EXISTS `atletas`;

CREATE TABLE `atletas` (
  `num_registro` int(11) NOT NULL AUTO_INCREMENT,
  `nacionalidad` enum('V','E') DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `pasaporte` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fechnac` date NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` text NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `ocupacion` varchar(50) NOT NULL,
  `id_asociacion` int(11) NOT NULL,
  `patologias` text NOT NULL,
  `alergias` text NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `peso` varchar(20) NOT NULL,
  `tal_zap` varchar(20) NOT NULL,
  `tal_pan` varchar(20) NOT NULL,
  `tal_cam` varchar(20) NOT NULL,
  `tal_pet` varchar(20) NOT NULL,
  `padre` varchar(50) NOT NULL,
  `cod_telpadre` int(11) DEFAULT NULL,
  `tel_padre` varchar(7) NOT NULL,
  `madre` varchar(50) NOT NULL,
  `cod_telmadre` int(11) DEFAULT NULL,
  `tel_madre` varchar(7) NOT NULL,
  `estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`num_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `atletas` */

insert  into `atletas`(`num_registro`,`nacionalidad`,`cedula`,`pasaporte`,`nombre`,`fechnac`,`sexo`,`cod_telefono`,`telefono`,`email`,`direccion`,`id_nivel`,`ocupacion`,`id_asociacion`,`patologias`,`alergias`,`id_tipo`,`peso`,`tal_zap`,`tal_pan`,`tal_cam`,`tal_pet`,`padre`,`cod_telpadre`,`tel_padre`,`madre`,`cod_telmadre`,`tel_madre`,`estatus`) values (1,'V',7186419,'v-7186419','Maria Linares','1952-09-03','Femenino',2,'0424-32','marai@gmail.com','Turmero',1,'Costurera',1,'Ninguna','Al Polvo',1,'70KG','34','354','454','545','Holaaaaaaaa',1,'0412-26','aquiiiiii',2,'0416-56','activo'),(2,'V',13575772,'v-13575772','Yergiroska Aguirre','1999-06-22','Femenino',2,'0412-32','yer@hotmail.com','palo negro',3,'albañil',3,'ninguna','ninguna',2,'84kg','12','12','12','12','maria',1,'0412-15','carlos',2,'0412-21','activo'),(3,'E',15646508,'E-15649505','Manuel Ruiz','1999-06-20','Masculino',1,'5657567','manuel@gmail.com','Maracay',1,'Estudiante',1,'ninguna','ninguna',2,'79kg','m','m','m','m','rosa',2,'7678787','pedro',3,'7676878','inactivo'),(4,'V',14569877,'v-14569877','Pedro Ordoñez','1978-06-07','Masculino',1,'2677735','pedro@hotmail.com','Palo Negro',4,'Oficinista',3,'Ninguna','Ninguna',2,'75kg','s','s','s','s','Dilia Perez',2,'8787878','Pedro Soto',2,'8787878','activo'),(5,'V',14382695,'5786435799','Alexander','1995-11-16','Masculino',0,'','','',0,'',0,'','',0,'','','','','','',0,'','',0,'','activo');

/*Table structure for table `auditoria` */

DROP TABLE IF EXISTS `auditoria`;

CREATE TABLE `auditoria` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(50) NOT NULL DEFAULT '',
  `Accion` varchar(255) NOT NULL DEFAULT '',
  `Hora` time NOT NULL DEFAULT '00:00:00',
  `Fecha` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`NRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

/*Data for the table `auditoria` */

insert  into `auditoria`(`NRegistro`,`Usuario`,`Accion`,`Hora`,`Fecha`) values (1,'Erick Deffitt','Salir de Sistema','14:25:38','2013-08-27'),(2,'Admin','Inicio de Sistema','14:25:41','2013-08-27'),(3,'Admin','Salir de Sistema','14:25:54','2013-08-27'),(4,'SUPERADMINISTRADOR','Inicio de Sistema','14:26:02','2013-08-27'),(5,'SUPERADMINISTRADOR','Salir de Sistema','14:31:30','2013-08-27'),(6,'PRESTAMOS','Inicio de Sistema','14:31:32','2013-08-27'),(7,'PRESTAMOS','Salir de Sistema','14:31:44','2013-08-27'),(8,'SUPERADMINISTRADOR','Inicio de Sistema','14:31:49','2013-08-27'),(9,'SUPERADMINISTRADOR','Salir de Sistema','14:33:18','2013-08-27'),(10,'CONTABILIDAD','Inicio de Sistema','14:33:22','2013-08-27'),(11,'CONTABILIDAD','Salir de Sistema','14:33:25','2013-08-27'),(12,'SUPERADMINISTRADOR','Inicio de Sistema','14:33:32','2013-08-27'),(13,'SUPERADMINISTRADOR','Salir de Sistema','14:33:36','2013-08-27'),(14,'SUPERADMINISTRADOR','Inicio de Sistema','14:33:41','2013-08-27'),(15,'SUPERADMINISTRADOR','Salir de Sistema','15:44:13','2013-08-27'),(16,'Admin','Inicio de Sistema','15:44:15','2013-08-27'),(17,'Admin','Salir de Sistema','15:44:22','2013-08-27'),(18,'SUPERADMINISTRADOR','Inicio de Sistema','15:44:28','2013-08-27'),(19,'SUPERADMINISTRADOR','Salir de Sistema','15:46:45','2013-08-27'),(20,'PRESTAMOS','Inicio de Sistema','15:46:48','2013-08-27'),(21,'PRESTAMOS','Salir de Sistema','15:46:53','2013-08-27'),(22,'SUPERADMINISTRADOR','Inicio de Sistema','15:46:59','2013-08-27'),(23,'SUPERADMINISTRADOR','Salir de Sistema','15:48:45','2013-08-27'),(24,'CONTABILIDAD','Inicio de Sistema','15:48:51','2013-08-27'),(25,'CONTABILIDAD','Salir de Sistema','15:48:57','2013-08-27'),(26,'SUPERADMINISTRADOR','Inicio de Sistema','15:49:04','2013-08-27'),(27,'SUPERADMINISTRADOR','Salir de Sistema','15:58:05','2013-08-27'),(28,'Admin','Inicio de Sistema','15:58:08','2013-08-27'),(29,'Admin','Salir de Sistema','15:58:10','2013-08-27'),(30,'SUPERADMINISTRADOR','Inicio de Sistema','15:58:19','2013-08-27'),(31,'SUPERADMINISTRADOR','Salir de Sistema','15:58:47','2013-08-27'),(32,'PRESTAMOS','Inicio de Sistema','15:58:50','2013-08-27'),(33,'PRESTAMOS','Salir de Sistema','15:58:57','2013-08-27'),(34,'SUPERADMINISTRADOR','Inicio de Sistema','15:59:03','2013-08-27'),(35,'SUPERADMINISTRADOR','Salir de Sistema','15:59:52','2013-08-27'),(36,'CONTABILIDAD','Inicio de Sistema','15:59:55','2013-08-27'),(37,'CONTABILIDAD','Salir de Sistema','16:00:07','2013-08-27'),(38,'SUPERADMINISTRADOR','Inicio de Sistema','16:00:16','2013-08-27'),(39,'SUPERADMINISTRADOR','Inicio de Sistema','16:37:03','2013-08-27'),(40,'SUPERADMINISTRADOR','Inicio de Sistema','11:01:30','2013-10-21'),(41,'SUPERADMINISTRADOR','Inicio de Sistema','11:56:09','2013-10-21'),(42,'SUPERADMINISTRADOR','Inicio de Sistema','11:56:24','2013-10-21'),(43,'SUPERADMINISTRADOR','Inicio de Sistema','12:03:27','2013-10-21'),(44,'SUPERADMINISTRADOR','Inicio de Sistema','12:03:50','2013-10-21'),(45,'SUPERADMINISTRADOR','Inicio de Sistema','14:21:38','2013-10-21'),(46,'SUPERADMINISTRADOR','Inicio de Sistema','14:22:26','2013-10-21'),(47,'SUPERADMINISTRADOR','Inicio de Sistema','15:53:29','2013-10-21'),(48,'SUPERADMINISTRADOR','Inicio de Sistema','15:54:15','2013-10-21'),(49,'SUPERADMINISTRADOR','Inicio de Sistema','16:43:40','2013-10-21'),(50,'SUPERADMINISTRADOR','Inicio de Sistema','17:57:34','2013-10-21'),(51,'SUPERADMINISTRADOR','Inicio de Sistema','17:59:00','2013-10-21'),(52,'SUPERADMINISTRADOR','Inicio de Sistema','18:00:24','2013-10-21'),(53,'SUPERADMINISTRADOR','Inicio de Sistema','18:02:21','2013-10-21'),(54,'SUPERADMINISTRADOR','Inicio de Sistema','18:24:52','2013-10-21'),(55,'SUPERADMINISTRADOR','Salir de Sistema','18:32:25','2013-10-21'),(56,'SUPERADMINISTRADOR','Inicio de Sistema','10:38:31','2013-10-22'),(57,'SUPERADMINISTRADOR','Salir de Sistema','10:55:51','2013-10-22'),(58,'ADMIN','Inicio de Sistema','10:55:56','2013-10-22'),(59,'ADMIN','Salir de Sistema','10:56:01','2013-10-22'),(60,'SUPERADMINISTRADOR','Inicio de Sistema','10:56:10','2013-10-22'),(61,'SUPERADMINISTRADOR','Inicio de Sistema','11:03:28','2013-10-22'),(62,'SUPERADMINISTRADOR','Inicio de Sistema','11:43:53','2013-10-22'),(63,'SUPERADMINISTRADOR','Inicio de Sistema','16:05:08','2013-10-28'),(64,'SUPERADMINISTRADOR','Inicio de Sistema','17:37:06','2013-10-28'),(65,'SUPERADMINISTRADOR','Inicio de Sistema','17:37:51','2013-10-28'),(66,'SUPERADMINISTRADOR','Inicio de Sistema','09:34:21','2013-11-05'),(67,'SUPERADMINISTRADOR','Inicio de Sistema','16:45:45','2013-11-23'),(68,'SUPERADMINISTRADOR','Inicio de Sistema','17:00:47','2013-11-23'),(69,'SUPERADMINISTRADOR','Inicio de Sistema','17:02:14','2013-11-23'),(70,'SUPERADMINISTRADOR','Inicio de Sistema','17:07:12','2013-11-23'),(71,'SUPERADMINISTRADOR','Inicio de Sistema','17:08:36','2013-11-23'),(72,'SUPERADMINISTRADOR','Inicio de Sistema','17:10:03','2013-11-23'),(73,'SUPERADMINISTRADOR','Inicio de Sistema','17:16:09','2013-11-23'),(74,'SUPERADMINISTRADOR','Inicio de Sistema','17:28:46','2013-11-23'),(75,'SUPERADMINISTRADOR','Inicio de Sistema','17:29:20','2013-11-23'),(76,'SUPERADMINISTRADOR','Inicio de Sistema','17:30:36','2013-11-23'),(77,'SUPERADMINISTRADOR','Inicio de Sistema','17:45:11','2013-11-23'),(78,'SUPERADMINISTRADOR','Inicio de Sistema','17:46:21','2013-11-23'),(79,'SUPERADMINISTRADOR','Inicio de Sistema','18:06:19','2013-11-23'),(80,'SUPERADMINISTRADOR','Inicio de Sistema','18:08:10','2013-11-23'),(81,'SUPERADMINISTRADOR','Inicio de Sistema','18:43:51','2013-11-23'),(82,'SUPERADMINISTRADOR','Inicio de Sistema','18:44:41','2013-11-23'),(83,'SUPERADMINISTRADOR','Inicio de Sistema','18:50:44','2013-11-23'),(84,'SUPERADMINISTRADOR','Inicio de Sistema','18:51:01','2013-11-23'),(85,'SUPERADMINISTRADOR','Inicio de Sistema','18:52:29','2013-11-23'),(86,'SUPERADMINISTRADOR','Inicio de Sistema','18:53:11','2013-11-23'),(87,'SUPERADMINISTRADOR','Inicio de Sistema','19:23:04','2013-11-23'),(88,'SUPERADMINISTRADOR','Inicio de Sistema','19:24:04','2013-11-23'),(89,'SUPERADMINISTRADOR','Inicio de Sistema','19:25:02','2013-11-23'),(90,'SUPERADMINISTRADOR','Inicio de Sistema','19:26:19','2013-11-23'),(91,'SUPERADMINISTRADOR','Inicio de Sistema','14:13:58','2013-11-25'),(92,'SUPERADMINISTRADOR','Inicio de Sistema','14:14:01','2013-11-25'),(93,'SUPERADMINISTRADOR','Inicio de Sistema','14:14:59','2013-11-25'),(94,'SUPERADMINISTRADOR','Inicio de Sistema','14:20:36','2013-11-25'),(95,'SUPERADMINISTRADOR','Inicio de Sistema','14:23:11','2013-11-25'),(96,'SUPERADMINISTRADOR','Inicio de Sistema','14:25:52','2013-11-25'),(97,'SUPERADMINISTRADOR','Inicio de Sistema','14:29:09','2013-11-25'),(98,'SUPERADMINISTRADOR','Inicio de Sistema','14:33:47','2013-11-25'),(99,'SUPERADMINISTRADOR','Inicio de Sistema','14:37:55','2013-11-25'),(100,'SUPERADMINISTRADOR','Inicio de Sistema','14:38:42','2013-11-25'),(101,'SUPERADMINISTRADOR','Inicio de Sistema','14:40:26','2013-11-25'),(102,'SUPERADMINISTRADOR','Inicio de Sistema','14:45:07','2013-11-25'),(103,'SUPERADMINISTRADOR','Inicio de Sistema','14:45:59','2013-11-25'),(104,'SUPERADMINISTRADOR','Inicio de Sistema','14:46:50','2013-11-25'),(105,'SUPERADMINISTRADOR','Inicio de Sistema','14:48:28','2013-11-25'),(106,'SUPERADMINISTRADOR','Inicio de Sistema','14:49:53','2013-11-25'),(107,'SUPERADMINISTRADOR','Inicio de Sistema','14:52:53','2013-11-25'),(108,'SUPERADMINISTRADOR','Inicio de Sistema','14:54:03','2013-11-25'),(109,'SUPERADMINISTRADOR','Inicio de Sistema','14:54:57','2013-11-25'),(110,'SUPERADMINISTRADOR','Inicio de Sistema','14:55:41','2013-11-25'),(111,'SUPERADMINISTRADOR','Inicio de Sistema','14:56:29','2013-11-25'),(112,'SUPERADMINISTRADOR','Inicio de Sistema','14:57:01','2013-11-25'),(113,'SUPERADMINISTRADOR','Inicio de Sistema','14:57:31','2013-11-25'),(114,'SUPERADMINISTRADOR','Inicio de Sistema','14:59:08','2013-11-25'),(115,'SUPERADMINISTRADOR','Inicio de Sistema','15:01:09','2013-11-25'),(116,'SUPERADMINISTRADOR','Inicio de Sistema','15:08:59','2013-11-25'),(117,'SUPERADMINISTRADOR','Inicio de Sistema','15:10:29','2013-11-25'),(118,'SUPERADMINISTRADOR','Salir de Sistema','15:17:36','2013-11-25'),(119,'ADMIN','Inicio de Sistema','15:17:41','2013-11-25'),(120,'ADMIN','Salir de Sistema','15:17:45','2013-11-25'),(121,'SUPERADMINISTRADOR','Inicio de Sistema','15:17:51','2013-11-25'),(122,'SUPERADMINISTRADOR','Salir de Sistema','15:30:15','2013-11-25'),(123,'TECNICO','Inicio de Sistema','15:30:21','2013-11-25'),(124,'TECNICO','Salir de Sistema','15:30:28','2013-11-25'),(125,'SUPERADMINISTRADOR','Inicio de Sistema','15:30:34','2013-11-25'),(126,'SUPERADMINISTRADOR','Salir de Sistema','15:32:50','2013-11-25'),(127,'OPERADOR','Inicio de Sistema','15:32:55','2013-11-25'),(128,'OPERADOR','Salir de Sistema','15:32:57','2013-11-25'),(129,'SUPERADMINISTRADOR','Inicio de Sistema','15:33:09','2013-11-25'),(130,'SUPERADMINISTRADOR','Inicio de Sistema','15:52:56','2013-11-25'),(131,'SUPERADMINISTRADOR','Inicio de Sistema','15:53:28','2013-11-25'),(132,'SUPERADMINISTRADOR','Inicio de Sistema','15:54:15','2013-11-25'),(133,'TECNICO','Inicio de Sistema','16:02:21','2013-11-25'),(134,'TECNICO','Salir de Sistema','16:02:32','2013-11-25'),(135,'TECNICO','Inicio de Sistema','16:02:42','2013-11-25'),(136,'TECNICO','Salir de Sistema','16:02:57','2013-11-25'),(137,'TECNICO','Inicio de Sistema','16:03:01','2013-11-25'),(138,'TECNICO','Salir de Sistema','16:03:02','2013-11-25'),(139,'SUPERADMINISTRADOR','Inicio de Sistema','22:12:59','2014-04-17'),(140,'SUPERADMINISTRADOR','Salir de Sistema','22:13:55','2014-04-17'),(141,'ADMIN','Inicio de Sistema','22:14:01','2014-04-17'),(142,'ADMIN','Salir de Sistema','22:14:06','2014-04-17'),(143,'OPERADOR','Inicio de Sistema','22:14:11','2014-04-17'),(144,'OPERADOR','Inicio de Sistema','22:15:08','2014-04-17'),(145,'TECNICO','Inicio de Sistema','22:15:52','2014-04-17'),(146,'TECNICO','Salir de Sistema','22:18:46','2014-04-17'),(147,'ADMIN','Inicio de Sistema','22:18:57','2014-04-17'),(148,'ADMIN','Inicio de Sistema','10:59:19','2014-04-18'),(149,'ADMIN','Salir de Sistema','11:01:45','2014-04-18'),(150,'','Inicio de Sistema','13:22:07','2014-04-18'),(151,'','Inicio de Sistema','15:18:15','2014-04-18'),(152,'','Inicio de Sistema','15:20:13','2014-04-18'),(153,'','Inicio de Sistema','19:58:50','2014-04-19'),(154,'','Inicio de Sistema','17:39:47','2014-04-20'),(155,'','Inicio de Sistema','19:16:05','2014-04-20'),(156,'','Inicio de Sistema','11:08:22','2014-04-22'),(157,'','Inicio de Sistema','14:00:09','2014-04-22'),(158,'','Inicio de Sistema','22:22:12','2014-04-22'),(159,'','Inicio de Sistema','17:23:31','2014-04-23'),(160,'','Inicio de Sistema','16:38:14','2014-05-01'),(161,'','Inicio de Sistema','14:55:34','2014-05-03'),(162,'','Inicio de Sistema','14:56:03','2014-05-03'),(163,'','Inicio de Sistema','14:57:07','2014-05-03'),(164,'','Inicio de Sistema','21:10:47','2014-05-03'),(165,'','Inicio de Sistema','21:27:08','2014-05-03'),(166,'','Inicio de Sistema','11:11:02','2014-05-04'),(167,'','Inicio de Sistema','11:11:19','2014-05-04'),(168,'','Inicio de Sistema','11:12:43','2014-05-04'),(169,'','Inicio de Sistema','11:13:10','2014-05-04'),(170,'','Inicio de Sistema','11:13:53','2014-05-04');

/*Table structure for table `buscar` */

DROP TABLE IF EXISTS `buscar`;

CREATE TABLE `buscar` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegUsu` int(11) NOT NULL,
  `Modulo` varchar(50) NOT NULL,
  `Campo` varchar(50) NOT NULL,
  `Compa` varchar(50) NOT NULL,
  `Valor` varchar(50) NOT NULL,
  PRIMARY KEY (`NRegistro`),
  KEY `NRegUsu` (`NRegUsu`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

/*Data for the table `buscar` */

insert  into `buscar`(`NRegistro`,`NRegUsu`,`Modulo`,`Campo`,`Compa`,`Valor`) values (16,39,'DINDESPACHOSAMB.PHP','NRegistro','Igual','178'),(35,64,'DINSOLICITUDES.PHP','Fecha','Mayor','14'),(75,81,'DINSOLICITUDES.PHP','Telefono','Igual','04142890573'),(82,30,'DINDESPACHOS.PHP','NRegistro','Semejante','200'),(84,136,'MANTUSU.PHP','Cedula','Igual','13113322'),(86,30,'DINSOLICITUDES.PHP','Descripcion','Semejante','ARBOL CAIDO'),(89,1,'DEFREPAUD.PHP','Usuario','Igual','superadministrador'),(90,2,'REPRANKING.PHP','NRegEve','Semejante','ASO');

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `num_registro` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  `edad` varchar(20) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `modalidad` int(11) NOT NULL,
  `id_estilo` varchar(20) NOT NULL,
  `id_region` varchar(20) NOT NULL,
  `id_tecnica` varchar(20) NOT NULL,
  `estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`num_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `categorias` */

insert  into `categorias`(`num_registro`,`descripcion`,`edad`,`sexo`,`modalidad`,`id_estilo`,`id_region`,`id_tecnica`,`estatus`) values (1,'Categoria 1','10-15','Femenino',1,'1','1','1','activo'),(2,'Categoria 2','15-18','Masculino',2,'2','2','2','inactivo'),(3,'Categoria 3','13-16','Femenino',3,'2','1','3','activo'),(4,'Categoria Yunior','06-10','Femenino',2,'1','2','1','activo');

/*Table structure for table `codigo_telefono` */

DROP TABLE IF EXISTS `codigo_telefono`;

CREATE TABLE `codigo_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `codigo_telefono` */

insert  into `codigo_telefono`(`id`,`codigo`,`tipo`) values (1,'0243',1),(2,'0244',1),(3,'0412',2),(4,'0416',2),(5,'0424',2),(6,'0414',2);

/*Table structure for table `competencia` */

DROP TABLE IF EXISTS `competencia`;

CREATE TABLE `competencia` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegAtl` int(11) NOT NULL,
  `NRegEve` int(11) NOT NULL,
  `NRegCat` int(11) NOT NULL,
  `Puntos` int(11) NOT NULL,
  `Estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`NRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `competencia` */

insert  into `competencia`(`NRegistro`,`NRegAtl`,`NRegEve`,`NRegCat`,`Puntos`,`Estatus`) values (1,1,3,1,5,'4TO LUGAR'),(2,1,3,2,20,'1ER LUGAR'),(3,2,3,1,20,'2DO LUGAR'),(4,2,3,2,1,'5TO LUGAR');

/*Table structure for table `detcategoria` */

DROP TABLE IF EXISTS `detcategoria`;

CREATE TABLE `detcategoria` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegCat` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Valor` varchar(50) NOT NULL,
  `Estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`NRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `detcategoria` */

insert  into `detcategoria`(`NRegistro`,`NRegCat`,`Descripcion`,`Valor`,`Estatus`) values (1,1,'NIVEL 1','A',''),(2,2,'RANGO 5','ADULTO FEMENINO','');

/*Table structure for table `detevento` */

DROP TABLE IF EXISTS `detevento`;

CREATE TABLE `detevento` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegEve` int(11) NOT NULL,
  `NRegCat` int(11) NOT NULL,
  `Estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`NRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `detevento` */

insert  into `detevento`(`NRegistro`,`NRegEve`,`NRegCat`,`Estatus`) values (1,1,1,'ACTIVO'),(2,1,2,'INACTIVO'),(3,3,1,'ACTIVO'),(4,3,2,'ACTIVO');

/*Table structure for table `detusuario` */

DROP TABLE IF EXISTS `detusuario`;

CREATE TABLE `detusuario` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegUsu` int(11) NOT NULL,
  `NRegPer` int(11) NOT NULL,
  `Estatus` varchar(50) NOT NULL,
  PRIMARY KEY (`NRegistro`),
  KEY `NRegUsu` (`NRegUsu`),
  KEY `NRegPer` (`NRegPer`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=latin1;

/*Data for the table `detusuario` */

insert  into `detusuario`(`NRegistro`,`NRegUsu`,`NRegPer`,`Estatus`) values (1,1,16,'ACTIVO'),(2,2,17,'ACTIVO'),(182,137,43,'ACTIVO'),(183,138,44,'ACTIVO');

/*Table structure for table `entrenadores` */

DROP TABLE IF EXISTS `entrenadores`;

CREATE TABLE `entrenadores` (
  `num_registro` int(11) NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(20) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `id_asociacion` int(11) NOT NULL,
  `fechnac` date NOT NULL,
  `estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`num_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `entrenadores` */

insert  into `entrenadores`(`num_registro`,`nacionalidad`,`cedula`,`nombre`,`sexo`,`cod_telefono`,`telefono`,`email`,`direccion`,`id_asociacion`,`fechnac`,`estatus`) values (1,'E',5676767,'Rosa Suarez','Femenino',6,'4444444','rosi@hotmail.com','Anaco',3,'1999-06-02','Activo'),(2,'V',7186419,'Sonia Ruiz','Femenino',2,'2678956','soni@hotmail.com','Ejido',2,'1993-06-15','Inactivo'),(3,'V',16532896,'Carlos Perez','Masculino',3,'6690401','carli@gmail.com','Turmero',1,'1993-06-16','Activo');

/*Table structure for table `estatus_evento` */

DROP TABLE IF EXISTS `estatus_evento`;

CREATE TABLE `estatus_evento` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `estatus_evento` varchar(50) DEFAULT NULL,
  KEY `id_estatus` (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `estatus_evento` */

insert  into `estatus_evento`(`id_estatus`,`estatus_evento`) values (1,'Inscripciones'),(2,'Proximo'),(3,'Ejecucion'),(4,'Culminado');

/*Table structure for table `estilo` */

DROP TABLE IF EXISTS `estilo`;

CREATE TABLE `estilo` (
  `id_estilo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estilo` varchar(25) DEFAULT NULL,
  KEY `id_estilo` (`id_estilo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `estilo` */

insert  into `estilo`(`id_estilo`,`nombre_estilo`) values (1,'MODERNO'),(2,'TRADICIONAL');

/*Table structure for table `eventos` */

DROP TABLE IF EXISTS `eventos`;

CREATE TABLE `eventos` (
  `num_registro` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `lugar` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `organizadores` text NOT NULL,
  `id_estatus` int(11) NOT NULL,
  PRIMARY KEY (`num_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `eventos` */

insert  into `eventos`(`num_registro`,`descripcion`,`lugar`,`fecha_inicio`,`fecha_fin`,`organizadores`,`id_estatus`) values (1,'EVENTO1','LUGAR EVENTO1','2013-01-01','2013-01-31','ORGANIZADORES DEL EVENTO1',1),(2,'EVENTO2','LUGAR EVENTO2','2013-12-01','2013-12-15','LISTA DE ORGANIZADORES',2),(3,'EVENTO3','LUGAR EVENTO3','1999-05-10','1999-05-12','ORGANIZADORES EVENTO3',3);

/*Table structure for table `inscripcion` */

DROP TABLE IF EXISTS `inscripcion`;

CREATE TABLE `inscripcion` (
  `cedula_atleta` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_modalidad` int(11) DEFAULT NULL,
  `id_estilo` int(11) DEFAULT NULL,
  `id_region` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `inscripcion` */

insert  into `inscripcion`(`cedula_atleta`,`id_categoria`,`id_modalidad`,`id_estilo`,`id_region`) values (13575772,1,2,1,1);

/*Table structure for table `inscripciones` */

DROP TABLE IF EXISTS `inscripciones`;

CREATE TABLE `inscripciones` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegEve` int(11) NOT NULL,
  `NRegAtl` int(11) NOT NULL,
  `NRegCat` int(11) NOT NULL,
  `Estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`NRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `inscripciones` */

insert  into `inscripciones`(`NRegistro`,`NRegEve`,`NRegAtl`,`NRegCat`,`Estatus`) values (1,1,1,2,'COMPLETA'),(2,1,1,1,'COMPLETA'),(3,1,2,2,'FALTAN REQUISITOS'),(4,1,2,1,'COMPLETA');

/*Table structure for table `maestro` */

DROP TABLE IF EXISTS `maestro`;

CREATE TABLE `maestro` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegMae` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Des1` varchar(100) NOT NULL,
  `Des2` varchar(100) NOT NULL,
  `Des3` varchar(100) NOT NULL,
  `Des4` double NOT NULL,
  `Des5` date NOT NULL,
  `Des6` tinyint(1) NOT NULL,
  `Estatus` varchar(50) NOT NULL,
  PRIMARY KEY (`NRegistro`),
  KEY `NRegMae` (`NRegMae`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

/*Data for the table `maestro` */

insert  into `maestro`(`NRegistro`,`NRegMae`,`Nombre`,`Des1`,`Des2`,`Des3`,`Des4`,`Des5`,`Des6`,`Estatus`) values (1,0,'MAESTRO','','','',0,'0000-00-00',0,'ACTIVO'),(2,1,'MENU','MENU DEL SISTEMA','NA','NA',0,'0000-00-00',0,'ACTIVO'),(3,2,'REGISTROS','MENU','NA','NA',1,'0000-00-00',0,'ACTIVO'),(4,2,'ACTIVIDADES','MENU','NA','NA',2,'0000-00-00',0,'ACTIVO'),(5,2,'REPORTES','MENU','NA','NA',4,'0000-00-00',0,'ACTIVO'),(6,2,'GRAFICOS','MENU','NA','NA',300,'0000-00-00',0,'INACTIVO'),(7,2,'GESTION','MENU','NA','NA',5,'0000-00-00',0,'INACTIVO'),(8,2,'CONFIGURACION','MENU','NA','NA',6,'0000-00-00',0,'ACTIVO'),(9,8,'MAESTRO','DETMENU','MANTMAESTRO.PHP','DEFINICION DE MAESTROS',1,'0000-00-00',0,'ACTIVO'),(10,8,'ACCESO','DETMENU','DEFACC.PHP','ACCESO',2,'0000-00-00',0,'ACTIVO'),(11,8,'USUARIO','DETMENU','MANTUSU.PHP','USUARIOS',3,'0000-00-00',0,'ACTIVO'),(12,8,'AUDITORIA','DETMENU','DEFREPAUD.PHP','AUDITORIA',4,'0000-00-00',0,'ACTIVO'),(13,8,'CAMBIAR CLAVE','DETMENU','DEFCAMCLA.PHP','CAMBIAR CLAVE',5,'0000-00-00',0,'ACTIVO'),(14,8,'AYUDA','DETMENU','DEFAYU.PHP','NA',6,'0000-00-00',0,'ACTIVO'),(15,1,'PERFILES','PERFILES DE USUARIO','NA','NA',0,'0000-00-00',0,'ACTIVO'),(16,15,'SADMIN','PERFIL SUPER ADMINISTRADOR','NA','NA',1,'0000-00-00',0,'ACTIVO'),(17,15,'ADMIN','PERFIL ADMINISTRADOR','NA','NA',2,'0000-00-00',0,'ACTIVO'),(43,15,'TECNICO','PERFIL TECNICO','NA','NA',3,'0000-00-00',0,'ACTIVO'),(44,15,'OPERADOR','PERFIL OPERADOR','NA','NA',4,'0000-00-00',0,'ACTIVO'),(45,3,'ASOCIACIONES','DETMENU','MANTASOCIACIONES.PHP','ASOCIACIONES',1,'0000-00-00',0,'ACTIVO'),(46,3,'ENTRENADORES','DETMENU','MANTENTRENADORES.PHP','ENTRENADORES',2,'0000-00-00',0,'ACTIVO'),(47,3,'CATEGORIAS','DETMENU','MANTCATEGORIAS.PHP','CATEGORIAS',4,'0000-00-00',0,'ACTIVO'),(49,4,'EVENTOS','DETMENU','DEFEVENTOS.PHP','EVENTOS',1,'0000-00-00',0,'ACTIVO'),(50,4,'INSCRIPCIONES','DETMENU','DEFINSCRIPCIONES.PHP','INSCRIPCIONES',2,'0000-00-00',0,'ACTIVO'),(51,4,'PREMIACION','DETMENU','DEFCOMPETENCIA.PHP','PREMIACION',3,'0000-00-00',0,'ACTIVO'),(57,5,'RANK PUNTOS ATLETAS','DETMENU','REPRANKING.PHP','RANKING PUNTOS ATLETAS',1,'0000-00-00',0,'ACTIVO'),(61,3,'ATLETAS','DETMENU','MANTATLETAS.PHP','ATLETAS',5,'0000-00-00',0,'ACTIVO'),(62,3,'MODALIDADES','DETMENU','MANTMODALIDADES.PHP','MODALIDADES',3,'0000-00-00',0,'ACTIVO'),(63,5,'RANK MEDALLAS ATLETAS','DETMENU','REPRANKINGMED.PHP','RANKING MEDALLAS ATLETAS',2,'0000-00-00',0,'ACTIVO'),(64,5,'PREMIACION','DETMENU','REPPREMIA.PHP','PREMIACION',5,'0000-00-00',0,'ACTIVO'),(65,5,'RANK PUNTOS ASOCIACION','DETMENU','REPRANKINGASO.PHP','RANKING PUNTOS ASOCIACION',3,'0000-00-00',0,'ACTIVO'),(66,5,'RANK MEDALLAS ASOCIACION','DETMENU','REPRANKINGMEDASO.PHP','RANKING MEDALLAS ASOCIACION',4,'0000-00-00',0,'ACTIVO');

/*Table structure for table `modalidades` */

DROP TABLE IF EXISTS `modalidades`;

CREATE TABLE `modalidades` (
  `num_registro` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `estatus` varchar(20) NOT NULL,
  PRIMARY KEY (`num_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `modalidades` */

insert  into `modalidades`(`num_registro`,`descripcion`,`estatus`) values (1,'COMBATE','Activo'),(2,'TAEKONDO','Activo'),(3,'TAOLU','Activo');

/*Table structure for table `nivel_academico` */

DROP TABLE IF EXISTS `nivel_academico`;

CREATE TABLE `nivel_academico` (
  `id_nivel` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(25) DEFAULT NULL,
  KEY `id_nivel` (`id_nivel`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `nivel_academico` */

insert  into `nivel_academico`(`id_nivel`,`nivel`) values (1,'Primaria'),(2,'Secundaria'),(3,'Bachiller'),(4,'TSU'),(5,'Universitario');

/*Table structure for table `region` */

DROP TABLE IF EXISTS `region`;

CREATE TABLE `region` (
  `id_region` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_region` varchar(25) DEFAULT NULL,
  KEY `id_region` (`id_region`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `region` */

insert  into `region`(`id_region`,`nombre_region`) values (1,'NORTE'),(2,'SUR');

/*Table structure for table `tecnica` */

DROP TABLE IF EXISTS `tecnica`;

CREATE TABLE `tecnica` (
  `id_tecnica` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tecnica` varchar(25) DEFAULT NULL,
  KEY `id_tecnica` (`id_tecnica`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tecnica` */

insert  into `tecnica`(`id_tecnica`,`nombre_tecnica`) values (1,'ARMA CORTA'),(2,'ARMA LARGA'),(3,'MANOS LIBRES');

/*Table structure for table `tipo_sangre` */

DROP TABLE IF EXISTS `tipo_sangre`;

CREATE TABLE `tipo_sangre` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_sangre` varchar(15) DEFAULT NULL,
  KEY `id_tipo` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tipo_sangre` */

insert  into `tipo_sangre`(`id_tipo`,`tipo_sangre`) values (1,'A'),(2,'B'),(3,'AB'),(4,'O');

/*Table structure for table `tipo_usuario` */

DROP TABLE IF EXISTS `tipo_usuario`;

CREATE TABLE `tipo_usuario` (
  `id_tipousuario` int(11) DEFAULT NULL,
  `tipo_usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tipo_usuario` */

/*Table structure for table `trabajo` */

DROP TABLE IF EXISTS `trabajo`;

CREATE TABLE `trabajo` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `NRegUsu` int(11) NOT NULL,
  `NRegMod` int(11) NOT NULL,
  `Widget` varchar(50) NOT NULL,
  `Form` varchar(50) NOT NULL,
  `Accion` varchar(50) NOT NULL,
  `Tabla` varchar(50) NOT NULL,
  `Indice` varchar(50) DEFAULT NULL,
  `ValorIndice` varchar(50) DEFAULT NULL,
  `Campos` varchar(1000) DEFAULT NULL,
  `Cmp1` varchar(1000) DEFAULT NULL,
  `Cmp2` varchar(1000) DEFAULT NULL,
  `Cmp3` varchar(1000) DEFAULT NULL,
  `Cmp4` varchar(1000) DEFAULT NULL,
  `Cmp5` varchar(1000) DEFAULT NULL,
  `Cmp6` varchar(1000) DEFAULT NULL,
  `Cmp7` varchar(1000) DEFAULT NULL,
  `Cmp8` varchar(1000) DEFAULT NULL,
  `Cmp9` varchar(1000) DEFAULT NULL,
  `Cmp10` varchar(1000) DEFAULT NULL,
  `Cmp11` varchar(1000) DEFAULT NULL,
  `Cmp12` varchar(1000) DEFAULT NULL,
  `Cmp13` varchar(1000) DEFAULT NULL,
  `Cmp14` varchar(1000) DEFAULT NULL,
  `Cmp15` varchar(1000) DEFAULT NULL,
  `Cmp16` varchar(1000) DEFAULT NULL,
  `Cmp17` varchar(1000) DEFAULT NULL,
  `Cmp18` varchar(1000) DEFAULT NULL,
  `Cmp19` varchar(1000) DEFAULT NULL,
  `Cmp20` varchar(1000) DEFAULT NULL,
  `Cmp21` varchar(1000) DEFAULT NULL,
  `Cmp22` varchar(1000) DEFAULT NULL,
  `Cmp23` varchar(1000) DEFAULT NULL,
  `Cmp24` varchar(1000) DEFAULT NULL,
  `Cmp25` varchar(1000) DEFAULT NULL,
  `Cmp26` varchar(1000) DEFAULT NULL,
  `Cmp27` varchar(1000) DEFAULT NULL,
  `Cmp28` varchar(1000) DEFAULT NULL,
  `Cmp29` varchar(1000) DEFAULT NULL,
  `Cmp30` varchar(1000) DEFAULT NULL,
  `Cmp31` varchar(1000) DEFAULT NULL,
  `Cmp32` varchar(1000) DEFAULT NULL,
  `Cmp33` varchar(1000) DEFAULT NULL,
  `Cmp34` varchar(1000) DEFAULT NULL,
  `Cmp35` varchar(1000) DEFAULT NULL,
  `Cmp36` varchar(1000) DEFAULT NULL,
  `Cmp37` varchar(1000) DEFAULT NULL,
  `Cmp38` varchar(1000) DEFAULT NULL,
  `Cmp39` varchar(1000) DEFAULT NULL,
  `Cmp40` varchar(1000) DEFAULT NULL,
  `Cmp41` varchar(1000) DEFAULT NULL,
  `Cmp42` varchar(1000) DEFAULT NULL,
  `Cmp43` varchar(1000) DEFAULT NULL,
  `Cmp44` varchar(1000) DEFAULT NULL,
  `Cmp45` varchar(1000) DEFAULT NULL,
  `Cmp46` varchar(1000) DEFAULT NULL,
  `Cmp47` varchar(1000) DEFAULT NULL,
  `Cmp48` varchar(1000) DEFAULT NULL,
  `Cmp49` varchar(1000) DEFAULT NULL,
  `Cmp50` varchar(1000) DEFAULT NULL,
  `NRegReg` int(11) NOT NULL,
  PRIMARY KEY (`NRegistro`),
  KEY `NRegUsu` (`NRegUsu`),
  KEY `NRegMod` (`NRegMod`),
  KEY `NRegReg` (`NRegReg`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `trabajo` */

insert  into `trabajo`(`NRegistro`,`NRegUsu`,`NRegMod`,`Widget`,`Form`,`Accion`,`Tabla`,`Indice`,`ValorIndice`,`Campos`,`Cmp1`,`Cmp2`,`Cmp3`,`Cmp4`,`Cmp5`,`Cmp6`,`Cmp7`,`Cmp8`,`Cmp9`,`Cmp10`,`Cmp11`,`Cmp12`,`Cmp13`,`Cmp14`,`Cmp15`,`Cmp16`,`Cmp17`,`Cmp18`,`Cmp19`,`Cmp20`,`Cmp21`,`Cmp22`,`Cmp23`,`Cmp24`,`Cmp25`,`Cmp26`,`Cmp27`,`Cmp28`,`Cmp29`,`Cmp30`,`Cmp31`,`Cmp32`,`Cmp33`,`Cmp34`,`Cmp35`,`Cmp36`,`Cmp37`,`Cmp38`,`Cmp39`,`Cmp40`,`Cmp41`,`Cmp42`,`Cmp43`,`Cmp44`,`Cmp45`,`Cmp46`,`Cmp47`,`Cmp48`,`Cmp49`,`Cmp50`,`NRegReg`) values (1,5,33,'W0','formW0','Modificar','solicitudes','NRegistro','29639','Telefono,Solicitante,Categoria,Descripcion,Observaciones,Direccion,NRegEst,NRegMun,NRegPar,NRegSec,NRegOpe,Hora','02432832541','BRISAIDA ZALAZAR','1','4','INDICO PERSONA DE 75 A OS PRESENTANDO DISNEA','CALLE ACUEDUCTO,CASA 8 SECTOR MATA SECA....ADYACENTE A LA IGLESIA ','5','42','154','206','131','17:46:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,29639),(2,5,33,'W3','formW3','Modificar','detsolicitudfrecuencias','NRegistro','29639','NRegFre,Unidad,AlMando,Procedimiento','5','ASDAS','ADSADS','ASDASD',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3390),(3,5,33,'W3','formW3','Modificar','detsolicitudfrecuencias','NRegistro','29639','NRegFre,Unidad,AlMando,Procedimiento','12','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3391),(4,5,33,'W4','formW4','Modificar','solicitudes','NRegistro','29639','NRegistro,Descripcion','29639','4',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,29639);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `NRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_usuario` varchar(50) NOT NULL,
  `Cedula` varchar(50) NOT NULL,
  `Telefonos` varchar(50) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `EMail` varchar(50) NOT NULL,
  `Cargo` varchar(50) NOT NULL,
  `Foto` tinytext NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Clave` text NOT NULL,
  `Tipo` varchar(50) NOT NULL,
  `IPLog` varchar(20) NOT NULL,
  `FechaHoraIni` datetime NOT NULL,
  `FechaHoraFin` datetime NOT NULL,
  `Estatus` varchar(50) NOT NULL,
  PRIMARY KEY (`NRegistro`),
  UNIQUE KEY `Usuario` (`Usuario`),
  KEY `Estatus` (`Estatus`),
  KEY `IPLog` (`IPLog`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`NRegistro`,`tipo_usuario`,`Cedula`,`Telefonos`,`Direccion`,`EMail`,`Cargo`,`Foto`,`Usuario`,`Clave`,`Tipo`,`IPLog`,`FechaHoraIni`,`FechaHoraFin`,`Estatus`) values (1,'SUPERADMINISTRADOR','V 00000000','0000 000 00 00','DIRECCION','SADMIN SADMIN.COM','SUPER AMINISTRADOR','IMG FOTOS NUE.JPG','sadmin','c5edac1b8c1d58bad90a246d8f08f53b','SUPERAMINISTRADOR','','2014-04-17 22:12:59','2014-04-17 22:13:55','ACTIVO'),(2,'ADMIN','V-11111111','0000 000 00 00','DIRECCION','ADMIN ADMIN.COM','ADMINISTRADOR','IMG FOTOS NUE.JPG','admin','21232f297a57a5a743894a0e4a801fc3','ADMINISTRADOR','','2014-04-18 10:59:18','2014-04-18 11:01:46','ACTIVO'),(137,'TECNICO','V-22222222','0202222 22 22','D2','EMAIL2 EMAIL.COM','PRESTAMOS','IMG NUE.JPG','tec','044c3027c1bfd773fc90762db80bf8cc','USUARIO','','2014-04-17 22:15:52','2014-04-17 22:18:46','ACTIVO'),(138,'OPERADOR','V-33333333','0303 333 33 33','D3','EMAIL3 EMAIL.COM','CONTABILIDAD','IMG NUE.JPG','ope','52e56600aff9d421d0ec69378e4a61f9','CONTABILIDAD','127.0.0.1','2014-04-17 22:15:08','2013-11-25 15:32:57','ACTIVO');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

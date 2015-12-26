CREATE DATABASE  IF NOT EXISTS `my-mvc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `my-mvc`;
-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: my-mvc
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_done` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (1,'2015-09-22','buy a tommy-gun in Barabashovo market',1,1,'00:00:00'),(2,'2015-09-22','make cake',1,0,'00:00:00'),(40,'2015-09-25','make HW',1,0,'17:51:00'),(41,'2015-09-25','send HW to Max',0,1,'19:33:14'),(42,'2015-09-25','drink Viski',0,0,'19:38:46'),(43,'2015-09-25','drink beer',0,0,'20:55:55'),(44,'2015-09-25','watch news',0,0,'21:22:26'),(61,'2015-12-26','read news',1,0,'01:39:21'),(62,'2015-12-26','watch Shuster-Live',0,0,'01:40:15'),(63,'2015-12-26','find chaise-longue',1,0,'01:41:25'),(64,'2015-12-26','check WM',1,0,'01:42:24'),(67,'2015-12-26','buy salt milling #3',0,0,'01:45:16'),(69,'2015-12-26','read news NN',1,0,'01:54:22'),(76,'2015-12-26','read news NN',0,0,'02:27:39'),(77,'2015-12-26','get task',0,0,'02:32:09');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-26  2:49:37

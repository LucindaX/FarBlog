-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: ZendProject
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.1

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'food','Food is great here'),(2,'Drinks','Food is great here');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forums`
--

LOCK TABLES `forums` WRITE;
/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
INSERT INTO `forums` VALUES (6,'Unix and Linux Questions','This forum is for answering Linux and Unix based questions',1),(28,'Unix and Linux Questions','This forum is for answering Linux and Unix based questions',1),(29,'blabla','helloojhgjghjgjhghjgj',1);
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forums_locked`
--

DROP TABLE IF EXISTS `forums_locked`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forums_locked` (
  `forum_id` int(11) NOT NULL,
  PRIMARY KEY (`forum_id`),
  CONSTRAINT `forums_locked_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forums_locked`
--

LOCK TABLES `forums_locked` WRITE;
/*!40000 ALTER TABLE `forums_locked` DISABLE KEYS */;
/*!40000 ALTER TABLE `forums_locked` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lockSystem`
--

DROP TABLE IF EXISTS `lockSystem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lockSystem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('locked','unlocked') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lockSystem`
--

LOCK TABLES `lockSystem` WRITE;
/*!40000 ALTER TABLE `lockSystem` DISABLE KEYS */;
INSERT INTO `lockSystem` VALUES (1,'unlocked');
/*!40000 ALTER TABLE `lockSystem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `body` mediumtext NOT NULL,
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES (3,14,'2014-04-01 04:15:38','helllo',3),(4,14,'2014-04-01 04:15:38','sadasdas',3),(7,14,'2014-04-01 04:15:40','sadasdas',3),(9,14,'2014-04-01 04:15:41','sadasdas',3),(10,14,'2014-04-01 04:15:42','sadasdas',3),(11,14,'2014-04-01 04:15:42','sadasdas',3),(12,14,'2014-04-01 04:15:42','sadasdas',3),(13,14,'2014-04-01 04:15:43','sadasdas',3),(14,14,'2014-04-01 04:15:43','sadasdas',3),(15,10,'2014-04-02 17:43:50','i am an idiot',6),(16,17,'2014-04-02 17:52:30','Whyyyyyyyyyyyyyyyyyyyyyyyyyyyyy\r\n',4);
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `threads`
--

DROP TABLE IF EXISTS `threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `body` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `sticky` enum('true','false') DEFAULT 'false',
  `visits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `forum_id` (`forum_id`),
  CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `threads_ibfk_2` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES (3,'How to Clean your bed in the morining','i wanted to ask how can somebody help me best way to clean my bed?',14,29,'2014-03-30 17:26:25','true',122),(4,'Why have fun','i don\'t know',10,6,'2014-04-02 17:08:44','false',8),(5,'addd','dsakldlkas',10,29,'2014-04-02 17:11:53','false',4),(6,'salma','sadalsda',10,6,'2014-04-02 17:31:12','false',16);
/*!40000 ALTER TABLE `threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `threads_locked`
--

DROP TABLE IF EXISTS `threads_locked`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `threads_locked` (
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`),
  CONSTRAINT `threads_locked_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads_locked`
--

LOCK TABLES `threads_locked` WRITE;
/*!40000 ALTER TABLE `threads_locked` DISABLE KEYS */;
/*!40000 ALTER TABLE `threads_locked` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(25) DEFAULT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `account_type` enum('admin','normal') NOT NULL,
  `gender` enum('m','f') DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `image` text,
  `signature` text,
  `status` varchar(15) NOT NULL DEFAULT 'offline',
  `date_joined` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,NULL,NULL,'NoWayHome','kolaw@poka.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','2014-03-30'),(13,NULL,NULL,'Jonny','lilian@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','normal',NULL,NULL,NULL,NULL,'banned','2014-03-30'),(14,NULL,NULL,'Karva5l','lilian@samba.com','81dc9bdb52d04dc20036dbd8313ed055','normal',NULL,NULL,NULL,NULL,'banned','2014-03-30'),(15,NULL,NULL,'Sabotoor','lilian@ko.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'banned','2014-03-30'),(16,NULL,NULL,'silky','lilian@popo.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','2014-03-30'),(17,NULL,NULL,'Aly','sadasdas@yahoo.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','0000-00-00'),(18,NULL,NULL,'salma','ui@yahoo.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'online','0000-00-00'),(19,'Metwaly','Karioke','karim','dde@yahoo.com','1234','admin','m','Nauru',NULL,NULL,'offline','0000-00-00'),(20,NULL,NULL,'sa3eed','momoza_contra@hotmail.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','2014-04-02'),(22,NULL,NULL,'jack','ahmed.sa3eed_azrk@hotmail.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'online','2014-04-02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_banned`
--

DROP TABLE IF EXISTS `users_banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_banned` (
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `users_banned_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_banned`
--

LOCK TABLES `users_banned` WRITE;
/*!40000 ALTER TABLE `users_banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_banned` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-02 20:04:06

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (3,'Linux based Questions','forums to ask about difficult matters'),(4,'Embedded Systems','A discussion about electronics'),(5,'Apple Support','Technical difficulties with Apple products');
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forums`
--

LOCK TABLES `forums` WRITE;
/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
INSERT INTO `forums` VALUES (30,'Shell Scripting','Shell scripting questions',3),(31,'AWK programming','disscussions about awk programming',3),(32,'Perl and bash scripting','perl and bash scripting',3),(33,'Arduino Analysis','Arduino Analysis',4),(34,'Segate platforms divisions','programming segate material to flash',4),(35,'electronic modeling','modeling symbols to aircrafts',4),(36,'Apple store technicals','problems with apple store',5),(37,'Updates','handling updates to phone',5);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES (17,18,'2014-04-07 16:42:37','the record is as such, i just need something that works theoretically for such, that finds the two instances of ABCD, but extract the `Root` out of ABCD......\r\n\r\n[awk -F, \'(NR==2) {print $3\"ABCXYZ\"}\' portfolio-hierarchy .csv RootABCXYZ ^dg@torpsbe1\\[1mClient_Source/20140403%\r\n\r\n---------- Post updated at 09:45 PM ---------- Previous update was at 09:44 PM ----------\r\n\r\ni mean ABCXYZ',12),(18,18,'2014-04-07 16:43:01','csv (.*)ABCXYZ\r\n\r\nMatch the characters \"csv \" literally\r\nMatch the regular expression below and capture its match into backreference number 1\r\n   Match any single character that is not a line break character\r\n      Between zero and unlimited times, as many times as possible, giving back as needed (greedy)\r\nMatch the characters \"ABCXYZ\" literally\r\n\r\n\r\n$result = preg_replace(\'/csv (.*)ABCXYZ/im\', \'$1\', $subject);',12),(19,18,'2014-04-07 16:43:34','Unfortunately that one is not working..\r\nwhy isn\'t this one working either? Do you see something fundamentally wrong?',12),(20,18,'2014-04-07 16:44:23','awk \'{sub(\"-\",X,$0); sum += $0} END {print sum}\' file',11),(21,18,'2014-04-07 16:44:40','awk \'{sub(\"-\",X,$0); sum += $0} END {printf \"%f\\n\", sum}\' file',11),(22,18,'2014-04-07 16:44:59','The other thing to keep in mind is that awk uses floating point numbers. It\'s not infinite precision. If you print that number to 13 extra decimal places, most of those decimals will be meaningless garbage.\r\n\r\nIf you want a perfect sum, bc should do the job, if you convert the output into something it can use.\r\n\r\n\r\nCode:\r\nawk \'BEGIN { print \"Z = 0;\" } { sub(/-/, \"\"); print \"Z += \",$1,\";\" } END { print \"Z;\" }\' inputfile | bc\r\n\r\nThis prints \"z = 0;\" as the first line, then all lines afterwards as \"z += number;\" And the final line as \"z;\" to print the final sum.',11),(23,18,'2014-04-07 16:45:33','Hi Corona !\r\n\r\nThanks for your guidance and I have used your code like this:\r\n\r\nCode:\r\n \r\n \r\n awk \'BEGIN { print \"Z = 0;\" } { sub(/-/, \"\"); print \"Z += \",$1,\";\" } END { print \"Z;\" }\' asa.txt | bc\r\n\r\nwhere asa.txt has data like:\r\n\r\n\r\nCode:\r\n \r\n21000000\r\n-3000\r\n3000\r\n-670500\r\n2963700\r\n\r\nbut I am getting an error of:\r\n\r\n\r\nCode:\r\n \r\nsyntax error on line 1 stdin\r\n\r\nNeed your help on this !\r\n',11);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES (7,'Convert ip ranges to CIDR netblocks','Hi,\r\n\r\nRecently I had to convert a 280K lines of ip ranges to the CIDR notation and generate a file to be used by ipset (netfilter) for ip filtering.\r\n\r\ncode:\r\n-N cidr nethash --maxelem 260000\r\n-N single iphash --maxelem 60000\r\n-A cidr 0.0.0.0/8\r\n-A cidr 1.0.64.0/18\r\n-A single 1.0.245.123\r\n-A cidr 1.2.2.0/24\r\n-A cidr 1.2.4.0/24\r\nCOMMIT',10,30,'2014-04-07 16:35:43','false',1),(8,'Tetris Game -- based on a shell script (new algorithm)','Hi all, i have successfully developed a shell version of the Tetris Game based on a new algorithm few days ago all by myself, below is the link of the source code that i posted at a Linux/Unix forum the first in China:\r\n\r\n[C|Go|C++|Shell based]\r\nOpen Source Project: https://github.com/yongye/shell\r\nScreenShot: http://bbs.chinaunix.net/thread-3614425-1-1.html\r\n\r\nI\'d love to know that someone can be able to optimize my source code and enhance it!\r\nhow to play with it?\r\n\r\nCode:\r\nbash Tetris_Game_Vector_Based.sh [runlevel] [previewlevel] [speedlevel]  [width] [height]\r\n\r\n\r\nI made a copy of my source code below(Tetris_Game_Vector_Based.sh):',10,30,'2014-04-07 16:36:43','false',1),(9,'Csh Programming Considered Harmful','I have noticed a few posts asking questions about c shell scripting these past few days. This a good read for those that currently or are thinking about writing a csh script:\r\n\r\nCsh Programming Considered Harmful',10,30,'2014-04-07 16:37:19','false',1),(10,'Need help in scripting','Hi,\r\n\r\nI have a requirement to write a shell script to judge/identify the records whether the email is good or bad. Below is the pre-requisites client has given\r\n\r\nValid domains for email address acceptable as \"COM,EDU,NET,ORG,INT,GOV,MIL,AERO,BIZ,COOP,INFO,MUSEUM,NAME,PRO\"\r\n\r\nand also need to check the below conditions\r\n\r\na) \'Characters ()<>,;:\\/\"\'\'[] or spaces are not permitted in an email address.\';\r\nb) \'An email address cannot contain control characters or DEL.\';\r\nc) \'An email address cannot begin with the dot or at-symbol.\';\r\nd) \'Names like root, webmaster etc. are unacceptable.\';\r\ne) \'An email address cannot have a dot immediately after the at-symbol . \';\r\n\r\ne.g :- A file contains data as below\r\n\r\n\r\nCode:\r\n1002334|a.neryariel@verizon.net|ARIEL|TELLEZ|9780545546379|1049622|Jeffry|9780545365765|9780545366847|1049641|Alfonso																																								201404\r\n1004888|hogardesilva@gmail.com|MARTIN|SILVA|9780545505994|||||1328346|Emilio\r\n6884268|info@ramonaprivateschools.com|Ellen|Kelly||||||1329346|Rajesh\r\n55852010|myorders@conways.mobi|Yasaswini|konaganti||||||1579326|Ramu\r\n56031277|administrator@leland.k12.mi.us|bharathi|katragadda||||||3429343|Suresh\r\n\r\nBased on the above file, we need to write a script to move the bad email data into a separate file. Seems that the bad emails are as follows.\r\n\r\nbademail data and these will be write it into a separate file.',10,30,'2014-04-07 16:38:31','false',1),(11,'Aggregation of huge data','Hi Friends,\r\n\r\nI have a file with sample amount data as follows:\r\n\r\n\r\nCode:\r\n \r\n -89990.3456\r\n8788798.990000128\r\n55109787.20\r\n-12455558989.90876\r\n\r\nI need to exclude the \'-\' symbol in order to treat all values as an absolute one and then I need to sum up.The record count is around 1 million.\r\n\r\nHow can I perform this ?\r\n\r\nRegards,\r\nRavichander',10,30,'2014-04-07 16:39:07','true',6),(12,'Looking for a perl-compatible regex solution','\r\nThis is for PHP preg_match code - which is PCRE therefore looking for a perl compatible suggestion\r\n\r\nI have this line returned I want to match and return..\r\n\r\n\r\nCode:\r\n[awk -F, \'(NR==2) {print $3\"ABCXYZ\"}\' portfolio-hierarchy .csv  RootABCXYZ ^dg@torpsbe1\\[1mClient_Source/20140403%\r\n\r\nI want to match the two instances of string ending \'ABCXYZ\' into an array.\r\nAnd on second element (ie. RootABCXYZ) only return the word \"Root\"..\r\n\r\nThanks in advance ',10,30,'2014-04-07 16:39:42','true',5);
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
INSERT INTO `users` VALUES (10,NULL,NULL,'NoWayHome','kolaw@poka.com','81dc9bdb52d04dc20036dbd8313ed055','normal',NULL,NULL,NULL,NULL,'offline','2014-03-30'),(13,NULL,NULL,'Jonny','lilian@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','normal',NULL,NULL,NULL,NULL,'banned','2014-03-30'),(14,NULL,NULL,'Karva5l','lilian@samba.com','81dc9bdb52d04dc20036dbd8313ed055','normal',NULL,NULL,NULL,NULL,'banned','2014-03-30'),(15,NULL,NULL,'Sabotoor','lilian@ko.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'banned','2014-03-30'),(16,NULL,NULL,'silky','lilian@popo.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','2014-03-30'),(17,NULL,NULL,'Aly','sadasdas@yahoo.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','0000-00-00'),(18,NULL,NULL,'salma','ui@yahoo.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','2014-04-07'),(19,'Metwaly','Karioke','karim','dde@yahoo.com','1234','admin','m','Nauru',NULL,NULL,'offline','0000-00-00'),(20,NULL,NULL,'sa3eed','momoza_contra@hotmail.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'offline','2014-04-02'),(22,NULL,NULL,'jack','ahmed.sa3eed_azrk@hotmail.com','81dc9bdb52d04dc20036dbd8313ed055','admin',NULL,NULL,NULL,NULL,'online','2014-04-02');
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

-- Dump completed on 2014-04-07 15:47:43

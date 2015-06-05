-- MySQL dump 10.13  Distrib 5.1.58, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: tptweb
-- ------------------------------------------------------
-- Server version	5.1.58-log

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
-- Table structure for table `k_airlist`
--

DROP TABLE IF EXISTS `k_airlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `k_airlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullDate` varchar(19) NOT NULL DEFAULT '',
  `seriesId` int(11) NOT NULL DEFAULT '0',
  `programId` int(11) NOT NULL DEFAULT '0',
  `versionId` int(11) NOT NULL DEFAULT '0',
  `repeat` varchar(10) DEFAULT NULL,
  `channel` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fullDate` (`fullDate`,`seriesId`,`programId`,`versionId`,`channel`),
  KEY `seriesId` (`seriesId`),
  KEY `programId` (`programId`),
  KEY `versionId` (`versionId`)
) ENGINE=MyISAM AUTO_INCREMENT=12605 DEFAULT CHARSET=latin1 COMMENT='Contains all airlist data from ProTrack going out 2 months';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `k_episode`
--

DROP TABLE IF EXISTS `k_episode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `k_episode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seriesId` int(11) NOT NULL,
  `programId` int(11) NOT NULL,
  `versionId` int(11) NOT NULL,
  `episodeLength` varchar(8) NOT NULL,
  `episodeNum` varchar(10) DEFAULT NULL,
  `episodeTitle` varchar(255) DEFAULT NULL,
  `episodeGuide` text,
  `episodeDesc` text,
  `episodeUrl` varchar(255) DEFAULT NULL,
  `cc` varchar(200) DEFAULT NULL,
  `stereo` varchar(200) DEFAULT NULL,
  `rating` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seriesId` (`seriesId`),
  KEY `programId` (`programId`),
  KEY `versionId` (`versionId`)
) ENGINE=MyISAM AUTO_INCREMENT=68643 DEFAULT CHARSET=latin1 COMMENT='Contains all ProTrack episode data.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `k_series`
--

DROP TABLE IF EXISTS `k_series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `k_series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seriesId` int(11) NOT NULL,
  `seriesCode` varchar(25) NOT NULL,
  `seriesTitle` varchar(255) NOT NULL,
  `seriesDesc` text,
  `seriesUrl` varchar(255) DEFAULT NULL,
  `seriesGenre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seriesId` (`seriesId`),
  FULLTEXT KEY `seriesTitle` (`seriesTitle`,`seriesDesc`)
) ENGINE=MyISAM AUTO_INCREMENT=670 DEFAULT CHARSET=latin1 COMMENT='Contains all imported ProTrack series listing data';
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-05 10:44:49

-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tc_stat
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.04.1

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `algorithm_match_results`
--

DROP TABLE IF EXISTS `algorithm_match_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `algorithm_match_results` (
  `match_id` int(11) NOT NULL,
  `coder_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `earnings` int(11) DEFAULT NULL,
  `old_rating` int(11) NOT NULL,
  `new_rating` int(11) NOT NULL,
  `new_volatility` int(11) NOT NULL,
  `room_rank` int(11) NOT NULL,
  `division_rank` int(11) NOT NULL,
  `advanced` tinyint(1) DEFAULT NULL,
  `submission_points` double NOT NULL,
  `challenge_points` double NOT NULL,
  `defense_points` double NOT NULL,
  `system_test_points` double NOT NULL,
  `final_points` double NOT NULL,
  `division` int(11) NOT NULL,
  `n_successful_challenges` int(11) NOT NULL,
  `n_failed_challenges` int(11) NOT NULL,
  `n_successful_defenses` int(11) NOT NULL,
  `n_failed_defenses` int(11) NOT NULL,
  `rated` tinyint(1) NOT NULL,
  `problem1_id` int(11) NOT NULL,
  `problem1_submission_points` double DEFAULT NULL,
  `problem1_final_points` double NOT NULL,
  `problem1_status` varchar(128) NOT NULL,
  `problem1_time` int(11) NOT NULL,
  `problem1_rank` int(11) DEFAULT NULL,
  `problem1_language` varchar(32) NOT NULL,
  `problem2_id` int(11) NOT NULL,
  `problem2_submission_points` double DEFAULT NULL,
  `problem2_final_points` double NOT NULL,
  `problem2_status` varchar(128) NOT NULL,
  `problem2_time` int(11) NOT NULL,
  `problem2_rank` int(11) DEFAULT NULL,
  `problem2_language` varchar(32) NOT NULL,
  `problem3_id` int(11) NOT NULL,
  `problem3_submission_points` double DEFAULT NULL,
  `problem3_final_points` double NOT NULL,
  `problem3_status` varchar(128) NOT NULL,
  `problem3_time` int(11) NOT NULL,
  `problem3_rank` int(11) DEFAULT NULL,
  `problem3_language` varchar(32) NOT NULL,
  PRIMARY KEY (`match_id`,`coder_id`),
  CONSTRAINT `algorithm_match_results_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `algorithm_matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `algorithm_match_results_ibfk_2` FOREIGN KEY (`coder_id`) REFERENCES `coders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `algorithm_matches`
--

DROP TABLE IF EXISTS `algorithm_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `algorithm_matches` (
  `id` int(11) NOT NULL,
  `full_name` varchar(1024) NOT NULL,
  `short_name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coders`
--

DROP TABLE IF EXISTS `coders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coders` (
  `id` int(11) NOT NULL,
  `handle` varchar(64) NOT NULL,
  `real_name` varchar(64) NOT NULL,
  `algorithm_rating` int(11) NOT NULL DEFAULT '1200',
  `algorithm_volatility` int(11) NOT NULL DEFAULT '0',
  `n_algorithm_matches` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `updating_status`
--

DROP TABLE IF EXISTS `updating_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `updating_status` (
  `type` varchar(64) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `status` text,
  `log` text NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-12 21:09:24

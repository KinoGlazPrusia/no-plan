CREATE DATABASE  IF NOT EXISTS `no_plan_db` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `no_plan_db`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: no_plan_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (21,'Social Gatherings','General meetups, hangouts, and social events','2024-08-09 10:59:31','2024-08-09 10:59:31'),(22,'Outdoor Activities','Hiking, picnics, beach days, etc.','2024-08-09 10:59:31','2024-08-09 10:59:31'),(23,'Sports & Fitness','Group workouts, sports matches, running clubs, etc.','2024-08-09 10:59:31','2024-08-09 10:59:31'),(24,'Cultural Events','Festivals, cultural celebrations, heritage sites visits','2024-08-09 10:59:31','2024-08-09 10:59:31'),(25,'Food & Drinks','Restaurant outings, food tastings, bar hopping, wine tasting','2024-08-09 10:59:31','2024-08-09 10:59:31'),(26,'Music & Concerts','Live music events, jam sessions, karaoke nights','2024-08-09 10:59:31','2024-08-09 10:59:31'),(27,'Art & Exhibitions','Gallery visits, art shows, interactive installations','2024-08-09 10:59:31','2024-08-09 10:59:31'),(28,'Educational & Workshops','Seminars, skill-sharing sessions, language exchanges','2024-08-09 10:59:31','2024-08-09 10:59:31'),(29,'Nightlife & Parties','Club events, dance parties, bar crawls','2024-08-09 10:59:31','2024-08-09 10:59:31'),(30,'Travel & Excursions','Day trips, weekend getaways, local tourism','2024-08-09 10:59:31','2024-08-09 10:59:31'),(31,'Wellness & Relaxation','Yoga sessions, meditation groups, spa days','2024-08-09 10:59:31','2024-08-09 10:59:31'),(32,'Professional Networking','Industry meetups, career fairs, coworking sessions','2024-08-09 10:59:31','2024-08-09 10:59:31'),(33,'Volunteering & Charity','Community service, fundraisers, environmental cleanups','2024-08-09 10:59:31','2024-08-09 10:59:31'),(34,'Technology & Gaming','LAN parties, hackathons, tech meetups','2024-08-09 10:59:31','2024-08-09 10:59:31'),(35,'Family-Friendly Activities','Playgroups, family outings, kid-friendly events','2024-08-09 10:59:31','2024-08-09 10:59:31'),(36,'Shopping & Markets','Flea markets, shopping trips, artisan fairs','2024-08-09 10:59:31','2024-08-09 10:59:31'),(37,'Movies & Theater','Film screenings, theater performances, drive-in movies','2024-08-09 10:59:31','2024-08-09 10:59:31'),(38,'Book Clubs & Literary Events','Reading groups, author signings, poetry readings','2024-08-09 10:59:31','2024-08-09 10:59:31'),(39,'Pets & Animal Lovers','Dog park meetups, pet adoption events, animal cafe visits','2024-08-09 10:59:31','2024-08-09 10:59:31'),(40,'Hobby & Craft Sessions','DIY workshops, crafting circles, hobby group meetings','2024-08-09 10:59:31','2024-08-09 10:59:31');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chat_plan1_idx` (`plan_id`),
  CONSTRAINT `fk_chat_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_message_user1_idx` (`user_id`),
  KEY `fk_message_chat1_idx` (`chat_id`),
  CONSTRAINT `fk_message_chat1` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `notification_type_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_notification_user1_idx` (`user_id`),
  KEY `fk_notification_notification_type1_idx` (`notification_type_id`),
  CONSTRAINT `fk_notification_notification_type1` FOREIGN KEY (`notification_type_id`) REFERENCES `notification_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_notification_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_type`
--

DROP TABLE IF EXISTS `notification_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_type`
--

LOCK TABLES `notification_type` WRITE;
/*!40000 ALTER TABLE `notification_type` DISABLE KEYS */;
INSERT INTO `notification_type` VALUES (1,'message','2024-09-02 07:59:37',0),(2,'participation_request','2024-09-02 07:59:37',0),(3,'participation_accepted','2024-09-02 07:59:37',0),(4,'participation_rejected','2024-09-02 07:59:37',0),(5,'participation_cancelled','2024-09-02 07:59:37',0),(6,'plan_rated','2024-09-02 07:59:37',0),(7,'rated','2024-09-02 07:59:37',0),(8,'followed','2024-09-02 07:59:37',0);
/*!40000 ALTER TABLE `notification_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participation`
--

DROP TABLE IF EXISTS `participation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participation` (
  `user_id` varchar(255) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`,`plan_id`),
  KEY `fk_participation_plan1_idx` (`plan_id`),
  KEY `fk_participation_participation_status1_idx` (`status_id`),
  CONSTRAINT `fk_participation_participation_status1` FOREIGN KEY (`status_id`) REFERENCES `participation_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participation_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participation_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participation`
--

LOCK TABLES `participation` WRITE;
/*!40000 ALTER TABLE `participation` DISABLE KEYS */;
/*!40000 ALTER TABLE `participation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participation_status`
--

DROP TABLE IF EXISTS `participation_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participation_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participation_status`
--

LOCK TABLES `participation_status` WRITE;
/*!40000 ALTER TABLE `participation_status` DISABLE KEYS */;
INSERT INTO `participation_status` VALUES (1,'pending','2024-09-02 08:06:41','2024-09-02 08:06:41'),(2,'accepted','2024-09-02 08:06:41','2024-09-02 08:06:41'),(3,'rejected','2024-09-02 08:06:41','2024-09-02 08:06:41'),(4,'cancelled','2024-09-02 08:06:41','2024-09-02 08:06:41');
/*!40000 ALTER TABLE `participation_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` point DEFAULT NULL,
  `max_participation` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_by_id` varchar(255) NOT NULL,
  `plan_img_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_plan_plan_status_idx` (`status_id`),
  KEY `fk_plan_users1_idx` (`created_by_id`),
  CONSTRAINT `fk_plan_plan_status` FOREIGN KEY (`status_id`) REFERENCES `plan_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_plan_users1` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan`
--

LOCK TABLES `plan` WRITE;
/*!40000 ALTER TABLE `plan` DISABLE KEYS */;
INSERT INTO `plan` VALUES (1,'Plan editado','Descripción del plan de prueba','2026-05-06 22:00:00',NULL,7,2,'77ce78e7-69ae-4b3d-9b6f-fc88a11defd5','assets/images/plan/1725265542998.jpeg','2024-09-02 08:25:42','2024-09-02 11:07:29'),(2,'Picnic en la playa','Quedaremos para hacer un picnic al atardecer en la playa','2025-09-15 22:00:00',NULL,8,2,'77ce78e7-69ae-4b3d-9b6f-fc88a11defd5','assets/images/plan/1725265773517.jpeg','2024-09-02 08:29:33','2024-09-02 08:29:33'),(3,'Videojuegos','Quedamos para jugar al Fifa','2026-07-17 22:00:00',NULL,4,2,'77ce78e7-69ae-4b3d-9b6f-fc88a11defd5','assets/images/plan/1725265936133.jpeg','2024-09-02 08:32:16','2024-09-02 08:32:16'),(4,'Tarde de skate','Vamos a patinar al skatepark de la Marbella','2025-12-11 23:00:00',NULL,6,2,'77ce78e7-69ae-4b3d-9b6f-fc88a11defd5','assets/images/plan/1725272128855.jpeg','2024-09-02 10:15:28','2024-09-02 10:15:28');
/*!40000 ALTER TABLE `plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_has_category`
--

DROP TABLE IF EXISTS `plan_has_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_has_category` (
  `plan_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`plan_id`,`category_id`),
  KEY `fk_plan_has_category_category1_idx` (`category_id`),
  KEY `fk_plan_has_category_plan1_idx` (`plan_id`),
  CONSTRAINT `fk_plan_has_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_plan_has_category_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_has_category`
--

LOCK TABLES `plan_has_category` WRITE;
/*!40000 ALTER TABLE `plan_has_category` DISABLE KEYS */;
INSERT INTO `plan_has_category` VALUES (1,21),(1,22),(2,21),(2,25),(3,21),(3,34),(4,21),(4,23);
/*!40000 ALTER TABLE `plan_has_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_rating`
--

DROP TABLE IF EXISTS `plan_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_rating` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `rated_plan_id` int(11) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_plan_rating_plan1_idx` (`rated_plan_id`),
  KEY `fk_rating_user10` (`user_id`),
  CONSTRAINT `fk_plan_rating_plan1` FOREIGN KEY (`rated_plan_id`) REFERENCES `plan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_user10` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_rating`
--

LOCK TABLES `plan_rating` WRITE;
/*!40000 ALTER TABLE `plan_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_rating_score`
--

DROP TABLE IF EXISTS `plan_rating_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_rating_score` (
  `plan_rating_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`plan_rating_id`,`criteria_id`),
  KEY `fk_rating_score_rating_criteria1_idx` (`criteria_id`),
  KEY `fk_plan_rating_score_plan_rating1_idx` (`plan_rating_id`),
  CONSTRAINT `fk_plan_rating_score_plan_rating1` FOREIGN KEY (`plan_rating_id`) REFERENCES `plan_rating` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_score_rating_criteria10` FOREIGN KEY (`criteria_id`) REFERENCES `rating_criteria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_rating_score`
--

LOCK TABLES `plan_rating_score` WRITE;
/*!40000 ALTER TABLE `plan_rating_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_rating_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_status`
--

DROP TABLE IF EXISTS `plan_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_status`
--

LOCK TABLES `plan_status` WRITE;
/*!40000 ALTER TABLE `plan_status` DISABLE KEYS */;
INSERT INTO `plan_status` VALUES (1,'draft','2024-09-02 08:09:39','2024-09-02 08:09:39'),(2,'published','2024-09-02 08:09:39','2024-09-02 08:09:39'),(3,'open','2024-09-02 08:09:39','2024-09-02 08:09:39'),(4,'closed','2024-09-02 08:09:39','2024-09-02 08:09:39'),(5,'in_progress','2024-09-02 08:09:39','2024-09-02 08:09:39'),(6,'completed','2024-09-02 08:09:39','2024-09-02 08:09:39'),(7,'cancelled','2024-09-02 08:09:39','2024-09-02 08:09:39'),(8,'postponed','2024-09-02 08:09:39','2024-09-02 08:09:39'),(9,'full','2024-09-02 08:09:39','2024-09-02 08:09:39'),(10,'pending_approval','2024-09-02 08:09:39','2024-09-02 08:09:39'),(11,'private','2024-09-02 08:09:39','2024-09-02 08:09:39'),(12,'public','2024-09-02 08:09:39','2024-09-02 08:09:39'),(13,'ended','2024-09-02 08:09:39','2024-09-02 08:09:39'),(14,'under_review','2024-09-02 08:09:39','2024-09-02 08:09:39'),(15,'archived','2024-09-02 08:09:39','2024-09-02 08:09:39');
/*!40000 ALTER TABLE `plan_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_step`
--

DROP TABLE IF EXISTS `plan_step`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id`,`plan_id`),
  KEY `fk_plan_step_plan1_idx` (`plan_id`),
  CONSTRAINT `fk_plan_step_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_step`
--

LOCK TABLES `plan_step` WRITE;
/*!40000 ALTER TABLE `plan_step` DISABLE KEYS */;
INSERT INTO `plan_step` VALUES (1,1,'Quedada','Quedamos delante de mi puerta','11:15:00'),(2,1,'Bar','Nos vamos a un bar juntos','11:15:00'),(3,2,'Reunión','Nos reunimos al final de la rambla de Vilanova','11:15:00'),(4,3,'Encuentro','Nos encontramos en la puerta de mi casa','11:15:00'),(5,3,'Compras','Vamos a comprar snacks y bebidas','11:15:00'),(6,3,'Jugamos!','Jugaremos por 2 horas','11:15:00'),(7,4,'Encuentro','Nos encontramos en el skatepark','12:00:00');
/*!40000 ALTER TABLE `plan_step` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating_criteria`
--

DROP TABLE IF EXISTS `rating_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rating_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` enum('user','plan') NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_criteria`
--

LOCK TABLES `rating_criteria` WRITE;
/*!40000 ALTER TABLE `rating_criteria` DISABLE KEYS */;
/*!40000 ALTER TABLE `rating_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'admin'),(2,'user');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `name` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `genre` enum('M','F','NB','O','NS') NOT NULL,
  `profile_img_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_connection` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `phone_UNIQUE` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('481fbb71-94e3-44b0-b668-37467499b869','Josep','Martin','jmartinbolet@gmail.com',NULL,'$2y$10$QqZqyUPPXNew0jmrlb.2v.RfRUHciVP9AUlsSNrTIr8xJDnebhp9u','1990-09-25 22:00:00','M','assets/images/avatar/1723051155491.png','2024-08-07 17:19:15','2024-08-07 17:19:15',NULL),('77ce78e7-69ae-4b3d-9b6f-fc88a11defd5','Jon','Doe','test@example.us',NULL,'$2y$10$jBQhrjU9tnGT/fCnmH3bxu9rbiISMTw779dk1X4tDiOOok9ujACsS','1990-09-25 22:00:00','M','assets/images/avatar/1722523741385.png','2024-08-01 14:49:01','2024-08-01 14:49:01',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_role`
--

DROP TABLE IF EXISTS `user_has_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_role` (
  `user_id` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_user_has_roles_roles1_idx` (`role_id`),
  KEY `fk_user_has_roles_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_has_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_roles_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_role`
--

LOCK TABLES `user_has_role` WRITE;
/*!40000 ALTER TABLE `user_has_role` DISABLE KEYS */;
INSERT INTO `user_has_role` VALUES ('481fbb71-94e3-44b0-b668-37467499b869',1),('481fbb71-94e3-44b0-b668-37467499b869',2),('77ce78e7-69ae-4b3d-9b6f-fc88a11defd5',1),('77ce78e7-69ae-4b3d-9b6f-fc88a11defd5',2);
/*!40000 ALTER TABLE `user_has_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_rating`
--

DROP TABLE IF EXISTS `user_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_rating` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `rated_user_id` varchar(255) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_rating_user2_idx` (`rated_user_id`),
  KEY `fk_rating_user1` (`user_id`),
  CONSTRAINT `fk_rating_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_user2` FOREIGN KEY (`rated_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_rating`
--

LOCK TABLES `user_rating` WRITE;
/*!40000 ALTER TABLE `user_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_rating_score`
--

DROP TABLE IF EXISTS `user_rating_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_rating_score` (
  `user_rating_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`user_rating_id`,`criteria_id`),
  KEY `fk_rating_score_rating_criteria1_idx` (`criteria_id`),
  CONSTRAINT `fk_rating_score_rating1` FOREIGN KEY (`user_rating_id`) REFERENCES `user_rating` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_score_rating_criteria1` FOREIGN KEY (`criteria_id`) REFERENCES `rating_criteria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_rating_score`
--

LOCK TABLES `user_rating_score` WRITE;
/*!40000 ALTER TABLE `user_rating_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_rating_score` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-02 13:57:51

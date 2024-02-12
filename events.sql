-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: events
-- ------------------------------------------------------
-- Server version	8.0.32-0buntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id_index` (`state_id`),
  CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'تهران',1),(2,'یزد',2),(3,'مشهد',3);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_buyers`
--

DROP TABLE IF EXISTS `event_buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_buyers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int unsigned NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` smallint unsigned NOT NULL DEFAULT '1',
  `unit_price` int NOT NULL,
  `created_ts` bigint NOT NULL,
  `status` enum('paid','pending') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` int unsigned NOT NULL,
  `tracking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `off_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_buyers_event_id_index` (`event_id`),
  KEY `event_buyers_user_id_index` (`user_id`),
  KEY `event_buyers_transaction_id_index` (`transaction_id`),
  KEY `event_buyers_off_id_index` (`off_id`),
  CONSTRAINT `event_buyers_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `event_buyers_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `miras2`.`transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `event_buyers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `miras2`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1777 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_buyers`
--

LOCK TABLES `event_buyers` WRITE;
/*!40000 ALTER TABLE `event_buyers` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_buyers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_comments`
--

DROP TABLE IF EXISTS `event_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int unsigned NOT NULL,
  `rate` smallint unsigned NOT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_bookmark` tinyint(1) DEFAULT NULL,
  `positive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negative` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_comments_event_id_index` (`event_id`),
  KEY `event_comments_user_id_index` (`user_id`),
  CONSTRAINT `event_comments_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `event_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `miras`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_comments`
--

LOCK TABLES `event_comments` WRITE;
/*!40000 ALTER TABLE `event_comments` DISABLE KEYS */;
INSERT INTO `event_comments` VALUES (1,176,3,'qweq',NULL,'dwq$$$___$$$dwq','e2',1,'2023-01-09 09:21:46','2023-01-21 08:46:39',3,'2023-01-21 08:46:39'),(2,186,2,'dqw',NULL,'wd','qw',1,'2023-01-18 07:56:00','2023-01-18 07:56:31',118,'2023-01-18 07:56:31'),(3,186,3,'desc',NULL,'pos','neg',1,'2023-01-18 08:00:38','2023-01-18 08:00:48',120,'2023-01-18 08:00:48'),(4,176,4,'weewqewq',NULL,'weqewq','231321',1,'2023-01-21 08:45:51','2023-01-21 08:46:43',118,'2023-01-21 08:46:43');
/*!40000 ALTER TABLE `event_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_facilities`
--

DROP TABLE IF EXISTS `event_facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_facilities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_facilities`
--

LOCK TABLES `event_facilities` WRITE;
/*!40000 ALTER TABLE `event_facilities` DISABLE KEYS */;
INSERT INTO `event_facilities` VALUES (2,'ddd',1),(6,'qw',1);
/*!40000 ALTER TABLE `event_facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_galleries`
--

DROP TABLE IF EXISTS `event_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_galleries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int unsigned NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` smallint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_galleries_event_id_index` (`event_id`),
  CONSTRAINT `event_galleries_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_galleries`
--

LOCK TABLES `event_galleries` WRITE;
/*!40000 ALTER TABLE `event_galleries` DISABLE KEYS */;
INSERT INTO `event_galleries` VALUES (21,219,'hE9gOiVrJKohHcF43OaJJFcykFzqn0pz7ajBfgCW.jpg',NULL,1000),(22,219,'fpymdiUN6JHjuwRCm6SQTaXX7g11m9yOKVSLcJLp.jpg',NULL,1000);
/*!40000 ALTER TABLE `event_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_sessions`
--

DROP TABLE IF EXISTS `event_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_sessions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int unsigned NOT NULL,
  `start` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
  `end` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
  PRIMARY KEY (`id`),
  KEY `event_sessions_event_id_index` (`event_id`),
  CONSTRAINT `event_sessions_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_sessions`
--

LOCK TABLES `event_sessions` WRITE;
/*!40000 ALTER TABLE `event_sessions` DISABLE KEYS */;
INSERT INTO `event_sessions` VALUES (5,155,'1672722180','1672891500'),(7,187,'1673983800','1674071400'),(8,187,'1674065700','1674149700'),(9,186,'1674077400','1674163800'),(11,157,'1673804160','1673807820'),(12,186,'1674408900','1674499200'),(13,186,'1674509400','1674514500'),(14,186,'1674585000','1674664800'),(15,219,'1675884900','1675974900');
/*!40000 ALTER TABLE `event_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_tags`
--

DROP TABLE IF EXISTS `event_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_tags` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_tags`
--

LOCK TABLES `event_tags` WRITE;
/*!40000 ALTER TABLE `event_tags` DISABLE KEYS */;
INSERT INTO `event_tags` VALUES (3,'wwdassa',1),(4,'aaa',1),(5,'bbb',1),(6,'vvd',1);
/*!40000 ALTER TABLE `event_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_registry` int unsigned DEFAULT NULL,
  `end_registry` int unsigned DEFAULT NULL,
  `off` mediumint unsigned DEFAULT NULL,
  `off_type` enum('percent','value') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `off_expiration` int unsigned DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facilities` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digest` mediumtext COLLATE utf8mb4_unicode_ci,
  `keywords` mediumtext COLLATE utf8mb4_unicode_ci,
  `seo_tags` mediumtext COLLATE utf8mb4_unicode_ci,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ticket_description` longtext COLLATE utf8mb4_unicode_ci,
  `age_description` longtext COLLATE utf8mb4_unicode_ci,
  `level_description` longtext COLLATE utf8mb4_unicode_ci,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `is_in_top_list` tinyint(1) NOT NULL DEFAULT '0',
  `rate` double(8,2) unsigned DEFAULT NULL,
  `seen` int unsigned NOT NULL DEFAULT '0',
  `sell_count` mediumint unsigned NOT NULL DEFAULT '0',
  `rate_count` mediumint unsigned NOT NULL DEFAULT '0',
  `comment_count` mediumint unsigned NOT NULL DEFAULT '0',
  `new_comment_count` mediumint unsigned NOT NULL DEFAULT '0',
  `capacity` mediumint unsigned DEFAULT NULL,
  `price` int unsigned DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `priority` mediumint unsigned NOT NULL DEFAULT '100',
  `city_id` int unsigned DEFAULT NULL,
  `launcher_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','confirmed','rejected','init') COLLATE utf8mb4_unicode_ci DEFAULT 'init',
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_launcher_id_index` (`launcher_id`),
  KEY `events_city_id_index` (`city_id`),
  CONSTRAINT `events_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `events_launcher_id_foreign` FOREIGN KEY (`launcher_id`) REFERENCES `launchers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (155,'Darrell Ziemann',1676276340,1678004340,NULL,'percent',NULL,'dassa_dassa_dassa',NULL,NULL,'qw_qw_ttt',NULL,NULL,NULL,NULL,'Quod in quam laudantium ut ex atque vitae nostrum. Est omnis quasi laudantium ad. Dolorem repellendus ducimus vitae quia modi accusamus. Cumque ut soluta suscipit rerum.',NULL,'child','local',1,1,NULL,4,0,0,0,0,10,440000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','54453453_45445565',54.62,-32.01,20,NULL,34,'2022-12-25 04:49:56','2023-01-09 03:41:59','confirmed','en_fr_fa','http://williamson.com/',NULL),(157,'Prof. Sydni Lubowitz V',1676276396,1678004396,13,'percent',14020101,'aaa_dassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Repudiandae velit ex ducimus est. Non rerum ullam ipsam maiores sit hic. Ea esse accusamus quia expedita iusto optio voluptates. Temporibus sapiente et nostrum quod.',NULL,'adult','local',1,0,NULL,0,0,0,0,0,18,500000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,9,1,34,'2022-12-25 04:49:56','2023-01-09 03:42:01','confirmed','fr_ar_en',NULL,NULL),(158,'Dr. Jazmyne Kohler III',1676276396,1678004396,NULL,'percent',NULL,'bbb_dassa_aaa_dassa',NULL,NULL,'ttt',NULL,NULL,NULL,NULL,'Eligendi dolores ducimus eum accusantium ducimus enim nihil. Id ipsam atque sapiente. Dolorem soluta quis magnam vel commodi.',NULL,'teen','state',1,0,NULL,0,0,0,0,0,4,420000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,6,1,34,'2022-12-25 04:49:57','2023-01-09 03:42:15','confirmed','tr',NULL,NULL),(159,'Koby Deckow',1670228396,1671092396,NULL,'percent',NULL,'bbb_aaa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Magnam perspiciatis doloribus et officiis qui. Voluptas aperiam ut fuga.',NULL,'teen','local',1,1,NULL,0,0,0,0,0,4,460000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,21,1,34,'2022-12-25 04:49:57','2022-12-25 04:49:57','rejected','fa_tr',NULL,NULL),(160,'Erik Daniel',1676276396,1678004396,NULL,'percent',NULL,'dassa_dassa_bbb_bbb',NULL,NULL,'ttt_ttt_ttt_ttt',NULL,NULL,NULL,NULL,'Aliquid autem voluptatum placeat et. Et recusandae voluptatum eum consequatur id et. Tempora expedita facilis quidem incidunt accusantium et quia.',NULL,'old','local',0,0,NULL,0,0,0,0,0,7,390000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,28,NULL,34,'2022-12-25 04:49:57','2022-12-25 04:49:57','rejected','tr_fa_fr_en','http://boyle.com/',NULL),(161,'Carlos Mayert MD',1676276396,1678004396,NULL,'percent',NULL,'dassa_bbb_aaa',NULL,NULL,'ttt',NULL,NULL,NULL,NULL,'Cumque omnis rerum libero eum qui doloremque repudiandae. Ut quis tempore magni quae labore tenetur et. Dignissimos omnis sunt rerum qui ut. Aut quo minima rerum eveniet quos nisi officiis ea.','Aut quae laudantium eos nostrum qui autem. Accusantium ex consequatur repellat tempora consequatur hic. Porro voluptas nostrum fuga est aperiam.','adult','pro',1,1,NULL,2,0,0,0,0,11,330000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,6,NULL,34,'2022-12-25 04:49:57','2023-01-02 07:40:42','confirmed','en','http://abshire.net/alias-aut-voluptatem-placeat-labore-quos.html',NULL),(162,'Maida Shanahan',1676276396,1678004396,NULL,'percent',NULL,'dassa_aaa_dassa_dassa_aaa',NULL,NULL,'ttt_qw_ttt_ttt',NULL,NULL,NULL,NULL,'Nisi quidem laudantium non voluptatibus molestias odio dolor. Modi eaque est quam velit mollitia impedit.',NULL,'adult','state',1,0,NULL,0,0,0,0,0,15,180000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,19,1,34,'2022-12-25 04:49:57','2022-12-25 04:49:57','confirmed','tr_fr_fa',NULL,NULL),(163,'Prof. Jamar Williamson V',1670228396,1671092396,NULL,'percent',NULL,'aaa_dassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Dolorem unde laboriosam vitae nihil culpa. Nostrum sed in veritatis repellendus consequuntur sed. Reiciendis dolores et fugiat deserunt maiores alias nihil. Aliquid aut dolores autem nam.',NULL,'all','national',0,0,NULL,0,0,0,0,0,1,140000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,4,1,34,'2022-12-25 04:49:57','2022-12-25 04:49:57','confirmed','fr',NULL,NULL),(164,'Eulah Monahan',1670228396,1671092396,NULL,'percent',NULL,'bbb_bbb_dassa_dassa',NULL,NULL,'qw_ttt_ttt_qw',NULL,NULL,NULL,NULL,'Esse consequatur sequi eius. Nisi exercitationem mollitia quasi eum illo nihil. Soluta odio amet recusandae autem blanditiis ipsam omnis.',NULL,'child','national',0,0,NULL,0,0,0,0,0,12,490000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,2,1,34,'2022-12-25 04:49:57','2022-12-25 04:49:57','confirmed','fr',NULL,NULL),(165,'Bridie Ward',1676276396,1678004396,16,'percent',14020101,'dassa_bbb_aaa_bbb_aaa',NULL,NULL,'qw_ttt_qw',NULL,NULL,NULL,NULL,'Amet nam repellendus eveniet qui qui ab accusantium iusto. Magnam nisi nobis inventore. Aut illum sint nobis debitis nihil. Minus repellat ex minima autem atque.',NULL,'all','local',1,0,NULL,0,0,0,0,0,15,400000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,13,NULL,34,'2022-12-25 04:49:57','2022-12-25 04:49:57','confirmed','fa_tr_fr_en','http://ebert.com/molestiae-beatae-est-aut',NULL),(166,'Nellie Stoltenberg',1670228396,1671092396,16,'percent',14020101,'aaa_bbb_dassa_bbb',NULL,NULL,'ttt',NULL,NULL,NULL,NULL,'Vitae qui et distinctio dolores repellat. Voluptas odit velit alias quasi ut quam nemo. Vitae ut omnis odio fugit impedit est nostrum. Exercitationem quisquam quisquam ullam autem assumenda.','Aliquam minima et est exercitationem ipsum et placeat repellendus. Deleniti nihil ipsa ducimus odio. Magni et fugit consequatur et quasi eum. Expedita aliquid rerum alias vitae.','all','local',1,1,NULL,0,0,0,0,0,8,400000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,2,1,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','confirmed','ar_en',NULL,NULL),(167,'Camren Haag',1670228396,1671092396,NULL,'percent',NULL,'dassa_aaa_dassa_aaa_dassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Consequatur qui unde et et. Non in eligendi totam molestiae culpa est voluptatem optio.','Asperiores voluptatem aut suscipit quisquam aut. Nihil modi iure labore et dolore sunt nostrum.','all','local',1,1,NULL,0,0,0,0,0,24,120000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,23,NULL,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','confirmed','ar_tr','https://dibbert.com/quod-quae-eveniet-dolorem-voluptatibus-labore-et.html',NULL),(168,'Sylvester Braun Sr.',1676276396,1678004396,NULL,'percent',NULL,'bbb',NULL,NULL,'ttt_ttt',NULL,NULL,NULL,NULL,'Repudiandae nam quis itaque eligendi officiis et. Dicta ipsa soluta explicabo atque quo ullam et. Voluptas cumque a iure eum consectetur. Ab sint consequuntur id error.',NULL,'all','pro',0,0,NULL,0,0,0,0,0,16,130000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,15,1,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','confirmed','fr_fa_ar_en',NULL,NULL),(169,'Isidro Hirthe II',1670228396,1671092396,NULL,'percent',NULL,'bbb_bbb_dassa_dassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Ipsa et perspiciatis et quo unde qui illo. Voluptatem quia quidem tempore at non sequi laudantium. Quia sint ducimus dolorem atque velit quae.',NULL,'teen','national',1,0,NULL,0,0,0,0,0,5,280000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,18,1,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','confirmed','tr_fa',NULL,NULL),(170,'Nella O\'Reilly',1676276396,1678004396,19,'percent',14020101,'dassa_dassa_dassa_aaa_bbb',NULL,NULL,'qw',NULL,NULL,NULL,NULL,'Beatae consequatur vel voluptate aperiam. Quam non et officia. Id natus eum pariatur minima. Iure quo qui soluta aliquid.',NULL,'all','national',1,1,NULL,0,0,0,0,0,28,260000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,9,1,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','rejected','fa',NULL,NULL),(171,'Mrs. Vella Kuhn IV',1676276396,1678004396,NULL,'percent',NULL,'bbb_bbb_dassa_aaa_aaa',NULL,NULL,'ttt_qw_qw',NULL,NULL,NULL,NULL,'Temporibus vitae esse quaerat voluptas autem qui vero. Omnis aperiam nulla totam tenetur sunt pariatur. Asperiores vel quia non. Sapiente voluptatem quis labore voluptates.',NULL,'teen','local',1,0,NULL,0,0,0,0,0,20,190000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,20,NULL,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','confirmed','ar_en_tr_fa','http://www.schultz.com/occaecati-autem-error-exercitationem-quisquam-libero-ut-ut-sit.html',NULL),(172,'Mr. Lavern Koelpin Sr.',1676276396,1678004396,NULL,'percent',NULL,'bbb_dassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Iusto soluta sed officia vero quia. Cupiditate itaque amet aliquam eaque fuga velit recusandae. Optio quod ad vel reprehenderit qui est voluptatibus.','Sunt explicabo nostrum distinctio pariatur pariatur repellat. Aspernatur deserunt impedit quis fuga voluptatem doloremque.','teen','national',1,1,NULL,0,0,0,0,0,17,500000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,13,1,34,'2022-12-25 04:49:58','2022-12-26 09:32:14','pending','en_fr_ar_tr',NULL,NULL),(173,'Rodolfo Bauch MD',1676276396,1678004396,NULL,'percent',NULL,'aaa_dassa_aaa_aaa_aaa',NULL,NULL,'qw_qw_ttt_qw',NULL,NULL,NULL,NULL,'Commodi numquam est error odit reiciendis facilis animi. Recusandae maiores quisquam vitae est totam dolores enim rerum.',NULL,'old','local',1,1,NULL,2,0,0,0,0,10,210000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,26,1,34,'2022-12-25 04:49:58','2023-01-02 07:40:49','confirmed','tr_en_fa_fr',NULL,NULL),(174,'Dell Bayer DVM',1670228396,1671092396,15,'percent',14020101,'dassa_dassa_bbb_dassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Voluptas cupiditate dolore doloremque quia nobis. Consectetur in id sed et. Vel aut ut et nulla. Id officia animi impedit vero minus.','Impedit architecto iusto iure enim molestiae omnis. Placeat a est nobis molestias neque asperiores. Natus beatae sint debitis voluptatem repellendus. Accusantium et quo rerum eos itaque a hic.','teen','state',1,1,NULL,0,0,0,0,0,11,470000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,15,NULL,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','confirmed','fr_tr_fa','http://www.kreiger.com/ipsum-aut-aspernatur-numquam-neque-qui-officiis.html',NULL),(175,'Santina Blick',1676276396,1678004396,NULL,'percent',NULL,'dassa_dassa_dassa_aaa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Commodi modi aut labore. Nulla suscipit molestias quo ut molestiae facere sunt. Pariatur nostrum eligendi omnis.','Et nostrum maiores qui fuga beatae dolorem. Sequi at et adipisci commodi veritatis rerum quia. Laudantium iure totam dolores quia. Numquam ut omnis sit inventore. Dolor qui ut et ea quasi.','all','national',1,1,NULL,0,0,0,0,0,15,420000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,23,1,34,'2022-12-25 04:49:58','2022-12-25 04:49:58','rejected','en_fr_ar',NULL,NULL),(176,'Amari Haag',1676276396,1678004396,19,'percent',14020101,'bbb_dassa',NULL,NULL,'qw_ttt',NULL,NULL,NULL,NULL,'Perspiciatis autem voluptatem rerum. Rem ipsum voluptatibus sit pariatur sit. Quo ab sed asperiores enim.','Aliquid qui veritatis dolore mollitia a. Enim sint dolores reprehenderit nobis aspernatur aut voluptatem. Quam veritatis rerum dignissimos veritatis. Ut labore beatae sit qui voluptas.','teen','state',1,1,3.50,143,0,2,2,0,20,340000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,13,1,34,'2022-12-25 04:49:59','2023-01-29 10:20:23','confirmed','fa_ar',NULL,NULL),(177,'Bella Weber',1676276396,1678004396,11,'percent',14020101,'dassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Fugiat eveniet in a pariatur iusto. Unde ducimus magnam velit consequuntur id dolorum cum. Nulla non commodi expedita est.',NULL,'child','local',1,1,NULL,2,0,0,0,0,11,110000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,11,1,34,'2022-12-25 04:49:59','2023-01-02 07:40:53','confirmed','en_ar',NULL,NULL),(178,'Dr. Alana Considine MD',1676276396,1678004396,NULL,'percent',NULL,'dassa_bbb',NULL,NULL,'ttt',NULL,NULL,NULL,NULL,'Vel dolorem illo veritatis eos. Dolor non est nobis. Labore dolor et rem deleniti saepe. Harum voluptatem aut voluptas.',NULL,'adult','local',1,0,NULL,0,0,0,0,0,27,150000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,19,NULL,34,'2022-12-25 04:49:59','2022-12-25 04:49:59','rejected','en_tr_ar','http://kemmer.info/',NULL),(179,'Deborah Schmitt IV',1676276396,1678004396,NULL,'percent',NULL,'bbb_dassa_bbb_dassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Ullam temporibus cumque adipisci et. Et ex est molestiae qui et. Nulla sit et officia eius ut est.',NULL,'old','pro',1,1,NULL,22,0,0,0,0,15,260000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,15,NULL,34,'2022-12-25 04:49:59','2023-01-16 08:45:06','confirmed','ar_fr_fa_tr','http://www.frami.net/quos-recusandae-non-illo-illum',NULL),(180,'Prof. Jewell Pagac',1676276396,1678004396,15,'percent',14020101,'dassa_dassa_bbb_bbb_dassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Dignissimos optio distinctio laborum. Est corrupti aut ratione est. Ut fuga cumque optio necessitatibus ut sapiente amet neque.','Quibusdam odit deleniti consequatur doloremque ducimus. Dolor est nobis est. Voluptas et suscipit et non et dolorem qui. Illo eveniet quia error et.','all','state',1,1,NULL,0,0,0,0,0,6,310000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,30,1,34,'2022-12-25 04:49:59','2022-12-25 04:49:59','confirmed','en_ar',NULL,NULL),(186,'تست جدید',1673226600,1675984260,NULL,NULL,NULL,'aaa','1zDPFsX2aOE0oUGJO8mgHUIcVtjp8Em0B3J4uo2i.jpg',NULL,'ddd',NULL,NULL,NULL,NULL,'<p style=\"text-align:justify;\">توضیحات</p>','این یک توضیح برای تست است.','child','national',1,0,2.50,188,0,2,2,0,15,20000,NULL,'mmmmm@yahoo.com',NULL,'22758921_33982312',NULL,NULL,100,NULL,34,'2022-12-25 07:52:19','2023-01-29 10:37:02','confirmed','gr_fr','http://google.com',NULL),(187,'tesst',1673203200,1674254100,NULL,NULL,NULL,'aaa_vvd','OGrUu7Owqjz5erMjblTWG2Nps7jGMSz1ZQp53A0Y.jpg',NULL,'ddd',NULL,NULL,NULL,NULL,'<p style=\"text-align:justify;\">این تست است&nbsp;</p>','tessst','teen','state',1,0,NULL,21,0,0,0,0,3,500000,NULL,'mmmmm@yahoo.com',NULL,'33982312',NULL,NULL,100,NULL,34,'2023-01-16 03:42:40','2023-01-19 05:54:42','confirmed','en_gr','https://google.com',NULL),(188,'new test',NULL,NULL,NULL,NULL,NULL,'bbb','GQdjIJzSfXoDt7xjuQ7YiU0w7exY1LSAllFPhwqv.jpg',NULL,'ddd',NULL,NULL,NULL,NULL,'<p style=\"text-align:justify;\">توضیحات</p>',NULL,'child','state',1,0,NULL,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,100,NULL,34,'2023-01-16 10:06:24','2023-01-16 10:06:40','init','tr','http://coo.com',NULL),(189,'Reed Haley',1679207607,1680935607,NULL,'percent',NULL,'bbb',NULL,NULL,'ddd_qw_qw_qw_qw',NULL,NULL,NULL,NULL,'Sed sunt quia est dolorem. Impedit velit assumenda eaque iste ratione rerum repellat. Explicabo ipsa sit temporibus consequatur et repellat repellat qui. Doloribus quas voluptate officia et aut.',NULL,'adult','pro',0,1,NULL,0,0,0,0,0,12,210000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,12,1,29,'2023-01-28 03:03:28','2023-01-28 03:03:28','confirmed','tr',NULL,NULL),(190,'Damon Kuhlman',1679207607,1680935607,NULL,'percent',NULL,'aaa',NULL,NULL,'ddd_qw_qw_ddd_qw',NULL,NULL,NULL,NULL,'Delectus ad ab mollitia voluptatum est. Alias nulla ea aut optio. Consequuntur earum esse vel similique ducimus laborum.','Nobis rem numquam explicabo voluptas occaecati voluptas voluptatem id. Porro unde nihil repellat perferendis et optio laborum fugiat. Vel quo odio odio cupiditate fugit dolor velit.','adult','national',1,0,NULL,0,0,0,0,0,6,210000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,30,1,30,'2023-01-28 03:03:28','2023-01-28 03:03:28','confirmed','fr_ar_tr',NULL,NULL),(191,'Dee DuBuque DVM',1679207607,1680935607,12,'percent',14020101,'wwdassa',NULL,NULL,'ddd_qw_qw',NULL,NULL,NULL,NULL,'In possimus et labore provident repellat voluptatibus. Incidunt voluptates quaerat distinctio. Dolor et enim at dolorem odit mollitia dolores laboriosam.','Inventore omnis quae dolores repellat non fuga et. Qui aspernatur aut a ut facere consequatur ad. Culpa voluptates velit et doloribus. Dolore sed sunt ut id aliquid incidunt.','all','local',1,1,NULL,0,0,0,0,0,21,340000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,30,1,31,'2023-01-28 03:03:28','2023-01-28 03:03:28','confirmed','en_fa',NULL,NULL),(192,'Miss Janae White III',1673159607,1674023607,19,'percent',14020101,'bbb_wwdassa_wwdassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sit exercitationem hic animi vitae nostrum. Blanditiis et et totam soluta fugiat sit et. Quibusdam sapiente quos quisquam at natus.',NULL,'adult','local',1,0,NULL,0,0,0,0,0,30,440000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,20,NULL,29,'2023-01-28 03:03:28','2023-01-28 03:03:28','confirmed','en_fr_fa','https://wolf.com/saepe-aliquam-quo-architecto-in-debitis-voluptatem.html',NULL),(193,'Virgie Schoen',1679207607,1680935607,NULL,'percent',NULL,'bbb_wwdassa_wwdassa_wwdassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Recusandae nihil accusantium non nisi esse repellat voluptatem adipisci. Tenetur rerum totam consequatur quia vel recusandae sunt. Consequatur eveniet minus quam at.',NULL,'all','local',1,0,NULL,0,0,0,0,0,27,360000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,16,NULL,30,'2023-01-28 03:03:28','2023-01-28 03:03:28','rejected','en_fa_ar','http://konopelski.org/et-velit-in-quidem-ullam-exercitationem',NULL),(194,'Prof. Monte Wyman',1673159607,1674023607,20,'percent',14020101,'wwdassa_aaa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Explicabo in qui ut rem. Quo et exercitationem repellendus incidunt a. Cumque dolor dicta voluptates a eos.',NULL,'all','local',0,0,NULL,0,0,0,0,0,19,440000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,3,1,29,'2023-01-28 03:03:28','2023-01-28 03:03:28','confirmed','tr_ar',NULL,NULL),(195,'Titus Hagenes',1673159607,1674023607,12,'percent',14020101,'vvd_vvd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Voluptas natus eaque numquam expedita. Quisquam at omnis distinctio deserunt.',NULL,'child','state',1,0,NULL,0,0,0,0,0,30,220000,'dwqdqwsad\r\ndwq','mmmmm@yahoo.com','https://google.com','22758921__33982312',35.7,51.43,20,1,34,'2023-01-28 03:03:29','2023-01-28 03:03:29','confirmed','en_ar_fr',NULL,NULL),(196,'Amina Mante',1673159607,1674023607,14,'percent',14020101,'vvd_aaa_wwdassa_wwdassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Quod nulla quas ipsum. Quia eius amet ut officiis eaque. Voluptatem est molestiae asperiores in. Qui eos neque praesentium animi officia.',NULL,'child','state',1,1,NULL,0,0,0,0,0,9,190000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,18,NULL,30,'2023-01-28 03:03:29','2023-01-28 03:03:29','confirmed','ar_fa_fr','https://www.rutherford.biz/modi-et-rerum-eius-error-quis-corrupti-officia',NULL),(197,'Prof. Santa Fritsch MD',1679207607,1680935607,NULL,'percent',NULL,'vvd_aaa_bbb',NULL,NULL,'qw',NULL,NULL,NULL,NULL,'Ea accusamus nam exercitationem. Dolor iure est repellendus fugit rerum. Voluptatem occaecati est cum rerum quo voluptatem mollitia. Enim quaerat magni voluptatem dolorum suscipit nisi atque et.','Consequatur enim aperiam dolore sit. Dicta tenetur necessitatibus qui repellat.','adult','national',1,0,NULL,0,0,0,0,0,14,180000,'dwqdwq','dd@yahoo.com','https://ccc.com','332123123__2321321',35.7,51.38,26,3,33,'2023-01-28 03:03:29','2023-01-28 03:03:29','rejected','ar_fa_en_tr',NULL,NULL),(198,'Dr. Ericka Flatley DDS',1679207607,1680935607,NULL,'percent',NULL,'aaa',NULL,NULL,'ddd_qw_ddd_qw_qw',NULL,NULL,NULL,NULL,'Sunt est sapiente iste nesciunt odit. Sed animi quasi modi in. Cum est modi sapiente. Totam officiis reiciendis id voluptate enim qui rerum fugiat. Similique ad cumque sint dignissimos sint quisquam.','In voluptas ipsam et qui. Voluptas tenetur accusantium vel rem. Recusandae perferendis dolore vel qui.','all','pro',1,0,NULL,0,0,0,0,0,24,270000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,3,1,30,'2023-01-28 03:03:29','2023-01-28 03:03:29','rejected','fa_fr_tr',NULL,NULL),(199,'Kieran Renner',1679207607,1680935607,12,'percent',14020101,'vvd_vvd_vvd',NULL,NULL,'qw_qw_qw_qw_qw',NULL,NULL,NULL,NULL,'Quo corrupti modi possimus est natus. Animi ipsa distinctio quam consequuntur reiciendis aspernatur laboriosam ipsa. Est in saepe in aut et quae beatae. Qui et a ullam sed qui.',NULL,'all','national',1,0,NULL,0,0,0,0,0,7,480000,'dwqdwq','dd@yahoo.com','https://ccc.com','332123123__2321321',35.7,51.38,14,3,33,'2023-01-28 03:03:29','2023-01-28 03:03:29','rejected','fr_fa',NULL,NULL),(200,'Deion Beier',1679207607,1680935607,NULL,'percent',NULL,'vvd_wwdassa_aaa_bbb',NULL,NULL,'ddd_qw',NULL,NULL,NULL,NULL,'Voluptatem ea hic assumenda facere nesciunt sapiente. Voluptate nihil nam tempore aut totam. Dignissimos et magni aliquid fugit illo aliquam maxime voluptas.','Soluta deleniti voluptatem voluptatibus autem. Excepturi qui rerum natus nihil culpa eos veniam. Mollitia eum voluptatibus aperiam tempora maxime possimus. Suscipit fugit quia voluptas velit.','teen','state',0,0,NULL,0,0,0,0,0,28,180000,'dwqdqwsad\r\ndwq','mmmmm@yahoo.com','https://google.com','22758921__33982312',35.7,51.43,8,1,34,'2023-01-28 03:03:29','2023-01-28 03:03:29','rejected','fa',NULL,NULL),(201,'Prof. Casey Howell',1673159607,1674023607,NULL,'percent',NULL,'aaa_vvd_vvd',NULL,NULL,'qw_qw_qw',NULL,NULL,NULL,NULL,'Eum possimus sed in voluptatum delectus. Repellat porro quidem iste rem doloremque laboriosam voluptas. Quo itaque et voluptate et suscipit. Ex aspernatur deserunt non quas enim aut reprehenderit.','Iste voluptatem non id et eos molestias dolores. Voluptates odio cum ea voluptatibus fugit id. Illo est et voluptatum recusandae dicta. Et velit similique facere error est.','adult','national',1,0,NULL,0,0,0,0,0,16,260000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,20,NULL,31,'2023-01-28 03:03:29','2023-01-28 03:03:29','rejected','tr','http://bauch.com/ducimus-reprehenderit-voluptatum-tenetur-nihil',NULL),(202,'Janiya Windler',1673159607,1674023607,NULL,'percent',NULL,'wwdassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Quia soluta expedita aspernatur eos qui tempora. Vel quo et repellendus delectus animi inventore. Eum quasi expedita aut.','Sit qui pariatur optio minus sunt aut. Tempore culpa voluptas necessitatibus itaque ipsam soluta exercitationem. Nihil eos sed dolore sunt occaecati autem.','teen','local',1,1,NULL,0,0,0,0,0,12,380000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,19,1,30,'2023-01-28 03:03:29','2023-01-28 03:03:29','confirmed','tr_en_fa_fr',NULL,NULL),(203,'Ora Gusikowski',1679207607,1680935607,13,'percent',14020101,'wwdassa_bbb',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Aut dolor nulla ullam eum qui voluptatem sint. Mollitia nihil id sapiente rerum minus non deleniti. Quas neque molestiae eum.',NULL,'teen','national',0,1,NULL,0,0,0,0,0,6,310000,'weqewqweqqwe\r\nwqe\r\newqweqwqe','aeqqwe@yahoo.com','https://google.com','2222222__222112321__3333333',35.7,51.39,8,NULL,37,'2023-01-28 03:03:29','2023-01-28 03:03:29','confirmed','fr_en_tr_ar','http://kling.net/vel-vel-occaecati-corporis-corporis-ratione-incidunt-qui',NULL),(204,'Selina Braun',1679207607,1680935607,17,'percent',14020101,'vvd_wwdassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Delectus assumenda modi aut aliquid et aut modi ut. Id aut impedit porro cumque quibusdam et sit. Laborum accusantium earum eveniet eius fuga illo sint. Provident et est culpa optio.','Consequatur nisi esse occaecati eum totam nisi molestiae unde. Ut placeat officia non eveniet explicabo accusamus sapiente eius. Rerum culpa eius maxime corrupti voluptate.','adult','state',1,1,NULL,0,0,0,0,0,11,420000,'dwqdwq','dd@yahoo.com','https://ccc.com','332123123__2321321',35.7,51.38,7,3,33,'2023-01-28 03:03:30','2023-01-28 03:03:30','rejected','ar_fr',NULL,NULL),(205,'Keenan Auer',1673159607,1674023607,19,'percent',14020101,'wwdassa_aaa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Quos natus iste error aliquam. Ipsam consequatur laborum pariatur quia quis. Corrupti tenetur veritatis sapiente iure qui atque. Ratione neque cumque cupiditate aut aperiam.','Quas unde quisquam sapiente possimus impedit. Voluptatem cumque doloribus occaecati consequatur. Inventore tempore dicta qui sint quod eligendi.','child','state',0,1,NULL,0,0,0,0,0,4,480000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,11,1,32,'2023-01-28 03:03:30','2023-01-28 03:03:30','confirmed','ar_en_tr',NULL,NULL),(206,'Ozella Sanford DVM',1673159607,1674023607,NULL,'percent',NULL,'wwdassa_wwdassa',NULL,NULL,'qw_ddd_ddd_qw_ddd',NULL,NULL,NULL,NULL,'Id facere omnis incidunt sed laudantium eligendi ut. Delectus et magni vel hic illo. Ea architecto accusantium sed voluptates.',NULL,'child','pro',0,0,NULL,0,0,0,0,0,8,410000,'dwqdqwsad\r\ndwq','mmmmm@yahoo.com','https://google.com','22758921__33982312',35.7,51.43,2,NULL,34,'2023-01-28 03:03:30','2023-01-28 03:03:30','confirmed','fr','http://kerluke.com/occaecati-debitis-voluptates-sint',NULL),(207,'Richie Kuhlman',1679207608,1680935608,15,'percent',14020101,'wwdassa_aaa_wwdassa_bbb_wwdassa',NULL,NULL,'qw_ddd',NULL,NULL,NULL,NULL,'Quam recusandae repudiandae magnam eos qui unde delectus perspiciatis. Molestiae nihil commodi quae et. Corrupti illum molestiae quo soluta id sit aut.','Ullam optio est culpa. Rerum pariatur ut non ut nemo nemo. Necessitatibus porro dicta totam sed qui. Non doloremque repudiandae explicabo similique consequatur ea est perspiciatis.','teen','state',1,0,NULL,0,0,0,0,0,21,270000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,20,NULL,32,'2023-01-28 03:03:30','2023-01-28 03:03:30','confirmed','tr_fa','http://www.waters.com/',NULL),(208,'Burdette Hyatt',1679207608,1680935608,NULL,'percent',NULL,'aaa_aaa_vvd',NULL,NULL,'ddd_ddd_qw',NULL,NULL,NULL,NULL,'Et et exercitationem dolorem sed similique. Quae veritatis et quaerat quaerat eos ea explicabo. Sint maxime sit unde facere. Laborum sint rerum ipsa ut.','Mollitia nisi nemo quam error consectetur vitae. Ea occaecati sunt consequuntur magnam facere consequatur vero dignissimos. Unde voluptatibus recusandae quaerat consequatur.','old','state',0,1,NULL,0,0,0,0,0,13,100000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,14,1,29,'2023-01-28 03:03:30','2023-01-28 03:03:30','confirmed','ar_fr',NULL,NULL),(209,'Ms. Queen Jast',1679207608,1680935608,11,'percent',14020101,'vvd_aaa_aaa_bbb_aaa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sunt adipisci dignissimos earum quis. Explicabo reprehenderit consequatur ab. Dolor eos nihil perferendis aut autem et porro totam. Ut voluptatem quos consequuntur necessitatibus.','Qui voluptas non placeat dolor aut molestias. Praesentium magnam cum optio sed quasi corporis reiciendis. Fugiat corporis laboriosam dolorem fuga deleniti quam iste.','adult','pro',1,1,NULL,0,0,0,0,0,13,440000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,22,1,30,'2023-01-28 03:03:30','2023-01-28 03:03:30','confirmed','ar_fr',NULL,NULL),(210,'Mrs. Maximillia Rolfson',1679207608,1680935608,10,'percent',14020101,'vvd_vvd_wwdassa',NULL,NULL,'qw_qw_qw_qw_ddd',NULL,NULL,NULL,NULL,'Omnis quia qui maiores. Sit ut beatae facere placeat nesciunt. Aliquid adipisci vel repellendus qui quod. Saepe ex ad non consequatur consequatur explicabo eius.','Expedita cum voluptate aut quos dicta et repellat. Sapiente unde dolor illum molestias eveniet voluptatem ipsa sapiente. Consequatur voluptatum incidunt enim veritatis rem est.','child','pro',1,1,NULL,0,0,0,0,0,3,490000,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404','larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,8,1,32,'2023-01-28 03:03:30','2023-01-28 03:03:30','rejected','ar_en',NULL,NULL),(211,'Ally Kutch',1679207608,1680935608,NULL,'percent',NULL,'aaa_vvd_bbb',NULL,NULL,'qw',NULL,NULL,NULL,NULL,'Odio omnis voluptatem cum ipsum qui. Non qui quos omnis dolorem sint. Dignissimos voluptatem mollitia doloremque nihil et sed.',NULL,'old','pro',1,1,NULL,0,0,0,0,0,25,350000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,19,1,30,'2023-01-28 03:03:31','2023-01-28 03:03:31','confirmed','fr_fa_en_ar',NULL,NULL),(212,'Miss Germaine Blanda',1679207608,1680935608,16,'percent',14020101,'aaa_bbb_aaa_aaa_vvd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Et nulla fugiat cumque molestiae voluptas. Voluptatem ut ullam fugit at. Ut perferendis fugit et modi corporis natus.',NULL,'teen','state',1,0,NULL,0,0,0,0,0,26,390000,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132','msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,26,1,30,'2023-01-28 03:03:31','2023-01-28 03:03:31','confirmed','tr',NULL,NULL),(213,'Maxime Kris DDS',1679207608,1680935608,18,'percent',14020101,'wwdassa_bbb_wwdassa_vvd',NULL,NULL,'ddd_ddd_ddd_qw',NULL,NULL,NULL,NULL,'Dolores et ducimus vitae vel et a sed. Enim eos et aperiam. Officia nihil aliquid sapiente cupiditate ipsum illum id. Nihil aut assumenda modi iure atque dignissimos eaque.','Rerum odio laudantium enim eaque laboriosam ut neque. Aut tenetur amet cumque quam illum sed. Non ipsam aut eum qui eligendi nemo.','child','state',1,0,NULL,0,0,0,0,0,27,430000,'dwqdqwsad\r\ndwq','mmmmm@yahoo.com','https://google.com','22758921__33982312',35.7,51.43,5,1,34,'2023-01-28 03:03:31','2023-01-28 03:03:31','confirmed','fr_tr_fa_en',NULL,NULL),(214,'Caden Feeney',1673159608,1674023608,NULL,'percent',NULL,'wwdassa_aaa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Inventore cum maxime mollitia voluptate aspernatur. Doloremque quaerat repellat nemo vel ab et esse voluptate. Aliquid et pariatur et nesciunt ex rem et distinctio.','Dolor dignissimos ea est. Nihil rem impedit occaecati placeat officiis ratione. Quis aperiam eveniet eum maiores adipisci. Aut illo veniam repellendus debitis ipsa maiores consectetur sed.','all','state',1,1,NULL,0,0,0,0,0,8,150000,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171','eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,20,1,31,'2023-01-28 03:03:31','2023-01-28 03:03:31','confirmed','fa_fr',NULL,NULL),(215,'Prof. Malika Maggio DDS',1679207608,1680935608,18,'percent',14020101,'vvd_aaa_wwdassa_aaa_aaa',NULL,NULL,'ddd_ddd_qw',NULL,NULL,NULL,NULL,'Delectus cupiditate quis quas deleniti et aut. Ut sequi est autem numquam. Cumque eos officia voluptas rerum ipsum consequatur.',NULL,'child','state',1,0,NULL,0,0,0,0,0,21,370000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,2,1,29,'2023-01-28 03:03:31','2023-01-28 03:03:31','confirmed','ar_fa',NULL,NULL),(216,'Isabelle Daniel',1679207608,1680935608,NULL,'percent',NULL,'vvd',NULL,NULL,'qw_ddd_ddd_qw',NULL,NULL,NULL,NULL,'Rerum facilis quam fugit error mollitia quasi. Iure voluptatem atque est temporibus consectetur et. Soluta commodi ab debitis nobis magnam. Enim odio repellat ratione non ad totam inventore iste.','Corrupti repudiandae autem voluptatum eius velit consectetur. Assumenda natus pariatur earum perferendis aut. Nostrum et rem quis.','teen','national',1,1,NULL,0,0,0,0,0,7,500000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,26,NULL,29,'2023-01-28 03:03:31','2023-01-28 03:03:31','confirmed','en_tr_fa','http://www.willms.com/maiores-eum-veritatis-suscipit-labore',NULL),(217,'Ms. Lola Medhurst DDS',1679207608,1680935608,NULL,'percent',NULL,'bbb_vvd_vvd',NULL,NULL,'qw_ddd_ddd',NULL,NULL,NULL,NULL,'Qui rerum expedita et blanditiis cupiditate itaque aut. Necessitatibus optio ea quos excepturi. Voluptates facere ut et molestiae beatae neque. Sit debitis sint veniam in recusandae numquam.','Tenetur quod ut quam fugit. Cupiditate rerum quia beatae cum velit enim adipisci enim. Mollitia dolores eos explicabo. Impedit et architecto facere.','old','pro',0,0,NULL,0,0,0,0,0,16,420000,'weqewqweqqwe\r\nwqe\r\newqweqwqe','aeqqwe@yahoo.com','https://google.com','2222222__222112321__3333333',35.7,51.39,7,NULL,37,'2023-01-28 03:03:32','2023-01-28 03:03:32','confirmed','ar_fr','http://www.nikolaus.info/quia-repellendus-et-deleniti-sint-sed.html',NULL),(218,'Prof. Leanne Lockman',1679207608,1680935608,18,'percent',14020101,'vvd_aaa',NULL,NULL,'ddd_ddd_ddd_ddd',NULL,NULL,NULL,NULL,'Dolores tempora in voluptatum perspiciatis asperiores fugiat. Eum minima dolore blanditiis ut consequuntur id distinctio repellat. Aperiam dolorum nisi esse temporibus ut impedit nemo quas.','Facere sint vero id nulla dignissimos perferendis. Adipisci repellendus odio eveniet cupiditate libero dolores. Id repellat excepturi beatae et minima suscipit.','teen','local',1,0,NULL,0,0,0,0,0,19,300000,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754','hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,14,1,29,'2023-01-28 03:03:32','2023-01-28 03:03:32','rejected','tr',NULL,NULL),(219,'dwqdwqdwq',1675174320,1675189800,NULL,NULL,NULL,'aaa_bbb','HFfSK5gzeIAjPkpct1rFeGIXGhvYauKK8fGivaXm.jpg',NULL,'ddd',NULL,NULL,NULL,NULL,'<p style=\"text-align:justify;\">qdwqdqqdw</p>','dwq','adult','state',1,0,NULL,0,0,0,0,0,30,100000,'dwqdwqdwq',NULL,NULL,NULL,35.70690016853575,51.40480651855384,100,1,40,'2023-01-29 07:26:47','2023-01-29 07:31:37','rejected','en_tr',NULL,'1971933113');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `launcher_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `followers_user_id_launcher_id_unique` (`user_id`,`launcher_id`),
  KEY `followers_user_id_index` (`user_id`),
  KEY `followers_launcher_id_index` (`launcher_id`),
  CONSTRAINT `followers_launcher_id_foreign` FOREIGN KEY (`launcher_id`) REFERENCES `launchers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `followers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `miras`.`users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followers`
--

LOCK TABLES `followers` WRITE;
/*!40000 ALTER TABLE `followers` DISABLE KEYS */;
INSERT INTO `followers` VALUES (3,3,30,'2023-01-16 06:03:03','2023-01-16 06:03:03'),(7,3,34,'2023-01-17 09:11:17','2023-01-17 09:11:17'),(11,118,34,'2023-01-18 09:50:59','2023-01-18 09:50:59');
/*!40000 ALTER TABLE `followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `launcher_bank_accounts`
--

DROP TABLE IF EXISTS `launcher_bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launcher_bank_accounts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `launcher_id` int unsigned NOT NULL,
  `shaba_no` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `launcher_bank_accounts_launcher_id_index` (`launcher_id`),
  CONSTRAINT `launcher_bank_accounts_launcher_id_foreign` FOREIGN KEY (`launcher_id`) REFERENCES `launchers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `launcher_bank_accounts`
--

LOCK TABLES `launcher_bank_accounts` WRITE;
/*!40000 ALTER TABLE `launcher_bank_accounts` DISABLE KEYS */;
INSERT INTO `launcher_bank_accounts` VALUES (5,40,'123456789123456789123456',NULL,'2023-01-29 08:20:27','2023-01-29 08:20:27','pending',1),(6,33,'123456789123456789123456',NULL,'2023-01-29 10:27:00','2023-01-29 10:27:00','pending',1);
/*!40000 ALTER TABLE `launcher_bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `launcher_certifications`
--

DROP TABLE IF EXISTS `launcher_certifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launcher_certifications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `launcher_id` int unsigned NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `launcher_certifications_launcher_id_index` (`launcher_id`),
  CONSTRAINT `launcher_certifications_launcher_id_foreign` FOREIGN KEY (`launcher_id`) REFERENCES `launchers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `launcher_certifications`
--

LOCK TABLES `launcher_certifications` WRITE;
/*!40000 ALTER TABLE `launcher_certifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `launcher_certifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `launcher_comments`
--

DROP TABLE IF EXISTS `launcher_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launcher_comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `launcher_id` int unsigned NOT NULL,
  `rate` smallint unsigned NOT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_bookmark` tinyint(1) DEFAULT NULL,
  `positive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negative` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `launcher_comments_launcher_id_index` (`launcher_id`),
  KEY `launcher_comments_user_id_index` (`user_id`),
  CONSTRAINT `launcher_comments_launcher_id_foreign` FOREIGN KEY (`launcher_id`) REFERENCES `launchers` (`id`),
  CONSTRAINT `launcher_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `miras`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `launcher_comments`
--

LOCK TABLES `launcher_comments` WRITE;
/*!40000 ALTER TABLE `launcher_comments` DISABLE KEYS */;
INSERT INTO `launcher_comments` VALUES (1,34,2,'dqwdwqwq',NULL,'weqwq','aaasad',1,'2023-01-18 07:57:56','2023-01-18 07:58:37',118,'2023-01-18 07:58:37');
/*!40000 ALTER TABLE `launcher_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `launchers`
--

DROP TABLE IF EXISTS `launchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `user_NID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_birth_day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) unsigned DEFAULT NULL,
  `seen` int unsigned NOT NULL DEFAULT '0',
  `rate_count` mediumint unsigned NOT NULL DEFAULT '0',
  `comment_count` mediumint unsigned NOT NULL DEFAULT '0',
  `new_comment_count` mediumint unsigned NOT NULL DEFAULT '0',
  `about` longtext COLLATE utf8mb4_unicode_ci,
  `launcher_type` enum('haghighi','hoghoghi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hoghoghi',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digest` mediumtext COLLATE utf8mb4_unicode_ci,
  `keywords` mediumtext COLLATE utf8mb4_unicode_ci,
  `seo_tags` mediumtext COLLATE utf8mb4_unicode_ci,
  `launcher_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `launcher_city_id` int unsigned DEFAULT NULL,
  `launcher_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `launcher_site` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `launcher_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `launcher_x` double(8,2) DEFAULT NULL,
  `launcher_y` double(8,2) DEFAULT NULL,
  `company_newspaper` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_last_changes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_NID_card` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `follower_count` mediumint unsigned NOT NULL DEFAULT '0',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','confirmed','rejected','init') COLLATE utf8mb4_unicode_ci DEFAULT 'init',
  `back_img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `launchers_user_id_unique` (`user_id`),
  UNIQUE KEY `launchers_phone_unique` (`phone`),
  KEY `launchers_launcher_city_id_index` (`launcher_city_id`),
  KEY `launchers_user_id_index` (`user_id`),
  CONSTRAINT `launchers_launcher_city_id_foreign` FOREIGN KEY (`launcher_city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `launchers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `miras`.`users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `launchers`
--

LOCK TABLES `launchers` WRITE;
/*!40000 ALTER TABLE `launchers` DISABLE KEYS */;
INSERT INTO `launchers` VALUES (29,138,'0019191919','doyle.wava@macejkovic.org','1368/02/04',NULL,2,0,0,0,'Cum necessitatibus et sunt aut. Et et nam quo. Non sit et unde itaque possimus et. Cum molestiae impedit voluptatem.','hoghoghi','Janessa Swift','khososi','11521-5563','28985',NULL,NULL,NULL,NULL,NULL,'2006 Streich Shore Suite 680\nSchowaltertown, HI 95803-7754',1,'hilda.feest@lind.net','http://www.pollich.info/dolor-est-impedit-aspernatur-est-cumque-in-voluptatum-quia','1-386-217-4339',82.69,10.87,'Y4AvZbS7lusIxr2upGKqArunrLnjh6fHTTDZGp7U.jpg','8cwEXWtBYPd7NxhbtAqixp1sOELBEStsIHsvu953.jpg','DbPtz9XU7YFviYWewE02sHOyN86SvgOzZqwxZTTK.jpg','2022-12-25 04:49:49','2023-01-18 04:42:00',0,'Dr. Chance Torp III','Mr. Immanuel Treutel DVM','+1 (760) 665-7584','confirmed',NULL),(30,139,'0019191920','lernser@gmail.com','1368/02/04',NULL,10,0,0,0,'Reprehenderit aut reiciendis vero. Ut quis aut et consequatur et. Magnam facere deleniti ea deleniti animi alias.','hoghoghi','Prof. Erich Eichmann II','khososi','26118','14473-9745',NULL,NULL,NULL,NULL,NULL,'797 Grant Forks Apt. 152\nPort Estelltown, HI 36132',1,'msmith@hotmail.com','http://ward.com/nulla-at-quo-perspiciatis-quos.html','260-994-3004',-7.33,31.29,NULL,NULL,NULL,'2022-12-25 04:49:49','2023-01-16 07:53:29',1,'Dr. Baylee Lueilwitz','Emanuel McClure','(571) 730-6127','confirmed',NULL),(31,140,'0019191921','davon43@roob.com','1368/02/04',NULL,0,0,0,0,'Quasi perferendis non quia eveniet aut. Voluptatem rem ut consequatur quos. In illum ut consequuntur soluta inventore.','hoghoghi','Vella Jerde','khososi','81487-1245','80486',NULL,NULL,NULL,NULL,NULL,'5154 Hope Brooks Suite 501\nHaroldland, RI 92448-8171',1,'eliane.waelchi@yahoo.com','http://bailey.com/labore-cupiditate-voluptates-corporis-consequatur-exercitationem-qui-voluptas-molestias','+1-323-364-0332',-59.35,-156.41,NULL,NULL,NULL,'2022-12-25 04:49:49','2022-12-25 04:49:49',0,'Angelita Waters II','Junior Pagac IV','470.949.2064','confirmed',NULL),(32,141,'0019191922','towne.geraldine@wolf.com','1368/02/04',NULL,0,0,0,0,'Et culpa quaerat temporibus rerum aut occaecati. Voluptatem nobis incidunt qui mollitia. Sed ex beatae excepturi sunt omnis officia. Rerum et consequatur facere dolorem aliquam aliquam enim ut.','hoghoghi','Kirsten Heaney DVM','khososi','99123','68251',NULL,NULL,NULL,NULL,NULL,'96191 Domenick Mission Apt. 064\nNorth Mohamedburgh, MO 95404',1,'larissa.satterfield@terry.com','http://www.douglas.com/tempore-et-quidem-est-nihil','762-683-7707',54.62,-32.01,NULL,NULL,NULL,'2022-12-25 04:49:50','2023-01-16 10:01:36',0,'Jeffry Anderson','Dr. Molly Bartell','+1.336.401.5189','confirmed',NULL),(33,3,'0020045098','bbb@yahoo.com','1376/1/23',NULL,2,0,0,0,NULL,'haghighi',NULL,NULL,NULL,NULL,'7mGOy7nHIqUCgQJi3sMNmnsLaGEPWRfAShGDqM3x.jpg',NULL,NULL,NULL,NULL,'dwqdwq',3,'dd@yahoo.com','https://ccc.com','332123123__2321321',35.70,51.38,'wQfAO5B1Bj1qk83vekHUbv2YOyqQGo3rOzmkrwRP.jpg','fWuU9AvvkRGDOwafeF86XGLFeMgUBLYJVqkKVwfB.jpg','jhHDEHFXhBcdUimoQ89GJL4AFXjYN7b0xVImPlz5.jpg','2022-12-25 09:34:58','2023-01-17 10:43:04',0,'تست جدید','تست جدید','09214519087','confirmed',NULL),(34,118,'0250040859','sss@yahoo.com','1374/2/14',2.00,100,1,1,0,'dwqdwqdwq\r\newqewqewqsa\r\ndwq','haghighi','sdwqwq',NULL,'1972321213',NULL,'kNz73NUNIdRYcAhXfSvnUiJkz3OgzBlbgpd2Nirg.jpg',NULL,NULL,NULL,NULL,'dwqdqwsad\r\ndwq',1,'mmmmm@yahoo.com','https://google.com','22758921__33982312',35.70,51.43,NULL,NULL,'DE7v0A6uehjUnlpw3ygqWM7VboYZ6Rqdge4O7bo7.jpg','2023-01-08 10:09:28','2023-01-29 05:17:23',2,'undefined','undefined','09391328463','pending',NULL),(37,109,'0018914373','wqw@yahoo.com','1387/1/23',NULL,0,0,0,0,'dsadqqeqweqw\r\nwqewqeqwewqe\r\nwqeweq','hoghoghi','eqwewq','art','1971933113','212132321321','K3fsZc26H9absBMEgwO96Wm5cMUVVp6uoqYcWCgn.jpg',NULL,NULL,NULL,NULL,'weqewqweqqwe\r\nwqe\r\newqweqwqe',1,'aeqqwe@yahoo.com','https://google.com','2222222__222112321__3333333',35.70,51.39,'RuVtpvyVvEIFOBLPMsOqrx3LJ0sDT4Bpbn9n2LyD.jpg','s4vkDfOjnMxGNLQDadgmqU3llwIR2xX1mMGI0FRP.jpg','zGe4hU6bqyYvi35yJNbLXbXmU3gGh7CUCnDxJhJl.jpg','2023-01-16 05:32:37','2023-01-16 05:36:52',0,'undefined','undefined','09123333394','confirmed',NULL),(38,121,'0018914373','mmms@gmail.com','1390/3/20',NULL,0,0,0,0,'این تست بیو است','haghighi','قنداب',NULL,'1971933113',NULL,'esQxr07n0y8k30nRxx3om6AL0PeQjlSwPCUtQN3S.jpg',NULL,NULL,NULL,NULL,'این یک آدرس تست است.',1,'mmp@yahoo.com','https://google.com','222312123',35.70,51.43,NULL,NULL,'YXZZj2EiG3Fg6jejbhiEFsuWa6SbkjVv0FGQVm6Y.jpg','2023-01-29 05:27:52','2023-01-29 05:27:57',0,'undefined','undefined','09902201345','pending',NULL),(40,122,'0018914373','dwqdwq@yahoo.com','1345/3/23',NULL,2,0,0,0,NULL,'haghighi','dwq',NULL,'1971933113',NULL,'QLWMCw9dlByWe3N5k1t2pM0Rqw77T4NptoEbysBF.jpg',NULL,NULL,NULL,NULL,'dwqd\r\newqewq',1,NULL,NULL,NULL,35.71,51.38,NULL,NULL,'u7x4m1btAPL3p8zkTMu3mYuZdMu3GBndwEdyWHNO.jpg','2023-01-29 07:02:02','2023-01-29 10:24:46',0,'qweqw','eqwewq','09356908743','confirmed',NULL);
/*!40000 ALTER TABLE `launchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `money_requests`
--

DROP TABLE IF EXISTS `money_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `money_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `launcher_bank_account_id` int unsigned NOT NULL,
  `amount` int unsigned NOT NULL,
  `additional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('pending','rejected','paid','confirmed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `money_requests_user_id_index` (`user_id`),
  KEY `money_requests_launcher_bank_account_id_index` (`launcher_bank_account_id`),
  CONSTRAINT `money_requests_launcher_bank_account_id_foreign` FOREIGN KEY (`launcher_bank_account_id`) REFERENCES `launcher_bank_accounts` (`id`),
  CONSTRAINT `money_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `miras`.`users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money_requests`
--

LOCK TABLES `money_requests` WRITE;
/*!40000 ALTER TABLE `money_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `money_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'تهران'),(2,'یزد'),(3,'خراسان رضوی');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-30 12:11:03

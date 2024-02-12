-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: miras2
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
-- Table structure for table `activation`
--

DROP TABLE IF EXISTS `activation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activation` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vc_expired_at` bigint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activation_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activation`
--

LOCK TABLES `activation` WRITE;
/*!40000 ALTER TABLE `activation` DISABLE KEYS */;
INSERT INTO `activation` VALUES (15,'09214915905',150564,'2023-01-01 03:28:24','2023-01-01 03:28:24',1672556424);
/*!40000 ALTER TABLE `activation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `address` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `x` double(8,2) NOT NULL,
  `y` double(8,2) NOT NULL,
  `city_id` int unsigned NOT NULL,
  `recv_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recv_last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recv_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_name_user_id_unique` (`name`,`user_id`),
  KEY `address_user_id_index` (`user_id`),
  KEY `address_city_id_index` (`city_id`),
  CONSTRAINT `address_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `events`.`cities` (`id`),
  CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,116,'بایبلابمنتابیمکانبلاپبابل\nایبابتنمیلتیبکگلنیبخ\nیبلبپلیبلایگن','سینا عادلی کودهی','1517974414',35.70,51.42,174,'سینا','عادلی کودهی','09123840843',0),(2,3,'این یک آدرس تست است. تهران - چهار راه جهان کودک - میدان ونک - چهار راه ولیعصر عج میدان مادر خ ۲ کوچه ۱۰','sadq','1971933123',35.71,51.38,1,'sadwq','asdwq','09121111111',1);
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `href` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` enum('home','list','detail') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` enum('event','shop') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'https://google.com','tag','BW8ajrHmRsQYCYdnNY8isappPBMJoT0ZgswfhfUS.jpg','home','shop'),(2,'https://google.com','کفش','qvjRHfOG0OrRX3Rz7yDgsuO724ULAlWO9jqoBFSz.jpg','home','shop'),(3,NULL,NULL,'mjk6jiwoWSS5ZpUc279tnOKyTgyhnWRA3GBBjVDK.jpg','home','event'),(4,NULL,NULL,'JVa8MjmOSVkXAlWTkIkgtOctyP31flL0ETMrHMuG.jpg','home','event');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digest` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `article_tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int unsigned NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` enum('shop','event') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (7,'/rOnywwVAGXV8Yws8veBKEXjeOn0C6gT1MOoSywSp.jpg','سفالگری','به هنر ساخت ظروف گلی با دست و یا چرخ، سفالگری می گویند. مرغوب ترین خاک برای تولید ظروف سفالی خاک رس است؛','به هنر ساخت ظروف گلی با دست و یا چرخ، سفالگری می گویند. مرغوب ترین خاک برای تولید ظروف سفالی خاک رس است؛','سفالگری','سفالگری,فرهنگ و هنر','صنایع دستی','2022-10-13 09:23:31','2022-10-13 09:27:28','سفالگری',1,1,NULL,'shop'),(8,'/ON4K0B9fR5jxdxACNmAIGvYuEAkkT34Q6MtY9yPI.jpg',NULL,'کااشی کاری یکی از نمادهای مهم در معماری ایرانی است که به صورت آجرهای لعاب دار برای زیبایی داخل و یا بیرون بنا استفاده می شود. کلمه کاشی نام خود را از شهر کاشان که از مهمترین مراکز تولید سفال و کاشی مرکز ایران به شمار می رود گرفته است.','کاشی کاری یکی از نمادهای مهم در معماری ایرانی است که به صورت آجرهای لعاب دار برای زیبایی داخل و یا بیرون بنا استفاده می شود. کلمه کاشی نام خود را از شهر کاشان که از مهمترین مراکز تولید سفال و کاشی مرکز ایران به شمار می رود گرفته است.',NULL,NULL,'فرهنگ و هنر','2022-10-13 09:24:38','2022-11-13 06:41:32','کاشی کاری',2,1,NULL,'shop'),(9,'/S4UWcw8CIPls5i4ZOwvkgu2YvnQyIZ9xMOOYjLOl.jpg',NULL,'میناکاری هنری است که از آن برای زینت بخشیدن به زیورآلات و ظروف استفاده می شود. به گفته پرفسور پوپ در کتاب \"سیری در هنر ایران\" میناکاری هنر درخشان آتش و خاک است با رنگ های پخته و درخشان که سابقه آن به 1500 سال پیش از میلاد می رسد. بنا به اعتقاد پژوهشگران این هنر در ایران بنیان نهاده شده و سپس به سایر نقاط جهان راه یافته است. یکی از قدیمی ترین آثار مکشوفه در خاک ایران بازوبندی از جنس طلاست که منقش به مینا کاری است، قدمت این اثر به دوران هخامنشی می-رسد و در حال حاضر در موزه ویکتوریا و آلبرت لندن نگهداری می شود؛ همچنین بشقاب های ساسانی کشف شده در ارمنستان که در موزه متروپولیتن نیویورک و در موزه هنرهای اسلامی برلین نگهداری می شوند. دوره سلجوقیان را اوج هنری میناکاری می دانند و آثار کار شده را به کشورهای هم جوار نیز صادر می کردند؛ یکی از معروف ترین آثار این دوره که شهرت جهانی دارد \"سینی آلب ارسلان\" نام دارد که میناکاری روی نقره است و امروزه در موزه صنایع ظریفه بوستون نگهداری می شود. حسن کاشانی هنرمند این اثر است که نامش با خط کوفی بر روی آن حک شده است. روش میناکاری به این صورت است که ابتدا زیر ساخت مورد نظر را که امروزه معمولاً از فلز مس مرغوب است آماده کرده،','میناکاری هنری است که از آن برای زینت بخشیدن به زیورآلات و ظروف استفاده می شود. به گفته پرفسور پوپ در کتاب \"سیری در هنر ایران\" میناکاری هنر درخشان آتش و خاک است با رنگ های پخته و درخشان که سابقه آن به 1500 سال پیش از میلاد می رسد. بنا به اعتقاد پژوهشگران این هنر در ایران بنیان نهاده شده و سپس به سایر نقاط جهان راه یافته است. یکی از قدیمی ترین آثار مکشوفه در خاک ایران بازوبندی از جنس طلاست که منقش به مینا کاری است، قدمت این اثر به دوران هخامنشی می-رسد و در حال حاضر در موزه ویکتوریا و آلبرت لندن نگهداری می شود؛ همچنین بشقاب های ساسانی کشف شده در ارمنستان که در موزه متروپولیتن نیویورک و در موزه هنرهای اسلامی برلین نگهداری می شوند. دوره سلجوقیان را اوج هنری میناکاری می دانند و آثار کار شده را به کشورهای هم جوار نیز صادر می کردند؛ یکی از معروف ترین آثار این دوره که شهرت جهانی دارد \"سینی آلب ارسلان\" نام دارد که میناکاری روی نقره است و امروزه در موزه صنایع ظریفه بوستون نگهداری می شود. حسن کاشانی هنرمند این اثر است که نامش با خط کوفی بر روی آن حک شده است. روش میناکاری به این صورت است که ابتدا زیر ساخت مورد نظر را که امروزه معمولاً از فلز مس مرغوب است آماده کرده،',NULL,NULL,'میراث ناملموس','2022-10-13 09:25:55','2022-10-13 09:27:47','میناکاری',3,1,NULL,'shop'),(10,'/r6LBkBvXh8LTCjxyzqxnfPjIl2BNyaa9WtcTK94C.jpg',NULL,'«قالی بافی»یکی از صنایع دستی سنتی بسیار معروف ایران است. بسیاری به جای کلمه قالی، کلمۀ فرش را به کار می برند. واژه قالی به بافته ایی گفته می شود که بر روی دار (عمودی یا افقی) بافته  و در آن تکه های کوتاه الیاف به وسیله تکنیکی خاص، به دور تارهای موازی، گره زده می شود تا بافته دارای پرزهای بلند شود (پرزهای بلند باعث نرمی و لطافت سطح قالی می شود). مواد اولیه قالی برای تار پشم، کرک یا ابریشم پُرتاب، و برای پود نخ پنبه ای، پشم یا ابریشم کم تاب است، و دارای نقوش اسلیمی، ختایی و هندسی است. کلمه فرش عربی و اسم مفعول آن مفروش است. فرش، در عربی به معنای زمین است و متضاد کلمه عرش، یعنی آسمان، و به هر گستردنی می تواند اطلاق شود.','«قالی بافی»یکی از صنایع دستی سنتی بسیار معروف ایران است. بسیاری به جای کلمه قالی، کلمۀ فرش را به کار می برند. واژه قالی به بافته ایی گفته می شود که بر روی دار (عمودی یا افقی) بافته  و در آن تکه های کوتاه الیاف به وسیله تکنیکی خاص، به دور تارهای موازی، گره زده می شود تا بافته دارای پرزهای بلند شود (پرزهای بلند باعث نرمی و لطافت سطح قالی می شود). مواد اولیه قالی برای تار پشم، کرک یا ابریشم پُرتاب، و برای پود نخ پنبه ای، پشم یا ابریشم کم تاب است، و دارای نقوش اسلیمی، ختایی و هندسی است. کلمه فرش عربی و اسم مفعول آن مفروش است. فرش، در عربی به معنای زمین است و متضاد کلمه عرش، یعنی آسمان، و به هر گستردنی می تواند اطلاق شود.',NULL,NULL,'صادرات','2022-10-13 09:26:26','2022-10-13 09:27:55','قالی بافی',4,1,NULL,'shop'),(11,'/GI8GYFtaEGC7XBRYHeRNMP5BL44afc9MrcSa5V4M.jpg',NULL,'تاریخ یزد با تاریخچه ی نساجی در این شهر گره خورده­ است. تولید منسوجات سنتی یزد از این لحاظ در اولویت قرار داشت که اولاً مواد اولیه ی آن یعنی پنبه و ابریشم را به راحتی در منطقه تولید می ­کردند و دیگر این که زنان می­ توانستد آن­ را در منزل انجام دهند. اما عامل دیگری نیز در تاریخچه ی نساجی یزد مؤثر بود و آن واقع­شدن این شهر در مسیر جاده ی ابریشم است که به اهالی منطقه این امکان را می­داد که به راحتی از این طریق داد و ستد کنند.','تاریخ یزد با تاریخچه ی نساجی در این شهر گره خورده­ است. تولید منسوجات سنتی یزد از این لحاظ در اولویت قرار داشت که اولاً مواد اولیه ی آن یعنی پنبه و ابریشم را به راحتی در منطقه تولید می ­کردند و دیگر این که زنان می­ توانستد آن­ را در منزل انجام دهند. اما عامل دیگری نیز در تاریخچه ی نساجی یزد مؤثر بود و آن واقع­شدن این شهر در مسیر جاده ی ابریشم است که به اهالی منطقه این امکان را می­داد که به راحتی از این طریق داد و ستد کنند.',NULL,NULL,'صنایع دستی فاخر','2022-10-13 09:26:50','2022-10-13 09:28:05','دارایی بافی (ایکات) ((یزد))',4,1,NULL,'shop'),(12,'cDjJN4NL0iVqDQsi091jTiruVgk6sX5NABBzoxHB.jpg','dd','dwqdwq','<p style=\"text-align:justify;\">dwqdwqdqw</p>','dwq','dwqdwq','wqwq','2023-01-02 08:37:44','2023-01-02 08:37:44','dwq',1,1,'wq','event');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Alborz','OUUfxMR2GCaanxo5aFGuamIHyBZrmWvSl9M3acER.jpg','tag'),(2,'asdasd','ipf32LHBjS0rkgzes40kecAhdV1WznlhMnjGmLp0.jpg','کفش'),(3,'brand1',NULL,NULL),(4,'brand2',NULL,NULL),(5,'brand3',NULL,NULL),(6,'پورمعمار',NULL,NULL),(7,'آبتین',NULL,NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digest` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int unsigned NOT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `show_in_first_page` tinyint(1) NOT NULL DEFAULT '0',
  `show_items_in_first_page` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  KEY `categories_parent_id_index` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=445 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (368,'دکوراسیون و منزل','FgdO63KGRSHzCTrEvVm51zUA2YWwZSrIOtyEjgD3.png','دکوراسیون و منزل','دکوراسیون و منزل','دکوراسیون و منزل','دکوراسیون و منزل',2,NULL,1,0,0),(369,'انواع فرش','JK4OCbXN1xdMjFnQmqTiVJUhfv1Xm9M13dGmG05F.png','انواع فرش','انواع فرش','انواع فرش','انواع فرش',6,368,1,1,1),(371,'فرش دست‌بافت','TZZ6aY57aydaah8kD5ipX0Xq6jFdbFlzWM1qRGVC.png','فرش دست‌بافت','فرش دست‌بافت','فرش دست‌بافت','فرش دست‌بافت',8,369,1,0,1),(372,'تابلو فرش','ikzuwOlJ8iVLCgQFATU2bThE0cfIKG7w0rw9HMBf.png','تابلو فرش','تابلو فرش','تابلو فرش','تابلو فرش',9,369,1,1,0),(375,'دکوراتیو','7FG46a1YXIbcA5GGmKmZ7NeTcsaZYx83nlbAnXix.png','دکوراتیو','دکوراتیو','دکوراتیو','دکوراتیو',12,368,1,0,0),(376,'مجسمه و تندیس','oqZPuRVvduaAgjz9C9LBllziWfe7gDImpKAQKqRa.png','مجسمه و تندیس','مجسمه و تندیس','مجسمه و تندیس','مجسمه و تندیس',72,375,1,0,0),(377,'شمع','tmhpEUx87QSRnGQjJ1O2Sz6cIBev6svboK2zaBoB.png','لوازم تزئینی','لوازم تزئینی','لوازم تزئینی','لوازم تزئینی',73,375,1,0,0),(378,'آینه','nGtkG0PduHsr8RAxVwNQ6DVFG59huudySP5dKbzR.png','آینه','آینه','آینه','آینه',74,375,1,0,0),(379,'کوسن، رومیزی و شال مبل',NULL,'کوسن، رومیزی و شال مبل','کوسن، رومیزی و شال مبل','کوسن، رومیزی و شال مبل','کوسن، رومیزی و شال مبل',75,375,1,0,0),(380,'قاب عکس و تابلو',NULL,'قاب عکس و تابلو','قاب عکس و تابلو','قاب عکس و تابلو','قاب عکس و تابلو',76,375,1,0,0),(384,'زیبایی و سلامت','TxbWSahabpvzdSsRO7w1O13RUIN25IziGWFvZRd9.png','زیبایی و سلامت','زیبایی و سلامت','زیبایی و سلامت','زیبایی و سلامت',3,NULL,1,0,0),(385,'لوازم بهداشتی',NULL,'لوازم بهداشتی','لوازم بهداشتی','لوازم بهداشتی','لوازم بهداشتی',60,384,1,0,0),(386,'کرم و مراقبت پوست',NULL,'کرم و مراقبت پوست','کرم و مراقبت پوست','کرم و مراقبت پوست','کرم و مراقبت پوست',61,385,1,0,0),(387,'شامپو و مراقبت مو',NULL,'شامپو و مراقبت مو','شامپو و مراقبت مو','شامپو و مراقبت مو','شامپو و مراقبت مو',62,385,1,0,0),(388,'زیورآلات زنانه',NULL,'زیورآلات زنانه','زیورآلات زنانه','زیورآلات زنانه','زیورآلات زنانه',63,384,1,0,0),(389,'زیورآلات طلا زنانه',NULL,'زیورآلات طلا زنانه','زیورآلات طلا زنانه','زیورآلات طلا زنانه','زیورآلات طلا زنانه',64,388,1,0,0),(390,'زیورآلات نقره زنانه',NULL,'زیورآلات نقره زنانه','زیورآلات نقره زنانه','زیورآلات نقره زنانه','زیورآلات نقره زنانه',65,388,1,0,0),(391,'حلقه و انگشتر زنانه',NULL,'حلقه و انگشتر زنانه','حلقه و انگشتر زنانه','حلقه و انگشتر زنانه','حلقه و انگشتر زنانه',66,388,1,0,0),(392,'گوشواره',NULL,'گوشواره','گوشواره','گوشواره','گوشواره',67,388,1,0,1),(393,'زیورآلات مردانه',NULL,'زیورآلات مردانه','زیورآلات مردانه','زیورآلات مردانه','زیورآلات مردانه',68,384,1,0,0),(394,'زیورآلات طلا مردانه',NULL,'زیورآلات طلا مردانه','زیورآلات طلا مردانه','زیورآلات طلا مردانه','زیورآلات طلا مردانه',69,393,1,0,0),(395,'زیورآلات نقره مردانه',NULL,'زیورآلات نقره مردانه','زیورآلات نقره مردانه','زیورآلات نقره مردانه','زیورآلات نقره مردانه',70,393,1,0,0),(396,'حلقه و انگشتر مردانه',NULL,'حلقه و انگشتر مردانه','حلقه و انگشتر مردانه','حلقه و انگشتر مردانه','حلقه و انگشتر مردانه',71,393,1,0,0),(397,'مد و پوشاک','TNuBw2ZD0gb546GiQTIeEeMcx0bTk1zh0EhYYGp3.png','مد و پوشاک','مد و پوشاک','مد و پوشاک','مد و پوشاک',5,NULL,1,1,0),(398,'لباس مردانه',NULL,'لباس مردانه','لباس مردانه','لباس مردانه','لباس مردانه',49,397,1,0,0),(400,'تی‌شرت',NULL,'تی‌شرت','تی‌شرت','تی‌شرت','تی‌شرت',51,398,1,0,0),(402,'شال گردن',NULL,'شال گردن','شال گردن','شال گردن','شال گردن',53,398,1,0,0),(403,'کلاه',NULL,'کلاه','کلاه','کلاه','کلاه',54,398,1,0,0),(404,'لباس زنانه',NULL,'لباس زنانه','لباس زنانه','لباس زنانه','لباس زنانه',55,397,1,0,0),(405,'پیراهن زنانه',NULL,'پیراهن','پیراهن','پیراهن','پیراهن',56,404,1,0,0),(406,'دامن',NULL,'دامن','دامن','دامن','دامن',57,404,1,0,0),(407,'مانتو',NULL,'مانتو','مانتو','مانتو','مانتو',58,404,1,0,0),(408,'شال',NULL,'شال','شال','شال','شال',59,404,1,0,0),(409,'هنر و صنایع دستی','NkelDTQ8ThpGaGmz0gRSK7N5D23e5AKAjcMfcVY7.png','هنر و صنایع دستی','هنر و صنایع دستی','هنر و صنایع دستی','هنر و صنایع دستی',1,NULL,1,1,1),(410,'دست‌بافته‌ها',NULL,'دست‌بافته‌ها','دست‌بافته‌ها','دست‌بافته‌ها','دست‌بافته‌ها',13,409,1,0,0),(411,'کیف دست دوز',NULL,'کیف دست دوز','کیف دست دوز','کیف دست دوز','کیف دست دوز',14,410,1,0,0),(412,'پارچه قلمکار','DS3mihROsGtPlkdyLpkx9O6lqvJKquuIS7rvT0Z0.png','پارچه قلمکار','چاپ قلمکار یکی از پرشمار هنرهای دستی شهر اصفهان است. رواج و رونق صنایع­دستی اصفهان چنان چشم­گیر و پر­رونق است که در سال 1394 شمسی از سوی شورای جهانی صنایع ­دستی به عنوان شهر جهانی صنایع ­دستیِ خلاق برگزیده شده است.','پارچه قلمکار','پارچه قلمکار',15,410,1,1,1),(415,'ترمه','hbE3NJUNhPbslR9bsKzD5kKAjcJaqKxDpvuXa8Qr.png','دستمال و حوله','ترمه بافی یکی از دست بافته های بسیار ظریف و محبوب ایران است که با دستگاه چهاروردی نساجی سنتی بافته می شود.','ترمه','ترمه',18,410,1,1,0),(416,'بافتنی',NULL,'بافتنی','بافتنی','بافتنی','بافتنی',19,410,1,0,0),(417,'سوزن دوزی','lfbDhggtTOAFigjrFgexy9jLvpTV70hvmlwkkOdX.png','سوزن دوزی','سوزن ­دوزی­ های بلوچستان از بهترین نمونه­ های هنر ­دستی در ایران است. به سوزن ­دوزی بلوچ در اصطلاح محلی \"سوچن ­دوزی\" می­ گویند. شواهد موجود حاکی از آن است که این شیوه‌ی دوخت از اوایل اسلام در میان این قوم رایج بوده و دردوره ­های تیموری و صفوی به اوج خود رسیده است. این هنر به­ طور عمده برای تزئین جامه‌ی محلی زنان به­ کار می­ رود.','سوزن دوزی','سوزن دوزی',20,410,1,1,0),(418,'سرمه دوزی',NULL,'سرمه دوزی','سرمه دوزی','سرمه دوزی','سرمه دوزی',22,410,1,0,0),(419,'جاجیم','rc0RoOVXn94EBUemRjUL3U69aZMPde3bV9NtL9db.png','جاجیم','شهرستان خلخال یکی از مراکز مهم صنایع ­دستی استان اردبیل و نیز کشور محسوب می ­شود، مهم ­ترین صنایع این منطقه، جاجیم ­بافی است.','جاجیم','جاجیم',23,410,1,1,0),(420,'کیف چرم',NULL,'کیف چرم','کیف چرم','کیف چرم','کیف چرم',24,410,1,0,0),(422,'محصولات چوبی و حصیری',NULL,'محصولات چوبی و حصیری','محصولات چوبی و حصیری','محصولات چوبی و حصیری','محصولات چوبی و حصیری',26,409,1,0,0),(423,'خاتم کاری','u1QTwYP4VrgOeu8xw0yTa9Beof8xsrGyFPMcQfJj.png','خاتم کاری','خاتم یکی از هنرهای گرانبهای ایران است که به عنوان یکی از صنایع دستی دشوار و پیچیده شناخته می شود و تولید و ساخت آن مستلزم دقت و صبر است. از آنجا که مواد تشکیل دهنده خاتم کاری عمدتاً چوب و چسب است و این مواد با گذر زمان آسیب می بینند','خاتم کاری','خاتم کاری',27,422,1,1,0),(424,'خراطی','99gS5Y92GeiOMRupsT07w4SZ5xBiAS8xsAkbepz9.png','خراطی','در معنای کلام به هر چیز رگه‌‌دار معرق می‌‌گویند ولی مفهوم آن در این نوع به‌‌خصوص هنر، ایجاد نقش‌‌ها و طرح‌‌های زیبایی است که از دوربری و تلفیق چوب‌‌های رنگی روی زمینه‌‌ای از چوب یا پلی‌‌استر شکل‌‌ می‌‌گیرد.','خراطی','خراطی',28,422,1,0,0),(425,'حصیربافی','fpRa25L0OmZVtng8HRFOyr62OZIF0nrSd4P0eaZF.png','حصیربافی','حصیر­بافی آن دسته از صنایع ­دستی است که در مناطق مختلف ایران و جهان به شیوه ­های مختلف و با استفاده از گیاهان گوناگون بافته می ­شود و قدمتی چندین هزار ساله دارد.','حصیربافی','حصیربافی',29,422,1,1,0),(426,'منبت کاری','bTzdF0wTajIwNgUN0b9btezdNsgDlj9LIkHR2txH.png','منبت کاری','صنایع دستی مهم گلپایگان قالی بافی، نمد بافی، گلیم بافی، منبت کاری، خطاطی، نقاشی...است. شعر و موسیقی و ادبیات هم در گلپایگان سابقه چندین ساله دارد. هنرمنبتکاری اززمان‌های گذشته دراین شهراساتیدمعروفی داشته ‌است.','منبت کاری','منبت کاری',30,422,1,1,0),(427,'معرق کاری','91qHECAlAV8PBJxMtQH67ih6CalPAhz1PcrHeMFl.png','معرق کاری','در معنای کلام به هر چیز رگه‌‌دار معرق می‌‌گویند ولی مفهوم آن در این نوع به‌‌خصوص هنر، ایجاد نقش‌‌ها و طرح‌‌های زیبایی است که از دوربری و تلفیق چوب‌‌های رنگی روی زمینه‌‌ای از چوب یا پلی‌‌استر شکل‌‌ می‌‌گیرد.','معرق کاری','معرق کاری',31,422,1,1,0),(428,'نقاشی و دست‌نوشته',NULL,'نقاشی و دست‌نوشته','نقاشی و دست‌نوشته','نقاشی و دست‌نوشته','نقاشی و دست‌نوشته',32,409,1,0,0),(429,'چاپ سنتی',NULL,'چاپ سنتی','چاپ سنتی','چاپ سنتی','چاپ سنتی',33,409,1,0,0),(430,'محصولات سنگی، چینی و سرامیکی',NULL,'محصولات سنگی، چینی و سرامیکی','محصولات سنگی، چینی و سرامیکی','محصولات سنگی، چینی و سرامیکی','محصولات سنگی، چینی و سرامیکی',34,409,1,0,0),(431,'جعبه',NULL,'جعبه','جعبه','جعبه','جعبه',35,430,1,0,0),(432,'سفال، سرامیک و چینی',NULL,'سفال، سرامیک و چینی','سفال، سرامیک و چینی','سفال، سرامیک و چینی','سفال، سرامیک و چینی',36,430,1,0,0),(433,'گلدان',NULL,'گلدان','گلدان','گلدان','گلدان',37,430,1,0,0),(434,'کاشی کاری',NULL,'کاشی کاری','کاشی کاری','کاشی کاری','کاشی کاری',38,430,1,0,0),(435,'محصولات فلزی',NULL,'محصولات فلزی','محصولات فلزی','محصولات فلزی','محصولات فلزی',39,409,1,0,0),(436,'قلمزنی','L0WmON5xNlKwLDp04eRWciKJIVodYQQBb1ZNTUp8.png','قلمزنی','قلم زنی یکی از رشته های زیبای صنایع دستی ایران است که بر روی فلزات مختلف کار می شود تاریخ دقیقی از زمان شکل گیری این هنر در دست نیست؛','قلمزنی','قلمزنی',40,435,1,1,0),(437,'ملیله کاری',NULL,'ملیله کاری','ملیله کاری','ملیله کاری','ملیله کاری',41,435,1,0,0),(438,'فیروزه کوبی',NULL,'فیروزه کوبی','فیروزه کوبی','فیروزه کوبی','فیروزه کوبی',42,435,1,0,0),(439,'محصولات مسی','NvJyr2q8jnXmeFvJjSLcN84dt3mMSrbFmzwUhZua.png','محصولات مسی','محصولات مسی','محصولات مسی','محصولات مسی',43,409,1,1,0),(440,'محصولات برنجی و برنزی',NULL,'محصولات برنجی و برنزی','محصولات برنجی و برنزی','محصولات برنجی و برنزی','محصولات برنجی و برنزی',44,409,1,0,0),(441,'محصولات نقره','ppNeFOqkDpT6bPwsZNGN3jJ1KroTb1cLPSRo0tzl.png','محصولات نقره','محصولات نقره','محصولات نقره','محصولات نقره',45,409,1,1,0),(442,'میناکاری',NULL,'میناکاری','میناکاری','میناکاری','میناکاری',47,435,1,0,0),(443,'صنایع دستی فاخر','M5Vfy0FsgfeTNZxLa0TQTGWG17SSnh3lv7QLKgKp.png','صنایع دستی فاخر','صنایع دستی فاخر','صنایع دستی فاخر','صنایع دستی فاخر',4,NULL,1,1,1),(444,'هنرمندان نام آور','KsTLYi8QCiXQHBDN88mSNNVYgYV8g5wkMFNAauX9.png','هنرمندان نام آور','هنرمندان نام آور','هنرمندان نام آور','هنرمندان نام آور',48,443,1,1,1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_features`
--

DROP TABLE IF EXISTS `category_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_features` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_in_top` tinyint(1) NOT NULL DEFAULT '0',
  `effect_on_price` tinyint(1) NOT NULL DEFAULT '0',
  `effect_on_available_count` tinyint(1) NOT NULL DEFAULT '0',
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int unsigned NOT NULL,
  `answer_type` enum('number','text','longtext','multi_choice') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `category_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_features_category_id_index` (`category_id`),
  CONSTRAINT `category_features_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_features`
--

LOCK TABLES `category_features` WRITE;
/*!40000 ALTER TABLE `category_features` DISABLE KEYS */;
INSERT INTO `category_features` VALUES (3,'شکل',1,0,0,NULL,NULL,1,'text',371),(4,'محل بافت',1,0,0,NULL,NULL,2,'text',371),(5,'نام طرح',0,0,0,NULL,NULL,4,'text',371),(6,'تراکم',1,0,0,'رج',NULL,3,'number',371),(7,'جنس پرز',1,0,0,NULL,NULL,6,'text',371),(8,'جنس نخ تار',0,0,0,NULL,NULL,7,'text',371),(9,'رنگ زمینه',0,0,0,NULL,NULL,8,'text',371),(10,'نحوه رنگرزی',1,0,0,NULL,NULL,10,'text',371),(11,'ابعاد',1,0,0,'سانتی متر',NULL,1,'text',371),(12,'سایز',0,0,0,'مترمربع',NULL,10,'number',371),(13,'وزن تقریبی',0,0,0,'کیلوگرم',NULL,11,'number',371),(14,'محل بافت',1,0,0,NULL,NULL,1,'text',372),(15,'نوع بافت',1,0,0,NULL,NULL,2,'text',372),(16,'تراکم در هفت سانتی متر',1,0,0,'رج',NULL,3,'number',372),(17,'جنس پرز',1,0,0,NULL,NULL,6,'text',372),(18,'جنس قاب',1,0,0,NULL,NULL,7,'text',372),(19,'جنس نخ تار',0,0,0,NULL,NULL,12,'text',372),(20,'جنس نخ پود',0,0,0,NULL,NULL,13,'text',372),(21,'ابعاد تابلو',1,0,0,'سانتی متر',NULL,8,'text',372),(22,'وزن تقریبی',0,0,0,'کیلوگرم',NULL,5,'number',372),(23,'ویژگی تابلو',0,0,0,NULL,NULL,15,'text',372),(24,'کاربرد',1,0,0,NULL,NULL,1,'text',378),(25,'شکل',1,0,0,NULL,NULL,2,'text',378),(26,'حنس',1,0,0,NULL,NULL,3,'text',378),(27,'تعداد تکه',0,0,0,'تکه',NULL,6,'number',378),(28,'ابعاد',1,0,0,'سانتی متر',NULL,4,'text',378),(29,'وزن',0,0,0,'کیلوگرم',NULL,6,'number',378),(30,'نحوه نصب',0,0,0,NULL,NULL,8,'longtext',378),(31,'نوع اندود آینه',0,0,0,NULL,NULL,7,'text',378),(32,'نوع ابزار لبه آینه',0,0,0,NULL,NULL,6,'text',378),(33,'جنس',1,0,0,NULL,NULL,1,'text',377),(34,'شکل ظاهری',1,0,0,NULL,NULL,2,'text',377),(35,'مناسب برای',1,0,0,NULL,NULL,3,'text',377),(36,'ویژگی',1,0,0,NULL,NULL,4,'text',377),(37,'ابعاد',0,0,0,'سانتی متر',NULL,4,'text',377),(38,'وزن',0,0,0,'کیلوگرم',NULL,6,'text',377),(39,'رایحه',1,0,0,NULL,NULL,4,'text',377),(40,'مواد اولیه',1,0,0,NULL,NULL,1,'text',376),(41,'ابعاد',1,0,0,'سانتی متر',NULL,2,'text',376),(42,'وزن',1,0,0,'کیلوگرم',NULL,3,'number',376),(43,'ابعاد بسته بندی',0,0,0,'سانتی متر',NULL,6,'text',376),(44,'وزن با بسته بندی',0,0,0,'کیلوگرم',NULL,7,'text',376),(45,'اندازه',1,1,0,'سانتی متر','Med$$11__Small$$22__Large$$33',1,'multi_choice',412),(46,'درجه کیفی',1,0,0,NULL,NULL,2,'text',412),(47,'شکل',1,0,0,NULL,NULL,3,'text',412),(48,'مناسب برای',1,0,0,NULL,NULL,4,'text',412),(49,'محل تولید',0,0,0,NULL,NULL,6,'text',412),(50,'سازنده',0,0,0,NULL,NULL,7,'text',412),(52,'استان تولید',1,0,0,NULL,NULL,2,'text',408),(53,'ابعاد',1,0,0,'سانتی متر',NULL,3,'text',408),(54,'جنس',1,0,0,NULL,NULL,4,'text',408),(55,'multicolor',1,1,0,NULL,'قرمز$$rgb(244, 67, 54)__آبی$$rgb(33, 150, 243)__زرد$$rgb(255, 235, 59)__سبز$$rgb(0, 230, 118)__بنفش$$rgb(156, 39, 177)__سبز تیره$$rgb(0, 126, 51)__نارنجی کمرنگ$$rgb(255, 175, 71)__لاجوردی$$rgb(0, 225, 255)',1,'multi_choice',408),(56,'سایز',1,0,1,'سانتی متر','90*70$$90*70__70*50$$70*50__50*20$$50*20',2,'multi_choice',372),(57,'multicolor',1,0,1,NULL,'آبی$$rgb(0,0,255)__قرمز$$rgb(255,0,0)__سبز$$rgb(0,255,0)',1,'multi_choice',371);
/*!40000 ALTER TABLE `category_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `msg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rate` tinyint DEFAULT NULL,
  `is_bookmark` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `positive` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `negative` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comments_product_id_user_id_unique` (`product_id`,`user_id`),
  KEY `comments_product_id_index` (`product_id`),
  KEY `comments_user_id_index` (`user_id`),
  CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,18,3,'عالی','2022-10-27 06:39:52','2022-10-27 06:42:45',3,NULL,1,'زیبا$$$___$$$اصل','گران','2022-10-27 06:42:45'),(2,20,3,NULL,'2022-10-27 06:41:11','2022-11-12 10:24:39',NULL,1,0,NULL,NULL,NULL),(3,13,115,NULL,'2022-11-03 10:19:58','2022-11-03 10:19:58',NULL,1,0,NULL,NULL,NULL),(6,21,3,NULL,'2022-11-12 10:24:42','2022-11-12 10:24:42',NULL,1,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `can_pay_cash` tinyint(1) NOT NULL DEFAULT '0',
  `desc_default` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sell_list_period` tinyint NOT NULL DEFAULT '7',
  `seen_list_period` tinyint NOT NULL DEFAULT '7',
  `home_banner_limit` tinyint NOT NULL DEFAULT '2',
  `detail_banner_limit` tinyint NOT NULL DEFAULT '1',
  `list_banner_limit` tinyint NOT NULL DEFAULT '1',
  `critical_point` tinyint NOT NULL DEFAULT '5',
  `site` enum('event','shop') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,0,'<figure class=\"image ck-widget image-style-align-left\" contenteditable=\"false\"><img src=\"data:image/jpeg;base64,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\" class=\"mCS_img_loaded\"><figcaption class=\"ck-editor__editable ck-editor__nested-editable\" data-placeholder=\"Enter image caption\" contenteditable=\"true\">نتنت</figcaption></figure><p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>',7,7,2,1,1,5,'shop'),(2,0,NULL,7,7,2,1,1,5,'event');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `priority` int unsigned NOT NULL,
  `site` enum('event','shop') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (1,'چگونه مطمئن باشم کالایی که میخرم اصل و با کیفیت است؟','<p>ویزیت ایران پس از بررسی کیفیت فروشندگان صنایع دستی اقدام به همکاری با آن‌ها می نماید. تمامی فروشندگام موجود در وب سایت دارای تاییدیه های کافی و لازم از مراجمع ذی صلاح هستند و نام و مشخصات آن ها برای پیگیری های آتی کاملا مورد تایید است. همچنین سابقه فعالیت و تعداد شکایات موجود در طول فعالیت نیز از دیگر عواملی است که در انتخاب ارایه دهندگان و کنترل قیمت آن ها نقشی تعیین کننده دارد.&nbsp;</p>',1,1,'shop'),(2,'چگونه می توانم اقدام به پرداخت هزینه نمایم؟','<p>تنها روشی که برای پرداخت هزینه در سایت موجود است، پرداخت هزینه به صورت آنلاین پس از سفارش است. در حال حاضر در تلاش برای ارایه خدمات مالی منعطف تری بر روی ساماه هستیم که پس از تکمیل به وب سایت اضافه شده و اطلاع رسانی می شود.&nbsp;</p>',1,2,'shop'),(3,'مدت زمان و هزینه ارسال چگونه محاسبه می شود؟','<p>ارسال کالا همگی با هماهنگی پست و بسته به موقعیت جغرافیایی خریدار مابین 2 تا 5 روز کاری طول خواهد کشید. هزینه ارسال به صورت خودکار در هنگام ورود آدرس محاسبه شده و به اطلاع شما خواهد رسید. همچنین تمامی مرسولات دارای بیمه تا سقف قیمت خرید محصول هستند.&nbsp;</p>',1,3,'shop'),(4,'آیا امکان مرجوع نمودن کالا وجود دارد؟','<p>در صورتی که کالای ارسالی با مشخصات اعلام شده در هنگام خرید مغایرت داشت و یا در هنگام ارسال و قبل از تحویل دچار آسیب شده بود شما می تواید از طریق تیکت درخواست خود را با مطرح نمایید تا در اسرع وقت فرآیند مربوطه را پیگیری کنیم. در این خصوص حتما صفحه اطلاعات لازم در خصوص <a href=\"https://www.visitiran.ir/\">مرجوع نمودن کالا </a>را مشاده کنید.</p>',1,4,'shop'),(5,'آیا ساخت رویداد هزینه‌ای دارد؟','<p style=\"text-align:justify;\">&nbsp;ایجاد رویداد رایگان است و انشار آن نیز کاملا رایگان است.برای رویدادهایی که از سیستم وبینار استفاده میکنند با توجه به ظرفیت و ساعت انتخابی شما هزینه محاسبه میشود و برای رویدادهایی که از سیستم وبینار شخصی استفاده میکنند هیچ هزینه ای دریافت نمی گردد.&nbsp;</p><p style=\"text-align:justify;\">اگر ثبت‌نام در رویداد شما رایگان باشد، کارمزدی هم از شما دریافت نمی‌شود. کارمزد ایوند برای همه رویدادهای پولی ۴ درصد از قیمت بلیت و ۱۲۵۰ تومان به ازای هر بلیت است. برگزارکننده این امکان را دارد که شیوه پرداخت کارمزد را تغییر دهد؛ به صورت پیش فرض کارمزد توسط شرکت کنندگان پرداخت میشود.</p>',1,1,'event'),(6,'نحوه‌ی تسویه حساب با برگزارکنندگان به چه شکل است؟','<p style=\"text-align:justify;\">برگزارکننده باید پس از ایجاد رویداد، در قسمت «حسابداری» اطلاعات بانکی خود را به&nbsp;صورت&nbsp;کامل وارد نماید. بعد از انجام این کار -هر زمان که تمایل داشته باشید- می‌توانید روی دکمه‌ی تسویه حساب کلیک کنید تا مبالغ فروش ظرف ۲۴ ساعت کاری به حساب‌تان واریز شود. فاکتور تسویه حساب 1 ساعت پس از اتمام رویداد صادر میشود.</p>',1,2,'event'),(7,'آیا امکان خرید بلیت بدون عضویت وجود دارد؟','<p style=\"text-align:justify;\">برای اطلاع از رویداد ها نیازی به عضویت نیست اما در صورت ثبت نام در وریدادهایی که نیازمند تهیه بلیت هستند ما به اطلاعات پایه شما برای صدور بلیت نیاز داریم.</p>',1,3,'event'),(8,'چطور می‌توانم از برگزاری رویداد های دلخواهم آگاه شوم؟','<p style=\"text-align:justify;\">با دنبال کردن برگزارکنندگان رویدادهای دلخواه‌تان، در آینده از طریق ایمیل از سایر رویدادهای آن‌ها با خبر خواهید شد.\r\n</p>',1,4,'event');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int unsigned NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('student','teacher','advisor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forms_city_id_index` (`city_id`),
  CONSTRAINT `forms_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `events`.`cities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info_box`
--

DROP TABLE IF EXISTS `info_box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_box` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `img_large` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_mid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_small` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `href` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collapse_from` enum('right','left','center') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'right',
  `site` enum('event','shop') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `info_box`
--

LOCK TABLES `info_box` WRITE;
/*!40000 ALTER TABLE `info_box` DISABLE KEYS */;
INSERT INTO `info_box` VALUES (2,'h4vbCrHqYfKmub37riEMSqBqq8Il9tjt4JS4xBQA.png','RDVwfYHtXXl4ftfYak4aUp6eSqMosMDC9Y7sCVGp.png','WlxichgMfkqoSHQs8Q7tN8DtOzR7CJ7RUR9q1Iel.png','https://www.visitiran.ir/','روزمادر','right','shop'),(3,'38fJQ4pim9ALJhl3jul7Q9jZ29gHITS1tTB1uO2C.jpg',NULL,NULL,'https://google.com',NULL,'right','event');
/*!40000 ALTER TABLE `info_box` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'send_event_registry_notification','{\"uuid\":\"846b664f-0d78-4192-9997-9224fc362872\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":4:{s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674646984,1674646924),(2,'send_event_registry_notification','{\"uuid\":\"147a8f48-4fca-4e7b-80ba-bf849b89e1ff\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":4:{s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674647128,1674647068),(3,'send_event_registry_notification','{\"uuid\":\"06c8ec4d-859e-4438-a116-4ffc4ef11b38\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":4:{s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674647179,1674647119),(4,'send_event_registry_notification','{\"uuid\":\"ffafea14-9baf-4abd-b336-4fa90d199f56\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":4:{s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674647229,1674647169),(5,'default','{\"uuid\":\"a0bb64ff-c39c-44ff-8792-f504be49f404\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":4:{s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674648521,1674648521),(6,'default','{\"uuid\":\"993d686f-da5b-4780-94fd-eccd26febdd9\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":5:{s:4:\\\"name\\\";s:17:\\\"محمد قانع\\\";s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674649225,1674649225),(7,'default','{\"uuid\":\"5336b3db-5aba-4dd6-a044-561c5fc42a26\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":5:{s:4:\\\"name\\\";s:17:\\\"محمد قانع\\\";s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674649266,1674649266),(8,'send_event_registry_notification','{\"uuid\":\"cef84b76-2e01-4b51-876d-d2839004a567\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":5:{s:4:\\\"name\\\";s:17:\\\"محمد قانع\\\";s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674649441,1674649381),(9,'default','{\"uuid\":\"381b5b94-ce6f-41b6-a7b9-d492a00d90a4\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":5:{s:4:\\\"name\\\";s:17:\\\"محمد قانع\\\";s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674649660,1674649660),(10,'default','{\"uuid\":\"f61b8f2d-3faf-40e5-b5cf-05347c2f455d\",\"displayName\":\"App\\\\Listeners\\\\SendEventRegistryNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:43:\\\"App\\\\Listeners\\\\SendEventRegistryNotification\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:24:\\\"App\\\\Events\\\\EventRegistry\\\":5:{s:4:\\\"name\\\";s:17:\\\"محمد قانع\\\";s:5:\\\"phone\\\";s:11:\\\"09214915905\\\";s:4:\\\"mail\\\";s:21:\\\"mghaneh1375@yahoo.com\\\";s:5:\\\"event\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Event\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:6:\\\"mysql2\\\";}s:6:\\\"socket\\\";N;}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1674649703,1674649703);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_users`
--

DROP TABLE IF EXISTS `mail_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mail_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail_users_mail_unique` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_users`
--

LOCK TABLES `mail_users` WRITE;
/*!40000 ALTER TABLE `mail_users` DISABLE KEYS */;
INSERT INTO `mail_users` VALUES (1,'sina.adeli.k@gmail.com','2022-10-27 06:33:20','2022-10-27 06:33:20');
/*!40000 ALTER TABLE `mail_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mails`
--

DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mails` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_id` int unsigned NOT NULL,
  `status` enum('pending','fail','success') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mails_news_id_index` (`news_id`),
  CONSTRAINT `mails_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mails`
--

LOCK TABLES `mails` WRITE;
/*!40000 ALTER TABLE `mails` DISABLE KEYS */;
/*!40000 ALTER TABLE `mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2016_06_01_000001_create_oauth_auth_codes_table',1),(2,'2016_06_01_000002_create_oauth_access_tokens_table',1),(3,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(4,'2016_06_01_000004_create_oauth_clients_table',1),(5,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(6,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2022_09_08_064622_category',1),(8,'2022_09_08_064753_brand',1),(9,'2022_09_08_064832_product',1),(10,'2022_09_08_065237_category_features',1),(11,'2022_09_08_071213_create_users_table',1),(12,'2022_09_08_075041_create_off_table',1),(13,'2022_09_08_080333_create_purchase_table',1),(14,'2022_09_08_080601_create_purchase_items_table',1),(15,'2022_09_08_081719_create_product_galleries_table',1),(16,'2022_09_08_082540_create_activation_table',1),(17,'2022_09_08_083019_create_product_features_table',1),(18,'2022_09_11_083402_create_comment_table',1),(19,'2022_09_11_083450_create_bookmark_table',1),(20,'2022_09_11_083627_create_address_table',1),(21,'2022_09_11_084857_create_config_table',1),(22,'2022_09_11_084912_create_slider_table',1),(23,'2022_09_16_102513_create_table_info_box',1),(24,'2022_09_16_103227_create_table_faq',1),(25,'2022_09_16_103326_create_table_news',1),(26,'2022_09_16_103358_create_table_mails',1),(27,'2022_09_16_103436_create_table_blogs',1),(28,'2022_09_16_103526_create_table_product_rates',1),(29,'2022_09_16_103544_create_table_banner',1),(30,'2022_10_03_163144_change_digest_in_category_table',2),(31,'2022_10_04_082902_change_digest_in_product_table',2),(32,'2022_10_04_083041_change_digest_in_blogs_table',2),(33,'2022_10_04_083140_create_seller_table',2),(34,'2022_10_04_083243_change_seller_in_products_table',2),(35,'2022_10_04_113735_change_user_accesses',2),(36,'2022_10_04_114414_change_user_accesses_in_users_table',2),(37,'2022_10_05_100138_make_img_nullable_in_product_table',2),(38,'2022_10_05_184628_add_header_to_blogs_table',2),(39,'2022_10_05_185809_make_img_nullable_in_blogs_table',2),(40,'2022_10_06_105533_change_off_expiration_in_products_table',2),(41,'2022_10_06_184513_create_mail_users_table',2),(42,'2022_10_07_123427_add_seller_and_brand_to_offs_table',2),(43,'2022_10_08_154001_create_jobs_table',2),(44,'2022_10_08_170914_change_expiration_in_off_table',2),(45,'2022_10_10_181436_create_product_seen_table',3),(46,'2022_10_12_074652_add_rate_to_comment_table',4),(47,'2022_10_12_075118_remove_bookmarks_table',4),(48,'2022_10_12_134621_change_price_and_count_in_product_features_table',4),(49,'2022_10_13_060432_add_guarantee_to_products_table',4),(50,'2022_10_13_064453_change_comment_dependency_to_cascade_in_comments_table',4),(51,'2022_10_13_064523_change_gallery_dependency_to_cascade_in_product_galleries_table',4),(52,'2022_10_13_064543_change_feature_dependency_to_cascade_in_product_features_table',4),(53,'2022_10_13_065608_change_description_to_nullable_in_products_table',4),(54,'2022_10_14_120221_change_price_and_count_to_string_in_product_features_table',4),(55,'2022_10_14_161940_add_rate_count_to_products_table',4),(56,'2022_10_14_163131_add_status_to_comments_table',4),(57,'2022_10_14_163217_add_new_comment_count_to_products_table',4),(58,'2022_10_15_053659_add_slug_to_products_table',5),(59,'2022_10_15_053706_add_slug_to_blogs_table',5),(60,'2022_10_15_100154_add_sell_count_to_products_table',6),(61,'2022_10_15_102443_create_similars_table',6),(62,'2022_10_15_102822_add_timestamp_to_products_table',6),(63,'2022_10_15_121619_change_gaurantee_in_products_table',7),(73,'2022_10_17_105921_add_negative_and_positive_point_in_comments_table',8),(74,'2022_10_17_125542_add_confirmed_at_in_comments_table',8),(75,'2022_10_18_055625_make_rate_double_in_products_table',8),(76,'2022_10_18_122026_remove_title_in_comments_table',8),(77,'2022_10_18_124200_add_thumbnail_in_products_table',8),(78,'2022_10_18_124206_add_thumbnail_in_gallery_table',8),(79,'2022_10_19_143949_add_access_in_users_table',8),(80,'2022_10_19_152757_add_site_in_sliders_table',8),(81,'2022_10_19_152931_add_site_in_banners_table',8),(82,'2022_10_19_154643_create_states_table',8),(83,'2022_10_19_155301_create_event_facilities_table',8),(84,'2022_10_19_155357_create_event_tags_table',8),(85,'2022_10_19_155512_create_cities_table',8),(86,'2022_10_19_155702_create_launcher_table',8),(87,'2022_10_19_155856_create_events_table',8),(88,'2022_10_19_160157_add_launcher_access_to_users_table',8),(89,'2022_10_19_161844_create_launcher_certifications_table',8),(90,'2022_10_19_161909_create_launcher_bank_accounts_table',8),(91,'2022_10_19_161931_create_event_sessions_table',8),(92,'2022_10_19_165856_create_event_galleries_table',8),(93,'2022_10_19_173541_create_event_comments_table',8),(94,'2022_10_19_173558_create_launcher_comments_table',8),(95,'2022_10_19_184103_change_user_accesses2_in_users_table',8),(96,'2022_10_19_185307_add_site_in_faq_table',8),(97,'2022_10_23_175208_add_site_in_info_box_table',9),(98,'2022_10_23_182055_create_followers_table',10),(99,'2022_10_23_182303_add_follower_count_in_launchers_table',10),(100,'2022_10_24_102253_add_vc_expired_at_in_activations_table',10),(101,'2022_10_24_102317_set_name_nullable_in_users_table',10),(102,'2022_10_26_112848_add_additional_fields_in_address_table',10),(103,'2022_10_29_105247_add_additional_fields_in_users_table',10),(116,'2022_11_05_100603_add_default_in_address_table',11),(117,'2022_11_05_105522_add_delivery_at_in_purchase_table',11),(118,'2022_11_07_074454_make_user_id_unique_in_launchers_table',11),(119,'2022_11_07_090038_make_shaba_24_digit_in_launcher_bank_accounts_table',11),(120,'2022_11_09_080728_change_status_in_launcher_bank_accounts',11),(121,'2022_11_09_102854_add_default_in_launcher_bank_accounts_table',11),(122,'2022_11_10_112642_add_name_and_phone_to_launchers_table',11),(123,'2022_11_21_070155_create_forms_table',12),(124,'2022_11_23_083726_change_status_phase_in_launchers_table',13),(125,'2022_11_23_083838_change_status_phase_2_in_launchers_table',13),(126,'2022_11_23_083940_change_status_in_events_table',13),(127,'2022_11_23_090404_add_visibility_in_event_facilities_table',14),(128,'2022_11_26_063710_add_visibility_in_event_tags_table',15),(130,'2022_11_26_073028_make_nullable_fields_in_events_table',16),(131,'2022_11_26_145810_change_start_and_date_in_event_sessions_table',17),(132,'2022_11_28_115023_add_site_in_config_table',18),(133,'2022_11_28_191854_create_tickets_table',18),(134,'2022_11_28_192324_create_msgs_table',18),(135,'2022_11_30_094250_add_postal_code_in_events_table',19),(136,'2022_12_08_140922_create_event_buyers_table',19),(137,'2022_12_09_151241_add_user_id_in_launcher_comments_table',19),(138,'2022_12_09_190811_add_user_id_in_event_comments_table',19),(139,'2022_12_10_112642_add_name_and_phone_to_launchers_table',20),(140,'2022_12_24_123949_add_back_img_in_launchers_table',21),(142,'2023_01_02_114418_add_site_in_blogs_table',22),(143,'2023_01_09_185635_create_sessions_table',23),(144,'2023_01_15_112013_add_init_status_in_events_table',23),(145,'2023_01_15_112256_add_init_status_in_launchers_table',23),(146,'2023_01_15_155945_add_unique_in_followers_table',23),(147,'2023_01_20_103506_add_info_fields_in_event_buyers_table',24),(148,'2023_01_21_125014_add_site_in_off_table',25),(187,'2023_01_23_105444_drop_unique_user_in_event_buyers_table',27),(188,'2023_01_26_105458_create_money_requests_table',27),(195,'2023_01_28_085114_change_purchase_table',28),(196,'2023_01_21_135608_create_transactions_table',29),(197,'2023_01_28_132145_change_in_purchase_items_table',30),(198,'2023_01_29_065805_drop_unique_in_address_table',31),(199,'2023_01_29_065934_drop_unique_in_purchase_items_table',32),(202,'2023_01_29_074518_add_address_to_purchase_table',33);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msgs`
--

DROP TABLE IF EXISTS `msgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `msgs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `ticket_id` int unsigned NOT NULL,
  `msg` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach_5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `msgs_user_id_index` (`user_id`),
  KEY `msgs_ticket_id_index` (`ticket_id`),
  CONSTRAINT `msgs_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  CONSTRAINT `msgs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msgs`
--

LOCK TABLES `msgs` WRITE;
/*!40000 ALTER TABLE `msgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `msgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `msg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offs`
--

DROP TABLE IF EXISTS `offs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `amount` int unsigned NOT NULL,
  `off_type` enum('value','percent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `off_expiration` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `brand_id` int unsigned DEFAULT NULL,
  `seller_id` int unsigned DEFAULT NULL,
  `site` enum('shop','event') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`),
  KEY `offs_user_id_index` (`user_id`),
  KEY `offs_category_id_index` (`category_id`),
  KEY `offs_brand_id_index` (`brand_id`),
  KEY `offs_seller_id_index` (`seller_id`),
  CONSTRAINT `offs_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `offs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `offs_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  CONSTRAINT `offs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offs`
--

LOCK TABLES `offs` WRITE;
/*!40000 ALTER TABLE `offs` DISABLE KEYS */;
INSERT INTO `offs` VALUES (3,'SSS',3,NULL,5000000,'value','14011127','2023-01-29 06:53:50','2023-01-29 06:53:50',NULL,NULL,'shop'),(4,'WWW',3,NULL,700000000,'value','14011127','2023-01-29 13:08:05','2023-01-29 13:08:05',NULL,NULL,'shop');
/*!40000 ALTER TABLE `offs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_features`
--

DROP TABLE IF EXISTS `product_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_features` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `category_feature_id` int unsigned NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_count` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_features_product_id_category_feature_id_unique` (`product_id`,`category_feature_id`),
  KEY `product_features_product_id_index` (`product_id`),
  KEY `product_features_category_feature_id_index` (`category_feature_id`),
  CONSTRAINT `product_features_category_feature_id_foreign` FOREIGN KEY (`category_feature_id`) REFERENCES `category_features` (`id`),
  CONSTRAINT `product_features_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_features`
--

LOCK TABLES `product_features` WRITE;
/*!40000 ALTER TABLE `product_features` DISABLE KEYS */;
INSERT INTO `product_features` VALUES (3,11,3,'مستطیل',NULL,NULL),(4,11,4,'فارس',NULL,NULL),(5,11,5,'قشقایی',NULL,NULL),(6,11,6,'40',NULL,NULL),(7,11,7,'ابریشم',NULL,NULL),(8,11,13,'19',NULL,NULL),(9,11,12,'6.1',NULL,NULL),(10,11,11,'۳۰۵x۲۰۰x۲',NULL,NULL),(11,11,10,'سنتی با استفاده از رنگ‌های طبیعی',NULL,NULL),(12,11,9,'کرم',NULL,NULL),(13,11,8,'ابریشم',NULL,NULL),(14,17,45,'Med$$Large__11$$33','300,000$$500,000',NULL),(15,17,46,'ممتاز',NULL,NULL),(16,17,47,'مریع',NULL,NULL),(17,17,48,'میزه های دو نفره',NULL,NULL),(18,17,49,'اصفهان',NULL,NULL),(19,17,50,'استاد علیزاده',NULL,NULL),(20,22,3,'مستطیل',NULL,NULL),(21,22,4,'تهران',NULL,NULL),(22,22,6,'600',NULL,NULL),(23,22,5,'تهرانی',NULL,NULL),(24,22,7,'پلی استر',NULL,NULL),(25,22,8,'پلی استر',NULL,NULL),(26,22,9,'سفید',NULL,NULL),(27,22,10,'ماشینی',NULL,NULL),(28,22,11,'3*3',NULL,NULL),(29,22,12,'6',NULL,NULL),(30,22,13,'2',NULL,NULL),(31,24,52,'همدان',NULL,NULL),(32,24,53,'130*130',NULL,NULL),(33,24,54,'نخ',NULL,NULL),(34,24,55,'قرمز$$آبی$$زرد$$سبز$$بنفش$$سبز تیره$$نارنجی کمرنگ$$لاجوردی__rgb(244, 67, 54)$$rgb(33, 150, 243)$$rgb(255, 235, 59)$$rgb(0, 230, 118)$$rgb(156, 39, 177)$$rgb(0, 126, 51)$$rgb(255, 175, 71)$$rgb(0, 225, 255)','143,000$$133,000$$145,000$$146,000$$147,000$$148,000$$135,000$$150,000',NULL),(35,25,14,'تبریز',NULL,NULL),(36,25,15,'دستبافت',NULL,NULL),(37,25,18,'PVC',NULL,NULL),(38,25,19,'ابریشم',NULL,NULL),(39,25,20,'کرک',NULL,NULL),(40,25,22,'15',NULL,NULL),(41,25,23,'قاب',NULL,NULL),(42,25,56,'90*70$$70*50$$50*20__90*70$$70*50$$50*20',NULL,'7$$2$$1'),(43,23,57,'آبی$$قرمز$$سبز__rgb(0,0,255)$$rgb(255,0,0)$$rgb(0,255,0)',NULL,'10$$4$$3');
/*!40000 ALTER TABLE `product_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_galleries`
--

DROP TABLE IF EXISTS `product_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_galleries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `priority` int unsigned NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_galleries_product_id_index` (`product_id`),
  CONSTRAINT `product_galleries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_galleries`
--

LOCK TABLES `product_galleries` WRITE;
/*!40000 ALTER TABLE `product_galleries` DISABLE KEYS */;
INSERT INTO `product_galleries` VALUES (2,11,1,1,'/gOzw6mvqqcvnVKYnJpMpPnGClz3tDsGQbVqj8reU.jpg',NULL,NULL),(3,11,2,1,'/wBaybWeNHcbcmJNaYIypVpwoyf5L3nCG6i7g85HL.jpg',NULL,NULL),(4,11,3,1,'/IHcefJgIZ71AlHnXS66VgM9iutLnap7vG3br63Fy.jpg',NULL,NULL),(5,11,4,1,'/7UQXu3aq0TmxgQ49thf0AigfP2Fat0GLXMyX3GIn.jpg',NULL,NULL),(6,11,5,1,'/39hOtzcEhJwnZVrwcGAzelAcI9N9whbqlqcrkoaT.jpg',NULL,NULL),(7,12,1,1,'/gngPQKCKSZHCY6tRMxPSAuhyylWtGZrn6Qivg1rA.jpg',NULL,NULL),(8,12,2,1,'/2iaqgg8gfqKb7pLnlw3v6MwNxra7Rg9CSktBW1Lq.jpg',NULL,NULL),(10,12,3,1,'/kG2JUGNTvno0DOhYMGnuflst64QCqEHY7jnm0zfn.jpg',NULL,NULL),(11,12,3,1,'/NKWKIwXtDrnELFhHbBCKu9xXKmIOrpiG0rWKvlNQ.jpg',NULL,NULL),(12,13,1,1,'/W3djaZLj0xmuB64AZ2pgXvmwajgZ7fKHe89pEU9r.jpg',NULL,NULL),(13,13,2,1,'/QOnvA0SG4ffNUv4RAZf49RCe6natDWCt2cXHKQ8e.jpg',NULL,NULL),(14,13,3,1,'/PbeRNlMnioQs0cXPyy8XelgOT3QJVP4QtDzLcUIo.jpg',NULL,NULL),(15,18,1,1,'/tWZyI3ZZmoGZGG11PIuwHDB9QPodLCAupx9xcbaU.jpg',NULL,NULL),(16,18,2,1,'/DScngLSaJrtbD4mjPH3WnfaDHIH15JUcNK9CUjVy.jpg',NULL,NULL),(17,22,1,1,'oHBLi21unStOjvrNsxCDJpaNOGA0xHi7XwN8hTgW.jpg',NULL,NULL),(18,22,2,1,'Pg79QS4qufQfbgK9MJ7yMTeJW7WklCrJIZixh5aZ.png',NULL,NULL),(19,24,1,1,'UpJ5bH7tNxFv1BcFhX4N3q19U1dhkRcRSheWqPv0.jpg',NULL,NULL),(20,24,2,1,'t6dzICp8jmDSE9xEtDRGBXoxSdBw1ajMThEGdQUW.jpg',NULL,NULL),(21,24,3,1,'hC6zd0B0y58XMCVIZ1205Jpm1oppDXBAYkc7HPfx.jpg',NULL,NULL);
/*!40000 ALTER TABLE `product_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_rates`
--

DROP TABLE IF EXISTS `product_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_rates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `rate` enum('1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_rates_product_id_user_id_unique` (`product_id`,`user_id`),
  KEY `product_rates_product_id_index` (`product_id`),
  KEY `product_rates_user_id_index` (`user_id`),
  CONSTRAINT `product_rates_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_rates`
--

LOCK TABLES `product_rates` WRITE;
/*!40000 ALTER TABLE `product_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_seen`
--

DROP TABLE IF EXISTS `product_seen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_seen` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `seen` int unsigned NOT NULL,
  `updated` tinyint(1) NOT NULL DEFAULT '0',
  `date` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_seen_product_id_index` (`product_id`),
  CONSTRAINT `product_seen_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_seen`
--

LOCK TABLES `product_seen` WRITE;
/*!40000 ALTER TABLE `product_seen` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_seen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `digest` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rate` double unsigned DEFAULT NULL,
  `price` int unsigned NOT NULL,
  `seen` int unsigned NOT NULL DEFAULT '0',
  `priority` tinyint NOT NULL,
  `available_count` tinyint NOT NULL DEFAULT '0',
  `off` int unsigned DEFAULT NULL,
  `off_type` enum('value','percent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `off_expiration` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `is_in_top_list` tinyint(1) NOT NULL DEFAULT '0',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int unsigned NOT NULL,
  `brand_id` int unsigned NOT NULL,
  `similars` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_id` int unsigned DEFAULT NULL,
  `guarantee` smallint DEFAULT NULL,
  `introduce` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rate_count` int unsigned NOT NULL DEFAULT '0',
  `comment_count` int unsigned NOT NULL DEFAULT '0',
  `new_comment_count` int unsigned NOT NULL DEFAULT '0',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sell_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_brand_id_index` (`brand_id`),
  KEY `products_seller_id_index` (`seller_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (11,'فرش دستباف 12 متری پورمعمار مدل شکارگاه کد 110','درخواست مرجوع کردن کالا در گروه فرش دستبافت با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).','فرش دستبافت','فرش دستبافت','فرش دستباف 12 متری پورمعمار مدل شکارگاه کد 110',NULL,849900000,99,1,10,NULL,NULL,NULL,1,1,'/7i9Ld6IPAYjERfRUHBHyobEH6HlqJ3vZV6aKZ1cp.jpg','فرش دستباف 12 متری پورمعمار مدل شکارگاه کد 110',371,6,NULL,3,NULL,'<h3 style=\"text-align:justify;\">فرش دستباف چیست؟</h3><p style=\"text-align:justify;\">یکی از مهمترین تجهیزات و کالاها که از گذشته تا کنون اهمیت ویژه‌ای در زندگی انسان داشته است ، فرش و محصولات نساجی می‌باشد ؛ زیرا استفاده از این وسایل در ایجاد حس آسایش و آرامش انسان کمک شایانی می‌کند. حال در این بین یکی از بی‌نظیرترین و پرطرفدارترین انواع فرش ، فرش‌های دستباف هستند که جزو محصولات کهن ایرانی نیز به شمار می‌روند. در اینجا سوالی که ممکن است برای خریداران پیش بیاید این است که فرش دستباف چیست؟ دقت داشته باشید که کلمه فرش یک عبارت عربی است که به معنی گسترده می‌باشد و به مواردی چون قالی و پلاس اطلاق می‌شود. در نتیجه می‌توان گفت منظور از فرش دستباف ، زیراندازی می‌باشد که به وسیله دست از تار و پود بافته شده است که این امر طبیعتا موجب ایجاد طرح‌های بسیار زیبا بر روی آن می‌شود و طرفداران زیادی در سراسر دنیا دارد.</p><h3 style=\"text-align:justify;\">تاریخچه فرش دستباف</h3><p style=\"text-align:justify;\">با توجه به تاریخچه کهنی که در تولید فرش و قالی دستباف ایرانی وجود دارد در حال حاضر می‌توان گفت محصول بافته شده به دست هنرمندان ایرانی جزو بهترین و زیباترین نوع فرش در دنیا است که این امر از نظر کارشناسان بین‌المللی فرش تایید شده است. اما با وجود آنکه در سال ۱۳۲۸ شمسی اولین فرش‌های گره‌دار به عنوان پوشش اسب و یا در چادر صحرانشینان مورد استفاده قرار گرفته است و سپس در تولید این محصول پیشرفت‌های زیادی حاصل شده پژوهشگران اعتقاد دارند که آغاز شکوفایی هنر فرشبافی در ایران به قرن ۱۶ و ۱۷ میلادی بر می‌گردد.</p><p style=\"text-align:justify;\">در سال‌های گذشته با پیشرفت تکنولوژی در بسیاری از زمینه‌ها از جمله زمینه تولید فرش ، شاهد تغییر و تحولات بسیار عظیمی در تولید این محصول بودیم ؛ به طوری که در ابتدای تولید فرش به دست هنرمندان ایرانی ، نقش‌های بسیار ساده و طرح‌های آسانی روی این محصولات نساجی پیاده می‌شد اما با گذشت زمان تحول شگرفی در تولید این محصول به وجود آمد و این امر موجب تنوع بی‌نظیر در بازار فرش دستباف شد.</p><h3 style=\"text-align:justify;\">فرش‌های دستباف تاریخی</h3><p style=\"text-align:justify;\">در میان فرش‌های مهم دستباف در تاریخ ایران می‌توان به فرش و قالی‌های ذیل اشاره کرد :</p><figure class=\"image ck-widget\" contenteditable=\"false\"><img src=\"https://ziloome.com/wp-content/uploads/2019/03/handmade-carpet-2.jpg\" alt=\"فرش‌های دستباف تاریخی\" srcset=\"https://ziloome.com/wp-content/uploads/2019/03/handmade-carpet-2.jpg 660w, https://ziloome.com/wp-content/uploads/2019/03/handmade-carpet-2-510x307.jpg 510w, https://ziloome.com/wp-content/uploads/2019/03/handmade-carpet-2-150x90.jpg 150w, https://ziloome.com/wp-content/uploads/2019/03/handmade-carpet-2-300x180.jpg 300w\" sizes=\"100vw\" width=\"660\" class=\"mCS_img_loaded\"><figcaption class=\"ck-editor__editable ck-editor__nested-editable ck-placeholder ck-hidden\" contenteditable=\"true\" data-placeholder=\"Enter image caption\"><br data-cke-filler=\"true\"></figcaption></figure><ol><li style=\"text-align:justify;\"><strong>قالی پازیریک :</strong> این فرش قدمتی ۲۵۰۰ ساله دارد و در اندازه‌های ۲۱۰ در ۱۸۳ سانتیمتر و با حدود ۳۶۰۰ گره بافته شده است.</li><li style=\"text-align:justify;\"><strong>فرش بهارستان :</strong> معروف به فرش بهار خسرو که یک قالی بسیار عالی در زمان خسرو پرویز می‌باشد.</li><li style=\"text-align:justify;\"><strong>قالی دستباف عصر صفوی :</strong> یکی دیگر از زیباترین قالی‌های دستباف ایرانی بوده که خلاقیت و نبوغ هنرمندان در زمان حکومت صفویان را نشان می‌دهد ، در این دوره قالیبافان با استفاده از طرح‌هایی در حدود ۱۵۰۰ تخته فرش و قالی از خود به جا گذاشته اند.</li><li style=\"text-align:justify;\"><strong>قالی ترنج منظره حیوانات :</strong> یکی دیگر از فرش‌های ایرانی است که با زمینه قرمز رنگ و طرح‌های زیبایی ، تولید شده از ابریشم می‌باشد که موجب محبوبیت بالای آن شده است.</li><li style=\"text-align:justify;\"><strong>قالی چلسی :</strong> یکی دیگر از فرش‌های زیبای جهان قالی چلسی است که در مجموعه فرش‌های موزه ویکتوریا و آلبرت لندن نگهداری می‌شود.</li></ol><ul><li style=\"text-align:justify;\"><br data-cke-filler=\"true\"></li></ul><h3 style=\"text-align:justify;\">مواد به کار رفته در فرش دستباف</h3><p style=\"text-align:justify;\">یکی از شاخص‌ترین مواردی که موجب محبوبیت و مشهوریت فرش دستباف ایرانی شده است مواد مصرف شده در این قالی‌ها است که دارای کیفیت و مرغوبیت بسیار بالایی هستند و این امر در کنار زیبایی محصول مورد اهمیت می‌باشد. یکی از مواد به کار رفته در تار و پود فرش دستبافت ایرانی پنبه و پشم می‌باشد که این نوع فرش و قالی به فرش یا قالی پشمی مشهور است. همچنین می‌توان گفت در میان عشایر به جای نخ از پشم استفاده می‌شود.</p><h3 style=\"text-align:justify;\">انواع فرش دستباف</h3><p style=\"text-align:justify;\">از انواع فرش دستباف می‌توان به موارد زیر اشاره کرد :</p><ol><li style=\"text-align:justify;\"><strong>قالی تمام ابریشم :</strong> پرز و چله آن از نخ ابریشم مرغوب بافته شده است.</li><li style=\"text-align:justify;\"><strong>گل ابریشم :</strong> &nbsp;نوع دیگری از فرش یا قالی دستباف است که در دوره حاشیه‌ها و در نقش‌های آن به جای پرز پشمی ، از ابریشم استفاده می‌شود.</li><li style=\"text-align:justify;\"><strong>قالی کف ابریشم :</strong> نوع دیگری از فرش دستباف است که در زمینه آن به جای پشم از ابریشم استفاده می‌شود.</li><li style=\"text-align:justify;\"><strong>سوف :</strong> نوع دیگری از فرش و قالی دستباف است که زمینه آن از پود ضخیم و نازک تشکیل شده است و نقش و گل و بوته پرزدار دارد.</li></ol><ul><li style=\"text-align:justify;\"><br data-cke-filler=\"true\"></li></ul>',0,0,0,'فرش_دستباف_12_متری_پورمعمار_مدل_شکارگاه_کد_110',0,'2022-10-15 15:02:02',NULL,NULL),(12,'فرش دستبافت نه و نیم متری اصفهان آبتین کد 4','درخواست مرجوع کردن کالا در گروه فرش دستبافت با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).','فرش دستبافت','فرش دستبافت','فرش دستبافت نه و نیم متری اصفهان آبتین کد 4',NULL,396500000,11,2,2,NULL,NULL,NULL,1,1,'/VlWJBYDBEVnizTCvYFpkhm2RNQ4A87upOO9yf3gf.jpg','فرش دستبافت نه و نیم متری اصفهان آبتین کد 4',371,7,NULL,5,NULL,NULL,0,0,0,'فرش_دستبافت_نه_و_نیم_متری_اصفهان_آبتین_کد_4',0,'2022-10-15 15:02:02',NULL,NULL),(13,'فرش دستبافت شش متری طرح قشقایی کد 564517r','درخواست مرجوع کردن کالا در گروه فرش دستبافت با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).','فرش دستبافت','فرش دستبافت','فرش دستبافت شش متری طرح قشقایی کد 564517r',NULL,38500000,59,3,8,10,'percent','14010826',1,1,'/RPDcn4hOLkga681uROKTUeM3DkeUZYQfHsKlsvpH.jpg','فرش دستبافت شش متری طرح قشقایی کد 564517r',371,3,NULL,6,NULL,NULL,0,0,0,'فرش_دستبافت_شش_متری_طرح_قشقایی_کد_564517r',0,'2022-10-15 15:02:02',NULL,NULL),(14,'فرش دستباف ذرع و نیم مدل درختی تمام ابریشم قم کد YMM36-20',NULL,'فرش دستباف ذرع و نیم مدل درختی تمام ابریشم قم کد YMM36-20',NULL,'درخواست مرجوع کردن کالا در گروه فرش دستبافت با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).',NULL,75000000,1,4,5,NULL,NULL,NULL,1,1,'/V4EpHjas2thZkeUnxTFH02XzA5zfZbzHGGtgGuyp.jpg',NULL,371,7,NULL,7,NULL,NULL,0,0,0,'فرش_دستباف_ذرع_و_نیم_مدل_درختی_تمام_ابریشم_قم_کد_YMM36-20',0,'2022-10-15 15:02:02',NULL,NULL),(15,'فرش دستباف شش و نیم متری سی پرشیا کد 102458','فرش دستباف شش و نیم متری سی پرشیا کد 102458',NULL,NULL,'فرش دستباف شش و نیم متری سی پرشیا کد 102458',NULL,395000000,17,6,3,NULL,NULL,NULL,1,1,'/vQ2N27gIabRYDjmwAkmcq6hNhtr6zT5wAAhWv6IC.jpg',NULL,371,1,NULL,4,NULL,NULL,0,0,0,'فرش_دستباف_شش_و_نیم_متری_سی_پرشیا_کد_102458',0,'2022-10-15 15:02:02',NULL,NULL),(16,'فرش دستبافت 6 متری طرح کرمان','فرش دستبافت 6 متری طرح کرمان',NULL,NULL,'فرش دستبافت 6 متری طرح کرمان',NULL,15000000,28,7,10,20,'percent','14010812',1,1,'/tx8E36VzDYPGIuApmaBi4S52Lg9AuyC7ZrWttvEh.jpg',NULL,371,1,NULL,4,NULL,NULL,0,0,0,'فرش_دستبافت_6_متری_طرح_کرمان',0,'2022-10-15 15:02:02',NULL,NULL),(17,'روتختي قلمكار عطريان طرح خشتي مدل G278','روتختي قلمكار عطريان طرح خشتي مدل G278','قلمکار','قلمکار','روتختي قلمكار عطريان طرح خشتي مدل G278',NULL,547000,75,1,3,25,'percent','14011028',1,1,'/Io711aN5wcgXw2kDJeXF2SXYDOQbqea8qI45MCbZ.jpg',NULL,412,1,NULL,4,NULL,NULL,0,0,0,'روتختي_قلمكار_عطريان_طرح_خشتي_مدل_G278',0,'2022-10-15 15:02:02',NULL,NULL),(18,'سفره قلمکار عطریان طرح خوشه انگور کد G367','سفره قلمکار عطریان طرح خوشه انگور کد G367','سفره قلمکار','سفره قلمکار','سفره قلمکار عطریان طرح خوشه انگور کد G367',2,348000,52,2,20,NULL,NULL,NULL,1,1,'/Jdo83mEFFO0sNkIJQAq0m8taCwBzhJsoorvyhIox.jpg','سفره قلمکار',412,1,NULL,4,NULL,NULL,1,1,0,'سفره_قلمکار_عطریان_طرح_خوشه_انگور_کد_G367',0,'2022-10-15 15:02:02',NULL,NULL),(19,'سفره قلمکار طرح پاییز','سفره قلمکار طرح پاییز',NULL,NULL,'سفره قلمکار طرح پاییز',NULL,172900,57,4,1,NULL,NULL,NULL,1,1,'/y2xLwgg7o4tFH3K8xLjpF3IzbvDZC9gOXF8Snq86.jpg',NULL,412,1,NULL,4,NULL,NULL,0,0,0,'سفره_قلمکار_طرح_پاییز',0,'2022-10-15 15:02:02',NULL,NULL),(20,'سفره قلمکار طرح سنتی کد 150100','سفره قلمکار طرح سنتی کد 150100',NULL,NULL,'سفره قلمکار طرح سنتی کد 150100',NULL,474000,23,4,5,NULL,NULL,NULL,1,0,'/6ufEsCIUnTP1DeoNhWFrM3AadjA4CKsIbaBrW4Dl.jpg',NULL,412,1,NULL,4,NULL,NULL,0,0,0,'سفره_قلمکار_طرح_سنتی_کد_150100',0,'2022-10-15 15:02:02',NULL,NULL),(21,'روميزي قلمكار عطريان طرح گل كد G403','روميزي قلمكار عطريان طرح گل كد G403',NULL,NULL,'روميزي قلمكار عطريان طرح گل كد G403',NULL,184800,75,6,20,10,'percent','14010728',1,1,'/iLpCMDUlOCJQQdbZlMuSStZHIsa4RqMzlyDzAMxG.jpg',NULL,412,1,NULL,4,NULL,NULL,0,0,0,'روميزي_قلمكار_عطريان_طرح_گل_كد_G403',0,'2022-10-15 15:02:02',NULL,NULL),(22,'فرش ماشینی مدل فانتزی کد BRN2021','درخواست مرجوع کردن کالا در گروه فرش ماشینی با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).',NULL,NULL,'درخواست مرجوع کردن کالا در گروه فرش ماشینی با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).',NULL,79000,46,6,0,NULL,NULL,NULL,1,0,'fjqkM06kUJf6n2LRXqFZN3zmBxDMMVyjeck2005m.jpg',NULL,371,6,NULL,5,6,'<p style=\"text-align:justify;\">این نوع خزهای پشت چرم دار مدل‌های جدید هستند که می‌توان به عنوان فرش کوچک استفاده کرد و به دلیل چرم زیر کار این خز ها هم مثل پادری‌های دیگر لیز نمی‌خورند. به علاوه که میشه به عنوان پادری استفاده کرد می‌توان روی مبل به عنوان شال که روی دسته مبل تک نفره ویا روی مبل سه نفره می‌اندازند که در خانه‌های غربی بسیار استفاده شده و سبک بسیار شیکی است. دیگر استفاده آن کنار یا روی تختخواب است که بعد از خواب پاهایمان در جایی نرم و گرم گذاشته شود و زوج های جوان در حال حاضر سبک اتاقخوابشان از این نوع خزها بسیار استفاده می‌شود. کاربرد پرطرفدار دیگر این خز ها این است که دکوری‌ها بلند ویا کوتاه(اگر روی میز گذاشته شود) مثل فانوس‌های بلند و جاشمعی‌های کنار سالنی و... روی خز گذاشته شود و محیط را کامل و زیباتر میکند.</p><p><br data-cke-filler=\"true\"></p>',0,0,0,'فرش_ماشینی_مدل_فانتزی_کد_BRN2021',0,'2022-10-23 18:34:54',NULL,NULL),(23,'فرش دستبافت نیم متری مدل روصندلی تک گل',NULL,NULL,NULL,NULL,NULL,310000,60,7,0,10,'percent','14011022',1,0,'pEKA4pEdc42xdyp9hMJpFLDJz8prc9VmNFkj83dX.jpg',NULL,371,6,NULL,4,2,'<p>فرق بین بودن یا نبودن این محصول روی صندلی شما، مثل نشستن روی زمین و نشستن روی فرش هست. این محصول برای راحتی مصرف کنندگانی که زیاد روی صندلی می نشنینند طراحی شده است و علاوه بر زیبایی محیط، خواص درمانی پشم را نیز دارا می باشد. این محصول بصورت نیمه دستبافت تهیه گردیده است، یعنی نه کاملا دستبافت است و نه کاملا ماشینی. بلکه ترکیبی از این دو می باشد، اما تمامی خواص و کیفیت فرش ماشینی را دارا می باشد. تنها تفاوت فرش نیمه دستبافت با فرش دستبافت در محدودیت استفاده از رنگ های مختلف و طرح های مختلف می باشد. اما در سایر مشخصات کاملا شبیه و در بعضی از خواص فیزیکی بهتر از فرش دستبافت می باشند.</p><p><br data-cke-filler=\"true\"></p>',0,0,0,'فرش_مدل رومیزی',0,'2022-10-23 18:37:15',NULL,NULL),(24,'روسری دست دوز زنانه مدل سنتی گلونی','مرجوع نمودن این کالا تایع شرایط خاص است.',NULL,NULL,'مرجوع نمودن این کالا تایع شرایط خاص است.',NULL,133000,174,10,0,20,'percent','14011113',1,1,'HM6zqsNe2W3Q8LxpBgK4ZfC7VVsUUWZtbzdAoy7V.jpg',NULL,408,1,NULL,4,NULL,'<p><strong>روسری سنتی گلونی</strong>: روسری با قدمت بیش از هزار سال همراه و راز نگه دار زن <a href=\"https://hcshop.taci.ir/blog/11/%D8%AF%D8%A7%D8%B1%D8%A7%DB%8C%DB%8C%20%D8%A8%D8%A7%D9%81%DB%8C%20%28%D8%A7%DB%8C%DA%A9%D8%A7%D8%AA%29%20%28%28%DB%8C%D8%B2%D8%AF%29%29\">عشایر</a> .گاهی حجابی برای موهای مشکی اش و بارها شال دردهای کمرش و گاهی به عنوان کلاهی برای سرش .با این روسرها بارها دستمال رقص اش کرده و در هوا چرخانیده و گاهی هم نم نم اشک هایش راجمع کرده .گلونی را تنها زنان نمی پوشن دستاریست برای سر مردان غیور و خوش ذوق و شال کمریست برای زدن سنگینی بار بر زمین .حتما یکی از آنها برای دل خود داشته باشید</p><p style=\"text-align:justify;\"><strong>روسری سنتی گلونی</strong>: روسری با قدمت بیش از هزار سال همراه و راز نگه دار زن <a href=\"https://hcshop.taci.ir/blog/11/%D8%AF%D8%A7%D8%B1%D8%A7%DB%8C%DB%8C%20%D8%A8%D8%A7%D9%81%DB%8C%20%28%D8%A7%DB%8C%DA%A9%D8%A7%D8%AA%29%20%28%28%DB%8C%D8%B2%D8%AF%29%29\">عشایر</a> .گاهی حجابی برای موهای مشکی اش و بارها شال دردهای کمرش و گاهی به عنوان کلاهی برای سرش .با این روسرها بارها دستمال رقص اش کرده و در هوا چرخانیده و گاهی هم نم نم اشک هایش راجمع کرده .گلونی را تنها زنان نمی پوشن دستاریست برای سر مردان غیور و خوش ذوق و شال کمریست برای زدن سنگینی بار بر زمین .حتما یکی از آنها برای دل خود داشته باشید</p><p><br data-cke-filler=\"true\"></p><p style=\"text-align:justify;\"><strong>روسری سنتی گلونی</strong>: روسری با قدمت بیش از هزار سال همراه و راز نگه دار زن <a href=\"https://hcshop.taci.ir/blog/11/%D8%AF%D8%A7%D8%B1%D8%A7%DB%8C%DB%8C%20%D8%A8%D8%A7%D9%81%DB%8C%20%28%D8%A7%DB%8C%DA%A9%D8%A7%D8%AA%29%20%28%28%DB%8C%D8%B2%D8%AF%29%29\">عشایر</a> .گاهی حجابی برای موهای مشکی اش و بارها شال دردهای کمرش و گاهی به عنوان کلاهی برای سرش .با این روسرها بارها دستمال رقص اش کرده و در هوا چرخانیده و گاهی هم نم نم اشک هایش راجمع کرده .گلونی را تنها زنان نمی پوشن دستاریست برای سر مردان غیور و خوش ذوق و شال کمریست برای زدن سنگینی بار بر زمین .حتما یکی از آنها برای دل خود داشته باشید</p><p><br data-cke-filler=\"true\"></p><p style=\"text-align:justify;\"><strong>روسری سنتی گلونی</strong>: روسری با قدمت بیش از هزار سال همراه و راز نگه دار زن <a href=\"https://hcshop.taci.ir/blog/11/%D8%AF%D8%A7%D8%B1%D8%A7%DB%8C%DB%8C%20%D8%A8%D8%A7%D9%81%DB%8C%20%28%D8%A7%DB%8C%DA%A9%D8%A7%D8%AA%29%20%28%28%DB%8C%D8%B2%D8%AF%29%29\">عشایر</a> .گاهی حجابی برای موهای مشکی اش و بارها شال دردهای کمرش و گاهی به عنوان کلاهی برای سرش .با این روسرها بارها دستمال رقص اش کرده و در هوا چرخانیده و گاهی هم نم نم اشک هایش راجمع کرده .گلونی را تنها زنان نمی پوشن دستاریست برای سر مردان غیور و خوش ذوق و شال کمریست برای زدن سنگینی بار بر زمین .حتما یکی از آنها برای دل خود داشته باشید</p><p style=\"text-align:justify;\"><strong>روسری سنتی گلونی</strong>: روسری با قدمت بیش از هزار سال همراه و راز نگه دار زن <a href=\"https://hcshop.taci.ir/blog/11/%D8%AF%D8%A7%D8%B1%D8%A7%DB%8C%DB%8C%20%D8%A8%D8%A7%D9%81%DB%8C%20%28%D8%A7%DB%8C%DA%A9%D8%A7%D8%AA%29%20%28%28%DB%8C%D8%B2%D8%AF%29%29\">عشایر</a> .گاهی حجابی برای موهای مشکی اش و بارها شال دردهای کمرش و گاهی به عنوان کلاهی برای سرش .با این روسرها بارها دستمال رقص اش کرده و در هوا چرخانیده و گاهی هم نم نم اشک هایش راجمع کرده .گلونی را تنها زنان نمی پوشن دستاریست برای سر مردان غیور و خوش ذوق و شال کمریست برای زدن سنگینی بار بر زمین .حتما یکی از آنها برای دل خود داشته باشید</p>',0,0,0,'روسری-دست-دوز-زنانه-مدل-سنتی-گلونی',0,'2022-11-12 09:28:29',NULL,NULL),(25,'تابلو فرش دستبافت طرح دایره هستی کد ۳۹۷۳۴۸۱',NULL,'فرش','فرش','درخواست مرجوع کردن کالا در گروه تابلو فرش با دلیل \"انصراف از خرید\" تنها در صورتی قابل تایید است که کالا در شرایط اولیه باشد (در صورت پلمپ بودن، کالا نباید باز شده باشد).',NULL,60000000,137,3,8,NULL,NULL,NULL,1,1,'ikoVMN6qhMOi8vowSAORBd1R2NFpQgo07iKeg2i1.jpg','فرش',372,1,NULL,5,3,'<p style=\"text-align:justify;\"><br data-cke-filler=\"true\"></p>',0,0,0,'تابلو-فرش-دستبافت-طرح-دایره-هستی-کد-۳۹۷۳۴۸',0,'2022-11-12 09:46:22',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `status` enum('finalized','sending','delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('cach','online') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('paid','pending') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` int unsigned NOT NULL,
  `delivery` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int unsigned NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `recv_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recv_phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_user_id_index` (`user_id`),
  KEY `purchase_transaction_id_index` (`transaction_id`),
  KEY `purchase_city_id_index` (`city_id`),
  CONSTRAINT `purchase_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `events`.`cities` (`id`),
  CONSTRAINT `purchase_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `purchase_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase`
--

LOCK TABLES `purchase` WRITE;
/*!40000 ALTER TABLE `purchase` DISABLE KEYS */;
INSERT INTO `purchase` VALUES (6,3,'sending','online','2023-01-29 13:10:57','2023-01-29 13:10:57',NULL,'paid',6,'',1,'این یک آدرس تست است. تهران - چهار راه جهان کودک - میدان ونک - چهار راه ولیعصر عج میدان مادر خ ۲ کوچه ۱۰','1971933123',35.71,51.38,'sadwq','09121111111');
/*!40000 ALTER TABLE `purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `off_amount` int unsigned DEFAULT NULL,
  `product_id` int unsigned NOT NULL,
  `purchase_id` int unsigned NOT NULL,
  `count` tinyint NOT NULL DEFAULT '1',
  `feature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_index` (`purchase_id`),
  KEY `purchase_items_product_id_index` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
INSERT INTO `purchase_items` VALUES (12,290000,24,6,1,'رنگ زرد',1450000),(13,270000,24,6,1,'رنگ نارنجی کمرنگ',1350000),(14,0,25,6,1,'سایز 70*50',600000000);
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sellers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (1,'seller1',NULL,NULL),(2,'seller2',NULL,NULL),(3,'پورمعمار',NULL,NULL),(4,'ویزیت ایران',NULL,NULL),(5,'گالری هزار و یک شهر',NULL,NULL),(6,'منصوری کارپت',NULL,NULL),(7,'یاسر',NULL,NULL);
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `similars`
--

DROP TABLE IF EXISTS `similars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `similars` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `sim_1` int unsigned DEFAULT NULL,
  `sim_2` int unsigned DEFAULT NULL,
  `sim_3` int unsigned DEFAULT NULL,
  `sim_4` int unsigned DEFAULT NULL,
  `sim_5` int unsigned DEFAULT NULL,
  `sim_6` int unsigned DEFAULT NULL,
  `sim_7` int unsigned DEFAULT NULL,
  `sim_8` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `similars_product_id_index` (`product_id`),
  CONSTRAINT `similars_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `similars`
--

LOCK TABLES `similars` WRITE;
/*!40000 ALTER TABLE `similars` DISABLE KEYS */;
INSERT INTO `similars` VALUES (23,11,12,15,14,13,16,NULL,NULL,NULL),(24,12,15,13,16,11,14,NULL,NULL,NULL),(25,13,16,14,15,12,11,NULL,NULL,NULL),(26,14,13,16,15,12,11,NULL,NULL,NULL),(27,15,12,14,13,11,16,NULL,NULL,NULL),(28,16,13,14,12,11,15,NULL,NULL,NULL),(29,17,20,18,21,19,NULL,NULL,NULL,NULL),(30,18,20,21,19,17,NULL,NULL,NULL,NULL),(31,19,21,18,20,17,NULL,NULL,NULL,NULL),(32,20,17,18,21,19,NULL,NULL,NULL,NULL),(33,21,19,18,20,17,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `similars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `img_large` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_mid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_small` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `href` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int unsigned NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `site` enum('event','shop') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (3,'qKbtd9h5H774msqEDT8uitxHmVOpOV0YQlbzdP5G.png','5iuqYQCALrIPgdQDVFBmWsbeiH1c6MsiGQY0vzn4.png','qC3pFVB9lERxogMA3N1mzkSsIuoA6b5YdwOSuIay.png','تخفیف شگفت انگیز','https://www.visitiran.ir/',1,1,'shop'),(4,'kat6XpRhtjqSSiTcVl0UXdMWlR1VjLpTQ8D3qNx7.jpg','W4hIs1r4xkt5ju3rCCoIgU3I5usGOsd5HBj54CuP.png','SuKROOZJ6ZMZErLIkAZrpSHJIH9c3SxkxgDNJhTA.png','صنایع دستی فاخر','https://www.visitiran.ir/',2,1,'shop'),(6,'HNJoin8wi8Ws2hVs80Yg2hAsDywoCswfeqPvcNpT.jpg','H7jSsgw9Vonmws1gYYCgUEzL6I7uwZXvsfAT2Q1F.jpg',NULL,NULL,'http://shop.bogenstudio.com/#',1,1,'event'),(7,'RZM91AdwismbY0vZvvuJhnNqBB2DFfW4K5ecbay2.jpg','agrEc9ps65OQjdQ3xu5WgDB1mYucDlqcsGnJdpv7.jpg','XnoevtzyWdCi7DjdeMwg1J1hYJ3P0ZwJ8WdJGRxa.jpg',NULL,'http://shop.bogenstudio.com/#',2,1,'event'),(8,'NlBWPjAHpgo6y5EoFnQfjSTABVpRDyB0HcBSLgiT.jpg','yyX0r1o6vlIMEKg7QbvK1RaP1RVntn7VDupK6OEf.jpg','38EojVfpx5tPJ0fNFXvN52CAV6MNuO1Bz9KDGujy.jpg',NULL,NULL,3,1,'event'),(9,'IVQhgJYbGgLGkwyQyj0PSt6y0wyOT80sFJhi4o6R.jpg','vKJmfCQmSy6JDmhwtfTZjW1G2bYS8eknVKtA2Ph3.jpg','oXE9RpCrpijvmC1z6h4z7b2yLH38GLAhLkdBXExo.jpg',NULL,NULL,4,1,'event'),(10,'N4Pzubn20IMABDQGl6MSAQZxe7Ww9k7M5oUUeqfs.jpg','p4L4E95l9IYYA1AW635XTGO65Vr10b9o2nLjXLQj.jpg','7g676LbDukfeA1WivFTLtuTStC9SQZVq5qrvMCoT.jpg',NULL,NULL,5,1,'event'),(11,'0yPwK4UYPMUq708qUp4Yq9W7vN2IYtuzfFgRl274.jpg','Aln4znxqNhFM1OJbx27vmm56swzo7TK0uKGTl0If.jpg','oXMgZth5s2XiJvbnnMJ66NEwo1rmGUyIzAulg6uI.jpg',NULL,NULL,6,1,'event'),(12,'0A1sy0DwwAA1min444BZVWUQksAAeVktGB1jV6qt.jpg','2D7dLtKqRs8mUwluA5bhzDDBg9PZHDJYHfUWiVeM.jpg','9KzUhzTO21XLHLi20Btfwq168DTces8HU9GQFDQJ.jpg',NULL,NULL,7,1,'event');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` enum('shop','event') COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('low','mid','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','answered','finished') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_user_id_index` (`user_id`),
  CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `transaction_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('init','cancelled','completed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` enum('shop','event') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop',
  `amount` int unsigned NOT NULL,
  `transfer` int unsigned NOT NULL DEFAULT '0',
  `ref_id` int unsigned DEFAULT NULL,
  `off_id` int unsigned DEFAULT NULL,
  `off_amount` int unsigned DEFAULT NULL,
  `additional` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_user_id_index` (`user_id`),
  KEY `transactions_ref_id_index` (`ref_id`),
  KEY `transactions_off_id_index` (`off_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (6,3,NULL,'778920','completed','shop',0,200000,NULL,4,602240000,NULL,'2023-01-29 13:10:57','2023-01-29 13:10:57');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','init','blocked') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'init',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `access` enum('both','event','shop') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'both',
  `level` enum('admin','editor','report','user','news','finance','launcher') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `nid` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_day` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_back` enum('WALLET','ONLINE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WALLET',
  `shaba_no` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_nid_unique` (`nid`),
  UNIQUE KEY `users_mail_unique` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'تست','تست','active','09121111111','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-09 02:24:49','2023-01-29 05:09:23','both','admin','0018914373','mmm@yahoo.com','1375/11/20','WALLET',NULL),(4,'user','user','active','09122222222','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-09 02:24:49','2022-10-09 02:24:49','both','user',NULL,NULL,NULL,'WALLET',NULL),(5,'launcher','launcher','active','09131111111','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 14:46:19','2022-10-21 14:46:19','both','launcher',NULL,NULL,NULL,'WALLET',NULL),(6,'launcher','launcher','active','09141111111','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 14:46:19','2022-10-21 14:46:19','both','launcher',NULL,NULL,NULL,'WALLET',NULL),(7,'launcher','launcher','active','09151111111','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 14:46:19','2022-10-21 14:46:19','both','launcher',NULL,NULL,NULL,'WALLET',NULL),(8,'launcher','launcher','active','09161111111','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 14:46:19','2022-10-21 14:46:19','both','launcher',NULL,NULL,NULL,'WALLET',NULL),(9,'admin2','admin2','active','09121234567','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:31','2023-01-09 03:44:56','event','admin',NULL,NULL,NULL,'WALLET',NULL),(10,'admin3','admin3','active','09127654321','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:31','2022-10-21 15:05:31','shop','admin',NULL,NULL,NULL,'WALLET',NULL),(11,'editor','editor','active','09211234567','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:31','2022-10-21 15:05:31','both','editor',NULL,NULL,NULL,'WALLET',NULL),(12,'finance','finance','active','09131234567','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:31','2022-10-21 15:05:31','both','finance',NULL,NULL,NULL,'WALLET',NULL),(13,'report','report','active','09141234567','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:31','2022-10-21 15:05:31','both','report',NULL,NULL,NULL,'WALLET',NULL),(14,'user','blocked','init','09212222222','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(15,'user 0','user 0','active','09123333300','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(16,'user 1','user 1','active','09123333301','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(17,'user 2','user 2','active','09123333302','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(18,'user 3','user 3','active','09123333303','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(19,'user 4','user 4','active','09123333304','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(20,'user 5','user 5','active','09123333305','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(21,'user 6','user 6','active','09123333306','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(22,'user 7','user 7','active','09123333307','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:32','2022-10-21 15:05:32','both','user',NULL,NULL,NULL,'WALLET',NULL),(23,'user 8','user 8','active','09123333308','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:33','2022-10-21 15:05:33','both','user',NULL,NULL,NULL,'WALLET',NULL),(24,'user 9','user 9','active','09123333309','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:33','2022-10-21 15:05:33','both','user',NULL,NULL,NULL,'WALLET',NULL),(25,'user 10','user 10','active','09123333310','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:33','2022-10-21 15:05:33','both','user',NULL,NULL,NULL,'WALLET',NULL),(26,'user 11','user 11','active','09123333311','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:33','2022-10-21 15:05:33','both','user',NULL,NULL,NULL,'WALLET',NULL),(27,'user 12','user 12','active','09123333312','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:33','2022-10-21 15:05:33','both','user',NULL,NULL,NULL,'WALLET',NULL),(28,'user 13','user 13','active','09123333313','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:34','2022-10-21 15:05:34','both','user',NULL,NULL,NULL,'WALLET',NULL),(29,'user 14','user 14','active','09123333314','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:34','2022-10-21 15:05:34','both','user',NULL,NULL,NULL,'WALLET',NULL),(30,'user 15','user 15','active','09123333315','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:34','2022-10-21 15:05:34','both','user',NULL,NULL,NULL,'WALLET',NULL),(31,'user 16','user 16','active','09123333316','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:34','2022-10-21 15:05:34','both','user',NULL,NULL,NULL,'WALLET',NULL),(32,'user 17','user 17','active','09123333317','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:34','2022-10-21 15:05:34','both','user',NULL,NULL,NULL,'WALLET',NULL),(33,'user 18','user 18','active','09123333318','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:34','2022-10-21 15:05:34','both','user',NULL,NULL,NULL,'WALLET',NULL),(34,'user 19','user 19','active','09123333319','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(35,'user 20','user 20','active','09123333320','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(36,'user 21','user 21','active','09123333321','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(37,'user 22','user 22','active','09123333322','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(38,'user 23','user 23','active','09123333323','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(39,'user 24','user 24','active','09123333324','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(40,'user 25','user 25','active','09123333325','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(41,'user 26','user 26','active','09123333326','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(42,'user 27','user 27','active','09123333327','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:35','2022-10-21 15:05:35','both','user',NULL,NULL,NULL,'WALLET',NULL),(43,'user 28','user 28','active','09123333328','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:36','2022-10-21 15:05:36','both','user',NULL,NULL,NULL,'WALLET',NULL),(44,'user 29','user 29','active','09123333329','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:36','2022-10-21 15:05:36','both','user',NULL,NULL,NULL,'WALLET',NULL),(45,'user 30','user 30','active','09123333330','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:36','2022-10-21 15:05:36','both','user',NULL,NULL,NULL,'WALLET',NULL),(46,'user 31','user 31','active','09123333331','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:36','2022-10-21 15:05:36','both','user',NULL,NULL,NULL,'WALLET',NULL),(47,'user 32','user 32','active','09123333332','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:36','2022-10-21 15:05:36','both','user',NULL,NULL,NULL,'WALLET',NULL),(48,'user 33','user 33','active','09123333333','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:36','2022-10-21 15:05:36','both','user',NULL,NULL,NULL,'WALLET',NULL),(49,'user 34','user 34','active','09123333334','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:37','2022-10-21 15:05:37','both','user',NULL,NULL,NULL,'WALLET',NULL),(50,'user 35','user 35','active','09123333335','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:37','2022-10-21 15:05:37','both','user',NULL,NULL,NULL,'WALLET',NULL),(51,'user 36','user 36','active','09123333336','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:37','2022-10-21 15:05:37','both','user',NULL,NULL,NULL,'WALLET',NULL),(52,'user 37','user 37','active','09123333337','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:37','2022-10-21 15:05:37','both','user',NULL,NULL,NULL,'WALLET',NULL),(53,'user 38','user 38','active','09123333338','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:37','2022-10-21 15:05:37','both','user',NULL,NULL,NULL,'WALLET',NULL),(54,'user 39','user 39','active','09123333339','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:37','2022-10-21 15:05:37','both','user',NULL,NULL,NULL,'WALLET',NULL),(55,'user 40','user 40','active','09123333340','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(56,'user 41','user 41','active','09123333341','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(57,'user 42','user 42','active','09123333342','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(58,'user 43','user 43','active','09123333343','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(59,'user 44','user 44','active','09123333344','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(60,'user 45','user 45','active','09123333345','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(61,'user 46','user 46','active','09123333346','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(62,'user 47','user 47','active','09123333347','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:38','2022-10-21 15:05:38','both','user',NULL,NULL,NULL,'WALLET',NULL),(63,'user 48','user 48','active','09123333348','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(64,'user 49','user 49','active','09123333349','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(65,'user 50','user 50','active','09123333350','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(66,'user 51','user 51','active','09123333351','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(67,'user 52','user 52','active','09123333352','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(68,'user 53','user 53','active','09123333353','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(69,'user 54','user 54','active','09123333354','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(70,'user 55','user 55','active','09123333355','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(71,'user 56','user 56','active','09123333356','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(72,'user 57','user 57','active','09123333357','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:39','2022-10-21 15:05:39','both','user',NULL,NULL,NULL,'WALLET',NULL),(73,'user 58','user 58','active','09123333358','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:40','2022-10-21 15:05:40','both','user',NULL,NULL,NULL,'WALLET',NULL),(74,'user 59','user 59','active','09123333359','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:40','2022-10-21 15:05:40','both','user',NULL,NULL,NULL,'WALLET',NULL),(75,'user 60','user 60','active','09123333360','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:40','2022-10-21 15:05:40','both','user',NULL,NULL,NULL,'WALLET',NULL),(76,'user 61','user 61','active','09123333361','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:40','2022-10-21 15:05:40','both','user',NULL,NULL,NULL,'WALLET',NULL),(77,'user 62','user 62','active','09123333362','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:40','2022-10-21 15:05:40','both','user',NULL,NULL,NULL,'WALLET',NULL),(78,'user 63','user 63','active','09123333363','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:40','2022-10-21 15:05:40','both','user',NULL,NULL,NULL,'WALLET',NULL),(79,'user 64','user 64','active','09123333364','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:41','2022-10-21 15:05:41','both','user',NULL,NULL,NULL,'WALLET',NULL),(80,'user 65','user 65','active','09123333365','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:41','2022-10-21 15:05:41','both','user',NULL,NULL,NULL,'WALLET',NULL),(81,'user 66','user 66','active','09123333366','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:41','2022-10-21 15:05:41','both','user',NULL,NULL,NULL,'WALLET',NULL),(82,'user 67','user 67','active','09123333367','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:41','2022-10-21 15:05:41','both','user',NULL,NULL,NULL,'WALLET',NULL),(83,'user 68','user 68','active','09123333368','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:41','2022-10-21 15:05:41','both','user',NULL,NULL,NULL,'WALLET',NULL),(84,'user 69','user 69','active','09123333369','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:41','2022-10-21 15:05:41','both','user',NULL,NULL,NULL,'WALLET',NULL),(85,'user 70','user 70','active','09123333370','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(86,'user 71','user 71','active','09123333371','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(87,'user 72','user 72','active','09123333372','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(88,'user 73','user 73','active','09123333373','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(89,'user 74','user 74','active','09123333374','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(90,'user 75','user 75','active','09123333375','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(91,'user 76','user 76','active','09123333376','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(92,'user 77','user 77','active','09123333377','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:42','2022-10-21 15:05:42','both','user',NULL,NULL,NULL,'WALLET',NULL),(93,'user 78','user 78','active','09123333378','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(94,'user 79','user 79','active','09123333379','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(95,'user 80','user 80','active','09123333380','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(96,'user 81','user 81','active','09123333381','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(97,'user 82','user 82','active','09123333382','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(98,'user 83','user 83','active','09123333383','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(99,'user 84','user 84','active','09123333384','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:43','2022-10-21 15:05:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(100,'user 85','user 85','active','09123333385','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(101,'user 86','user 86','active','09123333386','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(102,'user 87','user 87','active','09123333387','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(103,'user 88','user 88','active','09123333388','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(104,'user 89','user 89','active','09123333389','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(105,'user 90','user 90','active','09123333390','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(106,'user 91','user 91','active','09123333391','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:44','2022-10-21 15:05:44','both','user',NULL,NULL,NULL,'WALLET',NULL),(107,'user 92','user 92','active','09123333392','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2022-10-21 15:05:45','both','user',NULL,NULL,NULL,'WALLET',NULL),(108,'user 93','user 93','active','09123333393','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2022-10-21 15:05:45','both','user',NULL,NULL,NULL,'WALLET',NULL),(109,'user 94','user 94','active','09123333394','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2023-01-16 05:36:52','both','launcher',NULL,NULL,NULL,'WALLET',NULL),(110,'user 95','user 95','active','09123333395','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2022-10-21 15:05:45','both','user',NULL,NULL,NULL,'WALLET',NULL),(111,'user 96','user 96','active','09123333396','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2022-10-21 15:05:45','both','user',NULL,NULL,NULL,'WALLET',NULL),(112,'user 97','user 97','active','09123333397','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2022-10-21 15:05:45','both','user',NULL,NULL,NULL,'WALLET',NULL),(113,'user 98','user 98','active','09123333398','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:45','2022-10-21 15:05:45','both','user',NULL,NULL,NULL,'WALLET',NULL),(114,'user 99','user 99','active','09123333399','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-10-21 15:05:46','2022-10-21 15:05:46','both','user',NULL,NULL,NULL,'WALLET',NULL),(115,NULL,NULL,'active','09111111111','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-11-03 10:17:59','2022-11-03 10:17:59','both','user',NULL,NULL,NULL,'WALLET',NULL),(116,NULL,NULL,'active','09123840843','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2022-11-07 14:29:48','2022-11-07 14:29:48','both','user',NULL,NULL,NULL,'WALLET',NULL),(117,'mohammad','ghane','active','09214915905','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2023-01-08 09:20:29','2023-01-08 09:20:29','both','admin','0250040859','m2m@yahoo.com',NULL,'WALLET',NULL),(118,'تست','سلام','active','09391328463','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2023-01-08 10:06:14','2023-01-29 05:10:29','both','launcher','0020033087','mmmm@gmail.com','1340/3/20','WALLET',NULL),(119,NULL,NULL,'active','09124545431','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2023-01-18 04:57:43','2023-01-18 04:57:43','both','user',NULL,NULL,NULL,'WALLET',NULL),(120,NULL,NULL,'active','091243422343','$2y$10$nOnMlbagbG3.WH71qwWSVOIvKLqvPaMYCxClOyk2rZ9Uoy8zsJNba',NULL,'2023-01-18 07:19:46','2023-01-18 07:19:46','both','user',NULL,NULL,NULL,'WALLET',NULL),(121,NULL,NULL,'active','09902201345',NULL,NULL,'2023-01-29 05:20:00','2023-01-29 05:20:00','both','user',NULL,NULL,NULL,'WALLET',NULL),(122,'ممد','علی','active','09356908743',NULL,NULL,'2023-01-29 05:36:53','2023-01-29 07:25:13','both','launcher',NULL,NULL,'1340/2/12','WALLET',NULL),(123,NULL,NULL,'active','09323341243',NULL,NULL,'2023-01-29 10:28:27','2023-01-29 10:28:27','both','user',NULL,NULL,NULL,'WALLET',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-30 12:11:18

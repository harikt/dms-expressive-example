-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: dms
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.17.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `analytics`
--

DROP TABLE IF EXISTS `analytics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analytics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `driver` varchar(255) NOT NULL,
  `options` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics`
--

LOCK TABLES `analytics` WRITE;
/*!40000 ALTER TABLE `analytics` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_article_comments`
--

DROP TABLE IF EXISTS `blog_article_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_article_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(10) unsigned NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(254) NOT NULL,
  `content` text NOT NULL,
  `posted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7E7549A79452A475` (`blog_article_id`),
  CONSTRAINT `fk_blog_article_comments_blog_article_id_blog_articles` FOREIGN KEY (`blog_article_id`) REFERENCES `blog_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_article_comments`
--

LOCK TABLES `blog_article_comments` WRITE;
/*!40000 ALTER TABLE `blog_article_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_article_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_articles`
--

DROP TABLE IF EXISTS `blog_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_category_id` int(10) unsigned DEFAULT NULL,
  `blog_author_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `extract` text NOT NULL,
  `featured_image` varchar(500) DEFAULT NULL,
  `featured_image_file_name` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `article_content` longtext,
  `allow_sharing` tinyint(1) NOT NULL,
  `allow_commenting` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_articles_slug_unique_index` (`slug`),
  KEY `IDX_CB80154FCB76011C` (`blog_category_id`),
  KEY `IDX_CB80154F530B1B54` (`blog_author_id`),
  CONSTRAINT `fk_blog_articles_blog_author_id_blog_authors` FOREIGN KEY (`blog_author_id`) REFERENCES `blog_authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_blog_articles_blog_category_id_blog_categories` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_articles`
--

LOCK TABLES `blog_articles` WRITE;
/*!40000 ALTER TABLE `blog_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_authors`
--

DROP TABLE IF EXISTS `blog_authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_authors_slug_unique_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_authors`
--

LOCK TABLES `blog_authors` WRITE;
/*!40000 ALTER TABLE `blog_authors` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES (1,'Php','php',1,'2017-09-26 05:41:52','2017-09-26 05:41:52');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_enquiries`
--

DROP TABLE IF EXISTS `contact_enquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_enquiries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(8000) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_enquiries`
--

LOCK TABLES `contact_enquiries` WRITE;
/*!40000 ALTER TABLE `contact_enquiries` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_enquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_group_file_areas`
--

DROP TABLE IF EXISTS `content_group_file_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_group_file_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `client_file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_file_unique_index` (`content_group_id`,`name`),
  KEY `IDX_9DC2122BACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_file_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_group_file_areas`
--

LOCK TABLES `content_group_file_areas` WRITE;
/*!40000 ALTER TABLE `content_group_file_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_group_file_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_group_html_areas`
--

DROP TABLE IF EXISTS `content_group_html_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_group_html_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_html_unique_index` (`content_group_id`,`name`),
  KEY `IDX_87B6C2F3ACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_html_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_group_html_areas`
--

LOCK TABLES `content_group_html_areas` WRITE;
/*!40000 ALTER TABLE `content_group_html_areas` DISABLE KEYS */;
INSERT INTO `content_group_html_areas` VALUES (2,2,'content',''),(4,1,'content','<p>Content</p>');
/*!40000 ALTER TABLE `content_group_html_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_group_image_areas`
--

DROP TABLE IF EXISTS `content_group_image_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_group_image_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `client_file_name` varchar(255) DEFAULT NULL,
  `alt_text` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_images_unique_index` (`content_group_id`,`name`),
  KEY `IDX_39468675ACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_image_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_group_image_areas`
--

LOCK TABLES `content_group_image_areas` WRITE;
/*!40000 ALTER TABLE `content_group_image_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_group_image_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_group_metadata`
--

DROP TABLE IF EXISTS `content_group_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_group_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_metadata_unique_index` (`content_group_id`,`name`),
  KEY `IDX_2CCF82BFACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_metadata_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_group_metadata`
--

LOCK TABLES `content_group_metadata` WRITE;
/*!40000 ALTER TABLE `content_group_metadata` DISABLE KEYS */;
INSERT INTO `content_group_metadata` VALUES (3,2,'title',''),(4,2,'description',''),(5,1,'title',''),(6,1,'description','');
/*!40000 ALTER TABLE `content_group_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_group_text_areas`
--

DROP TABLE IF EXISTS `content_group_text_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_group_text_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_text_unique_index` (`content_group_id`,`name`),
  KEY `IDX_61F51841ACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_text_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_group_text_areas`
--

LOCK TABLES `content_group_text_areas` WRITE;
/*!40000 ALTER TABLE `content_group_text_areas` DISABLE KEYS */;
INSERT INTO `content_group_text_areas` VALUES (2,2,'title',''),(4,1,'title','Homepage');
/*!40000 ALTER TABLE `content_group_text_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_groups`
--

DROP TABLE IF EXISTS `content_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `namespace` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order_index` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_985B49DC727ACA70` (`parent_id`),
  CONSTRAINT `fk_content_groups_parent_id_content_groups` FOREIGN KEY (`parent_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_groups`
--

LOCK TABLES `content_groups` WRITE;
/*!40000 ALTER TABLE `content_groups` DISABLE KEYS */;
INSERT INTO `content_groups` VALUES (1,NULL,'pages','home',1,'2017-09-25 16:45:44'),(2,NULL,'pages','about',2,'2017-09-25 15:29:20'),(3,1,'__element__','carousel-item',1,'2017-09-25 16:45:44'),(4,1,'__element__','carousel-item',2,'2017-09-25 16:45:44'),(5,1,'__element__','carousel-item',3,'2017-09-25 16:45:44'),(6,1,'__element__','carousel-item',4,'2017-09-25 16:45:44');
/*!40000 ALTER TABLE `content_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dms_password_resets`
--

DROP TABLE IF EXISTS `dms_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_password_resets_token_unique_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_password_resets`
--

LOCK TABLES `dms_password_resets` WRITE;
/*!40000 ALTER TABLE `dms_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `dms_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dms_permissions`
--

DROP TABLE IF EXISTS `dms_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2B0D74A1D60322AC` (`role_id`),
  CONSTRAINT `fk_dms_permissions_role_id_dms_roles` FOREIGN KEY (`role_id`) REFERENCES `dms_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_permissions`
--

LOCK TABLES `dms_permissions` WRITE;
/*!40000 ALTER TABLE `dms_permissions` DISABLE KEYS */;
INSERT INTO `dms_permissions` VALUES (8,1,'admin.users.view'),(9,1,'documents.files.view'),(10,1,'analytics.config.view');
/*!40000 ALTER TABLE `dms_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dms_roles`
--

DROP TABLE IF EXISTS `dms_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_roles`
--

LOCK TABLES `dms_roles` WRITE;
/*!40000 ALTER TABLE `dms_roles` DISABLE KEYS */;
INSERT INTO `dms_roles` VALUES (1,'Editor');
/*!40000 ALTER TABLE `dms_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dms_temp_files`
--

DROP TABLE IF EXISTS `dms_temp_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_temp_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(40) NOT NULL,
  `file` text NOT NULL,
  `client_file_name` varchar(255) DEFAULT NULL,
  `type` enum('uploaded-image','uploaded-file','stored-image','in-memory','stored-file') NOT NULL COMMENT '(DC2Type:CustomEnum__uploaded_image__uploaded_file__stored_image__in_memory__stored_file)',
  `expiry_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_temp_files_token_unique_index` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_temp_files`
--

LOCK TABLES `dms_temp_files` WRITE;
/*!40000 ALTER TABLE `dms_temp_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `dms_temp_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dms_user_roles`
--

DROP TABLE IF EXISTS `dms_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F104DAD60322AC` (`role_id`),
  KEY `IDX_2F104DAA76ED395` (`user_id`),
  CONSTRAINT `fk_dms_user_roles_role_id_dms_roles` FOREIGN KEY (`role_id`) REFERENCES `dms_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dms_user_roles_user_id_dms_users` FOREIGN KEY (`user_id`) REFERENCES `dms_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_user_roles`
--

LOCK TABLES `dms_user_roles` WRITE;
/*!40000 ALTER TABLE `dms_user_roles` DISABLE KEYS */;
INSERT INTO `dms_user_roles` VALUES (8,1,2),(9,1,3);
/*!40000 ALTER TABLE `dms_user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dms_users`
--

DROP TABLE IF EXISTS `dms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dms_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('local','oauth') NOT NULL COMMENT '(DC2Type:CustomEnum__local__oauth)',
  `full_name` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `username` varchar(255) NOT NULL,
  `is_super_user` tinyint(1) NOT NULL,
  `is_banned` tinyint(1) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_algorithm` varchar(10) DEFAULT NULL,
  `password_cost_factor` int(11) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `oauth_provider_name` varchar(255) DEFAULT NULL,
  `oauth_account_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_users_email_unique_index` (`email`),
  UNIQUE KEY `dms_users_username_unique_index` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_users`
--

LOCK TABLES `dms_users` WRITE;
/*!40000 ALTER TABLE `dms_users` DISABLE KEYS */;
INSERT INTO `dms_users` VALUES (1,'local','Hari KT','kthari85@gmail.com','admin',1,0,'$2y$10$yORc6P2EGmzoMP5.rri.pucVDk9XQPs.JYQlsMHeZvZ.hkua25CEq','bcrypt',10,'ZtOF1hDs8BGas0jGcy2YPWm43iMpjsQw3sv8kc61lLFJ7qDgMhzdvYG5PO9s',NULL,NULL),(2,'local','Hari','someone@gmail.com','harikt',1,0,'$2y$10$o9hNWM/siGp0tOCPzu0BgenF8VfKYfBL7dAkaN49rwQn4qjnGfbYW','bcrypt',10,'ko6EdolS3w9Kmv3tqWp0sOJiCVWNjCNmA1m0Dy3bZGsWAbjrAu2xbF4Yh0MV',NULL,NULL),(3,'local','Elliot Levin','hello@example.com','Time_Toogo',1,0,'$2y$10$BLjom0GZh1K8xBT/8T90ZOttlxLyGx/0FiY0R/1S/4YltcKfq6Era','bcrypt',10,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dms_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2017_07_19_050100_initial_db',1),(2,'2017_07_19_052054_todo-1',1),(3,'2017_08_06_170253_blog',1),(4,'2017_09_14_091536_content',1),(5,'2017_09_14_095013_contact',1),(6,'2017_09_25_205847_analytics',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo_items`
--

DROP TABLE IF EXISTS `todo_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_items`
--

LOCK TABLES `todo_items` WRITE;
/*!40000 ALTER TABLE `todo_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo_items` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-08 16:17:05

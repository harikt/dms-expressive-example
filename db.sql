-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `blog_articles`;
CREATE TABLE `blog_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_category_id` int(10) unsigned DEFAULT NULL,
  `blog_author_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extract` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `article_content` longtext COLLATE utf8mb4_unicode_ci,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_articles` (`id`, `blog_category_id`, `blog_author_id`, `title`, `sub_title`, `slug`, `extract`, `featured_image`, `featured_image_file_name`, `date`, `article_content`, `allow_sharing`, `allow_commenting`, `published`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	'Hello World',	'And is a sub title',	'hello-world',	'Extract',	NULL,	NULL,	'2017-08-07',	'<p>Extract</p>',	1,	1,	1,	'2017-08-06 17:07:58',	'2017-09-12 10:27:11');

DROP TABLE IF EXISTS `blog_article_comments`;
CREATE TABLE `blog_article_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(10) unsigned NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7E7549A79452A475` (`blog_article_id`),
  CONSTRAINT `fk_blog_article_comments_blog_article_id_blog_articles` FOREIGN KEY (`blog_article_id`) REFERENCES `blog_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `blog_authors`;
CREATE TABLE `blog_authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_authors_slug_unique_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_authors` (`id`, `name`, `role`, `slug`, `bio`) VALUES
(1,	'John',	'admin',	'john',	'<p>John is an author with role admin.</p>'),
(2,	'Hari KT',	'admin',	'harikt',	'Hari KT'),
(3,	'Elliot Levin',	'admin',	'elliot-levin',	'<p>Lead developer at id digital agency and student at university of melbourne</p>');

DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `published`, `created_at`, `updated_at`) VALUES
(1,	'Php',	'php',	1,	'2017-08-06 17:06:09',	'2017-09-14 18:00:16'),
(2,	'Golang',	'golang',	1,	'2017-08-06 17:06:22',	'2017-09-14 05:23:12'),
(3,	'Another',	'another',	1,	'2017-09-13 15:18:41',	'2017-09-13 15:18:41');

DROP TABLE IF EXISTS `contact_enquiries`;
CREATE TABLE `contact_enquiries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(8000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_enquiries` (`id`, `email`, `name`, `subject`, `message`, `created_at`) VALUES
(1,	'kthari85@gmail.com',	'Hari KT',	'Hello world',	'Hello world',	'2017-09-14 09:50:24'),
(2,	'john@derbis.com',	'Debris Netting',	'Debris Netting',	'Debris Netting',	'2017-09-14 10:00:12'),
(3,	'someone@example.com',	'Hello',	'H and I',	'Oh man.',	'2017-09-14 17:23:15'),
(4,	'someone@example.com',	'Hello',	';) and edited',	'Oh man.',	'2017-09-14 17:23:56'),
(5,	'someone@example.com',	'Hello',	'Oh I am edited',	'Oh man.',	'2017-09-14 17:24:36');

DROP TABLE IF EXISTS `content_groups`;
CREATE TABLE `content_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_index` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_985B49DC727ACA70` (`parent_id`),
  CONSTRAINT `fk_content_groups_parent_id_content_groups` FOREIGN KEY (`parent_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `content_groups` (`id`, `parent_id`, `namespace`, `name`, `order_index`, `updated_at`) VALUES
(1,	NULL,	'pages',	'home',	1,	'2017-09-14 18:37:42'),
(6,	NULL,	'pages',	'about',	2,	'2017-09-14 09:55:13');

DROP TABLE IF EXISTS `content_group_file_areas`;
CREATE TABLE `content_group_file_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_file_unique_index` (`content_group_id`,`name`),
  KEY `IDX_9DC2122BACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_file_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `content_group_html_areas`;
CREATE TABLE `content_group_html_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `html` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_html_unique_index` (`content_group_id`,`name`),
  KEY `IDX_87B6C2F3ACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_html_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `content_group_html_areas` (`id`, `content_group_id`, `name`, `html`) VALUES
(6,	6,	'content',	'<p>And content of about</p>'),
(9,	1,	'content',	'<p>And this is a big content.</p>\r\n<p>More content can be placed here.</p>\r\n<p>And this is a big content.</p>\r\n<p>More content can be placed here.</p>\r\n<p>&nbsp;</p>\r\n<p>And this is a big content.</p>\r\n<p>More content can be placed here.</p>\r\n<p>&nbsp;</p>\r\n<p>And this is a big content.</p>\r\n<p>More content can be placed here.</p>\r\n<p>&nbsp;</p>\r\n<p>And this is a big content.</p>\r\n<p>More content can be placed here.</p>\r\n<p>&nbsp;</p>\r\n<p>And this is a big content.</p>\r\n<p>More content can be placed here.</p>\r\n<p>&nbsp;</p>');

DROP TABLE IF EXISTS `content_group_image_areas`;
CREATE TABLE `content_group_image_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_text` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_images_unique_index` (`content_group_id`,`name`),
  KEY `IDX_39468675ACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_image_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `content_group_metadata`;
CREATE TABLE `content_group_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_metadata_unique_index` (`content_group_id`,`name`),
  KEY `IDX_2CCF82BFACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_metadata_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `content_group_metadata` (`id`, `content_group_id`, `name`, `value`) VALUES
(11,	6,	'title',	'Meta title'),
(12,	6,	'description',	'Meta description'),
(17,	1,	'title',	'Meta title a'),
(18,	1,	'description',	'and meta description');

DROP TABLE IF EXISTS `content_group_text_areas`;
CREATE TABLE `content_group_text_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_group_id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_group_text_unique_index` (`content_group_id`,`name`),
  KEY `IDX_61F51841ACE333A8` (`content_group_id`),
  CONSTRAINT `fk_content_group_text_areas_content_group_id_content_groups` FOREIGN KEY (`content_group_id`) REFERENCES `content_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `content_group_text_areas` (`id`, `content_group_id`, `name`, `text`) VALUES
(8,	6,	'title',	'About page'),
(13,	1,	'title',	'Hello World');

DROP TABLE IF EXISTS `dms_analytics`;
CREATE TABLE `dms_analytics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `dms_password_resets`;
CREATE TABLE `dms_password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_password_resets_token_unique_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dms_password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(4,	'kthari85@gmail.com',	'$2y$10$0DgrzVEj5g8nRYnZlKOSweg5irR2exqO4qr7LgLQIpe1yDTn0uxoS',	'2017-09-13 11:28:40');

DROP TABLE IF EXISTS `dms_permissions`;
CREATE TABLE `dms_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2B0D74A1D60322AC` (`role_id`),
  CONSTRAINT `fk_dms_permissions_role_id_dms_roles` FOREIGN KEY (`role_id`) REFERENCES `dms_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dms_permissions` (`id`, `role_id`, `name`) VALUES
(1,	1,	'admin.users.view'),
(2,	1,	'documents.files.view'),
(3,	1,	'analytics.config.view');

DROP TABLE IF EXISTS `dms_roles`;
CREATE TABLE `dms_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dms_roles` (`id`, `name`) VALUES
(1,	'Editor');

DROP TABLE IF EXISTS `dms_temp_files`;
CREATE TABLE `dms_temp_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('uploaded-image','uploaded-file','stored-image','in-memory','stored-file') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:CustomEnum__uploaded_image__uploaded_file__stored_image__in_memory__stored_file)',
  `expiry_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_temp_files_token_unique_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `dms_users`;
CREATE TABLE `dms_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('local','oauth') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:CustomEnum__local__oauth)',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_super_user` tinyint(1) NOT NULL,
  `is_banned` tinyint(1) NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_algorithm` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_cost_factor` int(11) DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_provider_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_account_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_users_email_unique_index` (`email`),
  UNIQUE KEY `dms_users_username_unique_index` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dms_users` (`id`, `type`, `full_name`, `email`, `username`, `is_super_user`, `is_banned`, `password_hash`, `password_algorithm`, `password_cost_factor`, `remember_token`, `oauth_provider_name`, `oauth_account_id`) VALUES
(1,	'local',	'Hari KT',	'kthari85@gmail.com',	'admin',	1,	0,	'$2y$10$yORc6P2EGmzoMP5.rri.pucVDk9XQPs.JYQlsMHeZvZ.hkua25CEq',	'bcrypt',	10,	'ZtOF1hDs8BGas0jGcy2YPWm43iMpjsQw3sv8kc61lLFJ7qDgMhzdvYG5PO9s',	NULL,	NULL),
(2,	'local',	'Hari',	'someone@gmail.com',	'harikt',	1,	0,	'$2y$10$o9hNWM/siGp0tOCPzu0BgenF8VfKYfBL7dAkaN49rwQn4qjnGfbYW',	'bcrypt',	10,	'ko6EdolS3w9Kmv3tqWp0sOJiCVWNjCNmA1m0Dy3bZGsWAbjrAu2xbF4Yh0MV',	NULL,	NULL),
(3,	'local',	'Elliot Levin',	'hello@example.com',	'Time_Toogo',	1,	0,	'$2y$10$BLjom0GZh1K8xBT/8T90ZOttlxLyGx/0FiY0R/1S/4YltcKfq6Era',	'bcrypt',	10,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `dms_user_roles`;
CREATE TABLE `dms_user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F104DAD60322AC` (`role_id`),
  KEY `IDX_2F104DAA76ED395` (`user_id`),
  CONSTRAINT `fk_dms_user_roles_role_id_dms_roles` FOREIGN KEY (`role_id`) REFERENCES `dms_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dms_user_roles_user_id_dms_users` FOREIGN KEY (`user_id`) REFERENCES `dms_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dms_user_roles` (`id`, `role_id`, `user_id`) VALUES
(3,	1,	3),
(5,	1,	2);

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2017_07_19_050100_initial_db',	1),
(2,	'2017_07_19_052054_todo-1',	2),
(3,	'2017_08_06_170253_blog',	3),
(4,	'2017_09_14_091536_content',	4),
(5,	'2017_09_14_095013_contact',	5);

DROP TABLE IF EXISTS `todo_items`;
CREATE TABLE `todo_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `todo_items` (`id`, `description`, `completed`) VALUES
(1,	'Hello World',	1),
(2,	'Another world',	1);

-- 2017-09-14 18:41:06

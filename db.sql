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
(1,	'Php',	'php',	1,	'2017-08-06 17:06:09',	'2017-09-13 15:34:25'),
(2,	'Golang',	'golang',	1,	'2017-08-06 17:06:22',	'2017-08-06 17:06:22'),
(3,	'Another',	'another',	1,	'2017-09-13 15:18:41',	'2017-09-13 15:18:41');

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

INSERT INTO `dms_temp_files` (`id`, `token`, `file`, `client_file_name`, `type`, `expiry_time`) VALUES
(1,	'PGqxhU2BfRRXfFygrzCsklT8Ah9p3Dfw0wdgsSo2',	'/home/hari/experiments/php/dms-experiments/storage/dms/temp-uploads/dCQI54Pob6zWKIy5D8PZVPMSRn0uQMnZ',	'Screenshot from 2017-07-18 20-36-07.png',	'stored-image',	'2017-07-19 06:03:23'),
(2,	'wJEcQFHTMQJFIap67Y3YnjAz1i3aZRzLc5PqpBIW',	'/home/hari/experiments/php/dms-experiments/storage/dms/temp-uploads/1pmRzi4AZT3bcKXLCVXlFNBX9eYSAkws',	'Screenshot from 2017-07-18 20-36-07.png',	'stored-image',	'2017-07-19 06:05:26'),
(3,	'zBdBuQFq340gi4i114ZOm1JGl1pnu0kO8KwgsKwP',	'/home/hari/experiments/php/dms-experiments/storage/dms/temp-uploads/jUkXZt7dBOKrFZ6XCss9R1MGNIRiqqJ6',	'Screenshot from 2017-07-18 20-36-07.png',	'stored-image',	'2017-07-19 06:05:42'),
(4,	'6pVuMPaSN0r6DCanby8WtlXkmqbH3zqzMwJZwY38',	'/home/hari/experiments/php/dms-experiments/public/files/Screenshot from 2017-07-18 20-36-07-1.png',	'Screenshot from 2017-07-18 20-36-07-1.png',	'stored-image',	'2017-07-19 06:06:12'),
(5,	'Lfbi2LHubkTz9fpFBlMSo2AGaEmYOhoI7y68faBF',	'/home/hari/experiments/php/dms-experiments/storage/dms/temp-uploads/3iHQFpkIBylaGGGwF32COvDp7Ez7udrS',	'Screenshot from 2017-06-24 11-18-17.png',	'stored-image',	'2017-07-19 06:36:20'),
(6,	'1tZflRa19ELp2n03R7nI9pLEOY6JL01Qxn0QtR8L',	'/home/hari/experiments/php/dms-experiments/storage/dms/temp-uploads/dxQ6CXb1OD2s8ReN0PEZxfZp4Gn72JQZ',	'unnamed.png',	'stored-image',	'2017-08-06 18:07:44'),
(7,	'WF0yqzWxe6YPhjizGozEZc1W2dWUjtw9paDVk1QH',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-08-06 18:07:58'),
(8,	'3UJe3gfvTLETf4htuMgsle3qHnrQnznWVjDShj5c',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:04:19'),
(9,	'PayHkMeYoZrEfbFH7Ga6POkXf8n4kz2mKVDhFUlB',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:06:32'),
(10,	'dDXCkdVAFLyM487btvLrKvAydZ9GzQv8Hj4bzKJp',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:09:31'),
(11,	'fkAiT4Prq5LG2F1LyKei4R6o34DfP0gFr0daNxrD',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:09:33'),
(12,	'9whDCSWkygSJWASuweyVFEy3ZoWZ7uz8hdi4UIfV',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:09:34'),
(13,	'EnVLFb3cPXnOaNtgBWckL4G4TuVPJkGsnFZGA66n',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:10:10'),
(14,	'aDVk706lZkkkWiwpFpbydr15mtHA8yfsH88P4Yzh',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:10:24'),
(15,	'5xOZztUc33CJNmlIATmni1O5cNKH5itbLBXDBlyu',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:10:30'),
(16,	'78VPSzbPNwtrh6KEmRpa7UM1zK6vKJbh26mRCHD9',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:12:02'),
(17,	'6NtKEdSZBmfEBMcqcAuCkPPcOiQlTtpycBqq6huV',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:12:22'),
(18,	'4C1J4Lm2gIJOaWWeLDVweDXKOMWku6gDk6dgIcWJ',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:19:26'),
(19,	'phWKSi26xnDqrbYvWLFH8PIeiwQZwJcjsjq9TPZr',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:19:27'),
(20,	'gDiPUsJuGKjOlVjpan7NNUBR2E1fI3X4FgJzks6X',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:19:28'),
(21,	'SyNc73Hit787hJJpysrZ0bvPzNhe1gDpWDsNJ2az',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:19:29'),
(22,	'nCyNXwZmFJzdzaltTKewkzifFbrS4wetXbzQEIVO',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:19:30'),
(23,	'aRFI7TT6vMTjmnNm1yJkk9N44hjOIXEjhPyiXd9h',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:19:33'),
(24,	'wpbkp6xiusJEdoPOxyQDr3cDDFIwLuZz5NSlyQMi',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:20:36'),
(25,	'FN9E0ZPnxdblUn47iiarhwneqPFluMC3oxSSZVs7',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:20:36'),
(26,	'r2LgRaZDyrTM34xoxuDhKrqRMlVmkuYnhq5130Tl',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:21:42'),
(27,	'pt1X1LkJTuIAJTyNITipccnKrK6uyAfSmUKVLAtz',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:22:25'),
(28,	'quWD8fzf8xg8cGWLsDdl835kDWOnaLRf7QmoczBw',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:01'),
(29,	'8uZuKBLvJG8kgtT7t5diX4p5CvwILJTCtAAYtat0',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:15'),
(30,	'JbWgV37IzRcu1XLGbB40zGsmZlLh1Od8MmYKpLz6',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:39'),
(31,	'qtLFVT7ncDUPOUd8vxVy6wiMXxmY9oyyWEdvcuoj',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:40'),
(32,	'7Id7svy8pISwKpoLCZwH5mXr3re83ddrpwa6sPO7',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:48'),
(33,	'3XGnlsJipAk15XjTuRpc8jrm4hS2w9xfJ2OfKXgy',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:48'),
(34,	'NaczoEkImrWZD0JHlQQT7ZacP4x1Lqz3grjbud9j',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:26:49'),
(35,	'yBQIpZ8SeQTGwcaxs8OxWrBuNvYgLTpxScJFUyLP',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:20'),
(36,	'eTysVBT84vjizs9534oObdGMupoXovN2Aspq9VGX',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:20'),
(37,	'Xc7tnsBrfuQzLgHrSGLIQpzeE7vvjH2OxzEIu34W',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:21'),
(38,	'Uv1lOkTXappIPhqYCAyOB8XsUKYFIlorOMs3xXzi',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:43'),
(39,	'nXl8dOJ8w4e0wZoiN2sMf8Rwb9bPRjWiVq9mtVLs',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:44'),
(40,	'F8z1anvFge2MlizT86iTjYnAgXpXHEclHT8a7Yw6',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:44'),
(41,	'wcjdqC388DchZW2gvJ66oRm60yJCjGaubOAHssmV',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:45'),
(42,	'PnPPw5XWSaXqm3sLtsqyHJtlRl305ZNvwkBQBNnh',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:27:46'),
(43,	'VQwVdiCacnVMHYZzCJVJ8QPdLHtMg3MB9BuAeJxF',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:29:37'),
(44,	'NMCOpFrV2vrl0vGok2lilFCbLP0R8FtX1aZRsjsa',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:29:38'),
(45,	'eAuFWHnAJbuCl9dmtkYCz02QksgRKbJ8RbRwvI5n',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 07:29:39'),
(46,	'ULhO5u6mfNC7bmrVTuNi6X2S78mlep8gYdhXIgHo',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:33:02'),
(47,	'BZchbAXmoov4EDmkKFRB91nj1Wtnp4TIqnXE2bOb',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:35:26'),
(48,	'ZGnx2ezt4t5xz6k1Qhb93uOkMQzp6Uf6eY6etJpV',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:37:49'),
(49,	'5RKNAEbNJ7WpxHIAxxHL0SsDyRBxJVXQX1PUS3wr',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:37:54'),
(50,	'Ru1NoxDmrlzj1BXhImdb7hq4x0hen9tXEl9tGdBO',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:38:41'),
(51,	'IP48ZwGZ3pKT0J8kxQL9jqFAVDrcgeb0oMp64nIr',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:38:50'),
(52,	'YOWFtyO9quVffJSVsTjCOpKDHCufsBEWk1Wqzgyb',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:39:41'),
(53,	'PXqYOnYYcow9jUeqeRZYaFDFVkLyNCBcS4CfRtOG',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:41:52'),
(54,	'2ArYf8VUt2YKKKV5yppfMsEqUFI9rfmRBv2wFpxV',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:43:37'),
(55,	'4nSJMxKIECLEn2bkZupscNrF4OzpnKhUYSRZUF6x',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:44:08'),
(56,	'zXT6a2EAxpfTxjJkkQxrjZtoRhHWTI4YWaqHO0DW',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:44:10'),
(57,	'H8X8aCyWUXDaPB4WJksZ8c5GGQkappRDi70kkmWg',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:44:32'),
(58,	'tpyd2E5Ff44VrSjfvSEGvLZnryqBDHarOtS5L2bo',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:44:39'),
(59,	'ZrjyOnkhOcEgYJNxyoMfsuxa1l5qcWLn2kio7zdh',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:46:50'),
(60,	'9YNksymKdgBBjlkW7p1WFowOQBx5nQs61q9UGKgZ',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:50:28'),
(61,	'SQCrAncyanvP8f9T3xJHh7QosnO9JH15jx8gBGEE',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 10:56:04'),
(62,	'6yqnx5jhdJn89oEhFs2jDDs3ztHM19WP2ggqepxo',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:00:50'),
(63,	'R5JsyK6Tzm8YbexriCcgxBaLvJ2dMLgDptcXyhmv',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:01:02'),
(64,	'jVdaJ2HmRmKFwUehozWJ9B3z5y8VHek7h8GhLt3v',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:01:10'),
(65,	'5LidmeHwSHErTKmeh0D8uzvFo4IlR31uc4UknznX',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:01:38'),
(66,	'CgE3KWi2MOWp2H9N2tjJ6E10IPAFcpYdm5324Kdy',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:02:19'),
(67,	'HnIEGCqbhY3DK0fLHGsMMX2TXEq8BedUtWgTcZaL',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:02:46'),
(68,	'zDojua30TYpTz7FJinwU8z0L7EDojOXmDr4CkAp3',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:24:34'),
(69,	'kgAkmoJEQMURlbAmkIJups9aQrtqg6L6290urIfp',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:25:45'),
(70,	'tj9YtTxRKDoRpnBZcARoXrAQZgidKgwJ0MX50xbA',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:25:49'),
(71,	'f4WqoX4DHNUgJQFZYRb5vTMKfTX5RcHu7CVRMjMy',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:26:18'),
(72,	'GYauA7YWZWompouMciGQamo63XWAPDj1Sa5mO25S',	'/home/hari/experiments/php/dms-expressive-integration/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:26:30'),
(73,	'kLoMbzXGFmXdc4ePV3yaxDxlI9tPRUeCNQooZb7S',	'/home/hari/experiments/php/dms-experiments/public/app/images/blog/ddDW4k7fZ3p0e675',	'unnamed.png',	'stored-image',	'2017-09-12 11:27:04'),
(74,	'QlcFYtarEYXkiErBZbZ4QqW86Eq4szyyL0sVq8vQ',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/VewYkW8HoxxZ5mD1paA9bz3xv9v8MAbb',	'unnamed.png',	'stored-image',	'2017-09-12 11:46:24'),
(75,	'fRDnHnFI5teKw2xiohfcg1hfXqi7t7RhFTo0ZLXY',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/TMbZub7Nhcc9ug2ow28AjFtp9XPYLoUn',	'unnamed.png',	'stored-image',	'2017-09-12 11:47:12'),
(76,	'ASuosjRfMZ198CH3WNU2jykBUKAk2PUgxqFkqyNK',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/IcIrFSIEHiLzqpPUzfhvGuhetGJulKEk',	'unnamed.png',	'stored-image',	'2017-09-12 11:47:27'),
(77,	'PWdHAJhGvCbtUma8bfhjOnLSnkoyFKB7UTJCpLxK',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/Y0T2HTPS3EReSs6peVOqGXD4ytOchHLw',	'unnamed.png',	'stored-image',	'2017-09-12 19:45:19'),
(78,	'OnmQUNh1xpw7fqhTyQkdajUuc5S2VXNF1nQV0hDI',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/6cdpvzhS1kAS9F1UjwDHT9JvhFcOuloy',	'Henke.jpg',	'stored-image',	'2017-09-13 07:24:29'),
(79,	'1qqiJqpPsRRE8kqqGObCF1vJ2YjkkkaqKMhPaGVv',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/6sZesxpglwlOa1OntMrIYCHSuWbfQf0v',	'medium_animals-beautiful-sweet-funny-cute-cats-picture-hd-wallpaper.jpg',	'stored-image',	'2017-09-13 07:24:29'),
(80,	'z0hdOihTDQBQWHL8vdf1tumrHGc4i0DsjEqj9ZBV',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/IF8h6q1CqSS3wjk05duWGA2DhDdRls5p',	'OIo.jpg',	'stored-image',	'2017-09-13 07:24:29'),
(81,	'pS485Bm6jZwiD2km8UhTfJBffXHFG9Tq7g56E4hj',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/AFbeuZOUha9WIydyYeT4gIm0ckYbSBbj',	'OIo-sm.jpg',	'stored-image',	'2017-09-13 07:24:29'),
(82,	'VLfvJFlLpSnMCrzXtx0qDtHFa4VBIaovyldFAQBs',	'/home/hari/experiments/php/dms-expressive-integration/dms-web/config/Ds3W5LTzm875JV1Mpucm1dc2L7NIbqdw',	'unnamed.png',	'stored-image',	'2017-09-13 07:24:29'),
(83,	'pqUFiIbJDDwMDSzUDls7BCUGzMEgTL2iFsKITTrg',	'/home/hari/experiments/php/dms-expressive-integration/web.expressive/config/DqYZRam2TGKfEYohBu4PQ6y9rJxlaPWD',	'OIo.jpg',	'stored-image',	'2017-09-13 16:34:33'),
(84,	'SHcPUMjLiMvS2yDMMKZYnEhQ4gRKzr5S5kUOp4lt',	'/home/hari/experiments/php/dms-expressive-integration/data/cache/dms/temp-uploads/OVxB5x84rCuNtaTCML1UxRzYi27T37XO',	'medium_animals-beautiful-sweet-funny-cute-cats-picture-hd-wallpaper.jpg',	'stored-image',	'2017-09-13 16:41:15');

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
(1,	'local',	'Admin',	'admin@admin.com',	'admin',	1,	0,	'$2y$10$yORc6P2EGmzoMP5.rri.pucVDk9XQPs.JYQlsMHeZvZ.hkua25CEq',	'bcrypt',	10,	'vVRZ95ieIiCXB2cY71fNSM6NuRPjmNqNuDgPiKgzlBoQyYhdm2y8OduWtyAa',	NULL,	NULL),
(2,	'local',	'Hari KT',	'kthari85@gmail.com',	'harikt',	1,	0,	'$2y$10$o9hNWM/siGp0tOCPzu0BgenF8VfKYfBL7dAkaN49rwQn4qjnGfbYW',	'bcrypt',	10,	'ko6EdolS3w9Kmv3tqWp0sOJiCVWNjCNmA1m0Dy3bZGsWAbjrAu2xbF4Yh0MV',	NULL,	NULL),
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
(2,	1,	2),
(3,	1,	3);

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
(3,	'2017_08_06_170253_blog',	3);

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

-- 2017-09-13 15:45:50

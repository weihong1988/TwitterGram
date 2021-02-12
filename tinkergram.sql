-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 12, 2021 at 09:41 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinkergram`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `followers_user_id_friend_id_unique` (`user_id`,`friend_id`),
  KEY `followers_friend_id_foreign` (`friend_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `friend_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2021-02-12 01:37:29', '2021-02-12 01:37:29'),
(3, 1, 2, '2021-02-12 01:38:32', '2021-02-12 01:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keywords_user_id_foreign` (`user_id`),
  KEY `keywords_post_id_foreign` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`id`, `user_id`, `post_id`, `keyword`, `score`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'partner loving', 4, '2021-02-12 01:31:46', '2021-02-12 01:31:46'),
(2, 4, 1, 'fluffy dogs', 4, '2021-02-12 01:31:46', '2021-02-12 01:31:46'),
(3, 4, 1, 'dogs', 2, '2021-02-12 01:31:46', '2021-02-12 01:31:46'),
(4, 4, 2, 'dogs hanging', 4, '2021-02-12 01:32:09', '2021-02-12 01:32:09'),
(5, 4, 2, 'mother', 1, '2021-02-12 01:32:09', '2021-02-12 01:32:09'),
(6, 4, 2, 'sister', 1, '2021-02-12 01:32:09', '2021-02-12 01:32:09'),
(7, 4, 2, 'family', 1, '2021-02-12 01:32:09', '2021-02-12 01:32:09'),
(8, 1, 3, 'firm fluffy buns', 9, '2021-02-12 01:33:06', '2021-02-12 01:33:06'),
(9, 1, 3, 'box', 1, '2021-02-12 01:33:06', '2021-02-12 01:33:06'),
(10, 1, 4, 'floppy ears bun bun', 14, '2021-02-12 01:33:29', '2021-02-12 01:33:29'),
(11, 1, 4, 'bun bun', 6, '2021-02-12 01:33:29', '2021-02-12 01:33:29'),
(12, 1, 4, 'white', 1, '2021-02-12 01:33:29', '2021-02-12 01:33:29'),
(13, 1, 4, 'sleepy', 1, '2021-02-12 01:33:29', '2021-02-12 01:33:29'),
(14, 1, 5, 'young bun', 3, '2021-02-12 01:33:50', '2021-02-12 01:33:50'),
(15, 1, 5, 'bun', 2, '2021-02-12 01:33:50', '2021-02-12 01:33:50'),
(16, 1, 5, 'young', 2, '2021-02-12 01:33:50', '2021-02-12 01:33:50'),
(17, 1, 5, 'friendly', 1, '2021-02-12 01:33:50', '2021-02-12 01:33:50'),
(18, 2, 6, 'pretty hot chicks', 8, '2021-02-12 01:34:59', '2021-02-12 01:34:59'),
(19, 2, 6, 'hot chicks', 5, '2021-02-12 01:34:59', '2021-02-12 01:34:59'),
(20, 2, 6, 'group', 1, '2021-02-12 01:34:59', '2021-02-12 01:34:59'),
(21, 2, 7, 'hot chick standing', 8, '2021-02-12 01:35:19', '2021-02-12 01:35:19'),
(22, 2, 7, 'hot chick', 5, '2021-02-12 01:35:19', '2021-02-12 01:35:19'),
(23, 2, 7, 'perfect', 1, '2021-02-12 01:35:19', '2021-02-12 01:35:19'),
(24, 2, 7, 'middle', 1, '2021-02-12 01:35:19', '2021-02-12 01:35:19'),
(25, 3, 8, 'white young pussy', 8, '2021-02-12 01:36:00', '2021-02-12 01:36:00'),
(26, 3, 8, 'specimen found', 4, '2021-02-12 01:36:00', '2021-02-12 01:36:00'),
(27, 3, 8, 'pussy', 2, '2021-02-12 01:36:00', '2021-02-12 01:36:00'),
(28, 3, 9, 'friendly pussy', 4, '2021-02-12 01:36:19', '2021-02-12 01:36:19'),
(29, 3, 9, 'pussy', 2, '2021-02-12 01:36:19', '2021-02-12 01:36:19'),
(30, 3, 9, 'bed', 1, '2021-02-12 01:36:19', '2021-02-12 01:36:19'),
(31, 3, 10, 'shy pussy', 3, '2021-02-12 01:36:37', '2021-02-12 01:36:37'),
(32, 3, 10, 'pussy', 2, '2021-02-12 01:36:37', '2021-02-12 01:36:37'),
(33, 3, 10, 'shy', 2, '2021-02-12 01:36:37', '2021-02-12 01:36:37'),
(34, 3, 10, 'young', 1, '2021-02-12 01:36:37', '2021-02-12 01:36:37'),
(35, 3, 11, 'elderly pussy', 4, '2021-02-12 01:36:54', '2021-02-12 01:36:54'),
(36, 3, 11, 'dark', 1, '2021-02-12 01:36:54', '2021-02-12 01:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_12_18_141340_create_profiles_table', 1),
(5, '2020_12_19_060908_create_posts_table', 1),
(6, '2020_12_25_182920_create_ratings_table', 1),
(7, '2021_01_29_132737_create_followers_table', 1),
(8, '2021_01_29_132920_create_keywords_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tweettitle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tweetcontent` text COLLATE utf8mb4_unicode_ci,
  `tweetimage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `tweettitle`, `tweetcontent`, `tweetimage`, `created_at`, `updated_at`) VALUES
(1, 4, 'Fluffy dogs', 'Dogs as a partner loving each other', 'uploads/FKn38OTjBLNWCXVkUvqKDC3dDdQoESCpg4jtz31u.jpg', '2021-02-12 01:31:46', '2021-02-12 01:31:46'),
(2, 4, 'Mother and sister', 'A family of dogs hanging out together', 'uploads/s17x27JqCDzlFTHSbdEtmsR227WwxK8YxXgn9gyZ.jpg', '2021-02-12 01:32:09', '2021-02-12 01:32:09'),
(3, 1, 'Two firm fluffy buns', 'In a box', 'uploads/8hwEaMtcPdzKlSqMP2EI91OpbzwZGkoFGkYoCnLD.jpg', '2021-02-12 01:33:06', '2021-02-12 01:33:06'),
(4, 1, 'Floppy ears bun bun', 'This bun bun is white and sleepy', 'uploads/b9awelYBdUi78ygSgk7WZ15DR1DrdcD6RiM2wpLb.jpg', '2021-02-12 01:33:29', '2021-02-12 01:33:29'),
(5, 1, 'Young bun', 'This bun is young and friendly hearted', 'uploads/yjeQ6VNZA0Stz0DvneQIO4p0eIWg1ddwonLKpl9J.jpg', '2021-02-12 01:33:50', '2021-02-12 01:37:49'),
(6, 2, 'A group of hot chicks', 'Pretty hot chicks in a group', 'uploads/bad60TIoxSlBJh1csvC2q2QlApst93MKxRAj9cu6.jpg', '2021-02-12 01:34:59', '2021-02-12 01:34:59'),
(7, 2, 'Perfect looking hot chick', 'Hot chick standing in the middle', 'uploads/vryOAceOUasYnbauDGh1Db8fEhSgD9l2r8kqHqUs.jpg', '2021-02-12 01:35:19', '2021-02-12 01:35:19'),
(8, 3, 'White young pussy', 'This pussy is the best specimen found', 'uploads/9yaM8QZdA8UzxJKfvJ68igvyoPw1GrUEnJzMip4K.png', '2021-02-12 01:36:00', '2021-02-12 01:36:00'),
(9, 3, 'Friendly pussy on bed', 'Pussy is on bed', 'uploads/of1H6U5YSqvE7fJI6JWK9hcLZiUlTAcsSDaRBd3N.jpg', '2021-02-12 01:36:19', '2021-02-12 01:36:19'),
(10, 3, 'Shy pussy', 'This pussy is young and shy', 'uploads/VYNF6zgkI8jkiq611FjpZ7F58lTlsBSk0Q0x0sOr.jpg', '2021-02-12 01:36:37', '2021-02-12 01:36:37'),
(11, 3, 'Old elderly pussy', 'Looks quite old and dark', 'uploads/ZJJ03pkeI5cCb3uY7IKyCZ3uvDx77wPquuHz4hQh.jpg', '2021-02-12 01:36:53', '2021-02-12 01:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `description`, `image`, `isadmin`, `created_at`, `updated_at`) VALUES
(1, 1, 'I love rabbits', 'uploads/zvUpr5N7VNemI2CpLK7D5CLQzfsAxMiNcVn2F8Ub.jpg', 0, '2021-02-12 01:22:37', '2021-02-12 01:22:37'),
(2, 2, 'I am very cute', 'uploads/PPQDpuiHpTQrV8W8hDEUYAc7X1rFsMMRZv0Wx5yb.jpg', 0, '2021-02-12 01:29:31', '2021-02-12 01:29:31'),
(3, 3, 'I love cats', 'uploads/iVEn7zKPd3Lw39E9HLRvhPn0tXEgJLbhBVSow4M0.jpg', 0, '2021-02-12 01:30:15', '2021-02-12 01:30:15'),
(4, 4, 'I love dogs', 'uploads/uiqzGrfjQvfcMRZXZF1zStS9LItl17aEvEaHTrKI.jpg', 0, '2021-02-12 01:31:09', '2021-02-12 01:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `rating` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_post_id_foreign` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `post_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 4, '2021-02-12 01:32:15', '2021-02-12 01:32:15'),
(2, 4, 1, 3, '2021-02-12 01:32:16', '2021-02-12 01:32:16'),
(3, 1, 11, 3, '2021-02-12 01:40:31', '2021-02-12 01:40:31'),
(4, 1, 10, 4, '2021-02-12 01:40:36', '2021-02-12 01:40:36'),
(5, 1, 9, 3, '2021-02-12 01:40:41', '2021-02-12 01:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RabbitLover', 'user1@gmail.com', NULL, '$2y$10$OOvY./6KaYpZ6RniisXtnu8QR76u/qXK6x3c4.pOt15hNH4D2WwHS', NULL, '2021-02-12 01:22:22', '2021-02-12 01:22:22'),
(2, 'Hot Chick', 'user2@gmail.com', NULL, '$2y$10$XPtE196UobmxmzY54FAhS.092y8T.cps/iMMeJtS18ZWoXuMlO/2q', NULL, '2021-02-12 01:28:32', '2021-02-12 01:28:32'),
(3, 'CatLover', 'user3@gmail.com', NULL, '$2y$10$EhWvjxxpXaVjCNAZo1Kr9O8uEiTDcDNrnstym5oUI/AxZI/Fqvsdm', NULL, '2021-02-12 01:29:59', '2021-02-12 01:29:59'),
(4, 'DogLover', 'user4@gmail.com', NULL, '$2y$10$DSOlV21XdQ9nLPhxZcb6m.eljAwaDS.NA/CKSwrjUee2eCFOCUJmq', NULL, '2021-02-12 01:30:56', '2021-02-12 01:30:56');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

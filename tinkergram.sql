-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 31, 2021 at 01:50 AM
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
(2, 4, 1, '2021-01-30 01:26:48', '2021-01-30 01:26:48'),
(3, 4, 2, '2021-01-30 01:26:49', '2021-01-30 01:26:49');

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`id`, `user_id`, `post_id`, `keyword`, `score`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'hot chick', 4, '2021-01-30 01:03:56', '2021-01-30 01:03:56'),
(2, 1, 1, 'super cute chick', 9, '2021-01-30 01:03:56', '2021-01-30 01:03:56'),
(3, 1, 1, 'short skirt', 4, '2021-01-30 01:03:56', '2021-01-30 01:03:56'),
(4, 1, 1, 'hot pants', 4, '2021-01-30 01:03:56', '2021-01-30 01:03:56'),
(5, 1, 1, 'wear', 1, '2021-01-30 01:03:56', '2021-01-30 01:03:56'),
(6, 1, 2, 'mature chick', 4, '2021-01-30 01:04:31', '2021-01-30 01:04:31'),
(7, 1, 2, 'long legs chick', 9, '2021-01-30 01:04:31', '2021-01-30 01:04:31'),
(8, 1, 2, 'people find', 4, '2021-01-30 01:04:31', '2021-01-30 01:04:31'),
(9, 1, 2, 'interesting', 1, '2021-01-30 01:04:31', '2021-01-30 01:04:31'),
(10, 2, 3, 'cute pussy', 4, '2021-01-30 01:05:53', '2021-01-30 01:05:53'),
(11, 2, 3, 'cute cat pussy', 9, '2021-01-30 01:05:53', '2021-01-30 01:05:53'),
(12, 2, 4, 'wet cat', 4, '2021-01-30 01:07:01', '2021-01-30 01:07:01'),
(13, 2, 4, 'hot', 1, '2021-01-30 01:07:01', '2021-01-30 01:07:01'),
(14, 2, 4, 'wet cat', 4, '2021-01-30 01:07:01', '2021-01-30 01:07:01'),
(15, 2, 4, 'hot', 1, '2021-01-30 01:07:01', '2021-01-30 01:07:01'),
(16, 3, 5, 'cute cuddley buns', 9, '2021-01-30 01:08:26', '2021-01-30 01:08:26'),
(17, 3, 5, 'cute cuddley buns', 9, '2021-01-30 01:08:26', '2021-01-30 01:08:26'),
(18, 3, 6, 'hot fluffy buns', 9, '2021-01-30 01:08:50', '2021-01-30 01:08:50'),
(19, 3, 6, 'hot fluffy buns', 9, '2021-01-30 01:08:50', '2021-01-30 01:08:50'),
(20, 4, 7, 'world', 1, '2021-01-30 01:11:07', '2021-01-30 01:11:07'),
(21, 4, 7, 'lonely', 1, '2021-01-30 01:11:07', '2021-01-30 01:11:07');

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2014_10_12_000000_create_users_table', 1),
(16, '2014_10_12_100000_create_password_resets_table', 1),
(17, '2019_08_19_000000_create_failed_jobs_table', 1),
(18, '2020_12_18_141340_create_profiles_table', 1),
(19, '2020_12_19_060908_create_posts_table', 1),
(20, '2020_12_25_182920_create_ratings_table', 1),
(21, '2021_01_29_132737_create_followers_table', 1),
(22, '2021_01_29_132920_create_keywords_table', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `tweettitle`, `tweetcontent`, `tweetimage`, `created_at`, `updated_at`) VALUES
(1, 1, 'I am a hot chick', 'Super cute chick. I wear a short skirt and hot pants', 'uploads/TqfXAFa5uEY4Bu53YlKIRiqD1olnuAjzkQsg8boe.jpg', '2021-01-30 01:03:56', '2021-01-30 01:03:56'),
(2, 1, 'Mature chick', 'Long legs chick. Many people find it interesting.', 'uploads/veOZAkX6IQ9iu5nMivVuzDDdP7qwrRrs93oEV6ue.jpg', '2021-01-30 01:04:31', '2021-01-30 01:04:31'),
(3, 2, 'Cute pussy', 'Very cute cat pussy', 'uploads/iFx8uSCTwvN8FniF43G8ckmVx8fLYavUUYy5WYeu.jpg', '2021-01-30 01:05:53', '2021-01-30 01:05:53'),
(4, 2, 'Hot and wet cat', 'Hot and wet cat', 'uploads/gPrEbdK1BO137UYhEsLEtOIlLuGVoms6yzJqhNBb.jpg', '2021-01-30 01:07:01', '2021-01-30 01:07:01'),
(5, 3, 'Cute cuddley buns', 'Cute cuddley buns', 'uploads/0bvjMiHgmSCi3j8TSUfHe4WNICGBgPIce3yjwALS.jpg', '2021-01-30 01:08:26', '2021-01-30 01:08:26'),
(6, 3, 'Hot fluffy buns', 'Hot fluffy buns', 'uploads/Ex2nNnPD2VgXtL5IV7TApbBwGxK9uRkwTa01j6Do.jpg', '2021-01-30 01:08:50', '2021-01-30 01:08:50');

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
(1, 1, 'I am very cute', 'uploads/G83VBeRcErhLxSh3janX0RTfWkky4lmbIYzGlk2I.jpg', 0, '2021-01-30 01:03:12', '2021-01-30 01:03:12'),
(2, 2, 'I love cats', 'uploads/IeFr458jUKhsLWSCc2eJ8LaiMRXuiBZRTfaDWFA9.png', 0, '2021-01-30 01:05:34', '2021-01-30 01:05:34'),
(3, 3, 'I love rabbits', 'uploads/1W5x5LBakGx2AdCWsfhvU3Z125K7gFsfnW1q6bef.jpg', 0, '2021-01-30 01:08:09', '2021-01-30 01:08:09'),
(4, 4, 'I love dogs', 'uploads/pa66st2olp09ogVD6rTkXT93mJriuMv0W5WzXsBj.jpg', 0, '2021-01-30 01:10:48', '2021-01-30 01:10:48');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `post_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, '2021-01-30 01:04:00', '2021-01-30 01:04:00'),
(2, 2, 3, 4, '2021-01-30 01:06:04', '2021-01-30 01:06:04'),
(3, 2, 4, 4, '2021-01-30 01:07:04', '2021-01-30 01:07:04'),
(4, 3, 5, 4, '2021-01-30 01:08:28', '2021-01-30 01:08:29'),
(5, 3, 6, 5, '2021-01-30 01:08:52', '2021-01-30 01:08:52'),
(6, 4, 7, 4, '2021-01-30 01:12:12', '2021-01-30 01:12:12');

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
(1, 'Hot chick', 'user1@gmail.com', NULL, '$2y$10$51G8qk3m3Vq/7sf2BfqVzuoFdh8/g9cqjAbcAuIIhihx7iP/ZzpZe', NULL, '2021-01-30 01:02:52', '2021-01-30 01:02:52'),
(2, 'CatLover', 'user2@gmail.com', NULL, '$2y$10$QYjFahwpVURv7qaTgAKi0Ou/mj8pvByYE6EbZI.reo7B3qR.sevlu', NULL, '2021-01-30 01:05:06', '2021-01-30 01:05:06'),
(3, 'RabbitLover', 'user3@gmail.com', NULL, '$2y$10$mFUw8Afw4kXdw4iv3gT5euSt66SSFcmbjuvelT1HlY1mt/FJ539oW', NULL, '2021-01-30 01:07:52', '2021-01-30 01:07:52'),
(4, 'DogLover', 'user4@gmail.com', NULL, '$2y$10$pLeIWogXJATCHKPoR3gCMuUq9hnu9lRUWmh4hug4RY3yk9pMW/1c2', NULL, '2021-01-30 01:10:33', '2021-01-30 01:10:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

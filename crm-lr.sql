-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 17, 2025 at 11:19 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm-lr`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_merged` tinyint(1) NOT NULL DEFAULT '0',
  `merged_into_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `gender`, `profile_image`, `additional_file`, `is_merged`, `merged_into_id`, `user_id`, `created_at`, `updated_at`) VALUES
(19, 'kiran', 'tankkiran.itn@gmail.com', '09104519340', 'male', NULL, NULL, 0, NULL, 1, '2025-07-17 04:39:03', '2025-07-17 04:55:54'),
(21, 'Hina', 'hin@gmail.com', '09104519340', NULL, 'profile_images/I2gG3Dq2czWPmIjDv2NCMEDchaqe4jEq5194bcw0.jpg', NULL, 1, 19, 1, '2025-07-17 04:54:57', '2025-07-17 04:55:54'),
(24, 'admin', 'admindata@gmail.com', '2232232122', 'other', 'profile_images/8U6qaUnSqLwfh3xNdq97vEnDZxHV8n4qMPXOw65T.png', NULL, 0, NULL, 1, '2025-07-17 05:48:34', '2025-07-17 05:48:34'),
(14, 'Test user', 'test@example.com', '9978998789', 'other', 'profile_images/QIzUvwhsb3w3q9w1NuLBEn2JXvykujy9e0ubaSju.jpg', NULL, 1, 21, 1, '2025-07-17 04:02:01', '2025-07-17 04:55:36'),
(23, 'Nikunj', 'Nikun@gmail.com', '08849090190', 'male', NULL, NULL, 1, 19, 1, '2025-07-17 05:47:25', '2025-07-17 05:48:51');

-- --------------------------------------------------------

--
-- Table structure for table `contact_custom_field_values`
--

DROP TABLE IF EXISTS `contact_custom_field_values`;
CREATE TABLE IF NOT EXISTS `contact_custom_field_values` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contact_id` bigint UNSIGNED NOT NULL,
  `custom_field_id` bigint UNSIGNED NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_custom_field_values_contact_id_foreign` (`contact_id`),
  KEY `contact_custom_field_values_custom_field_id_foreign` (`custom_field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_custom_field_values`
--

INSERT INTO `contact_custom_field_values` (`id`, `contact_id`, `custom_field_id`, `value`, `created_at`, `updated_at`) VALUES
(57, 23, 6, NULL, '2025-07-17 05:47:25', '2025-07-17 05:47:25'),
(56, 23, 3, 'B2 - 103, Global City, Sayan Road, Amroli Surat', '2025-07-17 05:47:25', '2025-07-17 05:47:32'),
(55, 23, 2, NULL, '2025-07-17 05:47:25', '2025-07-17 05:47:25'),
(54, 23, 1, NULL, '2025-07-17 05:47:25', '2025-07-17 05:47:25'),
(53, 22, 3, NULL, '2025-07-17 05:19:57', '2025-07-17 05:19:57'),
(52, 22, 2, NULL, '2025-07-17 05:19:57', '2025-07-17 05:19:57'),
(51, 22, 1, NULL, '2025-07-17 05:19:57', '2025-07-17 05:19:57'),
(50, 21, 3, 'shree ganesh 6, gokul park, kothariya main road, rajkot', '2025-07-17 04:54:57', '2025-07-17 04:54:57'),
(49, 21, 2, NULL, '2025-07-17 04:54:57', '2025-07-17 04:54:57'),
(48, 21, 1, NULL, '2025-07-17 04:54:57', '2025-07-17 04:54:57'),
(47, 20, 3, 'rajkot - 5', '2025-07-17 04:50:17', '2025-07-17 04:50:17'),
(46, 20, 2, NULL, '2025-07-17 04:50:17', '2025-07-17 04:50:17'),
(45, 20, 1, NULL, '2025-07-17 04:50:17', '2025-07-17 04:50:17'),
(44, 19, 3, 'B2 - 103, Global City, Sayan Road, Amroli Surat', '2025-07-17 04:39:03', '2025-07-17 05:48:51'),
(43, 19, 2, NULL, '2025-07-17 04:39:03', '2025-07-17 04:39:03'),
(41, 14, 3, 'rajkot - 5', '2025-07-17 04:36:12', '2025-07-17 04:36:12'),
(42, 19, 1, NULL, '2025-07-17 04:39:03', '2025-07-17 04:39:03'),
(40, 18, 3, 'rajkot - 5', '2025-07-17 04:35:46', '2025-07-17 04:35:46'),
(39, 18, 2, NULL, '2025-07-17 04:35:46', '2025-07-17 04:35:46'),
(26, 14, 1, NULL, '2025-07-17 04:02:01', '2025-07-17 04:02:01'),
(27, 14, 2, NULL, '2025-07-17 04:02:01', '2025-07-17 04:02:01'),
(38, 18, 1, NULL, '2025-07-17 04:35:46', '2025-07-17 04:35:46'),
(29, 15, 1, NULL, '2025-07-17 04:12:18', '2025-07-17 04:12:18'),
(30, 15, 2, NULL, '2025-07-17 04:12:18', '2025-07-17 04:12:18'),
(31, 15, 3, 'rajkot - 5', '2025-07-17 04:12:18', '2025-07-17 04:12:18'),
(32, 16, 1, NULL, '2025-07-17 04:13:33', '2025-07-17 04:13:33'),
(33, 16, 2, NULL, '2025-07-17 04:13:33', '2025-07-17 04:13:33'),
(34, 16, 3, 'rajkot - 5', '2025-07-17 04:13:33', '2025-07-17 04:13:33'),
(35, 17, 1, NULL, '2025-07-17 04:14:16', '2025-07-17 04:14:16'),
(36, 17, 2, NULL, '2025-07-17 04:14:16', '2025-07-17 04:14:16'),
(37, 17, 3, 'rajkot - 5', '2025-07-17 04:14:16', '2025-07-17 04:20:50'),
(58, 24, 1, NULL, '2025-07-17 05:48:34', '2025-07-17 05:48:34'),
(59, 24, 2, NULL, '2025-07-17 05:48:34', '2025-07-17 05:48:34'),
(60, 24, 3, NULL, '2025-07-17 05:48:34', '2025-07-17 05:48:34'),
(61, 24, 6, NULL, '2025-07-17 05:48:34', '2025-07-17 05:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `contact_merges`
--

DROP TABLE IF EXISTS `contact_merges`;
CREATE TABLE IF NOT EXISTS `contact_merges` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `master_contact_id` bigint UNSIGNED NOT NULL,
  `merged_contact_id` bigint UNSIGNED NOT NULL,
  `merged_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_merges_master_contact_id_foreign` (`master_contact_id`),
  KEY `contact_merges_merged_contact_id_foreign` (`merged_contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_merges`
--

INSERT INTO `contact_merges` (`id`, `master_contact_id`, `merged_contact_id`, `merged_data`, `created_at`, `updated_at`) VALUES
(10, 19, 23, '{\"old_master\": {\"id\": 19, \"name\": \"kiran\", \"email\": \"tankkiran.itn@gmail.com\", \"phone\": \"09104519340\", \"gender\": \"male\", \"user_id\": 1, \"is_merged\": 0, \"created_at\": \"2025-07-17T10:09:03.000000Z\", \"updated_at\": \"2025-07-17T10:25:54.000000Z\", \"profile_image\": null, \"merged_into_id\": null, \"additional_file\": null}, \"old_secondary\": {\"id\": 23, \"name\": \"Nikunj\", \"email\": \"Nikun@gmail.com\", \"phone\": \"08849090190\", \"gender\": \"male\", \"user_id\": 1, \"is_merged\": 0, \"created_at\": \"2025-07-17T11:17:25.000000Z\", \"updated_at\": \"2025-07-17T11:17:32.000000Z\", \"profile_image\": null, \"merged_into_id\": null, \"additional_file\": null}, \"selected_fields\": {\"name\": \"kiran\", \"email\": \"tankkiran.itn@gmail.com\", \"phone\": \"09104519340\", \"gender\": \"male\"}, \"selected_custom_fields\": {\"3\": \"B2 - 103, Global City, Sayan Road, Amroli Surat\"}}', '2025-07-17 05:48:51', '2025-07-17 05:48:51'),
(8, 21, 14, '{\"old_master\": {\"id\": 21, \"name\": \"Hina\", \"email\": \"hin@gmail.com\", \"phone\": \"09104519340\", \"gender\": null, \"user_id\": 1, \"is_merged\": 0, \"created_at\": \"2025-07-17T10:24:57.000000Z\", \"updated_at\": \"2025-07-17T10:24:57.000000Z\", \"profile_image\": \"profile_images/I2gG3Dq2czWPmIjDv2NCMEDchaqe4jEq5194bcw0.jpg\", \"merged_into_id\": null, \"additional_file\": null}, \"old_secondary\": {\"id\": 14, \"name\": \"Test user\", \"email\": \"test@example.com\", \"phone\": \"9978998789\", \"gender\": \"other\", \"user_id\": 1, \"is_merged\": 1, \"created_at\": \"2025-07-17T09:32:01.000000Z\", \"updated_at\": \"2025-07-17T09:43:00.000000Z\", \"profile_image\": \"profile_images/QIzUvwhsb3w3q9w1NuLBEn2JXvykujy9e0ubaSju.jpg\", \"merged_into_id\": 15, \"additional_file\": null}, \"selected_fields\": {\"name\": \"Hina\", \"email\": \"hin@gmail.com\", \"phone\": \"09104519340\", \"gender\": null}, \"selected_custom_fields\": {\"3\": \"shree ganesh 6, gokul park, kothariya main road, rajkot\"}}', '2025-07-17 04:55:36', '2025-07-17 04:55:36'),
(9, 19, 21, '{\"old_master\": {\"id\": 19, \"name\": \"kiran\", \"email\": \"tankkiran.itn@gmail.com\", \"phone\": null, \"gender\": \"male\", \"user_id\": 1, \"is_merged\": 0, \"created_at\": \"2025-07-17T10:09:03.000000Z\", \"updated_at\": \"2025-07-17T10:09:03.000000Z\", \"profile_image\": null, \"merged_into_id\": null, \"additional_file\": null}, \"old_secondary\": {\"id\": 21, \"name\": \"Hina\", \"email\": \"hin@gmail.com\", \"phone\": \"09104519340\", \"gender\": null, \"user_id\": 1, \"is_merged\": 0, \"created_at\": \"2025-07-17T10:24:57.000000Z\", \"updated_at\": \"2025-07-17T10:24:57.000000Z\", \"profile_image\": \"profile_images/I2gG3Dq2czWPmIjDv2NCMEDchaqe4jEq5194bcw0.jpg\", \"merged_into_id\": null, \"additional_file\": null}, \"selected_fields\": {\"name\": \"kiran\", \"email\": \"tankkiran.itn@gmail.com\", \"phone\": \"09104519340\", \"gender\": \"male\"}, \"selected_custom_fields\": {\"3\": \"shree ganesh 6, gokul park, kothariya main road, rajkot\"}}', '2025-07-17 04:55:54', '2025-07-17 04:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Birthday', 'date', '2025-07-16 09:41:16', '2025-07-16 09:41:16'),
(2, 'Company Name', 'text', '2025-07-16 09:41:16', '2025-07-16 09:41:16'),
(3, 'Address', 'text', '2025-07-16 09:41:16', '2025-07-16 09:41:16'),
(6, 'test1', 'text', '2025-07-17 05:46:55', '2025-07-17 05:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
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
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_16_054902_create_contacts_table', 2),
(5, '2025_07_16_054912_create_custom_fields_table', 2),
(6, '2025_07_16_054917_create_contact_custom_field_values_table', 2),
(7, '2025_07_16_054923_create_contact_merges_table', 2),
(8, '2023_01_01_000000_create_contacts_table', 3),
(9, '2025_07_17_091311_add_user_id_to_contacts_table', 3),
(10, '2025_07_17_111403_add_is_admin_to_users_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('yecuOKLSZfUv795fzIL1bYHXAz9v4lVO2Ry4dFqJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoid0NPNmc0R1NhZlVUZHEyVzkzRjFRQjRZM0pOYkhVdEhxTW9SdUZEQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY29udGFjdHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1Mjc1MTAyOTt9fQ==', 1752751140);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'kiran', 'tankkiran.itn@gmail.com', NULL, '$2y$12$7/Ngk20ztZKp.1xMLCRz7udl3esRxbO0D1.DrM2LOhj58pXZfmF9q', 0, NULL, '2025-07-16 00:49:03', '2025-07-16 00:49:03'),
(2, 'admin', 'admin@gmail.com', NULL, '$2y$12$yHF6pZyoJanTBGTP4QTUW.O8ng1AkNtP9ifWOXSTwDL0Yng7aQV0K', 1, NULL, '2025-07-17 05:45:57', '2025-07-17 05:45:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

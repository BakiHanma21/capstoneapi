-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 01:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `service_xpress_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(10) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `status` enum('PENDING','CONFIRMED','CANCELLED') NOT NULL DEFAULT 'PENDING',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `worker_id`, `customer_id`, `title`, `description`, `amount`, `start`, `end`, `start_time`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 8, 7, 'Construction Worker/Masonry', 'I need to fix my ceiling ASAP!', 500, '2025-04-16', '2025-04-17', '08:00:00', 'CONFIRMED', 'images/1744657005.jpg', '2025-04-14 10:56:45', '2025-04-14 10:58:30'),
(2, 4, 7, 'qwe', 'qwe', 1500, '2025-04-16', '2025-04-17', '09:00:00', 'CONFIRMED', 'images/1744658497.png', '2025-04-14 11:21:37', '2025-04-14 11:23:15'),
(3, 8, 7, 'qwe', 'qwe', 1000, '2025-04-18', '2025-04-19', '10:00:00', 'CONFIRMED', 'images/1744869673.png', '2025-04-16 22:01:13', '2025-04-16 22:02:10'),
(4, 8, 7, 'qwe', 'qwe', 1500, '2025-04-18', '2025-04-19', '10:00:00', 'CONFIRMED', 'images/1744891649.jpg', '2025-04-17 04:07:29', '2025-04-17 04:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `count`, `created_at`, `updated_at`) VALUES
(1, 'Car Cleaner', 20, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(2, 'Cook', 15, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(3, 'Driver', 25, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(4, 'Electrician', 18, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(5, 'Home Instructor', 10, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(6, 'Maid', 30, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(7, 'Mechanic', 12, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(8, 'Plumber', 22, '2025-04-14 10:41:17', '2025-04-14 10:41:17'),
(9, 'Tutor', 19, '2025-04-14 10:41:17', '2025-04-14 10:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `message`, `file_path`, `file_name`, `file_type`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 7, 8, 'hello', NULL, NULL, NULL, '2025-04-14 11:00:43', '2025-04-14 10:59:18', '2025-04-14 11:00:43'),
(2, 7, 8, NULL, 'chat_files/TIRffLU0Vcdm4gxMFs2SMlKRaipen1Uo86pfgt0t.png', NULL, NULL, '2025-04-14 11:00:43', '2025-04-14 10:59:30', '2025-04-14 11:00:43'),
(3, 8, 7, 'hi', NULL, NULL, NULL, '2025-04-14 11:01:53', '2025-04-14 11:00:50', '2025-04-14 11:01:53'),
(4, 7, 8, 'nagbayad na ako', NULL, NULL, NULL, '2025-04-14 11:04:03', '2025-04-14 11:03:41', '2025-04-14 11:04:03'),
(5, 8, 7, 'ok slamat', NULL, NULL, NULL, '2025-04-14 11:05:42', '2025-04-14 11:04:09', '2025-04-14 11:05:42'),
(6, 7, 8, 'salamat din', NULL, NULL, NULL, '2025-04-14 11:15:29', '2025-04-14 11:05:50', '2025-04-14 11:15:29'),
(7, 7, 8, 'ok ba?', NULL, NULL, NULL, '2025-04-14 11:18:23', '2025-04-14 11:17:48', '2025-04-14 11:18:23'),
(8, 8, 7, 'oo', NULL, NULL, NULL, '2025-04-14 11:23:47', '2025-04-14 11:18:30', '2025-04-14 11:23:47'),
(9, 7, 4, 'hello', NULL, NULL, NULL, '2025-04-14 11:24:11', '2025-04-14 11:23:44', '2025-04-14 11:24:11'),
(10, 4, 7, 'hi', NULL, NULL, NULL, '2025-04-14 11:24:48', '2025-04-14 11:24:22', '2025-04-14 11:24:48'),
(11, 1, 7, 'hello', NULL, NULL, NULL, '2025-04-14 11:27:28', '2025-04-14 11:26:50', '2025-04-14 11:27:28'),
(12, 1, 8, 'hello', NULL, NULL, NULL, '2025-04-14 11:28:29', '2025-04-14 11:26:56', '2025-04-14 11:28:29'),
(13, 1, 8, 'hi', NULL, NULL, NULL, '2025-04-14 11:28:29', '2025-04-14 11:27:04', '2025-04-14 11:28:29'),
(14, 1, 7, 'hi', NULL, NULL, NULL, '2025-04-14 11:27:28', '2025-04-14 11:27:09', '2025-04-14 11:27:28'),
(15, 7, 1, 'hello din admin', NULL, NULL, NULL, '2025-04-14 11:29:05', '2025-04-14 11:28:13', '2025-04-14 11:29:05'),
(16, 8, 1, 'hello din admin', NULL, NULL, NULL, '2025-04-14 11:29:15', '2025-04-14 11:28:38', '2025-04-14 11:29:15'),
(17, 1, 7, NULL, 'chat_files/XwEnvWG05RadhdxHJDNk2aCRHz8rAnrGVRTpHN31.png', NULL, NULL, '2025-04-14 11:32:04', '2025-04-14 11:31:40', '2025-04-14 11:32:04'),
(18, 7, 1, NULL, 'chat_files/og2L0WvsGkw0rj1QlZ3efWFGn3nlIrncaFfyRNv8.jpg', NULL, NULL, '2025-04-16 21:29:32', '2025-04-16 21:28:32', '2025-04-16 21:29:32'),
(19, 1, 8, NULL, 'chat_files/Ke65cWQcFouqap20RsF5SR9ZvprJFbQAmNzFJv3f.jpg', NULL, NULL, '2025-04-16 21:30:23', '2025-04-16 21:29:57', '2025-04-16 21:30:23'),
(20, 8, 1, NULL, 'chat_files/xFZHYADgWSqoL0ZDXpB8BjI6lgJNAhrMIrl74Ds2.jpg', NULL, NULL, '2025-04-16 21:31:10', '2025-04-16 21:30:39', '2025-04-16 21:31:10'),
(21, 1, 8, NULL, 'chat_files/KTLoqWwWO4G8hsBlAihSlsVopSr9Nv1bR67d3o2t.jpg', NULL, NULL, '2025-04-16 23:32:50', '2025-04-16 21:38:10', '2025-04-16 23:32:50'),
(22, 7, 1, NULL, 'chat_files/bdvK5VdLZIsiq4aZ8K6bvpA3W0GVNRaBvizRcF2L.jpg', NULL, NULL, '2025-04-16 23:38:50', '2025-04-16 21:39:22', '2025-04-16 23:38:50'),
(23, 7, 8, NULL, 'chat_files/39rX5RzG9J3QTH1axxISW4P5Dt6WcFp6fK1jwv5B.jpg', NULL, NULL, '2025-04-16 22:07:16', '2025-04-16 21:40:18', '2025-04-16 22:07:16'),
(24, 7, 8, NULL, 'chat_files/xQg7LqXEa3PaoLUwxPm9fmlM1kPwF9ET.jpg', 'construction.jpg', 'jpg', '2025-04-16 22:07:16', '2025-04-16 21:47:41', '2025-04-16 22:07:16'),
(25, 7, 8, NULL, 'chat_files/SdrOdVAFvzQDp9vPOVobbQ6vuYwE8ZUF.jpg', 'construction.jpg', 'jpg', '2025-04-16 22:07:16', '2025-04-16 21:52:17', '2025-04-16 22:07:16'),
(26, 7, 4, NULL, 'chat_files/NgV1byiduA80DbxO1v7l9mIf3f6nme9Y.jpg', 'construction.jpg', 'jpg', NULL, '2025-04-16 21:59:32', '2025-04-16 21:59:32'),
(27, 7, 8, NULL, 'chat_files/QPLAkxbpbGpR4fAbbOIDVl1DeWkfcwIz.png', 'bg2.png', 'png', '2025-04-16 22:07:16', '2025-04-16 22:05:45', '2025-04-16 22:07:16'),
(28, 8, 7, NULL, '/uploads/chat/1744870526_melzJ5yOuk.jpg', '4.jpg', 'jpg', '2025-04-16 22:17:23', '2025-04-16 22:15:26', '2025-04-16 22:17:23'),
(29, 7, 8, NULL, '/uploads/chat/1744870662_35TPRurlRm.jpg', 'background_login.jpg', 'jpg', '2025-04-16 23:32:56', '2025-04-16 22:17:42', '2025-04-16 23:32:56'),
(30, 7, 8, NULL, '/uploads/chat/1744876265_Lf2vsBeU8v.jpg', 'Paymaya qr code.jpg', 'jpg', '2025-04-17 01:25:52', '2025-04-16 23:51:05', '2025-04-17 01:25:52'),
(31, 7, 8, NULL, '/uploads/chat/1744877810_1hU4pHEIeI.png', 'green check-Photoroom.png', 'png', '2025-04-17 01:25:52', '2025-04-17 00:16:50', '2025-04-17 01:25:52'),
(32, 7, 8, NULL, '/uploads/chat/1744877830_PgsFK5BHrA.png', 'logo.png', 'png', '2025-04-17 01:25:52', '2025-04-17 00:17:10', '2025-04-17 01:25:52'),
(33, 7, 1, NULL, '/uploads/chat/1744877866_s7hNIsIVUz.png', 's-removebg-preview.png', 'png', '2025-04-17 03:32:22', '2025-04-17 00:17:46', '2025-04-17 03:32:22'),
(34, 8, 1, NULL, '/uploads/chat/1744885651_dtwuEy7WeR.png', 'admin.png', 'png', '2025-04-17 03:33:22', '2025-04-17 02:27:31', '2025-04-17 03:33:22'),
(35, 8, 7, NULL, '/uploads/chat/1744885687_Vw8CREWCZW.jpg', 'admin-login.jpg', 'jpg', '2025-04-17 02:28:47', '2025-04-17 02:28:07', '2025-04-17 02:28:47'),
(36, 7, 1, NULL, '/uploads/chat/1744885781_Rj8ayi5Hz9.jpg', 'admin-login.jpg', 'jpg', '2025-04-17 03:32:22', '2025-04-17 02:29:41', '2025-04-17 03:32:22'),
(37, 1, 7, NULL, '/uploads/chat/1744889561_6XHVW8Tmd4.png', 'bg.png', 'png', '2025-04-17 03:35:51', '2025-04-17 03:32:41', '2025-04-17 03:35:51'),
(38, 1, 8, NULL, '/uploads/chat/1744889729_96L9BbgJ5l.jpg', 'admin-login.jpg', 'jpg', '2025-04-17 03:36:19', '2025-04-17 03:35:29', '2025-04-17 03:36:19'),
(39, 1, 7, NULL, '/uploads/chat/1744890726_bXo3kyC7rw.jpg', 'user-icon.jpg', 'jpg', '2025-04-17 03:53:51', '2025-04-17 03:52:06', '2025-04-17 03:53:51'),
(40, 1, 8, NULL, '/uploads/chat/1744890780_DrFheIedLg.png', 'skilled-worker.png', 'png', '2025-04-17 03:54:31', '2025-04-17 03:53:00', '2025-04-17 03:54:31'),
(41, 7, 1, NULL, '/uploads/chat/1744890848_xpwxyq66Os.jpg', 'admin-login.jpg', 'jpg', '2025-04-17 03:55:02', '2025-04-17 03:54:08', '2025-04-17 03:55:02'),
(42, 8, 1, NULL, '/uploads/chat/1744890883_n1aDoHmfB6.png', 'admin.png', 'png', '2025-04-17 03:55:20', '2025-04-17 03:54:43', '2025-04-17 03:55:20'),
(43, 8, 7, NULL, '/uploads/chat/1744905297_rTwGDfPVgq.pdf', 'P.S.G_CHAPTER 1 (1).pdf', 'pdf', '2025-04-17 19:29:35', '2025-04-17 07:54:57', '2025-04-17 19:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `customer_id`, `worker_id`, `created_at`, `updated_at`) VALUES
(1, 7, 5, '2025-04-14 10:55:22', '2025-04-14 10:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"9c48f0f5-3f10-4ac1-92ad-41d0911ca8ce\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744657158, 1744657158),
(2, 'default', '{\"uuid\":\"f8c77ecc-143b-4f8c-833f-acce8fd5271a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744657170, 1744657170),
(3, 'default', '{\"uuid\":\"62e71128-5fce-4b8f-8bc9-e567639c95f6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744657250, 1744657250),
(4, 'default', '{\"uuid\":\"d3fc1b09-46e0-4cab-9067-b8517dc96a06\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744657421, 1744657421),
(5, 'default', '{\"uuid\":\"46e6179b-16ae-463d-8e48-e925c38ba845\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744657449, 1744657449),
(6, 'default', '{\"uuid\":\"32d04f8f-06e3-42ff-9fdc-1a40493f82a0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744657550, 1744657550),
(7, 'default', '{\"uuid\":\"5fdff4db-933f-4503-a6f4-b26f0a14d2e0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658268, 1744658268),
(8, 'default', '{\"uuid\":\"ab88a9a8-fa58-4a2b-a245-c7c8bc692fbf\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658310, 1744658310),
(9, 'default', '{\"uuid\":\"5fa54350-5c20-48ce-97b7-115c310093a5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658624, 1744658624),
(10, 'default', '{\"uuid\":\"e775eda1-56ee-4694-83aa-7c1a0cc6365c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658662, 1744658662),
(11, 'default', '{\"uuid\":\"5102f73a-810d-4e89-97f1-8f0033ad870c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658810, 1744658810),
(12, 'default', '{\"uuid\":\"8dfe7bdb-b427-49e5-ae43-de3f8012a372\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658816, 1744658816),
(13, 'default', '{\"uuid\":\"2234f478-4ab5-40de-87d0-da1cec837566\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658824, 1744658824),
(14, 'default', '{\"uuid\":\"c02dfa5f-1b60-4f32-aaa7-7252d7bf21aa\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658829, 1744658829),
(15, 'default', '{\"uuid\":\"fb5ff9a6-b053-47f2-aa93-3e4071ced40e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658893, 1744658893),
(16, 'default', '{\"uuid\":\"c888ff15-cc13-49d9-a1f9-3b725434a33d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744658918, 1744658918),
(17, 'default', '{\"uuid\":\"7b2c21e4-b1ff-43a1-8e3b-2c271a2ed273\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744659100, 1744659100),
(18, 'default', '{\"uuid\":\"680e35dc-5c8d-46a8-af1f-9a8d7eb60fc4\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744867712, 1744867712),
(19, 'default', '{\"uuid\":\"080a5bd4-6104-4633-ab6d-99bc3e0e5805\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744867797, 1744867797),
(20, 'default', '{\"uuid\":\"9fe96f81-eef6-4fb2-aa87-64b09443cc7a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744867839, 1744867839),
(21, 'default', '{\"uuid\":\"20b72d86-02ce-4ea2-84a5-fa2062bb0046\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"140a1539-83ec-4d2e-99bc-a96870d764fe\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744868290, 1744868290),
(22, 'default', '{\"uuid\":\"44d82524-ab98-4883-8894-e40e64b48858\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"140a1539-83ec-4d2e-99bc-a96870d764fe\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744868290, 1744868290),
(23, 'default', '{\"uuid\":\"0f14d820-6426-4def-ae40-2a11c0415784\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744868290, 1744868290),
(24, 'default', '{\"uuid\":\"48078087-9ad1-441d-bd43-39e017181e52\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"071d4fb6-1633-4352-8536-7e5d1a81dd0a\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744868362, 1744868362),
(25, 'default', '{\"uuid\":\"ac527f17-c279-4781-8166-419cdc026b01\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"071d4fb6-1633-4352-8536-7e5d1a81dd0a\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744868362, 1744868362),
(26, 'default', '{\"uuid\":\"319f2b10-00b5-461a-a4e3-fe37f67c46c2\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744868362, 1744868362),
(27, 'default', '{\"uuid\":\"f952d36f-773d-4e39-8584-27731c792730\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"f48c83b7-6a46-4473-a2f2-9d1946a8fcd0\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744868418, 1744868418),
(28, 'default', '{\"uuid\":\"813933b5-3ead-4b59-bb95-5229c387592c\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"f48c83b7-6a46-4473-a2f2-9d1946a8fcd0\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744868418, 1744868418),
(29, 'default', '{\"uuid\":\"f1e263ee-a396-4c36-be16-e6da182a8b0c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744868418, 1744868418),
(30, 'default', '{\"uuid\":\"a94d08ba-2daa-4653-9c4c-3814a695b28f\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"ee4d3487-1714-45ad-a9dd-6e401fd02d31\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744868861, 1744868861),
(31, 'default', '{\"uuid\":\"d1fd0c30-e94b-49d5-8b9a-70eeca288c19\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"ee4d3487-1714-45ad-a9dd-6e401fd02d31\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744868861, 1744868861),
(32, 'default', '{\"uuid\":\"d59c02cc-34e0-42d1-9c9c-7e79335d4e8b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744868861, 1744868861),
(33, 'default', '{\"uuid\":\"81aa06d9-22ed-4459-a0c1-c861db02d185\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"be5f718e-b8ca-4328-88d3-c45fece537e4\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744869138, 1744869138),
(34, 'default', '{\"uuid\":\"3dd2a6cd-d1d4-43a1-8671-8d9af6e25c69\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"be5f718e-b8ca-4328-88d3-c45fece537e4\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744869138, 1744869138),
(35, 'default', '{\"uuid\":\"577998f3-8ccb-44e9-bdb6-e5f844e0cc53\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744869138, 1744869138),
(36, 'default', '{\"uuid\":\"5992c868-59db-4f2d-a8f4-3741118bfb47\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:4;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2871170c-91c1-4858-a009-8c46356f4413\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744869572, 1744869572),
(37, 'default', '{\"uuid\":\"f8a1636c-1a34-4ecc-a7f5-5060fcb5468d\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:4;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2871170c-91c1-4858-a009-8c46356f4413\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744869572, 1744869572),
(38, 'default', '{\"uuid\":\"aa9b071d-1044-4996-aad1-4700a4705dd1\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744869572, 1744869572);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(39, 'default', '{\"uuid\":\"de50ff25-5f86-4864-a171-9878ebb36f6d\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"bda87567-0230-43c6-acd4-1c8e94c90a45\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744869945, 1744869945),
(40, 'default', '{\"uuid\":\"e4ec20be-94a7-4052-bcdf-ac8351755bee\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"bda87567-0230-43c6-acd4-1c8e94c90a45\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744869945, 1744869945),
(41, 'default', '{\"uuid\":\"266b5db6-f8de-4345-b60f-89b764f41b28\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744869945, 1744869945),
(42, 'default', '{\"uuid\":\"3de9249c-c1f6-4250-a5f7-4fb1d280c41a\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"c95b8e1b-ddeb-4581-bcdd-28ed9a6c75ad\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744870526, 1744870526),
(43, 'default', '{\"uuid\":\"fe2e5e3e-beb6-419a-a3b6-cc9b5204dc82\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"c95b8e1b-ddeb-4581-bcdd-28ed9a6c75ad\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744870526, 1744870526),
(44, 'default', '{\"uuid\":\"0c498c6a-792f-49a1-86f8-4935008d97b8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744870526, 1744870526),
(45, 'default', '{\"uuid\":\"5bc09ce9-0df7-4375-bef6-1c9e5ab4d9f6\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"8c039ad7-0db8-4c69-85c9-206d18985797\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744870662, 1744870662),
(46, 'default', '{\"uuid\":\"065a68f8-1a45-4d06-a324-5c09117ff99a\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"8c039ad7-0db8-4c69-85c9-206d18985797\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744870662, 1744870662),
(47, 'default', '{\"uuid\":\"01e8b83b-ff09-42c1-8b42-928c59ae6d38\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744870662, 1744870662),
(48, 'default', '{\"uuid\":\"9f8f25f5-1cf8-493a-ba63-5cb9573e65f3\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"bd6d2ba5-151a-48ab-b58a-fb86a714e95b\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744876265, 1744876265),
(49, 'default', '{\"uuid\":\"133eb8c3-b8fe-49b5-af06-22a78cb2cccb\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"bd6d2ba5-151a-48ab-b58a-fb86a714e95b\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744876265, 1744876265),
(50, 'default', '{\"uuid\":\"eec219be-8c31-47ac-aee0-20884e8d0688\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744876265, 1744876265),
(51, 'default', '{\"uuid\":\"658dfc7c-7a1d-4dde-8409-317020c7ff57\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"b4f9e05e-7761-44b0-8339-4bc1d0706eaa\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744877810, 1744877810),
(52, 'default', '{\"uuid\":\"efefcfe9-6879-4f62-b558-7cc15cd50073\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"b4f9e05e-7761-44b0-8339-4bc1d0706eaa\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744877810, 1744877810),
(53, 'default', '{\"uuid\":\"c7742e46-3346-4f80-afb4-153c34dbd97b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744877810, 1744877810),
(54, 'default', '{\"uuid\":\"b1f86612-18f6-4870-9dae-d9245372184e\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"d9f1591d-c289-4b1c-b7dc-f611a77e77e3\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744877830, 1744877830),
(55, 'default', '{\"uuid\":\"4fd7bda0-d11f-4a45-a082-de5176ea9593\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"d9f1591d-c289-4b1c-b7dc-f611a77e77e3\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744877830, 1744877830),
(56, 'default', '{\"uuid\":\"ff22ee6b-2911-4dac-968b-faad3457907f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744877830, 1744877830),
(57, 'default', '{\"uuid\":\"56841e40-be6e-4132-8914-4d220ca287eb\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"00417cdc-a0b5-454e-8486-90126aa53091\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744877866, 1744877866),
(58, 'default', '{\"uuid\":\"bf08d8a1-392f-49d2-bdeb-3ad88c5d271b\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"00417cdc-a0b5-454e-8486-90126aa53091\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744877866, 1744877866),
(59, 'default', '{\"uuid\":\"ea25852a-a79e-4b05-875a-16966365e40a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744877866, 1744877866),
(60, 'default', '{\"uuid\":\"6de8732e-75b2-4173-a83d-085240fa4a33\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2268ed79-d878-427c-a2f8-f6ff30c89d04\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744885652, 1744885652),
(61, 'default', '{\"uuid\":\"d975a9af-4d44-4a83-8d86-040612f61df6\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2268ed79-d878-427c-a2f8-f6ff30c89d04\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744885652, 1744885652),
(62, 'default', '{\"uuid\":\"389cf4a5-3388-4174-89b6-e3049f172d5a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744885652, 1744885652),
(63, 'default', '{\"uuid\":\"43a4da01-1c7c-4c48-8156-a11d0ba82612\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2ed16bb2-b21c-48fe-8e13-b0ccb974302c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744885687, 1744885687),
(64, 'default', '{\"uuid\":\"58c9a8c8-2833-4622-bcba-a92fb47d39c2\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2ed16bb2-b21c-48fe-8e13-b0ccb974302c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744885687, 1744885687),
(65, 'default', '{\"uuid\":\"42ecfa5f-8973-4aea-9b71-773f5dc78dec\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744885687, 1744885687),
(66, 'default', '{\"uuid\":\"ea1ae27e-5512-402a-9929-f803bfdd205d\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"d85ef502-897a-4640-9a62-cf36ad2ae5f5\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744885781, 1744885781),
(67, 'default', '{\"uuid\":\"1b17ee3b-17c4-42c7-8ab7-196ae550c577\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"d85ef502-897a-4640-9a62-cf36ad2ae5f5\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744885781, 1744885781),
(68, 'default', '{\"uuid\":\"e7c7ad9e-e057-4242-8f70-23e7b2b3d211\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744885781, 1744885781),
(69, 'default', '{\"uuid\":\"ad666f9d-9784-434e-abb0-6e0fbf72d5ef\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"9b39870b-3f52-4f40-bbb7-519f1e0f605c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744889561, 1744889561),
(70, 'default', '{\"uuid\":\"d846284a-2466-4de0-9416-13c9b116df0c\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"9b39870b-3f52-4f40-bbb7-519f1e0f605c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744889561, 1744889561),
(71, 'default', '{\"uuid\":\"8d9f3044-c205-4d72-8a6d-722c5abd923b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744889561, 1744889561),
(72, 'default', '{\"uuid\":\"9d7679ce-e2fa-4139-bf87-d03bfe90a803\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"7c27eb7e-2e2a-4b0b-8800-10fbf1c5183c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744889729, 1744889729);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(73, 'default', '{\"uuid\":\"fa23d9d1-82d9-43c5-9438-e53156bb910b\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"7c27eb7e-2e2a-4b0b-8800-10fbf1c5183c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744889729, 1744889729),
(74, 'default', '{\"uuid\":\"8276bce1-8f1a-4d2c-a46a-bed2f660774f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744889729, 1744889729),
(75, 'default', '{\"uuid\":\"5bc39e72-2719-4e2c-a2d3-70c95e41c724\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"14fa04cb-499d-46c1-9c22-31225b4c7e0c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744890727, 1744890727),
(76, 'default', '{\"uuid\":\"83eddf63-c51e-4a81-94dd-5ea7adbf2e8f\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"14fa04cb-499d-46c1-9c22-31225b4c7e0c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744890727, 1744890727),
(77, 'default', '{\"uuid\":\"79ffee7e-85a8-43ce-8419-71c1fc750738\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744890727, 1744890727),
(78, 'default', '{\"uuid\":\"c6458c18-00f5-4f90-9bb6-e3cde71610de\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"0ca784dd-f055-4490-a05f-e79e9122dbae\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744890780, 1744890780),
(79, 'default', '{\"uuid\":\"e329e8a4-f114-45e6-847e-94eedb68a3f3\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"0ca784dd-f055-4490-a05f-e79e9122dbae\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744890780, 1744890780),
(80, 'default', '{\"uuid\":\"1e863086-067c-4dd9-9324-a2c1e337ac7a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744890780, 1744890780),
(81, 'default', '{\"uuid\":\"dbb44168-0505-4a6b-a33f-6e00e4ce4bf7\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"8463a602-e19e-44cc-9905-c7c132397f10\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744890849, 1744890849),
(82, 'default', '{\"uuid\":\"3852c29c-4d72-49d9-b2af-77bce4301168\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"8463a602-e19e-44cc-9905-c7c132397f10\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744890849, 1744890849),
(83, 'default', '{\"uuid\":\"6408da25-2ae6-4c81-83a2-a2e834ebba6a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744890849, 1744890849),
(84, 'default', '{\"uuid\":\"610baf20-1441-4345-9cf5-d85c7950d440\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"6bf77a3e-9e7b-4961-a903-24e5c8ea220a\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744890883, 1744890883),
(85, 'default', '{\"uuid\":\"420e9822-fbd4-4ea7-99c5-65786b4bec52\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"6bf77a3e-9e7b-4961-a903-24e5c8ea220a\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744890883, 1744890883),
(86, 'default', '{\"uuid\":\"31a53be0-a487-47b8-b52e-4cb4699ee23b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744890883, 1744890883),
(87, 'default', '{\"uuid\":\"6eda8707-ea2e-408a-aaab-43dc85d56443\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"a49090a8-8f36-4752-8002-f847cfc662a2\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1744905297, 1744905297),
(88, 'default', '{\"uuid\":\"a69e550d-18ff-4379-8740-e49c113acbd7\",\"displayName\":\"App\\\\Notifications\\\\ChatMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\ChatMessageNotification\\\":3:{s:7:\\\"\\u0000*\\u0000chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"\\u0000*\\u0000sender\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"a49090a8-8f36-4752-8002-f847cfc662a2\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:9:\\\"broadcast\\\";}}\"}}', 0, NULL, 1744905297, 1744905297),
(89, 'default', '{\"uuid\":\"3fd30bef-12ea-459b-a0b3-66cabca287dd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744905297, 1744905297);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `proposed_cost` decimal(10,2) DEFAULT NULL,
  `additional_details` text DEFAULT NULL,
  `typed_message` varchar(255) DEFAULT NULL,
  `is_agreed` enum('yes','no','pending') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_16_194858_create_skilled_workers_table', 1),
(5, '2024_12_16_194913_create_worker_works_table', 1),
(6, '2024_12_16_194917_create_reviews_table', 1),
(7, '2024_12_16_194920_create_favorites_table', 1),
(8, '2024_12_16_194924_create_transactions_table', 1),
(9, '2024_12_16_194926_create_messages_table', 1),
(10, '2024_12_16_194930_create_reports_table', 1),
(11, '2024_12_16_194933_create_response_messages_table', 1),
(12, '2024_12_16_194936_create_bookings_table', 1),
(13, '2024_12_16_201713_create_work_requests_table', 1),
(14, '2024_12_22_183303_create_personal_access_tokens_table', 1),
(15, '2024_12_29_151303_create_categories_table', 1),
(16, '2025_01_16_225537_add_reviews_and_rating_to_transactions_table', 1),
(17, '2025_01_21_045423_add_review2_and_rating2_to_transactions_table', 1),
(18, '2025_01_21_045517_add_report_reason_to_users_table', 1),
(19, '2025_03_07_070041_create_password_reset_tokens_table', 1),
(20, '2025_03_23_093815_add_qr_code_and_receipt_url_to_transactions_table', 1),
(21, '2025_03_26_073330_create_chats_table', 1),
(22, '2025_04_13_110525_modify_messages_table', 1),
(23, '2025_04_15_000000_create_notifications_table', 2),
(24, '2025_04_15_000001_add_file_columns_to_chats_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('johnwick.dawg321@gmail.com', '$2y$12$9MBsL1rDUkSOhXcwjkyu7.PolAYqSkDpR8kpRFfl4FJ0/lx7incuK', '2025-04-14 10:51:24'),
('namekaze.minato1010@gmail.com', '$2y$12$KEvvC23ZnXDrpV/bltJFDeykdt/53L/1yri6hF7e228MUzXrGBep2', '2025-04-14 10:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '3be7dfe6c653857816b9ef98a5a793fb175c3c174bad113289e79ceb6c0f0dc7', '[\"*\"]', '2025-04-14 10:50:45', NULL, '2025-04-14 10:47:34', '2025-04-14 10:50:45'),
(2, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '69c6ff5b8ca11a397f9c87cb194773bf8775a4872585f6cdf31c2039becc9405', '[\"*\"]', '2025-04-14 10:53:52', NULL, '2025-04-14 10:52:38', '2025-04-14 10:53:52'),
(3, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'b032f7c276fd315c38120cd948409cb08cba377c301fbb607a7c1040f39dd365', '[\"*\"]', '2025-04-14 10:55:05', NULL, '2025-04-14 10:54:03', '2025-04-14 10:55:05'),
(4, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '6fb516dfba0b4c27d1369c834c77575ba0f356ff864b0f8be1827ba7784cafc5', '[\"*\"]', '2025-04-14 10:57:16', NULL, '2025-04-14 10:55:12', '2025-04-14 10:57:16'),
(5, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'ab632ae22755b3cca6cad8d81fbb97001685c29957031aea10194047758a6196', '[\"*\"]', '2025-04-14 10:58:32', NULL, '2025-04-14 10:58:05', '2025-04-14 10:58:32'),
(6, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '18618f6f8845b4c518f5a7aab56480069e6334d896a887cd9711f98962fd0fd2', '[\"*\"]', '2025-04-14 10:59:31', NULL, '2025-04-14 10:58:49', '2025-04-14 10:59:31'),
(7, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '09402f9224948bc8e361554818a5be443583cac7062233b62554586216cf23be', '[\"*\"]', '2025-04-14 11:00:05', NULL, '2025-04-14 10:59:44', '2025-04-14 11:00:05'),
(8, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '1151c95fc32502eb1e2d5a7c28c388b5be5221d633c8c73c2b202cd9f31f1b56', '[\"*\"]', '2025-04-14 11:00:51', NULL, '2025-04-14 11:00:34', '2025-04-14 11:00:51'),
(9, 'App\\Models\\User', 1, 'SERVICEEXPRESS', 'b7dee942dc1afcd7bf8e2e8d1f62016b0fefd471d11bb3c577db5eb98f45980b', '[\"*\"]', '2025-04-14 11:01:24', NULL, '2025-04-14 11:01:13', '2025-04-14 11:01:24'),
(10, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'd0cea55c7bd1a391c3ca33a65f667a3b50d8b82078e267b87c4ccb4b4476d1ed', '[\"*\"]', '2025-04-14 11:01:56', NULL, '2025-04-14 11:01:45', '2025-04-14 11:01:56'),
(11, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '5a8b6bbdb3d49ee7fd3f08d4d871b853c5ce85f1eee889bdf52ba5165f2075fe', '[\"*\"]', '2025-04-14 11:02:54', NULL, '2025-04-14 11:02:22', '2025-04-14 11:02:54'),
(12, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'b42db2b092f95da9a86ea610e45113bb4c5361824e70e253380849b006877962', '[\"*\"]', '2025-04-14 11:03:42', NULL, '2025-04-14 11:03:15', '2025-04-14 11:03:42'),
(13, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'fba88570c153599473f52c994db6722ed9224f4744c77eacb15a98d169609b82', '[\"*\"]', '2025-04-14 11:04:39', NULL, '2025-04-14 11:03:52', '2025-04-14 11:04:39'),
(14, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '9f005b29d2cdfa751435f3ab7d89b39b55281a027d9269a52c336e43a80cbebd', '[\"*\"]', '2025-04-14 11:05:51', NULL, '2025-04-14 11:04:51', '2025-04-14 11:05:51'),
(15, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '82a0ca589294802dd934f48febd24647d9c438b0e9b162bec394c3a4bbe65a8f', '[\"*\"]', '2025-04-14 11:12:31', NULL, '2025-04-14 11:06:10', '2025-04-14 11:12:31'),
(16, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '010d5b94b1d6e52cb14da4743d2b2501fa79940bab839dedb3ae2b2bb21a451d', '[\"*\"]', '2025-04-14 11:15:00', NULL, '2025-04-14 11:12:50', '2025-04-14 11:15:00'),
(17, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '58cab0bd3a75a8f85fa2f70dd799568c6c734d8a07abb33a34cde2767ce81a79', '[\"*\"]', '2025-04-14 11:15:32', NULL, '2025-04-14 11:15:10', '2025-04-14 11:15:32'),
(18, 'App\\Models\\User', 1, 'SERVICEEXPRESS', 'f9a0e8967806fbe6f177387e582fd3ed48c00d89ea24187fed50a3ab9457f16b', '[\"*\"]', '2025-04-14 11:17:18', NULL, '2025-04-14 11:15:44', '2025-04-14 11:17:18'),
(19, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '662e7014ce07f23a8650467a287ec318eef2e45f7d4a730f3281a23c5ab0bb02', '[\"*\"]', '2025-04-14 11:17:49', NULL, '2025-04-14 11:17:28', '2025-04-14 11:17:49'),
(20, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '5a3f7ae3370701a3711242a9f3b9f3500ac5fb247ebe53fe684306be778dc520', '[\"*\"]', '2025-04-14 11:18:31', NULL, '2025-04-14 11:18:05', '2025-04-14 11:18:31'),
(21, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '202172a78fd8b84bf6cb1bcd8454a1185fddeb926fd8bdcfc9c6c3831cc427bc', '[\"*\"]', '2025-04-14 11:22:11', NULL, '2025-04-14 11:18:38', '2025-04-14 11:22:11'),
(22, 'App\\Models\\User', 4, 'SERVICEEXPRESS', '8632195188ea0ec4e9e7ad51963283986cedc8aaf0dd70ca16a7d60735dc518f', '[\"*\"]', '2025-04-14 11:23:22', NULL, '2025-04-14 11:23:03', '2025-04-14 11:23:22'),
(23, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '13eba17df2b1218d2f3f52df7894b68d279b42f347e4355f3db8146e0ef5f54f', '[\"*\"]', '2025-04-14 11:23:57', NULL, '2025-04-14 11:23:32', '2025-04-14 11:23:57'),
(24, 'App\\Models\\User', 4, 'SERVICEEXPRESS', '40c2b911d3c2420248670e331b2fdd4c3b7245af42e4393437f3f65500a5ac6b', '[\"*\"]', '2025-04-14 11:24:30', NULL, '2025-04-14 11:24:05', '2025-04-14 11:24:30'),
(25, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '0e4f5c0fe4d226324d9c54b422bc6b92b3725da8b8d76499549cd1cfd6eae3b0', '[\"*\"]', '2025-04-14 11:24:56', NULL, '2025-04-14 11:24:41', '2025-04-14 11:24:56'),
(26, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '382786054d6a63a1eeae2f0f62ae5788f4e3dcd97fed86d342b162753d8e4d3f', '[\"*\"]', '2025-04-14 11:27:10', NULL, '2025-04-14 11:26:33', '2025-04-14 11:27:10'),
(27, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '242b3988869430a6b79abd8ceb70e88da5dc1abb2b1f6ab88dd410394db2d08c', '[\"*\"]', '2025-04-14 11:28:14', NULL, '2025-04-14 11:27:21', '2025-04-14 11:28:14'),
(28, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'b3672c28e28a009b731017998c4eec3628732d3138c86d16d9f8450bcd4096c0', '[\"*\"]', '2025-04-14 11:28:39', NULL, '2025-04-14 11:28:22', '2025-04-14 11:28:39'),
(29, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '98d9c7e0cb05988ba0957416e332a6f5a3f293c0564505cdfae4c36c9ddbd2c8', '[\"*\"]', '2025-04-14 11:31:41', NULL, '2025-04-14 11:28:51', '2025-04-14 11:31:41'),
(30, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '15559fc495c89f61c6482ef66db78dd2ea9b3240f00438fae6326aec34a16175', '[\"*\"]', '2025-04-14 11:32:07', NULL, '2025-04-14 11:31:56', '2025-04-14 11:32:07'),
(31, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '3b682c6b8b80d8d9a6ffde289c70a842eb314ccd63807be5a76c0e4b21b7cc1b', '[\"*\"]', '2025-04-16 21:24:36', NULL, '2025-04-16 21:19:54', '2025-04-16 21:24:36'),
(32, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'c11fde9207766919cc122872d1f1fe06caa821020948db20ea956b65993025fc', '[\"*\"]', '2025-04-16 21:26:04', NULL, '2025-04-16 21:24:53', '2025-04-16 21:26:04'),
(33, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '8786e9197c41d5e1bfa660ec3a5ac7de54fa3f0767c8e71896ea5bd56d14fb04', '[\"*\"]', '2025-04-16 21:27:29', NULL, '2025-04-16 21:26:16', '2025-04-16 21:27:29'),
(34, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '3a295b4beee1a3fa1ee7b477cd7a1663532d744e2390f306acc38df5c173a05d', '[\"*\"]', '2025-04-16 21:28:34', NULL, '2025-04-16 21:27:43', '2025-04-16 21:28:34'),
(35, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '47d5c35f1ac249181ae4ce7dbf79c52e43623c5cbef5005517e5c62612edda00', '[\"*\"]', '2025-04-16 21:29:59', NULL, '2025-04-16 21:28:52', '2025-04-16 21:29:59'),
(36, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'd35f82c561c099407d7e86d7852a7fc845880bae18b1e6f54ebdf7234305c1e0', '[\"*\"]', '2025-04-16 21:30:42', NULL, '2025-04-16 21:30:10', '2025-04-16 21:30:42'),
(37, 'App\\Models\\User', 1, 'SERVICEEXPRESS', 'ffbbb2b1c7a260e67b8755da4ac43263153bba30ea615ee039a9aaa943355358', '[\"*\"]', '2025-04-16 21:38:12', NULL, '2025-04-16 21:30:57', '2025-04-16 21:38:12'),
(38, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '81f15c2c97d7470c8da1594ec362ffaf0918678558a5085685524b641fdbb208', '[\"*\"]', '2025-04-16 22:01:16', NULL, '2025-04-16 21:38:44', '2025-04-16 22:01:16'),
(39, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '26bd9a7e501a6c2feede1a28f091168083bc0c011efddfbcb51a8776b40cde36', '[\"*\"]', '2025-04-16 22:02:29', NULL, '2025-04-16 22:01:27', '2025-04-16 22:02:29'),
(40, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '922fd41136947de6826022629a8820bdb2325c593a6bc0209e0496f9be689060', '[\"*\"]', '2025-04-16 22:03:08', NULL, '2025-04-16 22:02:56', '2025-04-16 22:03:08'),
(41, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '25583a0112ce042cd49a013afcac753e86c816c11e7c80289101c2b62b3338b4', '[\"*\"]', '2025-04-16 22:03:32', NULL, '2025-04-16 22:03:30', '2025-04-16 22:03:32'),
(42, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'b5c598cd912022de93838e2ff2c9c0c5a06ef7b7347edcfb55998ceb7d3a99f8', '[\"*\"]', '2025-04-16 22:04:34', NULL, '2025-04-16 22:03:38', '2025-04-16 22:04:34'),
(43, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '48ce9d1f0b2865c90e4223011cd201f9091769d65c516ed75b375f5eec61e948', '[\"*\"]', '2025-04-16 22:05:47', NULL, '2025-04-16 22:04:55', '2025-04-16 22:05:47'),
(44, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '73f807a525dba945c7b761e19fd3786ad66e18b0cb50460c3ccf439921cdd7c4', '[\"*\"]', '2025-04-16 22:15:28', NULL, '2025-04-16 22:06:52', '2025-04-16 22:15:28'),
(45, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'ca9c419e27404932705f49e27bdeb77f308381272cf195f2d12a63086c185707', '[\"*\"]', '2025-04-16 23:09:06', NULL, '2025-04-16 22:16:49', '2025-04-16 23:09:06'),
(46, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'e54760946b7765832a711cb1b5355744a7e87c354d6fdfa899439e9e128025dc', '[\"*\"]', '2025-04-16 23:38:27', NULL, '2025-04-16 23:32:37', '2025-04-16 23:38:27'),
(47, 'App\\Models\\User', 1, 'SERVICEEXPRESS', 'd371ed5e74ca385469bd2b83b30e80e3467cf1b487d9b2651c45aefb05a5e52d', '[\"*\"]', '2025-04-16 23:49:55', NULL, '2025-04-16 23:38:38', '2025-04-16 23:49:55'),
(48, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '6149312f1b8f2dba3a001c045b140caff7884c6a4275d7da9454c0380bfb8511', '[\"*\"]', '2025-04-17 00:17:54', NULL, '2025-04-16 23:50:06', '2025-04-17 00:17:54'),
(49, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '688d5a20852691fcb8b611c42a67f956070eaa219b05db9caa29dd55f87aaf64', '[\"*\"]', '2025-04-17 00:41:29', NULL, '2025-04-17 00:41:22', '2025-04-17 00:41:29'),
(50, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '3b28171ba1499de50035e7b4e8ec9407d30da014dc2e94eb2b84763dbfd7661c', '[\"*\"]', '2025-04-17 01:13:17', NULL, '2025-04-17 00:41:40', '2025-04-17 01:13:17'),
(51, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'd0579ea0ff958ab4907f5b39878b2814a313602209737e519d345364fe050876', '[\"*\"]', '2025-04-17 01:13:40', NULL, '2025-04-17 01:13:32', '2025-04-17 01:13:40'),
(52, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'd910faf9273086177b17599b66a4a40effa3ea517afb8efabf558a5cef3fb778', '[\"*\"]', '2025-04-17 01:13:53', NULL, '2025-04-17 01:13:52', '2025-04-17 01:13:53'),
(53, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '11c69f018abe0919b453d1b500c2e1cbc49357bba1399168ff8a5a35745429b5', '[\"*\"]', '2025-04-17 01:14:09', NULL, '2025-04-17 01:14:08', '2025-04-17 01:14:09'),
(54, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '51ac3e746395d8d9bdc3f83e06158be6c0fe9ecfbd6f6e803824c95a5daa5579', '[\"*\"]', '2025-04-17 01:14:18', NULL, '2025-04-17 01:14:17', '2025-04-17 01:14:18'),
(55, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '377cb089ad054f9f70a67db5064aa5b31706f522684ff039ca79aa055c93965e', '[\"*\"]', '2025-04-17 01:14:33', NULL, '2025-04-17 01:14:26', '2025-04-17 01:14:33'),
(56, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'bb1491bcabb03513308ed02e2e90abd3e498ea1241671d42ae9d63abc9f7aff7', '[\"*\"]', '2025-04-17 01:15:31', NULL, '2025-04-17 01:15:27', '2025-04-17 01:15:31'),
(57, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'd65c97d3bb477df196eb778e2eb5a20272c128eac0807e46428fad94ce236c60', '[\"*\"]', '2025-04-17 01:17:05', NULL, '2025-04-17 01:17:00', '2025-04-17 01:17:05'),
(58, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '8c0c083fdea302a99083a60e350fc34b2fbca9fb8e5f055af3fb890e6230ad3a', '[\"*\"]', '2025-04-17 01:26:05', NULL, '2025-04-17 01:25:42', '2025-04-17 01:26:05'),
(59, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '485580056344796e42e549401f576899a095b9d0c582e77d63285236269adc8b', '[\"*\"]', '2025-04-17 01:26:26', NULL, '2025-04-17 01:26:18', '2025-04-17 01:26:26'),
(60, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '533787a66162bfffae9c3399dc474a7b366264f569e4cc3c13fcc1a9275e349a', '[\"*\"]', '2025-04-17 01:27:01', NULL, '2025-04-17 01:27:00', '2025-04-17 01:27:01'),
(61, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '142d5af2b5f6f2f6c4ab625fb5c119bf9e2b3993c953bf5708ec07a824d0092e', '[\"*\"]', '2025-04-17 01:27:32', NULL, '2025-04-17 01:27:30', '2025-04-17 01:27:32'),
(62, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'f23626cfb1701e6be7e133e4c130aa608f964b9b1b52aa13a181ff875c363546', '[\"*\"]', '2025-04-17 02:26:15', NULL, '2025-04-17 01:32:53', '2025-04-17 02:26:15'),
(63, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '89ef04ad1928ab08277323cf49cbd61fb78a9adb1d6a22233bb63b1d05ede43f', '[\"*\"]', '2025-04-17 02:28:09', NULL, '2025-04-17 02:26:30', '2025-04-17 02:28:09'),
(64, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'e3495d19490c63be3fc340028d6cc669b9c2213771c5917e486fd478a0fa6604', '[\"*\"]', '2025-04-17 02:29:42', NULL, '2025-04-17 02:28:33', '2025-04-17 02:29:42'),
(65, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '1643f1c49130eee9cab96fca6e927b50bbc9ec946453d397faa58db222011922', '[\"*\"]', '2025-04-17 03:24:03', NULL, '2025-04-17 03:22:31', '2025-04-17 03:24:03'),
(66, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '3a0cd5195e99b8ad3e9a0b2324b1b68c6758bf0d66ac88317381d324812ab63a', '[\"*\"]', '2025-04-17 03:24:25', NULL, '2025-04-17 03:24:20', '2025-04-17 03:24:25'),
(67, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'fe1859fb03a12f79524dfe73245474010c9bdfb23d8cd45715eaa3eebb354db5', '[\"*\"]', '2025-04-17 03:25:46', NULL, '2025-04-17 03:24:37', '2025-04-17 03:25:46'),
(68, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '04026d0e1538bdd75b8f6cc4d3bcdafcad12acb22430ea1c4d6c22687c84daa2', '[\"*\"]', '2025-04-17 03:35:30', NULL, '2025-04-17 03:26:12', '2025-04-17 03:35:30'),
(69, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'fe605f1126b81290866bc5e76738c40ff1a71ff1140642649b5c99bcb497ecea', '[\"*\"]', '2025-04-17 03:35:55', NULL, '2025-04-17 03:35:37', '2025-04-17 03:35:55'),
(70, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '5dad1c716faaee0f7c8457ae9a339e9e5f430ef2a1ee64eecf75787cf3dfc937', '[\"*\"]', '2025-04-17 03:36:54', NULL, '2025-04-17 03:36:11', '2025-04-17 03:36:54'),
(71, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'a36114248464a9d80af48360972806cc2c02f6b46120cad7f5b97ff4633dac03', '[\"*\"]', '2025-04-17 03:37:28', NULL, '2025-04-17 03:37:16', '2025-04-17 03:37:28'),
(72, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '849e529839dbcff18a3a7f768678b71f447fdbb4b62dfd188c805352806b693a', '[\"*\"]', '2025-04-17 03:53:01', NULL, '2025-04-17 03:37:41', '2025-04-17 03:53:01'),
(73, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '15c16979b18d87652c52c834c78acc62ecf4fe028b02485fd3a0e2c103b03754', '[\"*\"]', '2025-04-17 03:54:09', NULL, '2025-04-17 03:53:40', '2025-04-17 03:54:09'),
(74, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'ec5f3006aa718acfb67f687b5aa06ad2d0e23121439eea2c6a2d7b86cf5c6701', '[\"*\"]', '2025-04-17 03:54:44', NULL, '2025-04-17 03:54:22', '2025-04-17 03:54:44'),
(75, 'App\\Models\\User', 1, 'SERVICEEXPRESS', 'e10cbdacfb8f9c472f7100fa0f2390a7763be3e9b76cd0c0518a4805353f1599', '[\"*\"]', '2025-04-17 04:04:20', NULL, '2025-04-17 03:54:54', '2025-04-17 04:04:20'),
(76, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'd52e21a97fbc4870626100864e3f28a9b9c8780f7c58c5f9b8b5b2b74b8dd851', '[\"*\"]', '2025-04-17 04:07:42', NULL, '2025-04-17 04:06:25', '2025-04-17 04:07:42'),
(77, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '4026a2a280e500670f8df7e99881dc5ad0f4b97d43f5e0eb81dfb2580f512f63', '[\"*\"]', '2025-04-17 04:09:23', NULL, '2025-04-17 04:07:55', '2025-04-17 04:09:23'),
(78, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'f8f3ec4f70605d3fe8a6370d767b2221565bd0c01730d588add4635c08b88317', '[\"*\"]', '2025-04-17 04:10:42', NULL, '2025-04-17 04:09:42', '2025-04-17 04:10:42'),
(79, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'b725c5642d557e3962ef620fd8d6744d2a378f0dc0e8ecc7c89c2ba0422a493a', '[\"*\"]', '2025-04-17 04:11:28', NULL, '2025-04-17 04:11:02', '2025-04-17 04:11:28'),
(80, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '7d11a9329521baaea78176badb981d197892cdb74df8f0d876ff543599f853bb', '[\"*\"]', '2025-04-17 04:12:53', NULL, '2025-04-17 04:11:45', '2025-04-17 04:12:53'),
(81, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '1621a9d87db8da2b71eed9045b9484c4702e12ceecc3cd39155b59f026d394dc', '[\"*\"]', '2025-04-17 04:13:10', NULL, '2025-04-17 04:13:03', '2025-04-17 04:13:10'),
(82, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'b976f360864fbe69be8c019bbccf84114a16ba5d58ef3a2a9543f578e07ed164', '[\"*\"]', '2025-04-17 04:14:35', NULL, '2025-04-17 04:13:32', '2025-04-17 04:14:35'),
(83, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'f52f6a61b29fde768ecf72c70ce957238d3ce55b7cae113aa415e0b5042f4ef2', '[\"*\"]', '2025-04-17 07:36:10', NULL, '2025-04-17 07:36:10', '2025-04-17 07:36:10'),
(84, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '1306cda0cbf6d94e6cc6956fd64eccd817fef5c5f22e8ba396a412bb4ecdd268', '[\"*\"]', '2025-04-17 07:44:18', NULL, '2025-04-17 07:38:57', '2025-04-17 07:44:18'),
(85, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '7c12ceda1b5915f0612ef46e3d8c5d8930af96327f7681a48fb97a6399d42f80', '[\"*\"]', '2025-04-17 07:51:23', NULL, '2025-04-17 07:44:29', '2025-04-17 07:51:23'),
(86, 'App\\Models\\User', 8, 'SERVICEEXPRESS', 'd4f258574260b5058db18c0c3e5e66693cd3d4152e78cecc62900461bd11dd29', '[\"*\"]', '2025-04-17 08:41:30', NULL, '2025-04-17 07:51:45', '2025-04-17 08:41:30'),
(87, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '22b2660d20be822e82352afed538f556d58b88d6a140f9f51c2416f00b696de4', '[\"*\"]', '2025-04-17 19:29:54', NULL, '2025-04-17 19:24:30', '2025-04-17 19:29:54'),
(88, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '4cb056512cb4a7e392aecb87b7925ebb0c58a9354e5171a1b6c5a6f7c0997407', '[\"*\"]', '2025-04-17 19:33:01', NULL, '2025-04-17 19:30:14', '2025-04-17 19:33:01'),
(89, 'App\\Models\\User', 1, 'SERVICEEXPRESS', 'f8bcf8c079e4e3f364dd8a0b1d3d26f009c11aaf239d36013e72b50fe677a42b', '[\"*\"]', '2025-04-17 19:36:34', NULL, '2025-04-17 19:33:24', '2025-04-17 19:36:34'),
(90, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'b879355ea19682f0d571fb9e4b188310c99b2d8c39aaea72f465845af020e7ed', '[\"*\"]', '2025-04-17 20:11:02', NULL, '2025-04-17 20:11:01', '2025-04-17 20:11:02'),
(91, 'App\\Models\\User', 7, 'SERVICEEXPRESS', 'eccef734cb3ef549898e13421e3afa84c593765b8cf3aa6a6ea3d0f887ef14fa', '[\"*\"]', '2025-04-17 20:41:24', NULL, '2025-04-17 20:40:45', '2025-04-17 20:41:24'),
(92, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '94fa90bc71a6b73345ac7cf8be238ae4c73d5824901a6d4a3fa838588315707a', '[\"*\"]', '2025-04-17 20:51:16', NULL, '2025-04-17 20:45:47', '2025-04-17 20:51:16'),
(93, 'App\\Models\\User', 7, 'SERVICEEXPRESS', '526d0e767fbdface24427ae5a4f626d0907383de17731361864906fa7c33fb07', '[\"*\"]', '2025-04-18 01:53:26', NULL, '2025-04-18 01:53:05', '2025-04-18 01:53:26'),
(94, 'App\\Models\\User', 8, 'SERVICEEXPRESS', '94ad3cce4e830123f70c1d71a17a31872b35feedb5f4d5489fd64fd3ffc68848', '[\"*\"]', '2025-04-18 01:54:21', NULL, '2025-04-18 01:53:35', '2025-04-18 01:54:21'),
(95, 'App\\Models\\User', 1, 'SERVICEEXPRESS', '15c274b19120e0c22b4f9b0a37ae068a13bbd7f9b79cad2029b9f1555de6a75f', '[\"*\"]', '2025-04-18 02:19:39', NULL, '2025-04-18 01:55:30', '2025-04-18 02:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reported_person` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `response_messages`
--

CREATE TABLE `response_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(10) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `worker_id`, `name`, `rating`, `text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Charlie', 5, 'Amazing craftsmanship!', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(2, 1, 'Eve', 4, 'Good work, but a bit pricey.', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(3, 2, 'Charlie', 5, 'Amazing craftsmanship!', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(4, 2, 'Eve', 4, 'Good work, but a bit pricey.', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(5, 3, 'Charlie', 5, 'Amazing craftsmanship!', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(6, 3, 'Eve', 4, 'Good work, but a bit pricey.', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(7, 4, 'Charlie', 5, 'Amazing craftsmanship!', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(8, 4, 'Eve', 4, 'Good work, but a bit pricey.', '2025-04-14 10:41:19', '2025-04-14 10:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `skilled_workers`
--

CREATE TABLE `skilled_workers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `work_done` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`work_done`)),
  `work_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skilled_workers`
--

INSERT INTO `skilled_workers` (`id`, `user_id`, `job`, `location`, `experience`, `availability`, `work_done`, `work_image`, `created_at`, `updated_at`) VALUES
(1, 3, 'Electrician', 'Amapola Street Purok 2', 5, 1, '[]', 'images/work_image.png', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(2, 4, 'Carpenter', 'Salang Street Purok 1', 3, 1, '[]', 'images/work_image.png', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(3, 5, 'Car Painter', 'Rodriguez Street Purok 5', 3, 0, '[]', 'images/work_image.png', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(4, 6, 'Car Electrician', 'Adelfa Street Purok 3', 3, 0, '[]', 'images/work_image.png', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(5, 8, 'construction', 'Purok 2 Tala Street', 4, 1, NULL, NULL, '2025-04-14 10:47:07', '2025-04-14 10:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `request_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `receipt_url` varchar(255) DEFAULT NULL,
  `payment_status` enum('PENDING','PAID','FAILED','MANUALLY UPDATED') NOT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT 0,
  `review2` text DEFAULT NULL,
  `rating2` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `request_id`, `customer_id`, `name`, `amount`, `title`, `description`, `qr_code_url`, `receipt_url`, `payment_status`, `payment_date`, `created_at`, `updated_at`, `review`, `rating`, `review2`, `rating2`) VALUES
(1, 8, 7, 'Minato Namekaze', '500', 'Construction Worker/Masonry', 'I need to fix my ceiling ASAP!', 'qr_codes/67fd5bde19e48.jpg', 'receipts/67fd5bffc8865.jpg', 'MANUALLY UPDATED', '2025-04-14', '2025-04-14 10:58:30', '2025-04-14 11:05:31', 'goods', 4, 'thank you', 4),
(2, 4, 7, 'Minato Namekaze', '1500', 'qwe', 'qwe', NULL, NULL, 'PENDING', '2025-04-17', '2025-04-14 11:23:15', '2025-04-14 11:23:15', NULL, 0, NULL, 0),
(3, 8, 7, 'Minato Namekaze', '1000', 'qwe', 'qwe', 'qr_codes/68009975c1c9e.jpg', 'receipts/6800999cc88c8.jpg', 'MANUALLY UPDATED', '2025-04-17', '2025-04-16 22:02:10', '2025-04-16 22:05:17', 'qwe', 3, 'qwe', 3),
(4, 8, 7, 'Minato Namekaze', '1500', 'qwe', 'qwe', 'qr_codes/6800ef73d43f1.jpg', 'receipts/6800efc2767a1.jpg', 'MANUALLY UPDATED', '2025-04-17', '2025-04-17 04:08:25', '2025-04-17 04:12:29', 'eryre', 2, '346dj', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('USER','WORKER','ADMINISTRATOR') NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `occupation` text DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `valid_id` text DEFAULT NULL,
  `purok` text DEFAULT NULL,
  `street` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `reviews` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reviews`)),
  `image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `report_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `profile_image`, `job`, `location`, `experience`, `availability`, `occupation`, `certifications`, `skills`, `valid_id`, `purok`, `street`, `phone`, `rating`, `reviews`, `image`, `remember_token`, `created_at`, `updated_at`, `report_reason`) VALUES
(1, 'Administrator User', 'admin@gmail.com', NULL, '$2y$12$1boFbDO9Drcdz2brQOxVMelhHDUYO5H6EeGoVe5/NsAKy1by0.q8q', 'ADMINISTRATOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', NULL, NULL, NULL, NULL, NULL, NULL, 'images/1744947247.jpg', NULL, '2025-04-14 10:41:18', '2025-04-17 19:34:19', NULL),
(2, 'Micheal Jordan', 'user@gmail.com', NULL, '$2y$12$OPg9zqY3zLtx2kcaEa4jGex83/yIWjqHKkGyE4TwwcG6dn81pnx.i', 'USER', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '123-456-7890', NULL, NULL, 'images/image.png', NULL, '2025-04-14 10:41:18', '2025-04-14 10:41:18', NULL),
(3, 'Cedric Lee', 'worker@gmail.com', NULL, '$2y$12$6iJjgTW8Bkn93ECgc3/lVuyxiFWIbnE2dFLlhiMCjsSOB8TdpE2Lu', 'WORKER', NULL, NULL, 'Amapola Street Purok 2', 5, 1, NULL, NULL, 'Electrician', 'worker_valid_id.png', NULL, NULL, '123-456-7890', 4, NULL, 'images/image.png', NULL, '2025-04-14 10:41:18', '2025-04-14 10:41:18', NULL),
(4, 'Sasuke Uchiha', 'jane.smith@example.com', NULL, '$2y$12$CcQkRUdhD0pvoex/0lXue.T6r.iy.JAxtzRduQHFTFk0EMunDDtN.', 'WORKER', NULL, NULL, 'Salang Street Purok 1', 3, 1, NULL, NULL, 'Carpenter', 'worker_valid_id.png', NULL, NULL, '987-654-3210', 3, NULL, 'images/image.png', NULL, '2025-04-14 10:41:18', '2025-04-14 10:41:18', NULL),
(5, 'Yujiro Hanma', 'alex.johnson@example.com', NULL, '$2y$12$Eog2Bg6ct91BZU8GlJcC/.jRAG/XHxVzwplRGz28fl2vaJ3nLx2sW', 'WORKER', NULL, NULL, 'Rodriguez Street Purok 5', 3, 0, NULL, NULL, 'Car Painter', 'worker_valid_id.png', NULL, NULL, '987-654-3210', 3, NULL, 'images/image.png', NULL, '2025-04-14 10:41:19', '2025-04-14 10:41:19', NULL),
(6, 'Lebron James', 'emily.davis@example.com', NULL, '$2y$12$68NmhiNbtZvjgNBL9DEwuO5P08pXdYxTbE6E1Klmq/6IETpalfpjC', 'WORKER', NULL, NULL, 'Adelfa Street Purok 3', 3, 0, NULL, NULL, 'Car Electrician', 'worker_valid_id.png', NULL, NULL, '987-654-3210', 3, NULL, 'images/image.png', NULL, '2025-04-14 10:41:19', '2025-04-14 10:41:19', NULL),
(7, 'Minato Namekaze', 'namekaze.minato1010@gmail.com', NULL, '$2y$12$Pwoin7NV85N6eezk8.47GOP0G1ew5CEtC5WI.a5HONBQP1DKlqOsm', 'USER', NULL, NULL, 'Purok 1, Salang Street', NULL, 0, NULL, NULL, NULL, NULL, 'Purok 1', 'Salang Street', '09121275801', NULL, NULL, 'images/1744656284.jpg', NULL, '2025-04-14 10:44:44', '2025-04-14 10:50:02', NULL),
(8, 'John Wick', 'johnwick.dawg321@gmail.com', NULL, '$2y$12$2ql4QO3i8FeQZ6uOfjtd1.OSiA2kf81r4F4nIQWQ3CpPxzZaYC9Ba', 'WORKER', NULL, NULL, 'Purok 2 Tala Street', 4, 1, NULL, NULL, 'construction', 'images/1744656427_valid_id.jpg', NULL, NULL, '09456456456', NULL, NULL, 'images/1744947045.png', NULL, '2025-04-14 10:47:07', '2025-04-17 19:30:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `worker_works`
--

CREATE TABLE `worker_works` (
  `work_id` int(10) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_works`
--

INSERT INTO `worker_works` (`work_id`, `worker_id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'House Wiring', 'Completed full house wiring for a two-story home.', 'images/image1.png', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(2, 1, 'Fuse Box Installation', 'Installed and configured a modern fuse box system.', 'images/image2.png', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(3, 2, 'House Wiring', 'Completed full house wiring for a two-story home.', 'images/image1.png', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(4, 2, 'Fuse Box Installation', 'Installed and configured a modern fuse box system.', 'images/image2.png', '2025-04-14 10:41:18', '2025-04-14 10:41:18'),
(5, 3, 'House Wiring', 'Completed full house wiring for a two-story home.', 'images/image1.png', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(6, 3, 'Fuse Box Installation', 'Installed and configured a modern fuse box system.', 'images/image2.png', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(7, 4, 'House Wiring', 'Completed full house wiring for a two-story home.', 'images/image1.png', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(8, 4, 'Fuse Box Installation', 'Installed and configured a modern fuse box system.', 'images/image2.png', '2025-04-14 10:41:19', '2025-04-14 10:41:19'),
(9, 5, 'construction', 'Repair and build a houses (2-story house or more)', 'images/1744656427_work_example_1.jpg', '2025-04-14 10:47:07', '2025-04-14 10:47:07'),
(10, 5, 'electrician', 'fixing outlet and other electrical components', 'images/1744656427_work_example_2.jpg', '2025-04-14 10:47:07', '2025-04-14 10:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `work_requests`
--

CREATE TABLE `work_requests` (
  `request_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `service` varchar(255) NOT NULL,
  `status` enum('PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `proposed_cost` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `bookings_worker_id_foreign` (`worker_id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  ADD KEY `chats_created_at_index` (`created_at`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `response_messages`
--
ALTER TABLE `response_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reviews_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `skilled_workers`
--
ALTER TABLE `skilled_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skilled_workers_user_id_foreign` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `worker_works`
--
ALTER TABLE `worker_works`
  ADD PRIMARY KEY (`work_id`),
  ADD KEY `worker_works_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `work_requests`
--
ALTER TABLE `work_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response_messages`
--
ALTER TABLE `response_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skilled_workers`
--
ALTER TABLE `skilled_workers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `worker_works`
--
ALTER TABLE `worker_works`
  MODIFY `work_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `work_requests`
--
ALTER TABLE `work_requests`
  MODIFY `request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `skilled_workers` (`id`);

--
-- Constraints for table `skilled_workers`
--
ALTER TABLE `skilled_workers`
  ADD CONSTRAINT `skilled_workers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `worker_works`
--
ALTER TABLE `worker_works`
  ADD CONSTRAINT `worker_works_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `skilled_workers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

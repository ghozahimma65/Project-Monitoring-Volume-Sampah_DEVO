-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 03:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devo`
--

-- --------------------------------------------------------

--
-- Table structure for table `abnormal_readings`
--

CREATE TABLE `abnormal_readings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depo_id` bigint(20) UNSIGNED NOT NULL,
  `nilai_terbaca` varchar(255) NOT NULL,
  `catatan` text NOT NULL,
  `acknowledged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `depos`
--

CREATE TABLE `depos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_depo` varchar(255) NOT NULL,
  `lokasi` text NOT NULL,
  `panjang` decimal(8,2) NOT NULL,
  `lebar` decimal(8,2) NOT NULL,
  `tinggi` decimal(8,2) NOT NULL,
  `jumlah_sensor` int(11) NOT NULL,
  `jumlah_esp` int(11) NOT NULL,
  `volume_maksimal` decimal(10,2) NOT NULL,
  `volume_saat_ini` decimal(10,2) NOT NULL DEFAULT 0.00,
  `persentase_volume` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` enum('normal','warning','critical') NOT NULL DEFAULT 'normal',
  `waktu_kritis` timestamp NULL DEFAULT NULL,
  `led_status` tinyint(1) NOT NULL DEFAULT 0,
  `last_updated` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depos`
--

INSERT INTO `depos` (`id`, `nama_depo`, `lokasi`, `panjang`, `lebar`, `tinggi`, `jumlah_sensor`, `jumlah_esp`, `volume_maksimal`, `volume_saat_ini`, `persentase_volume`, `status`, `waktu_kritis`, `led_status`, `last_updated`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Depo Jogokaryan', 'Jogokaryan', 2.00, 2.00, 2.00, 1, 1, 8.00, 7.28, 91.00, 'critical', NULL, 1, '2025-09-02 00:58:22', 1, '2025-08-25 00:37:16', '2025-09-02 00:58:22'),
(25, 'Depo Prototype', 'Life Media', 0.25, 0.18, 0.18, 1, 1, 0.01, 0.00, 17.65, 'normal', NULL, 0, '2025-09-09 11:08:15', 1, '2025-09-02 21:40:23', '2025-09-09 11:08:15'),
(31, 'Depo Prototype DKGA', 'DKGA', 25.00, 18.00, 18.00, 113, 29, 8100.00, 0.00, 0.00, 'normal', NULL, 0, NULL, 1, '2025-09-15 08:55:04', '2025-09-15 08:55:04');

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
(1, 'default', '{\"uuid\":\"7cfa30ce-b51c-417c-99c0-0d268d3a9bdf\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"127fda14-e940-463f-9978-280cc99215f4\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1755481529,\"delay\":null}', 0, NULL, 1755481529, 1755481529),
(2, 'default', '{\"uuid\":\"7b769a30-7f3d-4c97-acd4-a61202f0fd06\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"c1339e4b-3beb-4062-92bc-775e55e0fa4a\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1755481603,\"delay\":null}', 0, NULL, 1755481603, 1755481603),
(3, 'default', '{\"uuid\":\"a4f964b9-5bf1-45b1-ae23-2bab96b8d790\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"dc1ef2fe-1597-4fc0-906b-0e669e0b4dc0\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1755481692,\"delay\":null}', 0, NULL, 1755481692, 1755481692),
(4, 'default', '{\"uuid\":\"48fe635b-b1ca-45e4-bf16-e0a5981b922a\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"9b438184-af28-423e-8d42-8db7b891e1c9\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1755483307,\"delay\":null}', 0, NULL, 1755483307, 1755483307),
(5, 'default', '{\"uuid\":\"75ce3d79-d2ba-4f9c-8881-d3046d1eb9fe\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"1a13cc9c-d462-4da1-a68d-dc79f579b38e\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1755766380,\"delay\":null}', 0, NULL, 1755766380, 1755766380),
(6, 'default', '{\"uuid\":\"7a3717e9-cc56-450c-bb69-275a19c037f5\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"b32cffa5-9482-4b6b-86f7-acb1db8a9f2d\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1756181784,\"delay\":null}', 0, NULL, 1756181785, 1756181785),
(7, 'default', '{\"uuid\":\"7bce5fd4-a632-4c16-9e23-af828fd25e39\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2704b622-db6f-43c6-b237-2f8f665b2ba3\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758015056,\"delay\":null}', 0, NULL, 1758015057, 1758015057),
(8, 'default', '{\"uuid\":\"09e2aa78-3ca5-466f-8ece-1ea9c1a8f5e1\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"7b8abb8b-1caf-469f-b411-900d00e3ee6e\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758015126,\"delay\":null}', 0, NULL, 1758015126, 1758015126),
(9, 'default', '{\"uuid\":\"cd4eb49f-aa02-4f95-8e5f-b57777543939\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"cde52c8e-d33d-46f2-b290-42cf4e11530d\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758015565,\"delay\":null}', 0, NULL, 1758015565, 1758015565),
(10, 'default', '{\"uuid\":\"3809f2af-c575-4b12-9ff6-85fd74389141\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"8b504f89-150f-483a-a1cf-7796bd22079b\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758015670,\"delay\":null}', 0, NULL, 1758015670, 1758015670),
(11, 'default', '{\"uuid\":\"f9490568-96ea-4449-a1a1-ebbb453fe3e2\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"ff3e0862-dbb4-4a30-9592-ece99d8c8887\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758016771,\"delay\":null}', 0, NULL, 1758016771, 1758016771),
(12, 'default', '{\"uuid\":\"955744b4-3bf0-4cc1-a647-7c99c40f5f49\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"c2b98dc8-103a-4c29-89ff-a0ca2345632f\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758019765,\"delay\":null}', 0, NULL, 1758019765, 1758019765),
(13, 'default', '{\"uuid\":\"17a16e5e-ba53-4884-a0f6-ea75dce9a26a\",\"displayName\":\"App\\\\Notifications\\\\NewReportNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewReportNotification\\\":2:{s:6:\\\"report\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Report\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"7bcc8a6f-b6cf-4c23-96c5-635928e7c504\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1758022447,\"delay\":null}', 0, NULL, 1758022447, 1758022447);

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
(4, '2025_08_03_054820_create_depos_table', 1),
(5, '2025_08_03_055535_create_sensor_readings_table', 1),
(6, '2025_08_03_055642_create_reports_table', 1),
(7, '2025_08_03_055738_create_notifications_table', 1),
(8, '2025_08_03_055828_create_volume_history_table', 1),
(9, '2025_08_03_165040_add_report_id_to_reports_table', 1),
(10, '2025_08_07_040026_create_personal_access_tokens_table', 1),
(11, '2025_08_12_025049_add_waktu_kritis_to_depos_table', 2),
(12, '2025_08_12_031925_create_abnormal_readings_table', 3),
(13, '2025_08_12_040546_add_acknowledged_at_to_abnormal_readings_table', 4),
(14, '2025_08_15_072338_add_foto_to_reports_table', 5),
(15, '2025_08_20_033415_add_morphs_to_notifications_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `target_audience` varchar(255) NOT NULL DEFAULT 'admin',
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_id` varchar(255) NOT NULL,
  `depo_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `kategori` enum('overload','kerusakan_sensor','sampah_berserakan','bau_tidak_sedap','lainnya') NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('pending','in_progress','resolved','rejected') NOT NULL DEFAULT 'pending',
  `admin_response` text DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_id`, `depo_id`, `tanggal_laporan`, `kategori`, `deskripsi`, `foto`, `status`, `admin_response`, `resolved_at`, `created_at`, `updated_at`) VALUES
(20, 'RPT-2025-001', 1, '2025-08-26', 'overload', 'bos iki sampah e wes penuh', NULL, 'pending', NULL, NULL, '2025-08-25 21:16:22', '2025-08-25 21:16:22'),
(21, 'RPT-2025-002', 31, '2025-09-16', 'kerusakan_sensor', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL, 'pending', NULL, NULL, '2025-09-16 09:30:52', '2025-09-16 09:30:52'),
(22, 'RPT-2025-003', 25, '2025-09-16', 'overload', 'aaaaaaaaaaaaaaaaaaaaaa', NULL, 'pending', NULL, NULL, '2025-09-16 09:32:06', '2025-09-16 09:32:06'),
(23, 'RPT-2025-004', 25, '2025-09-16', 'overload', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL, 'pending', NULL, NULL, '2025-09-16 09:39:19', '2025-09-16 09:39:19'),
(24, 'RPT-2025-005', 25, '2025-09-16', 'overload', 'jhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', NULL, 'pending', NULL, NULL, '2025-09-16 09:41:10', '2025-09-16 09:41:10'),
(25, 'RPT-2025-006', 25, '2025-09-16', 'overload', 'sssssssssssssssssssssssssss', NULL, 'pending', NULL, NULL, '2025-09-16 09:59:31', '2025-09-16 09:59:31'),
(26, 'RPT-2025-007', 25, '2025-09-16', 'kerusakan_sensor', 'tesssssssssssssssssss', NULL, 'resolved', NULL, '2025-09-16 11:31:39', '2025-09-16 10:49:25', '2025-09-16 11:31:39'),
(27, 'RPT-2025-008', 25, '2025-09-16', 'overload', 'sampah e kebak lek ndang di buak', NULL, 'pending', NULL, NULL, '2025-09-16 11:34:05', '2025-09-16 11:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_readings`
--

CREATE TABLE `sensor_readings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depo_id` bigint(20) UNSIGNED NOT NULL,
  `esp_id` varchar(255) NOT NULL,
  `volume` decimal(8,4) NOT NULL,
  `reading_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_readings`
--

INSERT INTO `sensor_readings` (`id`, `depo_id`, `esp_id`, `volume`, `reading_time`, `created_at`, `updated_at`) VALUES
(251, 1, 'ESP-001', 0.0000, '2025-08-25 19:22:56', '2025-08-25 19:22:56', '2025-08-25 19:22:56'),
(252, 1, 'ESP-001', 0.0000, '2025-08-25 19:24:02', '2025-08-25 19:24:02', '2025-08-25 19:24:02'),
(253, 1, 'ESP-001', 18.5000, '2025-08-25 19:25:07', '2025-08-25 19:25:07', '2025-08-25 19:25:07'),
(254, 1, 'ESP-001', 0.0000, '2025-08-25 19:26:12', '2025-08-25 19:26:12', '2025-08-25 19:26:12'),
(255, 1, 'ESP-001', 0.0000, '2025-08-25 19:27:28', '2025-08-25 19:27:28', '2025-08-25 19:27:28'),
(256, 1, 'ESP-001', 0.0000, '2025-08-25 19:27:31', '2025-08-25 19:27:31', '2025-08-25 19:27:31'),
(257, 1, 'ESP-001', 0.0000, '2025-08-25 19:28:36', '2025-08-25 19:28:36', '2025-08-25 19:28:36'),
(258, 1, 'ESP-001', 0.0000, '2025-08-25 19:29:42', '2025-08-25 19:29:42', '2025-08-25 19:29:42'),
(259, 1, 'ESP-001', 93.5000, '2025-08-25 19:31:57', '2025-08-25 19:31:57', '2025-08-25 19:31:57'),
(260, 1, 'ESP-001', 44.5000, '2025-08-25 19:35:12', '2025-08-25 19:35:12', '2025-08-25 19:35:12'),
(261, 1, 'ESP-001', 77.5000, '2025-08-25 19:37:23', '2025-08-25 19:37:23', '2025-08-25 19:37:23'),
(262, 1, 'ESP-001', 0.0000, '2025-08-25 19:38:28', '2025-08-25 19:38:28', '2025-08-25 19:38:28'),
(263, 1, 'ESP-001', 0.0000, '2025-08-25 19:39:34', '2025-08-25 19:39:34', '2025-08-25 19:39:34'),
(264, 1, 'ESP-001', 85.0000, '2025-08-25 19:41:45', '2025-08-25 19:41:45', '2025-08-25 19:41:45'),
(265, 1, 'ESP-001', 94.0000, '2025-08-25 19:42:51', '2025-08-25 19:42:51', '2025-08-25 19:42:51'),
(266, 1, 'ESP-001', 95.5000, '2025-08-25 19:43:56', '2025-08-25 19:43:56', '2025-08-25 19:43:56'),
(267, 1, 'ESP-001', 0.0000, '2025-08-25 19:45:04', '2025-08-25 19:45:04', '2025-08-25 19:45:04'),
(268, 1, 'ESP-001', 0.0000, '2025-08-25 19:46:10', '2025-08-25 19:46:10', '2025-08-25 19:46:10'),
(269, 1, 'ESP-001', 72.5000, '2025-08-25 19:47:16', '2025-08-25 19:47:16', '2025-08-25 19:47:16'),
(270, 1, 'ESP-001', 97.0000, '2025-08-25 19:48:21', '2025-08-25 19:48:21', '2025-08-25 19:48:21'),
(271, 1, 'ESP-001', 92.0000, '2025-08-25 19:49:27', '2025-08-25 19:49:27', '2025-08-25 19:49:27'),
(272, 1, 'ESP-001', 97.0000, '2025-08-25 19:50:33', '2025-08-25 19:50:33', '2025-08-25 19:50:33'),
(273, 1, 'ESP-001', 81.5000, '2025-08-25 19:51:18', '2025-08-25 19:51:18', '2025-08-25 19:51:18'),
(274, 1, 'ESP-001', 91.5000, '2025-08-25 19:51:53', '2025-08-25 19:51:53', '2025-08-25 19:51:53'),
(275, 1, 'ESP-001', 0.0000, '2025-08-25 19:52:58', '2025-08-25 19:52:58', '2025-08-25 19:52:58'),
(276, 1, 'ESP-001', 79.0000, '2025-08-25 19:54:07', '2025-08-25 19:54:07', '2025-08-25 19:54:07'),
(277, 1, 'ESP-001', 0.0000, '2025-08-25 19:55:24', '2025-08-25 19:55:24', '2025-08-25 19:55:24'),
(278, 1, 'ESP-001', 89.5000, '2025-08-25 19:55:40', '2025-08-25 19:55:40', '2025-08-25 19:55:40'),
(279, 1, 'ESP-001', 80.0000, '2025-08-25 19:56:46', '2025-08-25 19:56:46', '2025-08-25 19:56:46'),
(280, 1, 'ESP-001', 84.5000, '2025-08-25 19:57:04', '2025-08-25 19:57:04', '2025-08-25 19:57:04'),
(281, 1, 'ESP-001', 96.5000, '2025-08-25 19:57:29', '2025-08-25 19:57:29', '2025-08-25 19:57:29'),
(282, 1, 'ESP-001', 95.5000, '2025-08-25 19:57:44', '2025-08-25 19:57:44', '2025-08-25 19:57:44'),
(283, 1, 'ESP-001', 0.0000, '2025-08-25 20:36:25', '2025-08-25 20:36:25', '2025-08-25 20:36:25'),
(284, 1, 'ESP-001', 41.5000, '2025-08-25 20:36:40', '2025-08-25 20:36:40', '2025-08-25 20:36:40'),
(285, 1, 'ESP-001', 48.0000, '2025-08-25 20:36:56', '2025-08-25 20:36:56', '2025-08-25 20:36:56'),
(286, 1, 'ESP-001', 42.0000, '2025-08-25 20:37:12', '2025-08-25 20:37:12', '2025-08-25 20:37:12'),
(287, 1, 'ESP-001', 40.0000, '2025-08-25 20:37:28', '2025-08-25 20:37:28', '2025-08-25 20:37:28'),
(288, 1, 'ESP-001', 62.0000, '2025-08-25 20:37:43', '2025-08-25 20:37:43', '2025-08-25 20:37:43'),
(289, 1, 'ESP-001', 83.0000, '2025-08-25 20:38:17', '2025-08-25 20:38:17', '2025-08-25 20:38:17'),
(290, 1, 'ESP-001', 38.0000, '2025-08-25 20:39:21', '2025-08-25 20:39:21', '2025-08-25 20:39:21'),
(291, 1, 'ESP-001', 96.5000, '2025-08-25 20:40:27', '2025-08-25 20:40:27', '2025-08-25 20:40:27'),
(292, 1, 'ESP-001', 0.0000, '2025-08-25 20:41:32', '2025-08-25 20:41:32', '2025-08-25 20:41:32'),
(293, 1, 'ESP-001', 78.0000, '2025-08-25 20:54:53', '2025-08-25 20:54:53', '2025-08-25 20:54:53'),
(294, 1, 'ESP-001', 94.5000, '2025-08-25 23:19:43', '2025-08-25 23:19:43', '2025-08-25 23:19:43'),
(295, 1, 'ESP-001', 50.5000, '2025-08-25 23:20:47', '2025-08-25 23:20:47', '2025-08-25 23:20:47'),
(296, 1, 'ESP-001', 52.5000, '2025-08-25 23:21:52', '2025-08-25 23:21:52', '2025-08-25 23:21:52'),
(297, 1, 'ESP-001', 0.0000, '2025-08-25 23:22:58', '2025-08-25 23:22:58', '2025-08-25 23:22:58'),
(298, 1, 'ESP-001', 17.5000, '2025-08-25 23:24:03', '2025-08-25 23:24:03', '2025-08-25 23:24:03'),
(299, 1, 'ESP-001', 87.5000, '2025-08-25 23:25:08', '2025-08-25 23:25:08', '2025-08-25 23:25:08'),
(300, 1, 'ESP-001', 82.5000, '2025-08-25 23:26:14', '2025-08-25 23:26:14', '2025-08-25 23:26:14'),
(301, 1, 'ESP-001', 90.5000, '2025-08-25 23:27:19', '2025-08-25 23:27:19', '2025-08-25 23:27:19'),
(302, 1, 'ESP-001', 56.0000, '2025-08-25 23:28:24', '2025-08-25 23:28:24', '2025-08-25 23:28:24'),
(303, 1, 'ESP-001', 59.5000, '2025-08-25 23:29:30', '2025-08-25 23:29:30', '2025-08-25 23:29:30'),
(304, 1, 'ESP-001', 17.5000, '2025-09-02 00:00:14', '2025-09-02 00:00:14', '2025-09-02 00:00:14'),
(305, 1, 'ESP-001', 0.0000, '2025-09-02 00:01:20', '2025-09-02 00:01:20', '2025-09-02 00:01:20'),
(306, 1, 'ESP-001', 0.0000, '2025-09-02 00:30:33', '2025-09-02 00:30:33', '2025-09-02 00:30:33'),
(307, 1, 'ESP-001', 0.0000, '2025-09-02 00:32:52', '2025-09-02 00:32:52', '2025-09-02 00:32:52'),
(308, 1, 'ESP-001', 0.0000, '2025-09-02 00:37:02', '2025-09-02 00:37:02', '2025-09-02 00:37:02'),
(309, 1, 'ESP-001', 0.0000, '2025-09-02 00:37:10', '2025-09-02 00:37:10', '2025-09-02 00:37:10'),
(310, 1, 'ESP-001', 93.0000, '2025-09-02 00:47:52', '2025-09-02 00:47:52', '2025-09-02 00:47:52'),
(311, 1, 'ESP-001', 0.0000, '2025-09-02 00:53:22', '2025-09-02 00:53:22', '2025-09-02 00:53:22'),
(312, 1, 'ESP-001', 85.5000, '2025-09-02 00:56:32', '2025-09-02 00:56:32', '2025-09-02 00:56:32'),
(313, 1, 'ESP-001', 91.0000, '2025-09-02 00:58:24', '2025-09-02 00:58:24', '2025-09-02 00:58:24'),
(314, 25, 'ESP-003', 5.5600, '2025-09-02 21:57:45', '2025-09-02 21:57:45', '2025-09-02 21:57:45'),
(315, 25, 'ESP-003', 27.7800, '2025-09-02 21:59:56', '2025-09-02 21:59:56', '2025-09-02 21:59:56'),
(316, 25, 'ESP-003', 33.3300, '2025-09-02 22:01:00', '2025-09-02 22:01:00', '2025-09-02 22:01:00'),
(317, 25, 'ESP-003', 16.6700, '2025-09-02 22:02:05', '2025-09-02 22:02:05', '2025-09-02 22:02:05'),
(318, 25, 'ESP-003', 50.0000, '2025-09-02 22:03:11', '2025-09-02 22:03:11', '2025-09-02 22:03:11'),
(319, 25, 'ESP-003', 33.3300, '2025-09-02 22:05:21', '2025-09-02 22:05:21', '2025-09-02 22:05:21'),
(320, 25, 'ESP-003', 38.8900, '2025-09-02 22:06:26', '2025-09-02 22:06:26', '2025-09-02 22:06:26'),
(321, 25, 'ESP-003', 38.8900, '2025-09-02 22:07:31', '2025-09-02 22:07:31', '2025-09-02 22:07:31'),
(322, 25, 'ESP-003', 38.8900, '2025-09-02 22:08:36', '2025-09-02 22:08:36', '2025-09-02 22:08:36'),
(323, 25, 'ESP-003', 27.7800, '2025-09-02 22:09:42', '2025-09-02 22:09:42', '2025-09-02 22:09:42'),
(324, 25, 'ESP-003', 27.7800, '2025-09-02 22:10:47', '2025-09-02 22:10:47', '2025-09-02 22:10:47'),
(325, 25, 'ESP-003', 66.6700, '2025-09-02 22:11:51', '2025-09-02 22:11:51', '2025-09-02 22:11:51'),
(326, 25, 'ESP-003', 66.6700, '2025-09-02 22:12:59', '2025-09-02 22:12:59', '2025-09-02 22:12:59'),
(327, 25, 'ESP-003', 5.5600, '2025-09-03 00:53:52', '2025-09-03 00:53:52', '2025-09-03 00:53:52'),
(328, 25, 'ESP-003', 11.1100, '2025-09-03 00:54:58', '2025-09-03 00:54:58', '2025-09-03 00:54:58'),
(329, 25, 'ESP-003', 11.1100, '2025-09-03 00:56:03', '2025-09-03 00:56:03', '2025-09-03 00:56:03'),
(330, 25, 'ESP-003', 5.5600, '2025-09-03 00:57:09', '2025-09-03 00:57:09', '2025-09-03 00:57:09'),
(331, 25, 'ESP-003', 11.1100, '2025-09-03 00:58:14', '2025-09-03 00:58:14', '2025-09-03 00:58:14'),
(332, 25, 'ESP-003', 11.1100, '2025-09-03 00:59:19', '2025-09-03 00:59:19', '2025-09-03 00:59:19'),
(333, 25, 'ESP-003', 11.1100, '2025-09-03 01:00:24', '2025-09-03 01:00:24', '2025-09-03 01:00:24'),
(334, 25, 'ESP-003', 11.1100, '2025-09-03 01:01:30', '2025-09-03 01:01:30', '2025-09-03 01:01:30'),
(335, 25, 'ESP-003', 11.1100, '2025-09-03 01:02:35', '2025-09-03 01:02:35', '2025-09-03 01:02:35'),
(336, 25, 'ESP-003', 11.1100, '2025-09-03 01:03:41', '2025-09-03 01:03:41', '2025-09-03 01:03:41'),
(337, 25, 'ESP-003', 5.5600, '2025-09-03 01:04:46', '2025-09-03 01:04:46', '2025-09-03 01:04:46'),
(338, 25, 'ESP-003', 5.5600, '2025-09-03 01:05:51', '2025-09-03 01:05:51', '2025-09-03 01:05:51'),
(339, 25, 'ESP-003', 5.5600, '2025-09-03 01:06:57', '2025-09-03 01:06:57', '2025-09-03 01:06:57'),
(340, 25, 'ESP-003', 5.5600, '2025-09-03 01:08:02', '2025-09-03 01:08:02', '2025-09-03 01:08:02'),
(341, 25, 'ESP-003', 11.1100, '2025-09-03 01:09:08', '2025-09-03 01:09:08', '2025-09-03 01:09:08'),
(342, 25, 'ESP-003', 27.7800, '2025-09-03 01:10:13', '2025-09-03 01:10:13', '2025-09-03 01:10:13'),
(343, 25, 'ESP-003', 61.1100, '2025-09-03 01:11:18', '2025-09-03 01:11:18', '2025-09-03 01:11:18'),
(344, 25, 'ESP-003', 0.0000, '2025-09-03 01:12:23', '2025-09-03 01:12:23', '2025-09-03 01:12:23'),
(345, 25, 'ESP-003', 55.5600, '2025-09-03 01:13:27', '2025-09-03 01:13:27', '2025-09-03 01:13:27'),
(346, 25, 'ESP-003', 5.5600, '2025-09-03 01:14:33', '2025-09-03 01:14:33', '2025-09-03 01:14:33'),
(347, 25, 'ESP-003', 5.5600, '2025-09-03 01:15:37', '2025-09-03 01:15:37', '2025-09-03 01:15:37'),
(348, 25, 'ESP-003', 11.1100, '2025-09-03 01:16:42', '2025-09-03 01:16:42', '2025-09-03 01:16:42'),
(349, 25, 'ESP-003', 11.1100, '2025-09-03 01:17:47', '2025-09-03 01:17:47', '2025-09-03 01:17:47'),
(350, 25, 'ESP-003', 11.1100, '2025-09-03 01:18:52', '2025-09-03 01:18:52', '2025-09-03 01:18:52'),
(351, 25, 'ESP-003', 11.1100, '2025-09-03 01:19:57', '2025-09-03 01:19:57', '2025-09-03 01:19:57'),
(352, 25, 'ESP-003', 11.1100, '2025-09-03 01:21:03', '2025-09-03 01:21:03', '2025-09-03 01:21:03'),
(353, 25, 'ESP-003', 11.1100, '2025-09-03 01:22:10', '2025-09-03 01:22:10', '2025-09-03 01:22:10'),
(354, 25, 'ESP-003', 11.1100, '2025-09-04 02:16:47', '2025-09-04 02:16:47', '2025-09-04 02:16:47'),
(355, 25, 'ESP-003', 11.1100, '2025-09-04 02:17:46', '2025-09-04 02:17:46', '2025-09-04 02:17:46'),
(356, 25, 'ESP-003', 11.1100, '2025-09-04 02:18:51', '2025-09-04 02:18:51', '2025-09-04 02:18:51'),
(357, 25, 'ESP-003', 27.7800, '2025-09-04 02:21:01', '2025-09-04 02:21:01', '2025-09-04 02:21:01'),
(358, 25, 'ESP-003', 11.1100, '2025-09-04 02:22:07', '2025-09-04 02:22:07', '2025-09-04 02:22:07'),
(359, 25, 'ESP-003', 11.1100, '2025-09-04 02:23:12', '2025-09-04 02:23:12', '2025-09-04 02:23:12'),
(360, 25, 'ESP-003', 11.1100, '2025-09-04 02:24:17', '2025-09-04 02:24:17', '2025-09-04 02:24:17'),
(361, 25, 'ESP-003', 38.8900, '2025-09-04 02:25:23', '2025-09-04 02:25:23', '2025-09-04 02:25:23'),
(362, 25, 'ESP-003', 38.8900, '2025-09-04 02:26:28', '2025-09-04 02:26:28', '2025-09-04 02:26:28'),
(363, 25, 'ESP-003', 38.8900, '2025-09-04 02:27:33', '2025-09-04 02:27:33', '2025-09-04 02:27:33'),
(364, 25, 'ESP-003', 38.8900, '2025-09-04 02:28:38', '2025-09-04 02:28:38', '2025-09-04 02:28:38'),
(365, 25, 'ESP-003', 11.1100, '2025-09-04 02:29:43', '2025-09-04 02:29:43', '2025-09-04 02:29:43'),
(366, 25, 'ESP-003', 11.1100, '2025-09-04 02:30:48', '2025-09-04 02:30:48', '2025-09-04 02:30:48'),
(367, 25, 'ESP-003', 11.1100, '2025-09-04 02:31:53', '2025-09-04 02:31:53', '2025-09-04 02:31:53'),
(368, 25, 'ESP-003', 11.1100, '2025-09-04 02:48:49', '2025-09-04 02:48:49', '2025-09-04 02:48:49'),
(369, 25, 'ESP-003', 11.1100, '2025-09-04 02:50:07', '2025-09-04 02:50:07', '2025-09-04 02:50:07'),
(370, 25, 'ESP-003', 11.1100, '2025-09-04 02:51:12', '2025-09-04 02:51:12', '2025-09-04 02:51:12'),
(371, 25, 'ESP-003', 11.1100, '2025-09-04 02:52:16', '2025-09-04 02:52:16', '2025-09-04 02:52:16'),
(372, 25, 'ESP-003', 11.1100, '2025-09-04 02:53:21', '2025-09-04 02:53:21', '2025-09-04 02:53:21'),
(373, 25, 'ESP-003', 0.0000, '2025-09-04 02:54:26', '2025-09-04 02:54:26', '2025-09-04 02:54:26'),
(374, 25, 'ESP-003', 33.3300, '2025-09-04 02:55:31', '2025-09-04 02:55:31', '2025-09-04 02:55:31'),
(375, 25, 'ESP-003', 38.8900, '2025-09-04 03:25:48', '2025-09-04 03:25:48', '2025-09-04 03:25:48'),
(376, 25, 'ESP-003', 44.4400, '2025-09-04 03:26:54', '2025-09-04 03:26:54', '2025-09-04 03:26:54'),
(377, 25, 'ESP-003', 27.7800, '2025-09-04 03:27:59', '2025-09-04 03:27:59', '2025-09-04 03:27:59'),
(378, 25, 'ESP-003', 44.4400, '2025-09-04 03:29:04', '2025-09-04 03:29:04', '2025-09-04 03:29:04'),
(379, 25, 'ESP-003', 44.4400, '2025-09-04 03:30:09', '2025-09-04 03:30:09', '2025-09-04 03:30:09'),
(380, 25, 'ESP-003', 38.8900, '2025-09-04 03:31:16', '2025-09-04 03:31:16', '2025-09-04 03:31:16'),
(381, 25, 'ESP-003', 38.8900, '2025-09-04 03:32:21', '2025-09-04 03:32:21', '2025-09-04 03:32:21'),
(382, 25, 'ESP-003', 38.8900, '2025-09-04 03:33:26', '2025-09-04 03:33:26', '2025-09-04 03:33:26'),
(383, 25, 'ESP-003', 44.4400, '2025-09-04 03:34:32', '2025-09-04 03:34:32', '2025-09-04 03:34:32'),
(384, 25, 'ESP-003', 44.4400, '2025-09-04 03:35:38', '2025-09-04 03:35:38', '2025-09-04 03:35:38'),
(385, 25, 'ESP-003', 44.4400, '2025-09-04 03:36:43', '2025-09-04 03:36:43', '2025-09-04 03:36:43'),
(386, 25, 'ESP-003', 44.4400, '2025-09-04 03:37:49', '2025-09-04 03:37:49', '2025-09-04 03:37:49'),
(387, 25, 'ESP-003', 38.8900, '2025-09-04 03:38:54', '2025-09-04 03:38:54', '2025-09-04 03:38:54'),
(388, 25, 'ESP-003', 38.8900, '2025-09-04 03:39:59', '2025-09-04 03:39:59', '2025-09-04 03:39:59'),
(389, 25, 'ESP-003', 47.0600, '2025-09-07 21:06:55', '2025-09-07 21:06:55', '2025-09-07 21:06:55'),
(390, 25, 'ESP-003', 5.8800, '2025-09-07 21:08:00', '2025-09-07 21:08:00', '2025-09-07 21:08:00'),
(391, 25, 'ESP-003', 2.9400, '2025-09-07 21:09:05', '2025-09-07 21:09:05', '2025-09-07 21:09:05'),
(392, 25, 'ESP-003', 2.9400, '2025-09-07 21:10:09', '2025-09-07 21:10:09', '2025-09-07 21:10:09'),
(393, 25, 'ESP-003', 11.7600, '2025-09-09 10:57:23', '2025-09-09 10:57:23', '2025-09-09 10:57:23'),
(394, 25, 'ESP-003', 0.0000, '2025-09-09 10:58:29', '2025-09-09 10:58:29', '2025-09-09 10:58:29'),
(395, 25, 'ESP-003', 8.8200, '2025-09-09 10:59:33', '2025-09-09 10:59:33', '2025-09-09 10:59:33'),
(396, 25, 'ESP-003', 14.7100, '2025-09-09 11:00:38', '2025-09-09 11:00:38', '2025-09-09 11:00:38'),
(397, 25, 'ESP-003', 82.3500, '2025-09-09 11:01:43', '2025-09-09 11:01:43', '2025-09-09 11:01:43'),
(398, 25, 'ESP-003', 2.9400, '2025-09-09 11:02:48', '2025-09-09 11:02:48', '2025-09-09 11:02:48'),
(399, 25, 'ESP-003', 11.7600, '2025-09-09 11:03:51', '2025-09-09 11:03:51', '2025-09-09 11:03:51'),
(400, 25, 'ESP-003', 2.9400, '2025-09-09 11:06:06', '2025-09-09 11:06:06', '2025-09-09 11:06:06'),
(401, 25, 'ESP-003', 0.0000, '2025-09-09 11:07:10', '2025-09-09 11:07:10', '2025-09-09 11:07:10'),
(402, 25, 'ESP-003', 17.6500, '2025-09-09 11:08:15', '2025-09-09 11:08:15', '2025-09-09 11:08:15');

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
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin DEVO', 'admin@devo.com', NULL, '$2y$12$rFl.Tqo5FWciWpvK9IOaL.kbl1icEogOLEluNaX9nnFvKaAPQVAka', 'admin', 'C0nczBv9H5hX5v5EVzDqKjVzTvq3WExyBfGnPNttYNbgCFTNsgqiARORBlel', '2025-08-11 00:56:24', '2025-08-11 00:56:24'),
(2, 'Super Admin', 'superadmin@devo.com', NULL, '$2y$12$ID9r3qpvH7YVLA.yIDlDgODf1NmJfyQlX0Q3j6yPpcwme9kdgZM56', 'admin', NULL, '2025-08-11 00:56:24', '2025-08-11 00:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `volume_history`
--

CREATE TABLE `volume_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depo_id` bigint(20) UNSIGNED NOT NULL,
  `volume` decimal(10,2) NOT NULL,
  `persentase` decimal(5,2) NOT NULL,
  `status` enum('normal','warning','critical') NOT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abnormal_readings`
--
ALTER TABLE `abnormal_readings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abnormal_readings_depo_id_foreign` (`depo_id`);

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
-- Indexes for table `depos`
--
ALTER TABLE `depos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_type_created_at_index` (`type`,`created_at`),
  ADD KEY `notifications_is_read_target_audience_index` (`is_read`,`target_audience`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_report_id_unique` (`report_id`),
  ADD KEY `reports_depo_id_foreign` (`depo_id`),
  ADD KEY `reports_report_id_index` (`report_id`),
  ADD KEY `reports_status_index` (`status`),
  ADD KEY `reports_kategori_index` (`kategori`);

--
-- Indexes for table `sensor_readings`
--
ALTER TABLE `sensor_readings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sensor_readings_depo_id_reading_time_index` (`depo_id`,`reading_time`),
  ADD KEY `sensor_readings_esp_id_index` (`esp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `volume_history`
--
ALTER TABLE `volume_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volume_history_depo_id_recorded_at_index` (`depo_id`,`recorded_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abnormal_readings`
--
ALTER TABLE `abnormal_readings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `depos`
--
ALTER TABLE `depos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sensor_readings`
--
ALTER TABLE `sensor_readings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `volume_history`
--
ALTER TABLE `volume_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abnormal_readings`
--
ALTER TABLE `abnormal_readings`
  ADD CONSTRAINT `abnormal_readings_depo_id_foreign` FOREIGN KEY (`depo_id`) REFERENCES `depos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_depo_id_foreign` FOREIGN KEY (`depo_id`) REFERENCES `depos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sensor_readings`
--
ALTER TABLE `sensor_readings`
  ADD CONSTRAINT `sensor_readings_depo_id_foreign` FOREIGN KEY (`depo_id`) REFERENCES `depos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `volume_history`
--
ALTER TABLE `volume_history`
  ADD CONSTRAINT `volume_history_depo_id_foreign` FOREIGN KEY (`depo_id`) REFERENCES `depos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2025 pada 04.14
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'admin pengelola akun'),
(2, 'user', 'user pemiliki beberapa perusahaan'),
(3, 'petugas', 'petugas yang mengecek laporan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 1),
(1, 1),
(1, 1),
(1, 2),
(1, 2),
(1, 2),
(1, 2),
(2, 2),
(2, 2),
(2, 2),
(2, 2),
(2, 2),
(2, 2),
(3, 2),
(3, 2),
(3, 3),
(3, 3),
(3, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 11),
(1, 11),
(1, 11),
(1, 20),
(2, 9),
(2, 9),
(2, 9),
(2, 9),
(2, 12),
(2, 12),
(2, 12),
(2, 12),
(2, 19),
(2, 21),
(3, 15),
(3, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'muhammad', 2, '2025-05-23 23:06:03', 0),
(2, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-23 23:49:22', 1),
(3, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-23 23:49:32', 1),
(4, '::1', 'HAYYYA', NULL, '2025-05-23 23:56:18', 0),
(5, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-23 23:56:37', 1),
(6, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 00:03:04', 1),
(7, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 00:03:29', 1),
(8, '::1', 'HAYYYA', NULL, '2025-05-24 00:06:51', 0),
(9, '::1', 'HAYYYA', NULL, '2025-05-24 00:07:03', 0),
(10, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 00:07:25', 1),
(11, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 00:22:34', 1),
(12, '::1', 'HAYYYA', NULL, '2025-05-24 00:23:00', 0),
(13, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 00:23:07', 1),
(14, '::1', 'HAYYYA', NULL, '2025-05-24 00:38:06', 0),
(15, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 00:38:16', 1),
(16, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 02:19:23', 1),
(17, '::1', 'f1d022013aanhar@gmail.com', 10, '2025-05-24 13:35:50', 1),
(18, '::1', 'HAYYYA', NULL, '2025-05-24 17:22:12', 0),
(19, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-24 17:22:37', 1),
(20, '::1', 'f1d022013aanhar@gmail.com', 10, '2025-05-24 17:58:56', 1),
(21, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-24 18:12:43', 1),
(22, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-24 20:05:20', 1),
(23, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 00:32:22', 1),
(24, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 01:24:35', 1),
(25, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 01:27:29', 1),
(26, '::1', 'admin', NULL, '2025-05-25 01:32:55', 0),
(27, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 01:33:10', 1),
(28, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-25 01:33:28', 1),
(29, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 01:43:27', 1),
(30, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 01:50:36', 1),
(31, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 01:50:54', 1),
(32, '::1', 'admin', NULL, '2025-05-25 02:11:37', 0),
(33, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 02:12:01', 1),
(34, '::1', 'solihinmuhammadanhar@gmail.com', 9, '2025-05-25 02:48:08', 1),
(35, '::1', 'admin', NULL, '2025-05-25 03:38:23', 0),
(36, '::1', 'admin', NULL, '2025-05-25 03:38:32', 0),
(37, '::1', 'admin', NULL, '2025-05-25 03:39:07', 0),
(38, '::1', 'admin', NULL, '2025-05-25 03:39:41', 0),
(39, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 03:40:26', 1),
(40, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 04:35:50', 1),
(41, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 04:44:53', 1),
(42, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-25 06:38:41', 1),
(43, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 06:40:17', 1),
(44, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 07:18:24', 1),
(45, '::1', 'ksrpmiunitunram06@gmail.com', 13, '2025-05-25 07:43:35', 1),
(46, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 13:42:28', 1),
(47, '::1', 'ksrpmiunitunram08@gmail.com', 14, '2025-05-25 18:09:34', 1),
(48, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-25 18:23:49', 1),
(49, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-26 00:31:03', 1),
(50, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-26 01:06:34', 1),
(51, '::1', 'petugas', NULL, '2025-05-26 02:38:21', 0),
(52, '::1', 'petugass', NULL, '2025-05-26 02:39:22', 0),
(53, '::1', 'petugass', NULL, '2025-05-26 02:39:44', 0),
(54, '::1', 'petugass', NULL, '2025-05-26 02:40:21', 0),
(55, '::1', 'petugas', NULL, '2025-05-26 02:40:36', 0),
(56, '::1', 'petugas', NULL, '2025-05-26 02:40:54', 0),
(57, '::1', 'petugass', NULL, '2025-05-26 02:41:22', 0),
(58, '::1', 'petugass', NULL, '2025-05-26 02:42:10', 0),
(59, '::1', 'petugas', NULL, '2025-05-26 02:42:31', 0),
(60, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-05-26 02:43:38', 1),
(61, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-05-26 02:49:51', 1),
(62, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-26 03:04:58', 1),
(63, '::1', 'user', NULL, '2025-05-26 03:20:27', 0),
(64, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-26 03:20:45', 1),
(65, '::1', 'petuasnya', NULL, '2025-05-26 04:05:24', 0),
(66, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-05-26 04:05:35', 1),
(67, '::1', 'admin', NULL, '2025-05-27 01:15:21', 0),
(68, '::1', 'petugasnya', NULL, '2025-05-27 01:15:32', 0),
(69, '::1', 'petugasnya', NULL, '2025-05-27 01:15:45', 0),
(70, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-27 01:16:00', 1),
(71, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-27 01:16:52', 1),
(72, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-27 01:56:15', 1),
(73, '::1', 'ksrpmiunitunram11@gmail.com', 16, '2025-05-27 02:42:52', 1),
(74, '::1', 'ksrpmiunitunram11@gmail.com', 16, '2025-05-27 02:43:30', 1),
(75, '::1', 'ksrpmiunitunram11@gmail.com', 16, '2025-05-27 02:58:43', 1),
(76, '::1', 'f1d022013anhar@gmail.com', 11, '2025-05-27 03:02:36', 1),
(77, '::1', 'bem@gamil.com', 19, '2025-05-27 03:21:36', 1),
(78, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-27 05:34:42', 1),
(79, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-05-27 06:35:34', 1),
(80, '::1', 'petugas', NULL, '2025-05-27 07:08:36', 0),
(81, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-05-27 07:08:51', 1),
(82, '::1', 'muhammadanharsolihin@gmail.com', 12, '2025-06-03 02:50:40', 1),
(83, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-03 02:51:26', 1),
(84, '::1', 'f1d022013anhar@gmail.com', 11, '2025-06-03 02:52:58', 1),
(85, '::1', 'YENI@GMAIL.COM', 21, '2025-06-03 02:54:16', 1),
(86, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-03 02:58:46', 1),
(87, '::1', 'admin', NULL, '2025-06-03 02:59:51', 0),
(88, '::1', 'f1d022013anhar@gmail.com', 11, '2025-06-03 03:00:04', 1),
(89, '::1', 'YENI', NULL, '2025-06-03 03:02:07', 0),
(90, '::1', 'YENI@GMAIL.COM', 21, '2025-06-03 03:02:18', 1),
(91, '::1', 'YENI@GMAIL.COM', 21, '2025-06-03 03:04:49', 1),
(92, '::1', 'YENI@GMAIL.COM', 21, '2025-06-03 04:03:15', 1),
(93, '::1', 'YENI@GMAIL.COM', 21, '2025-06-03 04:16:50', 1),
(94, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-03 04:37:42', 1),
(95, '::1', 'YENI@GMAIL.COM', 21, '2025-06-04 14:40:46', 1),
(96, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-04 15:11:53', 1),
(97, '::1', 'YENI@GMAIL.COM', 21, '2025-06-04 15:19:21', 1),
(98, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-04 15:23:43', 1),
(99, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-04 15:44:53', 1),
(100, '::1', 'YENI@GMAIL.COM', 21, '2025-06-04 15:53:54', 1),
(101, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-04 15:57:29', 1),
(102, '::1', 'YENI@GMAIL.COM', 21, '2025-06-04 16:26:41', 1),
(103, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-04 16:33:54', 1),
(104, '::1', 'YENI@GMAIL.COM', 21, '2025-06-04 16:34:11', 1),
(105, '::1', 'admin', NULL, '2025-06-05 00:39:23', 0),
(106, '::1', 'f1d022013anhar@gmail.com', 11, '2025-06-05 00:39:35', 1),
(107, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-05 01:58:19', 1),
(108, '::1', 'YENI', NULL, '2025-06-05 14:15:14', 0),
(109, '::1', 'YENI@GMAIL.COM', 21, '2025-06-05 14:15:24', 1),
(110, '::1', 'YENI@GMAIL.COM', 21, '2025-06-10 01:59:30', 1),
(111, '::1', 'YENI@GMAIL.COM', 21, '2025-06-12 01:54:03', 1),
(112, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-12 01:56:52', 1),
(113, '::1', 'f1d022013anhar@gmail.com', 11, '2025-06-12 01:57:45', 1),
(114, '::1', 'YENI@GMAIL.COM', 21, '2025-06-12 02:00:18', 1),
(115, '::1', 'petugasny', NULL, '2025-06-12 02:01:41', 0),
(116, '::1', 'ksrpmiunitunram06@gmail.com', 15, '2025-06-12 02:01:51', 1),
(117, '::1', 'f1d022013anhar@gmail.com', 11, '2025-06-12 02:03:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'manage-users', 'manage all users'),
(2, 'manage-profile', 'manage profile'),
(3, 'petugas', 'laporan\r\n\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_users_permissions`
--

INSERT INTO `auth_users_permissions` (`user_id`, `permission_id`) VALUES
(15, 3),
(15, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koordinat`
--

CREATE TABLE `koordinat` (
  `latitude_deg` int(11) NOT NULL,
  `latitude_min` int(11) NOT NULL,
  `latitude_sec` int(11) NOT NULL,
  `latitude_dir` enum('N','S') NOT NULL,
  `longitude_deg` int(11) NOT NULL,
  `longitude_min` int(11) NOT NULL,
  `longitude_sec` int(11) NOT NULL,
  `longitude_dir` enum('E','W') NOT NULL,
  `foto_lokasi` varchar(255) DEFAULT NULL,
  `locationName` varchar(50) NOT NULL,
  `companyName` varchar(50) NOT NULL,
  `permit` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `koordinat`
--

INSERT INTO `koordinat` (`latitude_deg`, `latitude_min`, `latitude_sec`, `latitude_dir`, `longitude_deg`, `longitude_min`, `longitude_sec`, `longitude_dir`, `foto_lokasi`, `locationName`, `companyName`, `permit`) VALUES
(0, 1, 1, 'N', 111, 1, 1, 'E', '1', '', '', 0),
(0, 1, 1, 'N', 111, 1, 1, 'E', '1', '', '', 0),
(6, 9, 21, 'S', 106, 46, 12, 'E', '1747897309_d597b982f719d743082f.png', 'asads', 'Nonea', 0),
(6, 9, 43, 'S', 106, 47, 42, 'E', '1747897324_ac906139b7a47aeadfeb.png', 'asads', 'Nonea', 0),
(6, 10, 31, 'S', 106, 46, 55, 'E', '1747897523_14fa8e467398f844e70f.png', 'asads', 'A', 0),
(6, 10, 35, 'S', 106, 44, 49, 'E', '1747898914_b8a2a8c031d77ff23358.png', 'ampenan selatan', 'king potokopo', 0),
(8, 33, 42, 'S', 116, 4, 27, 'E', '1747918777_179f080be09d7d78e6e4.png', 'ampenan selatan', 'jalan duyung', 0),
(6, 10, 50, 'S', 106, 48, 2, 'E', '1748182099_bd9ed799aa6c73ad3ff4.jpeg', 'jalan saleh sungkar', 'king potokopo', 12345),
(6, 10, 21, 'S', 106, 50, 34, 'E', '1748182740_39d46abb6f7e532dc255.jpeg', 'jalan saleh sungkar', 'king potokopo', 12345),
(6, 10, 58, 'S', 106, 49, 18, 'E', '1748182792_a762de96c1220f53862c.jpeg', 'jalan saleh sungkar', 'king potokopo', 12345),
(6, 11, 19, 'N', 106, 49, 40, 'E', '1748188559_b7108b53147f48b450f8.png', 'ampenan ', 'baru', 245),
(6, 10, 56, 'S', 106, 49, 4, 'E', '1748188602_2258eced317cbd5b016e.jpeg', 'ampenan ', 'baru', 245),
(6, 11, 36, 'S', 106, 48, 44, 'E', '1748194277_0b9dfc09ef07a07e592d.jpeg', 'jalan kepiting', 'pt. gunung rinjanu', 12345),
(8, 35, 6, 'S', 116, 4, 51, 'E', '1748195470_06b9351d05e6ca78b633.png', 'rumah anhar', 'rumah anhar', 83114),
(6, 10, 28, 'S', 106, 47, 17, 'E', '1748219750_f2c2fee3f175760501eb.png', 'rumah anhar', 'rumah anhar', 83114),
(6, 11, 1, 'S', 106, 48, 51, 'E', '1748219995_bd401374e6947660238f.png', 'rumah anhar', 'rumah anhar', 83114),
(6, 9, 36, 'S', 106, 45, 24, 'E', '1748220098_84a0fe7fdd6e163756b2.png', 'rumahku', 'rumahku', 83114),
(6, 9, 46, 'S', 106, 44, 11, 'E', '1748220397_165e78c32b09a4f1fac5.png', 'rumah kkn', 'rumah kkn', 987654),
(8, 36, 42, 'S', 116, 6, 1, 'E', '1748221188_6ba159ec6a1322fc778d.png', 'kampus saya', 'unram', 987654),
(8, 36, 34, 'S', 116, 6, 11, 'E', '1748221228_7934f7e8f6b639d30dfc.png', 'unram', 'unram', 83114),
(8, 36, 42, 'S', 116, 6, 3, 'E', '1748221564_854efce3426226f771d4.png', 'unram', 'unram', 83114),
(8, 34, 57, 'S', 116, 5, 19, 'E', '1748226958_d2943a26d7b218b221d0.png', 'unram', 'unram', 83114),
(8, 34, 55, 'S', 116, 4, 60, 'E', '1748227034_b6847a48c9152e3db415.png', 'rti', 'rti', 1234),
(8, 36, 59, 'S', 116, 5, 16, 'E', '1749523847_ca53881610a074a002a5.png', 'jem[ong baru', 'pt coba ', 123456789);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `judul`, `file`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'asasa', '1749048787_ac2689ac55502ff8fa62.pdf', 21, '', '2025-06-04 14:53:07', '2025-06-04 15:11:59'),
(2, 'laporan pertama', '1749050595_a9684711c3f0c1f9c977.pdf', 21, '', '2025-06-04 15:23:15', '2025-06-04 15:28:14'),
(3, 'fefdsfsf', '1749050606_9fa8977aaccfc70cdb43.pdf', 21, '', '2025-06-04 15:23:26', '2025-06-04 15:28:18'),
(4, 'asas', '1749052614_dec30f3df60ea8228bbb.pdf', 21, '', '2025-06-04 15:56:54', '2025-06-04 15:57:36'),
(5, 'laporan pertama', '1749052635_4057833d40397300e34b.pdf', 21, '', '2025-06-04 15:57:15', '2025-06-04 15:57:39'),
(6, 'asas', '1749054771_fc959f10f7895354431f.pdf', 21, '', '2025-06-04 16:32:51', '2025-06-04 16:33:58'),
(7, 'meymey jelek', '1749693678_c1a7b421bb7d8191e97c.docx', 21, 'pending', '2025-06-12 02:01:18', '2025-06-12 02:01:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1747987693, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `user_image` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `user_image`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 'solihinmuhammadanhar@gmail.com', 'HAYYYA', '', '$2y$10$xEudrXBpesajRul4aOqnR.nri4uUDutsw1Y1H5usDjlKdIEGtjqDG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-23 23:49:01', '2025-05-23 23:49:01', NULL),
(11, 'f1d022013anhar@gmail.com', 'admin', '', '$2y$10$ZHSaeSJeM8e.6EQaNk39ZeEEbJU4rvSe5jJ4ZaFiOxQuKHa97fvg6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-24 18:07:18', '2025-05-24 18:07:18', NULL),
(12, 'muhammadanharsolihin@gmail.com', 'user', '', '$2y$10$advPkiCfvOrfb7J.FbwD5eCpGt51I6dO0bHL2ZRTPbME/3dVPwSya', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-25 01:43:13', '2025-05-25 01:43:13', NULL),
(15, 'ksrpmiunitunram06@gmail.com', 'petugasnya', '', '$2y$10$pqEUPK81l2itdCY5XF9s0eK5qnoi6K48cxnvR4JP3JRSXo.DIdSEO', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-26 02:43:24', '2025-05-26 02:43:24', NULL),
(16, 'ksrpmiunitunram11@gmail.com', 'mahasiswa', '', '$2y$10$D6dh5HXLjCbBaH2Ugnof8eE/8Rs0J46RUfJfwFKfTCAZKQKFhnLlG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-27 02:24:40', '2025-05-27 02:24:40', NULL),
(17, 'teknik@gmail.com', 'mahasiswa teknik', '', '$2y$10$gNxYMAwwH8D6USWd0r6XYedcqMqZqK8qWPG/9EUegcBHX7hFzgIaq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-27 03:06:22', '2025-05-27 03:06:22', NULL),
(18, 'anhar@gmail.com', 'teknik jaya', '', '$2y$10$gGQM.rOWApoaas9qj0Udqelf859NV3w3g02rQGAgLTFV/nefEKn6K', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-27 03:16:15', '2025-05-27 03:16:15', NULL),
(19, 'bem@gamil.com', 'bemftunram', '', '$2y$10$bPVIkS3KzccHUS1IDEJzde0viwt2s6kJ8on0k9IraOoboAtgkJRRK', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-27 03:20:31', '2025-05-27 03:20:31', NULL),
(20, 'PKL@GMAIL.COM', 'PKLUNRAM', '', '$2y$10$.rE/UAwVO7H3wkB1luGJkumFPC2Iq03.ITAJBYyLxoJJKmYLZnPe6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-03 02:53:32', '2025-06-03 02:53:32', NULL),
(21, 'YENI@GMAIL.COM', 'YENI', '', '$2y$10$yZN4CosLtmjlA1jNot1XJO8rIETMa4pXTxXSylD0gacgl8O2oGVvi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-03 02:54:02', '2025-06-03 02:54:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indeks untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indeks untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indeks untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

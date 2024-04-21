-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2024 at 05:41 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlkho`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Màu Trắng', '', 1, '2022-03-18 22:31:26', 1, NULL, NULL),
(2, 'Màu Sọc Xanh Dương', '', 1, '2022-03-18 22:31:41', 1, '2023-05-09 20:52:27', 1),
(3, 'Màu Hồng', '', 1, '2022-03-18 22:31:52', 1, '2024-03-21 22:13:01', 1),
(6, 'Màu Tím', '', 1, '2023-09-08 21:52:13', 1, NULL, NULL),
(7, 'Màu Xanh Blue', '', 1, '2023-09-08 21:52:34', 1, NULL, NULL),
(8, 'Màu Vàng', '', 1, '2023-09-08 21:52:44', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `bank` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `address`, `phone`, `bank`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Dung', 'Nguyễn Thị', 'Khe Sanh - Lao Bảo', '123456789', 'Agribank: 12345678', '', 1, '2022-03-25 22:26:43', 1, '2024-03-21 22:23:27', 1),
(2, 'Lệ', 'Thái Thị', 'Quảng Điền', '0987878787', 'Agribak: 12345677 <br/>\nVietcombank: 23453455345345', '', 1, '2023-05-04 21:56:52', 1, '2024-03-21 22:17:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `log_login_logout`
--

CREATE TABLE `log_login_logout` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `time_login` datetime NOT NULL,
  `time_logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `log_login_logout`
--

INSERT INTO `log_login_logout` (`id`, `user_id`, `email`, `time_login`, `time_logout`) VALUES
(14, 2, 'teacher@gmail.com', '2021-09-04 20:13:25', NULL),
(15, 1, 'admin@gmail.com', '2021-09-04 20:13:55', NULL),
(16, 30, 'hoangtantruong@gmail.com', '2021-09-05 22:24:26', NULL),
(17, 30, 'hoangtantruong@gmail.com', '2021-09-06 09:47:59', NULL),
(18, 30, 'hoangtantruong@gmail.com', '2021-09-06 11:08:02', NULL),
(19, 51, 'tdlanh@gmail.com', '2021-09-06 11:29:33', NULL),
(20, 51, 'tdlanh@gmail.com', '2021-09-06 13:53:41', NULL),
(21, 30, 'hoangtantruong@gmail.com', '2021-09-06 13:55:18', NULL),
(22, 51, 'tdlanh@gmail.com', '2021-09-06 13:55:41', NULL),
(23, 1, 'admin@gmail.com', '2021-09-06 13:56:07', NULL),
(24, 30, 'hoangtantruong@gmail.com', '2021-09-06 13:56:26', NULL),
(25, 48, 'ttnhien@gmail.com', '2021-09-06 14:00:58', NULL),
(26, 48, 'ttnhien@gmail.com', '2021-09-06 14:14:35', NULL),
(27, 1, 'admin@gmail.com', '2021-09-08 15:33:15', NULL),
(28, 30, 'hoangtantruong@gmail.com', '2021-09-09 00:41:45', NULL),
(29, 1, 'admin@gmail.com', '2021-09-09 13:26:07', NULL),
(30, 2, 'teacher@gmail.com', '2021-10-06 21:03:54', NULL),
(31, 2, 'teacher@gmail.com', '2021-10-09 22:00:21', NULL),
(32, 1, 'admin@gmail.com', '2021-10-10 09:12:18', NULL),
(33, 1, 'admin@gmail.com', '2021-10-13 20:58:15', NULL),
(34, 2, 'teacher@gmail.com', '2021-10-13 20:59:20', NULL),
(35, 1, 'admin@gmail.com', '2021-10-21 08:18:47', NULL),
(36, 2, 'teacher@gmail.com', '2021-11-11 20:13:02', NULL),
(37, 1, 'admin@gmail.com', '2021-11-21 20:52:28', NULL),
(38, 1, 'admin@gmail.com', '2021-11-21 20:56:14', NULL),
(39, 2, 'teacher@gmail.com', '2021-11-21 20:58:50', NULL),
(40, 1, 'admin@gmail.com', '2021-11-22 16:25:19', NULL),
(41, 2, 'teacher@gmail.com', '2021-11-25 23:09:39', NULL),
(42, 13, 'ldanh@gmail.com', '2021-12-30 09:51:17', NULL),
(43, 2, 'dtmchi.huongtra@gmail.com', '2021-12-30 11:20:52', NULL),
(44, 1, 'admin@gmail.com', '2022-01-01 16:24:55', NULL),
(45, 1, 'admin@gmail.com', '2022-01-01 16:26:15', NULL),
(46, 1, 'admin@gmail.com', '2022-03-16 22:34:11', NULL),
(47, 1, 'admin@gmail.com', '2022-03-16 22:49:08', NULL),
(48, 1, 'admin@gmail.com', '2022-03-16 23:53:58', NULL),
(49, 1, 'admin@gmail.com', '2022-03-18 19:45:22', NULL),
(50, 1, 'admin@gmail.com', '2022-03-22 22:13:18', NULL),
(51, 1, 'admin@gmail.com', '2022-03-25 20:36:34', NULL),
(52, 1, 'admin@gmail.com', '2022-03-31 19:28:33', NULL),
(53, 1, 'admin@gmail.com', '2022-04-01 19:57:08', NULL),
(54, 1, 'admin@gmail.com', '2022-04-03 09:46:02', NULL),
(55, 1, 'admin@gmail.com', '2022-04-16 08:37:27', NULL),
(56, 1, 'admin@gmail.com', '2023-05-04 21:52:02', NULL),
(57, 1, 'admin@gmail.com', '2023-05-09 20:51:43', NULL),
(58, 1, 'admin@gmail.com', '2023-09-08 21:24:16', NULL),
(59, 1, 'admin@gmail.com', '2023-09-08 22:37:06', NULL),
(60, 1, 'admin@gmail.com', '2023-09-08 22:42:04', NULL),
(61, 1, 'admin@gmail.com', '2023-09-09 21:06:14', NULL),
(62, 1, 'admin@gmail.com', '2023-09-21 20:09:02', NULL),
(63, 1, 'admin@gmail.com', '2023-09-21 20:09:58', NULL),
(64, 1, 'admin@gmail.com', '2023-10-01 14:38:11', NULL),
(65, 1, 'admin@gmail.com', '2023-10-22 06:36:28', NULL),
(66, 1, 'admin@gmail.com', '2024-03-21 21:58:10', NULL),
(67, 1, 'admin@gmail.com', '2024-03-21 21:58:48', NULL),
(68, 1, 'admin@gmail.com', '2024-03-21 22:22:50', NULL),
(69, 1, 'admin@gmail.com', '2024-03-27 10:48:08', NULL),
(70, 1, 'admin@gmail.com', '2024-03-27 19:34:23', NULL),
(71, 1, 'admin@gmail.com', '2024-04-07 10:03:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Bao 10 Kg', 'Loại Bao 10 Kg', 1, '2022-03-18 21:54:17', 1, '2022-03-18 21:56:27', 1),
(2, 'Bao 25 Kg', 'Loại Bao 25 Kg', 1, '2022-03-18 21:54:27', 1, '2022-03-18 21:56:20', 1),
(3, 'Bao 50 Kg', 'Loại Bao 25 Kg', 1, '2022-03-18 21:54:35', 1, '2022-03-18 21:56:12', 1),
(4, 'Bao 30 Kg', 'Loại Bao 30 Kg', 1, '2022-03-18 21:56:04', 1, NULL, NULL),
(5, 'Bao 5 Kg', 'Loại Bao 5 kg', 1, '2022-03-18 21:57:30', 1, NULL, NULL),
(9, 'Bao Lộn Xộn', 'Loại bao lộn xộn nhiều kg', 1, '2022-03-18 21:58:18', 1, '2023-05-09 20:56:31', 1),
(10, 'Bao 21 Kg', 'Bao Loại Thiếu', 1, '2022-03-18 21:58:26', 1, '2023-05-09 20:54:08', 1),
(13, 'Bao 49 Kg', 'Loại bao 49 Kg', 1, '2023-09-08 22:01:54', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_type_id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `product_type_id`, `description`, `status`, `unit`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Bắp Xay Mịn', 6, 'bắp xay mịn', 1, 'Kg', '2022-03-25 21:05:54', 1, '2023-05-09 21:32:05', 1),
(2, 'Bắp Hột', 6, 'Bắp hột chưa xay', 1, 'Kg', '2022-03-25 21:06:26', 1, NULL, NULL),
(3, 'Bắp Xay To', 6, 'Bắp xay to', 1, 'Kg', '2023-05-09 21:31:01', 1, NULL, NULL),
(4, 'Nếp Mía', 1, 'Nếp bao có hình cây mía', 1, 'Kg', '2023-09-08 22:02:54', 1, NULL, NULL),
(5, 'Nếp Na', 1, '', 1, 'Kg', '2024-03-27 19:41:28', 1, NULL, NULL),
(6, 'Cám Loại 1', 9, 'Cám loại đẹp', 1, 'Kg', '2024-03-27 19:43:09', 1, '2024-03-27 19:45:07', 1),
(7, 'Cám Loại 2', 9, 'Cám loại 2', 1, 'Kg', '2024-03-27 19:44:04', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_quantities`
--

CREATE TABLE `product_quantities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_quantities`
--

INSERT INTO `product_quantities` (`id`, `product_id`, `package_id`, `color_id`, `quantity`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 3, 2, 5000, '2023-09-08 21:34:53', 1, '2023-09-09 21:34:22', 00000000000000000001);

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Nếp', '', 1, '2022-03-17 00:16:44', 1, '2024-03-21 22:25:11', 1),
(2, 'Gạo', NULL, 1, '2022-03-18 19:45:48', 1, '2022-03-18 21:25:11', 1),
(6, 'Bắp', '', 1, '2022-03-18 21:36:34', 1, NULL, NULL),
(9, 'Cám', '', 1, '2023-09-08 21:53:18', 1, NULL, NULL),
(10, 'Lúa', '', 1, '2023-09-08 21:53:27', 1, NULL, NULL),
(11, 'Tấm', '', 1, '2023-09-08 21:53:34', 1, NULL, NULL),
(12, 'Bao', '', 1, '2024-03-21 22:25:20', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `note` date DEFAULT NULL,
  `pay_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `color_name` varchar(255) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `unit` varchar(255) NOT NULL DEFAULT 'Kg',
  `price` decimal(19,4) NOT NULL DEFAULT 0.0000,
  `total` decimal(19,4) NOT NULL DEFAULT 0.0000,
  `note` text DEFAULT NULL,
  `created_at` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_pays`
--

CREATE TABLE `sale_pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `total` decimal(19,4) NOT NULL DEFAULT 0.0000,
  `note` text NOT NULL,
  `employee` bigint(20) UNSIGNED NOT NULL,
  `create_at` date NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT 0,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `level` int(1) UNSIGNED NOT NULL DEFAULT 2,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `sex`, `date_of_birth`, `email`, `phone_number`, `address`, `email_verified_at`, `password`, `remember_token`, `level`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 0, '2021-07-27', 'admin@gmail.com', '123456789', 'Trung tâm GDNN-GDTX Hương Trà', NULL, '$2y$10$5.oD245DLToxEQuFqJWmgeBrOLLquQkrZnq3yMA.Gtc5DSmbbVvJy', NULL, 0, 1, '2019-04-24 01:44:43', '2021-07-28 14:11:45'),
(2, 'Chi', 'Đoàn Thị Mai', 0, '1988-03-24', 'dtmchi.huongtra@gmail.com', '0949196567', 'Tu Ha - Hương Trà - TT Huế', NULL, '$2y$10$O0.Zjtx7g3m09VDTtseXBOjByZLhgBIT5yfuzVrK8WcKq3QhcC4Ra', NULL, 1, 1, '2019-04-28 00:33:42', '2021-07-28 19:02:01'),
(13, 'Dũng', 'Đoàn Viết', 1, '2021-07-28', 'dung@gmail.com', NULL, NULL, NULL, '$2y$10$VQIkG.xyAFLkX5GiUNhS2eVrULSZNEnHApR2yHCLmyDuyBz1y5TFW', NULL, 2, 1, '2021-07-28 18:47:29', NULL),
(14, 'Hương', 'Ngô Thị Thu', 1, '2021-07-28', 'huong@gmail.com', NULL, NULL, NULL, '$2y$10$smpEgF7sKQrgX.Of31YhI.OsEAloLzVHyXN8xWf/.GR7shiK96qeG', NULL, 2, 1, '2021-07-28 18:48:52', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_login_logout`
--
ALTER TABLE `log_login_logout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `product_quantities`
--
ALTER TABLE `product_quantities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_pays`
--
ALTER TABLE `sale_pays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_login_logout`
--
ALTER TABLE `log_login_logout`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_quantities`
--
ALTER TABLE `product_quantities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_pays`
--
ALTER TABLE `sale_pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

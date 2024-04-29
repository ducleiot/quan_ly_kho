-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 29, 2024 lúc 05:00 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlkho`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `debts`
--

CREATE TABLE `debts` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `sale_id` bigint(20) NOT NULL,
  `amount_owed` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `sale_id` bigint(20) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `date_payment` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

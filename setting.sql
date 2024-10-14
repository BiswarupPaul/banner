-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 12:58 PM
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
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `option_name` text NOT NULL,
  `option_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `option_name`, `option_value`, `created_at`, `updated_at`) VALUES
(1, 'website_name', 'busfam', '0000-00-00 00:00:00', '2024-09-28 10:54:58'),
(2, 'website_url', 'busfam.com', '0000-00-00 00:00:00', '2024-09-28 10:55:07'),
(3, 'phone_no', '[value-3]', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'whatsapp_no', '[value-3]', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'email_id', '[value-3]', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'website_name', 'busfam1', '2024-09-28 10:58:04', '2024-09-28 10:58:04'),
(7, 'website_url', 'busfam.com', '2024-09-28 10:58:04', '2024-09-28 10:58:04'),
(8, 'phone_no', '[value-3], ', '2024-09-28 10:58:04', '2024-09-28 10:58:04'),
(9, 'whatsapp_no', '[value-3], ', '2024-09-28 10:58:04', '2024-09-28 10:58:04'),
(10, 'email_id', '', '2024-09-28 10:58:04', '2024-09-28 10:58:04'),
(11, 'website_name', 'busfam1', '2024-09-28 11:00:00', '2024-09-28 11:00:00'),
(12, 'website_url', 'busfam.com', '2024-09-28 11:00:00', '2024-09-28 11:00:00'),
(13, 'phone_no', '9123975974, , ', '2024-09-28 11:00:00', '2024-09-28 11:00:00'),
(14, 'whatsapp_no', '[value-3], , ', '2024-09-28 11:00:00', '2024-09-28 11:00:00'),
(15, 'email_id', '', '2024-09-28 11:00:00', '2024-09-28 11:00:00'),
(16, 'website_name', 'busfam1', '2024-10-04 06:02:43', '2024-10-04 06:02:43'),
(17, 'website_url', 'busfam.com', '2024-10-04 06:02:43', '2024-10-04 06:02:43'),
(18, 'phone_no', '9123975974, , , ', '2024-10-04 06:02:43', '2024-10-04 06:02:43'),
(19, 'whatsapp_no', '4569823107, , , ', '2024-10-04 06:02:43', '2024-10-04 06:02:43'),
(20, 'email_id', '', '2024-10-04 06:02:43', '2024-10-04 06:02:43'),
(21, 'website_name', 'busfam1', '2024-10-04 06:03:04', '2024-10-04 06:03:04'),
(22, 'website_url', 'busfam.com', '2024-10-04 06:03:04', '2024-10-04 06:03:04'),
(23, 'phone_no', '9123975974', '2024-10-04 06:03:04', '2024-10-04 06:03:04'),
(24, 'whatsapp_no', '4569823107', '2024-10-04 06:03:04', '2024-10-04 06:03:04'),
(25, 'email_id', '', '2024-10-04 06:03:05', '2024-10-04 06:03:05'),
(26, 'website_name', 'busfam1', '2024-10-04 06:03:07', '2024-10-04 06:03:07'),
(27, 'website_url', 'busfam.com', '2024-10-04 06:03:08', '2024-10-04 06:03:08'),
(28, 'phone_no', '9123975974, ', '2024-10-04 06:03:08', '2024-10-04 06:03:08'),
(29, 'whatsapp_no', '4569823107, ', '2024-10-04 06:03:08', '2024-10-04 06:03:08'),
(30, 'email_id', '', '2024-10-04 06:03:08', '2024-10-04 06:03:08'),
(31, 'website_name', 'busfam1', '2024-10-04 06:03:12', '2024-10-04 06:03:12'),
(32, 'website_url', 'busfam.com', '2024-10-04 06:03:12', '2024-10-04 06:03:12'),
(33, 'phone_no', '9123975974, ', '2024-10-04 06:03:12', '2024-10-04 06:03:12'),
(34, 'whatsapp_no', '4569823107, ', '2024-10-04 06:03:12', '2024-10-04 06:03:12'),
(35, 'email_id', '', '2024-10-04 06:03:12', '2024-10-04 06:03:12'),
(36, 'website_name', 'busfam1', '2024-10-04 06:03:18', '2024-10-04 06:03:18'),
(37, 'website_url', 'busfam.com', '2024-10-04 06:03:18', '2024-10-04 06:03:18'),
(38, 'phone_no', '9123975974', '2024-10-04 06:03:18', '2024-10-04 06:03:18'),
(39, 'whatsapp_no', '4569823107', '2024-10-04 06:03:18', '2024-10-04 06:03:18'),
(40, 'email_id', '', '2024-10-04 06:03:18', '2024-10-04 06:03:18'),
(41, 'website_name', 'busfam1', '2024-10-04 06:04:20', '2024-10-04 06:04:20'),
(42, 'website_url', 'busfam.com', '2024-10-04 06:04:20', '2024-10-04 06:04:20'),
(43, 'phone_no', '9123975974, 6259301478', '2024-10-04 06:04:20', '2024-10-04 06:04:20'),
(44, 'whatsapp_no', '4569823107, 1234569870', '2024-10-04 06:04:20', '2024-10-04 06:04:20'),
(45, 'email_id', '', '2024-10-04 06:04:20', '2024-10-04 06:04:20'),
(46, 'website_name', 'busfam1', '2024-10-04 06:05:43', '2024-10-04 06:05:43'),
(47, 'website_url', 'busfam.com', '2024-10-04 06:05:43', '2024-10-04 06:05:43'),
(48, 'phone_no', '9123975974, 6259301478, ', '2024-10-04 06:05:43', '2024-10-04 06:05:43'),
(49, 'whatsapp_no', '4569823107, 1234569870, ', '2024-10-04 06:05:43', '2024-10-04 06:05:43'),
(50, 'email_id', '', '2024-10-04 06:05:44', '2024-10-04 06:05:44'),
(51, 'website_name', 'busfam', '2024-10-05 05:09:24', '2024-10-05 05:09:24'),
(52, 'website_url', 'busfam.com', '2024-10-05 05:09:24', '2024-10-05 05:09:24'),
(53, 'phone_no', '9123975974, 6259301478, , ', '2024-10-05 05:09:24', '2024-10-05 05:09:24'),
(54, 'whatsapp_no', '4569823107, 1234569870, , ', '2024-10-05 05:09:24', '2024-10-05 05:09:24'),
(55, 'email_id', '', '2024-10-05 05:09:24', '2024-10-05 05:09:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

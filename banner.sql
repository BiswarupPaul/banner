-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2024 at 11:18 AM
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
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `phone_no` text NOT NULL,
  `image` text NOT NULL,
  `gallery_image` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `content`, `phone_no`, `image`, `gallery_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BeautifulLife', '<span style=\"color: rgb(71, 71, 71); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">Being content with your life means that&nbsp;</span><span style=\"background-color: rgb(211, 227, 253); color: rgb(4, 12, 40); font-family: &quot;Google Sans&quot;, Arial, sans-serif;\">you\'re satisfied with what you have and who you are</span><span style=\"color: rgb(71, 71, 71); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">. Instead of comparing yourself to others or wishing you had a different life, you feel you\'re living a life you can stand behind.</span>', 'a:2:{i:0;s:10:\"9080506070\";i:1;s:9:\"321456089\";}', '82818_life.png', '95788_group.png, 13240_student.png, 56645_life.png', '1', '2024-08-19 11:13:59', '2024-08-31 07:44:08'),
(2, 'Education', '<p>Education is very needed for every successful person.</p>', '', '99091_education.png', '', '1', '2024-08-19 11:16:47', '2024-08-19 11:16:47'),
(3, 'OlympicGames', '<span style=\"color: rgb(133, 135, 150); font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-weight: 700; background-color: rgb(255, 255, 255);\">The modern&nbsp;</span><span style=\"font-weight: bolder; color: rgb(133, 135, 150); font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; background-color: rgb(255, 255, 255);\">Olympic Games</span><span style=\"color: rgb(133, 135, 150); font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-weight: 700; background-color: rgb(255, 255, 255);\">&nbsp;(</span><span style=\"font-weight: bolder; color: rgb(133, 135, 150); font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; background-color: rgb(255, 255, 255);\">OG; or&nbsp;Olympics;&nbsp;<span style=\"background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-radius: 2px;\">French</span>:&nbsp;<i lang=\"fr\">Jeux olympiques, JO</i></span><span style=\"color: rgb(133, 135, 150); font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-weight: 700; background-color: rgb(255, 255, 255);\">)</span><span style=\"color: rgb(133, 135, 150); font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-weight: 700; background-color: rgb(255, 255, 255);\">&nbsp;are the world\'s leading international sporting events.</span>', 'a:2:{i:0;s:10:\"1259634078\";i:1;s:10:\"2563014789\";}', '16418_olympic.png', '23862_human.png, 13550_student.png', '1', '2024-08-19 11:22:02', '2024-08-31 05:36:29'),
(4, 'Sports', 'The outdoor sports industry is a hotbed of opportunity. With around, it’s pretty much a goldmine. One you could tap into with just a bit of content creation effort. The right content can get you seen by millions of people around the world –but in such a stacked field, you have to think outside the box to get ahead of the competition.', 'a:1:{i:0;s:10:\"4563210789\";}', '34490_sports.png', '65093_competition.png', '1', '2024-08-19 11:24:31', '2024-08-31 06:01:27'),
(13, 'Competition', 'Competitive content analysis isthe process of identifying your competitors and analyzing their content strategies to determine what tactics work well and benchmark your own performance. You can also uncover a competitor&amp;#039;s weaker points and figure out where you have relative strengths.', 'a:1:{i:0;s:10:\"1596357845\";}', '43494_competition.png', '36266_group.png', '1', '2024-08-23 12:55:41', '2024-08-31 05:33:03'),
(41, 'Student', 'Students interact with the course content through engaging in such learning activities as reading, watching videos, using software programs, participating in simulations, exploring resources, and working on course assignments.', 'a:2:{i:0;s:10:\"7896321045\";i:1;s:10:\"6523014789\";}', '25306_student.png, 67803_group.png, 15219_student.png', '72371_group.png, 45123_student.png, 46718_sports.png, 99698_olympic.png', '1', '2024-08-29 12:53:28', '2024-09-02 07:15:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

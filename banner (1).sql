-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 12:57 PM
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
(1, 'BeautifulLife', '<span style=\"color: rgb(40, 40, 41); font-family: -apple-system, system-ui, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; font-size: 15px; background-color: rgb(255, 255, 255);\">A beautiful life to me is feeling whole- it’s knowing yourself in all your strengths and weaknesses and being okay with exactly what you are in that moment- it’s accepting yourself in all ways.&nbsp;</span>', 'a:1:{i:0;s:10:\"6996321540\";}', '16724_life.png', '', '1', '2024-10-04 07:53:50', '2024-10-04 07:54:21'),
(2, 'Education', '<span style=\"color: rgb(84, 93, 126); font-family: &quot;Google Sans&quot;, Arial, sans-serif; letter-spacing: 0.1px; background-color: rgb(255, 255, 255);\">Educational content is a way for businesses to inform, instruct, or train their audience without directly promoting a product or service.&nbsp;</span><span style=\"color: rgb(84, 93, 126); font-family: &quot;Google Sans&quot;, Arial, sans-serif; letter-spacing: 0.1px; background-color: rgb(255, 255, 255);\">It can include tutorial videos, blog posts, online courses, or podcasts.</span>', 'a:2:{i:0;s:11:\"45668920137\";i:1;s:10:\"9985632014\";}', '22158_education.png', '', '0', '2024-10-04 07:59:28', '2024-10-04 07:59:55'),
(3, 'Olympic Games', '<p><span style=\"color: rgb(84, 93, 126); font-family: &quot;Google Sans&quot;, Arial, sans-serif; letter-spacing: 0.1px; background-color: rgb(255, 255, 255);\">The Olympic Games are a global sporting event that takes place every four years and celebrates unity, excellence, and athleticism.&nbsp;</span><span style=\"color: rgb(84, 93, 126); font-family: &quot;Google Sans&quot;, Arial, sans-serif; letter-spacing: 0.1px; background-color: rgb(255, 255, 255);\">The games feature a variety of sports, such as gymnastics, swimming, ice skating, and track and field.</span><br></p>', 'a:1:{i:0;s:10:\"9156320478\";}', '79098_olympic.png', '', '1', '2024-10-04 08:01:16', '2024-10-04 08:01:16'),
(4, 'Sports', '<p><span style=\"color: rgb(71, 71, 71); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">Sport is&nbsp;</span><span style=\"background-color: rgb(211, 227, 253); color: rgb(4, 12, 40); font-family: &quot;Google Sans&quot;, Arial, sans-serif;\">a form of physical activity or game</span><span style=\"color: rgb(71, 71, 71); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">. Often competitive and organized, sports use, maintain, or improve physical ability and skills. They also provide enjoyment to participants and, in some cases, entertainment to spectators.</span><br></p>', 'a:1:{i:0;s:10:\"6598230147\";}', '67821_sports.png', '', '1', '2024-10-04 08:02:10', '2024-10-04 08:02:10'),
(5, 'Competition', '<p><span class=\"\" style=\"color: rgb(0, 29, 53); font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 18px; background-color: rgb(255, 255, 255);\">Competition content refers to&nbsp;<mark class=\"QVRyCf\" style=\"background: var(--m3c22); border-radius: 4px; padding: 0px 2px;\">the content created by competitors in a market</mark>.&nbsp;</span><span class=\"\" style=\"color: rgb(0, 29, 53); font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 18px; background-color: rgb(255, 255, 255);\">A competitive content analysis is a process to examine the content strategies of competitors to gain insights and improve your own content.</span><br></p>', 'a:2:{i:0;s:10:\"1233215607\";i:1;s:10:\"0332145987\";}', '22618_competition.png', '', '1', '2024-10-04 08:03:17', '2024-10-04 08:03:17'),
(6, 'Student', '<span style=\"color: rgb(71, 71, 71); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">Students interact with content&nbsp;</span><span style=\"background-color: rgb(211, 227, 253); color: rgb(4, 12, 40); font-family: &quot;Google Sans&quot;, Arial, sans-serif;\">any time they encounter a new fact, idea, theory, or principle presented to them by another person in a course</span><span style=\"color: rgb(71, 71, 71); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">, whether by reading, watching, listening, or viewing something presented to them.</span>', 'a:1:{i:0;s:10:\"4689572013\";}', '58321_group.png', '', '1', '2024-10-04 08:04:31', '2024-10-04 08:04:31');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

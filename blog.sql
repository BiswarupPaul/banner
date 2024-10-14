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
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(3) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `category`, `content`, `image`, `status`, `publish_date`) VALUES
(1, 'Bengali Thali', 3, 'jhjhhj kjjkjkkjk klkllklklklk kkklklkllk kjkllklklklk klklkllklklkklfg jhjhjkjkjkkjkj \'kmmkkkjkjjk jhjhjhjhj kjjkkjkjk klklklkkl kkkkkl kkkkklkl', '80295_bengali_thali.png', '1', '2024-10-04 07:17:34'),
(2, 'Outdoor Game', 1, '<p>Outdoor games mainly refer to&nbsp;<strong>those games which we play outside in the open air</strong>. Since it is played outside, several factors like weather and time must be taken into consideration. It is not possible to play outdoor games when it is raining heavily or when it gets dark as children may fall sick or injure themselves.</p>\r\n', '67804_cricket.png', '1', '2024-10-04 07:20:47'),
(3, 'Movie', 2, '<p>Among classics such as&nbsp;<strong>Nightmare on Elm Street</strong>&nbsp;and The Exorcist, you&#39;ll find modern masterpieces of horror, including Hereditary, The Grudge, and The Conjuring.</p>\r\n', '33675_movie.png', '1', '2024-10-04 07:23:24'),
(4, 'WaterFload', 4, '<p>The Adventure Blog was started in 2007 as a Blogspot and has morphed into a website with a devoted following and social community with some of the biggest names in climbing, hiking, mountaineering, biking, kayaking, traveling, and any other intrepid outdoor pursuits!</p>\r\n', '11620_adventure.png', '1', '2024-10-04 07:25:41'),
(5, 'Smart Veg', 3, '<p>I&rsquo;ve tried to explore a variety of flavors in this roundup, not limiting myself to Indian cuisine. You&rsquo;ll find a mix of Mediterranean sandwiches, pasta dishes, noodles, fusion foods, quesadillas, rice recipes, biryanis, upmas, and many other dishes that make perfect lunch box options.</p>\r\n', '99695_veg.png', '1', '2024-10-04 07:28:57'),
(6, '', 0, '', '', '1', '2024-10-04 10:16:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

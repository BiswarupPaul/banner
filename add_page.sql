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
-- Table structure for table `add_page`
--

CREATE TABLE `add_page` (
  `id` int(3) NOT NULL,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_page`
--

INSERT INTO `add_page` (`id`, `title`, `slug`, `content`, `image`) VALUES
(1, 'Home', 'home', 'Home is everything !!', '93610_home.png'),
(2, 'Passion', 'passion', '<p>Passion is all about your life.</p>', '19295_passion.png'),
(3, 'Goals', 'goals', '<p>Give something positive in the society.</p>', '64582_goals.png'),
(4, 'Football_Club', 'football-club', '<p>Play Football with your passion !!</p>', '28982_football_image.png'),
(5, 'Passion', 'passion-6', 'Dream Big, Work Hard !!', '53375_passion2.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_page`
--
ALTER TABLE `add_page`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_page`
--
ALTER TABLE `add_page`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

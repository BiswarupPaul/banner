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
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `R_id` int(5) NOT NULL,
  `image` text NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `age` int(2) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone_number` text NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`R_id`, `image`, `fname`, `lname`, `age`, `date_of_birth`, `email`, `username`, `phone_number`, `gender`, `password`) VALUES
(1, '82963_man.png', 'Suresh', 'Chandra', 35, '1994-03-07', 'admin100@gmail.com', 'suresh35', '2564301892', 'male', '$2y$10$WLE.ogalekgorBopXpXd9OttT2UMJKu/3vrwh.t/x8tE9G5j6vhKG'),
(2, '99368_man.jpg', 'Arnab', 'Roy', 20, '2004-01-06', 'admin200@gmail.com', 'arnab20', '1234560879', 'male', '$2y$10$kwWm1qdQ3cIzYdgpr9ueoubW902YF8bRlPPDjtNfwXxyYzk38ef4i'),
(3, '16848_images.png', 'Jishu', 'Sen', 22, '2002-04-16', 'admin300@gmail.com', 'jishu22', '7896523012', 'male', '$2y$10$ywiWCwNBv5/pagMoF.1XIuS.jngVp1gK3vkITrT.vAkTDXTo4uh2u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`R_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `R_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

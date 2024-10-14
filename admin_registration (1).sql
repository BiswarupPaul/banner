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
-- Table structure for table `admin_registration`
--

CREATE TABLE `admin_registration` (
  `A_id` int(5) NOT NULL,
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
-- Dumping data for table `admin_registration`
--

INSERT INTO `admin_registration` (`A_id`, `image`, `fname`, `lname`, `age`, `date_of_birth`, `email`, `username`, `phone_number`, `gender`, `password`) VALUES
(1, '', 'Aniket', 'Roy', 30, '1994-02-23', 'test123@gmail.com', 'aniket30', '8123005267', 'male', '$2y$10$r4xo7HTVw1rTU4QPEfFWPuxwLcF9frweirqOJ2HEDmKGVQbiJr./2'),
(2, '', 'Sukana', 'Shaw', 29, '1995-01-31', 'test200@gmail.com', 'sukana29', '2305614950', 'female', '$2y$10$xt9ByBMZ7dt8Bdwkc1qzB.TP4C.ibxkQeHszArsvtbWgyhUO/q.jO'),
(3, '', 'Subhan', 'Sen', 23, '2001-03-07', 'test100@gmail.com', 'subhan23', '9511596357', 'male', '$2y$10$.njMCIFhawLGc0lv.WJ8BegP/lV82o0zDxXq1IXFcYJgh8By0MeGi'),
(4, '', 'admin', 'test', 20, '2002-08-19', 'admin5089@gmail.com', 'admin20', '7896541236', 'male', '$2y$10$JBNX9sbrws.6P.AGNARngeBdEdF6JWPErG6AUEAiyYI49xXgLYspe'),
(5, '', 'bantu', 'sen', 25, '2024-08-08', 'test600@gmail.com', 'bantu25', '9636963696', 'male', '$2y$10$Y9r2ojmBaBNyH.drHivGpeGC1Q0mQwsKsenyfWc1202F0uUm0MCFq'),
(6, '', 'piklu', 'das', 32, '1992-02-11', 'test32@gmail.com', 'piklu32', '7854236591', 'male', '$2y$10$wJa0mtC8PNc3bH8DKefNF.WDcPzeyHvWpeZp/5UHYAqkRPueT8432'),
(7, '', 'hii', 'hello', 42, '2024-08-14', 'test42@gmail.com', 'hii42', '7898789878', 'male', '$2y$10$CR3iAX9qQhQEl2IQHPD5ze0NJrxqMQMrpOR/63kFn7/mKLxAbJTja'),
(8, '', 'kon', 'don', 60, '1964-08-10', 'test60@gmail.com', 'kon60', '7414789875', 'male', '$2y$10$0CfxDSGJF5InhUkcAlA9JuMy0Bj2HLYZH/3E3Trut9KiGTbun2yDu'),
(9, '', 'RUPALI', 'SHARMA', 29, '1994-10-10', 'rupali.s@busfam.in', 'rupalis', '9876543210', 'female', '$2y$10$YsDEo1otYEUtxw.Q6IkJfOxm3FE9qbHwefd1y0OmHGZE6AF7W9Fhy'),
(11, '52873_man.png', 'Aritra', 'Roy', 25, '1999-05-18', 'test300@gmail.com', 'aritra25', '4523987610', 'male', '$2y$10$IWa5VPB03rCIojiUN9qs..d9pGWKeZdxKjhBCzN.ufuwxRa88OsGq'),
(12, '65075_person.png', 'Kustab', 'Roy', 45, '1979-04-19', 'test400@gmail.com', 'kustab45', '9632587401', 'male', '$2y$10$xujF43NMuUZimcLPdeYRiuB4YxXYfR6VxIUfLRa1.iw8XVWvCGGz6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_registration`
--
ALTER TABLE `admin_registration`
  ADD PRIMARY KEY (`A_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_registration`
--
ALTER TABLE `admin_registration`
  MODIFY `A_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

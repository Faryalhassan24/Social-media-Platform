-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2025 at 01:21 PM
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
-- Database: `loginsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `DateRegistered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`user_id`, `email`, `username`, `password`, `DateRegistered`) VALUES
(3, 'umer.momo13@gmail.com', 'umerali', '$2y$10$JJSgozf4apNbZLpg/LZUjeo3T1p6W6yux2R/1moUf2ZH63sPDVcxm', '2025-12-08 21:46:57'),
(4, 'shaky@shaky.com', 'shaky', '$2y$10$VdNcikrzluss6lKHjU/EOeR7c56F.3mVL/zF3RDC/ALBcAJ3X2gYS', '2025-12-08 21:49:47'),
(5, 'umer@ali.com', 'umerali', '$2y$10$Q9.KXOPMRx4lod0wSycLDOB18BhaT5PQnHGsB01BM.EhHwdJPi.y6', '2025-12-08 21:55:18'),
(6, 'aumer0201@gmail.com', 'umerali2', '$2y$10$4ft1Uzct6mjCJ/CYBt65ROSsA7nBHli77lqzpIu.OwTJgJPPdZkuu', '2025-12-08 22:00:03'),
(7, 'asd@asd.com', 'asd', '$2y$10$8EDoq.aNOJ3Fs6ddnkZ5I.ioq9LqTXAtSwOLn2QgQVC/095O/netS', '0000-00-00 00:00:00'),
(8, 'shaky@bhai.com', 'shakybhai44', '$2y$10$xr3VlxyXNL2T7cWmBd3eaeMZGYrwem8QzPVkDavmgxgB3GcDYaoCS', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

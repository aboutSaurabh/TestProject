-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2020 at 08:27 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payu`
--

-- --------------------------------------------------------

--
-- Table structure for table `filedetails`
--

CREATE TABLE `filedetails` (
  `id` int(11) NOT NULL,
  `batchId` varchar(256) DEFAULT NULL,
  `fileName` varchar(250) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `filedetails`
--

INSERT INTO `filedetails` (`id`, `batchId`, `fileName`, `createdDate`, `status`) VALUES
(1, '5fc6939b19d63', '1606849434formate (8).csv', '2020-12-01 20:03:55', 1),
(2, '5fc6947b1e7c1', '1606849658formate (8).csv', '2020-12-01 20:07:39', 1),
(3, '5fc694e216169', '1606849761formate (8).csv', '2020-12-01 20:09:22', 1),
(4, '5fc69504933e4', '1606849796formate (9).csv', '2020-12-01 20:09:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productdetails`
--

CREATE TABLE `productdetails` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productdetails`
--

INSERT INTO `productdetails` (`id`, `file_id`, `name`, `description`, `created_on`, `modified`, `status`) VALUES
(1, 1, 'P1', 'Testing text', '2020-12-01 20:03:55', '2020-12-01 20:03:55', 1),
(2, 1, 'P2', 'Testing.............', '2020-12-01 20:03:55', '2020-12-01 20:03:55', 1),
(3, 1, 'P3', 'De sc.......', '2020-12-01 20:03:55', '2020-12-01 20:03:55', 1),
(4, 2, 'P1', 'Testing text', '2020-12-01 20:07:39', '2020-12-01 20:07:39', 1),
(5, 2, 'P2', 'Testing.............', '2020-12-01 20:07:39', '2020-12-01 20:07:39', 1),
(6, 2, 'P3', 'De sc.......', '2020-12-01 20:07:39', '2020-12-01 20:07:39', 1),
(7, 3, 'P1', 'Testing text', '2020-12-01 20:09:22', '2020-12-01 20:09:22', 1),
(8, 3, 'P2', 'Testing.............', '2020-12-01 20:09:22', '2020-12-01 20:09:22', 1),
(9, 3, 'P3', 'De sc.......', '2020-12-01 20:09:22', '2020-12-01 20:09:22', 1),
(10, 4, 'P1', 'Testing text', '2020-12-01 20:09:56', '2020-12-01 20:09:56', 1),
(11, 4, 'P2', 'Testing.............', '2020-12-01 20:09:56', '2020-12-01 20:09:56', 1),
(12, 4, 'P3', 'De sc.......', '2020-12-01 20:09:56', '2020-12-01 20:09:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `last_login`, `created_on`, `status`) VALUES
(1, 'Demo', 'demo@gmail.com', '$2y$10$LJ6FPfxiYnoGZ.uzODE9S.UFw557go/yuJZz6wj6QIVfxV67w6z5K', '2020-12-01 20:07:49', '2020-11-09 13:22:00', 1),
(2, 'Demo', 'test@gmail.com', '$2y$10$LJ6FPfxiYnoGZ.uzODE9S.UFw557go/yuJZz6wj6QIVfxV67w6z5K', NULL, '2020-11-09 13:22:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filedetails`
--
ALTER TABLE `filedetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productdetails`
--
ALTER TABLE `productdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filedetails`
--
ALTER TABLE `filedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productdetails`
--
ALTER TABLE `productdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

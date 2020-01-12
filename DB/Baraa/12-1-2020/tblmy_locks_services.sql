-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2020 at 06:37 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legal_services`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_locks_services`
--

CREATE TABLE IF NOT EXISTS `tblmy_locks_services` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rel_sid` int(11) NOT NULL,
  `rel_stype` varchar(20) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_locks_services`
--

INSERT INTO `tblmy_locks_services` (`id`, `password`, `rel_sid`, `rel_stype`, `locked`) VALUES
(1, 'baraa123', 8, 'kd-y', 1),
(2, '2ZbZ8Yy2cb0T', 9, 'kd-y', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_locks_services`
--
ALTER TABLE `tblmy_locks_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`rel_sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_locks_services`
--
ALTER TABLE `tblmy_locks_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

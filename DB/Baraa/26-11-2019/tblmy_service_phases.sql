-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2019 at 11:56 PM
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
-- Table structure for table `tblmy_service_phases`
--

CREATE TABLE IF NOT EXISTS `tblmy_service_phases` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `slug` varchar(30) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_service_phases`
--

INSERT INTO `tblmy_service_phases` (`id`, `name`, `slug`, `service_id`, `is_active`, `deleted`) VALUES
(1, 'مرحلة خاصة بالقضايا', 'legal_phase_1', 1, 1, 0),
(2, 'مرحلة خاصة بالقضايا 2', 'legal_phase_2', 1, 1, 0),
(3, 'مرحلة خاصة بالقضايا 3', 'legal_phase_3', 1, 1, 0),
(4, 'مرحلة خاصة بالعقود', 'legal_phase_4', 2, 1, 0),
(5, 'مرحلة خاصة بالعقود 2', 'legal_phase_5', 2, 1, 0),
(6, 'مرحلة خاصة بالعقود 3', 'legal_phase_6', 2, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_service_phases`
--
ALTER TABLE `tblmy_service_phases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_service_phases`
--
ALTER TABLE `tblmy_service_phases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

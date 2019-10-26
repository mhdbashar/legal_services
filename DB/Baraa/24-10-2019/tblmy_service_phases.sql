-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2019 at 11:10 PM
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
  `is_active` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_service_phases`
--

INSERT INTO `tblmy_service_phases` (`id`, `name`, `slug`, `is_active`, `deleted`) VALUES
(1, 'مرحلة الطلب', 'legal_phase_1', 1, 0),
(2, 'الإحالة', 'legal_phase_2', 1, 0),
(3, 'قرار 34', 'legal_phase_3', 1, 0),
(4, 'تم الإعلان', 'legal_phase_4', 0, 0),
(5, 'قرار 46', 'legal_phase_5', 0, 0),
(6, 'قرار 83', 'legal_phase_6', 0, 0);

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

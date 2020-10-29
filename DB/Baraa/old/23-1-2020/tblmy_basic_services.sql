-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2020 at 09:00 PM
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
-- Table structure for table `tblmy_basic_services`
--

CREATE TABLE IF NOT EXISTS `tblmy_basic_services` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `is_primary` int(2) NOT NULL DEFAULT '0',
  `show_on_sidebar` tinyint(1) NOT NULL DEFAULT '1',
  `is_module` tinyint(1) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_basic_services`
--

INSERT INTO `tblmy_basic_services` (`id`, `name`, `slug`, `prefix`, `numbering`, `is_primary`, `show_on_sidebar`, `is_module`, `datecreated`) VALUES
(1, 'قضايا', 'kd-y', 'CASE', 1, 1, 1, 0, '2019-04-15 18:03:19'),
(2, 'عقود', 'aakod', 'Akd', 1, 1, 1, 0, '2019-05-01 19:43:08'),
(3, 'استشارات', 'stsh-r-t', 'Istsh', 1, 1, 1, 0, '2019-05-08 01:28:21'),
(9, 'نزاعات مالية', 'nz_aa_t_m_ly', 'Dispute', NULL, 1, 0, 1, '2020-01-23 21:03:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_basic_services`
--
ALTER TABLE `tblmy_basic_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_basic_services`
--
ALTER TABLE `tblmy_basic_services`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

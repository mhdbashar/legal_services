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
-- Table structure for table `tblmy_phase_data`
--

CREATE TABLE IF NOT EXISTS `tblmy_phase_data` (
  `id` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_complete` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_phase_data`
--

INSERT INTO `tblmy_phase_data` (`id`, `phase_id`, `rel_id`, `rel_type`, `created_at`, `is_complete`) VALUES
(1, 1, 1, 'kd-y', '2019-11-26 22:44:07', 0),
(2, 2, 1, 'kd-y', '2019-11-26 22:46:00', 0),
(3, 3, 1, 'kd-y', '2019-11-26 22:46:26', 0),
(4, 4, 1, 'aakod', '2019-11-26 22:46:37', 0),
(5, 5, 1, 'aakod', '2019-11-26 22:46:43', 0),
(6, 6, 1, 'aakod', '2019-11-26 22:46:52', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_phase_data`
--
ALTER TABLE `tblmy_phase_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_phase_data`
--
ALTER TABLE `tblmy_phase_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

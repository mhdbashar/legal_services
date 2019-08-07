-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:58 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perfex_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcase_files`
--

CREATE TABLE `tbloservice_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `description` text,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `oservice_id` int(11) NOT NULL,
  `visible_to_customer` tinyint(1) DEFAULT '0',
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `external` varchar(40) DEFAULT NULL,
  `external_link` text,
  `thumbnail_link` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_files`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_files`
--
ALTER TABLE `tbloservice_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_files`
--
ALTER TABLE `tbloservice_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

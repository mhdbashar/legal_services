-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2020 at 12:18 AM
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
-- Database: `legal_services`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_services_tags`
--

CREATE TABLE `tblmy_services_tags` (
  `id` int(11) NOT NULL,
  `rel_type` varchar(100) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `tag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_services_tags`
--

INSERT INTO `tblmy_services_tags` (`id`, `rel_type`, `rel_id`, `tag`) VALUES
(1, 'kd-y', 9, 'تجريب'),
(2, 'kd-y', 9, 'قضية'),
(3, 'kd-y', 9, 'قضا'),
(4, 'kd-y', 9, 'نماذج'),
(5, 'kd-y', 9, 'الابحاث'),
(6, 'kd-y', 9, 'السعودية'),
(26, 'aakod', 1, 'تجريب'),
(27, 'aakod', 1, 'عقد'),
(28, 'aakod', 1, 'نماذج'),
(29, 'aakod', 1, 'السعودية');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_services_tags`
--
ALTER TABLE `tblmy_services_tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_services_tags`
--
ALTER TABLE `tblmy_services_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

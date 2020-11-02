-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 10:47 PM
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
-- Table structure for table `tbllegal_procedures`
--

CREATE TABLE `tbllegal_procedures` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbllegal_procedures`
--

INSERT INTO `tbllegal_procedures` (`id`, `list_id`, `subcat_id`, `reference_id`, `datecreated`) VALUES
(2, 1, 52, 1, '2020-04-20 00:06:03'),
(3, 1, 52, 3, '2020-04-20 00:13:37'),
(4, 1, 52, 7, '2020-04-20 00:25:30'),
(5, 1, 52, 8, '2020-04-20 00:26:43'),
(7, 2, 53, 10, '2020-04-20 00:46:41'),
(8, 4, 53, 11, '2020-04-20 01:01:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbllegal_procedures`
--
ALTER TABLE `tbllegal_procedures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_key` (`list_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbllegal_procedures`
--
ALTER TABLE `tbllegal_procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbllegal_procedures`
--
ALTER TABLE `tbllegal_procedures`
  ADD CONSTRAINT `list_key` FOREIGN KEY (`list_id`) REFERENCES `tbllegal_procedures_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2020 at 12:43 AM
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
-- Table structure for table `tblmy_judicialdept`
--

CREATE TABLE `tblmy_judicialdept` (
  `j_id` int(255) NOT NULL,
  `Jud_number` varchar(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `is_default` int(1) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_judicialdept`
--

INSERT INTO `tblmy_judicialdept` (`j_id`, `Jud_number`, `c_id`, `is_default`, `datecreated`) VALUES
(1, 'nothing_was_specified', 1, 1, '2020-10-10 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_judicialdept`
--
ALTER TABLE `tblmy_judicialdept`
  ADD PRIMARY KEY (`j_id`),
  ADD KEY `CourtJudKey` (`c_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_judicialdept`
--
ALTER TABLE `tblmy_judicialdept`
  MODIFY `j_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblmy_judicialdept`
--
ALTER TABLE `tblmy_judicialdept`
  ADD CONSTRAINT `CourtJudKey` FOREIGN KEY (`c_id`) REFERENCES `tblmy_courts` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

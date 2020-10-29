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
-- Table structure for table `tbllegal_procedures_lists`
--

CREATE TABLE `tbllegal_procedures_lists` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbllegal_procedures_lists`
--

INSERT INTO `tbllegal_procedures_lists` (`id`, `cat_id`, `rel_id`, `rel_type`, `datecreated`) VALUES
(1, 48, 1, 'kd-y', '2020-04-15 19:53:16'),
(2, 49, 1, 'kd-y', '2020-04-20 00:44:01'),
(3, 56, 1, 'kd-y', '2020-04-20 00:46:32'),
(4, 49, 5, 'kd-y', '2020-04-20 01:01:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbllegal_procedures_lists`
--
ALTER TABLE `tbllegal_procedures_lists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbllegal_procedures_lists`
--
ALTER TABLE `tbllegal_procedures_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

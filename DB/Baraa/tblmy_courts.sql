-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 11:02 AM
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
-- Table structure for table `tblmy_courts`
--

CREATE TABLE `tblmy_courts` (
  `c_id` int(255) NOT NULL,
  `court_name` varchar(255) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_courts`
--

INSERT INTO `tblmy_courts` (`c_id`, `court_name`, `datecreated`) VALUES
(1, 'محكمة دمشق القانونية', '2019-04-06 20:28:14'),
(2, 'تجريب', '2019-05-21 00:24:25'),
(3, 'تجريب1', '2019-05-21 00:26:21'),
(4, 'تجريب', '2019-05-21 00:27:06'),
(6, 'محكمة الشاغور', '2019-05-31 23:44:37'),
(11, 'last test', '2019-06-01 00:02:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  ADD PRIMARY KEY (`c_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  MODIFY `c_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2019 at 01:35 AM
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
-- Table structure for table `tblmy_session_info`
--

CREATE TABLE `tblmy_session_info` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `session_number` int(11) DEFAULT NULL,
  `judicial_office_number` int(11) NOT NULL,
  `court_id` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `court_decision` text NOT NULL,
  `session_information` text NOT NULL,
  `judge_id` int(11) NOT NULL,
  `session_type` text NOT NULL,
  `customer_report` int(11) NOT NULL,
  `send_to_customer` int(11) NOT NULL,
  `session_status` int(11) NOT NULL,
  `time` time NOT NULL,
  `next_session_date` date DEFAULT NULL,
  `next_session_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_session_info`
--

INSERT INTO `tblmy_session_info` (`id`, `task_id`, `session_number`, `judicial_office_number`, `court_id`, `dept`, `court_decision`, `session_information`, `judge_id`, `session_type`, `customer_report`, `send_to_customer`, `session_status`, `time`, `next_session_date`, `next_session_time`) VALUES
(7, 7, 123, 123, 2, 123, 'qqwqwqwqwqwqw', 'جلسة تجريبية جلسة تجريبية جلسة تجريبية', 1, 'جلسة قضائية', 1, 1, 0, '03:00:00', '2019-09-20', '01:00:00'),
(8, 8, 0, 0, 2, 0, '', '', 3, '', 0, 0, 0, '14:01:00', NULL, NULL),
(9, 9, 0, 0, 2, 0, '', '', 3, '', 0, 0, 0, '01:00:00', NULL, NULL),
(11, 11, 0, 0, 2, 0, '', '', 3, '', 0, 0, 0, '01:00:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_session_info`
--
ALTER TABLE `tblmy_session_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_session_info`
--
ALTER TABLE `tblmy_session_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

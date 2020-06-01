-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02 أكتوبر 2019 الساعة 00:22
-- إصدار الخادم: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legalserv`
--

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_transactions`
--

CREATE TABLE `tblmy_transactions` (
  `id` int(11) NOT NULL,
  `definition` int(11) NOT NULL,
  `description` varchar(225) NOT NULL,
  `type` int(11) NOT NULL,
  `origin` int(11) NOT NULL,
  `incoming_num` int(11) DEFAULT NULL,
  `incoming_source` int(11) DEFAULT NULL,
  `incoming_type` int(11) DEFAULT NULL,
  `is_secret` tinyint(1) NOT NULL,
  `importance` int(11) NOT NULL,
  `classification` int(11) NOT NULL,
  `owner` varchar(225) NOT NULL,
  `owner_phone` int(25) NOT NULL,
  `source_reporter` varchar(225) DEFAULT NULL,
  `source_reporter_phone` int(25) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_transactions`
--

INSERT INTO `tblmy_transactions` (`id`, `definition`, `description`, `type`, `origin`, `incoming_num`, `incoming_source`, `incoming_type`, `is_secret`, `importance`, `classification`, `owner`, `owner_phone`, `source_reporter`, `source_reporter_phone`, `email`, `date`, `isDeleted`) VALUES
(5, 0, 'ghfghfhgfhg', 1, 1, 654, 1, 1, 0, 1, 2, '0', 651, '0', 9655, 'mhdbashard@gmail.com', '2019-10-14', 0),
(6, 0, 'ghfghfhgfhg', 2, 1, 94789, 1, 1, 1, 1, 1, 'wassss', 6, '0', 6, 'mhdbashard@gmail.com', '2019-10-06', 0),
(7, 0, 'ghfghfhgfhg', 1, 1, 94789, 1, 0, 0, 0, 1, 'waseem', 0, 'jhv', 0, '', '0000-00-00', 0),
(8, 1, 'cxvxcvxc', 1, 1, NULL, NULL, NULL, 1, 0, 1, 'cxvxcvxcv', 0, NULL, NULL, NULL, NULL, 1),
(9, 1, 'ghfghfhgfhg', 0, 1, NULL, NULL, NULL, 1, 0, 1, 'dfsd', 0, NULL, NULL, NULL, NULL, 1),
(10, 1, 'ghfghfhgfhg', 0, 2, NULL, NULL, NULL, 0, 0, 2, 'waseem', 0, NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_transactions`
--
ALTER TABLE `tblmy_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_transactions`
--
ALTER TABLE `tblmy_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

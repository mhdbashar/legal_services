-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 أغسطس 2019 الساعة 10:30
-- إصدار الخادم: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm2`
--

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_sessiondiscussions`
--

CREATE TABLE `tblmy_sessiondiscussions` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL,
  `datecreated` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_sessiondiscussions`
--

INSERT INTO `tblmy_sessiondiscussions` (`id`, `session_id`, `subject`, `description`, `show_to_customer`, `datecreated`, `last_activity`, `staff_id`, `contact_id`) VALUES
(1, 1, 'ahmad zaher khrezaty', 'j', 1, '2019-07-22 20:13:52', '0000-00-00 00:00:00', 1, 0),
(2, 8, 'ahmad zaher khrezaty', '', 1, '2019-08-07 08:41:20', '0000-00-00 00:00:00', 1, 0),
(3, 9, 'asdasdasd', '', 1, '2019-08-07 09:43:25', '0000-00-00 00:00:00', 1, 0),
(4, 9, 'ahmad', 'asdasdasd', 1, '2019-08-07 15:31:53', '0000-00-00 00:00:00', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_sessiondiscussions`
--
ALTER TABLE `tblmy_sessiondiscussions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_sessiondiscussions`
--
ALTER TABLE `tblmy_sessiondiscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 أغسطس 2019 الساعة 10:29
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
-- بنية الجدول `tblmy_service_session`
--

CREATE TABLE `tblmy_service_session` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(200) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `court_id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `details` text NOT NULL,
  `next_action` text NOT NULL,
  `report` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_service_session`
--

INSERT INTO `tblmy_service_session` (`id`, `service_id`, `rel_id`, `rel_type`, `subject`, `court_id`, `judge_id`, `date`, `time`, `details`, `next_action`, `report`, `status`, `result`, `staff`, `deleted`, `created`) VALUES
(1, 0, 0, '', 'ahmad zaher', 2, 1, '2019-07-22', '00:00:00', 'Ahmad is King', '', '', 0, 0, 1, 1, '2019-08-05 03:29:17'),
(2, 1, 1, '', 'asdasd', 2, 1, '2019-07-18', '00:00:00', '', '', '', 1, 0, 1, 0, '2019-08-05 03:04:37'),
(3, 1, 1, '', 'yahia', 1, 2, '2019-07-18', '00:00:00', '', '', '', 0, 1, 1, 0, '2019-08-07 03:49:00'),
(4, 0, 0, '', 'ahmad zaher s', 1, 2, '2019-08-05', '00:00:00', '', '', '', 0, 0, 1, 1, '2019-08-05 03:29:25'),
(5, 1, 1, '', 'df', 1, 2, '0000-00-00', '12:00:00', '', '', '', 0, 0, 1, 0, '2019-08-07 04:00:33'),
(6, 0, 0, '', 'ahmad zaher khrezaty', 2, 2, '0000-00-00', '00:00:00', '', '', '', 0, 0, 1, 1, '2019-08-05 03:29:21'),
(7, 0, 0, '', 'ahmad zaher khrezaty', 1, 2, '2019-08-05', '00:00:00', '', '', '', 0, 0, 1, 1, '2019-08-05 03:31:00'),
(8, 1, 1, '', 'ahmad zaher khrezaty', 2, 2, '2019-08-05', '00:00:00', '', '', '', 0, 0, 1, 0, '2019-08-05 03:31:12'),
(9, 1, 1, '', 'ahmad', 2, 2, '2019-08-05', '02:58:00', 'Ahmad Zaher Khrezaty', 'asdasdasd', '', 0, 0, 1, 0, '2019-08-07 04:05:38'),
(10, 1, 1, '', 'ahmad', 2, 2, '2019-08-07', '13:03:00', '', '', '', 0, 0, 1, 0, '2019-08-07 03:53:37'),
(11, 1, 3, '', 'ahmad zaher khrezaty', 1, 1, '2019-08-02', '03:03:00', '', '', '', 0, 0, 1, 0, '2019-08-07 12:57:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_service_session`
--
ALTER TABLE `tblmy_service_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_service_session`
--
ALTER TABLE `tblmy_service_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

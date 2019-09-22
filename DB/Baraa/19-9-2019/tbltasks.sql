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
-- Table structure for table `tbltasks`
--

CREATE TABLE `tbltasks` (
  `id` int(11) NOT NULL,
  `name` mediumtext,
  `description` text,
  `priority` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `startdate` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `datefinished` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `is_added_from_contact` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT '0',
  `is_recurring_from` int(11) DEFAULT NULL,
  `cycles` int(11) NOT NULL DEFAULT '0',
  `total_cycles` int(11) NOT NULL DEFAULT '0',
  `custom_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `last_recurring_date` date DEFAULT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(30) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `billable` tinyint(1) NOT NULL DEFAULT '0',
  `billed` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `milestone` int(11) DEFAULT '0',
  `kanban_order` int(11) NOT NULL DEFAULT '0',
  `milestone_order` int(11) NOT NULL DEFAULT '0',
  `visible_to_client` tinyint(1) NOT NULL DEFAULT '0',
  `deadline_notified` int(11) NOT NULL DEFAULT '0',
  `is_session` int(11) DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbltasks`
--

INSERT INTO `tbltasks` (`id`, `name`, `description`, `priority`, `dateadded`, `startdate`, `duedate`, `datefinished`, `addedfrom`, `is_added_from_contact`, `status`, `recurring_type`, `repeat_every`, `recurring`, `is_recurring_from`, `cycles`, `total_cycles`, `custom_recurring`, `last_recurring_date`, `rel_id`, `rel_type`, `is_public`, `billable`, `billed`, `invoice_id`, `hourly_rate`, `milestone`, `kanban_order`, `milestone_order`, `visible_to_client`, `deadline_notified`, `is_session`, `deleted`) VALUES
(7, 'جلسة تجريبية', NULL, 2, '2019-09-18 15:33:12', '2019-09-17', '2019-09-20', NULL, 1, 0, 4, 'week', 0, 0, NULL, 0, 0, 0, NULL, 3, 'kd-y', 0, 1, 0, 0, '100.00', 0, 0, 0, 0, 0, 1, 0),
(8, 'test', NULL, 2, '2019-09-18 17:57:45', '2019-09-28', NULL, NULL, 1, 0, 4, NULL, 0, 0, NULL, 0, 0, 0, NULL, 3, 'kd-y', 0, 1, 0, 0, '0.00', 0, 0, 0, 0, 0, 1, 0),
(9, 'جلسة تجريبية 2', NULL, 2, '2019-09-18 17:59:14', '2019-09-17', NULL, NULL, 1, 0, 4, NULL, 0, 0, NULL, 0, 0, 0, NULL, 3, 'kd-y', 0, 1, 0, 0, '0.00', 0, 0, 0, 0, 0, 1, 0),
(11, 'qwqw', NULL, 2, '2019-09-18 18:32:30', '2019-09-18', NULL, NULL, 1, 0, 4, NULL, 0, 0, NULL, 0, 0, 0, NULL, 3, 'kd-y', 0, 1, 0, 0, '0.00', 0, 0, 0, 0, 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbltasks`
--
ALTER TABLE `tbltasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`),
  ADD KEY `milestone` (`milestone`),
  ADD KEY `kanban_order` (`kanban_order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbltasks`
--
ALTER TABLE `tbltasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

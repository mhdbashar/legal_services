-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 11:00 AM
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
-- Table structure for table `tblexpenses`
--

CREATE TABLE `tblexpenses` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax2` int(11) NOT NULL DEFAULT '0',
  `reference_no` varchar(100) DEFAULT NULL,
  `note` text,
  `expense_name` varchar(191) DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `billable` int(11) DEFAULT '0',
  `invoiceid` int(11) DEFAULT NULL,
  `paymentmode` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT '0',
  `cycles` int(11) NOT NULL DEFAULT '0',
  `total_cycles` int(11) NOT NULL DEFAULT '0',
  `custom_recurring` int(11) NOT NULL DEFAULT '0',
  `last_recurring_date` date DEFAULT NULL,
  `create_invoice_billable` tinyint(1) DEFAULT NULL,
  `send_invoice_to_customer` tinyint(1) NOT NULL,
  `recurring_from` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `addedfrom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblexpenses`
--

INSERT INTO `tblexpenses` (`id`, `category`, `currency`, `amount`, `tax`, `tax2`, `reference_no`, `note`, `expense_name`, `clientid`, `project_id`, `rel_id`, `rel_type`, `billable`, `invoiceid`, `paymentmode`, `date`, `recurring_type`, `repeat_every`, `recurring`, `cycles`, `total_cycles`, `custom_recurring`, `last_recurring_date`, `create_invoice_billable`, `send_invoice_to_customer`, `recurring_from`, `dateadded`, `addedfrom`) VALUES
(1, 1, 1, '12.00', 0, 0, '', '', 'test', 9, 1, NULL, NULL, 1, NULL, '', '2019-06-28', NULL, NULL, 0, 0, 0, 0, NULL, 0, 0, NULL, '2019-06-28 20:19:34', 1),
(2, 1, 1, '123.00', 0, 0, '', '', 'test2', 9, 1, NULL, NULL, 1, NULL, '', '2019-06-28', NULL, NULL, 0, 0, 0, 0, NULL, 0, 0, NULL, '2019-06-28 20:38:29', 1),
(3, 1, 1, '0.00', 0, 0, '', 'sdfsdf', 'sdfsdf', 9, 1, NULL, NULL, 1, NULL, '', '2019-07-09', NULL, NULL, 0, 0, 0, 0, NULL, 0, 0, NULL, '2019-07-09 01:08:04', 1),
(4, 1, 1, '0.00', 0, 0, '', 'sdfsdf', 'sdfsdf', 9, 1, NULL, NULL, 1, NULL, '', '2019-07-09', NULL, NULL, 0, 0, 0, 0, NULL, 0, 0, NULL, '2019-07-09 01:08:09', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblexpenses`
--
ALTER TABLE `tblexpenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `category` (`category`),
  ADD KEY `currency` (`currency`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblexpenses`
--
ALTER TABLE `tblexpenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

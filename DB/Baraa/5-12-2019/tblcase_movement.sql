-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2019 at 09:22 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `tblcase_movement`
--

CREATE TABLE IF NOT EXISTS `tblcase_movement` (
  `id` int(11) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(191) NOT NULL,
  `opponent_id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `representative` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `court_id` int(11) NOT NULL,
  `jud_num` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `billing_type` int(11) NOT NULL,
  `case_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `project_rate_per_hour` int(11) NOT NULL,
  `project_cost` decimal(15,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `project_created` date NOT NULL,
  `inserted_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` date DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `description` text NOT NULL,
  `case_result` varchar(255) NOT NULL,
  `file_number_case` int(11) DEFAULT NULL,
  `file_number_court` int(11) DEFAULT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_id` (`case_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

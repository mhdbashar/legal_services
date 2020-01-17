-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2019 at 01:17 AM
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
  `case_id` int(11) NOT NULL,
  `previous_case_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_movement`
--

INSERT INTO `tblcase_movement` (`id`, `numbering`, `code`, `name`, `opponent_id`, `clientid`, `representative`, `cat_id`, `subcat_id`, `court_id`, `jud_num`, `country`, `city`, `billing_type`, `case_status`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `inserted_date`, `deadline`, `date_finished`, `description`, `case_result`, `file_number_case`, `file_number_court`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `case_id`, `previous_case_id`) VALUES
(1, 1, 'CASE1', 'القضية الاولى', 2, 1, 2, 1, 2, 2, 7, 217, 'al-hasaka', 1, 2, 1, 0, '550.00', '1970-01-01', '2019-12-11', '2019-12-11 23:25:17', '1970-01-01', NULL, 'القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى القضية الاولى&nbsp;', 'متداولة', 123, 123, 0, '12.00', 0, 1, 1, 1, NULL),
(2, NULL, 'CASE1', 'القضية الاولى', 2, 1, 2, 1, 2, 2, 7, 217, 'al-hasaka', 1, 2, 1, 0, '550.00', '2019-11-28', '2019-12-11', '2019-12-11 23:31:47', '2019-12-26', NULL, 'حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب حركة القضية تجريب&nbsp;', 'متداولة', 123, 123, 0, '12.00', 0, 0, 1, 1, NULL),
(3, 2, 'CASE2', 'القضية الثانية', 2, 1, 1, 1, 2, 2, 7, 118, 'al-farwania', 1, 2, 1, 0, '341234.00', '1970-01-01', '2019-12-15', '2019-12-15 23:13:17', '1970-01-01', NULL, 'القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية القضية الثانية&nbsp;', 'متداولة', 12312, 1231231, 0, '234.00', 0, 1, 1, 3, NULL),
(4, 3, 'CASE3', 'ttest', 2, 1, 2, 1, 2, 2, 7, 118, 'kuwait', 1, 2, 1, 0, '13123.00', '1970-01-01', '2019-12-21', '2019-12-21 19:04:08', '1970-01-01', NULL, 'ttest ttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttest', 'متداولة', 123, 123, 0, '342.00', 0, 1, 1, 4, NULL),
(5, 4, 'CASE4', 'ttestttestttest', 2, 1, 2, 1, 2, 2, 7, 0, '', 1, 2, 1, 0, '0.00', '1970-01-01', '2019-12-21', '2019-12-21 19:05:03', '1970-01-01', NULL, '', 'متداولة', 65, 65, 0, '0.00', 0, 1, 1, 5, NULL),
(6, 5, 'CASE5', 'براء ', 2, 1, 2, 1, 2, 2, 7, 4, 'Oran', 1, 2, 1, 0, '234234.00', '1970-01-01', '2019-12-26', '2019-12-26 01:38:04', '1970-01-01', NULL, '<span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span>', 'متداولة', 342, 423, 0, '3.00', 0, 1, 1, 7, 4),
(7, NULL, 'CASE5', 'براء تيست تيست', 2, 1, 2, 1, 2, 2, 7, 4, 'Oran', 1, 2, 1, 0, '234234.00', '2019-12-25', '2019-12-26', '2019-12-26 01:43:41', '2019-12-26', NULL, '<span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span><span>previous_case_id</span>', 'متداولة', 342, 423, 0, '3.00', 0, 0, 1, 6, 4);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 11:01 AM
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
-- Table structure for table `tblmy_cases`
--

CREATE TABLE `tblmy_cases` (
  `id` int(11) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(191) NOT NULL,
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
  `deadline` date DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `description` text NOT NULL,
  `case_result` varchar(255) NOT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_cases`
--

INSERT INTO `tblmy_cases` (`id`, `numbering`, `code`, `name`, `clientid`, `representative`, `cat_id`, `subcat_id`, `court_id`, `jud_num`, `country`, `city`, `billing_type`, `case_status`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `case_result`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`) VALUES
(1, 1, 'CASE1', 'رفع دعوى على براء', 9, 3, 1, 2, 1, 5, 194, 'Khobar', 1, 2, 2, 0, '123.00', '2019-05-01', '2019-05-28', NULL, NULL, 'test&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edit', 'متداولة', 1, '2.00', 0, 0, 1),
(3, 2, 'CASE2', 'test 2', 9, 3, 1, 2, 1, 1, 194, 'yanbu', 1, 5, 3, 0, '123.00', '2019-05-02', '2019-05-30', '2019-05-02', NULL, 'test 2test 2test 2test 2', 'خاسرة', 1, '123.00', 0, 0, 1),
(4, 3, 'CASE3', 'test', 8, 4, 1, 2, 1, 6, 194, 'al-taef', 1, 5, 3, 0, '123.00', '2019-06-13', '2019-06-01', NULL, NULL, 'select#judges[].selectpickerselect#judges[].selectpicker', 'متداولة', 1, '123.00', 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_cases`
--
ALTER TABLE `tblmy_cases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_cases`
--
ALTER TABLE `tblmy_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

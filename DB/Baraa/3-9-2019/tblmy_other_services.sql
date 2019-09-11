-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2019 at 01:33 AM
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
-- Table structure for table `tblmy_other_services`
--

CREATE TABLE `tblmy_other_services` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `clientid` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `service_session_link` int(11) NOT NULL DEFAULT '0',
  `billing_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `project_rate_per_hour` int(11) NOT NULL,
  `project_cost` decimal(15,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `project_created` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `description` text NOT NULL,
  `country` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_other_services`
--

INSERT INTO `tblmy_other_services` (`id`, `service_id`, `code`, `numbering`, `name`, `clientid`, `cat_id`, `subcat_id`, `service_session_link`, `billing_type`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `country`, `city`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `branch_id`, `deleted`) VALUES
(1, 2, 'Akd1', 1, 'اول عقد', 3, 5, 6, 1, 1, 1, 0, '123.00', '2019-08-30', '2019-08-30', '2019-08-31', NULL, 'اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد اول عقد', 217, 'دمشق', 0, '123.00', 0, 0, 1, 0, 1),
(2, 2, 'Akd2', 2, 'عقد ثاني', 2, 5, 6, 0, 1, 1, 0, '0.00', '2019-08-17', '2019-08-30', NULL, NULL, 'عقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثانيعقد ثاني', 125, 'الزنتان', 0, '0.00', 0, 0, 1, 0, 0),
(3, 3, 'Istsh3', 3, 'استشارة اولى', 1, 7, 8, 1, 1, 1, 0, '123.00', '2019-08-30', '2019-08-30', '2019-08-31', NULL, 'استشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولىاستشارة اولى', 18, 'سترة', 0, '123.00', 0, 0, 1, 0, 0),
(4, 3, 'Istsh4', 4, 'ثاني استشارة', 3, 11, 12, 1, 1, 1, 0, '0.00', '2019-08-31', '2019-08-30', NULL, NULL, 'test', 113, 'اربد', 0, '0.00', 0, 0, 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_other_services`
--
ALTER TABLE `tblmy_other_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_other_services`
--
ALTER TABLE `tblmy_other_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 17, 2020 at 07:38 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_imported_services`
--

CREATE TABLE `tblmy_imported_services` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `clientid` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `service_session_link` int(11) NOT NULL DEFAULT 0,
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
  `progress` int(11) DEFAULT 0,
  `progress_from_tasks` int(11) NOT NULL DEFAULT 1,
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `imported` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_imported_services`
--

INSERT INTO `tblmy_imported_services` (`id`, `service_id`, `code`, `numbering`, `name`, `clientid`, `cat_id`, `subcat_id`, `service_session_link`, `billing_type`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `country`, `city`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `branch_id`, `deleted`, `imported`) VALUES
(3, 3, '432', NULL, 'added from api', 3, 0, 0, 1, 0, 1, 0, '0.00', '2019-07-12', '2020-06-04', '2020-07-22', NULL, 'this is service 3 and it\'s added by api', 0, '', 0, '9.50', 0, 1, 0, 0, 0, 0),
(18, 2, 'Akd3', 3, 'dasdsa', 17, 5, 6, 1, 2, 2, 0, '0.00', '2020-03-11', '2020-06-10', NULL, NULL, '', 0, '', 0, '0.00', 0, 1, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_imported_services`
--
ALTER TABLE `tblmy_imported_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_imported_services`
--
ALTER TABLE `tblmy_imported_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2020 at 12:41 AM
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
-- Table structure for table `tblmy_categories`
--

CREATE TABLE `tblmy_categories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_id` int(255) DEFAULT NULL,
  `parent_id` int(255) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_categories`
--

INSERT INTO `tblmy_categories` (`id`, `name`, `service_id`, `parent_id`, `type_id`, `datecreated`) VALUES
(1, 'قضايا احوال شخصية', 1, 0, NULL, '2019-04-22 23:18:06'),
(2, 'خلع وطلاق', 1, 1, NULL, '2019-04-22 23:18:34'),
(3, 'test', 1, 0, NULL, '2019-05-01 16:35:13'),
(4, '1', 1, 3, NULL, '2019-05-01 16:35:22'),
(5, 'test', 2, 0, NULL, '2019-05-15 04:58:00'),
(6, 'test cat', 2, 5, NULL, '2019-05-15 04:58:09'),
(7, 'cat', 3, 0, NULL, '2019-05-16 04:06:43'),
(8, 'sub test', 3, 7, NULL, '2019-05-16 04:07:06'),
(9, '54', 3, 0, NULL, '2019-06-02 03:53:28'),
(10, '676', 3, 9, NULL, '2019-06-02 03:53:56'),
(11, 'ttest', 3, 0, NULL, '2019-06-02 03:55:39'),
(12, 'sub trtst', 3, 11, NULL, '2019-06-02 03:55:52'),
(16, 'تصنيف رئيسي', 9, 0, NULL, '2020-03-28 21:48:40'),
(17, 'تصنيف فرعي', 9, 16, NULL, '2020-03-28 21:48:51'),
(18, 'sserserwer', 9, 16, NULL, '2020-03-28 21:55:28'),
(19, 'sdrsrsdr', 9, 16, NULL, '2020-03-28 21:55:36'),
(20, '2', 9, 0, NULL, '2020-03-28 22:08:52'),
(21, '222222222', 9, 20, NULL, '2020-03-28 22:08:58'),
(22, '1111111111', 1, 1, NULL, '2020-03-28 22:15:58'),
(23, '22222222222222', 1, 1, NULL, '2020-03-28 22:16:05'),
(24, '4444444444444', 1, 3, NULL, '2020-03-28 22:16:10'),
(25, 'test2', 2, 5, NULL, '2020-03-28 22:17:05'),
(26, 'test3', 2, 5, NULL, '2020-03-28 22:17:12'),
(27, '2', 2, 0, NULL, '2020-03-28 22:19:47'),
(28, '221212', 2, 27, NULL, '2020-03-28 22:19:56'),
(29, '22222', 2, 27, NULL, '2020-03-28 22:20:04'),
(44, 'طعون ', NULL, 0, 2, '2020-04-09 23:12:05'),
(45, 'طعون بقلب طعون', NULL, 44, 2, '2020-04-09 23:12:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CateServKey` (`service_id`),
  ADD KEY `categoty_type_key` (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  ADD CONSTRAINT `CateServKey` FOREIGN KEY (`service_id`) REFERENCES `tblmy_basic_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoty_type_key` FOREIGN KEY (`type_id`) REFERENCES `tblcategory_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

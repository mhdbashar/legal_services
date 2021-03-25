-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2020 at 08:26 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `office`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblkeycode`
--

CREATE TABLE `tblkeycode` (
  `id` int(11) NOT NULL,
  `keycode` varchar(1500) NOT NULL,
  `office_name_in_center` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblkeycode`
--

INSERT INTO `tblkeycode` (`id`, `keycode`, `office_name_in_center`) VALUES
(30, 'VFd0NFZWZFlSazlpVlZGNVV6SjBiazFyZEhGWFdFRTFZVmM0ZVZkV1JtNU5iR3hWVjFoS01HRllXWGxYVm1oYVkwUnNjR05WYkU5aFZ6UjVWMVpTWVZvelVuQmlha3BhV1d4d2NGUnRNVWhQVkdzMU1reFVXWEZPYlVReVMydG5Na3RxV1hBNWFXOHlXVkZuTWxsVVdtaE9iVU15UzJaYWFIUnRTVEpaV1QwPQ==', 'شبكة بابل لخدمات القانون');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblkeycode`
--
ALTER TABLE `tblkeycode`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblkeycode`
--
ALTER TABLE `tblkeycode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

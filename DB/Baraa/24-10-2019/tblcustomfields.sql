-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2019 at 11:10 PM
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
-- Table structure for table `tblcustomfields`
--

CREATE TABLE IF NOT EXISTS `tblcustomfields` (
  `id` int(11) NOT NULL,
  `fieldto` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `options` mediumtext,
  `display_inline` tinyint(1) NOT NULL DEFAULT '0',
  `field_order` int(11) DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `show_on_pdf` int(11) NOT NULL DEFAULT '0',
  `show_on_ticket_form` tinyint(1) NOT NULL DEFAULT '0',
  `only_admin` tinyint(1) NOT NULL DEFAULT '0',
  `show_on_table` tinyint(1) NOT NULL DEFAULT '0',
  `show_on_client_portal` int(11) NOT NULL DEFAULT '0',
  `disalow_client_to_edit` int(11) NOT NULL DEFAULT '0',
  `bs_column` int(11) NOT NULL DEFAULT '12'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcustomfields`
--

INSERT INTO `tblcustomfields` (`id`, `fieldto`, `name`, `slug`, `required`, `type`, `options`, `display_inline`, `field_order`, `active`, `show_on_pdf`, `show_on_ticket_form`, `only_admin`, `show_on_table`, `show_on_client_portal`, `disalow_client_to_edit`, `bs_column`) VALUES
(1, 'legal_phase_1_kd_y', 'رقم الطلب', 'legal_phase_1_kd_y_rkm_ltlb', 1, 'number', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 12),
(2, 'legal_phase_1_kd_y', 'المحكمة', 'legal_phase_1_kd_y_lmhkm', 1, 'select', 'test', 0, 1, 1, 0, 0, 0, 0, 0, 0, 12),
(3, 'legal_phase_1_kd_y', 'ملاحظات', 'legal_phase_1_kd_y_ml_hth_t', 0, 'textarea', '', 0, 2, 1, 0, 0, 0, 0, 0, 0, 12),
(4, 'legal_phase_2_kd_y', 'رقم القيد', 'legal_phase_2_kd_y_rkm_lkyd', 1, 'number', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 12),
(5, 'legal_phase_2_kd_y', 'تاريخ الإحالة', 'legal_phase_2_kd_y_t_rykh_l_h_l', 1, 'date_picker', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 12),
(6, 'legal_phase_1_aakod', 'test', 'legal_phase_1_aakod_test', 1, 'number', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 12),
(7, 'legal_phase_3_kd_y', 'رقم القرار', 'legal_phase_3_kd_y_rkm_lkr_r', 1, 'number', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcustomfields`
--
ALTER TABLE `tblcustomfields`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcustomfields`
--
ALTER TABLE `tblcustomfields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

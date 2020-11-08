-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2020 at 12:20 PM
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
-- Table structure for table `tblmy_services_tags`
--

CREATE TABLE `tblmy_services_tags` (
  `id` int(11) NOT NULL,
  `rel_type` varchar(100) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_services_tags`
--

INSERT INTO `tblmy_services_tags` (`id`, `rel_type`, `rel_id`, `tag`) VALUES
(1, 'kd-y', 9, 'تجريب'),
(2, 'kd-y', 9, 'قضية'),
(3, 'kd-y', 9, 'اولى'),
(4, 'kd-y', 9, 'من'),
(5, 'kd-y', 9, 'اجل'),
(6, 'kd-y', 9, 'التاغات'),
(7, 'kd-y', 9, '<span>الحمد'),
(8, 'kd-y', 9, 'لله'),
(9, 'kd-y', 9, 'اليوم'),
(10, 'kd-y', 9, 'و'),
(11, 'kd-y', 9, 'رسمياً'),
(12, 'kd-y', 9, 'أتممت'),
(13, 'kd-y', 9, 'المتطلبات'),
(14, 'kd-y', 9, 'لشهادة'),
(15, 'kd-y', 9, 'الماجستير'),
(16, 'kd-y', 9, 'في'),
(17, 'kd-y', 9, 'هندسة'),
(18, 'kd-y', 9, 'الطاقات'),
(19, 'kd-y', 9, 'المتجددة'),
(20, 'kd-y', 9, 'من'),
(21, 'kd-y', 9, 'جامعة'),
(22, 'kd-y', 9, 'أوريجون'),
(23, 'kd-y', 9, 'تيك'),
(24, 'kd-y', 9, 'في'),
(25, 'kd-y', 9, 'الولايات'),
(26, 'kd-y', 9, 'المتحدة'),
(27, 'kd-y', 9, 'الأمريكية'),
(28, 'kd-y', 9, 'بتقدير'),
(29, 'kd-y', 9, 'ممتاز'),
(30, 'kd-y', 9, 'خلال'),
(31, 'kd-y', 9, 'فترة'),
(32, 'kd-y', 9, 'دراستي'),
(33, 'kd-y', 9, 'كنت'),
(34, 'kd-y', 9, 'محظوظا'),
(35, 'kd-y', 9, 'بتدريس'),
(36, 'kd-y', 9, '6'),
(37, 'kd-y', 9, 'صفوف'),
(38, 'kd-y', 9, 'بما'),
(39, 'kd-y', 9, 'يتعلق'),
(40, 'kd-y', 9, 'بمبادئ'),
(41, 'kd-y', 9, 'الدارات'),
(42, 'kd-y', 9, 'الكهربائية'),
(43, 'kd-y', 9, 'لطلاب'),
(44, 'kd-y', 9, 'الهندسة'),
(45, 'kd-y', 9, 'الكهربائية'),
(46, 'kd-y', 9, 'و'),
(47, 'kd-y', 9, 'بمساعدة'),
(48, 'kd-y', 9, 'الأساتذة'),
(49, 'kd-y', 9, 'بتدريس'),
(50, 'kd-y', 9, '12'),
(51, 'kd-y', 9, 'صف'),
(52, 'kd-y', 9, 'مختلف<span><br><span>لم'),
(53, 'kd-y', 9, 'أبتعد'),
(54, 'kd-y', 9, 'كثيرا'),
(55, 'kd-y', 9, 'عن'),
(56, 'kd-y', 9, 'القسم'),
(57, 'kd-y', 9, 'العملي'),
(58, 'kd-y', 9, 'للهندسة'),
(59, 'kd-y', 9, 'و'),
(60, 'kd-y', 9, 'أتممت'),
(61, 'kd-y', 9, 'سنة'),
(62, 'kd-y', 9, 'كاملة'),
(63, 'kd-y', 9, 'من'),
(64, 'kd-y', 9, 'العمل'),
(65, 'kd-y', 9, 'بشركة'),
(66, 'kd-y', 9, 'PacifiCorp'),
(67, 'kd-y', 9, 'و'),
(68, 'kd-y', 9, 'التي'),
(69, 'kd-y', 9, 'تعد'),
(70, 'kd-y', 9, 'من'),
(71, 'kd-y', 9, 'أكبر'),
(72, 'kd-y', 9, 'شركات'),
(73, 'kd-y', 9, 'الكهرباء'),
(74, 'kd-y', 9, 'بالساحل'),
(75, 'kd-y', 9, 'الغربي'),
(76, 'kd-y', 9, 'للولايات'),
(77, 'kd-y', 9, 'المتحدة'),
(78, 'kd-y', 9, 'خلالها'),
(79, 'kd-y', 9, 'عملت'),
(80, 'kd-y', 9, 'على<span><span'),
(81, 'kd-y', 9, 'class=textexposedhide>..<span>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_services_tags`
--
ALTER TABLE `tblmy_services_tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_services_tags`
--
ALTER TABLE `tblmy_services_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2020 at 09:51 PM
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
-- Table structure for table `tblmy_dialog_boxes`
--

CREATE TABLE IF NOT EXISTS `tblmy_dialog_boxes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc_ar` text,
  `desc_en` text,
  `page_url` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_dialog_boxes`
--

INSERT INTO `tblmy_dialog_boxes` (`id`, `title`, `desc_ar`, `desc_en`, `page_url`, `active`) VALUES
(5, 'ماهي مربعات الحوار؟', 'ما هو أبجد هوز؟ الإجابة السريعة والمبسطة هي أن Lorem Ipsum يشير إلى النص الذي تستخدمه صناعة DTP (النشر المكتبي) كنص بديل عندما لا يتوفر النص الحقيقي. على سبيل المثال ، عند تصميم كتيب أو كتاب ، سيقوم المصمم بإدراج نص Lorem ipsum إذا كان النص الحقيقي غير متوفر.', 'What is Lorem ipsum? A quick and simplified answer is that Lorem Ipsum refers to text that the DTP (Desktop Publishing) industry use as replacement text when the real text is not available. For example, when designing a brochure or book, a designer will insert Lorem ipsum text if the real text is not available.', 'admin/Dialog_boxes', 0),
(6, 'ماهي انشاء القضية؟', 'إنشاء القضيةإنشاء القضيةإنشاء القضيةإنشاء القضيةإنشاء القضيةإنشاء القضيةإنشاء القضية', 'Create the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issueCreate the issue', 'admin/Case/add/1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_dialog_boxes`
--
ALTER TABLE `tblmy_dialog_boxes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_dialog_boxes`
--
ALTER TABLE `tblmy_dialog_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30 سبتمبر 2019 الساعة 19:41
-- إصدار الخادم: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legalserv`
--

-- --------------------------------------------------------

--
-- بنية الجدول `tblactivity_log`
--

CREATE TABLE `tblactivity_log` (
  `id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `staffid` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblactivity_log`
--

INSERT INTO `tblactivity_log` (`id`, `description`, `date`, `staffid`) VALUES
(93, 'New Session [ID: 12]', '2019-08-18 14:42:10', 'Mhdbashar Das'),
(94, 'Vac Deleted [12]', '2019-08-18 14:42:16', 'Mhdbashar Das'),
(95, 'Vac Deleted [12]', '2019-08-18 14:42:22', 'Mhdbashar Das'),
(96, 'Sub Services Deleted [Service ID: 2]', '2019-08-18 17:58:25', 'Mhdbashar Das'),
(97, 'Sub Services Deleted [Service ID: 5]', '2019-08-18 17:58:36', 'Mhdbashar Das'),
(98, 'Sub Services Deleted [Service ID: 4]', '2019-08-18 17:58:40', 'Mhdbashar Das'),
(99, 'New Sub Service Added [ServiceID: 6]', '2019-08-18 18:53:54', 'Mhdbashar Das'),
(100, 'New Task Added [ID:7, Name: عقد جديد]', '2019-08-18 19:01:37', 'Mhdbashar Das'),
(101, 'New Sub Service Added [ServiceID: 7]', '2019-08-18 19:07:37', 'Mhdbashar Das'),
(102, 'Case Updated [CaseID: 7]', '2019-08-18 19:18:11', 'Mhdbashar Das'),
(103, 'Case Deleted [CaseID: 7]', '2019-08-20 23:01:25', 'Mhdbashar Das'),
(104, 'Case Deleted [CaseID: 8]', '2019-08-20 23:01:33', 'Mhdbashar Das'),
(105, 'New Cases Movement [id: 10]', '2019-08-20 23:03:01', 'Mhdbashar Das'),
(106, 'New Cases Added [CaseID: 9]', '2019-08-20 23:03:02', 'Mhdbashar Das'),
(107, 'Case Updated [CaseID: 9]', '2019-08-20 23:03:29', 'Mhdbashar Das'),
(108, 'New Sub Service Added [ServiceID: 1]', '2019-08-20 23:06:37', 'Mhdbashar Das'),
(109, 'Sub Services Deleted [Service ID: 1]', '2019-08-21 19:36:33', 'Mhdbashar Das'),
(110, 'New Sub Service Added [ServiceID: 2]', '2019-08-21 19:37:34', 'Mhdbashar Das'),
(111, 'Sub Services Deleted [Service ID: 2]', '2019-08-21 20:08:01', 'Mhdbashar Das'),
(112, 'Project Deleted [ID: 3, Name: test]', '2019-08-22 18:08:40', 'Mhdbashar Das'),
(113, 'New Project Created [ID: 4]', '2019-08-22 18:09:03', 'Mhdbashar Das'),
(114, 'New Project Created [ID: 5]', '2019-08-24 12:06:57', 'Mhdbashar Das'),
(115, 'New Task Added [ID:8, Name: test]', '2019-08-25 18:43:59', 'Mhdbashar Das'),
(116, 'New Task Added [ID:9, Name: test]', '2019-08-25 18:45:06', 'Mhdbashar Das'),
(117, 'New Case Movement [id: 11]', '2019-08-26 18:44:27', 'Mhdbashar Das'),
(118, 'New Cases Added [CaseID: 1]', '2019-08-26 18:44:28', 'Mhdbashar Das'),
(119, 'Case Deleted [CaseID: 1]', '2019-08-26 18:46:08', 'Mhdbashar Das'),
(120, 'New Case Movement [id: 1]', '2019-08-26 18:47:05', 'Mhdbashar Das'),
(121, 'New Cases Added [CaseID: 2]', '2019-08-26 18:47:06', 'Mhdbashar Das'),
(122, 'Project Updated [ID: 4]', '2019-08-26 21:02:08', 'Mhdbashar Das'),
(123, 'Invoice Status Updated [Invoice Number: INV-000001, From: Overdue To: Paid]', '2019-08-26 21:06:17', 'Mhdbashar Das'),
(124, 'Payment Recorded [ID:1, Invoice Number: INV-000001, Total: $10.00]', '2019-08-26 21:06:17', 'Mhdbashar Das'),
(125, 'Payment Updated [Number:1]', '2019-08-26 21:06:38', 'Mhdbashar Das'),
(126, 'New Proposal Created [ID: 1]', '2019-08-26 21:10:39', 'Mhdbashar Das'),
(127, 'Failed Login Attempt [Email: mhdbashard@gmail.com, Is Staff Member: Yes, IP: ::1]', '2019-08-29 09:46:20', NULL),
(128, 'New Sub Service Added [ServiceID: 1]', '2019-08-29 09:48:54', 'Mhdbashar Das'),
(129, 'Sub Services Updated [ServID: 1]', '2019-08-29 09:51:08', 'Mhdbashar Das'),
(130, 'Sub Services Updated [ServID: 1]', '2019-08-29 09:51:27', 'Mhdbashar Das'),
(131, 'Case Deleted [CaseID: 2]', '2019-08-29 09:59:16', 'Mhdbashar Das'),
(132, 'New Case Movement [id: 2]', '2019-08-29 10:19:39', 'Mhdbashar Das'),
(133, 'New Cases Added [CaseID: 3]', '2019-08-29 10:19:41', 'Mhdbashar Das'),
(134, 'Case Deleted [CaseID: 3]', '2019-08-29 10:23:59', 'Mhdbashar Das'),
(135, 'New Case Movement [id: 1]', '2019-08-29 10:25:28', 'Mhdbashar Das'),
(136, 'New Cases Added [CaseID: 4]', '2019-08-29 10:25:29', 'Mhdbashar Das'),
(137, 'New Case Movement [id: 1]', '2019-08-29 10:34:44', 'Mhdbashar Das'),
(138, 'New Cases Added [CaseID: 1]', '2019-08-29 10:34:46', 'Mhdbashar Das'),
(139, 'Case Updated [CaseID: 1]', '2019-08-29 10:35:24', 'Mhdbashar Das'),
(140, 'New Case Movement [id: 2]', '2019-08-29 10:35:25', 'Mhdbashar Das'),
(141, 'Sub Services Deleted [Service ID: 1]', '2019-08-29 11:04:15', 'Mhdbashar Das'),
(142, 'New Sub Service Added [ServiceID: 2]', '2019-08-29 11:05:36', 'Mhdbashar Das'),
(143, 'New Session [ID: 14]', '2019-08-29 12:11:58', 'Mhdbashar Das'),
(144, 'New Branches Added []', '2019-08-29 14:44:56', 'Mhdbashar Das'),
(145, 'Add Branch [1] To clients [3]', '2019-08-29 14:45:42', 'Mhdbashar Das'),
(146, 'Customer Info Updated [ID: 3]', '2019-08-29 14:45:42', 'Mhdbashar Das'),
(147, 'New Task Added [ID:10, Name: test]', '2019-08-29 21:45:58', 'Mhdbashar Das'),
(148, 'Sub Services Updated [ServID: 2]', '2019-08-29 21:46:48', 'Mhdbashar Das'),
(149, 'استشارات Deleted [ServiceID: 2]', '2019-09-01 17:30:30', 'Mhdbashar Das'),
(150, 'New استشارات Added [ServiceID: 5]', '2019-09-01 17:43:17', 'Mhdbashar Das'),
(151, 'New عقود Added [ServiceID: 6]', '2019-09-03 18:47:47', 'Mhdbashar Das'),
(152, 'Project Updated [ID: 5]', '2019-09-03 18:50:31', 'Mhdbashar Das'),
(153, 'New Task Added [ID:11, Name: test]', '2019-09-03 19:17:26', 'Mhdbashar Das'),
(154, 'New Task Added [ID:12, Name: test]', '2019-09-03 19:17:27', 'Mhdbashar Das'),
(155, 'عقود Restore From Recycle Bin [CaseID: 1]', '2019-09-04 16:25:47', 'Mhdbashar Das'),
(156, 'عقود Moved To Recycle Bin [ServiceID: 2]', '2019-09-04 17:37:50', 'Mhdbashar Das'),
(157, 'New عقود Added [ServiceID: 5]', '2019-09-04 17:39:59', 'Mhdbashar Das'),
(158, 'New Expense Category Added [ID: 1]', '2019-09-04 18:49:18', 'Mhdbashar Das'),
(159, 'New Expense Added [5]', '2019-09-04 18:49:29', 'Mhdbashar Das'),
(160, 'Expense Deleted [1]', '2019-09-04 18:49:36', 'Mhdbashar Das'),
(161, 'Expense Receipt Deleted [ExpenseID: 5]', '2019-09-04 18:49:59', 'Mhdbashar Das'),
(162, 'عقود Deleted [ServiceID: 2]', '2019-09-04 19:36:30', 'Mhdbashar Das'),
(163, 'عقود Deleted [ServiceID: 1]', '2019-09-04 19:36:36', 'Mhdbashar Das'),
(164, 'استشارات Deleted [ServiceID: 3]', '2019-09-04 19:36:52', 'Mhdbashar Das'),
(165, 'استشارات Deleted [ServiceID: 4]', '2019-09-04 19:37:09', 'Mhdbashar Das'),
(166, 'New procuration [ID: 1] for client [ID: 3', '2019-09-07 17:16:29', 'Mhdbashar Das'),
(167, 'عقود Moved To Recycle Bin [ServiceID: 5]', '2019-09-08 13:13:57', 'Mhdbashar Das'),
(168, 'Cron Invoked Manually', '2019-09-08 14:15:11', 'Mhdbashar Das'),
(169, 'Cron Invoked Manually', '2019-09-10 20:44:29', 'Mhdbashar Das'),
(170, ' Confirm Empty Legal Services Recycle Bin', '2019-09-10 20:44:42', 'Mhdbashar Das'),
(171, 'New Project Created [ID: 6]', '2019-09-12 19:22:28', 'Mhdbashar Das'),
(172, 'New Invoice Item Added [ID:2, المبلغ المدين شهريا]', '2019-09-12 20:57:11', 'Mhdbashar Das'),
(173, 'New Project Created [ID: 7]', '2019-09-15 20:21:26', 'Mhdbashar Das'),
(174, 'Project Updated [ID: 7]', '2019-09-15 20:26:33', 'Mhdbashar Das'),
(175, 'Case Moved To Recycle Bin [CaseID: 1]', '2019-09-15 20:35:08', 'Mhdbashar Das'),
(176, 'Case Deleted [CaseID: 1]', '2019-09-15 20:35:38', 'Mhdbashar Das'),
(177, 'New Case Movement [id: 3]', '2019-09-16 17:53:06', 'Mhdbashar Das'),
(178, 'New Case Added [CaseID: 2]', '2019-09-16 17:53:07', 'Mhdbashar Das'),
(179, 'Add Branch [1] To cases [2]', '2019-09-16 17:53:08', 'Mhdbashar Das'),
(180, 'Procuration State Updated [ID: 2]', '2019-09-16 17:54:52', 'Mhdbashar Das'),
(181, 'Procuration State Updated [ID: 1]', '2019-09-16 17:55:01', 'Mhdbashar Das'),
(182, 'Procuration Type Updated [ID: 1]', '2019-09-16 17:55:40', 'Mhdbashar Das'),
(183, 'Procuration Type Updated [ID: 2]', '2019-09-16 17:55:50', 'Mhdbashar Das'),
(184, 'New procuration [ID: 1] for client [ID: ', '2019-09-16 17:56:46', 'Mhdbashar Das'),
(185, 'New procuration [ID: 2] for client [ID: ', '2019-09-17 00:03:18', 'Mhdbashar Das'),
(186, 'New procuration [ID: 3] for client [ID: ', '2019-09-17 13:44:46', 'Mhdbashar Das'),
(187, ' procuration Deleted [ID: 3]', '2019-09-17 13:46:18', 'Mhdbashar Das'),
(188, 'Procuration Doc Deleted [ProcID: 1]', '2019-09-17 13:46:31', 'Mhdbashar Das'),
(189, ' procuration Deleted [ID: 1]', '2019-09-17 13:46:31', 'Mhdbashar Das'),
(190, 'Procuration Doc Deleted [ProcID: 2]', '2019-09-17 13:46:44', 'Mhdbashar Das'),
(191, ' procuration Deleted [ID: 2]', '2019-09-17 13:46:44', 'Mhdbashar Das'),
(192, 'New procuration [ID: 1] for client [ID: ', '2019-09-17 18:38:18', 'Mhdbashar Das'),
(193, 'New procuration [ID: 2] for client [ID: ', '2019-09-17 20:14:29', 'Mhdbashar Das'),
(194, 'New procuration [ID: 2] for client [ID: ', '2019-09-17 21:13:35', 'Mhdbashar Das'),
(195, 'New procuration [ID: 3] for client [ID: ', '2019-09-17 21:13:36', 'Mhdbashar Das'),
(196, 'New procuration [ID: 4] for client [ID: ', '2019-09-17 21:13:41', 'Mhdbashar Das'),
(197, ' procuration Deleted [ID: 4]', '2019-09-17 21:13:50', 'Mhdbashar Das'),
(198, ' procuration Deleted [ID: 3]', '2019-09-17 21:13:56', 'Mhdbashar Das'),
(199, ' procuration Deleted [ID: 2]', '2019-09-17 21:14:00', 'Mhdbashar Das'),
(200, 'New procuration [ID: 2] for client [ID: ', '2019-09-17 21:14:54', 'Mhdbashar Das'),
(201, 'New procuration [ID: 3] for client [ID: ', '2019-09-17 21:17:11', 'Mhdbashar Das'),
(202, ' procuration Updated [ID: ] for client [ID: ', '2019-09-19 13:50:05', 'Mhdbashar Das'),
(203, 'Procuration Doc Deleted [ProcID: 3]', '2019-09-19 13:50:41', 'Mhdbashar Das'),
(204, ' procuration Deleted [ID: 3]', '2019-09-19 13:50:42', 'Mhdbashar Das'),
(205, ' procuration Deleted [ID: 2]', '2019-09-19 13:50:50', 'Mhdbashar Das'),
(206, 'New procuration [ID: 2] for client [ID: ', '2019-09-19 13:55:50', 'Mhdbashar Das'),
(207, 'New procuration [ID: 3] for client [ID: ', '2019-09-19 13:57:00', 'Mhdbashar Das'),
(208, ' procuration Updated [ID: ] for client [ID: ', '2019-09-19 13:59:03', 'Mhdbashar Das'),
(209, ' procuration Deleted [ID: 2]', '2019-09-19 14:07:28', 'Mhdbashar Das'),
(210, ' procuration Deleted [ID: 3]', '2019-09-19 14:07:38', 'Mhdbashar Das'),
(211, ' procuration Updated [ID: ] for client [ID: 1', '2019-09-19 14:07:59', 'Mhdbashar Das'),
(212, 'New procuration [ID: 2] for client [ID: ', '2019-09-19 17:58:11', 'Mhdbashar Das'),
(213, ' procuration Deleted [ID: 2]', '2019-09-19 18:01:47', 'Mhdbashar Das'),
(214, ' procuration Updated [ID: ] for client [ID: 1', '2019-09-19 18:02:01', 'Mhdbashar Das'),
(215, 'New procuration [ID: 2] for client [ID: ', '2019-09-19 18:03:20', 'Mhdbashar Das'),
(216, 'Procuration Doc Deleted [ProcID: 2]', '2019-09-19 18:04:30', 'Mhdbashar Das'),
(217, ' procuration Deleted [ID: 2]', '2019-09-19 18:04:30', 'Mhdbashar Das'),
(218, 'Procuration Doc Deleted [ProcID: 1]', '2019-09-19 18:04:34', 'Mhdbashar Das'),
(219, ' procuration Deleted [ID: 1]', '2019-09-19 18:04:34', 'Mhdbashar Das'),
(220, 'New procuration [ID: 1] for client [ID: ', '2019-09-19 18:05:18', 'Mhdbashar Das'),
(221, 'New procuration [ID: 2] for client [ID: ', '2019-09-19 18:16:19', 'Mhdbashar Das'),
(222, 'Procuration Doc Deleted [ProcID: 1]', '2019-09-19 18:17:26', 'Mhdbashar Das'),
(223, ' procuration Deleted [ID: 1]', '2019-09-19 18:17:27', 'Mhdbashar Das'),
(224, 'Procuration Doc Deleted [ProcID: 2]', '2019-09-19 18:17:32', 'Mhdbashar Das'),
(225, ' procuration Deleted [ID: 2]', '2019-09-19 18:17:32', 'Mhdbashar Das'),
(226, 'New procuration [ID: 1] for client [ID: 3', '2019-09-19 18:19:56', 'Mhdbashar Das'),
(227, 'New procuration [ID: 2] for client [ID: ', '2019-09-19 18:20:55', 'Mhdbashar Das'),
(228, 'New procuration [ID: 3] for client [ID: ', '2019-09-19 19:04:15', 'Mhdbashar Das'),
(229, 'New procuration [ID: 1] for client [ID: ', '2019-09-19 19:15:05', 'Mhdbashar Das'),
(230, 'New Case Movement [id: 4]', '2019-09-19 19:32:45', 'Mhdbashar Das'),
(231, 'New Case Added [CaseID: 3]', '2019-09-19 19:32:46', 'Mhdbashar Das'),
(232, 'Add Branch [1] To cases [3]', '2019-09-19 19:32:46', 'Mhdbashar Das'),
(233, 'New Case Movement [id: 5]', '2019-09-19 19:37:45', 'Mhdbashar Das'),
(234, 'New Case Added [CaseID: 4]', '2019-09-19 19:37:47', 'Mhdbashar Das'),
(235, 'Add Branch [1] To cases [4]', '2019-09-19 19:37:47', 'Mhdbashar Das'),
(236, 'Case Moved To Recycle Bin [CaseID: 4]', '2019-09-19 19:38:13', 'Mhdbashar Das'),
(237, 'Case Moved To Recycle Bin [CaseID: 3]', '2019-09-19 19:38:19', 'Mhdbashar Das'),
(238, 'Case Deleted [CaseID: 3]', '2019-09-19 19:48:01', 'Mhdbashar Das'),
(239, 'Case Deleted [CaseID: 4]', '2019-09-19 19:48:07', 'Mhdbashar Das'),
(240, 'New transaction [ID: 1]', '2019-09-30 01:25:25', 'Mhdbashar Das'),
(241, 'New transaction [ID: 2]', '2019-09-30 01:26:36', 'Mhdbashar Das'),
(242, 'New transaction [ID: 3]', '2019-09-30 01:37:21', 'Mhdbashar Das'),
(243, 'New transaction [ID: 4]', '2019-09-30 20:25:10', 'Mhdbashar Das');

-- --------------------------------------------------------

--
-- بنية الجدول `tblannouncements`
--

CREATE TABLE `tblannouncements` (
  `announcementid` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `message` text DEFAULT NULL,
  `showtousers` int(11) NOT NULL,
  `showtostaff` int(11) NOT NULL,
  `showname` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  `userid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblbranches`
--

CREATE TABLE `tblbranches` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblbranches`
--

INSERT INTO `tblbranches` (`id`, `title_en`, `title_ar`, `country_id`, `city_id`, `address`, `phone`) VALUES
(1, 'test', 'test', 217, 336, 'test', 'test');

-- --------------------------------------------------------

--
-- بنية الجدول `tblbranches_services`
--

CREATE TABLE `tblbranches_services` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `rel_type` varchar(25) NOT NULL,
  `rel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblbranches_services`
--

INSERT INTO `tblbranches_services` (`id`, `branch_id`, `rel_type`, `rel_id`) VALUES
(1, 1, 'clients', 3),
(2, 1, 'cases', 2),
(3, 1, 'cases', 3),
(4, 1, 'cases', 4);

-- --------------------------------------------------------

--
-- بنية الجدول `tblcasediscussioncomments`
--

CREATE TABLE `tblcasediscussioncomments` (
  `id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `discussion_type` varchar(10) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT 0,
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcasediscussions`
--

CREATE TABLE `tblcasediscussions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcasediscussions`
--

INSERT INTO `tblcasediscussions` (`id`, `project_id`, `subject`, `description`, `show_to_customer`, `datecreated`, `last_activity`, `staff_id`, `contact_id`) VALUES
(1, 5, '1', '1111111111111111111', 1, '2019-07-30 22:54:37', '2019-07-30 23:06:26', 3, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblcase_activity`
--

CREATE TABLE `tblcase_activity` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `fullname` varchar(100) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT 0,
  `description_key` varchar(191) NOT NULL COMMENT 'Language file key',
  `additional_data` text DEFAULT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcase_activity`
--

INSERT INTO `tblcase_activity` (`id`, `project_id`, `staff_id`, `contact_id`, `fullname`, `visible_to_customer`, `description_key`, `additional_data`, `dateadded`) VALUES
(4, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:41:16'),
(5, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:41:16'),
(6, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:41:21'),
(7, 12, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:43:13'),
(8, 12, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:43:13'),
(9, 15, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:47:16'),
(10, 15, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:47:16'),
(11, 15, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:47:21'),
(12, 17, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:48:50'),
(13, 17, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:48:51'),
(14, 17, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:48:56'),
(15, 18, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:49:10'),
(16, 18, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:49:10'),
(17, 18, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:49:15'),
(18, 19, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:49:58'),
(19, 19, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:49:58'),
(20, 20, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:51:11'),
(21, 20, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:51:11'),
(22, 20, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:51:16'),
(23, 21, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:51:24'),
(24, 21, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:51:24'),
(25, 22, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:52:40'),
(26, 22, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:52:40'),
(27, 23, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:53:06'),
(28, 23, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:53:06'),
(29, 24, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:54:31'),
(30, 24, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:54:31'),
(31, 24, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:54:36'),
(56, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:03:50'),
(57, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:03:50'),
(58, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:03:55'),
(62, 10, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:06:54'),
(63, 10, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:06:54'),
(64, 10, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:06:59'),
(65, 11, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:08:34'),
(66, 11, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:08:34'),
(67, 11, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:08:34'),
(179, 0, 1, 0, 'Mhdbashar Das', 0, 'project_activity_created_milestone', 'milestone', '2019-07-30 18:00:57'),
(184, 9, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-01 15:46:46'),
(197, 10, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-20 23:03:01'),
(198, 9, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-08-20 23:03:01'),
(199, 9, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-20 23:03:02'),
(200, 9, 1, 0, 'Mhdbashar Das', 1, 'project_activity_updated', '', '2019-08-20 23:03:29'),
(201, 11, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-26 18:44:27'),
(207, 2, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-29 10:19:39'),
(217, 2, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-08-29 10:35:24'),
(218, 2, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-29 10:35:25'),
(224, 2, 1, 0, 'Mhdbashar Das', 1, 'LService_activity_created', '', '2019-09-16 17:53:07'),
(228, 5, 1, 0, 'Mhdbashar Das', 1, 'CaseMov_activity_created', '', '2019-09-19 19:37:45');

-- --------------------------------------------------------

--
-- بنية الجدول `tblcase_files`
--

CREATE TABLE `tblcase_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `visible_to_customer` tinyint(1) DEFAULT 0,
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `external` varchar(40) DEFAULT NULL,
  `external_link` text DEFAULT NULL,
  `thumbnail_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcase_movement`
--

CREATE TABLE `tblcase_movement` (
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
  `inserted_date` datetime NOT NULL DEFAULT current_timestamp(),
  `deadline` date DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `description` text NOT NULL,
  `case_result` varchar(255) NOT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT 0,
  `progress_from_tasks` int(11) NOT NULL DEFAULT 1,
  `addedfrom` int(11) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcase_movement`
--

INSERT INTO `tblcase_movement` (`id`, `numbering`, `code`, `name`, `clientid`, `representative`, `cat_id`, `subcat_id`, `court_id`, `jud_num`, `country`, `city`, `billing_type`, `case_status`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `inserted_date`, `deadline`, `date_finished`, `description`, `case_result`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `case_id`) VALUES
(3, 1, 'CASE1', 'قضية 1', 3, 2, 3, 4, 2, 7, 105, 'karkouk', 1, 2, 1, 0, '0.00', '2581-02-17', '2019-09-16', '2019-09-16 17:53:06', NULL, NULL, '', 'متداولة', 0, '0.00', 0, 1, 1, 2);

-- --------------------------------------------------------

--
-- بنية الجدول `tblcase_notes`
--

CREATE TABLE `tblcase_notes` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcase_settings`
--

CREATE TABLE `tblcase_settings` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcase_settings`
--

INSERT INTO `tblcase_settings` (`id`, `case_id`, `name`, `value`) VALUES
(1, 2, 'available_features', 'a:18:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;}'),
(2, 2, 'view_tasks', '1'),
(3, 2, 'create_tasks', '1'),
(4, 2, 'edit_tasks', '1'),
(5, 2, 'comment_on_tasks', '1'),
(6, 2, 'view_task_comments', '1'),
(7, 2, 'view_task_attachments', '1'),
(8, 2, 'view_task_checklist_items', '1'),
(9, 2, 'upload_on_tasks', '1'),
(10, 2, 'view_task_total_logged_time', '1'),
(11, 2, 'view_finance_overview', '1'),
(12, 2, 'upload_files', '1'),
(13, 2, 'open_discussions', '1'),
(14, 2, 'view_milestones', '1'),
(15, 2, 'view_gantt', '1'),
(16, 2, 'view_timesheets', '1'),
(17, 2, 'view_activity_log', '1'),
(18, 2, 'view_team_members', '1'),
(19, 2, 'hide_tasks_on_main_tasks_table', '0');

-- --------------------------------------------------------

--
-- بنية الجدول `tblcities`
--

CREATE TABLE `tblcities` (
  `Id` int(11) NOT NULL,
  `Name_en` char(100) NOT NULL,
  `Name_ar` char(100) NOT NULL,
  `Country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcities`
--

INSERT INTO `tblcities` (`Id`, `Name_en`, `Name_ar`, `Country_id`) VALUES
(1, 'macadisho', 'مقديشو', 204),
(2, 'Riyadh', 'الرياض', 194),
(3, 'Dammam', 'الدمام', 194),
(4, 'Khobar', 'الخبر', 194),
(5, 'Dahran', 'الظهران', 194),
(6, 'Jubail', 'الجبيل', 194),
(7, 'Jeddah', 'جدة', 194),
(8, 'mecca', 'مكة', 194),
(9, 'al-madinah', 'المدينة المنورة', 194),
(10, 'al-taef', 'الطائف', 194),
(11, 'hafr-elbaten', 'حفر الباطن', 194),
(12, 'hufuf', 'الهفوف', 194),
(13, 'yanbu', 'ينبع', 194),
(14, 'tabuk', 'تبوك', 194),
(15, 'qassim', 'القصيم', 194),
(16, 'hael', 'حائل', 194),
(17, 'abha', 'ابها', 194),
(18, 'al-baha', 'الباحة', 194),
(19, 'jezan', 'جازان', 194),
(20, 'najran', 'نجران', 194),
(21, 'al-jouf', 'الجوف', 194),
(22, 'arar', 'عرعر', 194),
(23, 'dubai', 'دبي', 228),
(24, 'abu-dhabi', 'ابو ظبي', 228),
(25, 'ras-alkheima', 'راس الخيمة', 228),
(26, 'ajman', 'عجمان', 228),
(27, 'al-ain', 'العين', 228),
(28, 'um-al-qewain', 'ام القيوين', 228),
(29, 'manama', 'المنامة', 18),
(30, 'doha', 'الدوحة', 179),
(31, 'muscat', 'مسقط', 166),
(32, 'salala', 'صلالة', 166),
(33, 'tripoly', 'طرابلس', 125),
(34, 'bagdad', 'بغداد', 105),
(35, 'amman', 'عمان', 113),
(36, 'irbid', 'اربد', 113),
(37, 'quds', 'القدس', 169),
(38, 'bairut', 'بيروت', 122),
(39, 'tripoly', 'طرابلس', 122),
(40, 'saida', 'صيدا', 122),
(287, 'cairo', 'القاهرة', 66),
(288, 'elixandaria', 'الاسكندرية', 66),
(289, 'mansoura', 'المنصورة', 66),
(290, 'aswan', 'اسوان', 66),
(291, 'sharm-elshiekh', 'شرم الشيخ', 66),
(292, 'el-fayoum', 'الفيوم', 66),
(293, 'sohag', 'سوهاج', 66),
(294, 'el-menya', 'المنيا', 66),
(295, 'bani-suwayf', 'بني سويف', 66),
(296, 'tanta', 'طنطا', 66),
(297, 'asyout', 'اسيوط', 66),
(298, 'luxor', 'الاقصر', 66),
(299, 'bin-ghazi', 'بن غازي', 125),
(300, 'sart', 'سرت', 125),
(301, 'msrata', 'مصراتة', 125),
(302, 'zwara', 'زوارة', 125),
(303, 'ubari', 'اوباري', 125),
(304, 'khoms', 'الخمس', 125),
(305, 'zintan', 'الزنتان', 125),
(306, 'al-marj', 'المرج', 125),
(307, 'intisar', 'انتصار', 125),
(308, 'zlitan', 'زليتن', 125),
(309, 'sabha', 'سبها', 125),
(310, 'sabrata', 'صبراتة', 125),
(311, 'tobrok', 'طبرق', 125),
(312, 'garian', 'غريان', 125),
(313, 'bnt-jbail', 'بنت جبيل', 122),
(314, 'zahla', 'زحلة', 122),
(315, 'akkar', 'عكار', 122),
(316, 'soor', 'صور', 122),
(317, 'al-rayyan', 'الريان', 179),
(318, 'mesaieed', 'مصايد', 179),
(319, 'dukhan', 'دخان', 179),
(320, 'ras-laffan', 'راس لفان', 179),
(321, 'lusail', 'لوسيل', 179),
(322, 'al-khor', 'الخور', 179),
(323, 'haifa', 'حيفا', 169),
(324, 'ram-allah', 'رام الله', 169),
(325, 'rafah', 'رفح', 169),
(326, 'ghaza', 'غزة', 169),
(327, 'nablos', 'نابلس', 169),
(328, 'adam', 'ادم', 166),
(329, 'nizwa', 'نزوى', 166),
(330, 'sur', 'صور', 166),
(331, 'sohar', 'صحار', 166),
(332, 'al-rustaq', 'الرستاق', 166),
(333, 'damascus', 'دمشق', 217),
(334, 'homs', 'حمص', 217),
(335, 'aleppo', 'حلب', 217),
(336, 'al-hasaka', 'الحسكة', 217),
(337, 'idleb', 'ادلب', 217),
(338, 'al-raqqa', 'الرقة', 217),
(339, 'qamishli', 'القامشلي', 217),
(340, 'latakia', 'اللاذقية', 217),
(341, 'hamah', 'حماه', 217),
(342, 'daraa', 'درعا', 217),
(343, 'der-el-zor', 'دير الزور', 217),
(344, 'tartous', 'طرطوس', 217),
(345, 'safaqs', 'صفاقس', 227),
(346, 'tunisia', 'تونس', 227),
(347, 'Sousse', 'سوسة', 227),
(348, 'kairouan', 'القيروان', 227),
(349, 'istanbul', 'استنبول', 222),
(350, 'izmir', 'ازمير', 222),
(351, 'ankara', 'انقرة', 222),
(352, 'antakya', 'انطاكية', 222),
(353, 'marsin', 'مرسين', 222),
(354, 'ghazi-entab', 'عازي عنتاب', 222),
(355, 'sanaa', 'صنعاء', 248),
(356, 'taiz', 'تعز', 248),
(357, 'adan', 'عدن', 248),
(358, 'ibb', 'اب', 248),
(359, 'newyork', 'نيويورك', 230),
(360, 'washengton', 'واشنطن', 230),
(361, 'london', 'لندن', 229),
(362, 'casa-blanka', 'كازابلانكا', 149),
(363, 'marrakesh', 'مراكش', 149),
(364, 'barlin', 'برلين', 80),
(365, 'shtutgart', 'شتوتغارت', 80),
(366, 'kuwait', 'الكويت', 118),
(367, 'al-jahara', 'الجهراء', 118),
(368, 'al-farwania', 'الفروانية', 118),
(369, 'holi', 'حولي', 118),
(370, 'mubarak-al-kabeer', 'مبارك الكبير', 118),
(371, 'al-ahmadi', 'الاحمدي', 118),
(372, 'karkouk', 'كركوك', 105),
(373, 'irbil', 'اربيل', 105),
(374, 'al-fallouga', 'الفلوجة', 105),
(375, 'al-ramadi', 'الرمادي', 105),
(376, 'stockholm', 'ستوكهولم', 210),
(377, 'khartoum', 'الخرطوم', 211),
(378, 'annaba', 'عنابة', 4),
(379, 'algiers', 'الجزائر', 4),
(380, 'muharraq', 'المحرق', 18),
(381, 'sharqa', 'الشارقة', 228),
(384, 'Kuala-Lumpur', 'كوالالمبور', 133),
(385, 'fujaira', 'الفجيرة', 228),
(386, 'toronto', 'تورونتو', 38),
(387, 'Nouakchott', 'نواكشوط', 139),
(388, 'al-ahsa', 'الاحساء', 194),
(389, 'khor-fakkan', 'خورفكان', 228),
(390, 'zarqa', 'الزرقاء', 113),
(391, 'ar-Rusaifa', 'الرصيفة', 113),
(392, 'al-Quwaisima', 'القويسمة', 113),
(393, 'Wadi-as-Sir', 'وادي السير', 113),
(394, 'Aqaba', 'العقبة', 113),
(395, 'ar-Ramtha', 'الرمثا', 113),
(396, 'Qalyubia', 'القليوبية', 66),
(397, 'giza', 'الجيزة', 66),
(398, 'Beheira', 'البحيرة', 66),
(399, 'Matruh', 'مطروح', 66),
(400, 'Damietta', 'دمياط', 66),
(401, 'Dakahlia', 'الدقهلية', 66),
(402, 'Kafr-El-Sheikh', 'كفر الشيخ', 66),
(403, 'Gharbia', 'الغربية', 66),
(404, 'Monufia', 'المنوفية', 66),
(405, 'Sharqia', 'الشرقية', 66),
(406, 'Port-Said', 'بور سعيد', 66),
(407, 'Suez', 'السويس', 66),
(408, 'Qena', 'قنا', 66),
(409, 'Ismailia', 'الاسماعيلية', 66),
(410, 'red-sea-Hurghada', 'البحر الاحمر/الغردقة', 66),
(411, 'North-Sinai', 'شمال سيناء', 66),
(412, 'South-Sinai', 'جنوب سيناء', 66),
(413, 'rayf-dimashq', 'ريف دمشق', 217),
(414, 'As-Suwayda', 'السويداء', 217),
(415, 'quneitra', 'القنيطرة', 217),
(416, 'rabat', 'الرباط', 149),
(417, 'agadir', 'اغادير', 149),
(418, 'tangier', 'طنجة', 149),
(419, 'oujda', 'وجدة', 149),
(420, 'fes', 'فاس', 149),
(421, 'meknas', 'مكناس', 149),
(422, 'al-hoceima', 'الحسيمة-تازة', 149),
(423, 'kenitra', 'القنيطرة', 149),
(424, 'settat', 'سطات', 149),
(425, 'Safi', 'آسفي', 149),
(426, 'tetouan', 'تطوان', 149),
(427, 'tebessa', 'تبسة', 149),
(428, 'Oran', 'وهران', 4),
(429, 'constantine', 'قسنطينة', 4),
(430, 'tlemcen', 'تلمسان', 4),
(431, 'setif', 'سطيف', 4),
(432, 'bejaia', 'بيجاية', 4),
(433, 'biskra', 'بسكرة', 4),
(434, 'jijel', 'جيجل', 4),
(435, 'ghardaia', 'غرداية', 4),
(436, 'skikda', 'سكيكدة', 4),
(437, 'djelfa', 'الجلفة', 4),
(438, 'batna', 'باتنة', 4),
(439, 'sidi-bel-abbes', 'سيدي بلعباس', 4),
(440, 'chlef', 'الشلف', 4),
(441, 'mostaganem', 'مستغانم', 4),
(442, 'al-Kharj', 'الخرج', 194),
(443, 'sakakah', 'سكاكا', 194),
(444, 'buraydah', 'بريدة', 194),
(445, 'khamis-mushait', 'خميس مشيط', 194),
(446, 'unaizah', 'عنيزة', 194),
(447, 'dawadmi', 'الدوادمي', 194),
(448, 'az-zulfi', 'الزلفي', 194),
(449, 'qatif', 'القطيف', 194),
(450, 'bisha', 'بيشة', 194),
(451, 'al-qunfudhah', 'القنفذة', 194),
(452, 'Majmaah', 'المجمعة', 194),
(453, 'Riffa', 'الرفاع', 18),
(454, 'Sitra', 'سترة', 18),
(455, 'Isa-Town', 'مدينة عيسى', 18),
(456, 'Madinat-zayed', 'مدينة زايد', 18),
(457, 'Zallaq', 'الزلاق', 18);

-- --------------------------------------------------------

--
-- بنية الجدول `tblclients`
--

CREATE TABLE `tblclients` (
  `userid` int(11) NOT NULL,
  `company` varchar(191) DEFAULT NULL,
  `vat` varchar(50) DEFAULT NULL,
  `phonenumber` varchar(30) DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT 0,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `leadid` int(11) DEFAULT NULL,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT 0,
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT 0,
  `longitude` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `default_language` varchar(40) DEFAULT NULL,
  `default_currency` int(11) NOT NULL DEFAULT 0,
  `show_primary_contact` int(11) NOT NULL DEFAULT 0,
  `stripe_id` varchar(40) DEFAULT NULL,
  `registration_confirmed` int(11) NOT NULL DEFAULT 1,
  `addedfrom` int(11) NOT NULL DEFAULT 0,
  `individual` tinyint(4) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblclients`
--

INSERT INTO `tblclients` (`userid`, `company`, `vat`, `phonenumber`, `country`, `city`, `zip`, `state`, `address`, `website`, `datecreated`, `active`, `leadid`, `billing_street`, `billing_city`, `billing_state`, `billing_zip`, `billing_country`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `longitude`, `latitude`, `default_language`, `default_currency`, `show_primary_contact`, `stripe_id`, `registration_confirmed`, `addedfrom`, `individual`, `branch_id`) VALUES
(1, 'Client individual ', NULL, '', 217, 'homs', NULL, NULL, '', NULL, '2019-07-25 13:56:59', 1, NULL, '', '', '', '', 0, '', '', '', '', 0, NULL, NULL, '', 0, 0, NULL, 1, 1, 1, 0),
(2, 'Client company', NULL, '', 194, 'al-baha', NULL, NULL, '', NULL, '2019-07-25 13:58:22', 1, NULL, '', '', '', '', 0, '', '', '', '', 0, NULL, NULL, '', 0, 0, NULL, 1, 1, 0, 0),
(3, 'Al-Muslat Company', NULL, '', 194, 'yanbu', '', '', '', '', '2019-07-27 15:21:46', 1, NULL, '', '', '', '', 0, '', '', '', '', 0, NULL, NULL, '', 0, 0, NULL, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblconsents`
--

CREATE TABLE `tblconsents` (
  `id` int(11) NOT NULL,
  `action` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(40) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `lead_id` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `opt_in_purpose_description` text DEFAULT NULL,
  `purpose_id` int(11) NOT NULL,
  `staff_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblconsent_purposes`
--

CREATE TABLE `tblconsent_purposes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcontacts`
--

CREATE TABLE `tblcontacts` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `is_primary` int(11) NOT NULL DEFAULT 1,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `new_pass_key` varchar(32) DEFAULT NULL,
  `new_pass_key_requested` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `email_verification_key` varchar(32) DEFAULT NULL,
  `email_verification_sent_at` datetime DEFAULT NULL,
  `last_ip` varchar(40) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_password_change` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `profile_image` varchar(191) DEFAULT NULL,
  `direction` varchar(3) DEFAULT NULL,
  `invoice_emails` tinyint(1) NOT NULL DEFAULT 1,
  `estimate_emails` tinyint(1) NOT NULL DEFAULT 1,
  `credit_note_emails` tinyint(1) NOT NULL DEFAULT 1,
  `contract_emails` tinyint(1) NOT NULL DEFAULT 1,
  `task_emails` tinyint(1) NOT NULL DEFAULT 1,
  `project_emails` tinyint(1) NOT NULL DEFAULT 1,
  `ticket_emails` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcontact_permissions`
--

CREATE TABLE `tblcontact_permissions` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcontracts`
--

CREATE TABLE `tblcontracts` (
  `id` int(11) NOT NULL,
  `content` longtext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `client` int(11) NOT NULL,
  `datestart` date DEFAULT NULL,
  `dateend` date DEFAULT NULL,
  `contract_type` int(11) DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  `isexpirynotified` int(11) NOT NULL DEFAULT 0,
  `contract_value` decimal(15,2) DEFAULT NULL,
  `trash` tinyint(1) DEFAULT 0,
  `not_visible_to_client` tinyint(1) NOT NULL DEFAULT 0,
  `hash` varchar(32) DEFAULT NULL,
  `signed` tinyint(1) NOT NULL DEFAULT 0,
  `signature` varchar(40) DEFAULT NULL,
  `acceptance_firstname` varchar(50) DEFAULT NULL,
  `acceptance_lastname` varchar(50) DEFAULT NULL,
  `acceptance_email` varchar(100) DEFAULT NULL,
  `acceptance_date` datetime DEFAULT NULL,
  `acceptance_ip` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcontracts_types`
--

CREATE TABLE `tblcontracts_types` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcontract_comments`
--

CREATE TABLE `tblcontract_comments` (
  `id` int(11) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `contract_id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcontract_renewals`
--

CREATE TABLE `tblcontract_renewals` (
  `id` int(11) NOT NULL,
  `contractid` int(11) NOT NULL,
  `old_start_date` date NOT NULL,
  `new_start_date` date NOT NULL,
  `old_end_date` date DEFAULT NULL,
  `new_end_date` date DEFAULT NULL,
  `old_value` decimal(15,2) DEFAULT NULL,
  `new_value` decimal(15,2) DEFAULT NULL,
  `date_renewed` datetime NOT NULL,
  `renewed_by` varchar(100) NOT NULL,
  `renewed_by_staff_id` int(11) NOT NULL DEFAULT 0,
  `is_on_old_expiry_notified` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcountries`
--

CREATE TABLE `tblcountries` (
  `country_id` int(5) NOT NULL,
  `iso2` char(2) DEFAULT NULL,
  `short_name` varchar(80) NOT NULL DEFAULT '',
  `short_name_ar` varchar(80) NOT NULL,
  `long_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` varchar(6) DEFAULT NULL,
  `un_member` varchar(12) DEFAULT NULL,
  `calling_code` varchar(8) DEFAULT NULL,
  `cctld` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcountries`
--

INSERT INTO `tblcountries` (`country_id`, `iso2`, `short_name`, `short_name_ar`, `long_name`, `iso3`, `numcode`, `un_member`, `calling_code`, `cctld`) VALUES
(1, 'AF', 'Afghanistan', '', 'Islamic Republic of Afghanistan', 'AFG', '004', 'yes', '93', '.af'),
(2, 'AX', 'Aland Islands', '', '&Aring;land Islands', 'ALA', '248', 'no', '358', '.ax'),
(3, 'AL', 'Albania', '', 'Republic of Albania', 'ALB', '008', 'yes', '355', '.al'),
(4, 'DZ', 'Algeria', 'الجزائر', 'People\'s Democratic Republic of Algeria', 'DZA', '012', 'yes', '213', '.dz'),
(5, 'AS', 'American Samoa', '', 'American Samoa', 'ASM', '016', 'no', '1+684', '.as'),
(6, 'AD', 'Andorra', '', 'Principality of Andorra', 'AND', '020', 'yes', '376', '.ad'),
(7, 'AO', 'Angola', '', 'Republic of Angola', 'AGO', '024', 'yes', '244', '.ao'),
(8, 'AI', 'Anguilla', '', 'Anguilla', 'AIA', '660', 'no', '1+264', '.ai'),
(9, 'AQ', 'Antarctica', '', 'Antarctica', 'ATA', '010', 'no', '672', '.aq'),
(10, 'AG', 'Antigua and Barbuda', '', 'Antigua and Barbuda', 'ATG', '028', 'yes', '1+268', '.ag'),
(11, 'AR', 'Argentina', '', 'Argentine Republic', 'ARG', '032', 'yes', '54', '.ar'),
(12, 'AM', 'Armenia', '', 'Republic of Armenia', 'ARM', '051', 'yes', '374', '.am'),
(13, 'AW', 'Aruba', '', 'Aruba', 'ABW', '533', 'no', '297', '.aw'),
(14, 'AU', 'Australia', '', 'Commonwealth of Australia', 'AUS', '036', 'yes', '61', '.au'),
(15, 'AT', 'Austria', '', 'Republic of Austria', 'AUT', '040', 'yes', '43', '.at'),
(16, 'AZ', 'Azerbaijan', '', 'Republic of Azerbaijan', 'AZE', '031', 'yes', '994', '.az'),
(17, 'BS', 'Bahamas', '', 'Commonwealth of The Bahamas', 'BHS', '044', 'yes', '1+242', '.bs'),
(18, 'BH', 'Bahrain', 'البحرين', 'Kingdom of Bahrain', 'BHR', '048', 'yes', '973', '.bh'),
(19, 'BD', 'Bangladesh', '', 'People\'s Republic of Bangladesh', 'BGD', '050', 'yes', '880', '.bd'),
(20, 'BB', 'Barbados', '', 'Barbados', 'BRB', '052', 'yes', '1+246', '.bb'),
(21, 'BY', 'Belarus', '', 'Republic of Belarus', 'BLR', '112', 'yes', '375', '.by'),
(22, 'BE', 'Belgium', '', 'Kingdom of Belgium', 'BEL', '056', 'yes', '32', '.be'),
(23, 'BZ', 'Belize', '', 'Belize', 'BLZ', '084', 'yes', '501', '.bz'),
(24, 'BJ', 'Benin', '', 'Republic of Benin', 'BEN', '204', 'yes', '229', '.bj'),
(25, 'BM', 'Bermuda', '', 'Bermuda Islands', 'BMU', '060', 'no', '1+441', '.bm'),
(26, 'BT', 'Bhutan', '', 'Kingdom of Bhutan', 'BTN', '064', 'yes', '975', '.bt'),
(27, 'BO', 'Bolivia', '', 'Plurinational State of Bolivia', 'BOL', '068', 'yes', '591', '.bo'),
(28, 'BQ', 'Bonaire, Sint Eustatius and Saba', '', 'Bonaire, Sint Eustatius and Saba', 'BES', '535', 'no', '599', '.bq'),
(29, 'BA', 'Bosnia and Herzegovina', '', 'Bosnia and Herzegovina', 'BIH', '070', 'yes', '387', '.ba'),
(30, 'BW', 'Botswana', '', 'Republic of Botswana', 'BWA', '072', 'yes', '267', '.bw'),
(31, 'BV', 'Bouvet Island', '', 'Bouvet Island', 'BVT', '074', 'no', 'NONE', '.bv'),
(32, 'BR', 'Brazil', '', 'Federative Republic of Brazil', 'BRA', '076', 'yes', '55', '.br'),
(33, 'IO', 'British Indian Ocean Territory', '', 'British Indian Ocean Territory', 'IOT', '086', 'no', '246', '.io'),
(34, 'BN', 'Brunei', '', 'Brunei Darussalam', 'BRN', '096', 'yes', '673', '.bn'),
(35, 'BG', 'Bulgaria', '', 'Republic of Bulgaria', 'BGR', '100', 'yes', '359', '.bg'),
(36, 'BF', 'Burkina Faso', '', 'Burkina Faso', 'BFA', '854', 'yes', '226', '.bf'),
(37, 'BI', 'Burundi', '', 'Republic of Burundi', 'BDI', '108', 'yes', '257', '.bi'),
(38, 'KH', 'Cambodia', '', 'Kingdom of Cambodia', 'KHM', '116', 'yes', '855', '.kh'),
(39, 'CM', 'Cameroon', '', 'Republic of Cameroon', 'CMR', '120', 'yes', '237', '.cm'),
(40, 'CA', 'Canada', '', 'Canada', 'CAN', '124', 'yes', '1', '.ca'),
(41, 'CV', 'Cape Verde', '', 'Republic of Cape Verde', 'CPV', '132', 'yes', '238', '.cv'),
(42, 'KY', 'Cayman Islands', '', 'The Cayman Islands', 'CYM', '136', 'no', '1+345', '.ky'),
(43, 'CF', 'Central African Republic', '', 'Central African Republic', 'CAF', '140', 'yes', '236', '.cf'),
(44, 'TD', 'Chad', '', 'Republic of Chad', 'TCD', '148', 'yes', '235', '.td'),
(45, 'CL', 'Chile', '', 'Republic of Chile', 'CHL', '152', 'yes', '56', '.cl'),
(46, 'CN', 'China', '', 'People\'s Republic of China', 'CHN', '156', 'yes', '86', '.cn'),
(47, 'CX', 'Christmas Island', '', 'Christmas Island', 'CXR', '162', 'no', '61', '.cx'),
(48, 'CC', 'Cocos (Keeling) Islands', '', 'Cocos (Keeling) Islands', 'CCK', '166', 'no', '61', '.cc'),
(49, 'CO', 'Colombia', '', 'Republic of Colombia', 'COL', '170', 'yes', '57', '.co'),
(50, 'KM', 'Comoros', '', 'Union of the Comoros', 'COM', '174', 'yes', '269', '.km'),
(51, 'CG', 'Congo', '', 'Republic of the Congo', 'COG', '178', 'yes', '242', '.cg'),
(52, 'CK', 'Cook Islands', '', 'Cook Islands', 'COK', '184', 'some', '682', '.ck'),
(53, 'CR', 'Costa Rica', '', 'Republic of Costa Rica', 'CRI', '188', 'yes', '506', '.cr'),
(54, 'CI', 'Cote d\'ivoire (Ivory Coast)', '', 'Republic of C&ocirc;te D\'Ivoire (Ivory Coast)', 'CIV', '384', 'yes', '225', '.ci'),
(55, 'HR', 'Croatia', '', 'Republic of Croatia', 'HRV', '191', 'yes', '385', '.hr'),
(56, 'CU', 'Cuba', '', 'Republic of Cuba', 'CUB', '192', 'yes', '53', '.cu'),
(57, 'CW', 'Curacao', '', 'Cura&ccedil;ao', 'CUW', '531', 'no', '599', '.cw'),
(58, 'CY', 'Cyprus', '', 'Republic of Cyprus', 'CYP', '196', 'yes', '357', '.cy'),
(59, 'CZ', 'Czech Republic', '', 'Czech Republic', 'CZE', '203', 'yes', '420', '.cz'),
(60, 'CD', 'Democratic Republic of the Congo', '', 'Democratic Republic of the Congo', 'COD', '180', 'yes', '243', '.cd'),
(61, 'DK', 'Denmark', '', 'Kingdom of Denmark', 'DNK', '208', 'yes', '45', '.dk'),
(62, 'DJ', 'Djibouti', '', 'Republic of Djibouti', 'DJI', '262', 'yes', '253', '.dj'),
(63, 'DM', 'Dominica', '', 'Commonwealth of Dominica', 'DMA', '212', 'yes', '1+767', '.dm'),
(64, 'DO', 'Dominican Republic', '', 'Dominican Republic', 'DOM', '214', 'yes', '1+809, 8', '.do'),
(65, 'EC', 'Ecuador', '', 'Republic of Ecuador', 'ECU', '218', 'yes', '593', '.ec'),
(66, 'EG', 'Egypt', 'مصر', 'Arab Republic of Egypt', 'EGY', '818', 'yes', '20', '.eg'),
(67, 'SV', 'El Salvador', '', 'Republic of El Salvador', 'SLV', '222', 'yes', '503', '.sv'),
(68, 'GQ', 'Equatorial Guinea', '', 'Republic of Equatorial Guinea', 'GNQ', '226', 'yes', '240', '.gq'),
(69, 'ER', 'Eritrea', '', 'State of Eritrea', 'ERI', '232', 'yes', '291', '.er'),
(70, 'EE', 'Estonia', '', 'Republic of Estonia', 'EST', '233', 'yes', '372', '.ee'),
(71, 'ET', 'Ethiopia', '', 'Federal Democratic Republic of Ethiopia', 'ETH', '231', 'yes', '251', '.et'),
(72, 'FK', 'Falkland Islands (Malvinas)', '', 'The Falkland Islands (Malvinas)', 'FLK', '238', 'no', '500', '.fk'),
(73, 'FO', 'Faroe Islands', '', 'The Faroe Islands', 'FRO', '234', 'no', '298', '.fo'),
(74, 'FJ', 'Fiji', '', 'Republic of Fiji', 'FJI', '242', 'yes', '679', '.fj'),
(75, 'FI', 'Finland', '', 'Republic of Finland', 'FIN', '246', 'yes', '358', '.fi'),
(76, 'FR', 'France', '', 'French Republic', 'FRA', '250', 'yes', '33', '.fr'),
(77, 'GF', 'French Guiana', '', 'French Guiana', 'GUF', '254', 'no', '594', '.gf'),
(78, 'PF', 'French Polynesia', '', 'French Polynesia', 'PYF', '258', 'no', '689', '.pf'),
(79, 'TF', 'French Southern Territories', '', 'French Southern Territories', 'ATF', '260', 'no', NULL, '.tf'),
(80, 'GA', 'Gabon', '', 'Gabonese Republic', 'GAB', '266', 'yes', '241', '.ga'),
(81, 'GM', 'Gambia', '', 'Republic of The Gambia', 'GMB', '270', 'yes', '220', '.gm'),
(82, 'GE', 'Georgia', '', 'Georgia', 'GEO', '268', 'yes', '995', '.ge'),
(83, 'DE', 'Germany', '', 'Federal Republic of Germany', 'DEU', '276', 'yes', '49', '.de'),
(84, 'GH', 'Ghana', '', 'Republic of Ghana', 'GHA', '288', 'yes', '233', '.gh'),
(85, 'GI', 'Gibraltar', '', 'Gibraltar', 'GIB', '292', 'no', '350', '.gi'),
(86, 'GR', 'Greece', '', 'Hellenic Republic', 'GRC', '300', 'yes', '30', '.gr'),
(87, 'GL', 'Greenland', '', 'Greenland', 'GRL', '304', 'no', '299', '.gl'),
(88, 'GD', 'Grenada', '', 'Grenada', 'GRD', '308', 'yes', '1+473', '.gd'),
(89, 'GP', 'Guadaloupe', '', 'Guadeloupe', 'GLP', '312', 'no', '590', '.gp'),
(90, 'GU', 'Guam', '', 'Guam', 'GUM', '316', 'no', '1+671', '.gu'),
(91, 'GT', 'Guatemala', '', 'Republic of Guatemala', 'GTM', '320', 'yes', '502', '.gt'),
(92, 'GG', 'Guernsey', '', 'Guernsey', 'GGY', '831', 'no', '44', '.gg'),
(93, 'GN', 'Guinea', '', 'Republic of Guinea', 'GIN', '324', 'yes', '224', '.gn'),
(94, 'GW', 'Guinea-Bissau', '', 'Republic of Guinea-Bissau', 'GNB', '624', 'yes', '245', '.gw'),
(95, 'GY', 'Guyana', '', 'Co-operative Republic of Guyana', 'GUY', '328', 'yes', '592', '.gy'),
(96, 'HT', 'Haiti', '', 'Republic of Haiti', 'HTI', '332', 'yes', '509', '.ht'),
(97, 'HM', 'Heard Island and McDonald Islands', '', 'Heard Island and McDonald Islands', 'HMD', '334', 'no', 'NONE', '.hm'),
(98, 'HN', 'Honduras', '', 'Republic of Honduras', 'HND', '340', 'yes', '504', '.hn'),
(99, 'HK', 'Hong Kong', '', 'Hong Kong', 'HKG', '344', 'no', '852', '.hk'),
(100, 'HU', 'Hungary', '', 'Hungary', 'HUN', '348', 'yes', '36', '.hu'),
(101, 'IS', 'Iceland', '', 'Republic of Iceland', 'ISL', '352', 'yes', '354', '.is'),
(102, 'IN', 'India', '', 'Republic of India', 'IND', '356', 'yes', '91', '.in'),
(103, 'ID', 'Indonesia', '', 'Republic of Indonesia', 'IDN', '360', 'yes', '62', '.id'),
(104, 'IR', 'Iran', '', 'Islamic Republic of Iran', 'IRN', '364', 'yes', '98', '.ir'),
(105, 'IQ', 'Iraq', 'العراق', 'Republic of Iraq', 'IRQ', '368', 'yes', '964', '.iq'),
(106, 'IE', 'Ireland', '', 'Ireland', 'IRL', '372', 'yes', '353', '.ie'),
(107, 'IM', 'Isle of Man', '', 'Isle of Man', 'IMN', '833', 'no', '44', '.im'),
(108, 'IL', 'Israel', '', 'State of Israel', 'ISR', '376', 'yes', '972', '.il'),
(109, 'IT', 'Italy', '', 'Italian Republic', 'ITA', '380', 'yes', '39', '.jm'),
(110, 'JM', 'Jamaica', '', 'Jamaica', 'JAM', '388', 'yes', '1+876', '.jm'),
(111, 'JP', 'Japan', '', 'Japan', 'JPN', '392', 'yes', '81', '.jp'),
(112, 'JE', 'Jersey', '', 'The Bailiwick of Jersey', 'JEY', '832', 'no', '44', '.je'),
(113, 'JO', 'Jordan', 'الأردن', 'Hashemite Kingdom of Jordan', 'JOR', '400', 'yes', '962', '.jo'),
(114, 'KZ', 'Kazakhstan', '', 'Republic of Kazakhstan', 'KAZ', '398', 'yes', '7', '.kz'),
(115, 'KE', 'Kenya', '', 'Republic of Kenya', 'KEN', '404', 'yes', '254', '.ke'),
(116, 'KI', 'Kiribati', '', 'Republic of Kiribati', 'KIR', '296', 'yes', '686', '.ki'),
(117, 'XK', 'Kosovo', '', 'Republic of Kosovo', '---', '---', 'some', '381', ''),
(118, 'KW', 'Kuwait', 'الكويت', 'State of Kuwait', 'KWT', '414', 'yes', '965', '.kw'),
(119, 'KG', 'Kyrgyzstan', '', 'Kyrgyz Republic', 'KGZ', '417', 'yes', '996', '.kg'),
(120, 'LA', 'Laos', '', 'Lao People\'s Democratic Republic', 'LAO', '418', 'yes', '856', '.la'),
(121, 'LV', 'Latvia', '', 'Republic of Latvia', 'LVA', '428', 'yes', '371', '.lv'),
(122, 'LB', 'Lebanon', 'لبنان', 'Republic of Lebanon', 'LBN', '422', 'yes', '961', '.lb'),
(123, 'LS', 'Lesotho', '', 'Kingdom of Lesotho', 'LSO', '426', 'yes', '266', '.ls'),
(124, 'LR', 'Liberia', '', 'Republic of Liberia', 'LBR', '430', 'yes', '231', '.lr'),
(125, 'LY', 'Libya', 'ليبيا', 'Libya', 'LBY', '434', 'yes', '218', '.ly'),
(126, 'LI', 'Liechtenstein', '', 'Principality of Liechtenstein', 'LIE', '438', 'yes', '423', '.li'),
(127, 'LT', 'Lithuania', '', 'Republic of Lithuania', 'LTU', '440', 'yes', '370', '.lt'),
(128, 'LU', 'Luxembourg', '', 'Grand Duchy of Luxembourg', 'LUX', '442', 'yes', '352', '.lu'),
(129, 'MO', 'Macao', '', 'The Macao Special Administrative Region', 'MAC', '446', 'no', '853', '.mo'),
(130, 'MK', 'Macedonia', '', 'The Former Yugoslav Republic of Macedonia', 'MKD', '807', 'yes', '389', '.mk'),
(131, 'MG', 'Madagascar', '', 'Republic of Madagascar', 'MDG', '450', 'yes', '261', '.mg'),
(132, 'MW', 'Malawi', '', 'Republic of Malawi', 'MWI', '454', 'yes', '265', '.mw'),
(133, 'MY', 'Malaysia', '', 'Malaysia', 'MYS', '458', 'yes', '60', '.my'),
(134, 'MV', 'Maldives', '', 'Republic of Maldives', 'MDV', '462', 'yes', '960', '.mv'),
(135, 'ML', 'Mali', '', 'Republic of Mali', 'MLI', '466', 'yes', '223', '.ml'),
(136, 'MT', 'Malta', '', 'Republic of Malta', 'MLT', '470', 'yes', '356', '.mt'),
(137, 'MH', 'Marshall Islands', '', 'Republic of the Marshall Islands', 'MHL', '584', 'yes', '692', '.mh'),
(138, 'MQ', 'Martinique', '', 'Martinique', 'MTQ', '474', 'no', '596', '.mq'),
(139, 'MR', 'Mauritania', 'موريتانيا', 'Islamic Republic of Mauritania', 'MRT', '478', 'yes', '222', '.mr'),
(140, 'MU', 'Mauritius', '', 'Republic of Mauritius', 'MUS', '480', 'yes', '230', '.mu'),
(141, 'YT', 'Mayotte', '', 'Mayotte', 'MYT', '175', 'no', '262', '.yt'),
(142, 'MX', 'Mexico', '', 'United Mexican States', 'MEX', '484', 'yes', '52', '.mx'),
(143, 'FM', 'Micronesia', '', 'Federated States of Micronesia', 'FSM', '583', 'yes', '691', '.fm'),
(144, 'MD', 'Moldava', '', 'Republic of Moldova', 'MDA', '498', 'yes', '373', '.md'),
(145, 'MC', 'Monaco', '', 'Principality of Monaco', 'MCO', '492', 'yes', '377', '.mc'),
(146, 'MN', 'Mongolia', '', 'Mongolia', 'MNG', '496', 'yes', '976', '.mn'),
(147, 'ME', 'Montenegro', '', 'Montenegro', 'MNE', '499', 'yes', '382', '.me'),
(148, 'MS', 'Montserrat', '', 'Montserrat', 'MSR', '500', 'no', '1+664', '.ms'),
(149, 'MA', 'Morocco', 'المغرب', 'Kingdom of Morocco', 'MAR', '504', 'yes', '212', '.ma'),
(150, 'MZ', 'Mozambique', '', 'Republic of Mozambique', 'MOZ', '508', 'yes', '258', '.mz'),
(151, 'MM', 'Myanmar (Burma)', '', 'Republic of the Union of Myanmar', 'MMR', '104', 'yes', '95', '.mm'),
(152, 'NA', 'Namibia', '', 'Republic of Namibia', 'NAM', '516', 'yes', '264', '.na'),
(153, 'NR', 'Nauru', '', 'Republic of Nauru', 'NRU', '520', 'yes', '674', '.nr'),
(154, 'NP', 'Nepal', '', 'Federal Democratic Republic of Nepal', 'NPL', '524', 'yes', '977', '.np'),
(155, 'NL', 'Netherlands', '', 'Kingdom of the Netherlands', 'NLD', '528', 'yes', '31', '.nl'),
(156, 'NC', 'New Caledonia', '', 'New Caledonia', 'NCL', '540', 'no', '687', '.nc'),
(157, 'NZ', 'New Zealand', '', 'New Zealand', 'NZL', '554', 'yes', '64', '.nz'),
(158, 'NI', 'Nicaragua', '', 'Republic of Nicaragua', 'NIC', '558', 'yes', '505', '.ni'),
(159, 'NE', 'Niger', '', 'Republic of Niger', 'NER', '562', 'yes', '227', '.ne'),
(160, 'NG', 'Nigeria', '', 'Federal Republic of Nigeria', 'NGA', '566', 'yes', '234', '.ng'),
(161, 'NU', 'Niue', '', 'Niue', 'NIU', '570', 'some', '683', '.nu'),
(162, 'NF', 'Norfolk Island', '', 'Norfolk Island', 'NFK', '574', 'no', '672', '.nf'),
(163, 'KP', 'North Korea', '', 'Democratic People\'s Republic of Korea', 'PRK', '408', 'yes', '850', '.kp'),
(164, 'MP', 'Northern Mariana Islands', '', 'Northern Mariana Islands', 'MNP', '580', 'no', '1+670', '.mp'),
(165, 'NO', 'Norway', '', 'Kingdom of Norway', 'NOR', '578', 'yes', '47', '.no'),
(166, 'OM', 'Oman', 'سلطنة عمان', 'Sultanate of Oman', 'OMN', '512', 'yes', '968', '.om'),
(167, 'PK', 'Pakistan', '', 'Islamic Republic of Pakistan', 'PAK', '586', 'yes', '92', '.pk'),
(168, 'PW', 'Palau', '', 'Republic of Palau', 'PLW', '585', 'yes', '680', '.pw'),
(169, 'PS', 'Palestine', 'فلسطين', 'State of Palestine (or Occupied Palestinian Territory)', 'PSE', '275', 'some', '970', '.ps'),
(170, 'PA', 'Panama', '', 'Republic of Panama', 'PAN', '591', 'yes', '507', '.pa'),
(171, 'PG', 'Papua New Guinea', '', 'Independent State of Papua New Guinea', 'PNG', '598', 'yes', '675', '.pg'),
(172, 'PY', 'Paraguay', '', 'Republic of Paraguay', 'PRY', '600', 'yes', '595', '.py'),
(173, 'PE', 'Peru', '', 'Republic of Peru', 'PER', '604', 'yes', '51', '.pe'),
(174, 'PH', 'Phillipines', '', 'Republic of the Philippines', 'PHL', '608', 'yes', '63', '.ph'),
(175, 'PN', 'Pitcairn', '', 'Pitcairn', 'PCN', '612', 'no', 'NONE', '.pn'),
(176, 'PL', 'Poland', '', 'Republic of Poland', 'POL', '616', 'yes', '48', '.pl'),
(177, 'PT', 'Portugal', '', 'Portuguese Republic', 'PRT', '620', 'yes', '351', '.pt'),
(178, 'PR', 'Puerto Rico', '', 'Commonwealth of Puerto Rico', 'PRI', '630', 'no', '1+939', '.pr'),
(179, 'QA', 'Qatar', 'قطر', 'State of Qatar', 'QAT', '634', 'yes', '974', '.qa'),
(180, 'RE', 'Reunion', '', 'R&eacute;union', 'REU', '638', 'no', '262', '.re'),
(181, 'RO', 'Romania', '', 'Romania', 'ROU', '642', 'yes', '40', '.ro'),
(182, 'RU', 'Russia', '', 'Russian Federation', 'RUS', '643', 'yes', '7', '.ru'),
(183, 'RW', 'Rwanda', '', 'Republic of Rwanda', 'RWA', '646', 'yes', '250', '.rw'),
(184, 'BL', 'Saint Barthelemy', '', 'Saint Barth&eacute;lemy', 'BLM', '652', 'no', '590', '.bl'),
(185, 'SH', 'Saint Helena', '', 'Saint Helena, Ascension and Tristan da Cunha', 'SHN', '654', 'no', '290', '.sh'),
(186, 'KN', 'Saint Kitts and Nevis', '', 'Federation of Saint Christopher and Nevis', 'KNA', '659', 'yes', '1+869', '.kn'),
(187, 'LC', 'Saint Lucia', '', 'Saint Lucia', 'LCA', '662', 'yes', '1+758', '.lc'),
(188, 'MF', 'Saint Martin', '', 'Saint Martin', 'MAF', '663', 'no', '590', '.mf'),
(189, 'PM', 'Saint Pierre and Miquelon', '', 'Saint Pierre and Miquelon', 'SPM', '666', 'no', '508', '.pm'),
(190, 'VC', 'Saint Vincent and the Grenadines', '', 'Saint Vincent and the Grenadines', 'VCT', '670', 'yes', '1+784', '.vc'),
(191, 'WS', 'Samoa', '', 'Independent State of Samoa', 'WSM', '882', 'yes', '685', '.ws'),
(192, 'SM', 'San Marino', '', 'Republic of San Marino', 'SMR', '674', 'yes', '378', '.sm'),
(193, 'ST', 'Sao Tome and Principe', '', 'Democratic Republic of S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'STP', '678', 'yes', '239', '.st'),
(194, 'SA', 'Saudi Arabia', 'السعودية', 'Kingdom of Saudi Arabia', 'SAU', '682', 'yes', '966', '.sa'),
(195, 'SN', 'Senegal', '', 'Republic of Senegal', 'SEN', '686', 'yes', '221', '.sn'),
(196, 'RS', 'Serbia', '', 'Republic of Serbia', 'SRB', '688', 'yes', '381', '.rs'),
(197, 'SC', 'Seychelles', '', 'Republic of Seychelles', 'SYC', '690', 'yes', '248', '.sc'),
(198, 'SL', 'Sierra Leone', '', 'Republic of Sierra Leone', 'SLE', '694', 'yes', '232', '.sl'),
(199, 'SG', 'Singapore', '', 'Republic of Singapore', 'SGP', '702', 'yes', '65', '.sg'),
(200, 'SX', 'Sint Maarten', '', 'Sint Maarten', 'SXM', '534', 'no', '1+721', '.sx'),
(201, 'SK', 'Slovakia', '', 'Slovak Republic', 'SVK', '703', 'yes', '421', '.sk'),
(202, 'SI', 'Slovenia', '', 'Republic of Slovenia', 'SVN', '705', 'yes', '386', '.si'),
(203, 'SB', 'Solomon Islands', '', 'Solomon Islands', 'SLB', '090', 'yes', '677', '.sb'),
(204, 'SO', 'Somalia', 'الصومال', 'Somali Republic', 'SOM', '706', 'yes', '252', '.so'),
(205, 'ZA', 'South Africa', '', 'Republic of South Africa', 'ZAF', '710', 'yes', '27', '.za'),
(206, 'GS', 'South Georgia and the South Sandwich Islands', '', 'South Georgia and the South Sandwich Islands', 'SGS', '239', 'no', '500', '.gs'),
(207, 'KR', 'South Korea', '', 'Republic of Korea', 'KOR', '410', 'yes', '82', '.kr'),
(208, 'SS', 'South Sudan', '', 'Republic of South Sudan', 'SSD', '728', 'yes', '211', '.ss'),
(209, 'ES', 'Spain', '', 'Kingdom of Spain', 'ESP', '724', 'yes', '34', '.es'),
(210, 'LK', 'Sri Lanka', '', 'Democratic Socialist Republic of Sri Lanka', 'LKA', '144', 'yes', '94', '.lk'),
(211, 'SD', 'Sudan', 'السودان', 'Republic of the Sudan', 'SDN', '729', 'yes', '249', '.sd'),
(212, 'SR', 'Suriname', '', 'Republic of Suriname', 'SUR', '740', 'yes', '597', '.sr'),
(213, 'SJ', 'Svalbard and Jan Mayen', '', 'Svalbard and Jan Mayen', 'SJM', '744', 'no', '47', '.sj'),
(214, 'SZ', 'Swaziland', '', 'Kingdom of Swaziland', 'SWZ', '748', 'yes', '268', '.sz'),
(215, 'SE', 'Sweden', '', 'Kingdom of Sweden', 'SWE', '752', 'yes', '46', '.se'),
(216, 'CH', 'Switzerland', '', 'Swiss Confederation', 'CHE', '756', 'yes', '41', '.ch'),
(217, 'SY', 'Syria', 'سوريا', 'Syrian Arab Republic', 'SYR', '760', 'yes', '963', '.sy'),
(218, 'TW', 'Taiwan', '', 'Republic of China (Taiwan)', 'TWN', '158', 'former', '886', '.tw'),
(219, 'TJ', 'Tajikistan', '', 'Republic of Tajikistan', 'TJK', '762', 'yes', '992', '.tj'),
(220, 'TZ', 'Tanzania', '', 'United Republic of Tanzania', 'TZA', '834', 'yes', '255', '.tz'),
(221, 'TH', 'Thailand', '', 'Kingdom of Thailand', 'THA', '764', 'yes', '66', '.th'),
(222, 'TL', 'Timor-Leste (East Timor)', '', 'Democratic Republic of Timor-Leste', 'TLS', '626', 'yes', '670', '.tl'),
(223, 'TG', 'Togo', '', 'Togolese Republic', 'TGO', '768', 'yes', '228', '.tg'),
(224, 'TK', 'Tokelau', '', 'Tokelau', 'TKL', '772', 'no', '690', '.tk'),
(225, 'TO', 'Tonga', '', 'Kingdom of Tonga', 'TON', '776', 'yes', '676', '.to'),
(226, 'TT', 'Trinidad and Tobago', '', 'Republic of Trinidad and Tobago', 'TTO', '780', 'yes', '1+868', '.tt'),
(227, 'TN', 'Tunisia', 'تونس', 'Republic of Tunisia', 'TUN', '788', 'yes', '216', '.tn'),
(228, 'TR', 'Turkey', '', 'Republic of Turkey', 'TUR', '792', 'yes', '90', '.tr'),
(229, 'TM', 'Turkmenistan', '', 'Turkmenistan', 'TKM', '795', 'yes', '993', '.tm'),
(230, 'TC', 'Turks and Caicos Islands', '', 'Turks and Caicos Islands', 'TCA', '796', 'no', '1+649', '.tc'),
(231, 'TV', 'Tuvalu', '', 'Tuvalu', 'TUV', '798', 'yes', '688', '.tv'),
(232, 'UG', 'Uganda', '', 'Republic of Uganda', 'UGA', '800', 'yes', '256', '.ug'),
(233, 'UA', 'Ukraine', '', 'Ukraine', 'UKR', '804', 'yes', '380', '.ua'),
(234, 'AE', 'United Arab Emirates', '', 'United Arab Emirates', 'ARE', '784', 'yes', '971', '.ae'),
(235, 'GB', 'United Kingdom', '', 'United Kingdom of Great Britain and Nothern Ireland', 'GBR', '826', 'yes', '44', '.uk'),
(236, 'US', 'United States', '', 'United States of America', 'USA', '840', 'yes', '1', '.us'),
(237, 'UM', 'United States Minor Outlying Islands', '', 'United States Minor Outlying Islands', 'UMI', '581', 'no', 'NONE', 'NONE'),
(238, 'UY', 'Uruguay', '', 'Eastern Republic of Uruguay', 'URY', '858', 'yes', '598', '.uy'),
(239, 'UZ', 'Uzbekistan', '', 'Republic of Uzbekistan', 'UZB', '860', 'yes', '998', '.uz'),
(240, 'VU', 'Vanuatu', '', 'Republic of Vanuatu', 'VUT', '548', 'yes', '678', '.vu'),
(241, 'VA', 'Vatican City', '', 'State of the Vatican City', 'VAT', '336', 'no', '39', '.va'),
(242, 'VE', 'Venezuela', '', 'Bolivarian Republic of Venezuela', 'VEN', '862', 'yes', '58', '.ve'),
(243, 'VN', 'Vietnam', '', 'Socialist Republic of Vietnam', 'VNM', '704', 'yes', '84', '.vn'),
(244, 'VG', 'Virgin Islands, British', '', 'British Virgin Islands', 'VGB', '092', 'no', '1+284', '.vg'),
(245, 'VI', 'Virgin Islands, US', '', 'Virgin Islands of the United States', 'VIR', '850', 'no', '1+340', '.vi'),
(246, 'WF', 'Wallis and Futuna', '', 'Wallis and Futuna', 'WLF', '876', 'no', '681', '.wf'),
(247, 'EH', 'Western Sahara', '', 'Western Sahara', 'ESH', '732', 'no', '212', '.eh'),
(248, 'YE', 'Yemen', '', 'Republic of Yemen', 'YEM', '887', 'yes', '967', '.ye'),
(249, 'ZM', 'Zambia', '', 'Republic of Zambia', 'ZMB', '894', 'yes', '260', '.zm'),
(250, 'ZW', 'Zimbabwe', '', 'Republic of Zimbabwe', 'ZWE', '716', 'yes', '263', '.zw');

-- --------------------------------------------------------

--
-- بنية الجدول `tblcreditnotes`
--

CREATE TABLE `tblcreditnotes` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT 1,
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `adminnote` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `clientnote` text DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `discount_percent` decimal(15,2) DEFAULT 0.00,
  `discount_total` decimal(15,2) DEFAULT 0.00,
  `discount_type` varchar(30) NOT NULL,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT NULL,
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT NULL,
  `include_shipping` tinyint(1) NOT NULL,
  `show_shipping_on_credit_note` tinyint(1) NOT NULL DEFAULT 1,
  `show_quantity_as` int(11) NOT NULL DEFAULT 1,
  `reference_no` varchar(100) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcreditnote_refunds`
--

CREATE TABLE `tblcreditnote_refunds` (
  `id` int(11) NOT NULL,
  `credit_note_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `refunded_on` date NOT NULL,
  `payment_mode` varchar(40) NOT NULL,
  `note` text DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcredits`
--

CREATE TABLE `tblcredits` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `date_applied` datetime NOT NULL,
  `amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcurrencies`
--

CREATE TABLE `tblcurrencies` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `decimal_separator` varchar(5) DEFAULT NULL,
  `thousand_separator` varchar(5) DEFAULT NULL,
  `placement` varchar(10) DEFAULT NULL,
  `isdefault` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcurrencies`
--

INSERT INTO `tblcurrencies` (`id`, `symbol`, `name`, `decimal_separator`, `thousand_separator`, `placement`, `isdefault`) VALUES
(1, '$', 'USD', '.', ',', 'before', 1),
(2, 'â‚¬', 'EUR', ',', '.', 'before', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblcustomers_groups`
--

CREATE TABLE `tblcustomers_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblcustomers_groups`
--

INSERT INTO `tblcustomers_groups` (`id`, `name`) VALUES
(1, 'Web Developer');

-- --------------------------------------------------------

--
-- بنية الجدول `tblcustomer_admins`
--

CREATE TABLE `tblcustomer_admins` (
  `staff_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_assigned` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcustomer_groups`
--

CREATE TABLE `tblcustomer_groups` (
  `id` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcustomfields`
--

CREATE TABLE `tblcustomfields` (
  `id` int(11) NOT NULL,
  `fieldto` varchar(15) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(20) NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `display_inline` tinyint(1) NOT NULL DEFAULT 0,
  `field_order` int(11) DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 1,
  `show_on_pdf` int(11) NOT NULL DEFAULT 0,
  `show_on_ticket_form` tinyint(1) NOT NULL DEFAULT 0,
  `only_admin` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_table` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_client_portal` int(11) NOT NULL DEFAULT 0,
  `disalow_client_to_edit` int(11) NOT NULL DEFAULT 0,
  `bs_column` int(11) NOT NULL DEFAULT 12
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcustomfieldsvalues`
--

CREATE TABLE `tblcustomfieldsvalues` (
  `id` int(11) NOT NULL,
  `relid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `fieldto` varchar(15) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `departmentid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `imap_username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_from_header` tinyint(1) NOT NULL DEFAULT 0,
  `host` varchar(150) DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `encryption` varchar(3) DEFAULT NULL,
  `delete_after_import` int(11) NOT NULL DEFAULT 0,
  `calendar_id` mediumtext DEFAULT NULL,
  `hidefromclient` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbldepartments`
--

INSERT INTO `tbldepartments` (`departmentid`, `name`, `imap_username`, `email`, `email_from_header`, `host`, `password`, `encryption`, `delete_after_import`, `calendar_id`, `hidefromclient`, `branch_id`) VALUES
(3, 'Web Developers', 'mhdbashard@gmail.com', '', 0, '', '', '', 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tbldismissed_announcements`
--

CREATE TABLE `tbldismissed_announcements` (
  `dismissedannouncementid` int(11) NOT NULL,
  `announcementid` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblemailtemplates`
--

CREATE TABLE `tblemailtemplates` (
  `emailtemplateid` int(11) NOT NULL,
  `type` mediumtext NOT NULL,
  `slug` varchar(100) NOT NULL,
  `language` varchar(40) DEFAULT NULL,
  `name` mediumtext NOT NULL,
  `subject` mediumtext NOT NULL,
  `message` text NOT NULL,
  `fromname` mediumtext NOT NULL,
  `fromemail` varchar(100) DEFAULT NULL,
  `plaintext` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblemailtemplates`
--

INSERT INTO `tblemailtemplates` (`emailtemplateid`, `type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
(1, 'client', 'new-client-created', 'english', 'New Contact Added/Registered (Welcome Email)', 'Welcome aboard', 'Dear {contact_firstname} {contact_lastname}<br /><br />Thank you for registering on the <strong>{companyname}</strong> CRM System.<br /><br />We just wanted to say welcome.<br /><br />Please contact us if you need any help.<br /><br />Click here to view your profile: <a href=\"{crm_url}\">{crm_url}</a><br /><br />Kind Regards, <br />{email_signature}<br /><br />(This is an automated email, so please don\'t reply to this email address)', '{companyname} | CRM', '', 0, 1, 0),
(2, 'invoice', 'invoice-send-to-client', 'english', 'Send Invoice to Customer', 'Invoice with number {invoice_number} created', '<span style=\"font-size: 12pt;\">Dear {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">We have prepared the following invoice for you: <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Invoice status</strong>: {invoice_status}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(3, 'ticket', 'new-ticket-opened-admin', 'english', 'New Ticket Opened (Opened by Staff, Sent to Customer)', 'New Support Ticket Opened', '<span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">New support ticket has been opened.</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {ticket_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Department:</strong> {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {ticket_priority}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}<br /><br /></a>Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(4, 'ticket', 'ticket-reply', 'english', 'Ticket Reply (Sent to Customer)', 'New Ticket Reply', '<span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">You have a new ticket reply to ticket <a href=\"{ticket_url}\">#{ticket_id}</a></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Ticket Subject:</strong> {ticket_subject}<br /></span><br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(5, 'ticket', 'ticket-autoresponse', 'english', 'New Ticket Opened - Autoresponse', 'New Support Ticket Opened', '<span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">Thank you for contacting our support team. A support ticket has now been opened for your request. You will be notified when a response is made by email.</span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {ticket_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {ticket_priority}</span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(6, 'invoice', 'invoice-payment-recorded', 'english', 'Invoice Payment Recorded (Sent to Customer)', 'Invoice Payment Recorded', '<span style=\"font-size: 12pt;\">Hello {contact_firstname}&nbsp;{contact_lastname}<br /><br /></span>Thank you for the payment. Find the payment details below:<br /><br />-------------------------------------------------<br /><br />Amount:&nbsp;<strong>{payment_total}<br /></strong>Date:&nbsp;<strong>{payment_date}</strong><br />Invoice number:&nbsp;<span style=\"font-size: 12pt;\"><strong># {invoice_number}<br /><br /></strong></span>-------------------------------------------------<br /><br />You can always view the invoice for this payment at the following link:&nbsp;<a href=\"{invoice_link}\"><span style=\"font-size: 12pt;\">{invoice_number}</span></a><br /><br />We are looking forward working with you.<br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(7, 'invoice', 'invoice-overdue-notice', 'english', 'Invoice Overdue Notice', 'Invoice Overdue Notice - {invoice_number}', '<span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">This is an overdue notice for invoice <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\">This invoice was due: {invoice_duedate}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(8, 'invoice', 'invoice-already-send', 'english', 'Invoice Already Sent to Customer', 'Invoice # {invoice_number} ', '<span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">At your request, here is the invoice with number <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(9, 'ticket', 'new-ticket-created-staff', 'english', 'New Ticket Created (Opened by Customer, Sent to Staff Members)', 'New Ticket Created', '<span style=\"font-size: 12pt;\">A new support ticket has been opened.</span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Subject</strong>: {ticket_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority</strong>: {ticket_priority}</span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}<br /></a></span><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(10, 'estimate', 'estimate-send-to-client', 'english', 'Send Estimate to Customer', 'Estimate # {estimate_number} created', '<span style=\"font-size: 12pt;\">Dear {contact_firstname} {contact_lastname}</span><br /> <br /><span style=\"font-size: 12pt;\">Please find the attached estimate <strong># {estimate_number}</strong></span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Estimate status:</strong> {estimate_status}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span><br /> <br /><span style=\"font-size: 12pt;\">We look forward to your communication.</span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}<br /></span>', '{companyname} | CRM', '', 0, 1, 0),
(11, 'ticket', 'ticket-reply-to-admin', 'english', 'Ticket Reply (Sent to Staff)', 'New Support Ticket Reply', '<span style=\"font-size: 12pt;\">A new support ticket reply from {contact_firstname} {contact_lastname}</span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Subject</strong>: {ticket_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority</strong>: {ticket_priority}</span><br /> <br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /> <br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(12, 'estimate', 'estimate-already-send', 'english', 'Estimate Already Sent to Customer', 'Estimate # {estimate_number} ', '<span style=\"font-size: 12pt;\">Dear {contact_firstname} {contact_lastname}</span><br /> <br /><span style=\"font-size: 12pt;\">Thank you for your estimate request.</span><br /> <br /><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span><br /> <br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(13, 'contract', 'contract-expiration', 'english', 'Contract Expiration Reminder (Sent to Customer Contacts)', 'Contract Expiration Reminder', '<span style=\"font-size: 12pt;\">Dear {client_company}</span><br /><br /><span style=\"font-size: 12pt;\">This is a reminder that the following contract will expire soon:</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {contract_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Description:</strong> {contract_description}</span><br /><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {contract_datestart}</span><br /><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {contract_dateend}</span><br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(14, 'tasks', 'task-assigned', 'english', 'New Task Assigned (Sent to Staff)', 'New Task Assigned to You - {task_name}', '<span style=\"font-size: 12pt;\">Dear {staff_firstname}</span><br /><br /><span style=\"font-size: 12pt;\">You have been assigned to a new task:</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}<br /></span><strong>Start Date:</strong> {task_startdate}<br /><span style=\"font-size: 12pt;\"><strong>Due date:</strong> {task_duedate}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {task_priority}<br /><br /></span><span style=\"font-size: 12pt;\"><span>You can view the task on the following link</span>: <a href=\"{task_link}\">{task_name}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(15, 'tasks', 'task-added-as-follower', 'english', 'Staff Member Added as Follower on Task (Sent to Staff)', 'You are added as follower on task - {task_name}', '<span style=\"font-size: 12pt;\">Hi {staff_firstname}<br /></span><br /><span style=\"font-size: 12pt;\">You have been added as follower on the following task:</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}</span><br /><span style=\"font-size: 12pt;\"><strong>Start date:</strong> {task_startdate}</span><br /><br /><span>You can view the task on the following link</span><span>: </span><a href=\"{task_link}\">{task_name}</a><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(16, 'tasks', 'task-commented', 'english', 'New Comment on Task (Sent to Staff)', 'New Comment on Task - {task_name}', 'Dear {staff_firstname}<br /><br />A comment has been made on the following task:<br /><br /><strong>Name:</strong> {task_name}<br /><strong>Comment:</strong> {task_comment}<br /><br />You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(17, 'tasks', 'task-added-attachment', 'english', 'New Attachment(s) on Task (Sent to Staff)', 'New Attachment on Task - {task_name}', 'Hi {staff_firstname}<br /><br /><strong>{task_user_take_action}</strong> added an attachment on the following task:<br /><br /><strong>Name:</strong> {task_name}<br /><br />You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(18, 'estimate', 'estimate-declined-to-staff', 'english', 'Estimate Declined (Sent to Staff)', 'Customer Declined Estimate', '<span style=\"font-size: 12pt;\">Hi</span><br /> <br /><span style=\"font-size: 12pt;\">Customer ({client_company}) declined estimate with number <strong># {estimate_number}</strong></span><br /> <br /><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span><br /> <br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(19, 'estimate', 'estimate-accepted-to-staff', 'english', 'Estimate Accepted (Sent to Staff)', 'Customer Accepted Estimate', '<span style=\"font-size: 12pt;\">Hi</span><br /> <br /><span style=\"font-size: 12pt;\">Customer ({client_company}) accepted estimate with number <strong># {estimate_number}</strong></span><br /> <br /><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span><br /> <br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(20, 'proposals', 'proposal-client-accepted', 'english', 'Customer Action - Accepted (Sent to Staff)', 'Customer Accepted Proposal', '<div>Hi<br /> <br />Client <strong>{proposal_proposal_to}</strong> accepted the following proposal:<br /> <br /><strong>Number:</strong> {proposal_number}<br /><strong>Subject</strong>: {proposal_subject}<br /><strong>Total</strong>: {proposal_total}<br /> <br />View the proposal on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /> <br />Kind Regards,<br />{email_signature}</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>', '{companyname} | CRM', '', 0, 1, 0),
(21, 'proposals', 'proposal-send-to-customer', 'english', 'Send Proposal to Customer', 'Proposal With Number {proposal_number} Created', 'Dear {proposal_proposal_to}<br /><br />Please find our attached proposal.<br /><br />This proposal is valid until: {proposal_open_till}<br />You can view the proposal on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /><br />Please don\'t hesitate to comment online if you have any questions.<br /><br />We look forward to your communication.<br /><br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(22, 'proposals', 'proposal-client-declined', 'english', 'Customer Action - Declined (Sent to Staff)', 'Client Declined Proposal', 'Hi<br /> <br />Customer <strong>{proposal_proposal_to}</strong> declined the proposal <strong>{proposal_subject}</strong><br /> <br />View the proposal on the following link <a href=\"{proposal_link}\">{proposal_number}</a>&nbsp;or from the admin area.<br /> <br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(23, 'proposals', 'proposal-client-thank-you', 'english', 'Thank You Email (Sent to Customer After Accept)', 'Thank for you accepting proposal', 'Dear {proposal_proposal_to}<br /> <br />Thank for for accepting the proposal.<br /> <br />We look forward to doing business with you.<br /> <br />We will contact you as soon as possible<br /> <br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(24, 'proposals', 'proposal-comment-to-client', 'english', 'New Comment Â (Sent to Customer/Lead)', 'New Proposal Comment', 'Dear {proposal_proposal_to}<br /> <br />A new comment has been made on the following proposal: <strong>{proposal_number}</strong><br /> <br />You can view and reply to the comment on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /> <br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(25, 'proposals', 'proposal-comment-to-admin', 'english', 'New Comment (Sent to Staff) ', 'New Proposal Comment', 'Hi<br /> <br />A new comment has been made to the proposal <strong>{proposal_subject}</strong><br /> <br />You can view and reply to the comment on the following link: <a href=\"{proposal_link}\">{proposal_number}</a>&nbsp;or from the admin area.<br /> <br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(26, 'estimate', 'estimate-thank-you-to-customer', 'english', 'Thank You Email (Sent to Customer After Accept)', 'Thank for you accepting estimate', '<span style=\"font-size: 12pt;\">Dear {contact_firstname} {contact_lastname}</span><br /> <br /><span style=\"font-size: 12pt;\">Thank for for accepting the estimate.</span><br /> <br /><span style=\"font-size: 12pt;\">We look forward to doing business with you.</span><br /> <br /><span style=\"font-size: 12pt;\">We will contact you as soon as possible.</span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(27, 'tasks', 'task-deadline-notification', 'english', 'Task Deadline Reminder - Sent to Assigned Members', 'Task Deadline Reminder', 'Hi {staff_firstname}&nbsp;{staff_lastname}<br /><br />This is an automated email from {companyname}.<br /><br />The task <strong>{task_name}</strong> deadline is on <strong>{task_duedate}</strong>. <br />This task is still not finished.<br /><br />You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(28, 'contract', 'send-contract', 'english', 'Send Contract to Customer', 'Contract - {contract_subject}', '<p><span style=\"font-size: 12pt;\">Hi&nbsp;{contact_firstname}&nbsp;{contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">Please find the {contract_subject} attached.<br /><br /></span><span style=\"font-size: 12pt;\">Looking forward to hear from you.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname} | CRM', '', 0, 1, 0),
(29, 'invoice', 'invoice-payment-recorded-to-staff', 'english', 'Invoice Payment Recorded (Sent to Staff)', 'New Invoice Payment', '<span style=\"font-size: 12pt;\">Hi</span><br /><br /><span style=\"font-size: 12pt;\">Customer recorded payment for invoice <strong># {invoice_number}</strong></span><br /> <br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(30, 'ticket', 'auto-close-ticket', 'english', 'Auto Close Ticket', 'Ticket Auto Closed', '<p><span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">Ticket {ticket_subject} has been auto close due to inactivity.</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Ticket #</strong>: <a href=\"{ticket_url}\">{ticket_id}</a></span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {ticket_priority}</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname} | CRM', '', 0, 1, 0),
(31, 'project', 'new-project-discussion-created-to-staff', 'english', 'New Project Discussion (Sent to Project Members)', 'New Project Discussion Created - {project_name}', '<p>Hi {staff_firstname}<br /><br />New project discussion created from <strong>{discussion_creator}</strong><br /><br /><strong>Subject:</strong> {discussion_subject}<br /><strong>Description:</strong> {discussion_description}<br /><br />You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(32, 'project', 'new-project-discussion-created-to-customer', 'english', 'New Project Discussion (Sent to Customer Contacts)', 'New Project Discussion Created - {project_name}', '<p>Hello {contact_firstname} {contact_lastname}<br /><br />New project discussion created from <strong>{discussion_creator}</strong><br /><br /><strong>Subject:</strong> {discussion_subject}<br /><strong>Description:</strong> {discussion_description}<br /><br />You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(33, 'project', 'new-project-file-uploaded-to-customer', 'english', 'New Project File(s) Uploaded (Sent to Customer Contacts)', 'New Project File(s) Uploaded - {project_name}', '<p>Hello {contact_firstname} {contact_lastname}<br /><br />New project file is uploaded on <strong>{project_name}</strong> from <strong>{file_creator}</strong><br /><br />You can view the project on the following link: <a href=\"{project_link}\">{project_name}</a><br /><br />To view the file in our CRM you can click on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(34, 'project', 'new-project-file-uploaded-to-staff', 'english', 'New Project File(s) Uploaded (Sent to Project Members)', 'New Project File(s) Uploaded - {project_name}', '<p>Hello&nbsp;{staff_firstname}</p>\r\n<p>New project&nbsp;file is uploaded on&nbsp;<strong>{project_name}</strong> from&nbsp;<strong>{file_creator}</strong></p>\r\n<p>You can view the project on the following link: <a href=\"{project_link}\">{project_name}<br /></a><br />To view&nbsp;the file you can click on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a></p>\r\n<p>Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(35, 'project', 'new-project-discussion-comment-to-customer', 'english', 'New Discussion Comment  (Sent to Customer Contacts)', 'New Discussion Comment', '<p><span style=\"font-size: 12pt;\">Hello {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">New discussion comment has been made on <strong>{discussion_subject}</strong> from <strong>{comment_creator}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Discussion subject:</strong> {discussion_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Comment</strong>: {discussion_comment}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname} | CRM', '', 0, 1, 0),
(36, 'project', 'new-project-discussion-comment-to-staff', 'english', 'New Discussion Comment (Sent to Project Members)', 'New Discussion Comment', '<p>Hi {staff_firstname}<br /><br />New discussion comment has been made on <strong>{discussion_subject}</strong> from <strong>{comment_creator}</strong><br /><br /><strong>Discussion subject:</strong> {discussion_subject}<br /><strong>Comment:</strong> {discussion_comment}<br /><br />You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(37, 'project', 'staff-added-as-project-member', 'english', 'Staff Added as Project Member', 'New project assigned to you', '<p>Hi {staff_firstname}<br /><br />New project has been assigned to you.<br /><br />You can view the project on the following link <a href=\"{project_link}\">{project_name}</a><br /><br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(38, 'estimate', 'estimate-expiry-reminder', 'english', 'Estimate Expiration Reminder', 'Estimate Expiration Reminder', '<p><span style=\"font-size: 12pt;\">Hello {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\">The estimate with <strong># {estimate_number}</strong> will expire on <strong>{estimate_expirydate}</strong></span><br /><br /><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname} | CRM', '', 0, 1, 0),
(39, 'proposals', 'proposal-expiry-reminder', 'english', 'Proposal Expiration Reminder', 'Proposal Expiration Reminder', '<p>Hello {proposal_proposal_to}<br /><br />The proposal {proposal_number}&nbsp;will expire on <strong>{proposal_open_till}</strong><br /><br />You can view the proposal on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(40, 'staff', 'new-staff-created', 'english', 'New Staff Created (Welcome Email)', 'You are added as staff member', 'Hi {staff_firstname}<br /><br />You are added as member on our CRM.<br /><br />Please use the following logic credentials:<br /><br /><strong>Email:</strong> {staff_email}<br /><strong>Password:</strong> {password}<br /><br />Click <a href=\"{admin_url}\">here </a>to login in the dashboard.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(41, 'client', 'contact-forgot-password', 'english', 'Forgot Password', 'Create New Password', '<h2>Create a new password</h2>\r\nForgot your password?<br /> To create a new password, just follow this link:<br /> <br /><a href=\"{reset_password_url}\">Reset Password</a><br /> <br /> You received this email, because it was requested by a {companyname}&nbsp;user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same. <br /><br /> {email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(42, 'client', 'contact-password-reseted', 'english', 'Password Reset - Confirmation', 'Your password has been changed', '<strong><span style=\"font-size: 14pt;\">You have changed your password.</span><br /></strong><br /> Please, keep it in your records so you don\'t forget it.<br /> <br /> Your email address for login is: {contact_email}<br /><br />If this wasnt you, please contact us.<br /><br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(43, 'client', 'contact-set-password', 'english', 'Set New Password', 'Set new password on {companyname} ', '<h2><span style=\"font-size: 14pt;\">Setup your new password on {companyname}</span></h2>\r\nPlease use the following link to set up your new password:<br /><br /><a href=\"{set_password_url}\">Set new password</a><br /><br />Keep it in your records so you don\'t forget it.<br /><br />Please set your new password in <strong>48 hours</strong>. After that, you won\'t be able to set your password because this link will expire.<br /><br />You can login at: <a href=\"{crm_url}\">{crm_url}</a><br />Your email address for login: {contact_email}<br /><br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(44, 'staff', 'staff-forgot-password', 'english', 'Forgot Password', 'Create New Password', '<h2><span style=\"font-size: 14pt;\">Create a new password</span></h2>\r\nForgot your password?<br /> To create a new password, just follow this link:<br /> <br /><a href=\"{reset_password_url}\">Reset Password</a><br /> <br /> You received this email, because it was requested by a <strong>{companyname}</strong>&nbsp;user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same. <br /><br /> {email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(45, 'staff', 'staff-password-reseted', 'english', 'Password Reset - Confirmation', 'Your password has been changed', '<span style=\"font-size: 14pt;\"><strong>You have changed your password.<br /></strong></span><br /> Please, keep it in your records so you don\'t forget it.<br /> <br /> Your email address for login is: {staff_email}<br /><br /> If this wasnt you, please contact us.<br /><br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(46, 'project', 'assigned-to-project', 'english', 'New Project Created (Sent to Customer Contacts)', 'New Project Created', '<p>Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}</p>\r\n<p>New project is assigned to your company.<br /><br /><strong>Project Name:</strong>&nbsp;{project_name}<br /><strong>Project Start Date:</strong>&nbsp;{project_start_date}</p>\r\n<p>You can view the project on the following link:&nbsp;<a href=\"{project_link}\">{project_name}</a></p>\r\n<p>We are looking forward hearing from you.<br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(47, 'tasks', 'task-added-attachment-to-contacts', 'english', 'New Attachment(s) on Task (Sent to Customer Contacts)', 'New Attachment on Task - {task_name}', '<span>Hi {contact_firstname} {contact_lastname}</span><br /><br /><strong>{task_user_take_action}</strong><span> added an attachment on the following task:</span><br /><br /><strong>Name:</strong><span> {task_name}</span><br /><br /><span>You can view the task on the following link: </span><a href=\"{task_link}\">{task_name}</a><br /><br /><span>Kind Regards,</span><br /><span>{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(48, 'tasks', 'task-commented-to-contacts', 'english', 'New Comment on Task (Sent to Customer Contacts)', 'New Comment on Task - {task_name}', '<span>Dear {contact_firstname} {contact_lastname}</span><br /><br /><span>A comment has been made on the following task:</span><br /><br /><strong>Name:</strong><span> {task_name}</span><br /><strong>Comment:</strong><span> {task_comment}</span><br /><br /><span>You can view the task on the following link: </span><a href=\"{task_link}\">{task_name}</a><br /><br /><span>Kind Regards,</span><br /><span>{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(49, 'leads', 'new-lead-assigned', 'english', 'New Lead Assigned to Staff Member', 'New lead assigned to you', '<p>Hello {lead_assigned}<br /><br />New lead is assigned to you.<br /><br /><strong>Lead Name:</strong>&nbsp;{lead_name}<br /><strong>Lead Email:</strong>&nbsp;{lead_email}<br /><br />You can view the lead on the following link: <a href=\"{lead_link}\">{lead_name}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(50, 'client', 'client-statement', 'english', 'Statement - Account Summary', 'Account Statement from {statement_from} to {statement_to}', 'Dear {contact_firstname} {contact_lastname}, <br /><br />Its been a great experience working with you.<br /><br />Attached with this email is a list of all transactions for the period between {statement_from} to {statement_to}<br /><br />For your information your account balance due is total:&nbsp;{statement_balance_due}<br /><br />Please contact us if you need more information.<br /> <br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(51, 'ticket', 'ticket-assigned-to-admin', 'english', 'New Ticket Assigned (Sent to Staff)', 'New support ticket has been assigned to you', '<p><span style=\"font-size: 12pt;\">Hi</span></p>\r\n<p><span style=\"font-size: 12pt;\">A new support ticket&nbsp;has been assigned to you.</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Subject</strong>: {ticket_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority</strong>: {ticket_priority}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname} | CRM', '', 0, 1, 0),
(52, 'client', 'new-client-registered-to-admin', 'english', 'New Customer Registration (Sent to admins)', 'New Customer Registration', 'Hello.<br /><br />New customer registration on your customer portal:<br /><br /><strong>Firstname:</strong>&nbsp;{contact_firstname}<br /><strong>Lastname:</strong>&nbsp;{contact_lastname}<br /><strong>Company:</strong>&nbsp;{client_company}<br /><strong>Email:</strong>&nbsp;{contact_email}<br /><br />Best Regards', '{companyname} | CRM', '', 0, 1, 0),
(53, 'leads', 'new-web-to-lead-form-submitted', 'english', 'Web to lead form submitted - Sent to lead', '{lead_name} - We Received Your Request', 'Hello {lead_name}.<br /><br /><strong>Your request has been received.</strong><br /><br />This email is to let you know that we received your request and we will get back to you as soon as possible with more information.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 0, 0),
(54, 'staff', 'two-factor-authentication', 'english', 'Two Factor Authentication', 'Confirm Your Login', '<p>Hi {staff_firstname}</p>\r\n<p style=\"text-align: left;\">You received this email because you have enabled two factor authentication in your account.<br />Use the following code to confirm your login:</p>\r\n<p style=\"text-align: left;\"><span style=\"font-size: 18pt;\"><strong>{two_factor_auth_code}<br /><br /></strong><span style=\"font-size: 12pt;\">{email_signature}</span><strong><br /><br /><br /><br /></strong></span></p>', '{companyname} | CRM', '', 0, 1, 0),
(55, 'project', 'project-finished-to-customer', 'english', 'Project Marked as Finished (Sent to Customer Contacts)', 'Project Marked as Finished', '<p>Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}</p>\r\n<p>You are receiving this email because project&nbsp;<strong>{project_name}</strong> has been marked as finished. This project is assigned under your company and we just wanted to keep you up to date.<br /><br />You can view the project on the following link:&nbsp;<a href=\"{project_link}\">{project_name}</a></p>\r\n<p>If you have any questions don\'t hesitate to contact us.<br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(56, 'credit_note', 'credit-note-send-to-client', 'english', 'Send Credit Note To Email', 'Credit Note With Number #{credit_note_number} Created', 'Dear&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />We have attached the credit note with number <strong>#{credit_note_number} </strong>for your reference.<br /><br /><strong>Date:</strong>&nbsp;{credit_note_date}<br /><strong>Total Amount:</strong>&nbsp;{credit_note_total}<br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /> <br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(57, 'tasks', 'task-status-change-to-staff', 'english', 'Task Status Changed (Sent to Staff)', 'Task Status Changed', '<span style=\"font-size: 12pt;\">Hi {staff_firstname}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>{task_user_take_action}</strong> marked task as <strong>{task_status}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}</span><br /><span style=\"font-size: 12pt;\"><strong>Due date:</strong> {task_duedate}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(58, 'tasks', 'task-status-change-to-contacts', 'english', 'Task Status Changed (Sent to Customer Contacts)', 'Task Status Changed', '<span style=\"font-size: 12pt;\">Hi {contact_firstname} {contact_lastname}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>{task_user_take_action}</strong> marked task as <strong>{task_status}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}</span><br /><span style=\"font-size: 12pt;\"><strong>Due date:</strong> {task_duedate}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(59, 'staff', 'reminder-email-staff', 'english', 'Staff Reminder Email', 'You Have a New Reminder!', '<p>Hello&nbsp;{staff_firstname}<br /><br /><strong>You have a new reminder&nbsp;linked to&nbsp;{staff_reminder_relation_name}!<br /><br />Reminder description:</strong><br />{staff_reminder_description}<br /><br />Click <a href=\"{staff_reminder_relation_link}\">here</a> to view&nbsp;<a href=\"{staff_reminder_relation_link}\">{staff_reminder_relation_name}</a><br /><br />Best Regards<br /><br /></p>', '{companyname} | CRM', '', 0, 1, 0),
(60, 'contract', 'contract-comment-to-client', 'english', 'New Comment Â (Sent to Customer Contacts)', 'New Contract Comment', 'Dear {contact_firstname} {contact_lastname}<br /> <br />A new comment has been made on the following contract: <strong>{contract_subject}</strong><br /> <br />You can view and reply to the comment on the following link: <a href=\"{contract_link}\">{contract_subject}</a><br /> <br />Kind Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(61, 'contract', 'contract-comment-to-admin', 'english', 'New Comment (Sent to Staff) ', 'New Contract Comment', 'Hi {staff_firstname}<br /><br />A new comment has been made to the contract&nbsp;<strong>{contract_subject}</strong><br /><br />You can view and reply to the comment on the following link: <a href=\"{contract_link}\">{contract_subject}</a>&nbsp;or from the admin area.<br /><br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(62, 'subscriptions', 'send-subscription', 'english', 'Send Subscription to Customer', 'Subscription Created', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />We have prepared the subscription&nbsp;<strong>{subscription_name}</strong> for your company.<br /><br />Click <a href=\"{subscription_link}\">here</a> to review the subscription and subscribe.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(63, 'subscriptions', 'subscription-payment-failed', 'english', 'Subscription Payment Failed', 'Your most recent invoice payment failed', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br br=\"\" />Unfortunately, your most recent invoice payment for&nbsp;<strong>{subscription_name}</strong> was declined.<br /><br /> This could be due to a change in your card number, your card expiring,<br /> cancellation of your credit card, or the card issuer not recognizing the<br /> payment and therefore taking action to prevent it.<br /><br /> Please update your payment information as soon as possible by logging in here:<br /><a href=\"{crm_url}\">{crm_url}</a><br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(64, 'subscriptions', 'subscription-canceled', 'english', 'Subscription Canceled (Sent to customer primary contact)', 'Your subscription has been canceled', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />Your subscription&nbsp;<strong>{subscription_name} </strong>has been canceled, if you have any questions don\'t hesitate to contact us.<br /><br />It was a pleasure doing business with you.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(65, 'subscriptions', 'subscription-payment-succeeded', 'english', 'Subscription Payment Succeeded (Sent to customer primary contact)', 'Subscription  Payment Receipt - {subscription_name}', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />This email is to let you know that we received your payment for subscription&nbsp;<strong>{subscription_name}&nbsp;</strong>of&nbsp;<strong><span>{payment_total}<br /><br /></span></strong>The invoice associated with it is now with status&nbsp;<strong>{invoice_status}<br /></strong><br />Thank you for your confidence.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(66, 'contract', 'contract-expiration-to-staff', 'english', 'Contract Expiration Reminder (Sent to Staff)', 'Contract Expiration Reminder', 'Hi {staff_firstname}<br /><br /><span style=\"font-size: 12pt;\">This is a reminder that the following contract will expire soon:</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {contract_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Description:</strong> {contract_description}</span><br /><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {contract_datestart}</span><br /><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {contract_dateend}</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname} | CRM', '', 0, 1, 0),
(67, 'gdpr', 'gdpr-removal-request', 'english', 'Removal Request From Contact (Sent to administrators)', 'Data Removal Request Received', 'Hello&nbsp;{staff_firstname}&nbsp;{staff_lastname}<br /><br />Data removal has been requested by&nbsp;{contact_firstname} {contact_lastname}<br /><br />You can review this request and take proper actions directly from the admin area.', '{companyname} | CRM', '', 0, 1, 0),
(68, 'gdpr', 'gdpr-removal-request-lead', 'english', 'Removal Request From Lead (Sent to administrators)', 'Data Removal Request Received', 'Hello&nbsp;{staff_firstname}&nbsp;{staff_lastname}<br /><br />Data removal has been requested by {lead_name}<br /><br />You can review this request and take proper actions directly from the admin area.<br /><br />To view the lead inside the admin area click here:&nbsp;<a href=\"{lead_link}\">{lead_link}</a>', '{companyname} | CRM', '', 0, 1, 0),
(69, 'client', 'client-registration-confirmed', 'english', 'Customer Registration Confirmed', 'Your registration is confirmed', '<p>Dear {contact_firstname} {contact_lastname}<br /><br />We just wanted to let you know that your registration at&nbsp;{companyname} is successfully confirmed and your account is now active.<br /><br />You can login at&nbsp;<a href=\"{crm_url}\">{crm_url}</a> with the email and password you provided during registration.<br /><br />Please contact us if you need any help.<br /><br />Kind Regards, <br />{email_signature}</p>\r\n<p><br />(This is an automated email, so please don\'t reply to this email address)</p>', '{companyname} | CRM', '', 0, 1, 0),
(70, 'contract', 'contract-signed-to-staff', 'english', 'Contract Signed (Sent to Staff)', 'Customer Signed a Contract', 'Hi {staff_firstname}<br /><br />A contract with subject&nbsp;<strong>{contract_subject} </strong>has been successfully signed by the customer.<br /><br />You can view the contract at the following link: <a href=\"{contract_link}\">{contract_subject}</a>&nbsp;or from the admin area.<br /><br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(71, 'subscriptions', 'customer-subscribed-to-staff', 'english', 'Customer Subscribed to a Subscription (Sent to administrators and subscription creator)', 'Customer Subscribed to a Subscription', 'The customer <strong>{client_company}</strong> subscribed to a subscription with name&nbsp;<strong>{subscription_name}</strong><br /><br /><strong>ID</strong>:&nbsp;{subscription_id}<br /><strong>Subscription name</strong>:&nbsp;{subscription_name}<br /><strong>Subscription description</strong>:&nbsp;{subscription_description}<br /><br />You can view the subscription by clicking <a href=\"{subscription_link}\">here</a><br />\r\n<div style=\"text-align: center;\"><span style=\"font-size: 10pt;\">&nbsp;</span></div>\r\nBest Regards,<br />{email_signature}<br /><br /><span style=\"font-size: 10pt;\"><span style=\"color: #999999;\">You are receiving this email because you are either administrator or you are creator of the subscription.</span></span>', '{companyname} | CRM', '', 0, 1, 0),
(72, 'client', 'contact-verification-email', 'english', 'Email Verification (Sent to Contact After Registration)', 'Verify Email Address', '<p>Hello&nbsp;{contact_firstname}<br /><br />Please click the button below to verify your email address.<br /><br /><a href=\"{email_verification_url}\">Verify Email Address</a><br /><br />If you did not create an account, no further action is required</p>\r\n<p><br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(73, 'client', 'new-customer-profile-file-uploaded-to-staff', 'english', 'New Customer Profile File(s) Uploaded (Sent to Staff)', 'Customer Uploaded New File(s) in Profile', 'Hi!<br /><br />New file(s) is uploaded into the customer ({client_company}) profile by&nbsp;{contact_firstname}<br /><br />You can check the uploaded files into the admin area by clicking <a href=\"{customer_profile_files_admin_link}\">here</a> or at the following link:&nbsp;{customer_profile_files_admin_link}<br /><br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(74, 'staff', 'event-notification-to-staff', 'english', 'Event Notification (Calendar)', 'Upcoming Event - {event_title}', 'Hi {staff_firstname}! <br /><br />This is a reminder for event <a href=\\\"{event_link}\\\">{event_title}</a> scheduled at {event_start_date}. <br /><br />Regards.', '', '', 0, 1, 0),
(75, 'client', 'new-client-created', 'arabic', 'New Contact Added/Registered (Welcome Email) [arabic]', 'Welcome aboard', '', '{companyname} | CRM', NULL, 0, 1, 0),
(76, 'invoice', 'invoice-send-to-client', 'arabic', 'Send Invoice to Customer [arabic]', 'Invoice with number {invoice_number} created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(77, 'ticket', 'new-ticket-opened-admin', 'arabic', 'New Ticket Opened (Opened by Staff, Sent to Customer) [arabic]', 'New Support Ticket Opened', '', '{companyname} | CRM', NULL, 0, 1, 0),
(78, 'ticket', 'ticket-reply', 'arabic', 'Ticket Reply (Sent to Customer) [arabic]', 'New Ticket Reply', '', '{companyname} | CRM', NULL, 0, 1, 0),
(79, 'ticket', 'ticket-autoresponse', 'arabic', 'New Ticket Opened - Autoresponse [arabic]', 'New Support Ticket Opened', '', '{companyname} | CRM', NULL, 0, 1, 0),
(80, 'invoice', 'invoice-payment-recorded', 'arabic', 'Invoice Payment Recorded (Sent to Customer) [arabic]', 'Invoice Payment Recorded', '', '{companyname} | CRM', NULL, 0, 1, 0),
(81, 'invoice', 'invoice-overdue-notice', 'arabic', 'Invoice Overdue Notice [arabic]', 'Invoice Overdue Notice - {invoice_number}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(82, 'invoice', 'invoice-already-send', 'arabic', 'Invoice Already Sent to Customer [arabic]', 'Invoice # {invoice_number} ', '', '{companyname} | CRM', NULL, 0, 1, 0),
(83, 'ticket', 'new-ticket-created-staff', 'arabic', 'New Ticket Created (Opened by Customer, Sent to Staff Members) [arabic]', 'New Ticket Created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(84, 'estimate', 'estimate-send-to-client', 'arabic', 'Send Estimate to Customer [arabic]', 'Estimate # {estimate_number} created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(85, 'ticket', 'ticket-reply-to-admin', 'arabic', 'Ticket Reply (Sent to Staff) [arabic]', 'New Support Ticket Reply', '', '{companyname} | CRM', NULL, 0, 1, 0);
INSERT INTO `tblemailtemplates` (`emailtemplateid`, `type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
(86, 'estimate', 'estimate-already-send', 'arabic', 'Estimate Already Sent to Customer [arabic]', 'Estimate # {estimate_number} ', '', '{companyname} | CRM', NULL, 0, 1, 0),
(87, 'contract', 'contract-expiration', 'arabic', 'Contract Expiration Reminder (Sent to Customer Contacts) [arabic]', 'Contract Expiration Reminder', '', '{companyname} | CRM', NULL, 0, 1, 0),
(88, 'tasks', 'task-assigned', 'arabic', 'New Task Assigned (Sent to Staff) [arabic]', 'New Task Assigned to You - {task_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(89, 'tasks', 'task-added-as-follower', 'arabic', 'Staff Member Added as Follower on Task (Sent to Staff) [arabic]', 'You are added as follower on task - {task_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(90, 'tasks', 'task-commented', 'arabic', 'New Comment on Task (Sent to Staff) [arabic]', 'New Comment on Task - {task_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(91, 'tasks', 'task-added-attachment', 'arabic', 'New Attachment(s) on Task (Sent to Staff) [arabic]', 'New Attachment on Task - {task_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(92, 'estimate', 'estimate-declined-to-staff', 'arabic', 'Estimate Declined (Sent to Staff) [arabic]', 'Customer Declined Estimate', '', '{companyname} | CRM', NULL, 0, 1, 0),
(93, 'estimate', 'estimate-accepted-to-staff', 'arabic', 'Estimate Accepted (Sent to Staff) [arabic]', 'Customer Accepted Estimate', '', '{companyname} | CRM', NULL, 0, 1, 0),
(94, 'proposals', 'proposal-client-accepted', 'arabic', 'Customer Action - Accepted (Sent to Staff) [arabic]', 'Customer Accepted Proposal', '', '{companyname} | CRM', NULL, 0, 1, 0),
(95, 'proposals', 'proposal-send-to-customer', 'arabic', 'Send Proposal to Customer [arabic]', 'Proposal With Number {proposal_number} Created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(96, 'proposals', 'proposal-client-declined', 'arabic', 'Customer Action - Declined (Sent to Staff) [arabic]', 'Client Declined Proposal', '', '{companyname} | CRM', NULL, 0, 1, 0),
(97, 'proposals', 'proposal-client-thank-you', 'arabic', 'Thank You Email (Sent to Customer After Accept) [arabic]', 'Thank for you accepting proposal', '', '{companyname} | CRM', NULL, 0, 1, 0),
(98, 'proposals', 'proposal-comment-to-client', 'arabic', 'New Comment Â (Sent to Customer/Lead) [arabic]', 'New Proposal Comment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(99, 'proposals', 'proposal-comment-to-admin', 'arabic', 'New Comment (Sent to Staff)  [arabic]', 'New Proposal Comment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(100, 'estimate', 'estimate-thank-you-to-customer', 'arabic', 'Thank You Email (Sent to Customer After Accept) [arabic]', 'Thank for you accepting estimate', '', '{companyname} | CRM', NULL, 0, 1, 0),
(101, 'tasks', 'task-deadline-notification', 'arabic', 'Task Deadline Reminder - Sent to Assigned Members [arabic]', 'Task Deadline Reminder', '', '{companyname} | CRM', NULL, 0, 1, 0),
(102, 'contract', 'send-contract', 'arabic', 'Send Contract to Customer [arabic]', 'Contract - {contract_subject}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(103, 'invoice', 'invoice-payment-recorded-to-staff', 'arabic', 'Invoice Payment Recorded (Sent to Staff) [arabic]', 'New Invoice Payment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(104, 'ticket', 'auto-close-ticket', 'arabic', 'Auto Close Ticket [arabic]', 'Ticket Auto Closed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(105, 'project', 'new-project-discussion-created-to-staff', 'arabic', 'New Project Discussion (Sent to Project Members) [arabic]', 'New Project Discussion Created - {project_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(106, 'project', 'new-project-discussion-created-to-customer', 'arabic', 'New Project Discussion (Sent to Customer Contacts) [arabic]', 'New Project Discussion Created - {project_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(107, 'project', 'new-project-file-uploaded-to-customer', 'arabic', 'New Project File(s) Uploaded (Sent to Customer Contacts) [arabic]', 'New Project File(s) Uploaded - {project_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(108, 'project', 'new-project-file-uploaded-to-staff', 'arabic', 'New Project File(s) Uploaded (Sent to Project Members) [arabic]', 'New Project File(s) Uploaded - {project_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(109, 'project', 'new-project-discussion-comment-to-customer', 'arabic', 'New Discussion Comment  (Sent to Customer Contacts) [arabic]', 'New Discussion Comment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(110, 'project', 'new-project-discussion-comment-to-staff', 'arabic', 'New Discussion Comment (Sent to Project Members) [arabic]', 'New Discussion Comment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(111, 'project', 'staff-added-as-project-member', 'arabic', 'Staff Added as Project Member [arabic]', 'New project assigned to you', '', '{companyname} | CRM', NULL, 0, 1, 0),
(112, 'estimate', 'estimate-expiry-reminder', 'arabic', 'Estimate Expiration Reminder [arabic]', 'Estimate Expiration Reminder', '', '{companyname} | CRM', NULL, 0, 1, 0),
(113, 'proposals', 'proposal-expiry-reminder', 'arabic', 'Proposal Expiration Reminder [arabic]', 'Proposal Expiration Reminder', '', '{companyname} | CRM', NULL, 0, 1, 0),
(114, 'staff', 'new-staff-created', 'arabic', 'New Staff Created (Welcome Email) [arabic]', 'You are added as staff member', '', '{companyname} | CRM', NULL, 0, 1, 0),
(115, 'client', 'contact-forgot-password', 'arabic', 'Forgot Password [arabic]', 'Create New Password', '', '{companyname} | CRM', NULL, 0, 1, 0),
(116, 'client', 'contact-password-reseted', 'arabic', 'Password Reset - Confirmation [arabic]', 'Your password has been changed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(117, 'client', 'contact-set-password', 'arabic', 'Set New Password [arabic]', 'Set new password on {companyname} ', '', '{companyname} | CRM', NULL, 0, 1, 0),
(118, 'staff', 'staff-forgot-password', 'arabic', 'Forgot Password [arabic]', 'Create New Password', '', '{companyname} | CRM', NULL, 0, 1, 0),
(119, 'staff', 'staff-password-reseted', 'arabic', 'Password Reset - Confirmation [arabic]', 'Your password has been changed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(120, 'project', 'assigned-to-project', 'arabic', 'New Project Created (Sent to Customer Contacts) [arabic]', 'New Project Created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(121, 'tasks', 'task-added-attachment-to-contacts', 'arabic', 'New Attachment(s) on Task (Sent to Customer Contacts) [arabic]', 'New Attachment on Task - {task_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(122, 'tasks', 'task-commented-to-contacts', 'arabic', 'New Comment on Task (Sent to Customer Contacts) [arabic]', 'New Comment on Task - {task_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(123, 'leads', 'new-lead-assigned', 'arabic', 'New Lead Assigned to Staff Member [arabic]', 'New lead assigned to you', '', '{companyname} | CRM', NULL, 0, 1, 0),
(124, 'client', 'client-statement', 'arabic', 'Statement - Account Summary [arabic]', 'Account Statement from {statement_from} to {statement_to}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(125, 'ticket', 'ticket-assigned-to-admin', 'arabic', 'New Ticket Assigned (Sent to Staff) [arabic]', 'New support ticket has been assigned to you', '', '{companyname} | CRM', NULL, 0, 1, 0),
(126, 'client', 'new-client-registered-to-admin', 'arabic', 'New Customer Registration (Sent to admins) [arabic]', 'New Customer Registration', '', '{companyname} | CRM', NULL, 0, 1, 0),
(127, 'leads', 'new-web-to-lead-form-submitted', 'arabic', 'Web to lead form submitted - Sent to lead [arabic]', '{lead_name} - We Received Your Request', '', '{companyname} | CRM', NULL, 0, 0, 0),
(128, 'staff', 'two-factor-authentication', 'arabic', 'Two Factor Authentication [arabic]', 'Confirm Your Login', '', '{companyname} | CRM', NULL, 0, 1, 0),
(129, 'project', 'project-finished-to-customer', 'arabic', 'Project Marked as Finished (Sent to Customer Contacts) [arabic]', 'Project Marked as Finished', '', '{companyname} | CRM', NULL, 0, 1, 0),
(130, 'credit_note', 'credit-note-send-to-client', 'arabic', 'Send Credit Note To Email [arabic]', 'Credit Note With Number #{credit_note_number} Created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(131, 'tasks', 'task-status-change-to-staff', 'arabic', 'Task Status Changed (Sent to Staff) [arabic]', 'Task Status Changed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(132, 'tasks', 'task-status-change-to-contacts', 'arabic', 'Task Status Changed (Sent to Customer Contacts) [arabic]', 'Task Status Changed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(133, 'staff', 'reminder-email-staff', 'arabic', 'Staff Reminder Email [arabic]', 'You Have a New Reminder!', '', '{companyname} | CRM', NULL, 0, 1, 0),
(134, 'contract', 'contract-comment-to-client', 'arabic', 'New Comment Â (Sent to Customer Contacts) [arabic]', 'New Contract Comment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(135, 'contract', 'contract-comment-to-admin', 'arabic', 'New Comment (Sent to Staff)  [arabic]', 'New Contract Comment', '', '{companyname} | CRM', NULL, 0, 1, 0),
(136, 'subscriptions', 'send-subscription', 'arabic', 'Send Subscription to Customer [arabic]', 'Subscription Created', '', '{companyname} | CRM', NULL, 0, 1, 0),
(137, 'subscriptions', 'subscription-payment-failed', 'arabic', 'Subscription Payment Failed [arabic]', 'Your most recent invoice payment failed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(138, 'subscriptions', 'subscription-canceled', 'arabic', 'Subscription Canceled (Sent to customer primary contact) [arabic]', 'Your subscription has been canceled', '', '{companyname} | CRM', NULL, 0, 1, 0),
(139, 'subscriptions', 'subscription-payment-succeeded', 'arabic', 'Subscription Payment Succeeded (Sent to customer primary contact) [arabic]', 'Subscription  Payment Receipt - {subscription_name}', '', '{companyname} | CRM', NULL, 0, 1, 0),
(140, 'contract', 'contract-expiration-to-staff', 'arabic', 'Contract Expiration Reminder (Sent to Staff) [arabic]', 'Contract Expiration Reminder', '', '{companyname} | CRM', NULL, 0, 1, 0),
(141, 'gdpr', 'gdpr-removal-request', 'arabic', 'Removal Request From Contact (Sent to administrators) [arabic]', 'Data Removal Request Received', '', '{companyname} | CRM', NULL, 0, 1, 0),
(142, 'gdpr', 'gdpr-removal-request-lead', 'arabic', 'Removal Request From Lead (Sent to administrators) [arabic]', 'Data Removal Request Received', '', '{companyname} | CRM', NULL, 0, 1, 0),
(143, 'client', 'client-registration-confirmed', 'arabic', 'Customer Registration Confirmed [arabic]', 'Your registration is confirmed', '', '{companyname} | CRM', NULL, 0, 1, 0),
(144, 'contract', 'contract-signed-to-staff', 'arabic', 'Contract Signed (Sent to Staff) [arabic]', 'Customer Signed a Contract', '', '{companyname} | CRM', NULL, 0, 1, 0),
(145, 'subscriptions', 'customer-subscribed-to-staff', 'arabic', 'Customer Subscribed to a Subscription (Sent to administrators and subscription creator) [arabic]', 'Customer Subscribed to a Subscription', '', '{companyname} | CRM', NULL, 0, 1, 0),
(146, 'client', 'contact-verification-email', 'arabic', 'Email Verification (Sent to Contact After Registration) [arabic]', 'Verify Email Address', '', '{companyname} | CRM', NULL, 0, 1, 0),
(147, 'client', 'new-customer-profile-file-uploaded-to-staff', 'arabic', 'New Customer Profile File(s) Uploaded (Sent to Staff) [arabic]', 'Customer Uploaded New File(s) in Profile', '', '{companyname} | CRM', NULL, 0, 1, 0),
(148, 'staff', 'event-notification-to-staff', 'arabic', 'Event Notification (Calendar) [arabic]', 'Upcoming Event - {event_title}', '', '', NULL, 0, 1, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblestimates`
--

CREATE TABLE `tblestimates` (
  `id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `datesend` datetime DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT 0,
  `hash` varchar(32) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `expirydate` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `clientnote` text DEFAULT NULL,
  `adminnote` text DEFAULT NULL,
  `discount_percent` decimal(15,2) DEFAULT 0.00,
  `discount_total` decimal(15,2) DEFAULT 0.00,
  `discount_type` varchar(30) DEFAULT NULL,
  `invoiceid` int(11) DEFAULT NULL,
  `invoiced_date` datetime DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `sale_agent` int(11) NOT NULL DEFAULT 0,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT NULL,
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT NULL,
  `include_shipping` tinyint(1) NOT NULL,
  `show_shipping_on_estimate` tinyint(1) NOT NULL DEFAULT 1,
  `show_quantity_as` int(11) NOT NULL DEFAULT 1,
  `pipeline_order` int(11) NOT NULL DEFAULT 0,
  `is_expiry_notified` int(11) NOT NULL DEFAULT 0,
  `acceptance_firstname` varchar(50) DEFAULT NULL,
  `acceptance_lastname` varchar(50) DEFAULT NULL,
  `acceptance_email` varchar(100) DEFAULT NULL,
  `acceptance_date` datetime DEFAULT NULL,
  `acceptance_ip` varchar(40) DEFAULT NULL,
  `signature` varchar(40) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblevents`
--

CREATE TABLE `tblevents` (
  `eventid` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` text DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `public` int(11) NOT NULL DEFAULT 0,
  `color` varchar(10) DEFAULT NULL,
  `isstartnotified` tinyint(1) NOT NULL DEFAULT 0,
  `reminder_before` int(11) NOT NULL DEFAULT 0,
  `reminder_before_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblexpenses`
--

CREATE TABLE `tblexpenses` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax2` int(11) NOT NULL DEFAULT 0,
  `reference_no` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `expense_name` varchar(191) DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `billable` int(11) DEFAULT 0,
  `invoiceid` int(11) DEFAULT NULL,
  `paymentmode` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT 0,
  `cycles` int(11) NOT NULL DEFAULT 0,
  `total_cycles` int(11) NOT NULL DEFAULT 0,
  `custom_recurring` int(11) NOT NULL DEFAULT 0,
  `last_recurring_date` date DEFAULT NULL,
  `create_invoice_billable` tinyint(1) DEFAULT NULL,
  `send_invoice_to_customer` tinyint(1) NOT NULL,
  `recurring_from` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `addedfrom` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblexpenses`
--

INSERT INTO `tblexpenses` (`id`, `category`, `currency`, `amount`, `tax`, `tax2`, `reference_no`, `note`, `expense_name`, `clientid`, `project_id`, `rel_sid`, `rel_stype`, `billable`, `invoiceid`, `paymentmode`, `date`, `recurring_type`, `repeat_every`, `recurring`, `cycles`, `total_cycles`, `custom_recurring`, `last_recurring_date`, `create_invoice_billable`, `send_invoice_to_customer`, `recurring_from`, `dateadded`, `addedfrom`, `deleted`) VALUES
(5, 1, 1, '5.00', 0, 0, '', '', 'tes', 0, 0, NULL, NULL, 0, NULL, '', '2019-09-04', NULL, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, '2019-09-04 18:49:29', 1, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblexpenses_categories`
--

CREATE TABLE `tblexpenses_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblexpenses_categories`
--

INSERT INTO `tblexpenses_categories` (`id`, `name`, `description`) VALUES
(1, 'test', '');

-- --------------------------------------------------------

--
-- بنية الجدول `tblfiles`
--

CREATE TABLE `tblfiles` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `filetype` varchar(40) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT 0,
  `attachment_key` varchar(32) DEFAULT NULL,
  `external` varchar(40) DEFAULT NULL,
  `external_link` text DEFAULT NULL,
  `thumbnail_link` text DEFAULT NULL COMMENT 'For external usage',
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT 0,
  `task_comment_id` int(11) NOT NULL DEFAULT 0,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblform_questions`
--

CREATE TABLE `tblform_questions` (
  `questionid` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `question` mediumtext NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `question_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblform_question_box`
--

CREATE TABLE `tblform_question_box` (
  `boxid` int(11) NOT NULL,
  `boxtype` varchar(10) NOT NULL,
  `questionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblform_question_box_description`
--

CREATE TABLE `tblform_question_box_description` (
  `questionboxdescriptionid` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `boxid` mediumtext NOT NULL,
  `questionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblform_results`
--

CREATE TABLE `tblform_results` (
  `resultid` int(11) NOT NULL,
  `boxid` int(11) NOT NULL,
  `boxdescriptionid` int(11) DEFAULT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `questionid` int(11) NOT NULL,
  `answer` text DEFAULT NULL,
  `resultsetid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblgdpr_requests`
--

CREATE TABLE `tblgdpr_requests` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `lead_id` int(11) NOT NULL DEFAULT 0,
  `request_type` varchar(191) DEFAULT NULL,
  `status` varchar(40) DEFAULT NULL,
  `request_date` datetime NOT NULL,
  `request_from` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblinvoicepaymentrecords`
--

CREATE TABLE `tblinvoicepaymentrecords` (
  `id` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paymentmode` varchar(40) DEFAULT NULL,
  `paymentmethod` varchar(191) DEFAULT NULL,
  `date` date NOT NULL,
  `daterecorded` datetime NOT NULL,
  `note` text NOT NULL,
  `transactionid` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblinvoicepaymentrecords`
--

INSERT INTO `tblinvoicepaymentrecords` (`id`, `invoiceid`, `amount`, `paymentmode`, `paymentmethod`, `date`, `daterecorded`, `note`, `transactionid`) VALUES
(1, 1, '10.00', '1', '', '2019-08-26', '2019-08-26 21:06:17', '', '');

-- --------------------------------------------------------

--
-- بنية الجدول `tblinvoices`
--

CREATE TABLE `tblinvoices` (
  `id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `datesend` datetime DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `status` int(11) DEFAULT 1,
  `clientnote` text DEFAULT NULL,
  `adminnote` text DEFAULT NULL,
  `last_overdue_reminder` date DEFAULT NULL,
  `cancel_overdue_reminders` int(11) NOT NULL DEFAULT 0,
  `allowed_payment_modes` mediumtext DEFAULT NULL,
  `token` mediumtext DEFAULT NULL,
  `discount_percent` decimal(15,2) DEFAULT 0.00,
  `discount_total` decimal(15,2) DEFAULT 0.00,
  `discount_type` varchar(30) NOT NULL,
  `recurring` int(11) NOT NULL DEFAULT 0,
  `recurring_type` varchar(10) DEFAULT NULL,
  `custom_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `cycles` int(11) NOT NULL DEFAULT 0,
  `total_cycles` int(11) NOT NULL DEFAULT 0,
  `is_recurring_from` int(11) DEFAULT NULL,
  `last_recurring_date` date DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `sale_agent` int(11) NOT NULL DEFAULT 0,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT NULL,
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT NULL,
  `include_shipping` tinyint(1) NOT NULL,
  `show_shipping_on_invoice` tinyint(1) NOT NULL DEFAULT 1,
  `show_quantity_as` int(11) NOT NULL DEFAULT 1,
  `project_id` int(11) DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `subscription_id` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblitemable`
--

CREATE TABLE `tblitemable` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(15) NOT NULL,
  `description` mediumtext NOT NULL,
  `long_description` mediumtext DEFAULT NULL,
  `qty` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `unit` varchar(40) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblitemable`
--

INSERT INTO `tblitemable` (`id`, `rel_id`, `rel_type`, `description`, `long_description`, `qty`, `rate`, `unit`, `item_order`) VALUES
(1, 2, 'invoice', 'قضية 1', 'test - 505:00 Hours', '1.00', '0.00', '', 1),
(2, 1, 'invoice', 'test', '', '1.00', '10.00', '', 1),
(3, 1, 'proposal', 'test', '', '1.00', '10.00', '', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tblitems`
--

CREATE TABLE `tblitems` (
  `id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `long_description` text DEFAULT NULL,
  `rate` decimal(15,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax2` int(11) DEFAULT NULL,
  `unit` varchar(40) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblitems`
--

INSERT INTO `tblitems` (`id`, `description`, `long_description`, `rate`, `tax`, `tax2`, `unit`, `group_id`) VALUES
(1, 'test', '', '10.00', NULL, NULL, '', 0),
(2, 'المبلغ المدين شهريا', '', '10000.00', NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblitems_groups`
--

CREATE TABLE `tblitems_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblitem_tax`
--

CREATE TABLE `tblitem_tax` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `taxrate` decimal(15,2) NOT NULL,
  `taxname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblknowedge_base_article_feedback`
--

CREATE TABLE `tblknowedge_base_article_feedback` (
  `articleanswerid` int(11) NOT NULL,
  `articleid` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblknowledge_base`
--

CREATE TABLE `tblknowledge_base` (
  `articleid` int(11) NOT NULL,
  `articlegroup` int(11) NOT NULL,
  `subject` mediumtext NOT NULL,
  `description` text NOT NULL,
  `slug` mediumtext NOT NULL,
  `active` tinyint(4) NOT NULL,
  `datecreated` datetime NOT NULL,
  `article_order` int(11) NOT NULL DEFAULT 0,
  `staff_article` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblknowledge_base_groups`
--

CREATE TABLE `tblknowledge_base_groups` (
  `groupid` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `group_slug` text DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  `color` varchar(10) DEFAULT '#28B8DA',
  `group_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblleads`
--

CREATE TABLE `tblleads` (
  `id` int(11) NOT NULL,
  `hash` varchar(65) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `company` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT 0,
  `zip` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `assigned` int(11) NOT NULL DEFAULT 0,
  `dateadded` datetime NOT NULL,
  `from_form_id` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `lastcontact` datetime DEFAULT NULL,
  `dateassigned` date DEFAULT NULL,
  `last_status_change` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `leadorder` int(11) DEFAULT 1,
  `phonenumber` varchar(50) DEFAULT NULL,
  `date_converted` datetime DEFAULT NULL,
  `lost` tinyint(1) NOT NULL DEFAULT 0,
  `junk` int(11) NOT NULL DEFAULT 0,
  `last_lead_status` int(11) NOT NULL DEFAULT 0,
  `is_imported_from_email_integration` tinyint(1) NOT NULL DEFAULT 0,
  `email_integration_uid` varchar(30) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `default_language` varchar(40) DEFAULT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblleads_email_integration`
--

CREATE TABLE `tblleads_email_integration` (
  `id` int(11) NOT NULL COMMENT 'the ID always must be 1',
  `active` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `imap_server` varchar(100) NOT NULL,
  `password` mediumtext NOT NULL,
  `check_every` int(11) NOT NULL DEFAULT 5,
  `responsible` int(11) NOT NULL,
  `lead_source` int(11) NOT NULL,
  `lead_status` int(11) NOT NULL,
  `encryption` varchar(3) DEFAULT NULL,
  `folder` varchar(100) NOT NULL,
  `last_run` varchar(50) DEFAULT NULL,
  `notify_lead_imported` tinyint(1) NOT NULL DEFAULT 1,
  `notify_lead_contact_more_times` tinyint(1) NOT NULL DEFAULT 1,
  `notify_type` varchar(20) DEFAULT NULL,
  `notify_ids` mediumtext DEFAULT NULL,
  `mark_public` int(11) NOT NULL DEFAULT 0,
  `only_loop_on_unseen_emails` tinyint(1) NOT NULL DEFAULT 1,
  `delete_after_import` int(11) NOT NULL DEFAULT 0,
  `create_task_if_customer` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblleads_email_integration`
--

INSERT INTO `tblleads_email_integration` (`id`, `active`, `email`, `imap_server`, `password`, `check_every`, `responsible`, `lead_source`, `lead_status`, `encryption`, `folder`, `last_run`, `notify_lead_imported`, `notify_lead_contact_more_times`, `notify_type`, `notify_ids`, `mark_public`, `only_loop_on_unseen_emails`, `delete_after_import`, `create_task_if_customer`) VALUES
(1, 0, '', '', '', 10, 0, 0, 0, 'tls', 'inbox', '', 1, 1, 'assigned', '', 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tblleads_sources`
--

CREATE TABLE `tblleads_sources` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblleads_sources`
--

INSERT INTO `tblleads_sources` (`id`, `name`) VALUES
(2, 'Facebook'),
(1, 'Google');

-- --------------------------------------------------------

--
-- بنية الجدول `tblleads_status`
--

CREATE TABLE `tblleads_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `statusorder` int(11) DEFAULT NULL,
  `color` varchar(10) DEFAULT '#28B8DA',
  `isdefault` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblleads_status`
--

INSERT INTO `tblleads_status` (`id`, `name`, `statusorder`, `color`, `isdefault`) VALUES
(1, 'Customer', 1000, '#7cb342', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tbllead_activity_log`
--

CREATE TABLE `tbllead_activity_log` (
  `id` int(11) NOT NULL,
  `leadid` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `additional_data` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `staffid` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `custom_activity` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbllead_integration_emails`
--

CREATE TABLE `tbllead_integration_emails` (
  `id` int(11) NOT NULL,
  `subject` mediumtext DEFAULT NULL,
  `body` mediumtext DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `leadid` int(11) NOT NULL,
  `emailid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmail_queue`
--

CREATE TABLE `tblmail_queue` (
  `id` int(11) NOT NULL,
  `engine` varchar(40) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `cc` text DEFAULT NULL,
  `bcc` text DEFAULT NULL,
  `message` mediumtext NOT NULL,
  `alt_message` mediumtext DEFAULT NULL,
  `status` enum('pending','sending','sent','failed') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `headers` text DEFAULT NULL,
  `attachments` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmigrations`
--

CREATE TABLE `tblmigrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmigrations`
--

INSERT INTO `tblmigrations` (`version`) VALUES
(235);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmilestones`
--

CREATE TABLE `tblmilestones` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `description_visible_to_customer` tinyint(1) DEFAULT 0,
  `due_date` date NOT NULL,
  `project_id` int(11) NOT NULL,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `milestone_order` int(11) NOT NULL DEFAULT 0,
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmodules`
--

CREATE TABLE `tblmodules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(55) NOT NULL,
  `installed_version` varchar(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmodules`
--

INSERT INTO `tblmodules` (`id`, `module_name`, `installed_version`, `active`) VALUES
(1, 'menu_setup', '2.3.0', 1),
(2, 'hrm', '1.0.0', 0),
(3, 'label_management', '2.3.0', 1),
(4, 'location_module', '2.3.0', 0),
(5, 'session', '2.3.0', 0),
(6, 'disputes', '1.0.0', 1),
(7, 'branches', '2.3.0', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_award`
--

CREATE TABLE `tblmy_award` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `award` double NOT NULL,
  `reason` text NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_award`
--

INSERT INTO `tblmy_award` (`id`, `staff_id`, `award`, `reason`, `date`) VALUES
(1, 2, 20, '', '2019-07'),
(2, 1, 44, '', '2019-07'),
(3, 1, 33, '', '2019-07');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_bank`
--

CREATE TABLE `tblmy_bank` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `routing_number` int(11) NOT NULL,
  `account_number` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_basic_services`
--

CREATE TABLE `tblmy_basic_services` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `is_primary` int(2) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_basic_services`
--

INSERT INTO `tblmy_basic_services` (`id`, `name`, `slug`, `prefix`, `numbering`, `is_primary`, `datecreated`) VALUES
(1, 'قضايا', 'kd-y', 'CASE', 1, 1, '2019-04-15 18:03:19'),
(2, 'عقود', 'aakod', 'Akd', 1, 1, '2019-05-01 19:43:08'),
(3, 'استشارات', 'stsh-r-t', 'Istsh', 1, 1, '2019-05-08 01:28:21');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_cases`
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
  `progress` int(11) DEFAULT 0,
  `progress_from_tasks` int(11) NOT NULL DEFAULT 1,
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_cases`
--

INSERT INTO `tblmy_cases` (`id`, `numbering`, `code`, `name`, `clientid`, `representative`, `cat_id`, `subcat_id`, `court_id`, `jud_num`, `country`, `city`, `billing_type`, `case_status`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `case_result`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `branch_id`, `deleted`) VALUES
(2, 1, 'CASE1', 'قضية 1', 3, 2, 3, 4, 2, 7, 105, 'karkouk', 1, 2, 1, 0, '0.00', '2019-09-13', '2019-09-16', NULL, NULL, '', 'متداولة', 0, '0.00', 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_casestatus`
--

CREATE TABLE `tblmy_casestatus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_casestatus`
--

INSERT INTO `tblmy_casestatus` (`id`, `name`) VALUES
(1, 'Case Status 1'),
(2, 'case status 2');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_cases_judges`
--

CREATE TABLE `tblmy_cases_judges` (
  `id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_cases_judges`
--

INSERT INTO `tblmy_cases_judges` (`id`, `judge_id`, `case_id`) VALUES
(3, 3, 2),
(4, 1, 2);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_cases_movement_judges`
--

CREATE TABLE `tblmy_cases_movement_judges` (
  `id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `case_mov_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_cases_movement_judges`
--

INSERT INTO `tblmy_cases_movement_judges` (`id`, `judge_id`, `case_mov_id`) VALUES
(2, 3, 2),
(3, 1, 2);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_categories`
--

CREATE TABLE `tblmy_categories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_id` int(255) NOT NULL,
  `parent_id` int(255) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_categories`
--

INSERT INTO `tblmy_categories` (`id`, `name`, `service_id`, `parent_id`, `datecreated`) VALUES
(1, 'قضايا احوال شخصية', 1, 0, '2019-04-22 23:18:06'),
(2, 'خلع وطلاق', 1, 1, '2019-04-22 23:18:34'),
(3, 'test', 1, 0, '2019-05-01 16:35:13'),
(4, '1', 1, 3, '2019-05-01 16:35:22'),
(5, 'test', 2, 0, '2019-05-15 04:58:00'),
(6, 'test cat', 2, 5, '2019-05-15 04:58:09'),
(7, 'cat', 3, 0, '2019-05-16 04:06:43'),
(8, 'sub test', 3, 7, '2019-05-16 04:07:06'),
(9, '54', 3, 0, '2019-06-02 03:53:28'),
(10, '676', 3, 9, '2019-06-02 03:53:56'),
(11, 'ttest', 3, 0, '2019-06-02 03:55:39'),
(12, 'sub trtst', 3, 11, '2019-06-02 03:55:52');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_courts`
--

CREATE TABLE `tblmy_courts` (
  `c_id` int(11) NOT NULL,
  `court_name` varchar(250) NOT NULL,
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_courts`
--

INSERT INTO `tblmy_courts` (`c_id`, `court_name`, `datecreated`) VALUES
(2, 'محكمة العدل', '2019-07-23');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_customer_representative`
--

CREATE TABLE `tblmy_customer_representative` (
  `id` int(11) NOT NULL,
  `representative` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_customer_representative`
--

INSERT INTO `tblmy_customer_representative` (`id`, `representative`) VALUES
(1, 'Accused'),
(2, 'Victim');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_employee_basic`
--

CREATE TABLE `tblmy_employee_basic` (
  `employee_basic_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `joining_date` date NOT NULL,
  `date_of_birth` date NOT NULL,
  `maratial_status` varchar(50) NOT NULL,
  `father_name` varchar(50) DEFAULT NULL,
  `mother_name` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_holiday`
--

CREATE TABLE `tblmy_holiday` (
  `id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_holiday`
--

INSERT INTO `tblmy_holiday` (`id`, `event_name`, `description`, `start_date`, `end_date`) VALUES
(1, 'holiday 1', 'desc holiday 1', '2019-07-21', '2019-07-23');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_judges`
--

CREATE TABLE `tblmy_judges` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_judges`
--

INSERT INTO `tblmy_judges` (`id`, `name`, `note`) VALUES
(1, 'قاضي أول', ''),
(3, 'Judge two', '');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_judicialdept`
--

CREATE TABLE `tblmy_judicialdept` (
  `j_id` int(255) NOT NULL,
  `Jud_number` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_judicialdept`
--

INSERT INTO `tblmy_judicialdept` (`j_id`, `Jud_number`, `c_id`, `datecreated`) VALUES
(7, 3, 2, '2019-07-28 20:58:03');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_members_cases`
--

CREATE TABLE `tblmy_members_cases` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_members_cases`
--

INSERT INTO `tblmy_members_cases` (`id`, `staff_id`, `project_id`) VALUES
(17, 1, 9),
(21, 1, 2);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_members_services`
--

CREATE TABLE `tblmy_members_services` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_members_services`
--

INSERT INTO `tblmy_members_services` (`id`, `staff_id`, `oservice_id`) VALUES
(3, 1, 5),
(4, 1, 6);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_newstaff`
--

CREATE TABLE `tblmy_newstaff` (
  `user_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `period` varchar(1) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `main_salary` int(11) NOT NULL,
  `transportation_expenses` int(11) NOT NULL,
  `other_expenses` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_newstaff`
--

INSERT INTO `tblmy_newstaff` (`user_id`, `staff_id`, `period`, `gender`, `main_salary`, `transportation_expenses`, `other_expenses`, `job_title`, `created`) VALUES
(1, 2, 'm', '', 0, 0, 0, '', '0000-00-00'),
(2, 1, 'e', '', 500, 12, 25, '', '0000-00-00');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_other_services`
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
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_other_services`
--

INSERT INTO `tblmy_other_services` (`id`, `service_id`, `code`, `numbering`, `name`, `clientid`, `cat_id`, `subcat_id`, `service_session_link`, `billing_type`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `country`, `city`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `branch_id`, `deleted`) VALUES
(5, 2, 'Akd5', 5, 'عقد@عقد', 3, 5, 6, 0, 1, 1, 0, '0.00', '2019-09-27', '2019-09-04', NULL, NULL, '', 0, '', 0, '0.00', 0, 0, 1, 0, 2);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_procurationstate`
--

CREATE TABLE `tblmy_procurationstate` (
  `id` int(11) NOT NULL,
  `procurationstate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_procurationstate`
--

INSERT INTO `tblmy_procurationstate` (`id`, `procurationstate`) VALUES
(1, 'Finished'),
(2, 'Ongoing');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_procurationtype`
--

CREATE TABLE `tblmy_procurationtype` (
  `id` int(11) NOT NULL,
  `procurationtype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_procurationtype`
--

INSERT INTO `tblmy_procurationtype` (`id`, `procurationtype`) VALUES
(1, 'Private'),
(2, 'Public');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_projects_contacts`
--

CREATE TABLE `tblmy_projects_contacts` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `contact_type` int(2) NOT NULL DEFAULT 0,
  `contact_name` varchar(50) NOT NULL DEFAULT '',
  `contact_address` varchar(250) NOT NULL DEFAULT '',
  `contact_email` varchar(50) NOT NULL DEFAULT '',
  `contact_phone` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_projects_contacts`
--

INSERT INTO `tblmy_projects_contacts` (`id`, `project_id`, `contact_type`, `contact_name`, `contact_address`, `contact_email`, `contact_phone`) VALUES
(1, 5, 0, 'opppnent 1', 'test', 'test@mail.com', 'ds'),
(2, 5, 1, 'opppnent lawyer', 'testt', 'test@mail.com', 'ds'),
(3, 6, 0, 'tt', 'tt', 'tt', 'tt');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_projects_meta`
--

CREATE TABLE `tblmy_projects_meta` (
  `id` int(11) NOT NULL,
  `project_id` int(12) NOT NULL DEFAULT 0,
  `meta_key` varchar(100) NOT NULL DEFAULT '',
  `meta_value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_projects_meta`
--

INSERT INTO `tblmy_projects_meta` (`id`, `project_id`, `meta_key`, `meta_value`) VALUES
(1, 5, 'representative', '2'),
(2, 5, 'country', '125'),
(3, 5, 'city', 'yanbu'),
(4, 5, 'address1', 'address'),
(5, 5, 'address2', 'address'),
(6, 5, 'addressed_to', 'address'),
(7, 5, 'notes', ''),
(8, 5, 'projects_status', ''),
(9, 5, 'cat_id', ''),
(10, 5, 'subcat_id', ''),
(11, 6, 'representative', '2'),
(12, 6, 'country', '169'),
(13, 6, 'city', 'damascus'),
(14, 6, 'address1', 'tt'),
(15, 6, 'address2', 'tt'),
(16, 6, 'addressed_to', 'tt'),
(17, 6, 'notes', ''),
(18, 6, 'projects_status', '1'),
(19, 6, 'cat_id', ''),
(20, 6, 'subcat_id', '');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_projects_statuses`
--

CREATE TABLE `tblmy_projects_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_projects_statuses`
--

INSERT INTO `tblmy_projects_statuses` (`id`, `status_name`) VALUES
(1, 'حالة 1');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_project_invoicepaymentrecords`
--

CREATE TABLE `tblmy_project_invoicepaymentrecords` (
  `id` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paymentmode` varchar(40) DEFAULT NULL,
  `paymentmethod` varchar(191) DEFAULT NULL,
  `date` date NOT NULL,
  `daterecorded` datetime NOT NULL,
  `note` text NOT NULL,
  `transactionid` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_project_invoices`
--

CREATE TABLE `tblmy_project_invoices` (
  `id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `datesend` datetime DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `status` int(11) DEFAULT 1,
  `clientnote` text DEFAULT NULL,
  `adminnote` text DEFAULT NULL,
  `last_overdue_reminder` date DEFAULT NULL,
  `cancel_overdue_reminders` int(11) NOT NULL DEFAULT 0,
  `allowed_payment_modes` mediumtext DEFAULT NULL,
  `token` mediumtext DEFAULT NULL,
  `discount_percent` decimal(15,2) DEFAULT 0.00,
  `discount_total` decimal(15,2) DEFAULT 0.00,
  `discount_type` varchar(30) NOT NULL,
  `recurring` int(11) NOT NULL DEFAULT 0,
  `recurring_type` varchar(10) DEFAULT NULL,
  `custom_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `cycles` int(11) NOT NULL DEFAULT 0,
  `total_cycles` int(11) NOT NULL DEFAULT 0,
  `is_recurring_from` int(11) DEFAULT NULL,
  `last_recurring_date` date DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `sale_agent` int(11) NOT NULL DEFAULT 0,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT NULL,
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT NULL,
  `include_shipping` tinyint(1) NOT NULL,
  `show_shipping_on_invoice` tinyint(1) NOT NULL DEFAULT 1,
  `show_quantity_as` int(11) NOT NULL DEFAULT 1,
  `project_id` int(11) DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `subscription_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_salary`
--

CREATE TABLE `tblmy_salary` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `ammount` double NOT NULL,
  `payment_month` varchar(20) NOT NULL,
  `paid_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_service_session`
--

CREATE TABLE `tblmy_service_session` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(200) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `court_id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `details` text NOT NULL,
  `next_action` text NOT NULL,
  `report` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_service_session`
--

INSERT INTO `tblmy_service_session` (`id`, `service_id`, `rel_id`, `rel_type`, `subject`, `court_id`, `judge_id`, `date`, `time`, `details`, `next_action`, `report`, `status`, `result`, `staff`, `deleted`, `created`) VALUES
(12, 1, 7, '', 'test', 2, 3, '2019-08-18', '17:30:00', '', '', '', 1, 1, 1, 0, '2019-08-18 11:42:22'),
(14, 1, 1, '', 'test', 2, 3, '2019-08-29', '05:55:00', '', '', '', 0, 0, 1, 0, '2019-08-29 09:11:58');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_sessiondiscussioncomments`
--

CREATE TABLE `tblmy_sessiondiscussioncomments` (
  `id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `discussion_type` varchar(10) NOT NULL,
  `parent` int(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT 0,
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_sessiondiscussions`
--

CREATE TABLE `tblmy_sessiondiscussions` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL,
  `datecreated` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_session_info`
--

CREATE TABLE `tblmy_session_info` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `session_number` int(11) DEFAULT NULL,
  `judicial_office_number` int(11) NOT NULL,
  `court_id` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `court_decision` text NOT NULL,
  `session_information` text NOT NULL,
  `judge_id` int(11) NOT NULL,
  `session_type` text NOT NULL,
  `customer_report` int(11) NOT NULL,
  `send_to_customer` int(11) NOT NULL,
  `session_status` int(11) NOT NULL,
  `time` time NOT NULL,
  `next_session_date` date DEFAULT NULL,
  `next_session_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_session_info`
--

INSERT INTO `tblmy_session_info` (`id`, `task_id`, `session_number`, `judicial_office_number`, `court_id`, `dept`, `court_decision`, `session_information`, `judge_id`, `session_type`, `customer_report`, `send_to_customer`, `session_status`, `time`, `next_session_date`, `next_session_time`) VALUES
(7, 7, 123, 123, 2, 123, 'qqwqwqwqwqwqw', 'جلسة تجريبية جلسة تجريبية جلسة تجريبية', 1, 'جلسة قضائية', 1, 1, 0, '03:00:00', '2019-09-20', '01:00:00'),
(8, 8, 0, 0, 2, 0, '', '', 3, '', 0, 0, 0, '14:01:00', NULL, NULL),
(9, 9, 0, 0, 2, 0, '', '', 3, '', 0, 0, 0, '01:00:00', NULL, NULL),
(11, 11, 0, 0, 2, 0, '', '', 3, '', 0, 0, 0, '01:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_training`
--

CREATE TABLE `tblmy_training` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `training` varchar(20) NOT NULL,
  `vendor` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `cost` double NOT NULL,
  `status` varchar(20) NOT NULL,
  `performance` varchar(20) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_training`
--

INSERT INTO `tblmy_training` (`id`, `staff_id`, `training`, `vendor`, `start_date`, `end_date`, `cost`, `status`, `performance`, `remarks`) VALUES
(4, 1, 'yyy', 'zzzz', '2019-07-04', '2019-07-12', 50, '0', '0', '');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_training_attachments`
--

CREATE TABLE `tblmy_training_attachments` (
  `id` int(11) NOT NULL,
  `trainid` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `filetype` text NOT NULL,
  `dateadded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_training_attachments`
--

INSERT INTO `tblmy_training_attachments` (`id`, `trainid`, `file_name`, `filetype`, `dateadded`) VALUES
(1, 2, 'Ambari.png', 'image/png', '2019-07-30'),
(3, 3, 'RHCSA.pdf', 'application/pdf', '2019-07-30'),
(4, 4, 'Capture.png', 'image/png', '2019-07-30');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_transactions`
--

CREATE TABLE `tblmy_transactions` (
  `id` int(11) NOT NULL,
  `definition` int(11) NOT NULL,
  `description` varchar(225) NOT NULL,
  `type` int(11) NOT NULL,
  `origin` int(11) NOT NULL,
  `incoming_num` int(11) DEFAULT NULL,
  `incoming_source` int(11) DEFAULT NULL,
  `incoming_type` int(11) DEFAULT NULL,
  `is_secret` tinyint(1) NOT NULL,
  `importance` int(11) NOT NULL,
  `classification` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `owner_phone` int(25) NOT NULL,
  `source_reporter` int(11) DEFAULT NULL,
  `source_reporter_phone` int(25) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_transactions`
--

INSERT INTO `tblmy_transactions` (`id`, `definition`, `description`, `type`, `origin`, `incoming_num`, `incoming_source`, `incoming_type`, `is_secret`, `importance`, `classification`, `owner`, `owner_phone`, `source_reporter`, `source_reporter_phone`, `email`, `date`, `isDeleted`) VALUES
(1, 0, '6548653', 0, 1, 94789, 1, 0, 0, 0, 1, 8787, 6, 656, 6, 'jkhlj@kjkl.ijh', '2019-09-17', NULL),
(2, 0, '6548653', 1, 1, 94789, 1, 0, 0, 0, 1, 8787, 6, 656, 6, 'jkhlj@kjkl.ijh', '0000-00-00', NULL),
(3, 0, '6548653', 1, 1, 94789, 1, 1, 0, 0, 1, 8787, 0, 0, 6, 'mhdbashard@gmail.com', '2019-09-22', 0),
(4, 1, '6548653', 0, 1, NULL, NULL, NULL, 0, 0, 1, 0, 6, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_vac`
--

CREATE TABLE `tblmy_vac` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_vac`
--

INSERT INTO `tblmy_vac` (`id`, `staff_id`, `description`, `start_date`, `end_date`) VALUES
(1, 1, 'vac 1', '2019-07-09', '2019-07-10');

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_workday`
--

CREATE TABLE `tblmy_workday` (
  `saturday` int(11) NOT NULL,
  `sunday` int(11) NOT NULL,
  `monday` int(11) NOT NULL,
  `tuesday` int(11) NOT NULL,
  `wednesday` int(11) NOT NULL,
  `thursday` int(11) NOT NULL,
  `friday` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_workday`
--

INSERT INTO `tblmy_workday` (`saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`) VALUES
(1, 0, 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tblmy_workdays_period`
--

CREATE TABLE `tblmy_workdays_period` (
  `morning` varchar(50) NOT NULL,
  `evening` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblmy_workdays_period`
--

INSERT INTO `tblmy_workdays_period` (`morning`, `evening`) VALUES
('9:30-13:30', '2:00-12:00');

-- --------------------------------------------------------

--
-- بنية الجدول `tblnewsfeed_comment_likes`
--

CREATE TABLE `tblnewsfeed_comment_likes` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `dateliked` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblnewsfeed_posts`
--

CREATE TABLE `tblnewsfeed_posts` (
  `postid` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `visibility` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `pinned` int(11) NOT NULL,
  `datepinned` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblnewsfeed_post_comments`
--

CREATE TABLE `tblnewsfeed_post_comments` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblnewsfeed_post_likes`
--

CREATE TABLE `tblnewsfeed_post_likes` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `dateliked` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblnotes`
--

CREATE TABLE `tblnotes` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `date_contacted` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblnotifications`
--

CREATE TABLE `tblnotifications` (
  `id` int(11) NOT NULL,
  `isread` int(11) NOT NULL DEFAULT 0,
  `isread_inline` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `fromuserid` int(11) NOT NULL,
  `fromclientid` int(11) NOT NULL DEFAULT 0,
  `from_fullname` varchar(100) NOT NULL,
  `touserid` int(11) NOT NULL,
  `fromcompany` int(11) DEFAULT NULL,
  `link` mediumtext DEFAULT NULL,
  `additional_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblnotifications`
--

INSERT INTO `tblnotifications` (`id`, `isread`, `isread_inline`, `date`, `description`, `fromuserid`, `fromclientid`, `from_fullname`, `touserid`, `fromcompany`, `link`, `additional_data`) VALUES
(1, 1, 1, '2019-09-08 14:15:11', 'ConfirmEmptyLegalServicesRecycleBin', 0, 0, '', 1, 1, 'LegalServices/LegalServices_controller/confirm_empty_recycle_bin', NULL),
(2, 1, 1, '2019-09-10 20:44:30', 'ConfirmEmptyLegalServicesRecycleBin', 0, 0, '', 1, 1, 'LegalServices/LegalServices_controller/confirm_empty_recycle_bin', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `tbloptions`
--

CREATE TABLE `tbloptions` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `value` longtext NOT NULL,
  `autoload` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbloptions`
--

INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES
(1, 'dateformat', 'Y-m-d|%Y-%m-%d', 1),
(2, 'companyname', '', 1),
(3, 'services', '1', 1),
(4, 'maximum_allowed_ticket_attachments', '4', 1),
(5, 'ticket_attachments_file_extensions', '.jpg,.png,.pdf,.doc,.zip,.rar', 1),
(6, 'staff_access_only_assigned_departments', '1', 1),
(7, 'use_knowledge_base', '1', 1),
(8, 'smtp_email', '', 1),
(9, 'smtp_password', '', 1),
(10, 'company_info_format', '{company_name}<br />\r\n{address}<br />\r\n{city} {state}<br />\r\n{country_code} {zip_code}<br />\r\n{vat_number_with_label}', 0),
(11, 'smtp_port', '', 1),
(12, 'smtp_host', '', 1),
(13, 'smtp_email_charset', 'utf-8', 1),
(14, 'default_timezone', 'Asia/Damascus', 1),
(15, 'clients_default_theme', 'perfex', 1),
(16, 'company_logo', '', 1),
(17, 'tables_pagination_limit', '25', 1),
(18, 'main_domain', '', 1),
(19, 'allow_registration', '0', 1),
(20, 'knowledge_base_without_registration', '1', 1),
(21, 'email_signature', '', 1),
(22, 'default_staff_role', '1', 1),
(23, 'newsfeed_maximum_files_upload', '10', 1),
(24, 'contract_expiration_before', '4', 1),
(25, 'invoice_prefix', 'INV-', 1),
(26, 'decimal_separator', '.', 1),
(27, 'thousand_separator', ',', 1),
(28, 'invoice_company_name', '', 1),
(29, 'invoice_company_address', '', 1),
(30, 'invoice_company_city', '', 1),
(31, 'invoice_company_country_code', '', 1),
(32, 'invoice_company_postal_code', '', 1),
(33, 'invoice_company_phonenumber', '', 1),
(34, 'view_invoice_only_logged_in', '0', 1),
(35, 'invoice_number_format', '1', 1),
(36, 'next_invoice_number', '2', 0),
(37, 'active_language', 'arabic', 1),
(38, 'invoice_number_decrement_on_delete', '1', 1),
(39, 'automatically_send_invoice_overdue_reminder_after', '1', 1),
(40, 'automatically_resend_invoice_overdue_reminder_after', '3', 1),
(41, 'expenses_auto_operations_hour', '21', 1),
(42, 'delete_only_on_last_invoice', '1', 1),
(43, 'delete_only_on_last_estimate', '1', 1),
(44, 'create_invoice_from_recurring_only_on_paid_invoices', '0', 1),
(45, 'allow_payment_amount_to_be_modified', '1', 1),
(46, 'rtl_support_client', '1', 1),
(47, 'limit_top_search_bar_results_to', '10', 1),
(48, 'estimate_prefix', 'EST-', 1),
(49, 'next_estimate_number', '1', 0),
(50, 'estimate_number_decrement_on_delete', '1', 1),
(51, 'estimate_number_format', '1', 1),
(52, 'estimate_auto_convert_to_invoice_on_client_accept', '1', 1),
(53, 'exclude_estimate_from_client_area_with_draft_status', '1', 1),
(54, 'rtl_support_admin', '1', 1),
(55, 'last_cron_run', '1568137469', 1),
(56, 'show_sale_agent_on_estimates', '1', 1),
(57, 'show_sale_agent_on_invoices', '1', 1),
(58, 'predefined_terms_invoice', '', 1),
(59, 'predefined_terms_estimate', '', 1),
(60, 'default_task_priority', '2', 1),
(61, 'dropbox_app_key', '', 1),
(62, 'show_expense_reminders_on_calendar', '1', 1),
(63, 'only_show_contact_tickets', '1', 1),
(64, 'predefined_clientnote_invoice', '', 1),
(65, 'predefined_clientnote_estimate', '', 1),
(66, 'custom_pdf_logo_image_url', '', 1),
(67, 'favicon', '', 1),
(68, 'invoice_due_after', '30', 1),
(69, 'google_api_key', '', 1),
(70, 'google_calendar_main_calendar', '', 1),
(71, 'default_tax', 'a:0:{}', 1),
(72, 'show_invoices_on_calendar', '1', 1),
(73, 'show_estimates_on_calendar', '1', 1),
(74, 'show_contracts_on_calendar', '1', 1),
(75, 'show_tasks_on_calendar', '1', 1),
(76, 'show_customer_reminders_on_calendar', '1', 1),
(77, 'output_client_pdfs_from_admin_area_in_client_language', '0', 1),
(78, 'show_lead_reminders_on_calendar', '1', 1),
(79, 'send_estimate_expiry_reminder_before', '4', 1),
(80, 'leads_default_source', '', 1),
(81, 'leads_default_status', '', 1),
(82, 'proposal_expiry_reminder_enabled', '1', 1),
(83, 'send_proposal_expiry_reminder_before', '4', 1),
(84, 'default_contact_permissions', 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";}', 1),
(85, 'pdf_logo_width', '150', 1),
(86, 'access_tickets_to_none_staff_members', '0', 1),
(87, 'customer_default_country', '0', 1),
(88, 'view_estimate_only_logged_in', '0', 1),
(89, 'show_status_on_pdf_ei', '1', 1),
(90, 'email_piping_only_replies', '0', 1),
(91, 'email_piping_only_registered', '0', 1),
(92, 'default_view_calendar', 'month', 1),
(93, 'email_piping_default_priority', '2', 1),
(94, 'total_to_words_lowercase', '0', 1),
(95, 'show_tax_per_item', '1', 1),
(96, 'total_to_words_enabled', '0', 1),
(97, 'receive_notification_on_new_ticket', '1', 0),
(98, 'autoclose_tickets_after', '0', 1),
(99, 'media_max_file_size_upload', '10', 1),
(100, 'client_staff_add_edit_delete_task_comments_first_hour', '0', 1),
(101, 'show_projects_on_calendar', '1', 1),
(102, 'leads_kanban_limit', '50', 1),
(103, 'tasks_reminder_notification_before', '2', 1),
(104, 'pdf_font', 'freesans', 1),
(105, 'pdf_table_heading_color', '#323a45', 1),
(106, 'pdf_table_heading_text_color', '#ffffff', 1),
(107, 'pdf_font_size', '10', 1),
(108, 'default_leads_kanban_sort', 'leadorder', 1),
(109, 'default_leads_kanban_sort_type', 'asc', 1),
(110, 'allowed_files', '.png,.jpg,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt', 1),
(111, 'show_all_tasks_for_project_member', '1', 1),
(112, 'email_protocol', 'smtp', 1),
(113, 'calendar_first_day', '0', 1),
(114, 'recaptcha_secret_key', '', 1),
(115, 'show_help_on_setup_menu', '1', 1),
(116, 'show_proposals_on_calendar', '1', 1),
(117, 'smtp_encryption', '', 1),
(118, 'recaptcha_site_key', '', 1),
(119, 'smtp_username', '', 1),
(120, 'auto_stop_tasks_timers_on_new_timer', '1', 1),
(121, 'notification_when_customer_pay_invoice', '1', 1),
(122, 'calendar_invoice_color', '#FF6F00', 1),
(123, 'calendar_estimate_color', '#FF6F00', 1),
(124, 'calendar_proposal_color', '#84c529', 1),
(125, 'new_task_auto_assign_current_member', '1', 1),
(126, 'calendar_reminder_color', '#03A9F4', 1),
(127, 'calendar_contract_color', '#B72974', 1),
(128, 'calendar_project_color', '#B72974', 1),
(129, 'update_info_message', '', 1),
(130, 'show_estimate_reminders_on_calendar', '1', 1),
(131, 'show_invoice_reminders_on_calendar', '1', 1),
(132, 'show_proposal_reminders_on_calendar', '1', 1),
(133, 'proposal_due_after', '7', 1),
(134, 'allow_customer_to_change_ticket_status', '0', 1),
(135, 'lead_lock_after_convert_to_customer', '0', 1),
(136, 'default_proposals_pipeline_sort', 'pipeline_order', 1),
(137, 'default_proposals_pipeline_sort_type', 'asc', 1),
(138, 'default_estimates_pipeline_sort', 'pipeline_order', 1),
(139, 'default_estimates_pipeline_sort_type', 'asc', 1),
(140, 'use_recaptcha_customers_area', '0', 1),
(141, 'remove_decimals_on_zero', '0', 1),
(142, 'remove_tax_name_from_item_table', '0', 1),
(143, 'pdf_format_invoice', 'A4-PORTRAIT', 1),
(144, 'pdf_format_estimate', 'A4-PORTRAIT', 1),
(145, 'pdf_format_proposal', 'A4-PORTRAIT', 1),
(146, 'pdf_format_payment', 'A4-PORTRAIT', 1),
(147, 'pdf_format_contract', 'A4-PORTRAIT', 1),
(148, 'swap_pdf_info', '0', 1),
(149, 'exclude_invoice_from_client_area_with_draft_status', '1', 1),
(150, 'cron_has_run_from_cli', '0', 1),
(151, 'hide_cron_is_required_message', '0', 0),
(152, 'auto_assign_customer_admin_after_lead_convert', '1', 1),
(153, 'show_transactions_on_invoice_pdf', '1', 1),
(154, 'show_pay_link_to_invoice_pdf', '1', 1),
(155, 'tasks_kanban_limit', '50', 1),
(156, 'purchase_key', '', 1),
(157, 'estimates_pipeline_limit', '50', 1),
(158, 'proposals_pipeline_limit', '50', 1),
(159, 'proposal_number_prefix', 'PRO-', 1),
(160, 'number_padding_prefixes', '6', 1),
(161, 'show_page_number_on_pdf', '0', 1),
(162, 'calendar_events_limit', '4', 1),
(163, 'show_setup_menu_item_only_on_hover', '0', 1),
(164, 'company_requires_vat_number_field', '0', 1),
(165, 'company_is_required', '1', 1),
(166, 'allow_contact_to_delete_files', '0', 1),
(167, 'company_vat', '', 1),
(168, 'di', '1563438556', 1),
(169, 'invoice_auto_operations_hour', '21', 1),
(170, 'use_minified_files', '1', 1),
(171, 'only_own_files_contacts', '0', 1),
(172, 'allow_primary_contact_to_view_edit_billing_and_shipping', '0', 1),
(173, 'estimate_due_after', '7', 1),
(174, 'staff_members_open_tickets_to_all_contacts', '1', 1),
(175, 'time_format', '24', 1),
(176, 'delete_activity_log_older_then', '1', 1),
(177, 'disable_language', '0', 1),
(178, 'company_state', '', 1),
(179, 'email_header', '<!doctype html>\n                            <html>\n                            <head>\n                              <meta name=\"viewport\" content=\"width=device-width\" />\n                              <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n                              <style>\n                                body {\n                                 background-color: #f6f6f6;\n                                 font-family: sans-serif;\n                                 -webkit-font-smoothing: antialiased;\n                                 font-size: 14px;\n                                 line-height: 1.4;\n                                 margin: 0;\n                                 padding: 0;\n                                 -ms-text-size-adjust: 100%;\n                                 -webkit-text-size-adjust: 100%;\n                               }\n                               table {\n                                 border-collapse: separate;\n                                 mso-table-lspace: 0pt;\n                                 mso-table-rspace: 0pt;\n                                 width: 100%;\n                               }\n                               table td {\n                                 font-family: sans-serif;\n                                 font-size: 14px;\n                                 vertical-align: top;\n                               }\n                                   /* -------------------------------------\n                                     BODY & CONTAINER\n                                     ------------------------------------- */\n                                     .body {\n                                       background-color: #f6f6f6;\n                                       width: 100%;\n                                     }\n                                     /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */\n\n                                     .container {\n                                       display: block;\n                                       margin: 0 auto !important;\n                                       /* makes it centered */\n                                       max-width: 680px;\n                                       padding: 10px;\n                                       width: 680px;\n                                     }\n                                     /* This should also be a block element, so that it will fill 100% of the .container */\n\n                                     .content {\n                                       box-sizing: border-box;\n                                       display: block;\n                                       margin: 0 auto;\n                                       max-width: 680px;\n                                       padding: 10px;\n                                     }\n                                   /* -------------------------------------\n                                     HEADER, FOOTER, MAIN\n                                     ------------------------------------- */\n\n                                     .main {\n                                       background: #fff;\n                                       border-radius: 3px;\n                                       width: 100%;\n                                     }\n                                     .wrapper {\n                                       box-sizing: border-box;\n                                       padding: 20px;\n                                     }\n                                     .footer {\n                                       clear: both;\n                                       padding-top: 10px;\n                                       text-align: center;\n                                       width: 100%;\n                                     }\n                                     .footer td,\n                                     .footer p,\n                                     .footer span,\n                                     .footer a {\n                                       color: #999999;\n                                       font-size: 12px;\n                                       text-align: center;\n                                     }\n                                     hr {\n                                       border: 0;\n                                       border-bottom: 1px solid #f6f6f6;\n                                       margin: 20px 0;\n                                     }\n                                   /* -------------------------------------\n                                     RESPONSIVE AND MOBILE FRIENDLY STYLES\n                                     ------------------------------------- */\n\n                                     @media only screen and (max-width: 620px) {\n                                       table[class=body] .content {\n                                         padding: 0 !important;\n                                       }\n                                       table[class=body] .container {\n                                         padding: 0 !important;\n                                         width: 100% !important;\n                                       }\n                                       table[class=body] .main {\n                                         border-left-width: 0 !important;\n                                         border-radius: 0 !important;\n                                         border-right-width: 0 !important;\n                                       }\n                                     }\n                                   </style>\n                                 </head>\n                                 <body class=\"\">\n                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\">\n                                    <tr>\n                                     <td>&nbsp;</td>\n                                     <td class=\"container\">\n                                      <div class=\"content\">\n                                        <!-- START CENTERED WHITE CONTAINER -->\n                                        <table class=\"main\">\n                                          <!-- START MAIN CONTENT AREA -->\n                                          <tr>\n                                           <td class=\"wrapper\">\n                                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n                                              <tr>\n                                               <td>', 1),
(180, 'show_pdf_signature_invoice', '1', 0),
(181, 'show_pdf_signature_estimate', '1', 0),
(182, 'signature_image', '', 0),
(183, 'scroll_responsive_tables', '0', 1),
(184, 'email_footer', '</td>\n                             </tr>\n                           </table>\n                         </td>\n                       </tr>\n                       <!-- END MAIN CONTENT AREA -->\n                     </table>\n                     <!-- START FOOTER -->\n                     <div class=\"footer\">\n                      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n                        <tr>\n                          <td class=\"content-block\">\n                            <span>{companyname}</span>\n                          </td>\n                        </tr>\n                      </table>\n                    </div>\n                    <!-- END FOOTER -->\n                    <!-- END CENTERED WHITE CONTAINER -->\n                  </div>\n                </td>\n                <td>&nbsp;</td>\n              </tr>\n            </table>\n            </body>\n            </html>', 1),
(185, 'exclude_proposal_from_client_area_with_draft_status', '1', 1),
(186, 'pusher_app_key', '', 1),
(187, 'pusher_app_secret', '', 1),
(188, 'pusher_app_id', '', 1),
(189, 'pusher_realtime_notifications', '0', 1),
(190, 'pdf_format_statement', 'A4-PORTRAIT', 1),
(191, 'pusher_cluster', '', 1),
(192, 'show_table_export_button', 'to_all', 1),
(193, 'allow_staff_view_proposals_assigned', '1', 1),
(194, 'show_cloudflare_notice', '1', 0),
(195, 'task_modal_class', 'modal-lg', 1),
(196, 'lead_modal_class', 'modal-lg', 1),
(197, 'show_timesheets_overview_all_members_notice_admins', '1', 0),
(198, 'desktop_notifications', '0', 1),
(199, 'hide_notified_reminders_from_calendar', '1', 0),
(200, 'customer_info_format', '{company_name}<br />\r\n{street}<br />\r\n{city} {state}<br />\r\n{country_code} {zip_code}', 0),
(201, 'timer_started_change_status_in_progress', '1', 0),
(202, 'default_ticket_reply_status', '3', 1),
(203, 'default_task_status', 'auto', 1),
(204, 'email_queue_skip_with_attachments', '1', 1),
(205, 'email_queue_enabled', '0', 1),
(206, 'last_email_queue_retry', '1568137470', 1),
(207, 'auto_dismiss_desktop_notifications_after', '0', 1),
(208, 'proposal_info_format', '{proposal_to}<br />\r\n{address}<br />\r\n{city} {state}<br />\r\n{country_code} {zip_code}<br />\r\n{phone}<br />\r\n{email}', 0),
(209, 'ticket_replies_order', 'asc', 1),
(210, 'new_recurring_invoice_action', 'generate_and_send', 0),
(211, 'bcc_emails', '', 0),
(212, 'email_templates_language_checks', 'a:74:{s:25:\"new-client-created-arabic\";i:1;s:29:\"invoice-send-to-client-arabic\";i:1;s:30:\"new-ticket-opened-admin-arabic\";i:1;s:19:\"ticket-reply-arabic\";i:1;s:26:\"ticket-autoresponse-arabic\";i:1;s:31:\"invoice-payment-recorded-arabic\";i:1;s:29:\"invoice-overdue-notice-arabic\";i:1;s:27:\"invoice-already-send-arabic\";i:1;s:31:\"new-ticket-created-staff-arabic\";i:1;s:30:\"estimate-send-to-client-arabic\";i:1;s:28:\"ticket-reply-to-admin-arabic\";i:1;s:28:\"estimate-already-send-arabic\";i:1;s:26:\"contract-expiration-arabic\";i:1;s:20:\"task-assigned-arabic\";i:1;s:29:\"task-added-as-follower-arabic\";i:1;s:21:\"task-commented-arabic\";i:1;s:28:\"task-added-attachment-arabic\";i:1;s:33:\"estimate-declined-to-staff-arabic\";i:1;s:33:\"estimate-accepted-to-staff-arabic\";i:1;s:31:\"proposal-client-accepted-arabic\";i:1;s:32:\"proposal-send-to-customer-arabic\";i:1;s:31:\"proposal-client-declined-arabic\";i:1;s:32:\"proposal-client-thank-you-arabic\";i:1;s:33:\"proposal-comment-to-client-arabic\";i:1;s:32:\"proposal-comment-to-admin-arabic\";i:1;s:37:\"estimate-thank-you-to-customer-arabic\";i:1;s:33:\"task-deadline-notification-arabic\";i:1;s:20:\"send-contract-arabic\";i:1;s:40:\"invoice-payment-recorded-to-staff-arabic\";i:1;s:24:\"auto-close-ticket-arabic\";i:1;s:46:\"new-project-discussion-created-to-staff-arabic\";i:1;s:49:\"new-project-discussion-created-to-customer-arabic\";i:1;s:44:\"new-project-file-uploaded-to-customer-arabic\";i:1;s:41:\"new-project-file-uploaded-to-staff-arabic\";i:1;s:49:\"new-project-discussion-comment-to-customer-arabic\";i:1;s:46:\"new-project-discussion-comment-to-staff-arabic\";i:1;s:36:\"staff-added-as-project-member-arabic\";i:1;s:31:\"estimate-expiry-reminder-arabic\";i:1;s:31:\"proposal-expiry-reminder-arabic\";i:1;s:24:\"new-staff-created-arabic\";i:1;s:30:\"contact-forgot-password-arabic\";i:1;s:31:\"contact-password-reseted-arabic\";i:1;s:27:\"contact-set-password-arabic\";i:1;s:28:\"staff-forgot-password-arabic\";i:1;s:29:\"staff-password-reseted-arabic\";i:1;s:26:\"assigned-to-project-arabic\";i:1;s:40:\"task-added-attachment-to-contacts-arabic\";i:1;s:33:\"task-commented-to-contacts-arabic\";i:1;s:24:\"new-lead-assigned-arabic\";i:1;s:23:\"client-statement-arabic\";i:1;s:31:\"ticket-assigned-to-admin-arabic\";i:1;s:37:\"new-client-registered-to-admin-arabic\";i:1;s:37:\"new-web-to-lead-form-submitted-arabic\";i:1;s:32:\"two-factor-authentication-arabic\";i:1;s:35:\"project-finished-to-customer-arabic\";i:1;s:33:\"credit-note-send-to-client-arabic\";i:1;s:34:\"task-status-change-to-staff-arabic\";i:1;s:37:\"task-status-change-to-contacts-arabic\";i:1;s:27:\"reminder-email-staff-arabic\";i:1;s:33:\"contract-comment-to-client-arabic\";i:1;s:32:\"contract-comment-to-admin-arabic\";i:1;s:24:\"send-subscription-arabic\";i:1;s:34:\"subscription-payment-failed-arabic\";i:1;s:28:\"subscription-canceled-arabic\";i:1;s:37:\"subscription-payment-succeeded-arabic\";i:1;s:35:\"contract-expiration-to-staff-arabic\";i:1;s:27:\"gdpr-removal-request-arabic\";i:1;s:32:\"gdpr-removal-request-lead-arabic\";i:1;s:36:\"client-registration-confirmed-arabic\";i:1;s:31:\"contract-signed-to-staff-arabic\";i:1;s:35:\"customer-subscribed-to-staff-arabic\";i:1;s:33:\"contact-verification-email-arabic\";i:1;s:50:\"new-customer-profile-file-uploaded-to-staff-arabic\";i:1;s:34:\"event-notification-to-staff-arabic\";i:1;}', 0),
(213, 'proposal_accept_identity_confirmation', '1', 0),
(214, 'estimate_accept_identity_confirmation', '1', 0),
(215, 'new_task_auto_follower_current_member', '0', 1),
(216, 'task_biillable_checked_on_creation', '1', 1),
(217, 'predefined_clientnote_credit_note', '', 1),
(218, 'predefined_terms_credit_note', '', 1),
(219, 'next_credit_note_number', '1', 1),
(220, 'credit_note_prefix', 'CN-', 1),
(221, 'credit_note_number_decrement_on_delete', '1', 1),
(222, 'pdf_format_credit_note', 'A4-PORTRAIT', 1),
(223, 'show_pdf_signature_credit_note', '1', 0),
(224, 'show_credit_note_reminders_on_calendar', '1', 1),
(225, 'show_amount_due_on_invoice', '1', 1),
(226, 'show_total_paid_on_invoice', '1', 1),
(227, 'show_credits_applied_on_invoice', '1', 1),
(228, 'staff_members_create_inline_lead_status', '1', 1),
(229, 'staff_members_create_inline_customer_groups', '1', 1),
(230, 'staff_members_create_inline_ticket_services', '1', 1),
(231, 'staff_members_save_tickets_predefined_replies', '1', 1),
(232, 'staff_members_create_inline_contract_types', '1', 1),
(233, 'staff_members_create_inline_expense_categories', '1', 1),
(234, 'show_project_on_credit_note', '1', 1),
(235, 'proposals_auto_operations_hour', '21', 1),
(236, 'estimates_auto_operations_hour', '21', 1),
(237, 'contracts_auto_operations_hour', '21', 1),
(238, 'credit_note_number_format', '1', 1),
(239, 'allow_non_admin_members_to_import_leads', '0', 1),
(240, 'e_sign_legal_text', 'By clicking on \"Sign\", I consent to be legally bound by this electronic representation of my signature.', 1),
(241, 'show_pdf_signature_contract', '1', 1),
(242, 'view_contract_only_logged_in', '0', 1),
(243, 'show_subscriptions_in_customers_area', '1', 1),
(244, 'calendar_only_assigned_tasks', '0', 1),
(245, 'after_subscription_payment_captured', 'send_invoice_and_receipt', 1),
(246, 'mail_engine', 'phpmailer', 1),
(247, 'gdpr_enable_terms_and_conditions', '0', 1),
(248, 'privacy_policy', '', 1),
(249, 'terms_and_conditions', '', 1),
(250, 'gdpr_enable_terms_and_conditions_lead_form', '0', 1),
(251, 'gdpr_enable_terms_and_conditions_ticket_form', '0', 1),
(252, 'gdpr_contact_enable_right_to_be_forgotten', '0', 1),
(253, 'show_gdpr_in_customers_menu', '1', 1),
(254, 'show_gdpr_link_in_footer', '1', 1),
(255, 'enable_gdpr', '0', 1),
(256, 'gdpr_on_forgotten_remove_invoices_credit_notes', '0', 1),
(257, 'gdpr_on_forgotten_remove_estimates', '0', 1),
(258, 'gdpr_enable_consent_for_contacts', '0', 1),
(259, 'gdpr_consent_public_page_top_block', '', 1),
(260, 'gdpr_page_top_information_block', '', 1),
(261, 'gdpr_enable_lead_public_form', '0', 1),
(262, 'gdpr_show_lead_custom_fields_on_public_form', '0', 1),
(263, 'gdpr_lead_attachments_on_public_form', '0', 1),
(264, 'gdpr_enable_consent_for_leads', '0', 1),
(265, 'gdpr_lead_enable_right_to_be_forgotten', '0', 1),
(266, 'allow_staff_view_invoices_assigned', '1', 1),
(267, 'gdpr_data_portability_leads', '0', 1),
(268, 'gdpr_lead_data_portability_allowed', '', 1),
(269, 'gdpr_contact_data_portability_allowed', '', 1),
(270, 'gdpr_data_portability_contacts', '0', 1),
(271, 'allow_staff_view_estimates_assigned', '1', 1),
(272, 'gdpr_after_lead_converted_delete', '0', 1),
(273, 'gdpr_show_terms_and_conditions_in_footer', '0', 1),
(274, 'save_last_order_for_tables', '0', 1),
(275, 'company_logo_dark', '', 1),
(276, 'customers_register_require_confirmation', '0', 1),
(277, 'allow_non_admin_staff_to_delete_ticket_attachments', '0', 1),
(278, 'receive_notification_on_new_ticket_replies', '1', 0),
(279, 'google_client_id', '', 1),
(280, 'enable_google_picker', '1', 1),
(281, 'show_ticket_reminders_on_calendar', '1', 1),
(282, 'ticket_import_reply_only', '0', 1),
(283, 'visible_customer_profile_tabs', 'all', 0),
(284, 'show_project_on_invoice', '1', 1),
(285, 'show_project_on_estimate', '1', 1),
(286, 'staff_members_create_inline_lead_source', '1', 1),
(287, 'upgraded_from_version', '', 0),
(288, 'lead_unique_validation', '[\"email\"]', 1),
(289, 'last_upgrade_copy_data', '', 1),
(290, 'sms_clickatell_api_key', '', 1),
(291, 'sms_clickatell_active', '0', 1),
(292, 'sms_clickatell_initialized', '1', 1),
(293, 'sms_msg91_sender_id', '', 1),
(294, 'sms_msg91_auth_key', '', 1),
(295, 'sms_msg91_active', '0', 1),
(296, 'sms_msg91_initialized', '1', 1),
(297, 'sms_twilio_account_sid', '', 1),
(298, 'sms_twilio_auth_token', '', 1),
(299, 'sms_twilio_phone_number', '', 1),
(300, 'sms_twilio_active', '0', 1),
(301, 'sms_twilio_initialized', '1', 1),
(302, 'aside_menu_active', '[]', 1),
(303, 'setup_menu_active', '[]', 1),
(304, 'paymentmethod_authorize_aim_active', '0', 1),
(305, 'paymentmethod_authorize_aim_label', 'Authorize.net AIM', 1),
(306, 'paymentmethod_authorize_aim_api_login_id', '', 0),
(307, 'paymentmethod_authorize_aim_api_transaction_key', '', 0),
(308, 'paymentmethod_authorize_aim_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(309, 'paymentmethod_authorize_aim_currencies', 'USD', 0),
(310, 'paymentmethod_authorize_aim_test_mode_enabled', '0', 0),
(311, 'paymentmethod_authorize_aim_developer_mode_enabled', '1', 0),
(312, 'paymentmethod_authorize_aim_default_selected', '1', 1),
(313, 'paymentmethod_authorize_aim_initialized', '1', 1),
(314, 'paymentmethod_authorize_sim_active', '0', 1),
(315, 'paymentmethod_authorize_sim_label', 'Authorize.net SIM', 1),
(316, 'paymentmethod_authorize_sim_api_login_id', '', 0),
(317, 'paymentmethod_authorize_sim_api_transaction_key', '', 0),
(318, 'paymentmethod_authorize_sim_api_secret_key', '', 0),
(319, 'paymentmethod_authorize_sim_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(320, 'paymentmethod_authorize_sim_currencies', 'USD', 0),
(321, 'paymentmethod_authorize_sim_test_mode_enabled', '0', 0),
(322, 'paymentmethod_authorize_sim_developer_mode_enabled', '1', 0),
(323, 'paymentmethod_authorize_sim_default_selected', '1', 1),
(324, 'paymentmethod_authorize_sim_initialized', '1', 1),
(325, 'paymentmethod_instamojo_active', '0', 1),
(326, 'paymentmethod_instamojo_label', 'Instamojo', 1),
(327, 'paymentmethod_instamojo_api_key', '', 0),
(328, 'paymentmethod_instamojo_auth_token', '', 0),
(329, 'paymentmethod_instamojo_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(330, 'paymentmethod_instamojo_currencies', 'INR', 0),
(331, 'paymentmethod_instamojo_test_mode_enabled', '1', 0),
(332, 'paymentmethod_instamojo_default_selected', '1', 1),
(333, 'paymentmethod_instamojo_initialized', '1', 1),
(334, 'paymentmethod_mollie_active', '0', 1),
(335, 'paymentmethod_mollie_label', 'Mollie', 1),
(336, 'paymentmethod_mollie_api_key', '', 0),
(337, 'paymentmethod_mollie_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(338, 'paymentmethod_mollie_currencies', 'EUR', 0),
(339, 'paymentmethod_mollie_test_mode_enabled', '1', 0),
(340, 'paymentmethod_mollie_default_selected', '1', 1),
(341, 'paymentmethod_mollie_initialized', '1', 1),
(342, 'paymentmethod_paypal_braintree_active', '0', 1),
(343, 'paymentmethod_paypal_braintree_label', 'Braintree', 1),
(344, 'paymentmethod_paypal_braintree_merchant_id', '', 0),
(345, 'paymentmethod_paypal_braintree_api_public_key', '', 0),
(346, 'paymentmethod_paypal_braintree_api_private_key', '', 0),
(347, 'paymentmethod_paypal_braintree_currencies', 'USD', 0),
(348, 'paymentmethod_paypal_braintree_paypal_enabled', '1', 0),
(349, 'paymentmethod_paypal_braintree_test_mode_enabled', '1', 0),
(350, 'paymentmethod_paypal_braintree_default_selected', '1', 1),
(351, 'paymentmethod_paypal_braintree_initialized', '1', 1),
(352, 'paymentmethod_paypal_checkout_active', '0', 1),
(353, 'paymentmethod_paypal_checkout_label', 'Paypal Smart Checkout', 1),
(354, 'paymentmethod_paypal_checkout_client_id', '', 0),
(355, 'paymentmethod_paypal_checkout_secret', '', 0),
(356, 'paymentmethod_paypal_checkout_payment_description', 'Payment for Invoice {invoice_number}', 0),
(357, 'paymentmethod_paypal_checkout_currencies', 'USD,CAD,EUR', 0),
(358, 'paymentmethod_paypal_checkout_test_mode_enabled', '1', 0),
(359, 'paymentmethod_paypal_checkout_default_selected', '1', 1),
(360, 'paymentmethod_paypal_checkout_initialized', '1', 1),
(361, 'paymentmethod_paypal_active', '0', 1),
(362, 'paymentmethod_paypal_label', 'Paypal', 1),
(363, 'paymentmethod_paypal_username', '', 0),
(364, 'paymentmethod_paypal_password', '', 0),
(365, 'paymentmethod_paypal_signature', '', 0),
(366, 'paymentmethod_paypal_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(367, 'paymentmethod_paypal_currencies', 'EUR,USD', 0),
(368, 'paymentmethod_paypal_test_mode_enabled', '1', 0),
(369, 'paymentmethod_paypal_default_selected', '1', 1),
(370, 'paymentmethod_paypal_initialized', '1', 1),
(371, 'paymentmethod_payu_money_active', '0', 1),
(372, 'paymentmethod_payu_money_label', 'PayU Money', 1),
(373, 'paymentmethod_payu_money_key', '', 0),
(374, 'paymentmethod_payu_money_salt', '', 0),
(375, 'paymentmethod_payu_money_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(376, 'paymentmethod_payu_money_currencies', 'INR', 0),
(377, 'paymentmethod_payu_money_test_mode_enabled', '1', 0),
(378, 'paymentmethod_payu_money_default_selected', '1', 1),
(379, 'paymentmethod_payu_money_initialized', '1', 1),
(380, 'paymentmethod_stripe_active', '0', 1),
(381, 'paymentmethod_stripe_label', 'Stripe Checkout', 1),
(382, 'paymentmethod_stripe_api_secret_key', '', 0),
(383, 'paymentmethod_stripe_api_publishable_key', '', 0),
(384, 'paymentmethod_stripe_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(385, 'paymentmethod_stripe_webhook_key', 'c7e1e018ba178eaf64dffd46d99cd417', 0),
(386, 'paymentmethod_stripe_currencies', 'USD,CAD', 0),
(387, 'paymentmethod_stripe_allow_primary_contact_to_update_credit_card', '1', 0),
(388, 'paymentmethod_stripe_test_mode_enabled', '1', 0),
(389, 'paymentmethod_stripe_default_selected', '1', 1),
(390, 'paymentmethod_stripe_initialized', '1', 1),
(391, 'paymentmethod_stripe_ideal_active', '0', 1),
(392, 'paymentmethod_stripe_ideal_label', 'Stripe iDEAL', 1),
(393, 'paymentmethod_stripe_ideal_api_secret_key', '', 0),
(394, 'paymentmethod_stripe_ideal_api_publishable_key', '', 0),
(395, 'paymentmethod_stripe_ideal_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(396, 'paymentmethod_stripe_ideal_statement_descriptor', 'Payment for Invoice {invoice_number}', 0),
(397, 'paymentmethod_stripe_ideal_webhook_key', '3ea02397aecacf1fa3adb74c7ff60ff2', 0),
(398, 'paymentmethod_stripe_ideal_currencies', 'EUR', 0),
(399, 'paymentmethod_stripe_ideal_test_mode_enabled', '1', 0),
(400, 'paymentmethod_stripe_ideal_default_selected', '1', 1),
(401, 'paymentmethod_stripe_ideal_initialized', '1', 1),
(402, 'paymentmethod_two_checkout_active', '0', 1),
(403, 'paymentmethod_two_checkout_label', '2Checkout', 1),
(404, 'paymentmethod_two_checkout_account_number', '', 0),
(405, 'paymentmethod_two_checkout_private_key', '', 0),
(406, 'paymentmethod_two_checkout_publishable_key', '', 0),
(407, 'paymentmethod_two_checkout_currencies', 'USD,EUR', 0),
(408, 'paymentmethod_two_checkout_test_mode_enabled', '1', 0),
(409, 'paymentmethod_two_checkout_default_selected', '1', 1),
(410, 'paymentmethod_two_checkout_initialized', '1', 1),
(411, 'sms_trigger_invoice_overdue_notice', '', 0),
(412, 'sms_trigger_invoice_payment_recorded', '', 0),
(413, 'sms_trigger_estimate_expiration_reminder', '', 0),
(414, 'sms_trigger_proposal_expiration_reminder', '', 0),
(415, 'sms_trigger_proposal_new_comment_to_customer', '', 0),
(416, 'sms_trigger_proposal_new_comment_to_staff', '', 0),
(417, 'sms_trigger_contract_new_comment_to_customer', '', 0),
(418, 'sms_trigger_contract_new_comment_to_staff', '', 0),
(419, 'sms_trigger_contract_expiration_reminder', '', 0),
(420, 'sms_trigger_staff_reminder', '', 0),
(424, 'isHijri', 'on', 1),
(425, 'hijri_format', 'Y-m-d|%Y-%m-%d|hijri', 1),
(426, 'hijri_pages', '[\"Case\"]', 1),
(427, 'adjust_data', '[]', 1),
(428, 'automatically_reminders_before_empty_recycle_bin_days', '1', 1),
(429, 'automatically_empty_recycle_bin_after_days', '1', 1),
(430, 'procurations_reminder_notification_before', '1', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tbloservicediscussioncomments`
--

CREATE TABLE `tbloservicediscussioncomments` (
  `id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `discussion_type` varchar(10) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT 0,
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbloservicediscussions`
--

CREATE TABLE `tbloservicediscussions` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbloservice_activity`
--

CREATE TABLE `tbloservice_activity` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `fullname` varchar(100) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT 0,
  `description_key` varchar(191) NOT NULL COMMENT 'Language file key',
  `additional_data` text DEFAULT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbloservice_activity`
--

INSERT INTO `tbloservice_activity` (`id`, `oservice_id`, `staff_id`, `contact_id`, `fullname`, `visible_to_customer`, `description_key`, `additional_data`, `dateadded`) VALUES
(1, 7, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:29:59'),
(2, 7, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:29:59'),
(3, 7, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:30:04'),
(4, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:41:16'),
(5, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:41:16'),
(6, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:41:21'),
(7, 12, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:43:13'),
(8, 12, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:43:13'),
(9, 15, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:47:16'),
(10, 15, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:47:16'),
(11, 15, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:47:21'),
(12, 17, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:48:50'),
(13, 17, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:48:51'),
(14, 17, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:48:56'),
(15, 18, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:49:10'),
(16, 18, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:49:10'),
(17, 18, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:49:15'),
(18, 19, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:49:58'),
(19, 19, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:49:58'),
(20, 20, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:51:11'),
(21, 20, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:51:11'),
(22, 20, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:51:16'),
(23, 21, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:51:24'),
(24, 21, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:51:24'),
(25, 22, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:52:40'),
(26, 22, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:52:40'),
(27, 23, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:53:06'),
(28, 23, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:53:06'),
(29, 24, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 03:54:31'),
(30, 24, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 03:54:31'),
(31, 24, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 03:54:36'),
(47, 6, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:02:36'),
(48, 6, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:02:36'),
(49, 6, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:02:41'),
(50, 7, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:03:15'),
(51, 7, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:03:15'),
(52, 7, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:03:20'),
(53, 8, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:03:41'),
(54, 8, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:03:41'),
(55, 8, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:03:47'),
(56, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:03:50'),
(57, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:03:50'),
(58, 9, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:03:55'),
(62, 10, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:06:54'),
(63, 10, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:06:54'),
(64, 10, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:06:59'),
(65, 11, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:08:34'),
(66, 11, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:08:34'),
(67, 11, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:08:34'),
(166, 6, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-08-18 18:53:53'),
(167, 6, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-18 18:53:54'),
(168, 7, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-08-18 19:07:36'),
(169, 7, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-18 19:07:37'),
(178, 5, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-09-01 17:43:17'),
(179, 5, 1, 0, 'Mhdbashar Das', 1, 'LService_activity_updated', '', '2019-09-01 17:43:17'),
(180, 6, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-09-03 18:47:46'),
(181, 6, 1, 0, 'Mhdbashar Das', 1, 'LService_activity_updated', '', '2019-09-03 18:47:47'),
(182, 5, 1, 0, 'Mhdbashar Das', 1, 'LService_activity_updated', '', '2019-09-04 17:39:59');

-- --------------------------------------------------------

--
-- بنية الجدول `tbloservice_files`
--

CREATE TABLE `tbloservice_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `oservice_id` int(11) NOT NULL,
  `visible_to_customer` tinyint(1) DEFAULT 0,
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `external` varchar(40) DEFAULT NULL,
  `external_link` text DEFAULT NULL,
  `thumbnail_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbloservice_notes`
--

CREATE TABLE `tbloservice_notes` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbloservice_settings`
--

CREATE TABLE `tbloservice_settings` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbloservice_settings`
--

INSERT INTO `tbloservice_settings` (`id`, `oservice_id`, `name`, `value`) VALUES
(1, 5, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:15:\"OserviceSession\";i:1;}'),
(2, 5, 'view_tasks', '1'),
(3, 5, 'create_tasks', '1'),
(4, 5, 'edit_tasks', '1'),
(5, 5, 'comment_on_tasks', '1'),
(6, 5, 'view_task_comments', '1'),
(7, 5, 'view_task_attachments', '1'),
(8, 5, 'view_task_checklist_items', '1'),
(9, 5, 'upload_on_tasks', '1'),
(10, 5, 'view_task_total_logged_time', '1'),
(11, 5, 'view_finance_overview', '1'),
(12, 5, 'upload_files', '1'),
(13, 5, 'open_discussions', '1'),
(14, 5, 'view_milestones', '1'),
(15, 5, 'view_gantt', '1'),
(16, 5, 'view_timesheets', '1'),
(17, 5, 'view_activity_log', '1'),
(18, 5, 'view_team_members', '1'),
(19, 5, 'hide_tasks_on_main_tasks_table', '1');

-- --------------------------------------------------------

--
-- بنية الجدول `tblpayment_modes`
--

CREATE TABLE `tblpayment_modes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `show_on_pdf` int(11) NOT NULL DEFAULT 0,
  `invoices_only` int(11) NOT NULL DEFAULT 0,
  `expenses_only` int(11) NOT NULL DEFAULT 0,
  `selected_by_default` int(11) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblpayment_modes`
--

INSERT INTO `tblpayment_modes` (`id`, `name`, `description`, `show_on_pdf`, `invoices_only`, `expenses_only`, `selected_by_default`, `active`) VALUES
(1, 'Bank', NULL, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tblpinned_cases`
--

CREATE TABLE `tblpinned_cases` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblpinned_oservices`
--

CREATE TABLE `tblpinned_oservices` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblpinned_projects`
--

CREATE TABLE `tblpinned_projects` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblprocurations`
--

CREATE TABLE `tblprocurations` (
  `id` int(11) NOT NULL,
  `NO` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `come_from` varchar(255) NOT NULL,
  `folder_no` varchar(255) NOT NULL,
  `file_doc` varchar(255) NOT NULL,
  `recurring_from` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `not_visible_to_client` tinyint(1) NOT NULL DEFAULT 0,
  `addedfrom` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblprocuration_cases`
--

CREATE TABLE `tblprocuration_cases` (
  `id` int(11) NOT NULL,
  `procuration` int(11) NOT NULL,
  `_case` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `tblprocuration_cases`
--

INSERT INTO `tblprocuration_cases` (`id`, `procuration`, `_case`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- بنية الجدول `tblprojectdiscussioncomments`
--

CREATE TABLE `tblprojectdiscussioncomments` (
  `id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `discussion_type` varchar(10) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT 0,
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblprojectdiscussions`
--

CREATE TABLE `tblprojectdiscussions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblprojects`
--

CREATE TABLE `tblprojects` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `clientid` int(11) NOT NULL,
  `billing_type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `project_created` date NOT NULL,
  `date_finished` datetime DEFAULT NULL,
  `progress` int(11) DEFAULT 0,
  `progress_from_tasks` int(11) NOT NULL DEFAULT 1,
  `project_cost` decimal(15,2) DEFAULT NULL,
  `project_rate_per_hour` decimal(15,2) DEFAULT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `project_type` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblprojects`
--

INSERT INTO `tblprojects` (`id`, `name`, `description`, `status`, `clientid`, `billing_type`, `start_date`, `deadline`, `project_created`, `date_finished`, `progress`, `progress_from_tasks`, `project_cost`, `project_rate_per_hour`, `estimated_hours`, `addedfrom`, `branch_id`, `project_type`) VALUES
(4, 'test', '', 2, 3, 1, '2019-08-22', NULL, '2019-08-22', NULL, 100, 1, '10.00', '0.00', '0.00', 1, 0, 0),
(5, 'نزاع مالي 1', '', 3, 3, 1, '2019-08-24', NULL, '2019-08-24', NULL, 0, 0, '0.00', '0.00', '0.00', 1, 0, 1),
(6, 'tt', '', 2, 3, 1, '2019-09-12', '2019-09-13', '2019-09-12', NULL, 0, 0, '5000.00', '0.00', NULL, 1, 0, 1),
(7, 'tt', '', 2, 3, 1, '2019-09-15', NULL, '2019-09-15', NULL, 100, 1, '0.00', '0.00', '0.00', 1, 0, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tblproject_activity`
--

CREATE TABLE `tblproject_activity` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `fullname` varchar(100) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT 0,
  `description_key` varchar(191) NOT NULL COMMENT 'Language file key',
  `additional_data` text DEFAULT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblproject_activity`
--

INSERT INTO `tblproject_activity` (`id`, `project_id`, `staff_id`, `contact_id`, `fullname`, `visible_to_customer`, `description_key`, `additional_data`, `dateadded`) VALUES
(1, 1, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-07-30 18:11:59'),
(2, 1, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-07-30 18:12:01'),
(3, 2, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-07-31 21:17:45'),
(4, 2, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-07-31 21:17:46'),
(8, 4, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-08-22 18:09:02'),
(9, 4, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-22 18:09:03'),
(10, 5, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-08-24 12:06:54'),
(11, 5, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-08-24 12:06:57'),
(12, 4, 1, 0, 'Mhdbashar Das', 1, 'project_activity_updated', '', '2019-08-26 21:02:08'),
(13, 5, 1, 0, 'Mhdbashar Das', 0, 'project_activity_uploaded_file', '15607969259684dd18b.txt', '2019-09-01 13:40:12'),
(14, 5, 1, 0, 'Mhdbashar Das', 1, 'project_activity_marked_all_tasks_as_complete', '', '2019-09-03 18:50:31'),
(15, 5, 1, 0, 'Mhdbashar Das', 1, 'project_activity_updated', '', '2019-09-03 18:50:31'),
(16, 5, 1, 0, 'Mhdbashar Das', 1, 'project_status_updated', '<b><lang>project_status_3</lang></b>', '2019-09-03 18:50:32'),
(17, 5, 1, 0, 'Mhdbashar Das', 1, 'project_activity_task_deleted', 'test', '2019-09-03 20:55:41'),
(18, 6, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-09-12 19:22:13'),
(19, 6, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-09-12 19:22:28'),
(20, 7, 1, 0, 'Mhdbashar Das', 1, 'project_activity_added_team_member', 'Mhdbashar Das', '2019-09-15 20:21:25'),
(21, 7, 1, 0, 'Mhdbashar Das', 1, 'project_activity_created', '', '2019-09-15 20:21:25'),
(22, 7, 1, 0, 'Mhdbashar Das', 1, 'project_activity_updated', '', '2019-09-15 20:26:33');

-- --------------------------------------------------------

--
-- بنية الجدول `tblproject_files`
--

CREATE TABLE `tblproject_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `visible_to_customer` tinyint(1) DEFAULT 0,
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `external` varchar(40) DEFAULT NULL,
  `external_link` text DEFAULT NULL,
  `thumbnail_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblproject_files`
--

INSERT INTO `tblproject_files` (`id`, `file_name`, `subject`, `description`, `filetype`, `dateadded`, `last_activity`, `project_id`, `visible_to_customer`, `staffid`, `contact_id`, `external`, `external_link`, `thumbnail_link`) VALUES
(1, '15607969259684dd18b.txt', '15607969259684dd18b.txt', NULL, 'text/plain', '2019-09-01 13:40:12', NULL, 5, 0, 1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `tblproject_members`
--

CREATE TABLE `tblproject_members` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblproject_members`
--

INSERT INTO `tblproject_members` (`id`, `project_id`, `staff_id`) VALUES
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `tblproject_notes`
--

CREATE TABLE `tblproject_notes` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblproject_settings`
--

CREATE TABLE `tblproject_settings` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblproject_settings`
--

INSERT INTO `tblproject_settings` (`id`, `project_id`, `name`, `value`) VALUES
(1, 1, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(2, 1, 'view_tasks', '1'),
(3, 1, 'create_tasks', '1'),
(4, 1, 'edit_tasks', '1'),
(5, 1, 'comment_on_tasks', '1'),
(6, 1, 'view_task_comments', '1'),
(7, 1, 'view_task_attachments', '1'),
(8, 1, 'view_task_checklist_items', '1'),
(9, 1, 'upload_on_tasks', '1'),
(10, 1, 'view_task_total_logged_time', '1'),
(11, 1, 'view_finance_overview', '1'),
(12, 1, 'upload_files', '1'),
(13, 1, 'open_discussions', '1'),
(14, 1, 'view_milestones', '1'),
(15, 1, 'view_gantt', '1'),
(16, 1, 'view_timesheets', '1'),
(17, 1, 'view_activity_log', '1'),
(18, 1, 'view_team_members', '1'),
(19, 1, 'hide_tasks_on_main_tasks_table', '0'),
(20, 2, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(21, 2, 'view_tasks', '1'),
(22, 2, 'create_tasks', '1'),
(23, 2, 'edit_tasks', '1'),
(24, 2, 'comment_on_tasks', '1'),
(25, 2, 'view_task_comments', '1'),
(26, 2, 'view_task_attachments', '1'),
(27, 2, 'view_task_checklist_items', '1'),
(28, 2, 'upload_on_tasks', '1'),
(29, 2, 'view_task_total_logged_time', '1'),
(30, 2, 'view_finance_overview', '1'),
(31, 2, 'upload_files', '1'),
(32, 2, 'open_discussions', '1'),
(33, 2, 'view_milestones', '1'),
(34, 2, 'view_gantt', '1'),
(35, 2, 'view_timesheets', '1'),
(36, 2, 'view_activity_log', '1'),
(37, 2, 'view_team_members', '1'),
(38, 2, 'hide_tasks_on_main_tasks_table', '0'),
(58, 4, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(59, 4, 'view_tasks', '1'),
(60, 4, 'create_tasks', '1'),
(61, 4, 'edit_tasks', '1'),
(62, 4, 'comment_on_tasks', '1'),
(63, 4, 'view_task_comments', '1'),
(64, 4, 'view_task_attachments', '1'),
(65, 4, 'view_task_checklist_items', '1'),
(66, 4, 'upload_on_tasks', '1'),
(67, 4, 'view_task_total_logged_time', '1'),
(68, 4, 'view_finance_overview', '1'),
(69, 4, 'upload_files', '1'),
(70, 4, 'open_discussions', '1'),
(71, 4, 'view_milestones', '1'),
(72, 4, 'view_gantt', '1'),
(73, 4, 'view_timesheets', '1'),
(74, 4, 'view_activity_log', '1'),
(75, 4, 'view_team_members', '1'),
(76, 4, 'hide_tasks_on_main_tasks_table', '0'),
(77, 5, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(78, 5, 'view_tasks', '1'),
(79, 5, 'create_tasks', '1'),
(80, 5, 'edit_tasks', '1'),
(81, 5, 'comment_on_tasks', '1'),
(82, 5, 'view_task_comments', '1'),
(83, 5, 'view_task_attachments', '1'),
(84, 5, 'view_task_checklist_items', '1'),
(85, 5, 'upload_on_tasks', '1'),
(86, 5, 'view_task_total_logged_time', '1'),
(87, 5, 'view_finance_overview', '1'),
(88, 5, 'upload_files', '1'),
(89, 5, 'open_discussions', '1'),
(90, 5, 'view_milestones', '1'),
(91, 5, 'view_gantt', '1'),
(92, 5, 'view_timesheets', '1'),
(93, 5, 'view_activity_log', '1'),
(94, 5, 'view_team_members', '1'),
(95, 5, 'hide_tasks_on_main_tasks_table', '0'),
(96, 6, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:17:\"disputes_invoices\";i:0;}'),
(97, 6, 'view_tasks', '1'),
(98, 6, 'create_tasks', '1'),
(99, 6, 'edit_tasks', '1'),
(100, 6, 'comment_on_tasks', '1'),
(101, 6, 'view_task_comments', '1'),
(102, 6, 'view_task_attachments', '1'),
(103, 6, 'view_task_checklist_items', '1'),
(104, 6, 'upload_on_tasks', '1'),
(105, 6, 'view_task_total_logged_time', '1'),
(106, 6, 'view_finance_overview', '1'),
(107, 6, 'upload_files', '1'),
(108, 6, 'open_discussions', '1'),
(109, 6, 'view_milestones', '1'),
(110, 6, 'view_gantt', '1'),
(111, 6, 'view_timesheets', '1'),
(112, 6, 'view_activity_log', '1'),
(113, 6, 'view_team_members', '1'),
(114, 6, 'hide_tasks_on_main_tasks_table', '0'),
(115, 7, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(116, 7, 'view_tasks', '1'),
(117, 7, 'create_tasks', '1'),
(118, 7, 'edit_tasks', '1'),
(119, 7, 'comment_on_tasks', '1'),
(120, 7, 'view_task_comments', '1'),
(121, 7, 'view_task_attachments', '1'),
(122, 7, 'view_task_checklist_items', '1'),
(123, 7, 'upload_on_tasks', '1'),
(124, 7, 'view_task_total_logged_time', '1'),
(125, 7, 'view_finance_overview', '1'),
(126, 7, 'upload_files', '1'),
(127, 7, 'open_discussions', '1'),
(128, 7, 'view_milestones', '1'),
(129, 7, 'view_gantt', '1'),
(130, 7, 'view_timesheets', '1'),
(131, 7, 'view_activity_log', '1'),
(132, 7, 'view_team_members', '1'),
(133, 7, 'hide_tasks_on_main_tasks_table', '0');

-- --------------------------------------------------------

--
-- بنية الجدول `tblproposals`
--

CREATE TABLE `tblproposals` (
  `id` int(11) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `discount_percent` decimal(15,2) NOT NULL,
  `discount_total` decimal(15,2) NOT NULL,
  `discount_type` varchar(30) DEFAULT NULL,
  `show_quantity_as` int(11) NOT NULL DEFAULT 1,
  `currency` int(11) NOT NULL,
  `open_till` date DEFAULT NULL,
  `date` date NOT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(40) DEFAULT NULL,
  `assigned` int(11) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `proposal_to` varchar(191) DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT 0,
  `zip` varchar(50) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL,
  `estimate_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `date_converted` datetime DEFAULT NULL,
  `pipeline_order` int(11) NOT NULL DEFAULT 0,
  `is_expiry_notified` int(11) NOT NULL DEFAULT 0,
  `acceptance_firstname` varchar(50) DEFAULT NULL,
  `acceptance_lastname` varchar(50) DEFAULT NULL,
  `acceptance_email` varchar(100) DEFAULT NULL,
  `acceptance_date` datetime DEFAULT NULL,
  `acceptance_ip` varchar(40) DEFAULT NULL,
  `signature` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblproposals`
--

INSERT INTO `tblproposals` (`id`, `subject`, `content`, `addedfrom`, `datecreated`, `total`, `subtotal`, `total_tax`, `adjustment`, `discount_percent`, `discount_total`, `discount_type`, `show_quantity_as`, `currency`, `open_till`, `date`, `rel_id`, `rel_type`, `assigned`, `hash`, `proposal_to`, `country`, `zip`, `state`, `city`, `address`, `email`, `phone`, `allow_comments`, `status`, `estimate_id`, `invoice_id`, `date_converted`, `pipeline_order`, `is_expiry_notified`, `acceptance_firstname`, `acceptance_lastname`, `acceptance_email`, `acceptance_date`, `acceptance_ip`, `signature`) VALUES
(1, 'test', '{proposal_items}', 1, '2019-08-26 21:10:38', '10.00', '10.00', '0.00', '0.00', '0.00', '0.00', '', 1, 1, '2019-09-02', '2019-08-26', 3, 'customer', 1, 'a5eb1af4a0f1064ceccff49756c07181', 'Al-Muslat Company', 194, '', '', 'yanbu', '', 'test@test.com', '', 1, 1, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `tblproposal_comments`
--

CREATE TABLE `tblproposal_comments` (
  `id` int(11) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `proposalid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblrelated_items`
--

CREATE TABLE `tblrelated_items` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(30) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblreminders`
--

CREATE TABLE `tblreminders` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `isnotified` int(11) NOT NULL DEFAULT 0,
  `rel_id` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `rel_type` varchar(40) NOT NULL,
  `notify_by_email` int(11) NOT NULL DEFAULT 1,
  `creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblroles`
--

CREATE TABLE `tblroles` (
  `roleid` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `permissions` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblroles`
--

INSERT INTO `tblroles` (`roleid`, `name`, `permissions`) VALUES
(1, 'Employee', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `tblsales_activity`
--

CREATE TABLE `tblsales_activity` (
  `id` int(11) NOT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `rel_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `additional_data` text DEFAULT NULL,
  `staffid` varchar(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblsales_activity`
--

INSERT INTO `tblsales_activity` (`id`, `rel_type`, `rel_id`, `description`, `additional_data`, `staffid`, `full_name`, `date`) VALUES
(1, 'invoice', 2, 'invoice_activity_status_updated', 'a:2:{i:0;s:36:\"<original_status>1</original_status>\";i:1;s:26:\"<new_status>2</new_status>\";}', '1', 'Mhdbashar Das', '2019-07-31 21:19:08'),
(2, 'invoice', 2, 'invoice_activity_created', '', '1', 'Mhdbashar Das', '2019-07-31 21:19:09'),
(3, 'invoice', 1, 'invoice_estimate_activity_added_item', 'a:1:{i:0;s:4:\"test\";}', '1', 'Mhdbashar Das', '2019-08-01 14:33:30'),
(4, 'invoice', 1, 'invoice_activity_status_updated', 'a:2:{i:0;s:36:\"<original_status>1</original_status>\";i:1;s:26:\"<new_status>4</new_status>\";}', '1', 'Mhdbashar Das', '2019-08-01 14:33:30'),
(5, 'invoice', 1, 'invoice_activity_status_updated', 'a:2:{i:0;s:36:\"<original_status>4</original_status>\";i:1;s:26:\"<new_status>2</new_status>\";}', '1', 'Mhdbashar Das', '2019-08-26 21:06:17'),
(6, 'invoice', 1, 'invoice_activity_payment_made_by_staff', 'a:2:{i:0;s:6:\"$10.00\";i:1;s:84:\"<a href=\"http://localhost/legalserv/admin/payments/payment/1\" target=\"_blank\">#1</a>\";}', '1', 'Mhdbashar Das', '2019-08-26 21:06:17');

-- --------------------------------------------------------

--
-- بنية الجدول `tblservices`
--

CREATE TABLE `tblservices` (
  `serviceid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblsessions`
--

CREATE TABLE `tblsessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblsessions`
--

INSERT INTO `tblsessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('015mlt7heg92svpmm8vv50b2i0grrrvi', '::1', 1568906152, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383930363135323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('024idsdes9fcdt3l89r1le4q5lbk7qql', '::1', 1567345548, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334353333333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b6f66667365747c733a313a2231223b5f5f63695f766172737c613a313a7b733a363a226f6666736574223b733a333a226f6c64223b7d),
('09une47dgcm2edgkjvvqbtjs7up4mpdd', '::1', 1568713986, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383731333938323b7265645f75726c7c733a33323a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f61646d696e223b),
('0acj4vk0hvrrr2ve67gicinpoice29ut', '::1', 1569612486, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631323438363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('0bp6ic1u73c3lvc8trpfprs9fu9cmqq6', '::1', 1568905010, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383930353031303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('0dvg3nloufhl4r077269sl9vb9dbdj64', '::1', 1569794721, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739343732313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('0mepmf8emmdk3dgeceqgnegn11rr9eqq', '::1', 1568718306, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383731383330363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('0pmc20llhdfkraan1shpqt5akis8f63u', '::1', 1567339264, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333343337333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('0r34bkaqgn3orudlg1hvnimajsvoj9kg', '::1', 1568650548, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635303534383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('1g1nmstu62hqtj47ho2lbccsflu650ou', '::1', 1569861645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836313634353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('1g26o5u011fid34nve86239tk6ie2dk8', '::1', 1569792728, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739323732383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('1hllr24p8v7202vfut9l1gukmkhjutc3', '::1', 1568732275, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733323237353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('1n6rbi78tdi1t03angapqg3v4b05d8so', '::1', 1569863168, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836333136383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('1oh21tvtl5ibd2p555rorklqeqofeakd', '::1', 1567241442, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234313434313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('1s5uf282qaoh1s6qv5edffhgcv40meev', '::1', 1567527532, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532373134383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('1up5ula47noggvtrem7budgoadaikbao', '::1', 1567104456, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130343139353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7461736b735f6b616e62616e5f766965777c733a343a2274727565223b),
('2888d0eiath2potgotpt0j5i9f1afg10', '::1', 1568668109, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383636383031383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('29dhupcsp0acfr6hgq30k010ojprb9au', '::1', 1568910950, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383931303935303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('2blen3iida8susgfqlhh0fv9lj9kkoru', '::1', 1567521662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532313631393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('2p8sfk81ff2buotjl0r7h8chg020ocd2', '::1', 1568733203, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733333230333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('2s72k7rof7iepq8avt7tdt9f49lt8kok', '::1', 1569616106, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631363130363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('2slkh0i58l7qv6bcr4m9kfokkdhj8e1j', '::1', 1569613594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631333539343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('2u2iqcgr9fltrii4hu3lorm83ehtrf9c', '::1', 1567603060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630323539393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('386vnragojj17lqcpqnqhm8ef6cvu53p', '::1', 1569860440, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836303434303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('3c2qta2n8ru1plke84n3j5s4smroali6', '::1', 1567332909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333323634323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('3cr2mj3eqb80k07pksm1no7tjmp9qh1p', '::1', 1569863811, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836333831313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('3d2fr9sa4ak89kivvccd5mqvaivb93bj', '::1', 1567861146, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373836313035333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('3hmjngehrp0qel26hdt5hldlsaff6eus', '::1', 1568197436, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139373433363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('3hsr8ogfb1lltjdpokofbnfn9hl6rfr6', '::1', 1568651944, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635313934343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('3jgl4ro6hrq16msj9feakqa0vhe8uk52', '::1', 1568133279, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383133333233373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('3r0dmur1f84g87cgfmpv5cn8dhd4kauh', '::1', 1568650228, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635303232383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('4f1jnmmnd53oml28a87oks2qlthd12sa', '::1', 1569796583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739363538333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('4huqln6l966o2snbih57t676l3gb21if', '::1', 1567246565, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234363536353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('4rt5l1g0oo20smsc3rchl48gcc1sj4jb', '::1', 1568204928, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383230343932383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('5491df8rfflj8e7lb9kadhltjr28rmkn', '::1', 1568911300, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383931313330303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('5bgo03co5rmq67ddfc47bv8djspcdh0j', '::1', 1569687268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393638373236383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5dcor2je25ljt236ruhugfo55bea8hfp', '::1', 1568721229, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383732313232393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('5dqhvn1gfegvhp3a5vp2f2hh2dssrram', '::1', 1567339879, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393837353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('5dukneuofqddat79lp1jth2q99vn3007', '::1', 1568910607, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383931303630373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('5j2tovb0c9bn49nhklbmurqggnemqueh', '::1', 1567700090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373730303032303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('5jrf0qfhlo3ibo4rn77fk7ijvj6a4oj1', '::1', 1567524236, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532343036383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('5ua3fe7678likol4iu8q5f041v3mhqpe', '::1', 1569528067, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393532383036373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5v6sptrf5nj5igiohbovgvfg3t76f7ra', '::1', 1569616763, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631363736333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('681f0ro4nromr5552gc8qjr4k1l254em', '::1', 1567526580, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532363537303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('68orh1dkusplrueh1ac4uh1slmn6uu3k', '::1', 1568734697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733343639373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6bni7k7ak428egp5ajc5pd31kigo1v5j', '::1', 1567101551, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130313532323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6ckus2367i6skqiasqarcnl5kvns3utt', '::1', 1569613904, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631333930343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('6k186vojcln6hb1ecrtd8jlc35ivqdmv', '::1', 1567526233, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532363233313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6k8fljp6enguecag3bosmnv5au2bke5q', '::1', 1569485476, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393438353437363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6u1137bf31r8hj6j1tvctrroar09ic43', '::1', 1568651533, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635313533333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6vf2rqhb8n540fpf7mvblqck2ka2kj78', '::1', 1568720387, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383732303338373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6vi6k2ar7njr81kl5m5e184uvdmc0c8k', '::1', 1568716764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383731363736343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6vlaahabc4q1i74kkii2fvdsr32qg17h', '::1', 1567699691, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373639393638313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('7etkgs17p6bm3dpqrrp2o5nksqutviel', '::1', 1568910227, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383931303232373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('7fpt7d6ne73vib2oo4kpfh30un253cua', '::1', 1568567847, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383536373834373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('7gamn6hg1jinft8hq4abv5c3phqfatg0', '::1', 1568310321, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383331303332313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('7hftjdvclunnlfh9f17hk4fkoom4iga5', '::1', 1568739939, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733393933393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('7te5s2ljqe1s2j9tbvo9ugknv2rl1kkh', '::1', 1567930985, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373933303937363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b),
('823qir8t7nvf1qbb9ac2i9d7d0q3t515', '::1', 1567341684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334313338353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('824ben37964n6lvbt9mp55mefvcmj2us', '::1', 1568890241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383839303234313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('88ofhord56ss6cgnfclntmundrqogaca', '::1', 1567525849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532353632343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('8acpn6i53cvbi9r68g31os35ciof0l6k', '::1', 1569795501, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739353530313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('8cfrvsn4rkoinieilt4hdsj8fs46evv5', '::1', 1569796221, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739363232313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('8q62ofcfrctt25n3ig9gfeui0ep7j27g', '::1', 1568569506, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383536393530363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('90pasbnf0ncb3kec6ngqorbc1cah1hf4', '::1', 1568739274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733393237343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('947auhn2vr5d827dj33opoj99pnttegf', '::1', 1567866071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373836353739313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('963ka0ercjett26c3f8thunmk46k1omk', '::1', 1569862684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836323638343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('9ljo2pv5nr52n8uetqu68crkhdq68btf', '::1', 1567609012, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630393030383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('9lu1rude6hoougjhi1t9ua3hg13vhpqs', '::1', 1567333045, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333323936363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('9nm57t1k7lut2r17v7kpgne5na86lpm2', '::1', 1568909010, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383930393031303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('9t6t5vsp89d8sl14mgt4fvnb8o1e7jha', '::1', 1567082757, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037383937333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('9ubhpjcjif37qdert0gl5csev79486b8', '::1', 1567349037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334383739323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('9vq2g17710eq5jcbhsgngj1pb2gidbmu', '::1', 1568191921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139313932313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('a6jud61dkoq9cj0ffdnulg13341agjtt', '::1', 1568567251, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383536373235313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('abevqdqgdivu7t4i8nonmmqpi67ad85d', '::1', 1568568539, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383536383533393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('absu3sl3o7sonvdqsuc3bp3rk36bpts7', '::1', 1568568845, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383536383834353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('af79a4f8frtvsmkapl236ajnnet7smv3', '::1', 1569864282, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836343238323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ajdbm9l98ompfro5ec2jv2e0jhqdi5m4', '::1', 1568649334, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634393333343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('am021pk8c55fon9khogm4gsbcbb4rn9g', '::1', 1567612213, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373631323030313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('at3lcpt8r1lis5u0atdfd35qrqnogeop', '::1', 1569792237, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739323233373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('atbfv6s5r0os6cb6810op59givcdrkmv', '::1', 1569617142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631373134323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('b1e8tob3t1d2r3253tgbgcnvb76430an', '::1', 1568320673, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383332303637333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('b8k5uq011f1c41ehvo65h19mdf6qhb9e', '::1', 1567247032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234373032383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('bd1fh5vugpacoosqi4ma24lgp43u6ka0', '::1', 1567328188, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373332373930393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('bdnfn8o0nqfouf85gme2k1v9fha5rra4', '::1', 1568720775, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383732303737353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('bgv1esbt9gpd908n16ef04gpocu0jmft', '::1', 1569614649, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631343634393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('bkpd49rglpg8fc8ch0ec03pq3tilnm3r', '::1', 1569688115, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393638383131353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('bm5mhncpm42qocb1q10i1qvka8bbv37e', '::1', 1567073909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333930363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('c37iuiq4aabmqhqslvj0p61indhr7csh', '::1', 1568191351, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139313335313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('c3rnsk5akjfagl4nc53cmu584amfhrj9', '::1', 1568306860, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383330363836303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('c9beia196epckm85tlc0n2peqh1h2vk5', '::1', 1567603399, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630333036393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('cfdn6kmhciea6oqroq8j75h5hk3s7jir', '::1', 1568307398, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383330373339383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('cg70h68atu4klgtmt5p6n7i8kcfilir6', '::1', 1569485174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393438353137343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('cuqa6o4t0puf2gctc0jn9gvee8r5vmcq', '::1', 1568648925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634383932353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('cvlk146vkcjtb7q6c5pprq5r2so70i1c', '::1', 1568206293, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383230363239333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('d9ldj5qiqeamf0s7plqo7j23li7fot5u', '::1', 1568651200, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635313230303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('dgfdftv55bve5eh51cusdbnp910ht9me', '::1', 1568228945, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383232383934353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('dijv999jbuam32sej8ciekge3vanlh5q', '::1', 1569527351, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393532373334363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('drpauasam0i0o5h1lobn8iqll50gdr4k', '::1', 1569793650, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739333635303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('e4l1q2qgh6bq39ppt2mdatu9furvppc6', '::1', 1568648233, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634383233333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('e66c0kitfigqjccl68ri2k5v80t7or7i', '::1', 1569861994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836313939343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('e8cbsue7980etd1g3s206hnsc8ol9cmi', '::1', 1568650899, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635303839393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('e8n22kdvkql96hsg4lrjcpg3dn7ag5ln', '::1', 1569617220, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631373134323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('e9t0u4h8s59gu37udqkghsp644svjus8', '::1', 1568740386, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383734303338363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ebijfob8c64ugcib64ncaovp2di99nka', '::1', 1567941901, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373934313639333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('eg96tlj0ud7vlqs3qr8nc9fellb4p2qj', '::1', 1568667643, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383636373633393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('ehhsoehsb7ctik9amceil2krrdfjs82r', '::1', 1568731689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733313638393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ehomubq0sfua1bmoq7afaibn2b9b39fb', '::1', 1567603622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630333430323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('erb3f463qipircf4n5sj4ffs2ufn4bpb', '::1', 1567699713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373639393639313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('es0pr8nrvk9l4d0oteikpir8eb6ruk3e', '::1', 1568196500, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139363530303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('f6gpth5ii95ne2vn94jtje0jqg157p7s', '::1', 1567599912, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539393837363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ffdq8qbjjfgfvm54kkbmhm5g12r3hnub', '::1', 1568229738, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383232393733383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('fg9il70vmh402o877rbk50ic8sa5oa2t', '::1', 1568305445, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383330353434353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('fql12dupsh5tcobsmgdmuj4ebdk7ufks', '::1', 1568744400, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383734343138353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('ftnvknioajgpvj8dsmdpqqb867amsr5v', '::1', 1567543096, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323938343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('g63cs10jrtgnjb4g3ibbhibbokq9cjkq', '::1', 1569486145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393438363134353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('g95e24bul92ls9lij65l0gc2ne5li13o', '::1', 1569795088, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739353038383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ga4jfbqu58pst03floqpfop2pqm0f8du', '::1', 1567541611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534313435363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('gboskn8a8hljef566vfc1f6estaikoju', '::1', 1567542825, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534323536343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('gdl9l1a18pl4vltjrqvdjbskn685jo2e', '::1', 1568740982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383734303938323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('gkp07cu02gt70lab96m7o5qa6tvafe85', '::1', 1567935828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373933353738313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('godqcpgmum905jp49j38oj7v2jiclt5l', '::1', 1567346679, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334353635333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('gqsb0vjsu74ep3sd35uuhqg0ficsku5j', '::1', 1567342175, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334313930333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('gu3fcs9vt8lva9cqn2luhoufr6c57o3m', '::1', 1568320767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383332303637333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('gvm72p5tpbkplsbb56lov6dllgeude2s', '::1', 1568735931, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733353933313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('h1s2tfli30fojjggatb3og46000gsbdp', '::1', 1568190410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139303431303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('h2592vgof1ks9nv39ohbgb6vg21dv1h3', '::1', 1567458601, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383532333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('h3v0d21fmc8t4121u26felef62d60snl', '::1', 1568911720, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383931313632353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('h4g6i8e08c7d85d9cd6scikdn5qmqbdp', '::1', 1569793962, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739333936323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('hap5c3jti31lg5l091lk5ttjcmh6ooqc', '::1', 1569864641, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836343634313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('hcbos13kkbrnmrkf8rr3t17otakp79o5', '::1', 1567100444, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130303339343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('hkign0hlfe6dr83825jq6nfh7aht7hva', '::1', 1568188624, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383138383632343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('hkni83av4v1thgbnporems14j87acful', '::1', 1568652826, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635323832363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('hplclhhou0ke8prdgie3gmr0lvbgvsql', '::1', 1567672971, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637323933343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('hpoq5jnt3fif7plj52ag1iq1pv0p2r1e', '::1', 1567542010, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534313836323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('hq5lf0jt6diae8kajtl3j97c9euelnqf', '::1', 1569613103, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631333130333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('hslkdsuh7r8kdn1pv0dqa11u8d370q6q', '::1', 1568647420, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634373432303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('hvcu1k2dr1cjeauobq25pjt7ocpmakkt', '::1', 1568568176, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383536383137363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('i39664rtogh2uhm6m4jnehgnbj60lmi7', '::1', 1567084535, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038343530393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('iajuo5h9ci76vi2c6rf4sn3f1vbban07', '::1', 1568729949, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383732393934393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('ic12f101qd1iof6gb86n3p5fqf2qj9l5', '::1', 1569858942, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393835383934323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('icnilfgtr9qspmfslklqa7u7evqpji6n', '::1', 1567525609, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532343434393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('id1pbu87omnt1flsgnvipg7gogd9pgok', '::1', 1568891246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383839313234363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('idmsjctoqm9l17desvn60tpeudng3rd3', '::1', 1568743540, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383734333534303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('j42gk72ec2mr1hsg79ck0c57gvbv0015', '::1', 1567685061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373638353030353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('j6de67btqaiq8sk09ntf9oovtgsqk00i', '::1', 1568198960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139383936303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('j6ropq90fdm9vfllh453t2jrecl8nh9a', '::1', 1567241440, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234313039393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('j8elvqk6l0pq32lnur714oga4ms05ejt', '::1', 1569610840, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631303834303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('jdknnqjqanth17skv00ajgbrmm5okecf', '::1', 1569614241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631343234313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('jglla1cmrtp9285s5uuumgjsd2td1rd8', '::1', 1568731317, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733313331373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('jhqmdtbqvh35rdl5grj5u69lhtjvqnng', '::1', 1568138935, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383133373339343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('ji497tjaoof64fudntdv5lufs6m5asjs', '::1', 1568732585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733323538353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('jj4icmllp1gdsuhi8om4ehpg871eu1qh', '::1', 1568310790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383331303739303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('jp7v8jh0sidjueflv4h8gko9ikm5vp4c', '::1', 1569864948, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836343934383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('jrg961bn2tnau7ivm8nr3h17859h1gua', '::1', 1568744185, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383734343138353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('k2r76eav3lbheukiikjm720vmihudest', '::1', 1569689293, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393638393239333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('k6b9ect61sruulja1d3pqt204ctu4ga0', '::1', 1568305052, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383330353035323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('k8ege4pk0qr2sch36im25nuk85023faa', '::1', 1568897023, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383839373032333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('kbnmdi86poa1entlqt68v7237l35c404', '::1', 1568570313, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383537303331333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('keuqcm8quf0tmpketolb4a6cmfdpvhv9', '::1', 1568905311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383930353331313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('khr561j0ojrdiof9u8706cltih68csom', '::1', 1569612787, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631323738373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('kjvagbqppc3a8iug64gcj3l7jdd2v7d9', '::1', 1567328509, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373332383235313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('l2djp6tq7hda9r80jbvkkr10a35bgdgp', '::1', 1569862321, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836323332313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('l47najcf9lj0v0ujig1u4tl5afr0ckav', '::1', 1569615728, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631353732383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('l9cm3r5b1u99vi23ud6oppvb5422mj0g', '::1', 1568890552, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383839303535323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b6d6573736167652d737563636573737c733a33383a22d8aad98520d8a5d8b6d8a7d981d8a92050726f6375726174696f6e20d8a8d986d8acd8a7d8ad223b5f5f63695f766172737c613a313a7b733a31353a226d6573736167652d73756363657373223b733a333a226f6c64223b7d),
('lad06sp5lh1pqe3rrpofrsvnqjmc7il3', '::1', 1567533618, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373533333334313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('lakek818lptst801og760hgvptadtv3b', '::1', 1569528727, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393532383432353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('lcbqqj4p6anc9d11rd0lod3jpj4jvmtl', '::1', 1569861295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836313239353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('lh7940shejshs2hvji3q2q7agasv0nub', '::1', 1567241757, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234313735363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('lrmstu0295rrndrh5nrl5hffa0iq0m9j', '::1', 1567931341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373933313239383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('lrv0mf6t5g48j766lsu0mahmei85mumt', '::1', 1568652489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635323438393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('m2n0ahd60scno63t7e2efk05npdh711o', '::1', 1569611958, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631313935383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('m4hjcculihbm6enmfseap9jirq3p76bc', '::1', 1567865791, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373836353431393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('merrfag0hled8ljg38jigdja9ul9rh03', '::1', 1569791171, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739313137313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('mftq940auppqthikfoh5nvrvf3ogci07', '::1', 1568738596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733383539363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('mg81prq1t3p7ft3os62nd8hnasio69es', '::1', 1567956542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373935363533383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('mp5p7psm4oto200t0tete2b78hnrajrs', '::1', 1567325977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373332353936363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b6f66667365747c693a303b5f5f63695f766172737c613a313a7b733a363a226f6666736574223b733a333a226f6c64223b7d),
('n0ol0m7apdhvuq1rqukmaiof7gmfov53', '::1', 1567619137, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373631393132363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('n2s7emmlvepvvv7njdugndvbocccc2t4', '::1', 1568739585, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733393538353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('n2tlo1i8ee5ksjhp1e6bumns2keqne4f', '::1', 1568743880, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383734333838303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('n5mhgatoeaef4fsh6j00777m5ah8n316', '::1', 1568228580, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383232383538303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('ndo3f695e539k5i3pui36cs9jojqohfi', '::1', 1567231627, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373233313439383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b6f66667365747c693a303b5f5f63695f766172737c613a313a7b733a363a226f6666736574223b733a333a226f6c64223b7d),
('neenkbdeip6616no5grv1lp2it00897b', '::1', 1567325666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373332353437333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('nfrjss4ptiuvgh3hohosc0333gfvs9r4', '::1', 1569611149, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631313134393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ni6ci6si542kiviscnhnd0sldnbam6vh', '::1', 1567937162, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373933373135303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('nlk0fps769tf62pb216clgpjt97qlifm', '::1', 1568188949, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383138383934393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('nrac9a1qmvtdcqoabqhta3onqicci1h0', '::1', 1567346723, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334363638323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('nslrrh3pj9qsb2ga706j97d0ich167dk', '::1', 1567329156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373332383938383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('o4gkvp6knipf2pmvo5sk4sh33e38c0ck', '::1', 1569528425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393532383432353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('o91ejtd8ojh8bhq7is27qveeo3gkd7e7', '::1', 1567670531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637303532363b7265645f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f61646d696e2f536572766963652f33223b);
INSERT INTO `tblsessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('ofoa2e40d2vcf7st5as072qkkntenes5', '::1', 1569527692, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393532373639323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('oou0m6pk2o323ed0ciejcnlbkirba9dj', '::1', 1568738925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733383932353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('oqdmijaicbjb145ceoc19sm07v9ulplm', '::1', 1569796642, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739363538333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b6d6573736167652d737563636573737c733a33353a22d8aad98520d8a5d8b6d8a7d981d8a920696e636f6d696e6720d8a8d986d8acd8a7d8ad223b5f5f63695f766172737c613a313a7b733a31353a226d6573736167652d73756363657373223b733a333a226f6c64223b7d),
('orfs432d22m3l8kb5t5nsitsl9fm4ctt', '::1', 1569615133, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631353133333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('p64ammhjenguvlle4gq0qug1bupg6l7o', '::1', 1569794301, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739343330313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('pa61k7olij0vmkd0fv7a2q448m5d20eg', '::1', 1569687793, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393638373739333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('pitm5p8idrjvik549jqmt3obfebiics6', '::1', 1568906457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383930363435373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('pnj2sjv3t832air444bj2pkjv47gm2u2', '::1', 1568648542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634383534323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('psks21s5b144c56m42lr23o5o5da2prt', '::1', 1567599873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373539393837323b7265645f75726c7c733a34313a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f61646d696e2f73657474696e6773223b),
('ptnlohrtj3c889k31a46c3rdql4qif1u', '::1', 1567600625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630303631353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('punuqvbi4gnrjo9e8kh76d76hd0ed0fj', '::1', 1569865100, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836343934383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('puunhtj918d2o2l98hm3ra08cj135hta', '::1', 1567608037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630373833343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('q1e2u8m36l8fn55qm1s74faehmaf0hfu', '::1', 1568732892, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733323839323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('q508cdjounbd4niifc3hdmubvkife2ar', '::1', 1567701691, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373730313632393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qav46n6d8sj8ve0jnh2sodsjm3j6sshk', '::1', 1567541107, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373534303932383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qc3652v1gint152sngcn2d2c8s12ntk7', '::1', 1568130419, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383133303338313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qejcdkvcsmk15k0qt5gaddnmasgvc61m', '::1', 1568306086, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383330363038363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qiggrssotkmaedguk83h0fi6k496pi4u', '::1', 1568721713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383732313731333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qjg211okb3annd5g3shomgba6t3nofb2', '::1', 1567459061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373435383835373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qjrv2ojvnhpfk99ljj6a3km59tdh4ghq', '::1', 1568717085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383731373038353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qna2p7tkqtv4kppv0ejdp25fioo00buv', '::1', 1567607830, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373630333934383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('qnco6l1hrl0s809flmn0tnk4sn9hbj1f', '::1', 1567100043, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373039393938373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('qoofeja45nen3u40cgff6a48vohea23k', '::1', 1567246511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373234363235383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qt1dgrmeeljr67va5u7dcjog877jr3hj', '::1', 1569689480, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393638393239333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('qv3okvcjrbjltsdhirdslbhr8qhq8rjd', '::1', 1567348218, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334373230333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('r0f6efcghspvd4p0nl07e3i114d3kn6j', '::1', 1567956583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373935363534323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('r5m886ailvabqp2dgcgpkjnde3qe9eop', '::1', 1569860856, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393836303835363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('r7t0hcdi8bffb3k17nl8rhgo2d00b8mt', '::1', 1567615150, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373631343938313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('r8a693n2crlfhnpskjfkq384gul8g34m', '::1', 1567345332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334353033303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b6f66667365747c693a303b5f5f63695f766172737c613a313a7b733a363a226f6666736574223b733a333a226f6c64223b7d),
('rav43mmudoc6vh6umoecjkv6rqvigfhu', '::1', 1568645686, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634353638363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('rcpuc9aaihdmrknfkqikoesrlmggh2n1', '::1', 1568722192, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383732323139323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('rcvcp3v97inahdahi8nrvcts7mgpn65g', '::1', 1567700019, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373639393731333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('rfh20secovl9v5nt7a32jk6p9ktn49ad', '::1', 1567941268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373933373630313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('rkcceq73n3uuculvchfc3fmtur1frev2', '::1', 1568897372, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383839373337323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('rt71epqbvp29bh2b33v2u2htnn92nlbn', '::1', 1567674102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373637343039393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('rvrda7k6p6umr88gp980d5uibvfaah0o', '::1', 1568733548, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383733333534383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('s20bp9ud3l16kqh9273ttlqsn251si3g', '::1', 1568139073, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383133393032323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('s875j4h3ll5lllrrqm15ulcls1sh7113', '::1', 1568139598, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383133393537393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('sb7j6gajjbe6e07hj36ir578vvcdk1di', '::1', 1567084503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373038323736313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('sni5f97rlgaidbc9gt9ns2sa2kmc2mv5', '::1', 1567526219, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373532353932373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('so9e102isgm6ie85u2j5pif7d44thmo1', '::1', 1568229883, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383232393733383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('sqgv334uqt45va6i445bk42847l7er7o', '::1', 1568909684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383930393638343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('su1v0hvrpiacp45ge3q62v6sg9hhq5gh', '::1', 1568311836, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383331313833363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('t1bt63see95gdgs2f2le3gj0r7oslen2', '::1', 1569790819, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739303831393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('t4gvnmqq409dpp5oeakedct5ftmpc7ci', '::1', 1569616457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393631363435373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('t9qcljr8gva9bs0v9t6d4slru34c32qp', '::1', 1569527346, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393532373334363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('tlj4j3id701snbehh4n458el152ktshm', '::1', 1568575327, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383537353330353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('tnl78slum8v8l2e4oh311ndsbc4le6r4', '::1', 1568647912, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383634373931323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('to0e8i8un55g36155b2vk5v3gl0l73sp', '::1', 1567104191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373130313936393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('tomfk1lf68tmue1ml3065ampld429hmj', '::1', 1568668018, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383636383031383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('tr3pg1unp5n975ub233b9300o6t88da9', '::1', 1567941325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373934313237303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ts5f1qqonr89g3seh2ov3mt5i1e98d5g', '::1', 1568718618, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383731383631383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('ttvh52robgon9pr69ufslg375sobhvp3', '::1', 1568575305, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383537353330353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('u1k83s9er220i10v3rqq427ufagkmu37', '::1', 1568653200, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383635333230303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ulrsgc9dhllq6j6i7e7uchcdtqrktheq', '::1', 1569858099, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393835383039393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('utaili7u5rvr0b6kfd61v7bmido2mokg', '::1', 1568911625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383931313632353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('v5tgj3pnj37qdav6b46tsqlfvdet9ne4', '::1', 1567348325, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373334383232323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('v65191q7gehccbpo312arau1lhha9l7k', '::1', 1569795886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393739353838363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('v6oj2scvs9t1avo3mv40lhfuv1ic1goj', '::1', 1569686634, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393638363633343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('vebe6mb1vfenahd81lrsjqs3nstn7jvl', '::1', 1567339404, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373333393236363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('vif1gn6ef9q9ep8mhp05i5hhto57lm1p', '::1', 1568197989, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383139373938393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b7265645f75726c7c733a32373a22687474703a2f2f6c6f63616c686f73742f6c6567616c736572762f223b),
('vq0l44prur779jhqh4t03jfh356n52o3', '::1', 1567073843, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373037333534323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b);

-- --------------------------------------------------------

--
-- بنية الجدول `tblshared_customer_files`
--

CREATE TABLE `tblshared_customer_files` (
  `file_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblspam_filters`
--

CREATE TABLE `tblspam_filters` (
  `id` int(11) NOT NULL,
  `type` varchar(40) NOT NULL,
  `rel_type` varchar(10) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblstaff`
--

CREATE TABLE `tblstaff` (
  `staffid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `facebook` mediumtext DEFAULT NULL,
  `linkedin` mediumtext DEFAULT NULL,
  `phonenumber` varchar(30) DEFAULT NULL,
  `skype` varchar(50) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `datecreated` datetime NOT NULL,
  `profile_image` varchar(191) DEFAULT NULL,
  `last_ip` varchar(40) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_password_change` datetime DEFAULT NULL,
  `new_pass_key` varchar(32) DEFAULT NULL,
  `new_pass_key_requested` datetime DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `role` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `default_language` varchar(40) DEFAULT NULL,
  `direction` varchar(3) DEFAULT NULL,
  `media_path_slug` varchar(191) DEFAULT NULL,
  `is_not_staff` int(11) NOT NULL DEFAULT 0,
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `two_factor_auth_enabled` tinyint(1) DEFAULT 0,
  `two_factor_auth_code` varchar(100) DEFAULT NULL,
  `two_factor_auth_code_requested` datetime DEFAULT NULL,
  `email_signature` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tblstaff`
--

INSERT INTO `tblstaff` (`staffid`, `email`, `firstname`, `lastname`, `facebook`, `linkedin`, `phonenumber`, `skype`, `password`, `datecreated`, `profile_image`, `last_ip`, `last_login`, `last_activity`, `last_password_change`, `new_pass_key`, `new_pass_key_requested`, `admin`, `role`, `active`, `default_language`, `direction`, `media_path_slug`, `is_not_staff`, `hourly_rate`, `two_factor_auth_enabled`, `two_factor_auth_code`, `two_factor_auth_code_requested`, `email_signature`) VALUES
(1, 'mhdbashard@gmail.com', 'Mhdbashar', 'Das', '', NULL, '', '', '$2a$08$JJ4pffim0G5twlrWkQPc6u0VVwlDdZPvyn4rbHz3l7uclgmHLHeyq', '2019-07-18 10:29:15', NULL, '::1', '2019-09-30 18:36:07', '2019-09-30 20:38:20', NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, 0, '0.00', 0, NULL, NULL, NULL),
(2, 'mohamad@gmail.com', 'mohamad', 'mohamad', '', '', '', '', '$2a$08$3U3Yq/bdVzixBFhr8sEWG.N64L8VEBgakihhEiQFdaXPJBbB47C06', '2019-07-20 15:54:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '', '', 'mohamad-mohamad', 0, '0.00', 0, NULL, NULL, '');

-- --------------------------------------------------------

--
-- بنية الجدول `tblstaff_departments`
--

CREATE TABLE `tblstaff_departments` (
  `staffdepartmentid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblstaff_permissions`
--

CREATE TABLE `tblstaff_permissions` (
  `staff_id` int(11) NOT NULL,
  `feature` varchar(40) NOT NULL,
  `capability` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblsubscriptions`
--

CREATE TABLE `tblsubscriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `description_in_item` tinyint(1) NOT NULL DEFAULT 0,
  `clientid` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL DEFAULT 0,
  `stripe_plan_id` text DEFAULT NULL,
  `stripe_subscription_id` text NOT NULL,
  `next_billing_cycle` bigint(20) DEFAULT NULL,
  `ends_at` bigint(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `created_from` int(11) NOT NULL,
  `date_subscribed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltaggables`
--

CREATE TABLE `tbltaggables` (
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `tag_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltags`
--

CREATE TABLE `tbltags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltasks`
--

CREATE TABLE `tbltasks` (
  `id` int(11) NOT NULL,
  `name` mediumtext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `startdate` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `datefinished` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `is_added_from_contact` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT 0,
  `is_recurring_from` int(11) DEFAULT NULL,
  `cycles` int(11) NOT NULL DEFAULT 0,
  `total_cycles` int(11) NOT NULL DEFAULT 0,
  `custom_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `last_recurring_date` date DEFAULT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(30) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `billable` tinyint(1) NOT NULL DEFAULT 0,
  `billed` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_id` int(11) NOT NULL DEFAULT 0,
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `milestone` int(11) DEFAULT 0,
  `kanban_order` int(11) NOT NULL DEFAULT 0,
  `milestone_order` int(11) NOT NULL DEFAULT 0,
  `visible_to_client` tinyint(1) NOT NULL DEFAULT 0,
  `deadline_notified` int(11) NOT NULL DEFAULT 0,
  `is_session` int(11) DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbltasks`
--

INSERT INTO `tbltasks` (`id`, `name`, `description`, `priority`, `dateadded`, `startdate`, `duedate`, `datefinished`, `addedfrom`, `is_added_from_contact`, `status`, `recurring_type`, `repeat_every`, `recurring`, `is_recurring_from`, `cycles`, `total_cycles`, `custom_recurring`, `last_recurring_date`, `rel_id`, `rel_type`, `is_public`, `billable`, `billed`, `invoice_id`, `hourly_rate`, `milestone`, `kanban_order`, `milestone_order`, `visible_to_client`, `deadline_notified`, `is_session`, `deleted`) VALUES
(7, 'جلسة تجريبية', NULL, 2, '2019-09-18 15:33:12', '2019-09-17', '2019-09-20', NULL, 1, 0, 4, 'week', 0, 0, NULL, 0, 0, 0, NULL, 2, 'kd-y', 0, 1, 0, 0, '100.00', 0, 0, 0, 0, 0, 1, 0),
(8, 'test', NULL, 2, '2019-09-18 17:57:45', '2019-09-28', NULL, NULL, 1, 0, 4, NULL, 0, 0, NULL, 0, 0, 0, NULL, 2, 'kd-y', 0, 1, 0, 0, '0.00', 0, 0, 0, 0, 0, 1, 0),
(9, 'جلسة تجريبية 2', NULL, 2, '2019-09-18 17:59:14', '2019-09-17', NULL, NULL, 1, 0, 4, NULL, 0, 0, NULL, 0, 0, 0, NULL, 2, 'kd-y', 0, 1, 0, 0, '0.00', 0, 0, 0, 0, 0, 1, 0),
(11, 'qwqw', NULL, 2, '2019-09-18 18:32:30', '2019-09-18', NULL, NULL, 1, 0, 4, NULL, 0, 0, NULL, 0, 0, 0, NULL, 2, 'kd-y', 0, 1, 0, 0, '0.00', 0, 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tbltaskstimers`
--

CREATE TABLE `tbltaskstimers` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `start_time` varchar(64) NOT NULL,
  `end_time` varchar(64) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltasks_checklist_templates`
--

CREATE TABLE `tbltasks_checklist_templates` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltask_assigned`
--

CREATE TABLE `tbltask_assigned` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `assigned_from` int(11) NOT NULL DEFAULT 0,
  `is_assigned_from_contact` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbltask_assigned`
--

INSERT INTO `tbltask_assigned` (`id`, `staffid`, `taskid`, `assigned_from`, `is_assigned_from_contact`) VALUES
(5, 1, 5, 1, 0),
(7, 1, 7, 1, 0),
(8, 1, 8, 1, 0),
(9, 1, 9, 1, 0),
(11, 1, 11, 1, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `tbltask_checklist_items`
--

CREATE TABLE `tbltask_checklist_items` (
  `id` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `description` text NOT NULL,
  `finished` int(11) NOT NULL DEFAULT 0,
  `dateadded` datetime NOT NULL,
  `addedfrom` int(11) NOT NULL,
  `finished_from` int(11) DEFAULT 0,
  `list_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltask_comments`
--

CREATE TABLE `tbltask_comments` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `taskid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT 0,
  `file_id` int(11) NOT NULL DEFAULT 0,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltask_followers`
--

CREATE TABLE `tbltask_followers` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltaxes`
--

CREATE TABLE `tbltaxes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `taxrate` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltickets`
--

CREATE TABLE `tbltickets` (
  `ticketid` int(11) NOT NULL,
  `adminreplying` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL,
  `contactid` int(11) NOT NULL DEFAULT 0,
  `email` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `department` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `service` int(11) DEFAULT NULL,
  `ticketkey` varchar(32) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `lastreply` datetime DEFAULT NULL,
  `clientread` int(11) NOT NULL DEFAULT 0,
  `adminread` int(11) NOT NULL DEFAULT 0,
  `assigned` int(11) NOT NULL DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(30) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltickets_pipe_log`
--

CREATE TABLE `tbltickets_pipe_log` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `email_to` varchar(100) NOT NULL,
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` mediumtext NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltickets_predefined_replies`
--

CREATE TABLE `tbltickets_predefined_replies` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltickets_priorities`
--

CREATE TABLE `tbltickets_priorities` (
  `priorityid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbltickets_priorities`
--

INSERT INTO `tbltickets_priorities` (`priorityid`, `name`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High');

-- --------------------------------------------------------

--
-- بنية الجدول `tbltickets_status`
--

CREATE TABLE `tbltickets_status` (
  `ticketstatusid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `isdefault` int(11) NOT NULL DEFAULT 0,
  `statuscolor` varchar(7) DEFAULT NULL,
  `statusorder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `tbltickets_status`
--

INSERT INTO `tbltickets_status` (`ticketstatusid`, `name`, `isdefault`, `statuscolor`, `statusorder`) VALUES
(1, 'Open', 1, '#ff2d42', 1),
(2, 'In progress', 1, '#84c529', 2),
(3, 'Answered', 1, '#0000ff', 3),
(4, 'On Hold', 1, '#c0c0c0', 4),
(5, 'Closed', 1, '#03a9f4', 5);

-- --------------------------------------------------------

--
-- بنية الجدول `tblticket_attachments`
--

CREATE TABLE `tblticket_attachments` (
  `id` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `replyid` int(11) DEFAULT NULL,
  `file_name` varchar(191) NOT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblticket_replies`
--

CREATE TABLE `tblticket_replies` (
  `id` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `contactid` int(11) NOT NULL DEFAULT 0,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `message` text DEFAULT NULL,
  `attachment` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltodos`
--

CREATE TABLE `tbltodos` (
  `todoid` int(11) NOT NULL,
  `description` text NOT NULL,
  `staffid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  `finished` tinyint(1) NOT NULL,
  `datefinished` datetime DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbltracked_mails`
--

CREATE TABLE `tbltracked_mails` (
  `id` int(11) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT 0,
  `date_opened` datetime DEFAULT NULL,
  `subject` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbluser_auto_login`
--

CREATE TABLE `tbluser_auto_login` (
  `key_id` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `staff` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tbluser_meta`
--

CREATE TABLE `tbluser_meta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `client_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `contact_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(191) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblvault`
--

CREATE TABLE `tblvault` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `server_address` varchar(191) NOT NULL,
  `port` int(11) DEFAULT NULL,
  `username` varchar(191) NOT NULL,
  `password` text NOT NULL,
  `description` text DEFAULT NULL,
  `creator` int(11) NOT NULL,
  `creator_name` varchar(100) DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `share_in_projects` tinyint(1) NOT NULL DEFAULT 0,
  `last_updated` datetime DEFAULT NULL,
  `last_updated_from` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblviews_tracking`
--

CREATE TABLE `tblviews_tracking` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `view_ip` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `tblweb_to_lead`
--

CREATE TABLE `tblweb_to_lead` (
  `id` int(11) NOT NULL,
  `form_key` varchar(32) NOT NULL,
  `lead_source` int(11) NOT NULL,
  `lead_status` int(11) NOT NULL,
  `notify_lead_imported` int(11) NOT NULL DEFAULT 1,
  `notify_type` varchar(20) DEFAULT NULL,
  `notify_ids` mediumtext DEFAULT NULL,
  `responsible` int(11) NOT NULL DEFAULT 0,
  `name` varchar(191) NOT NULL,
  `form_data` mediumtext DEFAULT NULL,
  `recaptcha` int(11) NOT NULL DEFAULT 0,
  `submit_btn_name` varchar(40) DEFAULT NULL,
  `success_submit_msg` text DEFAULT NULL,
  `language` varchar(40) DEFAULT NULL,
  `allow_duplicate` int(11) NOT NULL DEFAULT 1,
  `mark_public` int(11) NOT NULL DEFAULT 0,
  `track_duplicate_field` varchar(20) DEFAULT NULL,
  `track_duplicate_field_and` varchar(20) DEFAULT NULL,
  `create_task_on_duplicate` int(11) NOT NULL DEFAULT 0,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffid` (`staffid`);

--
-- Indexes for table `tblannouncements`
--
ALTER TABLE `tblannouncements`
  ADD PRIMARY KEY (`announcementid`);

--
-- Indexes for table `tblbranches`
--
ALTER TABLE `tblbranches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbranches_services`
--
ALTER TABLE `tblbranches_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcasediscussioncomments`
--
ALTER TABLE `tblcasediscussioncomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcasediscussions`
--
ALTER TABLE `tblcasediscussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcase_activity`
--
ALTER TABLE `tblcase_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcase_files`
--
ALTER TABLE `tblcase_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `tblcase_notes`
--
ALTER TABLE `tblcase_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcase_settings`
--
ALTER TABLE `tblcase_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`case_id`);

--
-- Indexes for table `tblcities`
--
ALTER TABLE `tblcities`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclients`
--
ALTER TABLE `tblclients`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `country` (`country`),
  ADD KEY `leadid` (`leadid`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `tblconsents`
--
ALTER TABLE `tblconsents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purpose_id` (`purpose_id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `tblconsent_purposes`
--
ALTER TABLE `tblconsent_purposes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontacts`
--
ALTER TABLE `tblcontacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `firstname` (`firstname`),
  ADD KEY `lastname` (`lastname`),
  ADD KEY `email` (`email`),
  ADD KEY `is_primary` (`is_primary`);

--
-- Indexes for table `tblcontact_permissions`
--
ALTER TABLE `tblcontact_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontracts`
--
ALTER TABLE `tblcontracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client` (`client`),
  ADD KEY `contract_type` (`contract_type`);

--
-- Indexes for table `tblcontracts_types`
--
ALTER TABLE `tblcontracts_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontract_comments`
--
ALTER TABLE `tblcontract_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontract_renewals`
--
ALTER TABLE `tblcontract_renewals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcountries`
--
ALTER TABLE `tblcountries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `tblcreditnotes`
--
ALTER TABLE `tblcreditnotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `rel_sid` (`rel_sid`),
  ADD KEY `rel_stype` (`rel_stype`);

--
-- Indexes for table `tblcreditnote_refunds`
--
ALTER TABLE `tblcreditnote_refunds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcredits`
--
ALTER TABLE `tblcredits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcurrencies`
--
ALTER TABLE `tblcurrencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcustomers_groups`
--
ALTER TABLE `tblcustomers_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tblcustomer_admins`
--
ALTER TABLE `tblcustomer_admins`
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tblcustomer_groups`
--
ALTER TABLE `tblcustomer_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupid` (`groupid`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `tblcustomfields`
--
ALTER TABLE `tblcustomfields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcustomfieldsvalues`
--
ALTER TABLE `tblcustomfieldsvalues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relid` (`relid`),
  ADD KEY `fieldto` (`fieldto`),
  ADD KEY `fieldid` (`fieldid`);

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`departmentid`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tbldismissed_announcements`
--
ALTER TABLE `tbldismissed_announcements`
  ADD PRIMARY KEY (`dismissedannouncementid`),
  ADD KEY `announcementid` (`announcementid`),
  ADD KEY `staff` (`staff`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tblemailtemplates`
--
ALTER TABLE `tblemailtemplates`
  ADD PRIMARY KEY (`emailtemplateid`);

--
-- Indexes for table `tblestimates`
--
ALTER TABLE `tblestimates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `currency` (`currency`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `sale_agent` (`sale_agent`),
  ADD KEY `rel_sid` (`rel_sid`),
  ADD KEY `rel_stype` (`rel_stype`);

--
-- Indexes for table `tblevents`
--
ALTER TABLE `tblevents`
  ADD PRIMARY KEY (`eventid`);

--
-- Indexes for table `tblexpenses`
--
ALTER TABLE `tblexpenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `category` (`category`),
  ADD KEY `currency` (`currency`),
  ADD KEY `rel_sid` (`rel_sid`),
  ADD KEY `rel_stype` (`rel_stype`);

--
-- Indexes for table `tblexpenses_categories`
--
ALTER TABLE `tblexpenses_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblfiles`
--
ALTER TABLE `tblfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`);

--
-- Indexes for table `tblform_questions`
--
ALTER TABLE `tblform_questions`
  ADD PRIMARY KEY (`questionid`);

--
-- Indexes for table `tblform_question_box`
--
ALTER TABLE `tblform_question_box`
  ADD PRIMARY KEY (`boxid`);

--
-- Indexes for table `tblform_question_box_description`
--
ALTER TABLE `tblform_question_box_description`
  ADD PRIMARY KEY (`questionboxdescriptionid`);

--
-- Indexes for table `tblform_results`
--
ALTER TABLE `tblform_results`
  ADD PRIMARY KEY (`resultid`);

--
-- Indexes for table `tblgdpr_requests`
--
ALTER TABLE `tblgdpr_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblinvoicepaymentrecords`
--
ALTER TABLE `tblinvoicepaymentrecords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `paymentmethod` (`paymentmethod`);

--
-- Indexes for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `sale_agent` (`sale_agent`),
  ADD KEY `total` (`total`),
  ADD KEY `rel_stype` (`rel_stype`),
  ADD KEY `rel_sid` (`rel_sid`);

--
-- Indexes for table `tblitemable`
--
ALTER TABLE `tblitemable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`),
  ADD KEY `qty` (`qty`),
  ADD KEY `rate` (`rate`);

--
-- Indexes for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tax` (`tax`),
  ADD KEY `tax2` (`tax2`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `tblitems_groups`
--
ALTER TABLE `tblitems_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblitem_tax`
--
ALTER TABLE `tblitem_tax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `tblknowedge_base_article_feedback`
--
ALTER TABLE `tblknowedge_base_article_feedback`
  ADD PRIMARY KEY (`articleanswerid`);

--
-- Indexes for table `tblknowledge_base`
--
ALTER TABLE `tblknowledge_base`
  ADD PRIMARY KEY (`articleid`);

--
-- Indexes for table `tblknowledge_base_groups`
--
ALTER TABLE `tblknowledge_base_groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `tblleads`
--
ALTER TABLE `tblleads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `company` (`company`),
  ADD KEY `email` (`email`),
  ADD KEY `assigned` (`assigned`),
  ADD KEY `status` (`status`),
  ADD KEY `source` (`source`),
  ADD KEY `lastcontact` (`lastcontact`),
  ADD KEY `dateadded` (`dateadded`),
  ADD KEY `leadorder` (`leadorder`),
  ADD KEY `from_form_id` (`from_form_id`);

--
-- Indexes for table `tblleads_email_integration`
--
ALTER TABLE `tblleads_email_integration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleads_sources`
--
ALTER TABLE `tblleads_sources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tblleads_status`
--
ALTER TABLE `tblleads_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tbllead_activity_log`
--
ALTER TABLE `tbllead_activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbllead_integration_emails`
--
ALTER TABLE `tbllead_integration_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmail_queue`
--
ALTER TABLE `tblmail_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmilestones`
--
ALTER TABLE `tblmilestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_sid` (`rel_sid`),
  ADD KEY `rel_stype` (`rel_stype`);

--
-- Indexes for table `tblmodules`
--
ALTER TABLE `tblmodules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_award`
--
ALTER TABLE `tblmy_award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_bank`
--
ALTER TABLE `tblmy_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_basic_services`
--
ALTER TABLE `tblmy_basic_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_cases`
--
ALTER TABLE `tblmy_cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_casestatus`
--
ALTER TABLE `tblmy_casestatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_cases_judges`
--
ALTER TABLE `tblmy_cases_judges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `tblmy_cases_movement_judges`
--
ALTER TABLE `tblmy_cases_movement_judges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `case_id` (`case_mov_id`);

--
-- Indexes for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CateServKey` (`service_id`);

--
-- Indexes for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tblmy_customer_representative`
--
ALTER TABLE `tblmy_customer_representative`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_employee_basic`
--
ALTER TABLE `tblmy_employee_basic`
  ADD PRIMARY KEY (`employee_basic_id`);

--
-- Indexes for table `tblmy_holiday`
--
ALTER TABLE `tblmy_holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_judges`
--
ALTER TABLE `tblmy_judges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_judicialdept`
--
ALTER TABLE `tblmy_judicialdept`
  ADD PRIMARY KEY (`j_id`),
  ADD KEY `CourtJudKey` (`c_id`);

--
-- Indexes for table `tblmy_members_cases`
--
ALTER TABLE `tblmy_members_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tblmy_members_services`
--
ALTER TABLE `tblmy_members_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tblmy_newstaff`
--
ALTER TABLE `tblmy_newstaff`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tblmy_other_services`
--
ALTER TABLE `tblmy_other_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_procurationstate`
--
ALTER TABLE `tblmy_procurationstate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_procurationtype`
--
ALTER TABLE `tblmy_procurationtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_projects_contacts`
--
ALTER TABLE `tblmy_projects_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tblmy_projects_meta`
--
ALTER TABLE `tblmy_projects_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tblmy_projects_statuses`
--
ALTER TABLE `tblmy_projects_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_project_invoicepaymentrecords`
--
ALTER TABLE `tblmy_project_invoicepaymentrecords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `paymentmethod` (`paymentmethod`);

--
-- Indexes for table `tblmy_project_invoices`
--
ALTER TABLE `tblmy_project_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `sale_agent` (`sale_agent`),
  ADD KEY `total` (`total`),
  ADD KEY `rel_stype` (`rel_stype`),
  ADD KEY `rel_sid` (`rel_sid`);

--
-- Indexes for table `tblmy_salary`
--
ALTER TABLE `tblmy_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_service_session`
--
ALTER TABLE `tblmy_service_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_sessiondiscussioncomments`
--
ALTER TABLE `tblmy_sessiondiscussioncomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_sessiondiscussions`
--
ALTER TABLE `tblmy_sessiondiscussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_session_info`
--
ALTER TABLE `tblmy_session_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `tblmy_training`
--
ALTER TABLE `tblmy_training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_training_attachments`
--
ALTER TABLE `tblmy_training_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_transactions`
--
ALTER TABLE `tblmy_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_vac`
--
ALTER TABLE `tblmy_vac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnewsfeed_comment_likes`
--
ALTER TABLE `tblnewsfeed_comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnewsfeed_posts`
--
ALTER TABLE `tblnewsfeed_posts`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `tblnewsfeed_post_comments`
--
ALTER TABLE `tblnewsfeed_post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnewsfeed_post_likes`
--
ALTER TABLE `tblnewsfeed_post_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnotes`
--
ALTER TABLE `tblnotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`);

--
-- Indexes for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloptions`
--
ALTER TABLE `tbloptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tbloservicediscussioncomments`
--
ALTER TABLE `tbloservicediscussioncomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloservicediscussions`
--
ALTER TABLE `tbloservicediscussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloservice_activity`
--
ALTER TABLE `tbloservice_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloservice_files`
--
ALTER TABLE `tbloservice_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloservice_notes`
--
ALTER TABLE `tbloservice_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloservice_settings`
--
ALTER TABLE `tbloservice_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oservice_id` (`oservice_id`);

--
-- Indexes for table `tblpayment_modes`
--
ALTER TABLE `tblpayment_modes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpinned_cases`
--
ALTER TABLE `tblpinned_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tblpinned_oservices`
--
ALTER TABLE `tblpinned_oservices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oservice_id` (`oservice_id`);

--
-- Indexes for table `tblpinned_projects`
--
ALTER TABLE `tblpinned_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tblprocurations`
--
ALTER TABLE `tblprocurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprocuration_cases`
--
ALTER TABLE `tblprocuration_cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprojectdiscussioncomments`
--
ALTER TABLE `tblprojectdiscussioncomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprojectdiscussions`
--
ALTER TABLE `tblprojectdiscussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprojects`
--
ALTER TABLE `tblprojects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tblproject_activity`
--
ALTER TABLE `tblproject_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproject_files`
--
ALTER TABLE `tblproject_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproject_members`
--
ALTER TABLE `tblproject_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tblproject_notes`
--
ALTER TABLE `tblproject_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproject_settings`
--
ALTER TABLE `tblproject_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tblproposals`
--
ALTER TABLE `tblproposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproposal_comments`
--
ALTER TABLE `tblproposal_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrelated_items`
--
ALTER TABLE `tblrelated_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblreminders`
--
ALTER TABLE `tblreminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`),
  ADD KEY `staff` (`staff`);

--
-- Indexes for table `tblroles`
--
ALTER TABLE `tblroles`
  ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `tblsales_activity`
--
ALTER TABLE `tblsales_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblservices`
--
ALTER TABLE `tblservices`
  ADD PRIMARY KEY (`serviceid`);

--
-- Indexes for table `tblsessions`
--
ALTER TABLE `tblsessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tblspam_filters`
--
ALTER TABLE `tblspam_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstaff`
--
ALTER TABLE `tblstaff`
  ADD PRIMARY KEY (`staffid`),
  ADD KEY `firstname` (`firstname`),
  ADD KEY `lastname` (`lastname`);

--
-- Indexes for table `tblstaff_departments`
--
ALTER TABLE `tblstaff_departments`
  ADD PRIMARY KEY (`staffdepartmentid`);

--
-- Indexes for table `tblsubscriptions`
--
ALTER TABLE `tblsubscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `currency` (`currency`),
  ADD KEY `tax_id` (`tax_id`),
  ADD KEY `rel_sid` (`rel_sid`),
  ADD KEY `rel_stype` (`rel_stype`);

--
-- Indexes for table `tbltaggables`
--
ALTER TABLE `tbltaggables`
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `tbltags`
--
ALTER TABLE `tbltags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tbltasks`
--
ALTER TABLE `tbltasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_id` (`rel_id`),
  ADD KEY `rel_type` (`rel_type`),
  ADD KEY `milestone` (`milestone`),
  ADD KEY `kanban_order` (`kanban_order`);

--
-- Indexes for table `tbltaskstimers`
--
ALTER TABLE `tbltaskstimers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tbltasks_checklist_templates`
--
ALTER TABLE `tbltasks_checklist_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltask_assigned`
--
ALTER TABLE `tbltask_assigned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskid` (`taskid`),
  ADD KEY `staffid` (`staffid`);

--
-- Indexes for table `tbltask_checklist_items`
--
ALTER TABLE `tbltask_checklist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskid` (`taskid`);

--
-- Indexes for table `tbltask_comments`
--
ALTER TABLE `tbltask_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `taskid` (`taskid`);

--
-- Indexes for table `tbltask_followers`
--
ALTER TABLE `tbltask_followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltaxes`
--
ALTER TABLE `tbltaxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltickets`
--
ALTER TABLE `tbltickets`
  ADD PRIMARY KEY (`ticketid`),
  ADD KEY `service` (`service`),
  ADD KEY `department` (`department`),
  ADD KEY `status` (`status`),
  ADD KEY `userid` (`userid`),
  ADD KEY `priority` (`priority`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `contactid` (`contactid`),
  ADD KEY `rel_sid` (`rel_sid`),
  ADD KEY `rel_stype` (`rel_stype`);

--
-- Indexes for table `tbltickets_pipe_log`
--
ALTER TABLE `tbltickets_pipe_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltickets_predefined_replies`
--
ALTER TABLE `tbltickets_predefined_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltickets_priorities`
--
ALTER TABLE `tbltickets_priorities`
  ADD PRIMARY KEY (`priorityid`);

--
-- Indexes for table `tbltickets_status`
--
ALTER TABLE `tbltickets_status`
  ADD PRIMARY KEY (`ticketstatusid`);

--
-- Indexes for table `tblticket_attachments`
--
ALTER TABLE `tblticket_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblticket_replies`
--
ALTER TABLE `tblticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltodos`
--
ALTER TABLE `tbltodos`
  ADD PRIMARY KEY (`todoid`);

--
-- Indexes for table `tbltracked_mails`
--
ALTER TABLE `tbltracked_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser_meta`
--
ALTER TABLE `tbluser_meta`
  ADD PRIMARY KEY (`umeta_id`);

--
-- Indexes for table `tblvault`
--
ALTER TABLE `tblvault`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblviews_tracking`
--
ALTER TABLE `tblviews_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblweb_to_lead`
--
ALTER TABLE `tblweb_to_lead`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `tblannouncements`
--
ALTER TABLE `tblannouncements`
  MODIFY `announcementid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblbranches`
--
ALTER TABLE `tblbranches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbranches_services`
--
ALTER TABLE `tblbranches_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblcasediscussioncomments`
--
ALTER TABLE `tblcasediscussioncomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcasediscussions`
--
ALTER TABLE `tblcasediscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcase_activity`
--
ALTER TABLE `tblcase_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `tblcase_files`
--
ALTER TABLE `tblcase_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblcase_notes`
--
ALTER TABLE `tblcase_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcase_settings`
--
ALTER TABLE `tblcase_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tblcities`
--
ALTER TABLE `tblcities`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `tblclients`
--
ALTER TABLE `tblclients`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblconsents`
--
ALTER TABLE `tblconsents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblconsent_purposes`
--
ALTER TABLE `tblconsent_purposes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontacts`
--
ALTER TABLE `tblcontacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontact_permissions`
--
ALTER TABLE `tblcontact_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontracts`
--
ALTER TABLE `tblcontracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontracts_types`
--
ALTER TABLE `tblcontracts_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontract_comments`
--
ALTER TABLE `tblcontract_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontract_renewals`
--
ALTER TABLE `tblcontract_renewals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcountries`
--
ALTER TABLE `tblcountries`
  MODIFY `country_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `tblcreditnotes`
--
ALTER TABLE `tblcreditnotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcreditnote_refunds`
--
ALTER TABLE `tblcreditnote_refunds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcredits`
--
ALTER TABLE `tblcredits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcurrencies`
--
ALTER TABLE `tblcurrencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcustomers_groups`
--
ALTER TABLE `tblcustomers_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcustomer_groups`
--
ALTER TABLE `tblcustomer_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomfields`
--
ALTER TABLE `tblcustomfields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomfieldsvalues`
--
ALTER TABLE `tblcustomfieldsvalues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `departmentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbldismissed_announcements`
--
ALTER TABLE `tbldismissed_announcements`
  MODIFY `dismissedannouncementid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblemailtemplates`
--
ALTER TABLE `tblemailtemplates`
  MODIFY `emailtemplateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `tblestimates`
--
ALTER TABLE `tblestimates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblevents`
--
ALTER TABLE `tblevents`
  MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblexpenses`
--
ALTER TABLE `tblexpenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblexpenses_categories`
--
ALTER TABLE `tblexpenses_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblfiles`
--
ALTER TABLE `tblfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblform_questions`
--
ALTER TABLE `tblform_questions`
  MODIFY `questionid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblform_question_box`
--
ALTER TABLE `tblform_question_box`
  MODIFY `boxid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblform_question_box_description`
--
ALTER TABLE `tblform_question_box_description`
  MODIFY `questionboxdescriptionid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblform_results`
--
ALTER TABLE `tblform_results`
  MODIFY `resultid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblgdpr_requests`
--
ALTER TABLE `tblgdpr_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblinvoicepaymentrecords`
--
ALTER TABLE `tblinvoicepaymentrecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblitemable`
--
ALTER TABLE `tblitemable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblitems`
--
ALTER TABLE `tblitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblitems_groups`
--
ALTER TABLE `tblitems_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblitem_tax`
--
ALTER TABLE `tblitem_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblknowedge_base_article_feedback`
--
ALTER TABLE `tblknowedge_base_article_feedback`
  MODIFY `articleanswerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblknowledge_base`
--
ALTER TABLE `tblknowledge_base`
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblknowledge_base_groups`
--
ALTER TABLE `tblknowledge_base_groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblleads`
--
ALTER TABLE `tblleads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblleads_email_integration`
--
ALTER TABLE `tblleads_email_integration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'the ID always must be 1', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblleads_sources`
--
ALTER TABLE `tblleads_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblleads_status`
--
ALTER TABLE `tblleads_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbllead_activity_log`
--
ALTER TABLE `tbllead_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbllead_integration_emails`
--
ALTER TABLE `tbllead_integration_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmail_queue`
--
ALTER TABLE `tblmail_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmilestones`
--
ALTER TABLE `tblmilestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblmodules`
--
ALTER TABLE `tblmodules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmy_award`
--
ALTER TABLE `tblmy_award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblmy_bank`
--
ALTER TABLE `tblmy_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_basic_services`
--
ALTER TABLE `tblmy_basic_services`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblmy_cases`
--
ALTER TABLE `tblmy_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmy_casestatus`
--
ALTER TABLE `tblmy_casestatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_cases_judges`
--
ALTER TABLE `tblmy_cases_judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmy_cases_movement_judges`
--
ALTER TABLE `tblmy_cases_movement_judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_customer_representative`
--
ALTER TABLE `tblmy_customer_representative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_employee_basic`
--
ALTER TABLE `tblmy_employee_basic`
  MODIFY `employee_basic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_holiday`
--
ALTER TABLE `tblmy_holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblmy_judges`
--
ALTER TABLE `tblmy_judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblmy_judicialdept`
--
ALTER TABLE `tblmy_judicialdept`
  MODIFY `j_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmy_members_cases`
--
ALTER TABLE `tblmy_members_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblmy_members_services`
--
ALTER TABLE `tblmy_members_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmy_newstaff`
--
ALTER TABLE `tblmy_newstaff`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_other_services`
--
ALTER TABLE `tblmy_other_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblmy_procurationstate`
--
ALTER TABLE `tblmy_procurationstate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_procurationtype`
--
ALTER TABLE `tblmy_procurationtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_projects_contacts`
--
ALTER TABLE `tblmy_projects_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblmy_projects_meta`
--
ALTER TABLE `tblmy_projects_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblmy_projects_statuses`
--
ALTER TABLE `tblmy_projects_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblmy_project_invoicepaymentrecords`
--
ALTER TABLE `tblmy_project_invoicepaymentrecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_project_invoices`
--
ALTER TABLE `tblmy_project_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_salary`
--
ALTER TABLE `tblmy_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_service_session`
--
ALTER TABLE `tblmy_service_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblmy_sessiondiscussioncomments`
--
ALTER TABLE `tblmy_sessiondiscussioncomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_sessiondiscussions`
--
ALTER TABLE `tblmy_sessiondiscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmy_session_info`
--
ALTER TABLE `tblmy_session_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblmy_training`
--
ALTER TABLE `tblmy_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmy_training_attachments`
--
ALTER TABLE `tblmy_training_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmy_transactions`
--
ALTER TABLE `tblmy_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmy_vac`
--
ALTER TABLE `tblmy_vac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblnewsfeed_comment_likes`
--
ALTER TABLE `tblnewsfeed_comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnewsfeed_posts`
--
ALTER TABLE `tblnewsfeed_posts`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnewsfeed_post_comments`
--
ALTER TABLE `tblnewsfeed_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnewsfeed_post_likes`
--
ALTER TABLE `tblnewsfeed_post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotes`
--
ALTER TABLE `tblnotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbloptions`
--
ALTER TABLE `tbloptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `tbloservicediscussioncomments`
--
ALTER TABLE `tbloservicediscussioncomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbloservicediscussions`
--
ALTER TABLE `tbloservicediscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbloservice_activity`
--
ALTER TABLE `tbloservice_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `tbloservice_files`
--
ALTER TABLE `tbloservice_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbloservice_notes`
--
ALTER TABLE `tbloservice_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbloservice_settings`
--
ALTER TABLE `tbloservice_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblpayment_modes`
--
ALTER TABLE `tblpayment_modes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblpinned_cases`
--
ALTER TABLE `tblpinned_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblpinned_oservices`
--
ALTER TABLE `tblpinned_oservices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblpinned_projects`
--
ALTER TABLE `tblpinned_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblprocurations`
--
ALTER TABLE `tblprocurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblprocuration_cases`
--
ALTER TABLE `tblprocuration_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblprojectdiscussioncomments`
--
ALTER TABLE `tblprojectdiscussioncomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblprojectdiscussions`
--
ALTER TABLE `tblprojectdiscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblprojects`
--
ALTER TABLE `tblprojects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblproject_activity`
--
ALTER TABLE `tblproject_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblproject_files`
--
ALTER TABLE `tblproject_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblproject_members`
--
ALTER TABLE `tblproject_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblproject_notes`
--
ALTER TABLE `tblproject_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblproject_settings`
--
ALTER TABLE `tblproject_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `tblproposals`
--
ALTER TABLE `tblproposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblproposal_comments`
--
ALTER TABLE `tblproposal_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblrelated_items`
--
ALTER TABLE `tblrelated_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblreminders`
--
ALTER TABLE `tblreminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblroles`
--
ALTER TABLE `tblroles`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblsales_activity`
--
ALTER TABLE `tblsales_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblservices`
--
ALTER TABLE `tblservices`
  MODIFY `serviceid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblspam_filters`
--
ALTER TABLE `tblspam_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstaff`
--
ALTER TABLE `tblstaff`
  MODIFY `staffid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblstaff_departments`
--
ALTER TABLE `tblstaff_departments`
  MODIFY `staffdepartmentid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsubscriptions`
--
ALTER TABLE `tblsubscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltags`
--
ALTER TABLE `tbltags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltasks`
--
ALTER TABLE `tbltasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbltaskstimers`
--
ALTER TABLE `tbltaskstimers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltasks_checklist_templates`
--
ALTER TABLE `tbltasks_checklist_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltask_assigned`
--
ALTER TABLE `tbltask_assigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbltask_checklist_items`
--
ALTER TABLE `tbltask_checklist_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltask_comments`
--
ALTER TABLE `tbltask_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltask_followers`
--
ALTER TABLE `tbltask_followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltaxes`
--
ALTER TABLE `tbltaxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltickets`
--
ALTER TABLE `tbltickets`
  MODIFY `ticketid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbltickets_pipe_log`
--
ALTER TABLE `tbltickets_pipe_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltickets_predefined_replies`
--
ALTER TABLE `tbltickets_predefined_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltickets_priorities`
--
ALTER TABLE `tbltickets_priorities`
  MODIFY `priorityid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbltickets_status`
--
ALTER TABLE `tbltickets_status`
  MODIFY `ticketstatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblticket_attachments`
--
ALTER TABLE `tblticket_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblticket_replies`
--
ALTER TABLE `tblticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltodos`
--
ALTER TABLE `tbltodos`
  MODIFY `todoid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltracked_mails`
--
ALTER TABLE `tbltracked_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbluser_meta`
--
ALTER TABLE `tbluser_meta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblvault`
--
ALTER TABLE `tblvault`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblviews_tracking`
--
ALTER TABLE `tblviews_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblweb_to_lead`
--
ALTER TABLE `tblweb_to_lead`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  ADD CONSTRAINT `CateServKey` FOREIGN KEY (`service_id`) REFERENCES `tblmy_basic_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `tblmy_judicialdept`
--
ALTER TABLE `tblmy_judicialdept`
  ADD CONSTRAINT `CourtJudKey` FOREIGN KEY (`c_id`) REFERENCES `tblmy_courts` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

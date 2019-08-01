-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:58 AM
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
-- Table structure for table `tblcase_activity`
--

CREATE TABLE `tblcase_activity` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `fullname` varchar(100) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT '0',
  `description_key` varchar(191) NOT NULL COMMENT 'Language file key',
  `additional_data` text,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_activity`
--

INSERT INTO `tblcase_activity` (`id`, `project_id`, `staff_id`, `contact_id`, `fullname`, `visible_to_customer`, `description_key`, `additional_data`, `dateadded`) VALUES
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
(38, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:00:17'),
(39, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:00:17'),
(40, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:00:23'),
(41, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:00:51'),
(42, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:00:51'),
(43, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:00:56'),
(44, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-28 04:02:09'),
(45, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-28 04:02:09'),
(46, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-28 04:02:14'),
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
(83, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-29 01:18:59'),
(84, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-29 01:18:59'),
(85, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-05-29 01:19:05'),
(86, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_status_updated', '<b><lang>project_status_1</lang></b>', '2019-05-29 01:19:06'),
(87, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-05-29 01:20:33'),
(88, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-29 01:24:09'),
(89, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-05-29 01:24:09'),
(90, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_removed_team_member', 'essa aned', '2019-05-29 01:45:34'),
(91, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-05-29 01:45:34'),
(92, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_removed_team_member', 'Baraa Alhalabi', '2019-05-29 01:51:20'),
(93, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-30 04:20:09'),
(94, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-30 04:20:09'),
(95, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-30 04:20:09'),
(96, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-05-30 04:20:48'),
(97, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-05-31 20:29:30'),
(98, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-05-31 20:29:30'),
(99, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-05-31 20:29:30'),
(100, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-06-01 20:27:41'),
(101, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-06-01 20:27:41'),
(102, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-06-01 20:27:41'),
(103, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-06-02 03:47:03'),
(104, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-06-02 03:47:03'),
(105, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-06-02 03:47:03'),
(106, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-06-03 04:16:19'),
(107, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-06-03 04:16:19'),
(108, 3, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-06-03 04:16:25'),
(109, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created_milestone', 'Milestone test', '2019-06-16 18:17:49'),
(110, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created_milestone', 'mali stone test', '2019-06-16 18:22:30'),
(111, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'BAIT_IWB303_MuhammadMazenALmustafa_F18_HW.docx', '2019-06-16 19:07:31'),
(112, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'BAIT_IWB303_MuhammadMazenALmustafa_F18_HW.docx', '2019-06-16 19:14:45'),
(113, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'BAIT_IWB303_MuhammadMazenALmustafa_F18_HW.docx', '2019-06-16 19:47:42'),
(114, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'اللائحة الداخلية BIT.pdf', '2019-06-17 16:23:38'),
(115, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'برنامج الفحص.png', '2019-06-17 16:39:30'),
(116, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_project_file_removed', 'برنامج الفحص.png', '2019-06-17 16:43:02'),
(117, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'برنامج الفحص-.png', '2019-06-17 16:58:41'),
(118, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_project_file_removed', 'برنامج الفحص-.png', '2019-06-17 16:58:51'),
(119, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'برنامج الفحص--.png', '2019-06-17 17:08:53'),
(120, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_project_file_removed', 'برنامج الفحص--.png', '2019-06-17 17:09:19'),
(121, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'برنامج الفحص---.png', '2019-06-17 17:09:23'),
(122, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_project_file_removed', 'برنامج الفحص---.png', '2019-06-17 17:10:45'),
(123, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'برنامج الفحص----.png', '2019-06-17 17:10:49'),
(124, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-17 17:46:56'),
(125, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-22 22:36:36'),
(126, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-22 22:46:09'),
(127, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-22 23:02:07'),
(128, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-22 23:22:13'),
(129, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'برنامج الفحص----.png<br />برنامج الفحص.png', '2019-06-22 23:24:14'),
(130, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'برنامج الفحص----.png<br />نموذج وظايف قالب.docx', '2019-06-22 23:24:15'),
(131, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-22 23:24:28'),
(132, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-22 23:25:06'),
(133, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-23 23:49:37'),
(134, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_commented_on_discussion', 'برنامج الفحص----.png', '2019-06-23 23:50:00'),
(135, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'برنامج الفحص----.png<br />Untitled-1-1.png', '2019-06-24 00:02:56'),
(136, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'برنامج الفحص----.png<br />Untitled-1.png', '2019-06-24 00:02:57'),
(137, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'برنامج الفحص----.png<br />برنامج الفحص.png', '2019-06-24 00:02:57'),
(138, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'برنامج الفحص----.png<br />برنامج الفحص-.png', '2019-06-24 00:02:59'),
(139, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_project_file_removed', 'برنامج الفحص----.png', '2019-06-24 00:26:07'),
(140, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created_milestone', 'ds', '2019-07-02 01:32:08'),
(141, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created_milestone', 'baraa', '2019-07-02 15:40:00'),
(142, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_milestone', 'ds', '2019-07-02 16:14:19'),
(143, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_milestone', 'baraa', '2019-07-02 16:21:10'),
(144, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created_milestone', '$ServID', '2019-07-02 16:21:28'),
(145, 1, 1, 0, 'Baraa Alhalabi', 0, 'project_activity_uploaded_file', 'F18DataNetworkHomework.docx', '2019-07-02 16:46:54'),
(146, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_commented_on_discussion', 'F18DataNetworkHomework.docx', '2019-07-02 16:58:30'),
(147, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_commented_on_discussion', 'F18DataNetworkHomework.docx', '2019-07-02 16:59:10'),
(148, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'F18DataNetworkHomework.docx<br />برنامج الفحص.png', '2019-07-02 16:59:25'),
(149, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_file_discussion_comment', 'F18DataNetworkHomework.docx<br />asdasdasd', '2019-07-02 16:59:27'),
(150, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_discussion', 'ss', '2019-07-02 17:51:45'),
(151, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated_discussion', 'sssxasasdasdasdasdas', '2019-07-02 17:52:09'),
(152, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_deleted_discussion', 'sssxasasdasdasdasdas', '2019-07-02 17:52:16'),
(153, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created_milestone', 'dasdasd', '2019-07-08 23:29:56'),
(154, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-07-09 17:16:10'),
(155, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-07-09 17:16:52'),
(156, 2, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-07-09 17:16:52'),
(157, 2, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-07-09 17:16:52'),
(158, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-07-09 17:17:00'),
(159, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-07-09 17:19:51'),
(160, 4, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-07-09 17:19:51'),
(161, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-07-09 17:20:15'),
(162, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'essa aned', '2019-07-09 17:20:15'),
(163, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_added_team_member', 'Baraa Alhalabi', '2019-07-09 17:20:15'),
(164, 5, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_created', '', '2019-07-09 17:20:15'),
(165, 1, 1, 0, 'Baraa Alhalabi', 1, 'project_activity_updated', '', '2019-07-09 17:41:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_activity`
--
ALTER TABLE `tblcase_activity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_activity`
--
ALTER TABLE `tblcase_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

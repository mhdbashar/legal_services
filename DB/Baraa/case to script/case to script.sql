-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 11:03 AM
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
-- Table structure for table `tblpinned_cases`
--

CREATE TABLE `tblpinned_cases` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpinned_cases`
--

INSERT INTO `tblpinned_cases` (`id`, `project_id`, `staff_id`) VALUES
(6, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblpinned_cases`
--
ALTER TABLE `tblpinned_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblpinned_cases`
--
ALTER TABLE `tblpinned_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 11:03 AM
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
-- Table structure for table `tblmy_members_cases`
--

CREATE TABLE `tblmy_members_cases` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_members_cases`
--

INSERT INTO `tblmy_members_cases` (`id`, `staff_id`, `project_id`) VALUES
(1, 2, 1),
(5, 1, 1),
(6, 2, 3),
(7, 1, 3),
(8, 2, 4),
(9, 1, 4),
(10, 2, 2),
(11, 1, 2),
(12, 2, 5),
(13, 1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_members_cases`
--
ALTER TABLE `tblmy_members_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_members_cases`
--
ALTER TABLE `tblmy_members_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `tblmy_casestatus`
--

CREATE TABLE `tblmy_casestatus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_casestatus`
--

INSERT INTO `tblmy_casestatus` (`id`, `name`) VALUES
(1, 'قيد الدراسة'),
(2, 'رفع الدعوى'),
(4, 'مرحلة النظر'),
(5, 'مرحلة الإعتراض'),
(6, 'مرحلة الإستئناف'),
(7, 'مرحلة التنفيذ'),
(8, 'الإنهاء');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_casestatus`
--
ALTER TABLE `tblmy_casestatus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_casestatus`
--
ALTER TABLE `tblmy_casestatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `tblmy_cases_judges`
--

CREATE TABLE `tblmy_cases_judges` (
  `id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_cases_judges`
--

INSERT INTO `tblmy_cases_judges` (`id`, `judge_id`, `case_id`) VALUES
(3, 3, 1),
(5, 3, 4),
(6, 3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_cases_judges`
--
ALTER TABLE `tblmy_cases_judges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `case_id` (`case_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_cases_judges`
--
ALTER TABLE `tblmy_cases_judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `tblmy_basic_services`
--

CREATE TABLE `tblmy_basic_services` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `is_primary` int(2) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_basic_services`
--

INSERT INTO `tblmy_basic_services` (`id`, `name`, `slug`, `prefix`, `numbering`, `is_primary`, `datecreated`) VALUES
(1, 'قضايا', 'kd-y', 'CASE', 1, 1, '2019-04-15 18:03:19'),
(2, 'عقود', 'aakod', 'Akd', 1, 1, '2019-05-01 19:43:08'),
(3, 'استشارات', 'stsh-r-t', 'Istsh', 1, 1, '2019-05-08 01:28:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_basic_services`
--
ALTER TABLE `tblmy_basic_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_basic_services`
--
ALTER TABLE `tblmy_basic_services`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `tblcasediscussions`
--

CREATE TABLE `tblcasediscussions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `contact_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcasediscussions`
--

INSERT INTO `tblcasediscussions` (`id`, `project_id`, `subject`, `description`, `show_to_customer`, `datecreated`, `last_activity`, `staff_id`, `contact_id`) VALUES
(1, 1, 'test hlk', 'test hlktest hlktest hlktest hlk', 1, '2019-06-23 00:51:48', NULL, 1, 0),
(2, 1, 'test hlk', 'test hlk', 1, '2019-06-23 00:52:23', NULL, 1, 0),
(5, 1, 'asdasdasd', 'asdsd', 1, '2019-07-02 17:25:12', NULL, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcasediscussions`
--
ALTER TABLE `tblcasediscussions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcasediscussions`
--
ALTER TABLE `tblcasediscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:57 AM
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
-- Table structure for table `tblcasediscussioncomments`
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
  `contact_id` int(11) DEFAULT '0',
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcasediscussioncomments`
--
ALTER TABLE `tblcasediscussioncomments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcasediscussioncomments`
--
ALTER TABLE `tblcasediscussioncomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:59 AM
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
-- Table structure for table `tblcase_settings`
--

CREATE TABLE `tblcase_settings` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_settings`
--

INSERT INTO `tblcase_settings` (`id`, `project_id`, `name`, `value`) VALUES
(39, 1, 'available_features', '0'),
(40, 1, 'view_tasks', '0'),
(41, 1, 'create_tasks', '0'),
(42, 1, 'edit_tasks', '0'),
(43, 1, 'comment_on_tasks', '0'),
(44, 1, 'view_task_comments', '0'),
(45, 1, 'view_task_attachments', '0'),
(46, 1, 'view_task_checklist_items', '0'),
(47, 1, 'upload_on_tasks', '0'),
(48, 1, 'view_task_total_logged_time', '0'),
(49, 1, 'view_finance_overview', '0'),
(50, 1, 'upload_files', '0'),
(51, 1, 'open_discussions', '0'),
(52, 1, 'view_milestones', '0'),
(53, 1, 'view_gantt', '0'),
(54, 1, 'view_timesheets', '0'),
(55, 1, 'view_activity_log', '0'),
(56, 1, 'view_team_members', '0'),
(57, 1, 'hide_tasks_on_main_tasks_table', '0'),
(58, 4, 'available_features', '0'),
(59, 4, 'view_tasks', '0'),
(60, 4, 'create_tasks', '0'),
(61, 4, 'edit_tasks', '0'),
(62, 4, 'comment_on_tasks', '0'),
(63, 4, 'view_task_comments', '0'),
(64, 4, 'view_task_attachments', '0'),
(65, 4, 'view_task_checklist_items', '0'),
(66, 4, 'upload_on_tasks', '0'),
(67, 4, 'view_task_total_logged_time', '0'),
(68, 4, 'view_finance_overview', '0'),
(69, 4, 'upload_files', '0'),
(70, 4, 'open_discussions', '0'),
(71, 4, 'view_milestones', '0'),
(72, 4, 'view_gantt', '0'),
(73, 4, 'view_timesheets', '0'),
(74, 4, 'view_activity_log', '0'),
(75, 4, 'view_team_members', '0'),
(76, 4, 'hide_tasks_on_main_tasks_table', '0'),
(77, 5, 'available_features', '0'),
(78, 5, 'view_tasks', '0'),
(79, 5, 'create_tasks', '0'),
(80, 5, 'edit_tasks', '0'),
(81, 5, 'comment_on_tasks', '0'),
(82, 5, 'view_task_comments', '0'),
(83, 5, 'view_task_attachments', '0'),
(84, 5, 'view_task_checklist_items', '0'),
(85, 5, 'upload_on_tasks', '0'),
(86, 5, 'view_task_total_logged_time', '0'),
(87, 5, 'view_finance_overview', '0'),
(88, 5, 'upload_files', '0'),
(89, 5, 'open_discussions', '0'),
(90, 5, 'view_milestones', '0'),
(91, 5, 'view_gantt', '0'),
(92, 5, 'view_timesheets', '0'),
(93, 5, 'view_activity_log', '0'),
(94, 5, 'view_team_members', '0'),
(95, 5, 'hide_tasks_on_main_tasks_table', '0'),
(96, 6, 'available_features', '0'),
(97, 6, 'view_tasks', '0'),
(98, 6, 'create_tasks', '0'),
(99, 6, 'edit_tasks', '0'),
(100, 6, 'comment_on_tasks', '0'),
(101, 6, 'view_task_comments', '0'),
(102, 6, 'view_task_attachments', '0'),
(103, 6, 'view_task_checklist_items', '0'),
(104, 6, 'upload_on_tasks', '0'),
(105, 6, 'view_task_total_logged_time', '0'),
(106, 6, 'view_finance_overview', '0'),
(107, 6, 'upload_files', '0'),
(108, 6, 'open_discussions', '0'),
(109, 6, 'view_milestones', '0'),
(110, 6, 'view_gantt', '0'),
(111, 6, 'view_timesheets', '0'),
(112, 6, 'view_activity_log', '0'),
(113, 6, 'view_team_members', '0'),
(114, 6, 'hide_tasks_on_main_tasks_table', '0'),
(115, 7, 'available_features', '0'),
(116, 7, 'view_tasks', '0'),
(117, 7, 'create_tasks', '0'),
(118, 7, 'edit_tasks', '0'),
(119, 7, 'comment_on_tasks', '0'),
(120, 7, 'view_task_comments', '0'),
(121, 7, 'view_task_attachments', '0'),
(122, 7, 'view_task_checklist_items', '0'),
(123, 7, 'upload_on_tasks', '0'),
(124, 7, 'view_task_total_logged_time', '0'),
(125, 7, 'view_finance_overview', '0'),
(126, 7, 'upload_files', '0'),
(127, 7, 'open_discussions', '0'),
(128, 7, 'view_milestones', '0'),
(129, 7, 'view_gantt', '0'),
(130, 7, 'view_timesheets', '0'),
(131, 7, 'view_activity_log', '0'),
(132, 7, 'view_team_members', '0'),
(133, 7, 'hide_tasks_on_main_tasks_table', '0'),
(134, 8, 'available_features', '0'),
(135, 8, 'view_tasks', '0'),
(136, 8, 'create_tasks', '0'),
(137, 8, 'edit_tasks', '0'),
(138, 8, 'comment_on_tasks', '0'),
(139, 8, 'view_task_comments', '0'),
(140, 8, 'view_task_attachments', '0'),
(141, 8, 'view_task_checklist_items', '0'),
(142, 8, 'upload_on_tasks', '0'),
(143, 8, 'view_task_total_logged_time', '0'),
(144, 8, 'view_finance_overview', '0'),
(145, 8, 'upload_files', '0'),
(146, 8, 'open_discussions', '0'),
(147, 8, 'view_milestones', '0'),
(148, 8, 'view_gantt', '0'),
(149, 8, 'view_timesheets', '0'),
(150, 8, 'view_activity_log', '0'),
(151, 8, 'view_team_members', '0'),
(152, 8, 'hide_tasks_on_main_tasks_table', '0'),
(153, 9, 'available_features', '0'),
(154, 9, 'view_tasks', '0'),
(155, 9, 'create_tasks', '0'),
(156, 9, 'edit_tasks', '0'),
(157, 9, 'comment_on_tasks', '0'),
(158, 9, 'view_task_comments', '0'),
(159, 9, 'view_task_attachments', '0'),
(160, 9, 'view_task_checklist_items', '0'),
(161, 9, 'upload_on_tasks', '0'),
(162, 9, 'view_task_total_logged_time', '0'),
(163, 9, 'view_finance_overview', '0'),
(164, 9, 'upload_files', '0'),
(165, 9, 'open_discussions', '0'),
(166, 9, 'view_milestones', '0'),
(167, 9, 'view_gantt', '0'),
(168, 9, 'view_timesheets', '0'),
(169, 9, 'view_activity_log', '0'),
(170, 9, 'view_team_members', '0'),
(171, 9, 'hide_tasks_on_main_tasks_table', '0'),
(191, 10, 'available_features', '0'),
(192, 10, 'view_tasks', '0'),
(193, 10, 'create_tasks', '0'),
(194, 10, 'edit_tasks', '0'),
(195, 10, 'comment_on_tasks', '0'),
(196, 10, 'view_task_comments', '0'),
(197, 10, 'view_task_attachments', '0'),
(198, 10, 'view_task_checklist_items', '0'),
(199, 10, 'upload_on_tasks', '0'),
(200, 10, 'view_task_total_logged_time', '0'),
(201, 10, 'view_finance_overview', '0'),
(202, 10, 'upload_files', '0'),
(203, 10, 'open_discussions', '0'),
(204, 10, 'view_milestones', '0'),
(205, 10, 'view_gantt', '0'),
(206, 10, 'view_timesheets', '0'),
(207, 10, 'view_activity_log', '0'),
(208, 10, 'view_team_members', '0'),
(209, 10, 'hide_tasks_on_main_tasks_table', '0'),
(210, 11, 'available_features', '0'),
(211, 11, 'view_tasks', '0'),
(212, 11, 'create_tasks', '0'),
(213, 11, 'edit_tasks', '0'),
(214, 11, 'comment_on_tasks', '0'),
(215, 11, 'view_task_comments', '0'),
(216, 11, 'view_task_attachments', '0'),
(217, 11, 'view_task_checklist_items', '0'),
(218, 11, 'upload_on_tasks', '0'),
(219, 11, 'view_task_total_logged_time', '0'),
(220, 11, 'view_finance_overview', '0'),
(221, 11, 'upload_files', '0'),
(222, 11, 'open_discussions', '0'),
(223, 11, 'view_milestones', '0'),
(224, 11, 'view_gantt', '0'),
(225, 11, 'view_timesheets', '0'),
(226, 11, 'view_activity_log', '0'),
(227, 11, 'view_team_members', '0'),
(228, 11, 'hide_tasks_on_main_tasks_table', '0'),
(324, 1, 'available_features', '0'),
(325, 1, 'view_tasks', '0'),
(326, 1, 'create_tasks', '0'),
(327, 1, 'edit_tasks', '0'),
(328, 1, 'comment_on_tasks', '0'),
(329, 1, 'view_task_comments', '0'),
(330, 1, 'view_task_attachments', '0'),
(331, 1, 'view_task_checklist_items', '0'),
(332, 1, 'upload_on_tasks', '0'),
(333, 1, 'view_task_total_logged_time', '0'),
(334, 1, 'view_finance_overview', '0'),
(335, 1, 'upload_files', '0'),
(336, 1, 'open_discussions', '0'),
(337, 1, 'view_milestones', '0'),
(338, 1, 'view_gantt', '0'),
(339, 1, 'view_timesheets', '0'),
(340, 1, 'view_activity_log', '0'),
(341, 1, 'view_team_members', '0'),
(342, 1, 'hide_tasks_on_main_tasks_table', '0'),
(343, 4, 'available_features', '0'),
(344, 4, 'view_tasks', '0'),
(345, 4, 'create_tasks', '0'),
(346, 4, 'edit_tasks', '0'),
(347, 4, 'comment_on_tasks', '0'),
(348, 4, 'view_task_comments', '0'),
(349, 4, 'view_task_attachments', '0'),
(350, 4, 'view_task_checklist_items', '0'),
(351, 4, 'upload_on_tasks', '0'),
(352, 4, 'view_task_total_logged_time', '0'),
(353, 4, 'view_finance_overview', '0'),
(354, 4, 'upload_files', '0'),
(355, 4, 'open_discussions', '0'),
(356, 4, 'view_milestones', '0'),
(357, 4, 'view_gantt', '0'),
(358, 4, 'view_timesheets', '0'),
(359, 4, 'view_activity_log', '0'),
(360, 4, 'view_team_members', '0'),
(361, 4, 'hide_tasks_on_main_tasks_table', '0'),
(362, 4, 'available_features', '0'),
(363, 4, 'view_tasks', '0'),
(364, 4, 'create_tasks', '0'),
(365, 4, 'edit_tasks', '0'),
(366, 4, 'comment_on_tasks', '0'),
(367, 4, 'view_task_comments', '0'),
(368, 4, 'view_task_attachments', '0'),
(369, 4, 'view_task_checklist_items', '0'),
(370, 4, 'upload_on_tasks', '0'),
(371, 4, 'view_task_total_logged_time', '0'),
(372, 4, 'view_finance_overview', '0'),
(373, 4, 'upload_files', '0'),
(374, 4, 'open_discussions', '0'),
(375, 4, 'view_milestones', '0'),
(376, 4, 'view_gantt', '0'),
(377, 4, 'view_timesheets', '0'),
(378, 4, 'view_activity_log', '0'),
(379, 4, 'view_team_members', '0'),
(380, 4, 'hide_tasks_on_main_tasks_table', '0'),
(381, 5, 'available_features', '0'),
(382, 5, 'view_tasks', '0'),
(383, 5, 'create_tasks', '0'),
(384, 5, 'edit_tasks', '0'),
(385, 5, 'comment_on_tasks', '0'),
(386, 5, 'view_task_comments', '0'),
(387, 5, 'view_task_attachments', '0'),
(388, 5, 'view_task_checklist_items', '0'),
(389, 5, 'upload_on_tasks', '0'),
(390, 5, 'view_task_total_logged_time', '0'),
(391, 5, 'view_finance_overview', '0'),
(392, 5, 'upload_files', '0'),
(393, 5, 'open_discussions', '0'),
(394, 5, 'view_milestones', '0'),
(395, 5, 'view_gantt', '0'),
(396, 5, 'view_timesheets', '0'),
(397, 5, 'view_activity_log', '0'),
(398, 5, 'view_team_members', '0'),
(399, 5, 'hide_tasks_on_main_tasks_table', '0'),
(400, 1, 'available_features', 'a:1:{s:16:\"project_activity\";i:1;}'),
(401, 1, 'view_tasks', '0'),
(402, 1, 'create_tasks', '0'),
(403, 1, 'edit_tasks', '0'),
(404, 1, 'comment_on_tasks', '0'),
(405, 1, 'view_task_comments', '0'),
(406, 1, 'view_task_attachments', '0'),
(407, 1, 'view_task_checklist_items', '0'),
(408, 1, 'upload_on_tasks', '0'),
(409, 1, 'view_task_total_logged_time', '0'),
(410, 1, 'view_finance_overview', '0'),
(411, 1, 'upload_files', '0'),
(412, 1, 'open_discussions', '0'),
(413, 1, 'view_milestones', '0'),
(414, 1, 'view_gantt', '0'),
(415, 1, 'view_timesheets', '0'),
(416, 1, 'view_activity_log', '0'),
(417, 1, 'view_team_members', '0'),
(418, 1, 'hide_tasks_on_main_tasks_table', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_settings`
--
ALTER TABLE `tblcase_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_settings`
--
ALTER TABLE `tblcase_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:59 AM
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
-- Table structure for table `tblcase_notes`
--

CREATE TABLE `tblcase_notes` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_notes`
--

INSERT INTO `tblcase_notes` (`id`, `project_id`, `content`, `staff_id`) VALUES
(1, 1, 'asdasdasdsdfsdfsdfsdfs', 1),
(2, 3, 'fghfghfghfgh', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_notes`
--
ALTER TABLE `tblcase_notes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_notes`
--
ALTER TABLE `tblcase_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:59 AM
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
-- Table structure for table `tblcase_movement`
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
  `deadline` date DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `description` text NOT NULL,
  `case_result` varchar(255) NOT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_movement`
--

INSERT INTO `tblcase_movement` (`id`, `numbering`, `code`, `name`, `clientid`, `representative`, `cat_id`, `subcat_id`, `court_id`, `jud_num`, `country`, `city`, `billing_type`, `case_status`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `case_result`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `case_id`) VALUES
(1, NULL, 'CASE1', 'test case moement', 9, 3, 1, 2, 1, 5, 194, 'Khobar', 1, 2, 2, 0, '123.00', '2019-05-01', '2019-07-09', NULL, NULL, 'test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test&nbsp;', 'متداولة', 1, '2.00', 0, 0, 1, 1),
(2, NULL, 'CASE1', 'test case moement', 9, 3, 1, 2, 1, 5, 194, 'Khobar', 1, 2, 2, 0, '123.00', '2019-05-01', '2019-07-09', NULL, NULL, 'test case moement&nbsp;', 'متداولة', 1, '2.00', 0, 0, 1, 0),
(3, NULL, 'CASE1', 'test case moement', 9, 3, 1, 2, 1, 5, 194, 'Khobar', 1, 2, 2, 0, '123.00', '2019-05-01', '2019-07-09', NULL, NULL, 'test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement test case moement&nbsp;', 'متداولة', 1, '2.00', 0, 0, 1, 0),
(4, NULL, 'CASE1', 'test case moement after edit', 9, 3, 1, 2, 1, 5, 194, 'Khobar', 1, 2, 2, 0, '123.00', '2019-05-01', '2019-07-09', NULL, NULL, 'test&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edit', 'متداولة', 1, '2.00', 0, 0, 1, 0),
(5, NULL, 'CASE1', 'test case moement after edit test case moement after edit', 9, 3, 1, 2, 1, 5, 194, 'Khobar', 1, 2, 2, 0, '123.00', '2019-05-01', '2019-07-09', NULL, NULL, 'test&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edittest&nbsp;case moement after edit', 'متداولة', 1, '2.00', 0, 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_id` (`case_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `tblcase_files`
--

CREATE TABLE `tblcase_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `description` text,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `visible_to_customer` tinyint(1) DEFAULT '0',
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `external` varchar(40) DEFAULT NULL,
  `external_link` text,
  `thumbnail_link` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcase_files`
--

INSERT INTO `tblcase_files` (`id`, `file_name`, `subject`, `description`, `filetype`, `dateadded`, `last_activity`, `project_id`, `visible_to_customer`, `staffid`, `contact_id`, `external`, `external_link`, `thumbnail_link`) VALUES
(1, 'F18DataNetworkHomework.docx', 'F18DataNetworkHomework.docx', NULL, 'application/vnd.openxmlformats-officedocument.word', '2019-07-02 16:46:54', '2019-07-02 16:59:10', 1, 1, 1, 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcase_files`
--
ALTER TABLE `tblcase_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcase_files`
--
ALTER TABLE `tblcase_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `tblmy_categories`
--

CREATE TABLE `tblmy_categories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_id` int(255) NOT NULL,
  `parent_id` int(255) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_categories`
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CateServKey` (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblmy_categories`
--
ALTER TABLE `tblmy_categories`
  ADD CONSTRAINT `CateServKey` FOREIGN KEY (`service_id`) REFERENCES `tblmy_basic_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 11:02 AM
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
-- Table structure for table `tblmy_courts`
--

CREATE TABLE `tblmy_courts` (
  `c_id` int(255) NOT NULL,
  `court_name` varchar(255) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_courts`
--

INSERT INTO `tblmy_courts` (`c_id`, `court_name`, `datecreated`) VALUES
(1, 'محكمة دمشق القانونية', '2019-04-06 20:28:14'),
(2, 'تجريب', '2019-05-21 00:24:25'),
(3, 'تجريب1', '2019-05-21 00:26:21'),
(4, 'تجريب', '2019-05-21 00:27:06'),
(6, 'محكمة الشاغور', '2019-05-31 23:44:37'),
(11, 'last test', '2019-06-01 00:02:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  ADD PRIMARY KEY (`c_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  MODIFY `c_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

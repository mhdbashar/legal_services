-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2020 at 06:30 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `office_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblactivity_log`
--

CREATE TABLE `tblactivity_log` (
  `id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `staffid` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblactivity_log`
--

INSERT INTO `tblactivity_log` (`id`, `description`, `date`, `staffid`) VALUES
(1, 'New User Added [ID: 1, Name: legal_serv1]', '2020-09-28 19:59:29', 'Mhdbashar  '),
(2, 'New User Added [ID: 2, Name: legal_serv2]', '2020-09-28 20:11:07', 'Mhdbashar  '),
(3, 'New Client Created [ID: 1]', '2020-09-28 20:12:01', NULL),
(4, 'Failed to send email template - The following From address failed: root@localhost : MAIL FROM command failed,Access denied - Invalid HELO name (See RFC2821 4.1.1.1)\r\n,550,SMTP server error: MAIL FROM command failed Detail: Access denied - Invalid HELO name (See RFC2821 4.1.1.1)\r\n SMTP code: 550SMTP server error: MAIL FROM command failed Detail: Access denied - Invalid HELO name (See RFC2821 4.1.1.1)\r\n SMTP code: 550<br /><pre>\n\n</pre>', '2020-09-28 20:12:06', NULL),
(5, 'Contact Created [ID: 1]', '2020-09-28 20:12:06', NULL),
(6, 'New قضايا Added [ServiceID: 2]', '2020-09-28 20:49:57', NULL),
(7, 'New قضايا Added [ServiceID: 4]', '2020-09-28 20:54:35', NULL),
(8, 'imported Moved To Recycle Bin [ServiceID: 1]', '2020-09-28 20:54:50', 'Mhdbashar  '),
(9, 'imported Moved To Recycle Bin [ServiceID: 2]', '2020-09-28 20:54:59', 'Mhdbashar  '),
(10, 'imported Moved To Recycle Bin [ServiceID: 3]', '2020-09-28 20:55:06', 'Mhdbashar  '),
(11, 'imported Moved To Recycle Bin [ServiceID: 4]', '2020-09-28 20:55:13', 'Mhdbashar  '),
(12, 'User Deleted [ID: 2]', '2020-10-02 19:25:04', 'Mhdbashar  '),
(13, 'User Deleted [ID: 1]', '2020-10-02 19:25:12', 'Mhdbashar  ');

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncements`
--

CREATE TABLE `tblannouncements` (
  `announcementid` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `message` text,
  `showtousers` int(11) NOT NULL,
  `showtostaff` int(11) NOT NULL,
  `showname` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  `userid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `tblcase_movement`
--

CREATE TABLE `tblcase_movement` (
  `id` int(11) NOT NULL,
  `numbering` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(191) NOT NULL,
  `opponent_id` int(11) NOT NULL,
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
  `inserted_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` date DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `description` text NOT NULL,
  `case_result` varchar(255) NOT NULL,
  `file_number_case` int(11) DEFAULT NULL,
  `file_number_court` int(11) DEFAULT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `previous_case_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `tblcase_settings`
--

CREATE TABLE `tblcase_settings` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory_types`
--

CREATE TABLE `tblcategory_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcategory_types`
--

INSERT INTO `tblcategory_types` (`id`, `type`) VALUES
(1, 'خدمة قانونية'),
(2, 'اجراء قانوني');

-- --------------------------------------------------------

--
-- Table structure for table `tblcities`
--

CREATE TABLE `tblcities` (
  `Id` int(11) NOT NULL,
  `Name_en` char(100) NOT NULL,
  `Name_ar` char(100) NOT NULL,
  `Country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcities`
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
-- Table structure for table `tblclients`
--

CREATE TABLE `tblclients` (
  `userid` int(11) NOT NULL,
  `company` varchar(191) DEFAULT NULL,
  `vat` varchar(50) DEFAULT NULL,
  `phonenumber` varchar(30) DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT '0',
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `leadid` int(11) DEFAULT NULL,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT '0',
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT '0',
  `longitude` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `default_language` varchar(40) DEFAULT NULL,
  `default_currency` int(11) NOT NULL DEFAULT '0',
  `show_primary_contact` int(11) NOT NULL DEFAULT '0',
  `stripe_id` varchar(40) DEFAULT NULL,
  `registration_confirmed` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL DEFAULT '0',
  `individual` tinyint(4) NOT NULL DEFAULT '1',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `client_type` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblclients`
--

INSERT INTO `tblclients` (`userid`, `company`, `vat`, `phonenumber`, `country`, `city`, `zip`, `state`, `address`, `website`, `datecreated`, `active`, `leadid`, `billing_street`, `billing_city`, `billing_state`, `billing_zip`, `billing_country`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `longitude`, `latitude`, `default_language`, `default_currency`, `show_primary_contact`, `stripe_id`, `registration_confirmed`, `addedfrom`, `individual`, `branch_id`, `client_type`) VALUES
(1, 'شركة زاهر', '', '', 0, '', '', '', '', '', '2020-09-28 20:12:01', 1, NULL, '', '', '', '', 0, '', '', '', '', 0, NULL, NULL, '', 0, 0, NULL, 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblconsents`
--

CREATE TABLE `tblconsents` (
  `id` int(11) NOT NULL,
  `action` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(40) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `lead_id` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `opt_in_purpose_description` text,
  `purpose_id` int(11) NOT NULL,
  `staff_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblconsent_purposes`
--

CREATE TABLE `tblconsent_purposes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `date_created` datetime NOT NULL,
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontacts`
--

CREATE TABLE `tblcontacts` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `is_primary` int(11) NOT NULL DEFAULT '1',
  `firstname` varchar(191) DEFAULT NULL,
  `lastname` varchar(191) DEFAULT NULL,
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
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_image` varchar(191) DEFAULT NULL,
  `direction` varchar(3) DEFAULT NULL,
  `invoice_emails` tinyint(1) NOT NULL DEFAULT '1',
  `estimate_emails` tinyint(1) NOT NULL DEFAULT '1',
  `credit_note_emails` tinyint(1) NOT NULL DEFAULT '1',
  `contract_emails` tinyint(1) NOT NULL DEFAULT '1',
  `task_emails` tinyint(1) NOT NULL DEFAULT '1',
  `project_emails` tinyint(1) NOT NULL DEFAULT '1',
  `ticket_emails` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcontacts`
--

INSERT INTO `tblcontacts` (`id`, `userid`, `is_primary`, `firstname`, `lastname`, `email`, `phonenumber`, `title`, `datecreated`, `password`, `new_pass_key`, `new_pass_key_requested`, `email_verified_at`, `email_verification_key`, `email_verification_sent_at`, `last_ip`, `last_login`, `last_password_change`, `active`, `profile_image`, `direction`, `invoice_emails`, `estimate_emails`, `credit_note_emails`, `contract_emails`, `task_emails`, `project_emails`, `ticket_emails`) VALUES
(1, 1, 1, 'شركة زاهر', NULL, 'hiastskype@gmail.com', '', NULL, '2020-09-28 20:12:02', '$2a$08$F32b2shIYd49FYUTZYyQyOVZGCGg3LTrb9KYEqzlPJsGS3Aei36Hm', NULL, NULL, '2020-09-28 20:12:01', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact_permissions`
--

CREATE TABLE `tblcontact_permissions` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcontact_permissions`
--

INSERT INTO `tblcontact_permissions` (`id`, `permission_id`, `userid`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontracts`
--

CREATE TABLE `tblcontracts` (
  `id` int(11) NOT NULL,
  `content` longtext,
  `description` text,
  `subject` varchar(191) DEFAULT NULL,
  `client` int(11) NOT NULL,
  `datestart` date DEFAULT NULL,
  `dateend` date DEFAULT NULL,
  `contract_type` int(11) DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  `isexpirynotified` int(11) NOT NULL DEFAULT '0',
  `contract_value` decimal(15,2) DEFAULT NULL,
  `trash` tinyint(1) DEFAULT '0',
  `not_visible_to_client` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(32) DEFAULT NULL,
  `signed` tinyint(1) NOT NULL DEFAULT '0',
  `signature` varchar(40) DEFAULT NULL,
  `marked_as_signed` tinyint(1) NOT NULL DEFAULT '0',
  `acceptance_firstname` varchar(50) DEFAULT NULL,
  `acceptance_lastname` varchar(50) DEFAULT NULL,
  `acceptance_email` varchar(100) DEFAULT NULL,
  `acceptance_date` datetime DEFAULT NULL,
  `acceptance_ip` varchar(40) DEFAULT NULL,
  `type_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontracts_types`
--

CREATE TABLE `tblcontracts_types` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontract_comments`
--

CREATE TABLE `tblcontract_comments` (
  `id` int(11) NOT NULL,
  `content` mediumtext,
  `contract_id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontract_renewals`
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
  `renewed_by_staff_id` int(11) NOT NULL DEFAULT '0',
  `is_on_old_expiry_notified` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcountries`
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
-- Dumping data for table `tblcountries`
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
-- Table structure for table `tblcreditnotes`
--

CREATE TABLE `tblcreditnotes` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT '1',
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `adminnote` text,
  `terms` text,
  `clientnote` text,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `project_id` int(11) NOT NULL DEFAULT '0',
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `discount_percent` decimal(15,2) DEFAULT '0.00',
  `discount_total` decimal(15,2) DEFAULT '0.00',
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
  `show_shipping_on_credit_note` tinyint(1) NOT NULL DEFAULT '1',
  `show_quantity_as` int(11) NOT NULL DEFAULT '1',
  `reference_no` varchar(100) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcreditnote_refunds`
--

CREATE TABLE `tblcreditnote_refunds` (
  `id` int(11) NOT NULL,
  `credit_note_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `refunded_on` date NOT NULL,
  `payment_mode` varchar(40) NOT NULL,
  `note` text,
  `amount` decimal(15,2) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcredits`
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
-- Table structure for table `tblcurrencies`
--

CREATE TABLE `tblcurrencies` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `decimal_separator` varchar(5) DEFAULT NULL,
  `thousand_separator` varchar(5) DEFAULT NULL,
  `placement` varchar(10) DEFAULT NULL,
  `isdefault` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcurrencies`
--

INSERT INTO `tblcurrencies` (`id`, `symbol`, `name`, `decimal_separator`, `thousand_separator`, `placement`, `isdefault`) VALUES
(1, '$', 'USD', '.', ',', 'before', 0),
(2, 'â‚¬', 'EUR', ',', '.', 'before', 0),
(3, 'SR', 'SAR', ',', '.', 'before', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers_groups`
--

CREATE TABLE `tblcustomers_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer_admins`
--

CREATE TABLE `tblcustomer_admins` (
  `staff_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_assigned` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer_groups`
--

CREATE TABLE `tblcustomer_groups` (
  `id` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomfields`
--

CREATE TABLE `tblcustomfields` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomfieldsvalues`
--

CREATE TABLE `tblcustomfieldsvalues` (
  `id` int(11) NOT NULL,
  `relid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `fieldto` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `departmentid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `imap_username` varchar(191) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_from_header` tinyint(1) NOT NULL DEFAULT '0',
  `host` varchar(150) DEFAULT NULL,
  `password` mediumtext,
  `encryption` varchar(3) DEFAULT NULL,
  `delete_after_import` int(11) NOT NULL DEFAULT '0',
  `calendar_id` mediumtext,
  `hidefromclient` tinyint(1) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbldismissed_announcements`
--

CREATE TABLE `tbldismissed_announcements` (
  `dismissedannouncementid` int(11) NOT NULL,
  `announcementid` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblemaillists`
--

CREATE TABLE `tblemaillists` (
  `listid` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `creator` varchar(100) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblemailtemplates`
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
  `plaintext` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblemailtemplates`
--

INSERT INTO `tblemailtemplates` (`emailtemplateid`, `type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
(1, 'client', 'new-client-created', 'english', 'New Contact Added/Registered (Welcome Email)', 'Welcome aboard', 'Dear {contact_fullname}<br /><br />Thank you for registering on the <strong>{companyname}</strong> Portal System.<br /><br />We just wanted to say welcome.<br /><br />Please contact us if you need any help.<br /><br />Click here to view your profile: <a href=\"{crm_url}\">{crm_url}</a><br /><br />Kind Regards, <br />{email_signature}<br /><br />(This is an automated email, so please don\'t reply to this email address)', '{companyname}', '', 0, 1, 0),
(2, 'invoice', 'invoice-send-to-client', 'english', 'Send Invoice to Customer', 'Invoice with number {invoice_number} created', '<span style=\"font-size: 12pt;\">Dear {contact_fullname}</span><br /><br /><span style=\"font-size: 12pt;\">We have prepared the following invoice for you: <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Invoice status</strong>: {invoice_status}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(3, 'ticket', 'new-ticket-opened-admin', 'english', 'New Ticket Opened (Opened by Staff, Sent to Customer)', 'New Support Ticket Opened', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi {contact_fullname}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">New support ticket has been opened.</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {ticket_subject}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Department:</strong> {ticket_department}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {ticket_priority}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{ticket_message}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}<br /><br /></a>Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(4, 'ticket', 'ticket-reply', 'english', 'Ticket Reply (Sent to Customer)', 'New Ticket Reply', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi <strong>{contact_fullname}</strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You have a new ticket reply to ticket <a href=\"{ticket_url}\">#{ticket_id}</a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Ticket Subject:</strong> {ticket_subject}<br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{ticket_message}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(5, 'ticket', 'ticket-autoresponse', 'english', 'New Ticket Opened - Autoresponse', 'New Support Ticket Opened', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi {contact_fullname}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Thank you for contacting our support team. A support ticket has now been opened for your request. You will be notified when a response is made by email.</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {ticket_subject}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {ticket_priority}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{ticket_message}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname} ', '', 0, 1, 0),
(6, 'invoice', 'invoice-payment-recorded', 'english', 'Invoice Payment Recorded (Sent to Customer)', 'Invoice Payment Recorded', '<span style=\"font-size: 12pt;\">Hello {contact_fullname}<br /><br /></span>Thank you for the payment. Find the payment details below:<br /><br />-------------------------------------------------<br /><br />Amount:&nbsp;<strong>{payment_total}<br /></strong>Date:&nbsp;<strong>{payment_date}</strong><br />Invoice number:&nbsp;<span style=\"font-size: 12pt;\"><strong># {invoice_number}<br /><br /></strong></span>-------------------------------------------------<br /><br />You can always view the invoice for this payment at the following link:&nbsp;<a href=\"{invoice_link}\"><span style=\"font-size: 12pt;\">{invoice_number}</span></a><br /><br />We are looking forward working with you.<br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(7, 'invoice', 'invoice-overdue-notice', 'english', 'Invoice Overdue Notice', 'Invoice Overdue Notice - {invoice_number}', '<span style=\"font-size: 12pt;\">Hi </span>{contact_fullname}<br /><br /><span style=\"font-size: 12pt;\">This is an overdue notice for invoice <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\">This invoice was due: {invoice_duedate}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(8, 'invoice', 'invoice-already-send', 'english', 'Invoice Already Sent to Customer', 'Invoice # {invoice_number} ', '<span style=\"font-size: 12pt;\">Hi {contact_fullname}</span><br /><br /><span style=\"font-size: 12pt;\">At your request, here is the invoice with number <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(9, 'ticket', 'new-ticket-created-staff', 'english', 'New Ticket Created (Opened by Customer, Sent to Staff Members)', 'New Ticket Created', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">A new support ticket has been opened.</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject</strong>: {ticket_subject}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Priority</strong>: {ticket_priority}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{ticket_message}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}<br /></a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(10, 'estimate', 'estimate-send-to-client', 'english', 'Send Estimate to Customer', 'Estimate # {estimate_number} created', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {contact_fullname}<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please find the attached estimate <strong># {estimate_number}<br /><br /></strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Estimate status:</strong> {estimate_status}<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}<br /><br /></a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">We look forward to your communication.</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}<br /></span></div>', '{companyname}', '', 0, 1, 0),
(11, 'ticket', 'ticket-reply-to-admin', 'english', 'Ticket Reply (Sent to Staff)', 'New Support Ticket Reply', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">A new support ticket reply from {contact_fullname}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject</strong>: {ticket_subject}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Priority</strong>: {ticket_priority}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{ticket_message}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(12, 'estimate', 'estimate-already-send', 'english', 'Estimate Already Sent to Customer', 'Estimate # {estimate_number} ', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {contact_fullname}</span></div>\r\n<br /><br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Thank you for your estimate request.</span></div>\r\n<br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please contact us for more information.</span></div>\r\n<br /><br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(13, 'contract', 'contract-expiration', 'english', 'Contract Expiration Reminder (Sent to Customer Contacts)', 'Contract Expiration Reminder', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {client_company}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">This is a reminder that the following contract will expire soon:</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {contract_subject}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Description:</strong> {contract_description}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {contract_datestart}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {contract_dateend}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please contact us for more information.</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(14, 'tasks', 'task-assigned', 'english', 'New Task Assigned (Sent to Staff)', 'New Task Assigned to You - {task_name}', '<span style=\"font-size: 12pt;\">Dear {staff_fullname}</span><br /><br /><span style=\"font-size: 12pt;\">You have been assigned to a new task:</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}<br /></span><strong>Start Date:</strong> {task_startdate}<br /><span style=\"font-size: 12pt;\"><strong>Due date:</strong> {task_duedate}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {task_priority}<br /><br /></span><span style=\"font-size: 12pt;\"><span>You can view the task on the following link</span>: <a href=\"{task_link}\">{task_name}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(15, 'tasks', 'task-added-as-follower', 'english', 'Staff Member Added as Follower on Task (Sent to Staff)', 'You are added as follower on task - {task_name}', '<span style=\"font-size: 12pt;\">Hi {staff_fullname}<br /></span><br /><span style=\"font-size: 12pt;\">You have been added as follower on the following task:</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}</span><br /><span style=\"font-size: 12pt;\"><strong>Start date:</strong> {task_startdate}</span><br /><br /><span>You can view the task on the following link</span><span>: </span><a href=\"{task_link}\">{task_name}</a><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(16, 'tasks', 'task-commented', 'english', 'New Comment on Task (Sent to Staff)', 'New Comment on Task - {task_name}', 'Dear <span style=\"font-size: 12pt;\">{staff_fullname}</span><br /><br />A comment has been made on the following task:<br /><br /><strong>Name:</strong> {task_name}<br /><strong>Comment:</strong> {task_comment}<br /><br />You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(17, 'tasks', 'task-added-attachment', 'english', 'New Attachment(s) on Task (Sent to Staff)', 'New Attachment on Task - {task_name}', 'Hi {staff_firstname}<br /><br /><strong>{task_user_take_action}</strong> added an attachment on the following task:<br /><br /><strong>Name:</strong> {task_name}<br /><br />You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(18, 'estimate', 'estimate-declined-to-staff', 'english', 'Estimate Declined (Sent to Staff)', 'Customer Declined Estimate', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi</span></div>\r\n<br /><br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Customer ({client_company}) declined estimate with number <strong># {estimate_number}</strong></span></div>\r\n<br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span></div>\r\n<br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(19, 'estimate', 'estimate-accepted-to-staff', 'english', 'Estimate Accepted (Sent to Staff)', 'Customer Accepted Estimate', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Customer ({client_company}) accepted estimate with number <strong># {estimate_number}<br /><br /></strong></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}<br /><br /></a></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(20, 'proposals', 'proposal-client-accepted', 'english', 'Customer Action - Accepted (Sent to Staff)', 'Customer Accepted Proposal', '<div>Hi<br /><br />Client <strong>{proposal_proposal_to}</strong> accepted the following proposal:<br /><br /><strong>Number:</strong> {proposal_number}<br /><strong>Subject</strong>: {proposal_subject}<br /><strong>Total</strong>: {proposal_total}<br /><br />View the proposal on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /><br />Kind Regards,<br />{email_signature}</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>', '{companyname}', '', 0, 1, 0),
(21, 'proposals', 'proposal-send-to-customer', 'english', 'Send Proposal to Customer', 'Proposal With Number {proposal_number} Created', 'Dear {proposal_proposal_to}<br /><br />Please find our attached proposal.<br /><br />This proposal is valid until: {proposal_open_till}<br />You can view the proposal on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /><br />Please don\'t hesitate to comment online if you have any questions.<br /><br />We look forward to your communication.<br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(22, 'proposals', 'proposal-client-declined', 'english', 'Customer Action - Declined (Sent to Staff)', 'Client Declined Proposal', 'Hi<br /><br />Customer <strong>{proposal_proposal_to}</strong> declined the proposal <strong>{proposal_subject}</strong><br /><br />View the proposal on the following link <a href=\"{proposal_link}\">{proposal_number}</a>&nbsp;or from the admin area.<br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(23, 'proposals', 'proposal-client-thank-you', 'english', 'Thank You Email (Sent to Customer After Accept)', 'Thank for you accepting proposal', 'Dear {proposal_proposal_to}<br /><br />Thank for for accepting the proposal.<br /><br />We look forward to doing business with you.<br /><br />We will contact you as soon as possible<br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(24, 'proposals', 'proposal-comment-to-client', 'english', 'New Comment Â (Sent to Customer/Lead)', 'New Proposal Comment', 'Dear {proposal_proposal_to}<br /><br />A new comment has been made on the following proposal: <strong>{proposal_number}</strong><br /><br />You can view and reply to the comment on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(25, 'proposals', 'proposal-comment-to-admin', 'english', 'New Comment (Sent to Staff) ', 'New Proposal Comment', 'Hi<br /><br />A new comment has been made to the proposal <strong>{proposal_subject}</strong><br /><br />You can view and reply to the comment on the following link: <a href=\"{proposal_link}\">{proposal_number}</a>&nbsp;or from the admin area.<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(26, 'estimate', 'estimate-thank-you-to-customer', 'english', 'Thank You Email (Sent to Customer After Accept)', 'Thank for you accepting estimate', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {contact_fullname}<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Thank for for accepting the estimate.<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">We look forward to doing business with you.<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">We will contact you as soon as possible.<br /><br /></span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(27, 'tasks', 'task-deadline-notification', 'english', 'Task Deadline Reminder - Sent to Assigned Members', 'Task Deadline Reminder', 'Hi <span style=\"font-size: 12pt;\">{staff_fullname}</span><br /><br />This is an automated email from {companyname}.<br /><br />The task <strong>{task_name}</strong> deadline is on <strong>{task_duedate}</strong>. <br />This task is still not finished.<br /><br />You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a><br /><br />Kind Regards,<br />{email_signature}', '{companyname} ', '', 0, 1, 0),
(28, 'contract', 'send-contract', 'english', 'Send Contract to Customer', 'Contract - {contract_subject}', '<p><span style=\"font-size: 12pt;\">Hi {contact_fullname}</span><br /><br /><span style=\"font-size: 12pt;\">Please find the {contract_subject} attached.<br /><br /></span><span style=\"font-size: 12pt;\">Looking forward to hear from you.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname}', '', 0, 1, 0),
(29, 'invoice', 'invoice-payment-recorded-to-staff', 'english', 'Invoice Payment Recorded (Sent to Staff)', 'New Invoice Payment', '<span style=\"font-size: 12pt;\">Hi</span><br /><br /><span style=\"font-size: 12pt;\">Customer recorded payment for invoice <strong># {invoice_number}</strong></span><br /><br /><span style=\"font-size: 12pt;\">You can view the invoice on the following link: <a href=\"{invoice_link}\">{invoice_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(30, 'ticket', 'auto-close-ticket', 'english', 'Auto Close Ticket', 'Ticket Auto Closed', '<p style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi {contact_fullname}</span><br /><br /><span style=\"font-size: 12pt;\">Ticket {ticket_subject} has been auto close due to inactivity.</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Ticket #</strong>: <a href=\"{ticket_url}\">{ticket_id}</a></span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority:</strong> {ticket_priority}</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname} ', '', 0, 1, 0),
(31, 'project', 'new-project-discussion-created-to-staff', 'english', 'New Project Discussion (Sent to Project Members)', 'New Project Discussion Created - {project_name}', '<p>Hi {staff_fullname}<br /><br />New project discussion created from <strong>{discussion_creator}</strong><br /><br /><strong>Subject:</strong> {discussion_subject}<br /><strong>Description:</strong> {discussion_description}<br /><br />You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(32, 'project', 'new-project-discussion-created-to-customer', 'english', 'New Project Discussion (Sent to Customer Contacts)', 'New Project Discussion Created - {project_name}', '<p>Hello {contact_fullname}<br /><br />New project discussion created from <strong>{discussion_creator}</strong><br /><br /><strong>Subject:</strong> {discussion_subject}<br /><strong>Description:</strong> {discussion_description}<br /><br />You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(33, 'project', 'new-project-file-uploaded-to-customer', 'english', 'New Project File(s) Uploaded (Sent to Customer Contacts)', 'New Project File(s) Uploaded - {project_name}', '<p>Hello {contact_fullname}<br><br>New project file is uploaded on <strong>{project_name}</strong> from <strong>{file_creator}</strong><br><br>You can view the project on the following link: <a href=\"%7Bproject_link%7D\">{project_name}</a><br><br>To view the file in our CRM you can click on the following link: <a href=\"%7Bdiscussion_link%7D\">{discussion_subject}</a><br><br>Kind Regards,<br>{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(34, 'project', 'new-project-file-uploaded-to-staff', 'english', 'New Project File(s) Uploaded (Sent to Project Members)', 'New Project File(s) Uploaded - {project_name}', '<p>Hello {staff_fullname}</p>\r\n<p>New project&nbsp;file is uploaded on&nbsp;<strong>{project_name}</strong> from&nbsp;<strong>{file_creator}</strong></p>\r\n<p>You can view the project on the following link: <a href=\"{project_link}\">{project_name}<br /></a><br />To view&nbsp;the file you can click on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a></p>\r\n<p>Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(35, 'project', 'new-project-discussion-comment-to-customer', 'english', 'New Discussion Comment  (Sent to Customer Contacts)', 'New Discussion Comment', '<p><span style=\"font-size: 12pt;\">Hello {contact_fullname}</span><br /><br /><span style=\"font-size: 12pt;\">New discussion comment has been made on <strong>{discussion_subject}</strong> from <strong>{comment_creator}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Discussion subject:</strong> {discussion_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Comment</strong>: {discussion_comment}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname}', '', 0, 1, 0),
(36, 'project', 'new-project-discussion-comment-to-staff', 'english', 'New Discussion Comment (Sent to Project Members)', 'New Discussion Comment', '<p>Hi {staff_fullname}<br /><br />New discussion comment has been made on <strong>{discussion_subject}</strong> from <strong>{comment_creator}</strong><br /><br /><strong>Discussion subject:</strong> {discussion_subject}<br /><strong>Comment:</strong> {discussion_comment}<br /><br />You can view the discussion on the following link: <a href=\"{discussion_link}\">{discussion_subject}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(37, 'project', 'staff-added-as-project-member', 'english', 'Staff Added as Project Member', 'New project assigned to you', '<p>Hi {staff_fullname}<br /><br />New project has been assigned to you.<br /><br />You can view the project on the following link <a href=\"{project_link}\">{project_name}</a><br /><br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(38, 'estimate', 'estimate-expiry-reminder', 'english', 'Estimate Expiration Reminder', 'Estimate Expiration Reminder', '<p style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hello </span>{contact_fullname}<br /><span style=\"font-size: 12pt;\">The estimate with <strong># {estimate_number}</strong> will expire on <strong>{estimate_expirydate}</strong></span><br /><br /><span style=\"font-size: 12pt;\">You can view the estimate on the following link: <a href=\"{estimate_link}\">{estimate_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname}', '', 0, 1, 0),
(39, 'proposals', 'proposal-expiry-reminder', 'english', 'Proposal Expiration Reminder', 'Proposal Expiration Reminder', '<p>Hello {proposal_proposal_to}<br /><br />The proposal {proposal_number}&nbsp;will expire on <strong>{proposal_open_till}</strong><br /><br />You can view the proposal on the following link: <a href=\"{proposal_link}\">{proposal_number}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(40, 'staff', 'new-staff-created', 'english', 'New Staff Created (Welcome Email)', 'You are added as staff member', 'Hi {staff_fullname}<br /><br />You are added as member on our Portal.<br /><br />Please use the following logic credentials:<br /><br /><strong>Email:</strong> {staff_email}<br /><strong>Password:</strong> {password}<br /><br />Click <a href=\"{admin_url}\">here </a>to login in the dashboard.<br /><br />Best Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(41, 'client', 'contact-forgot-password', 'english', 'Forgot Password', 'Create New Password', '<h2>Create a new password</h2>\r\nForgot your password?<br />To create a new password, just follow this link:<br /><br /><a href=\"{reset_password_url}\">Reset Password</a><br /><br />You received this email, because it was requested by a {companyname}&nbsp;user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same. <br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(42, 'client', 'contact-password-reseted', 'english', 'Password Reset - Confirmation', 'Your password has been changed', '<strong><span style=\"font-size: 14pt;\">You have changed your password.</span><br /></strong><br />Please, keep it in your records so you don\'t forget it.<br /><br />Your email address for login is: {contact_email}<br /><br />If this wasnt you, please contact us.<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(43, 'client', 'contact-set-password', 'english', 'Set New Password', 'Set new password on {companyname} ', '<h2><span style=\"font-size: 14pt;\">Setup your new password on {companyname}</span></h2>\r\nPlease use the following link to set up your new password:<br /><br /><a href=\"{set_password_url}\">Set new password</a><br /><br />Keep it in your records so you don\'t forget it.<br /><br />Please set your new password in <strong>48 hours</strong>. After that, you won\'t be able to set your password because this link will expire.<br /><br />You can login at: <a href=\"{crm_url}\">{crm_url}</a><br />Your email address for login: {contact_email}<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(44, 'staff', 'staff-forgot-password', 'english', 'Forgot Password', 'Create New Password', '<h2><span style=\"font-size: 14pt;\">Create a new password</span></h2>\r\nForgot your password?<br />To create a new password, just follow this link:<br /><br /><a href=\"{reset_password_url}\">Reset Password</a><br /><br />You received this email, because it was requested by a <strong>{companyname}</strong>&nbsp;user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same. <br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(45, 'staff', 'staff-password-reseted', 'english', 'Password Reset - Confirmation', 'Your password has been changed', '<span style=\"font-size: 14pt;\"><strong>You have changed your password.<br /></strong></span><br />Please, keep it in your records so you don\'t forget it.<br /><br />Your email address for login is: {staff_email}<br /><br />If this wasnt you, please contact us.<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(46, 'project', 'assigned-to-project', 'english', 'New Project Created (Sent to Customer Contacts)', 'New Project Created', '<p>Hello {contact_fullname}</p>\r\n<p>New project is assigned to your company.<br /><br /><strong>Project Name:</strong>&nbsp;{project_name}<br /><strong>Project Start Date:</strong>&nbsp;{project_start_date}</p>\r\n<p>You can view the project on the following link:&nbsp;<a href=\"{project_link}\">{project_name}</a></p>\r\n<p>We are looking forward hearing from you.<br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(47, 'tasks', 'task-added-attachment-to-contacts', 'english', 'New Attachment(s) on Task (Sent to Customer Contacts)', 'New Attachment on Task - {task_name}', '<span>Hi {contact_fullname}</span><br /><br /><strong>{task_user_take_action}</strong><span> added an attachment on the following task:</span><br /><br /><strong>Name:</strong><span> {task_name}</span><br /><br /><span>You can view the task on the following link: </span><a href=\"{task_link}\">{task_name}</a><br /><br /><span>Kind Regards,</span><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(48, 'tasks', 'task-commented-to-contacts', 'english', 'New Comment on Task (Sent to Customer Contacts)', 'New Comment on Task - {task_name}', '<span>Dear {contact_fullname}</span><br /><br /><span>A comment has been made on the following task:</span><br /><br /><strong>Name:</strong><span> {task_name}</span><br /><strong>Comment:</strong><span> {task_comment}</span><br /><br /><span>You can view the task on the following link: </span><a href=\"{task_link}\">{task_name}</a><br /><br /><span>Kind Regards,</span><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(49, 'leads', 'new-lead-assigned', 'english', 'New Lead Assigned to Staff Member', 'New lead assigned to you', '<p>Hello {lead_assigned}<br /><br />New lead is assigned to you.<br /><br /><strong>Lead Name:</strong>&nbsp;{lead_name}<br /><strong>Lead Email:</strong>&nbsp;{lead_email}<br /><br />You can view the lead on the following link: <a href=\"{lead_link}\">{lead_name}</a><br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(50, 'client', 'client-statement', 'english', 'Statement - Account Summary', 'Account Statement from {statement_from} to {statement_to}', 'Dear {contact_fullname}, <br /><br />Its been a great experience working with you.<br /><br />Attached with this email is a list of all transactions for the period between {statement_from} to {statement_to}<br /><br />For your information your account balance due is total:&nbsp;{statement_balance_due}<br /><br />Please contact us if you need more information.<br /><br />Kind Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(51, 'ticket', 'ticket-assigned-to-admin', 'english', 'New Ticket Assigned (Sent to Staff)', 'New support ticket has been assigned to you', '<p style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Hi</span></p>\r\n<p style=\"text-align: left;\"><span style=\"font-size: 12pt;\">A new support ticket&nbsp;has been assigned to you.</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Subject</strong>: {ticket_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>Department</strong>: {ticket_department}</span><br /><span style=\"font-size: 12pt;\"><strong>Priority</strong>: {ticket_priority}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>Ticket message:</strong></span><br /><span style=\"font-size: 12pt;\">{ticket_message}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the ticket on the following link: <a href=\"{ticket_url}\">#{ticket_id}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span></p>', '{companyname}', '', 0, 1, 0),
(52, 'client', 'new-client-registered-to-admin', 'english', 'New Customer Registration (Sent to admins)', 'New Customer Registration', 'Hello.<br /><br />New customer registration on your customer portal:<br /><br /><strong>Fullname:</strong> {contact_fullname}<br /><strong>Company:</strong>&nbsp;{client_company}<br /><strong>Email:</strong>&nbsp;{contact_email}<br /><br />Best Regards', '{companyname}', '', 0, 1, 0),
(53, 'leads', 'new-web-to-lead-form-submitted', 'english', 'Web to lead form submitted - Sent to lead', '{lead_name} - We Received Your Request', 'Hello {lead_name}.<br /><br /><strong>Your request has been received.</strong><br /><br />This email is to let you know that we received your request and we will get back to you as soon as possible with more information.<br /><br />Best Regards,<br />{email_signature}', '{companyname}', '', 0, 1, 0),
(54, 'staff', 'two-factor-authentication', 'english', 'Two Factor Authentication', 'Confirm Your Login', '<p style=\"text-align: left;\">Hi {staff_fullname}</p>\r\n<p style=\"text-align: left;\">You received this email because you have enabled two factor authentication in your account.<br />Use the following code to confirm your login:</p>\r\n<p style=\"text-align: left;\"><span style=\"font-size: 18pt;\"><strong>{two_factor_auth_code}<br /><br /></strong><span style=\"font-size: 12pt;\">{email_signature}</span><strong><br /><br /><br /><br /></strong></span></p>', '{companyname}', '', 0, 1, 0),
(55, 'project', 'project-finished-to-customer', 'english', 'Project Marked as Finished (Sent to Customer Contacts)', 'Project Marked as Finished', '<p>Hello {contact_fullname}</p>\r\n<p>You are receiving this email because project&nbsp;<strong>{project_name}</strong> has been marked as finished. This project is assigned under your company and we just wanted to keep you up to date.<br /><br />You can view the project on the following link:&nbsp;<a href=\"{project_link}\">{project_name}</a></p>\r\n<p>If you have any questions don\'t hesitate to contact us.<br /><br />Kind Regards,<br />{email_signature}</p>', '{companyname}', '', 0, 1, 0),
(56, 'credit_note', 'credit-note-send-to-client', 'english', 'Send Credit Note To Email', 'Credit Note With Number #{credit_note_number} Created', 'Dear <span style=\"font-size: 12pt;\">{contact_fullname}</span><br /><br />We have attached the credit note with number <strong>#{credit_note_number} </strong>for your reference.<br /><br /><strong>Date:</strong>&nbsp;{credit_note_date}<br /><strong>Total Amount:</strong>&nbsp;{credit_note_total}<br /><br /><span style=\"font-size: 12pt;\">Please contact us for more information.</span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(57, 'tasks', 'task-status-change-to-staff', 'english', 'Task Status Changed (Sent to Staff)', 'Task Status Changed', '<span style=\"font-size: 12pt;\">Hi {staff_fullname}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>{task_user_take_action}</strong> marked task as <strong>{task_status}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}</span><br /><span style=\"font-size: 12pt;\"><strong>Due date:</strong> {task_duedate}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(58, 'tasks', 'task-status-change-to-contacts', 'english', 'Task Status Changed (Sent to Customer Contacts)', 'Task Status Changed', '<span style=\"font-size: 12pt;\">Hi {contact_fullname}</span><br /><br /><span style=\"font-size: 12pt;\"><strong>{task_user_take_action}</strong> marked task as <strong>{task_status}</strong></span><br /><br /><span style=\"font-size: 12pt;\"><strong>Name:</strong> {task_name}</span><br /><span style=\"font-size: 12pt;\"><strong>Due date:</strong> {task_duedate}</span><br /><br /><span style=\"font-size: 12pt;\">You can view the task on the following link: <a href=\"{task_link}\">{task_name}</a></span><br /><br /><span style=\"font-size: 12pt;\">Kind Regards,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(59, 'staff', 'reminder-email-staff', 'english', 'Staff Reminder Email', 'You Have a New Reminder!', '<p>Hello {staff_fullname}<br /><br /><strong>You have a new reminder&nbsp;linked to&nbsp;{staff_reminder_relation_name}!<br /><br />Reminder description:</strong><br />{staff_reminder_description}<br /><br />Click <a href=\"{staff_reminder_relation_link}\">here</a> to view&nbsp;<a href=\"{staff_reminder_relation_link}\">{staff_reminder_relation_name}</a><br /><br />Best Regards<br /><br /></p>', '{companyname}', '', 0, 1, 0),
(60, 'contract', 'contract-comment-to-client', 'english', 'New Comment Â (Sent to Customer Contacts)', 'New Contract Comment', '<div style=\"text-align: left;\">Dear {contact_fullname}</div>\r\n<div style=\"text-align: left;\">A new comment has been made on the following contract: <strong>{contract_subject}</strong></div>\r\n<br />\r\n<div style=\"text-align: left;\">You can view and reply to the comment on the following link: <a href=\"{contract_link}\">{contract_subject}</a></div>\r\n<br />\r\n<div style=\"text-align: left;\">Kind Regards,</div>\r\n<div style=\"text-align: left;\">{email_signature}</div>', '{companyname}', '', 0, 1, 0),
(61, 'contract', 'contract-comment-to-admin', 'english', 'New Comment (Sent to Staff) ', 'New Contract Comment', '<div style=\"text-align: left;\">Hi {staff_fullname}</div>\r\n<div style=\"text-align: left;\">A new comment has been made to the contract&nbsp;<strong>{contract_subject}</strong></div>\r\n<br />\r\n<div style=\"text-align: left;\">You can view and reply to the comment on the following link: <a href=\"{contract_link}\">{contract_subject}</a>&nbsp;or from the admin area.<br /><br /></div>\r\n<div style=\"text-align: left;\">{email_signature}</div>', '{companyname}', '', 0, 1, 0),
(62, 'subscriptions', 'send-subscription', 'english', 'Send Subscription to Customer', 'Subscription Created', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />We have prepared the subscription&nbsp;<strong>{subscription_name}</strong> for your company.<br /><br />Click <a href=\"{subscription_link}\">here</a> to review the subscription and subscribe.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(63, 'subscriptions', 'subscription-payment-failed', 'english', 'Subscription Payment Failed', 'Your most recent invoice payment failed', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br br=\"\" />Unfortunately, your most recent invoice payment for&nbsp;<strong>{subscription_name}</strong> was declined.<br /><br /> This could be due to a change in your card number, your card expiring,<br /> cancellation of your credit card, or the card issuer not recognizing the<br /> payment and therefore taking action to prevent it.<br /><br /> Please update your payment information as soon as possible by logging in here:<br /><a href=\"{crm_url}\">{crm_url}</a><br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(64, 'subscriptions', 'subscription-canceled', 'english', 'Subscription Canceled (Sent to customer primary contact)', 'Your subscription has been canceled', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />Your subscription&nbsp;<strong>{subscription_name} </strong>has been canceled, if you have any questions don\'t hesitate to contact us.<br /><br />It was a pleasure doing business with you.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(65, 'subscriptions', 'subscription-payment-succeeded', 'english', 'Subscription Payment Succeeded (Sent to customer primary contact)', 'Subscription  Payment Receipt - {subscription_name}', 'Hello&nbsp;{contact_firstname}&nbsp;{contact_lastname}<br /><br />This email is to let you know that we received your payment for subscription&nbsp;<strong>{subscription_name}&nbsp;</strong>of&nbsp;<strong><span>{payment_total}<br /><br /></span></strong>The invoice associated with it is now with status&nbsp;<strong>{invoice_status}<br /></strong><br />Thank you for your confidence.<br /><br />Best Regards,<br />{email_signature}', '{companyname} | CRM', '', 0, 1, 0),
(66, 'contract', 'contract-expiration-to-staff', 'english', 'Contract Expiration Reminder (Sent to Staff)', 'Contract Expiration Reminder', '<div style=\"text-align: left;\">Hi {staff_fullname}</div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">This is a reminder that the following contract will expire soon:</span></div>\r\n<br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {contract_subject}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Description:</strong> {contract_description}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {contract_datestart}</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {contract_dateend}</span></div>\r\n<br />\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>\r\n<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname}', '', 0, 1, 0),
(67, 'gdpr', 'gdpr-removal-request', 'english', 'Removal Request From Contact (Sent to administrators)', 'Data Removal Request Received', 'Hello {staff_fullname}<br /><br />Data removal has been requested by {contact_fullname}<br /><br />You can review this request and take proper actions directly from the admin area.', '{companyname}', '', 0, 1, 0),
(68, 'gdpr', 'gdpr-removal-request-lead', 'english', 'Removal Request From Lead (Sent to administrators)', 'Data Removal Request Received', 'Hello {staff_fullname}<br /><br />Data removal has been requested by {lead_name}<br /><br />You can review this request and take proper actions directly from the admin area.<br /><br />To view the lead inside the admin area click here:&nbsp;<a href=\"{lead_link}\">{lead_link}</a>', '{companyname}', '', 0, 1, 0),
(69, 'client', 'client-registration-confirmed', 'english', 'Customer Registration Confirmed', 'Your registration is confirmed', '<p>Dear {contact_firstname} {contact_lastname}<br /><br />We just wanted to let you know that your registration at&nbsp;{companyname} is successfully confirmed and your account is now active.<br /><br />You can login at&nbsp;<a href=\"{crm_url}\">{crm_url}</a> with the email and password you provided during registration.<br /><br />Please contact us if you need any help.<br /><br />Kind Regards, <br />{email_signature}</p>\r\n<p><br />(This is an automated email, so please don\'t reply to this email address)</p>', '{companyname} | CRM', '', 0, 1, 0),
(70, 'contract', 'contract-signed-to-staff', 'english', 'Contract Signed (Sent to Staff)', 'Customer Signed a Contract', '<div style=\"text-align: left;\">Hi {staff_fullname}</div>\r\n<div style=\"text-align: left;\">A contract with subject&nbsp;<strong>{contract_subject} </strong>has been successfully signed by the customer.</div>\r\n<div style=\"text-align: left;\">You can view the contract at the following link: <a href=\"{contract_link}\">{contract_subject}</a>&nbsp;or from the admin area.</div>\r\n<div style=\"text-align: left;\">{email_signature}</div>', '{companyname}', '', 0, 1, 0),
(71, 'subscriptions', 'customer-subscribed-to-staff', 'english', 'Customer Subscribed to a Subscription (Sent to administrators and subscription creator)', 'Customer Subscribed to a Subscription', 'The customer <strong>{client_company}</strong> subscribed to a subscription with name&nbsp;<strong>{subscription_name}</strong><br /><br /><strong>ID</strong>:&nbsp;{subscription_id}<br /><strong>Subscription name</strong>:&nbsp;{subscription_name}<br /><strong>Subscription description</strong>:&nbsp;{subscription_description}<br /><br />You can view the subscription by clicking <a href=\"{subscription_link}\">here</a><br />\r\n<div style=\"text-align: center;\"><span style=\"font-size: 10pt;\">&nbsp;</span></div>\r\nBest Regards,<br />{email_signature}<br /><br /><span style=\"font-size: 10pt;\"><span style=\"color: #999999;\">You are receiving this email because you are either administrator or you are creator of the subscription.</span></span>', '{companyname} | CRM', '', 0, 1, 0),
(72, 'client', 'contact-verification-email', 'english', 'Email Verification (Sent to Contact After Registration)', 'Verify Email Address', '<p>Hello {contact_fullname}<br /><br />Please click the button below to verify your email address.<br /><br /><a href=\"{email_verification_url}\">Verify Email Address</a><br /><br />If you did not create an account, no further action is required</p>\r\n<p><br />{email_signature}</p>', '{companyname}', '', 0, 1, 0);
INSERT INTO `tblemailtemplates` (`emailtemplateid`, `type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
(73, 'client', 'new-customer-profile-file-uploaded-to-staff', 'english', 'New Customer Profile File(s) Uploaded (Sent to Staff)', 'Customer Uploaded New File(s) in Profile', 'Hi!<br /><br />New file(s) is uploaded into the customer ({client_company}) profile by {contact_fullname}<br /><br />You can check the uploaded files into the admin area by clicking <a href=\"{customer_profile_files_admin_link}\">here</a> or at the following link:&nbsp;{customer_profile_files_admin_link}<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(74, 'staff', 'event-notification-to-staff', 'english', 'Event Notification (Calendar)', 'Upcoming Event - {event_title}', 'Hi {staff_fullname}! <br /><br />This is a reminder for event <a href=\"%5C\">{event_title}</a> scheduled at {event_start_date}. <br /><br />Regards.', '{companyname}', '', 0, 1, 0),
(75, 'client', 'new-client-created', 'arabic', 'عضو جديد إضافة / تسجيل (بريد إلكتروني ترحيبي)', 'مرحباً بكم', '<strong>عزيزي</strong> {contact_fullname} ،<br /><br /><strong>شكرًا لك على التسجيل في نظام البوابة </strong><span style=\"color: #3366ff;\">{companyname}</span>.<br /><br /><strong>أردنا فقط أن نرحب.</strong><br /><br />يرجى الاتصال بنا اذا كنت بحاجة إلى أي مساعدة.<br /><br /><strong>انقر هنا لعرض ملفك الشخصي:</strong><span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {crm_url}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong><br /><br /><strong>(هذه رسالة بريد إلكتروني آلية ، لذا يرجى عدم الرد على عنوان البريد الإلكتروني هذا)</strong>', '{companyname}', '', 0, 1, 0),
(76, 'invoice', 'invoice-send-to-client', 'arabic', 'إرسال فاتورة إلى العميل ', 'تم إنشاء فاتورة بالرقم {invoice_number}', '<strong>عميلنا الكريم </strong>{contact_fullname} <br /><br /><strong>لقد أعددنا الفاتورة التالية لك:</strong> <span style=\"color: #000000;\"># {invoice_number}</span><br /><br /><strong>حالة الفاتورة:</strong> {invoice_status}<br /><br /><strong>يمكنك عرض الفاتورة على الرابط التالي:</strong> <span style=\"color: #0000ff;\">{invoice_number}</span><br /><br />يرجى الاتصال بنا للحصول على مزيد من المعلومات.<br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(77, 'ticket', 'new-ticket-opened-admin', 'arabic', 'فتح تذكرة جديدة (فتحها الموظف ، مرسلة إلى العميل)', 'تم فتح تذكرة جديدة', '<span style=\"font-family: verdana, geneva, sans-serif;\">مرحبا {contact_fullname}<br /><br />تم فتح تذكرة جديدة<br /><br /><strong>الموضوع</strong>: {ticket_subject}<br /><strong>القسم</strong>: {ticket_department}<br /><strong>الأولوية</strong>: {ticket_priority}<br /><br /><strong>نص التذكرة:</strong><br /><br />{ticket_message}<br /><br />يمكنك مشاهدة كامل التذكرة عبر الرابط التالي:<br /><br /><span style=\"font-size: 12pt;\"><a href=\"{ticket_url}\">#{ticket_id}<br /><br /></a></span></span><strong>أطيب التحيات<br /><br />{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(78, 'ticket', 'ticket-reply', 'arabic', 'رد التذكرة (مرسلة للعميل)', 'رد على تذكرة', '<div style=\"text-align: center;\"><strong>السلام عليكم ورحمة الله وبركاته,,,</strong><br /><br /></div>\r\n<strong>أسعد الله أوقاتك {contact_fullname}</strong><br /><br /><strong>لديك رد جديد على التذكرة :&nbsp; {ticket_id}</strong><br /><br /><strong>الموضوع : {ticket_subject}<br /><br />نص الرد :<br /><br /></strong>{ticket_message}<br /><br />يمكنك متابعة التذكرة عبر الرابط التالي :<br />{ticket_url}<br /><br />\r\n<div style=\"text-align: center;\"><strong>أطيب التحيات<br /><br />{email_signature}<br /></strong></div>', '{companyname}', '', 0, 1, 0),
(79, 'ticket', 'ticket-autoresponse', 'arabic', 'فتح تذكرة جديدة - الرد الآلي', 'فتح تذكرة جديدة', '<strong>السلام عليكم ورحمة الله وبركاته,,,</strong><br /><br /><strong>مرحباً {contact_fullname}</strong><br /><br /><strong>نشكرك على الاتصال بفريق الدعم لدينا. تم الآن فتح بطاقة دعم لطلبك. سيتم إعلامك عندما يتم الرد عبر البريد الإلكتروني.</strong><br /><br /><strong>الموضوع : {ticket_subject}</strong><br /><strong>القسم : {ticket_department}</strong><br /><strong>الأولوية : {ticket_priority}</strong><br /><br /><strong>نص التذكرة :</strong><br /><br /><strong>{ticket_message}</strong><br /><br /><strong>يمكنكم متابعة التذكرة عبر الرابط التالي :</strong><br /><br /><strong><span style=\"font-size: 12pt;\"><a href=\"{ticket_url}\">#{ticket_id}</a></span></strong><br /><br /><br /><strong>مع أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname} ', '', 0, 1, 0),
(80, 'invoice', 'invoice-payment-recorded', 'arabic', 'تسجيل دفعة على فاتورة (مرسلة إلى العميل)', 'تم تسجيل دفعة الفاتورة', '<strong>مرحبًا</strong> {contact_fullname}<br /><br /><strong>شكرا لك على الدفع. اعثر على تفاصيل الدفع أدناه:</strong><br /><br />-------------------------------------------------<br /><br /><strong>المبلغ:</strong> {payment_total}<br /><strong>التاريخ:</strong> {payment_date}<br /><strong>رقم الفاتورة:</strong> # {invoice_number}<br /><br />-------------------------------------------------<br /><br />يمكنك دائمًا عرض فاتورة هذه الدفعة على الرابط التالي<span style=\"color: #0000ff;\">: {invoice_number}</span><br /><br />نحن نتطلع للعمل معكم.<br /><br />أ<strong>طيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(81, 'invoice', 'invoice-overdue-notice', 'arabic', 'إشعار فاتورة متأخرة', 'إشعار بفاتورة متأخرة - {invoice_number}', '<strong>مرحبًا عميلنا كريم</strong> {contact_fullname}<br /><br /><strong>هذا إشعار متأخر عن الفاتورة رقم</strong> <span style=\"background-color: #ffffff;\">{invoice_number}</span><br /><br /><strong>كانت هذه الفاتورة مستحقة الدفع:</strong> {invoice_duedate}<br /><br />يمكنك عرض الفاتورة على الرابط التالي: <span style=\"background-color: #ffffff; color: #3366ff;\">{invoice_number}</span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(82, 'invoice', 'invoice-already-send', 'arabic', 'فاتورة مرسلة بالفعل للعميل', 'فاتورة # {invoice_number}', '<strong>مرحبًا</strong> <strong>عميلنا الكريم</strong>{contact_fullname}<br /><br /><strong>بناء على طلبك ، إليك الفاتورة برقم</strong> # {invoice_number}<br /><br />يمكنك عرض الفاتورة على الرابط التالي:<span style=\"color: #3366ff;\"> {invoice_number}</span><br /><br />يرجى الاتصال بنا للحصول على مزيد من المعلومات.<br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(83, 'ticket', 'new-ticket-created-staff', 'arabic', 'تذكرة جديدة تم إنشاؤها (فتحها العميل ، مرسلة إلى فريق العمل)', 'تم إنشاء تذكرة جديدة', '<strong>السلام عليكم ورحمة الله وبركاته,,,</strong><br /><br />\r\n<div class=\"text-wrap tlid-copy-target\">\r\n<div class=\"result-shield-container tlid-copy-target result-rtl\"><strong><span class=\"tlid-translation translation\" lang=\"ar\"><span title=\"\">تم فتح تذكرة جديدة.<br /><br />الموضوع: {ticket_subject}<br />القسم: {ticket_department}<br />الأولوية: {ticket_priority}<br /><br />نص الرسالة:<br /><br />{ticket_message}<br /></span></span><span class=\"tlid-translation-gender-indicator translation-gender-indicator\"></span></strong></div>\r\n</div>\r\n<br /><strong>يمكنك متابعة التذكرة عبر الرابط :</strong><br /><br /><strong><span style=\"font-size: 12pt;\"><a href=\"{ticket_url}\">#{ticket_id}</a></span></strong><br /><br /><strong>مع أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong><br />\r\n<div class=\"text-wrap tlid-copy-target\">\r\n<div class=\"result-shield-container tlid-copy-target result-rtl\"><span class=\"tlid-translation translation\" lang=\"ar\"><span title=\"\"><br /></span></span><span class=\"tlid-translation-gender-indicator translation-gender-indicator\"></span></div>\r\n</div>', '{companyname}', '', 0, 1, 0),
(84, 'estimate', 'estimate-send-to-client', 'arabic', 'إرسال عرض أتعاب للعميل', 'تم إنشاء عرض أتعاب بالرقم # {estimate_number}', 'السلام عليكم ورحمة الله وبركاته,,,<br /><br />عزيزي {contact_fullname}<br /><br />ستجد في المرفقات <strong>عرض الأتعاب #</strong><br />{estimate_number}<br /><br /><strong>حالة العرض:</strong> {estimate_status}<br /><br />يمكنك متابعة العرض من خلال الرابط التالي:<br /><br />{estimate_link}<br /><br />نسعد بتواصلكم<br /><br />مع أطيب التحيات<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(85, 'ticket', 'ticket-reply-to-admin', 'arabic', 'رد التذكرة (مرسلة إلى فريق العمل)', 'رد جديد على التذكرة', '<strong>السلام عليكم ورحمة الله وبركاته,,,</strong><br /><br /><strong>رد جديد على التذكرة من قبل {contact_fullname}</strong><br /><br /><strong>الموضوع: {ticket_subject}</strong><br /><strong>القسم: {ticket_department}</strong><br /><strong>الأولوية: {ticket_priority}</strong><br /><br /><strong>نص الرسالة :</strong><br /><br /><strong>{ticket_message}</strong><br /><br /><strong>يمكنك متابعة التذكرة عبر الرابط :</strong><br /><br /><strong><span style=\"font-size: 12pt;\"><a href=\"{ticket_url}\">#{ticket_id}</a></span></strong><br /><br /><strong>مع أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(86, 'estimate', 'estimate-already-send', 'arabic', 'عرض أتعاب أرسل بالفعل إلى العميل', 'عرض أتعاب # {estimate_number}', 'السلام عليكم ورحمة الله وبركاته,,,<br /><br />عميلنا الكريم {contact_fullname}<br /><br />نشكرك على طلب عرض الأتعاب<br /><br />يمكنك متابعة العرض عبر الرابط :<br /><br />{estimate_link}<br /><br />يمكنك التواصل معنا للمزيد من المعلومات <br /><br />مع أطيب التحيات<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(87, 'contract', 'contract-expiration', 'arabic', 'تذكير بانتهاء العقد (مرسلة إلى جهات اتصال العملاء)', 'تذكير بقرب انتهاء صلاحية العقد', '<span style=\"font-size: 12pt;\">عميلنا الكريم {client_company}<br /><br />السلام عليكم ورحمة الله وبركاته,,,<br /></span><br /><br />هذا تذكير لكم بقرب إنتهاء صلاحية العقد ذو المعلومات التالية:<span style=\"font-size: 12pt;\"></span><br />الموضوع: {contract_subject}<span style=\"font-size: 12pt;\"></span><br /><span style=\"font-size: 12pt;\"><strong>الوصف: {contract_description}</strong></span><br /><span style=\"font-size: 12pt;\"><strong>تاريخ البداية : {contract_datestart}</strong></span><br /><span style=\"font-size: 12pt;\"><strong>تاريخ النهاية: {contract_dateend}</strong></span><br /><br />يرجى التواصل معنا للمزيد من المعلومات<span style=\"font-size: 12pt;\"></span><br /><br /><span style=\"font-size: 12pt;\">مع أطيب التحيات,<br /></span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(88, 'tasks', 'task-assigned', 'arabic', 'تعيين مهمة جديدة (مرسلة إلى فريق العمل)', 'تم إضافة مهمة جديدة لك - {task_name}', '<strong>عزيزي</strong> {staff_fullname} ،<br /><br /><strong>لقد تم تكليفك بمهمة جديدة:</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><strong>تاريخ البدء:</strong> {task_startdate}<br /><strong>تاريخ الاستحقاق:</strong> {task_duedate}<br /><strong>الأولوية:</strong> {task_priority}<br /><br />يمكنك عرض المهمة على الرابط التالي:<span style=\"color: #3366ff;\"> {task_name}</span><br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(89, 'tasks', 'task-added-as-follower', 'arabic', 'تمت إضافة موظف لمتابعة مهمة (مرسلة إلى فريق العمل)', 'تمت إضافتك كمتابع في المهمة - {task_name}', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>لقد تمت إضافتك كمتابع في المهمة التالية:</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><strong>تاريخ البدء:</strong> {task_startdate}<br /><br />يمكنك عرض المهمة على الرابط التالي:<span style=\"color: #3366ff;\"> {<span style=\"text-decoration: underline;\">task_name}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(90, 'tasks', 'task-commented', 'arabic', 'تعليق جديد على المهمة (مرسلة إلى فريق العمل)', 'تعليق جديد على المهمة - {task_name}', '<strong>عزيزي</strong> {staff_fullname} ،<br /><br /><strong>وقد تم التعليق على المهمة التالية:</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><strong>تعليق:</strong> {task_comment}<br /><br />يمكنك عرض المهمة على الرابط التالي:<span style=\"color: #3366ff;\"> {<span style=\"text-decoration: underline;\">task_name</span>}</span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(91, 'tasks', 'task-added-attachment', 'arabic', 'المرفقات الجديدة للمهمة (مرسلة إلى فريق العمل)', 'مرفق جديد للمهمة - {task_name}', '<strong>مرحبًا</strong> {staff_firstname}<br /><br /><strong>أضاف {task_user_take_action} مرفقًا في المهمة التالية:</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><br />يمكنك عرض المهمة على الرابط التالي: <span style=\"color: #3366ff;\">{<span style=\"text-decoration: underline;\">task_name</span>}</span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(92, 'estimate', 'estimate-declined-to-staff', 'arabic', 'رفض عرض الاتعاب (مرسلة إلى فريق العمل)', 'قام العميل برفض العرض', 'السلام عليكم ورحمة الله وبركاته,,,<br /><br />العميل {client_company} قام برفض عرض الأتعاب ذو الرقم <span style=\"font-size: 12pt;\"><strong># {estimate_number}<br /><br /><br />يمكن متابعة العرض عبر الرابط :<br /><br />{estimate_link}<br /><br />{email_signature}</strong></span>', '{companyname}', '', 0, 1, 0),
(93, 'estimate', 'estimate-accepted-to-staff', 'arabic', 'قبول عرض الأتعاب (مرسلة إلى فريق العمل)', 'قام العميل بقبول العرض', '<span style=\"font-size: 12pt;\">السلام عليكم ورحمة الله وبركاته</span><br /><br /><strong>العميل {client_company} قام بقبول عرض الأتعاب ذو الرقم <span style=\"font-size: 12pt;\"># {estimate_number}</span></strong><span style=\"font-size: 12pt;\"><strong></strong></span><br /><br /><span style=\"font-size: 12pt;\">يمكنك متابعة العرض عبر الرابط:<br /><a href=\"{estimate_link}\">{estimate_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(94, 'proposals', 'proposal-client-accepted', 'arabic', 'قبول العطاء (مرسلة إلى فريق العمل)', 'تم قبول العطاء من العميل', '<strong>مرحبا</strong><br /><br /><strong>قبل العميل {proposal_proposal_to}</strong> الاقتراح التالي:<br /><br /><strong>رقم:</strong> {proposal_number}<br /><strong>الموضوع:</strong> {proposal_subject}<br /><strong>الإجمالي:</strong> {proposal_total}<br /><br />شاهد الاقتراح على الرابط التالي:\r\n<div style=\"text-align: justify;\"><span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{<a href=\"{https://law.babillawnet.com/admin/emails/email_template/proposal_link}\">proposal_number</a>}</span></span></div>\r\n<br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(95, 'proposals', 'proposal-send-to-customer', 'arabic', 'إرسال عطاء إلى العميل', 'تم إنشاء عطاء بالرقم {proposal_number}', '<strong>عزيزي العميل</strong>{proposal_proposal_to}<br /><br />تجدون اقتراحنا المرفق.<br /><br /><strong>هذا الاقتراح صالح حتى:</strong> {proposal_open_till}<br />يمكنك عرض الاقتراح على الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{<a href=\"{https://law.babillawnet.com/admin/emails/email_template/proposal_link}\">proposal_number</a>}</span></span><br /><br />لا تتردد في التعليق على الإنترنت إذا كان لديك أي أسئلة.<br /><br />نحن نتطلع إلى اتصالك.<br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(96, 'proposals', 'proposal-client-declined', 'arabic', 'رفض العطاء (مرسلة إلى فريق العمل)', 'تم رفض العطاء من قبل العميل', '<strong>مرحبا</strong><br /><br />رفض <strong>{proposal_proposal_to}</strong> العميل الاقتراح <strong>{proposal_subject}</strong><br /><br />اعرض الاقتراح على الرابط التالي<span style=\"text-decoration: underline;\">&nbsp;<a href=\"{https://law.babillawnet.com/admin/emails/email_template/proposal_link}\">{proposal_number}</a> </span>أو من منطقة المشرف.<br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(97, 'proposals', 'proposal-client-thank-you', 'arabic', 'رسالة شكر (مرسلة إلى العميل بعد القبول)', 'نشكركم على قبول العطاء', '<div style=\"text-align: justify;\"><strong>عزيزي العميل</strong>{proposal_proposal_to}</div>\r\n<div style=\"text-align: justify;\">شكرا لقبول الاقتراح.</div>\r\n<div style=\"text-align: justify;\">ونحن نتطلع إلى العمل معكم.</div>\r\n<div style=\"text-align: justify;\">سنتواصل معك بأقرب وقت ممكن</div>\r\n<div style=\"text-align: justify;\"><strong>أطيب التحيات</strong>،</div>\r\n<div style=\"text-align: justify;\"><strong>{email_signature}</strong></div>', '{companyname}', '', 0, 1, 0),
(98, 'proposals', 'proposal-comment-to-client', 'arabic', 'تعليق جديد (مرسل إلى العميل/ العميل المحتمل)', 'تعليق جديد على العطاء', '<strong>عزيزي العميل</strong> {proposal_proposal_to}<br /><br /><strong>تم إجراء تعليق جديد على الاقتراح التالي: {proposal_number}</strong><br /><br />يمكنك عرض التعليق على الرابط التالي والرد عليه: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{<a href=\"{https://law.babillawnet.com/admin/emails/email_template/proposal_link}\">proposal_number</a>}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(99, 'proposals', 'proposal-comment-to-admin', 'arabic', 'تعليق جديد (مرسل إلى فريق العمل)', 'تعليق جديد على العطاء', '<strong>مرحبا</strong><br /><br /><strong>تم إجراء تعليق جديد على الاقتراح {proposal_subject}</strong><br /><br />يمكنك عرض التعليق على الرابط التالي والرد عليه: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{<a href=\"{https://law.babillawnet.com/admin/emails/email_template/proposal_link}\">proposal_number</a>}</span></span> أو من منطقة المشرف.<br /><br />\r\n<div style=\"text-align: justify;\"><strong>{email_signature}</strong></div>', '{companyname}', '', 0, 1, 0),
(100, 'estimate', 'estimate-thank-you-to-customer', 'arabic', 'رسالة شكر (مرسلة إلى العميل بعد القبول)', 'نشكركم على قبول عرض الأتعاب', '<span style=\"font-size: 12pt;\">السلام عليكم ورحمة الله وبركاته<br /><br />عميلنا الكريم {contact_fullname}</span><br /><br />نشكركم على قبولكم لعرض الأتعاب المقدم من قبلنا<span style=\"font-size: 12pt;\"></span><br /><br />\r\n<div class=\"text-wrap tlid-copy-target\">\r\n<div class=\"result-shield-container tlid-copy-target result-rtl\" tabindex=\"0\"><span class=\"tlid-translation translation\" lang=\"ar\"><span title=\"\" class=\"\">ونحن نتطلع إلى العمل معكم وتحقيق تطلعاتكم.</span></span><span class=\"tlid-translation-gender-indicator translation-gender-indicator\"></span><span class=\"tlid-trans-verified-button trans-verified-button\" role=\"button\"></span></div>\r\n</div>\r\n<br /><br />\r\n<div class=\"text-wrap tlid-copy-target\">\r\n<div class=\"result-shield-container tlid-copy-target result-rtl\" tabindex=\"0\"><span class=\"tlid-translation translation\" lang=\"ar\"><span title=\"\" class=\"\">سنتواصل معك بأقرب وقت ممكن.</span></span><span class=\"tlid-translation-gender-indicator translation-gender-indicator\"></span><span class=\"tlid-trans-verified-button trans-verified-button\" role=\"button\"></span></div>\r\n</div>\r\n<br /><br /><span style=\"font-size: 12pt;\">أطيب التحيات,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(101, 'tasks', 'task-deadline-notification', 'arabic', 'تذكير بالموعد النهائي للمهمة - مرسلة إلى الأعضاء المعينين', 'تذكير الموعد النهائي للمهمة', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>هذه رسالة بريد إلكتروني آلية من {companyname}.</strong><br /><br /><strong>الموعد النهائي للمهمة</strong> {task_name} <strong>هو</strong>{task_duedate}.<br />هذه المهمة لم تنته بعد.<br /><br />يمكنك عرض المهمة على الرابط التالي:<span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {task_name}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname} ', '', 0, 1, 0),
(102, 'contract', 'send-contract', 'arabic', 'إرسال العقد للعميل', 'العقد - {contract_subject}', '<span style=\"font-size: 12pt;\">عميلنا الكريم {contact_fullname}<br /><br />السلام عليكم ورحمة الله وبركاته</span><br /><br />نرجوا العثور في المرفقات على {contract_subject}<span style=\"font-size: 12pt;\"><br /><br />نتطلع للإستماع لكم</span><span style=\"font-size: 12pt;\"></span><br /><br /><span style=\"font-size: 12pt;\">أطيب التحيات,<br /></span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(103, 'invoice', 'invoice-payment-recorded-to-staff', 'arabic', 'تسجيل دفعة على الفاتورة (مرسلة إلى فريق العمل)', 'دفع فاتورة جديدة', '<strong>مرحبا</strong><br /><br /><strong>سجّل العميل الدفعة للفاتورة رقم</strong> {invoice_number}<br /><br />يمكنك عرض الفاتورة على الرابط التالي: <span style=\"color: #3366ff;\">{invoice_number}</span><br /><br /><strong>أطيب التحيات</strong>،<br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(104, 'ticket', 'auto-close-ticket', 'arabic', 'رسالة الإغلاق الآلي للتذكرة', 'تم إغلاق التذكرة', '<strong>السلام عليكم ورحمة الله وبركاته,,,</strong><br /><br /><strong>مرحباً {contact_fullname}</strong><br /><br /><strong>التذكرة {ticket_subject} تم إغلاقها تلقائياًَ بسبب عدم وجود أي نشاط عليها.</strong><br /><br /><strong>التذكرة: {ticket_id}</strong><br /><strong>القسم: {ticket_department}</strong><br /><strong>الأولوية:&nbsp; {ticket_priority}</strong><br /><br /><strong>مع أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname} ', '', 0, 1, 0),
(105, 'project', 'new-project-discussion-created-to-staff', 'arabic', 'مناقشة جديدة في خدمة قانونية (مرسلة إلى فريق العمل)', 'تم إنشاء مناقشة جديدة للخدمة - {project_name}', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم إنشاء مناقشة خدمة جديدة من</strong> {discussion_creator}<br /><br /><strong>الموضوع:</strong> {discussion_subject}<br /><strong>الوصف:</strong> {discussion_description}<br /><br />يمكنك مشاهدة المناقشة على الرابط التالي:<span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {discussion_subject}</span></span><br /><br /><strong>أطيب التحيات،</strong><br />\r\n<div style=\"text-align: justify;\"><strong>{email_signature}</strong></div>', '{companyname}', '', 0, 1, 0),
(106, 'project', 'new-project-discussion-created-to-customer', 'arabic', 'مناقشة جديدة لخدمة قانونية (مرسلة إلى جهات اتصال العملاء)', 'تم إنشاء مناقشة جديدة للخدمة - {project_name}', '<strong>مرحبًا</strong> {contact_fullname}<br /><br /><strong>تم إنشاء مناقشة خدمة جديدة من</strong> {discussion_creator}<br /><br /><strong>الموضوع:</strong> {discussion_subject}<br /><strong>الوصف:</strong> {discussion_description}<br /><br />يمكنك مشاهدة المناقشة على الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{discussion_subject}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br />\r\n<div style=\"text-align: justify;\"><strong>{email_signature}</strong></div>', '{companyname}', '', 0, 1, 0),
(107, 'project', 'new-project-file-uploaded-to-customer', 'arabic', 'تحميل ملف (ملفات) جديدة على خدمة قانونية (مرسلة إلى جهات اتصال العملاء)', 'تم تحميل ملف (ملفات) جديدة للخدمة - {project_name}', '<strong>&#1605;&#1585;&#1581;&#1576;&#1611;&#1575;</strong> {contact_fullname}<br><br><strong>&#1578;&#1605; &#1578;&#1581;&#1605;&#1610;&#1604; &#1605;&#1604;&#1601; &#1582;&#1583;&#1605;&#1577; &#1580;&#1583;&#1610;&#1583; &#1601;&#1610;</strong> {project_name} <strong>&#1605;&#1606;</strong> {file_creator}<br><br>&#1610;&#1605;&#1603;&#1606;&#1603; &#1605;&#1588;&#1575;&#1607;&#1583;&#1577; &#1575;&#1604;&#1582;&#1583;&#1605;&#1577; &#1593;&#1604;&#1609; &#1575;&#1604;&#1585;&#1575;&#1576;&#1591; &#1575;&#1604;&#1578;&#1575;&#1604;&#1610;: <span style=\"text-decoration:underline;\"><span style=\"color:#3366ff;text-decoration:underline;\">{project_name}</span></span><br><br>&#1604;&#1593;&#1585;&#1590; &#1575;&#1604;&#1605;&#1604;&#1601; &#1601;&#1610; CRM &#1548; &#1610;&#1605;&#1603;&#1606;&#1603; &#1575;&#1604;&#1606;&#1602;&#1585; &#1601;&#1608;&#1602; &#1575;&#1604;&#1575;&#1585;&#1578;&#1576;&#1575;&#1591; &#1575;&#1604;&#1578;&#1575;&#1604;&#1610;: <span style=\"text-decoration:underline;\"><span style=\"color:#3366ff;text-decoration:underline;\">{discussion_subject</span></span><span style=\"color:#3366ff;\">}</span><br><br><strong>&#1571;&#1591;&#1610;&#1576; &#1575;&#1604;&#1578;&#1581;&#1610;&#1575;&#1578;</strong>&#1548;<br><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(108, 'project', 'new-project-file-uploaded-to-staff', 'arabic', 'تحميل ملف (ملفات) جديدة على خدمة قانونية (مرسلة إلى فريق العمل)', 'تم تحميل ملف (ملفات) جديدة للخدمة - {project_name}', '<strong>مرحبًا</strong> {staff_fullname}<br /><br />تم تحميل ملف خدمةجديد في<strong> {project_name}</strong> من <strong>{file_creator}</strong><br /><br />يمكنك مشاهدة الخدمةعلى الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{project_name}</span></span><br /><br />لعرض الملف يمكنك الضغط على الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{discussion_subject}</span></span><br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(109, 'project', 'new-project-discussion-comment-to-customer', 'arabic', 'تعليق جديد على مناقشة (مرسلة إلى جهات اتصال العملاء)', 'تعليق جديد على المناقشة', '<strong>مرحبًا</strong> {contact_fullname}<br /><br />تم إجراء تعليق مناقشة جديد على<strong> {discussion_subject}</strong> من <strong>{comment_creator</strong>}<br /><br /><strong>موضوع المناقشة:</strong> {discussion_subject}<br /><strong>تعليق:</strong> {discussion_comment}<br /><br />يمكنك مشاهدة المناقشة على الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{discussion_subject}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(110, 'project', 'new-project-discussion-comment-to-staff', 'arabic', 'تعليق جديد على مناقشة (مرسلة إلى فريق العمل)', 'تعليق جديد على المناقشة', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم إجراء تعليق مناقشة جديد على</strong> {discussion_subject} <strong>من</strong> {comment_creator}<br /><br /><strong>موضوع المناقشة</strong>: {discussion_subject}<br /><strong>تعليق</strong>: {discussion_comment}<br /><br />يمكنك مشاهدة المناقشة على الرابط التالي:<span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {discussion_subject}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(111, 'project', 'staff-added-as-project-member', 'arabic', 'إضافة موظف كعضو في الخدمة', 'تم تخصيص خدمة جديدة لك', '<strong>مرحبًا</strong> {staff_fullname}<br /><br />تم تعيين خدمة جديد لك.<br /><br />يمكنك مشاهدة المشروع على الرابط التالي <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{project_name}</span></span><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(112, 'estimate', 'estimate-expiry-reminder', 'arabic', 'تذكير انتهاء صلاحية عرض الأتعاب', 'تذكير بقرب انتهاء صلاحية العرض', 'السلام عليكم ورحمة الله وبركاته,,,<br /><br />عميلنا الكريم {contact_fullname}<span style=\"font-size: 12pt;\"></span><br /><br /><strong>صلاحية عرض الأتعاب ذو الرقم <span style=\"font-size: 12pt;\"># {estimate_number} ستنتهي في {estimate_expirydate}</span></strong><span style=\"font-size: 12pt;\"><strong></strong></span><br /><br /><span style=\"font-size: 12pt;\">يمكنك متابعة العرض عبر الرابط :<br /><a href=\"{estimate_link}\">{estimate_number}</a></span><br /><br /><span style=\"font-size: 12pt;\">مع أطيب التحيات,<br /></span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(113, 'proposals', 'proposal-expiry-reminder', 'arabic', 'تذكير بانتهاء صلاحية العطاء', 'تذكير بقرب انتهاء صلاحية العطاء', '<strong>مرحبًا</strong> {proposal_proposal_to}<br /><br /><strong>سينتهي اقتراح {proposal_number} في {proposal_open_till}</strong><br /><br />يمكنك عرض الاقتراح على الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{<a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/proposal_link}\">proposal_number</a>}</span></span><br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(114, 'staff', 'new-staff-created', 'arabic', 'إنشاء حساب موظف جديد (رسالة ترحيب)', 'تم إضافتك كعضو في فريق العمل', '<div style=\"text-align: right;\"><strong>مرحبًا عزيزي</strong> {staff_fullname}<br /><br /><strong>تتم إضافتك كعضو في بوابتنا</strong>.<br /><br /><strong>الرجاء استخدام بيانات اعتماد المنطق التالية:</strong><br /><br /><strong>البريد الإلكتروني</strong>: {staff_email}<br /><strong>كلمة المرور</strong>: {password}<br /><br />انقر <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">هنا</span> </span>لتسجيل الدخول في لوحة القيادة.<br /><br /><strong>تحياتي الحارة</strong>،<br /><strong>{email_signature}</strong><br /><br /></div>', '{companyname}', '', 0, 1, 0),
(115, 'client', 'contact-forgot-password', 'arabic', 'نسيت كلمة المرور', 'إنشاء كلمة مرور جديدة', '<strong>أنشئ كلمة مرور جديدة</strong><br /><strong>نسيت رقمك السري؟</strong><br /><strong>لإنشاء كلمة مرور جديدة ، ما عليك سوى اتباع هذا الرابط:</strong><br /><br /><a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/reset_password_url}\">Reset Password</a><br /><br />لقد تلقيت هذا البريد الإلكتروني لأنه تم طلبه بواسطة مستخدم <span style=\"color: #3366ff;\">{companyname}</span>. هذا جزء من الإجراء لإنشاء كلمة مرور جديدة على النظام. إذا لم تطلب كلمة مرور جديدة ، فيرجى تجاهل هذا البريد الإلكتروني وستظل كلمة المرور كما هي.<br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(116, 'client', 'contact-password-reseted', 'arabic', 'إعادة تعيين كلمة المرور - التأكيد', 'تم تغيير كلمة المرور', '<strong>لقد قمت بتغيير كلمة المرور الخاصة بك</strong>.<br /><br />من فضلك ، احتفظ بها في سجلاتك حتى لا تنسى ذلك.<br /><br />عنوان بريدك الإلكتروني لتسجيل الدخول هو: <span style=\"color: #3366ff;\">{contact_email}</span><br /><br />إذا لم يكن هذا أنت ، يرجى الاتصال بنا.<br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(117, 'client', 'contact-set-password', 'arabic', 'تعيين كلمة مرور جديدة', 'تعيين كلمة مرور جديدة في بوابة {companyname}', '<strong>قم بإعداد كلمة المرور الجديدة الخاصة بك على {companyname}</strong><br />يرجى استخدام الرابط التالي لإعداد كلمة المرور الجديدة الخاصة بك:<br /><br /><a href=\"{https://law.babillawnet.com/admin/emails/email_template/set_password_url}\">Set new password</a><br /><br />احتفظ بها في سجلاتك حتى لا تنسى ذلك.<br /><br />يرجى تعيين كلمة المرور الجديدة في 48 ساعة. بعد ذلك ، لن تتمكن من تعيين كلمة مرورك لأن هذا الرابط سينتهي.<br /><br />يمكنك تسجيل الدخول على: <span style=\"color: #3366ff;\">{crm_url}</span><br />عنوان بريدك الإلكتروني لتسجيل الدخول: <span style=\"color: #3366ff;\">{contact_email}</span><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(118, 'staff', 'staff-forgot-password', 'arabic', 'نسيت كلمة المرور', 'إنشاء كلمة مرور جديدة', '<strong>أنشئ كلمة مرور جديدة</strong><br /><strong>نسيت رقمك السري؟</strong><br />لإنشاء كلمة مرور جديدة ، ما عليك سوى اتباع هذا الرابط:<br /><br /><span style=\"color: #3366ff;\"><a href=\"{https://law.babillawnet.com/admin/emails/email_template/reset_password_url}\">Reset Password</a></span><br /><br />لقد تلقيت هذا البريد الإلكتروني لأنه تم طلبه بواسطة مستخدم <strong>{companyname}</strong>. هذا جزء من الإجراء لإنشاء كلمة مرور جديدة على النظام. إذا لم تطلب كلمة مرور جديدة ، فيرجى تجاهل هذا البريد الإلكتروني وستظل كلمة المرور كما هي.<br /><br />\r\n<div style=\"text-align: justify;\"><strong>{email_signature}</strong></div>', '{companyname}', '', 0, 1, 0),
(119, 'staff', 'staff-password-reseted', 'arabic', 'إعادة تعيين كلمة المرور - التأكيد', 'تم تغيير كلمة المرور الخاصة بك', '<strong>لقد قمت بتغيير كلمة المرور الخاصة بك</strong>.<br /><br />من فضلك ، احتفظ بها في سجلاتك حتى لا تنسى ذلك.<br /><br />عنوان بريدك الإلكتروني لتسجيل الدخول هو<span style=\"text-decoration: underline;\"><span style=\"background-color: #3366ff;\">: <span style=\"color: #3366ff; background-color: #ffffff;\">{staff_email}</span></span></span><br /><br />إذا لم يكن هذا أنت ، يرجى الاتصال بنا.<br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(120, 'project', 'assigned-to-project', 'arabic', 'إنشاء خدمة جديدة (مرسلة إلى جهات اتصال العملاء)', 'تم إنشاء خدمة جديدة', '<br /><br /><strong>تم تعيين خدمة جديد لشركتك</strong>.<br /><br /><strong>اسم الخدمة</strong>: {project_name}<br /><strong>تاريخ بدء الخدمة:</strong> {project_start_date}<br /><br />يمكنك مشاهدة الخدمة على الرابط التالي:<span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {project_name}</span></span><br /><br />نحن نتطلع إلى الاستماع منك.<br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(121, 'tasks', 'task-added-attachment-to-contacts', 'arabic', 'المرفقات الجديدة للمهمة (مرسلة إلى جهات اتصال العملاء)', 'مرفق جديد للمهمة - {task_name}', '<strong>مرحبًا عزيزي العميل</strong> {contact_fullname}<br /><br /><strong>أضاف </strong>{task_user_take_action}<strong> مرفقًا في المهمة التالية:</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><br />يمكنك عرض المهمة على الرابط التالي: <span style=\"color: #3366ff;\"><span style=\"text-decoration: underline;\">{task_name</span>}</span><br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(122, 'tasks', 'task-commented-to-contacts', 'arabic', 'تعليق جديد على المهمة (مرسلة إلى جهات اتصال العملاء)', 'تعليق جديد على المهمة - {task_name}', '<strong>عزيزي</strong> {contact_fullname} ،<br /><br /><strong>وقد تم التعليق على المهمة التالية:</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><strong>تعليق:</strong> {task_comment}<br /><br />يمكنك عرض المهمة على الرابط التالي: <span style=\"color: #3366ff;\">{task_name}</span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(123, 'leads', 'new-lead-assigned', 'arabic', 'تخصيص عميل محتمل جديد لموظف', 'تم تخصيص عميل متوقع لك', '<strong>مرحبًا</strong> {lead_assigned}<br /><br /><strong>تم تعيين عميل محتمل جديد لك</strong>.<br /><br /><strong>اسم العميل المحتمل</strong>: {lead_name}<br /><strong>البريد الإلكتروني المحتمل</strong>: {lead_email}<br /><br />يمكنك عرض العميل المحتمل على الرابط التالي:<span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {lead_name}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(124, 'client', 'client-statement', 'arabic', 'كشف الحساب - ملخص الحساب', 'كشف حساب من {statement_from} الى {statement_to}', '<strong>مرحبًا</strong> {contact_fullname} ،<br /><br /><strong>لقد كانت تجربة رائعة للعمل معك</strong>.<br /><br /><strong>مرفق مع هذا البريد الإلكتروني قائمة بجميع المعاملات للفترة من {statement_from} إلى {statement_to}</strong><br /><br /><strong>لمعلوماتك ، رصيد حسابك المستحق هو الإجمالي:</strong> <span style=\"color: #3366ff;\">{statement_balance_due}</span><br /><br />ارجوك اتصل بنا ان كنت تريد مزيد من المعلومات.<br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(125, 'ticket', 'ticket-assigned-to-admin', 'arabic', 'تخصيص تذكرة جديدة (مرسلة لفريق العمل)', 'تم تخصيص تذكرة جديدة لك', 'السلام عليكم ورحمة الله وبركاته,,,<br /><br />تذكرة جديدة تم تخصيصها لك<br /><br /><strong>الموضوع :</strong> {ticket_subject}<br /><strong>القسم:</strong> {ticket_department}<br /><strong>الأولوية: </strong>{ticket_priority}<strong><br /><br /><br />نص التذكرة: <br /><br /></strong>{ticket_message}<br /><br /><strong>مع اطيب التحيات</strong><br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(126, 'client', 'new-client-registered-to-admin', 'arabic', 'تسجيل عميل جديد (مرسلة للمشرفين)', 'تسجيل عميل جديد', '<strong>مرحبا</strong>.<br /><br /><strong>تسجيل عميل جديد على بوابة العملاء الخاصة بك:</strong><br /><br /><strong>الاسم الكامل</strong>: <span style=\"color: #3366ff;\">{contact_fullname}</span><br /><strong>الشركة</strong>: <span style=\"color: #3366ff;\">{client_company}</span><br /><strong>البريد الإلكتروني</strong>:<span style=\"color: #3366ff;\"> {contact_email}</span><br /><br /><strong>تحياتي الحارة</strong>', '{companyname}', '', 0, 1, 0),
(127, 'leads', 'new-web-to-lead-form-submitted', 'arabic', 'إستلام رسالة من العميل المحتمل - مرسل إلى العميل المحتمل', '{lead_name} - تم إستلام طلبك', '<strong>مرحبًا</strong> {lead_name}<br /><br /><strong>تم استلام طلبك</strong>.<br /><br />هذا البريد الإلكتروني لإعلامك بأننا استلمنا طلبك وسنرد عليك في أقرب وقت ممكن بمزيد من المعلومات.<br /><br /><strong>تحياتي الحارة</strong>\r\n<div style=\"text-align: justify;\">،</div>\r\n<div style=\"text-align: justify;\"><strong>{email_signature}</strong></div>', '{companyname}', '', 0, 1, 0),
(128, 'staff', 'two-factor-authentication', 'arabic', 'المصادقة الثنائية', 'تأكيد تسجيل الدخول الخاص بك', '<strong>مرحبًا</strong> {staff_fullname}<br /><br />لقد تلقيت هذه الرسالة الإلكترونية لأنك مكّنت المصادقة ذات العاملين في حسابك.<br />استخدم الكود التالي لتأكيد تسجيل الدخول الخاص بك:<br /><br /><span style=\"color: #3366ff;\">{two_factor_auth_code}</span><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(129, 'project', 'project-finished-to-customer', 'arabic', 'الإخطار بإنتهاء الخدمة (مرسلة إلى جهات اتصال العملاء)', 'تم إغلاق الخدمة', '<strong>مرحبًا</strong> {contact_fullname}<br /><br /><strong>أنت تتلقى هذا البريد الإلكتروني لأنه تم وضع علامة على الخدمة {project_name} على أنه مكتمل. تم تعيين هذا الخدمة في إطار شركتك ، وأردنا فقط إبقائك على اطلاع.</strong><br /><br />يمكنك مشاهدة الخدمة على الرابط التالي: <span style=\"text-decoration: underline; color: #3366ff;\">{project_name}</span><br /><br />إذا كان لديك أي أسئلة لا تتردد في الاتصال بنا.<br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(130, 'credit_note', 'credit-note-send-to-client', 'arabic', 'إرسال إشعار رصيد دائن بالبريد الإلكتروني', 'تم إنشاء رصيد دائن بالرقم # {credit_note_number}', '<strong>عزيزي</strong> {contact_fullname} ،<br /><br /><strong>لقد أرفقنا إشعار الائتمان برقم</strong> <span style=\"color: #0000ff;\"># {credit_note_number}</span> <strong>كمرجع لك.</strong><br /><br /><strong>التاريخ:</strong> {credit_note_date}<br /><strong>المبلغ الإجمالي:</strong> {credit_note_total}<br /><br />يرجى الاتصال بنا للحصول على مزيد من المعلومات.<br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(131, 'tasks', 'task-status-change-to-staff', 'arabic', 'تغيير حالة المهمة (مرسلة إلى فريق العمل)', 'تم تغيير حالة المهمة', '<strong>مرحبًا</strong> {staff_fullname}<br /><br />{task_user_take_action}<strong> وضع علامة على المهمة على أنها </strong>{task_status}<br /><br /><strong>الاسم:</strong> {task_name}<br /><strong>تاريخ الاستحقاق:</strong> {task_duedate}<br /><br />يمكنك عرض المهمة على الرابط التالي: <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">{task_name}</span></span><br /><br /><strong>أطيب التحيات</strong>،<br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(132, 'tasks', 'task-status-change-to-contacts', 'arabic', 'تغيير حالة المهمة (مرسلة إلى جهات اتصال العملاء)', 'تم تغيير حالة المهمة', '<strong>مرحبًا</strong> {contact_fullname}<br /><br />{task_user_take_action}<strong> وضع علامة على المهمة على أنها {task_status}</strong><br /><br /><strong>الاسم:</strong> {task_name}<br /><strong>تاريخ الاستحقاق:</strong> {task_duedate}<br /><br />يمكنك عرض المهمة على الرابط التالي: <span style=\"color: #3366ff;\">{<span style=\"text-decoration: underline;\">task_name}</span></span><br /><br /><strong>أطيب التحيات،</strong><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(133, 'staff', 'reminder-email-staff', 'arabic', 'بريد تذكير فريق العمل', 'لديك تذكير جديد!', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>لديك تذكير جديد مرتبط بـ {</strong>staff_reminder_relation_name}!<br /><br /><strong>وصف تذكير:</strong><br />{staff_reminder_description}<br /><br /><strong>انقر <span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">هنا</span> </span>لعرض</strong><span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"> {staff_reminder_relation_name</span></span>}<br /><br /><strong>تحياتي الحارة</strong>', '{companyname}', '', 0, 1, 0),
(134, 'contract', 'contract-comment-to-client', 'arabic', 'تعليق جديد (مرسل إلى جهات اتصال العملاء)', 'تعليق جديد على العقد', 'عميلنا الكريم {contact_fullname}<br /><br />السلام عليكم ورحمة الله وبركاته<br /><br /><strong>يوجد تعليق جديد يخص العقد : {contract_subject}</strong><br /><br />يمكنك إستعراض التعليق والرد عليه عبر الرابط : <a href=\"{contract_link}\">{contract_subject}</a><br /><br />مع أطيب التحيات,<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(135, 'contract', 'contract-comment-to-admin', 'arabic', 'تعليق جديد (مرسلة إلى فريق العمل)', 'تعليق جديد على العقد', 'السلام عليكم ورحمة الله وبركاته<br /><br />مرحباً {staff_fullname}<br /><br /><strong>يوجد تعليق جديد يخص العقد : {contract_subject}</strong><br /><br />يمكنك إستعراض التعليق والرد عليه عبر الرابط : <a href=\"{contract_link}\">{contract_subject}</a><br />أو من خلال منطقة المسؤول<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(136, 'subscriptions', 'send-subscription', 'arabic', 'إرسال الإشتراك للعميل', 'تم إنشاء الاشتراك', '', '{companyname}', NULL, 0, 1, 0),
(137, 'subscriptions', 'subscription-payment-failed', 'arabic', 'فشل دفع الاشتراك', 'فشل في دفع الفاتورة الأخيرة', '', '{companyname}', NULL, 0, 1, 0),
(138, 'subscriptions', 'subscription-canceled', 'arabic', 'إلغاء الاشتراك (مرسلة إلى جهة الاتصال الأساسية للعميل) ', 'تم إلغاء اشتراكك', '', '{companyname}', NULL, 0, 1, 0),
(139, 'subscriptions', 'subscription-payment-succeeded', 'arabic', 'نجاح دفع الاشتراك (مرسلة إلى جهة الاتصال الأساسية للعميل)', 'إيصال دفع الاشتراك - {subscription_name}', '', '{companyname}', NULL, 0, 1, 0),
(140, 'contract', 'contract-expiration-to-staff', 'arabic', 'تذكير بانتهاء العقد (مرسل إلى فريق العمل)', 'تذكير بقرب انتهاء صلاحية العقد', 'السلام عليكم ورحمة الله وبركاته,,<br /><br />مرحباً {staff_fullname}<br /><br />هذا تذكير بقرب إنتهاء صلاحية العقد ذو المعلومات التالية<span style=\"font-size: 12pt;\"></span><br /><br /><span style=\"font-size: 12pt;\"><strong>الموضوع:</strong> {contract_subject}</span><br /><span style=\"font-size: 12pt;\"><strong>الوصف:</strong> {contract_description}</span><br /><span style=\"font-size: 12pt;\"><strong>تاريخ البداية:</strong> {contract_datestart}</span><br /><span style=\"font-size: 12pt;\"><strong>تاريه الإنتهاء:</strong> {contract_dateend}</span><br /><br /><span style=\"font-size: 12pt;\">مع أطيب التحيات,</span><br /><span style=\"font-size: 12pt;\">{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(141, 'gdpr', 'gdpr-removal-request', 'arabic', 'طلب إزالة جهة اتصال (مرسلة للمسؤولين)', 'تم تلقي طلب إزالة البيانات', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم طلب إزالة البيانات بواسطة</strong> {contact_fullname}<br /><br /><strong>يمكنك مراجعة هذا الطلب واتخاذ الإجراءات المناسبة مباشرة من منطقة الإدارة</strong>.', '{companyname}', '', 0, 1, 0),
(142, 'gdpr', 'gdpr-removal-request-lead', 'arabic', 'طلب إزالة العميل المحتمل (مرسل إلى المسؤولين)', 'تم تلقي طلب إزالة البيانات', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم طلب إزالة البيانات بواسطة</strong> {lead_name}<br /><br /><strong>يمكنك مراجعة هذا الطلب واتخاذ الإجراءات المناسبة مباشرة من منطقة الإدارة.</strong><br /><br /><strong>لعرض العميل المحتمل داخل منطقة الإدارة ، انقر</strong><span style=\"color: #3366ff;\"> هنا</span>: {<span style=\"text-decoration: underline; color: #3366ff;\">lead_link</span>}', '{companyname}', '', 0, 1, 0),
(143, 'client', 'client-registration-confirmed', 'arabic', 'تأكيد تسجيل العميل', 'تم تأكيد تسجيلك', '', '{companyname}', NULL, 0, 1, 0),
(144, 'contract', 'contract-signed-to-staff', 'arabic', 'توقيع العقد (مرسلة إلى فريق العمل)', 'قام العميل بتوقيع عقد', 'السلام عليكم ورحمة الله وبركاته,,<br /><br />مرحباً {staff_fullname}<br /><br />نفيدكم بإنه قد تم توقيع العقد {contract_subject} من قبل العميل بنجاح<br /><br />يمكنكم متابعة العقد عبر الرابط <a href=\"{contract_link}\">{contract_subject}</a>.<br /><br />{email_signature}', '{companyname}', '', 0, 1, 0),
(145, 'subscriptions', 'customer-subscribed-to-staff', 'arabic', 'تسجيل إشتراك عميل (مرسلة للمسؤولين ومنشئ الاشتراك)', 'تم اشتراك العميل', '', '{companyname}', NULL, 0, 1, 0),
(146, 'client', 'contact-verification-email', 'arabic', 'التحقق من البريد الإلكتروني (مرسلة إلى جهة الاتصال بعد التسجيل)', 'التحقق من عنوان البريد الإلكتروني', '<strong>مرحبًا</strong> {contact_fullname}<br /><br />يرجى النقر على الزر أدناه للتحقق من عنوان بريدك الإلكتروني.<br /><br />\r\n<div style=\"text-align: justify;\"><span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\"><a href=\"{https://law.babillawnet.com/admin/emails/email_template/email_verification_url}\">Verify Email Address</a></span></span></div>\r\n<br /><br />إذا لم تقم بإنشاء حساب ، فلا يلزم اتخاذ أي إجراء آخر<br /><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(147, 'client', 'new-customer-profile-file-uploaded-to-staff', 'arabic', 'تحميل ملف (ملفات) جديدة على الملف الشخصي للعميل (مرسلة إلى فريق العمل)', 'قام العميل بتحميل ملف جديد في ملف التعريف', '<strong>مرحبا!</strong><br /><br />يتم تحميل الملف (الملفات) الجديدة إلى ملف تعريف العميل <strong>({client_company})</strong> بواسطة<strong> {contact_fullname}</strong><br /><br />يمكنك التحقق من الملفات التي تم تحميلها في منطقة المسؤول بالنقر<span style=\"text-decoration: underline; color: #3366ff;\"> هنا </span>أو على الرابط التالي: <span style=\"color: #3366ff;\">{customer_profile_files_admin_link}</span><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(148, 'staff', 'event-notification-to-staff', 'arabic', 'تنبيه بحدث (التقويم)', 'حدث قادم ', '<strong>مرحبًا</strong> {staff_fullname}!<br /><br /><strong>هذا تذكير للحدث {<span style=\"text-decoration: underline;\"><span style=\"color: #3366ff; text-decoration: underline;\">event_title</span></span>} المجدول في {event_start_date}.</strong><br /><br /><strong>مع تحياتي.</strong>', '{companyname}', '', 0, 1, 0),
(149, 'subscriptions', 'subscription-payment-requires-action', 'english', 'Credit Card Authorization Required - SCA', 'Important: Confirm your subscription {subscription_name} payment', '<p>Hello {contact_firstname}</p>\r\n<p><strong>Your bank sometimes requires an additional step to make sure an online transaction was authorized.</strong><br /><br />Because of European regulation to protect consumers, many online payments now require two-factor authentication. Your bank ultimately decides when authentication is required to confirm a payment, but you may notice this step when you start paying for a service or when the cost changes.<br /><br />In order to pay the subscription <strong>{subscription_name}</strong>, you will need to&nbsp;confirm your payment by clicking on the follow link: <strong><a href=\"{subscription_authorize_payment_link}\">{subscription_authorize_payment_link}</a></strong><br /><br />To view the subscription, please click at the following link: <a href=\"{subscription_link}\"><span>{subscription_link}</span></a><br />or you can login in our dedicated area here: <a href=\"{crm_url}/login\">{crm_url}/login</a> in case you want to update your credit card or view the subscriptions you are subscribed.<br /><br />Best Regards,<br />{email_signature}</p>', '{companyname} | CRM', '', 0, 1, 0),
(150, 'subscriptions', 'subscription-payment-requires-action', 'arabic', 'طلب تفويض بطاقة الائتمان - SCA', 'هام: قم بتأكيد دفع اشتراكك {subscription_name}', '', '{companyname}', NULL, 0, 1, 0),
(151, 'sessions', 'session-added-as-follower', 'english', 'Staff Member Added as Follower on Session (Sent to Staff)', 'Staff Member Added as Follower on Session', '<h4 class=\"no-margin\">Staff Member Added as Follower on Session<br />{session_user_take_action}<br />{session_link}<br />{session_name}<br />{session_description}<br />{session_status}<br />{session_priority}<br />{session_startdate}<br />{session_duedate}<br />{session_related}<br /><br /></h4>', '{companyname} ', '', 0, 1, 0);
INSERT INTO `tblemailtemplates` (`emailtemplateid`, `type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
(152, 'sessions', 'session-added-as-follower', 'arabic', 'تمت إضافة موظف لمتابعة جلسة (مرسلة إلى فريق العمل)', 'تمت إضافة موظف كمتابع في الجلسة', '<h4 class=\"no-margin\">تمت إضافة عضو هيئة تدريس كمتابع في الجلسة<br />{session_user_take_action}<br />{session_link}<br />{session_name}<br />{session_description}<br />{session_status}<br />{session_priority}<br />{session_startdate}<br />{session_duedate}<br />{session_related}<br /><br /></h4>', '{companyname} ', '', 0, 1, 0),
(153, 'sessions', 'session-assigned', 'english', 'New Session Assigned (Sent to Staff)', '', '<h4 class=\"no-margin\">New Session Assigned&nbsp;</h4>', '{companyname}', '', 0, 1, 0),
(154, 'sessions', 'session-assigned', 'arabic', 'تخصيص جلسة جديدة (مرسلة إلى فريق العمل)', 'تكليف بحضور جلسة', '<strong>تم تعيين جلسة جديدة</strong>', '{companyname}', '', 0, 1, 0),
(155, 'sessions', 'session-deadline-notification', 'english', 'Session Deadline Reminder - Sent to Assigned Members', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(156, 'sessions', 'session-deadline-notification', 'arabic', 'تذكير بالموعد النهائي للجلسة - مرسلة إلى الموظفين المعينين', 'تذكير نهائي بموعد الجلسة', '', '{companyname}', NULL, 0, 1, 0),
(157, 'sessions', 'session-added-attachment-to-contacts', 'english', 'New Attachment(s) on Session (Sent to Customer Contacts)', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(158, 'sessions', 'session-added-attachment-to-contacts', 'arabic', 'مرفقات جديدة في الجلسة (مرسلة إلى جهات اتصال العملاء)', 'تم إضافة مرفقات للجلسة', '', '{companyname}', NULL, 0, 1, 0),
(159, 'sessions', 'session-added-attachment', 'english', 'New Attachment(s) on Session (Sent to Staff)', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(160, 'sessions', 'session-added-attachment', 'arabic', 'مرفقات جديدة للجلسة (مرسلة لفريق العمل)', 'تم إضافة مرفقات للجلسة', '', '{companyname}', NULL, 0, 1, 0),
(161, 'sessions', 'session-commented-to-contacts', 'english', 'New Comment on Task (Sent to Customer Contacts)', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(162, 'sessions', 'session-commented-to-contacts', 'arabic', 'تعليق جديد على الجلسة (مرسل إلى جهات اتصال العملاء)', 'تعليق جديد على الجلسة', '', '{companyname}', NULL, 0, 1, 0),
(163, 'sessions', 'session-commented', 'english', 'New Comment on Session (Sent to Staff)', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(164, 'sessions', 'session-commented', 'arabic', 'تعليق جديد على الجلسة (مرسل إلى فريق العمل)', 'تعليق جديد على الجلسة', '', '{companyname}', NULL, 0, 1, 0),
(165, 'sessions', 'session-status-change-to-contacts', 'english', 'Session Status Changed (Sent to Customer Contacts)', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(166, 'sessions', 'session-status-change-to-contacts', 'arabic', 'تغيير حالة الجلسة (مرسلة إلى جهات اتصال العملاء)', 'تم تغيير حالة الجلسة', '', '{companyname}', NULL, 0, 1, 0),
(167, 'sessions', 'session-status-change-to-staff', 'english', 'Session Status Changed (Sent to Staff)', '', '', '{companyname} | CRM', NULL, 0, 1, 0),
(168, 'sessions', 'session-status-change-to-staff', 'arabic', 'تغيير حالة الجلسة (مرسلة إلى فريق العمل)', 'تم تغيير حالة الجلسة', '', '{companyname}', NULL, 0, 1, 0),
(169, 'sessions', 'send_report_session', 'arabic', 'تقرير الجلسة (مرسل إلى فريق العمل)', 'تقرير الجلسة', 'عربية:<br />{session_name} <br />{session_user_take_action}<br />{session_link}<br />{session_description}<br />{session_status}<br />{session_priority}<br />{session_startdate}<br />{session_duedate}<br />{session_related}<br />إرسال تقرير', '{companyname}', '', 0, 1, 0),
(170, 'sessions', 'send_report_session', 'english', 'Session Send Report (Sent to Staff)', 'send_report_session', 'english<br />{session_name} <br />{session_user_take_action}<br />{session_link}<br />{session_description}<br />{session_status}<br />{session_priority}<br />{session_startdate}<br />{session_duedate}<br />{session_related}<br /><br />send_report_session', '{companyname}', '', 0, 1, 0),
(171, 'sessions', 'next_session_action', 'english', 'Reminder For Next Session Action', '', '<h3 class=\"no-margin\" style=\"text-align: right;\"><span style=\"background-color: #ffff99; color: #999999;\"><strong>Reminder For Next Session Action</strong></span><br /><br />السلام عليكم&nbsp;<br />هذا البريد هو تذكير بموعد جلسة جديد تم تحديده<br />سيكون تاريخ الموعد التالي في: <span style=\"background-color: #ccffcc;\">{next_session_time}</span><br />التوقيت: <span style=\"background-color: #008080;\">{next_session_date}</span><br />نمط الجلسة: <span style=\"background-color: #ccffcc;\">{session_type}</span><br />معلومات الجلسة: <span style=\"background-color: #ccffcc;\">{session_information}</span><br />قرار المحكمة: <span style=\"background-color: #ccffcc;\">{court_decision}<br /><br /><br /></span></h3>', '{companyname}', '', 0, 1, 0),
(172, 'sessions', 'next_session_action', 'arabic', 'تذكير بإجراءات الجلسة القادمة', 'إجراءات مطلوبة للجلسة القادمة', '<strong>تذكير بإجراء الجلسة التالية</strong>:<br />\r\n<h3 class=\"no-margin\" style=\"text-align: right;\">السلام عليكم&nbsp;<br />هذا البريد هو تذكير بموعد جلسة جديد تم تحديده<br />سيكون تاريخ الموعد التالي في: <span style=\"background-color: #ccffcc;\">{next_session_time}</span><br />التوقيت: <span style=\"background-color: #008080;\">{next_session_date}</span><br />نمط الجلسة: <span style=\"background-color: #ccffcc;\">{session_type}</span><br />معلومات الجلسة: <span style=\"background-color: #ccffcc;\">{session_information}</span><br />قرار المحكمة: <span style=\"background-color: #ccffcc;\">{court_decision}<br /></span></h3>', '{companyname}', '', 0, 1, 0),
(173, 'appointly', 'appointment-cron-reminder-to-staff', 'english', 'Appointment reminder (Sent to Staff and Attendees)', 'You have an upcoming appointment !', '<span> Hello {staff_fullname}</span><br /><span> You have an upcoming appointment that is need to be held date {appointment_date} and location {appointment_location}</span><br /><br /><span><strong>Additional info for your appointment:</strong></span><br /><span><strong>Appointment Subject:</strong> {appointment_subject}</span><br /><span><strong>Appointment Description:</strong> {appointment_description}</span><br /><span><strong>Appointment scheduled date to start:</strong> {appointment_date}</span><br /><span><strong>You can view this appointment at the following link:</strong> <a href=\"{appointment_admin_url}\">Your appointment URL</a></span><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(174, 'appointly', 'appointment-cancelled-to-staff', 'english', 'Appointment cancelled (Sent to Staff and Attendees)', 'Appointment has been cancelled !', '<span> Hello {staff_fullname}. </span><br /><br /><span> The appointment that needed to be held on date {appointment_date} and location {appointment_location} with contact {appointment_client_name} is cancelled.</span><br /><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(175, 'appointly', 'appointment-cancelled-to-contact', 'english', 'Appointment cancelled (Sent to Contact)', 'Your appointment has been cancelled !', '<span> Hello {appointment_client_name}. </span><br /><br /><span> The appointment that needed to be held on date {appointment_date} and location {appointment_location} is now cancelled.</span><br /><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(176, 'appointly', 'appointment-cron-reminder-to-contact', 'english', 'Appointment reminder (Sent to Contact)', 'You have an upcoming appointment !', '<span> Hello {appointment_client_name}. </span><br /><br /><span> You have an upcoming appointment that is need to be held date {appointment_date} and location {appointment_location}.</span><br /><br /><span><strong>Additional info for your appointment</strong></span><br /><span><strong>Appointment Subject:</strong> {appointment_subject}</span><br /><span><strong>Appointment Description:</strong> {appointment_description}</span><br /><span><strong>Appointment scheduled date to start:</strong> {appointment_date}</span><br /><span><strong>You can view this appointment at the following link:</strong> <a href=\"{appointment_public_url}\">Your appointment URL</a></span><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(177, 'appointly', 'appointment-approved-to-staff', 'english', 'Appointment approved (Sent to Staff and Atendees)', 'You are added as a appointment attendee', '<span> Hello {staff_fullname}.</span><br /><br /><span> You are added as a appointment attendee.</span><br /><br /><span><strong>Appointment Subject:</strong> {appointment_subject}</span><br /><span><strong>Appointment Description:</strong> {appointment_description}</span><br /><span><strong>Appointment scheduled date to start:</strong> {appointment_date}</span><br /><span><strong>You can view this appointment at the following link:</strong> <a href=\"{appointment_admin_url}\">Your appointment URL</a></span><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(178, 'appointly', 'appointment-approved-to-contact', 'english', 'Appointment approved (Sent to Contact)', 'Your appointment has been approved', '<span> Hello {appointment_client_name}.</span><br /><br /><span> You appointment has been approved!</span><br /><br /><span><strong>Appointment Subject:</strong> {appointment_subject}</span><br /><span><strong>Appointment Description:</strong> {appointment_description}</span><br /><span><strong>Appointment scheduled date to start:</strong> {appointment_date}</span><br /><span><strong>You can keep track of your appointment at the following link:</strong> <a href=\"{appointment_public_url}\">Your appointment URL</a></span><br /><span><br />If you have any questions Please contact us for more information.</span><br /><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', '{companyname}', '', 0, 1, 0),
(179, 'appointly', 'appointment-submitted-to-staff', 'english', 'New appointment request (Sent to Responsible Person)', 'New appointment request via external form', '<span><span>Hello {staff_fullname}<br /><br />New appointment request submitted via external form</span>.<br /><br /><span><strong>Appointment Subject:</strong> {appointment_subject}</span><br /><br /><span><strong>Appointment Description:</strong> {appointment_description}</span><br /><br /><span><strong>Appointment requested scheduled start date:</strong> {appointment_date}</span><br /><br /><span><strong>You can view this appointment request at the following link:</strong> <a href=\"{appointment_admin_url}\">{appointment_admin_url}</a></span><br /><br /><br />{companyname}<br />{crm_url}<br /><span></span></span>', '{companyname}', '', 0, 1, 0),
(180, 'appointly', 'callback-assigned-to-staff', 'english', 'Assigned to callback (Sent to Staff)', 'You have been assigned to handle a new callback', '<span><span>Hello {staff_fullname}<br /><br />An admin assigned a callback to you, you can view this callback request at the following link: <a href=\"{admin_url/appointly/callbacks}\">{admin_url}/appointly/callbacks</a></span><br /><br /><br />{companyname}<br />{crm_url}<br /><span></span></span>', '{companyname}', '', 0, 1, 0),
(181, 'appointly', 'newcallback-requested-to-staff', 'english', 'New callback request (Sent to Callbacks Responsible Person)', 'You have a new callback request', '<span><span>Hello {staff_fullname}<br /><br />A new callback request has just been submitted, fast navigate to callbacks to view latest callback submitted: <a href=\"{admin_url/appointly/callbacks}\">{admin_url}/appointly/callbacks</a></span><br /><br /><br />{companyname}<br />{crm_url}<br /><span></span></span>', '{companyname}', '', 0, 1, 0),
(182, 'appointly', 'appointly-appointment-request-feedback', 'english', 'Request Appointment Feedback (Sent to Client)', 'Feedback request for Appointment', '<span><span>Hello {appointment_client_name} <br /><br />A new feedback request has just been submitted, please leave your comments and thoughts about this past appointment, fast navigate to the appointment to add a feedback: <a href=\"{appointment_public_url}\">{appointment_public_url}</a></span><br /><br /><br />{companyname}<br />{crm_url}<br /><span></span></span>', '{companyname}', '', 0, 1, 0),
(183, 'appointly', 'appointly-appointment-feedback-received', 'english', 'New Feedback Received (Sent to Responsible Person)', 'New appointment feedback rating received', '<span><span>Hello {staff_fullname} <br /><br />A new feedback rating has been received from client {appointment_client_name}. View the new feedback rating submitted at the following link: <a href=\"{appointment_admin_url}\">{appointment_admin_url}</a></span><br /><br /><br />{companyname}<br />{crm_url}<br /><span></span></span>', '{companyname}', '', 0, 1, 0),
(184, 'appointly', 'appointly-appointment-feedback-updated', 'english', 'Feedback Updated (Sent to Responsible Person)', 'Appointment feedback rating updated', '<span><span>Hello {staff_fullname} <br /><br />An existing feedback was just updated from client {appointment_client_name}. View the new rating submitted at the following link: <a href=\"{appointment_admin_url}\">{appointment_admin_url}</a></span><br /><br /><br />{companyname}<br />{crm_url}<br /><span></span></span>', '{companyname}', '', 0, 1, 0),
(185, 'appointly', 'appointment-cron-reminder-to-staff', 'arabic', 'تذكير بموعد (مرسلة لفريق العمل والحضور)', 'لديك موعد قادم!', '<strong>مرحبًا</strong> {staff_fullname}<br /><strong>لديك موعد قادم يجب تحديد تاريخه</strong> {appointment_date} <strong>والموقع</strong> {appointment_location}<br /><br /><strong>معلومات إضافية لموعدك:</strong><br /><strong>موضوع الموعد</strong>: {appointment_subject}<br /><strong>وصف الموعد</strong>: {appointment_description}<br /><strong>الموعد المقرر للبدء</strong>: {appointment_date}<br />يمكنك عرض هذا الموعد على الرابط التالي: <span><a href=\"{https://law.babillawnet.com/admin/emails/email_template/appointment_admin_url}\">Your appointment URL</a></span><br /><br /><strong>أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(186, 'appointly', 'appointment-cancelled-to-staff', 'arabic', 'إلغاء الموعد (مرسلة لفريق العمل والحضور)', 'تم إلغاء الموعد', '<strong>مرحبًا</strong> {staff_fullname}.<br /><br />الموعد المطلوب عقده في تاريخ {appointment_date} والموقع {appointment_location} مع جهة الاتصال {appointment_client_name} <strong>تم إلغاؤه</strong>.<br /><br /><br /><strong>أطيب التحيات</strong>\r\n<div style=\"text-align: justify;\"></div>\r\n<strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(187, 'appointly', 'appointment-cancelled-to-contact', 'arabic', 'تم إلغاء الموعد (مرسلة إلى جهة الاتصال)', 'تم إلغاء الموعد', '<strong>مرحبًا</strong> {appointment_client_name}.<br /><br /><strong>الموعد المطلوب عقده في التاريخ</strong> {appointment_date}<strong> والموقع</strong> {appointment_location}<strong> تم إلغاؤه الآن.</strong>\r\n<div style=\"text-align: justify;\"></div>\r\n<strong>أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(188, 'appointly', 'appointment-cron-reminder-to-contact', 'arabic', 'تذكير بموعد (مرسلة إلى جهات الاتصال)', 'لديك موعد قادم', '<strong>مرحبًا</strong> {appointment_client_name}.<br /><br /><strong>لديك موعد قادم يجب تحديد تاريخه</strong> {appointment_date} <strong>والموقع</strong> {appointment_location}.<br /><br /><strong>معلومات إضافية لموعدك</strong><br /><strong>موضوع الموعد:</strong> {appointment_subject}<br /><strong>وصف الموعد:</strong> {appointment_description}<br /><strong>الموعد المقرر للبدء:</strong> {appointment_date}<br /><strong>يمكنك عرض هذا الموعد على الرابط التالي</strong>: <span><a href=\"{https://law.babillawnet.com/admin/emails/email_template/appointment_public_url}\">Your appointment URL</a></span><br /><br /><strong>أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(189, 'appointly', 'appointment-approved-to-staff', 'arabic', 'تأكيد الموعد (مرسلة لفريق العمل والحضور)', 'تم إضافتك لحضور إجتماع', '<strong>مرحبًا</strong> {staff_fullname}.<br /><br /><strong>تتم إضافتك كحضور موعد.</strong><br /><br /><strong>موضوع الموعد</strong>: {appointment_subject}<br /><strong>وصف الموعد</strong>: {appointment_description}<br /><strong>الموعد المقرر للبد</strong>ء: {appointment_date}<br /><strong>يمكنك عرض هذا الموعد على الرابط التالي</strong>: <span><a href=\"{https://law.babillawnet.com/admin/emails/email_template/appointment_admin_url}\">Your appointment URL</a></span><br /><br /><strong>أطيب التحيات</strong><br /><br /><strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(190, 'appointly', 'appointment-approved-to-contact', 'arabic', 'تأكيد الموعد (مرسلة إلى جهات الاتصال)', 'تمت الموافقة على الموعد', '<strong>مرحبًا</strong> {appointment_client_name}.<br /><br /><strong>تمت الموافقة على موعدك</strong>!<br /><br /><strong>موضوع الموعد</strong>: {appointment_subject}<br /><strong>وصف الموعد</strong>: {appointment_description}<br /><strong>الموعد المقرر للبدء</strong>: {appointment_date}<br />يمكنك تتبع موعدك على الرابط التالي:<span> <a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/appointment_public_url}\">Your appointment URL</a></span><br /><br />إذا كان لديك أي أسئلة يرجى الاتصال بنا لمزيد من المعلومات.<br /><br /><br /><strong>أطيب التحيات</strong>\r\n<div></div>\r\n<strong>{email_signature}</strong>', '{companyname}', '', 0, 1, 0),
(191, 'appointly', 'appointment-submitted-to-staff', 'arabic', 'طلب موعد (مرسل إلى المسؤول)', 'طلب موعد جديد عبر نموذج خارجي', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>قدم طلب موعد جديد عبر نموذج خارجي.</strong><br /><br /><strong>موضوع الموعد</strong>: {appointment_subject}<br /><br /><strong>وصف الموعد:</strong> {appointment_description}<br /><br /><strong>تم طلب الموعد في تاريخ البدء المجدول</strong>: {appointment_date}<br /><br /><strong>يمكنك عرض طلب الموعد هذا على الرابط التالي:</strong> {<span><a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/appointment_admin_url}\">appointment_admin_url</a></span>}<br /><br /><br />{companyname}<br />{crm_url}', '{companyname}', '', 0, 1, 0),
(192, 'appointly', 'callback-assigned-to-staff', 'arabic', 'تخصيص الرد على إتصال (مرسلة إلى فريق العمل)', 'لقد تم تكليفك بالرد على اتصال جديد', '<strong>مرحبًا</strong> {staff_fullname}<br /><br />قام أحد المشرفين بتعيين رد اتصال لك ، ويمكنك عرض طلب رد الاتصال هذا على الرابط التالي: <span><a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/admin_url/appointly/callbacks}\">{admin_url}/appointly/callbacks</a></span><span style=\"background-color: #3366ff;\">}</span><br /><br /><br />{companyname}<br />{crm_url}', '{companyname}', '', 0, 1, 0),
(193, 'appointly', 'newcallback-requested-to-staff', 'arabic', 'طلب إتصال (مرسل إلى الشخص المسؤول عن الرد على الاتصال)', 'لديك طلب اتصال جديد', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم إرسال طلب رد جديد ، انتقل سريعًا إلى عمليات رد الاتصال لعرض آخر رد اتصال تم</strong> <strong>إرساله:</strong> <span><a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/admin_url/appointly/callbacks}\">{admin_url}/appointly/callbacks</a></span>}<br /><br /><br /><strong>{companyname}</strong><br /><strong>{crm_url}</strong>', '{companyname}', '', 0, 1, 0),
(194, 'appointly', 'appointly-appointment-request-feedback', 'arabic', 'طلب تقييم الموعد (مرسلة للعميل)', 'طلب تقييم الموعد', '<strong>عميلنا الكريم</strong> {appointment_client_name}<br /><br /><strong>تم إرسال طلب تعليقات جديد للتو ، يرجى ترك تعليقاتك وأفكارك حول هذا الموعد السابق</strong>\r\n<div style=\"text-align: justify;\"><strong>، وانتقل سريعًا إلى الموعد لإضافة تعليق:</strong></div>\r\n{<span><a href=\"{https://law.babillawnet.com/admin/emails/email_template/appointment_public_url}\">appointment_public_url</a></span>}<br /><br /><br />{companyname}<br />{crm_url}', '{companyname}', '', 0, 1, 0),
(195, 'appointly', 'appointly-appointment-feedback-received', 'arabic', 'تلقي تقييمات جديدة (مرسلة إلى الشخص المسؤول)', 'تم تلقي تقييم جديد على الموعد', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم تلقي تقييم جديد للتعليقات من العميل</strong> {appointment_client_name}. <strong>شاهد تقييم التعليقات الجديد المقدم على الرابط التالي:</strong> {<span><a href=\"{https%3A//law.babillawnet.com/admin/emails/email_template/appointment_admin_url}\">appointment_admin_url</a></span>}<br /><br /><br /><strong>{companyname}</strong><br /><strong>{crm_url}</strong>', '{companyname}', '', 0, 1, 0),
(196, 'appointly', 'appointly-appointment-feedback-updated', 'arabic', 'تحديث التقييم (مرسلة إلى المسؤول)', 'تم تحديث التقييم على الموعد', '<strong>مرحبًا</strong> {staff_fullname}<br /><br /><strong>تم تحديث التعليقات الحالية للتو من العميل</strong> {appointment_client_name}. <strong>شاهد التقييم الجديد المقدم على الرابط التالي</strong>: {<span><a href=\"{https://law.babillawnet.com/admin/emails/email_template/appointment_admin_url}\">appointment_admin_url</a></span>}<br /><br /><br /><strong>{companyname}</strong><br /><strong>{crm_url}</strong>', '{companyname}', '', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblestimates`
--

CREATE TABLE `tblestimates` (
  `id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `datesend` datetime DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(32) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `expirydate` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `clientnote` text,
  `adminnote` text,
  `discount_percent` decimal(15,2) DEFAULT '0.00',
  `discount_total` decimal(15,2) DEFAULT '0.00',
  `discount_type` varchar(30) DEFAULT NULL,
  `invoiceid` int(11) DEFAULT NULL,
  `invoiced_date` datetime DEFAULT NULL,
  `terms` text,
  `reference_no` varchar(100) DEFAULT NULL,
  `sale_agent` int(11) NOT NULL DEFAULT '0',
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
  `show_shipping_on_estimate` tinyint(1) NOT NULL DEFAULT '1',
  `show_quantity_as` int(11) NOT NULL DEFAULT '1',
  `pipeline_order` int(11) NOT NULL DEFAULT '0',
  `is_expiry_notified` int(11) NOT NULL DEFAULT '0',
  `acceptance_firstname` varchar(50) DEFAULT NULL,
  `acceptance_lastname` varchar(50) DEFAULT NULL,
  `acceptance_email` varchar(100) DEFAULT NULL,
  `acceptance_date` datetime DEFAULT NULL,
  `acceptance_ip` varchar(40) DEFAULT NULL,
  `signature` varchar(40) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblevents`
--

CREATE TABLE `tblevents` (
  `eventid` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` text,
  `userid` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `public` int(11) NOT NULL DEFAULT '0',
  `color` varchar(10) DEFAULT NULL,
  `isstartnotified` tinyint(1) NOT NULL DEFAULT '0',
  `reminder_before` int(11) NOT NULL DEFAULT '0',
  `reminder_before_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblexpenses`
--

CREATE TABLE `tblexpenses` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax2` int(11) NOT NULL DEFAULT '0',
  `reference_no` varchar(100) DEFAULT NULL,
  `note` text,
  `expense_name` varchar(191) DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `billable` int(11) DEFAULT '0',
  `invoiceid` int(11) DEFAULT NULL,
  `paymentmode` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT '0',
  `cycles` int(11) NOT NULL DEFAULT '0',
  `total_cycles` int(11) NOT NULL DEFAULT '0',
  `custom_recurring` int(11) NOT NULL DEFAULT '0',
  `last_recurring_date` date DEFAULT NULL,
  `create_invoice_billable` tinyint(1) DEFAULT NULL,
  `send_invoice_to_customer` tinyint(1) NOT NULL,
  `recurring_from` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `addedfrom` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblexpenses_categories`
--

CREATE TABLE `tblexpenses_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblfiles`
--

CREATE TABLE `tblfiles` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `filetype` varchar(40) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT '0',
  `attachment_key` varchar(32) DEFAULT NULL,
  `external` varchar(40) DEFAULT NULL,
  `external_link` text,
  `thumbnail_link` text COMMENT 'For external usage',
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT '0',
  `task_comment_id` int(11) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblform_questions`
--

CREATE TABLE `tblform_questions` (
  `questionid` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `question` mediumtext NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `question_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblform_question_box`
--

CREATE TABLE `tblform_question_box` (
  `boxid` int(11) NOT NULL,
  `boxtype` varchar(10) NOT NULL,
  `questionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblform_question_box_description`
--

CREATE TABLE `tblform_question_box_description` (
  `questionboxdescriptionid` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `boxid` mediumtext NOT NULL,
  `questionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblform_results`
--

CREATE TABLE `tblform_results` (
  `resultid` int(11) NOT NULL,
  `boxid` int(11) NOT NULL,
  `boxdescriptionid` int(11) DEFAULT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `questionid` int(11) NOT NULL,
  `answer` text,
  `resultsetid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblgdpr_requests`
--

CREATE TABLE `tblgdpr_requests` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL DEFAULT '0',
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `lead_id` int(11) NOT NULL DEFAULT '0',
  `request_type` varchar(191) DEFAULT NULL,
  `status` varchar(40) DEFAULT NULL,
  `request_date` datetime NOT NULL,
  `request_from` varchar(150) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblgoals`
--

CREATE TABLE `tblgoals` (
  `id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `goal_type` int(11) NOT NULL,
  `contract_type` int(11) NOT NULL DEFAULT '0',
  `achievement` int(11) NOT NULL,
  `notify_when_fail` tinyint(1) NOT NULL DEFAULT '1',
  `notify_when_achieve` tinyint(1) NOT NULL DEFAULT '1',
  `notified` int(11) NOT NULL DEFAULT '0',
  `staff_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblinventory_history`
--

CREATE TABLE `tblinventory_history` (
  `id` int(11) NOT NULL,
  `assets` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `acction` varchar(50) NOT NULL,
  `inventory_begin` int(11) DEFAULT NULL,
  `inventory_end` int(11) NOT NULL,
  `cost` decimal(15,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoicepaymentrecords`
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
  `transactionid` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoices`
--

CREATE TABLE `tblinvoices` (
  `id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `datesend` datetime DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `status` int(11) DEFAULT '1',
  `clientnote` text,
  `adminnote` text,
  `last_overdue_reminder` date DEFAULT NULL,
  `cancel_overdue_reminders` int(11) NOT NULL DEFAULT '0',
  `allowed_payment_modes` mediumtext,
  `token` mediumtext,
  `discount_percent` decimal(15,2) DEFAULT '0.00',
  `discount_total` decimal(15,2) DEFAULT '0.00',
  `discount_type` varchar(30) NOT NULL,
  `recurring` int(11) NOT NULL DEFAULT '0',
  `recurring_type` varchar(10) DEFAULT NULL,
  `custom_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `cycles` int(11) NOT NULL DEFAULT '0',
  `total_cycles` int(11) NOT NULL DEFAULT '0',
  `is_recurring_from` int(11) DEFAULT NULL,
  `last_recurring_date` date DEFAULT NULL,
  `terms` text,
  `sale_agent` int(11) NOT NULL DEFAULT '0',
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
  `show_shipping_on_invoice` tinyint(1) NOT NULL DEFAULT '1',
  `show_quantity_as` int(11) NOT NULL DEFAULT '1',
  `project_id` int(11) DEFAULT '0',
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `subscription_id` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblirac_method`
--

CREATE TABLE `tblirac_method` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `facts` text NOT NULL,
  `legal_authority` text NOT NULL,
  `analysis` text NOT NULL,
  `result` text NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbliservice_settings`
--

CREATE TABLE `tbliservice_settings` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbliservice_settings`
--

INSERT INTO `tbliservice_settings` (`id`, `oservice_id`, `name`, `value`) VALUES
(366, 37, 'available_features', 'a:17:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:13:\"project_files\";i:1;s:18:\"project_milestones\";i:0;s:19:\"project_discussions\";i:0;s:13:\"project_gantt\";i:0;s:15:\"project_tickets\";i:0;s:16:\"project_invoices\";i:0;s:17:\"project_estimates\";i:0;s:16:\"project_expenses\";i:0;s:20:\"project_credit_notes\";i:0;s:13:\"project_notes\";i:0;s:16:\"project_activity\";i:0;s:5:\"Phase\";i:0;s:10:\"Procedures\";i:0;s:12:\"help_library\";i:0;}'),
(367, 37, 'view_tasks', '0'),
(368, 37, 'create_tasks', '0'),
(369, 37, 'edit_tasks', '0'),
(370, 37, 'comment_on_tasks', '0'),
(371, 37, 'view_task_comments', '0'),
(372, 37, 'view_task_attachments', '0'),
(373, 37, 'view_task_checklist_items', '0'),
(374, 37, 'upload_on_tasks', '0'),
(375, 37, 'view_task_total_logged_time', '0'),
(376, 37, 'view_finance_overview', '0'),
(377, 37, 'upload_files', '0'),
(378, 37, 'open_discussions', '0'),
(379, 37, 'view_milestones', '0'),
(380, 37, 'view_gantt', '0'),
(381, 37, 'view_timesheets', '0'),
(382, 37, 'view_activity_log', '0'),
(383, 37, 'view_team_members', '0'),
(384, 37, 'hide_tasks_on_main_tasks_table', '0'),
(385, 38, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(386, 38, 'view_tasks', '0'),
(387, 38, 'create_tasks', '0'),
(388, 38, 'edit_tasks', '0'),
(389, 38, 'comment_on_tasks', '0'),
(390, 38, 'view_task_comments', '0'),
(391, 38, 'view_task_attachments', '0'),
(392, 38, 'view_task_checklist_items', '0'),
(393, 38, 'upload_on_tasks', '0'),
(394, 38, 'view_task_total_logged_time', '0'),
(395, 38, 'view_finance_overview', '0'),
(396, 38, 'upload_files', '0'),
(397, 38, 'open_discussions', '0'),
(398, 38, 'view_milestones', '0'),
(399, 38, 'view_gantt', '0'),
(400, 38, 'view_timesheets', '0'),
(401, 38, 'view_activity_log', '0'),
(402, 38, 'view_team_members', '0'),
(403, 38, 'hide_tasks_on_main_tasks_table', '0'),
(404, 39, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(405, 39, 'view_tasks', '0'),
(406, 39, 'create_tasks', '0'),
(407, 39, 'edit_tasks', '0'),
(408, 39, 'comment_on_tasks', '0'),
(409, 39, 'view_task_comments', '0'),
(410, 39, 'view_task_attachments', '0'),
(411, 39, 'view_task_checklist_items', '0'),
(412, 39, 'upload_on_tasks', '0'),
(413, 39, 'view_task_total_logged_time', '0'),
(414, 39, 'view_finance_overview', '0'),
(415, 39, 'upload_files', '0'),
(416, 39, 'open_discussions', '0'),
(417, 39, 'view_milestones', '0'),
(418, 39, 'view_gantt', '0'),
(419, 39, 'view_timesheets', '0'),
(420, 39, 'view_activity_log', '0'),
(421, 39, 'view_team_members', '0'),
(422, 39, 'hide_tasks_on_main_tasks_table', '0'),
(423, 40, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(424, 40, 'view_tasks', '0'),
(425, 40, 'create_tasks', '0'),
(426, 40, 'edit_tasks', '0'),
(427, 40, 'comment_on_tasks', '0'),
(428, 40, 'view_task_comments', '0'),
(429, 40, 'view_task_attachments', '0'),
(430, 40, 'view_task_checklist_items', '0'),
(431, 40, 'upload_on_tasks', '0'),
(432, 40, 'view_task_total_logged_time', '0'),
(433, 40, 'view_finance_overview', '0'),
(434, 40, 'upload_files', '0'),
(435, 40, 'open_discussions', '0'),
(436, 40, 'view_milestones', '0'),
(437, 40, 'view_gantt', '0'),
(438, 40, 'view_timesheets', '0'),
(439, 40, 'view_activity_log', '0'),
(440, 40, 'view_team_members', '0'),
(441, 40, 'hide_tasks_on_main_tasks_table', '0'),
(442, 41, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(443, 41, 'view_tasks', '0'),
(444, 41, 'create_tasks', '0'),
(445, 41, 'edit_tasks', '0'),
(446, 41, 'comment_on_tasks', '0'),
(447, 41, 'view_task_comments', '0'),
(448, 41, 'view_task_attachments', '0'),
(449, 41, 'view_task_checklist_items', '0'),
(450, 41, 'upload_on_tasks', '0'),
(451, 41, 'view_task_total_logged_time', '0'),
(452, 41, 'view_finance_overview', '0'),
(453, 41, 'upload_files', '0'),
(454, 41, 'open_discussions', '0'),
(455, 41, 'view_milestones', '0'),
(456, 41, 'view_gantt', '0'),
(457, 41, 'view_timesheets', '0'),
(458, 41, 'view_activity_log', '0'),
(459, 41, 'view_team_members', '0'),
(460, 41, 'hide_tasks_on_main_tasks_table', '0'),
(461, 42, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(462, 42, 'view_tasks', '0'),
(463, 42, 'create_tasks', '0'),
(464, 42, 'edit_tasks', '0'),
(465, 42, 'comment_on_tasks', '0'),
(466, 42, 'view_task_comments', '0'),
(467, 42, 'view_task_attachments', '0'),
(468, 42, 'view_task_checklist_items', '0'),
(469, 42, 'upload_on_tasks', '0'),
(470, 42, 'view_task_total_logged_time', '0'),
(471, 42, 'view_finance_overview', '0'),
(472, 42, 'upload_files', '0'),
(473, 42, 'open_discussions', '0'),
(474, 42, 'view_milestones', '0'),
(475, 42, 'view_gantt', '0'),
(476, 42, 'view_timesheets', '0'),
(477, 42, 'view_activity_log', '0'),
(478, 42, 'view_team_members', '0'),
(479, 42, 'hide_tasks_on_main_tasks_table', '0'),
(480, 43, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(481, 43, 'view_tasks', '0'),
(482, 43, 'create_tasks', '0'),
(483, 43, 'edit_tasks', '0'),
(484, 43, 'comment_on_tasks', '0'),
(485, 43, 'view_task_comments', '0'),
(486, 43, 'view_task_attachments', '0'),
(487, 43, 'view_task_checklist_items', '0'),
(488, 43, 'upload_on_tasks', '0'),
(489, 43, 'view_task_total_logged_time', '0'),
(490, 43, 'view_finance_overview', '0'),
(491, 43, 'upload_files', '0'),
(492, 43, 'open_discussions', '0'),
(493, 43, 'view_milestones', '0'),
(494, 43, 'view_gantt', '0'),
(495, 43, 'view_timesheets', '0'),
(496, 43, 'view_activity_log', '0'),
(497, 43, 'view_team_members', '0'),
(498, 43, 'hide_tasks_on_main_tasks_table', '0'),
(499, 44, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(500, 44, 'view_tasks', '0'),
(501, 44, 'create_tasks', '0'),
(502, 44, 'edit_tasks', '0'),
(503, 44, 'comment_on_tasks', '0'),
(504, 44, 'view_task_comments', '0'),
(505, 44, 'view_task_attachments', '0'),
(506, 44, 'view_task_checklist_items', '0'),
(507, 44, 'upload_on_tasks', '0'),
(508, 44, 'view_task_total_logged_time', '0'),
(509, 44, 'view_finance_overview', '0'),
(510, 44, 'upload_files', '0'),
(511, 44, 'open_discussions', '0'),
(512, 44, 'view_milestones', '0'),
(513, 44, 'view_gantt', '0'),
(514, 44, 'view_timesheets', '0'),
(515, 44, 'view_activity_log', '0'),
(516, 44, 'view_team_members', '0'),
(517, 44, 'hide_tasks_on_main_tasks_table', '0'),
(518, 45, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(519, 45, 'view_tasks', '0'),
(520, 45, 'create_tasks', '0'),
(521, 45, 'edit_tasks', '0'),
(522, 45, 'comment_on_tasks', '0'),
(523, 45, 'view_task_comments', '0'),
(524, 45, 'view_task_attachments', '0'),
(525, 45, 'view_task_checklist_items', '0'),
(526, 45, 'upload_on_tasks', '0'),
(527, 45, 'view_task_total_logged_time', '0'),
(528, 45, 'view_finance_overview', '0'),
(529, 45, 'upload_files', '0'),
(530, 45, 'open_discussions', '0'),
(531, 45, 'view_milestones', '0'),
(532, 45, 'view_gantt', '0'),
(533, 45, 'view_timesheets', '0'),
(534, 45, 'view_activity_log', '0'),
(535, 45, 'view_team_members', '0'),
(536, 45, 'hide_tasks_on_main_tasks_table', '0'),
(537, 46, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(538, 46, 'view_tasks', '0'),
(539, 46, 'create_tasks', '0'),
(540, 46, 'edit_tasks', '0'),
(541, 46, 'comment_on_tasks', '0'),
(542, 46, 'view_task_comments', '0'),
(543, 46, 'view_task_attachments', '0'),
(544, 46, 'view_task_checklist_items', '0'),
(545, 46, 'upload_on_tasks', '0'),
(546, 46, 'view_task_total_logged_time', '0'),
(547, 46, 'view_finance_overview', '0'),
(548, 46, 'upload_files', '0'),
(549, 46, 'open_discussions', '0'),
(550, 46, 'view_milestones', '0'),
(551, 46, 'view_gantt', '0'),
(552, 46, 'view_timesheets', '0'),
(553, 46, 'view_activity_log', '0'),
(554, 46, 'view_team_members', '0'),
(555, 46, 'hide_tasks_on_main_tasks_table', '0'),
(556, 47, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(557, 47, 'view_tasks', '0'),
(558, 47, 'create_tasks', '0'),
(559, 47, 'edit_tasks', '0'),
(560, 47, 'comment_on_tasks', '0'),
(561, 47, 'view_task_comments', '0'),
(562, 47, 'view_task_attachments', '0'),
(563, 47, 'view_task_checklist_items', '0'),
(564, 47, 'upload_on_tasks', '0'),
(565, 47, 'view_task_total_logged_time', '0'),
(566, 47, 'view_finance_overview', '0'),
(567, 47, 'upload_files', '0'),
(568, 47, 'open_discussions', '0'),
(569, 47, 'view_milestones', '0'),
(570, 47, 'view_gantt', '0'),
(571, 47, 'view_timesheets', '0'),
(572, 47, 'view_activity_log', '0'),
(573, 47, 'view_team_members', '0'),
(574, 47, 'hide_tasks_on_main_tasks_table', '0'),
(575, 48, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(576, 48, 'view_tasks', '0'),
(577, 48, 'create_tasks', '0'),
(578, 48, 'edit_tasks', '0'),
(579, 48, 'comment_on_tasks', '0'),
(580, 48, 'view_task_comments', '0'),
(581, 48, 'view_task_attachments', '0'),
(582, 48, 'view_task_checklist_items', '0'),
(583, 48, 'upload_on_tasks', '0'),
(584, 48, 'view_task_total_logged_time', '0'),
(585, 48, 'view_finance_overview', '0'),
(586, 48, 'upload_files', '0'),
(587, 48, 'open_discussions', '0'),
(588, 48, 'view_milestones', '0'),
(589, 48, 'view_gantt', '0'),
(590, 48, 'view_timesheets', '0'),
(591, 48, 'view_activity_log', '0'),
(592, 48, 'view_team_members', '0'),
(593, 48, 'hide_tasks_on_main_tasks_table', '0'),
(594, 49, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(595, 49, 'view_tasks', '0'),
(596, 49, 'create_tasks', '0'),
(597, 49, 'edit_tasks', '0'),
(598, 49, 'comment_on_tasks', '0'),
(599, 49, 'view_task_comments', '0'),
(600, 49, 'view_task_attachments', '0'),
(601, 49, 'view_task_checklist_items', '0'),
(602, 49, 'upload_on_tasks', '0'),
(603, 49, 'view_task_total_logged_time', '0'),
(604, 49, 'view_finance_overview', '0'),
(605, 49, 'upload_files', '0'),
(606, 49, 'open_discussions', '0'),
(607, 49, 'view_milestones', '0'),
(608, 49, 'view_gantt', '0'),
(609, 49, 'view_timesheets', '0'),
(610, 49, 'view_activity_log', '0'),
(611, 49, 'view_team_members', '0'),
(612, 49, 'hide_tasks_on_main_tasks_table', '0'),
(613, 50, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(614, 50, 'view_tasks', '0'),
(615, 50, 'create_tasks', '0'),
(616, 50, 'edit_tasks', '0'),
(617, 50, 'comment_on_tasks', '0'),
(618, 50, 'view_task_comments', '0'),
(619, 50, 'view_task_attachments', '0'),
(620, 50, 'view_task_checklist_items', '0'),
(621, 50, 'upload_on_tasks', '0'),
(622, 50, 'view_task_total_logged_time', '0'),
(623, 50, 'view_finance_overview', '0'),
(624, 50, 'upload_files', '0'),
(625, 50, 'open_discussions', '0'),
(626, 50, 'view_milestones', '0'),
(627, 50, 'view_gantt', '0'),
(628, 50, 'view_timesheets', '0'),
(629, 50, 'view_activity_log', '0'),
(630, 50, 'view_team_members', '0'),
(631, 50, 'hide_tasks_on_main_tasks_table', '0'),
(632, 51, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(633, 51, 'view_tasks', '0'),
(634, 51, 'create_tasks', '0'),
(635, 51, 'edit_tasks', '0'),
(636, 51, 'comment_on_tasks', '0'),
(637, 51, 'view_task_comments', '0'),
(638, 51, 'view_task_attachments', '0'),
(639, 51, 'view_task_checklist_items', '0'),
(640, 51, 'upload_on_tasks', '0'),
(641, 51, 'view_task_total_logged_time', '0'),
(642, 51, 'view_finance_overview', '0'),
(643, 51, 'upload_files', '0'),
(644, 51, 'open_discussions', '0'),
(645, 51, 'view_milestones', '0'),
(646, 51, 'view_gantt', '0'),
(647, 51, 'view_timesheets', '0'),
(648, 51, 'view_activity_log', '0'),
(649, 51, 'view_team_members', '0'),
(650, 51, 'hide_tasks_on_main_tasks_table', '0'),
(651, 52, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(652, 52, 'view_tasks', '0'),
(653, 52, 'create_tasks', '0'),
(654, 52, 'edit_tasks', '0'),
(655, 52, 'comment_on_tasks', '0'),
(656, 52, 'view_task_comments', '0'),
(657, 52, 'view_task_attachments', '0'),
(658, 52, 'view_task_checklist_items', '0'),
(659, 52, 'upload_on_tasks', '0'),
(660, 52, 'view_task_total_logged_time', '0'),
(661, 52, 'view_finance_overview', '0'),
(662, 52, 'upload_files', '0'),
(663, 52, 'open_discussions', '0'),
(664, 52, 'view_milestones', '0'),
(665, 52, 'view_gantt', '0'),
(666, 52, 'view_timesheets', '0'),
(667, 52, 'view_activity_log', '0'),
(668, 52, 'view_team_members', '0'),
(669, 52, 'hide_tasks_on_main_tasks_table', '0'),
(670, 53, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(671, 53, 'view_tasks', '0'),
(672, 53, 'create_tasks', '0'),
(673, 53, 'edit_tasks', '0'),
(674, 53, 'comment_on_tasks', '0'),
(675, 53, 'view_task_comments', '0'),
(676, 53, 'view_task_attachments', '0'),
(677, 53, 'view_task_checklist_items', '0'),
(678, 53, 'upload_on_tasks', '0'),
(679, 53, 'view_task_total_logged_time', '0'),
(680, 53, 'view_finance_overview', '0'),
(681, 53, 'upload_files', '0'),
(682, 53, 'open_discussions', '0'),
(683, 53, 'view_milestones', '0'),
(684, 53, 'view_gantt', '0'),
(685, 53, 'view_timesheets', '0'),
(686, 53, 'view_activity_log', '0'),
(687, 53, 'view_team_members', '0'),
(688, 53, 'hide_tasks_on_main_tasks_table', '0'),
(689, 54, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(690, 54, 'view_tasks', '0'),
(691, 54, 'create_tasks', '0'),
(692, 54, 'edit_tasks', '0'),
(693, 54, 'comment_on_tasks', '0'),
(694, 54, 'view_task_comments', '0'),
(695, 54, 'view_task_attachments', '0'),
(696, 54, 'view_task_checklist_items', '0'),
(697, 54, 'upload_on_tasks', '0'),
(698, 54, 'view_task_total_logged_time', '0'),
(699, 54, 'view_finance_overview', '0'),
(700, 54, 'upload_files', '0'),
(701, 54, 'open_discussions', '0'),
(702, 54, 'view_milestones', '0'),
(703, 54, 'view_gantt', '0'),
(704, 54, 'view_timesheets', '0'),
(705, 54, 'view_activity_log', '0'),
(706, 54, 'view_team_members', '0'),
(707, 54, 'hide_tasks_on_main_tasks_table', '0'),
(708, 55, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(709, 55, 'view_tasks', '0'),
(710, 55, 'create_tasks', '0'),
(711, 55, 'edit_tasks', '0'),
(712, 55, 'comment_on_tasks', '0'),
(713, 55, 'view_task_comments', '0'),
(714, 55, 'view_task_attachments', '0'),
(715, 55, 'view_task_checklist_items', '0'),
(716, 55, 'upload_on_tasks', '0'),
(717, 55, 'view_task_total_logged_time', '0'),
(718, 55, 'view_finance_overview', '0'),
(719, 55, 'upload_files', '0'),
(720, 55, 'open_discussions', '0'),
(721, 55, 'view_milestones', '0'),
(722, 55, 'view_gantt', '0'),
(723, 55, 'view_timesheets', '0'),
(724, 55, 'view_activity_log', '0'),
(725, 55, 'view_team_members', '0'),
(726, 55, 'hide_tasks_on_main_tasks_table', '0'),
(727, 56, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(728, 56, 'view_tasks', '0'),
(729, 56, 'create_tasks', '0'),
(730, 56, 'edit_tasks', '0'),
(731, 56, 'comment_on_tasks', '0'),
(732, 56, 'view_task_comments', '0'),
(733, 56, 'view_task_attachments', '0'),
(734, 56, 'view_task_checklist_items', '0'),
(735, 56, 'upload_on_tasks', '0'),
(736, 56, 'view_task_total_logged_time', '0'),
(737, 56, 'view_finance_overview', '0'),
(738, 56, 'upload_files', '0'),
(739, 56, 'open_discussions', '0'),
(740, 56, 'view_milestones', '0'),
(741, 56, 'view_gantt', '0'),
(742, 56, 'view_timesheets', '0'),
(743, 56, 'view_activity_log', '0'),
(744, 56, 'view_team_members', '0'),
(745, 56, 'hide_tasks_on_main_tasks_table', '0'),
(746, 57, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(747, 57, 'view_tasks', '0'),
(748, 57, 'create_tasks', '0'),
(749, 57, 'edit_tasks', '0'),
(750, 57, 'comment_on_tasks', '0'),
(751, 57, 'view_task_comments', '0'),
(752, 57, 'view_task_attachments', '0'),
(753, 57, 'view_task_checklist_items', '0'),
(754, 57, 'upload_on_tasks', '0'),
(755, 57, 'view_task_total_logged_time', '0'),
(756, 57, 'view_finance_overview', '0'),
(757, 57, 'upload_files', '0'),
(758, 57, 'open_discussions', '0'),
(759, 57, 'view_milestones', '0'),
(760, 57, 'view_gantt', '0'),
(761, 57, 'view_timesheets', '0'),
(762, 57, 'view_activity_log', '0'),
(763, 57, 'view_team_members', '0'),
(764, 57, 'hide_tasks_on_main_tasks_table', '0'),
(765, 58, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(766, 58, 'view_tasks', '0'),
(767, 58, 'create_tasks', '0'),
(768, 58, 'edit_tasks', '0'),
(769, 58, 'comment_on_tasks', '0'),
(770, 58, 'view_task_comments', '0'),
(771, 58, 'view_task_attachments', '0'),
(772, 58, 'view_task_checklist_items', '0'),
(773, 58, 'upload_on_tasks', '0'),
(774, 58, 'view_task_total_logged_time', '0'),
(775, 58, 'view_finance_overview', '0'),
(776, 58, 'upload_files', '0'),
(777, 58, 'open_discussions', '0'),
(778, 58, 'view_milestones', '0'),
(779, 58, 'view_gantt', '0'),
(780, 58, 'view_timesheets', '0'),
(781, 58, 'view_activity_log', '0'),
(782, 58, 'view_team_members', '0'),
(783, 58, 'hide_tasks_on_main_tasks_table', '0'),
(784, 59, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(785, 59, 'view_tasks', '0'),
(786, 59, 'create_tasks', '0'),
(787, 59, 'edit_tasks', '0'),
(788, 59, 'comment_on_tasks', '0'),
(789, 59, 'view_task_comments', '0'),
(790, 59, 'view_task_attachments', '0'),
(791, 59, 'view_task_checklist_items', '0'),
(792, 59, 'upload_on_tasks', '0'),
(793, 59, 'view_task_total_logged_time', '0'),
(794, 59, 'view_finance_overview', '0'),
(795, 59, 'upload_files', '0'),
(796, 59, 'open_discussions', '0'),
(797, 59, 'view_milestones', '0'),
(798, 59, 'view_gantt', '0'),
(799, 59, 'view_timesheets', '0'),
(800, 59, 'view_activity_log', '0'),
(801, 59, 'view_team_members', '0'),
(802, 59, 'hide_tasks_on_main_tasks_table', '0'),
(803, 60, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(804, 60, 'view_tasks', '0'),
(805, 60, 'create_tasks', '0'),
(806, 60, 'edit_tasks', '0'),
(807, 60, 'comment_on_tasks', '0'),
(808, 60, 'view_task_comments', '0'),
(809, 60, 'view_task_attachments', '0'),
(810, 60, 'view_task_checklist_items', '0'),
(811, 60, 'upload_on_tasks', '0'),
(812, 60, 'view_task_total_logged_time', '0'),
(813, 60, 'view_finance_overview', '0'),
(814, 60, 'upload_files', '0'),
(815, 60, 'open_discussions', '0'),
(816, 60, 'view_milestones', '0'),
(817, 60, 'view_gantt', '0'),
(818, 60, 'view_timesheets', '0'),
(819, 60, 'view_activity_log', '0'),
(820, 60, 'view_team_members', '0'),
(821, 60, 'hide_tasks_on_main_tasks_table', '0'),
(822, 61, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(823, 61, 'view_tasks', '0'),
(824, 61, 'create_tasks', '0'),
(825, 61, 'edit_tasks', '0'),
(826, 61, 'comment_on_tasks', '0'),
(827, 61, 'view_task_comments', '0'),
(828, 61, 'view_task_attachments', '0'),
(829, 61, 'view_task_checklist_items', '0'),
(830, 61, 'upload_on_tasks', '0'),
(831, 61, 'view_task_total_logged_time', '0'),
(832, 61, 'view_finance_overview', '0'),
(833, 61, 'upload_files', '0'),
(834, 61, 'open_discussions', '0'),
(835, 61, 'view_milestones', '0'),
(836, 61, 'view_gantt', '0'),
(837, 61, 'view_timesheets', '0'),
(838, 61, 'view_activity_log', '0'),
(839, 61, 'view_team_members', '0'),
(840, 61, 'hide_tasks_on_main_tasks_table', '0'),
(841, 62, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(842, 62, 'view_tasks', '0'),
(843, 62, 'create_tasks', '0'),
(844, 62, 'edit_tasks', '0'),
(845, 62, 'comment_on_tasks', '0'),
(846, 62, 'view_task_comments', '0'),
(847, 62, 'view_task_attachments', '0'),
(848, 62, 'view_task_checklist_items', '0'),
(849, 62, 'upload_on_tasks', '0'),
(850, 62, 'view_task_total_logged_time', '0'),
(851, 62, 'view_finance_overview', '0'),
(852, 62, 'upload_files', '0'),
(853, 62, 'open_discussions', '0'),
(854, 62, 'view_milestones', '0'),
(855, 62, 'view_gantt', '0'),
(856, 62, 'view_timesheets', '0'),
(857, 62, 'view_activity_log', '0'),
(858, 62, 'view_team_members', '0'),
(859, 62, 'hide_tasks_on_main_tasks_table', '0'),
(860, 63, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(861, 63, 'view_tasks', '0'),
(862, 63, 'create_tasks', '0'),
(863, 63, 'edit_tasks', '0'),
(864, 63, 'comment_on_tasks', '0'),
(865, 63, 'view_task_comments', '0'),
(866, 63, 'view_task_attachments', '0'),
(867, 63, 'view_task_checklist_items', '0'),
(868, 63, 'upload_on_tasks', '0'),
(869, 63, 'view_task_total_logged_time', '0'),
(870, 63, 'view_finance_overview', '0'),
(871, 63, 'upload_files', '0'),
(872, 63, 'open_discussions', '0'),
(873, 63, 'view_milestones', '0'),
(874, 63, 'view_gantt', '0'),
(875, 63, 'view_timesheets', '0'),
(876, 63, 'view_activity_log', '0'),
(877, 63, 'view_team_members', '0'),
(878, 63, 'hide_tasks_on_main_tasks_table', '0'),
(879, 64, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(880, 64, 'view_tasks', '0'),
(881, 64, 'create_tasks', '0'),
(882, 64, 'edit_tasks', '0'),
(883, 64, 'comment_on_tasks', '0'),
(884, 64, 'view_task_comments', '0'),
(885, 64, 'view_task_attachments', '0'),
(886, 64, 'view_task_checklist_items', '0'),
(887, 64, 'upload_on_tasks', '0'),
(888, 64, 'view_task_total_logged_time', '0'),
(889, 64, 'view_finance_overview', '0'),
(890, 64, 'upload_files', '0'),
(891, 64, 'open_discussions', '0'),
(892, 64, 'view_milestones', '0'),
(893, 64, 'view_gantt', '0'),
(894, 64, 'view_timesheets', '0'),
(895, 64, 'view_activity_log', '0'),
(896, 64, 'view_team_members', '0'),
(897, 64, 'hide_tasks_on_main_tasks_table', '0'),
(898, 65, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_gantt\";i:1;s:13:\"project_tasks\";i:1;s:17:\"project_estimates\";i:1;s:21:\"project_subscriptions\";i:1;s:16:\"project_invoices\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:15:\"project_tickets\";i:1;s:18:\"project_timesheets\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(899, 65, 'view_tasks', '0'),
(900, 65, 'create_tasks', '0'),
(901, 65, 'edit_tasks', '0'),
(902, 65, 'comment_on_tasks', '0'),
(903, 65, 'view_task_comments', '0'),
(904, 65, 'view_task_attachments', '0'),
(905, 65, 'view_task_checklist_items', '0'),
(906, 65, 'upload_on_tasks', '0'),
(907, 65, 'view_task_total_logged_time', '0'),
(908, 65, 'view_finance_overview', '0'),
(909, 65, 'upload_files', '0'),
(910, 65, 'open_discussions', '0'),
(911, 65, 'view_milestones', '0'),
(912, 65, 'view_gantt', '0'),
(913, 65, 'view_timesheets', '0'),
(914, 65, 'view_activity_log', '0'),
(915, 65, 'view_team_members', '0'),
(916, 65, 'hide_tasks_on_main_tasks_table', '0'),
(917, 66, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:16:\"project_invoices\";i:1;s:11:\"procuration\";i:0;s:13:\"project_tasks\";i:0;s:18:\"project_timesheets\";i:0;s:18:\"project_milestones\";i:0;s:13:\"project_files\";i:0;s:19:\"project_discussions\";i:0;s:13:\"project_gantt\";i:0;s:15:\"project_tickets\";i:0;s:17:\"project_estimates\";i:0;s:16:\"project_expenses\";i:0;s:20:\"project_credit_notes\";i:0;s:13:\"project_notes\";i:0;s:16:\"project_activity\";i:0;s:12:\"CaseMovement\";i:0;s:11:\"CaseSession\";i:0;s:5:\"Phase\";i:0;s:4:\"IRAC\";i:0;s:10:\"Procedures\";i:0;s:12:\"help_library\";i:0;}'),
(918, 66, 'view_tasks', '0'),
(919, 66, 'create_tasks', '0'),
(920, 66, 'edit_tasks', '0'),
(921, 66, 'comment_on_tasks', '0'),
(922, 66, 'view_task_comments', '0'),
(923, 66, 'view_task_attachments', '0'),
(924, 66, 'view_task_checklist_items', '0'),
(925, 66, 'upload_on_tasks', '0'),
(926, 66, 'view_task_total_logged_time', '0'),
(927, 66, 'view_finance_overview', '0'),
(928, 66, 'upload_files', '0'),
(929, 66, 'open_discussions', '0'),
(930, 66, 'view_milestones', '0'),
(931, 66, 'view_gantt', '0'),
(932, 66, 'view_timesheets', '0'),
(933, 66, 'view_activity_log', '0'),
(934, 66, 'view_team_members', '0'),
(935, 66, 'hide_tasks_on_main_tasks_table', '0'),
(936, 67, 'available_features', 'a:17:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;s:12:\"help_library\";i:0;}'),
(937, 67, 'view_tasks', '0'),
(938, 67, 'create_tasks', '0'),
(939, 67, 'edit_tasks', '0'),
(940, 67, 'comment_on_tasks', '0'),
(941, 67, 'view_task_comments', '0'),
(942, 67, 'view_task_attachments', '0'),
(943, 67, 'view_task_checklist_items', '0'),
(944, 67, 'upload_on_tasks', '0'),
(945, 67, 'view_task_total_logged_time', '0'),
(946, 67, 'view_finance_overview', '0'),
(947, 67, 'upload_files', '0'),
(948, 67, 'open_discussions', '0'),
(949, 67, 'view_milestones', '0'),
(950, 67, 'view_gantt', '0'),
(951, 67, 'view_timesheets', '0'),
(952, 67, 'view_activity_log', '0'),
(953, 67, 'view_team_members', '0'),
(954, 67, 'hide_tasks_on_main_tasks_table', '0'),
(955, 68, 'available_features', 'a:17:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:13:\"project_files\";i:1;s:18:\"project_milestones\";i:0;s:19:\"project_discussions\";i:0;s:13:\"project_gantt\";i:0;s:15:\"project_tickets\";i:0;s:16:\"project_invoices\";i:0;s:17:\"project_estimates\";i:0;s:16:\"project_expenses\";i:0;s:20:\"project_credit_notes\";i:0;s:13:\"project_notes\";i:0;s:16:\"project_activity\";i:0;s:5:\"Phase\";i:0;s:10:\"Procedures\";i:0;s:12:\"help_library\";i:0;}'),
(956, 68, 'view_tasks', '0'),
(957, 68, 'create_tasks', '0'),
(958, 68, 'edit_tasks', '0'),
(959, 68, 'comment_on_tasks', '0'),
(960, 68, 'view_task_comments', '0'),
(961, 68, 'view_task_attachments', '0'),
(962, 68, 'view_task_checklist_items', '0'),
(963, 68, 'upload_on_tasks', '0'),
(964, 68, 'view_task_total_logged_time', '0'),
(965, 68, 'view_finance_overview', '0'),
(966, 68, 'upload_files', '0'),
(967, 68, 'open_discussions', '0'),
(968, 68, 'view_milestones', '0'),
(969, 68, 'view_gantt', '0'),
(970, 68, 'view_timesheets', '0'),
(971, 68, 'view_activity_log', '0'),
(972, 68, 'view_team_members', '0'),
(973, 68, 'hide_tasks_on_main_tasks_table', '0'),
(974, 69, 'available_features', 'a:17:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:13:\"project_files\";i:1;s:18:\"project_milestones\";i:0;s:19:\"project_discussions\";i:0;s:13:\"project_gantt\";i:0;s:15:\"project_tickets\";i:0;s:16:\"project_invoices\";i:0;s:17:\"project_estimates\";i:0;s:16:\"project_expenses\";i:0;s:20:\"project_credit_notes\";i:0;s:13:\"project_notes\";i:0;s:16:\"project_activity\";i:0;s:5:\"Phase\";i:0;s:10:\"Procedures\";i:0;s:12:\"help_library\";i:0;}'),
(975, 69, 'view_tasks', '0'),
(976, 69, 'create_tasks', '0'),
(977, 69, 'edit_tasks', '0'),
(978, 69, 'comment_on_tasks', '0'),
(979, 69, 'view_task_comments', '0'),
(980, 69, 'view_task_attachments', '0'),
(981, 69, 'view_task_checklist_items', '0'),
(982, 69, 'upload_on_tasks', '0'),
(983, 69, 'view_task_total_logged_time', '0'),
(984, 69, 'view_finance_overview', '0'),
(985, 69, 'upload_files', '0'),
(986, 69, 'open_discussions', '0'),
(987, 69, 'view_milestones', '0'),
(988, 69, 'view_gantt', '0'),
(989, 69, 'view_timesheets', '0'),
(990, 69, 'view_activity_log', '0'),
(991, 69, 'view_team_members', '0'),
(992, 69, 'hide_tasks_on_main_tasks_table', '0'),
(993, 70, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_gantt\";i:1;s:13:\"project_tasks\";i:1;s:17:\"project_estimates\";i:1;s:21:\"project_subscriptions\";i:1;s:16:\"project_invoices\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:15:\"project_tickets\";i:1;s:18:\"project_timesheets\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(994, 70, 'view_tasks', '0'),
(995, 70, 'create_tasks', '0'),
(996, 70, 'edit_tasks', '0'),
(997, 70, 'comment_on_tasks', '0'),
(998, 70, 'view_task_comments', '0'),
(999, 70, 'view_task_attachments', '0'),
(1000, 70, 'view_task_checklist_items', '0'),
(1001, 70, 'upload_on_tasks', '0'),
(1002, 70, 'view_task_total_logged_time', '0'),
(1003, 70, 'view_finance_overview', '0'),
(1004, 70, 'upload_files', '0'),
(1005, 70, 'open_discussions', '0'),
(1006, 70, 'view_milestones', '0'),
(1007, 70, 'view_gantt', '0'),
(1008, 70, 'view_timesheets', '0'),
(1009, 70, 'view_activity_log', '0'),
(1010, 70, 'view_team_members', '0'),
(1011, 70, 'hide_tasks_on_main_tasks_table', '0'),
(1012, 71, 'available_features', 'a:15:{s:16:\"project_overview\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_gantt\";i:1;s:13:\"project_tasks\";i:1;s:17:\"project_estimates\";i:1;s:21:\"project_subscriptions\";i:1;s:16:\"project_invoices\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:15:\"project_tickets\";i:1;s:18:\"project_timesheets\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;}'),
(1013, 71, 'view_tasks', '0'),
(1014, 71, 'create_tasks', '0'),
(1015, 71, 'edit_tasks', '0'),
(1016, 71, 'comment_on_tasks', '0'),
(1017, 71, 'view_task_comments', '0'),
(1018, 71, 'view_task_attachments', '0'),
(1019, 71, 'view_task_checklist_items', '0'),
(1020, 71, 'upload_on_tasks', '0'),
(1021, 71, 'view_task_total_logged_time', '0'),
(1022, 71, 'view_finance_overview', '0'),
(1023, 71, 'upload_files', '0'),
(1024, 71, 'open_discussions', '0'),
(1025, 71, 'view_milestones', '0'),
(1026, 71, 'view_gantt', '0'),
(1027, 71, 'view_timesheets', '0'),
(1028, 71, 'view_activity_log', '0'),
(1029, 71, 'view_team_members', '0'),
(1030, 71, 'hide_tasks_on_main_tasks_table', '0'),
(1031, 72, 'available_features', 'a:17:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;s:12:\"help_library\";i:0;}'),
(1032, 72, 'view_tasks', '0'),
(1033, 72, 'create_tasks', '0'),
(1034, 72, 'edit_tasks', '0'),
(1035, 72, 'comment_on_tasks', '0'),
(1036, 72, 'view_task_comments', '0'),
(1037, 72, 'view_task_attachments', '0'),
(1038, 72, 'view_task_checklist_items', '0'),
(1039, 72, 'upload_on_tasks', '0'),
(1040, 72, 'view_task_total_logged_time', '0'),
(1041, 72, 'view_finance_overview', '0'),
(1042, 72, 'upload_files', '0'),
(1043, 72, 'open_discussions', '0'),
(1044, 72, 'view_milestones', '0'),
(1045, 72, 'view_gantt', '0'),
(1046, 72, 'view_timesheets', '0'),
(1047, 72, 'view_activity_log', '0'),
(1048, 72, 'view_team_members', '0'),
(1049, 72, 'hide_tasks_on_main_tasks_table', '0'),
(1050, 73, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:16:\"project_invoices\";i:1;s:11:\"procuration\";i:0;s:13:\"project_tasks\";i:0;s:18:\"project_timesheets\";i:0;s:18:\"project_milestones\";i:0;s:13:\"project_files\";i:0;s:19:\"project_discussions\";i:0;s:13:\"project_gantt\";i:0;s:15:\"project_tickets\";i:0;s:17:\"project_estimates\";i:0;s:16:\"project_expenses\";i:0;s:20:\"project_credit_notes\";i:0;s:13:\"project_notes\";i:0;s:16:\"project_activity\";i:0;s:12:\"CaseMovement\";i:0;s:11:\"CaseSession\";i:0;s:5:\"Phase\";i:0;s:4:\"IRAC\";i:0;s:10:\"Procedures\";i:0;s:12:\"help_library\";i:0;}'),
(1051, 73, 'view_tasks', '0'),
(1052, 73, 'create_tasks', '0'),
(1053, 73, 'edit_tasks', '0'),
(1054, 73, 'comment_on_tasks', '0'),
(1055, 73, 'view_task_comments', '0'),
(1056, 73, 'view_task_attachments', '0'),
(1057, 73, 'view_task_checklist_items', '0'),
(1058, 73, 'upload_on_tasks', '0'),
(1059, 73, 'view_task_total_logged_time', '0'),
(1060, 73, 'view_finance_overview', '0'),
(1061, 73, 'upload_files', '0'),
(1062, 73, 'open_discussions', '0'),
(1063, 73, 'view_milestones', '0'),
(1064, 73, 'view_gantt', '0'),
(1065, 73, 'view_timesheets', '0'),
(1066, 73, 'view_activity_log', '0'),
(1067, 73, 'view_team_members', '0'),
(1068, 73, 'hide_tasks_on_main_tasks_table', '0'),
(1069, 74, 'available_features', 'a:16:{s:16:\"project_overview\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:21:\"project_subscriptions\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:5:\"Phase\";i:1;}'),
(1070, 74, 'view_tasks', '0'),
(1071, 74, 'create_tasks', '0'),
(1072, 74, 'edit_tasks', '0'),
(1073, 74, 'comment_on_tasks', '0'),
(1074, 74, 'view_task_comments', '0'),
(1075, 74, 'view_task_attachments', '0'),
(1076, 74, 'view_task_checklist_items', '0'),
(1077, 74, 'upload_on_tasks', '0'),
(1078, 74, 'view_task_total_logged_time', '0'),
(1079, 74, 'view_finance_overview', '0'),
(1080, 74, 'upload_files', '0'),
(1081, 74, 'open_discussions', '0'),
(1082, 74, 'view_milestones', '0'),
(1083, 74, 'view_gantt', '0'),
(1084, 74, 'view_timesheets', '0'),
(1085, 74, 'view_activity_log', '0'),
(1086, 74, 'view_team_members', '0'),
(1087, 74, 'hide_tasks_on_main_tasks_table', '0'),
(1088, 2, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(1089, 2, 'view_tasks', '0'),
(1090, 2, 'create_tasks', '0'),
(1091, 2, 'edit_tasks', '0'),
(1092, 2, 'comment_on_tasks', '0'),
(1093, 2, 'view_task_comments', '0'),
(1094, 2, 'view_task_attachments', '0'),
(1095, 2, 'view_task_checklist_items', '0'),
(1096, 2, 'upload_on_tasks', '0'),
(1097, 2, 'view_task_total_logged_time', '0'),
(1098, 2, 'view_finance_overview', '0'),
(1099, 2, 'upload_files', '0'),
(1100, 2, 'open_discussions', '0'),
(1101, 2, 'view_milestones', '0'),
(1102, 2, 'view_gantt', '0'),
(1103, 2, 'view_timesheets', '0'),
(1104, 2, 'view_activity_log', '0'),
(1105, 2, 'view_team_members', '0'),
(1106, 2, 'hide_tasks_on_main_tasks_table', '0'),
(1107, 3, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(1108, 3, 'view_tasks', '0'),
(1109, 3, 'create_tasks', '0'),
(1110, 3, 'edit_tasks', '0'),
(1111, 3, 'comment_on_tasks', '0'),
(1112, 3, 'view_task_comments', '0'),
(1113, 3, 'view_task_attachments', '0'),
(1114, 3, 'view_task_checklist_items', '0'),
(1115, 3, 'upload_on_tasks', '0'),
(1116, 3, 'view_task_total_logged_time', '0'),
(1117, 3, 'view_finance_overview', '0'),
(1118, 3, 'upload_files', '0'),
(1119, 3, 'open_discussions', '0'),
(1120, 3, 'view_milestones', '0'),
(1121, 3, 'view_gantt', '0'),
(1122, 3, 'view_timesheets', '0'),
(1123, 3, 'view_activity_log', '0'),
(1124, 3, 'view_team_members', '0'),
(1125, 3, 'hide_tasks_on_main_tasks_table', '0'),
(1126, 4, 'available_features', 'a:21:{s:16:\"project_overview\";i:1;s:11:\"procuration\";i:1;s:13:\"project_tasks\";i:1;s:18:\"project_timesheets\";i:1;s:18:\"project_milestones\";i:1;s:13:\"project_files\";i:1;s:19:\"project_discussions\";i:1;s:13:\"project_gantt\";i:1;s:15:\"project_tickets\";i:1;s:16:\"project_invoices\";i:1;s:17:\"project_estimates\";i:1;s:16:\"project_expenses\";i:1;s:20:\"project_credit_notes\";i:1;s:13:\"project_notes\";i:1;s:16:\"project_activity\";i:1;s:12:\"CaseMovement\";i:1;s:11:\"CaseSession\";i:1;s:5:\"Phase\";i:1;s:4:\"IRAC\";i:1;s:10:\"Procedures\";i:1;s:12:\"help_library\";i:1;}'),
(1127, 4, 'view_tasks', '0'),
(1128, 4, 'create_tasks', '0'),
(1129, 4, 'edit_tasks', '0'),
(1130, 4, 'comment_on_tasks', '0'),
(1131, 4, 'view_task_comments', '0'),
(1132, 4, 'view_task_attachments', '0'),
(1133, 4, 'view_task_checklist_items', '0'),
(1134, 4, 'upload_on_tasks', '0'),
(1135, 4, 'view_task_total_logged_time', '0'),
(1136, 4, 'view_finance_overview', '0'),
(1137, 4, 'upload_files', '0'),
(1138, 4, 'open_discussions', '0'),
(1139, 4, 'view_milestones', '0'),
(1140, 4, 'view_gantt', '0'),
(1141, 4, 'view_timesheets', '0'),
(1142, 4, 'view_activity_log', '0'),
(1143, 4, 'view_team_members', '0'),
(1144, 4, 'hide_tasks_on_main_tasks_table', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tblitemable`
--

CREATE TABLE `tblitemable` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(15) NOT NULL,
  `description` mediumtext NOT NULL,
  `long_description` mediumtext,
  `qty` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `unit` varchar(40) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

CREATE TABLE `tblitems` (
  `id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `long_description` text,
  `rate` decimal(15,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax2` int(11) DEFAULT NULL,
  `unit` varchar(40) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblitems_groups`
--

CREATE TABLE `tblitems_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblitem_tax`
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
-- Table structure for table `tblknowedge_base_article_feedback`
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
-- Table structure for table `tblknowledge_base`
--

CREATE TABLE `tblknowledge_base` (
  `articleid` int(11) NOT NULL,
  `articlegroup` int(11) NOT NULL,
  `subject` mediumtext NOT NULL,
  `description` text NOT NULL,
  `slug` mediumtext NOT NULL,
  `active` tinyint(4) NOT NULL,
  `datecreated` datetime NOT NULL,
  `article_order` int(11) NOT NULL DEFAULT '0',
  `staff_article` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblknowledge_base`
--

INSERT INTO `tblknowledge_base` (`articleid`, `articlegroup`, `subject`, `description`, `slug`, `active`, `datecreated`, `article_order`, `staff_article`) VALUES
(1, 1, 'القضايا', 'نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص', 'lkd-y', 1, '2020-01-16 18:55:52', 0, 0),
(2, 2, 'الاجازات', 'نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نصنص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص نص', 'l-g-z-t', 1, '2020-01-16 18:57:30', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblknowledge_base_groups`
--

CREATE TABLE `tblknowledge_base_groups` (
  `groupid` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `group_slug` text,
  `description` mediumtext,
  `active` tinyint(4) NOT NULL,
  `color` varchar(10) DEFAULT '#28B8DA',
  `group_order` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblknowledge_base_groups`
--

INSERT INTO `tblknowledge_base_groups` (`groupid`, `name`, `group_slug`, `description`, `active`, `color`, `group_order`) VALUES
(1, 'الخدمات القانونية', 'lkhdm-t-lk-nony', '', 1, '', 1),
(2, 'شؤون الموظفين', 'sh-on-lmothfyn', '', 1, '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblleads`
--

CREATE TABLE `tblleads` (
  `id` int(11) NOT NULL,
  `hash` varchar(65) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `company` varchar(191) DEFAULT NULL,
  `description` text,
  `country` int(11) NOT NULL DEFAULT '0',
  `zip` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `assigned` int(11) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL,
  `from_form_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `lastcontact` datetime DEFAULT NULL,
  `dateassigned` date DEFAULT NULL,
  `last_status_change` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `leadorder` int(11) DEFAULT '1',
  `phonenumber` varchar(50) DEFAULT NULL,
  `date_converted` datetime DEFAULT NULL,
  `lost` tinyint(1) NOT NULL DEFAULT '0',
  `junk` int(11) NOT NULL DEFAULT '0',
  `last_lead_status` int(11) NOT NULL DEFAULT '0',
  `is_imported_from_email_integration` tinyint(1) NOT NULL DEFAULT '0',
  `email_integration_uid` varchar(30) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `default_language` varchar(40) DEFAULT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblleads_email_integration`
--

CREATE TABLE `tblleads_email_integration` (
  `id` int(11) NOT NULL COMMENT 'the ID always must be 1',
  `active` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `imap_server` varchar(100) NOT NULL,
  `password` mediumtext NOT NULL,
  `check_every` int(11) NOT NULL DEFAULT '5',
  `responsible` int(11) NOT NULL,
  `lead_source` int(11) NOT NULL,
  `lead_status` int(11) NOT NULL,
  `encryption` varchar(3) DEFAULT NULL,
  `folder` varchar(100) NOT NULL,
  `last_run` varchar(50) DEFAULT NULL,
  `notify_lead_imported` tinyint(1) NOT NULL DEFAULT '1',
  `notify_lead_contact_more_times` tinyint(1) NOT NULL DEFAULT '1',
  `notify_type` varchar(20) DEFAULT NULL,
  `notify_ids` mediumtext,
  `mark_public` int(11) NOT NULL DEFAULT '0',
  `only_loop_on_unseen_emails` tinyint(1) NOT NULL DEFAULT '1',
  `delete_after_import` int(11) NOT NULL DEFAULT '0',
  `create_task_if_customer` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblleads_sources`
--

CREATE TABLE `tblleads_sources` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblleads_sources`
--

INSERT INTO `tblleads_sources` (`id`, `name`) VALUES
(2, 'Facebook'),
(1, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `tblleads_status`
--

CREATE TABLE `tblleads_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `statusorder` int(11) DEFAULT NULL,
  `color` varchar(10) DEFAULT '#28B8DA',
  `isdefault` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblleads_status`
--

INSERT INTO `tblleads_status` (`id`, `name`, `statusorder`, `color`, `isdefault`) VALUES
(1, 'Customer', 1000, '#7cb342', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbllead_activity_log`
--

CREATE TABLE `tbllead_activity_log` (
  `id` int(11) NOT NULL,
  `leadid` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `additional_data` text,
  `date` datetime NOT NULL,
  `staffid` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `custom_activity` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbllead_integration_emails`
--

CREATE TABLE `tbllead_integration_emails` (
  `id` int(11) NOT NULL,
  `subject` mediumtext,
  `body` mediumtext,
  `dateadded` datetime NOT NULL,
  `leadid` int(11) NOT NULL,
  `emailid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbllegal_procedures`
--

CREATE TABLE `tbllegal_procedures` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbllegal_procedures_lists`
--

CREATE TABLE `tbllegal_procedures_lists` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbllistemails`
--

CREATE TABLE `tbllistemails` (
  `emailid` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmaillistscustomfields`
--

CREATE TABLE `tblmaillistscustomfields` (
  `customfieldid` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  `fieldname` varchar(150) NOT NULL,
  `fieldslug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmaillistscustomfieldvalues`
--

CREATE TABLE `tblmaillistscustomfieldvalues` (
  `customfieldvalueid` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  `customfieldid` int(11) NOT NULL,
  `emailid` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmail_attachment`
--

CREATE TABLE `tblmail_attachment` (
  `id` int(11) UNSIGNED NOT NULL,
  `mail_id` int(11) NOT NULL,
  `file_name` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(45) NOT NULL DEFAULT 'inbox'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmail_inbox`
--

CREATE TABLE `tblmail_inbox` (
  `id` int(11) UNSIGNED NOT NULL,
  `from_staff_id` int(11) NOT NULL DEFAULT '0',
  `to_staff_id` int(11) NOT NULL DEFAULT '0',
  `to` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bcc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `body` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `has_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `date_received` datetime NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `folder` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inbox',
  `stared` tinyint(1) NOT NULL DEFAULT '0',
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `from_email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmail_outbox`
--

CREATE TABLE `tblmail_outbox` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender_staff_id` int(11) NOT NULL DEFAULT '0',
  `to` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bcc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `body` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `has_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `date_sent` datetime NOT NULL,
  `stared` tinyint(1) NOT NULL DEFAULT '0',
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `reply_from_id` int(11) DEFAULT NULL,
  `reply_type` varchar(45) NOT NULL DEFAULT 'inbox',
  `draft` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmail_queue`
--

CREATE TABLE `tblmail_queue` (
  `id` int(11) NOT NULL,
  `engine` varchar(40) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `cc` text,
  `bcc` text,
  `message` mediumtext NOT NULL,
  `alt_message` mediumtext,
  `status` enum('pending','sending','sent','failed') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `headers` text,
  `attachments` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmigrations`
--

CREATE TABLE `tblmigrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmigrations`
--

INSERT INTO `tblmigrations` (`version`) VALUES
(244);

-- --------------------------------------------------------

--
-- Table structure for table `tblmilestones`
--

CREATE TABLE `tblmilestones` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text,
  `description_visible_to_customer` tinyint(1) DEFAULT '0',
  `due_date` date NOT NULL,
  `project_id` int(11) NOT NULL,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `milestone_order` int(11) NOT NULL DEFAULT '0',
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmodules`
--

CREATE TABLE `tblmodules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(55) NOT NULL,
  `installed_version` varchar(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmodules`
--

INSERT INTO `tblmodules` (`id`, `module_name`, `installed_version`, `active`) VALUES
(1, 'menu_setup', '2.3.0', 0),
(3, 'label_management', '1.0.0', 0),
(4, 'location_module', '2.3.0', 0),
(5, 'session', '2.3.0', 0),
(6, 'disputes', '1.0.0', 0),
(7, 'branches', '2.3.0', 0),
(8, 'hr', '1.0.0', 0),
(9, 'appointly', '1.1.5', 0),
(11, 'mailbox', '1.0.0', 0),
(12, 'theme_style', '2.3.0', 0),
(13, 'goals', '2.3.0', 0),
(14, 'surveys', '2.3.0', 0),
(15, 'backup', '2.3.0', 0),
(16, 'account_planning', '1.0.0', 0),
(17, 'perfex_email_builder', '2.0.1', 0),
(18, 'prchat', '1.4.3', 0),
(19, 'assets', '1.0.0', 0),
(20, 'zoom', '1.0.0', 0),
(21, 'api', '1.0.0', 1);

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
  `show_on_sidebar` tinyint(1) NOT NULL DEFAULT '1',
  `is_module` tinyint(1) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_basic_services`
--

INSERT INTO `tblmy_basic_services` (`id`, `name`, `slug`, `prefix`, `numbering`, `is_primary`, `show_on_sidebar`, `is_module`, `datecreated`) VALUES
(1, 'قضايا', 'kd-y', 'CASE', 1, 1, 1, 0, '2019-04-15 18:03:19'),
(2, 'عقود', 'aakod', 'Akd', 1, 1, 1, 0, '2019-05-01 19:43:08'),
(3, 'استشارات', 'stsh-r-t', 'Istsh', 1, 1, 1, 0, '2019-05-08 01:28:21'),
(9, 'نزاعات مالية', 'nz_aa_t_m_ly', 'Dispute', NULL, 1, 0, 1, '2020-01-23 21:03:43');

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
  `opponent_id` int(11) NOT NULL,
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
  `file_number_case` int(11) DEFAULT NULL,
  `file_number_court` int(11) DEFAULT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `previous_case_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_casestatus`
--

CREATE TABLE `tblmy_casestatus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_cases_judges`
--

CREATE TABLE `tblmy_cases_judges` (
  `id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_cases_movement_judges`
--

CREATE TABLE `tblmy_cases_movement_judges` (
  `id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `case_mov_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_courts`
--

CREATE TABLE `tblmy_courts` (
  `c_id` int(11) NOT NULL,
  `court_name` varchar(250) NOT NULL,
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_customers_company_groups`
--

CREATE TABLE `tblmy_customers_company_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_customer_company_groups`
--

CREATE TABLE `tblmy_customer_company_groups` (
  `id` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_customer_representative`
--

CREATE TABLE `tblmy_customer_representative` (
  `id` int(11) NOT NULL,
  `representative` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_dialog_boxes`
--

CREATE TABLE `tblmy_dialog_boxes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc_ar` text,
  `desc_en` text,
  `page_url` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_employee_basic`
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
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `contract` int(11) NOT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `imported` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmy_imported_services`
--

INSERT INTO `tblmy_imported_services` (`id`, `service_id`, `code`, `numbering`, `name`, `clientid`, `cat_id`, `subcat_id`, `service_session_link`, `billing_type`, `status`, `project_rate_per_hour`, `project_cost`, `start_date`, `project_created`, `deadline`, `date_finished`, `description`, `country`, `city`, `contract`, `estimated_hours`, `progress`, `progress_from_tasks`, `addedfrom`, `branch_id`, `deleted`, `imported`) VALUES
(1, 1, 'CASE1', 1, 'new case', 1, 2, 3, 1, 2, 1, 0, '0.00', '2020-09-28', '2020-09-28', NULL, NULL, '', 'مصر', '', 0, '0.00', 0, 1, 0, 0, 1, 0),
(2, 1, 'CASE1', 1, 'new case', 1, 2, 3, 1, 2, 1, 0, '0.00', '2020-09-28', '2020-09-28', NULL, NULL, '', 'مصر', '', 0, '0.00', 0, 1, 0, 0, 1, 0),
(3, 1, 'CASE1', 1, 'new case', 1, 2, 3, 1, 2, 1, 0, '0.00', '2020-09-28', '2020-09-28', NULL, NULL, '', 'مصر', '', 0, '0.00', 0, 1, 0, 0, 1, 0),
(4, 1, 'CASE1', 1, 'new case', 1, 2, 3, 1, 2, 1, 0, '0.00', '2020-09-28', '2020-09-28', NULL, NULL, '', 'مصر', '', 0, '0.00', 0, 1, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_judges`
--

CREATE TABLE `tblmy_judges` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_judicialdept`
--

CREATE TABLE `tblmy_judicialdept` (
  `j_id` int(255) NOT NULL,
  `Jud_number` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `datecreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_members_cases`
--

CREATE TABLE `tblmy_members_cases` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_members_movement_cases`
--

CREATE TABLE `tblmy_members_movement_cases` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `case_mov_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_members_services`
--

CREATE TABLE `tblmy_members_services` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_phase_data`
--

CREATE TABLE `tblmy_phase_data` (
  `id` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_complete` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_procurationstate`
--

CREATE TABLE `tblmy_procurationstate` (
  `id` int(11) NOT NULL,
  `procurationstate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_procurationtype`
--

CREATE TABLE `tblmy_procurationtype` (
  `id` int(11) NOT NULL,
  `procurationtype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_services_tags`
--

CREATE TABLE `tblmy_services_tags` (
  `id` int(11) NOT NULL,
  `rel_type` varchar(100) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `tag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_service_phases`
--

CREATE TABLE `tblmy_service_phases` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `slug` varchar(30) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_sessiondiscussioncomments`
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
  `contact_id` int(11) DEFAULT '0',
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_sessiondiscussions`
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
-- Table structure for table `tblmy_session_info`
--

CREATE TABLE `tblmy_session_info` (
  `s_id` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `tblmy_transactions`
--

CREATE TABLE `tblmy_transactions` (
  `id` int(11) NOT NULL,
  `definition` int(11) NOT NULL,
  `description` varchar(225) NOT NULL,
  `type` varchar(225) NOT NULL,
  `origin` varchar(225) NOT NULL,
  `incoming_num` int(11) DEFAULT NULL,
  `incoming_source` varchar(225) DEFAULT NULL,
  `incoming_type` varchar(225) DEFAULT NULL,
  `is_secret` tinyint(1) NOT NULL,
  `importance` varchar(225) NOT NULL,
  `classification` varchar(225) NOT NULL,
  `owner` varchar(225) NOT NULL,
  `owner_phone` int(25) NOT NULL,
  `source_reporter` varchar(225) DEFAULT NULL,
  `source_reporter_phone` int(25) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblnewsfeed_comment_likes`
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
-- Table structure for table `tblnewsfeed_posts`
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
-- Table structure for table `tblnewsfeed_post_comments`
--

CREATE TABLE `tblnewsfeed_post_comments` (
  `id` int(11) NOT NULL,
  `content` text,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblnewsfeed_post_likes`
--

CREATE TABLE `tblnewsfeed_post_likes` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `dateliked` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblnotes`
--

CREATE TABLE `tblnotes` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `description` text,
  `date_contacted` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblnotifications`
--

CREATE TABLE `tblnotifications` (
  `id` int(11) NOT NULL,
  `isread` int(11) NOT NULL DEFAULT '0',
  `isread_inline` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `fromuserid` int(11) NOT NULL,
  `fromclientid` int(11) NOT NULL DEFAULT '0',
  `from_fullname` varchar(100) NOT NULL,
  `touserid` int(11) NOT NULL,
  `fromcompany` int(11) DEFAULT NULL,
  `link` mediumtext,
  `additional_data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbloptions`
--

CREATE TABLE `tbloptions` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `value` longtext NOT NULL,
  `autoload` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbloptions`
--

INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES
(1, 'dateformat', 'Y-m-d|%Y-%m-%d', 1),
(2, 'companyname', 'local_office', 1),
(3, 'services', '1', 1),
(4, 'maximum_allowed_ticket_attachments', '4', 1),
(5, 'ticket_attachments_file_extensions', '.jpg,.png,.pdf,.doc,.zip,.rar', 1),
(6, 'staff_access_only_assigned_departments', '1', 1),
(7, 'use_knowledge_base', '1', 1),
(8, 'smtp_email', '', 1),
(9, 'smtp_password', '', 1),
(10, 'company_info_format', '{company_name}<br />\r\n{address}<br />\r\n{city}<br />\r\n{bo_box} {zip_code}<br />\r\n{vat_number_with_label}', 0),
(11, 'smtp_port', '465', 1),
(12, 'smtp_host', 'mail.tl4t.com', 1),
(13, 'smtp_email_charset', 'utf-8', 1),
(14, 'default_timezone', 'Asia/Riyadh', 1),
(15, 'clients_default_theme', 'perfex', 1),
(16, 'company_logo', '', 1),
(17, 'tables_pagination_limit', '25', 1),
(18, 'main_domain', 'https://www.googlefhg.com/', 1),
(19, 'allow_registration', '0', 1),
(20, 'knowledge_base_without_registration', '0', 1),
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
(34, 'view_invoice_only_logged_in', '1', 1),
(35, 'invoice_number_format', '1', 1),
(36, 'next_invoice_number', '6', 0),
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
(49, 'next_estimate_number', '3', 0),
(50, 'estimate_number_decrement_on_delete', '1', 1),
(51, 'estimate_number_format', '1', 1),
(52, 'estimate_auto_convert_to_invoice_on_client_accept', '1', 1),
(53, 'exclude_estimate_from_client_area_with_draft_status', '1', 1),
(54, 'rtl_support_admin', '1', 1),
(55, 'last_cron_run', '1590835501', 1),
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
(87, 'customer_default_country', '194', 1),
(88, 'view_estimate_only_logged_in', '0', 1),
(89, 'show_status_on_pdf_ei', '1', 1),
(90, 'email_piping_only_replies', '0', 1),
(91, 'email_piping_only_registered', '0', 1),
(92, 'default_view_calendar', 'month', 1),
(93, 'email_piping_default_priority', '2', 1),
(94, 'total_to_words_lowercase', '0', 1),
(95, 'show_tax_per_item', '1', 1),
(96, 'total_to_words_enabled', '1', 1),
(97, 'receive_notification_on_new_ticket', '1', 0),
(98, 'autoclose_tickets_after', '0', 1),
(99, 'media_max_file_size_upload', '10', 1),
(100, 'client_staff_add_edit_delete_task_comments_first_hour', '0', 1),
(101, 'show_projects_on_calendar', '1', 1),
(102, 'leads_kanban_limit', '50', 1),
(103, 'tasks_reminder_notification_before', '2', 1),
(104, 'pdf_font', 'aealarabiya', 1),
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
(117, 'smtp_encryption', 'ssl', 1),
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
(148, 'swap_pdf_info', '1', 1),
(149, 'exclude_invoice_from_client_area_with_draft_status', '1', 1),
(150, 'cron_has_run_from_cli', '1', 1),
(151, 'hide_cron_is_required_message', '1', 0),
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
(175, 'time_format', '12', 1),
(176, 'delete_activity_log_older_then', '1', 1),
(177, 'disable_language', '0', 1),
(178, 'company_state', 'الرياض', 1),
(179, 'email_header', '', 1),
(180, 'show_pdf_signature_invoice', '1', 0),
(181, 'show_pdf_signature_estimate', '1', 0),
(182, 'signature_image', '', 0),
(183, 'scroll_responsive_tables', '0', 1),
(184, 'email_footer', '', 1),
(185, 'exclude_proposal_from_client_area_with_draft_status', '1', 1),
(186, 'pusher_app_key', '', 1),
(187, 'pusher_app_secret', '', 1),
(188, 'pusher_app_id', '', 1),
(189, 'pusher_realtime_notifications', '1', 1),
(190, 'pdf_format_statement', 'A4-PORTRAIT', 1),
(191, 'pusher_cluster', 'eu', 1),
(192, 'show_table_export_button', 'to_all', 1),
(193, 'allow_staff_view_proposals_assigned', '1', 1),
(194, 'show_cloudflare_notice', '1', 0),
(195, 'task_modal_class', 'modal-xxl', 1),
(196, 'lead_modal_class', 'modal-lg', 1),
(197, 'show_timesheets_overview_all_members_notice_admins', '1', 0),
(198, 'desktop_notifications', '1', 1),
(199, 'hide_notified_reminders_from_calendar', '1', 0),
(200, 'customer_info_format', '{company_name}<br />\r\n{city} <br />\r\n{zip_code}', 0),
(201, 'timer_started_change_status_in_progress', '1', 0),
(202, 'default_ticket_reply_status', '3', 1),
(203, 'default_task_status', 'auto', 1),
(204, 'email_queue_skip_with_attachments', '1', 1),
(205, 'email_queue_enabled', '0', 1),
(206, 'last_email_queue_retry', '1590835502', 1),
(207, 'auto_dismiss_desktop_notifications_after', '0', 1),
(208, 'proposal_info_format', '{proposal_to}<br />\r\n{address}<br />\r\n{city} {state}<br />\r\n{country_code} {zip_code}<br />\r\n{phone}<br />\r\n{email}', 0),
(209, 'ticket_replies_order', 'asc', 1),
(210, 'new_recurring_invoice_action', 'generate_and_send', 0),
(211, 'bcc_emails', '', 0);
INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES
(212, 'email_templates_language_checks', 'a:2044:{s:25:\"new-client-created-arabic\";i:1;s:29:\"invoice-send-to-client-arabic\";i:1;s:30:\"new-ticket-opened-admin-arabic\";i:1;s:19:\"ticket-reply-arabic\";i:1;s:26:\"ticket-autoresponse-arabic\";i:1;s:31:\"invoice-payment-recorded-arabic\";i:1;s:29:\"invoice-overdue-notice-arabic\";i:1;s:27:\"invoice-already-send-arabic\";i:1;s:31:\"new-ticket-created-staff-arabic\";i:1;s:30:\"estimate-send-to-client-arabic\";i:1;s:28:\"ticket-reply-to-admin-arabic\";i:1;s:28:\"estimate-already-send-arabic\";i:1;s:26:\"contract-expiration-arabic\";i:1;s:20:\"task-assigned-arabic\";i:1;s:29:\"task-added-as-follower-arabic\";i:1;s:21:\"task-commented-arabic\";i:1;s:28:\"task-added-attachment-arabic\";i:1;s:33:\"estimate-declined-to-staff-arabic\";i:1;s:33:\"estimate-accepted-to-staff-arabic\";i:1;s:31:\"proposal-client-accepted-arabic\";i:1;s:32:\"proposal-send-to-customer-arabic\";i:1;s:31:\"proposal-client-declined-arabic\";i:1;s:32:\"proposal-client-thank-you-arabic\";i:1;s:33:\"proposal-comment-to-client-arabic\";i:1;s:32:\"proposal-comment-to-admin-arabic\";i:1;s:37:\"estimate-thank-you-to-customer-arabic\";i:1;s:33:\"task-deadline-notification-arabic\";i:1;s:20:\"send-contract-arabic\";i:1;s:40:\"invoice-payment-recorded-to-staff-arabic\";i:1;s:24:\"auto-close-ticket-arabic\";i:1;s:46:\"new-project-discussion-created-to-staff-arabic\";i:1;s:49:\"new-project-discussion-created-to-customer-arabic\";i:1;s:44:\"new-project-file-uploaded-to-customer-arabic\";i:1;s:41:\"new-project-file-uploaded-to-staff-arabic\";i:1;s:49:\"new-project-discussion-comment-to-customer-arabic\";i:1;s:46:\"new-project-discussion-comment-to-staff-arabic\";i:1;s:36:\"staff-added-as-project-member-arabic\";i:1;s:31:\"estimate-expiry-reminder-arabic\";i:1;s:31:\"proposal-expiry-reminder-arabic\";i:1;s:24:\"new-staff-created-arabic\";i:1;s:30:\"contact-forgot-password-arabic\";i:1;s:31:\"contact-password-reseted-arabic\";i:1;s:27:\"contact-set-password-arabic\";i:1;s:28:\"staff-forgot-password-arabic\";i:1;s:29:\"staff-password-reseted-arabic\";i:1;s:26:\"assigned-to-project-arabic\";i:1;s:40:\"task-added-attachment-to-contacts-arabic\";i:1;s:33:\"task-commented-to-contacts-arabic\";i:1;s:24:\"new-lead-assigned-arabic\";i:1;s:23:\"client-statement-arabic\";i:1;s:31:\"ticket-assigned-to-admin-arabic\";i:1;s:37:\"new-client-registered-to-admin-arabic\";i:1;s:37:\"new-web-to-lead-form-submitted-arabic\";i:1;s:32:\"two-factor-authentication-arabic\";i:1;s:35:\"project-finished-to-customer-arabic\";i:1;s:33:\"credit-note-send-to-client-arabic\";i:1;s:34:\"task-status-change-to-staff-arabic\";i:1;s:37:\"task-status-change-to-contacts-arabic\";i:1;s:27:\"reminder-email-staff-arabic\";i:1;s:33:\"contract-comment-to-client-arabic\";i:1;s:32:\"contract-comment-to-admin-arabic\";i:1;s:24:\"send-subscription-arabic\";i:1;s:34:\"subscription-payment-failed-arabic\";i:1;s:28:\"subscription-canceled-arabic\";i:1;s:37:\"subscription-payment-succeeded-arabic\";i:1;s:35:\"contract-expiration-to-staff-arabic\";i:1;s:27:\"gdpr-removal-request-arabic\";i:1;s:32:\"gdpr-removal-request-lead-arabic\";i:1;s:36:\"client-registration-confirmed-arabic\";i:1;s:31:\"contract-signed-to-staff-arabic\";i:1;s:35:\"customer-subscribed-to-staff-arabic\";i:1;s:33:\"contact-verification-email-arabic\";i:1;s:50:\"new-customer-profile-file-uploaded-to-staff-arabic\";i:1;s:34:\"event-notification-to-staff-arabic\";i:1;s:28:\"new-client-created-bulgarian\";i:1;s:32:\"invoice-send-to-client-bulgarian\";i:1;s:33:\"new-ticket-opened-admin-bulgarian\";i:1;s:22:\"ticket-reply-bulgarian\";i:1;s:29:\"ticket-autoresponse-bulgarian\";i:1;s:34:\"invoice-payment-recorded-bulgarian\";i:1;s:32:\"invoice-overdue-notice-bulgarian\";i:1;s:30:\"invoice-already-send-bulgarian\";i:1;s:34:\"new-ticket-created-staff-bulgarian\";i:1;s:33:\"estimate-send-to-client-bulgarian\";i:1;s:31:\"ticket-reply-to-admin-bulgarian\";i:1;s:31:\"estimate-already-send-bulgarian\";i:1;s:29:\"contract-expiration-bulgarian\";i:1;s:23:\"task-assigned-bulgarian\";i:1;s:32:\"task-added-as-follower-bulgarian\";i:1;s:24:\"task-commented-bulgarian\";i:1;s:31:\"task-added-attachment-bulgarian\";i:1;s:36:\"estimate-declined-to-staff-bulgarian\";i:1;s:36:\"estimate-accepted-to-staff-bulgarian\";i:1;s:34:\"proposal-client-accepted-bulgarian\";i:1;s:35:\"proposal-send-to-customer-bulgarian\";i:1;s:34:\"proposal-client-declined-bulgarian\";i:1;s:35:\"proposal-client-thank-you-bulgarian\";i:1;s:36:\"proposal-comment-to-client-bulgarian\";i:1;s:35:\"proposal-comment-to-admin-bulgarian\";i:1;s:40:\"estimate-thank-you-to-customer-bulgarian\";i:1;s:36:\"task-deadline-notification-bulgarian\";i:1;s:23:\"send-contract-bulgarian\";i:1;s:43:\"invoice-payment-recorded-to-staff-bulgarian\";i:1;s:27:\"auto-close-ticket-bulgarian\";i:1;s:49:\"new-project-discussion-created-to-staff-bulgarian\";i:1;s:52:\"new-project-discussion-created-to-customer-bulgarian\";i:1;s:47:\"new-project-file-uploaded-to-customer-bulgarian\";i:1;s:44:\"new-project-file-uploaded-to-staff-bulgarian\";i:1;s:52:\"new-project-discussion-comment-to-customer-bulgarian\";i:1;s:49:\"new-project-discussion-comment-to-staff-bulgarian\";i:1;s:39:\"staff-added-as-project-member-bulgarian\";i:1;s:34:\"estimate-expiry-reminder-bulgarian\";i:1;s:34:\"proposal-expiry-reminder-bulgarian\";i:1;s:27:\"new-staff-created-bulgarian\";i:1;s:33:\"contact-forgot-password-bulgarian\";i:1;s:34:\"contact-password-reseted-bulgarian\";i:1;s:30:\"contact-set-password-bulgarian\";i:1;s:31:\"staff-forgot-password-bulgarian\";i:1;s:32:\"staff-password-reseted-bulgarian\";i:1;s:29:\"assigned-to-project-bulgarian\";i:1;s:43:\"task-added-attachment-to-contacts-bulgarian\";i:1;s:36:\"task-commented-to-contacts-bulgarian\";i:1;s:27:\"new-lead-assigned-bulgarian\";i:1;s:26:\"client-statement-bulgarian\";i:1;s:34:\"ticket-assigned-to-admin-bulgarian\";i:1;s:40:\"new-client-registered-to-admin-bulgarian\";i:1;s:40:\"new-web-to-lead-form-submitted-bulgarian\";i:1;s:35:\"two-factor-authentication-bulgarian\";i:1;s:38:\"project-finished-to-customer-bulgarian\";i:1;s:36:\"credit-note-send-to-client-bulgarian\";i:1;s:37:\"task-status-change-to-staff-bulgarian\";i:1;s:40:\"task-status-change-to-contacts-bulgarian\";i:1;s:30:\"reminder-email-staff-bulgarian\";i:1;s:36:\"contract-comment-to-client-bulgarian\";i:1;s:35:\"contract-comment-to-admin-bulgarian\";i:1;s:27:\"send-subscription-bulgarian\";i:1;s:37:\"subscription-payment-failed-bulgarian\";i:1;s:31:\"subscription-canceled-bulgarian\";i:1;s:40:\"subscription-payment-succeeded-bulgarian\";i:1;s:38:\"contract-expiration-to-staff-bulgarian\";i:1;s:30:\"gdpr-removal-request-bulgarian\";i:1;s:35:\"gdpr-removal-request-lead-bulgarian\";i:1;s:39:\"client-registration-confirmed-bulgarian\";i:1;s:34:\"contract-signed-to-staff-bulgarian\";i:1;s:38:\"customer-subscribed-to-staff-bulgarian\";i:1;s:36:\"contact-verification-email-bulgarian\";i:1;s:53:\"new-customer-profile-file-uploaded-to-staff-bulgarian\";i:1;s:37:\"event-notification-to-staff-bulgarian\";i:1;s:26:\"new-client-created-catalan\";i:1;s:30:\"invoice-send-to-client-catalan\";i:1;s:31:\"new-ticket-opened-admin-catalan\";i:1;s:20:\"ticket-reply-catalan\";i:1;s:27:\"ticket-autoresponse-catalan\";i:1;s:32:\"invoice-payment-recorded-catalan\";i:1;s:30:\"invoice-overdue-notice-catalan\";i:1;s:28:\"invoice-already-send-catalan\";i:1;s:32:\"new-ticket-created-staff-catalan\";i:1;s:31:\"estimate-send-to-client-catalan\";i:1;s:29:\"ticket-reply-to-admin-catalan\";i:1;s:29:\"estimate-already-send-catalan\";i:1;s:27:\"contract-expiration-catalan\";i:1;s:21:\"task-assigned-catalan\";i:1;s:30:\"task-added-as-follower-catalan\";i:1;s:22:\"task-commented-catalan\";i:1;s:29:\"task-added-attachment-catalan\";i:1;s:34:\"estimate-declined-to-staff-catalan\";i:1;s:34:\"estimate-accepted-to-staff-catalan\";i:1;s:32:\"proposal-client-accepted-catalan\";i:1;s:33:\"proposal-send-to-customer-catalan\";i:1;s:32:\"proposal-client-declined-catalan\";i:1;s:33:\"proposal-client-thank-you-catalan\";i:1;s:34:\"proposal-comment-to-client-catalan\";i:1;s:33:\"proposal-comment-to-admin-catalan\";i:1;s:38:\"estimate-thank-you-to-customer-catalan\";i:1;s:34:\"task-deadline-notification-catalan\";i:1;s:21:\"send-contract-catalan\";i:1;s:41:\"invoice-payment-recorded-to-staff-catalan\";i:1;s:25:\"auto-close-ticket-catalan\";i:1;s:47:\"new-project-discussion-created-to-staff-catalan\";i:1;s:50:\"new-project-discussion-created-to-customer-catalan\";i:1;s:45:\"new-project-file-uploaded-to-customer-catalan\";i:1;s:42:\"new-project-file-uploaded-to-staff-catalan\";i:1;s:50:\"new-project-discussion-comment-to-customer-catalan\";i:1;s:47:\"new-project-discussion-comment-to-staff-catalan\";i:1;s:37:\"staff-added-as-project-member-catalan\";i:1;s:32:\"estimate-expiry-reminder-catalan\";i:1;s:32:\"proposal-expiry-reminder-catalan\";i:1;s:25:\"new-staff-created-catalan\";i:1;s:31:\"contact-forgot-password-catalan\";i:1;s:32:\"contact-password-reseted-catalan\";i:1;s:28:\"contact-set-password-catalan\";i:1;s:29:\"staff-forgot-password-catalan\";i:1;s:30:\"staff-password-reseted-catalan\";i:1;s:27:\"assigned-to-project-catalan\";i:1;s:41:\"task-added-attachment-to-contacts-catalan\";i:1;s:34:\"task-commented-to-contacts-catalan\";i:1;s:25:\"new-lead-assigned-catalan\";i:1;s:24:\"client-statement-catalan\";i:1;s:32:\"ticket-assigned-to-admin-catalan\";i:1;s:38:\"new-client-registered-to-admin-catalan\";i:1;s:38:\"new-web-to-lead-form-submitted-catalan\";i:1;s:33:\"two-factor-authentication-catalan\";i:1;s:36:\"project-finished-to-customer-catalan\";i:1;s:34:\"credit-note-send-to-client-catalan\";i:1;s:35:\"task-status-change-to-staff-catalan\";i:1;s:38:\"task-status-change-to-contacts-catalan\";i:1;s:28:\"reminder-email-staff-catalan\";i:1;s:34:\"contract-comment-to-client-catalan\";i:1;s:33:\"contract-comment-to-admin-catalan\";i:1;s:25:\"send-subscription-catalan\";i:1;s:35:\"subscription-payment-failed-catalan\";i:1;s:29:\"subscription-canceled-catalan\";i:1;s:38:\"subscription-payment-succeeded-catalan\";i:1;s:36:\"contract-expiration-to-staff-catalan\";i:1;s:28:\"gdpr-removal-request-catalan\";i:1;s:33:\"gdpr-removal-request-lead-catalan\";i:1;s:37:\"client-registration-confirmed-catalan\";i:1;s:32:\"contract-signed-to-staff-catalan\";i:1;s:36:\"customer-subscribed-to-staff-catalan\";i:1;s:34:\"contact-verification-email-catalan\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-catalan\";i:1;s:35:\"event-notification-to-staff-catalan\";i:1;s:26:\"new-client-created-chinese\";i:1;s:30:\"invoice-send-to-client-chinese\";i:1;s:31:\"new-ticket-opened-admin-chinese\";i:1;s:20:\"ticket-reply-chinese\";i:1;s:27:\"ticket-autoresponse-chinese\";i:1;s:32:\"invoice-payment-recorded-chinese\";i:1;s:30:\"invoice-overdue-notice-chinese\";i:1;s:28:\"invoice-already-send-chinese\";i:1;s:32:\"new-ticket-created-staff-chinese\";i:1;s:31:\"estimate-send-to-client-chinese\";i:1;s:29:\"ticket-reply-to-admin-chinese\";i:1;s:29:\"estimate-already-send-chinese\";i:1;s:27:\"contract-expiration-chinese\";i:1;s:21:\"task-assigned-chinese\";i:1;s:30:\"task-added-as-follower-chinese\";i:1;s:22:\"task-commented-chinese\";i:1;s:29:\"task-added-attachment-chinese\";i:1;s:34:\"estimate-declined-to-staff-chinese\";i:1;s:34:\"estimate-accepted-to-staff-chinese\";i:1;s:32:\"proposal-client-accepted-chinese\";i:1;s:33:\"proposal-send-to-customer-chinese\";i:1;s:32:\"proposal-client-declined-chinese\";i:1;s:33:\"proposal-client-thank-you-chinese\";i:1;s:34:\"proposal-comment-to-client-chinese\";i:1;s:33:\"proposal-comment-to-admin-chinese\";i:1;s:38:\"estimate-thank-you-to-customer-chinese\";i:1;s:34:\"task-deadline-notification-chinese\";i:1;s:21:\"send-contract-chinese\";i:1;s:41:\"invoice-payment-recorded-to-staff-chinese\";i:1;s:25:\"auto-close-ticket-chinese\";i:1;s:47:\"new-project-discussion-created-to-staff-chinese\";i:1;s:50:\"new-project-discussion-created-to-customer-chinese\";i:1;s:45:\"new-project-file-uploaded-to-customer-chinese\";i:1;s:42:\"new-project-file-uploaded-to-staff-chinese\";i:1;s:50:\"new-project-discussion-comment-to-customer-chinese\";i:1;s:47:\"new-project-discussion-comment-to-staff-chinese\";i:1;s:37:\"staff-added-as-project-member-chinese\";i:1;s:32:\"estimate-expiry-reminder-chinese\";i:1;s:32:\"proposal-expiry-reminder-chinese\";i:1;s:25:\"new-staff-created-chinese\";i:1;s:31:\"contact-forgot-password-chinese\";i:1;s:32:\"contact-password-reseted-chinese\";i:1;s:28:\"contact-set-password-chinese\";i:1;s:29:\"staff-forgot-password-chinese\";i:1;s:30:\"staff-password-reseted-chinese\";i:1;s:27:\"assigned-to-project-chinese\";i:1;s:41:\"task-added-attachment-to-contacts-chinese\";i:1;s:34:\"task-commented-to-contacts-chinese\";i:1;s:25:\"new-lead-assigned-chinese\";i:1;s:24:\"client-statement-chinese\";i:1;s:32:\"ticket-assigned-to-admin-chinese\";i:1;s:38:\"new-client-registered-to-admin-chinese\";i:1;s:38:\"new-web-to-lead-form-submitted-chinese\";i:1;s:33:\"two-factor-authentication-chinese\";i:1;s:36:\"project-finished-to-customer-chinese\";i:1;s:34:\"credit-note-send-to-client-chinese\";i:1;s:35:\"task-status-change-to-staff-chinese\";i:1;s:38:\"task-status-change-to-contacts-chinese\";i:1;s:28:\"reminder-email-staff-chinese\";i:1;s:34:\"contract-comment-to-client-chinese\";i:1;s:33:\"contract-comment-to-admin-chinese\";i:1;s:25:\"send-subscription-chinese\";i:1;s:35:\"subscription-payment-failed-chinese\";i:1;s:29:\"subscription-canceled-chinese\";i:1;s:38:\"subscription-payment-succeeded-chinese\";i:1;s:36:\"contract-expiration-to-staff-chinese\";i:1;s:28:\"gdpr-removal-request-chinese\";i:1;s:33:\"gdpr-removal-request-lead-chinese\";i:1;s:37:\"client-registration-confirmed-chinese\";i:1;s:32:\"contract-signed-to-staff-chinese\";i:1;s:36:\"customer-subscribed-to-staff-chinese\";i:1;s:34:\"contact-verification-email-chinese\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-chinese\";i:1;s:35:\"event-notification-to-staff-chinese\";i:1;s:24:\"new-client-created-czech\";i:1;s:28:\"invoice-send-to-client-czech\";i:1;s:29:\"new-ticket-opened-admin-czech\";i:1;s:18:\"ticket-reply-czech\";i:1;s:25:\"ticket-autoresponse-czech\";i:1;s:30:\"invoice-payment-recorded-czech\";i:1;s:28:\"invoice-overdue-notice-czech\";i:1;s:26:\"invoice-already-send-czech\";i:1;s:30:\"new-ticket-created-staff-czech\";i:1;s:29:\"estimate-send-to-client-czech\";i:1;s:27:\"ticket-reply-to-admin-czech\";i:1;s:27:\"estimate-already-send-czech\";i:1;s:25:\"contract-expiration-czech\";i:1;s:19:\"task-assigned-czech\";i:1;s:28:\"task-added-as-follower-czech\";i:1;s:20:\"task-commented-czech\";i:1;s:27:\"task-added-attachment-czech\";i:1;s:32:\"estimate-declined-to-staff-czech\";i:1;s:32:\"estimate-accepted-to-staff-czech\";i:1;s:30:\"proposal-client-accepted-czech\";i:1;s:31:\"proposal-send-to-customer-czech\";i:1;s:30:\"proposal-client-declined-czech\";i:1;s:31:\"proposal-client-thank-you-czech\";i:1;s:32:\"proposal-comment-to-client-czech\";i:1;s:31:\"proposal-comment-to-admin-czech\";i:1;s:36:\"estimate-thank-you-to-customer-czech\";i:1;s:32:\"task-deadline-notification-czech\";i:1;s:19:\"send-contract-czech\";i:1;s:39:\"invoice-payment-recorded-to-staff-czech\";i:1;s:23:\"auto-close-ticket-czech\";i:1;s:45:\"new-project-discussion-created-to-staff-czech\";i:1;s:48:\"new-project-discussion-created-to-customer-czech\";i:1;s:43:\"new-project-file-uploaded-to-customer-czech\";i:1;s:40:\"new-project-file-uploaded-to-staff-czech\";i:1;s:48:\"new-project-discussion-comment-to-customer-czech\";i:1;s:45:\"new-project-discussion-comment-to-staff-czech\";i:1;s:35:\"staff-added-as-project-member-czech\";i:1;s:30:\"estimate-expiry-reminder-czech\";i:1;s:30:\"proposal-expiry-reminder-czech\";i:1;s:23:\"new-staff-created-czech\";i:1;s:29:\"contact-forgot-password-czech\";i:1;s:30:\"contact-password-reseted-czech\";i:1;s:26:\"contact-set-password-czech\";i:1;s:27:\"staff-forgot-password-czech\";i:1;s:28:\"staff-password-reseted-czech\";i:1;s:25:\"assigned-to-project-czech\";i:1;s:39:\"task-added-attachment-to-contacts-czech\";i:1;s:32:\"task-commented-to-contacts-czech\";i:1;s:23:\"new-lead-assigned-czech\";i:1;s:22:\"client-statement-czech\";i:1;s:30:\"ticket-assigned-to-admin-czech\";i:1;s:36:\"new-client-registered-to-admin-czech\";i:1;s:36:\"new-web-to-lead-form-submitted-czech\";i:1;s:31:\"two-factor-authentication-czech\";i:1;s:34:\"project-finished-to-customer-czech\";i:1;s:32:\"credit-note-send-to-client-czech\";i:1;s:33:\"task-status-change-to-staff-czech\";i:1;s:36:\"task-status-change-to-contacts-czech\";i:1;s:26:\"reminder-email-staff-czech\";i:1;s:32:\"contract-comment-to-client-czech\";i:1;s:31:\"contract-comment-to-admin-czech\";i:1;s:23:\"send-subscription-czech\";i:1;s:33:\"subscription-payment-failed-czech\";i:1;s:27:\"subscription-canceled-czech\";i:1;s:36:\"subscription-payment-succeeded-czech\";i:1;s:34:\"contract-expiration-to-staff-czech\";i:1;s:26:\"gdpr-removal-request-czech\";i:1;s:31:\"gdpr-removal-request-lead-czech\";i:1;s:35:\"client-registration-confirmed-czech\";i:1;s:30:\"contract-signed-to-staff-czech\";i:1;s:34:\"customer-subscribed-to-staff-czech\";i:1;s:32:\"contact-verification-email-czech\";i:1;s:49:\"new-customer-profile-file-uploaded-to-staff-czech\";i:1;s:33:\"event-notification-to-staff-czech\";i:1;s:24:\"new-client-created-dutch\";i:1;s:28:\"invoice-send-to-client-dutch\";i:1;s:29:\"new-ticket-opened-admin-dutch\";i:1;s:18:\"ticket-reply-dutch\";i:1;s:25:\"ticket-autoresponse-dutch\";i:1;s:30:\"invoice-payment-recorded-dutch\";i:1;s:28:\"invoice-overdue-notice-dutch\";i:1;s:26:\"invoice-already-send-dutch\";i:1;s:30:\"new-ticket-created-staff-dutch\";i:1;s:29:\"estimate-send-to-client-dutch\";i:1;s:27:\"ticket-reply-to-admin-dutch\";i:1;s:27:\"estimate-already-send-dutch\";i:1;s:25:\"contract-expiration-dutch\";i:1;s:19:\"task-assigned-dutch\";i:1;s:28:\"task-added-as-follower-dutch\";i:1;s:20:\"task-commented-dutch\";i:1;s:27:\"task-added-attachment-dutch\";i:1;s:32:\"estimate-declined-to-staff-dutch\";i:1;s:32:\"estimate-accepted-to-staff-dutch\";i:1;s:30:\"proposal-client-accepted-dutch\";i:1;s:31:\"proposal-send-to-customer-dutch\";i:1;s:30:\"proposal-client-declined-dutch\";i:1;s:31:\"proposal-client-thank-you-dutch\";i:1;s:32:\"proposal-comment-to-client-dutch\";i:1;s:31:\"proposal-comment-to-admin-dutch\";i:1;s:36:\"estimate-thank-you-to-customer-dutch\";i:1;s:32:\"task-deadline-notification-dutch\";i:1;s:19:\"send-contract-dutch\";i:1;s:39:\"invoice-payment-recorded-to-staff-dutch\";i:1;s:23:\"auto-close-ticket-dutch\";i:1;s:45:\"new-project-discussion-created-to-staff-dutch\";i:1;s:48:\"new-project-discussion-created-to-customer-dutch\";i:1;s:43:\"new-project-file-uploaded-to-customer-dutch\";i:1;s:40:\"new-project-file-uploaded-to-staff-dutch\";i:1;s:48:\"new-project-discussion-comment-to-customer-dutch\";i:1;s:45:\"new-project-discussion-comment-to-staff-dutch\";i:1;s:35:\"staff-added-as-project-member-dutch\";i:1;s:30:\"estimate-expiry-reminder-dutch\";i:1;s:30:\"proposal-expiry-reminder-dutch\";i:1;s:23:\"new-staff-created-dutch\";i:1;s:29:\"contact-forgot-password-dutch\";i:1;s:30:\"contact-password-reseted-dutch\";i:1;s:26:\"contact-set-password-dutch\";i:1;s:27:\"staff-forgot-password-dutch\";i:1;s:28:\"staff-password-reseted-dutch\";i:1;s:25:\"assigned-to-project-dutch\";i:1;s:39:\"task-added-attachment-to-contacts-dutch\";i:1;s:32:\"task-commented-to-contacts-dutch\";i:1;s:23:\"new-lead-assigned-dutch\";i:1;s:22:\"client-statement-dutch\";i:1;s:30:\"ticket-assigned-to-admin-dutch\";i:1;s:36:\"new-client-registered-to-admin-dutch\";i:1;s:36:\"new-web-to-lead-form-submitted-dutch\";i:1;s:31:\"two-factor-authentication-dutch\";i:1;s:34:\"project-finished-to-customer-dutch\";i:1;s:32:\"credit-note-send-to-client-dutch\";i:1;s:33:\"task-status-change-to-staff-dutch\";i:1;s:36:\"task-status-change-to-contacts-dutch\";i:1;s:26:\"reminder-email-staff-dutch\";i:1;s:32:\"contract-comment-to-client-dutch\";i:1;s:31:\"contract-comment-to-admin-dutch\";i:1;s:23:\"send-subscription-dutch\";i:1;s:33:\"subscription-payment-failed-dutch\";i:1;s:27:\"subscription-canceled-dutch\";i:1;s:36:\"subscription-payment-succeeded-dutch\";i:1;s:34:\"contract-expiration-to-staff-dutch\";i:1;s:26:\"gdpr-removal-request-dutch\";i:1;s:31:\"gdpr-removal-request-lead-dutch\";i:1;s:35:\"client-registration-confirmed-dutch\";i:1;s:30:\"contract-signed-to-staff-dutch\";i:1;s:34:\"customer-subscribed-to-staff-dutch\";i:1;s:32:\"contact-verification-email-dutch\";i:1;s:49:\"new-customer-profile-file-uploaded-to-staff-dutch\";i:1;s:33:\"event-notification-to-staff-dutch\";i:1;s:25:\"new-client-created-french\";i:1;s:29:\"invoice-send-to-client-french\";i:1;s:30:\"new-ticket-opened-admin-french\";i:1;s:19:\"ticket-reply-french\";i:1;s:26:\"ticket-autoresponse-french\";i:1;s:31:\"invoice-payment-recorded-french\";i:1;s:29:\"invoice-overdue-notice-french\";i:1;s:27:\"invoice-already-send-french\";i:1;s:31:\"new-ticket-created-staff-french\";i:1;s:30:\"estimate-send-to-client-french\";i:1;s:28:\"ticket-reply-to-admin-french\";i:1;s:28:\"estimate-already-send-french\";i:1;s:26:\"contract-expiration-french\";i:1;s:20:\"task-assigned-french\";i:1;s:29:\"task-added-as-follower-french\";i:1;s:21:\"task-commented-french\";i:1;s:28:\"task-added-attachment-french\";i:1;s:33:\"estimate-declined-to-staff-french\";i:1;s:33:\"estimate-accepted-to-staff-french\";i:1;s:31:\"proposal-client-accepted-french\";i:1;s:32:\"proposal-send-to-customer-french\";i:1;s:31:\"proposal-client-declined-french\";i:1;s:32:\"proposal-client-thank-you-french\";i:1;s:33:\"proposal-comment-to-client-french\";i:1;s:32:\"proposal-comment-to-admin-french\";i:1;s:37:\"estimate-thank-you-to-customer-french\";i:1;s:33:\"task-deadline-notification-french\";i:1;s:20:\"send-contract-french\";i:1;s:40:\"invoice-payment-recorded-to-staff-french\";i:1;s:24:\"auto-close-ticket-french\";i:1;s:46:\"new-project-discussion-created-to-staff-french\";i:1;s:49:\"new-project-discussion-created-to-customer-french\";i:1;s:44:\"new-project-file-uploaded-to-customer-french\";i:1;s:41:\"new-project-file-uploaded-to-staff-french\";i:1;s:49:\"new-project-discussion-comment-to-customer-french\";i:1;s:46:\"new-project-discussion-comment-to-staff-french\";i:1;s:36:\"staff-added-as-project-member-french\";i:1;s:31:\"estimate-expiry-reminder-french\";i:1;s:31:\"proposal-expiry-reminder-french\";i:1;s:24:\"new-staff-created-french\";i:1;s:30:\"contact-forgot-password-french\";i:1;s:31:\"contact-password-reseted-french\";i:1;s:27:\"contact-set-password-french\";i:1;s:28:\"staff-forgot-password-french\";i:1;s:29:\"staff-password-reseted-french\";i:1;s:26:\"assigned-to-project-french\";i:1;s:40:\"task-added-attachment-to-contacts-french\";i:1;s:33:\"task-commented-to-contacts-french\";i:1;s:24:\"new-lead-assigned-french\";i:1;s:23:\"client-statement-french\";i:1;s:31:\"ticket-assigned-to-admin-french\";i:1;s:37:\"new-client-registered-to-admin-french\";i:1;s:37:\"new-web-to-lead-form-submitted-french\";i:1;s:32:\"two-factor-authentication-french\";i:1;s:35:\"project-finished-to-customer-french\";i:1;s:33:\"credit-note-send-to-client-french\";i:1;s:34:\"task-status-change-to-staff-french\";i:1;s:37:\"task-status-change-to-contacts-french\";i:1;s:27:\"reminder-email-staff-french\";i:1;s:33:\"contract-comment-to-client-french\";i:1;s:32:\"contract-comment-to-admin-french\";i:1;s:24:\"send-subscription-french\";i:1;s:34:\"subscription-payment-failed-french\";i:1;s:28:\"subscription-canceled-french\";i:1;s:37:\"subscription-payment-succeeded-french\";i:1;s:35:\"contract-expiration-to-staff-french\";i:1;s:27:\"gdpr-removal-request-french\";i:1;s:32:\"gdpr-removal-request-lead-french\";i:1;s:36:\"client-registration-confirmed-french\";i:1;s:31:\"contract-signed-to-staff-french\";i:1;s:35:\"customer-subscribed-to-staff-french\";i:1;s:33:\"contact-verification-email-french\";i:1;s:50:\"new-customer-profile-file-uploaded-to-staff-french\";i:1;s:34:\"event-notification-to-staff-french\";i:1;s:25:\"new-client-created-german\";i:1;s:29:\"invoice-send-to-client-german\";i:1;s:30:\"new-ticket-opened-admin-german\";i:1;s:19:\"ticket-reply-german\";i:1;s:26:\"ticket-autoresponse-german\";i:1;s:31:\"invoice-payment-recorded-german\";i:1;s:29:\"invoice-overdue-notice-german\";i:1;s:27:\"invoice-already-send-german\";i:1;s:31:\"new-ticket-created-staff-german\";i:1;s:30:\"estimate-send-to-client-german\";i:1;s:28:\"ticket-reply-to-admin-german\";i:1;s:28:\"estimate-already-send-german\";i:1;s:26:\"contract-expiration-german\";i:1;s:20:\"task-assigned-german\";i:1;s:29:\"task-added-as-follower-german\";i:1;s:21:\"task-commented-german\";i:1;s:28:\"task-added-attachment-german\";i:1;s:33:\"estimate-declined-to-staff-german\";i:1;s:33:\"estimate-accepted-to-staff-german\";i:1;s:31:\"proposal-client-accepted-german\";i:1;s:32:\"proposal-send-to-customer-german\";i:1;s:31:\"proposal-client-declined-german\";i:1;s:32:\"proposal-client-thank-you-german\";i:1;s:33:\"proposal-comment-to-client-german\";i:1;s:32:\"proposal-comment-to-admin-german\";i:1;s:37:\"estimate-thank-you-to-customer-german\";i:1;s:33:\"task-deadline-notification-german\";i:1;s:20:\"send-contract-german\";i:1;s:40:\"invoice-payment-recorded-to-staff-german\";i:1;s:24:\"auto-close-ticket-german\";i:1;s:46:\"new-project-discussion-created-to-staff-german\";i:1;s:49:\"new-project-discussion-created-to-customer-german\";i:1;s:44:\"new-project-file-uploaded-to-customer-german\";i:1;s:41:\"new-project-file-uploaded-to-staff-german\";i:1;s:49:\"new-project-discussion-comment-to-customer-german\";i:1;s:46:\"new-project-discussion-comment-to-staff-german\";i:1;s:36:\"staff-added-as-project-member-german\";i:1;s:31:\"estimate-expiry-reminder-german\";i:1;s:31:\"proposal-expiry-reminder-german\";i:1;s:24:\"new-staff-created-german\";i:1;s:30:\"contact-forgot-password-german\";i:1;s:31:\"contact-password-reseted-german\";i:1;s:27:\"contact-set-password-german\";i:1;s:28:\"staff-forgot-password-german\";i:1;s:29:\"staff-password-reseted-german\";i:1;s:26:\"assigned-to-project-german\";i:1;s:40:\"task-added-attachment-to-contacts-german\";i:1;s:33:\"task-commented-to-contacts-german\";i:1;s:24:\"new-lead-assigned-german\";i:1;s:23:\"client-statement-german\";i:1;s:31:\"ticket-assigned-to-admin-german\";i:1;s:37:\"new-client-registered-to-admin-german\";i:1;s:37:\"new-web-to-lead-form-submitted-german\";i:1;s:32:\"two-factor-authentication-german\";i:1;s:35:\"project-finished-to-customer-german\";i:1;s:33:\"credit-note-send-to-client-german\";i:1;s:34:\"task-status-change-to-staff-german\";i:1;s:37:\"task-status-change-to-contacts-german\";i:1;s:27:\"reminder-email-staff-german\";i:1;s:33:\"contract-comment-to-client-german\";i:1;s:32:\"contract-comment-to-admin-german\";i:1;s:24:\"send-subscription-german\";i:1;s:34:\"subscription-payment-failed-german\";i:1;s:28:\"subscription-canceled-german\";i:1;s:37:\"subscription-payment-succeeded-german\";i:1;s:35:\"contract-expiration-to-staff-german\";i:1;s:27:\"gdpr-removal-request-german\";i:1;s:32:\"gdpr-removal-request-lead-german\";i:1;s:36:\"client-registration-confirmed-german\";i:1;s:31:\"contract-signed-to-staff-german\";i:1;s:35:\"customer-subscribed-to-staff-german\";i:1;s:33:\"contact-verification-email-german\";i:1;s:50:\"new-customer-profile-file-uploaded-to-staff-german\";i:1;s:34:\"event-notification-to-staff-german\";i:1;s:24:\"new-client-created-greek\";i:1;s:28:\"invoice-send-to-client-greek\";i:1;s:29:\"new-ticket-opened-admin-greek\";i:1;s:18:\"ticket-reply-greek\";i:1;s:25:\"ticket-autoresponse-greek\";i:1;s:30:\"invoice-payment-recorded-greek\";i:1;s:28:\"invoice-overdue-notice-greek\";i:1;s:26:\"invoice-already-send-greek\";i:1;s:30:\"new-ticket-created-staff-greek\";i:1;s:29:\"estimate-send-to-client-greek\";i:1;s:27:\"ticket-reply-to-admin-greek\";i:1;s:27:\"estimate-already-send-greek\";i:1;s:25:\"contract-expiration-greek\";i:1;s:19:\"task-assigned-greek\";i:1;s:28:\"task-added-as-follower-greek\";i:1;s:20:\"task-commented-greek\";i:1;s:27:\"task-added-attachment-greek\";i:1;s:32:\"estimate-declined-to-staff-greek\";i:1;s:32:\"estimate-accepted-to-staff-greek\";i:1;s:30:\"proposal-client-accepted-greek\";i:1;s:31:\"proposal-send-to-customer-greek\";i:1;s:30:\"proposal-client-declined-greek\";i:1;s:31:\"proposal-client-thank-you-greek\";i:1;s:32:\"proposal-comment-to-client-greek\";i:1;s:31:\"proposal-comment-to-admin-greek\";i:1;s:36:\"estimate-thank-you-to-customer-greek\";i:1;s:32:\"task-deadline-notification-greek\";i:1;s:19:\"send-contract-greek\";i:1;s:39:\"invoice-payment-recorded-to-staff-greek\";i:1;s:23:\"auto-close-ticket-greek\";i:1;s:45:\"new-project-discussion-created-to-staff-greek\";i:1;s:48:\"new-project-discussion-created-to-customer-greek\";i:1;s:43:\"new-project-file-uploaded-to-customer-greek\";i:1;s:40:\"new-project-file-uploaded-to-staff-greek\";i:1;s:48:\"new-project-discussion-comment-to-customer-greek\";i:1;s:45:\"new-project-discussion-comment-to-staff-greek\";i:1;s:35:\"staff-added-as-project-member-greek\";i:1;s:30:\"estimate-expiry-reminder-greek\";i:1;s:30:\"proposal-expiry-reminder-greek\";i:1;s:23:\"new-staff-created-greek\";i:1;s:29:\"contact-forgot-password-greek\";i:1;s:30:\"contact-password-reseted-greek\";i:1;s:26:\"contact-set-password-greek\";i:1;s:27:\"staff-forgot-password-greek\";i:1;s:28:\"staff-password-reseted-greek\";i:1;s:25:\"assigned-to-project-greek\";i:1;s:39:\"task-added-attachment-to-contacts-greek\";i:1;s:32:\"task-commented-to-contacts-greek\";i:1;s:23:\"new-lead-assigned-greek\";i:1;s:22:\"client-statement-greek\";i:1;s:30:\"ticket-assigned-to-admin-greek\";i:1;s:36:\"new-client-registered-to-admin-greek\";i:1;s:36:\"new-web-to-lead-form-submitted-greek\";i:1;s:31:\"two-factor-authentication-greek\";i:1;s:34:\"project-finished-to-customer-greek\";i:1;s:32:\"credit-note-send-to-client-greek\";i:1;s:33:\"task-status-change-to-staff-greek\";i:1;s:36:\"task-status-change-to-contacts-greek\";i:1;s:26:\"reminder-email-staff-greek\";i:1;s:32:\"contract-comment-to-client-greek\";i:1;s:31:\"contract-comment-to-admin-greek\";i:1;s:23:\"send-subscription-greek\";i:1;s:33:\"subscription-payment-failed-greek\";i:1;s:27:\"subscription-canceled-greek\";i:1;s:36:\"subscription-payment-succeeded-greek\";i:1;s:34:\"contract-expiration-to-staff-greek\";i:1;s:26:\"gdpr-removal-request-greek\";i:1;s:31:\"gdpr-removal-request-lead-greek\";i:1;s:35:\"client-registration-confirmed-greek\";i:1;s:30:\"contract-signed-to-staff-greek\";i:1;s:34:\"customer-subscribed-to-staff-greek\";i:1;s:32:\"contact-verification-email-greek\";i:1;s:49:\"new-customer-profile-file-uploaded-to-staff-greek\";i:1;s:33:\"event-notification-to-staff-greek\";i:1;s:28:\"new-client-created-indonesia\";i:1;s:32:\"invoice-send-to-client-indonesia\";i:1;s:33:\"new-ticket-opened-admin-indonesia\";i:1;s:22:\"ticket-reply-indonesia\";i:1;s:29:\"ticket-autoresponse-indonesia\";i:1;s:34:\"invoice-payment-recorded-indonesia\";i:1;s:32:\"invoice-overdue-notice-indonesia\";i:1;s:30:\"invoice-already-send-indonesia\";i:1;s:34:\"new-ticket-created-staff-indonesia\";i:1;s:33:\"estimate-send-to-client-indonesia\";i:1;s:31:\"ticket-reply-to-admin-indonesia\";i:1;s:31:\"estimate-already-send-indonesia\";i:1;s:29:\"contract-expiration-indonesia\";i:1;s:23:\"task-assigned-indonesia\";i:1;s:32:\"task-added-as-follower-indonesia\";i:1;s:24:\"task-commented-indonesia\";i:1;s:31:\"task-added-attachment-indonesia\";i:1;s:36:\"estimate-declined-to-staff-indonesia\";i:1;s:36:\"estimate-accepted-to-staff-indonesia\";i:1;s:34:\"proposal-client-accepted-indonesia\";i:1;s:35:\"proposal-send-to-customer-indonesia\";i:1;s:34:\"proposal-client-declined-indonesia\";i:1;s:35:\"proposal-client-thank-you-indonesia\";i:1;s:36:\"proposal-comment-to-client-indonesia\";i:1;s:35:\"proposal-comment-to-admin-indonesia\";i:1;s:40:\"estimate-thank-you-to-customer-indonesia\";i:1;s:36:\"task-deadline-notification-indonesia\";i:1;s:23:\"send-contract-indonesia\";i:1;s:43:\"invoice-payment-recorded-to-staff-indonesia\";i:1;s:27:\"auto-close-ticket-indonesia\";i:1;s:49:\"new-project-discussion-created-to-staff-indonesia\";i:1;s:52:\"new-project-discussion-created-to-customer-indonesia\";i:1;s:47:\"new-project-file-uploaded-to-customer-indonesia\";i:1;s:44:\"new-project-file-uploaded-to-staff-indonesia\";i:1;s:52:\"new-project-discussion-comment-to-customer-indonesia\";i:1;s:49:\"new-project-discussion-comment-to-staff-indonesia\";i:1;s:39:\"staff-added-as-project-member-indonesia\";i:1;s:34:\"estimate-expiry-reminder-indonesia\";i:1;s:34:\"proposal-expiry-reminder-indonesia\";i:1;s:27:\"new-staff-created-indonesia\";i:1;s:33:\"contact-forgot-password-indonesia\";i:1;s:34:\"contact-password-reseted-indonesia\";i:1;s:30:\"contact-set-password-indonesia\";i:1;s:31:\"staff-forgot-password-indonesia\";i:1;s:32:\"staff-password-reseted-indonesia\";i:1;s:29:\"assigned-to-project-indonesia\";i:1;s:43:\"task-added-attachment-to-contacts-indonesia\";i:1;s:36:\"task-commented-to-contacts-indonesia\";i:1;s:27:\"new-lead-assigned-indonesia\";i:1;s:26:\"client-statement-indonesia\";i:1;s:34:\"ticket-assigned-to-admin-indonesia\";i:1;s:40:\"new-client-registered-to-admin-indonesia\";i:1;s:40:\"new-web-to-lead-form-submitted-indonesia\";i:1;s:35:\"two-factor-authentication-indonesia\";i:1;s:38:\"project-finished-to-customer-indonesia\";i:1;s:36:\"credit-note-send-to-client-indonesia\";i:1;s:37:\"task-status-change-to-staff-indonesia\";i:1;s:40:\"task-status-change-to-contacts-indonesia\";i:1;s:30:\"reminder-email-staff-indonesia\";i:1;s:36:\"contract-comment-to-client-indonesia\";i:1;s:35:\"contract-comment-to-admin-indonesia\";i:1;s:27:\"send-subscription-indonesia\";i:1;s:37:\"subscription-payment-failed-indonesia\";i:1;s:31:\"subscription-canceled-indonesia\";i:1;s:40:\"subscription-payment-succeeded-indonesia\";i:1;s:38:\"contract-expiration-to-staff-indonesia\";i:1;s:30:\"gdpr-removal-request-indonesia\";i:1;s:35:\"gdpr-removal-request-lead-indonesia\";i:1;s:39:\"client-registration-confirmed-indonesia\";i:1;s:34:\"contract-signed-to-staff-indonesia\";i:1;s:38:\"customer-subscribed-to-staff-indonesia\";i:1;s:36:\"contact-verification-email-indonesia\";i:1;s:53:\"new-customer-profile-file-uploaded-to-staff-indonesia\";i:1;s:37:\"event-notification-to-staff-indonesia\";i:1;s:26:\"new-client-created-italian\";i:1;s:30:\"invoice-send-to-client-italian\";i:1;s:31:\"new-ticket-opened-admin-italian\";i:1;s:20:\"ticket-reply-italian\";i:1;s:27:\"ticket-autoresponse-italian\";i:1;s:32:\"invoice-payment-recorded-italian\";i:1;s:30:\"invoice-overdue-notice-italian\";i:1;s:28:\"invoice-already-send-italian\";i:1;s:32:\"new-ticket-created-staff-italian\";i:1;s:31:\"estimate-send-to-client-italian\";i:1;s:29:\"ticket-reply-to-admin-italian\";i:1;s:29:\"estimate-already-send-italian\";i:1;s:27:\"contract-expiration-italian\";i:1;s:21:\"task-assigned-italian\";i:1;s:30:\"task-added-as-follower-italian\";i:1;s:22:\"task-commented-italian\";i:1;s:29:\"task-added-attachment-italian\";i:1;s:34:\"estimate-declined-to-staff-italian\";i:1;s:34:\"estimate-accepted-to-staff-italian\";i:1;s:32:\"proposal-client-accepted-italian\";i:1;s:33:\"proposal-send-to-customer-italian\";i:1;s:32:\"proposal-client-declined-italian\";i:1;s:33:\"proposal-client-thank-you-italian\";i:1;s:34:\"proposal-comment-to-client-italian\";i:1;s:33:\"proposal-comment-to-admin-italian\";i:1;s:38:\"estimate-thank-you-to-customer-italian\";i:1;s:34:\"task-deadline-notification-italian\";i:1;s:21:\"send-contract-italian\";i:1;s:41:\"invoice-payment-recorded-to-staff-italian\";i:1;s:25:\"auto-close-ticket-italian\";i:1;s:47:\"new-project-discussion-created-to-staff-italian\";i:1;s:50:\"new-project-discussion-created-to-customer-italian\";i:1;s:45:\"new-project-file-uploaded-to-customer-italian\";i:1;s:42:\"new-project-file-uploaded-to-staff-italian\";i:1;s:50:\"new-project-discussion-comment-to-customer-italian\";i:1;s:47:\"new-project-discussion-comment-to-staff-italian\";i:1;s:37:\"staff-added-as-project-member-italian\";i:1;s:32:\"estimate-expiry-reminder-italian\";i:1;s:32:\"proposal-expiry-reminder-italian\";i:1;s:25:\"new-staff-created-italian\";i:1;s:31:\"contact-forgot-password-italian\";i:1;s:32:\"contact-password-reseted-italian\";i:1;s:28:\"contact-set-password-italian\";i:1;s:29:\"staff-forgot-password-italian\";i:1;s:30:\"staff-password-reseted-italian\";i:1;s:27:\"assigned-to-project-italian\";i:1;s:41:\"task-added-attachment-to-contacts-italian\";i:1;s:34:\"task-commented-to-contacts-italian\";i:1;s:25:\"new-lead-assigned-italian\";i:1;s:24:\"client-statement-italian\";i:1;s:32:\"ticket-assigned-to-admin-italian\";i:1;s:38:\"new-client-registered-to-admin-italian\";i:1;s:38:\"new-web-to-lead-form-submitted-italian\";i:1;s:33:\"two-factor-authentication-italian\";i:1;s:36:\"project-finished-to-customer-italian\";i:1;s:34:\"credit-note-send-to-client-italian\";i:1;s:35:\"task-status-change-to-staff-italian\";i:1;s:38:\"task-status-change-to-contacts-italian\";i:1;s:28:\"reminder-email-staff-italian\";i:1;s:34:\"contract-comment-to-client-italian\";i:1;s:33:\"contract-comment-to-admin-italian\";i:1;s:25:\"send-subscription-italian\";i:1;s:35:\"subscription-payment-failed-italian\";i:1;s:29:\"subscription-canceled-italian\";i:1;s:38:\"subscription-payment-succeeded-italian\";i:1;s:36:\"contract-expiration-to-staff-italian\";i:1;s:28:\"gdpr-removal-request-italian\";i:1;s:33:\"gdpr-removal-request-lead-italian\";i:1;s:37:\"client-registration-confirmed-italian\";i:1;s:32:\"contract-signed-to-staff-italian\";i:1;s:36:\"customer-subscribed-to-staff-italian\";i:1;s:34:\"contact-verification-email-italian\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-italian\";i:1;s:35:\"event-notification-to-staff-italian\";i:1;s:27:\"new-client-created-japanese\";i:1;s:31:\"invoice-send-to-client-japanese\";i:1;s:32:\"new-ticket-opened-admin-japanese\";i:1;s:21:\"ticket-reply-japanese\";i:1;s:28:\"ticket-autoresponse-japanese\";i:1;s:33:\"invoice-payment-recorded-japanese\";i:1;s:31:\"invoice-overdue-notice-japanese\";i:1;s:29:\"invoice-already-send-japanese\";i:1;s:33:\"new-ticket-created-staff-japanese\";i:1;s:32:\"estimate-send-to-client-japanese\";i:1;s:30:\"ticket-reply-to-admin-japanese\";i:1;s:30:\"estimate-already-send-japanese\";i:1;s:28:\"contract-expiration-japanese\";i:1;s:22:\"task-assigned-japanese\";i:1;s:31:\"task-added-as-follower-japanese\";i:1;s:23:\"task-commented-japanese\";i:1;s:30:\"task-added-attachment-japanese\";i:1;s:35:\"estimate-declined-to-staff-japanese\";i:1;s:35:\"estimate-accepted-to-staff-japanese\";i:1;s:33:\"proposal-client-accepted-japanese\";i:1;s:34:\"proposal-send-to-customer-japanese\";i:1;s:33:\"proposal-client-declined-japanese\";i:1;s:34:\"proposal-client-thank-you-japanese\";i:1;s:35:\"proposal-comment-to-client-japanese\";i:1;s:34:\"proposal-comment-to-admin-japanese\";i:1;s:39:\"estimate-thank-you-to-customer-japanese\";i:1;s:35:\"task-deadline-notification-japanese\";i:1;s:22:\"send-contract-japanese\";i:1;s:42:\"invoice-payment-recorded-to-staff-japanese\";i:1;s:26:\"auto-close-ticket-japanese\";i:1;s:48:\"new-project-discussion-created-to-staff-japanese\";i:1;s:51:\"new-project-discussion-created-to-customer-japanese\";i:1;s:46:\"new-project-file-uploaded-to-customer-japanese\";i:1;s:43:\"new-project-file-uploaded-to-staff-japanese\";i:1;s:51:\"new-project-discussion-comment-to-customer-japanese\";i:1;s:48:\"new-project-discussion-comment-to-staff-japanese\";i:1;s:38:\"staff-added-as-project-member-japanese\";i:1;s:33:\"estimate-expiry-reminder-japanese\";i:1;s:33:\"proposal-expiry-reminder-japanese\";i:1;s:26:\"new-staff-created-japanese\";i:1;s:32:\"contact-forgot-password-japanese\";i:1;s:33:\"contact-password-reseted-japanese\";i:1;s:29:\"contact-set-password-japanese\";i:1;s:30:\"staff-forgot-password-japanese\";i:1;s:31:\"staff-password-reseted-japanese\";i:1;s:28:\"assigned-to-project-japanese\";i:1;s:42:\"task-added-attachment-to-contacts-japanese\";i:1;s:35:\"task-commented-to-contacts-japanese\";i:1;s:26:\"new-lead-assigned-japanese\";i:1;s:25:\"client-statement-japanese\";i:1;s:33:\"ticket-assigned-to-admin-japanese\";i:1;s:39:\"new-client-registered-to-admin-japanese\";i:1;s:39:\"new-web-to-lead-form-submitted-japanese\";i:1;s:34:\"two-factor-authentication-japanese\";i:1;s:37:\"project-finished-to-customer-japanese\";i:1;s:35:\"credit-note-send-to-client-japanese\";i:1;s:36:\"task-status-change-to-staff-japanese\";i:1;s:39:\"task-status-change-to-contacts-japanese\";i:1;s:29:\"reminder-email-staff-japanese\";i:1;s:35:\"contract-comment-to-client-japanese\";i:1;s:34:\"contract-comment-to-admin-japanese\";i:1;s:26:\"send-subscription-japanese\";i:1;s:36:\"subscription-payment-failed-japanese\";i:1;s:30:\"subscription-canceled-japanese\";i:1;s:39:\"subscription-payment-succeeded-japanese\";i:1;s:37:\"contract-expiration-to-staff-japanese\";i:1;s:29:\"gdpr-removal-request-japanese\";i:1;s:34:\"gdpr-removal-request-lead-japanese\";i:1;s:38:\"client-registration-confirmed-japanese\";i:1;s:33:\"contract-signed-to-staff-japanese\";i:1;s:37:\"customer-subscribed-to-staff-japanese\";i:1;s:35:\"contact-verification-email-japanese\";i:1;s:52:\"new-customer-profile-file-uploaded-to-staff-japanese\";i:1;s:36:\"event-notification-to-staff-japanese\";i:1;s:26:\"new-client-created-persian\";i:1;s:30:\"invoice-send-to-client-persian\";i:1;s:31:\"new-ticket-opened-admin-persian\";i:1;s:20:\"ticket-reply-persian\";i:1;s:27:\"ticket-autoresponse-persian\";i:1;s:32:\"invoice-payment-recorded-persian\";i:1;s:30:\"invoice-overdue-notice-persian\";i:1;s:28:\"invoice-already-send-persian\";i:1;s:32:\"new-ticket-created-staff-persian\";i:1;s:31:\"estimate-send-to-client-persian\";i:1;s:29:\"ticket-reply-to-admin-persian\";i:1;s:29:\"estimate-already-send-persian\";i:1;s:27:\"contract-expiration-persian\";i:1;s:21:\"task-assigned-persian\";i:1;s:30:\"task-added-as-follower-persian\";i:1;s:22:\"task-commented-persian\";i:1;s:29:\"task-added-attachment-persian\";i:1;s:34:\"estimate-declined-to-staff-persian\";i:1;s:34:\"estimate-accepted-to-staff-persian\";i:1;s:32:\"proposal-client-accepted-persian\";i:1;s:33:\"proposal-send-to-customer-persian\";i:1;s:32:\"proposal-client-declined-persian\";i:1;s:33:\"proposal-client-thank-you-persian\";i:1;s:34:\"proposal-comment-to-client-persian\";i:1;s:33:\"proposal-comment-to-admin-persian\";i:1;s:38:\"estimate-thank-you-to-customer-persian\";i:1;s:34:\"task-deadline-notification-persian\";i:1;s:21:\"send-contract-persian\";i:1;s:41:\"invoice-payment-recorded-to-staff-persian\";i:1;s:25:\"auto-close-ticket-persian\";i:1;s:47:\"new-project-discussion-created-to-staff-persian\";i:1;s:50:\"new-project-discussion-created-to-customer-persian\";i:1;s:45:\"new-project-file-uploaded-to-customer-persian\";i:1;s:42:\"new-project-file-uploaded-to-staff-persian\";i:1;s:50:\"new-project-discussion-comment-to-customer-persian\";i:1;s:47:\"new-project-discussion-comment-to-staff-persian\";i:1;s:37:\"staff-added-as-project-member-persian\";i:1;s:32:\"estimate-expiry-reminder-persian\";i:1;s:32:\"proposal-expiry-reminder-persian\";i:1;s:25:\"new-staff-created-persian\";i:1;s:31:\"contact-forgot-password-persian\";i:1;s:32:\"contact-password-reseted-persian\";i:1;s:28:\"contact-set-password-persian\";i:1;s:29:\"staff-forgot-password-persian\";i:1;s:30:\"staff-password-reseted-persian\";i:1;s:27:\"assigned-to-project-persian\";i:1;s:41:\"task-added-attachment-to-contacts-persian\";i:1;s:34:\"task-commented-to-contacts-persian\";i:1;s:25:\"new-lead-assigned-persian\";i:1;s:24:\"client-statement-persian\";i:1;s:32:\"ticket-assigned-to-admin-persian\";i:1;s:38:\"new-client-registered-to-admin-persian\";i:1;s:38:\"new-web-to-lead-form-submitted-persian\";i:1;s:33:\"two-factor-authentication-persian\";i:1;s:36:\"project-finished-to-customer-persian\";i:1;s:34:\"credit-note-send-to-client-persian\";i:1;s:35:\"task-status-change-to-staff-persian\";i:1;s:38:\"task-status-change-to-contacts-persian\";i:1;s:28:\"reminder-email-staff-persian\";i:1;s:34:\"contract-comment-to-client-persian\";i:1;s:33:\"contract-comment-to-admin-persian\";i:1;s:25:\"send-subscription-persian\";i:1;s:35:\"subscription-payment-failed-persian\";i:1;s:29:\"subscription-canceled-persian\";i:1;s:38:\"subscription-payment-succeeded-persian\";i:1;s:36:\"contract-expiration-to-staff-persian\";i:1;s:28:\"gdpr-removal-request-persian\";i:1;s:33:\"gdpr-removal-request-lead-persian\";i:1;s:37:\"client-registration-confirmed-persian\";i:1;s:32:\"contract-signed-to-staff-persian\";i:1;s:36:\"customer-subscribed-to-staff-persian\";i:1;s:34:\"contact-verification-email-persian\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-persian\";i:1;s:35:\"event-notification-to-staff-persian\";i:1;s:25:\"new-client-created-polish\";i:1;s:29:\"invoice-send-to-client-polish\";i:1;s:30:\"new-ticket-opened-admin-polish\";i:1;s:19:\"ticket-reply-polish\";i:1;s:26:\"ticket-autoresponse-polish\";i:1;s:31:\"invoice-payment-recorded-polish\";i:1;s:29:\"invoice-overdue-notice-polish\";i:1;s:27:\"invoice-already-send-polish\";i:1;s:31:\"new-ticket-created-staff-polish\";i:1;s:30:\"estimate-send-to-client-polish\";i:1;s:28:\"ticket-reply-to-admin-polish\";i:1;s:28:\"estimate-already-send-polish\";i:1;s:26:\"contract-expiration-polish\";i:1;s:20:\"task-assigned-polish\";i:1;s:29:\"task-added-as-follower-polish\";i:1;s:21:\"task-commented-polish\";i:1;s:28:\"task-added-attachment-polish\";i:1;s:33:\"estimate-declined-to-staff-polish\";i:1;s:33:\"estimate-accepted-to-staff-polish\";i:1;s:31:\"proposal-client-accepted-polish\";i:1;s:32:\"proposal-send-to-customer-polish\";i:1;s:31:\"proposal-client-declined-polish\";i:1;s:32:\"proposal-client-thank-you-polish\";i:1;s:33:\"proposal-comment-to-client-polish\";i:1;s:32:\"proposal-comment-to-admin-polish\";i:1;s:37:\"estimate-thank-you-to-customer-polish\";i:1;s:33:\"task-deadline-notification-polish\";i:1;s:20:\"send-contract-polish\";i:1;s:40:\"invoice-payment-recorded-to-staff-polish\";i:1;s:24:\"auto-close-ticket-polish\";i:1;s:46:\"new-project-discussion-created-to-staff-polish\";i:1;s:49:\"new-project-discussion-created-to-customer-polish\";i:1;s:44:\"new-project-file-uploaded-to-customer-polish\";i:1;s:41:\"new-project-file-uploaded-to-staff-polish\";i:1;s:49:\"new-project-discussion-comment-to-customer-polish\";i:1;s:46:\"new-project-discussion-comment-to-staff-polish\";i:1;s:36:\"staff-added-as-project-member-polish\";i:1;s:31:\"estimate-expiry-reminder-polish\";i:1;s:31:\"proposal-expiry-reminder-polish\";i:1;s:24:\"new-staff-created-polish\";i:1;s:30:\"contact-forgot-password-polish\";i:1;s:31:\"contact-password-reseted-polish\";i:1;s:27:\"contact-set-password-polish\";i:1;s:28:\"staff-forgot-password-polish\";i:1;s:29:\"staff-password-reseted-polish\";i:1;s:26:\"assigned-to-project-polish\";i:1;s:40:\"task-added-attachment-to-contacts-polish\";i:1;s:33:\"task-commented-to-contacts-polish\";i:1;s:24:\"new-lead-assigned-polish\";i:1;s:23:\"client-statement-polish\";i:1;s:31:\"ticket-assigned-to-admin-polish\";i:1;s:37:\"new-client-registered-to-admin-polish\";i:1;s:37:\"new-web-to-lead-form-submitted-polish\";i:1;s:32:\"two-factor-authentication-polish\";i:1;s:35:\"project-finished-to-customer-polish\";i:1;s:33:\"credit-note-send-to-client-polish\";i:1;s:34:\"task-status-change-to-staff-polish\";i:1;s:37:\"task-status-change-to-contacts-polish\";i:1;s:27:\"reminder-email-staff-polish\";i:1;s:33:\"contract-comment-to-client-polish\";i:1;s:32:\"contract-comment-to-admin-polish\";i:1;s:24:\"send-subscription-polish\";i:1;s:34:\"subscription-payment-failed-polish\";i:1;s:28:\"subscription-canceled-polish\";i:1;s:37:\"subscription-payment-succeeded-polish\";i:1;s:35:\"contract-expiration-to-staff-polish\";i:1;s:27:\"gdpr-removal-request-polish\";i:1;s:32:\"gdpr-removal-request-lead-polish\";i:1;s:36:\"client-registration-confirmed-polish\";i:1;s:31:\"contract-signed-to-staff-polish\";i:1;s:35:\"customer-subscribed-to-staff-polish\";i:1;s:33:\"contact-verification-email-polish\";i:1;s:50:\"new-customer-profile-file-uploaded-to-staff-polish\";i:1;s:34:\"event-notification-to-staff-polish\";i:1;s:29:\"new-client-created-portuguese\";i:1;s:33:\"invoice-send-to-client-portuguese\";i:1;s:34:\"new-ticket-opened-admin-portuguese\";i:1;s:23:\"ticket-reply-portuguese\";i:1;s:30:\"ticket-autoresponse-portuguese\";i:1;s:35:\"invoice-payment-recorded-portuguese\";i:1;s:33:\"invoice-overdue-notice-portuguese\";i:1;s:31:\"invoice-already-send-portuguese\";i:1;s:35:\"new-ticket-created-staff-portuguese\";i:1;s:34:\"estimate-send-to-client-portuguese\";i:1;s:32:\"ticket-reply-to-admin-portuguese\";i:1;s:32:\"estimate-already-send-portuguese\";i:1;s:30:\"contract-expiration-portuguese\";i:1;s:24:\"task-assigned-portuguese\";i:1;s:33:\"task-added-as-follower-portuguese\";i:1;s:25:\"task-commented-portuguese\";i:1;s:32:\"task-added-attachment-portuguese\";i:1;s:37:\"estimate-declined-to-staff-portuguese\";i:1;s:37:\"estimate-accepted-to-staff-portuguese\";i:1;s:35:\"proposal-client-accepted-portuguese\";i:1;s:36:\"proposal-send-to-customer-portuguese\";i:1;s:35:\"proposal-client-declined-portuguese\";i:1;s:36:\"proposal-client-thank-you-portuguese\";i:1;s:37:\"proposal-comment-to-client-portuguese\";i:1;s:36:\"proposal-comment-to-admin-portuguese\";i:1;s:41:\"estimate-thank-you-to-customer-portuguese\";i:1;s:37:\"task-deadline-notification-portuguese\";i:1;s:24:\"send-contract-portuguese\";i:1;s:44:\"invoice-payment-recorded-to-staff-portuguese\";i:1;s:28:\"auto-close-ticket-portuguese\";i:1;s:50:\"new-project-discussion-created-to-staff-portuguese\";i:1;s:53:\"new-project-discussion-created-to-customer-portuguese\";i:1;s:48:\"new-project-file-uploaded-to-customer-portuguese\";i:1;s:45:\"new-project-file-uploaded-to-staff-portuguese\";i:1;s:53:\"new-project-discussion-comment-to-customer-portuguese\";i:1;s:50:\"new-project-discussion-comment-to-staff-portuguese\";i:1;s:40:\"staff-added-as-project-member-portuguese\";i:1;s:35:\"estimate-expiry-reminder-portuguese\";i:1;s:35:\"proposal-expiry-reminder-portuguese\";i:1;s:28:\"new-staff-created-portuguese\";i:1;s:34:\"contact-forgot-password-portuguese\";i:1;s:35:\"contact-password-reseted-portuguese\";i:1;s:31:\"contact-set-password-portuguese\";i:1;s:32:\"staff-forgot-password-portuguese\";i:1;s:33:\"staff-password-reseted-portuguese\";i:1;s:30:\"assigned-to-project-portuguese\";i:1;s:44:\"task-added-attachment-to-contacts-portuguese\";i:1;s:37:\"task-commented-to-contacts-portuguese\";i:1;s:28:\"new-lead-assigned-portuguese\";i:1;s:27:\"client-statement-portuguese\";i:1;s:35:\"ticket-assigned-to-admin-portuguese\";i:1;s:41:\"new-client-registered-to-admin-portuguese\";i:1;s:41:\"new-web-to-lead-form-submitted-portuguese\";i:1;s:36:\"two-factor-authentication-portuguese\";i:1;s:39:\"project-finished-to-customer-portuguese\";i:1;s:37:\"credit-note-send-to-client-portuguese\";i:1;s:38:\"task-status-change-to-staff-portuguese\";i:1;s:41:\"task-status-change-to-contacts-portuguese\";i:1;s:31:\"reminder-email-staff-portuguese\";i:1;s:37:\"contract-comment-to-client-portuguese\";i:1;s:36:\"contract-comment-to-admin-portuguese\";i:1;s:28:\"send-subscription-portuguese\";i:1;s:38:\"subscription-payment-failed-portuguese\";i:1;s:32:\"subscription-canceled-portuguese\";i:1;s:41:\"subscription-payment-succeeded-portuguese\";i:1;s:39:\"contract-expiration-to-staff-portuguese\";i:1;s:31:\"gdpr-removal-request-portuguese\";i:1;s:36:\"gdpr-removal-request-lead-portuguese\";i:1;s:40:\"client-registration-confirmed-portuguese\";i:1;s:35:\"contract-signed-to-staff-portuguese\";i:1;s:39:\"customer-subscribed-to-staff-portuguese\";i:1;s:37:\"contact-verification-email-portuguese\";i:1;s:54:\"new-customer-profile-file-uploaded-to-staff-portuguese\";i:1;s:38:\"event-notification-to-staff-portuguese\";i:1;s:32:\"new-client-created-portuguese_br\";i:1;s:36:\"invoice-send-to-client-portuguese_br\";i:1;s:37:\"new-ticket-opened-admin-portuguese_br\";i:1;s:26:\"ticket-reply-portuguese_br\";i:1;s:33:\"ticket-autoresponse-portuguese_br\";i:1;s:38:\"invoice-payment-recorded-portuguese_br\";i:1;s:36:\"invoice-overdue-notice-portuguese_br\";i:1;s:34:\"invoice-already-send-portuguese_br\";i:1;s:38:\"new-ticket-created-staff-portuguese_br\";i:1;s:37:\"estimate-send-to-client-portuguese_br\";i:1;s:35:\"ticket-reply-to-admin-portuguese_br\";i:1;s:35:\"estimate-already-send-portuguese_br\";i:1;s:33:\"contract-expiration-portuguese_br\";i:1;s:27:\"task-assigned-portuguese_br\";i:1;s:36:\"task-added-as-follower-portuguese_br\";i:1;s:28:\"task-commented-portuguese_br\";i:1;s:35:\"task-added-attachment-portuguese_br\";i:1;s:40:\"estimate-declined-to-staff-portuguese_br\";i:1;s:40:\"estimate-accepted-to-staff-portuguese_br\";i:1;s:38:\"proposal-client-accepted-portuguese_br\";i:1;s:39:\"proposal-send-to-customer-portuguese_br\";i:1;s:38:\"proposal-client-declined-portuguese_br\";i:1;s:39:\"proposal-client-thank-you-portuguese_br\";i:1;s:40:\"proposal-comment-to-client-portuguese_br\";i:1;s:39:\"proposal-comment-to-admin-portuguese_br\";i:1;s:44:\"estimate-thank-you-to-customer-portuguese_br\";i:1;s:40:\"task-deadline-notification-portuguese_br\";i:1;s:27:\"send-contract-portuguese_br\";i:1;s:47:\"invoice-payment-recorded-to-staff-portuguese_br\";i:1;s:31:\"auto-close-ticket-portuguese_br\";i:1;s:53:\"new-project-discussion-created-to-staff-portuguese_br\";i:1;s:56:\"new-project-discussion-created-to-customer-portuguese_br\";i:1;s:51:\"new-project-file-uploaded-to-customer-portuguese_br\";i:1;s:48:\"new-project-file-uploaded-to-staff-portuguese_br\";i:1;s:56:\"new-project-discussion-comment-to-customer-portuguese_br\";i:1;s:53:\"new-project-discussion-comment-to-staff-portuguese_br\";i:1;s:43:\"staff-added-as-project-member-portuguese_br\";i:1;s:38:\"estimate-expiry-reminder-portuguese_br\";i:1;s:38:\"proposal-expiry-reminder-portuguese_br\";i:1;s:31:\"new-staff-created-portuguese_br\";i:1;s:37:\"contact-forgot-password-portuguese_br\";i:1;s:38:\"contact-password-reseted-portuguese_br\";i:1;s:34:\"contact-set-password-portuguese_br\";i:1;s:35:\"staff-forgot-password-portuguese_br\";i:1;s:36:\"staff-password-reseted-portuguese_br\";i:1;s:33:\"assigned-to-project-portuguese_br\";i:1;s:47:\"task-added-attachment-to-contacts-portuguese_br\";i:1;s:40:\"task-commented-to-contacts-portuguese_br\";i:1;s:31:\"new-lead-assigned-portuguese_br\";i:1;s:30:\"client-statement-portuguese_br\";i:1;s:38:\"ticket-assigned-to-admin-portuguese_br\";i:1;s:44:\"new-client-registered-to-admin-portuguese_br\";i:1;s:44:\"new-web-to-lead-form-submitted-portuguese_br\";i:1;s:39:\"two-factor-authentication-portuguese_br\";i:1;s:42:\"project-finished-to-customer-portuguese_br\";i:1;s:40:\"credit-note-send-to-client-portuguese_br\";i:1;s:41:\"task-status-change-to-staff-portuguese_br\";i:1;s:44:\"task-status-change-to-contacts-portuguese_br\";i:1;s:34:\"reminder-email-staff-portuguese_br\";i:1;s:40:\"contract-comment-to-client-portuguese_br\";i:1;s:39:\"contract-comment-to-admin-portuguese_br\";i:1;s:31:\"send-subscription-portuguese_br\";i:1;s:41:\"subscription-payment-failed-portuguese_br\";i:1;s:35:\"subscription-canceled-portuguese_br\";i:1;s:44:\"subscription-payment-succeeded-portuguese_br\";i:1;s:42:\"contract-expiration-to-staff-portuguese_br\";i:1;s:34:\"gdpr-removal-request-portuguese_br\";i:1;s:39:\"gdpr-removal-request-lead-portuguese_br\";i:1;s:43:\"client-registration-confirmed-portuguese_br\";i:1;s:38:\"contract-signed-to-staff-portuguese_br\";i:1;s:42:\"customer-subscribed-to-staff-portuguese_br\";i:1;s:40:\"contact-verification-email-portuguese_br\";i:1;s:57:\"new-customer-profile-file-uploaded-to-staff-portuguese_br\";i:1;s:41:\"event-notification-to-staff-portuguese_br\";i:1;s:27:\"new-client-created-romanian\";i:1;s:31:\"invoice-send-to-client-romanian\";i:1;s:32:\"new-ticket-opened-admin-romanian\";i:1;s:21:\"ticket-reply-romanian\";i:1;s:28:\"ticket-autoresponse-romanian\";i:1;s:33:\"invoice-payment-recorded-romanian\";i:1;s:31:\"invoice-overdue-notice-romanian\";i:1;s:29:\"invoice-already-send-romanian\";i:1;s:33:\"new-ticket-created-staff-romanian\";i:1;s:32:\"estimate-send-to-client-romanian\";i:1;s:30:\"ticket-reply-to-admin-romanian\";i:1;s:30:\"estimate-already-send-romanian\";i:1;s:28:\"contract-expiration-romanian\";i:1;s:22:\"task-assigned-romanian\";i:1;s:31:\"task-added-as-follower-romanian\";i:1;s:23:\"task-commented-romanian\";i:1;s:30:\"task-added-attachment-romanian\";i:1;s:35:\"estimate-declined-to-staff-romanian\";i:1;s:35:\"estimate-accepted-to-staff-romanian\";i:1;s:33:\"proposal-client-accepted-romanian\";i:1;s:34:\"proposal-send-to-customer-romanian\";i:1;s:33:\"proposal-client-declined-romanian\";i:1;s:34:\"proposal-client-thank-you-romanian\";i:1;s:35:\"proposal-comment-to-client-romanian\";i:1;s:34:\"proposal-comment-to-admin-romanian\";i:1;s:39:\"estimate-thank-you-to-customer-romanian\";i:1;s:35:\"task-deadline-notification-romanian\";i:1;s:22:\"send-contract-romanian\";i:1;s:42:\"invoice-payment-recorded-to-staff-romanian\";i:1;s:26:\"auto-close-ticket-romanian\";i:1;s:48:\"new-project-discussion-created-to-staff-romanian\";i:1;s:51:\"new-project-discussion-created-to-customer-romanian\";i:1;s:46:\"new-project-file-uploaded-to-customer-romanian\";i:1;s:43:\"new-project-file-uploaded-to-staff-romanian\";i:1;s:51:\"new-project-discussion-comment-to-customer-romanian\";i:1;s:48:\"new-project-discussion-comment-to-staff-romanian\";i:1;s:38:\"staff-added-as-project-member-romanian\";i:1;s:33:\"estimate-expiry-reminder-romanian\";i:1;s:33:\"proposal-expiry-reminder-romanian\";i:1;s:26:\"new-staff-created-romanian\";i:1;s:32:\"contact-forgot-password-romanian\";i:1;s:33:\"contact-password-reseted-romanian\";i:1;s:29:\"contact-set-password-romanian\";i:1;s:30:\"staff-forgot-password-romanian\";i:1;s:31:\"staff-password-reseted-romanian\";i:1;s:28:\"assigned-to-project-romanian\";i:1;s:42:\"task-added-attachment-to-contacts-romanian\";i:1;s:35:\"task-commented-to-contacts-romanian\";i:1;s:26:\"new-lead-assigned-romanian\";i:1;s:25:\"client-statement-romanian\";i:1;s:33:\"ticket-assigned-to-admin-romanian\";i:1;s:39:\"new-client-registered-to-admin-romanian\";i:1;s:39:\"new-web-to-lead-form-submitted-romanian\";i:1;s:34:\"two-factor-authentication-romanian\";i:1;s:37:\"project-finished-to-customer-romanian\";i:1;s:35:\"credit-note-send-to-client-romanian\";i:1;s:36:\"task-status-change-to-staff-romanian\";i:1;s:39:\"task-status-change-to-contacts-romanian\";i:1;s:29:\"reminder-email-staff-romanian\";i:1;s:35:\"contract-comment-to-client-romanian\";i:1;s:34:\"contract-comment-to-admin-romanian\";i:1;s:26:\"send-subscription-romanian\";i:1;s:36:\"subscription-payment-failed-romanian\";i:1;s:30:\"subscription-canceled-romanian\";i:1;s:39:\"subscription-payment-succeeded-romanian\";i:1;s:37:\"contract-expiration-to-staff-romanian\";i:1;s:29:\"gdpr-removal-request-romanian\";i:1;s:34:\"gdpr-removal-request-lead-romanian\";i:1;s:38:\"client-registration-confirmed-romanian\";i:1;s:33:\"contract-signed-to-staff-romanian\";i:1;s:37:\"customer-subscribed-to-staff-romanian\";i:1;s:35:\"contact-verification-email-romanian\";i:1;s:52:\"new-customer-profile-file-uploaded-to-staff-romanian\";i:1;s:36:\"event-notification-to-staff-romanian\";i:1;s:26:\"new-client-created-russian\";i:1;s:30:\"invoice-send-to-client-russian\";i:1;s:31:\"new-ticket-opened-admin-russian\";i:1;s:20:\"ticket-reply-russian\";i:1;s:27:\"ticket-autoresponse-russian\";i:1;s:32:\"invoice-payment-recorded-russian\";i:1;s:30:\"invoice-overdue-notice-russian\";i:1;s:28:\"invoice-already-send-russian\";i:1;s:32:\"new-ticket-created-staff-russian\";i:1;s:31:\"estimate-send-to-client-russian\";i:1;s:29:\"ticket-reply-to-admin-russian\";i:1;s:29:\"estimate-already-send-russian\";i:1;s:27:\"contract-expiration-russian\";i:1;s:21:\"task-assigned-russian\";i:1;s:30:\"task-added-as-follower-russian\";i:1;s:22:\"task-commented-russian\";i:1;s:29:\"task-added-attachment-russian\";i:1;s:34:\"estimate-declined-to-staff-russian\";i:1;s:34:\"estimate-accepted-to-staff-russian\";i:1;s:32:\"proposal-client-accepted-russian\";i:1;s:33:\"proposal-send-to-customer-russian\";i:1;s:32:\"proposal-client-declined-russian\";i:1;s:33:\"proposal-client-thank-you-russian\";i:1;s:34:\"proposal-comment-to-client-russian\";i:1;s:33:\"proposal-comment-to-admin-russian\";i:1;s:38:\"estimate-thank-you-to-customer-russian\";i:1;s:34:\"task-deadline-notification-russian\";i:1;s:21:\"send-contract-russian\";i:1;s:41:\"invoice-payment-recorded-to-staff-russian\";i:1;s:25:\"auto-close-ticket-russian\";i:1;s:47:\"new-project-discussion-created-to-staff-russian\";i:1;s:50:\"new-project-discussion-created-to-customer-russian\";i:1;s:45:\"new-project-file-uploaded-to-customer-russian\";i:1;s:42:\"new-project-file-uploaded-to-staff-russian\";i:1;s:50:\"new-project-discussion-comment-to-customer-russian\";i:1;s:47:\"new-project-discussion-comment-to-staff-russian\";i:1;s:37:\"staff-added-as-project-member-russian\";i:1;s:32:\"estimate-expiry-reminder-russian\";i:1;s:32:\"proposal-expiry-reminder-russian\";i:1;s:25:\"new-staff-created-russian\";i:1;s:31:\"contact-forgot-password-russian\";i:1;s:32:\"contact-password-reseted-russian\";i:1;s:28:\"contact-set-password-russian\";i:1;s:29:\"staff-forgot-password-russian\";i:1;s:30:\"staff-password-reseted-russian\";i:1;s:27:\"assigned-to-project-russian\";i:1;s:41:\"task-added-attachment-to-contacts-russian\";i:1;s:34:\"task-commented-to-contacts-russian\";i:1;s:25:\"new-lead-assigned-russian\";i:1;s:24:\"client-statement-russian\";i:1;s:32:\"ticket-assigned-to-admin-russian\";i:1;s:38:\"new-client-registered-to-admin-russian\";i:1;s:38:\"new-web-to-lead-form-submitted-russian\";i:1;s:33:\"two-factor-authentication-russian\";i:1;s:36:\"project-finished-to-customer-russian\";i:1;s:34:\"credit-note-send-to-client-russian\";i:1;s:35:\"task-status-change-to-staff-russian\";i:1;s:38:\"task-status-change-to-contacts-russian\";i:1;s:28:\"reminder-email-staff-russian\";i:1;s:34:\"contract-comment-to-client-russian\";i:1;s:33:\"contract-comment-to-admin-russian\";i:1;s:25:\"send-subscription-russian\";i:1;s:35:\"subscription-payment-failed-russian\";i:1;s:29:\"subscription-canceled-russian\";i:1;s:38:\"subscription-payment-succeeded-russian\";i:1;s:36:\"contract-expiration-to-staff-russian\";i:1;s:28:\"gdpr-removal-request-russian\";i:1;s:33:\"gdpr-removal-request-lead-russian\";i:1;s:37:\"client-registration-confirmed-russian\";i:1;s:32:\"contract-signed-to-staff-russian\";i:1;s:36:\"customer-subscribed-to-staff-russian\";i:1;s:34:\"contact-verification-email-russian\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-russian\";i:1;s:35:\"event-notification-to-staff-russian\";i:1;s:25:\"new-client-created-slovak\";i:1;s:29:\"invoice-send-to-client-slovak\";i:1;s:30:\"new-ticket-opened-admin-slovak\";i:1;s:19:\"ticket-reply-slovak\";i:1;s:26:\"ticket-autoresponse-slovak\";i:1;s:31:\"invoice-payment-recorded-slovak\";i:1;s:29:\"invoice-overdue-notice-slovak\";i:1;s:27:\"invoice-already-send-slovak\";i:1;s:31:\"new-ticket-created-staff-slovak\";i:1;s:30:\"estimate-send-to-client-slovak\";i:1;s:28:\"ticket-reply-to-admin-slovak\";i:1;s:28:\"estimate-already-send-slovak\";i:1;s:26:\"contract-expiration-slovak\";i:1;s:20:\"task-assigned-slovak\";i:1;s:29:\"task-added-as-follower-slovak\";i:1;s:21:\"task-commented-slovak\";i:1;s:28:\"task-added-attachment-slovak\";i:1;s:33:\"estimate-declined-to-staff-slovak\";i:1;s:33:\"estimate-accepted-to-staff-slovak\";i:1;s:31:\"proposal-client-accepted-slovak\";i:1;s:32:\"proposal-send-to-customer-slovak\";i:1;s:31:\"proposal-client-declined-slovak\";i:1;s:32:\"proposal-client-thank-you-slovak\";i:1;s:33:\"proposal-comment-to-client-slovak\";i:1;s:32:\"proposal-comment-to-admin-slovak\";i:1;s:37:\"estimate-thank-you-to-customer-slovak\";i:1;s:33:\"task-deadline-notification-slovak\";i:1;s:20:\"send-contract-slovak\";i:1;s:40:\"invoice-payment-recorded-to-staff-slovak\";i:1;s:24:\"auto-close-ticket-slovak\";i:1;s:46:\"new-project-discussion-created-to-staff-slovak\";i:1;s:49:\"new-project-discussion-created-to-customer-slovak\";i:1;s:44:\"new-project-file-uploaded-to-customer-slovak\";i:1;s:41:\"new-project-file-uploaded-to-staff-slovak\";i:1;s:49:\"new-project-discussion-comment-to-customer-slovak\";i:1;s:46:\"new-project-discussion-comment-to-staff-slovak\";i:1;s:36:\"staff-added-as-project-member-slovak\";i:1;s:31:\"estimate-expiry-reminder-slovak\";i:1;s:31:\"proposal-expiry-reminder-slovak\";i:1;s:24:\"new-staff-created-slovak\";i:1;s:30:\"contact-forgot-password-slovak\";i:1;s:31:\"contact-password-reseted-slovak\";i:1;s:27:\"contact-set-password-slovak\";i:1;s:28:\"staff-forgot-password-slovak\";i:1;s:29:\"staff-password-reseted-slovak\";i:1;s:26:\"assigned-to-project-slovak\";i:1;s:40:\"task-added-attachment-to-contacts-slovak\";i:1;s:33:\"task-commented-to-contacts-slovak\";i:1;s:24:\"new-lead-assigned-slovak\";i:1;s:23:\"client-statement-slovak\";i:1;s:31:\"ticket-assigned-to-admin-slovak\";i:1;s:37:\"new-client-registered-to-admin-slovak\";i:1;s:37:\"new-web-to-lead-form-submitted-slovak\";i:1;s:32:\"two-factor-authentication-slovak\";i:1;s:35:\"project-finished-to-customer-slovak\";i:1;s:33:\"credit-note-send-to-client-slovak\";i:1;s:34:\"task-status-change-to-staff-slovak\";i:1;s:37:\"task-status-change-to-contacts-slovak\";i:1;s:27:\"reminder-email-staff-slovak\";i:1;s:33:\"contract-comment-to-client-slovak\";i:1;s:32:\"contract-comment-to-admin-slovak\";i:1;s:24:\"send-subscription-slovak\";i:1;s:34:\"subscription-payment-failed-slovak\";i:1;s:28:\"subscription-canceled-slovak\";i:1;s:37:\"subscription-payment-succeeded-slovak\";i:1;s:35:\"contract-expiration-to-staff-slovak\";i:1;s:27:\"gdpr-removal-request-slovak\";i:1;s:32:\"gdpr-removal-request-lead-slovak\";i:1;s:36:\"client-registration-confirmed-slovak\";i:1;s:31:\"contract-signed-to-staff-slovak\";i:1;s:35:\"customer-subscribed-to-staff-slovak\";i:1;s:33:\"contact-verification-email-slovak\";i:1;s:50:\"new-customer-profile-file-uploaded-to-staff-slovak\";i:1;s:34:\"event-notification-to-staff-slovak\";i:1;s:26:\"new-client-created-spanish\";i:1;s:30:\"invoice-send-to-client-spanish\";i:1;s:31:\"new-ticket-opened-admin-spanish\";i:1;s:20:\"ticket-reply-spanish\";i:1;s:27:\"ticket-autoresponse-spanish\";i:1;s:32:\"invoice-payment-recorded-spanish\";i:1;s:30:\"invoice-overdue-notice-spanish\";i:1;s:28:\"invoice-already-send-spanish\";i:1;s:32:\"new-ticket-created-staff-spanish\";i:1;s:31:\"estimate-send-to-client-spanish\";i:1;s:29:\"ticket-reply-to-admin-spanish\";i:1;s:29:\"estimate-already-send-spanish\";i:1;s:27:\"contract-expiration-spanish\";i:1;s:21:\"task-assigned-spanish\";i:1;s:30:\"task-added-as-follower-spanish\";i:1;s:22:\"task-commented-spanish\";i:1;s:29:\"task-added-attachment-spanish\";i:1;s:34:\"estimate-declined-to-staff-spanish\";i:1;s:34:\"estimate-accepted-to-staff-spanish\";i:1;s:32:\"proposal-client-accepted-spanish\";i:1;s:33:\"proposal-send-to-customer-spanish\";i:1;s:32:\"proposal-client-declined-spanish\";i:1;s:33:\"proposal-client-thank-you-spanish\";i:1;s:34:\"proposal-comment-to-client-spanish\";i:1;s:33:\"proposal-comment-to-admin-spanish\";i:1;s:38:\"estimate-thank-you-to-customer-spanish\";i:1;s:34:\"task-deadline-notification-spanish\";i:1;s:21:\"send-contract-spanish\";i:1;s:41:\"invoice-payment-recorded-to-staff-spanish\";i:1;s:25:\"auto-close-ticket-spanish\";i:1;s:47:\"new-project-discussion-created-to-staff-spanish\";i:1;s:50:\"new-project-discussion-created-to-customer-spanish\";i:1;s:45:\"new-project-file-uploaded-to-customer-spanish\";i:1;s:42:\"new-project-file-uploaded-to-staff-spanish\";i:1;s:50:\"new-project-discussion-comment-to-customer-spanish\";i:1;s:47:\"new-project-discussion-comment-to-staff-spanish\";i:1;s:37:\"staff-added-as-project-member-spanish\";i:1;s:32:\"estimate-expiry-reminder-spanish\";i:1;s:32:\"proposal-expiry-reminder-spanish\";i:1;s:25:\"new-staff-created-spanish\";i:1;s:31:\"contact-forgot-password-spanish\";i:1;s:32:\"contact-password-reseted-spanish\";i:1;s:28:\"contact-set-password-spanish\";i:1;s:29:\"staff-forgot-password-spanish\";i:1;s:30:\"staff-password-reseted-spanish\";i:1;s:27:\"assigned-to-project-spanish\";i:1;s:41:\"task-added-attachment-to-contacts-spanish\";i:1;s:34:\"task-commented-to-contacts-spanish\";i:1;s:25:\"new-lead-assigned-spanish\";i:1;s:24:\"client-statement-spanish\";i:1;s:32:\"ticket-assigned-to-admin-spanish\";i:1;s:38:\"new-client-registered-to-admin-spanish\";i:1;s:38:\"new-web-to-lead-form-submitted-spanish\";i:1;s:33:\"two-factor-authentication-spanish\";i:1;s:36:\"project-finished-to-customer-spanish\";i:1;s:34:\"credit-note-send-to-client-spanish\";i:1;s:35:\"task-status-change-to-staff-spanish\";i:1;s:38:\"task-status-change-to-contacts-spanish\";i:1;s:28:\"reminder-email-staff-spanish\";i:1;s:34:\"contract-comment-to-client-spanish\";i:1;s:33:\"contract-comment-to-admin-spanish\";i:1;s:25:\"send-subscription-spanish\";i:1;s:35:\"subscription-payment-failed-spanish\";i:1;s:29:\"subscription-canceled-spanish\";i:1;s:38:\"subscription-payment-succeeded-spanish\";i:1;s:36:\"contract-expiration-to-staff-spanish\";i:1;s:28:\"gdpr-removal-request-spanish\";i:1;s:33:\"gdpr-removal-request-lead-spanish\";i:1;s:37:\"client-registration-confirmed-spanish\";i:1;s:32:\"contract-signed-to-staff-spanish\";i:1;s:36:\"customer-subscribed-to-staff-spanish\";i:1;s:34:\"contact-verification-email-spanish\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-spanish\";i:1;s:35:\"event-notification-to-staff-spanish\";i:1;s:26:\"new-client-created-swedish\";i:1;s:30:\"invoice-send-to-client-swedish\";i:1;s:31:\"new-ticket-opened-admin-swedish\";i:1;s:20:\"ticket-reply-swedish\";i:1;s:27:\"ticket-autoresponse-swedish\";i:1;s:32:\"invoice-payment-recorded-swedish\";i:1;s:30:\"invoice-overdue-notice-swedish\";i:1;s:28:\"invoice-already-send-swedish\";i:1;s:32:\"new-ticket-created-staff-swedish\";i:1;s:31:\"estimate-send-to-client-swedish\";i:1;s:29:\"ticket-reply-to-admin-swedish\";i:1;s:29:\"estimate-already-send-swedish\";i:1;s:27:\"contract-expiration-swedish\";i:1;s:21:\"task-assigned-swedish\";i:1;s:30:\"task-added-as-follower-swedish\";i:1;s:22:\"task-commented-swedish\";i:1;s:29:\"task-added-attachment-swedish\";i:1;s:34:\"estimate-declined-to-staff-swedish\";i:1;s:34:\"estimate-accepted-to-staff-swedish\";i:1;s:32:\"proposal-client-accepted-swedish\";i:1;s:33:\"proposal-send-to-customer-swedish\";i:1;s:32:\"proposal-client-declined-swedish\";i:1;s:33:\"proposal-client-thank-you-swedish\";i:1;s:34:\"proposal-comment-to-client-swedish\";i:1;s:33:\"proposal-comment-to-admin-swedish\";i:1;s:38:\"estimate-thank-you-to-customer-swedish\";i:1;s:34:\"task-deadline-notification-swedish\";i:1;s:21:\"send-contract-swedish\";i:1;s:41:\"invoice-payment-recorded-to-staff-swedish\";i:1;s:25:\"auto-close-ticket-swedish\";i:1;s:47:\"new-project-discussion-created-to-staff-swedish\";i:1;s:50:\"new-project-discussion-created-to-customer-swedish\";i:1;s:45:\"new-project-file-uploaded-to-customer-swedish\";i:1;s:42:\"new-project-file-uploaded-to-staff-swedish\";i:1;s:50:\"new-project-discussion-comment-to-customer-swedish\";i:1;s:47:\"new-project-discussion-comment-to-staff-swedish\";i:1;s:37:\"staff-added-as-project-member-swedish\";i:1;s:32:\"estimate-expiry-reminder-swedish\";i:1;s:32:\"proposal-expiry-reminder-swedish\";i:1;s:25:\"new-staff-created-swedish\";i:1;s:31:\"contact-forgot-password-swedish\";i:1;s:32:\"contact-password-reseted-swedish\";i:1;s:28:\"contact-set-password-swedish\";i:1;s:29:\"staff-forgot-password-swedish\";i:1;s:30:\"staff-password-reseted-swedish\";i:1;s:27:\"assigned-to-project-swedish\";i:1;s:41:\"task-added-attachment-to-contacts-swedish\";i:1;s:34:\"task-commented-to-contacts-swedish\";i:1;s:25:\"new-lead-assigned-swedish\";i:1;s:24:\"client-statement-swedish\";i:1;s:32:\"ticket-assigned-to-admin-swedish\";i:1;s:38:\"new-client-registered-to-admin-swedish\";i:1;s:38:\"new-web-to-lead-form-submitted-swedish\";i:1;s:33:\"two-factor-authentication-swedish\";i:1;s:36:\"project-finished-to-customer-swedish\";i:1;s:34:\"credit-note-send-to-client-swedish\";i:1;s:35:\"task-status-change-to-staff-swedish\";i:1;s:38:\"task-status-change-to-contacts-swedish\";i:1;s:28:\"reminder-email-staff-swedish\";i:1;s:34:\"contract-comment-to-client-swedish\";i:1;s:33:\"contract-comment-to-admin-swedish\";i:1;s:25:\"send-subscription-swedish\";i:1;s:35:\"subscription-payment-failed-swedish\";i:1;s:29:\"subscription-canceled-swedish\";i:1;s:38:\"subscription-payment-succeeded-swedish\";i:1;s:36:\"contract-expiration-to-staff-swedish\";i:1;s:28:\"gdpr-removal-request-swedish\";i:1;s:33:\"gdpr-removal-request-lead-swedish\";i:1;s:37:\"client-registration-confirmed-swedish\";i:1;s:32:\"contract-signed-to-staff-swedish\";i:1;s:36:\"customer-subscribed-to-staff-swedish\";i:1;s:34:\"contact-verification-email-swedish\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-swedish\";i:1;s:35:\"event-notification-to-staff-swedish\";i:1;s:26:\"new-client-created-turkish\";i:1;s:30:\"invoice-send-to-client-turkish\";i:1;s:31:\"new-ticket-opened-admin-turkish\";i:1;s:20:\"ticket-reply-turkish\";i:1;s:27:\"ticket-autoresponse-turkish\";i:1;s:32:\"invoice-payment-recorded-turkish\";i:1;s:30:\"invoice-overdue-notice-turkish\";i:1;s:28:\"invoice-already-send-turkish\";i:1;s:32:\"new-ticket-created-staff-turkish\";i:1;s:31:\"estimate-send-to-client-turkish\";i:1;s:29:\"ticket-reply-to-admin-turkish\";i:1;s:29:\"estimate-already-send-turkish\";i:1;s:27:\"contract-expiration-turkish\";i:1;s:21:\"task-assigned-turkish\";i:1;s:30:\"task-added-as-follower-turkish\";i:1;s:22:\"task-commented-turkish\";i:1;s:29:\"task-added-attachment-turkish\";i:1;s:34:\"estimate-declined-to-staff-turkish\";i:1;s:34:\"estimate-accepted-to-staff-turkish\";i:1;s:32:\"proposal-client-accepted-turkish\";i:1;s:33:\"proposal-send-to-customer-turkish\";i:1;s:32:\"proposal-client-declined-turkish\";i:1;s:33:\"proposal-client-thank-you-turkish\";i:1;s:34:\"proposal-comment-to-client-turkish\";i:1;s:33:\"proposal-comment-to-admin-turkish\";i:1;s:38:\"estimate-thank-you-to-customer-turkish\";i:1;s:34:\"task-deadline-notification-turkish\";i:1;s:21:\"send-contract-turkish\";i:1;s:41:\"invoice-payment-recorded-to-staff-turkish\";i:1;s:25:\"auto-close-ticket-turkish\";i:1;s:47:\"new-project-discussion-created-to-staff-turkish\";i:1;s:50:\"new-project-discussion-created-to-customer-turkish\";i:1;s:45:\"new-project-file-uploaded-to-customer-turkish\";i:1;s:42:\"new-project-file-uploaded-to-staff-turkish\";i:1;s:50:\"new-project-discussion-comment-to-customer-turkish\";i:1;s:47:\"new-project-discussion-comment-to-staff-turkish\";i:1;s:37:\"staff-added-as-project-member-turkish\";i:1;s:32:\"estimate-expiry-reminder-turkish\";i:1;s:32:\"proposal-expiry-reminder-turkish\";i:1;s:25:\"new-staff-created-turkish\";i:1;s:31:\"contact-forgot-password-turkish\";i:1;s:32:\"contact-password-reseted-turkish\";i:1;s:28:\"contact-set-password-turkish\";i:1;s:29:\"staff-forgot-password-turkish\";i:1;s:30:\"staff-password-reseted-turkish\";i:1;s:27:\"assigned-to-project-turkish\";i:1;s:41:\"task-added-attachment-to-contacts-turkish\";i:1;s:34:\"task-commented-to-contacts-turkish\";i:1;s:25:\"new-lead-assigned-turkish\";i:1;s:24:\"client-statement-turkish\";i:1;s:32:\"ticket-assigned-to-admin-turkish\";i:1;s:38:\"new-client-registered-to-admin-turkish\";i:1;s:38:\"new-web-to-lead-form-submitted-turkish\";i:1;s:33:\"two-factor-authentication-turkish\";i:1;s:36:\"project-finished-to-customer-turkish\";i:1;s:34:\"credit-note-send-to-client-turkish\";i:1;s:35:\"task-status-change-to-staff-turkish\";i:1;s:38:\"task-status-change-to-contacts-turkish\";i:1;s:28:\"reminder-email-staff-turkish\";i:1;s:34:\"contract-comment-to-client-turkish\";i:1;s:33:\"contract-comment-to-admin-turkish\";i:1;s:25:\"send-subscription-turkish\";i:1;s:35:\"subscription-payment-failed-turkish\";i:1;s:29:\"subscription-canceled-turkish\";i:1;s:38:\"subscription-payment-succeeded-turkish\";i:1;s:36:\"contract-expiration-to-staff-turkish\";i:1;s:28:\"gdpr-removal-request-turkish\";i:1;s:33:\"gdpr-removal-request-lead-turkish\";i:1;s:37:\"client-registration-confirmed-turkish\";i:1;s:32:\"contract-signed-to-staff-turkish\";i:1;s:36:\"customer-subscribed-to-staff-turkish\";i:1;s:34:\"contact-verification-email-turkish\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-turkish\";i:1;s:35:\"event-notification-to-staff-turkish\";i:1;s:29:\"new-client-created-vietnamese\";i:1;s:33:\"invoice-send-to-client-vietnamese\";i:1;s:34:\"new-ticket-opened-admin-vietnamese\";i:1;s:23:\"ticket-reply-vietnamese\";i:1;s:30:\"ticket-autoresponse-vietnamese\";i:1;s:35:\"invoice-payment-recorded-vietnamese\";i:1;s:33:\"invoice-overdue-notice-vietnamese\";i:1;s:31:\"invoice-already-send-vietnamese\";i:1;s:35:\"new-ticket-created-staff-vietnamese\";i:1;s:34:\"estimate-send-to-client-vietnamese\";i:1;s:32:\"ticket-reply-to-admin-vietnamese\";i:1;s:32:\"estimate-already-send-vietnamese\";i:1;s:30:\"contract-expiration-vietnamese\";i:1;s:24:\"task-assigned-vietnamese\";i:1;s:33:\"task-added-as-follower-vietnamese\";i:1;s:25:\"task-commented-vietnamese\";i:1;s:32:\"task-added-attachment-vietnamese\";i:1;s:37:\"estimate-declined-to-staff-vietnamese\";i:1;s:37:\"estimate-accepted-to-staff-vietnamese\";i:1;s:35:\"proposal-client-accepted-vietnamese\";i:1;s:36:\"proposal-send-to-customer-vietnamese\";i:1;s:35:\"proposal-client-declined-vietnamese\";i:1;s:36:\"proposal-client-thank-you-vietnamese\";i:1;s:37:\"proposal-comment-to-client-vietnamese\";i:1;s:36:\"proposal-comment-to-admin-vietnamese\";i:1;s:41:\"estimate-thank-you-to-customer-vietnamese\";i:1;s:37:\"task-deadline-notification-vietnamese\";i:1;s:24:\"send-contract-vietnamese\";i:1;s:44:\"invoice-payment-recorded-to-staff-vietnamese\";i:1;s:28:\"auto-close-ticket-vietnamese\";i:1;s:50:\"new-project-discussion-created-to-staff-vietnamese\";i:1;s:53:\"new-project-discussion-created-to-customer-vietnamese\";i:1;s:48:\"new-project-file-uploaded-to-customer-vietnamese\";i:1;s:45:\"new-project-file-uploaded-to-staff-vietnamese\";i:1;s:53:\"new-project-discussion-comment-to-customer-vietnamese\";i:1;s:50:\"new-project-discussion-comment-to-staff-vietnamese\";i:1;s:40:\"staff-added-as-project-member-vietnamese\";i:1;s:35:\"estimate-expiry-reminder-vietnamese\";i:1;s:35:\"proposal-expiry-reminder-vietnamese\";i:1;s:28:\"new-staff-created-vietnamese\";i:1;s:34:\"contact-forgot-password-vietnamese\";i:1;s:35:\"contact-password-reseted-vietnamese\";i:1;s:31:\"contact-set-password-vietnamese\";i:1;s:32:\"staff-forgot-password-vietnamese\";i:1;s:33:\"staff-password-reseted-vietnamese\";i:1;s:30:\"assigned-to-project-vietnamese\";i:1;s:44:\"task-added-attachment-to-contacts-vietnamese\";i:1;s:37:\"task-commented-to-contacts-vietnamese\";i:1;s:28:\"new-lead-assigned-vietnamese\";i:1;s:27:\"client-statement-vietnamese\";i:1;s:35:\"ticket-assigned-to-admin-vietnamese\";i:1;s:41:\"new-client-registered-to-admin-vietnamese\";i:1;s:41:\"new-web-to-lead-form-submitted-vietnamese\";i:1;s:36:\"two-factor-authentication-vietnamese\";i:1;s:39:\"project-finished-to-customer-vietnamese\";i:1;s:37:\"credit-note-send-to-client-vietnamese\";i:1;s:38:\"task-status-change-to-staff-vietnamese\";i:1;s:41:\"task-status-change-to-contacts-vietnamese\";i:1;s:31:\"reminder-email-staff-vietnamese\";i:1;s:37:\"contract-comment-to-client-vietnamese\";i:1;s:36:\"contract-comment-to-admin-vietnamese\";i:1;s:28:\"send-subscription-vietnamese\";i:1;s:38:\"subscription-payment-failed-vietnamese\";i:1;s:32:\"subscription-canceled-vietnamese\";i:1;s:41:\"subscription-payment-succeeded-vietnamese\";i:1;s:39:\"contract-expiration-to-staff-vietnamese\";i:1;s:31:\"gdpr-removal-request-vietnamese\";i:1;s:36:\"gdpr-removal-request-lead-vietnamese\";i:1;s:40:\"client-registration-confirmed-vietnamese\";i:1;s:35:\"contract-signed-to-staff-vietnamese\";i:1;s:39:\"customer-subscribed-to-staff-vietnamese\";i:1;s:37:\"contact-verification-email-vietnamese\";i:1;s:54:\"new-customer-profile-file-uploaded-to-staff-vietnamese\";i:1;s:38:\"event-notification-to-staff-vietnamese\";i:1;s:43:\"subscription-payment-requires-action-arabic\";i:1;s:46:\"subscription-payment-requires-action-bulgarian\";i:1;s:44:\"subscription-payment-requires-action-catalan\";i:1;s:44:\"subscription-payment-requires-action-chinese\";i:1;s:42:\"subscription-payment-requires-action-czech\";i:1;s:42:\"subscription-payment-requires-action-dutch\";i:1;s:43:\"subscription-payment-requires-action-french\";i:1;s:43:\"subscription-payment-requires-action-german\";i:1;s:42:\"subscription-payment-requires-action-greek\";i:1;s:46:\"subscription-payment-requires-action-indonesia\";i:1;s:44:\"subscription-payment-requires-action-italian\";i:1;s:45:\"subscription-payment-requires-action-japanese\";i:1;s:44:\"subscription-payment-requires-action-persian\";i:1;s:43:\"subscription-payment-requires-action-polish\";i:1;s:47:\"subscription-payment-requires-action-portuguese\";i:1;s:50:\"subscription-payment-requires-action-portuguese_br\";i:1;s:45:\"subscription-payment-requires-action-romanian\";i:1;s:44:\"subscription-payment-requires-action-russian\";i:1;s:43:\"subscription-payment-requires-action-slovak\";i:1;s:44:\"subscription-payment-requires-action-spanish\";i:1;s:44:\"subscription-payment-requires-action-swedish\";i:1;s:44:\"subscription-payment-requires-action-turkish\";i:1;s:47:\"subscription-payment-requires-action-vietnamese\";i:1;s:32:\"session-added-as-follower-arabic\";i:1;s:23:\"session-assigned-arabic\";i:1;s:36:\"session-deadline-notification-arabic\";i:1;s:43:\"session-added-attachment-to-contacts-arabic\";i:1;s:31:\"session-added-attachment-arabic\";i:1;s:36:\"session-commented-to-contacts-arabic\";i:1;s:24:\"session-commented-arabic\";i:1;s:40:\"session-status-change-to-contacts-arabic\";i:1;s:37:\"session-status-change-to-staff-arabic\";i:1;s:35:\"session-added-as-follower-bulgarian\";i:1;s:26:\"session-assigned-bulgarian\";i:1;s:39:\"session-deadline-notification-bulgarian\";i:1;s:46:\"session-added-attachment-to-contacts-bulgarian\";i:1;s:34:\"session-added-attachment-bulgarian\";i:1;s:39:\"session-commented-to-contacts-bulgarian\";i:1;s:27:\"session-commented-bulgarian\";i:1;s:43:\"session-status-change-to-contacts-bulgarian\";i:1;s:40:\"session-status-change-to-staff-bulgarian\";i:1;s:33:\"session-added-as-follower-catalan\";i:1;s:24:\"session-assigned-catalan\";i:1;s:37:\"session-deadline-notification-catalan\";i:1;s:44:\"session-added-attachment-to-contacts-catalan\";i:1;s:32:\"session-added-attachment-catalan\";i:1;s:37:\"session-commented-to-contacts-catalan\";i:1;s:25:\"session-commented-catalan\";i:1;s:41:\"session-status-change-to-contacts-catalan\";i:1;s:38:\"session-status-change-to-staff-catalan\";i:1;s:33:\"session-added-as-follower-chinese\";i:1;s:24:\"session-assigned-chinese\";i:1;s:37:\"session-deadline-notification-chinese\";i:1;s:44:\"session-added-attachment-to-contacts-chinese\";i:1;s:32:\"session-added-attachment-chinese\";i:1;s:37:\"session-commented-to-contacts-chinese\";i:1;s:25:\"session-commented-chinese\";i:1;s:41:\"session-status-change-to-contacts-chinese\";i:1;s:38:\"session-status-change-to-staff-chinese\";i:1;s:31:\"session-added-as-follower-czech\";i:1;s:22:\"session-assigned-czech\";i:1;s:35:\"session-deadline-notification-czech\";i:1;s:42:\"session-added-attachment-to-contacts-czech\";i:1;s:30:\"session-added-attachment-czech\";i:1;s:35:\"session-commented-to-contacts-czech\";i:1;s:23:\"session-commented-czech\";i:1;s:39:\"session-status-change-to-contacts-czech\";i:1;s:36:\"session-status-change-to-staff-czech\";i:1;s:31:\"session-added-as-follower-dutch\";i:1;s:22:\"session-assigned-dutch\";i:1;s:35:\"session-deadline-notification-dutch\";i:1;s:42:\"session-added-attachment-to-contacts-dutch\";i:1;s:30:\"session-added-attachment-dutch\";i:1;s:35:\"session-commented-to-contacts-dutch\";i:1;s:23:\"session-commented-dutch\";i:1;s:39:\"session-status-change-to-contacts-dutch\";i:1;s:36:\"session-status-change-to-staff-dutch\";i:1;s:32:\"session-added-as-follower-french\";i:1;s:23:\"session-assigned-french\";i:1;s:36:\"session-deadline-notification-french\";i:1;s:43:\"session-added-attachment-to-contacts-french\";i:1;s:31:\"session-added-attachment-french\";i:1;s:36:\"session-commented-to-contacts-french\";i:1;s:24:\"session-commented-french\";i:1;s:40:\"session-status-change-to-contacts-french\";i:1;s:37:\"session-status-change-to-staff-french\";i:1;s:32:\"session-added-as-follower-german\";i:1;s:23:\"session-assigned-german\";i:1;s:36:\"session-deadline-notification-german\";i:1;s:43:\"session-added-attachment-to-contacts-german\";i:1;s:31:\"session-added-attachment-german\";i:1;s:36:\"session-commented-to-contacts-german\";i:1;s:24:\"session-commented-german\";i:1;s:40:\"session-status-change-to-contacts-german\";i:1;s:37:\"session-status-change-to-staff-german\";i:1;s:31:\"session-added-as-follower-greek\";i:1;s:22:\"session-assigned-greek\";i:1;s:35:\"session-deadline-notification-greek\";i:1;s:42:\"session-added-attachment-to-contacts-greek\";i:1;s:30:\"session-added-attachment-greek\";i:1;s:35:\"session-commented-to-contacts-greek\";i:1;s:23:\"session-commented-greek\";i:1;s:39:\"session-status-change-to-contacts-greek\";i:1;s:36:\"session-status-change-to-staff-greek\";i:1;s:35:\"session-added-as-follower-indonesia\";i:1;s:26:\"session-assigned-indonesia\";i:1;s:39:\"session-deadline-notification-indonesia\";i:1;s:46:\"session-added-attachment-to-contacts-indonesia\";i:1;s:34:\"session-added-attachment-indonesia\";i:1;s:39:\"session-commented-to-contacts-indonesia\";i:1;s:27:\"session-commented-indonesia\";i:1;s:43:\"session-status-change-to-contacts-indonesia\";i:1;s:40:\"session-status-change-to-staff-indonesia\";i:1;s:33:\"session-added-as-follower-italian\";i:1;s:24:\"session-assigned-italian\";i:1;s:37:\"session-deadline-notification-italian\";i:1;s:44:\"session-added-attachment-to-contacts-italian\";i:1;s:32:\"session-added-attachment-italian\";i:1;s:37:\"session-commented-to-contacts-italian\";i:1;s:25:\"session-commented-italian\";i:1;s:41:\"session-status-change-to-contacts-italian\";i:1;s:38:\"session-status-change-to-staff-italian\";i:1;s:34:\"session-added-as-follower-japanese\";i:1;s:25:\"session-assigned-japanese\";i:1;s:38:\"session-deadline-notification-japanese\";i:1;s:45:\"session-added-attachment-to-contacts-japanese\";i:1;s:33:\"session-added-attachment-japanese\";i:1;s:38:\"session-commented-to-contacts-japanese\";i:1;s:26:\"session-commented-japanese\";i:1;s:42:\"session-status-change-to-contacts-japanese\";i:1;s:39:\"session-status-change-to-staff-japanese\";i:1;s:33:\"session-added-as-follower-persian\";i:1;s:24:\"session-assigned-persian\";i:1;s:37:\"session-deadline-notification-persian\";i:1;s:44:\"session-added-attachment-to-contacts-persian\";i:1;s:32:\"session-added-attachment-persian\";i:1;s:37:\"session-commented-to-contacts-persian\";i:1;s:25:\"session-commented-persian\";i:1;s:41:\"session-status-change-to-contacts-persian\";i:1;s:38:\"session-status-change-to-staff-persian\";i:1;s:32:\"session-added-as-follower-polish\";i:1;s:23:\"session-assigned-polish\";i:1;s:36:\"session-deadline-notification-polish\";i:1;s:43:\"session-added-attachment-to-contacts-polish\";i:1;s:31:\"session-added-attachment-polish\";i:1;s:36:\"session-commented-to-contacts-polish\";i:1;s:24:\"session-commented-polish\";i:1;s:40:\"session-status-change-to-contacts-polish\";i:1;s:37:\"session-status-change-to-staff-polish\";i:1;s:36:\"session-added-as-follower-portuguese\";i:1;s:27:\"session-assigned-portuguese\";i:1;s:40:\"session-deadline-notification-portuguese\";i:1;s:47:\"session-added-attachment-to-contacts-portuguese\";i:1;s:35:\"session-added-attachment-portuguese\";i:1;s:40:\"session-commented-to-contacts-portuguese\";i:1;s:28:\"session-commented-portuguese\";i:1;s:44:\"session-status-change-to-contacts-portuguese\";i:1;s:41:\"session-status-change-to-staff-portuguese\";i:1;s:39:\"session-added-as-follower-portuguese_br\";i:1;s:30:\"session-assigned-portuguese_br\";i:1;s:43:\"session-deadline-notification-portuguese_br\";i:1;s:50:\"session-added-attachment-to-contacts-portuguese_br\";i:1;s:38:\"session-added-attachment-portuguese_br\";i:1;s:43:\"session-commented-to-contacts-portuguese_br\";i:1;s:31:\"session-commented-portuguese_br\";i:1;s:47:\"session-status-change-to-contacts-portuguese_br\";i:1;s:44:\"session-status-change-to-staff-portuguese_br\";i:1;s:34:\"session-added-as-follower-romanian\";i:1;s:25:\"session-assigned-romanian\";i:1;s:38:\"session-deadline-notification-romanian\";i:1;s:45:\"session-added-attachment-to-contacts-romanian\";i:1;s:33:\"session-added-attachment-romanian\";i:1;s:38:\"session-commented-to-contacts-romanian\";i:1;s:26:\"session-commented-romanian\";i:1;s:42:\"session-status-change-to-contacts-romanian\";i:1;s:39:\"session-status-change-to-staff-romanian\";i:1;s:33:\"session-added-as-follower-russian\";i:1;s:24:\"session-assigned-russian\";i:1;s:37:\"session-deadline-notification-russian\";i:1;s:44:\"session-added-attachment-to-contacts-russian\";i:1;s:32:\"session-added-attachment-russian\";i:1;s:37:\"session-commented-to-contacts-russian\";i:1;s:25:\"session-commented-russian\";i:1;s:41:\"session-status-change-to-contacts-russian\";i:1;s:38:\"session-status-change-to-staff-russian\";i:1;s:32:\"session-added-as-follower-slovak\";i:1;s:23:\"session-assigned-slovak\";i:1;s:36:\"session-deadline-notification-slovak\";i:1;s:43:\"session-added-attachment-to-contacts-slovak\";i:1;s:31:\"session-added-attachment-slovak\";i:1;s:36:\"session-commented-to-contacts-slovak\";i:1;s:24:\"session-commented-slovak\";i:1;s:40:\"session-status-change-to-contacts-slovak\";i:1;s:37:\"session-status-change-to-staff-slovak\";i:1;s:33:\"session-added-as-follower-spanish\";i:1;s:24:\"session-assigned-spanish\";i:1;s:37:\"session-deadline-notification-spanish\";i:1;s:44:\"session-added-attachment-to-contacts-spanish\";i:1;s:32:\"session-added-attachment-spanish\";i:1;s:37:\"session-commented-to-contacts-spanish\";i:1;s:25:\"session-commented-spanish\";i:1;s:41:\"session-status-change-to-contacts-spanish\";i:1;s:38:\"session-status-change-to-staff-spanish\";i:1;s:33:\"session-added-as-follower-swedish\";i:1;s:24:\"session-assigned-swedish\";i:1;s:37:\"session-deadline-notification-swedish\";i:1;s:44:\"session-added-attachment-to-contacts-swedish\";i:1;s:32:\"session-added-attachment-swedish\";i:1;s:37:\"session-commented-to-contacts-swedish\";i:1;s:25:\"session-commented-swedish\";i:1;s:41:\"session-status-change-to-contacts-swedish\";i:1;s:38:\"session-status-change-to-staff-swedish\";i:1;s:33:\"session-added-as-follower-turkish\";i:1;s:24:\"session-assigned-turkish\";i:1;s:37:\"session-deadline-notification-turkish\";i:1;s:44:\"session-added-attachment-to-contacts-turkish\";i:1;s:32:\"session-added-attachment-turkish\";i:1;s:37:\"session-commented-to-contacts-turkish\";i:1;s:25:\"session-commented-turkish\";i:1;s:41:\"session-status-change-to-contacts-turkish\";i:1;s:38:\"session-status-change-to-staff-turkish\";i:1;s:36:\"session-added-as-follower-vietnamese\";i:1;s:27:\"session-assigned-vietnamese\";i:1;s:40:\"session-deadline-notification-vietnamese\";i:1;s:47:\"session-added-attachment-to-contacts-vietnamese\";i:1;s:35:\"session-added-attachment-vietnamese\";i:1;s:40:\"session-commented-to-contacts-vietnamese\";i:1;s:28:\"session-commented-vietnamese\";i:1;s:44:\"session-status-change-to-contacts-vietnamese\";i:1;s:41:\"session-status-change-to-staff-vietnamese\";i:1;s:26:\"send_report_session-arabic\";i:1;s:26:\"next_session_action-arabic\";i:1;s:41:\"appointment-cron-reminder-to-staff-arabic\";i:1;s:37:\"appointment-cancelled-to-staff-arabic\";i:1;s:39:\"appointment-cancelled-to-contact-arabic\";i:1;s:43:\"appointment-cron-reminder-to-contact-arabic\";i:1;s:36:\"appointment-approved-to-staff-arabic\";i:1;s:38:\"appointment-approved-to-contact-arabic\";i:1;s:37:\"appointment-submitted-to-staff-arabic\";i:1;s:33:\"callback-assigned-to-staff-arabic\";i:1;s:37:\"newcallback-requested-to-staff-arabic\";i:1;s:45:\"appointly-appointment-request-feedback-arabic\";i:1;s:46:\"appointly-appointment-feedback-received-arabic\";i:1;s:45:\"appointly-appointment-feedback-updated-arabic\";i:1;s:26:\"new-client-created-english\";i:1;s:30:\"invoice-send-to-client-english\";i:1;s:31:\"new-ticket-opened-admin-english\";i:1;s:20:\"ticket-reply-english\";i:1;s:27:\"ticket-autoresponse-english\";i:1;s:32:\"invoice-payment-recorded-english\";i:1;s:30:\"invoice-overdue-notice-english\";i:1;s:28:\"invoice-already-send-english\";i:1;s:32:\"new-ticket-created-staff-english\";i:1;s:31:\"estimate-send-to-client-english\";i:1;s:29:\"ticket-reply-to-admin-english\";i:1;s:29:\"estimate-already-send-english\";i:1;s:27:\"contract-expiration-english\";i:1;s:21:\"task-assigned-english\";i:1;s:30:\"task-added-as-follower-english\";i:1;s:22:\"task-commented-english\";i:1;s:29:\"task-added-attachment-english\";i:1;s:34:\"estimate-declined-to-staff-english\";i:1;s:34:\"estimate-accepted-to-staff-english\";i:1;s:32:\"proposal-client-accepted-english\";i:1;s:33:\"proposal-send-to-customer-english\";i:1;s:32:\"proposal-client-declined-english\";i:1;s:33:\"proposal-client-thank-you-english\";i:1;s:34:\"proposal-comment-to-client-english\";i:1;s:33:\"proposal-comment-to-admin-english\";i:1;s:38:\"estimate-thank-you-to-customer-english\";i:1;s:34:\"task-deadline-notification-english\";i:1;s:21:\"send-contract-english\";i:1;s:41:\"invoice-payment-recorded-to-staff-english\";i:1;s:25:\"auto-close-ticket-english\";i:1;s:47:\"new-project-discussion-created-to-staff-english\";i:1;s:50:\"new-project-discussion-created-to-customer-english\";i:1;s:45:\"new-project-file-uploaded-to-customer-english\";i:1;s:42:\"new-project-file-uploaded-to-staff-english\";i:1;s:50:\"new-project-discussion-comment-to-customer-english\";i:1;s:47:\"new-project-discussion-comment-to-staff-english\";i:1;s:37:\"staff-added-as-project-member-english\";i:1;s:32:\"estimate-expiry-reminder-english\";i:1;s:32:\"proposal-expiry-reminder-english\";i:1;s:25:\"new-staff-created-english\";i:1;s:31:\"contact-forgot-password-english\";i:1;s:32:\"contact-password-reseted-english\";i:1;s:28:\"contact-set-password-english\";i:1;s:29:\"staff-forgot-password-english\";i:1;s:30:\"staff-password-reseted-english\";i:1;s:27:\"assigned-to-project-english\";i:1;s:41:\"task-added-attachment-to-contacts-english\";i:1;s:34:\"task-commented-to-contacts-english\";i:1;s:25:\"new-lead-assigned-english\";i:1;s:24:\"client-statement-english\";i:1;s:32:\"ticket-assigned-to-admin-english\";i:1;s:38:\"new-client-registered-to-admin-english\";i:1;s:38:\"new-web-to-lead-form-submitted-english\";i:1;s:33:\"two-factor-authentication-english\";i:1;s:36:\"project-finished-to-customer-english\";i:1;s:34:\"credit-note-send-to-client-english\";i:1;s:35:\"task-status-change-to-staff-english\";i:1;s:38:\"task-status-change-to-contacts-english\";i:1;s:28:\"reminder-email-staff-english\";i:1;s:34:\"contract-comment-to-client-english\";i:1;s:33:\"contract-comment-to-admin-english\";i:1;s:25:\"send-subscription-english\";i:1;s:35:\"subscription-payment-failed-english\";i:1;s:29:\"subscription-canceled-english\";i:1;s:38:\"subscription-payment-succeeded-english\";i:1;s:36:\"contract-expiration-to-staff-english\";i:1;s:28:\"gdpr-removal-request-english\";i:1;s:33:\"gdpr-removal-request-lead-english\";i:1;s:37:\"client-registration-confirmed-english\";i:1;s:32:\"contract-signed-to-staff-english\";i:1;s:36:\"customer-subscribed-to-staff-english\";i:1;s:34:\"contact-verification-email-english\";i:1;s:51:\"new-customer-profile-file-uploaded-to-staff-english\";i:1;s:35:\"event-notification-to-staff-english\";i:1;s:44:\"subscription-payment-requires-action-english\";i:1;s:33:\"session-added-as-follower-english\";i:1;s:24:\"session-assigned-english\";i:1;s:37:\"session-deadline-notification-english\";i:1;s:44:\"session-added-attachment-to-contacts-english\";i:1;s:32:\"session-added-attachment-english\";i:1;s:37:\"session-commented-to-contacts-english\";i:1;s:25:\"session-commented-english\";i:1;s:41:\"session-status-change-to-contacts-english\";i:1;s:38:\"session-status-change-to-staff-english\";i:1;s:27:\"send_report_session-english\";i:1;s:27:\"next_session_action-english\";i:1;s:42:\"appointment-cron-reminder-to-staff-english\";i:1;s:38:\"appointment-cancelled-to-staff-english\";i:1;s:40:\"appointment-cancelled-to-contact-english\";i:1;s:44:\"appointment-cron-reminder-to-contact-english\";i:1;s:37:\"appointment-approved-to-staff-english\";i:1;s:39:\"appointment-approved-to-contact-english\";i:1;s:38:\"appointment-submitted-to-staff-english\";i:1;s:34:\"callback-assigned-to-staff-english\";i:1;s:38:\"newcallback-requested-to-staff-english\";i:1;s:46:\"appointly-appointment-request-feedback-english\";i:1;s:47:\"appointly-appointment-feedback-received-english\";i:1;s:46:\"appointly-appointment-feedback-updated-english\";i:1;}', 0);
INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES
(213, 'proposal_accept_identity_confirmation', '1', 0),
(214, 'estimate_accept_identity_confirmation', '1', 0),
(215, 'new_task_auto_follower_current_member', '0', 1),
(216, 'task_biillable_checked_on_creation', '1', 1),
(217, 'predefined_clientnote_credit_note', '', 1),
(218, 'predefined_terms_credit_note', '', 1),
(219, 'next_credit_note_number', '2', 1),
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
(240, 'e_sign_legal_text', 'بالنقر على \"توقيع\" ، أوافق على الالتزام قانونًا بهذا التمثيل الإلكتروني لتوقيعي.', 1),
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
(255, 'enable_gdpr', '1', 1),
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
(282, 'ticket_import_reply_only', '1', 1),
(283, 'visible_customer_profile_tabs', 'all', 0),
(284, 'show_project_on_invoice', '1', 1),
(285, 'show_project_on_estimate', '1', 1),
(286, 'staff_members_create_inline_lead_source', '1', 1),
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
(353, 'paymentmethod_paypal_checkout_label', 'Paypal Checkout', 1),
(354, 'paymentmethod_paypal_checkout_client_id', '', 0),
(355, 'paymentmethod_paypal_checkout_secret', '', 0),
(356, 'paymentmethod_paypal_checkout_payment_description', 'Payment for Invoice {invoice_number}', 0),
(357, 'paymentmethod_paypal_checkout_currencies', 'USD,CAD,EUR', 0),
(358, 'paymentmethod_paypal_checkout_test_mode_enabled', '1', 0),
(359, 'paymentmethod_paypal_checkout_default_selected', '1', 1),
(360, 'paymentmethod_paypal_checkout_initialized', '1', 1),
(361, 'paymentmethod_paypal_active', '1', 1),
(362, 'paymentmethod_paypal_label', 'Paypal', 1),
(363, 'paymentmethod_paypal_username', '', 0),
(364, 'paymentmethod_paypal_password', '', 0),
(365, 'paymentmethod_paypal_signature', '', 0),
(366, 'paymentmethod_paypal_description_dashboard', 'Payment for Invoice {invoice_number}', 0),
(367, 'paymentmethod_paypal_currencies', 'SAR,EUR,USD', 0),
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
(424, 'isHijri', 'off', 1),
(425, 'hijri_format', 'Y-m-d|%Y-%m-%d|hijri', 1),
(426, 'hijri_pages', '[\"Case\\/add\",\"group=CaseSession\",\"procuration\"]', 1),
(427, 'adjust_data', '[]', 1),
(428, 'automatically_reminders_before_empty_recycle_bin_days', '1', 1),
(429, 'automatically_empty_recycle_bin_after_days', '1', 1),
(430, 'procurations_reminder_notification_before', '', 1),
(431, 'next_disputes_invoice_number', '6', 1),
(433, 'automatically_resend_disputes_invoice_overdue_reminder_after', '-3', 1),
(434, 'automatically_send_disputes_invoice_overdue_reminder_after', '1', 1),
(438, 'incoming_side_En', '[{\"key\":\"\\u062c\\u0647\\u0629 1\",\"value\":\"\\u062c\\u0647\\u0629 1\"},{\"key\":\"\\u062c\\u0647\\u0629 2\",\"value\":\"\\u062c\\u0647\\u0629 2\"}]', 1),
(442, 'deduction_type', '[{\"key\":\"\\u0627\\u0644\\u062a\\u0623\\u0645\\u064a\\u0646\\u0627\\u062a \\u0627\\u0644\\u0625\\u062c\\u062a\\u0645\\u0627\\u0639\\u064a\\u0629\",\"value\":\"\\u0627\\u0644\\u062a\\u0623\\u0645\\u064a\\u0646\\u0627\\u062a \\u0627\\u0644\\u0625\\u062c\\u062a\\u0645\\u0627\\u0639\\u064a\\u0629\"}]', 1),
(443, 'automatically_send_lawyer_daily_agenda', '7', 1),
(444, 'document_type', '[{\"key\":\"\\u0627\\u0644\\u0647\\u0648\\u064a\\u0629 \\u0627\\u0644\\u0648\\u0637\\u0646\\u064a\\u0629\",\"value\":\"\\u0627\\u0644\\u0647\\u0648\\u064a\\u0629 \\u0627\\u0644\\u0648\\u0637\\u0646\\u064a\\u0629\"},{\"key\":\"\\u0631\\u062e\\u0635\\u0629 \\u0642\\u064a\\u0627\\u062f\\u0629\",\"value\":\"\\u0631\\u062e\\u0635\\u0629 \\u0642\\u064a\\u0627\\u062f\\u0629\"},{\"key\":\"\\u062c\\u0648\\u0627\\u0632 \\u0633\\u0641\\u0631\",\"value\":\"\\u062c\\u0648\\u0627\\u0632 \\u0633\\u0641\\u0631\"},{\"key\":\"\\u0631\\u062e\\u0635\\u0629 \\u0623\\u0642\\u0627\\u0645\\u0629\",\"value\":\"\\u0631\\u062e\\u0635\\u0629 \\u0623\\u0642\\u0627\\u0645\\u0629\"},{\"key\":\"\\u0631\\u062e\\u0635\\u0629 \\u0639\\u0645\\u0644\",\"value\":\"\\u0631\\u062e\\u0635\\u0629 \\u0639\\u0645\\u0644\"}]', 1),
(445, 'education_level_type', '[{\"key\":\"\\u0627\\u0644\\u062b\\u0627\\u0646\\u0648\\u064a\\u0629 \\u0627\\u0644\\u0639\\u0627\\u0645\\u0629\",\"value\":\"\\u0627\\u0644\\u062b\\u0627\\u0646\\u0648\\u064a\\u0629 \\u0627\\u0644\\u0639\\u0627\\u0645\\u0629\"}]', 1),
(446, 'skill_type', '[{\"key\":\"\\u0645\\u0647\\u0627\\u0631\\u0627\\u062a \\u0623\\u0648\\u0641\\u064a\\u0633\",\"value\":\"\\u0645\\u0647\\u0627\\u0631\\u0627\\u062a \\u0623\\u0648\\u0641\\u064a\\u0633\"},{\"key\":\"\\u0645\\u0647\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u0635\\u064a\\u0627\\u063a\\u0629 \",\"value\":\"\\u0645\\u0647\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u0635\\u064a\\u0627\\u063a\\u0629 \"}]', 1),
(447, 'education_type', '[{\"key\":\"\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629\",\"value\":\"\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629\"},{\"key\":\"\\u0627\\u0644\\u0639\\u0631\\u0628\\u064a\\u0629\",\"value\":\"\\u0627\\u0644\\u0639\\u0631\\u0628\\u064a\\u0629\"}]', 1),
(448, 'hr_document_reminder_notification_before', '1', 1),
(449, 'sms_mobily_sender_id', '', 1),
(450, 'sms_mobily_api_key', '', 1),
(451, 'sms_mobily_active', '0', 1),
(452, 'sms_mobily_initialized', '1', 1),
(453, 'branch_type', '[{\"key\":\" Corporation\",\"value\":\" Corporation\"},{\"key\":\" Exempt Organization\",\"value\":\" Exempt Organization\"},{\"key\":\" Partnership\",\"value\":\" Partnership\"},{\"key\":\" Private Foundation\",\"value\":\" Private Foundation\"},{\"key\":\" Limited Liability Company\",\"value\":\" Limited Liability Company\"}]', 1),
(454, 'relation_type', '[{\"key\":\"\\u0628\\u0646\\u0641\\u0633\\u0647\",\"value\":\"\\u0628\\u0646\\u0641\\u0633\\u0647\"},{\"key\":\"\\u0623\\u062e\\/\\u0640\\u062a\",\"value\":\"\\u0623\\u062e\\/\\u0640\\u062a\"},{\"key\":\"\\u0635\\u062f\\u064a\\u0642\",\"value\":\"\\u0635\\u062f\\u064a\\u0642\"},{\"key\":\"\\u0623\\u0628\\u0646\\/\\u0640\\u0629\",\"value\":\"\\u0623\\u0628\\u0646\\/\\u0640\\u0629\"},{\"key\":\"\\u0632\\u0648\\u062c\\/\\u0640\\u0629\",\"value\":\"\\u0632\\u0648\\u062c\\/\\u0640\\u0629\"},{\"key\":\"\\u0627\\u0644\\u0623\\u0628\\/\\u0627\\u0644\\u0623\\u0645\",\"value\":\"\\u0627\\u0644\\u0623\\u0628\\/\\u0627\\u0644\\u0623\\u0645\"},{\"key\":\"\\u0642\\u0631\\u064a\\u0628\",\"value\":\"\\u0642\\u0631\\u064a\\u0628\"}]', 1),
(455, 'show_php_version_notice', '1', 0),
(456, 'upgraded_from_version', '240', 1),
(457, 'appointly_responsible_person', '', 1),
(458, 'callbacks_responsible_person', '', 1),
(459, 'appointly_show_clients_schedule_button', '0', 1),
(460, 'appointly_tab_on_clients_page', '0', 1),
(461, 'appointly_also_delete_in_google_calendar', '1', 1),
(462, 'appointments_show_past_times', '1', 1),
(463, 'appointments_disable_weekends', '1', 1),
(464, 'appointly_client_meeting_approved_default', '0', 1),
(465, 'appointly_google_client_secret', '', 1),
(466, 'appointly_available_hours', '[\"08:00\",\"08:30\",\"09:00\",\"09:30\",\"10:00\",\"10:30\",\"11:00\",\"11:30\",\"12:00\",\"12:30\",\"13:00\",\"13:30\",\"14:00\",\"14:30\",\"15:00\",\"15:30\",\"16:00\",\"16:30\",\"17:00\"]', 1),
(467, 'appointly_default_feedbacks', '[\"0\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', 1),
(468, 'appointly_busy_times_enabled', '1', 1),
(469, 'callbacks_mode_enabled', '1', 1),
(470, 'appointly_appointments_recaptcha', '0', 1),
(471, 'pusher_chat_enabled', '1', 1),
(472, 'chat_staff_can_delete_messages', '1', 1),
(473, 'chat_desktop_messages_notifications', '1', 1),
(474, 'chat_members_can_create_groups', '1', 1),
(475, 'chat_client_enabled', '1', 1),
(476, 'chat_allow_staff_to_create_tickets', '1', 1),
(477, 'chat_show_only_users_with_chat_permissions', '1', 1),
(478, 'mailbox_enabled', '1', 1),
(479, 'mailbox_imap_server', 'mail.babillawnet.com', 1),
(480, 'mailbox_encryption', 'ssl', 1),
(481, 'mailbox_folder_scan', 'Inbox', 1),
(482, 'mailbox_check_every', '3', 1),
(483, 'mailbox_only_loop_on_unseen_emails', '1', 1),
(484, 'theme_style', '[{\"id\":\"tag-1\",\"color\":\"#3e4ec1\"}]', 1),
(485, 'theme_style_custom_admin_area', '', 1),
(486, 'theme_style_custom_clients_area', '', 1),
(487, 'theme_style_custom_clients_and_admin_area', '', 1),
(488, 'auto_backup_enabled', '0', 1),
(489, 'auto_backup_every', '7', 1),
(490, 'last_auto_backup', '', 1),
(491, 'delete_backups_older_then', '0', 1),
(492, 'survey_send_emails_per_cron_run', '100', 1),
(493, 'last_survey_send_cron', '', 1),
(494, 'old_email_header', '                                        <!doctype html>\r\n                            <html>\r\n                            <head>\r\n                              <meta name=\"viewport\" content=\"width=device-width\" />\r\n                              <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\r\n                              <style>\r\n                                body {\r\n                                 background-color: #f6f6f6;\r\n                                 font-family: sans-serif;\r\n                                 -webkit-font-smoothing: antialiased;\r\n                                 font-size: 14px;\r\n                                 line-height: 1.4;\r\n                                 margin: 0;\r\n                                 padding: 0;\r\n                                 -ms-text-size-adjust: 100%;\r\n                                 -webkit-text-size-adjust: 100%;\r\n                               }\r\n                               table {\r\n                                 border-collapse: separate;\r\n                                 mso-table-lspace: 0pt;\r\n                                 mso-table-rspace: 0pt;\r\n                                 width: 100%;\r\n                               }\r\n                               table td {\r\n                                 font-family: sans-serif;\r\n                                 font-size: 14px;\r\n                                 vertical-align: top;\r\n                               }\r\n                                   /* -------------------------------------\r\n                                     BODY & CONTAINER\r\n                                     ------------------------------------- */\r\n                                     .body {\r\n                                       background-color: #f6f6f6;\r\n                                       width: 100%;\r\n                                     }\r\n                                     /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */\r\n\r\n                                     .container {\r\n                                       display: block;\r\n                                       margin: 0 auto !important;\r\n                                       /* makes it centered */\r\n                                       max-width: 680px;\r\n                                       padding: 10px;\r\n                                       width: 680px;\r\n                                     }\r\n                                     /* This should also be a block element, so that it will fill 100% of the .container */\r\n\r\n                                     .content {\r\n                                       box-sizing: border-box;\r\n                                       display: block;\r\n                                       margin: 0 auto;\r\n                                       max-width: 680px;\r\n                                       padding: 10px;\r\n                                     }\r\n                                   /* -------------------------------------\r\n                                     HEADER, FOOTER, MAIN\r\n                                     ------------------------------------- */\r\n\r\n                                     .main {\r\n                                       background: #fff;\r\n                                       border-radius: 3px;\r\n                                       width: 100%;\r\n                                     }\r\n                                     .wrapper {\r\n                                       box-sizing: border-box;\r\n                                       padding: 20px;\r\n                                     }\r\n                                     .footer {\r\n                                       clear: both;\r\n                                       padding-top: 10px;\r\n                                       text-align: center;\r\n                                       width: 100%;\r\n                                     }\r\n                                     .footer td,\r\n                                     .footer p,\r\n                                     .footer span,\r\n                                     .footer a {\r\n                                       color: #999999;\r\n                                       font-size: 12px;\r\n                                       text-align: center;\r\n                                     }\r\n                                     hr {\r\n                                       border: 0;\r\n                                       border-bottom: 1px solid #f6f6f6;\r\n                                       margin: 20px 0;\r\n                                     }\r\n                                   /* -------------------------------------\r\n                                     RESPONSIVE AND MOBILE FRIENDLY STYLES\r\n                                     ------------------------------------- */\r\n\r\n                                     @media only screen and (max-width: 620px) {\r\n                                       table[class=body] .content {\r\n                                         padding: 0 !important;\r\n                                       }\r\n                                       table[class=body] .container {\r\n                                         padding: 0 !important;\r\n                                         width: 100% !important;\r\n                                       }\r\n                                       table[class=body] .main {\r\n                                         border-left-width: 0 !important;\r\n                                         border-radius: 0 !important;\r\n                                         border-right-width: 0 !important;\r\n                                       }\r\n                                     }\r\n                                   </style>\r\n                                 </head>\r\n                                 <body class=\"\">\r\n                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\">\r\n                                    <tr>\r\n                                     <td> </td>\r\n                                     <td class=\"container\">\r\n                                      <div class=\"content\">\r\n                                        <!-- START CENTERED WHITE CONTAINER -->\r\n                                        <table class=\"main\">\r\n                                          <!-- START MAIN CONTENT AREA -->\r\n                                          <tr>\r\n                                           <td class=\"wrapper\">\r\n                                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                                              <tr>\r\n                                               <td>                                    ', 1),
(495, 'old_email_footer', '                                        </td>\r\n                             </tr>\r\n                           </table>\r\n                         </td>\r\n                       </tr>\r\n                       <!-- END MAIN CONTENT AREA -->\r\n                     </table>\r\n                     <!-- START FOOTER -->\r\n                     <div class=\"footer\">\r\n                      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                        <tr>\r\n                          <td class=\"content-block\">\r\n                            <span>{companyname}</span>\r\n                          </td>\r\n                        </tr>\r\n                      </table>\r\n                    </div>\r\n                    <!-- END FOOTER -->\r\n                    <!-- END CENTERED WHITE CONTAINER -->\r\n                  </div>\r\n                </td>\r\n                <td> </td>\r\n              </tr>\r\n            </table>\r\n            </body>\r\n            </html>                                    ', 1),
(496, 'perfex_email_builder_default_media_folder', 'babil_email_builder', 1),
(497, 'aside_custom_email_and_sms_notifications_active', '[]', 1),
(498, 'setup_custom_email_and_sms_notifications_active', '[]', 1),
(499, 'sms_trigger_appointly_appointment_approved_send_to_client', '', 0),
(500, 'sms_trigger_appointly_appointment_cancelled_to_client', '', 0),
(501, 'sms_trigger_appointly_appointment_reminder_to_client', '', 0),
(502, 'task_bookmarks_enabled', '1', 1),
(503, 'account_planning_enabled', '1', 1),
(504, 'organizational_competencies_type', '[{\"key\":\"\\u0645\\u0628\\u062a\\u062f\\u0649\\u0621\",\"value\":\"\\u0645\\u0628\\u062a\\u062f\\u0649\\u0621\"},{\"key\":\"\\u0645\\u062d\\u062a\\u0631\\u0641\",\"value\":\"\\u0645\\u062d\\u062a\\u0631\\u0641\"},{\"key\":\"\\u0645\\u062a\\u0648\\u0633\\u0637 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0629\",\"value\":\"\\u0645\\u062a\\u0648\\u0633\\u0637 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0629\"}]', 1),
(505, 'technical_competencies_type', '[{\"key\":\"Beginner\",\"value\":\"Beginner\"},{\"key\":\"Intermediate\",\"value\":\"Intermediate\"},{\"key\":\"Advanced\",\"value\":\"Advanced\"},{\"key\":\"Expert / Leader\",\"value\":\"Expert / Leader\"}]', 1),
(506, 'training_type', '[{\"key\":\"\\u062f\\u0648\\u0631\\u0629 \\u062a\\u062f\\u0631\\u064a\\u0628\\u064a\\u0629 \\u0623\\u0648\\u0646 \\u0644\\u0627\\u064a\\u0646\",\"value\":\"\\u062f\\u0648\\u0631\\u0629 \\u062a\\u062f\\u0631\\u064a\\u0628\\u064a\\u0629 \\u0623\\u0648\\u0646 \\u0644\\u0627\\u064a\\u0646\"}]', 1),
(507, 'award_type', '[{\"key\":\"\\u0627\\u0644\\u0645\\u0648\\u0638\\u0641 \\u0627\\u0644\\u0645\\u0645\\u064a\\u0632\",\"value\":\"\\u0627\\u0644\\u0645\\u0648\\u0638\\u0641 \\u0627\\u0644\\u0645\\u0645\\u064a\\u0632\"}]', 1),
(508, 'termination_type', '[{\"key\":\"\\u0625\\u0633\\u062a\\u0642\\u0627\\u0644\\u0629\",\"value\":\"\\u0625\\u0633\\u062a\\u0642\\u0627\\u0644\\u0629\"},{\"key\":\"\\u0641\\u0635\\u0644\",\"value\":\"\\u0641\\u0635\\u0644\"},{\"key\":\"\\u0625\\u0646\\u062a\\u0647\\u0627\\u0621 \\u0627\\u0644\\u0639\\u0642\\u062f\",\"value\":\"\\u0625\\u0646\\u062a\\u0647\\u0627\\u0621 \\u0627\\u0644\\u0639\\u0642\\u062f\"}]', 1),
(509, 'warning_type', '[{\"key\":\"\\u062a\\u0623\\u062e\\u064a\\u0631 \\u0645\\u062a\\u0643\\u0631\\u0631 \\u0644\\u0623\\u0643\\u062b\\u0631 \\u0645\\u0646 15 \\u062f\\u0642\\u064a\\u0642\\u0629\",\"value\":\"\\u062a\\u0623\\u062e\\u064a\\u0631 \\u0645\\u062a\\u0643\\u0631\\u0631 \\u0644\\u0623\\u0643\\u062b\\u0631 \\u0645\\u0646 15 \\u062f\\u0642\\u064a\\u0642\\u0629\"},{\"key\":\"\\u063a\\u064a\\u0627\\u0628\",\"value\":\"\\u063a\\u064a\\u0627\\u0628\"}]', 1),
(510, 'office_name_in_center', 'babil_law', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbloservicediscussioncomments`
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
  `contact_id` int(11) DEFAULT '0',
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbloservicediscussions`
--

CREATE TABLE `tbloservicediscussions` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `contact_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbloservice_activity`
--

CREATE TABLE `tbloservice_activity` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `fullname` varchar(100) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT '0',
  `description_key` varchar(191) NOT NULL COMMENT 'Language file key',
  `additional_data` text,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbloservice_activity`
--

INSERT INTO `tbloservice_activity` (`id`, `oservice_id`, `staff_id`, `contact_id`, `fullname`, `visible_to_customer`, `description_key`, `additional_data`, `dateadded`) VALUES
(1, 4, 0, 0, NULL, 1, 'LService_activity_updated', '', '2020-09-28 20:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbloservice_files`
--

CREATE TABLE `tbloservice_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `description` text,
  `filetype` varchar(50) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `oservice_id` int(11) NOT NULL,
  `visible_to_customer` tinyint(1) DEFAULT '0',
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `external` varchar(40) DEFAULT NULL,
  `external_link` text,
  `thumbnail_link` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbloservice_notes`
--

CREATE TABLE `tbloservice_notes` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbloservice_settings`
--

CREATE TABLE `tbloservice_settings` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment_modes`
--

CREATE TABLE `tblpayment_modes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `show_on_pdf` int(11) NOT NULL DEFAULT '0',
  `invoices_only` int(11) NOT NULL DEFAULT '0',
  `expenses_only` int(11) NOT NULL DEFAULT '0',
  `selected_by_default` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblpinned_cases`
--

CREATE TABLE `tblpinned_cases` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblpinned_oservices`
--

CREATE TABLE `tblpinned_oservices` (
  `id` int(11) NOT NULL,
  `oservice_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblpinned_projects`
--

CREATE TABLE `tblpinned_projects` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocurations`
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
  `not_visible_to_client` tinyint(1) NOT NULL DEFAULT '0',
  `addedfrom` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `deadline_notified` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocuration_cases`
--

CREATE TABLE `tblprocuration_cases` (
  `id` int(11) NOT NULL,
  `procuration` int(11) NOT NULL,
  `_case` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectdiscussioncomments`
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
  `contact_id` int(11) DEFAULT '0',
  `fullname` varchar(191) DEFAULT NULL,
  `file_name` varchar(191) DEFAULT NULL,
  `file_mime_type` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectdiscussions`
--

CREATE TABLE `tblprojectdiscussions` (
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

-- --------------------------------------------------------

--
-- Table structure for table `tblprojects`
--

CREATE TABLE `tblprojects` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `clientid` int(11) NOT NULL,
  `billing_type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `project_created` date NOT NULL,
  `date_finished` datetime DEFAULT NULL,
  `progress` int(11) DEFAULT '0',
  `progress_from_tasks` int(11) NOT NULL DEFAULT '1',
  `project_cost` decimal(15,2) DEFAULT NULL,
  `project_rate_per_hour` decimal(15,2) DEFAULT NULL,
  `estimated_hours` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `project_type` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproject_activity`
--

CREATE TABLE `tblproject_activity` (
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

-- --------------------------------------------------------

--
-- Table structure for table `tblproject_files`
--

CREATE TABLE `tblproject_files` (
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

-- --------------------------------------------------------

--
-- Table structure for table `tblproject_members`
--

CREATE TABLE `tblproject_members` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproject_notes`
--

CREATE TABLE `tblproject_notes` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproject_settings`
--

CREATE TABLE `tblproject_settings` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproposals`
--

CREATE TABLE `tblproposals` (
  `id` int(11) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `content` longtext,
  `addedfrom` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `adjustment` decimal(15,2) DEFAULT NULL,
  `discount_percent` decimal(15,2) NOT NULL,
  `discount_total` decimal(15,2) NOT NULL,
  `discount_type` varchar(30) DEFAULT NULL,
  `show_quantity_as` int(11) NOT NULL DEFAULT '1',
  `currency` int(11) NOT NULL,
  `open_till` date DEFAULT NULL,
  `date` date NOT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(40) DEFAULT NULL,
  `assigned` int(11) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `proposal_to` varchar(191) DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT '0',
  `zip` varchar(50) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `allow_comments` tinyint(1) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL,
  `estimate_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `date_converted` datetime DEFAULT NULL,
  `pipeline_order` int(11) NOT NULL DEFAULT '0',
  `is_expiry_notified` int(11) NOT NULL DEFAULT '0',
  `acceptance_firstname` varchar(50) DEFAULT NULL,
  `acceptance_lastname` varchar(50) DEFAULT NULL,
  `acceptance_email` varchar(100) DEFAULT NULL,
  `acceptance_date` datetime DEFAULT NULL,
  `acceptance_ip` varchar(40) DEFAULT NULL,
  `signature` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproposal_comments`
--

CREATE TABLE `tblproposal_comments` (
  `id` int(11) NOT NULL,
  `content` mediumtext,
  `proposalid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblrelated_items`
--

CREATE TABLE `tblrelated_items` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(30) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblreminders`
--

CREATE TABLE `tblreminders` (
  `id` int(11) NOT NULL,
  `description` text,
  `date` datetime NOT NULL,
  `isnotified` int(11) NOT NULL DEFAULT '0',
  `rel_id` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `rel_type` varchar(40) NOT NULL,
  `notify_by_email` int(11) NOT NULL DEFAULT '1',
  `creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblroles`
--

CREATE TABLE `tblroles` (
  `roleid` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `permissions` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsales_activity`
--

CREATE TABLE `tblsales_activity` (
  `id` int(11) NOT NULL,
  `rel_type` varchar(20) DEFAULT NULL,
  `rel_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `additional_data` text,
  `staffid` varchar(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblscheduled_emails`
--

CREATE TABLE `tblscheduled_emails` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(15) NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `contacts` varchar(197) NOT NULL,
  `cc` text,
  `attach_pdf` tinyint(1) NOT NULL DEFAULT '1',
  `template` varchar(197) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblservices`
--

CREATE TABLE `tblservices` (
  `serviceid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsessions`
--

CREATE TABLE `tblsessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblsessions`
--

INSERT INTO `tblsessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('18ktd503d7p2972kiobeivrnue16d0d3', '::1', 1601652646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323634353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('18ltn1oevc1r07649mibu87d1r4pnrvc', '::1', 1601656169, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635353937353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('1heqivgc1k2oi05t0ehuiaq6bghecn2p', '::1', 1601647846, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634373439323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('1s5rc951rlag3or12cnd42t8j7a488g5', '::1', 1601635030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633343939313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('20kditqqvhu8eh0k4qjnej2dg3sb95od', '::1', 1601642206, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634323036353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('24lndrt8d5q0a3jkkc3gbdks24fj0maj', '::1', 1601636472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633363135323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('2l6cgeq5hif72f2ev1vs634v52hjtsl3', '::1', 1601636543, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633363437333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('32bbgupr0c5m6ru0la274r62mgal1j3v', '::1', 1601627471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373435343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('3rd90f1qmhd8seud0ubb94sic4hvn9q8', '::1', 1601653093, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323739323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('44tteideu7aplbnklom3des235dma6hp', '::1', 1601648473, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634383437323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('4a3k94649g4ok0u3jh9n6n6h6bf9a56v', '::1', 1601652019, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635313732373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('4v7jjbajv4gkgcbss81plblts87mb3bf', '::1', 1601653797, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635333730343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('500iujhk186np9b2d8187frjv26ejfn0', '::1', 1601629789, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632393738363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('50hvj6c3jmm8b7iq1cfh68f0on11h8sh', '::1', 1601634513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633343338363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5eqfr7l3l6t3uqf3t0dv4vs6ibfq9ave', '::1', 1601640734, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634303731343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5hhqridv1b1b9f7fdb1b624s2iokf3m6', '::1', 1601629159, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383835383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5jj88t28nt2o5kaghpbppgbv9ov1ep0q', '::1', 1601634463, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633343136303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5m17ov4kpts2cboiq68r8i36kbu8mssf', '::1', 1601627913, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373538313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('5qlrg1gjdk19m4ncbqomd6n327lca0pf', '::1', 1601635471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633353036343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('613po87a2svcmcnhrtra6g4li3pm6pd6', '::1', 1601638520, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633383531323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('6989ghicqosujsbuachf6o1uv2ivqe29', '::1', 1601651583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635313434333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('745qu1r664tajnagmbpoc6fei8ffqm13', '::1', 1601648472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634383136333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('75sj1jghe8607feepfshc9b92c7eibf0', '::1', 1601626389, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632363037313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('7672liravrogha9mb447u5i3ev8l5n7o', '::1', 1601652476, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323132323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('78f3q64p8u1l6n9ug2bod30dsvdkmb6l', '::1', 1601626394, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632363338393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('7jv8emngv8vmc3acf4dosh80hf266odt', '::1', 1601640710, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634303230363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('81df0ovsedcibo6ruqdcrik2bvtsaul2', '::1', 1601637473, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633373136313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('83tj0lce2p8kvtt6dimgiipofc3heq94', '::1', 1601650640, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635303334383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('844n41up1tsefjinfbj9jv5k0k6g39ts', '::1', 1601647849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634373834383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('8h8ec0iubl0drlu5pdtgi2dsrcv6itr6', '::1', 1601652257, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323235373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('8i7gfn4lu3uasii669dhrd9d1ccbuhin', '::1', 1601648786, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634383437333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('8nrsc3l4a68pl048q6j2rtefbd4hvroj', '::1', 1601628267, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383236363b),
('91a3kubm9q7r2takdafm3p62n8saom55', '::1', 1601652877, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323634363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('95lk57r77q3de6il6idjl2e84rip13mh', '::1', 1601643077, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634323737343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('960j4tkurv8hns426uhmv8u20vab0ac2', '::1', 1601652645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323235393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('b34buhfmuampeor42arpq9i01m2n2r1j', '::1', 1601649322, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634393133383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('c0f90r1462j2k1d1fn8ker24cngvq4c6', '::1', 1601650328, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635303038313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('cfbsho6ortnq5k5t55nho3p2v3vbqd9u', '::1', 1601634142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633333835323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('dli1b4p4ivr8ru358m3ljagnuvc0ch12', '::1', 1601627452, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373135303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('dsoduoih8ht3og14enp1jvml497lq2ks', '::1', 1601628110, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383131303b7265645f75726c7c733a35343a22687474703a2f2f6c6f63616c686f73742f6f66666963655f312f61646d696e2f73657474696e67733f67726f75703d67656e6572616c223b),
('e8qsnv5pe5qkvq5vd8rk7ru6ch4rg26b', '::1', 1601638187, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633383036333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('epa2kvtkgig2nopbr4tsn2arb8n3qbbh', '::1', 1601637162, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633363835373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('fdu9ajuhc8afgjgjitaplls0sopco85m', '::1', 1601651441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635313237393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('fh8e9q26ofeaumn06lbhsocn5sev88hq', '::1', 1601636086, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633353830353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('fq8n7m5c14qai6t2j6fv47lavqdpnbiu', '::1', 1601633726, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633333534353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('fvk8tl8j1m311kvl4pqfi6eal3ikube9', '::1', 1601653294, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323938383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('g4slnii9ng31irgdom9amv46fluq63t4', '::1', 1601648471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634383437303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('h0npcqpcj5mgumu4u84f11n0677dfrqv', '::1', 1601642545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634323236323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('h0o5b9oa99t83hurqm6dekf5bi7d5edc', '::1', 1601650522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635303237353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('h1tiv0d4r4g7nltvdo5k3pbrcc317fva', '::1', 1601653301, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635333239373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('hhb926kpmjc67imdb9euq4n71hm5qkbi', '::1', 1601628593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383331353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('homrbno5bbt9fjkaqsjjhn2sifu6tq82', '::1', 1601626925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632363431363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ht78rjinlfv108ub3bal6o5djk3entl4', '::1', 1601628060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373737323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b6d6573736167652d737563636573737c733a32393a22d8aad8add8afd98ad8ab20d8a7d984d8a5d8b9d8afd8a7d8afd8a7d8aa223b5f5f63695f766172737c613a313a7b733a31353a226d6573736167652d73756363657373223b733a333a226f6c64223b7d),
('i883lcrruol7jmgr3m59bugevp5d72ja', '::1', 1601649030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634383832353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('is88tn9jrboku8advqbd02l2clcb8kvq', '::1', 1601640160, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633393839343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('jr1nl3qi2j9vqhsup6919214viu7qp7s', '::1', 1601653138, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635333130333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('kfgpoa2l2cm0l6fll419iljj11c0svn9', '::1', 1601655318, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635353033383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('kiubfabkddpaulc5a0vs6eqi1d77lqc6', '::1', 1601648163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634373834393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('kkhpfv7gb14oo5f33uqcfkvsknthtukb', '::1', 1601630574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633303333313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('krbndfac1b2b6mgl0ech69hkbuep18f0', '::1', 1601642165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634323136343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('l3o5mdhmt1qv3rii6q7lh8jtfj3tbjtl', '::1', 1601641559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634313430323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('l9gqc1hftpobpk41l8f03vsq17pv8km7', '::1', 1601628265, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383236333b7265645f75726c7c733a33313a22687474703a2f2f6c6f63616c686f73742f6f66666963655f312f61646d696e223b),
('lhenr6cud4vlr8iv9e38cilqbuq6qh5c', '::1', 1601629463, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632393135393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('m2htqhcfoqm2r3da5pk52a4mnaupibem', '::1', 1601643397, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634333135353b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('mo15bq8uagldbr8149tmdo597to986v8', '::1', 1601656166, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635353839383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('nbfvtdanminu246c8qn2dr80qi8busss', '::1', 1601627581, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373537383b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('obki1pdd5kdj646okdf0089ru5f2isfh', '::1', 1601649794, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634393533303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ot3qhofepk6e9l0krlpd7703qfa2gkg9', '::1', 1601641398, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634313039303b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('p2p1filogqiei5vv9jmbjuv1v9f95n8v', '::1', 1601637842, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633373639363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('pib2gvv6n1aervabk29e181k00ceo3m9', '::1', 1601634702, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633343436333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('pot56646nbl6apq2sb4g93eata50b6kn', '::1', 1601626416, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632363431333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('puq911pvu34q78q87bgh9gb6uepdhj4j', '::1', 1601628534, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383232363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('q2u0bo0ovtumho24qt4o9p2bu6igjdtm', '::1', 1601642163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634313730373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('q8vdff61bbnkmva1qf11q6e0pj8eesrq', '::1', 1601631406, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633313430333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('qcjj6gbq40rdtqbe0lkj4116a1c205h0', '::1', 1601655894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635353534333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('qhepcq2tdsc2vft3lcut0etepfc2csna', '::1', 1601652259, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323235393b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('r3e3lss4mi38i6j3tv3655c6lsc11lvq', '::1', 1601629786, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632393436323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('r66qh5mlp1gpn11vveqmmdpd8g9rs3mb', '::1', 1601639995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633393839343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('sk20rmljn7o7peh41ptri69etefd1mhv', '::1', 1601628767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632383533323b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('smt6bcil96npsgja0jh8pgp57ag62o78', '::1', 1601627914, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373931333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b6d6573736167652d737563636573737c733a32393a22d8aad8add8afd98ad8ab20d8a7d984d8a5d8b9d8afd8a7d8afd8a7d8aa223b5f5f63695f766172737c613a313a7b733a31353a226d6573736167652d73756363657373223b733a333a226e6577223b7d),
('t1n61m0alsk46ijglnjh24li4bebnlro', '::1', 1601652680, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323437363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('u6u2g5bs2tklnqt2na8s9n6r353gq8a2', '::1', 1601633464, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633333234333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ua4jk0arkr8k4njln07m3raq4cgco2qc', '::1', 1601628207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313632373931343b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('ugeskh7r76l2p55vutks8hbma3punf8j', '::1', 1601652258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635323235373b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('v2v69g8edde8fef96rm6i3aunj1hag9d', '::1', 1601647848, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313634373834363b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c733a303a22223b),
('vdg1dkfr8ro6gr851qbief2i52t7tb1i', '::1', 1601652257, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313635313836333b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b),
('vjntvblj3akh2bcjhprc7qhq81cpiteq', '::1', 1601635804, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313633353437313b73746166665f757365725f69647c733a313a2231223b73746166665f6c6f676765645f696e7c623a313b73657475702d6d656e752d6f70656e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `tblshared_customer_files`
--

CREATE TABLE `tblshared_customer_files` (
  `file_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblspam_filters`
--

CREATE TABLE `tblspam_filters` (
  `id` int(11) NOT NULL,
  `type` varchar(40) NOT NULL,
  `rel_type` varchar(10) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblstaff`
--

CREATE TABLE `tblstaff` (
  `staffid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `facebook` mediumtext,
  `linkedin` mediumtext,
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
  `admin` int(11) NOT NULL DEFAULT '0',
  `role` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `default_language` varchar(40) DEFAULT NULL,
  `direction` varchar(3) DEFAULT NULL,
  `media_path_slug` varchar(191) DEFAULT NULL,
  `is_not_staff` int(11) NOT NULL DEFAULT '0',
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `two_factor_auth_enabled` tinyint(1) DEFAULT '0',
  `two_factor_auth_code` varchar(100) DEFAULT NULL,
  `two_factor_auth_code_requested` datetime DEFAULT NULL,
  `email_signature` text,
  `mail_password` varchar(250) DEFAULT NULL,
  `last_email_check` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblstaff`
--

INSERT INTO `tblstaff` (`staffid`, `email`, `firstname`, `lastname`, `facebook`, `linkedin`, `phonenumber`, `skype`, `password`, `datecreated`, `profile_image`, `last_ip`, `last_login`, `last_activity`, `last_password_change`, `new_pass_key`, `new_pass_key_requested`, `admin`, `role`, `active`, `default_language`, `direction`, `media_path_slug`, `is_not_staff`, `hourly_rate`, `two_factor_auth_enabled`, `two_factor_auth_code`, `two_factor_auth_code_requested`, `email_signature`, `mail_password`, `last_email_check`) VALUES
(1, 'admin@babillawnet.com', 'Mhdbashar', ' ', '', '', '966566664074', 'm.almuslat', '$2a$08$JJ4pffim0G5twlrWkQPc6u0VVwlDdZPvyn4rbHz3l7uclgmHLHeyq', '2019-07-18 10:29:15', 'IMG_0101.jpg', '::1', '2020-10-02 17:52:33', '2020-10-02 19:29:29', NULL, NULL, NULL, 1, 3, 1, 'arabic', '', NULL, 0, '0.00', 0, NULL, '2019-12-07 10:20:05', '', 'wp9h@fdw}BMx', '1590835502'),
(2, 'new@babil.com', 'موظف جديد', ' ', '', '', '', '', '$2a$08$h6b1mmjH6BtTKLTCVZURw.iGzUtmYkk0SUJUQvVoxexo55B/aTCDa', '2020-06-01 19:37:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '', '', 'mothf-gdyd', 0, '2.00', 0, NULL, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblstaff_departments`
--

CREATE TABLE `tblstaff_departments` (
  `staffdepartmentid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblstaff_permissions`
--

CREATE TABLE `tblstaff_permissions` (
  `staff_id` int(11) NOT NULL,
  `feature` varchar(40) NOT NULL,
  `capability` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsubscriptions`
--

CREATE TABLE `tblsubscriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text,
  `description_in_item` tinyint(1) NOT NULL DEFAULT '0',
  `clientid` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `terms` text,
  `currency` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `stripe_tax_id` varchar(50) DEFAULT NULL,
  `stripe_plan_id` text,
  `stripe_subscription_id` text NOT NULL,
  `next_billing_cycle` bigint(20) DEFAULT NULL,
  `ends_at` bigint(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `project_id` int(11) NOT NULL DEFAULT '0',
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `created_from` int(11) NOT NULL,
  `date_subscribed` datetime DEFAULT NULL,
  `in_test_environment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsurveyresultsets`
--

CREATE TABLE `tblsurveyresultsets` (
  `resultsetid` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `useragent` varchar(150) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsurveys`
--

CREATE TABLE `tblsurveys` (
  `surveyid` int(11) NOT NULL,
  `subject` mediumtext NOT NULL,
  `slug` mediumtext NOT NULL,
  `description` text NOT NULL,
  `viewdescription` text,
  `datecreated` datetime NOT NULL,
  `redirect_url` varchar(100) DEFAULT NULL,
  `send` tinyint(1) NOT NULL DEFAULT '0',
  `onlyforloggedin` int(11) DEFAULT '0',
  `fromname` varchar(100) DEFAULT NULL,
  `iprestrict` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `hash` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsurveysemailsendcron`
--

CREATE TABLE `tblsurveysemailsendcron` (
  `id` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `emailid` int(11) DEFAULT NULL,
  `listid` varchar(11) DEFAULT NULL,
  `log_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsurveysendlog`
--

CREATE TABLE `tblsurveysendlog` (
  `id` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `iscronfinished` int(11) NOT NULL DEFAULT '0',
  `send_to_mail_lists` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltaggables`
--

CREATE TABLE `tbltaggables` (
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `tag_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltags`
--

CREATE TABLE `tbltags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltasks`
--

CREATE TABLE `tbltasks` (
  `id` int(11) NOT NULL,
  `name` mediumtext,
  `description` text,
  `priority` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `startdate` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `datefinished` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `is_added_from_contact` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT '0',
  `is_recurring_from` int(11) DEFAULT NULL,
  `cycles` int(11) NOT NULL DEFAULT '0',
  `total_cycles` int(11) NOT NULL DEFAULT '0',
  `custom_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `last_recurring_date` date DEFAULT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(30) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `billable` tinyint(1) NOT NULL DEFAULT '0',
  `billed` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `milestone` int(11) DEFAULT '0',
  `kanban_order` int(11) NOT NULL DEFAULT '0',
  `milestone_order` int(11) NOT NULL DEFAULT '0',
  `visible_to_client` tinyint(1) NOT NULL DEFAULT '0',
  `deadline_notified` int(11) NOT NULL DEFAULT '0',
  `is_session` int(11) DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltaskstimers`
--

CREATE TABLE `tbltaskstimers` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `start_time` varchar(64) NOT NULL,
  `end_time` varchar(64) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltasks_checklist_templates`
--

CREATE TABLE `tbltasks_checklist_templates` (
  `id` int(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltask_assigned`
--

CREATE TABLE `tbltask_assigned` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `assigned_from` int(11) NOT NULL DEFAULT '0',
  `is_assigned_from_contact` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltask_checklist_items`
--

CREATE TABLE `tbltask_checklist_items` (
  `id` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `description` text NOT NULL,
  `finished` int(11) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL,
  `addedfrom` int(11) NOT NULL,
  `finished_from` int(11) DEFAULT '0',
  `list_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltask_comments`
--

CREATE TABLE `tbltask_comments` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `taskid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `file_id` int(11) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltask_followers`
--

CREATE TABLE `tbltask_followers` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltaxes`
--

CREATE TABLE `tbltaxes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `taxrate` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltickets`
--

CREATE TABLE `tbltickets` (
  `ticketid` int(11) NOT NULL,
  `adminreplying` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL,
  `contactid` int(11) NOT NULL DEFAULT '0',
  `email` text,
  `name` text,
  `department` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `service` int(11) DEFAULT NULL,
  `ticketkey` varchar(32) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text,
  `admin` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `lastreply` datetime DEFAULT NULL,
  `clientread` int(11) NOT NULL DEFAULT '0',
  `adminread` int(11) NOT NULL DEFAULT '0',
  `assigned` int(11) NOT NULL DEFAULT '0',
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(30) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltickets_pipe_log`
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
-- Table structure for table `tbltickets_predefined_replies`
--

CREATE TABLE `tbltickets_predefined_replies` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltickets_priorities`
--

CREATE TABLE `tbltickets_priorities` (
  `priorityid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbltickets_priorities`
--

INSERT INTO `tbltickets_priorities` (`priorityid`, `name`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High');

-- --------------------------------------------------------

--
-- Table structure for table `tbltickets_status`
--

CREATE TABLE `tbltickets_status` (
  `ticketstatusid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `isdefault` int(11) NOT NULL DEFAULT '0',
  `statuscolor` varchar(7) DEFAULT NULL,
  `statusorder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbltickets_status`
--

INSERT INTO `tbltickets_status` (`ticketstatusid`, `name`, `isdefault`, `statuscolor`, `statusorder`) VALUES
(1, 'Open', 1, '#ff2d42', 1),
(2, 'In progress', 1, '#84c529', 2),
(3, 'Answered', 1, '#0000ff', 3),
(4, 'On Hold', 1, '#c0c0c0', 4),
(5, 'Closed', 1, '#03a9f4', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tblticket_attachments`
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
-- Table structure for table `tblticket_replies`
--

CREATE TABLE `tblticket_replies` (
  `id` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `contactid` int(11) NOT NULL DEFAULT '0',
  `name` text,
  `email` text,
  `date` datetime NOT NULL,
  `message` text,
  `attachment` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbltodos`
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
-- Table structure for table `tbltracked_mails`
--

CREATE TABLE `tbltracked_mails` (
  `id` int(11) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT '0',
  `date_opened` datetime DEFAULT NULL,
  `subject` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser_api`
--

CREATE TABLE `tbluser_api` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser_auto_login`
--

CREATE TABLE `tbluser_auto_login` (
  `key_id` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staff` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbluser_auto_login`
--

INSERT INTO `tbluser_auto_login` (`key_id`, `user_id`, `user_agent`, `last_ip`, `last_login`, `staff`) VALUES
('cdb15865006e3315845f51f494cf85e5', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36 Edg/85.0.564.63', '::1', '2020-09-28 17:38:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser_meta`
--

CREATE TABLE `tbluser_meta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `client_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `contact_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(191) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbluser_meta`
--

INSERT INTO `tbluser_meta` (`umeta_id`, `staff_id`, `client_id`, `contact_id`, `meta_key`, `meta_value`) VALUES
(1, 0, 0, 1, 'consent_key', 'c61919adc6eb16a433b0207e2851d6a9-2385069757c2976482648ad05f61c98c'),
(2, 1, 0, 0, 'dashboard_widgets_visibility', NULL),
(3, 1, 0, 0, 'dashboard_widgets_order', NULL),
(4, 0, 0, 2, 'consent_key', '480660f2c1f3c82453b1db31d66def73-be6efad2a69b280396abf5c695e2a002'),
(5, 1, 0, 0, 'recent_searches', '[\"ahmad\",\"#ahmad\",\"#ah\",\"#a\",\"#i\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tblvault`
--

CREATE TABLE `tblvault` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `server_address` varchar(191) NOT NULL,
  `port` int(11) DEFAULT NULL,
  `username` varchar(191) NOT NULL,
  `password` text NOT NULL,
  `description` text,
  `creator` int(11) NOT NULL,
  `creator_name` varchar(100) DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `share_in_projects` tinyint(1) NOT NULL DEFAULT '0',
  `last_updated` datetime DEFAULT NULL,
  `last_updated_from` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblviews_tracking`
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
-- Table structure for table `tblweb_to_lead`
--

CREATE TABLE `tblweb_to_lead` (
  `id` int(11) NOT NULL,
  `form_key` varchar(32) NOT NULL,
  `lead_source` int(11) NOT NULL,
  `lead_status` int(11) NOT NULL,
  `notify_lead_imported` int(11) NOT NULL DEFAULT '1',
  `notify_type` varchar(20) DEFAULT NULL,
  `notify_ids` mediumtext,
  `responsible` int(11) NOT NULL DEFAULT '0',
  `name` varchar(191) NOT NULL,
  `form_data` mediumtext,
  `recaptcha` int(11) NOT NULL DEFAULT '0',
  `submit_btn_name` varchar(40) DEFAULT NULL,
  `success_submit_msg` text,
  `language` varchar(40) DEFAULT NULL,
  `allow_duplicate` int(11) NOT NULL DEFAULT '1',
  `mark_public` int(11) NOT NULL DEFAULT '0',
  `track_duplicate_field` varchar(20) DEFAULT NULL,
  `track_duplicate_field_and` varchar(20) DEFAULT NULL,
  `create_task_on_duplicate` int(11) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perfex_email_builder`
--

CREATE TABLE `tbl_perfex_email_builder` (
  `id` int(11) NOT NULL,
  `emailtemplateid` varchar(4) NOT NULL,
  `emailObject` text NOT NULL,
  `template` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
-- Indexes for table `tblcategory_types`
--
ALTER TABLE `tblcategory_types`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `contract_type` (`contract_type`),
  ADD KEY `type_id` (`type_id`);

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
-- Indexes for table `tblemaillists`
--
ALTER TABLE `tblemaillists`
  ADD PRIMARY KEY (`listid`);

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
-- Indexes for table `tblgoals`
--
ALTER TABLE `tblgoals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tblinventory_history`
--
ALTER TABLE `tblinventory_history`
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
-- Indexes for table `tblirac_method`
--
ALTER TABLE `tblirac_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbliservice_settings`
--
ALTER TABLE `tbliservice_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oservice_id` (`oservice_id`);

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
-- Indexes for table `tbllegal_procedures`
--
ALTER TABLE `tbllegal_procedures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_key` (`list_id`);

--
-- Indexes for table `tbllegal_procedures_lists`
--
ALTER TABLE `tbllegal_procedures_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbllistemails`
--
ALTER TABLE `tbllistemails`
  ADD PRIMARY KEY (`emailid`);

--
-- Indexes for table `tblmaillistscustomfields`
--
ALTER TABLE `tblmaillistscustomfields`
  ADD PRIMARY KEY (`customfieldid`);

--
-- Indexes for table `tblmaillistscustomfieldvalues`
--
ALTER TABLE `tblmaillistscustomfieldvalues`
  ADD PRIMARY KEY (`customfieldvalueid`),
  ADD KEY `listid` (`listid`),
  ADD KEY `customfieldid` (`customfieldid`);

--
-- Indexes for table `tblmail_attachment`
--
ALTER TABLE `tblmail_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmail_inbox`
--
ALTER TABLE `tblmail_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmail_outbox`
--
ALTER TABLE `tblmail_outbox`
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
  ADD KEY `CateServKey` (`service_id`),
  ADD KEY `categoty_type_key` (`type_id`);

--
-- Indexes for table `tblmy_courts`
--
ALTER TABLE `tblmy_courts`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tblmy_customers_company_groups`
--
ALTER TABLE `tblmy_customers_company_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_customer_company_groups`
--
ALTER TABLE `tblmy_customer_company_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_customer_representative`
--
ALTER TABLE `tblmy_customer_representative`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_dialog_boxes`
--
ALTER TABLE `tblmy_dialog_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_employee_basic`
--
ALTER TABLE `tblmy_employee_basic`
  ADD PRIMARY KEY (`employee_basic_id`);

--
-- Indexes for table `tblmy_imported_services`
--
ALTER TABLE `tblmy_imported_services`
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
-- Indexes for table `tblmy_members_movement_cases`
--
ALTER TABLE `tblmy_members_movement_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `project_id` (`case_mov_id`);

--
-- Indexes for table `tblmy_members_services`
--
ALTER TABLE `tblmy_members_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tblmy_other_services`
--
ALTER TABLE `tblmy_other_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_phase_data`
--
ALTER TABLE `tblmy_phase_data`
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
-- Indexes for table `tblmy_services_tags`
--
ALTER TABLE `tblmy_services_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmy_service_phases`
--
ALTER TABLE `tblmy_service_phases`
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
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `tblmy_transactions`
--
ALTER TABLE `tblmy_transactions`
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
-- Indexes for table `tblscheduled_emails`
--
ALTER TABLE `tblscheduled_emails`
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
-- Indexes for table `tblsurveyresultsets`
--
ALTER TABLE `tblsurveyresultsets`
  ADD PRIMARY KEY (`resultsetid`);

--
-- Indexes for table `tblsurveys`
--
ALTER TABLE `tblsurveys`
  ADD PRIMARY KEY (`surveyid`);

--
-- Indexes for table `tblsurveysemailsendcron`
--
ALTER TABLE `tblsurveysemailsendcron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsurveysendlog`
--
ALTER TABLE `tblsurveysendlog`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tbluser_api`
--
ALTER TABLE `tbluser_api`
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
-- Indexes for table `tbl_perfex_email_builder`
--
ALTER TABLE `tbl_perfex_email_builder`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblannouncements`
--
ALTER TABLE `tblannouncements`
  MODIFY `announcementid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcasediscussioncomments`
--
ALTER TABLE `tblcasediscussioncomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcasediscussions`
--
ALTER TABLE `tblcasediscussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcase_activity`
--
ALTER TABLE `tblcase_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcase_files`
--
ALTER TABLE `tblcase_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcase_movement`
--
ALTER TABLE `tblcase_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcase_notes`
--
ALTER TABLE `tblcase_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcase_settings`
--
ALTER TABLE `tblcase_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcategory_types`
--
ALTER TABLE `tblcategory_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcities`
--
ALTER TABLE `tblcities`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `tblclients`
--
ALTER TABLE `tblclients`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcontact_permissions`
--
ALTER TABLE `tblcontact_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblcustomers_groups`
--
ALTER TABLE `tblcustomers_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `departmentid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbldismissed_announcements`
--
ALTER TABLE `tbldismissed_announcements`
  MODIFY `dismissedannouncementid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblemaillists`
--
ALTER TABLE `tblemaillists`
  MODIFY `listid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblemailtemplates`
--
ALTER TABLE `tblemailtemplates`
  MODIFY `emailtemplateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `tblestimates`
--
ALTER TABLE `tblestimates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblevents`
--
ALTER TABLE `tblevents`
  MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblexpenses`
--
ALTER TABLE `tblexpenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblexpenses_categories`
--
ALTER TABLE `tblexpenses_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `tblgoals`
--
ALTER TABLE `tblgoals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblinventory_history`
--
ALTER TABLE `tblinventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblinvoicepaymentrecords`
--
ALTER TABLE `tblinvoicepaymentrecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblirac_method`
--
ALTER TABLE `tblirac_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbliservice_settings`
--
ALTER TABLE `tbliservice_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1145;

--
-- AUTO_INCREMENT for table `tblitemable`
--
ALTER TABLE `tblitemable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblitems`
--
ALTER TABLE `tblitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblknowledge_base_groups`
--
ALTER TABLE `tblknowledge_base_groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblleads`
--
ALTER TABLE `tblleads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblleads_sources`
--
ALTER TABLE `tblleads_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmy_imported_services`
--
ALTER TABLE `tblmy_imported_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbloservice_activity`
--
ALTER TABLE `tbloservice_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluser_api`
--
ALTER TABLE `tbluser_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

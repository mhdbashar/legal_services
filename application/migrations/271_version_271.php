<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_271 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        // Options
        add_option('automatically_resend_disputes_invoice_overdue_reminder_after', '-3');
        add_option('automatically_send_disputes_invoice_overdue_reminder_after', '1');
        add_option('next_disputes_invoice_number', '6');
        add_option('automatically_send_lawyer_daily_agenda', '7');
        add_option('hr_document_reminder_notification_before', '1');
        add_option('isHijri', 'off');
        add_option('hijri_format', 'Y-m-d|%Y-%m-%d|hijri');
        add_option('hijri_pages', '["Case\/add","group=CaseSession","procuration"]');
        add_option('automatically_reminders_before_empty_recycle_bin_days', '1');
        add_option('automatically_empty_recycle_bin_after_days', '1');

        //Tables

        if (!$this->db->table_exists(db_prefix() . 'my_link_services')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_link_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `rel_id` int(11) NOT NULL,
              `service_id` int(11) NOT NULL,
              `to_rel_id` int(11) NOT NULL,
              `to_service_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'procuration_cases')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'procuration_cases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `procuration` int(11) NOT NULL,
              `_case` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'procurations')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'procurations` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
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
              `case_id` int(11) DEFAULT NULL,
              `deadline_notified` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_procurationtype')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_procurationtype` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `procurationtype` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_procurationstate')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_procurationstate` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `procurationstate` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        // Add new table tblmy_courts

        if (!$this->db->table_exists(db_prefix() . 'my_courts')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_courts` (
              `c_id` int(11)  NOT NULL AUTO_INCREMENT,
              `court_name` varchar(250) NOT NULL,
              `is_default` int(1) NOT NULL DEFAULT "0",
              `datecreated` date NOT NULL, 
              PRIMARY KEY (`c_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            // insert default value table tblmy_courts
            $this->db->query("INSERT INTO `".db_prefix()."my_courts` (`c_id`, `court_name`, `is_default`, `datecreated`) VALUES
            (1, 'nothing_was_specified', 1, NOW())");
        }

        if (!$this->db->field_exists('is_default',  db_prefix() . 'my_courts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_courts` ADD `is_default` int(1) NOT NULL DEFAULT "0";');
            $this->db->query("INSERT INTO `".db_prefix()."my_courts` ( `court_name`, `is_default`, `datecreated`) VALUES
            ('nothing_was_specified', 1, NOW())");
        }

        // Add new table tblmy_judicialdept

        if (!$this->db->table_exists(db_prefix() . 'my_judicialdept')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_judicialdept` (
              `j_id` int(11)  NOT NULL AUTO_INCREMENT,
              `Jud_number` varchar(255) NOT NULL,
              `c_id` int(255) NOT NULL,
              `is_default` int(1) NOT NULL DEFAULT "0",
              `datecreated` datetime NOT NULL,
              PRIMARY KEY (`j_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `".db_prefix()."my_judicialdept`
              ADD KEY `CourtJudKey` (`c_id`);");
            $this->db->query("ALTER TABLE `".db_prefix()."my_judicialdept` ADD CONSTRAINT `CourtJudKey` FOREIGN KEY (`c_id`) REFERENCES `".db_prefix()."my_courts` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;
              ");

            // insert default value table tblmy_judicialdept
            $this->db->query("INSERT INTO `".db_prefix()."my_judicialdept` (`j_id`, `Jud_number`, `c_id`, `is_default`, `datecreated`) VALUES
              (1, 'nothing_was_specified', 1, 1, NOW());");
        }

        if (!$this->db->field_exists('is_default',  db_prefix() . 'my_judicialdept')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_judicialdept` ADD `is_default` int(1) NOT NULL DEFAULT "0";');
            $this->db->query("INSERT INTO `".db_prefix()."my_judicialdept` (`Jud_number`, `c_id`, `is_default`, `datecreated`) VALUES
                  ('nothing_was_specified', 1, 1, NOW());");
        }

        if (!$this->db->table_exists(db_prefix() . 'casediscussioncomments')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'casediscussioncomments` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `discussion_id` int(11) NOT NULL,
              `discussion_type` varchar(10) NOT NULL,
              `parent` int(11) DEFAULT NULL,
              `created` datetime NOT NULL,
              `modified` datetime DEFAULT NULL,
              `content` text NOT NULL,
              `staff_id` int(11) NOT NULL,
              `contact_id` int(11) DEFAULT "0",
              `fullname` varchar(191) DEFAULT NULL,
              `file_name` varchar(191) DEFAULT NULL,
              `file_mime_type` varchar(70) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'casediscussions')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'casediscussions` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `subject` varchar(191) NOT NULL,
              `description` text NOT NULL,
              `show_to_customer` tinyint(1) NOT NULL DEFAULT "0",
              `datecreated` datetime NOT NULL,
              `last_activity` datetime DEFAULT NULL,
              `staff_id` int(11) NOT NULL DEFAULT "0",
              `contact_id` int(11) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'case_activity')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'case_activity` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `staff_id` int(11) NOT NULL DEFAULT "0",
              `contact_id` int(11) NOT NULL DEFAULT "0",
              `fullname` varchar(100) DEFAULT NULL,
              `visible_to_customer` int(11) NOT NULL DEFAULT "0",
              `description_key` varchar(191) NOT NULL COMMENT "Language file key",
              `additional_data` text,
              `dateadded` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'case_files')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'case_files` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `file_name` varchar(191) NOT NULL,
              `subject` varchar(191) DEFAULT NULL,
              `description` text,
              `filetype` varchar(50) DEFAULT NULL,
              `dateadded` datetime NOT NULL,
              `last_activity` datetime DEFAULT NULL,
              `project_id` int(11) NOT NULL,
              `visible_to_customer` tinyint(1) DEFAULT "0",
              `staffid` int(11) NOT NULL,
              `contact_id` int(11) NOT NULL DEFAULT "0",
              `external` varchar(40) DEFAULT NULL,
              `external_link` text,
              `thumbnail_link` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'case_movement')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'case_movement` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
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
              `progress` int(11) DEFAULT "0",
              `progress_from_tasks` int(11) NOT NULL DEFAULT "1",
              `addedfrom` int(11) NOT NULL,
              `case_id` int(11) NOT NULL,
              `previous_case_id` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `".db_prefix()."case_movement` ADD KEY `case_id` (`case_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'case_notes')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'case_notes` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `content` text NOT NULL,
              `staff_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

        }

        if (!$this->db->table_exists(db_prefix() . 'case_settings')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'case_settings` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `case_id` int(11) NOT NULL,
              `name` varchar(100) NOT NULL,
              `value` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("ALTER TABLE `".db_prefix()."case_settings` ADD KEY `project_id` (`case_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'category_types')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'category_types` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `type` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("INSERT INTO `".db_prefix()."category_types` (`id`, `type`) VALUES
                  (1, 'خدمة قانونية'),
                  (2, 'اجراء قانوني');");
        }

        if (!$this->db->table_exists(db_prefix() . 'cities')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'cities` (
              `Id` int(11)  NOT NULL AUTO_INCREMENT,
              `Name_en` char(100) NOT NULL,
              `Name_ar` char(100) NOT NULL,
              `Country_id` int(11) NOT NULL,
              PRIMARY KEY (`Id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');


            $this->db->query("INSERT INTO `".db_prefix()."cities` (`Id`, `Name_en`, `Name_ar`, `Country_id`) VALUES
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
(457, 'Zallaq', 'الزلاق', 18);");
        }

        if (!$this->db->table_exists(db_prefix() . 'countries')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'countries` (
              `country_id` int(11)  NOT NULL AUTO_INCREMENT,
              `iso2` char(2) DEFAULT NULL,
              `short_name` varchar(80) NOT NULL DEFAULT "",
              `short_name_ar` varchar(80) NOT NULL,
              `long_name` varchar(80) NOT NULL DEFAULT "",
              `iso3` char(3) DEFAULT NULL,
              `numcode` varchar(6) DEFAULT NULL,
              `un_member` varchar(12) DEFAULT NULL,
              `calling_code` varchar(8) DEFAULT NULL,
              `cctld` varchar(5) DEFAULT NULL,
              PRIMARY KEY (`country_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            //Alter table tblcountries
            if (!$this->db->field_exists('short_name_ar', db_prefix() . 'countries')) {
                $this->db->query("ALTER TABLE `" . db_prefix() . "countries` ADD `short_name_ar` varchar(80) NOT NULL;");
            }

            $this->db->query("TRUNCATE ". db_prefix() . "countries");

            // insert default value table tblcountries
            $this->db->query("INSERT INTO ". db_prefix() . " `countries` (`country_id`, `iso2`, `short_name`, `short_name_ar`, `long_name`, `iso3`, `numcode`, `un_member`, `calling_code`, `cctld`) VALUES
('1', 'AF', 'Afghanistan', '', 'Islamic Republic of Afghanistan', 'AFG', '004', 'yes', '93', '.af'),
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
(250, 'ZW', 'Zimbabwe', '', 'Republic of Zimbabwe', 'ZWE', '716', 'yes', '263', '.zw');");
        }


        if (!$this->db->table_exists(db_prefix() . 'irac_method')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'irac_method` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `rel_id` int(11) NOT NULL,
              `rel_type` varchar(20) NOT NULL,
              `facts` text NOT NULL,
              `legal_authority` text NOT NULL,
              `analysis` text NOT NULL,
              `result` text NOT NULL,
              `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'legal_procedures_lists')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'legal_procedures_lists` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `cat_id` int(11) NOT NULL,
              `rel_id` int(11) NOT NULL,
              `rel_type` varchar(20) NOT NULL,
              `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'legal_procedures')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'legal_procedures` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `list_id` int(11) NOT NULL,
              `subcat_id` int(11) NOT NULL,
              `reference_id` int(11) NOT NULL,
              `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `".db_prefix()."legal_procedures` ADD KEY `list_key` (`list_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_basic_services')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_basic_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `slug` varchar(255) NOT NULL,
              `prefix` varchar(255) NOT NULL,
              `numbering` int(11) DEFAULT NULL,
              `is_primary` int(2) NOT NULL DEFAULT "0",
              `show_on_sidebar` tinyint(1) NOT NULL DEFAULT "1",
              `is_module` tinyint(1) NOT NULL DEFAULT "0",
              `datecreated` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("INSERT INTO `".db_prefix()."my_basic_services` (`id`, `name`, `slug`, `prefix`, `numbering`, `is_primary`, `show_on_sidebar`, `is_module`, `datecreated`) VALUES
(1, 'قضايا', 'kd-y', 'CASE', 1, 1, 1, 0, '2019-04-15 18:03:19'),
(2, 'عقود', 'aakod', 'Akd', 1, 1, 1, 0, '2019-05-01 19:43:08'),
(3, 'استشارات', 'stsh-r-t', 'Istsh', 1, 1, 1, 0, '2019-05-08 01:28:21'),
(9, 'نزاعات مالية', 'nz_aa_t_m_ly', 'Dispute', NULL, 1, 0, 1, '2020-01-23 21:03:43');");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_cases')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_cases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
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
              `progress` int(11) DEFAULT "0",
              `progress_from_tasks` int(11) NOT NULL DEFAULT "1",
              `addedfrom` int(11) NOT NULL,
              `branch_id` int(11) NOT NULL DEFAULT "0",
              `previous_case_id` int(11) DEFAULT NULL,
              `deleted` int(11) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_casestatus')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_casestatus` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `is_default` int(1) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("INSERT INTO `".db_prefix()."my_casestatus` (`id`, `name`, `is_default`) VALUES
(1, 'nothing_was_specified', 1);");
        }

        if (!$this->db->field_exists('is_default',  db_prefix() . 'my_casestatus')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_casestatus` ADD `is_default` int(1) NOT NULL DEFAULT "0";');
            $this->db->query("INSERT INTO `".db_prefix()."my_casestatus` ( `name`, `is_default`) VALUES
('nothing_was_specified', 1);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_cases_judges')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_cases_judges` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `judge_id` int(11) NOT NULL,
              `case_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `".db_prefix()."my_cases_judges` ADD KEY `judge_id` (`judge_id`),  ADD KEY `case_id` (`case_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_cases_movement_judges')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_cases_movement_judges` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `judge_id` int(11) NOT NULL,
              `case_mov_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `".db_prefix()."my_cases_movement_judges`
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `case_id` (`case_mov_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_categories')) {
            $this->db->query('CREATE TABLE `'.db_prefix().'my_categories` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `service_id` int(255) DEFAULT NULL,
              `parent_id` int(255) NOT NULL,
              `type_id` int(11) DEFAULT NULL,
              `datecreated` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `tblmy_categories`
  ADD KEY `CateServKey` (`service_id`),
  ADD KEY `categoty_type_key` (`type_id`);");


            $this->db->query("ALTER TABLE `tblmy_categories`
  ADD CONSTRAINT `CateServKey` FOREIGN KEY (`service_id`) REFERENCES `tblmy_basic_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoty_type_key` FOREIGN KEY (`type_id`) REFERENCES `tblcategory_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_customer_representative')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_customer_representative` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `representative` varchar(200) NOT NULL,
              `is_default` int(1) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("INSERT INTO `tblmy_customer_representative` (`id`, `representative`, `is_default`) VALUES
(1, 'nothing_was_specified', 1);");
        }

        if (!$this->db->field_exists('is_default',  db_prefix() . 'my_customer_representative')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_customer_representative` ADD `is_default` int(1) NOT NULL DEFAULT "0";');
            $this->db->query("INSERT INTO `tblmy_customer_representative` ( `representative`, `is_default`) VALUES
                  ('nothing_was_specified', 1);");
        }


        if (!$this->db->table_exists(db_prefix() . 'my_dialog_boxes')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_dialog_boxes` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `desc_ar` text,
              `desc_en` text,
              `page_url` varchar(255) NOT NULL,
              `active` int(11) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_judges')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_judges` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `name` varchar(250) NOT NULL,
              `note` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_members_cases')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_members_cases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `staff_id` int(11) NOT NULL,
              `project_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `tblmy_members_cases`
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `project_id` (`project_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_members_movement_cases')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_members_movement_cases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `staff_id` int(11) NOT NULL,
              `case_mov_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `tblmy_members_movement_cases`
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `project_id` (`case_mov_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_members_services')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_members_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `staff_id` int(11) NOT NULL,
              `oservice_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `tblmy_members_services`
  ADD KEY `staff_id` (`staff_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'my_other_services')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_other_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `service_id` int(11) NOT NULL,
              `code` varchar(255) NOT NULL,
              `numbering` int(11) DEFAULT NULL,
              `name` varchar(191) NOT NULL,
              `clientid` int(11) NOT NULL,
              `cat_id` int(11) NOT NULL,
              `subcat_id` int(11) NOT NULL,
              `service_session_link` int(11) NOT NULL DEFAULT "0",
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
              `progress` int(11) DEFAULT "0",
              `progress_from_tasks` int(11) NOT NULL DEFAULT "1",
              `addedfrom` int(11) NOT NULL,
              `branch_id` int(11) NOT NULL DEFAULT "0",
              `deleted` int(11) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_phase_data')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_phase_data` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `phase_id` int(11) NOT NULL,
              `rel_id` int(11) DEFAULT NULL,
              `rel_type` varchar(30) DEFAULT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `is_complete` int(11) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_services_tags')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_services_tags` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `rel_type` varchar(100) NOT NULL,
              `rel_id` int(11) NOT NULL,
              `tag` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_service_phases')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_service_phases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `name` varchar(40) NOT NULL,
              `slug` varchar(30) DEFAULT NULL,
              `service_id` int(11) NOT NULL,
              `is_active` int(1) NOT NULL DEFAULT "0",
              `deleted` int(1) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_sessiondiscussioncomments')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_sessiondiscussioncomments` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `discussion_id` int(11) NOT NULL,
              `discussion_type` varchar(10) NOT NULL,
              `parent` int(10) DEFAULT NULL,
              `created` datetime NOT NULL,
              `modified` datetime DEFAULT NULL,
              `content` text NOT NULL,
              `staff_id` int(11) NOT NULL,
              `contact_id` int(11) DEFAULT "0",
              `fullname` varchar(191) DEFAULT NULL,
              `file_name` varchar(191) DEFAULT NULL,
              `file_mime_type` varchar(70) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_sessiondiscussions')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_sessiondiscussions` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `session_id` int(11) NOT NULL,
              `subject` varchar(191) NOT NULL,
              `description` text NOT NULL,
              `show_to_customer` tinyint(1) NOT NULL,
              `datecreated` datetime NOT NULL,
              `last_activity` datetime NOT NULL,
              `staff_id` int(11) NOT NULL,
              `contact_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_session_info')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_session_info` (
              `s_id` int(11)  NOT NULL AUTO_INCREMENT,
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
              `next_session_time` time DEFAULT NULL,
              PRIMARY KEY (`s_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("ALTER TABLE `tblmy_session_info`
  ADD KEY `task_id` (`task_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'oservicediscussioncomments')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'oservicediscussioncomments` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `discussion_id` int(11) NOT NULL,
              `discussion_type` varchar(10) NOT NULL,
              `parent` int(11) DEFAULT NULL,
              `created` datetime NOT NULL,
              `modified` datetime DEFAULT NULL,
              `content` text NOT NULL,
              `staff_id` int(11) NOT NULL,
              `contact_id` int(11) DEFAULT "0",
              `fullname` varchar(191) DEFAULT NULL,
              `file_name` varchar(191) DEFAULT NULL,
              `file_mime_type` varchar(70) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'oservicediscussions')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'oservicediscussions` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `oservice_id` int(11) NOT NULL,
              `subject` varchar(191) NOT NULL,
              `description` text NOT NULL,
              `show_to_customer` tinyint(1) NOT NULL DEFAULT "0",
              `datecreated` datetime NOT NULL,
              `last_activity` datetime DEFAULT NULL,
              `staff_id` int(11) NOT NULL DEFAULT "0",
              `contact_id` int(11) NOT NULL DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'oservice_activity')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'oservice_activity` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `oservice_id` int(11) NOT NULL,
              `staff_id` int(11) NOT NULL DEFAULT "0",
              `contact_id` int(11) NOT NULL DEFAULT "0",
              `fullname` varchar(100) DEFAULT NULL,
              `visible_to_customer` int(11) NOT NULL DEFAULT "0",
              `description_key` varchar(191) NOT NULL COMMENT "Language file key",
              `additional_data` text,
              `dateadded` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'oservice_files')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'oservice_files` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `file_name` varchar(191) NOT NULL,
              `subject` varchar(191) DEFAULT NULL,
              `description` text,
              `filetype` varchar(50) DEFAULT NULL,
              `dateadded` datetime NOT NULL,
              `last_activity` datetime DEFAULT NULL,
              `oservice_id` int(11) NOT NULL,
              `visible_to_customer` tinyint(1) DEFAULT "0",
              `staffid` int(11) NOT NULL,
              `contact_id` int(11) NOT NULL DEFAULT "0",
              `external` varchar(40) DEFAULT NULL,
              `external_link` text,
              `thumbnail_link` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'oservice_notes')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'oservice_notes` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `oservice_id` int(11) NOT NULL,
              `content` text NOT NULL,
              `staff_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'oservice_settings')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'oservice_settings` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `oservice_id` int(11) NOT NULL,
              `name` varchar(100) NOT NULL,
              `value` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("ALTER TABLE `tbloservice_settings`
  ADD KEY `oservice_id` (`oservice_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'pinned_cases')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'pinned_cases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `staff_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("ALTER TABLE `tblpinned_cases`
  ADD KEY `project_id` (`project_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'pinned_oservices')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'pinned_oservices` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `oservice_id` int(11) NOT NULL,
              `staff_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
            $this->db->query("ALTER TABLE `tblpinned_oservices` ADD KEY `oservice_id` (`oservice_id`);");
        }

        if (!$this->db->table_exists(db_prefix() . 'written_reports')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'written_reports` (
                  `id` int(11) NOT NULL,
                  `report` text NOT NULL,
                  `addedfrom` int(11) NOT NULL,
                  `updatedfrom` int(11) DEFAULT NULL,
                  `created_at` datetime NOT NULL,
                  `updated_at` datetime DEFAULT NULL,
                  `rel_id` int(11) DEFAULT NULL,
                  `rel_type` varchar(30) DEFAULT NULL,
                  `editable` int(11) NOT NULL DEFAULT "1"
                ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ';');

            $this->db->query("ALTER TABLE ".db_prefix()."written_reports ADD PRIMARY KEY (`id`);");
            $this->db->query("ALTER TABLE ".db_prefix()."written_reports MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
        }

        //Alter table tblcontracts
        if (!$this->db->field_exists('type_id', db_prefix().'contracts')) {
            $this->db->query("ALTER TABLE `tblcontracts` ADD `type_id` int(11) NOT NULL DEFAULT '0';");
            $this->db->query("ALTER TABLE `tblcontracts` ADD KEY `type_id` (`type_id`)");
        }

        //Alter table tbldepartments
        if (!$this->db->field_exists('branch_id', db_prefix().'departments')) {
            $this->db->query("ALTER TABLE `tbldepartments` ADD `branch_id` int(11) NOT NULL DEFAULT '0';");
        }

        //Alter table tblestimates
        if (!$this->db->field_exists('rel_sid', db_prefix().'estimates')) {
            $this->db->query("ALTER TABLE `tblestimates` ADD `rel_sid` int(11) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblestimates` ADD KEY `rel_sid` (`rel_sid`)");
        }
        if (!$this->db->field_exists('rel_stype', db_prefix().'estimates')) {
            $this->db->query("ALTER TABLE `tblestimates` ADD `rel_stype` varchar(20) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblestimates` ADD KEY `rel_stype` (`rel_stype`)");
        }

        //Alter table tblexpenses
        if (!$this->db->field_exists('rel_sid', db_prefix() . 'expenses')) {
            $this->db->query("ALTER TABLE `tblexpenses` ADD `rel_sid` int(11) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblexpenses` ADD KEY `rel_sid` (`rel_sid`)");
        }
        if (!$this->db->field_exists('rel_stype', db_prefix() . 'expenses')) {
            $this->db->query("ALTER TABLE `tblexpenses` ADD `rel_stype` varchar(20) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblexpenses` ADD KEY `rel_stype` (`rel_stype`)");
        }

        //Alter table tblinvoices
        if (!$this->db->field_exists('rel_sid', db_prefix() . 'invoices')) {
            $this->db->query("ALTER TABLE `tblinvoices` ADD `rel_sid` int(11) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblinvoices` ADD KEY `rel_sid` (`rel_sid`)");
        }
        if (!$this->db->field_exists('rel_stype', db_prefix() . 'invoices')) {
            $this->db->query("ALTER TABLE `tblinvoices` ADD `rel_stype` varchar(20) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblinvoices` ADD KEY `rel_stype` (`rel_stype`)");
        }

        //Alter table tblmilestones
        if (!$this->db->field_exists('rel_sid', db_prefix() . 'milestones')) {
            $this->db->query("ALTER TABLE `tblmilestones` ADD `rel_sid` int(11) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblmilestones` ADD KEY `rel_sid` (`rel_sid`)");
        }
        if (!$this->db->field_exists('rel_stype', db_prefix() . 'milestones')) {
            $this->db->query("ALTER TABLE `tblmilestones` ADD `rel_stype` varchar(20) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tblmilestones` ADD KEY `rel_stype` (`rel_stype`)");
        }

        //Alter table tbltickets
        if (!$this->db->field_exists('rel_sid', db_prefix() . 'tickets')) {
            $this->db->query("ALTER TABLE `tbltickets` ADD `rel_sid` int(11) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tbltickets` ADD KEY `rel_sid` (`rel_sid`)");
        }
        if (!$this->db->field_exists('rel_stype', db_prefix() . 'tickets')) {
            $this->db->query("ALTER TABLE `tbltickets` ADD `rel_stype` varchar(20) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `tbltickets` ADD KEY `rel_stype` (`rel_stype`)");
        }

        //Alter table tbltasks
        if (!$this->db->field_exists('is_session', db_prefix() . 'tasks')) {
            $this->db->query("ALTER TABLE `tbltasks` ADD `is_session` int(11) DEFAULT '0';");
        }

        //Alter table tblstaff
        if (!$this->db->field_exists('firstname', db_prefix() . 'staff')) {
            $this->db->query("ALTER TABLE `tbltasks` ADD `firstname` varchar(50) NOT NULL;");
            $this->db->query("ALTER TABLE `tbltasks` ADD KEY `firstname` (`firstname`)");
        }
        if (!$this->db->field_exists('lastname', db_prefix() . 'staff')) {
            $this->db->query("ALTER TABLE `tbltasks` ADD `lastname` varchar(50) NOT NULL;");
            $this->db->query("ALTER TABLE `tbltasks` ADD KEY `lastname` (`lastname`)");
        }

        $sessions_rows = total_rows(db_prefix() .'emailtemplates', ['type' => 'sessions']);
        if($sessions_rows == 0){
            $this->db->query("INSERT INTO `tblemailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
            ('sessions', 'session-added-attachment-to-contacts', 'english', 'New Attachment(s) on Session (Sent to Customer Contacts)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-added-attachment-to-contacts', 'arabic', 'مرفقات جديدة في الجلسة (مرسلة إلى جهات اتصال العملاء)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-added-attachment', 'english', 'New Attachment(s) on Session (Sent to Staff)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-added-attachment', 'arabic', 'مرفقات جديدة للجلسة (مرسلة لفريق العمل)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-commented-to-contacts', 'english', 'New Comment on Task (Sent to Customer Contacts)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-commented-to-contacts', 'arabic', 'تعليق جديد على الجلسة (مرسل إلى جهات اتصال العملاء)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-commented', 'english', 'New Comment on Session (Sent to Staff)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-commented', 'arabic', 'تعليق جديد على الجلسة (مرسل إلى فريق العمل)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-status-change-to-contacts', 'english', 'Session Status Changed (Sent to Customer Contacts)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-status-change-to-contacts', 'arabic', 'تغيير حالة الجلسة (مرسلة إلى جهات اتصال العملاء)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-status-change-to-staff', 'english', 'Session Status Changed (Sent to Staff)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'session-status-change-to-staff', 'arabic', 'تغيير حالة الجلسة (مرسلة إلى فريق العمل)', '', '', '', NULL, 0, 1, 0),
            ('sessions', 'send_report_session', 'arabic', 'تقرير الجلسة (مرسل إلى فريق العمل)', '', '', '', '', 0, 1, 0),
            ('sessions', 'send_report_session', 'english', 'Session Send Report (Sent to Staff)', '', '', '', '', 0, 1, 0),
            ('sessions', 'next_session_action', 'english', 'Reminder For Next Session Action', '', '', '', '', 0, 1, 0),
            ('sessions', 'next_session_action', 'arabic', 'تذكير بإجراءات الجلسة القادمة', '', '', '', '', 0, 1, 0)");
        }

        $written_report_rows = total_rows(db_prefix() .'emailtemplates', ['type' => 'written_report']);
        if($written_report_rows == 0){
            $this->db->query("INSERT INTO `tblemailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
                 ('written_report', 'send_written_report_to_customer', 'english', 'Send written report to customer', '', '', '', '', 0, 1, 0),
                 ('written_report', 'send_written_report_to_customer', 'arabic', 'إرسال تقرير مكتوب للعميل', 'تقرير مكتوب للعميل', '', '', '', 0, 1, 0)");
        }
    }

}

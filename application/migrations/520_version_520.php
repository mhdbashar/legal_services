<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_520 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbldisputes_case_activity` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `project_id` int(11) NOT NULL,
            `staff_id` int(11) NOT NULL DEFAULT 0,
            `contact_id` int(11) NOT NULL DEFAULT 0,
            `fullname` varchar(100) DEFAULT NULL,
            `visible_to_customer` int(11) NOT NULL DEFAULT 0,
            `description_key` varchar(191) NOT NULL COMMENT 'Language file key',
            `additional_data` text DEFAULT NULL,
            `dateadded` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tbldisputes_case_notes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `project_id` int(11) NOT NULL,
            `content` text NOT NULL,
            `staff_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tbldisputes_pinned_cases` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `project_id` int(11) NOT NULL,
            `staff_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_casediscussioncomments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
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
            `file_mime_type` varchar(70) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_casediscussions` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `project_id` int(11) NOT NULL,
          `subject` varchar(191) NOT NULL,
          `description` text NOT NULL,
          `show_to_customer` tinyint(1) NOT NULL DEFAULT 0,
          `datecreated` datetime NOT NULL,
          `last_activity` datetime DEFAULT NULL,
          `staff_id` int(11) NOT NULL DEFAULT 0,
          `contact_id` int(11) NOT NULL DEFAULT 0,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
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
          `file_number_case` varchar(255) DEFAULT NULL,
          `file_number_court` bigint(20) DEFAULT NULL,
          `contract` int(11) NOT NULL,
          `estimated_hours` decimal(15,2) DEFAULT NULL,
          `progress` int(11) DEFAULT 0,
          `progress_from_tasks` int(11) NOT NULL DEFAULT 1,
          `addedfrom` int(11) NOT NULL,
          `branch_id` int(11) NOT NULL DEFAULT 0,
          `previous_case_id` int(11) DEFAULT NULL,
          `deleted` int(11) NOT NULL DEFAULT 0,
          `contact_notification` int(11) DEFAULT 1,
          `notify_contacts` text DEFAULT NULL,
          `childsubcat_id` int(11) NOT NULL DEFAULT 0,
          `opponent_lawyer_id` int(11) NOT NULL,
          `disputes_total` int(11) NOT NULL,
          `is_invoiced` int(1) NOT NULL DEFAULT 0,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_invoicepaymentrecords` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `invoiceid` int(11) NOT NULL,
          `amount` decimal(15,2) NOT NULL,
          `paymentmode` varchar(40) DEFAULT NULL,
          `paymentmethod` varchar(191) DEFAULT NULL,
          `date` date NOT NULL,
          `daterecorded` datetime NOT NULL,
          `note` text NOT NULL,
          `transactionid` mediumtext DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `invoiceid` (`invoiceid`),
          KEY `paymentmethod` (`paymentmethod`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_invoices` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
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
          PRIMARY KEY (`id`),
           KEY `currency` (`currency`),
           KEY `clientid` (`clientid`),
           KEY `project_id` (`project_id`),
           KEY `sale_agent` (`sale_agent`),
           KEY `total` (`total`),
           KEY `rel_stype` (`rel_stype`),
           KEY `rel_sid` (`rel_sid`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_judges` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `judge_id` int(11) NOT NULL,
          `case_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `judge_id` (`judge_id`),
          KEY `case_id` (`case_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_members` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `staff_id` int(11) NOT NULL,
          `project_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_movement_judges` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `judge_id` int(11) NOT NULL,
          `case_mov_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `judge_id` (`judge_id`),
          KEY `case_id` (`case_mov_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_movement_opponents` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `opponent_id` int(11) NOT NULL,
          `case_mov_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `opponent_id` (`opponent_id`),
          KEY `case_id` (`case_mov_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_opponents` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `opponent_id` int(11) NOT NULL,
          `case_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_cases_statuses` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `status_name` varchar(100) NOT NULL DEFAULT '',
          `is_default` int(1) NOT NULL DEFAULT 0,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_case_files` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
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
          `thumbnail_link` text DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_case_movement` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
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
          `inserted_date` datetime NOT NULL DEFAULT current_timestamp(),
          `deadline` date DEFAULT NULL,
          `date_finished` date DEFAULT NULL,
          `description` text NOT NULL,
          `case_result` varchar(255) NOT NULL,
          `file_number_case` int(11) DEFAULT NULL,
          `file_number_court` int(11) DEFAULT NULL,
          `contract` int(11) NOT NULL,
          `estimated_hours` decimal(15,2) DEFAULT NULL,
          `progress` int(11) DEFAULT 0,
          `progress_from_tasks` int(11) NOT NULL DEFAULT 1,
          `addedfrom` int(11) NOT NULL,
          `case_id` int(11) NOT NULL,
          `previous_case_id` int(11) DEFAULT NULL,
          `notify_contacts` text DEFAULT NULL,
          `childsubcat_id` int(11) NOT NULL DEFAULT 0,
          `opponent_lawyer_id` int(11) NOT NULL,
          `disputes_total` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `case_id` (`case_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_members_disputes_cases` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `staff_id` int(11) NOT NULL,
          `project_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `staff_id` (`staff_id`),
          KEY `project_id` (`project_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_members_disputes_movement_cases` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `staff_id` int(11) NOT NULL,
          `case_mov_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `staff_id` (`staff_id`),
          KEY `project_id` (`case_mov_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_disputes_case_settings` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `case_id` int(11) NOT NULL,
          `name` varchar(100) NOT NULL,
          `value` text DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblprocuration_disputes_cases` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `procuration` int(11) NOT NULL,
          `_case` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $service = $this->db->get_where('my_basic_services', array('id' => 22))->num_rows();
        if($service == 0){
            $this->db->query("INSERT INTO `tblmy_basic_services`(`id`, `name`, `slug`, `prefix`, `numbering`, `is_primary`, `show_on_sidebar`, `is_module`, `datecreated`) 
            VALUES 
(22, 'قضايا التنفيذ و التحصيل', 'kdaya_altnfith', 'Dispute_', 1, 1, 1, 0, '2021-07-27 10:27:07');            ");
        }

        $services = $this->db->order_by('id', 'ASC')->get('my_basic_services')->result();
        foreach ($services as $service){
            $service->id == 1 ? $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>1])
                : $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>15]);
            $service->id == 2 ? $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>3])
                : $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>15]);
            $service->id == 3 ? $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>4])
                : $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>15]);
            $service->id == 22 ? $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>2])
                : $this->db->where('id', $service->id)->update('my_basic_services', ['numbering'=>15]);
        }

        if(!file_exists('uploads/disputes_cases')){
            mkdir('uploads/disputes_cases');
        }
    }
}
    
    

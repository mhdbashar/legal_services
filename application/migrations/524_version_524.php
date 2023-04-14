<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_524 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {

        // Add tblregular_durations table
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblregular_durations` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar (255) NOT NULL,
                `number_of_days` int(11) NOT NULL,
                `court_id` int(11) ,
                `childsubcat_id` int(11) ,
                `categories` int(11) ,
                `sub_categories` int(11) ,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

        // Add tblcases_regular_durations table
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblcases_regular_durations` (
              `id` int(11) NOT NULL ,
                `case_id` varchar (255) NOT NULL,
                `reg_id` int(11) NOT NULL,
                `days` int(11) ,
                `start_date` date ,
                `end_date` date ,
                `deadline_notified` int(11) ,
                `regular_header` int(1) ,
                `dur_alert_close` date ,
                 PRIMARY KEY (`id`)
               
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

        // Add tbldurations_cases table
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbldurations_cases` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
               `reg_id` int(11) NOT NULL,
               `case_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");


        // Add new fields to tblmy_cases table

        if ($this->db->field_exists('duration_id', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` DROP COLUMN `duration_id` ');
        }
        if ($this->db->field_exists('regular_duration_begin_date', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` DROP COLUMN `regular_duration_begin_date` ');
        }
        if ($this->db->field_exists('deadline_notified', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` DROP COLUMN `deadline_notified` ');
        }
        if ($this->db->field_exists('regular_header', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` DROP COLUMN `regular_header` ');
        }
        if ($this->db->field_exists('dur_alert_close', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` DROP COLUMN `dur_alert_close` ');
        }
        //add filds to tblmy_session_info
        if (!$this->db->field_exists('clientid', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `clientid` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('contact_notification', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `contact_notification` INT DEFAULT 1');
        }
        if (!$this->db->field_exists('notify_contacts', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `notify_contacts` TEXT DEFAULT NULL');
        }

        $emailtemplate = $this->db->get_where('tblemailtemplates', array('slug' => 'next_session_action_to_opponent','type'=>'sessions','language'=>'arabic'))->num_rows();
        if($emailtemplate == 0) {
            $data = [
                'type' => 'sessions', 'slug' => 'next_session_action_to_opponent', 'language' => 'arabic', 'name' => 'تذكير بالجلسة القادمة (مرسل جهات اتصال الخصم)', 'subject' => 'تم إنشاء جلسة قادمة',
                'message' => '
                السيد : {contact_firstname}{contact_lastname}<br />السلام عليكم ورحمة الله وبركاته,,, وأسعد الله أوقاتكم بكل خير<br />فيما يلي نفيدكم بموعد الجلسة المقبلة الخاصة بكم. <br />تاريخ الجلسة القادمة : {next_session_date}<br />وقت الجلسة القادمة : {next_session_time}
                ',
                'fromname' => '{companyname}', 'fromemail' => '', 'plaintext' => '0', 'active' => '1', 'order' => '0',
            ];
            $this->db->insert(db_prefix() . 'emailtemplates', $data);
            add_option('settings[regular_durations_reminder_notification_before]', '5');
        }

    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_522 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        //add filds to tblmy_session_info
        if (!$this->db->field_exists('cat_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `cat_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('subcat_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `subcat_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('childsubcat_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `childsubcat_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('file_number_court', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `file_number_court` bigint(20) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('session_link', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `session_link` varchar(255) NULL DEFAULT NULL');
        }
        if(!get_option('sessions_reminder_notification_before')) {
            add_option('sessions_reminder_notification_before', 1);
        }
    }
}
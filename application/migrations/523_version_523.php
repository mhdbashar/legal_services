<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_523 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        //add filds to tblmy_session_info
        if (!$this->db->field_exists('clientid', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `clientid` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('contact_notification', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `contact_notification` INT DEFAULT 1');
        }
        if (!$this->db->field_exists('notify_contacts', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `notify_contacts` TEXT DEFAULT NULL');
        }
    }
}
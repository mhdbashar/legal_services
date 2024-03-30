<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_530 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        if (!$this->db->field_exists('proc_header', db_prefix() . 'procuration_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procuration_cases` ADD `proc_header` int(1) NULL DEFAULT 0');
        }
        if (!$this->db->field_exists('proc_alert_close', db_prefix() . 'procuration_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procuration_cases` ADD `proc_alert_close` date NULL DEFAULT NULL');
        }
    }
}

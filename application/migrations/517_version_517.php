<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_517 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {

        // jawad

        if (!$this->db->field_exists('time', db_prefix() . 'reminders')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'reminders` ADD `time` varchar(255) DEFAULT NULL');
        }

    }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_510 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        if (!$this->db->field_exists('notify_contacts', db_prefix() . 'case_movement')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'case_movement` ADD `notify_contacts` TEXT DEFAULT NULL');
        }
    }
}

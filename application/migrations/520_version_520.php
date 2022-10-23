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
        if (!$this->db->field_exists('add_to_library', db_prefix() . 'staff')) {
            $this->db->query("ALTER TABLE `tblstaff` ADD `add_to_library` tinyint(1) NOT NULL DEFAULT '0'");
        }
    }
}

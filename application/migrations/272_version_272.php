<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_272 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        //Alter table tblcontracts
        if (!$this->db->field_exists('rel_sid', db_prefix() . 'contracts')) {
            $this->db->query("ALTER TABLE `' . db_prefix() .  'contracts` ADD `rel_sid` int(11) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `' . db_prefix() .  'contracts` ADD KEY `rel_sid` (`rel_sid`)");
        }
        if (!$this->db->field_exists('rel_stype', db_prefix() . 'contracts')) {
            $this->db->query("ALTER TABLE `' . db_prefix() .  'contracts` ADD `rel_stype` varchar(20) DEFAULT NULL;");
            $this->db->query("ALTER TABLE `' . db_prefix() .  'contracts` ADD KEY `rel_stype` (`rel_stype`)");
        }

    }
}
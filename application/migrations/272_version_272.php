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
        add_option('wathq_api_key', 'eaQFFTW5oOLH5a908nkCcK78Z1PQ1FAx');

        if (!$this->db->field_exists('description', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `description` TEXT NULL;');
        }

        if (!$this->db->field_exists('principalId', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `principalId` int(11) NULL;');
        }

        if (!$this->db->field_exists('agentId', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `agentId` int(11) NULL;');
        }

        if (!$this->db->field_exists('name', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `name` VARCHAR(255) NULL;');
        }

        $this->db->query("ALTER TABLE `" . db_prefix() . "procurations` CHANGE `status` `status` VARCHAR(255) NOT NULL;");


        update_option('hijri_pages', '["Case\/add","group=CaseSession","procuration"]');
        update_option('isHijri', 'on');


        //Alter table tblcontracts
        if (!$this->db->field_exists('rel_sid', db_prefix() . 'contracts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() .  'contracts` ADD `rel_sid` int(11) DEFAULT NULL;');
            $this->db->query('ALTER TABLE `' . db_prefix() .  'contracts` ADD KEY `rel_sid` (`rel_sid`)');
        }
        if (!$this->db->field_exists('rel_stype', db_prefix() . 'contracts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() .  'contracts` ADD `rel_stype` varchar(20) DEFAULT NULL;');
            $this->db->query('ALTER TABLE `' . db_prefix() .  'contracts` ADD KEY `rel_stype` (`rel_stype`)');
        }

    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_509 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        if ($this->db->field_exists('judge_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` MODIFY `judge_id` int(11) DEFAULT NULL');
        }

        if ($this->db->field_exists('file_number_case', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` MODIFY `file_number_case`  VARCHAR(255) NULL DEFAULT NULL');
        }

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblsessions_checklist_templates` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `description` text,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

        if (!$this->db->field_exists('fathername', db_prefix() . 'contacts')) {
            $this->db->query("ALTER TABLE `tblcontacts` ADD `fathername` varchar(191) DEFAULT NULL;");
        }

        if (!$this->db->field_exists('grandfathername', db_prefix() . 'contacts')) {
            $this->db->query("ALTER TABLE `tblcontacts` ADD `grandfathername` varchar(191) DEFAULT NULL;");
        }

        update_option('clients_default_theme', 'babil');

        update_option('invoice_company_name', 'Babil INC');

        update_option('_v283_update_clients_theme', active_clients_theme());

        @rename(APPPATH . 'views/themes/perfex', APPPATH . 'views/themes/babil');
        @rename('assets/themes/perfex','assets/themes/babil');


    }
}

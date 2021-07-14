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

        $this->db->query("CREATE TABLE `tblsessions_checklist_templates` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `description` text,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    }
}

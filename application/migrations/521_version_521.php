<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_521 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        // Add saudi vat option for invoices and credit notes
        if(!get_option('saudi_vat'))
            add_option('saudi_vat', 1);

        // Add tblregular_durations table
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblregular_durations` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar (255) NOT NULL,
                `number_of_days` int(11) NOT NULL,
                `court_id` int(11) ,
                `childsubcat_id` int(11) ,
                `categories` int(11) ,
                `sub_categories` int(11) ,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

        // Add new fields to tblmy_cases table

        if (!$this->db->field_exists('duration_id', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `duration_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('regular_duration_begin_date', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `regular_duration_begin_date` date  NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('deadline_notified', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `deadline_notified` int(11) NOT NULL DEFAULT 0');
        }
        if (!$this->db->field_exists('regular_header', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `regular_header` tinyint(1) NOT NULL DEFAULT 0');
        }

    }
}
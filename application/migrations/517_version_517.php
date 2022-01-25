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
        // Add tblmy_courts_categories table
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_courts_categories` (
              `c_cat_id` int(11) NOT NULL AUTO_INCREMENT,
                `c_id` int(11) NOT NULL,
                `cat_id` int(11) NOT NULL,
              PRIMARY KEY (`c_cat_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

        // Add new fields to courts table

        if (!$this->db->field_exists('city', db_prefix() . 'my_courts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_courts` ADD `city` varchar(255) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('country', db_prefix() . 'my_courts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_courts` ADD `country` int(11) NOT NULL');
        }

        if (!$this->db->field_exists('court_description', db_prefix() . 'my_courts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_courts` ADD `court_description` TEXT DEFAULT NULL');
        }
        if (!$this->db->field_exists('is_basic', db_prefix() . 'my_courts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_courts` ADD `is_basic` int(1) NOT NULL');
        }

        // Add fields to judical table

        if (!$this->db->field_exists('Jud_description', db_prefix() . 'my_judicialdept')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_judicialdept` ADD `Jud_description` TEXT DEFAULT NULL');
        }

        if (!$this->db->field_exists('Jud_email', db_prefix() . 'my_courts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_courts` ADD `Jud_email` varchar(255) NULL DEFAULT NULL');
        }

        // Add fields to categories table

        if (!$this->db->field_exists('cat_description', db_prefix() . 'my_categories')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_categories` ADD `cat_description` TEXT DEFAULT NULL');
        }
        if (!$this->db->field_exists('is_basic', db_prefix() . 'my_categories')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_categories` ADD `is_basic` int(1) NOT NULL');
        }
        if (!$this->db->field_exists('country', db_prefix() . 'my_categories')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_categories` ADD `country` int(11) NOT NULL');
        }

        // Add fields to cases table

        if (!$this->db->field_exists('childsubcat_id', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` ADD `childsubcat_id` int(11) NOT NULL');
        }
        if (!$this->db->field_exists('childsubcat_id', db_prefix() . 'case_movement')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'case_movement` ADD `childsubcat_id` int(11) NOT NULL');
        }

    }
}

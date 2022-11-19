<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_303 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        add_option('hr_designation_prefix', 'DES-');

        add_option('next_hr_designation_number', '1');

        add_option('hr_designation_number', '1');

        if (!$CI->db->field_exists('number', db_prefix() . 'hr_designations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_designations` ADD `number` varchar(255) DEFAULT '';");
        }
        if (!$CI->db->field_exists('number_format', db_prefix() . 'hr_designations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_designations` ADD `number_format` varchar(255) DEFAULT '1';");
        }
    }
}


<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_302 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        add_option('hr_contract_prefix', '#CONTRACT');

        add_option('next_hr_contract_number', '1');

        add_option('hr_staff_prefix', '#STAFF');

        add_option('next_hr_staff_number', '1');

        if (!$CI->db->field_exists('code', db_prefix() . 'hr_contracts')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_contracts` ADD `code` varchar(255) DEFAULT '';");
        }
        if (!$CI->db->field_exists('code_number', db_prefix() . 'hr_contracts')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_contracts` ADD `code_number` varchar(255) DEFAULT '';");
        }

        if (!$CI->db->field_exists('code', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `code` varchar(255) DEFAULT '';");
        }
        if (!$CI->db->field_exists('code_number', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `code_number` varchar(255) DEFAULT '';");
        }

    }
}


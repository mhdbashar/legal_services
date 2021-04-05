<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_302 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        add_option('hr_contract_prefix', '#CONTRACT');

        add_option('next_hr_contract_number', '1');

        add_option('hr_contract_number', '1');

        add_option('hr_staff_prefix', '#STAFF');

        add_option('next_hr_staff_number', '1');

        add_option('hr_staff_number', '1');

        if (!$CI->db->field_exists('number', db_prefix() . 'hr_contracts')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_contracts` ADD `number` varchar(255) DEFAULT '';");
        }
        if (!$CI->db->field_exists('number_format', db_prefix() . 'hr_contracts')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_contracts` ADD `number_format` varchar(255) DEFAULT '1';");
        }

        if (!$CI->db->field_exists('number_format', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `number_format` varchar(255) DEFAULT '1';");
        }
//        if (!$CI->db->field_exists('prefix', db_prefix() . 'hr_extra_info')) {
//            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `prefix` varchar(255) DEFAULT '';");
//        }
        if (!$CI->db->field_exists('number', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `number` varchar(255) DEFAULT '';");
        }

        if (!$CI->db->field_exists('is_notification', db_prefix() . 'staff_insurance')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."staff_insurance` ADD `is_notification` int(11) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('recurring_from', db_prefix() . 'staff_insurance')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."staff_insurance` ADD `recurring_from` int(11) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('deadline_notified', db_prefix() . 'staff_insurance')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."staff_insurance` ADD `deadline_notified` int(11) DEFAULT 0;");
        }

    }
}


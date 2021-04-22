<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_307 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();


        if (!$CI->db->field_exists('country', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `country` int(11) DEFAULT 0;");
        }

        if (!$CI->db->field_exists('nationality', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `nationality` int(11) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('manager_id' ,db_prefix() . 'departments')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . "departments` ADD COLUMN `manager_id` INT(11) NULL DEFAULT 0;");
        }
        if (!$CI->db->field_exists('parent_id' ,db_prefix() . 'departments')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . "departments` ADD COLUMN `parent_id` INT(11) NULL DEFAULT 0;");
        }
    }
}
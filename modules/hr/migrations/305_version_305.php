<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_305 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        if (!$CI->db->field_exists('follower_staff', db_prefix() . 'hr_extra_info')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_extra_info` ADD `follower_staff` int(11) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('description', db_prefix() . 'hr_designations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_designations` ADD `description` text DEFAULT '';");
        }

    }
}


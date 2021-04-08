<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_304 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        if (!$CI->db->field_exists('deadline_notified', db_prefix() . 'hr_designations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_designations` ADD `number_format` varchar(255) DEFAULT '1';");
        }
    }
}


<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_311 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();


        if (!$CI->db->field_exists('status', db_prefix() . 'hr_resignations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_resignations` ADD `status` varchar(200) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('status', db_prefix() . 'hr_terminations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_terminations` ADD `status` varchar(200) DEFAULT 0;");
        }


    }
}

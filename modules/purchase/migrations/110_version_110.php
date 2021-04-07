<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_110 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        if (!$CI->db->field_exists('rel_type', db_prefix() . 'pur_contracts')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."pur_contracts` ADD `rel_type` varchar(255) DEFAULT '';");
        }
        if (!$CI->db->field_exists('rel_id', db_prefix() . 'pur_contracts')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."pur_contracts` ADD `rel_id` int(11) DEFAULT '0';");
        }
    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_306 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'hr_designations_groups')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_designations_groups` (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT,
            `name` varchar(200) NOT NULL,
            `description` text NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
        }

        if (!$CI->db->field_exists('group_id', db_prefix() . 'hr_designations')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."hr_designations` ADD `group_id` int(11) DEFAULT 0;");
        }
    }
}
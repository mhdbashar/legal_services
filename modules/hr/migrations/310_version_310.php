<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_310 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'hr_contracts_types')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_contracts_types` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` mediumtext NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }


    }
}

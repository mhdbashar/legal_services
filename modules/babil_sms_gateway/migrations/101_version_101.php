<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_101 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();
        add_option('new_gateway', 0);

        if (!$CI->db->table_exists(db_prefix() . 'saved_wa')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() .  'saved_wa` (
              `id` int(11) PRIMARY KEY AUTO_INCREMENT,
              `sender` varchar(200) NOT NULL,
              `msg` TEXT NOT NULL,
              `msg_id` int(11) NOT NULL,
              `created_at` datetime NOT NULL,
              `rel_type` varchar(30) NOT NULL,
              `rel_id` int(11) NOT NULL,
              `staff_id` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
        }
    }
}
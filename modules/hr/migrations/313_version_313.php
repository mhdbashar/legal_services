<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_313 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        if (!$CI->db->field_exists('second_name' ,db_prefix() . 'staff')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
            ADD COLUMN `second_name` varchar(191) NULL AFTER `firstname`');
        }
        if (!$CI->db->field_exists('third_name' ,db_prefix() . 'staff')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
            ADD COLUMN `third_name` varchar(191) NULL AFTER `second_name`');
        }
    }

}

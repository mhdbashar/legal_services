<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_108 extends App_module_migration
{
	public function up()
	{
        $CI = &get_instance();

        //V108: //Add new columns to staff table

        if (!$CI->db->field_exists('admin' ,db_prefix() . 'staff')) {
            $CI->db->query("ALTER TABLE `' . db_prefix() . 'staff`
            ADD COLUMN `admin` int(11) NULL ");
        }
        if (!$CI->db->field_exists('two_factor_auth_enabled' ,db_prefix() . 'staff')) {
            $CI->db->query("ALTER TABLE `' . db_prefix() . 'staff`
          ADD COLUMN `two_factor_auth_enabled` int(1) NULL ");
        }
        if (!$CI->db->field_exists('two_factor_auth_code' ,db_prefix() . 'staff')) {
            $CI->db->query("ALTER TABLE `' . db_prefix() . 'staff`
          ADD COLUMN `two_factor_auth_code` varchar(100) NULL ");
        }
        if (!$CI->db->field_exists('two_factor_auth_code_requested' ,db_prefix() . 'staff')) {
            $CI->db->query("ALTER TABLE `' . db_prefix() . 'staff`
          ADD COLUMN `two_factor_auth_code_requested` datetime NULL ");
        }
        if (!$CI->db->field_exists('twitter' ,db_prefix() . 'staff')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
         ADD COLUMN `twitter` varchar(50) NULL ');
        }
        if (!$CI->db->field_exists('skype' ,db_prefix() . 'staff')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
         ADD COLUMN `skype` varchar(50) NULL ');
        }





	}


}

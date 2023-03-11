<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_114 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();



        if (!$CI->db->field_exists('brand' ,db_prefix() . 'check_in_out')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'check_in_out`
				ADD COLUMN `brand` varchar(255) NULL;');
        }
        if (!$CI->db->field_exists('device' ,db_prefix() . 'check_in_out')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'check_in_out`
				ADD COLUMN `device` varchar(255) NULL;');
        }
	}
}
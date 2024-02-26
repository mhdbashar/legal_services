<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_119 extends App_module_migration
{
	public function up()
	{

        $CI = &get_instance();

        $CI->db->query('ALTER TABLE '.db_prefix() . 'timesheets_approval_setting'.' CONVERT TO CHARACTER SET utf8;');
        $CI->db->query('ALTER TABLE '.db_prefix() . 'timesheets_timekeeper_data'.' CONVERT TO CHARACTER SET utf8;');
        $CI->db->query('ALTER TABLE '.db_prefix() . 'timesheets_additional_timesheet'.' CONVERT TO CHARACTER SET utf8;');
	}
}

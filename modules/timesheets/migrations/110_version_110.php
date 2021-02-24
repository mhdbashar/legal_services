<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_110 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();
		if ($CI->db->field_exists('days_off' ,db_prefix() . 'timesheets_day_off')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_day_off`
				MODIFY `days_off` float NULL  DEFAULT 0'
			);
		}
		if ($CI->db->field_exists('start_time' ,db_prefix() . 'timesheets_requisition_leave')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_requisition_leave`
				MODIFY `start_time` datetime NULL,
				MODIFY `end_time` datetime NULL'
			);
		}
	}
}
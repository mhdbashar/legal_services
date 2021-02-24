<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_109 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_go_bussiness_advance_payment')) {
		    $CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_go_bussiness_advance_payment` (
		      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		      `requisition_leave` int(11) NOT NULL,
		      `used_to` varchar(200) NUll,
		      `amoun_of_money` varchar(200) NUll,
		      `request_date` DATE NULL,
		      `advance_payment_reason` TEXT NULL,
		      PRIMARY KEY (`id`)
		    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
	}
}
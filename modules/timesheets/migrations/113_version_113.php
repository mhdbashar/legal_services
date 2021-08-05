<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_113 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'type_of_leave')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "type_of_leave` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`male` enum('0','1') NOT NULL,
                `female` enum('0','1') NOT NULL,
                `muslim` enum('0','1') NOT NULL,
                `not_muslim` enum('0','1') NOT NULL,
                `citizen` enum('0','1') NOT NULL,
                `not_citizen` enum('0','1') NOT NULL,
                `name` varchar(255) NOT NULL,
                `number_of_days` int(11) NOT NULL,
                `entitlement_in_months` int(11) NOT NULL,
                `deserving_in_years` int(11) NOT NULL,
                `deserving_before_days` int(11) NOT NULL,
                `deserving_after_days` int(11) NOT NULL,
                `repeat_leave` enum('include','extend') NOT NULL,
                `notify_manager_before_deserving_days` int(11) NOT NULL,
                `notify_staff_before_deserving_days` int(11) NOT NULL,
                `is_deserving_salary` enum('0','1') NOT NULL,
                `salary_type` enum('total_salary','basic_salary') NOT NULL,
                `salary_allocation` enum('true','false') NOT NULL,
                `allow_substitute_employee` enum('0','1') NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }

        if (!$CI->db->table_exists(db_prefix() . 'type_of_leave_allocation')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "type_of_leave_allocation` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`percent` int(11) NOT NULL DEFAULT 0,
				`days` int(11) NOT NULL DEFAULT 0,
				`type_of_leave_id` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }
	}
}
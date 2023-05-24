<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_115 extends App_module_migration {
	public function up() {

        $CI = &get_instance();
        if (row_timesheets_options_exist('"start_month_for_annual_leave_cycle"') == 0){
            $CI->db->query('INSERT INTO `'.db_prefix().'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("start_month_for_annual_leave_cycle", "1", "1");');
        }

        if (row_timesheets_options_exist('"start_year_for_annual_leave_cycle"') == 0){
            $CI->db->query('INSERT INTO `'.db_prefix().'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("start_year_for_annual_leave_cycle", "'.date("Y").'", "1");');
        }

        if (row_timesheets_options_exist('"hour_notification_approval_exp"') == 0){
            $CI->db->query('INSERT INTO `'.db_prefix().'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("hour_notification_approval_exp","3", "1");');
        }
        if (!$CI->db->table_exists(db_prefix() . 'timesheets_type_of_leave')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_type_of_leave` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`type_name` varchar(200) NUll,
				`slug` varchar(200) NUll,
				`symbol` varchar(5) NUll,
				`date_creator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }
        if (!$CI->db->field_exists('type_of_leave_text', db_prefix() . 'timesheets_requisition_leave')) {
            $CI->db->query('ALTER TABLE `'.db_prefix() . "timesheets_requisition_leave`
				ADD COLUMN `type_of_leave_text` varchar(200) NULL");
        }
		if (row_timesheets_options_exist('"timekeeping_enable_valid_ip"') == 0) {
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("timekeeping_enable_valid_ip", "0", "1");
        ');
		}


        create_email_template('Timesheets - New application - Send to notification recipient', '{staff_name} created a new application {link} at {date_time}', 'timesheets_attendance_mgt', 'New application (Send to notification recipient)', 'new_leave_application_send_to_notification_recipients');
        $CI = &get_instance();

        if (!$CI->db->field_exists('brand' ,db_prefix() . 'check_in_out')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'check_in_out`
				ADD COLUMN `brand` varchar(255) NULL;');
        }
        if (!$CI->db->field_exists('device' ,db_prefix() . 'check_in_out')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'check_in_out`
				ADD COLUMN `device` varchar(255) NULL;');
        }

		if (!$CI->db->table_exists(db_prefix() . 'timesheets_valid_ip')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_valid_ip` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `ip` varchar(30) NUll,
        `enable` int(11) NOT NULL DEFAULT 1,
        `date_creator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
	}
}
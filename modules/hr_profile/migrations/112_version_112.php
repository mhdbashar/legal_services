<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_112 extends App_module_migration
{
	public function up()
	{
    $CI = &get_instance();
      $CI->db->query("CREATE TABLE IF NOT EXISTS  `timesheets_requisition_leave` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `staff_id` int(11) NOT NULL,
            `subject` varchar(100) NULL,
            `is_after` varchar(100) NULL,
            `is_before` varchar(100) NULL,
            `start_time` DATETIME NOT NULL,
            `end_time` DATETIME NOT NULL,
            `reason` text NULL,
            `approver_id` int(11) NOT NULL,
            `followers_id` int(11) NULL,
            `rel_type` int(11) NOT NULL COMMENT '1:Leave 2:Late_early 3:Go_out 4:Go_on_bussiness',
            `status` int(11) NULL DEFAULT 0 COMMENT '0:Create 1:Approver 2:Reject',
            PRIMARY KEY (`id`,staff_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    


      $CI->db->query("CREATE TABLE IF NOT EXISTS  `type_of_leave` (
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
                  `accumulative`  varchar(200) NOT NULL,
                  `code` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1; ");
    



    $this->db->query("ALTER TABLE `tblstaff` ADD `appointment` VARCHAR(222) NULL AFTER `education_level`;");



  }}
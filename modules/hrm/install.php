<?php

if (!$CI->db->table_exists(db_prefix() . 'my_new')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_newstaff` (
    `user_id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `staff_id` int(11) NOT NULL,
    `gender` varchar(20) NOT NULL,
    `main_salary` int(11) NOT NULL,
    `transportation_expenses` int(11) NOT NULL,
    `other_expenses` int(11) NOT NULL, 
    `job_title` varchar(255) NOT NULL, 
    `created` date NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_vac')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'my_vac` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `staff_id` int(11) NOT NULL,
	  `description` text NOT NULL,
	  `start_date` date NOT NULL,
	  `end_date` date NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

}

if (!$CI->db->table_exists(db_prefix() . 'my_workday')) {
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'my_workday` (
	  `saturday` int(11) NOT NULL,
	  `sunday` int(11) NOT NULL,
	  `monday` int(11) NOT NULL,
	  `tuesday` int(11) NOT NULL,
	  `wednesday` int(11) NOT NULL,
	  `thursday` int(11) NOT NULL,
	  `friday` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
	$CI->db->query("INSERT INTO `tblmy_workday` (`saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`) VALUES ('1', '1', '1', '1', '1', '1', '1');");
}

if (!$CI->db->table_exists(db_prefix() . 'my_holiday')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'my_holiday` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `event_name` varchar(200) NOT NULL,
	  `description` text NOT NULL,
	  `start_date` date NOT NULL,
	  `end_date` date NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_award')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'my_award` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `staff_id` int(11) NOT NULL,
	  `award` double NOT NULL,
	  `reason` text NOT NULL,
	  `date` varchar(20) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_salary')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'my_salary` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `staff_id` int(11) NOT NULL,
	  `comments` text NOT NULL,
	  `ammount` double NOT NULL,
	  `payment_month` varchar(20) NOT NULL,
	  `paid_date` timestamp NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_employee_basic')) { 
	$CI->db->query('CREATE TABLE `' .db_prefix().	'my_employee_basic` (
	`employee_basic_id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`staff_id` int(11) NOT NULL,
	`username` varchar(50) NOT NULL,
	`gender` varchar(50) NOT NULL,
	`mobile` varchar(50) NOT NULL,
	`joining_date` date NOT NULL,
	`date_of_birth` date NOT NULL,
	`maratial_status` varchar(50) NOT NULL,
	`father_name` varchar(50) DEFAULT NULL,
	`mother_name` varchar(50) DEFAULT NULL,
	`address` varchar(150) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
  
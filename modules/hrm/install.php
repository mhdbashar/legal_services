<?php


if (!$CI->db->table_exists(db_prefix() . 'newstaff')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'newstaff` (
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

if (!$CI->db->table_exists(db_prefix() . 'vac')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'vac` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `staff_id` int(11) NOT NULL,
	  `description` text NOT NULL,
	  `start_date` date NOT NULL,
	  `end_date` date NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

}

if (!$CI->db->table_exists(db_prefix() . 'workday')) {
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'workday` (
	  `saturday` int(11) NOT NULL,
	  `sunday` int(11) NOT NULL,
	  `monday` int(11) NOT NULL,
	  `tuesday` int(11) NOT NULL,
	  `wednesday` int(11) NOT NULL,
	  `thursday` int(11) NOT NULL,
	  `friday` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
	$CI->db->query("INSERT INTO `tblworkday` (`saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`) VALUES ('1', '1', '1', '1', '1', '1', '1');");
}

if (!$CI->db->table_exists(db_prefix() . 'holiday')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'holiday` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `event_name` varchar(200) NOT NULL,
	  `description` text NOT NULL,
	  `start_date` date NOT NULL,
	  `end_date` date NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'award')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'award` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `staff_id` int(11) NOT NULL,
	  `award` double NOT NULL,
	  `reason` text NOT NULL,
	  `date` varchar(20) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'salary')) {           
	$CI->db->query('CREATE TABLE `' . db_prefix() .  'salary` (
	  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
	  `staff_id` int(11) NOT NULL,
	  `comments` text NOT NULL,
	  `ammount` double NOT NULL,
	  `payment_month` varchar(20) NOT NULL,
	  `paid_date` timestamp NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}


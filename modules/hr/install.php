<?php

if (!$CI->db->table_exists(db_prefix() . 'hr_holiday')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_holiday` (
    `holiday_id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `event_name` varchar(200) NOT NULL,
    `description` text NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `location` varchar(200) DEFAULT NULL,
    `color` varchar(200) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
<?php


if (!$CI->db->table_exists(db_prefix() . 'my_service_session')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_service_session` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `service_id` int(11) NOT NULL,
    `rel_id` int(11) NOT NULL,
    `rel_type` varchar(200) NOT NULL,
    `subject` varchar(250) NOT NULL,
    `court_id` int(11) NOT NULL,
    `judge_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `details` text NOT NULL,
    `next_action` text NOT NULL,
    `next_date` date NOT NULL,
    `report` varchar(250) NOT NULL,
    `status` int(11) NOT NULL,
    `result` int(11) NOT NULL,
    `staff` int(11) NOT NULL,
    `deleted` tinyint(4) NOT NULL

  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_judges')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_judges` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(250) NOT NULL,
    `note` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_sessiondiscussions')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_sessiondiscussions` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `session_id` int(11) NOT NULL,
    `subject` varchar(191) NOT NULL,
    `description` text NOT NULL,
    `show_to_customer` tinyint(1) NOT NULL,
    `datecreated` datetime NOT NULL,
    `last_activity` datetime NOT NULL,
    `staff_id` int(11) NOT NULL,
    `contact_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_sessiondiscussioncomments')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_sessiondiscussioncomments` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `discussion_id` int(11) NOT NULL,
    `discussion_type` varchar(10) NOT NULL,
    `parent` int(10) DEFAULT NULL,
    `created` datetime NOT NULL,
    `modified` datetime DEFAULT NULL,
    `content` text NOT NULL,
    `staff_id` int(11) NOT NULL,
    `contact_id` int(11) DEFAULT "0",
    `fullname` varchar(191) DEFAULT NULL,
    `file_name` varchar(191) DEFAULT NULL,
    `file_mime_type` varchar(70) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'my_courts')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_courts` (
    `c_id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `court_name` varchar(250) NOT NULL,
    `datecreated` date NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
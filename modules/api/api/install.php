<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = & get_instance();
if (!$CI->db->table_exists(db_prefix() . 'user_api')) {
    $CI->db->query('CREATE TABLE `'. db_prefix() .'user_api` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `password` VARCHAR(50) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `expiration_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`));
');
}

$CI = & get_instance();

if (!$CI->db->table_exists(db_prefix() . 'token')) {
    $CI->db->query('CREATE TABLE `'. db_prefix() .'token` (
 `id` int(11) NOT NULL,
  `rel_id` varchar(100) NOT NULL,
  `rel_type` varchar(40) NOT NULL,
  `token_key` varchar(500) DEFAULT NULL,
  `token_id` varchar(500) NOT NULL,
  PRIMARY KEY (`id`));
');
}